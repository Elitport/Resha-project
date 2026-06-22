<?php
// marketplace.php — Resha Art · سوق الأعمال الفنية
// Fully integrated with index.html brand: video bg, frosted nav, RTL Arabic.

$artworks = [
  [
    "id"          => 1,
    "title"       => "همسات الصحراء",
    "title_en"    => "Desert Whispers",
    "artist"      => "ليلى إبراهيم",
    "location"    => "الرياض، السعودية",
    "price"       => 1200,
    "art_type"    => "abstract",
    "art_label"   => "تجريدي",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=600&q=80",
    "description" => "أكريليك على قماش. رحلة عبر الكثبان الذهبية في الربع الخالي.",
    "badge"       => "جديد",
    "badge_type"  => "new",
  ],
  [
    "id"          => 2,
    "title"       => "الهدوء الأزرق",
    "title_en"    => "Blue Serenity",
    "artist"      => "عمر الراشد",
    "location"    => "دبي، الإمارات",
    "price"       => 850,
    "art_type"    => "landscape",
    "art_label"   => "مناظر طبيعية",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=600&q=80",
    "description" => "ألوان مائية مستوحاة من مياه الخليج العربي عند الفجر.",
    "badge"       => "",
    "badge_type"  => "",
  ],
  [
    "id"          => 3,
    "title"       => "البورتريه الصامت",
    "title_en"    => "Silent Portrait",
    "artist"      => "نور خليل",
    "location"    => "القاهرة، مصر",
    "price"       => 2400,
    "art_type"    => "portrait",
    "art_label"   => "بورتريه",
    "status"      => "auction",
    "status_label"=> "مزاد مباشر",
    "image_url"   => "https://images.unsplash.com/photo-1578301978069-55e07489cfe1?w=600&q=80",
    "description" => "زيت على الكتان. دراسة في الضوء والظل في الوجه العربي المعاصر.",
    "badge"       => "مزاد",
    "badge_type"  => "auction",
  ],
  [
    "id"          => 4,
    "title"       => "المدينة النيونية",
    "title_en"    => "Neon Medina",
    "artist"      => "سارة الدوسري",
    "location"    => "الدوحة، قطر",
    "price"       => 600,
    "art_type"    => "digital",
    "art_label"   => "فن رقمي",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1637858868799-7f26a0640eb6?w=600&q=80",
    "description" => "فن رقمي يدمج الزخارف العربية التقليدية مع جماليات السايبربانك.",
    "badge"       => "جديد",
    "badge_type"  => "new",
  ],
  [
    "id"          => 5,
    "title"       => "ساعة الذهب",
    "title_en"    => "Golden Hour",
    "artist"      => "يوسف الأمين",
    "location"    => "عمّان، الأردن",
    "price"       => 1750,
    "art_type"    => "landscape",
    "art_label"   => "مناظر طبيعية",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&q=80",
    "description" => "لوحة زيتية تجسّد دفء أشعة الغروب في ربوع الأردن.",
    "badge"       => "",
    "badge_type"  => "",
  ],
  [
    "id"          => 6,
    "title"       => "العقل المتشظي",
    "title_en"    => "Fractured Mind",
    "artist"      => "ليلى إبراهيم",
    "location"    => "الرياض، السعودية",
    "price"       => 980,
    "art_type"    => "abstract",
    "art_label"   => "تجريدي",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1541512416146-3cf58d6b27cc?w=600&q=80",
    "description" => "وسائط مختلطة على لوح خشبي تستكشف الهوية والازدواجية.",
    "badge"       => "",
    "badge_type"  => "",
  ],
  [
    "id"          => 7,
    "title"       => "الشيخ",
    "title_en"    => "The Elder",
    "artist"      => "فاطمة الزهراء",
    "location"    => "مراكش، المغرب",
    "price"       => 3200,
    "art_type"    => "portrait",
    "art_label"   => "بورتريه",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=600&q=80",
    "description" => "بورتريه فحم فائق الواقعية لشيخ مغربي في ضوء الشمس.",
    "badge"       => "مميز",
    "badge_type"  => "featured",
  ],
  [
    "id"          => 8,
    "title"       => "السوق الرقمي",
    "title_en"    => "Cyber Souk",
    "artist"      => "خالد ناصر",
    "location"    => "بيروت، لبنان",
    "price"       => 450,
    "art_type"    => "digital",
    "art_label"   => "فن رقمي",
    "status"      => "available",
    "status_label"=> "متاح للبيع",
    "image_url"   => "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80",
    "description" => "إعادة تخيّل رقمية للسوق الشرقي التقليدي بلمسة مستقبلية.",
    "badge"       => "",
    "badge_type"  => "",
  ],
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>سوق ريشة فن · Resha Art Marketplace</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* ── RESET ── */
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
    html,body{width:100%;min-height:100vh;background:#ffffff;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;overflow-x:hidden;}

    /* ── BACKGROUND (exact from index.html) ── */
    .bg-wrap{position:fixed;inset:0;z-index:0;overflow:hidden;}
    .bg-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity 2s ease;z-index:2;}
    .bg-video.on{opacity:0.92;}
    .overlay{position:fixed;inset:0;z-index:3;pointer-events:none;background:linear-gradient(160deg,rgba(255,255,255,0.22) 0%,rgba(255,255,255,0) 50%,rgba(255,255,255,0.38) 100%);}
    .overlay2{position:fixed;inset:0;z-index:3;pointer-events:none;background:radial-gradient(ellipse at 20% 50%,rgba(0,100,255,0.06) 0%,transparent 60%);}

    /* ── TOP NAV (exact from index.html) ── */
    .topnav{
      position:fixed;top:0;left:0;right:0;z-index:200;
      display:flex;align-items:center;justify-content:space-between;
      padding:0 24px;height:56px;
      background:rgba(255,255,255,0.6);
      backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
      border-bottom:1px solid rgba(0,0,0,0.05);
    }
    [dir=rtl] .topnav{flex-direction:row-reverse;}
    [dir=rtl] .nav-right{flex-direction:row-reverse;}
    [dir=rtl] .nav-center{flex-direction:row-reverse;}
    [dir=rtl] .dropdown{left:auto;right:0;text-align:right;}
    [dir=rtl] .dropdown a{flex-direction:row-reverse;}

    .nav-logo{display:flex;align-items:center;gap:8px;text-decoration:none;color:#111111;flex-shrink:0;}
    .nav-logo svg{color:#ff0055;}
    .nav-logo span{font-size:13px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;}

    /* ── NAV CENTER ── */
    .nav-center{display:flex;align-items:stretch;gap:0;height:100%;}
    .nav-item{position:relative;display:flex;align-items:center;}
    .nav-item > a{
      display:flex;align-items:center;gap:5px;
      padding:0 16px;height:100%;
      font-size:11px;font-weight:600;letter-spacing:0.07em;text-transform:uppercase;
      color:rgba(0,0,0,0.65);text-decoration:none;
      transition:color 0.2s;white-space:nowrap;
      border-bottom:2px solid transparent;
    }
    .nav-item > a:hover{color:#000;}
    .nav-item:hover > a{color:#0055ff;border-bottom-color:#0055ff;}
    .nav-item.active-page > a{color:#ff0055;border-bottom-color:#ff0055;}

    .nav-item > a .chevron{width:10px;height:10px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;transition:transform 0.2s;flex-shrink:0;}
    .nav-item:hover > a .chevron{transform:rotate(180deg);}

    /* dropdown */
    .dropdown{
      position:absolute;top:100%;left:0;min-width:200px;
      background:rgba(255,255,255,0.96);
      backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
      border:1px solid rgba(0,0,0,0.07);
      border-radius:14px;box-shadow:0 16px 40px rgba(0,0,0,0.1);
      padding:8px;
      opacity:0;visibility:hidden;transform:translateY(8px);
      transition:opacity 0.2s,transform 0.2s,visibility 0.2s;
      pointer-events:none;
    }
    [dir=rtl] .dropdown{left:auto;right:0;}
    .nav-item:hover .dropdown{opacity:1;visibility:visible;transform:translateY(0);pointer-events:auto;}
    .dropdown a{
      display:flex;align-items:center;gap:10px;
      padding:9px 12px;border-radius:9px;
      font-size:12px;color:rgba(0,0,0,0.7);text-decoration:none;
      transition:background 0.15s,color 0.15s;
    }
    .dropdown a:hover{background:rgba(0,100,255,0.07);color:#0055ff;}
    .dropdown a .d-icon{width:14px;height:14px;fill:currentColor;opacity:0.6;flex-shrink:0;}

    /* ── NAV RIGHT ── */
    .nav-right{display:flex;align-items:center;gap:8px;flex-shrink:0;}
    .nav-btn{
      padding:6px 14px;border-radius:999px;font-size:11px;font-weight:600;
      letter-spacing:0.06em;text-transform:uppercase;cursor:pointer;
      text-decoration:none;display:inline-flex;align-items:center;gap:5px;
      transition:all 0.22s;border:1px solid rgba(0,0,0,0.1);
      background:rgba(0,0,0,0.04);color:rgba(0,0,0,0.8);
    }
    .nav-btn:hover{background:rgba(0,0,0,0.08);color:#000;}
    .nav-btn.primary{background:rgba(0,100,255,0.1);border-color:rgba(0,100,255,0.2);color:#0066ff;}
    .nav-btn.primary:hover{background:rgba(0,100,255,0.18);}
    .lang-btn{
      padding:5px 11px;border-radius:999px;font-size:10px;font-weight:600;
      letter-spacing:0.06em;cursor:pointer;
      border:1px solid rgba(0,0,0,0.1);
      background:rgba(255,255,255,0.7);color:rgba(0,0,0,0.7);
      backdrop-filter:blur(8px);transition:all 0.22s;
    }
    .lang-btn:hover{background:#111111;color:#fff;}

    /* ── PAGE WRAPPER ── */
    .page{position:relative;z-index:10;width:100%;max-width:1280px;margin:0 auto;padding:80px 32px 64px;min-height:100vh;}

    /* ── HERO ── */
    .mkt-hero{
      text-align:center;padding:48px 24px 40px;
      animation:riseUp 1s cubic-bezier(0.22,1,0.36,1) forwards;opacity:0;
    }
    .hero-badge{
      display:inline-flex;align-items:center;gap:8px;padding:5px 14px;
      border-radius:999px;margin-bottom:20px;
      background:rgba(255,0,85,0.06);border:1px solid rgba(255,0,85,0.18);
      font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#ff0055;
    }
    .pulse-dot{width:6px;height:6px;border-radius:50%;background:#ff0055;box-shadow:0 0 10px rgba(255,0,85,0.5);animation:pulse 2s infinite;}
    .mkt-hero h1{font-size:clamp(26px,4vw,48px);font-weight:300;line-height:1.18;color:#111111;margin-bottom:14px;letter-spacing:-0.02em;}
    .mkt-hero h1 em{font-style:normal;font-weight:700;background:linear-gradient(90deg,#ff0055,#0066ff,#aa00ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .mkt-hero p{font-size:14px;line-height:1.82;color:rgba(15,15,15,0.72);max-width:560px;margin:0 auto 28px;}

    /* ── GLASS PANEL ── */
    .glass-panel{
      background:rgba(255,255,255,0.72);
      backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
      border:1px solid rgba(255,255,255,0.9);
      border-radius:20px;
      box-shadow:0 8px 32px rgba(0,0,0,0.08);
    }

    /* ── SEARCH BAR ── */
    .search-wrap{max-width:560px;margin:0 auto;}
    .search-inner{display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:999px;background:rgba(255,255,255,0.88);backdrop-filter:blur(12px);border:1px solid rgba(0,0,0,0.1);box-shadow:0 4px 20px rgba(0,0,0,0.07);}
    .search-inner input{flex:1;border:none;background:transparent;font-size:13px;color:#111;outline:none;font-family:inherit;direction:rtl;}
    .search-inner input::placeholder{color:rgba(0,0,0,0.38);}
    .search-inner svg{flex-shrink:0;color:rgba(0,0,0,0.38);}

    /* ── FILTER TABS ── */
    .filter-row{display:flex;flex-wrap:wrap;justify-content:center;gap:8px;margin:24px 0;}
    .ftab{
      padding:7px 18px;border-radius:999px;font-size:11px;font-weight:600;
      letter-spacing:0.05em;cursor:pointer;
      border:1px solid rgba(0,0,0,0.1);
      background:rgba(255,255,255,0.7);color:rgba(0,0,0,0.65);
      backdrop-filter:blur(8px);transition:all 0.22s;
      display:inline-flex;align-items:center;gap:6px;
    }
    .ftab:hover{background:rgba(255,255,255,0.95);color:#000;border-color:rgba(0,0,0,0.2);}
    .ftab.active{background:#111111;color:#ffffff;border-color:#111111;box-shadow:0 4px 14px rgba(0,0,0,0.18);}

    /* ── SORT BAR ── */
    .sort-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:10px;}
    .sort-bar select{
      padding:6px 14px;border-radius:999px;font-size:11px;font-weight:600;
      border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.8);
      color:rgba(0,0,0,0.7);outline:none;cursor:pointer;font-family:inherit;
      backdrop-filter:blur(8px);
    }
    .results-count{font-size:12px;color:rgba(0,0,0,0.45);font-weight:500;letter-spacing:0.04em;}

    /* ── ARTWORK CARDS ── */
    .art-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
    @media(max-width:1100px){.art-grid{grid-template-columns:repeat(3,1fr);}}
    @media(max-width:768px){.art-grid{grid-template-columns:repeat(2,1fr);}}
    @media(max-width:480px){.art-grid{grid-template-columns:1fr;}}

    .art-card{
      border-radius:18px;overflow:hidden;cursor:pointer;
      background:rgba(255,255,255,0.75);
      backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
      border:1px solid rgba(255,255,255,0.95);
      box-shadow:0 4px 20px rgba(0,0,0,0.08);
      transition:transform 0.28s cubic-bezier(.25,.46,.45,.94),box-shadow 0.28s;
      animation:riseUp 0.45s ease both;
    }
    .art-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,0,0,0.14);}
    .art-card:nth-child(1){animation-delay:.05s} .art-card:nth-child(2){animation-delay:.10s}
    .art-card:nth-child(3){animation-delay:.15s} .art-card:nth-child(4){animation-delay:.20s}
    .art-card:nth-child(5){animation-delay:.25s} .art-card:nth-child(6){animation-delay:.30s}
    .art-card:nth-child(7){animation-delay:.35s} .art-card:nth-child(8){animation-delay:.40s}

    .card-img-wrap{position:relative;aspect-ratio:4/3;overflow:hidden;background:#f0f0f0;}
    .card-img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s cubic-bezier(.25,.46,.45,.94);}
    .art-card:hover .card-img{transform:scale(1.07);}

    /* hover overlay */
    .card-hover-overlay{
      position:absolute;inset:0;
      background:linear-gradient(to top,rgba(0,0,0,0.55),transparent);
      opacity:0;transition:opacity 0.3s;
      display:flex;align-items:flex-end;padding:14px;
    }
    .art-card:hover .card-hover-overlay{opacity:1;}
    .card-hover-label{font-size:11px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#fff;background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);padding:6px 14px;border-radius:999px;border:1px solid rgba(255,255,255,0.3);}

    /* badges */
    .card-badge{position:absolute;top:10px;right:10px;font-size:9px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;padding:4px 10px;border-radius:999px;}
    .badge-new{background:rgba(0,100,255,0.12);color:#0055ff;border:1px solid rgba(0,100,255,0.2);}
    .badge-auction{background:rgba(255,0,85,0.1);color:#ff0055;border:1px solid rgba(255,0,85,0.2);}
    .badge-featured{background:rgba(170,0,255,0.1);color:#aa00ff;border:1px solid rgba(170,0,255,0.2);}

    /* wishlist */
    .card-wish{position:absolute;top:10px;left:10px;width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,0.8);backdrop-filter:blur(6px);border:1px solid rgba(0,0,0,0.07);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;transition:all 0.2s;color:rgba(0,0,0,0.4);}
    .card-wish:hover{color:#ff0055;background:#fff;}
    .card-wish.loved{color:#ff0055;}

    /* card body */
    .card-body{padding:14px 16px 16px;}
    .card-type-pill{display:inline-block;font-size:9px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;padding:3px 9px;border-radius:999px;background:rgba(0,0,0,0.05);color:rgba(0,0,0,0.55);margin-bottom:8px;}
    .card-title{font-size:14px;font-weight:700;color:#111111;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .card-artist{display:flex;align-items:center;gap:6px;margin-bottom:12px;}
    .artist-avatar{width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,#ff0055,#aa00ff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:9px;font-weight:700;flex-shrink:0;}
    .artist-name{font-size:12px;color:rgba(0,0,0,0.55);}
    .artist-loc{font-size:10px;color:rgba(0,0,0,0.35);}

    .card-footer{display:flex;align-items:center;justify-content:space-between;}
    .card-price-area{}
    .card-status{font-size:10px;color:rgba(0,0,0,0.4);display:flex;align-items:center;gap:4px;margin-bottom:2px;}
    .status-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0;}
    .dot-available{background:#00c853;}
    .dot-auction{background:#ff0055;}
    .card-price{font-size:18px;font-weight:800;color:#111111;letter-spacing:-0.02em;}

    .btn-details{
      padding:7px 16px;border-radius:999px;
      background:#111111;color:#ffffff;
      font-size:10px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;
      border:none;cursor:pointer;transition:all 0.22s;
      white-space:nowrap;
    }
    .btn-details:hover{background:#333;transform:translateY(-1px);box-shadow:0 6px 16px rgba(0,0,0,0.15);}

    /* ── EMPTY STATE ── */
    #empty-state{display:none;text-align:center;padding:80px 20px;}
    .empty-icon{font-size:48px;margin-bottom:16px;}
    .empty-title{font-size:18px;font-weight:700;color:#111;margin-bottom:8px;}
    .empty-sub{font-size:13px;color:rgba(0,0,0,0.45);}
    .btn-reset{margin-top:20px;padding:10px 24px;border-radius:999px;background:#111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.22s;}
    .btn-reset:hover{background:#333;}

    /* ── ARTIST CTA BANNER ── */
    .artist-cta{
      margin-top:64px;border-radius:24px;overflow:hidden;position:relative;
      background:rgba(255,255,255,0.78);backdrop-filter:blur(20px);
      border:1px solid rgba(255,255,255,0.95);
      box-shadow:0 8px 32px rgba(0,0,0,0.08);
      padding:40px 48px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;
    }
    .cta-accent{position:absolute;top:-40px;left:-40px;width:200px;height:200px;border-radius:50%;background:linear-gradient(135deg,rgba(255,0,85,0.07),rgba(0,100,255,0.07));pointer-events:none;}
    .cta-title{font-size:22px;font-weight:700;color:#111;margin-bottom:8px;}
    .cta-sub{font-size:13px;color:rgba(0,0,0,0.55);line-height:1.7;max-width:400px;}
    .btn-cta-p{padding:11px 26px;border-radius:999px;background:#111111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;border:none;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all 0.22s;box-shadow:0 8px 20px rgba(0,0,0,0.1);}
    .btn-cta-p:hover{background:#333;transform:translateY(-2px);}

    /* ── DETAIL MODAL ── */
    .modal-bg{position:fixed;inset:0;z-index:500;background:rgba(255,255,255,0.82);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);display:none;align-items:center;justify-content:center;padding:20px;}
    .modal-bg.open{display:flex;}
    .modal-box{background:#ffffff;border:1px solid rgba(0,100,255,0.08);border-radius:24px;max-width:720px;width:100%;overflow:hidden;position:relative;animation:riseUp 0.38s ease;box-shadow:0 30px 70px rgba(0,0,0,0.12);max-height:90vh;overflow-y:auto;}
    .modal-close{position:absolute;top:14px;left:14px;width:32px;height:32px;border-radius:50%;background:#fff;border:1px solid rgba(0,0,0,0.1);color:#111;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.2s;z-index:10;}
    .modal-close:hover{background:rgba(255,0,0,0.08);color:red;}

    /* ── FOOTER ── */
    .mkt-footer{margin-top:64px;border-top:1px solid rgba(0,0,0,0.07);padding:32px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;}
    .footer-brand{display:flex;align-items:center;gap:8px;text-decoration:none;color:#111;}
    .footer-brand span{font-size:12px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;}
    .footer-links{display:flex;gap:20px;flex-wrap:wrap;}
    .footer-links a{font-size:11px;color:rgba(0,0,0,0.45);text-decoration:none;transition:color 0.2s;}
    .footer-links a:hover{color:#0055ff;}
    .footer-copy{font-size:11px;color:rgba(0,0,0,0.3);}

    /* ── ANIMATIONS ── */
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.4;transform:scale(0.8)}}
    @keyframes riseUp{from{opacity:0;transform:translateY(22px);}to{opacity:1;transform:translateY(0);}}

    /* ── MOBILE ── */
    @media(max-width:1024px){.nav-center{display:none;}}
    @media(max-width:768px){.topnav{padding:0 14px;}.page{padding:70px 16px 40px;}.artist-cta{padding:28px 24px;}.mkt-hero{padding:32px 16px 28px;}}
    @media(max-width:560px){.nav-logo span{display:none;}}
  </style>
</head>
<body>

<!-- ══════════════════════════════════════════
     BACKGROUND (exact match index.html)
══════════════════════════════════════════ -->
<div class="bg-wrap">
  <video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video>
</div>
<div class="overlay"></div>
<div class="overlay2"></div>

<!-- ══════════════════════════════════════════
     TOP NAV (exact match index.html)
══════════════════════════════════════════ -->
<nav class="topnav" id="topnav" dir="rtl">

  <!-- LOGO -->
  <a class="nav-logo" href="index.html">
    <svg width="18" height="18" viewBox="0 0 256 256" fill="currentColor">
      <path d="M4.688 136C68.373 136 120 187.627 120 251.312C120 252.883 119.967 254.445 119.905 256L0 256L0 136.096C1.555 136.034 3.117 136 4.688 136ZM251.312 136C252.883 136 254.445 136.034 256 136.096L256 256L136.095 256C136.032 254.438 136.001 252.875 136 251.312C136 187.627 187.627 136 251.312 136ZM119.905 0C119.967 1.555 120 3.117 120 4.688C120 68.373 68.373 120 4.687 120C3.117 120 1.555 119.967 0 119.905L0 0ZM256 119.905C254.445 119.967 252.883 120 251.312 120C187.627 120 136 68.373 136 4.687C136 3.117 136.033 1.555 136.095 0L256 0Z"/>
    </svg>
    <span>RESHA ART</span>
  </a>

  <!-- CENTER DROPDOWN NAV -->
  <div class="nav-center" id="nav-center" dir="rtl">

    <!-- الاستوديو -->
    <div class="nav-item">
      <a href="studio.php">
        <span>الاستوديو</span>
        <svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg>
      </a>
      <div class="dropdown">
        <a href="studio.php#watercolor">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M12 2C8 2 4 6 4 10c0 5.25 8 12 8 12s8-6.75 8-12c0-4-4-8-8-8z"/></svg>
          <span>ورشة الألوان المائية</span>
        </a>
        <a href="studio.php#oil">
          <svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
          <span>استوديو الرسم الزيتي</span>
        </a>
        <a href="studio.php#digital">
          <svg class="d-icon" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
          <span>مختبر الفن الرقمي</span>
        </a>
        <a href="studio.php#charcoal">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
          <span>الفحم والحبر</span>
        </a>
      </div>
    </div>

    <!-- المجتمع -->
    <div class="nav-item">
      <a href="community.php">
        <span>المجتمع</span>
        <svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg>
      </a>
      <div class="dropdown">
        <a href="chat.php">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          <span>غرفة محادثة الفنانين</span>
        </a>
        <a href="community.php#meet">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <span>تعرّف على فنانين</span>
        </a>
        <a href="community.php#share">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
          <span>شارك أعمالك</span>
        </a>
        <a href="community.php#learn">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
          <span>تعلّم معاً</span>
        </a>
      </div>
    </div>

    <!-- السوق — active page -->
    <div class="nav-item active-page">
      <a href="marketplace.php"><span>السوق</span></a>
    </div>

    <!-- استكشف أساليب الرسم -->
    <div class="nav-item">
      <a href="explore.php"><span>استكشف أساليب الرسم</span></a>
    </div>

    <!-- الدعم -->
    <div class="nav-item">
      <a href="support.php">
        <span>الدعم</span>
        <svg class="chevron" viewBox="0 0 10 6"><polyline points="1,1 5,5 9,1"/></svg>
      </a>
      <div class="dropdown">
        <a href="mailto:contact@reshaart.com">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <span>تواصل معنا</span>
        </a>
        <a href="support.php#how">
          <svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          <span>كيف يعمل الموقع</span>
        </a>
        <a href="support.php#terms">
          <svg class="d-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <span>شروط الاستخدام</span>
        </a>
      </div>
    </div>

  </div>

  <!-- RIGHT BUTTONS -->
  <div class="nav-right" dir="rtl">
    <a class="nav-btn primary" href="chat.php">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
      <span>محادثة الفنانين</span>
    </a>
    <a class="nav-btn" href="login.php"><span>تسجيل الدخول</span></a>
    <a class="nav-btn" href="register.php"><span>انضم مجاناً</span></a>
    <button class="lang-btn" onclick="window.location.href='marketplace.php?lang=en'">English</button>
  </div>

</nav>


<!-- ══════════════════════════════════════════
     PAGE CONTENT
══════════════════════════════════════════ -->
<div class="page" id="pg" dir="rtl">

  <!-- ── HERO ── -->
  <div class="mkt-hero">
    <div class="hero-badge">
      <div class="pulse-dot"></div>
      <span>سوق الأعمال الفنية</span>
    </div>
    <h1>اكتشف الفن الذي <em>يلمس روحك</em></h1>
    <p>أعمال فنية أصيلة من فنانين موهوبين عبر العالم العربي — لوحات، بورتريهات، فن رقمي، ومزادات حية.</p>

    <!-- Search -->
    <div class="search-wrap">
      <div class="search-inner">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input id="search-input" type="text" placeholder="ابحث بالعنوان أو اسم الفنان…" oninput="applyFilters()" />
      </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-row">
      <?php
      $filters = [
        ['all',       'الكل',               '🖼️'],
        ['abstract',  'تجريدي',             '🎨'],
        ['portrait',  'بورتريه',            '👤'],
        ['landscape', 'مناظر طبيعية',       '🏔️'],
        ['digital',   'فن رقمي',            '💻'],
      ];
      foreach ($filters as [$val, $label, $icon]):
      ?>
      <button
        onclick="setFilter('<?= $val ?>')"
        data-filter="<?= $val ?>"
        class="ftab <?= $val === 'all' ? 'active' : '' ?>">
        <span><?= $icon ?></span> <?= $label ?>
      </button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ── SORT BAR ── -->
  <div class="sort-bar">
    <span class="results-count" id="results-count"><?= count($artworks) ?> عمل فني</span>
    <select id="sort-select" onchange="applyFilters()">
      <option value="default">الترتيب: مميز</option>
      <option value="price-asc">السعر: الأقل أولاً</option>
      <option value="price-desc">السعر: الأعلى أولاً</option>
      <option value="title">العنوان: أ–ي</option>
    </select>
  </div>

  <!-- ── ARTWORK GRID ── -->
  <div class="art-grid" id="artwork-grid">

    <?php foreach ($artworks as $aw):
      $badge_cls = match($aw['badge_type']) {
        'new'      => 'badge-new',
        'auction'  => 'badge-auction',
        'featured' => 'badge-featured',
        default    => '',
      };
      $dot_cls = $aw['status'] === 'auction' ? 'dot-auction' : 'dot-available';
      $placeholder = 'https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=600&q=80';
    ?>
    <div class="art-card"
         data-type="<?= htmlspecialchars($aw['art_type']) ?>"
         data-title="<?= htmlspecialchars($aw['title']) ?>"
         data-artist="<?= htmlspecialchars($aw['artist']) ?>"
         data-price="<?= $aw['price'] ?>"
         onclick="openDetail(<?= $aw['id'] ?>)">

      <div class="card-img-wrap">
        <img class="card-img"
             src="<?= htmlspecialchars($aw['image_url']) ?>"
             alt="<?= htmlspecialchars($aw['title']) ?>"
             onerror="this.src='<?= $placeholder ?>'" />

        <!-- Hover overlay -->
        <div class="card-hover-overlay">
          <span class="card-hover-label">عرض التفاصيل ←</span>
        </div>

        <!-- Badge -->
        <?php if ($aw['badge']): ?>
        <span class="card-badge <?= $badge_cls ?>"><?= htmlspecialchars($aw['badge']) ?></span>
        <?php endif; ?>

        <!-- Wishlist -->
        <button class="card-wish" onclick="event.stopPropagation(); toggleWish(this)" title="أضف للمفضلة">♡</button>
      </div>

      <div class="card-body">
        <span class="card-type-pill"><?= htmlspecialchars($aw['art_label']) ?></span>
        <div class="card-title"><?= htmlspecialchars($aw['title']) ?></div>
        <div class="card-artist">
          <div class="artist-avatar"><?= mb_substr($aw['artist'], 0, 1) ?></div>
          <div>
            <div class="artist-name"><?= htmlspecialchars($aw['artist']) ?></div>
            <div class="artist-loc"><?= htmlspecialchars($aw['location']) ?></div>
          </div>
        </div>
        <div class="card-footer">
          <div class="card-price-area">
            <div class="card-status">
              <span class="status-dot <?= $dot_cls ?>"></span>
              <?= htmlspecialchars($aw['status_label']) ?>
            </div>
            <div class="card-price">$<?= number_format($aw['price']) ?></div>
          </div>
          <button class="btn-details" onclick="event.stopPropagation(); openDetail(<?= $aw['id'] ?>)">
            التفاصيل
          </button>
        </div>
      </div>

    </div>
    <?php endforeach; ?>

  </div><!-- /art-grid -->

  <!-- Empty state -->
  <div id="empty-state">
    <div class="empty-icon">🔍</div>
    <div class="empty-title">لا توجد نتائج</div>
    <div class="empty-sub">جرّب بحثاً مختلفاً أو تصفية أخرى.</div>
    <button class="btn-reset" onclick="resetFilters()">إعادة تعيين الفلاتر</button>
  </div>

  <!-- ── ARTIST CTA BANNER ── -->
  <div class="artist-cta">
    <div class="cta-accent"></div>
    <div style="position:relative;z-index:1;">
      <div class="cta-title">هل أنت فنان؟</div>
      <div class="cta-sub">انضم إلى مئات الفنانين الذين يبيعون أعمالهم على ريشة فن. ارفع أعمالك، حدّد سعرك، وتواصل مع هواة الفن حول العالم.</div>
    </div>
    <a href="artist_dashboard.php" class="btn-cta-p">
      افتح الاستوديو الخاص بك
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>

  <!-- ── FOOTER ── -->
  <div class="mkt-footer">
    <a class="footer-brand" href="index.html">
      <svg width="16" height="16" viewBox="0 0 256 256" fill="#ff0055">
        <path d="M4.688 136C68.373 136 120 187.627 120 251.312C120 252.883 119.967 254.445 119.905 256L0 256L0 136.096C1.555 136.034 3.117 136 4.688 136ZM251.312 136C252.883 136 254.445 136.034 256 136.096L256 256L136.095 256C136.032 254.438 136.001 252.875 136 251.312C136 187.627 187.627 136 251.312 136ZM119.905 0C119.967 1.555 120 3.117 120 4.688C120 68.373 68.373 120 4.687 120C3.117 120 1.555 119.967 0 119.905L0 0ZM256 119.905C254.445 119.967 252.883 120 251.312 120C187.627 120 136 68.373 136 4.687C136 3.117 136.033 1.555 136.095 0L256 0Z"/>
      </svg>
      <span>RESHA ART</span>
    </a>
    <div class="footer-links">
      <a href="index.html">الرئيسية</a>
      <a href="studio.php">الاستوديو</a>
      <a href="community.php">المجتمع</a>
      <a href="explore.php">استكشاف</a>
      <a href="support.php">الدعم</a>
      <a href="mailto:contact@reshaart.com">تواصل معنا</a>
    </div>
    <div class="footer-copy">© <?= date('Y') ?> Resha Art · جميع الحقوق محفوظة</div>
  </div>

</div><!-- /page -->


<!-- ══════════════════════════════════════════
     DETAIL MODAL
══════════════════════════════════════════ -->
<div class="modal-bg" id="modal-bg">
  <div class="modal-box" id="modal-box">
    <button class="modal-close" onclick="closeDetail()">✕</button>
    <div id="modal-content"></div>
  </div>
</div>


<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
// ── Artwork data (mirrors PHP array) ────────
const ARTWORKS = <?= json_encode(array_values($artworks), JSON_UNESCAPED_UNICODE) ?>;

// ── Video background (exact from index.html) ─
const v = document.getElementById('vid');
if (v) {
  v.addEventListener('canplay', () => v.classList.add('on'), { once: true });
  v.play().catch(() => {});
}

// ── State ────────────────────────────────────
let currentFilter = 'all';
let currentSort   = 'default';

// ── Filter ───────────────────────────────────
function setFilter(type) {
  currentFilter = type;
  document.querySelectorAll('.ftab').forEach(b => {
    b.classList.toggle('active', b.dataset.filter === type);
  });
  applyFilters();
}

function applyFilters() {
  const search = document.getElementById('search-input').value.trim();
  currentSort  = document.getElementById('sort-select').value;

  const cards = Array.from(document.querySelectorAll('#artwork-grid .art-card'));

  let matched = cards.filter(c => {
    const typeOk   = currentFilter === 'all' || c.dataset.type === currentFilter;
    const searchOk = !search ||
      c.dataset.title.includes(search) ||
      c.dataset.artist.includes(search);
    return typeOk && searchOk;
  });

  matched.sort((a, b) => {
    if (currentSort === 'price-asc')  return +a.dataset.price - +b.dataset.price;
    if (currentSort === 'price-desc') return +b.dataset.price - +a.dataset.price;
    if (currentSort === 'title')      return a.dataset.title.localeCompare(b.dataset.title);
    return 0;
  });

  const grid = document.getElementById('artwork-grid');
  cards.forEach(c => c.style.display = 'none');
  matched.forEach(c => { c.style.display = ''; grid.appendChild(c); });

  const empty = document.getElementById('empty-state');
  empty.style.display = matched.length === 0 ? 'block' : 'none';

  const n = matched.length;
  document.getElementById('results-count').textContent = n + ' عمل فني';
}

function resetFilters() {
  setFilter('all');
  document.getElementById('search-input').value = '';
  document.getElementById('sort-select').value = 'default';
  applyFilters();
}

// ── Wishlist ─────────────────────────────────
function toggleWish(btn) {
  btn.classList.toggle('loved');
  btn.textContent = btn.classList.contains('loved') ? '♥' : '♡';
}

// ── Detail Modal ─────────────────────────────
function openDetail(id) {
  const aw = ARTWORKS.find(a => a.id === id);
  if (!aw) return;

  const isAuction = aw.status === 'auction';
  const dotCls    = isAuction ? '#ff0055' : '#00c853';
  const placeholder = 'https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=600&q=80';

  document.getElementById('modal-content').innerHTML = `
    <div style="display:grid;grid-template-columns:1fr 1fr;">
      <div style="aspect-ratio:1;overflow:hidden;background:#f0f0f0;border-radius:24px 0 0 24px;">
        <img src="${e(aw.image_url)}" alt="${e(aw.title)}"
          style="width:100%;height:100%;object-fit:cover;"
          onerror="this.src='${placeholder}'" />
      </div>
      <div style="padding:28px 28px 28px 28px;display:flex;flex-direction:column;justify-content:space-between;direction:rtl;">
        <div>
          <span style="font-size:9px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;padding:3px 10px;border-radius:999px;background:rgba(0,0,0,0.05);color:rgba(0,0,0,0.5);">${e(aw.art_label)}</span>
          <h2 style="font-size:20px;font-weight:700;color:#111;margin:10px 0 4px;">${e(aw.title)}</h2>
          <div style="font-size:11px;color:rgba(0,0,0,0.4);margin-bottom:4px;">${e(aw.title_en)}</div>
          <div style="display:flex;align-items:center;gap:8px;margin:12px 0;">
            <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#ff0055,#aa00ff);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;">${e(aw.artist.charAt ? aw.artist.charAt(0) : aw.artist[0])}</div>
            <div>
              <div style="font-size:13px;font-weight:600;color:#111;">${e(aw.artist)}</div>
              <div style="font-size:11px;color:rgba(0,0,0,0.4);">${e(aw.location)}</div>
            </div>
          </div>
          <p style="font-size:13px;color:rgba(0,0,0,0.6);line-height:1.8;margin-bottom:16px;">${e(aw.description)}</p>
          <div style="display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:600;padding:6px 14px;border-radius:999px;background:${isAuction ? 'rgba(255,0,85,0.08)' : 'rgba(0,200,83,0.08)'};color:${isAuction ? '#ff0055' : '#009624'};border:1px solid ${isAuction ? 'rgba(255,0,85,0.18)' : 'rgba(0,200,83,0.18)'};">
            <span style="width:6px;height:6px;border-radius:50%;background:${dotCls};display:inline-block;"></span>
            ${e(aw.status_label)}
          </div>
        </div>
        <div style="border-top:1px solid rgba(0,0,0,0.07);padding-top:20px;margin-top:20px;">
          <div style="font-size:10px;color:rgba(0,0,0,0.4);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px;">السعر</div>
          <div style="font-size:28px;font-weight:800;color:#111;letter-spacing:-0.02em;margin-bottom:16px;">$${Number(aw.price).toLocaleString()}</div>
          <div style="display:flex;gap:10px;">
            <button onclick="alert('🛒 قريباً — ميزة الشراء قيد التطوير')"
              style="flex:1;padding:11px;border-radius:999px;background:#111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;border:none;cursor:pointer;transition:background 0.2s;"
              onmouseover="this.style.background='#333'" onmouseout="this.style.background='#111'">
              ${isAuction ? '🔨 المزايدة' : '🛒 اشتر الآن'}
            </button>
            <button onclick="alert('💬 قريباً — ميزة المراسلة قيد التطوير')"
              style="padding:11px 18px;border-radius:999px;border:1px solid rgba(0,0,0,0.12);background:transparent;color:#111;font-size:11px;font-weight:600;cursor:pointer;white-space:nowrap;">
              تواصل مع الفنان
            </button>
          </div>
        </div>
      </div>
    </div>`;

  document.getElementById('modal-bg').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeDetail() {
  document.getElementById('modal-bg').classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('modal-bg').addEventListener('click', function(ev) {
  if (ev.target === this) closeDetail();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });

function e(str) {
  return String(str ?? '')
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>

</body>
</html>
