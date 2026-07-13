<?php
require_once 'config.php';

/* People directory — logged-in users only. */
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

/* Approved artists + verified collectors, excluding banned accounts. */
$people = getDB()->query(
    "SELECT full_name_en, full_name_ar, artist_name, city, role, profile_picture
     FROM users
     WHERE COALESCE(is_banned,0) = 0
       AND is_verified = 1
       AND ( (role = 'artist' AND is_approved = 1) OR role = 'collector' )
     ORDER BY (role = 'artist') DESC, full_name_en ASC"
)->fetchAll();

/** First-letter avatar fallback when there's no profile picture. */
function initialOf(string $name): string {
    $name = trim($name);
    if ($name === '') return '?';
    return mb_strtoupper(mb_substr($name, 0, 1));
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" id="html">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>People · Oweili</title>
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

.page{position:relative;z-index:10;width:100%;max-width:1200px;margin:0 auto;padding:100px 24px 56px;}
.page-header{margin-bottom:26px;}
.page-badge{display:inline-flex;align-items:center;gap:8px;padding:5px 14px;border-radius:999px;margin-bottom:14px;background:rgba(0,100,255,0.06);border:1px solid rgba(0,100,255,0.15);font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#0066ff;}
.pulse-dot{width:6px;height:6px;border-radius:50%;background:#0066ff;box-shadow:0 0 8px rgba(0,100,255,0.5);animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:0.4;}}
.page-header h1{font-size:clamp(28px,4vw,48px);font-weight:300;color:#111;margin-bottom:12px;letter-spacing:-0.02em;}
.page-header h1 em{font-style:normal;font-weight:700;background:linear-gradient(90deg,#ff0055,#0066ff,#aa00ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.page-header p{font-size:15px;color:rgba(0,0,0,0.6);line-height:1.8;max-width:580px;}
[dir="rtl"] .page-header p{text-align:right;}

.filter-bar{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:26px;}
[dir="rtl"] .filter-bar{flex-direction:row-reverse;}
.filter-btn{padding:8px 20px;border-radius:999px;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.6);backdrop-filter:blur(8px);color:rgba(0,0,0,0.7);transition:all 0.22s;}
.filter-btn:hover{background:rgba(255,255,255,0.9);color:#111;}
.filter-btn.active{background:#111111;color:#fff;border-color:#111111;}

.people-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;}
.person-card{background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.07);border-radius:20px;padding:24px 20px;text-align:center;backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);transition:transform 0.3s ease,box-shadow 0.3s ease;}
.person-card:hover{transform:translateY(-4px);box-shadow:0 20px 40px rgba(0,0,0,0.08);}
.avatar{width:88px;height:88px;border-radius:50%;margin:0 auto 14px;background-size:cover;background-position:center;background-color:#eee;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:#fff;border:3px solid rgba(255,255,255,0.8);box-shadow:0 6px 18px rgba(0,0,0,0.1);}
.person-name{font-size:16px;font-weight:700;color:#111;margin-bottom:4px;}
.person-name-ar{font-size:12px;color:rgba(0,0,0,0.5);margin-bottom:8px;}
.person-city{font-size:12px;color:rgba(0,0,0,0.55);margin-bottom:10px;}
.role-pill{display:inline-block;padding:4px 12px;border-radius:999px;font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;}
.role-artist{background:rgba(255,0,85,0.1);color:#ff0055;border:1px solid rgba(255,0,85,0.2);}
.role-collector{background:rgba(0,100,255,0.08);color:#0066ff;border:1px solid rgba(0,100,255,0.18);}
.empty{padding:44px;text-align:center;color:rgba(0,0,0,0.5);background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.07);border-radius:20px;backdrop-filter:blur(16px);}
@media(max-width:768px){.topnav{padding:10px 14px;}.nav-logo span{display:none;}}
</style>
</head>
<body>
<div class="bg-wrap"><video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video></div>
<div class="overlay"></div>

<!-- NAV (shared brand navbar) -->
<?php include __DIR__ . "/nav.php"; ?>

<div class="page">
  <div class="page-header">
    <div class="page-badge"><span class="pulse-dot"></span><span id="t-badge">Community</span></div>
    <h1 id="t-h1">The <em>People</em> of Oweili</h1>
    <p id="t-desc">Meet the approved artists and collectors who make up the Oweili community.</p>
  </div>

  <div class="filter-bar">
    <button class="filter-btn active" data-role="all" onclick="setRole('all',this)" id="t-f-all">All</button>
    <button class="filter-btn" data-role="artist" onclick="setRole('artist',this)" id="t-f-artist">Artists</button>
    <button class="filter-btn" data-role="collector" onclick="setRole('collector',this)" id="t-f-collector">Collectors</button>
  </div>

  <?php if (!$people): ?>
    <div class="empty" id="t-empty">No members to show yet.</div>
  <?php else: ?>
    <div class="people-grid" id="grid">
      <?php foreach ($people as $p):
        $nameEn = $p['artist_name'] ?: ($p['full_name_en'] ?: 'Member');
        $nameAr = $p['full_name_ar'] ?: '';
        $pic    = $p['profile_picture'] ?: '';
        $isArtist = $p['role'] === 'artist';
        // Deterministic accent color for letter avatars.
        $palette = ['#ff0055','#0066ff','#aa00ff','#00a050','#ff8c00'];
        $accent  = $palette[crc32($nameEn) % count($palette)];
      ?>
      <div class="person-card" data-role="<?= e($p['role']) ?>">
        <?php if ($pic): ?>
          <div class="avatar" style="background-image:url('<?= e($pic) ?>');"></div>
        <?php else: ?>
          <div class="avatar" style="background-color:<?= $accent ?>;"><?= e(initialOf($nameEn)) ?></div>
        <?php endif; ?>
        <div class="person-name"><?= e($nameEn) ?></div>
        <?php if ($nameAr): ?><div class="person-name-ar" dir="rtl"><?= e($nameAr) ?></div><?php endif; ?>
        <?php if ($p['city']): ?><div class="person-city">📍 <?= e($p['city']) ?></div><?php endif; ?>
        <span class="role-pill <?= $isArtist ? 'role-artist' : 'role-collector' ?>"
              data-en="<?= $isArtist ? 'Artist' : 'Collector' ?>"
              data-ar="<?= $isArtist ? 'فنان' : 'مقتني' ?>"><?= $isArtist ? 'Artist' : 'Collector' ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<script>
const T={
  en:{dir:'ltr',lb:'العربية',badge:'Community',h1:'The <em>People</em> of Oweili',
    desc:'Meet the approved artists and collectors who make up the Oweili community.',
    all:'All',artist:'Artists',collector:'Collectors',empty:'No members to show yet.',
    nav:{studio:'The Studio',community:'Community',marketplace:'Marketplace',explore:'Explore Art Styles',support:'Support',
      s1:'Watercolor Workshop',s2:'Oil Painting Studio',s3:'Digital Art Lab',s4:'Charcoal & Ink',
      c1:'Artist Chat Room',c2:'Meet Fellow Artists',c3:'Share Your Work',c4:'Learn Together',
      sp1:'Contact Us',sp2:'How It Works',sp3:'Terms of Use',chat:'Artist Chat',login:'Sign In',reg:'Join Free'}},
  ar:{dir:'rtl',lb:'English',badge:'المجتمع',h1:'<em>أعضاء</em> أويلي',
    desc:'تعرّف على الفنانين والمقتنين المعتمدين الذين يشكّلون مجتمع أويلي.',
    all:'الكل',artist:'الفنانون',collector:'المقتنون',empty:'لا يوجد أعضاء لعرضهم بعد.',
    nav:{studio:'الاستوديو',community:'المجتمع',marketplace:'السوق',explore:'استكشف أساليب الرسم',support:'الدعم',
      s1:'ورشة الألوان المائية',s2:'استوديو الرسم الزيتي',s3:'مختبر الفن الرقمي',s4:'الفحم والحبر',
      c1:'غرفة محادثة الفنانين',c2:'تعرّف على فنانين',c3:'شارك أعمالك',c4:'تعلّم معاً',
      sp1:'تواصل معنا',sp2:'كيف يعمل الموقع',sp3:'شروط الاستخدام',chat:'محادثة الفنانين',login:'تسجيل الدخول',reg:'انضم مجاناً'}}
};
let L='en';
let curRole='all';
function setHtml(id,v){const el=document.getElementById(id);if(el)el.innerHTML=v;}
function setTxt(id,v){const el=document.getElementById(id);if(el)el.textContent=v;}
function setRole(r,btn){
  curRole=r;
  document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
  if(btn)btn.classList.add('active');
  document.querySelectorAll('.person-card').forEach(c=>{
    c.style.display=(r==='all'||c.dataset.role===r)?'':'none';
  });
}
function apply(l){
  const t=T[l];
  document.getElementById('html').lang=l;
  document.getElementById('html').setAttribute('dir',t.dir);
  document.documentElement.setAttribute('dir',t.dir);
  document.getElementById('topnav').setAttribute('dir',t.dir);
  document.getElementById('lb').textContent=t.lb;
  setTxt('t-badge',t.badge);setHtml('t-h1',t.h1);setTxt('t-desc',t.desc);
  setTxt('t-f-all',t.all);setTxt('t-f-artist',t.artist);setTxt('t-f-collector',t.collector);
  setTxt('t-empty',t.empty);
  document.querySelectorAll('.role-pill').forEach(el=>{el.textContent=l==='ar'?el.dataset.ar:el.dataset.en;});
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
</script>
</body>
</html>
