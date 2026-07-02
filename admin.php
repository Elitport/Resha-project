<?php
require_once 'config.php';

/* =====================================================================
 *  Resha Art · admin.php — approve / ban artists
 *  Simple password gate (no user account needed). The password is stored
 *  as a BCRYPT hash, never in plaintext. To change it, run:
 *     php -r "echo password_hash('NEW_PASS', PASSWORD_BCRYPT, ['cost'=>12]);"
 *  and paste the result below.
 * ===================================================================== */
const ADMIN_HASH = '$2y$12$LpsTBtU/4y7kG.uNE4ANke2/nUPPm0XjGmjQCcV3v7SZEPildM9qK';

$loginError = '';

/* ---- Handle login ---- */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['admin_pass'])) {
    if (verifyCsrf($_POST['csrf_token'] ?? null) && password_verify((string) $_POST['admin_pass'], ADMIN_HASH)) {
        session_regenerate_id(true);
        $_SESSION['is_admin'] = true;
    } else {
        $loginError = 'Incorrect password.';
    }
}

/* ---- Handle logout ---- */
if (isset($_GET['logout'])) {
    unset($_SESSION['is_admin']);
    header('Location: admin.php');
    exit;
}

$isAdmin = !empty($_SESSION['is_admin']);

/* ---- Handle approve / ban actions (admin only, CSRF-checked) ---- */
$flash = '';
if ($isAdmin && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['action'])) {
    if (!verifyCsrf($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid CSRF token.');
    }
    $uid    = (int) ($_POST['user_id'] ?? 0);
    $action = $_POST['action'];
    $map = [
        'approve'   => 'UPDATE users SET is_approved = 1 WHERE id = :id',
        'unapprove' => 'UPDATE users SET is_approved = 0 WHERE id = :id',
        'ban'       => 'UPDATE users SET is_banned = 1 WHERE id = :id',
        'unban'     => 'UPDATE users SET is_banned = 0 WHERE id = :id',
    ];
    if (isset($map[$action]) && $uid > 0) {
        getDB()->prepare($map[$action])->execute([':id' => $uid]);
        $flash = 'Updated.';
    }
    header('Location: admin.php' . ($flash ? '?ok=1' : ''));
    exit;
}

/* ---- Load artists list (only when authed) ---- */
$artists = [];
if ($isAdmin) {
    $artists = getDB()->query(
        "SELECT id, email, full_name_en, full_name_ar, city, is_verified, is_approved,
                COALESCE(is_banned,0) AS is_banned, created_at
         FROM users
         WHERE role = 'artist'
         ORDER BY is_approved ASC, created_at DESC"
    )->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin · Resha Art</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
body{min-height:100vh;background:#f4f5f7;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;color:#111111;padding:40px 20px;}
.wrap{max-width:1000px;margin:0 auto;}
h1{font-size:24px;font-weight:700;margin-bottom:4px;}
.sub{font-size:13px;color:rgba(0,0,0,0.5);margin-bottom:24px;}
.card{background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,0.05);padding:26px;}
.login-card{max-width:380px;margin:8vh auto 0;}
.login-card h1{margin-bottom:16px;}
label{display:block;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:rgba(0,0,0,0.5);margin-bottom:6px;}
input[type=password]{width:100%;padding:12px 14px;border-radius:12px;border:1px solid rgba(0,0,0,0.15);font-size:14px;font-family:inherit;}
input:focus{outline:none;border-color:#0066ff;box-shadow:0 0 0 3px rgba(0,100,255,0.12);}
.btn{padding:11px 22px;border-radius:999px;background:#111111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.22s;text-decoration:none;display:inline-block;}
.btn:hover{background:#ff0055;}
.btn.sm{padding:7px 14px;font-size:10px;}
.btn.green{background:#00a050;}.btn.green:hover{background:#0066ff;}
.btn.red{background:#ff0055;}.btn.red:hover{background:#111111;}
.btn.grey{background:rgba(0,0,0,0.08);color:#111111;}.btn.grey:hover{background:rgba(0,0,0,0.16);}
.err{color:#ff0055;font-size:13px;font-weight:600;margin-bottom:12px;}
.top{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;font-size:13px;}
th,td{text-align:left;padding:12px 10px;border-bottom:1px solid rgba(0,0,0,0.06);vertical-align:middle;}
th{font-size:10px;text-transform:uppercase;letter-spacing:0.08em;color:rgba(0,0,0,0.45);}
.pill{display:inline-block;padding:3px 10px;border-radius:999px;font-size:10px;font-weight:700;}
.pill.on{background:rgba(0,180,100,0.14);color:#00a050;}
.pill.off{background:rgba(0,0,0,0.06);color:rgba(0,0,0,0.5);}
.pill.ban{background:rgba(255,0,85,0.12);color:#ff0055;}
.acts{display:flex;gap:6px;flex-wrap:wrap;}
.name-ar{font-size:11px;color:rgba(0,0,0,0.45);}
.empty{padding:30px;text-align:center;color:rgba(0,0,0,0.4);}
</style>
</head>
<body>
<div class="wrap">
<?php if (!$isAdmin): ?>

  <form class="card login-card" method="post" action="admin.php">
    <h1>Admin Login</h1>
    <?php if ($loginError): ?><div class="err"><?= e($loginError) ?></div><?php endif; ?>
    <?= csrfField() ?>
    <label for="admin_pass">Password</label>
    <input type="password" id="admin_pass" name="admin_pass" required autofocus>
    <div style="margin-top:16px;"><button class="btn" type="submit">Sign In</button></div>
  </form>

<?php else: ?>

  <div class="top">
    <div>
      <h1>Artist Management</h1>
      <div class="sub">Approve new artists and ban abusive accounts.</div>
    </div>
    <div style="display:flex;gap:8px;">
      <a class="btn grey" href="admin_styles.php">Manage Styles</a>
      <a class="btn grey" href="admin.php?logout=1">Log out</a>
    </div>
  </div>

  <div class="card">
    <?php if (!$artists): ?>
      <div class="empty">No artist accounts yet.</div>
    <?php else: ?>
      <table>
        <thead>
          <tr><th>Artist</th><th>Email</th><th>City</th><th>Verified</th><th>Approved</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($artists as $a): ?>
          <tr>
            <td>
              <strong><?= e($a['full_name_en'] ?: '—') ?></strong>
              <?php if (!empty($a['full_name_ar'])): ?><div class="name-ar" dir="rtl"><?= e($a['full_name_ar']) ?></div><?php endif; ?>
            </td>
            <td><?= e($a['email']) ?></td>
            <td><?= e($a['city'] ?: '—') ?></td>
            <td><span class="pill <?= $a['is_verified'] ? 'on' : 'off' ?>"><?= $a['is_verified'] ? 'Yes' : 'No' ?></span></td>
            <td><span class="pill <?= $a['is_approved'] ? 'on' : 'off' ?>"><?= $a['is_approved'] ? 'Yes' : 'No' ?></span></td>
            <td><?php if ((int)$a['is_banned'] === 1): ?><span class="pill ban">Banned</span><?php else: ?><span class="pill on">Active</span><?php endif; ?></td>
            <td>
              <div class="acts">
                <?php if (!$a['is_approved']): ?>
                  <form method="post" action="admin.php"><?= csrfField() ?><input type="hidden" name="user_id" value="<?= (int)$a['id'] ?>"><button class="btn sm green" name="action" value="approve">Approve</button></form>
                <?php else: ?>
                  <form method="post" action="admin.php"><?= csrfField() ?><input type="hidden" name="user_id" value="<?= (int)$a['id'] ?>"><button class="btn sm grey" name="action" value="unapprove">Unapprove</button></form>
                <?php endif; ?>
                <?php if ((int)$a['is_banned'] === 1): ?>
                  <form method="post" action="admin.php"><?= csrfField() ?><input type="hidden" name="user_id" value="<?= (int)$a['id'] ?>"><button class="btn sm grey" name="action" value="unban">Unban</button></form>
                <?php else: ?>
                  <form method="post" action="admin.php"><?= csrfField() ?><input type="hidden" name="user_id" value="<?= (int)$a['id'] ?>"><button class="btn sm red" name="action" value="ban">Ban</button></form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

<?php endif; ?>
</div>
</body>
</html>
