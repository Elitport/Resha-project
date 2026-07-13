<?php
require_once 'config.php';

/* =====================================================================
 *  Oweili · admin.php — approve / ban artists
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

    /* --- Artwork moderation --- */
    if ($action === 'approve_art' || $action === 'reject_art') {
        $awId = (int) ($_POST['artwork_id'] ?? 0);
        if ($awId > 0) {
            if ($action === 'approve_art') {
                getDB()->prepare('UPDATE artworks SET is_approved = 1 WHERE id = :id')
                       ->execute([':id' => $awId]);
            } else {
                // Reject = remove the pending artwork and its uploaded image file.
                $row = getDB()->prepare('SELECT image_url FROM artworks WHERE id = :id');
                $row->execute([':id' => $awId]);
                $img = $row->fetchColumn();
                getDB()->prepare('DELETE FROM artworks WHERE id = :id')->execute([':id' => $awId]);
                if ($img && strpos($img, 'uploads/') === 0) {
                    $path = __DIR__ . '/' . $img;
                    if (is_file($path)) { @unlink($path); }
                }
            }
        }
        header('Location: admin.php?ok=1#pending');
        exit;
    }

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

/* ---- Load pending artworks (only when authed) ---- */
$pendingArt = [];
if ($isAdmin) {
    $pendingArt = getDB()->query(
        "SELECT a.id, a.title_en, a.title_ar, a.price, a.type, a.image_url, a.created_at,
                u.full_name_en AS artist_name
         FROM artworks a
         LEFT JOIN users u ON u.id = a.artist_id
         WHERE a.is_approved = 0
         ORDER BY a.created_at DESC"
    )->fetchAll();
}

/* ---- Load artists list (only when authed) ---- */
$artists = [];
if ($isAdmin) {
    $artists = getDB()->query(
        "SELECT id, email, full_name_en, full_name_ar, artist_name, city, is_verified, is_approved,
                profile_picture, art_video, COALESCE(is_banned,0) AS is_banned, created_at
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
<title>Admin · Oweili</title>
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
.sec-head{margin-bottom:16px;}
.sec-head h2{font-size:16px;font-weight:700;display:flex;align-items:center;gap:8px;}
.count{background:#ff0055;color:#fff;font-size:11px;font-weight:700;padding:2px 9px;border-radius:999px;}
.art-list{display:flex;flex-direction:column;gap:12px;}
.art-item{display:flex;align-items:center;gap:16px;padding:12px;border:1px solid rgba(0,0,0,0.07);border-radius:14px;}
.art-thumb{width:64px;height:64px;border-radius:10px;background-size:cover;background-position:center;background-color:#eee;flex-shrink:0;}
.art-meta{flex:1;min-width:0;}
.art-meta strong{font-size:14px;}
.art-info{font-size:12px;color:rgba(0,0,0,0.5);margin-top:3px;}
.verify-cell{display:flex;flex-direction:column;gap:6px;align-items:flex-start;min-width:150px;}
.verify-photo{width:52px;height:52px;border-radius:10px;object-fit:cover;border:1px solid rgba(0,0,0,0.1);}
.verify-video{width:150px;max-width:100%;border-radius:10px;background:#000;}
.video-link{font-size:11px;font-weight:600;color:#0066ff;text-decoration:none;}
.video-link:hover{text-decoration:underline;}
.no-media{font-size:11px;color:rgba(0,0,0,0.35);font-style:italic;}
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

  <!-- ===== PENDING ARTWORK APPROVAL ===== -->
  <div class="card" id="pending" style="margin-bottom:24px;">
    <div class="sec-head">
      <h2>Pending Artworks <span class="count"><?= count($pendingArt) ?></span></h2>
      <div class="sub" style="margin:0;">New uploads waiting for approval before they appear in the marketplace.</div>
    </div>
    <?php if (!$pendingArt): ?>
      <div class="empty">Nothing pending — all caught up. 🎉</div>
    <?php else: ?>
      <div class="art-list">
      <?php foreach ($pendingArt as $art): ?>
        <div class="art-item">
          <div class="art-thumb" style="background-image:url('<?= e($art['image_url']) ?>');"></div>
          <div class="art-meta">
            <strong><?= e($art['title_en'] ?: ($art['title_ar'] ?: 'Untitled')) ?></strong>
            <?php if (!empty($art['title_ar'])): ?><div class="name-ar" dir="rtl"><?= e($art['title_ar']) ?></div><?php endif; ?>
            <div class="art-info">
              <?= e($art['artist_name'] ?: 'Unknown artist') ?> ·
              <?= e(ucfirst((string)$art['type'])) ?> ·
              <?= $art['price'] !== null ? e(number_format((float)$art['price'])) . ' SAR' : '—' ?>
            </div>
          </div>
          <div class="acts">
            <form method="post" action="admin.php"><?= csrfField() ?><input type="hidden" name="artwork_id" value="<?= (int)$art['id'] ?>"><button class="btn sm green" name="action" value="approve_art">Approve</button></form>
            <form method="post" action="admin.php" onsubmit="return confirm('Reject and permanently delete this artwork?');"><?= csrfField() ?><input type="hidden" name="artwork_id" value="<?= (int)$art['id'] ?>"><button class="btn sm red" name="action" value="reject_art">Reject</button></form>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="card">
    <div class="sec-head"><h2>Artists</h2></div>
    <?php if (!$artists): ?>
      <div class="empty">No artist accounts yet.</div>
    <?php else: ?>
      <table>
        <thead>
          <tr><th>Artist</th><th>Verification</th><th>Email</th><th>City</th><th>Verified</th><th>Approved</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($artists as $a): ?>
          <tr>
            <td>
              <strong><?= e($a['full_name_en'] ?: '—') ?></strong>
              <?php if (!empty($a['artist_name'])): ?><div class="name-ar"><?= e($a['artist_name']) ?></div><?php endif; ?>
              <?php if (!empty($a['full_name_ar'])): ?><div class="name-ar" dir="rtl"><?= e($a['full_name_ar']) ?></div><?php endif; ?>
            </td>
            <td>
              <div class="verify-cell">
                <?php if (!empty($a['profile_picture'])): ?>
                  <a href="<?= e($a['profile_picture']) ?>" target="_blank" title="Open full photo">
                    <img class="verify-photo" src="<?= e($a['profile_picture']) ?>" alt="photo">
                  </a>
                <?php else: ?>
                  <span class="no-media">No photo</span>
                <?php endif; ?>
                <?php if (!empty($a['art_video'])): ?>
                  <video class="verify-video" src="<?= e($a['art_video']) ?>" controls preload="metadata"></video>
                  <a class="video-link" href="<?= e($a['art_video']) ?>" target="_blank">Open video ↗</a>
                <?php else: ?>
                  <span class="no-media">No video</span>
                <?php endif; ?>
              </div>
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
