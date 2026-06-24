<?php
/**
 * artist_dashboard.php — Resha Art · لوحة تحكم الفنان
 * Production-ready single-file PHP dashboard.
 * Drop into Hostinger public_html — no build step required.
 */

// ── Language detection ─────────────────────────────────────────────────────
$lang = in_array($_GET['lang'] ?? '', ['en', 'ar']) ? $_GET['lang'] : 'ar';

// ── Artist profile (replace with DB query in production) ────────────────────
$A = [
  'name_ar'    => 'ليلى إبراهيم',
  'name_en'    => 'Layla Ibrahim',
  'title_ar'   => 'فنانة تشكيلية · الرياض',
  'title_en'   => 'Visual Artist · Riyadh',
  'initials'   => 'لي',
  'avatar'     => '',
  'bio_ar'     => 'فنانة سعودية متخصصة في الألوان المائية والفن الرقمي. أستلهم أعمالي من بيئة الجزيرة العربية وتراثها البصري الثري.',
  'bio_en'     => 'Saudi artist specializing in watercolor and digital art. My work draws inspiration from the Arabian Peninsula\'s landscape and rich visual heritage.',
  'instagram'  => '@layla.art',
  'twitter'    => '@laylaibrahim',
  'website'    => 'www.laylaart.com',
  'iban'       => 'SA03 8000 0000 6080 1016 7519',
  'bank_ar'    => 'بنك الراجحي',
  'bank_en'    => 'Al Rajhi Bank',
  'joined_ar'  => 'يناير ٢٠٢٤',
  'joined_en'  => 'January 2024',
];

// ── Artworks (replace with DB query in production) ─────────────────────────
$artworks = [
  [
    'id'        => 1,
    'title_ar'  => 'همسات الصحراء',   'title_en'  => 'Desert Whispers',
    'desc_ar'   => 'أكريليك على قماش. رحلة عبر الكثبان الذهبية في الربع الخالي.',
    'desc_en'   => 'Acrylic on canvas. A journey through the golden dunes of the Empty Quarter.',
    'type'      => 'abstract',
    'type_ar'   => 'تجريدي',           'type_en'   => 'Abstract',
    'status'    => 'available',
    'price'     => 1200,
    'image'     => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=600&q=80',
    'date_ar'   => '١٠ مايو ٢٠٢٦',   'date_en'   => 'May 10, 2026',
    'views'     => 243,  'likes' => 18,
  ],
  [
    'id'        => 2,
    'title_ar'  => 'الهدوء الأزرق',   'title_en'  => 'Blue Serenity',
    'desc_ar'   => 'ألوان مائية مستوحاة من مياه الخليج العربي عند الفجر.',
    'desc_en'   => 'Watercolors inspired by the Arabian Gulf at dawn.',
    'type'      => 'landscape',
    'type_ar'   => 'مناظر طبيعية',    'type_en'   => 'Landscape',
    'status'    => 'sold',
    'price'     => 850,
    'image'     => 'https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=600&q=80',
    'date_ar'   => '٢٢ أبريل ٢٠٢٦',  'date_en'   => 'Apr 22, 2026',
    'views'     => 581,  'likes' => 42,
  ],
  [
    'id'        => 3,
    'title_ar'  => 'البورتريه الصامت','title_en'  => 'Silent Portrait',
    'desc_ar'   => 'زيت على الكتان. دراسة في الضوء والظل في الوجه العربي المعاصر.',
    'desc_en'   => 'Oil on linen. A study of light and shadow in the modern Arab face.',
    'type'      => 'portrait',
    'type_ar'   => 'بورتريه',          'type_en'   => 'Portrait',
    'status'    => 'auction',
    'price'     => 2400,
    'image'     => 'https://images.unsplash.com/photo-1578301978069-55e07489cfe1?w=600&q=80',
    'date_ar'   => '١ يونيو ٢٠٢٦',   'date_en'   => 'Jun 1, 2026',
    'views'     => 1124, 'likes' => 97,
  ],
  [
    'id'        => 4,
    'title_ar'  => 'المدينة النيونية', 'title_en'  => 'Neon Medina',
    'desc_ar'   => 'فن رقمي يدمج الزخارف العربية التقليدية مع جماليات السايبربانك.',
    'desc_en'   => 'Digital art fusing traditional Arabesque patterns with cyberpunk aesthetics.',
    'type'      => 'digital',
    'type_ar'   => 'فن رقمي',          'type_en'   => 'Digital Art',
    'status'    => 'available',
    'price'     => 600,
    'image'     => 'https://images.unsplash.com/photo-1637858868799-7f26a0640eb6?w=600&q=80',
    'date_ar'   => '١٥ يونيو ٢٠٢٦',  'date_en'   => 'Jun 15, 2026',
    'views'     => 388,  'likes' => 29,
  ],
  [
    'id'        => 5,
    'title_ar'  => 'ساعة الذهب',      'title_en'  => 'Golden Hour',
    'desc_ar'   => 'لوحة زيتية تجسّد دفء أشعة الغروب في ربوع الأردن.',
    'desc_en'   => 'An oil painting capturing the warm sunset rays across the hills of Jordan.',
    'type'      => 'landscape',
    'type_ar'   => 'مناظر طبيعية',    'type_en'   => 'Landscape',
    'status'    => 'available',
    'price'     => 1750,
    'image'     => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&q=80',
    'date_ar'   => '٨ يونيو ٢٠٢٦',   'date_en'   => 'Jun 8, 2026',
    'views'     => 204,  'likes' => 15,
  ],
  [
    'id'        => 6,
    'title_ar'  => 'العقل المتشظي',   'title_en'  => 'Fractured Mind',
    'desc_ar'   => 'وسائط مختلطة على لوح خشبي تستكشف الهوية والازدواجية.',
    'desc_en'   => 'Mixed media on wood panel exploring identity and duality.',
    'type'      => 'abstract',
    'type_ar'   => 'تجريدي',           'type_en'   => 'Abstract',
    'status'    => 'available',
    'price'     => 980,
    'image'     => 'https://images.unsplash.com/photo-1541512416146-3cf58d6b27cc?w=600&q=80',
    'date_ar'   => '٢٠ مايو ٢٠٢٦',   'date_en'   => 'May 20, 2026',
    'views'     => 167,  'likes' => 11,
  ],
];

// ── Orders (replace with DB query in production) ───────────────────────────
$orders = [
  [
    'id'         => 'ORD-2841',
    'art_ar'     => 'الهدوء الأزرق',   'art_en'    => 'Blue Serenity',
    'buyer_ar'   => 'محمد الفارس',      'buyer_en'  => 'Mohammed Al-Faris',
    'addr_ar'    => 'الرياض، حي النرجس، شارع الأمير محمد، عمارة ٤، شقة ٢١',
    'addr_en'    => 'Riyadh, Al-Narjis District, Prince Mohammed St., Bldg 4, Apt 21',
    'country_ar' => '🇸🇦 المملكة العربية السعودية',
    'country_en' => '🇸🇦 Saudi Arabia',
    'amount'     => 850,
    'status'     => 'delivered',
    'date_ar'    => '١٨ مايو ٢٠٢٦',   'date_en'   => 'May 18, 2026',
    'tracking'   => 'ARAMEX-44821733',
    'carrier'    => 'Aramex',
  ],
  [
    'id'         => 'ORD-2909',
    'art_ar'     => 'ساعة الذهب',      'art_en'    => 'Golden Hour',
    'buyer_ar'   => 'سارة الزيد',       'buyer_en'  => 'Sara Al-Zaid',
    'addr_ar'    => 'دبي، مرسى دبي، برج الأندلس ٢، الطابق ١٥',
    'addr_en'    => 'Dubai Marina, Al-Andalus Tower 2, Floor 15, UAE',
    'country_ar' => '🇦🇪 الإمارات العربية المتحدة',
    'country_en' => '🇦🇪 United Arab Emirates',
    'amount'     => 1750,
    'status'     => 'in_transit',
    'date_ar'    => '٩ يونيو ٢٠٢٦',   'date_en'   => 'Jun 9, 2026',
    'tracking'   => 'DHL-892044551',
    'carrier'    => 'DHL',
  ],
  [
    'id'         => 'ORD-2977',
    'art_ar'     => 'العقل المتشظي',   'art_en'    => 'Fractured Mind',
    'buyer_ar'   => 'عبدالله النصر',   'buyer_en'  => 'Abdullah Al-Nasr',
    'addr_ar'    => 'الدمام، حي الشاطئ، مجمع الواجهة البحرية، فيلا ٧',
    'addr_en'    => 'Dammam, Al-Shati District, Waterfront Complex, Villa 7, KSA',
    'country_ar' => '🇸🇦 المملكة العربية السعودية',
    'country_en' => '🇸🇦 Saudi Arabia',
    'amount'     => 980,
    'status'     => 'processing',
    'date_ar'    => '٢١ يونيو ٢٠٢٦',  'date_en'   => 'Jun 21, 2026',
    'tracking'   => '',
    'carrier'    => '',
  ],
];

// ── Wallet transactions ────────────────────────────────────────────────────
$txns = [
  ['ref'=>'TXN-9901','art_ar'=>'الهدوء الأزرق',    'art_en'=>'Blue Serenity',  'gross'=>850, 'fee'=>170,'net'=>680,'status'=>'cleared','date_ar'=>'٢٠ مايو ٢٠٢٦','date_en'=>'May 20, 2026'],
  ['ref'=>'TXN-9874','art_ar'=>'ساعة الذهب',        'art_en'=>'Golden Hour',    'gross'=>1750,'fee'=>350,'net'=>1400,'status'=>'escrow', 'date_ar'=>'١٢ يونيو ٢٠٢٦','date_en'=>'Jun 12, 2026'],
  ['ref'=>'TXN-9851','art_ar'=>'العقل المتشظي',     'art_en'=>'Fractured Mind', 'gross'=>980, 'fee'=>196,'net'=>784, 'status'=>'escrow', 'date_ar'=>'٢٢ يونيو ٢٠٢٦','date_en'=>'Jun 22, 2026'],
];
$cleared = array_sum(array_column(array_filter($txns, fn($t)=>$t['status']==='cleared'),'net'));
$escrow  = array_sum(array_column(array_filter($txns, fn($t)=>$t['status']==='escrow'), 'net'));

// ── Computed stats ─────────────────────────────────────────────────────────
$active_count  = count(array_filter($artworks, fn($a)=>in_array($a['status'],['available','auction'])));
$sold_count    = count(array_filter($artworks, fn($a)=>$a['status']==='sold'));
$auction_count = count(array_filter($artworks, fn($a)=>$a['status']==='auction'));
$total_sales   = array_sum(array_column(array_values(array_filter($artworks, fn($a)=>$a['status']==='sold')),'price'));
$total_views   = array_sum(array_column($artworks,'views'));
$total_likes   = array_sum(array_column($artworks,'likes'));

// ── Safe HTML escape ───────────────────────────────────────────────────────
function xss(string $v): string {
  return htmlspecialchars($v, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang==='ar'?'rtl':'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $lang==='ar' ? 'لوحة تحكم الفنان — ريشة فن' : 'Artist Dashboard — Resha Art' ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
/* ═══════════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════════ */
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html,body{width:100%;min-height:100vh;overflow-x:hidden;
  font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;
  -webkit-font-smoothing:antialiased}

/* ═══════════════════════════════════════════════
   VIDEO BACKGROUND — exact index.html spec
═══════════════════════════════════════════════ */
.bg-wrap{position:fixed;inset:0;z-index:0;overflow:hidden;background:#f5f4f2}
.bg-video{position:absolute;inset:0;width:100%;height:100%;
  object-fit:cover;opacity:0;transition:opacity 2s ease;z-index:2}
.bg-video.on{opacity:0.88}
.overlay{position:fixed;inset:0;z-index:3;pointer-events:none;
  background:linear-gradient(160deg,rgba(255,255,255,.26) 0%,rgba(255,255,255,0) 50%,rgba(255,255,255,.38) 100%)}
.overlay2{position:fixed;inset:0;z-index:3;pointer-events:none;
  background:radial-gradient(ellipse at 20% 50%,rgba(0,100,255,.05) 0%,transparent 60%)}

/* ═══════════════════════════════════════════════
   TOP NAV — exact index.html spec
═══════════════════════════════════════════════ */
.topnav{
  position:fixed;top:0;inset-inline:0;z-index:400;
  display:flex;align-items:center;justify-content:space-between;
  height:56px;padding:0 24px;
  background:rgba(255,255,255,.62);
  backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);
  border-bottom:1px solid rgba(0,0,0,.06);
}
[dir=rtl] .topnav,[dir=rtl] .nav-right{flex-direction:row-reverse}

.nav-logo{display:flex;align-items:center;gap:8px;
  text-decoration:none;color:#111;flex-shrink:0}
.nav-logo svg{color:#ff0055}
.nav-logo-text{font-size:13px;font-weight:700;letter-spacing:.14em;text-transform:uppercase}
.nav-right{display:flex;align-items:center;gap:8px;flex-shrink:0}

.nbtn{
  padding:6px 14px;border-radius:999px;font-size:11px;font-weight:600;
  letter-spacing:.05em;text-transform:uppercase;cursor:pointer;
  text-decoration:none;display:inline-flex;align-items:center;gap:5px;
  transition:all .22s;border:1px solid rgba(0,0,0,.1);
  background:rgba(0,0,0,.04);color:rgba(0,0,0,.78)
}
.nbtn:hover{background:rgba(0,0,0,.08);color:#000}
.nbtn.blue{background:rgba(0,100,255,.1);border-color:rgba(0,100,255,.2);color:#0066ff}
.nbtn.blue:hover{background:rgba(0,100,255,.18)}
.lang-btn{
  padding:5px 11px;border-radius:999px;font-size:10px;font-weight:600;
  letter-spacing:.06em;cursor:pointer;border:1px solid rgba(0,0,0,.1);
  background:rgba(255,255,255,.7);color:rgba(0,0,0,.7);
  backdrop-filter:blur(8px);transition:all .22s
}
.lang-btn:hover{background:#111;color:#fff}
.nav-user{display:flex;align-items:center;gap:8px}
.nav-av{
  width:30px;height:30px;border-radius:50%;overflow:hidden;flex-shrink:0;
  background:linear-gradient(135deg,#ff0055,#aa00ff);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:11px;font-weight:700;
  border:2px solid rgba(255,255,255,.85)
}
.nav-av img{width:100%;height:100%;object-fit:cover;border-radius:50%}
.nav-uname{font-size:12px;font-weight:600;color:#111;
  max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}

/* ═══════════════════════════════════════════════
   LAYOUT SHELL
═══════════════════════════════════════════════ */
.shell{position:relative;z-index:10;display:flex;min-height:100vh;padding-top:56px}

/* ═══════════════════════════════════════════════
   SIDEBAR — rgba(255,255,255,0.68)
═══════════════════════════════════════════════ */
.sidebar{
  position:fixed;top:56px;bottom:0;
  width:228px;flex-shrink:0;
  background:rgba(255,255,255,.68);
  backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);
  display:flex;flex-direction:column;
  overflow-y:auto;z-index:300;
  transition:transform .3s cubic-bezier(.4,0,.2,1)
}
[dir=ltr] .sidebar{left:0;border-right:1px solid rgba(0,0,0,.06)}
[dir=rtl] .sidebar{right:0;border-left:1px solid rgba(0,0,0,.06)}

.sb-inner{padding:16px 10px;flex:1;display:flex;flex-direction:column;gap:2px}
.sb-section{
  font-size:9px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:rgba(0,0,0,.32);padding:4px 12px;margin:10px 0 4px
}
.slink{
  display:flex;align-items:center;gap:10px;
  padding:9px 12px;border-radius:12px;
  font-size:12px;font-weight:500;color:rgba(0,0,0,.62);
  cursor:pointer;transition:all .18s;border:1px solid transparent;
  user-select:none;text-decoration:none
}
[dir=rtl] .slink{flex-direction:row-reverse}
.slink:hover{background:rgba(0,0,0,.05);color:#111}
.slink.active{
  background:rgba(255,255,255,.95);color:#111;
  border-color:rgba(0,0,0,.07);
  box-shadow:0 2px 10px rgba(0,0,0,.07)
}
.slink.active .sl-ico{color:#ff0055;opacity:1}
.sl-ico{width:16px;height:16px;flex-shrink:0;opacity:.6}
.sl-lbl{flex:1;white-space:nowrap}
.sl-badge{
  font-size:9px;font-weight:700;padding:2px 7px;
  border-radius:999px;background:rgba(255,0,85,.08);
  color:#ff0055;border:1px solid rgba(255,0,85,.14)
}
.sb-foot{padding:12px 10px;border-top:1px solid rgba(0,0,0,.06)}
.sb-acard{
  background:rgba(255,255,255,.82);border-radius:14px;
  padding:14px;border:1px solid rgba(0,0,0,.06)
}
.sb-ava{
  width:38px;height:38px;border-radius:50%;overflow:hidden;
  background:linear-gradient(135deg,#ff0055,#aa00ff);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:13px;font-weight:700;margin-bottom:8px
}
.sb-ava img{width:100%;height:100%;object-fit:cover;border-radius:50%}

/* mobile */
.sb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.22);z-index:299;backdrop-filter:blur(2px)}
.sb-overlay.open{display:block}
.sb-toggle{
  display:none;position:fixed;bottom:22px;z-index:500;
  width:46px;height:46px;border-radius:50%;
  background:#111;color:#fff;border:none;cursor:pointer;
  font-size:18px;align-items:center;justify-content:center;
  box-shadow:0 8px 24px rgba(0,0,0,.22)
}
[dir=ltr] .sb-toggle{right:22px}
[dir=rtl] .sb-toggle{left:22px}

@media(max-width:768px){
  .sidebar{transform:translateX(-110%)}
  [dir=rtl] .sidebar{transform:translateX(110%)}
  .sidebar.open{transform:translateX(0)}
  [dir=rtl] .sidebar.open{transform:translateX(0)}
  .sb-toggle{display:flex}
}

/* ═══════════════════════════════════════════════
   MAIN CONTENT AREA
═══════════════════════════════════════════════ */
.main{flex:1;min-width:0;padding:28px 30px 72px}
[dir=ltr] .main{margin-left:228px}
[dir=rtl] .main{margin-right:228px}
@media(max-width:768px){.main{margin:0!important;padding:20px 16px 80px}}

/* ═══════════════════════════════════════════════
   TAB SECTIONS
═══════════════════════════════════════════════ */
.tab-sec{display:none;animation:fadeIn .3s ease both}
.tab-sec.active{display:block}
@keyframes fadeIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

/* ═══════════════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════════════ */
.pg-head{
  display:flex;align-items:flex-start;justify-content:space-between;
  margin-bottom:26px;gap:16px;flex-wrap:wrap
}
.pg-title{font-size:21px;font-weight:700;color:#111;letter-spacing:-.02em}
.pg-sub{font-size:12px;color:rgba(0,0,0,.42);margin-top:3px}
.date-chip{
  font-size:11px;color:rgba(0,0,0,.4);
  background:rgba(255,255,255,.72);backdrop-filter:blur(8px);
  padding:5px 13px;border-radius:999px;
  border:1px solid rgba(0,0,0,.07);white-space:nowrap;flex-shrink:0
}

/* ═══════════════════════════════════════════════
   GLASS CARD — rgba(255,255,255,0.76)
═══════════════════════════════════════════════ */
.gc{
  background:rgba(255,255,255,.76);
  backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);
  border:1px solid rgba(255,255,255,.92);
  border-radius:18px;
  box-shadow:0 4px 22px rgba(0,0,0,.07)
}

/* ═══════════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════════ */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
@media(max-width:1080px){.stats-row{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px) {.stats-row{grid-template-columns:1fr}}
.scard{padding:20px 22px}
.scard-icon{font-size:24px;margin-bottom:12px}
.scard-lbl{
  font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:rgba(0,0,0,.4);margin-bottom:6px
}
.scard-val{font-size:28px;font-weight:800;color:#111;letter-spacing:-.02em;line-height:1}
.scard-sub{font-size:11px;color:rgba(0,0,0,.38);margin-top:6px}

/* progress bar accent */
.scard-bar{height:3px;border-radius:999px;margin-top:14px;background:rgba(0,0,0,.07);overflow:hidden}
.scard-fill{height:100%;border-radius:999px;transition:width .8s cubic-bezier(.4,0,.2,1)}

/* ═══════════════════════════════════════════════
   SECTION HEADER
═══════════════════════════════════════════════ */
.sec-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;gap:10px;flex-wrap:wrap}
.sec-title{font-size:14px;font-weight:700;color:#111}
.sec-badge{font-size:10px;font-weight:600;padding:3px 10px;border-radius:999px;background:rgba(0,0,0,.05);color:rgba(0,0,0,.5)}

/* ═══════════════════════════════════════════════
   DATA TABLE
═══════════════════════════════════════════════ */
.dt{width:100%;border-collapse:collapse}
.dt th{
  font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  color:rgba(0,0,0,.38);padding:8px 14px;text-align:start;
  border-bottom:1px solid rgba(0,0,0,.07)
}
.dt td{
  padding:11px 14px;border-bottom:1px solid rgba(0,0,0,.04);
  font-size:12px;color:rgba(0,0,0,.68);vertical-align:middle
}
.dt tr:last-child td{border-bottom:none}
.dt tr:hover td{background:rgba(0,0,0,.016)}
.dt-thumb{width:38px;height:38px;border-radius:9px;object-fit:cover;display:block;background:#f0f0f0}
.dt-art-cell{display:flex;align-items:center;gap:10px}

/* ═══════════════════════════════════════════════
   STATUS PILLS
═══════════════════════════════════════════════ */
.pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 10px;border-radius:999px;
  font-size:9px;font-weight:700;letter-spacing:.07em;text-transform:uppercase
}
.pill-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
.p-available{background:rgba(0,200,83,.1);color:#009624;border:1px solid rgba(0,200,83,.2)}
.p-sold      {background:rgba(0,100,255,.1);color:#0055ff;border:1px solid rgba(0,100,255,.2)}
.p-auction   {background:rgba(255,0,85,.1);color:#ff0055;border:1px solid rgba(255,0,85,.2)}
.p-processing{background:rgba(255,160,0,.1);color:#b36f00;border:1px solid rgba(255,160,0,.2)}
.p-in_transit{background:rgba(0,100,255,.1);color:#0055ff;border:1px solid rgba(0,100,255,.2)}
.p-delivered {background:rgba(0,200,83,.1);color:#009624;border:1px solid rgba(0,200,83,.2)}
.p-cleared   {background:rgba(0,200,83,.1);color:#009624;border:1px solid rgba(0,200,83,.2)}
.p-escrow    {background:rgba(255,160,0,.1);color:#b36f00;border:1px solid rgba(255,160,0,.2)}

/* ═══════════════════════════════════════════════
   ACTIVITY FEED
═══════════════════════════════════════════════ */
.act-item{display:flex;align-items:flex-start;gap:12px;padding:11px 0;border-bottom:1px solid rgba(0,0,0,.05)}
[dir=rtl] .act-item{flex-direction:row-reverse}
.act-item:last-child{border-bottom:none}
.act-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:3px}
.act-txt{font-size:12px;color:rgba(0,0,0,.62);line-height:1.6;flex:1}
.act-time{font-size:10px;color:rgba(0,0,0,.32);white-space:nowrap;flex-shrink:0}

/* ═══════════════════════════════════════════════
   PORTFOLIO GRID
═══════════════════════════════════════════════ */
.p-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
@media(max-width:960px){.p-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:500px){.p-grid{grid-template-columns:1fr}}
.pcard{border-radius:16px;overflow:hidden;cursor:pointer;transition:transform .26s,box-shadow .26s}
.pcard:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(0,0,0,.13)}
.pcard-img{aspect-ratio:4/3;width:100%;object-fit:cover;display:block;background:#f0f0f0}
.pcard-body{padding:13px 15px 15px}
.pcard-title{font-size:13px;font-weight:700;color:#111;margin-bottom:5px;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.pcard-meta{display:flex;align-items:center;justify-content:space-between;gap:6px}
.pcard-price{font-size:15px;font-weight:800;color:#111;letter-spacing:-.02em}
.pcard-eng{font-size:10px;color:rgba(0,0,0,.38)}
.pcard-actions{display:flex;gap:6px;margin-top:10px;flex-wrap:wrap}

/* ═══════════════════════════════════════════════
   CHIP FILTER ROW
═══════════════════════════════════════════════ */
.chip-row{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:20px}
.chip{
  padding:5px 15px;border-radius:999px;font-size:10px;font-weight:600;
  letter-spacing:.05em;cursor:pointer;transition:all .2s;
  border:1px solid rgba(0,0,0,.1);
  background:rgba(255,255,255,.7);color:rgba(0,0,0,.62);
  backdrop-filter:blur(6px)
}
.chip:hover{background:rgba(255,255,255,.95);color:#111}
.chip.active{background:#111;color:#fff;border-color:#111}

/* ═══════════════════════════════════════════════
   BUTTONS
═══════════════════════════════════════════════ */
.btn{
  padding:8px 18px;border-radius:999px;font-size:10px;font-weight:700;
  letter-spacing:.06em;text-transform:uppercase;border:none;
  cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:6px
}
.btn-primary{
  background:#111;color:#fff;
  box-shadow:0 6px 18px rgba(0,0,0,.12)
}
.btn-primary:hover{background:#333;transform:translateY(-1px)}
.btn-primary:disabled{opacity:.5;cursor:not-allowed;transform:none}
.btn-blue{background:rgba(0,100,255,.1);color:#0055ff;border:1px solid rgba(0,100,255,.18)}
.btn-blue:hover{background:rgba(0,100,255,.18)}
.btn-outline{background:transparent;color:#111;border:1px solid rgba(0,0,0,.14)}
.btn-outline:hover{background:rgba(0,0,0,.05)}
.btn-danger{background:rgba(255,0,85,.07);color:#ff0055;border:1px solid rgba(255,0,85,.15)}
.btn-danger:hover{background:rgba(255,0,85,.15)}
.btn-sm{padding:5px 13px;font-size:9px}
.btn-lg{padding:11px 26px;font-size:11px;box-shadow:0 8px 20px rgba(0,0,0,.12)}

/* ═══════════════════════════════════════════════
   FORMS
═══════════════════════════════════════════════ */
.fg{display:flex;flex-direction:column;gap:6px}
.fg-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:640px){.fg-2{grid-template-columns:1fr}}
.fg-full{grid-column:1/-1}
.f-label{
  font-size:10px;font-weight:700;letter-spacing:.07em;
  text-transform:uppercase;color:rgba(0,0,0,.52)
}
.f-req{color:#ff0055;margin-inline-start:2px}
.f-input,.f-select,.f-textarea{
  padding:10px 14px;border-radius:12px;
  border:1px solid rgba(0,0,0,.1);
  background:rgba(255,255,255,.92);color:#111;
  font-size:13px;font-family:inherit;outline:none;width:100%;
  transition:border-color .2s,box-shadow .2s
}
.f-input:focus,.f-select:focus,.f-textarea:focus{
  border-color:rgba(0,100,255,.35);
  box-shadow:0 0 0 3px rgba(0,100,255,.07)
}
.f-textarea{resize:vertical;min-height:88px}
.f-select{cursor:pointer}
.f-hint{font-size:10px;color:rgba(0,0,0,.38);margin-top:2px}

/* upload zone */
.upload-zone{
  border:2px dashed rgba(0,0,0,.12);border-radius:14px;
  background:rgba(255,255,255,.6);
  padding:30px 20px;text-align:center;cursor:pointer;transition:all .2s
}
.upload-zone:hover,.upload-zone.drag{
  border-color:rgba(0,100,255,.4);
  background:rgba(0,100,255,.03)
}
#img-preview{
  max-height:160px;max-width:100%;border-radius:10px;
  object-fit:cover;display:none;margin:14px auto 0;display:none
}

/* spinner */
.spinner{
  width:14px;height:14px;border-radius:50%;
  border:2px solid rgba(255,255,255,.3);border-top-color:#fff;
  animation:spin .7s linear infinite;display:none
}
@keyframes spin{to{transform:rotate(360deg)}}

/* ═══════════════════════════════════════════════
   ORDER CARDS
═══════════════════════════════════════════════ */
.ocard{padding:20px 22px;border-radius:18px;margin-bottom:14px}
.ocard-head{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-bottom:14px}
[dir=rtl] .ocard-head{flex-direction:row-reverse}
.ocard-id{font-size:13px;font-weight:700;color:#111}
.ocard-body{display:grid;grid-template-columns:1fr 1fr;gap:12px}
@media(max-width:560px){.ocard-body{grid-template-columns:1fr}}
.of{font-size:11px}
.of-lbl{font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(0,0,0,.35);margin-bottom:3px}
.of-val{font-size:12px;font-weight:500;color:#111;line-height:1.5}
.ocard-track{
  display:flex;align-items:center;gap:10px;flex-wrap:wrap;
  margin-top:14px;padding-top:14px;border-top:1px solid rgba(0,0,0,.06)
}
[dir=rtl] .ocard-track{flex-direction:row-reverse}
.track-code{
  font-size:11px;font-weight:600;font-family:monospace;
  background:rgba(0,0,0,.05);padding:4px 10px;border-radius:8px;color:#111
}

/* ═══════════════════════════════════════════════
   WALLET
═══════════════════════════════════════════════ */
.wal-row{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px}
@media(max-width:640px){.wal-row{grid-template-columns:1fr}}
.wc{padding:22px 24px;border-radius:18px}
.wc-lbl{font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(0,0,0,.38);margin-bottom:8px}
.wc-amt{font-size:28px;font-weight:800;color:#111;letter-spacing:-.02em;line-height:1}
.wc-sub{font-size:11px;color:rgba(0,0,0,.38);margin-top:5px}
.wc-escrow .wc-amt{color:#b36f00}

.tx-row{display:flex;align-items:center;justify-content:space-between;padding:13px 0;border-bottom:1px solid rgba(0,0,0,.05)}
[dir=rtl] .tx-row{flex-direction:row-reverse}
.tx-row:last-child{border-bottom:none}
.tx-art{font-size:12px;font-weight:600;color:#111}
.tx-ref{font-size:10px;font-family:monospace;color:rgba(0,0,0,.38)}
.tx-r{text-align:end}
[dir=rtl] .tx-r{text-align:start}
.tx-net{font-size:14px;font-weight:700}
.tx-net.cleared{color:#009624}
.tx-net.escrow{color:#b36f00}
.tx-fee-lbl{font-size:10px;color:rgba(0,0,0,.38)}

.iban-block{
  background:linear-gradient(135deg,rgba(17,17,17,.04),rgba(0,100,255,.04));
  border-radius:14px;padding:18px 20px;
  border:1px solid rgba(0,0,0,.08);margin-bottom:14px
}
.iban-num{font-size:15px;font-family:monospace;font-weight:700;color:#111;letter-spacing:.06em;word-break:break-all;margin-top:6px}
.iban-bank{font-size:11px;color:rgba(0,0,0,.42);margin-top:3px}

/* ═══════════════════════════════════════════════
   PROFILE
═══════════════════════════════════════════════ */
.pro-av-row{display:flex;align-items:center;gap:20px;flex-wrap:wrap;margin-bottom:20px}
[dir=rtl] .pro-av-row{flex-direction:row-reverse}
.pro-av-big{
  width:78px;height:78px;border-radius:50%;overflow:hidden;flex-shrink:0;
  background:linear-gradient(135deg,#ff0055,#aa00ff);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:24px;font-weight:700;
  border:3px solid rgba(255,255,255,.85);
  box-shadow:0 4px 18px rgba(0,0,0,.12)
}
.pro-av-big img{width:100%;height:100%;object-fit:cover;border-radius:50%}
.pro-av-meta .p-name{font-size:17px;font-weight:700;color:#111}
.pro-av-meta .p-title{font-size:12px;color:rgba(0,0,0,.45);margin-top:3px}
.pro-av-meta .p-since{font-size:11px;color:rgba(0,0,0,.32);margin-top:2px}

.social-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
@media(max-width:600px){.social-grid{grid-template-columns:1fr}}
.social-item{
  display:flex;align-items:center;gap:10px;
  padding:12px 14px;border-radius:13px;
  background:rgba(255,255,255,.6);border:1px solid rgba(0,0,0,.07)
}
[dir=rtl] .social-item{flex-direction:row-reverse}
.social-ico{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}

/* ═══════════════════════════════════════════════
   TOAST
═══════════════════════════════════════════════ */
.toast{
  position:fixed;bottom:26px;left:50%;
  transform:translateX(-50%) translateY(16px);
  background:#111;color:#fff;padding:11px 22px;border-radius:999px;
  font-size:12px;font-weight:600;z-index:9999;
  opacity:0;transition:all .32s;pointer-events:none;white-space:nowrap;
  box-shadow:0 8px 24px rgba(0,0,0,.22)
}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

/* ═══════════════════════════════════════════════
   DIVIDER / MISC
═══════════════════════════════════════════════ */
hr.div{border:none;border-top:1px solid rgba(0,0,0,.07);margin:24px 0}
.two-col{display:grid;grid-template-columns:1.4fr 1fr;gap:18px}
@media(max-width:860px){.two-col{grid-template-columns:1fr}}
@media(max-width:500px){.nav-uname,.date-chip{display:none}}
</style>
</head>
<body>

<!-- ══ BACKGROUND ════════════════════════════════════════════════════════════ -->
<div class="bg-wrap">
  <video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video>
</div>
<div class="overlay"></div>
<div class="overlay2"></div>

<!-- ══ TOP NAV ═══════════════════════════════════════════════════════════════ -->
<nav class="topnav">
  <a class="nav-logo" href="index.html">
    <svg width="18" height="18" viewBox="0 0 256 256" fill="currentColor">
      <path d="M4.688 136C68.373 136 120 187.627 120 251.312C120 252.883 119.967 254.445 119.905 256L0 256L0 136.096C1.555 136.034 3.117 136 4.688 136ZM251.312 136C252.883 136 254.445 136.034 256 136.096L256 256L136.095 256C136.032 254.438 136.001 252.875 136 251.312C136 187.627 187.627 136 251.312 136ZM119.905 0C119.967 1.555 120 3.117 120 4.688C120 68.373 68.373 120 4.687 120C3.117 120 1.555 119.967 0 119.905L0 0ZM256 119.905C254.445 119.967 252.883 120 251.312 120C187.627 120 136 68.373 136 4.687C136 3.117 136.033 1.555 136.095 0L256 0Z"/>
    </svg>
    <span class="nav-logo-text">RESHA ART</span>
  </a>

  <div class="nav-right">
    <a class="nbtn" href="marketplace.php"><span data-t="nav-market"></span></a>
    <a class="nbtn blue" href="marketplace.php"><span data-t="nav-list"></span></a>
    <button class="lang-btn" id="lb" onclick="tgl()"></button>
    <div class="nav-user">
      <div class="nav-av" id="nav-av"><?= xss($A['initials']) ?></div>
      <span class="nav-uname" id="nav-uname"></span>
    </div>
  </div>
</nav>

<!-- ══ SHELL ══════════════════════════════════════════════════════════════════ -->
<div class="shell">

  <!-- ─── SIDEBAR ───────────────────────────────────────────────────────── -->
  <aside class="sidebar" id="sidebar">
    <div class="sb-inner">

      <div class="sb-section" data-t="sb-sec-main"></div>

      <div class="slink active" data-tab="dashboard" onclick="switchTab('dashboard',this)">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <rect x="3" y="3" width="7" height="7" rx="1.5"/>
          <rect x="14" y="3" width="7" height="7" rx="1.5"/>
          <rect x="3" y="14" width="7" height="7" rx="1.5"/>
          <rect x="14" y="14" width="7" height="7" rx="1.5"/>
        </svg>
        <span class="sl-lbl" data-t="sb-dashboard"></span>
      </div>

      <div class="slink" data-tab="portfolio" onclick="switchTab('portfolio',this)">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <rect x="3" y="3" width="18" height="18" rx="2"/>
          <path d="M3 9h18M9 21V9"/>
        </svg>
        <span class="sl-lbl" data-t="sb-portfolio"></span>
        <span class="sl-badge"><?= count($artworks) ?></span>
      </div>

      <div class="slink" data-tab="orders" onclick="switchTab('orders',this)">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
          <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
        </svg>
        <span class="sl-lbl" data-t="sb-orders"></span>
        <span class="sl-badge"><?= count($orders) ?></span>
      </div>

      <div class="slink" data-tab="wallet" onclick="switchTab('wallet',this)">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h14v4"/>
          <path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/>
          <path d="M18 12a2 2 0 0 0 0 4h4v-4z"/>
        </svg>
        <span class="sl-lbl" data-t="sb-wallet"></span>
      </div>

      <div class="slink" data-tab="profile" onclick="switchTab('profile',this)">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <span class="sl-lbl" data-t="sb-profile"></span>
      </div>

      <div class="sb-section" data-t="sb-sec-tools"></div>

      <div class="slink" onclick="window.location.href='marketplace.php'">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        <span class="sl-lbl" data-t="sb-market"></span>
      </div>

      <div class="slink" onclick="showToast(L==='ar'?'قريباً — التحليلات قيد التطوير':'Coming soon — Analytics in development')">
        <svg class="sl-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M18 20V10M12 20V4M6 20v-6"/>
        </svg>
        <span class="sl-lbl" data-t="sb-analytics"></span>
      </div>

    </div>

    <!-- sidebar artist card -->
    <div class="sb-foot">
      <div class="sb-acard">
        <div class="sb-ava" id="sb-av"><?= xss($A['initials']) ?></div>
        <div style="font-size:12px;font-weight:700;color:#111;margin-bottom:2px" id="sb-name"></div>
        <div style="font-size:10px;color:rgba(0,0,0,.42)" id="sb-ttl"></div>
      </div>
    </div>
  </aside>

  <!-- sidebar overlay -->
  <div class="sb-overlay" id="sb-ov" onclick="closeSidebar()"></div>

  <!-- ─── MAIN ───────────────────────────────────────────────────────────── -->
  <main class="main">

    <!-- ████████████████████████████████████████
         TAB 1 — DASHBOARD
    ████████████████████████████████████████ -->
    <section class="tab-sec active" id="tab-dashboard">

      <div class="pg-head">
        <div>
          <div class="pg-title" data-t="dash-title"></div>
          <div class="pg-sub" id="dash-sub"></div>
        </div>
        <span class="date-chip"><?= xss(date('l, F j, Y')) ?></span>
      </div>

      <!-- Stat cards -->
      <div class="stats-row">

        <div class="scard gc">
          <div class="scard-icon">🖼️</div>
          <div class="scard-lbl" data-t="sc-active-lbl"></div>
          <div class="scard-val"><?= $active_count ?></div>
          <div class="scard-sub" data-t="sc-active-sub"></div>
          <div class="scard-bar"><div class="scard-fill" style="width:<?= min(100, $active_count*20) ?>%;background:linear-gradient(90deg,#ff0055,#aa00ff)"></div></div>
        </div>

        <div class="scard gc">
          <div class="scard-icon">💰</div>
          <div class="scard-lbl" data-t="sc-sales-lbl"></div>
          <div class="scard-val">$<?= number_format($total_sales) ?></div>
          <div class="scard-sub" id="sc-sold-sub"></div>
          <div class="scard-bar"><div class="scard-fill" style="width:<?= min(100,$sold_count*25) ?>%;background:linear-gradient(90deg,#00c853,#0055ff)"></div></div>
        </div>

        <div class="scard gc">
          <div class="scard-icon">🔨</div>
          <div class="scard-lbl" data-t="sc-auction-lbl"></div>
          <div class="scard-val"><?= $auction_count ?></div>
          <div class="scard-sub" data-t="sc-auction-sub"></div>
          <div class="scard-bar"><div class="scard-fill" style="width:<?= min(100,$auction_count*33) ?>%;background:linear-gradient(90deg,#ff0055,#ff6600)"></div></div>
        </div>

        <div class="scard gc">
          <div class="scard-icon">👁️</div>
          <div class="scard-lbl" data-t="sc-views-lbl"></div>
          <div class="scard-val"><?= number_format($total_views) ?></div>
          <div class="scard-sub" data-t="sc-views-sub"></div>
          <div class="scard-bar"><div class="scard-fill" style="width:<?= min(100, intval($total_views/30)) ?>%;background:linear-gradient(90deg,#0066ff,#aa00ff)"></div></div>
        </div>

      </div>

      <!-- Two-column: table + activity -->
      <div class="two-col">

        <!-- Best-performing artworks table -->
        <div class="gc" style="padding:18px 20px;overflow-x:auto">
          <div class="sec-hd">
            <div class="sec-title" data-t="dash-top-title"></div>
            <span class="sec-badge" data-t="dash-top-badge"></span>
          </div>
          <table class="dt">
            <thead>
              <tr>
                <th data-t="th-artwork"></th>
                <th data-t="th-type"></th>
                <th data-t="th-price"></th>
                <th data-t="th-status"></th>
                <th data-t="th-views"></th>
                <th data-t="th-likes"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($artworks as $aw): ?>
              <tr>
                <td>
                  <div class="dt-art-cell">
                    <img class="dt-thumb" src="<?= xss($aw['image']) ?>" alt=""
                      onerror="this.src='https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=100&q=60'">
                    <span class="bili-title" data-ar="<?= xss($aw['title_ar']) ?>" data-en="<?= xss($aw['title_en']) ?>"
                      style="font-weight:600;color:#111"><?= xss($aw['title_ar']) ?></span>
                  </div>
                </td>
                <td><span class="bili-type" data-ar="<?= xss($aw['type_ar']) ?>" data-en="<?= xss($aw['type_en']) ?>"><?= xss($aw['type_ar']) ?></span></td>
                <td style="font-weight:700">$<?= number_format($aw['price']) ?></td>
                <td>
                  <span class="pill p-<?= xss($aw['status']) ?>">
                    <span class="pill-dot" style="background:<?= $aw['status']==='sold'?'#0055ff':($aw['status']==='auction'?'#ff0055':'#00c853') ?>"></span>
                    <span class="s-cell" data-s="<?= xss($aw['status']) ?>"></span>
                  </span>
                </td>
                <td><?= number_format($aw['views']) ?></td>
                <td><?= $aw['likes'] ?> ♥</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Activity feed -->
        <div class="gc" style="padding:18px 20px">
          <div class="sec-hd">
            <div class="sec-title" data-t="dash-act-title"></div>
            <span class="sec-badge" data-t="dash-act-badge"></span>
          </div>
          <div id="act-feed"></div>
        </div>

      </div>
    </section>


    <!-- ████████████████████████████████████████
         TAB 2 — MY PORTFOLIO
    ████████████████████████████████████████ -->
    <section class="tab-sec" id="tab-portfolio">

      <div class="pg-head">
        <div>
          <div class="pg-title" data-t="port-title"></div>
          <div class="pg-sub" data-t="port-sub"></div>
        </div>
        <button class="btn btn-primary btn-lg" onclick="scrollTo(0,document.getElementById('upload-anchor').offsetTop-80)">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          <span data-t="port-add"></span>
        </button>
      </div>

      <!-- Filter chips -->
      <div class="chip-row">
        <button class="chip active" data-pf="all"       onclick="portFilter('all',this)"><span data-t="f-all"></span></button>
        <button class="chip"        data-pf="available" onclick="portFilter('available',this)"><span data-t="f-available"></span></button>
        <button class="chip"        data-pf="auction"   onclick="portFilter('auction',this)"><span data-t="f-auction"></span></button>
        <button class="chip"        data-pf="sold"      onclick="portFilter('sold',this)"><span data-t="f-sold"></span></button>
      </div>

      <!-- Portfolio grid -->
      <div class="p-grid" id="port-grid">
        <?php foreach ($artworks as $aw):
          $dcls = $aw['status']==='sold'?'#0055ff':($aw['status']==='auction'?'#ff0055':'#00c853');
        ?>
        <div class="pcard gc" data-pf-s="<?= xss($aw['status']) ?>">
          <img class="pcard-img" src="<?= xss($aw['image']) ?>" alt=""
            onerror="this.src='https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=600&q=80'">
          <div class="pcard-body">
            <span class="pill p-<?= xss($aw['status']) ?>" style="margin-bottom:8px">
              <span class="pill-dot" style="background:<?= $dcls ?>"></span>
              <span class="s-cell" data-s="<?= xss($aw['status']) ?>"></span>
            </span>
            <div class="pcard-title bili-title" data-ar="<?= xss($aw['title_ar']) ?>" data-en="<?= xss($aw['title_en']) ?>"><?= xss($aw['title_ar']) ?></div>
            <div class="pcard-meta">
              <span class="pcard-price">$<?= number_format($aw['price']) ?></span>
              <span class="pcard-eng">👁 <?= number_format($aw['views']) ?> &nbsp;♥ <?= $aw['likes'] ?></span>
            </div>
            <div class="pcard-actions">
              <button class="btn btn-outline btn-sm" data-t="port-edit" onclick="showToast(L==='ar'?'⚙️ تعديل العمل — قريباً':'⚙️ Edit artwork — coming soon')"></button>
              <button class="btn btn-blue btn-sm" data-t="port-preview" onclick="window.open('marketplace.php','_blank')"></button>
              <button class="btn btn-danger btn-sm" data-t="port-delete" onclick="deletePcard(this)"></button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <hr class="div" id="upload-anchor">

      <!-- ── Upload Form ─────────────────────── -->
      <div class="gc" style="padding:28px 30px">
        <div class="sec-hd" style="margin-bottom:22px">
          <div>
            <div class="sec-title" data-t="up-title"></div>
            <div style="font-size:12px;color:rgba(0,0,0,.42);margin-top:3px" data-t="up-sub"></div>
          </div>
        </div>

        <form id="up-form" onsubmit="submitUpload(event)" novalidate>
          <div class="fg-2">

            <div class="fg">
              <label class="f-label" data-t="up-tit-ar"></label>
              <input class="f-input" id="u-tit-ar" type="text" required>
            </div>
            <div class="fg">
              <label class="f-label" data-t="up-tit-en"></label>
              <input class="f-input" id="u-tit-en" type="text" required>
            </div>

            <div class="fg">
              <label class="f-label" data-t="up-price"></label>
              <input class="f-input" id="u-price" type="number" min="1" required>
            </div>
            <div class="fg">
              <label class="f-label" data-t="up-type"></label>
              <select class="f-select" id="u-type">
                <option value="abstract"  data-t="f-abstract"></option>
                <option value="portrait"  data-t="f-portrait"></option>
                <option value="landscape" data-t="f-landscape"></option>
                <option value="digital"   data-t="f-digital"></option>
              </select>
            </div>

            <div class="fg">
              <label class="f-label" data-t="up-status"></label>
              <select class="f-select" id="u-status">
                <option value="available" data-t="f-available"></option>
                <option value="auction"   data-t="f-auction"></option>
              </select>
            </div>
            <div class="fg">
              <label class="f-label" data-t="up-medium"></label>
              <input class="f-input" id="u-medium" type="text">
            </div>

            <div class="fg fg-full">
              <label class="f-label" data-t="up-desc"></label>
              <textarea class="f-textarea" id="u-desc"></textarea>
            </div>

            <div class="fg fg-full">
              <label class="f-label" data-t="up-img"></label>
              <div class="upload-zone" id="up-zone"
                   onclick="document.getElementById('u-file').click()"
                   ondragover="ev.preventDefault();this.classList.add('drag')"
                   ondragleave="this.classList.remove('drag')"
                   ondrop="handleDrop(event)">
                <div style="font-size:32px;margin-bottom:10px">🖼️</div>
                <div style="font-size:13px;font-weight:600;color:#111;margin-bottom:4px" data-t="up-drop"></div>
                <div style="font-size:11px;color:rgba(0,0,0,.38)" data-t="up-fmt"></div>
                <img id="img-preview" alt="preview">
              </div>
              <input type="file" id="u-file" accept="image/*" style="display:none" onchange="previewImg(this)">
            </div>

          </div>

          <div style="display:flex;justify-content:flex-end;margin-top:20px">
            <button type="submit" class="btn btn-primary btn-lg" id="up-btn">
              <div class="spinner" id="up-spin"></div>
              <span id="up-lbl" data-t="up-submit"></span>
            </button>
          </div>
        </form>
      </div>
    </section>


    <!-- ████████████████████████████████████████
         TAB 3 — ORDERS & SHIPPING
    ████████████████████████████████████████ -->
    <section class="tab-sec" id="tab-orders">

      <div class="pg-head">
        <div>
          <div class="pg-title" data-t="ord-title"></div>
          <div class="pg-sub" data-t="ord-sub"></div>
        </div>
      </div>

      <?php foreach ($orders as $o):
        $dotc = $o['status']==='delivered' ? '#00c853' : ($o['status']==='in_transit' ? '#0055ff' : '#b36f00');
      ?>
      <div class="ocard gc">
        <div class="ocard-head">
          <div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
              <span class="ocard-id"><?= xss($o['id']) ?></span>
              <span class="pill p-<?= xss($o['status']) ?>">
                <span class="pill-dot" style="background:<?= $dotc ?>"></span>
                <span class="s-cell" data-s="<?= xss($o['status']) ?>"></span>
              </span>
            </div>
            <div style="font-size:11px;color:rgba(0,0,0,.38);margin-top:4px">
              <span class="bili-date" data-ar="<?= xss($o['date_ar']) ?>" data-en="<?= xss($o['date_en']) ?>"><?= xss($o['date_ar']) ?></span>
            </div>
          </div>
          <div style="font-size:20px;font-weight:800;color:#111;letter-spacing:-.02em">$<?= number_format($o['amount']) ?></div>
        </div>

        <div class="ocard-body">
          <div class="of">
            <div class="of-lbl" data-t="ord-art"></div>
            <div class="of-val bili-art" data-ar="<?= xss($o['art_ar']) ?>" data-en="<?= xss($o['art_en']) ?>"><?= xss($o['art_ar']) ?></div>
          </div>
          <div class="of">
            <div class="of-lbl" data-t="ord-buyer"></div>
            <div class="of-val bili-buyer" data-ar="<?= xss($o['buyer_ar']) ?>" data-en="<?= xss($o['buyer_en']) ?>"><?= xss($o['buyer_ar']) ?></div>
          </div>
          <div class="of" style="grid-column:1/-1">
            <div class="of-lbl" data-t="ord-addr"></div>
            <div class="of-val bili-addr" data-ar="<?= xss($o['addr_ar']) ?>" data-en="<?= xss($o['addr_en']) ?>"><?= xss($o['addr_ar']) ?></div>
            <div style="font-size:11px;color:rgba(0,0,0,.4);margin-top:3px">
              <span class="bili-country" data-ar="<?= xss($o['country_ar']) ?>" data-en="<?= xss($o['country_en']) ?>"><?= xss($o['country_ar']) ?></span>
            </div>
          </div>
        </div>

        <?php if ($o['tracking']): ?>
        <div class="ocard-track">
          <span style="font-size:11px;font-weight:600;color:rgba(0,0,0,.4)" data-t="ord-track"></span>
          <span class="track-code"><?= xss($o['carrier']) ?> · <?= xss($o['tracking']) ?></span>
          <button class="btn btn-outline btn-sm" data-t="ord-copy"
            onclick="copyClip('<?= xss($o['tracking']) ?>',this)"></button>
          <button class="btn btn-blue btn-sm" data-t="ord-track-btn"
            onclick="showToast(L==='ar'?'🔍 تتبع الشحنة — قريباً':'🔍 Shipment tracking — coming soon')"></button>
        </div>
        <?php else: ?>
        <div style="margin-top:14px;padding-top:14px;border-top:1px solid rgba(0,0,0,.06);font-size:11px;color:rgba(0,0,0,.38)" data-t="ord-no-track"></div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>

    </section>


    <!-- ████████████████████████████████████████
         TAB 4 — WALLET & EARNINGS
    ████████████████████████████████████████ -->
    <section class="tab-sec" id="tab-wallet">

      <div class="pg-head">
        <div>
          <div class="pg-title" data-t="wal-title"></div>
          <div class="pg-sub" data-t="wal-sub"></div>
        </div>
        <button class="btn btn-primary btn-lg"
          onclick="showToast(L==='ar'?'🏦 طلب تحويل — قريباً':'🏦 Transfer request — coming soon')">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19V5M5 12l7-7 7 7"/>
          </svg>
          <span data-t="wal-withdraw"></span>
        </button>
      </div>

      <!-- Balance cards -->
      <div class="wal-row">
        <div class="wc gc">
          <div class="wc-lbl" data-t="wc-cleared-lbl"></div>
          <div class="wc-amt">$<?= number_format($cleared) ?></div>
          <div class="wc-sub" data-t="wc-cleared-sub"></div>
        </div>
        <div class="wc gc wc-escrow">
          <div class="wc-lbl" data-t="wc-escrow-lbl"></div>
          <div class="wc-amt">$<?= number_format($escrow) ?></div>
          <div class="wc-sub" data-t="wc-escrow-sub"></div>
        </div>
        <div class="wc gc">
          <div class="wc-lbl" data-t="wc-total-lbl"></div>
          <div class="wc-amt">$<?= number_format($cleared + $escrow) ?></div>
          <div class="wc-sub" data-t="wc-total-sub"></div>
        </div>
      </div>

      <!-- Transaction ledger -->
      <div class="gc" style="padding:20px 22px;margin-bottom:18px">
        <div class="sec-hd">
          <div class="sec-title" data-t="wal-ledger-title"></div>
          <span class="sec-badge"><?= count($txns) ?> <span data-t="wal-tx-unit"></span></span>
        </div>

        <?php foreach ($txns as $tx):
          $netCls = $tx['status']==='cleared' ? 'cleared' : 'escrow';
        ?>
        <div class="tx-row">
          <div>
            <div class="tx-art bili-tx-art" data-ar="<?= xss($tx['art_ar']) ?>" data-en="<?= xss($tx['art_en']) ?>"><?= xss($tx['art_ar']) ?></div>
            <div class="tx-ref"><?= xss($tx['ref']) ?> · <span class="bili-tx-date" data-ar="<?= xss($tx['date_ar']) ?>" data-en="<?= xss($tx['date_en']) ?>"><?= xss($tx['date_ar']) ?></span></div>
          </div>
          <div class="tx-r">
            <div class="tx-net <?= $netCls ?>">+$<?= number_format($tx['net']) ?></div>
            <div class="tx-fee-lbl"><span data-t="wal-fee"></span>: $<?= number_format($tx['fee']) ?></div>
            <span class="pill p-<?= xss($tx['status']) ?>" style="margin-top:4px">
              <span class="pill-dot" style="background:<?= $tx['status']==='cleared'?'#00c853':'#b36f00' ?>"></span>
              <span class="s-cell" data-s="<?= xss($tx['status']) ?>"></span>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- IBAN / bank details -->
      <div class="gc" style="padding:20px 22px">
        <div class="sec-hd" style="margin-bottom:14px">
          <div class="sec-title" data-t="wal-bank-title"></div>
        </div>
        <div class="iban-block">
          <div style="font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(0,0,0,.38)" data-t="wal-iban-lbl"></div>
          <div class="iban-num"><?= xss($A['iban']) ?></div>
          <div class="iban-bank bili-bank" data-ar="<?= xss($A['bank_ar']) ?>" data-en="<?= xss($A['bank_en']) ?>"><?= xss($A['bank_ar']) ?></div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          <button class="btn btn-primary" data-t="wal-copy-iban"
            onclick="copyClip('<?= xss($A['iban']) ?>',this)"></button>
          <button class="btn btn-outline" data-t="wal-edit-bank"
            onclick="switchTabByName('profile')"></button>
        </div>
      </div>

    </section>


    <!-- ████████████████████████████████████████
         TAB 5 — PROFILE & BIO SETTINGS
    ████████████████████████████████████████ -->
    <section class="tab-sec" id="tab-profile">

      <div class="pg-head">
        <div>
          <div class="pg-title" data-t="pro-title"></div>
          <div class="pg-sub" data-t="pro-sub"></div>
        </div>
        <button class="btn btn-primary btn-lg" onclick="saveProfile()">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          <span data-t="pro-save"></span>
        </button>
      </div>

      <!-- Avatar section -->
      <div class="gc" style="padding:24px 26px;margin-bottom:18px">
        <div class="pro-av-row">
          <div class="pro-av-big" id="pro-av"><?= xss($A['initials']) ?></div>
          <div class="pro-av-meta">
            <div class="p-name" id="pro-nm"></div>
            <div class="p-title" id="pro-ttl"></div>
            <div class="p-since">
              <span data-t="pro-since"></span>
              <span id="pro-since-val"></span>
            </div>
            <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap">
              <button class="btn btn-primary" data-t="pro-change-av"
                onclick="document.getElementById('av-file').click()"></button>
              <button class="btn btn-outline" data-t="pro-remove-av"
                onclick="removeAvatar()"></button>
              <input type="file" id="av-file" accept="image/*" style="display:none"
                onchange="previewAvatar(this)">
            </div>
          </div>
        </div>
      </div>

      <!-- Personal info form -->
      <div class="gc" style="padding:24px 26px;margin-bottom:18px">
        <div class="sec-title" style="margin-bottom:20px" data-t="pro-sec-info"></div>
        <div class="fg-2">
          <div class="fg">
            <label class="f-label" data-t="pro-f-name-ar"></label>
            <input class="f-input" id="p-nm-ar" type="text" value="<?= xss($A['name_ar']) ?>">
          </div>
          <div class="fg">
            <label class="f-label" data-t="pro-f-name-en"></label>
            <input class="f-input" id="p-nm-en" type="text" value="<?= xss($A['name_en']) ?>">
          </div>
          <div class="fg">
            <label class="f-label" data-t="pro-f-ttl-ar"></label>
            <input class="f-input" id="p-ttl-ar" type="text" value="<?= xss($A['title_ar']) ?>">
          </div>
          <div class="fg">
            <label class="f-label" data-t="pro-f-ttl-en"></label>
            <input class="f-input" id="p-ttl-en" type="text" value="<?= xss($A['title_en']) ?>">
          </div>
          <div class="fg fg-full">
            <label class="f-label" data-t="pro-f-bio-ar"></label>
            <textarea class="f-textarea" id="p-bio-ar"><?= xss($A['bio_ar']) ?></textarea>
          </div>
          <div class="fg fg-full">
            <label class="f-label" data-t="pro-f-bio-en"></label>
            <textarea class="f-textarea" id="p-bio-en"><?= xss($A['bio_en']) ?></textarea>
          </div>
        </div>
      </div>

      <!-- Social media links -->
      <div class="gc" style="padding:24px 26px;margin-bottom:18px">
        <div class="sec-title" style="margin-bottom:20px" data-t="pro-sec-social"></div>
        <div class="social-grid">
          <div class="social-item">
            <div class="social-ico" style="background:#fce4ec">📸</div>
            <div style="flex:1">
              <div class="f-label" style="margin-bottom:6px">Instagram</div>
              <input class="f-input" id="p-ig" type="text" value="<?= xss($A['instagram']) ?>"
                style="padding:7px 11px;font-size:12px">
            </div>
          </div>
          <div class="social-item">
            <div class="social-ico" style="background:#e3f2fd">𝕏</div>
            <div style="flex:1">
              <div class="f-label" style="margin-bottom:6px">X / Twitter</div>
              <input class="f-input" id="p-tw" type="text" value="<?= xss($A['twitter']) ?>"
                style="padding:7px 11px;font-size:12px">
            </div>
          </div>
          <div class="social-item">
            <div class="social-ico" style="background:#e8f5e9">🌐</div>
            <div style="flex:1">
              <div class="f-label" style="margin-bottom:6px" data-t="pro-f-web"></div>
              <input class="f-input" id="p-web" type="text" value="<?= xss($A['website']) ?>"
                style="padding:7px 11px;font-size:12px">
            </div>
          </div>
        </div>
      </div>

      <!-- Bank / IBAN -->
      <div class="gc" style="padding:24px 26px">
        <div class="sec-title" style="margin-bottom:20px" data-t="pro-sec-bank"></div>
        <div class="fg-2">
          <div class="fg">
            <label class="f-label" data-t="pro-f-bank"></label>
            <input class="f-input" id="p-bank" type="text"
              value="<?= xss($lang==='ar' ? $A['bank_ar'] : $A['bank_en']) ?>">
          </div>
          <div class="fg">
            <label class="f-label" data-t="pro-f-iban"></label>
            <input class="f-input" id="p-iban" type="text" value="<?= xss($A['iban']) ?>"
              style="font-family:monospace;letter-spacing:.04em">
            <span class="f-hint" data-t="pro-f-iban-hint"></span>
          </div>
        </div>
      </div>

    </section>

  </main>
</div><!-- /shell -->

<!-- mobile sidebar toggle -->
<button class="sb-toggle" id="sb-toggle" onclick="openSidebar()">☰</button>

<!-- toast -->
<div class="toast" id="toast"></div>


<!-- ══════════════════════════════════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════════════════════════════════ -->
<script>
// ── PHP → JS data bridge ─────────────────────────────────────────────────
const ARTIST = <?= json_encode([
  'name_ar'   => $A['name_ar'],
  'name_en'   => $A['name_en'],
  'title_ar'  => $A['title_ar'],
  'title_en'  => $A['title_en'],
  'joined_ar' => $A['joined_ar'],
  'joined_en' => $A['joined_en'],
], JSON_UNESCAPED_UNICODE) ?>;

// ── Translations ─────────────────────────────────────────────────────────
const T = {
  ar: {
    dir:'rtl', lb:'English',
    // nav
    'nav-market':'السوق', 'nav-list':'إضافة عمل',
    // sidebar
    'sb-sec-main':'القائمة الرئيسية', 'sb-sec-tools':'أدوات',
    'sb-dashboard':'لوحة التحكم', 'sb-portfolio':'أعمالي',
    'sb-orders':'الطلبات والشحن', 'sb-wallet':'المحفظة',
    'sb-profile':'الملف الشخصي', 'sb-market':'السوق',
    'sb-analytics':'التحليلات',
    // dashboard
    'dash-title':'لوحة التحكم',
    'dash-sub-pre':'مرحباً بعودتك،',
    'dash-top-title':'أعلى الأعمال أداءً',
    'dash-top-badge':'هذا الشهر',
    'dash-act-title':'النشاط الأخير',
    'dash-act-badge':'آخر 24 ساعة',
    // stat cards
    'sc-active-lbl':'قوائم نشطة',
    'sc-active-sub':'متاح للبيع + مزاد',
    'sc-sales-lbl':'إجمالي المبيعات',
    'sc-sold-unit':'عمل مباع',
    'sc-auction-lbl':'مزادات حية',
    'sc-auction-sub':'قيد المزايدة الآن',
    'sc-views-lbl':'إجمالي المشاهدات',
    'sc-views-sub':'عبر جميع الأعمال',
    // table headers
    'th-artwork':'العمل الفني', 'th-type':'النوع',
    'th-price':'السعر', 'th-status':'الحالة',
    'th-views':'مشاهدات', 'th-likes':'إعجابات',
    // status
    'st-available':'متاح', 'st-sold':'مُباع',
    'st-auction':'مزاد', 'st-processing':'قيد المعالجة',
    'st-in_transit':'في الطريق', 'st-delivered':'تم التسليم',
    'st-cleared':'محصّل', 'st-escrow':'محتجز',
    // activity
    'act-0':'مشاهد جديد للبورتريه الصامت',
    'act-1':'تم بيع عمل "الهدوء الأزرق" بنجاح',
    'act-2':'مزايدة جديدة على "البورتريه الصامت"',
    'act-3':'رسالة من مشتري حول "همسات الصحراء"',
    'act-4':'تم تمييز عملك في الصفحة الرئيسية',
    't-0':'منذ دقيقتين','t-1':'منذ ساعة',
    't-2':'منذ 3 ساعات','t-3':'منذ يوم','t-4':'منذ يومين',
    // portfolio
    'port-title':'أعمالي', 'port-sub':'أدر لوحاتك وإعدادات كل عمل فني',
    'port-add':'إضافة عمل جديد',
    'port-edit':'تعديل', 'port-preview':'معاينة', 'port-delete':'حذف',
    // filters
    'f-all':'الكل', 'f-available':'متاح',
    'f-auction':'مزاد', 'f-sold':'مُباع',
    'f-abstract':'تجريدي', 'f-portrait':'بورتريه',
    'f-landscape':'مناظر طبيعية', 'f-digital':'فن رقمي',
    // upload
    'up-title':'رفع عمل فني جديد',
    'up-sub':'أضف تفاصيل لوحتك لعرضها في السوق',
    'up-tit-ar':'اسم العمل (عربي) *',
    'up-tit-en':'اسم العمل (إنجليزي) *',
    'up-price':'السعر (USD) *',
    'up-type':'النوع الفني',
    'up-status':'حالة العرض',
    'up-medium':'الوسيط / المادة',
    'up-desc':'وصف العمل',
    'up-img':'صورة العمل',
    'up-drop':'اسحب الصورة هنا أو انقر للاختيار',
    'up-fmt':'PNG، JPG، WEBP — حد أقصى 12 ميغابايت',
    'up-submit':'رفع العمل الفني',
    // orders
    'ord-title':'الطلبات والشحن',
    'ord-sub':'تتبع طلبات المشترين وحالة التوصيل',
    'ord-art':'العمل الفني', 'ord-buyer':'المشتري',
    'ord-addr':'عنوان الشحن',
    'ord-track':'رقم التتبع', 'ord-copy':'نسخ',
    'ord-track-btn':'تتبع الشحنة',
    'ord-no-track':'لم يُحدَّد رقم تتبع بعد',
    // wallet
    'wal-title':'المحفظة والأرباح',
    'wal-sub':'تتبع أرباحك وأدر تحويلاتك البنكية',
    'wal-withdraw':'طلب تحويل',
    'wc-cleared-lbl':'أرباح محصّلة',
    'wc-cleared-sub':'جاهزة للسحب الفوري',
    'wc-escrow-lbl':'محتجز في الضمان',
    'wc-escrow-sub':'قيد التحقق (٧ أيام)',
    'wc-total-lbl':'الرصيد الكلي',
    'wc-total-sub':'محصّل + محتجز',
    'wal-ledger-title':'سجل المعاملات',
    'wal-tx-unit':'معاملة',
    'wal-fee':'رسوم المنصة',
    'wal-bank-title':'بيانات التحويل البنكي',
    'wal-iban-lbl':'رقم الآيبان (IBAN)',
    'wal-copy-iban':'نسخ الآيبان',
    'wal-edit-bank':'تعديل البيانات',
    // profile
    'pro-title':'الملف الشخصي',
    'pro-sub':'حدّث معلوماتك الشخصية والمهنية',
    'pro-save':'حفظ التغييرات',
    'pro-since':'عضو منذ',
    'pro-change-av':'تغيير الصورة',
    'pro-remove-av':'إزالة',
    'pro-sec-info':'المعلومات الشخصية',
    'pro-f-name-ar':'الاسم الكامل (عربي)',
    'pro-f-name-en':'الاسم الكامل (إنجليزي)',
    'pro-f-ttl-ar':'المسمى الوظيفي (عربي)',
    'pro-f-ttl-en':'المسمى الوظيفي (إنجليزي)',
    'pro-f-bio-ar':'نبذة تعريفية (عربي)',
    'pro-f-bio-en':'نبذة تعريفية (إنجليزي)',
    'pro-sec-social':'وسائل التواصل والموقع',
    'pro-f-web':'الموقع الإلكتروني',
    'pro-sec-bank':'بيانات الحساب البنكي',
    'pro-f-bank':'اسم البنك',
    'pro-f-iban':'رقم الآيبان',
    'pro-f-iban-hint':'استخدم الصيغة الدولية SA…',
    // toasts
    'toast-saved':'✅ تم حفظ الملف الشخصي بنجاح',
    'toast-uploaded':'✅ تم رفع العمل الفني بنجاح',
    'toast-deleted':'🗑️ تم حذف العمل',
    'toast-copied':'تم النسخ ✓',
    'toast-req-fields':'⚠️ يرجى ملء الحقول المطلوبة',
  },
  en: {
    dir:'ltr', lb:'العربية',
    // nav
    'nav-market':'Marketplace', 'nav-list':'List Artwork',
    // sidebar
    'sb-sec-main':'Main Menu', 'sb-sec-tools':'Tools',
    'sb-dashboard':'Dashboard', 'sb-portfolio':'My Portfolio',
    'sb-orders':'Orders & Shipping', 'sb-wallet':'Wallet',
    'sb-profile':'Profile Settings', 'sb-market':'Marketplace',
    'sb-analytics':'Analytics',
    // dashboard
    'dash-title':'Dashboard',
    'dash-sub-pre':'Welcome back,',
    'dash-top-title':'Top Performing Artworks',
    'dash-top-badge':'This Month',
    'dash-act-title':'Recent Activity',
    'dash-act-badge':'Last 24 hours',
    // stat cards
    'sc-active-lbl':'Active Listings',
    'sc-active-sub':'Available + Auction',
    'sc-sales-lbl':'Total Sales',
    'sc-sold-unit':'artwork sold',
    'sc-auction-lbl':'Live Auctions',
    'sc-auction-sub':'Currently bidding',
    'sc-views-lbl':'Total Views',
    'sc-views-sub':'Across all artworks',
    // table headers
    'th-artwork':'Artwork', 'th-type':'Type',
    'th-price':'Price', 'th-status':'Status',
    'th-views':'Views', 'th-likes':'Likes',
    // status
    'st-available':'Available', 'st-sold':'Sold',
    'st-auction':'Auction', 'st-processing':'Processing',
    'st-in_transit':'In Transit', 'st-delivered':'Delivered',
    'st-cleared':'Cleared', 'st-escrow':'Escrow',
    // activity
    'act-0':'New view on Silent Portrait',
    'act-1':'Blue Serenity sold successfully',
    'act-2':'New bid placed on Silent Portrait',
    'act-3':'Buyer message about Desert Whispers',
    'act-4':'Your artwork was featured on the homepage',
    't-0':'2 minutes ago','t-1':'1 hour ago',
    't-2':'3 hours ago','t-3':'1 day ago','t-4':'2 days ago',
    // portfolio
    'port-title':'My Portfolio', 'port-sub':'Manage your artworks and listing settings',
    'port-add':'Add New Artwork',
    'port-edit':'Edit', 'port-preview':'Preview', 'port-delete':'Delete',
    // filters
    'f-all':'All', 'f-available':'Available',
    'f-auction':'Auction', 'f-sold':'Sold',
    'f-abstract':'Abstract', 'f-portrait':'Portrait',
    'f-landscape':'Landscape', 'f-digital':'Digital',
    // upload
    'up-title':'Upload New Artwork',
    'up-sub':'Add your piece details to list it on the marketplace',
    'up-tit-ar':'Artwork Title (Arabic) *',
    'up-tit-en':'Artwork Title (English) *',
    'up-price':'Price (USD) *',
    'up-type':'Art Type',
    'up-status':'Listing Status',
    'up-medium':'Medium / Material',
    'up-desc':'Artwork Description',
    'up-img':'Artwork Image',
    'up-drop':'Drag image here or click to browse',
    'up-fmt':'PNG, JPG, WEBP — max 12 MB',
    'up-submit':'Upload Artwork',
    // orders
    'ord-title':'Orders & Shipping',
    'ord-sub':'Track buyer orders and shipment status',
    'ord-art':'Artwork', 'ord-buyer':'Buyer',
    'ord-addr':'Shipping Address',
    'ord-track':'Tracking Number', 'ord-copy':'Copy',
    'ord-track-btn':'Track Shipment',
    'ord-no-track':'Tracking number not assigned yet',
    // wallet
    'wal-title':'Wallet & Earnings',
    'wal-sub':'Track your earnings and manage bank transfers',
    'wal-withdraw':'Request Transfer',
    'wc-cleared-lbl':'Cleared Earnings',
    'wc-cleared-sub':'Ready to withdraw',
    'wc-escrow-lbl':'Held in Escrow',
    'wc-escrow-sub':'Under verification (7 days)',
    'wc-total-lbl':'Total Balance',
    'wc-total-sub':'Cleared + Escrow',
    'wal-ledger-title':'Transaction Ledger',
    'wal-tx-unit':'transactions',
    'wal-fee':'Platform fee',
    'wal-bank-title':'Bank Transfer Details',
    'wal-iban-lbl':'IBAN Number',
    'wal-copy-iban':'Copy IBAN',
    'wal-edit-bank':'Edit Details',
    // profile
    'pro-title':'Profile Settings',
    'pro-sub':'Update your personal and professional information',
    'pro-save':'Save Changes',
    'pro-since':'Member since',
    'pro-change-av':'Change Photo',
    'pro-remove-av':'Remove',
    'pro-sec-info':'Personal Information',
    'pro-f-name-ar':'Full Name (Arabic)',
    'pro-f-name-en':'Full Name (English)',
    'pro-f-ttl-ar':'Professional Title (Arabic)',
    'pro-f-ttl-en':'Professional Title (English)',
    'pro-f-bio-ar':'Artist Bio (Arabic)',
    'pro-f-bio-en':'Artist Bio (English)',
    'pro-sec-social':'Social Media & Portfolio',
    'pro-f-web':'Website',
    'pro-sec-bank':'Bank Account Information',
    'pro-f-bank':'Bank Name',
    'pro-f-iban':'IBAN Number',
    'pro-f-iban-hint':'Use international format SA…',
    // toasts
    'toast-saved':'✅ Profile saved successfully',
    'toast-uploaded':'✅ Artwork uploaded successfully',
    'toast-deleted':'🗑️ Artwork deleted',
    'toast-copied':'Copied ✓',
    'toast-req-fields':'⚠️ Please fill all required fields',
  }
};

// ── Language state ────────────────────────────────────────────────────────
let L = '<?= $lang ?>';

// ── XSS-safe DOM escape ───────────────────────────────────────────────────
function e(s) {
  return String(s ?? '')
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── apply(lang) — live DOM update ─────────────────────────────────────────
function apply(l) {
  const t = T[l];
  const isEn = l === 'en';

  // html root
  document.documentElement.setAttribute('dir', t.dir);
  document.documentElement.setAttribute('lang', l);

  // language toggle button
  document.getElementById('lb').textContent = t.lb;

  // all [data-t] text nodes
  document.querySelectorAll('[data-t]').forEach(el => {
    const k = el.dataset.t;
    if (t[k] !== undefined) el.textContent = t[k];
  });

  // <select> <option data-t>
  document.querySelectorAll('option[data-t]').forEach(op => {
    const k = op.dataset.t;
    if (t[k] !== undefined) op.textContent = t[k];
  });

  // nav & sidebar artist identity
  document.getElementById('nav-uname').textContent = isEn ? ARTIST.name_en : ARTIST.name_ar;
  document.getElementById('sb-name').textContent   = isEn ? ARTIST.name_en : ARTIST.name_ar;
  document.getElementById('sb-ttl').textContent    = isEn ? ARTIST.title_en : ARTIST.title_ar;
  document.getElementById('pro-nm').textContent    = isEn ? ARTIST.name_en : ARTIST.name_ar;
  document.getElementById('pro-ttl').textContent   = isEn ? ARTIST.title_en : ARTIST.title_ar;
  document.getElementById('pro-since-val').textContent = isEn ? ARTIST.joined_en : ARTIST.joined_ar;

  // dashboard greeting
  const ds = document.getElementById('dash-sub');
  if (ds) ds.textContent = t['dash-sub-pre'] + ' ' + (isEn ? ARTIST.name_en : ARTIST.name_ar);

  // sold count sub
  const ss = document.getElementById('sc-sold-sub');
  if (ss) ss.textContent = '<?= $sold_count ?> ' + t['sc-sold-unit'];

  // bilingual: title column
  document.querySelectorAll('.bili-title').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // bilingual: type column
  document.querySelectorAll('.bili-type').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // status cells
  document.querySelectorAll('.s-cell').forEach(el => {
    const s = el.dataset.s;
    el.textContent = t['st-' + s] || s;
  });

  // order fields
  document.querySelectorAll('.bili-date').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.bili-art').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.bili-buyer').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.bili-addr').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.bili-country').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // wallet fields
  document.querySelectorAll('.bili-tx-art').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.bili-tx-date').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.bili-bank').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // activity feed rebuild
  buildFeed(l);
}

// ── tgl() — toggle + history.replaceState ────────────────────────────────
function tgl() {
  L = L === 'ar' ? 'en' : 'ar';
  apply(L);
  const u = new URL(window.location.href);
  u.searchParams.set('lang', L);
  history.replaceState(null, '', u.toString());
}

// ── Video background ──────────────────────────────────────────────────────
(function(){
  const v = document.getElementById('vid');
  if (!v) return;
  v.addEventListener('canplay', () => v.classList.add('on'), { once: true });
  v.play().catch(() => {});
})();

// ── Tab switching ─────────────────────────────────────────────────────────
function switchTab(name, el) {
  document.querySelectorAll('.tab-sec').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.slink').forEach(s => s.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  if (el) el.classList.add('active');
  closeSidebar();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function switchTabByName(name) {
  const el = document.querySelector('.slink[data-tab="'+name+'"]');
  switchTab(name, el);
}

// ── Portfolio filter ──────────────────────────────────────────────────────
function portFilter(s, btn) {
  document.querySelectorAll('.chip[data-pf]').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.pcard[data-pf-s]').forEach(c => {
    c.style.display = (s === 'all' || c.dataset.pfS === s) ? '' : 'none';
  });
}

function deletePcard(btn) {
  const msg = L === 'ar'
    ? 'هل أنت متأكد من حذف هذا العمل؟'
    : 'Delete this artwork permanently?';
  if (!confirm(msg)) return;
  btn.closest('.pcard').remove();
  showToast(T[L]['toast-deleted']);
}

// ── Upload image preview ──────────────────────────────────────────────────
function previewImg(input) {
  const file = input.files[0];
  if (!file) return;
  const r = new FileReader();
  r.onload = ev => {
    const img = document.getElementById('img-preview');
    img.src = ev.target.result;
    img.style.display = 'block';
  };
  r.readAsDataURL(file);
}

function handleDrop(ev) {
  ev.preventDefault();
  document.getElementById('up-zone').classList.remove('drag');
  const file = ev.dataTransfer.files[0];
  if (!file || !file.type.startsWith('image/')) return;
  const dt = new DataTransfer();
  dt.items.add(file);
  const inp = document.getElementById('u-file');
  inp.files = dt.files;
  previewImg(inp);
}

function submitUpload(ev) {
  ev.preventDefault();
  const ta = document.getElementById('u-tit-ar').value.trim();
  const te = document.getElementById('u-tit-en').value.trim();
  const pr = document.getElementById('u-price').value;
  if (!ta || !te || !pr) {
    showToast(T[L]['toast-req-fields']);
    return;
  }
  const btn = document.getElementById('up-btn');
  const sp  = document.getElementById('up-spin');
  btn.disabled = true;
  sp.style.display = 'block';
  setTimeout(() => {
    btn.disabled = false;
    sp.style.display = 'none';
    document.getElementById('up-form').reset();
    const img = document.getElementById('img-preview');
    img.src = '';
    img.style.display = 'none';
    showToast(T[L]['toast-uploaded']);
  }, 1800);
}

// ── Profile avatar ────────────────────────────────────────────────────────
function previewAvatar(input) {
  const file = input.files[0];
  if (!file) return;
  const r = new FileReader();
  r.onload = ev => {
    const src = e(ev.target.result);
    ['pro-av','sb-av','nav-av'].forEach(id => {
      document.getElementById(id).innerHTML =
        `<img src="${src}" alt="avatar">`;
    });
  };
  r.readAsDataURL(file);
}

function removeAvatar() {
  const init = e('<?= $A['initials'] ?>');
  ['pro-av','sb-av','nav-av'].forEach(id => {
    document.getElementById(id).innerHTML = init;
  });
}

function saveProfile() {
  showToast(T[L]['toast-saved']);
}

// ── Clipboard copy ────────────────────────────────────────────────────────
function copyClip(text, btn) {
  navigator.clipboard.writeText(text).then(() => {
    const orig = btn.textContent;
    btn.textContent = T[L]['toast-copied'];
    setTimeout(() => { btn.textContent = orig; }, 2000);
  });
}

// ── Activity feed ─────────────────────────────────────────────────────────
const ACT_COLORS = ['#ff0055','#00c853','#ff0055','#0055ff','#aa00ff'];

function buildFeed(l) {
  const t = T[l];
  const feed = document.getElementById('act-feed');
  if (!feed) return;
  feed.innerHTML = [0,1,2,3,4].map(i => `
    <div class="act-item">
      <div class="act-dot" style="background:${e(ACT_COLORS[i])}"></div>
      <div class="act-txt">${e(t['act-'+i])}</div>
      <div class="act-time">${e(t['t-'+i])}</div>
    </div>
  `).join('');
}

// ── Sidebar (mobile) ──────────────────────────────────────────────────────
function openSidebar()  {
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('sb-ov').classList.add('open');
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sb-ov').classList.remove('open');
}

// ── Toast ─────────────────────────────────────────────────────────────────
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(t._tid);
  t._tid = setTimeout(() => t.classList.remove('show'), 3200);
}

// ── Boot ──────────────────────────────────────────────────────────────────
apply(L);
</script>
</body>
</html>
