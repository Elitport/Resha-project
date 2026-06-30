<?php
/* =====================================================================
 *  Resha Art · config.php
 *  Central bootstrap: DB connection (PDO), secure sessions, HTTPS,
 *  auth/role helpers, CSRF, rate limiting, upload validation.
 *
 *  Include at the very top of every page:  require_once 'config.php';
 * ===================================================================== */

declare(strict_types=1);

/* ---------------------------------------------------------------------
 *  1. DATABASE CREDENTIALS
 *  >>> REPLACE these placeholders with your real Hostinger DB values. <<<
 *  (Keep your existing credentials here — do not commit real secrets.)
 * ------------------------------------------------------------------- */
define('DB_HOST', 'localhost');
define('DB_NAME', 'YOUR_DATABASE_NAME');
define('DB_USER', 'YOUR_DATABASE_USER');
define('DB_PASS', 'YOUR_DATABASE_PASSWORD');
define('DB_CHARSET', 'utf8mb4');

/* Security tunables */
define('SESSION_LIFETIME', 7 * 24 * 60 * 60); // 7 days, in seconds
define('LOGIN_MAX_ATTEMPTS', 5);              // attempts...
define('LOGIN_WINDOW_SECONDS', 10 * 60);      // ...within 10 minutes
define('UPLOAD_MAX_BYTES', 5 * 1024 * 1024);  // 5 MB
const UPLOAD_ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp'];
const UPLOAD_ALLOWED_EXT  = ['jpg', 'jpeg', 'png', 'webp'];

/* ---------------------------------------------------------------------
 *  2. FORCE HTTPS — redirect any plain-HTTP request to HTTPS.
 *  (Hostinger sets HTTPS / forwarded headers behind its proxy.)
 * ------------------------------------------------------------------- */
function is_https(): bool {
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') return true;
    if (($_SERVER['SERVER_PORT'] ?? null) == 443) return true;
    if (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') return true;
    return false;
}
if (PHP_SAPI !== 'cli' && !is_https()) {
    $host = $_SERVER['HTTP_HOST'] ?? 'reshaart.com';
    $uri  = $_SERVER['REQUEST_URI'] ?? '/';
    header('Location: https://' . $host . $uri, true, 301);
    exit;
}

/* ---------------------------------------------------------------------
 *  3. SECURE SESSION — httponly, secure, samesite=Strict, 7-day life.
 * ------------------------------------------------------------------- */
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'domain'   => '',
        'secure'   => true,        // only sent over HTTPS
        'httponly' => true,        // not readable by JavaScript
        'samesite' => 'Strict',    // blocks cross-site cookie sending
    ]);
    ini_set('session.gc_maxlifetime', (string) SESSION_LIFETIME);
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_secure', '1');
    ini_set('session.cookie_httponly', '1');
    session_name('RESHA_SESSID');
    session_start();
}

/* A few hardening response headers (safe defaults). */
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

/* ---------------------------------------------------------------------
 *  4. DATABASE CONNECTION (PDO, prepared statements only)
 * ------------------------------------------------------------------- */
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // real prepared statements
        ]);
    } catch (PDOException $e) {
        // Never leak DB details to the client.
        error_log('DB connection failed: ' . $e->getMessage());
        http_response_code(500);
        // ===== TEMPORARY DEBUG — REMOVE BEFORE GOING LIVE =====
        // Shows the real DB error (credentials/host/db name) so we can fix it.
        // Restore the generic line below once the connection works.
        exit('DB ERROR: ' . $e->getMessage()
            . ' | in ' . $e->getFile() . ' on line ' . $e->getLine());
        // exit('A server error occurred. Please try again later.');
        // ======================================================
    }
    return $pdo;
}

/** Alias for db() — lets pages use getDB() consistently. */
function getDB(): PDO { return db(); }

/* ---------------------------------------------------------------------
 *  5. INPUT SANITISATION & SAFE OUTPUT
 * ------------------------------------------------------------------- */

/**
 * Clean user input. Recurses through arrays. Trims and strips control
 * characters. NOTE: this is for general hygiene — always still use PDO
 * prepared statements for SQL and e()/htmlspecialchars() for output.
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    $input = (string) $input;
    $input = trim($input);
    // remove invisible control chars (keep tab/newline)
    $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $input);
    return $input;
}

/** Escape a value for safe HTML output. Use everywhere you echo. */
function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/* ---------------------------------------------------------------------
 *  6. PASSWORD HASHING (BCRYPT)
 * ------------------------------------------------------------------- */
function hashPassword(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}
function verifyPassword(string $password, string $hash): bool {
    return password_verify($password, $hash);
}

/* ---------------------------------------------------------------------
 *  7. AUTH & ROLE HELPERS
 * ------------------------------------------------------------------- */

/** True if a valid, non-expired session exists for a real user. */
function isLoggedIn(): bool {
    if (empty($_SESSION['user_id']) || empty($_SESSION['session_token'])) {
        return false;
    }
    $stmt = db()->prepare(
        'SELECT 1 FROM sessions
         WHERE user_id = :uid AND session_token = :token
           AND (expires_at IS NULL OR expires_at > NOW())
         LIMIT 1'
    );
    $stmt->execute([
        ':uid'   => $_SESSION['user_id'],
        ':token' => $_SESSION['session_token'],
    ]);
    return (bool) $stmt->fetchColumn();
}

/** Fetch the current logged-in user row (or null). Cached per request. */
function currentUser(): ?array {
    static $cached = false;
    static $user = null;
    if ($cached) return $user;
    $cached = true;

    if (!isLoggedIn()) { $user = null; return null; }
    $stmt = db()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch() ?: null;
    return $user;
}

/** True if the logged-in user is an artist AND approved by an admin. */
function isArtist(): bool {
    $u = currentUser();
    return $u !== null && $u['role'] === 'artist' && (int) $u['is_approved'] === 1;
}

/** True if the logged-in user is an admin. */
function isAdmin(): bool {
    $u = currentUser();
    return $u !== null && $u['role'] === 'admin';
}

/* ---------------------------------------------------------------------
 *  8. SESSION TOKEN — create/regenerate after every login.
 *  Call loginUser($id) right after verifying the password.
 * ------------------------------------------------------------------- */
function loginUser(int $userId): string {
    // Prevent session fixation: brand-new PHP session id.
    session_regenerate_id(true);

    $token   = bin2hex(random_bytes(32));               // 64-char token
    $expires = date('Y-m-d H:i:s', time() + SESSION_LIFETIME);
    $ip      = clientIp();

    $stmt = db()->prepare(
        'INSERT INTO sessions (user_id, session_token, ip_address, expires_at)
         VALUES (:uid, :token, :ip, :exp)'
    );
    $stmt->execute([
        ':uid'   => $userId,
        ':token' => $token,
        ':ip'    => $ip,
        ':exp'   => $expires,
    ]);

    db()->prepare('UPDATE users SET last_login_at = NOW() WHERE id = :id')
        ->execute([':id' => $userId]);

    $_SESSION['user_id']       = $userId;
    $_SESSION['session_token'] = $token;
    return $token;
}

/** Destroy the current session everywhere (logout). */
function logoutUser(): void {
    if (!empty($_SESSION['session_token'])) {
        db()->prepare('DELETE FROM sessions WHERE session_token = :t')
            ->execute([':t' => $_SESSION['session_token']]);
    }
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

/* ---------------------------------------------------------------------
 *  9. RATE LIMITING — block an IP after 5 failed logins in 10 minutes.
 * ------------------------------------------------------------------- */
function clientIp(): string {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($parts[0]);
    }
    return substr($ip, 0, 45);
}

/** Record an attempt (call after each login try). */
function recordLoginAttempt(string $email, bool $success): void {
    $stmt = db()->prepare(
        'INSERT INTO login_attempts (ip_address, email, success)
         VALUES (:ip, :email, :ok)'
    );
    $stmt->execute([
        ':ip'    => clientIp(),
        ':email' => substr($email, 0, 190),
        ':ok'    => $success ? 1 : 0,
    ]);
}

/** True if the current IP is over the failed-attempt limit. */
function isRateLimited(): bool {
    $stmt = db()->prepare(
        'SELECT COUNT(*) FROM login_attempts
         WHERE ip_address = :ip AND success = 0
           AND created_at > (NOW() - INTERVAL :win SECOND)'
    );
    // bind INTERVAL value as integer
    $stmt->bindValue(':ip', clientIp());
    $stmt->bindValue(':win', LOGIN_WINDOW_SECONDS, PDO::PARAM_INT);
    $stmt->execute();
    return (int) $stmt->fetchColumn() >= LOGIN_MAX_ATTEMPTS;
}

/**
 * Guard helper for login handlers: if blocked, send 429 and stop.
 * Returns true when blocked so callers can `if (enforceRateLimit()) return;`
 */
function enforceRateLimit(): bool {
    if (isRateLimited()) {
        http_response_code(429);
        return true;
    }
    return false;
}

/* ---------------------------------------------------------------------
 *  10. CSRF PROTECTION
 * ------------------------------------------------------------------- */
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Hidden input for forms: echo csrfField(); */
function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

/** Validate a submitted token (timing-safe). */
function verifyCsrf(?string $token): bool {
    return !empty($_SESSION['csrf_token'])
        && is_string($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}

/** Enforce CSRF on POST handlers: if invalid, send 403 and stop. */
function requireCsrf(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        if (!verifyCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            exit('Invalid or missing CSRF token.');
        }
    }
}

/* ---------------------------------------------------------------------
 *  11. FILE UPLOAD VALIDATION — jpg/png/webp, max 5MB, verified by content.
 * ------------------------------------------------------------------- */
/**
 * Validate one entry from $_FILES. Returns [ok=>bool, error=>string, ext=>string].
 * Checks: upload error, real size, true MIME (finfo), and extension.
 */
function validateUpload(array $file): array {
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['ok' => false, 'error' => 'Invalid upload.', 'ext' => ''];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'Upload failed (code ' . $file['error'] . ').', 'ext' => ''];
    }
    if ($file['size'] <= 0 || $file['size'] > UPLOAD_MAX_BYTES) {
        return ['ok' => false, 'error' => 'File must be 1 byte – 5 MB.', 'ext' => ''];
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        return ['ok' => false, 'error' => 'Invalid upload source.', 'ext' => ''];
    }

    // True MIME from file content, not the client-supplied type.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, UPLOAD_ALLOWED_MIME, true)) {
        return ['ok' => false, 'error' => 'Only JPG, PNG, or WEBP images are allowed.', 'ext' => ''];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, UPLOAD_ALLOWED_EXT, true)) {
        return ['ok' => false, 'error' => 'Invalid file extension.', 'ext' => ''];
    }

    return ['ok' => true, 'error' => '', 'ext' => ($ext === 'jpeg' ? 'jpg' : $ext)];
}

/** Generate a safe, random filename for a validated upload. */
function safeUploadName(string $ext): string {
    return bin2hex(random_bytes(16)) . '.' . $ext;
}
