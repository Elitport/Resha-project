<?php
/* =====================================================================
 *  delete_check.php — TEMPORARY, READ ONLY. Removed straight after use.
 *  Why Azeem's deleted artworks still show: lists the artworks rows, the
 *  delete entries in the activity log, what links to artworks, and the
 *  newest lines of the private error log. Changes nothing.
 *  Only with the one-time key (only its SHA-256 is stored here). POST only.
 * ===================================================================== */
const OW_DC_UNTIL    = 1793484750;
const OW_DC_KEY_HASH = '172546adcffd59e4d8e5da6bdaa2f6e56016920a34067827c31d2ee2d7b80415';
if (time() > OW_DC_UNTIL) { http_response_code(404); exit; }
require_once 'config.php';
$keyOk = is_string($_POST['key'] ?? null) && hash_equals(OW_DC_KEY_HASH, hash('sha256', (string) $_POST['key']));
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || !$keyOk) { http_response_code(404); exit; }
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: no-store');
$db = getDB();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Time: ", gmdate('Y-m-d H:i:s'), " UTC\n== artworks ==\n";
foreach ($db->query('SELECT id, artist_id, title_en, is_approved, is_draft, status, image_url, created_at FROM artworks ORDER BY id') as $r) echo json_encode($r, JSON_UNESCAPED_UNICODE), "\n";
echo "== activity_log (newest 40) ==\n";
foreach ($db->query('SELECT id, created_at, actor_type, actor_id, action, target_type, target_id, details FROM activity_log ORDER BY id DESC LIMIT 40') as $r) echo json_encode($r, JSON_UNESCAPED_UNICODE), "\n";
echo "== what links to artworks (foreign keys) ==\n";
foreach ($db->query("SELECT TABLE_NAME, CONSTRAINT_NAME, DELETE_RULE FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME = 'artworks'") as $r) echo json_encode($r), "\n";
echo "== rows pointing at artworks ==\n";
foreach (['artwork_stages','artwork_colors','favorites','artwork_inquiries','purchases','auctions','bids','pending_changes'] as $t) {
  try { $c = $t === 'pending_changes' ? "target_type='artwork'" : '1=1'; $col = $t === 'pending_changes' ? 'target_id' : 'artwork_id';
        echo $t, ': ', json_encode($db->query("SELECT $col AS aid, COUNT(*) n FROM $t WHERE $c GROUP BY $col")->fetchAll()), "\n"; } catch (Throwable $e) { echo $t, ': (', substr($e->getMessage(), 0, 80), ")\n"; }
}
echo "== user 1 sign-in ==\n";
try { echo json_encode($db->query("SELECT id, role, last_login_at, updated_at FROM users WHERE id = 1")->fetch()), "\n"; } catch (Throwable $e) { echo substr($e->getMessage(),0,120), "\n"; }
echo "== sessions (times only) ==\n";
try { $cols = $db->query("SHOW COLUMNS FROM sessions")->fetchAll(PDO::FETCH_COLUMN); echo "columns: ", implode(',', $cols), "\n";
      $keep = array_values(array_intersect($cols, ['user_id','created_at','expires_at','last_seen','last_activity','updated_at']));
      if ($keep) foreach ($db->query('SELECT ' . implode(',', $keep) . ' FROM sessions ORDER BY 1') as $r) echo json_encode($r), "\n"; } catch (Throwable $e) { echo substr($e->getMessage(),0,120), "\n"; }
echo "== login_attempts (times only) ==\n";
try { $cols = $db->query("SHOW COLUMNS FROM login_attempts")->fetchAll(PDO::FETCH_COLUMN); echo "columns: ", implode(',', $cols), "\n";
      $keep = array_values(array_intersect($cols, ['attempted_at','created_at','success','was_successful']));
      if ($keep) foreach ($db->query('SELECT ' . implode(',', $keep) . ' FROM login_attempts ORDER BY 1 DESC LIMIT 15') as $r) echo json_encode($r), "\n"; } catch (Throwable $e) { echo substr($e->getMessage(),0,120), "\n"; }
echo "error log size: ", @filesize(__DIR__ . '/.logs/php-errors.log'), " modified: ", gmdate('Y-m-d H:i:s', (int) @filemtime(__DIR__ . '/.logs/php-errors.log')), "\n";
echo "PHP error_log setting: ", ini_get('error_log') ? basename(ini_get('error_log')) : '(default)', "\n";
echo "== error log (newest 40 lines) ==\n";
$f = __DIR__ . '/.logs/php-errors.log';
if (is_file($f)) { $l = file($f); echo implode('', array_slice($l, -8)); } else echo "(no log)\n";

echo "== server visit logs: requests to the artist pages today (no addresses shown) ==\n";
$dirs = [dirname(__DIR__) . '/logs', dirname(__DIR__, 2) . '/logs', dirname(__DIR__, 3) . '/logs', dirname(__DIR__, 3) . '/.logs'];
foreach ($dirs as $d) { if (!is_dir($d)) continue; echo "folder: ", str_replace(dirname(__DIR__, 3), '~', $d), "\n";
  foreach (scandir($d) as $f) { if ($f[0] === '.') continue; $fp = "$d/$f"; echo "  $f ", @filesize($fp), " ", gmdate('Y-m-d H:i', (int) @filemtime($fp)), "\n";
    if (is_file($fp) && preg_match('/access|log/i', $f) && filemtime($fp) > time() - 86400) {
      $txt = substr(preg_match('/\.gz$/', $f) ? (string) @gzdecode((string) file_get_contents($fp)) : (string) file_get_contents($fp), -3000000);
      foreach (explode("\n", $txt) as $line) if (preg_match('#(artist_dashboard|edit_artwork|artist_studio)#', $line) && strpos($line, '31/Oct/2026') !== false)
        echo "   ", preg_replace('/^\S+/', '(ip)', substr($line, 0, 260)), "\n"; } } }
