<?php
require_once 'config.php';

/* ---- Handle submit (before any output) ---- */
$errCode = '';
$okCode  = '';
$old = ['name_en' => '', 'name_ar' => '', 'artist_name' => '', 'email' => '', 'phone' => '', 'city' => '', 'role' => 'collector'];

/* Video upload limits (profile picture reuses config's 5 MB image validator). */
const VIDEO_MAX_BYTES = 50 * 1024 * 1024; // 50 MB

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $old['name_en']     = sanitize($_POST['full_name_en'] ?? '');
    $old['name_ar']     = sanitize($_POST['full_name_ar'] ?? '');
    $old['artist_name'] = sanitize($_POST['artist_name'] ?? '');
    $old['email']       = sanitize($_POST['email'] ?? '');
    $old['phone']       = sanitize($_POST['phone'] ?? '');
    $old['city']        = sanitize($_POST['city'] ?? '');
    $role               = ($_POST['role'] ?? '') === 'artist' ? 'artist' : 'collector';
    $old['role']        = $role;
    $pass    = (string) ($_POST['password'] ?? '');
    $confirm = (string) ($_POST['confirm'] ?? '');
    $terms   = !empty($_POST['terms']);

    $hasPhoto = !empty($_FILES['profile_picture']['name']);
    $hasVideo = !empty($_FILES['art_video']['name']);

    $strong = strlen($pass) >= 8
        && preg_match('/[A-Z]/', $pass)
        && preg_match('/[0-9]/', $pass)
        && preg_match('/[!@#$%^&*]/', $pass);

    if (!verifyCsrf($_POST['csrf_token'] ?? null)) {
        $errCode = 'csrf';
    } elseif ($old['name_en'] === '' || $old['email'] === '' || $old['phone'] === '') {
        $errCode = 'required';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errCode = 'email';
    } elseif (!preg_match('/^[+0-9][0-9 \-()]{6,29}$/', $old['phone'])) {
        $errCode = 'phone';
    } elseif (!$strong) {
        $errCode = 'weak';
    } elseif ($pass !== $confirm) {
        $errCode = 'mismatch';
    } elseif (!$terms) {
        $errCode = 'terms';
    } elseif ($role === 'artist' && !$hasVideo) {
        $errCode = 'video_required';
    } elseif ($hasPhoto && !validateUpload($_FILES['profile_picture'])['ok']) {
        $errCode = 'photo';
    } elseif ($hasVideo && !validateVideoUpload($_FILES['art_video'])['ok']) {
        $errCode = 'video';
    } else {
        // Email already exists?
        $stmt = getDB()->prepare('SELECT 1 FROM users WHERE email = :e LIMIT 1');
        $stmt->execute([':e' => $old['email']]);
        if ($stmt->fetchColumn()) {
            $errCode = 'exists';
        } else {
            // ---- Save uploaded files (already validated above) ----
            $photoRel = '';
            $videoRel = '';
            if ($hasPhoto) {
                $chk = validateUpload($_FILES['profile_picture']);
                $dir = __DIR__ . '/uploads/profiles/';
                if (!is_dir($dir)) { @mkdir($dir, 0755, true); }
                $fname = safeUploadName($chk['ext']);
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $dir . $fname)) {
                    $photoRel = 'uploads/profiles/' . $fname;
                }
            }
            if ($hasVideo) {
                $chk = validateVideoUpload($_FILES['art_video']);
                $dir = __DIR__ . '/uploads/videos/';
                if (!is_dir($dir)) { @mkdir($dir, 0755, true); }
                $fname = safeUploadName($chk['ext']);
                if (move_uploaded_file($_FILES['art_video']['tmp_name'], $dir . $fname)) {
                    $videoRel = 'uploads/videos/' . $fname;
                }
            }

            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 24 * 60 * 60); // 24h
            $ins = getDB()->prepare(
                'INSERT INTO users
                   (email, password, full_name_en, full_name_ar, artist_name, phone, role, city,
                    profile_picture, art_video,
                    is_verified, is_approved, verification_token, verification_expires)
                 VALUES
                   (:email, :pass, :nen, :nar, :aname, :phone, :role, :city,
                    :pic, :vid, 0, 0, :tok, :exp)'
            );
            $ins->execute([
                ':email' => $old['email'],
                ':pass'  => hashPassword($pass),
                ':nen'   => $old['name_en'],
                ':nar'   => $old['name_ar'],
                ':aname' => $old['artist_name'],
                ':phone' => $old['phone'],
                ':role'  => $role,
                ':city'  => $old['city'],
                ':pic'   => $photoRel,
                ':vid'   => $videoRel,
                ':tok'   => $token,
                ':exp'   => $expires,
            ]);

            // Send the verification email over authenticated SMTP. The From
            // address MUST be an address on this domain (no-reply@oweili.com)
            // or the mail server will silently drop it.
            $verifyUrl = 'https://' . ($_SERVER['HTTP_HOST'] ?? 'oweili.com')
                       . '/verify.php?token=' . $token;
            $subject = 'Verify your account';
            $body = "Welcome!\r\n\r\nPlease verify your account by clicking the link below:\r\n"
                  . $verifyUrl . "\r\n\r\nThis link expires in 24 hours.\r\n";

            if (!sendEmail($old['email'], $subject, $body)) {
                error_log('register.php: verification email failed to send to ' . $old['email']);
            }

            $okCode = 'check_email';
            $old = ['name_en' => '', 'name_ar' => '', 'artist_name' => '', 'email' => '', 'phone' => '', 'city' => '', 'role' => 'collector'];
        }
    }
}

/**
 * Validate an uploaded art video: MP4 only, up to 50 MB, real MIME check.
 * Returns ['ok'=>bool, 'ext'=>'mp4'].
 */
function validateVideoUpload(array $file): array {
    if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'ext' => ''];
    }
    if ($file['size'] <= 0 || $file['size'] > VIDEO_MAX_BYTES) {
        return ['ok' => false, 'ext' => ''];
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        return ['ok' => false, 'ext' => ''];
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    $ext   = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($mime, ['video/mp4', 'application/mp4'], true) || $ext !== 'mp4') {
        return ['ok' => false, 'ext' => ''];
    }
    return ['ok' => true, 'ext' => 'mp4'];
}

$ERR = [
    'csrf'     => ['en' => 'Security check failed. Please try again.', 'ar' => 'فشل التحقق الأمني. حاول مرة أخرى.'],
    'required' => ['en' => 'Please fill in the required fields.', 'ar' => 'يرجى تعبئة الحقول المطلوبة.'],
    'email'    => ['en' => 'Please enter a valid email address.', 'ar' => 'يرجى إدخال بريد إلكتروني صالح.'],
    'phone'    => ['en' => 'Please enter a valid phone number.', 'ar' => 'يرجى إدخال رقم هاتف صالح.'],
    'weak'     => ['en' => 'Password does not meet the requirements.', 'ar' => 'كلمة المرور لا تستوفي الشروط.'],
    'mismatch' => ['en' => 'Passwords do not match.', 'ar' => 'كلمتا المرور غير متطابقتين.'],
    'terms'    => ['en' => 'You must accept the terms and conditions.', 'ar' => 'يجب الموافقة على الشروط والأحكام.'],
    'exists'   => ['en' => 'An account with this email already exists.', 'ar' => 'يوجد حساب بهذا البريد الإلكتروني بالفعل.'],
    'video_required' => ['en' => 'Artists must upload a short video of themselves creating art.', 'ar' => 'يجب على الفنانين رفع فيديو قصير أثناء إبداع العمل الفني.'],
    'photo'    => ['en' => 'Profile picture must be a JPG or PNG under 5 MB.', 'ar' => 'يجب أن تكون الصورة الشخصية بصيغة JPG أو PNG وأقل من 5 ميجابايت.'],
    'video'    => ['en' => 'Art video must be an MP4 file under 50 MB.', 'ar' => 'يجب أن يكون الفيديو بصيغة MP4 وأقل من 50 ميجابايت.'],
];
$OK = ['check_email' => ['en' => 'Please check your email to verify your account.', 'ar' => 'يرجى مراجعة بريدك الإلكتروني لتفعيل حسابك.']];
$errEn = $errCode ? $ERR[$errCode]['en'] : '';
$errAr = $errCode ? $ERR[$errCode]['ar'] : '';
$okEn  = $okCode ? $OK[$okCode]['en'] : '';
$okAr  = $okCode ? $OK[$okCode]['ar'] : '';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" id="html">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Free · Oweili</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
html,body{width:100%;min-height:100vh;background:#fff;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;overflow-x:hidden;}
.bg-wrap{position:fixed;inset:0;z-index:0;overflow:hidden;}
.bg-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity 2s ease;z-index:2;}
.bg-video.on{opacity:0.95;}
.overlay{position:fixed;inset:0;z-index:3;pointer-events:none;background:linear-gradient(160deg,rgba(255,255,255,0.18) 0%,rgba(255,255,255,0) 50%,rgba(255,255,255,0.35) 100%);}
/* ── TOP NAV (shared brand navbar) ── */
.topnav{position:fixed;top:0;left:0;right:0;z-index:200;display:flex;align-items:center;justify-content:space-between;padding:0 16px;height:56px;background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid rgba(0,0,0,0.05);}
[dir="rtl"] .nav-center{flex-direction:row-reverse;}
[dir="rtl"] .dropdown{left:auto;right:0;text-align:right;}
[dir="rtl"] .dropdown a{flex-direction:row-reverse;}
.nav-logo{display:flex;align-items:center;gap:6px;text-decoration:none;color:#111111;flex-shrink:0;}
.nav-logo svg{color:#ff0055;}
.nav-logo span{font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;}
.nav-center{display:flex;align-items:stretch;gap:0;height:100%;}
.nav-item{position:relative;display:flex;align-items:center;}
.nav-item > a{display:flex;align-items:center;gap:4px;padding:0 12px;height:100%;font-size:10px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:rgba(0,0,0,0.65);text-decoration:none;transition:color 0.2s;white-space:nowrap;border-bottom:2px solid transparent;}
.nav-item > a:hover{color:#000;}
.nav-item:hover > a{color:#0055ff;border-bottom-color:#0055ff;}
.nav-item > a .chevron{width:10px;height:10px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;transition:transform 0.2s;flex-shrink:0;}
.nav-item:hover > a .chevron{transform:rotate(180deg);}
.dropdown{position:absolute;top:100%;left:0;min-width:200px;background:rgba(255,255,255,0.96);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(0,0,0,0.07);border-radius:14px;box-shadow:0 16px 40px rgba(0,0,0,0.1);padding:8px;opacity:0;visibility:hidden;transform:translateY(8px);transition:opacity 0.2s,transform 0.2s,visibility 0.2s;pointer-events:none;}
.nav-item:hover .dropdown{opacity:1;visibility:visible;transform:translateY(0);pointer-events:auto;}
.dropdown a{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;font-size:12px;color:rgba(0,0,0,0.7);text-decoration:none;transition:background 0.15s,color 0.15s;}
.dropdown a:hover{background:rgba(0,100,255,0.07);color:#0055ff;}
.dropdown a .d-icon{width:14px;height:14px;fill:currentColor;opacity:0.6;flex-shrink:0;}
.nav-right{display:flex;align-items:center;gap:6px;flex-shrink:0;}
.nav-btn{padding:5px 12px;border-radius:999px;font-size:10px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all 0.22s;border:1px solid rgba(0,0,0,0.1);background:rgba(0,0,0,0.04);color:rgba(0,0,0,0.8);}
.nav-btn:hover{background:rgba(0,0,0,0.08);color:#000;}
.nav-btn.primary{background:rgba(0,100,255,0.1);border-color:rgba(0,100,255,0.2);color:#0066ff;}
.nav-btn.primary:hover{background:rgba(0,100,255,0.18);}
.lang-btn{padding:4px 10px;border-radius:999px;font-size:10px;font-weight:600;letter-spacing:0.04em;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.7);color:rgba(0,0,0,0.7);backdrop-filter:blur(8px);transition:all 0.22s;}
.lang-btn:hover{background:#111111;color:#fff;}
@media(max-width:1024px){.nav-center{display:none;}}

/* ── AUTH CARD ── */
.auth-wrap{position:relative;z-index:10;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:90px 20px 40px;}
.auth-card{width:100%;max-width:480px;background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(0,0,0,0.07);border-radius:20px;box-shadow:0 20px 50px rgba(0,0,0,0.1);padding:36px 32px;animation:riseUp 0.8s cubic-bezier(0.22,1,0.36,1) forwards;opacity:0;}
.auth-head{margin-bottom:22px;text-align:center;}
.auth-head h1{font-size:26px;font-weight:700;color:#111111;margin-bottom:6px;}
.auth-head p{font-size:13px;color:rgba(0,0,0,0.55);}
.field{margin-bottom:14px;}
.field label{display:block;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:rgba(0,0,0,0.55);margin-bottom:6px;}
.field input,.field select{width:100%;padding:11px 14px;border-radius:12px;border:1px solid rgba(0,0,0,0.12);background:rgba(255,255,255,0.7);font-size:14px;color:#111111;transition:border 0.2s,box-shadow 0.2s;font-family:inherit;}
.field input:focus,.field select:focus{outline:none;border-color:#0066ff;box-shadow:0 0 0 3px rgba(0,100,255,0.12);}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.field input[type=file]{padding:9px 12px;font-size:12px;cursor:pointer;background:rgba(255,255,255,0.7);}
.field input[type=file]::file-selector-button{margin-right:12px;padding:6px 14px;border-radius:999px;border:none;background:#111111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;cursor:pointer;font-family:inherit;}
.field input[type=file]::file-selector-button:hover{background:#ff0055;}
[dir="rtl"] .field input[type=file]::file-selector-button{margin-right:0;margin-left:12px;}
.pw-wrap{position:relative;}
.pw-toggle{position:absolute;top:50%;transform:translateY(-50%);right:10px;background:none;border:none;cursor:pointer;font-size:11px;font-weight:600;color:#0066ff;text-transform:uppercase;letter-spacing:0.04em;padding:4px;}
[dir="rtl"] .pw-toggle{right:auto;left:10px;}
.pw-rules{list-style:none;margin:6px 0 4px;padding:10px 14px;background:rgba(0,0,0,0.03);border-radius:12px;}
.pw-rules li{font-size:12px;color:rgba(0,0,0,0.55);padding:3px 0;display:flex;align-items:center;gap:8px;transition:color 0.2s;}
[dir="rtl"] .pw-rules li{flex-direction:row-reverse;}
.pw-rules li .mark{width:16px;height:16px;border-radius:50%;border:1px solid rgba(0,0,0,0.2);display:inline-flex;align-items:center;justify-content:center;font-size:10px;color:transparent;flex-shrink:0;transition:all 0.2s;}
.pw-rules li.ok{color:#00a050;}
.pw-rules li.ok .mark{background:#00a050;border-color:#00a050;color:#fff;}
.terms{display:flex;align-items:flex-start;gap:8px;margin:6px 0 18px;font-size:12px;color:rgba(0,0,0,0.65);}
[dir="rtl"] .terms{flex-direction:row-reverse;text-align:right;}
.terms input{width:15px;height:15px;margin-top:2px;accent-color:#ff0055;cursor:pointer;flex-shrink:0;}
.btn-submit{width:100%;padding:13px;border-radius:999px;background:#111111;color:#fff;font-size:12px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.25s;}
.btn-submit:hover{background:#ff0055;transform:translateY(-2px);}
.auth-foot{margin-top:20px;text-align:center;font-size:13px;color:rgba(0,0,0,0.6);}
.link{color:#0066ff;text-decoration:none;font-weight:600;}
.link:hover{text-decoration:underline;}
.err-box{background:rgba(255,0,85,0.08);border:1px solid rgba(255,0,85,0.25);color:#ff0055;font-size:13px;font-weight:600;padding:11px 14px;border-radius:12px;margin-bottom:16px;}
.ok-box{background:rgba(0,180,100,0.1);border:1px solid rgba(0,180,100,0.3);color:#00a050;font-size:13px;font-weight:600;padding:11px 14px;border-radius:12px;margin-bottom:16px;}
[dir="rtl"] .auth-card{text-align:right;}
@keyframes riseUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
@media(max-width:768px){.topnav{padding:10px 14px;}.nav-logo span{display:none;}.grid2{grid-template-columns:1fr;}}
</style>
</head>
<body>
<div class="bg-wrap"><video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video></div>
<div class="overlay"></div>

<!-- NAV (shared brand navbar) -->
<?php include __DIR__ . "/nav.php"; ?>

<!-- REGISTER CARD -->
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-head">
      <h1 id="t-title">Join Free</h1>
      <p id="t-sub">Create your Oweili account</p>
    </div>

    <div class="err-box" id="err"
         data-en="<?= e($errEn) ?>" data-ar="<?= e($errAr) ?>"
         style="display:<?= $errCode ? 'block' : 'none' ?>;"><?= e($errEn) ?></div>
    <div class="ok-box" id="ok"
         data-en="<?= e($okEn) ?>" data-ar="<?= e($okAr) ?>"
         style="display:<?= $okCode ? 'block' : 'none' ?>;"><?= e($okEn) ?></div>

    <form method="post" action="register.php" autocomplete="on" enctype="multipart/form-data">
      <?= csrfField() ?>
      <div class="grid2">
        <div class="field">
          <label id="t-l-nen" for="name_en">Full name (English)</label>
          <input type="text" id="name_en" name="full_name_en" required value="<?= e($old['name_en']) ?>">
        </div>
        <div class="field">
          <label id="t-l-nar" for="name_ar">Full name (Arabic)</label>
          <input type="text" id="name_ar" name="full_name_ar" value="<?= e($old['name_ar']) ?>" dir="rtl">
        </div>
      </div>
      <div class="field">
        <label id="t-l-aname" for="artist_name">Public / artist name</label>
        <input type="text" id="artist_name" name="artist_name" value="<?= e($old['artist_name']) ?>" placeholder="Shown publicly on your profile">
      </div>
      <div class="field">
        <label id="t-l-email" for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?= e($old['email']) ?>">
      </div>
      <div class="field">
        <label id="t-l-phone" for="phone">Phone number</label>
        <input type="tel" id="phone" name="phone" required value="<?= e($old['phone']) ?>" placeholder="+966 5X XXX XXXX" dir="ltr">
      </div>
      <div class="field">
        <label id="t-l-photo" for="profile_picture">Profile picture (JPG/PNG, max 5MB)</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png">
      </div>
      <div class="field">
        <label id="t-l-pass" for="password">Password</label>
        <div class="pw-wrap">
          <input type="password" id="password" name="password" required oninput="checkRules()">
          <button type="button" class="pw-toggle" id="pw-toggle" onclick="togglePw('password',this)">SHOW</button>
        </div>
        <ul class="pw-rules">
          <li id="r-len"><span class="mark">✓</span><span id="t-r-len">Minimum 8 characters</span></li>
          <li id="r-upper"><span class="mark">✓</span><span id="t-r-upper">At least one uppercase letter</span></li>
          <li id="r-num"><span class="mark">✓</span><span id="t-r-num">At least one number</span></li>
          <li id="r-spec"><span class="mark">✓</span><span id="t-r-spec">At least one special character (!@#$%^&*)</span></li>
        </ul>
      </div>
      <div class="field">
        <label id="t-l-confirm" for="confirm">Confirm password</label>
        <div class="pw-wrap">
          <input type="password" id="confirm" name="confirm" required>
          <button type="button" class="pw-toggle" id="pw-toggle2" onclick="togglePw('confirm',this)">SHOW</button>
        </div>
      </div>
      <div class="grid2">
        <div class="field">
          <label id="t-l-role" for="role">I am a…</label>
          <select id="role" name="role" onchange="toggleVideo()">
            <option value="artist" id="opt-artist" <?= $old['role']==='artist'?'selected':'' ?>>Artist</option>
            <option value="collector" id="opt-collector" <?= $old['role']!=='artist'?'selected':'' ?>>Collector</option>
          </select>
        </div>
        <div class="field">
          <label id="t-l-city" for="city">City</label>
          <input type="text" id="city" name="city" value="<?= e($old['city']) ?>">
        </div>
      </div>
      <div class="field" id="video-field" style="display:none;">
        <label id="t-l-video" for="art_video">Art video — proof you create art (MP4, max 50MB)</label>
        <input type="file" id="art_video" name="art_video" accept="video/mp4">
        <p id="t-video-hint" style="font-size:11px;color:rgba(0,0,0,0.5);margin-top:6px;line-height:1.6;">A short clip of you creating art. Required for artists — the admin reviews it before approval.</p>
      </div>
      <label class="terms"><input type="checkbox" name="terms" value="1"><span id="t-terms">I agree to the Terms &amp; Conditions and Privacy Policy.</span></label>
      <button type="submit" class="btn-submit" id="t-submit">Join Free</button>
    </form>

    <div class="auth-foot">
      <span id="t-haveacc">Already have an account?</span>
      <a class="link" href="login.php" id="t-loginlink">Sign In</a>
    </div>
  </div>
</div>

<script>
const T={
  en:{dir:'ltr',lb:'العربية',title:'Join Free',sub:'Create your Oweili account',
    nen:'Full name (English)',nar:'Full name (Arabic)',aname:'Public / artist name',anamePlace:'Shown publicly on your profile',
    email:'Email',phone:'Phone number',photo:'Profile picture (JPG/PNG, max 5MB)',
    video:'Art video — proof you create art (MP4, max 50MB)',videoHint:'A short clip of you creating art. Required for artists — the admin reviews it before approval.',
    pass:'Password',confirm:'Confirm password',
    role:'I am a…',artist:'Artist',collector:'Collector',city:'City',
    rlen:'Minimum 8 characters',rupper:'At least one uppercase letter',rnum:'At least one number',rspec:'At least one special character (!@#$%^&*)',
    terms:'I agree to the Terms & Conditions and Privacy Policy.',submit:'Join Free',
    haveacc:'Already have an account?',loginlink:'Sign In',show:'SHOW',hide:'HIDE',
    nav:{studio:'The Studio',community:'Community',marketplace:'Marketplace',explore:'Explore Art Styles',support:'Support',
      s1:'Watercolor Workshop',s2:'Oil Painting Studio',s3:'Digital Art Lab',s4:'Charcoal & Ink',
      c1:'Artist Chat Room',c2:'Meet Fellow Artists',c3:'Share Your Work',c4:'Learn Together',
      sp1:'Contact Us',sp2:'How It Works',sp3:'Terms of Use',login:'Sign In',reg:'Join Free'}},
  ar:{dir:'rtl',lb:'English',title:'انضم مجاناً',sub:'أنشئ حسابك في أويلي',
    nen:'الاسم الكامل بالإنجليزية',nar:'الاسم الكامل بالعربية',aname:'الاسم العام / اسم الفنان',anamePlace:'يظهر علناً في ملفك الشخصي',
    email:'البريد الإلكتروني',phone:'رقم الهاتف',photo:'الصورة الشخصية (JPG/PNG، بحد أقصى 5 ميجابايت)',
    video:'فيديو فني — إثبات أنك تبدع الفن (MP4، بحد أقصى 50 ميجابايت)',videoHint:'مقطع قصير أثناء إبداعك للفن. مطلوب للفنانين — يراجعه المشرف قبل الموافقة.',
    pass:'كلمة المرور',confirm:'تأكيد كلمة المرور',
    role:'أنا…',artist:'فنان',collector:'مقتني',city:'المدينة',
    rlen:'الحد الأدنى 8 أحرف',rupper:'حرف كبير واحد على الأقل',rnum:'رقم واحد على الأقل',rspec:'رمز خاص واحد على الأقل (!@#$%^&*)',
    terms:'أوافق على الشروط والأحكام وسياسة الخصوصية.',submit:'انضم مجاناً',
    haveacc:'لديك حساب بالفعل؟',loginlink:'تسجيل الدخول',show:'إظهار',hide:'إخفاء',
    nav:{studio:'الاستوديو',community:'المجتمع',marketplace:'السوق',explore:'استكشف أساليب الرسم',support:'الدعم',
      s1:'ورشة الألوان المائية',s2:'استوديو الرسم الزيتي',s3:'مختبر الفن الرقمي',s4:'الفحم والحبر',
      c1:'غرفة محادثة الفنانين',c2:'تعرّف على فنانين',c3:'شارك أعمالك',c4:'تعلّم معاً',
      sp1:'تواصل معنا',sp2:'كيف يعمل الموقع',sp3:'شروط الاستخدام',login:'تسجيل الدخول',reg:'انضم مجاناً'}}
};
let L='en';
function togglePw(id,btn){
  const f=document.getElementById(id);
  const show=f.type==='password';
  f.type=show?'text':'password';
  btn.dataset.state=show?'shown':'hidden';
  btn.textContent=show?T[L].hide:T[L].show;
}
function checkRules(){
  const p=document.getElementById('password').value;
  const set=(id,ok)=>document.getElementById(id).classList.toggle('ok',ok);
  set('r-len',p.length>=8);
  set('r-upper',/[A-Z]/.test(p));
  set('r-num',/[0-9]/.test(p));
  set('r-spec',/[!@#$%^&*]/.test(p));
}
function setTxt(id,v){const el=document.getElementById(id);if(el)el.textContent=v;}
function apply(l){
  const t=T[l];
  document.getElementById('html').lang=l;
  document.getElementById('html').setAttribute('dir',t.dir);
  document.documentElement.setAttribute('dir',t.dir);
  document.getElementById('topnav').setAttribute('dir',t.dir);
  document.getElementById('lb').textContent=t.lb;
  setTxt('t-title',t.title);setTxt('t-sub',t.sub);
  setTxt('t-l-nen',t.nen);setTxt('t-l-nar',t.nar);setTxt('t-l-email',t.email);setTxt('t-l-phone',t.phone);
  setTxt('t-l-aname',t.aname);
  const an=document.getElementById('artist_name');if(an)an.placeholder=t.anamePlace;
  setTxt('t-l-photo',t.photo);setTxt('t-l-video',t.video);setTxt('t-video-hint',t.videoHint);
  setTxt('t-l-pass',t.pass);setTxt('t-l-confirm',t.confirm);
  setTxt('t-l-role',t.role);setTxt('opt-artist',t.artist);setTxt('opt-collector',t.collector);setTxt('t-l-city',t.city);
  setTxt('t-r-len',t.rlen);setTxt('t-r-upper',t.rupper);setTxt('t-r-num',t.rnum);setTxt('t-r-spec',t.rspec);
  setTxt('t-terms',t.terms);setTxt('t-submit',t.submit);
  setTxt('t-haveacc',t.haveacc);setTxt('t-loginlink',t.loginlink);
  ['pw-toggle','pw-toggle2'].forEach(id=>{const b=document.getElementById(id);if(b)b.textContent=(b.dataset.state==='shown')?t.hide:t.show;});
  const err=document.getElementById('err');if(err){const v=l==='ar'?err.dataset.ar:err.dataset.en;if(v)err.textContent=v;}
  const ok=document.getElementById('ok');if(ok){const v=l==='ar'?ok.dataset.ar:ok.dataset.en;if(v)ok.textContent=v;}
  const n=t.nav;
  setTxt('nav-studio-label',n.studio);setTxt('nav-community-label',n.community);
  setTxt('nav-marketplace-label',n.marketplace);setTxt('nav-explore-label',n.explore);setTxt('nav-support-label',n.support);
  setTxt('dd-s1',n.s1);setTxt('dd-s2',n.s2);setTxt('dd-s3',n.s3);setTxt('dd-s4',n.s4);
  setTxt('dd-c1',n.c1);setTxt('dd-c2',n.c2);setTxt('dd-c3',n.c3);setTxt('dd-c4',n.c4);
  setTxt('dd-sp1',n.sp1);setTxt('dd-sp2',n.sp2);setTxt('dd-sp3',n.sp3);
  setTxt('n-login-t',n.login);setTxt('n-reg-t',n.reg);
}
function toggleVideo(){
  const isArtist=document.getElementById('role').value==='artist';
  const wrap=document.getElementById('video-field');
  const vid=document.getElementById('art_video');
  if(wrap)wrap.style.display=isArtist?'block':'none';
  if(vid)vid.required=isArtist;
}
function tgl(){L=L==='en'?'ar':'en';apply(L);try{localStorage.setItem('lang',L);}catch(e){}}
try{var _s=localStorage.getItem('lang');if(_s==='ar'||_s==='en')L=_s;}catch(e){}
apply(L);
toggleVideo();
const v=document.getElementById('vid');
if(v){v.addEventListener('canplay',()=>v.classList.add('on'),{once:true});v.play().catch(()=>{});}
</script>
</body>
</html>
