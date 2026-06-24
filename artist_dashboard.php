<?php
// artist_dashboard.php — Resha Art · لوحة تحكم الفنان
// World-class single-file artist dashboard with bilingual AR/EN switching,
// video background, frosted glass brand, and 5 core section tabs.

$initialLang = in_array($_GET['lang'] ?? '', ['en','ar']) ? $_GET['lang'] : 'ar';

// ── Sample artist data ──────────────────────────────────────────────────────
$artist = [
  'name_ar'     => 'ليلى إبراهيم',
  'name_en'     => 'Layla Ibrahim',
  'title_ar'    => 'فنانة تشكيلية · الرياض',
  'title_en'    => 'Visual Artist · Riyadh',
  'initials'    => 'لي',
  'avatar_url'  => '',
  'bio_ar'      => 'فنانة سعودية متخصصة في الألوان المائية والفن الرقمي. أستلهم أعمالي من بيئة الجزيرة العربية وتراثها البصري الثري.',
  'bio_en'      => 'Saudi artist specializing in watercolor and digital art. My work draws inspiration from the Arabian Peninsula\'s landscape and rich visual heritage.',
  'instagram'   => '@layla.art',
  'twitter'     => '@laylaibrahim',
  'website'     => 'www.laylaart.com',
  'iban'        => 'SA03 8000 0000 6080 1016 7519',
  'bank'        => 'Al Rajhi Bank',
  'joined_ar'   => 'يناير ٢٠٢٤',
  'joined_en'   => 'January 2024',
];

$artworks = [
  [
    'id' => 1, 'title_ar' => 'همسات الصحراء', 'title_en' => 'Desert Whispers',
    'desc_ar'  => 'أكريليك على قماش. رحلة عبر الكثبان الذهبية في الربع الخالي.',
    'desc_en'  => 'Acrylic on canvas. A journey through the golden dunes of the Empty Quarter.',
    'price'    => 1200, 'art_type' => 'abstract',
    'type_ar'  => 'تجريدي', 'type_en' => 'Abstract',
    'status'   => 'available',
    'image_url'=> 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=600&q=80',
    'date_ar'  => '١٠ مايو ٢٠٢٦', 'date_en' => 'May 10, 2026',
    'views' => 243, 'likes' => 18,
  ],
  [
    'id' => 2, 'title_ar' => 'الهدوء الأزرق', 'title_en' => 'Blue Serenity',
    'desc_ar'  => 'ألوان مائية مستوحاة من مياه الخليج العربي عند الفجر.',
    'desc_en'  => 'Watercolors inspired by the Arabian Gulf at dawn.',
    'price'    => 850, 'art_type' => 'landscape',
    'type_ar'  => 'مناظر طبيعية', 'type_en' => 'Landscape',
    'status'   => 'sold',
    'image_url'=> 'https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=600&q=80',
    'date_ar'  => '٢٢ أبريل ٢٠٢٦', 'date_en' => 'Apr 22, 2026',
    'views' => 581, 'likes' => 42,
  ],
  [
    'id' => 3, 'title_ar' => 'البورتريه الصامت', 'title_en' => 'Silent Portrait',
    'desc_ar'  => 'زيت على الكتان. دراسة في الضوء والظل في الوجه العربي المعاصر.',
    'desc_en'  => 'Oil on linen. A study of light and shadow in the modern Arab face.',
    'price'    => 2400, 'art_type' => 'portrait',
    'type_ar'  => 'بورتريه', 'type_en' => 'Portrait',
    'status'   => 'auction',
    'image_url'=> 'https://images.unsplash.com/photo-1578301978069-55e07489cfe1?w=600&q=80',
    'date_ar'  => '١ يونيو ٢٠٢٦', 'date_en' => 'Jun 1, 2026',
    'views' => 1124, 'likes' => 97,
  ],
  [
    'id' => 4, 'title_ar' => 'المدينة النيونية', 'title_en' => 'Neon Medina',
    'desc_ar'  => 'فن رقمي يدمج الزخارف العربية التقليدية مع جماليات السايبربانك.',
    'desc_en'  => 'Digital art fusing traditional Arabesque patterns with cyberpunk aesthetics.',
    'price'    => 600, 'art_type' => 'digital',
    'type_ar'  => 'فن رقمي', 'type_en' => 'Digital Art',
    'status'   => 'available',
    'image_url'=> 'https://images.unsplash.com/photo-1637858868799-7f26a0640eb6?w=600&q=80',
    'date_ar'  => '١٥ يونيو ٢٠٢٦', 'date_en' => 'Jun 15, 2026',
    'views' => 388, 'likes' => 29,
  ],
];

// ── Stats ───────────────────────────────────────────────────────────────────
$active_count  = count(array_filter($artworks, fn($a) => in_array($a['status'], ['available','auction'])));
$sold_artworks = array_filter($artworks, fn($a) => $a['status'] === 'sold');
$sold_count    = count($sold_artworks);
$total_sales   = array_sum(array_column(array_values($sold_artworks), 'price'));
$auction_count = count(array_filter($artworks, fn($a) => $a['status'] === 'auction'));
$total_views   = array_sum(array_column($artworks, 'views'));

// ── Sample orders ───────────────────────────────────────────────────────────
$orders = [
  [
    'id' => 'ORD-2841',
    'artwork_ar' => 'الهدوء الأزرق', 'artwork_en' => 'Blue Serenity',
    'buyer_ar'   => 'محمد الفارس',   'buyer_en'   => 'Mohammed Al-Faris',
    'address_ar' => 'الرياض، حي النرجس، شارع الأمير محمد',
    'address_en' => 'Riyadh, Al-Narjis District, Prince Mohammed St.',
    'amount'     => 850, 'status' => 'delivered',
    'date_ar'    => '١٨ مايو ٢٠٢٦', 'date_en' => 'May 18, 2026',
    'tracking'   => 'ARAMEX-44821733',
  ],
  [
    'id' => 'ORD-2909',
    'artwork_ar' => 'ساعة الذهب',   'artwork_en' => 'Golden Hour',
    'buyer_ar'   => 'سارة الزيد',   'buyer_en'   => 'Sara Al-Zaid',
    'address_ar' => 'دبي، مرسى دبي، برج الأندلس ٢',
    'address_en' => 'Dubai, Dubai Marina, Al-Andalus Tower 2',
    'amount'     => 1750, 'status' => 'in_transit',
    'date_ar'    => '٩ يونيو ٢٠٢٦', 'date_en' => 'Jun 9, 2026',
    'tracking'   => 'DHL-892044551',
  ],
  [
    'id' => 'ORD-2977',
    'artwork_ar' => 'العقل المتشظي','artwork_en' => 'Fractured Mind',
    'buyer_ar'   => 'عبدالله النصر','buyer_en'   => 'Abdullah Al-Nasr',
    'address_ar' => 'الدمام، حي الشاطئ، مجمع الواجهة البحرية',
    'address_en' => 'Dammam, Al-Shati District, Waterfront Complex',
    'amount'     => 980, 'status' => 'processing',
    'date_ar'    => '٢١ يونيو ٢٠٢٦', 'date_en' => 'Jun 21, 2026',
    'tracking'   => '',
  ],
];

// ── Wallet transactions ─────────────────────────────────────────────────────
$transactions = [
  ['ref'=>'TXN-9901','artwork_ar'=>'الهدوء الأزرق','artwork_en'=>'Blue Serenity','amount'=>680,'fee'=>170,'status'=>'cleared','date_ar'=>'٢٠ مايو ٢٠٢٦','date_en'=>'May 20, 2026'],
  ['ref'=>'TXN-9874','artwork_ar'=>'همسات الصحراء','artwork_en'=>'Desert Whispers','amount'=>960,'fee'=>240,'status'=>'escrow','date_ar'=>'١٢ يونيو ٢٠٢٦','date_en'=>'Jun 12, 2026'],
  ['ref'=>'TXN-9851','artwork_ar'=>'المدينة النيونية','artwork_en'=>'Neon Medina','amount'=>480,'fee'=>120,'status'=>'escrow','date_ar'=>'١٦ يونيو ٢٠٢٦','date_en'=>'Jun 16, 2026'],
];
$cleared = array_sum(array_column(array_filter($transactions, fn($t) => $t['status']==='cleared'), 'amount'));
$escrow  = array_sum(array_column(array_filter($transactions, fn($t) => $t['status']==='escrow'),  'amount'));
?>
<!DOCTYPE html>
<html lang="<?= $initialLang ?>" dir="<?= $initialLang==='ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>لوحة تحكم الفنان · Resha Art</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* ── RESET ── */
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
    html,body{width:100%;min-height:100vh;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;overflow-x:hidden;}

    /* ── VIDEO BACKGROUND ── */
    .bg-wrap{position:fixed;inset:0;z-index:0;overflow:hidden;background:#f8f7f5;}
    .bg-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity 2s ease;z-index:2;}
    .bg-video.on{opacity:0.88;}
    .overlay{position:fixed;inset:0;z-index:3;pointer-events:none;background:linear-gradient(160deg,rgba(255,255,255,0.28) 0%,rgba(255,255,255,0.04) 50%,rgba(255,255,255,0.38) 100%);}
    .overlay2{position:fixed;inset:0;z-index:3;pointer-events:none;background:radial-gradient(ellipse at 20% 50%,rgba(0,100,255,0.05) 0%,transparent 60%);}

    /* ── TOP NAV ── */
    .topnav{
      position:fixed;top:0;left:0;right:0;z-index:300;
      display:flex;align-items:center;justify-content:space-between;
      padding:0 24px;height:56px;
      background:rgba(255,255,255,0.62);
      backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);
      border-bottom:1px solid rgba(0,0,0,0.06);
    }
    [dir=rtl] .topnav{flex-direction:row-reverse;}
    [dir=rtl] .nav-right{flex-direction:row-reverse;}

    .nav-logo{display:flex;align-items:center;gap:8px;text-decoration:none;color:#111;flex-shrink:0;}
    .nav-logo svg{color:#ff0055;}
    .nav-logo span{font-size:13px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;}
    .nav-right{display:flex;align-items:center;gap:8px;flex-shrink:0;}
    .nav-btn{padding:6px 14px;border-radius:999px;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all 0.22s;border:1px solid rgba(0,0,0,0.1);background:rgba(0,0,0,0.04);color:rgba(0,0,0,0.75);}
    .nav-btn:hover{background:rgba(0,0,0,0.08);color:#000;}
    .nav-btn.primary{background:rgba(0,100,255,0.1);border-color:rgba(0,100,255,0.2);color:#0066ff;}
    .nav-btn.primary:hover{background:rgba(0,100,255,0.18);}
    .lang-btn{padding:5px 11px;border-radius:999px;font-size:10px;font-weight:600;letter-spacing:0.06em;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.7);color:rgba(0,0,0,0.7);backdrop-filter:blur(8px);transition:all 0.22s;}
    .lang-btn:hover{background:#111;color:#fff;}
    .nav-user{display:flex;align-items:center;gap:8px;}
    .nav-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#ff0055,#aa00ff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;border:2px solid rgba(255,255,255,0.8);}
    .nav-name{font-size:12px;font-weight:600;color:#111;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}

    /* ── LAYOUT SHELL ── */
    .shell{position:relative;z-index:10;display:flex;min-height:100vh;padding-top:56px;}

    /* ── SIDEBAR ── */
    .sidebar{
      width:220px;flex-shrink:0;
      position:fixed;top:56px;bottom:0;
      background:rgba(255,255,255,0.68);
      backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
      border-right:1px solid rgba(0,0,0,0.06);
      display:flex;flex-direction:column;
      overflow-y:auto;z-index:200;
      transition:transform 0.3s ease;
    }
    [dir=rtl] .sidebar{right:0;left:auto;border-right:none;border-left:1px solid rgba(0,0,0,0.06);}
    [dir=ltr] .sidebar{left:0;right:auto;}
    .sidebar-inner{padding:20px 12px;flex:1;}
    .sidebar-section{font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:rgba(0,0,0,0.35);padding:0 10px;margin:18px 0 6px;}
    .slink{
      display:flex;align-items:center;gap:10px;
      padding:9px 10px;border-radius:11px;
      font-size:12px;font-weight:500;color:rgba(0,0,0,0.65);
      cursor:pointer;transition:all 0.18s;margin-bottom:2px;
      border:1px solid transparent;
      user-select:none;
    }
    [dir=rtl] .slink{flex-direction:row-reverse;}
    .slink:hover{background:rgba(0,0,0,0.05);color:#111;}
    .slink.active{background:rgba(255,255,255,0.95);color:#111;border-color:rgba(0,0,0,0.07);box-shadow:0 2px 8px rgba(0,0,0,0.06);}
    .slink.active .slink-icon{color:#ff0055;}
    .slink-icon{width:16px;height:16px;flex-shrink:0;opacity:0.65;}
    .slink.active .slink-icon{opacity:1;}
    .slink-label{flex:1;}
    .slink-badge{font-size:9px;font-weight:700;padding:2px 7px;border-radius:999px;background:rgba(255,0,85,0.1);color:#ff0055;border:1px solid rgba(255,0,85,0.15);}
    .sidebar-footer{padding:14px 12px;border-top:1px solid rgba(0,0,0,0.06);}
    .artist-card{background:rgba(255,255,255,0.8);border-radius:14px;padding:14px;border:1px solid rgba(0,0,0,0.06);}
    .artist-av{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#ff0055,#aa00ff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;margin-bottom:8px;overflow:hidden;}
    .artist-av img{width:100%;height:100%;object-fit:cover;border-radius:50%;}

    /* mobile sidebar toggle */
    .sidebar-toggle{display:none;position:fixed;bottom:20px;right:20px;z-index:400;width:48px;height:48px;border-radius:50%;background:#111;color:#fff;border:none;cursor:pointer;font-size:20px;align-items:center;justify-content:center;box-shadow:0 8px 24px rgba(0,0,0,0.2);}
    [dir=rtl] .sidebar-toggle{right:auto;left:20px;}
    @media(max-width:768px){.sidebar{transform:translateX(-100%);}.sidebar.open{transform:translateX(0);} [dir=rtl] .sidebar{transform:translateX(100%);} [dir=rtl] .sidebar.open{transform:translateX(0);} .sidebar-toggle{display:flex;}}
    .sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.25);z-index:199;backdrop-filter:blur(2px);}
    .sidebar-overlay.open{display:block;}

    /* ── MAIN CONTENT ── */
    .main{flex:1;min-width:0;padding:28px 32px 60px;}
    [dir=ltr] .main{margin-left:220px;}
    [dir=rtl] .main{margin-right:220px;}
    @media(max-width:768px){.main{margin:0!important;padding:20px 16px 80px;}}

    /* ── SECTION TABS ── */
    .tab-section{display:none;}
    .tab-section.active{display:block;}

    /* ── PAGE HEADER ── */
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:28px;gap:16px;flex-wrap:wrap;}
    .page-title{font-size:22px;font-weight:700;color:#111;letter-spacing:-0.02em;}
    .page-sub{font-size:13px;color:rgba(0,0,0,0.45);margin-top:4px;}
    .date-chip{font-size:11px;color:rgba(0,0,0,0.4);background:rgba(255,255,255,0.7);backdrop-filter:blur(8px);padding:5px 12px;border-radius:999px;border:1px solid rgba(0,0,0,0.07);white-space:nowrap;}

    /* ── GLASS CARD ── */
    .g-card{
      background:rgba(255,255,255,0.76);
      backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
      border:1px solid rgba(255,255,255,0.9);
      border-radius:18px;
      box-shadow:0 4px 20px rgba(0,0,0,0.07);
    }

    /* ── STAT CARDS ── */
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;}
    @media(max-width:1100px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
    @media(max-width:560px){.stats-grid{grid-template-columns:1fr;}}
    .stat-card{padding:18px 20px;border-radius:16px;}
    .stat-icon{font-size:22px;margin-bottom:10px;}
    .stat-label{font-size:10px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(0,0,0,0.45);margin-bottom:6px;}
    .stat-value{font-size:26px;font-weight:800;color:#111;letter-spacing:-0.02em;line-height:1;}
    .stat-sub{font-size:11px;color:rgba(0,0,0,0.4);margin-top:5px;}

    /* ── SECTION HEADERS ── */
    .sec-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px;}
    .sec-title{font-size:15px;font-weight:700;color:#111;}
    .sec-badge{font-size:10px;font-weight:600;padding:3px 10px;border-radius:999px;background:rgba(0,0,0,0.05);color:rgba(0,0,0,0.55);}

    /* ── ACTIVITY FEED ── */
    .activity-item{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid rgba(0,0,0,0.05);}
    [dir=rtl] .activity-item{flex-direction:row-reverse;}
    .activity-item:last-child{border-bottom:none;}
    .act-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px;}
    .act-text{font-size:12px;color:rgba(0,0,0,0.65);line-height:1.6;flex:1;}
    .act-time{font-size:10px;color:rgba(0,0,0,0.35);white-space:nowrap;}

    /* ── TOP ARTWORKS TABLE ── */
    .art-table{width:100%;border-collapse:collapse;}
    .art-table th{font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:rgba(0,0,0,0.4);padding:8px 12px;text-align:start;border-bottom:1px solid rgba(0,0,0,0.07);}
    .art-table td{padding:10px 12px;border-bottom:1px solid rgba(0,0,0,0.04);font-size:12px;color:rgba(0,0,0,0.7);vertical-align:middle;}
    .art-table tr:last-child td{border-bottom:none;}
    .art-table tr:hover td{background:rgba(0,0,0,0.018);}
    .art-thumb{width:36px;height:36px;border-radius:8px;object-fit:cover;display:block;}
    .status-pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:999px;font-size:9px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;}
    .status-available{background:rgba(0,200,83,0.1);color:#009624;}
    .status-sold{background:rgba(0,100,255,0.1);color:#0055ff;}
    .status-auction{background:rgba(255,0,85,0.1);color:#ff0055;}
    .status-dot{width:5px;height:5px;border-radius:50%;}

    /* ── PORTFOLIO GRID ── */
    .port-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
    @media(max-width:900px){.port-grid{grid-template-columns:repeat(2,1fr);}}
    @media(max-width:560px){.port-grid{grid-template-columns:1fr;}}
    .port-card{border-radius:16px;overflow:hidden;cursor:pointer;transition:transform 0.25s,box-shadow 0.25s;}
    .port-card:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.12);}
    .port-img{aspect-ratio:4/3;width:100%;object-fit:cover;display:block;background:#f0f0f0;}
    .port-body{padding:12px 14px 14px;}
    .port-title{font-size:13px;font-weight:700;color:#111;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .port-meta{display:flex;align-items:center;justify-content:space-between;gap:8px;}
    .port-price{font-size:15px;font-weight:800;color:#111;letter-spacing:-0.02em;}
    .port-actions{display:flex;gap:6px;margin-top:10px;}
    .btn-sm{padding:5px 13px;border-radius:999px;font-size:10px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.2s;}
    .btn-dark{background:#111;color:#fff;}
    .btn-dark:hover{background:#333;}
    .btn-outline{background:transparent;color:#111;border:1px solid rgba(0,0,0,0.15);}
    .btn-outline:hover{background:rgba(0,0,0,0.05);}
    .btn-danger{background:rgba(255,0,85,0.08);color:#ff0055;border:1px solid rgba(255,0,85,0.15);}
    .btn-danger:hover{background:rgba(255,0,85,0.15);}

    /* filter chips */
    .chip-row{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:20px;}
    .chip{padding:5px 14px;border-radius:999px;font-size:10px;font-weight:600;letter-spacing:0.05em;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.7);color:rgba(0,0,0,0.6);backdrop-filter:blur(6px);transition:all 0.2s;}
    .chip:hover{background:rgba(255,255,255,0.95);color:#111;}
    .chip.active{background:#111;color:#fff;border-color:#111;}

    /* ── UPLOAD FORM ── */
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    @media(max-width:700px){.form-grid{grid-template-columns:1fr;}}
    .form-group{display:flex;flex-direction:column;gap:6px;}
    .form-group.full{grid-column:1/-1;}
    .form-label{font-size:11px;font-weight:600;color:rgba(0,0,0,0.6);letter-spacing:0.05em;text-transform:uppercase;}
    .form-input,.form-select,.form-textarea{
      padding:10px 14px;border-radius:11px;border:1px solid rgba(0,0,0,0.1);
      background:rgba(255,255,255,0.9);color:#111;font-size:13px;font-family:inherit;
      outline:none;transition:border-color 0.2s,box-shadow 0.2s;width:100%;
    }
    .form-input:focus,.form-select:focus,.form-textarea:focus{border-color:rgba(0,100,255,0.3);box-shadow:0 0 0 3px rgba(0,100,255,0.07);}
    .form-textarea{resize:vertical;min-height:90px;}
    .form-select{cursor:pointer;}
    .upload-zone{
      border:2px dashed rgba(0,0,0,0.12);border-radius:14px;
      background:rgba(255,255,255,0.6);
      padding:32px;text-align:center;cursor:pointer;transition:all 0.2s;
    }
    .upload-zone:hover{border-color:rgba(0,100,255,0.3);background:rgba(0,100,255,0.03);}
    .upload-zone.drag{border-color:#0055ff;background:rgba(0,85,255,0.05);}
    #preview-img{max-height:180px;border-radius:10px;object-fit:cover;display:none;margin:12px auto 0;}
    .btn-primary{
      padding:11px 26px;border-radius:999px;background:#111;color:#fff;
      font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;
      border:none;cursor:pointer;display:inline-flex;align-items:center;gap:8px;
      transition:all 0.22s;box-shadow:0 6px 18px rgba(0,0,0,0.1);
    }
    .btn-primary:hover{background:#333;transform:translateY(-1px);}
    .btn-primary:disabled{opacity:0.5;cursor:not-allowed;transform:none;}
    .toast{
      position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(20px);
      background:#111;color:#fff;padding:12px 24px;border-radius:999px;
      font-size:12px;font-weight:600;z-index:999;
      opacity:0;transition:all 0.35s;pointer-events:none;white-space:nowrap;
    }
    .toast.show{opacity:1;transform:translateX(-50%) translateY(0);}
    .spinner{width:14px;height:14px;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;display:none;}
    @keyframes spin{to{transform:rotate(360deg);}}

    /* ── ORDERS ── */
    .order-card{padding:18px 20px;border-radius:16px;margin-bottom:14px;}
    .order-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;flex-wrap:wrap;gap:8px;}
    [dir=rtl] .order-header{flex-direction:row-reverse;}
    .order-id{font-size:11px;font-weight:700;letter-spacing:0.08em;color:rgba(0,0,0,0.5);}
    .order-date{font-size:11px;color:rgba(0,0,0,0.4);}
    .order-body{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    @media(max-width:640px){.order-body{grid-template-columns:1fr;}}
    .order-field{font-size:11px;}
    .order-field-label{color:rgba(0,0,0,0.38);font-weight:600;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:3px;font-size:9px;}
    .order-field-val{color:#111;font-weight:500;font-size:12px;}
    .order-tracking{display:flex;align-items:center;gap:8px;margin-top:12px;padding-top:12px;border-top:1px solid rgba(0,0,0,0.06);flex-wrap:wrap;}
    [dir=rtl] .order-tracking{flex-direction:row-reverse;}
    .tracking-code{font-size:11px;font-weight:600;font-family:monospace;background:rgba(0,0,0,0.05);padding:4px 10px;border-radius:7px;color:#111;}
    .os-processing{background:rgba(255,160,0,0.1);color:#b36f00;border:1px solid rgba(255,160,0,0.2);}
    .os-in_transit{background:rgba(0,100,255,0.1);color:#0055ff;border:1px solid rgba(0,100,255,0.2);}
    .os-delivered{background:rgba(0,200,83,0.1);color:#009624;border:1px solid rgba(0,200,83,0.2);}

    /* ── WALLET ── */
    .wallet-hero{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:24px;}
    @media(max-width:700px){.wallet-hero{grid-template-columns:1fr;}}
    .w-card{padding:22px 24px;border-radius:18px;}
    .w-label{font-size:10px;font-weight:600;letter-spacing:0.09em;text-transform:uppercase;color:rgba(0,0,0,0.4);margin-bottom:8px;}
    .w-amount{font-size:28px;font-weight:800;color:#111;letter-spacing:-0.02em;}
    .w-sub{font-size:11px;color:rgba(0,0,0,0.4);margin-top:5px;}
    .tx-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(0,0,0,0.05);}
    [dir=rtl] .tx-row{flex-direction:row-reverse;}
    .tx-row:last-child{border-bottom:none;}
    .tx-artwork{font-size:12px;font-weight:600;color:#111;}
    .tx-ref{font-size:10px;font-family:monospace;color:rgba(0,0,0,0.4);}
    .tx-amount{font-size:14px;font-weight:700;color:#111;}
    .tx-fee{font-size:10px;color:rgba(0,0,0,0.38);}
    .tx-cleared{color:#009624;}
    .tx-escrow{color:#b36f00;}

    /* IBAN card */
    .iban-card{background:linear-gradient(135deg,rgba(17,17,17,0.04),rgba(0,100,255,0.04));border-radius:16px;padding:20px 22px;border:1px solid rgba(0,0,0,0.08);}
    .iban-val{font-size:14px;font-family:monospace;font-weight:700;color:#111;letter-spacing:0.06em;word-break:break-all;margin-top:8px;}
    .iban-bank{font-size:11px;color:rgba(0,0,0,0.45);margin-top:4px;}

    /* ── PROFILE ── */
    .profile-avatar-wrap{display:flex;align-items:center;gap:20px;margin-bottom:24px;flex-wrap:wrap;}
    [dir=rtl] .profile-avatar-wrap{flex-direction:row-reverse;}
    .profile-av-big{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#ff0055,#aa00ff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;font-weight:700;overflow:hidden;flex-shrink:0;border:3px solid rgba(255,255,255,0.8);box-shadow:0 4px 20px rgba(0,0,0,0.1);}
    .profile-av-big img{width:100%;height:100%;object-fit:cover;border-radius:50%;}
    .profile-av-meta .name{font-size:18px;font-weight:700;color:#111;}
    .profile-av-meta .title{font-size:12px;color:rgba(0,0,0,0.45);margin-top:4px;}
    .profile-av-meta .joined{font-size:11px;color:rgba(0,0,0,0.35);margin-top:2px;}
    .social-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
    @media(max-width:600px){.social-grid{grid-template-columns:1fr;}}
    .social-item{display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:12px;background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.07);}
    [dir=rtl] .social-item{flex-direction:row-reverse;}
    .social-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}

    /* ── ANIMATIONS ── */
    @keyframes riseUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
    .rise{animation:riseUp 0.5s cubic-bezier(0.22,1,0.36,1) both;}
    .rise-1{animation-delay:.04s}.rise-2{animation-delay:.08s}.rise-3{animation-delay:.12s}.rise-4{animation-delay:.16s}

    /* ── MISC ── */
    .divider{border:none;border-top:1px solid rgba(0,0,0,0.07);margin:20px 0;}
    .text-muted{color:rgba(0,0,0,0.45);}
    @media(max-width:560px){.nav-name{display:none;}.date-chip{display:none;}}
  </style>
</head>
<body>

<!-- ══ BACKGROUND ══ -->
<div class="bg-wrap">
  <video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video>
</div>
<div class="overlay"></div>
<div class="overlay2"></div>

<!-- ══ TOP NAV ══ -->
<nav class="topnav" id="topnav">
  <a class="nav-logo" href="index.html">
    <svg width="18" height="18" viewBox="0 0 256 256" fill="currentColor">
      <path d="M4.688 136C68.373 136 120 187.627 120 251.312C120 252.883 119.967 254.445 119.905 256L0 256L0 136.096C1.555 136.034 3.117 136 4.688 136ZM251.312 136C252.883 136 254.445 136.034 256 136.096L256 256L136.095 256C136.032 254.438 136.001 252.875 136 251.312C136 187.627 187.627 136 251.312 136ZM119.905 0C119.967 1.555 120 3.117 120 4.688C120 68.373 68.373 120 4.687 120C3.117 120 1.555 119.967 0 119.905L0 0ZM256 119.905C254.445 119.967 252.883 120 251.312 120C187.627 120 136 68.373 136 4.687C136 3.117 136.033 1.555 136.095 0L256 0Z"/>
    </svg>
    <span>RESHA ART</span>
  </a>
  <div class="nav-right" id="nav-right">
    <a class="nav-btn" href="marketplace.php"><span data-t="nav-market"></span></a>
    <a class="nav-btn primary" href="marketplace.php"><span data-t="nav-list"></span></a>
    <button class="lang-btn" id="lb" onclick="tgl()"></button>
    <div class="nav-user">
      <div class="nav-avatar" id="nav-av"><?= htmlspecialchars($artist['initials']) ?></div>
      <span class="nav-name" id="nav-name"></span>
    </div>
  </div>
</nav>

<!-- ══ SHELL ══ -->
<div class="shell">

  <!-- ── SIDEBAR ── -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-inner">

      <div class="sidebar-section" data-t="sb-menu"></div>

      <div class="slink active" onclick="switchTab('dashboard')">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        <span class="slink-label" data-t="sb-dashboard"></span>
      </div>

      <div class="slink" onclick="switchTab('portfolio')">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
        <span class="slink-label" data-t="sb-portfolio"></span>
        <span class="slink-badge"><?= count($artworks) ?></span>
      </div>

      <div class="slink" onclick="switchTab('orders')">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        <span class="slink-label" data-t="sb-orders"></span>
        <span class="slink-badge"><?= count($orders) ?></span>
      </div>

      <div class="slink" onclick="switchTab('wallet')">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h14v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>
        <span class="slink-label" data-t="sb-wallet"></span>
      </div>

      <div class="slink" onclick="switchTab('profile')">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span class="slink-label" data-t="sb-profile"></span>
      </div>

      <div class="sidebar-section" data-t="sb-tools"></div>

      <div class="slink" onclick="goMarket()">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span class="slink-label" data-t="sb-market"></span>
      </div>

      <div class="slink" onclick="alert('Coming soon')">
        <svg class="slink-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
        <span class="slink-label" data-t="sb-analytics"></span>
      </div>

    </div>

    <!-- artist card -->
    <div class="sidebar-footer">
      <div class="artist-card">
        <div class="artist-av" id="sb-av">
          <?= htmlspecialchars($artist['initials']) ?>
        </div>
        <div style="font-size:12px;font-weight:700;color:#111;" id="sb-name"></div>
        <div style="font-size:10px;color:rgba(0,0,0,0.45);margin-top:2px;" id="sb-title"></div>
      </div>
    </div>
  </aside>

  <!-- sidebar overlay (mobile) -->
  <div class="sidebar-overlay" id="sb-overlay" onclick="closeSidebar()"></div>

  <!-- ── MAIN ── -->
  <main class="main">

    <!-- ════════════════════════════
         TAB 1 — DASHBOARD
    ════════════════════════════ -->
    <div class="tab-section active rise" id="tab-dashboard">

      <div class="page-header">
        <div>
          <div class="page-title" data-t="dash-title"></div>
          <div class="page-sub" id="dash-sub"></div>
        </div>
        <span class="date-chip"><?= date('l, F j, Y') ?></span>
      </div>

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card g-card rise rise-1">
          <div class="stat-icon">🖼️</div>
          <div class="stat-label" data-t="stat-active"></div>
          <div class="stat-value"><?= $active_count ?></div>
          <div class="stat-sub" data-t="stat-active-sub"></div>
        </div>
        <div class="stat-card g-card rise rise-2">
          <div class="stat-icon">💰</div>
          <div class="stat-label" data-t="stat-sales"></div>
          <div class="stat-value">$<?= number_format($total_sales) ?></div>
          <div class="stat-sub"><span id="sold-count-label"></span></div>
        </div>
        <div class="stat-card g-card rise rise-3">
          <div class="stat-icon">🔨</div>
          <div class="stat-label" data-t="stat-auction"></div>
          <div class="stat-value"><?= $auction_count ?></div>
          <div class="stat-sub" data-t="stat-auction-sub"></div>
        </div>
        <div class="stat-card g-card rise rise-4">
          <div class="stat-icon">👁️</div>
          <div class="stat-label" data-t="stat-views"></div>
          <div class="stat-value"><?= number_format($total_views) ?></div>
          <div class="stat-sub" data-t="stat-views-sub"></div>
        </div>
      </div>

      <!-- 2-column grid -->
      <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:18px;" id="dash-cols">

        <!-- Top artworks -->
        <div class="g-card" style="padding:18px 20px;">
          <div class="sec-header">
            <div class="sec-title" data-t="dash-top-art"></div>
            <span class="sec-badge" data-t="dash-top-art-sub"></span>
          </div>
          <table class="art-table">
            <thead>
              <tr>
                <th data-t="th-art"></th>
                <th data-t="th-type"></th>
                <th data-t="th-price"></th>
                <th data-t="th-status"></th>
                <th data-t="th-views"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($artworks as $aw): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <img class="art-thumb" src="<?= htmlspecialchars($aw['image_url']) ?>" alt="" onerror="this.style.display='none'">
                    <span class="title-cell" data-ar="<?= htmlspecialchars($aw['title_ar']) ?>" data-en="<?= htmlspecialchars($aw['title_en']) ?>" style="font-weight:600;color:#111;"><?= htmlspecialchars($aw['title_ar']) ?></span>
                  </div>
                </td>
                <td><span class="type-cell" data-ar="<?= htmlspecialchars($aw['type_ar']) ?>" data-en="<?= htmlspecialchars($aw['type_en']) ?>"><?= htmlspecialchars($aw['type_ar']) ?></span></td>
                <td style="font-weight:700;">$<?= number_format($aw['price']) ?></td>
                <td>
                  <span class="status-pill status-<?= $aw['status'] ?>">
                    <span class="status-dot" style="background:<?= $aw['status']==='sold' ? '#0055ff' : ($aw['status']==='auction' ? '#ff0055' : '#00c853') ?>;"></span>
                    <span class="status-cell" data-status="<?= $aw['status'] ?>"></span>
                  </span>
                </td>
                <td><?= number_format($aw['views']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Recent activity -->
        <div class="g-card" style="padding:18px 20px;">
          <div class="sec-header">
            <div class="sec-title" data-t="dash-activity"></div>
          </div>
          <div id="activity-feed">
            <!-- populated by JS based on language -->
          </div>
        </div>

      </div>

      <style>@media(max-width:900px){#dash-cols{grid-template-columns:1fr!important;}}</style>
    </div>


    <!-- ════════════════════════════
         TAB 2 — PORTFOLIO
    ════════════════════════════ -->
    <div class="tab-section" id="tab-portfolio">

      <div class="page-header">
        <div>
          <div class="page-title" data-t="port-title"></div>
          <div class="page-sub" data-t="port-sub"></div>
        </div>
        <button class="btn-primary" onclick="scrollToUpload()">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          <span data-t="port-add-btn"></span>
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
      <div class="port-grid" id="port-grid">
        <?php foreach ($artworks as $aw): ?>
        <div class="port-card g-card" data-pstatus="<?= $aw['status'] ?>">
          <img class="port-img" src="<?= htmlspecialchars($aw['image_url']) ?>" alt="" onerror="this.src='https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=600&q=80'">
          <div class="port-body">
            <span class="status-pill status-<?= $aw['status'] ?>" style="margin-bottom:8px;display:inline-flex;">
              <span class="status-dot" style="background:<?= $aw['status']==='sold' ? '#0055ff' : ($aw['status']==='auction' ? '#ff0055' : '#00c853') ?>;"></span>
              <span class="status-cell" data-status="<?= $aw['status'] ?>"></span>
            </span>
            <div class="port-title pcard-title" data-ar="<?= htmlspecialchars($aw['title_ar']) ?>" data-en="<?= htmlspecialchars($aw['title_en']) ?>"><?= htmlspecialchars($aw['title_ar']) ?></div>
            <div class="port-meta">
              <span class="port-price">$<?= number_format($aw['price']) ?></span>
              <span style="font-size:10px;color:rgba(0,0,0,0.4);">👁 <?= number_format($aw['views']) ?> &nbsp;♥ <?= $aw['likes'] ?></span>
            </div>
            <div class="port-actions">
              <button class="btn-sm btn-dark" data-t="port-edit" onclick="alert('Edit coming soon')"></button>
              <button class="btn-sm btn-outline" data-t="port-preview" onclick="window.open('marketplace.php')"></button>
              <button class="btn-sm btn-danger" data-t="port-delete" onclick="deleteCard(this)"></button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <hr class="divider" style="margin:32px 0;">

      <!-- ── Upload Form ── -->
      <div id="upload-anchor"></div>
      <div class="g-card" style="padding:28px 30px;" id="upload-form-wrap">
        <div class="sec-header" style="margin-bottom:20px;">
          <div>
            <div class="sec-title" data-t="upload-title"></div>
            <div style="font-size:12px;color:rgba(0,0,0,0.45);margin-top:4px;" data-t="upload-sub"></div>
          </div>
        </div>

        <form id="upload-form" onsubmit="submitUpload(event)" novalidate>
          <div class="form-grid">

            <div class="form-group">
              <label class="form-label" data-t="upload-title-ar"></label>
              <input class="form-input" id="f-title-ar" type="text" required />
            </div>
            <div class="form-group">
              <label class="form-label" data-t="upload-title-en"></label>
              <input class="form-input" id="f-title-en" type="text" required />
            </div>

            <div class="form-group">
              <label class="form-label" data-t="upload-price"></label>
              <input class="form-input" id="f-price" type="number" min="1" required />
            </div>
            <div class="form-group">
              <label class="form-label" data-t="upload-type"></label>
              <select class="form-select" id="f-type">
                <option value="abstract"  data-t="f-abstract"></option>
                <option value="portrait"  data-t="f-portrait"></option>
                <option value="landscape" data-t="f-landscape"></option>
                <option value="digital"   data-t="f-digital"></option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" data-t="upload-status"></label>
              <select class="form-select" id="f-status">
                <option value="available" data-t="f-available"></option>
                <option value="auction"   data-t="f-auction"></option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" data-t="upload-medium"></label>
              <input class="form-input" id="f-medium" type="text" />
            </div>

            <div class="form-group full">
              <label class="form-label" data-t="upload-desc"></label>
              <textarea class="form-textarea" id="f-desc" rows="3"></textarea>
            </div>

            <div class="form-group full">
              <label class="form-label" data-t="upload-image"></label>
              <div class="upload-zone" id="upload-zone"
                   onclick="document.getElementById('f-file').click()"
                   ondragover="event.preventDefault();this.classList.add('drag')"
                   ondragleave="this.classList.remove('drag')"
                   ondrop="handleDrop(event)">
                <div style="font-size:28px;margin-bottom:10px;">📁</div>
                <div style="font-size:13px;font-weight:600;color:#111;margin-bottom:4px;" data-t="upload-drop"></div>
                <div style="font-size:11px;color:rgba(0,0,0,0.4);" data-t="upload-formats"></div>
                <img id="preview-img" alt="preview" />
              </div>
              <input type="file" id="f-file" accept="image/*" style="display:none" onchange="previewFile(this)" />
            </div>

          </div>

          <div style="display:flex;justify-content:flex-end;margin-top:20px;">
            <button type="submit" class="btn-primary" id="submit-btn">
              <span id="submit-spinner" class="spinner"></span>
              <span id="submit-label" data-t="upload-submit"></span>
            </button>
          </div>
        </form>
      </div>
    </div>


    <!-- ════════════════════════════
         TAB 3 — ORDERS
    ════════════════════════════ -->
    <div class="tab-section" id="tab-orders">

      <div class="page-header">
        <div>
          <div class="page-title" data-t="ord-title"></div>
          <div class="page-sub" data-t="ord-sub"></div>
        </div>
      </div>

      <?php foreach ($orders as $o):
        $osCls = 'os-'.$o['status'];
      ?>
      <div class="order-card g-card">
        <div class="order-header">
          <div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
              <span style="font-size:14px;font-weight:700;color:#111;"><?= htmlspecialchars($o['id']) ?></span>
              <span class="status-pill <?= $osCls ?>">
                <span class="status-dot" style="background:<?= $o['status']==='delivered' ? '#00c853' : ($o['status']==='in_transit' ? '#0055ff' : '#b36f00') ?>;"></span>
                <span class="order-status-cell" data-status="<?= $o['status'] ?>"></span>
              </span>
            </div>
            <div class="order-date" style="margin-top:4px;">
              <span class="ord-date" data-ar="<?= htmlspecialchars($o['date_ar']) ?>" data-en="<?= htmlspecialchars($o['date_en']) ?>"><?= htmlspecialchars($o['date_ar']) ?></span>
            </div>
          </div>
          <div style="font-size:18px;font-weight:800;color:#111;letter-spacing:-0.02em;">$<?= number_format($o['amount']) ?></div>
        </div>
        <div class="order-body">
          <div class="order-field">
            <div class="order-field-label" data-t="ord-artwork"></div>
            <div class="order-field-val ord-artwork" data-ar="<?= htmlspecialchars($o['artwork_ar']) ?>" data-en="<?= htmlspecialchars($o['artwork_en']) ?>"><?= htmlspecialchars($o['artwork_ar']) ?></div>
          </div>
          <div class="order-field">
            <div class="order-field-label" data-t="ord-buyer"></div>
            <div class="order-field-val ord-buyer" data-ar="<?= htmlspecialchars($o['buyer_ar']) ?>" data-en="<?= htmlspecialchars($o['buyer_en']) ?>"><?= htmlspecialchars($o['buyer_ar']) ?></div>
          </div>
          <div class="order-field" style="grid-column:1/-1;">
            <div class="order-field-label" data-t="ord-address"></div>
            <div class="order-field-val ord-address" data-ar="<?= htmlspecialchars($o['address_ar']) ?>" data-en="<?= htmlspecialchars($o['address_en']) ?>"><?= htmlspecialchars($o['address_ar']) ?></div>
          </div>
        </div>
        <?php if ($o['tracking']): ?>
        <div class="order-tracking">
          <span style="font-size:11px;font-weight:600;color:rgba(0,0,0,0.45);" data-t="ord-tracking"></span>
          <span class="tracking-code"><?= htmlspecialchars($o['tracking']) ?></span>
          <button class="btn-sm btn-outline" data-t="ord-copy" onclick="copyText('<?= htmlspecialchars($o['tracking']) ?>', this)"></button>
        </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>

    </div>


    <!-- ════════════════════════════
         TAB 4 — WALLET
    ════════════════════════════ -->
    <div class="tab-section" id="tab-wallet">

      <div class="page-header">
        <div>
          <div class="page-title" data-t="wal-title"></div>
          <div class="page-sub" data-t="wal-sub"></div>
        </div>
        <button class="btn-primary" onclick="alert('Bank transfer feature coming soon')">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
          <span data-t="wal-withdraw"></span>
        </button>
      </div>

      <!-- Balance cards -->
      <div class="wallet-hero">
        <div class="w-card g-card">
          <div class="w-label" data-t="wal-cleared"></div>
          <div class="w-amount">$<?= number_format($cleared) ?></div>
          <div class="w-sub" data-t="wal-cleared-sub"></div>
        </div>
        <div class="w-card g-card">
          <div class="w-label" data-t="wal-escrow"></div>
          <div class="w-amount" style="color:#b36f00;">$<?= number_format($escrow) ?></div>
          <div class="w-sub" data-t="wal-escrow-sub"></div>
        </div>
        <div class="w-card g-card">
          <div class="w-label" data-t="wal-total"></div>
          <div class="w-amount">$<?= number_format($cleared + $escrow) ?></div>
          <div class="w-sub" data-t="wal-total-sub"></div>
        </div>
      </div>

      <!-- Transactions -->
      <div class="g-card" style="padding:20px 22px;margin-bottom:20px;">
        <div class="sec-header">
          <div class="sec-title" data-t="wal-tx-title"></div>
          <span class="sec-badge"><?= count($transactions) ?> <span data-t="wal-tx-count"></span></span>
        </div>
        <?php foreach ($transactions as $tx): ?>
        <div class="tx-row">
          <div>
            <div class="tx-artwork tx-art-name" data-ar="<?= htmlspecialchars($tx['artwork_ar']) ?>" data-en="<?= htmlspecialchars($tx['artwork_en']) ?>"><?= htmlspecialchars($tx['artwork_ar']) ?></div>
            <div class="tx-ref"><?= htmlspecialchars($tx['ref']) ?> · <span class="tx-date" data-ar="<?= htmlspecialchars($tx['date_ar']) ?>" data-en="<?= htmlspecialchars($tx['date_en']) ?>"><?= htmlspecialchars($tx['date_ar']) ?></span></div>
          </div>
          <div style="text-align:end;">
            <div class="tx-amount tx-<?= $tx['status'] ?>">+$<?= number_format($tx['amount']) ?></div>
            <div class="tx-fee"><span data-t="wal-fee"></span>: $<?= number_format($tx['fee']) ?></div>
            <span class="status-pill <?= $tx['status']==='cleared' ? 'status-available' : 'status-auction' ?>" style="margin-top:4px;">
              <span class="status-dot" style="background:<?= $tx['status']==='cleared' ? '#00c853' : '#b36f00' ?>;"></span>
              <span class="tx-status-cell" data-status="<?= $tx['status'] ?>"></span>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- IBAN Card -->
      <div class="g-card" style="padding:20px 22px;">
        <div class="sec-header" style="margin-bottom:14px;">
          <div class="sec-title" data-t="wal-bank-title"></div>
        </div>
        <div class="iban-card">
          <div style="font-size:10px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(0,0,0,0.4);" data-t="wal-iban"></div>
          <div class="iban-val"><?= htmlspecialchars($artist['iban']) ?></div>
          <div class="iban-bank"><?= htmlspecialchars($artist['bank']) ?></div>
        </div>
        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
          <button class="btn-sm btn-dark" data-t="wal-copy-iban" onclick="copyText('<?= htmlspecialchars($artist['iban']) ?>', this)"></button>
          <button class="btn-sm btn-outline" data-t="wal-edit-bank" onclick="switchTab('profile')"></button>
        </div>
      </div>

    </div>


    <!-- ════════════════════════════
         TAB 5 — PROFILE
    ════════════════════════════ -->
    <div class="tab-section" id="tab-profile">

      <div class="page-header">
        <div>
          <div class="page-title" data-t="pro-title"></div>
          <div class="page-sub" data-t="pro-sub"></div>
        </div>
        <button class="btn-primary" onclick="saveProfile()">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          <span data-t="pro-save"></span>
        </button>
      </div>

      <!-- Avatar row -->
      <div class="g-card" style="padding:24px 26px;margin-bottom:18px;">
        <div class="profile-avatar-wrap">
          <div class="profile-av-big" id="pro-av">
            <?= htmlspecialchars($artist['initials']) ?>
          </div>
          <div>
            <div class="profile-av-meta">
              <div class="name" id="pro-name"></div>
              <div class="title" id="pro-title-sub"></div>
              <div class="joined"><span data-t="pro-joined"></span> <span id="pro-joined-val"></span></div>
            </div>
            <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;">
              <button class="btn-sm btn-dark" onclick="document.getElementById('av-file').click()" data-t="pro-change-av"></button>
              <button class="btn-sm btn-outline" onclick="removeAvatar()" data-t="pro-remove-av"></button>
              <input type="file" id="av-file" accept="image/*" style="display:none" onchange="previewAvatar(this)">
            </div>
          </div>
        </div>
      </div>

      <!-- Profile form -->
      <div class="g-card" style="padding:24px 26px;margin-bottom:18px;">
        <div class="sec-title" style="margin-bottom:18px;" data-t="pro-info"></div>
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label" data-t="pro-name-ar"></label>
            <input class="form-input" id="p-name-ar" type="text" value="<?= htmlspecialchars($artist['name_ar']) ?>" />
          </div>
          <div class="form-group">
            <label class="form-label" data-t="pro-name-en"></label>
            <input class="form-input" id="p-name-en" type="text" value="<?= htmlspecialchars($artist['name_en']) ?>" />
          </div>
          <div class="form-group">
            <label class="form-label" data-t="pro-title-ar"></label>
            <input class="form-input" id="p-title-ar" type="text" value="<?= htmlspecialchars($artist['title_ar']) ?>" />
          </div>
          <div class="form-group">
            <label class="form-label" data-t="pro-title-en"></label>
            <input class="form-input" id="p-title-en" type="text" value="<?= htmlspecialchars($artist['title_en']) ?>" />
          </div>
          <div class="form-group full">
            <label class="form-label" data-t="pro-bio-ar"></label>
            <textarea class="form-textarea" id="p-bio-ar"><?= htmlspecialchars($artist['bio_ar']) ?></textarea>
          </div>
          <div class="form-group full">
            <label class="form-label" data-t="pro-bio-en"></label>
            <textarea class="form-textarea" id="p-bio-en"><?= htmlspecialchars($artist['bio_en']) ?></textarea>
          </div>
        </div>
      </div>

      <!-- Social & bank -->
      <div class="g-card" style="padding:24px 26px;margin-bottom:18px;">
        <div class="sec-title" style="margin-bottom:18px;" data-t="pro-social"></div>
        <div class="social-grid">
          <div class="social-item">
            <div class="social-icon" style="background:#fce4ec;">📸</div>
            <div style="flex:1;">
              <div style="font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:rgba(0,0,0,0.4);margin-bottom:4px;">Instagram</div>
              <input class="form-input" id="p-ig" type="text" value="<?= htmlspecialchars($artist['instagram']) ?>" style="padding:6px 10px;font-size:12px;" />
            </div>
          </div>
          <div class="social-item">
            <div class="social-icon" style="background:#e3f2fd;">🐦</div>
            <div style="flex:1;">
              <div style="font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:rgba(0,0,0,0.4);margin-bottom:4px;">X / Twitter</div>
              <input class="form-input" id="p-tw" type="text" value="<?= htmlspecialchars($artist['twitter']) ?>" style="padding:6px 10px;font-size:12px;" />
            </div>
          </div>
          <div class="social-item">
            <div class="social-icon" style="background:#e8f5e9;">🌐</div>
            <div style="flex:1;">
              <div style="font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:rgba(0,0,0,0.4);margin-bottom:4px;"><span data-t="pro-website"></span></div>
              <input class="form-input" id="p-web" type="text" value="<?= htmlspecialchars($artist['website']) ?>" style="padding:6px 10px;font-size:12px;" />
            </div>
          </div>
        </div>
      </div>

      <!-- Bank / IBAN -->
      <div class="g-card" style="padding:24px 26px;">
        <div class="sec-title" style="margin-bottom:18px;" data-t="pro-bank"></div>
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label" data-t="pro-bank-name"></label>
            <input class="form-input" id="p-bank" type="text" value="<?= htmlspecialchars($artist['bank']) ?>" />
          </div>
          <div class="form-group">
            <label class="form-label" data-t="pro-iban"></label>
            <input class="form-input" id="p-iban" type="text" value="<?= htmlspecialchars($artist['iban']) ?>" style="font-family:monospace;letter-spacing:0.04em;" />
          </div>
        </div>
      </div>

    </div><!-- /tab-profile -->

  </main>
</div><!-- /shell -->

<!-- Mobile sidebar toggle button -->
<button class="sidebar-toggle" id="sb-toggle" onclick="openSidebar()">☰</button>

<!-- Toast -->
<div class="toast" id="toast"></div>


<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
// ── Artist data ──────────────────────────────
const ARTIST = <?= json_encode([
  'name_ar'   => $artist['name_ar'],
  'name_en'   => $artist['name_en'],
  'title_ar'  => $artist['title_ar'],
  'title_en'  => $artist['title_en'],
  'joined_ar' => $artist['joined_ar'],
  'joined_en' => $artist['joined_en'],
], JSON_UNESCAPED_UNICODE) ?>;

// ── Translations ─────────────────────────────
const T = {
  ar: {
    dir:'rtl', lb:'English',
    // nav
    'nav-market': 'السوق',
    'nav-list':   'أضف عملاً',
    // sidebar
    'sb-menu':      'القائمة',
    'sb-tools':     'أدوات',
    'sb-dashboard': 'لوحة التحكم',
    'sb-portfolio': 'أعمالي',
    'sb-orders':    'الطلبات',
    'sb-wallet':    'المحفظة',
    'sb-profile':   'الملف الشخصي',
    'sb-market':    'السوق',
    'sb-analytics': 'التحليلات',
    // dashboard
    'dash-title':     'لوحة التحكم',
    'dash-sub-pre':   'مرحباً',
    'dash-top-art':   'أعمالك المميزة',
    'dash-top-art-sub':'أعلى أداءً',
    'dash-activity':  'النشاط الأخير',
    // stats
    'stat-active':      'قوائم نشطة',
    'stat-active-sub':  'متاح + مزاد',
    'stat-sales':       'إجمالي المبيعات',
    'stat-auction':     'مزادات حية',
    'stat-auction-sub': 'قيد المزايدة',
    'stat-views':       'المشاهدات',
    'stat-views-sub':   'عبر جميع الأعمال',
    'sold-count':       'عمل مباع',
    // table headers
    'th-art':    'العمل',
    'th-type':   'النوع',
    'th-price':  'السعر',
    'th-status': 'الحالة',
    'th-views':  'المشاهدات',
    // status labels
    'status-available': 'متاح',
    'status-sold':      'مُباع',
    'status-auction':   'مزاد',
    'status-processing':'قيد المعالجة',
    'status-in_transit':'في الطريق',
    'status-delivered': 'تم التسليم',
    'status-cleared':   'محصّل',
    'status-escrow':    'محتجز',
    // portfolio
    'port-title':   'أعمالي',
    'port-sub':     'أدر لوحاتك وإعدادات كل عمل فني',
    'port-add-btn': 'إضافة عمل جديد',
    'port-edit':    'تعديل',
    'port-preview': 'معاينة',
    'port-delete':  'حذف',
    // filter
    'f-all':       'الكل',
    'f-available': 'متاح',
    'f-auction':   'مزاد',
    'f-sold':      'مُباع',
    'f-abstract':  'تجريدي',
    'f-portrait':  'بورتريه',
    'f-landscape': 'مناظر طبيعية',
    'f-digital':   'فن رقمي',
    // upload form
    'upload-title':    'رفع عمل فني جديد',
    'upload-sub':      'أضف تفاصيل لوحتك الجديدة لعرضها في السوق',
    'upload-title-ar': 'اسم العمل (عربي)',
    'upload-title-en': 'اسم العمل (إنجليزي)',
    'upload-price':    'السعر (USD)',
    'upload-type':     'النوع الفني',
    'upload-status':   'حالة العرض',
    'upload-medium':   'الوسيط / المادة',
    'upload-desc':     'وصف العمل',
    'upload-image':    'صورة العمل',
    'upload-drop':     'اسحب الصورة هنا أو اضغط للاختيار',
    'upload-formats':  'PNG، JPG، WEBP — حد أقصى 12 ميغابايت',
    'upload-submit':   'رفع العمل',
    // orders
    'ord-title':    'الطلبات والشحن',
    'ord-sub':      'تتبع طلبات المشترين وحالة الشحن',
    'ord-artwork':  'العمل الفني',
    'ord-buyer':    'المشتري',
    'ord-address':  'عنوان الشحن',
    'ord-tracking': 'رقم التتبع',
    'ord-copy':     'نسخ',
    // wallet
    'wal-title':       'المحفظة والأرباح',
    'wal-sub':         'تتبع أرباحك وإدارة التحويلات البنكية',
    'wal-withdraw':    'طلب تحويل',
    'wal-cleared':     'أرباح محصّلة',
    'wal-cleared-sub': 'جاهزة للسحب',
    'wal-escrow':      'محتجز في الضمان',
    'wal-escrow-sub':  'قيد التحقق (7 أيام)',
    'wal-total':       'الإجمالي',
    'wal-total-sub':   'محصّل + محتجز',
    'wal-tx-title':    'سجل المعاملات',
    'wal-tx-count':    'معاملة',
    'wal-fee':         'رسوم المنصة',
    'wal-bank-title':  'بيانات التحويل البنكي',
    'wal-iban':        'رقم الآيبان (IBAN)',
    'wal-copy-iban':   'نسخ الآيبان',
    'wal-edit-bank':   'تعديل البيانات',
    // profile
    'pro-title':     'الملف الشخصي',
    'pro-sub':       'عدّل بياناتك ومعلوماتك المهنية',
    'pro-save':      'حفظ التغييرات',
    'pro-joined':    'عضو منذ',
    'pro-change-av': 'تغيير الصورة',
    'pro-remove-av': 'إزالة',
    'pro-info':      'المعلومات الشخصية',
    'pro-name-ar':   'الاسم (عربي)',
    'pro-name-en':   'الاسم (إنجليزي)',
    'pro-title-ar':  'المسمى الوظيفي (عربي)',
    'pro-title-en':  'المسمى الوظيفي (إنجليزي)',
    'pro-bio-ar':    'نبذة عنك (عربي)',
    'pro-bio-en':    'نبذة عنك (إنجليزي)',
    'pro-social':    'حسابات التواصل والموقع',
    'pro-website':   'الموقع الإلكتروني',
    'pro-bank':      'البيانات البنكية',
    'pro-bank-name': 'اسم البنك',
    'pro-iban':      'رقم الآيبان (IBAN)',
    // activity
    'act-new-view':  'مشاهد جديد لعملك',
    'act-sale':      'تم بيع عملك',
    'act-bid':       'مزايدة جديدة على',
    'act-msg':       'رسالة من مشتري على',
    'act-featured':  'تم تمييز عملك في السوق',
    'act-mins':      'منذ دقيقتين',
    'act-hour':      'منذ ساعة',
    'act-hours':     'منذ 3 ساعات',
    'act-day':       'منذ يوم',
    'act-days':      'منذ يومين',
  },
  en: {
    dir:'ltr', lb:'العربية',
    // nav
    'nav-market': 'Marketplace',
    'nav-list':   'List Artwork',
    // sidebar
    'sb-menu':      'Menu',
    'sb-tools':     'Tools',
    'sb-dashboard': 'Dashboard',
    'sb-portfolio': 'My Portfolio',
    'sb-orders':    'Orders',
    'sb-wallet':    'Wallet',
    'sb-profile':   'Profile',
    'sb-market':    'Marketplace',
    'sb-analytics': 'Analytics',
    // dashboard
    'dash-title':     'Dashboard',
    'dash-sub-pre':   'Welcome back,',
    'dash-top-art':   'Top Artworks',
    'dash-top-art-sub':'Best Performing',
    'dash-activity':  'Recent Activity',
    // stats
    'stat-active':      'Active Listings',
    'stat-active-sub':  'Available + Auction',
    'stat-sales':       'Total Sales',
    'stat-auction':     'Live Auctions',
    'stat-auction-sub': 'Currently bidding',
    'stat-views':       'Total Views',
    'stat-views-sub':   'Across all artworks',
    'sold-count':       'artwork sold',
    // table headers
    'th-art':    'Artwork',
    'th-type':   'Type',
    'th-price':  'Price',
    'th-status': 'Status',
    'th-views':  'Views',
    // status labels
    'status-available': 'Available',
    'status-sold':      'Sold',
    'status-auction':   'Auction',
    'status-processing':'Processing',
    'status-in_transit':'In Transit',
    'status-delivered': 'Delivered',
    'status-cleared':   'Cleared',
    'status-escrow':    'Escrow',
    // portfolio
    'port-title':   'My Portfolio',
    'port-sub':     'Manage your artworks and listing settings',
    'port-add-btn': 'Add New Artwork',
    'port-edit':    'Edit',
    'port-preview': 'Preview',
    'port-delete':  'Delete',
    // filter
    'f-all':       'All',
    'f-available': 'Available',
    'f-auction':   'Auction',
    'f-sold':      'Sold',
    'f-abstract':  'Abstract',
    'f-portrait':  'Portrait',
    'f-landscape': 'Landscape',
    'f-digital':   'Digital',
    // upload form
    'upload-title':    'Upload New Artwork',
    'upload-sub':      'Add your new piece details to list it on the marketplace',
    'upload-title-ar': 'Artwork Title (Arabic)',
    'upload-title-en': 'Artwork Title (English)',
    'upload-price':    'Price (USD)',
    'upload-type':     'Art Type',
    'upload-status':   'Listing Status',
    'upload-medium':   'Medium / Material',
    'upload-desc':     'Description',
    'upload-image':    'Artwork Image',
    'upload-drop':     'Drag image here or click to browse',
    'upload-formats':  'PNG, JPG, WEBP — max 12 MB',
    'upload-submit':   'Upload Artwork',
    // orders
    'ord-title':    'Orders & Shipping',
    'ord-sub':      'Track buyer orders and shipment status',
    'ord-artwork':  'Artwork',
    'ord-buyer':    'Buyer',
    'ord-address':  'Shipping Address',
    'ord-tracking': 'Tracking Number',
    'ord-copy':     'Copy',
    // wallet
    'wal-title':       'Wallet & Earnings',
    'wal-sub':         'Track your earnings and manage bank transfers',
    'wal-withdraw':    'Request Transfer',
    'wal-cleared':     'Cleared Earnings',
    'wal-cleared-sub': 'Ready to withdraw',
    'wal-escrow':      'Held in Escrow',
    'wal-escrow-sub':  'Under verification (7 days)',
    'wal-total':       'Total Balance',
    'wal-total-sub':   'Cleared + Escrow',
    'wal-tx-title':    'Transaction History',
    'wal-tx-count':    'transactions',
    'wal-fee':         'Platform fee',
    'wal-bank-title':  'Bank Transfer Details',
    'wal-iban':        'IBAN Number',
    'wal-copy-iban':   'Copy IBAN',
    'wal-edit-bank':   'Edit Details',
    // profile
    'pro-title':     'Profile Settings',
    'pro-sub':       'Update your personal and professional information',
    'pro-save':      'Save Changes',
    'pro-joined':    'Member since',
    'pro-change-av': 'Change Photo',
    'pro-remove-av': 'Remove',
    'pro-info':      'Personal Information',
    'pro-name-ar':   'Name (Arabic)',
    'pro-name-en':   'Name (English)',
    'pro-title-ar':  'Title (Arabic)',
    'pro-title-en':  'Title (English)',
    'pro-bio-ar':    'Bio (Arabic)',
    'pro-bio-en':    'Bio (English)',
    'pro-social':    'Social & Portfolio Links',
    'pro-website':   'Website',
    'pro-bank':      'Bank Information',
    'pro-bank-name': 'Bank Name',
    'pro-iban':      'IBAN Number',
    // activity
    'act-new-view':  'Someone viewed your artwork',
    'act-sale':      'Your artwork sold:',
    'act-bid':       'New bid on',
    'act-msg':       'Message from buyer about',
    'act-featured':  'Your artwork was featured in the marketplace',
    'act-mins':      '2 minutes ago',
    'act-hour':      '1 hour ago',
    'act-hours':     '3 hours ago',
    'act-day':       '1 day ago',
    'act-days':      '2 days ago',
  }
};

// ── Language state ────────────────────────────
let L = '<?= $initialLang ?>';

// ── XSS-safe escape ───────────────────────────
function e(str) {
  return String(str ?? '')
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── apply(lang) ───────────────────────────────
function apply(l) {
  const t = T[l];
  document.documentElement.setAttribute('dir', t.dir);
  document.documentElement.setAttribute('lang', l);
  document.getElementById('lb').textContent = t.lb;

  // all [data-t] text
  document.querySelectorAll('[data-t]').forEach(el => {
    const k = el.dataset.t;
    if (t[k] !== undefined) el.textContent = t[k];
  });

  // select <option> [data-t]
  document.querySelectorAll('select option[data-t]').forEach(op => {
    const k = op.dataset.t;
    if (t[k] !== undefined) op.textContent = t[k];
  });

  // nav & sidebar artist name/title
  const isEn = l === 'en';
  document.getElementById('nav-name').textContent  = isEn ? ARTIST.name_en  : ARTIST.name_ar;
  document.getElementById('sb-name').textContent   = isEn ? ARTIST.name_en  : ARTIST.name_ar;
  document.getElementById('sb-title').textContent  = isEn ? ARTIST.title_en : ARTIST.title_ar;
  document.getElementById('pro-name').textContent  = isEn ? ARTIST.name_en  : ARTIST.name_ar;
  document.getElementById('pro-title-sub').textContent = isEn ? ARTIST.title_en : ARTIST.title_ar;
  document.getElementById('pro-joined-val').textContent = isEn ? ARTIST.joined_en : ARTIST.joined_ar;

  // dashboard sub greeting
  const dsub = document.getElementById('dash-sub');
  if (dsub) dsub.textContent = t['dash-sub-pre'] + ' ' + (isEn ? ARTIST.name_en : ARTIST.name_ar);

  // sold count label
  const scl = document.getElementById('sold-count-label');
  if (scl) scl.textContent = '<?= $sold_count ?> ' + t['sold-count'];

  // bilingual cells — title / type in table
  document.querySelectorAll('.title-cell').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.type-cell').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.pcard-title').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // status pills
  document.querySelectorAll('.status-cell').forEach(el => {
    const s = el.dataset.status;
    el.textContent = t['status-' + s] || s;
  });
  document.querySelectorAll('.order-status-cell').forEach(el => {
    const s = el.dataset.status;
    el.textContent = t['status-' + s] || s;
  });
  document.querySelectorAll('.tx-status-cell').forEach(el => {
    const s = el.dataset.status;
    el.textContent = t['status-' + s] || s;
  });

  // order bilingual fields
  document.querySelectorAll('.ord-artwork').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.ord-buyer').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.ord-address').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.ord-date').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // wallet bilingual
  document.querySelectorAll('.tx-art-name').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });
  document.querySelectorAll('.tx-date').forEach(el => {
    el.textContent = isEn ? el.dataset.en : el.dataset.ar;
  });

  // activity feed
  buildActivity(l);

  // search input direction
  const si = document.getElementById('search-input');
  if (si) si.style.direction = t.dir;
}

// ── tgl() ─────────────────────────────────────
function tgl() {
  L = L === 'ar' ? 'en' : 'ar';
  apply(L);
  const url = new URL(window.location.href);
  url.searchParams.set('lang', L);
  history.replaceState(null, '', url.toString());
}

// ── Video background ──────────────────────────
const v = document.getElementById('vid');
if (v) {
  v.addEventListener('canplay', () => v.classList.add('on'), { once: true });
  v.play().catch(() => {});
}

// ── Tab switching ─────────────────────────────
function switchTab(name) {
  document.querySelectorAll('.tab-section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.slink').forEach(s => s.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  document.querySelectorAll('.slink').forEach(s => {
    if (s.getAttribute('onclick') && s.getAttribute('onclick').includes("'" + name + "'"))
      s.classList.add('active');
  });
  closeSidebar();
}

function goMarket() { window.location.href = 'marketplace.php'; }

// ── Portfolio filter ──────────────────────────
function portFilter(status, btn) {
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.port-card').forEach(card => {
    card.style.display = (status === 'all' || card.dataset.pstatus === status) ? '' : 'none';
  });
}

function deleteCard(btn) {
  if (!confirm(L === 'ar' ? 'هل أنت متأكد من حذف هذا العمل؟' : 'Are you sure you want to delete this artwork?')) return;
  btn.closest('.port-card').remove();
  showToast(L === 'ar' ? 'تم حذف العمل' : 'Artwork deleted');
}

function scrollToUpload() {
  document.getElementById('upload-anchor').scrollIntoView({ behavior: 'smooth' });
}

// ── Upload form ───────────────────────────────
function previewFile(input) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    const img = document.getElementById('preview-img');
    img.src = ev.target.result;
    img.style.display = 'block';
  };
  reader.readAsDataURL(file);
}

function handleDrop(ev) {
  ev.preventDefault();
  document.getElementById('upload-zone').classList.remove('drag');
  const file = ev.dataTransfer.files[0];
  if (!file || !file.type.startsWith('image/')) return;
  const dt = new DataTransfer();
  dt.items.add(file);
  const input = document.getElementById('f-file');
  input.files = dt.files;
  previewFile(input);
}

function submitUpload(ev) {
  ev.preventDefault();
  const titleAr = document.getElementById('f-title-ar').value.trim();
  const titleEn = document.getElementById('f-title-en').value.trim();
  const price   = document.getElementById('f-price').value;
  if (!titleAr || !titleEn || !price) {
    showToast(L === 'ar' ? '⚠️ يرجى ملء جميع الحقول المطلوبة' : '⚠️ Please fill all required fields');
    return;
  }
  const btn = document.getElementById('submit-btn');
  const sp  = document.getElementById('submit-spinner');
  btn.disabled = true;
  sp.style.display = 'block';
  setTimeout(() => {
    btn.disabled = false;
    sp.style.display = 'none';
    document.getElementById('upload-form').reset();
    document.getElementById('preview-img').style.display = 'none';
    showToast(L === 'ar' ? '✅ تم رفع العمل بنجاح' : '✅ Artwork uploaded successfully');
  }, 1800);
}

// ── Profile avatar preview ────────────────────
function previewAvatar(input) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    ['pro-av','sb-av','nav-av'].forEach(id => {
      const el = document.getElementById(id);
      el.innerHTML = `<img src="${e(ev.target.result)}" alt="avatar">`;
    });
  };
  reader.readAsDataURL(file);
}

function removeAvatar() {
  const initials = '<?= htmlspecialchars($artist['initials']) ?>';
  ['pro-av','sb-av','nav-av'].forEach(id => {
    document.getElementById(id).innerHTML = initials;
  });
}

function saveProfile() {
  showToast(L === 'ar' ? '✅ تم حفظ الملف الشخصي' : '✅ Profile saved successfully');
}

// ── Orders ────────────────────────────────────
function copyText(text, btn) {
  navigator.clipboard.writeText(text).then(() => {
    const orig = btn.textContent;
    btn.textContent = L === 'ar' ? 'تم النسخ ✓' : 'Copied ✓';
    setTimeout(() => { btn.textContent = orig; }, 1800);
  });
}

// ── Activity feed ─────────────────────────────
function buildActivity(l) {
  const t = T[l];
  const items = [
    { color:'#ff0055', text: t['act-new-view'] + ' "' + (l==='ar' ? 'البورتريه الصامت' : 'Silent Portrait') + '"', time: t['act-mins'] },
    { color:'#00c853', text: t['act-sale'] + ' "' + (l==='ar' ? 'الهدوء الأزرق' : 'Blue Serenity') + '"', time: t['act-hour'] },
    { color:'#ff0055', text: t['act-bid'] + ' "' + (l==='ar' ? 'البورتريه الصامت' : 'Silent Portrait') + '"', time: t['act-hours'] },
    { color:'#0055ff', text: t['act-msg'] + ' "' + (l==='ar' ? 'همسات الصحراء' : 'Desert Whispers') + '"', time: t['act-day'] },
    { color:'#aa00ff', text: t['act-featured'], time: t['act-days'] },
  ];
  const feed = document.getElementById('activity-feed');
  feed.innerHTML = items.map(item => `
    <div class="activity-item">
      <div class="act-dot" style="background:${e(item.color)};flex-shrink:0;"></div>
      <div class="act-text">${e(item.text)}</div>
      <div class="act-time">${e(item.time)}</div>
    </div>
  `).join('');
}

// ── Sidebar (mobile) ──────────────────────────
function openSidebar()  { document.getElementById('sidebar').classList.add('open'); document.getElementById('sb-overlay').classList.add('open'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sb-overlay').classList.remove('open'); }

// ── Toast ─────────────────────────────────────
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3000);
}

// ── Boot ──────────────────────────────────────
apply(L);
</script>
</body>
</html>
