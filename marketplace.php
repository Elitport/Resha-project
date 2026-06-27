<?php
// marketplace.php — Resha Art · Marketplace
// Production-ready, fully integrated bilingual dashboard with responsive toolbar.

$artworks = [
  ["id"=>1, "title_ar"=>"همسات الصحراء", "title_en"=>"Desert Whispers", "artist_ar"=>"ليلى إبراهيم", "artist_en"=>"Layla Ibrahim", "price"=>1200, "type"=>"abstract", "status"=>"available", "image_url"=>"https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=600&q=80"],
  ["id"=>2, "title_ar"=>"الهدوء الأزرق", "title_en"=>"Blue Serenity", "artist_ar"=>"عمر الراشد", "artist_en"=>"Omar Al-Rashid", "price"=>850, "type"=>"landscape", "status"=>"available", "image_url"=>"https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=600&q=80"]
];

$lang = isset($_GET['lang']) && $_GET['lang'] === 'ar' ? 'ar' : 'en';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resha Art Marketplace</title>
  <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
    body, html { width:100%; min-height:100vh; background:#fff; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif; overflow-x:hidden; }
    .bg-wrap { position: fixed; inset: 0; z-index: 0; overflow:hidden; }
    .bg-video { position:absolute; inset:0; width: 100%; height: 100%; object-fit: cover; }
    
    /* ── TOP NAV (shared brand navbar) ── */
    .topnav{position:fixed;top:0;left:0;right:0;z-index:1000;display:flex;align-items:center;justify-content:space-between;padding:0 16px;height:56px;background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid rgba(0,0,0,0.05);}
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

    .main-content { position: relative; z-index: 10; width:100%; max-width: 1200px; margin: 0 auto; padding: 100px 24px 48px; }

    /* PAGE HEADER */
    .page-header{margin-bottom:28px;}
    .page-header h1{font-size:clamp(26px,4vw,42px);font-weight:300;color:#111111;letter-spacing:-0.02em;margin-bottom:10px;}
    .page-header h1 em{font-style:normal;font-weight:700;background:linear-gradient(90deg,#ff0055,#0066ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .page-header p{font-size:14px;color:rgba(0,0,0,0.6);line-height:1.8;max-width:560px;}
    [dir="rtl"] .page-header p{text-align:right;}

    /* FILTER BAR */
    .filter-bar{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:28px;}
    [dir="rtl"] .filter-bar{flex-direction:row-reverse;}
    .filter-btn{padding:8px 20px;border-radius:999px;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.6);backdrop-filter:blur(8px);color:rgba(0,0,0,0.7);transition:all 0.22s;}
    .filter-btn:hover{background:rgba(255,255,255,0.9);color:#111111;}
    .filter-btn.active{background:#111111;color:#fff;border-color:#111111;}

    /* ART GRID */
    .art-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }

    /* GLASS CARD */
    .card { background: rgba(255,255,255,0.6); border:1px solid rgba(0,0,0,0.07); border-radius: 20px; overflow: hidden; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); transition: transform 0.3s ease, box-shadow 0.3s ease; display:flex; flex-direction:column; }
    .card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
    .card-img-wrap { position:relative; height: 200px; overflow:hidden; }
    .card-img { width:100%; height:100%; object-fit:cover; transition: transform 0.5s ease; }
    .card:hover .card-img { transform: scale(1.05); }
    .status-badge { position:absolute; top:12px; left:12px; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; backdrop-filter:blur(8px); }
    [dir="rtl"] .status-badge { left:auto; right:12px; }
    .status-available { background:rgba(0,180,100,0.15); color:#00a050; border:1px solid rgba(0,180,100,0.3); }
    .status-sold { background:rgba(255,0,85,0.12); color:#ff0055; border:1px solid rgba(255,0,85,0.25); }
    .card-body { padding:18px; display:flex; flex-direction:column; gap:4px; flex:1; }
    [dir="rtl"] .card-body { text-align:right; }
    .card-title { font-size:16px; font-weight:700; color:#111111; }
    .card-title-ar { font-size:13px; font-weight:600; color:rgba(0,0,0,0.55); }
    .card-artist { font-size:12px; color:rgba(0,0,0,0.6); margin-top:6px; }
    .card-artist-ar { font-size:11px; color:rgba(0,0,0,0.45); }
    .card-price { font-size:18px; font-weight:700; color:#0066ff; margin-top:10px; }
    .card-btn { margin-top:14px; display:inline-block; text-align:center; padding:10px 18px; border-radius:999px; background:#111111; color:#fff; font-size:11px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; text-decoration:none; border:none; cursor:pointer; transition:all 0.25s ease; }
    .card-btn:hover { background:#ff0055; transform:translateY(-2px); }
    .card.hidden { display:none; }

    @media(max-width:768px){ .main-content{padding:90px 16px 32px;} }
  </style>
</head>
<body>

<div class="bg-wrap">
  <video class="bg-video" autoplay loop muted playsinline src="bg.mp4"></video>
</div>

<?php $ar = $lang === 'ar'; ?>
<nav class="topnav">
  <a class="nav-logo" href="index.html">
    <svg width="18" height="18" viewBox="0 0 256 256" fill="currentColor"><path d="M4.688 136C68.373 136 120 187.627 120 251.312C120 252.883 119.967 254.445 119.905 256L0 256L0 136.096C1.555 136.034 3.117 136 4.688 136ZM251.312 136C252.883 136 254.445 136.034 256 136.096L256 256L136.095 256C136.032 254.438 136.001 252.875 136 251.312C136 187.627 187.627 136 251.312 136ZM119.905 0C119.967 1.555 120 3.117 120 4.688C120 68.373 68.373 120 4.687 120C3.117 120 1.555 119.967 0 119.905L0 0ZM256 119.905C254.445 119.967 252.883 120 251.312 120C187.627 120 136 68.373 136 4.687C136 3.117 136.033 1.555 136.095 0L256 0Z"/></svg>
    <span>RESHA ART</span>
  </a>
  <div class="nav-center">
    <div class="nav-item">
      <a href="studio.php"><span><?= $ar?'الاستوديو':'The Studio' ?></span><svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg></a>
      <div class="dropdown">
        <a href="studio.php#watercolor"><svg class="d-icon" viewBox="0 0 24 24"><path d="M12 2C8 2 4 6 4 10c0 5.25 8 12 8 12s8-6.75 8-12c0-4-4-8-8-8z"/></svg><span><?= $ar?'ورشة الألوان المائية':'Watercolor Workshop' ?></span></a>
        <a href="studio.php#oil"><svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg><span><?= $ar?'استوديو الرسم الزيتي':'Oil Painting Studio' ?></span></a>
        <a href="studio.php#digital"><svg class="d-icon" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg><span><?= $ar?'مختبر الفن الرقمي':'Digital Art Lab' ?></span></a>
        <a href="studio.php#charcoal"><svg class="d-icon" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg><span><?= $ar?'الفحم والحبر':'Charcoal & Ink' ?></span></a>
      </div>
    </div>
    <div class="nav-item">
      <a href="community.php"><span><?= $ar?'المجتمع':'Community' ?></span><svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg></a>
      <div class="dropdown">
        <a href="chat.php"><svg class="d-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span><?= $ar?'غرفة محادثة الفنانين':'Artist Chat Room' ?></span></a>
        <a href="community.php#meet"><svg class="d-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span><?= $ar?'تعرّف على فنانين':'Meet Fellow Artists' ?></span></a>
        <a href="community.php#share"><svg class="d-icon" viewBox="0 0 24 24"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg><span><?= $ar?'شارك أعمالك':'Share Your Work' ?></span></a>
        <a href="community.php#learn"><svg class="d-icon" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg><span><?= $ar?'تعلّم معاً':'Learn Together' ?></span></a>
      </div>
    </div>
    <div class="nav-item"><a href="marketplace.php?lang=<?= $lang ?>"><span><?= $ar?'السوق':'Marketplace' ?></span></a></div>
    <div class="nav-item"><a href="explore.php"><span><?= $ar?'استكشف أساليب الرسم':'Explore Art Styles' ?></span></a></div>
    <div class="nav-item">
      <a href="support.php"><span><?= $ar?'الدعم':'Support' ?></span><svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg></a>
      <div class="dropdown">
        <a href="mailto:contact@reshaart.com"><svg class="d-icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span><?= $ar?'تواصل معنا':'Contact Us' ?></span></a>
        <a href="support.php#how"><svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg><span><?= $ar?'كيف يعمل الموقع':'How It Works' ?></span></a>
        <a href="support.php#terms"><svg class="d-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span><?= $ar?'شروط الاستخدام':'Terms of Use' ?></span></a>
      </div>
    </div>
  </div>
  <div class="nav-right">
    <a class="nav-btn primary" href="chat.php"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg><span><?= $ar?'محادثة الفنانين':'Artist Chat' ?></span></a>
    <a class="nav-btn" href="login.php"><span><?= $ar?'تسجيل الدخول':'Sign In' ?></span></a>
    <a class="nav-btn" href="register.php"><span><?= $ar?'انضم مجاناً':'Join Free' ?></span></a>
    <button class="lang-btn" onclick="window.location.href='?lang=<?= $ar?'en':'ar' ?>'"><?= $ar?'English':'العربية' ?></button>
  </div>
</nav>

<main class="main-content">

  <div class="page-header">
    <h1><?= $ar ? 'فن <em>السوق</em>' : 'The <em>Marketplace</em>' ?></h1>
    <p><?= $ar
        ? 'اكتشف واقتنِ أعمالاً فنية أصلية من فنانين سعوديين موهوبين. كل قطعة فريدة من نوعها.'
        : 'Discover and collect original artworks from talented Saudi artists. Every piece is one of a kind.' ?></p>
  </div>

  <div class="filter-bar">
    <button class="filter-btn active" data-filter="all" onclick="filterCards('all', this)"><?= $ar?'الكل':'All' ?></button>
    <button class="filter-btn" data-filter="abstract" onclick="filterCards('abstract', this)"><?= $ar?'تجريدي':'Abstract' ?></button>
    <button class="filter-btn" data-filter="landscape" onclick="filterCards('landscape', this)"><?= $ar?'طبيعي':'Landscape' ?></button>
  </div>

  <div class="art-grid">
    <?php foreach ($artworks as $aw): ?>
      <div class="card" data-type="<?= htmlspecialchars($aw['type']) ?>">
        <div class="card-img-wrap">
          <img class="card-img" src="<?= htmlspecialchars($aw['image_url']) ?>" alt="<?= htmlspecialchars($ar ? $aw['title_ar'] : $aw['title_en']) ?>">
          <?php $sold = $aw['status'] === 'sold'; ?>
          <span class="status-badge <?= $sold ? 'status-sold' : 'status-available' ?>">
            <?= $sold ? ($ar?'مُباع':'Sold') : ($ar?'متاح':'Available') ?>
          </span>
        </div>
        <div class="card-body">
          <div class="card-title"><?= htmlspecialchars($aw['title_en']) ?></div>
          <div class="card-title-ar"><?= htmlspecialchars($aw['title_ar']) ?></div>
          <div class="card-artist"><?= $ar?'بواسطة':'by' ?> <?= htmlspecialchars($aw['artist_en']) ?></div>
          <div class="card-artist-ar"><?= htmlspecialchars($aw['artist_ar']) ?></div>
          <div class="card-price"><?= number_format($aw['price']) ?> <?= $ar?'ر.س':'SAR' ?></div>
          <a class="card-btn" href="artwork.php?id=<?= (int)$aw['id'] ?>&lang=<?= $lang ?>"><?= $ar?'عرض التفاصيل':'View Details' ?></a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</main>

<script>
function filterCards(type, btn){
  document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.art-grid .card').forEach(card=>{
    const show = (type === 'all' || card.dataset.type === type);
    card.classList.toggle('hidden', !show);
  });
}
</script>

</body>
</html>