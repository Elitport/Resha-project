<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr" id="html">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Explore Art Styles · Resha Art</title>
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
.page-badge{display:inline-flex;align-items:center;gap:8px;padding:5px 14px;border-radius:999px;margin-bottom:14px;background:rgba(170,0,255,0.06);border:1px solid rgba(170,0,255,0.15);font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#aa00ff;}
.pulse-dot{width:6px;height:6px;border-radius:50%;background:#aa00ff;box-shadow:0 0 8px rgba(170,0,255,0.5);animation:pulse 2s infinite;}
.page-header h1{font-size:clamp(28px,4vw,48px);font-weight:300;color:#111;margin-bottom:12px;letter-spacing:-0.02em;}
.page-header h1 em{font-style:normal;font-weight:700;background:linear-gradient(90deg,#ff0055,#0066ff,#aa00ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.page-header p{font-size:15px;color:rgba(0,0,0,0.6);line-height:1.8;max-width:580px;}
[dir="rtl"] .page-header p{text-align:right;}

.filter-bar{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:26px;}
[dir="rtl"] .filter-bar{flex-direction:row-reverse;}
.filter-btn{padding:8px 20px;border-radius:999px;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.6);backdrop-filter:blur(8px);color:rgba(0,0,0,0.7);transition:all 0.22s;}
.filter-btn:hover{background:rgba(255,255,255,0.9);color:#111;}
.filter-btn.active{background:#111111;color:#fff;border-color:#111111;}

.styles-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:22px;}
.style-card{background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.07);border-radius:20px;overflow:hidden;backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);cursor:pointer;transition:transform 0.3s ease,box-shadow 0.3s ease;display:flex;flex-direction:column;}
.style-card:hover{transform:translateY(-4px);box-shadow:0 20px 40px rgba(0,0,0,0.08);}
.style-img{height:190px;background-size:cover;background-position:center;transition:transform 0.5s ease;}
.style-card:hover .style-img{transform:scale(1.05);}
.style-body{padding:18px;display:flex;flex-direction:column;gap:5px;flex:1;}
[dir="rtl"] .style-body{text-align:right;}
.style-tag{display:inline-block;align-self:flex-start;padding:3px 10px;border-radius:999px;font-size:9px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;background:rgba(0,100,255,0.08);color:#0066ff;border:1px solid rgba(0,100,255,0.15);margin-bottom:4px;}
[dir="rtl"] .style-tag{align-self:flex-end;}
.style-title{font-size:17px;font-weight:700;color:#111;}
.style-sub{font-size:12px;color:rgba(0,0,0,0.55);}
.style-desc{font-size:12px;color:rgba(0,0,0,0.6);line-height:1.6;margin-top:6px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
.style-more{margin-top:12px;font-size:11px;font-weight:700;color:#ff0055;letter-spacing:0.06em;text-transform:uppercase;}

.empty{padding:44px;text-align:center;color:rgba(0,0,0,0.5);background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.07);border-radius:20px;backdrop-filter:blur(16px);}

/* MODAL */
.modal-bg{position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,0.5);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;padding:20px;}
.modal-bg.open{display:flex;}
.modal{background:rgba(255,255,255,0.97);backdrop-filter:blur(20px);border:1px solid rgba(0,0,0,0.08);border-radius:20px;max-width:560px;width:100%;overflow:hidden;box-shadow:0 30px 70px rgba(0,0,0,0.25);max-height:90vh;overflow-y:auto;}
.modal img{width:100%;height:260px;object-fit:cover;}
.modal-body{padding:26px;}
[dir="rtl"] .modal-body{text-align:right;}
.modal-body .m-tag{display:inline-block;padding:3px 10px;border-radius:999px;font-size:10px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;background:rgba(170,0,255,0.08);color:#aa00ff;margin-bottom:10px;}
.modal-body h2{font-size:22px;font-weight:700;color:#111;margin-bottom:2px;}
.modal-body .m-sub{font-size:14px;color:rgba(0,0,0,0.55);margin-bottom:12px;}
.modal-body p{font-size:13px;color:rgba(0,0,0,0.7);line-height:1.8;margin-bottom:16px;}
.m-tools{display:flex;flex-wrap:wrap;gap:8px;}
[dir="rtl"] .m-tools{flex-direction:row-reverse;}
.m-tool{padding:5px 12px;border-radius:8px;background:rgba(0,0,0,0.05);border:1px solid rgba(0,0,0,0.07);font-size:11px;color:rgba(0,0,0,0.7);}
.modal-close{float:right;background:none;border:none;font-size:24px;cursor:pointer;color:rgba(0,0,0,0.4);line-height:1;}
[dir="rtl"] .modal-close{float:left;}

@keyframes pulse{0%,100%{opacity:1}50%{opacity:0.4}}
@media(max-width:768px){.topnav{padding:10px 14px;}.nav-logo span{display:none;}.page{padding:90px 16px 32px;}}
</style>
</head>
<body>
<div class="bg-wrap"><video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video></div>
<div class="overlay"></div>

<?php include __DIR__ . "/nav.php"; ?>

<div class="page" id="pg">
  <div class="page-header">
    <div class="page-badge"><div class="pulse-dot"></div><span id="t-badge">12 Art Styles</span></div>
    <h1 id="t-h1">Explore <em>Art Styles</em></h1>
    <p id="t-desc">Discover the twelve creative disciplines at the heart of Resha Art — from timeless traditional media to cutting-edge digital forms.</p>
  </div>

  <div class="filter-bar" id="filterBar"></div>
  <div class="styles-grid" id="stylesGrid"></div>
  <div class="empty" id="emptyState" style="display:none;"></div>
</div>

<!-- DETAIL MODAL -->
<div class="modal-bg" id="modalBg" onclick="if(event.target===this)closeModal()">
  <div class="modal">
    <div class="modal-body">
      <button class="modal-close" onclick="closeModal()">&times;</button>
      <img id="m-img" src="" alt="">
      <span class="m-tag" id="m-tag"></span>
      <h2 id="m-title"></h2>
      <div class="m-sub" id="m-sub"></div>
      <p id="m-desc"></p>
      <div class="m-tools" id="m-tools"></div>
    </div>
  </div>
</div>

<!-- Single source of truth for the 12 styles -->
<script src="/art_styles.js"></script>
<script>
/* ---- Resolve the styles data exposed by art_styles.js (no duplication) ---- */
function getStyleData(){
  const cands = ['artStyles','ART_STYLES','STYLES','styles','artStylesData','RESHA_STYLES','art_styles','ARTSTYLES'];
  for(const k of cands){ if(typeof window[k] !== 'undefined' && window[k]) return window[k]; }
  return null;
}
/* Return the styles array for a given language, whatever shape the file uses. */
function stylesFor(lang){
  const d = getStyleData();
  if(!d) return [];
  if(Array.isArray(d)) return d;          // flat array
  if(d[lang]) return d[lang];             // { en:[...], ar:[...] }
  if(d.en)    return d.en;                // fallback
  return [];
}

const TAGLABEL = {
  en:{all:'All', Traditional:'Traditional', Digital:'Digital', 'Mixed Media':'Mixed Media'},
  ar:{all:'الكل', Traditional:'تقليدي', Digital:'رقمي', 'Mixed Media':'وسائط مختلطة'}
};
const UI = {
  en:{badge:'12 Art Styles', h1:'Explore <em>Art Styles</em>',
      desc:'Discover the twelve creative disciplines at the heart of Resha Art — from timeless traditional media to cutting-edge digital forms.',
      more:'View details →', empty:'No styles found.', tools:'Tools & Materials'},
  ar:{badge:'١٢ أسلوب فني', h1:'استكشف <em>أساليب الرسم</em>',
      desc:'اكتشف الأساليب الإبداعية الاثني عشر في قلب ريشة آرت — من الوسائط التقليدية الخالدة إلى الأشكال الرقمية الحديثة.',
      more:'عرض التفاصيل ←', empty:'لم يتم العثور على أساليب.', tools:'الأدوات والخامات'}
};

let L = 'en';
let curFilter = 'all';

function tagLabel(tag){ return (TAGLABEL[L] && TAGLABEL[L][tag]) ? TAGLABEL[L][tag] : tag; }

function buildFilters(){
  const list = stylesFor(L);
  const tags = ['all', ...Array.from(new Set(list.map(s => s.tag).filter(Boolean)))];
  const bar = document.getElementById('filterBar');
  bar.innerHTML = tags.map(t =>
    '<button class="filter-btn'+(t===curFilter?' active':'')+'" data-tag="'+String(t).replace(/"/g,'')+'" '+
    'onclick="setFilter(this.dataset.tag,this)">'+tagLabel(t)+'</button>'
  ).join('');
}

function esc(s){ const d=document.createElement('div'); d.textContent=String(s==null?'':s); return d.innerHTML; }

function buildGrid(){
  const list = stylesFor(L).filter(s => curFilter==='all' || s.tag===curFilter);
  const grid = document.getElementById('stylesGrid');
  const empty = document.getElementById('emptyState');
  if(!list.length){
    grid.innerHTML=''; empty.style.display='block'; empty.textContent = UI[L].empty;
    return;
  }
  empty.style.display='none';
  grid.innerHTML = list.map((s, i) =>
    '<div class="style-card" onclick="openModal('+i+')">'+
      '<div class="style-img" style="background-image:url(\''+esc(s.img)+'\')"></div>'+
      '<div class="style-body">'+
        (s.tag?'<span class="style-tag">'+esc(tagLabel(s.tag))+'</span>':'')+
        '<div class="style-title">'+esc(s.title)+'</div>'+
        (s.sub?'<div class="style-sub">'+esc(s.sub)+'</div>':'')+
        (s.desc?'<div class="style-desc">'+esc(s.desc)+'</div>':'')+
        '<div class="style-more">'+UI[L].more+'</div>'+
      '</div>'+
    '</div>'
  ).join('');
  // stash current filtered list for the modal
  window.__filtered = list;
}

function setFilter(tag, btn){
  curFilter = tag;
  document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
  if(btn) btn.classList.add('active');
  buildGrid();
}

function openModal(i){
  const s = (window.__filtered||[])[i];
  if(!s) return;
  document.getElementById('m-img').src = s.img || '';
  document.getElementById('m-tag').textContent = s.tag ? tagLabel(s.tag) : '';
  document.getElementById('m-title').textContent = s.title || '';
  document.getElementById('m-sub').textContent = s.sub || '';
  document.getElementById('m-desc').textContent = s.desc || '';
  const tools = Array.isArray(s.tools) ? s.tools : [];
  document.getElementById('m-tools').innerHTML = tools.map(t=>'<span class="m-tool">'+esc(t)+'</span>').join('');
  document.getElementById('modalBg').classList.add('open');
}
function closeModal(){ document.getElementById('modalBg').classList.remove('open'); }
document.addEventListener('keydown', e=>{ if(e.key==='Escape') closeModal(); });

/* ---- Bilingual nav + page labels ---- */
const NAV={
  en:{lb:'العربية',studio:'The Studio',community:'Community',marketplace:'Marketplace',explore:'Explore Art Styles',support:'Support',
    s1:'Watercolor Workshop',s2:'Oil Painting Studio',s3:'Digital Art Lab',s4:'Charcoal & Ink',
    c1:'Artist Chat Room',c2:'Meet Fellow Artists',c3:'Share Your Work',c4:'Learn Together',
    sp1:'Contact Us',sp2:'How It Works',sp3:'Terms of Use',chat:'Artist Chat',login:'Sign In',reg:'Join Free'},
  ar:{lb:'English',studio:'الاستوديو',community:'المجتمع',marketplace:'السوق',explore:'استكشف أساليب الرسم',support:'الدعم',
    s1:'ورشة الألوان المائية',s2:'استوديو الرسم الزيتي',s3:'مختبر الفن الرقمي',s4:'الفحم والحبر',
    c1:'غرفة محادثة الفنانين',c2:'تعرّف على فنانين',c3:'شارك أعمالك',c4:'تعلّم معاً',
    sp1:'تواصل معنا',sp2:'كيف يعمل الموقع',sp3:'شروط الاستخدام',chat:'محادثة الفنانين',login:'تسجيل الدخول',reg:'انضم مجاناً'}
};
function setTxt(id,v){const el=document.getElementById(id);if(el)el.textContent=v;}
function apply(l){
  L=l;
  const n=NAV[l];
  document.getElementById('html').lang=l;
  document.getElementById('html').setAttribute('dir', l==='ar'?'rtl':'ltr');
  document.documentElement.setAttribute('dir', l==='ar'?'rtl':'ltr');
  document.getElementById('topnav').setAttribute('dir', l==='ar'?'rtl':'ltr');
  document.getElementById('lb').textContent=n.lb;
  setTxt('nav-studio-label',n.studio);setTxt('nav-community-label',n.community);
  setTxt('nav-marketplace-label',n.marketplace);setTxt('nav-explore-label',n.explore);setTxt('nav-support-label',n.support);
  setTxt('dd-s1',n.s1);setTxt('dd-s2',n.s2);setTxt('dd-s3',n.s3);setTxt('dd-s4',n.s4);
  setTxt('dd-c1',n.c1);setTxt('dd-c2',n.c2);setTxt('dd-c3',n.c3);setTxt('dd-c4',n.c4);
  setTxt('dd-sp1',n.sp1);setTxt('dd-sp2',n.sp2);setTxt('dd-sp3',n.sp3);
  setTxt('n-chat-t',n.chat);setTxt('n-login-t',n.login);setTxt('n-reg-t',n.reg);
  document.getElementById('t-badge').textContent=UI[l].badge;
  document.getElementById('t-h1').innerHTML=UI[l].h1;
  document.getElementById('t-desc').textContent=UI[l].desc;
  buildFilters();
  buildGrid();
}
function tgl(){ apply(L==='en'?'ar':'en'); }
apply('en');

const v=document.getElementById('vid');
if(v){v.addEventListener('canplay',()=>v.classList.add('on'),{once:true});v.play().catch(()=>{});}
</script>
</body>
</html>
