<?php
require_once 'config.php';

/* =====================================================================
 *  Oweili · admin_styles.php — manage the art_styles table.
 *  Shares the admin session set by admin.php ($_SESSION['is_admin']).
 * ===================================================================== */

/* ---- Logout (shared with admin.php) ---- */
if (isset($_GET['logout'])) {
    unset($_SESSION['is_admin']);
    header('Location: admin.php');
    exit;
}

$isAdmin = !empty($_SESSION['is_admin']);
if (!$isAdmin) {
    // Not authed here — send them to the admin login.
    header('Location: admin.php');
    exit;
}

$flash = '';
$tableMissing = false;

/* ---- CRUD actions (CSRF-checked) ---- */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['action'])) {
    if (!verifyCsrf($_POST['csrf_token'] ?? null)) { http_response_code(403); exit('Invalid CSRF token.'); }
    $action = $_POST['action'];

    $titleEn = sanitize($_POST['title_en'] ?? '');
    $titleAr = sanitize($_POST['title_ar'] ?? '');
    $descEn  = trim((string) ($_POST['description_en'] ?? ''));
    $descAr  = trim((string) ($_POST['description_ar'] ?? ''));
    $tag     = sanitize($_POST['tag'] ?? 'Traditional');
    $img     = sanitize($_POST['image_url'] ?? '');
    $id      = (int) ($_POST['id'] ?? 0);

    try {
        if ($action === 'add') {
            getDB()->prepare(
                'INSERT INTO art_styles (title_en,title_ar,description_en,description_ar,tag,image_url,sort_order)
                 VALUES (:te,:ta,:de,:da,:tag,:img,
                    (SELECT COALESCE(MAX(sort_order),0)+1 FROM (SELECT * FROM art_styles) x))'
            )->execute([':te'=>$titleEn, ':ta'=>$titleAr, ':de'=>$descEn, ':da'=>$descAr, ':tag'=>$tag, ':img'=>$img]);
            $flash = 'added';
        } elseif ($action === 'edit' && $id > 0) {
            getDB()->prepare(
                'UPDATE art_styles SET title_en=:te,title_ar=:ta,description_en=:de,description_ar=:da,tag=:tag,image_url=:img WHERE id=:id'
            )->execute([':te'=>$titleEn, ':ta'=>$titleAr, ':de'=>$descEn, ':da'=>$descAr, ':tag'=>$tag, ':img'=>$img, ':id'=>$id]);
            $flash = 'saved';
        } elseif ($action === 'delete' && $id > 0) {
            getDB()->prepare('DELETE FROM art_styles WHERE id=:id')->execute([':id'=>$id]);
            $flash = 'deleted';
        }
    } catch (\Throwable $e) {
        error_log('admin_styles: ' . $e->getMessage());
        $flash = 'error';
    }
    header('Location: admin_styles.php?ok=' . $flash);
    exit;
}

/* ---- Load styles ---- */
$styles = [];
try {
    $styles = getDB()->query('SELECT * FROM art_styles ORDER BY sort_order ASC, id ASC')->fetchAll();
} catch (\Throwable $e) {
    $tableMissing = true;
}
$okFlash = $_GET['ok'] ?? '';
$TAGS = ['Traditional', 'Digital', 'Mixed Media'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Styles · Oweili</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
body{min-height:100vh;background:#f4f5f7;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;color:#111111;padding:40px 20px;}
.wrap{max-width:1000px;margin:0 auto;}
h1{font-size:24px;font-weight:700;margin-bottom:4px;}
.sub{font-size:13px;color:rgba(0,0,0,0.5);margin-bottom:24px;}
.card{background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,0.05);padding:26px;margin-bottom:24px;}
label{display:block;font-size:11px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:rgba(0,0,0,0.5);margin-bottom:6px;}
input,textarea,select{width:100%;padding:11px 14px;border-radius:12px;border:1px solid rgba(0,0,0,0.15);font-size:14px;font-family:inherit;background:#fff;}
textarea{resize:vertical;min-height:64px;}
input:focus,textarea:focus,select:focus{outline:none;border-color:#0066ff;box-shadow:0 0 0 3px rgba(0,100,255,0.12);}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.field{margin-bottom:14px;}
.btn{padding:11px 22px;border-radius:999px;background:#111111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.22s;text-decoration:none;display:inline-block;}
.btn:hover{background:#ff0055;}
.btn.sm{padding:7px 14px;font-size:10px;}
.btn.green{background:#00a050;}.btn.green:hover{background:#0066ff;}
.btn.red{background:#ff0055;}.btn.red:hover{background:#111111;}
.btn.grey{background:rgba(0,0,0,0.08);color:#111111;}.btn.grey:hover{background:rgba(0,0,0,0.16);}
.lang-btn{padding:9px 16px;border-radius:999px;font-size:12px;font-weight:700;letter-spacing:0.04em;cursor:pointer;border:1px solid rgba(0,0,0,0.1);background:#fff;color:rgba(0,0,0,0.7);transition:all 0.2s;}
.lang-btn:hover{background:#111;color:#fff;}
.top{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap;}
.flash{padding:11px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:16px;}
.flash.ok{background:rgba(0,180,100,0.1);border:1px solid rgba(0,180,100,0.3);color:#00a050;}
.flash.err{background:rgba(255,0,85,0.08);border:1px solid rgba(255,0,85,0.25);color:#ff0055;}
.sec-head h2{font-size:16px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.count{background:#0066ff;color:#fff;font-size:11px;font-weight:700;padding:2px 9px;border-radius:999px;}
.style-item{display:flex;gap:16px;padding:14px;border:1px solid rgba(0,0,0,0.07);border-radius:14px;margin-bottom:12px;align-items:flex-start;}
.style-thumb{width:80px;height:80px;border-radius:10px;background-size:cover;background-position:center;background-color:#eee;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:24px;color:rgba(0,0,0,0.25);}
.style-body{flex:1;min-width:0;}
.style-body h3{font-size:15px;font-weight:700;margin-bottom:2px;}
.style-body .ar{font-size:12px;color:rgba(0,0,0,0.5);margin-bottom:4px;}
.style-body p{font-size:12px;color:rgba(0,0,0,0.6);line-height:1.6;margin-bottom:6px;}
.tag-pill{display:inline-block;padding:3px 10px;border-radius:999px;font-size:10px;font-weight:700;background:rgba(0,100,255,0.1);color:#0066ff;}
.row-actions{display:flex;flex-direction:column;gap:6px;flex-shrink:0;}
.edit-form{display:none;margin-top:12px;padding-top:12px;border-top:1px solid rgba(0,0,0,0.06);}
.edit-form.open{display:block;}
.empty{padding:30px;text-align:center;color:rgba(0,0,0,0.4);}
[dir="rtl"] body{direction:rtl;}
[dir="rtl"] .style-item,[dir="rtl"] .top{flex-direction:row-reverse;}
@media(max-width:640px){.grid2{grid-template-columns:1fr;}.style-item{flex-direction:column;}}
</style>
</head>
<body>
<div class="wrap">

  <div class="top">
    <div>
      <h1>Manage Art Styles</h1>
      <div class="sub">Add, edit, or remove the art styles shown on the Explore page.</div>
    </div>
    <div style="display:flex;gap:8px;align-items:center;">
      <button class="lang-btn" id="lb" onclick="tglLang()">العربية</button>
      <a class="btn grey" href="admin.php">Back to Admin</a>
      <a class="btn grey" href="admin_styles.php?logout=1">Log out</a>
    </div>
  </div>

  <?php if ($okFlash): ?>
    <div class="flash <?= $okFlash === 'error' ? 'err' : 'ok' ?>">
      <?php
        echo $okFlash === 'added' ? 'Style added.'
           : ($okFlash === 'saved' ? 'Style updated.'
           : ($okFlash === 'deleted' ? 'Style deleted.'
           : 'Something went wrong.'));
      ?>
    </div>
  <?php endif; ?>

  <?php if ($tableMissing): ?>
    <div class="card"><div class="flash err" style="margin:0;">The <code>art_styles</code> table does not exist yet. Run <code>styles_setup.sql</code> in phpMyAdmin first.</div></div>
  <?php else: ?>

  <!-- ADD NEW STYLE -->
  <div class="card">
    <div class="sec-head"><h2>Add New Style</h2></div>
    <form method="post" action="admin_styles.php">
      <?= csrfField() ?>
      <input type="hidden" name="action" value="add">
      <div class="grid2">
        <div class="field"><label>Title (English)</label><input type="text" name="title_en" required></div>
        <div class="field"><label>Title (Arabic)</label><input type="text" name="title_ar" dir="rtl"></div>
      </div>
      <div class="grid2">
        <div class="field"><label>Description (English)</label><textarea name="description_en"></textarea></div>
        <div class="field"><label>Description (Arabic)</label><textarea name="description_ar" dir="rtl"></textarea></div>
      </div>
      <div class="grid2">
        <div class="field"><label>Tag</label>
          <select name="tag"><?php foreach ($TAGS as $t): ?><option value="<?= e($t) ?>"><?= e($t) ?></option><?php endforeach; ?></select>
        </div>
        <div class="field"><label>Image URL</label><input type="text" name="image_url" dir="ltr" placeholder="https://…"></div>
      </div>
      <button type="submit" class="btn green">Add Style</button>
    </form>
  </div>

  <!-- STYLES LIST -->
  <div class="card">
    <div class="sec-head"><h2>Art Styles <span class="count"><?= count($styles) ?></span></h2></div>
    <?php if (!$styles): ?>
      <div class="empty">No styles yet. Add your first one above.</div>
    <?php else: ?>
      <?php foreach ($styles as $s): ?>
        <div class="style-item">
          <div class="style-thumb" <?= $s['image_url'] ? 'style="background-image:url(\'' . e($s['image_url']) . '\');"' : '' ?>><?= $s['image_url'] ? '' : '🎨' ?></div>
          <div class="style-body">
            <h3><?= e($s['title_en'] ?: '—') ?></h3>
            <?php if (!empty($s['title_ar'])): ?><div class="ar" dir="rtl"><?= e($s['title_ar']) ?></div><?php endif; ?>
            <?php if (!empty($s['description_en'])): ?><p><?= e($s['description_en']) ?></p><?php endif; ?>
            <span class="tag-pill"><?= e($s['tag']) ?></span>

            <!-- Inline edit form -->
            <div class="edit-form" id="edit-<?= (int)$s['id'] ?>">
              <form method="post" action="admin_styles.php">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
                <div class="grid2">
                  <div class="field"><label>Title (English)</label><input type="text" name="title_en" value="<?= e($s['title_en']) ?>" required></div>
                  <div class="field"><label>Title (Arabic)</label><input type="text" name="title_ar" dir="rtl" value="<?= e($s['title_ar']) ?>"></div>
                </div>
                <div class="grid2">
                  <div class="field"><label>Description (English)</label><textarea name="description_en"><?= e($s['description_en']) ?></textarea></div>
                  <div class="field"><label>Description (Arabic)</label><textarea name="description_ar" dir="rtl"><?= e($s['description_ar']) ?></textarea></div>
                </div>
                <div class="grid2">
                  <div class="field"><label>Tag</label>
                    <select name="tag"><?php foreach ($TAGS as $t): ?><option value="<?= e($t) ?>" <?= $s['tag']===$t?'selected':'' ?>><?= e($t) ?></option><?php endforeach; ?></select>
                  </div>
                  <div class="field"><label>Image URL</label><input type="text" name="image_url" dir="ltr" value="<?= e($s['image_url']) ?>"></div>
                </div>
                <button type="submit" class="btn green sm">Save Changes</button>
                <button type="button" class="btn grey sm" onclick="toggleEdit(<?= (int)$s['id'] ?>)">Cancel</button>
              </form>
            </div>
          </div>
          <div class="row-actions">
            <button type="button" class="btn grey sm" onclick="toggleEdit(<?= (int)$s['id'] ?>)">Edit</button>
            <form method="post" action="admin_styles.php" onsubmit="return confirm('Delete this style?');" style="margin:0;">
              <?= csrfField() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
              <button type="submit" class="btn red sm">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <?php endif; ?>
</div>

<script>
function toggleEdit(id){
  var el=document.getElementById('edit-'+id);
  if(el) el.classList.toggle('open');
}

/* Bilingual — same approach as admin.php: swap known EN strings to AR. */
const ADICT = {
  "Manage Art Styles":"إدارة أساليب الرسم",
  "Add, edit, or remove the art styles shown on the Explore page.":"أضف أو عدّل أو احذف الأساليب الظاهرة في صفحة الاستكشاف.",
  "Back to Admin":"العودة للإدارة","Log out":"تسجيل الخروج",
  "Add New Style":"إضافة أسلوب جديد","Art Styles":"أساليب الرسم",
  "Title (English)":"العنوان (بالإنجليزية)","Title (Arabic)":"العنوان (بالعربية)",
  "Description (English)":"الوصف (بالإنجليزية)","Description (Arabic)":"الوصف (بالعربية)",
  "Tag":"التصنيف","Image URL":"رابط الصورة","Add Style":"إضافة الأسلوب",
  "Edit":"تعديل","Delete":"حذف","Save Changes":"حفظ التغييرات","Cancel":"إلغاء",
  "No styles yet. Add your first one above.":"لا توجد أساليب بعد. أضف أول أسلوب بالأعلى.",
  "Style added.":"تمت إضافة الأسلوب.","Style updated.":"تم تحديث الأسلوب.","Style deleted.":"تم حذف الأسلوب.",
  "Something went wrong.":"حدث خطأ ما.",
  "Traditional":"تقليدي","Digital":"رقمي","Mixed Media":"وسائط مختلطة"
};
const AREV = {}; Object.keys(ADICT).forEach(k=>AREV[ADICT[k]]=k);
let AL='en';
function walkTranslate(root, toAr){
  const map = toAr ? ADICT : AREV;
  const w=document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
  const nodes=[]; while(w.nextNode()) nodes.push(w.currentNode);
  nodes.forEach(n=>{ const k=n.nodeValue.trim(); if(k && map[k]!==undefined) n.nodeValue=n.nodeValue.replace(k, map[k]); });
  // translate option labels + placeholders too
  root.querySelectorAll('option').forEach(o=>{ const k=o.textContent.trim(); const m=(toAr?ADICT:AREV); if(m[k]!==undefined)o.textContent=m[k]; });
}
function applyLang(l){
  const toAr=l==='ar';
  document.documentElement.setAttribute('dir', toAr?'rtl':'ltr');
  document.documentElement.lang=l;
  if(l!==AL){ walkTranslate(document.body, toAr); AL=l; }
  const lb=document.getElementById('lb'); if(lb) lb.textContent = toAr ? 'English':'العربية';
}
function tglLang(){ const next=AL==='en'?'ar':'en'; try{localStorage.setItem('lang',next);}catch(e){} applyLang(next); }
try{var _s=localStorage.getItem('lang'); if(_s==='ar') applyLang('ar');}catch(e){}
</script>
</body>
</html>
