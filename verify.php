<?php
require_once 'config.php';

/* ---- Validate token (before output) ---- */
$token = sanitize($_GET['token'] ?? '');
$state = 'invalid';   // 'success' | 'invalid'

if ($token !== '' && ctype_xdigit($token) && strlen($token) <= 128) {
    $stmt = db()->prepare(
        'SELECT id FROM users
         WHERE verification_token = :t
           AND (verification_expires IS NULL OR verification_expires > NOW())
         LIMIT 1'
    );
    $stmt->execute([':t' => $token]);
    $row = $stmt->fetch();
    if ($row) {
        $upd = db()->prepare(
            'UPDATE users
             SET is_verified = 1, verification_token = NULL, verification_expires = NULL
             WHERE id = :id'
        );
        $upd->execute([':id' => $row['id']]);
        $state = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" id="html">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Account · Resha Art</title>
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

.auth-wrap{position:relative;z-index:10;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:90px 20px 40px;}
.auth-card{width:100%;max-width:440px;background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(0,0,0,0.07);border-radius:20px;box-shadow:0 20px 50px rgba(0,0,0,0.1);padding:40px 32px;text-align:center;animation:riseUp 0.8s cubic-bezier(0.22,1,0.36,1) forwards;opacity:0;}
.v-icon{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:34px;}
.v-icon.ok{background:rgba(0,180,100,0.12);border:1px solid rgba(0,180,100,0.3);}
.v-icon.bad{background:rgba(255,0,85,0.1);border:1px solid rgba(255,0,85,0.25);}
.auth-card h1{font-size:24px;font-weight:700;color:#111111;margin-bottom:10px;}
.auth-card p{font-size:14px;color:rgba(0,0,0,0.6);line-height:1.7;margin-bottom:24px;}
.btn-submit{display:inline-block;padding:12px 28px;border-radius:999px;background:#111111;color:#fff;font-size:12px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.25s;text-decoration:none;}
.btn-submit:hover{background:#ff0055;transform:translateY(-2px);}
.redir-note{margin-top:16px;font-size:12px;color:rgba(0,0,0,0.45);}
@keyframes riseUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
@media(max-width:768px){.topnav{padding:10px 14px;}.nav-logo span{display:none;}}
</style>
</head>
<body>
<div class="bg-wrap"><video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video></div>
<div class="overlay"></div>

<!-- NAV (shared brand navbar) -->
<nav class="topnav" id="topnav">
  <a class="nav-logo" href="index.html">
    <svg width="18" height="18" viewBox="0 0 256 256" fill="currentColor"><path d="M4.688 136C68.373 136 120 187.627 120 251.312C120 252.883 119.967 254.445 119.905 256L0 256L0 136.096C1.555 136.034 3.117 136 4.688 136ZM251.312 136C252.883 136 254.445 136.034 256 136.096L256 256L136.095 256C136.032 254.438 136.001 252.875 136 251.312C136 187.627 187.627 136 251.312 136ZM119.905 0C119.967 1.555 120 3.117 120 4.688C120 68.373 68.373 120 4.687 120C3.117 120 1.555 119.967 0 119.905L0 0ZM256 119.905C254.445 119.967 252.883 120 251.312 120C187.627 120 136 68.373 136 4.687C136 3.117 136.033 1.555 136.095 0L256 0Z"/></svg>
    <span>RESHA ART</span>
  </a>
  <div class="nav-center" id="nav-center">
    <div class="nav-item">
      <a href="studio.php" id="nav-studio-link"><span id="nav-studio-label">The Studio</span><svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg></a>
      <div class="dropdown" id="dd-studio">
        <a href="studio.php#watercolor"><svg class="d-icon" viewBox="0 0 24 24"><path d="M12 2C8 2 4 6 4 10c0 5.25 8 12 8 12s8-6.75 8-12c0-4-4-8-8-8z"/></svg><span id="dd-s1">Watercolor Workshop</span></a>
        <a href="studio.php#oil"><svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg><span id="dd-s2">Oil Painting Studio</span></a>
        <a href="studio.php#digital"><svg class="d-icon" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg><span id="dd-s3">Digital Art Lab</span></a>
        <a href="studio.php#charcoal"><svg class="d-icon" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg><span id="dd-s4">Charcoal & Ink</span></a>
      </div>
    </div>
    <div class="nav-item">
      <a href="community.php" id="nav-community-link"><span id="nav-community-label">Community</span><svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg></a>
      <div class="dropdown" id="dd-community">
        <a href="chat.php"><svg class="d-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span id="dd-c1">Artist Chat Room</span></a>
        <a href="community.php#meet"><svg class="d-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span id="dd-c2">Meet Fellow Artists</span></a>
        <a href="community.php#share"><svg class="d-icon" viewBox="0 0 24 24"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg><span id="dd-c3">Share Your Work</span></a>
        <a href="community.php#learn"><svg class="d-icon" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg><span id="dd-c4">Learn Together</span></a>
      </div>
    </div>
    <div class="nav-item"><a href="marketplace.php" id="nav-marketplace-link"><span id="nav-marketplace-label">Marketplace</span></a></div>
    <div class="nav-item"><a href="explore.php" id="nav-explore-link"><span id="nav-explore-label">Explore Art Styles</span></a></div>
    <div class="nav-item">
      <a href="support.php" id="nav-support-link"><span id="nav-support-label">Support</span><svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg></a>
      <div class="dropdown" id="dd-support">
        <a href="mailto:contact@reshaart.com"><svg class="d-icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span id="dd-sp1">Contact Us</span></a>
        <a href="support.php#how"><svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg><span id="dd-sp2">How It Works</span></a>
        <a href="support.php#terms"><svg class="d-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span id="dd-sp3">Terms of Use</span></a>
      </div>
    </div>
  </div>
  <div class="nav-right">
    <a class="nav-btn primary" href="chat.php" id="n-chat"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg><span id="n-chat-t">Artist Chat</span></a>
    <a class="nav-btn" href="login.php" id="n-login"><span id="n-login-t">Sign In</span></a>
    <a class="nav-btn" href="register.php" id="n-reg"><span id="n-reg-t">Join Free</span></a>
    <button class="lang-btn" onclick="tgl()" id="lb">العربية</button>
  </div>
</nav>

<div class="auth-wrap">
  <div class="auth-card">
    <?php if ($state === 'success'): ?>
      <div class="v-icon ok">✓</div>
      <h1 id="t-title">Your account is verified</h1>
      <p id="t-sub">You can now sign in.</p>
      <a class="btn-submit" href="login.php" id="t-btn">Sign In</a>
      <p class="redir-note" id="t-redir">Redirecting to sign in…</p>
    <?php else: ?>
      <div class="v-icon bad">✕</div>
      <h1 id="t-title">Invalid or expired link</h1>
      <p id="t-sub">This verification link is invalid or has expired. Please register again or request a new link.</p>
      <a class="btn-submit" href="register.php" id="t-btn">Register</a>
    <?php endif; ?>
  </div>
</div>

<script>
const STATE = <?= json_encode($state) ?>;
const T={
  en:{dir:'ltr',lb:'العربية',
    okTitle:'Your account is verified',okSub:'You can now sign in.',okBtn:'Sign In',redir:'Redirecting to sign in…',
    badTitle:'Invalid or expired link',badSub:'This verification link is invalid or has expired. Please register again or request a new link.',badBtn:'Register',
    nav:{studio:'The Studio',community:'Community',marketplace:'Marketplace',explore:'Explore Art Styles',support:'Support',
      s1:'Watercolor Workshop',s2:'Oil Painting Studio',s3:'Digital Art Lab',s4:'Charcoal & Ink',
      c1:'Artist Chat Room',c2:'Meet Fellow Artists',c3:'Share Your Work',c4:'Learn Together',
      sp1:'Contact Us',sp2:'How It Works',sp3:'Terms of Use',chat:'Artist Chat',login:'Sign In',reg:'Join Free'}},
  ar:{dir:'rtl',lb:'English',
    okTitle:'تم التحقق من حسابك',okSub:'يمكنك الآن تسجيل الدخول.',okBtn:'تسجيل الدخول',redir:'جارٍ التحويل إلى تسجيل الدخول…',
    badTitle:'رابط غير صالح أو منتهي',badSub:'رابط التحقق غير صالح أو منتهي الصلاحية. يرجى التسجيل مرة أخرى أو طلب رابط جديد.',badBtn:'إنشاء حساب',
    nav:{studio:'الاستوديو',community:'المجتمع',marketplace:'السوق',explore:'استكشف أساليب الرسم',support:'الدعم',
      s1:'ورشة الألوان المائية',s2:'استوديو الرسم الزيتي',s3:'مختبر الفن الرقمي',s4:'الفحم والحبر',
      c1:'غرفة محادثة الفنانين',c2:'تعرّف على فنانين',c3:'شارك أعمالك',c4:'تعلّم معاً',
      sp1:'تواصل معنا',sp2:'كيف يعمل الموقع',sp3:'شروط الاستخدام',chat:'محادثة الفنانين',login:'تسجيل الدخول',reg:'انضم مجاناً'}}
};
let L='en';
function setTxt(id,v){const el=document.getElementById(id);if(el)el.textContent=v;}
function apply(l){
  const t=T[l];
  document.getElementById('html').lang=l;
  document.getElementById('html').setAttribute('dir',t.dir);
  document.documentElement.setAttribute('dir',t.dir);
  document.getElementById('topnav').setAttribute('dir',t.dir);
  document.getElementById('lb').textContent=t.lb;
  if(STATE==='success'){
    setTxt('t-title',t.okTitle);setTxt('t-sub',t.okSub);setTxt('t-btn',t.okBtn);setTxt('t-redir',t.redir);
  }else{
    setTxt('t-title',t.badTitle);setTxt('t-sub',t.badSub);setTxt('t-btn',t.badBtn);
  }
  const n=t.nav;
  setTxt('nav-studio-label',n.studio);setTxt('nav-community-label',n.community);
  setTxt('nav-marketplace-label',n.marketplace);setTxt('nav-explore-label',n.explore);setTxt('nav-support-label',n.support);
  setTxt('dd-s1',n.s1);setTxt('dd-s2',n.s2);setTxt('dd-s3',n.s3);setTxt('dd-s4',n.s4);
  setTxt('dd-c1',n.c1);setTxt('dd-c2',n.c2);setTxt('dd-c3',n.c3);setTxt('dd-c4',n.c4);
  setTxt('dd-sp1',n.sp1);setTxt('dd-sp2',n.sp2);setTxt('dd-sp3',n.sp3);
  setTxt('n-chat-t',n.chat);setTxt('n-login-t',n.login);setTxt('n-reg-t',n.reg);
}
function tgl(){L=L==='en'?'ar':'en';apply(L);}
apply('en');
const v=document.getElementById('vid');
if(v){v.addEventListener('canplay',()=>v.classList.add('on'),{once:true});v.play().catch(()=>{});}
// Auto-redirect to login 3s after a successful verification.
if(STATE==='success'){ setTimeout(()=>{ window.location.href='login.php'; }, 3000); }
</script>
</body>
</html>
