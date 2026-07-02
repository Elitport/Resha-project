<?php
require_once 'config.php';

/* =====================================================================
 *  Server-side contact-info filter (Task 5) — cannot be bypassed.
 * ===================================================================== */
function containsContactInfo(string $text): bool {
    $t = mb_strtolower($text, 'UTF-8');

    // Email: word@word.word
    if (preg_match('/[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}/iu', $text)) return true;

    // Phone: 7+ digits, ignoring spaces/dashes/dots/parens/plus
    $compact = preg_replace('/[\s\-\.\(\)\+]+/u', '', $text);
    if (preg_match('/\d{7,}/u', (string) $compact)) return true;

    // @username handle
    if (preg_match('/@[a-z0-9_\.]{2,}/iu', $text)) return true;

    // Social links / keywords (EN + AR)
    $bad = [
        'instagram.com', 'wa.me', 'whatsapp', 'whats app', 't.me', 'telegram',
        'twitter.com', 'x.com/', 'facebook.com', 'fb.com', 'snapchat', 'snap:',
        'tiktok.com', 'dm me', 'inbox me',
        'راسلني', 'واتساب', 'واتس', 'رقمي', 'جوالي', 'تواصل معي', 'تيليجرام',
    ];
    foreach ($bad as $b) {
        if (mb_strpos($t, $b) !== false) return true;
    }
    return false;
}

/* =====================================================================
 *  JSON API (fetch / send). Re-validates auth + approved-artist role
 *  on EVERY request (Task 6), independent of page load.
 * ===================================================================== */
$action = $_GET['action'] ?? ($_POST['action'] ?? '');
if ($action === 'fetch' || $action === 'send') {
    header('Content-Type: application/json; charset=utf-8');

    // Re-validate session + role + approval every time.
    if (!isLoggedIn()) { echo json_encode(['ok' => false, 'error' => 'auth']); exit; }
    $me = currentUser();
    if (!$me || $me['role'] !== 'artist' || (int) $me['is_approved'] !== 1) {
        echo json_encode(['ok' => false, 'error' => 'forbidden']); exit;
    }
    $meId = (int) $me['id'];

    // Validate room.
    $roomId = (int) ($_REQUEST['room_id'] ?? 0);
    $rs = getDB()->prepare('SELECT id FROM chat_rooms WHERE id = :id LIMIT 1');
    $rs->execute([':id' => $roomId]);
    if (!$rs->fetchColumn()) { echo json_encode(['ok' => false, 'error' => 'room']); exit; }

    if ($action === 'send') {
        if (!verifyCsrf($_POST['csrf_token'] ?? null)) {
            echo json_encode(['ok' => false, 'error' => 'csrf']); exit;
        }
        $text = trim((string) ($_POST['message'] ?? ''));
        if ($text === '') { echo json_encode(['ok' => false, 'error' => 'empty']); exit; }
        if (mb_strlen($text, 'UTF-8') > 1000) { echo json_encode(['ok' => false, 'error' => 'toolong']); exit; }

        // Rate limit: 1 message / 3 seconds per user.
        $rl = getDB()->prepare('SELECT created_at FROM messages WHERE sender_id = :u ORDER BY id DESC LIMIT 1');
        $rl->execute([':u' => $meId]);
        $last = $rl->fetchColumn();
        if ($last && (time() - strtotime($last)) < 3) {
            echo json_encode(['ok' => false, 'error' => 'rate']); exit;
        }

        // Contact-info block (server side).
        if (containsContactInfo($text)) {
            echo json_encode(['ok' => false, 'error' => 'contact']); exit;
        }

        $ins = getDB()->prepare(
            'INSERT INTO messages (sender_id, room_id, message_text) VALUES (:u, :r, :t)'
        );
        $ins->execute([':u' => $meId, ':r' => $roomId, ':t' => $text]);
        echo json_encode(['ok' => true]); exit;
    }

    // action === 'fetch'
    $stmt = getDB()->prepare(
        'SELECT m.id, m.sender_id, m.message_text, m.created_at,
                u.full_name_en, u.full_name_ar, u.profile_picture
         FROM messages m
         JOIN users u ON u.id = m.sender_id
         WHERE m.room_id = :r
         ORDER BY m.id DESC
         LIMIT 80'
    );
    $stmt->execute([':r' => $roomId]);
    $rows = array_reverse($stmt->fetchAll());

    $out = [];
    foreach ($rows as $r) {
        $nameEn = $r['full_name_en'] !== '' ? $r['full_name_en'] : 'Artist';
        $out[] = [
            'id'      => (int) $r['id'],
            'mine'    => ((int) $r['sender_id'] === $meId),
            'name_en' => e($nameEn),
            'name_ar' => e($r['full_name_ar'] !== '' ? $r['full_name_ar'] : $nameEn),
            'pic'     => e($r['profile_picture'] ?? ''),
            'initial' => e(mb_strtoupper(mb_substr($nameEn, 0, 1, 'UTF-8'), 'UTF-8')),
            'text'    => e($r['message_text']),                 // escaped before display
            'time'    => date('H:i', strtotime($r['created_at'])),
        ];
    }
    echo json_encode(['ok' => true, 'me' => $meId, 'messages' => $out], JSON_UNESCAPED_UNICODE);
    exit;
}

/* =====================================================================
 *  PAGE — access control (Task 2)
 * ===================================================================== */
if (!isLoggedIn()) { header('Location: login.php'); exit; }
$me       = currentUser();
$role     = $me['role'] ?? '';
$approved = (int) ($me['is_approved'] ?? 0) === 1;
$access   = ($role === 'artist' && $approved) ? 'ok' : ($role === 'artist' ? 'pending' : 'notartist');

$lang = isset($_GET['lang']) && $_GET['lang'] === 'ar' ? 'ar' : 'en';
$ar   = $lang === 'ar';

$rooms = [];
if ($access === 'ok') {
    $rooms = getDB()->query('SELECT * FROM chat_rooms ORDER BY sort_order ASC')->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $ar ? 'rtl' : 'ltr' ?>" id="html">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $ar ? 'غرف دردشة الفنانين' : 'Artist Chat Rooms' ?> · Resha Art</title>
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

.wrap{position:relative;z-index:10;width:100%;max-width:1180px;margin:0 auto;padding:80px 20px 24px;}

/* ACCESS-DENIED CARD */
.gate{max-width:520px;margin:40px auto;padding:40px 32px;text-align:center;background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(0,0,0,0.07);border-radius:20px;box-shadow:0 20px 50px rgba(0,0,0,0.1);}
.gate .ic{font-size:44px;margin-bottom:14px;}
.gate h2{font-size:22px;font-weight:700;color:#111111;margin-bottom:10px;}
.gate p{font-size:14px;color:rgba(0,0,0,0.6);line-height:1.7;margin-bottom:22px;}
.gate a{display:inline-block;padding:12px 26px;border-radius:999px;background:#111111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;text-decoration:none;transition:all 0.25s;}
.gate a:hover{background:#ff0055;transform:translateY(-2px);}

/* CHAT LAYOUT */
.chat{display:grid;grid-template-columns:260px 1fr;gap:18px;height:calc(100vh - 110px);min-height:480px;}
[dir="rtl"] .chat{direction:rtl;}
.glass{background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(0,0,0,0.07);border-radius:20px;}
.rooms{padding:14px;overflow-y:auto;}
.rooms h3{font-size:11px;text-transform:uppercase;letter-spacing:0.12em;color:rgba(0,0,0,0.4);font-weight:700;margin:6px 8px 12px;}
.room{display:flex;align-items:center;gap:10px;padding:11px 12px;border-radius:12px;cursor:pointer;transition:background 0.18s;margin-bottom:4px;}
[dir="rtl"] .room{flex-direction:row-reverse;text-align:right;}
.room:hover{background:rgba(0,100,255,0.07);}
.room.active{background:#111111;}
.room.active .room-name,.room.active .room-ic{color:#fff;}
.room-ic{font-size:18px;flex-shrink:0;}
.room-name{font-size:13px;font-weight:600;color:#111111;}

.panel{display:flex;flex-direction:column;overflow:hidden;}
.panel-head{padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.06);display:flex;align-items:center;gap:10px;}
[dir="rtl"] .panel-head{flex-direction:row-reverse;}
.panel-head .ic{font-size:20px;}
.panel-head h2{font-size:16px;font-weight:700;color:#111111;}
.messages{flex:1;overflow-y:auto;padding:18px 20px;display:flex;flex-direction:column;gap:12px;}
.msg{display:flex;gap:10px;max-width:78%;}
[dir="rtl"] .msg{flex-direction:row-reverse;}
.msg.mine{align-self:flex-end;flex-direction:row-reverse;}
[dir="rtl"] .msg.mine{flex-direction:row;}
.msg .av{width:34px;height:34px;border-radius:50%;flex-shrink:0;object-fit:cover;background:linear-gradient(135deg,#ff0055,#0066ff,#aa00ff);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;}
.bubble{background:rgba(255,255,255,0.85);border:1px solid rgba(0,0,0,0.06);border-radius:16px;padding:9px 13px;}
.msg.mine .bubble{background:rgba(0,100,255,0.1);border-color:rgba(0,100,255,0.18);}
.bubble .who{font-size:11px;font-weight:700;color:#0066ff;margin-bottom:3px;}
.msg.mine .bubble .who{color:#aa00ff;}
.bubble .txt{font-size:13px;color:#111111;line-height:1.55;word-break:break-word;}
.bubble .tm{font-size:9px;color:rgba(0,0,0,0.4);margin-top:4px;text-align:right;}
[dir="rtl"] .bubble .tm{text-align:left;}
.empty-chat{margin:auto;color:rgba(0,0,0,0.4);font-size:13px;}

.composer{padding:14px 18px;border-top:1px solid rgba(0,0,0,0.06);}
.composer form{display:flex;gap:10px;align-items:center;}
[dir="rtl"] .composer form{flex-direction:row-reverse;}
.composer input[type=text]{flex:1;padding:12px 16px;border-radius:999px;border:1px solid rgba(0,0,0,0.12);background:rgba(255,255,255,0.8);font-size:14px;font-family:inherit;color:#111111;}
.composer input:focus{outline:none;border-color:#0066ff;box-shadow:0 0 0 3px rgba(0,100,255,0.12);}
.composer button{padding:12px 24px;border-radius:999px;background:#111111;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;border:none;cursor:pointer;transition:all 0.25s;}
.composer button:hover{background:#ff0055;transform:translateY(-2px);}
.send-error{font-size:12px;color:#ff0055;font-weight:600;margin-top:8px;min-height:16px;}

@media(max-width:768px){
  .topnav{padding:10px 14px;}.nav-logo span{display:none;}
  .chat{grid-template-columns:1fr;height:auto;}
  .rooms{display:flex;overflow-x:auto;gap:8px;}
  .rooms h3{display:none;}
  .room{flex-direction:column;gap:4px;min-width:84px;text-align:center;}
  [dir="rtl"] .room{flex-direction:column;}
  .room-name{font-size:11px;}
  .panel{height:70vh;}
}
</style>
</head>
<body>
<div class="bg-wrap"><video class="bg-video" id="vid" autoplay loop muted playsinline src="bg.mp4"></video></div>
<div class="overlay"></div>

<!-- NAV (shared brand navbar) -->
<?php include __DIR__ . "/nav.php"; ?>

<div class="wrap">
<?php if ($access !== 'ok'): ?>

  <div class="gate">
    <?php if ($access === 'notartist'): ?>
      <div class="ic">🔒</div>
      <h2 id="g-title" data-en="Artists only" data-ar="للفنانين فقط"><?= $ar?'للفنانين فقط':'Artists only' ?></h2>
      <p id="g-msg"
         data-en="This chat room is only available to verified artists."
         data-ar="غرفة الدردشة هذه متاحة فقط للفنانين الموثقين."><?= $ar?'غرفة الدردشة هذه متاحة فقط للفنانين الموثقين.':'This chat room is only available to verified artists.' ?></p>
    <?php else: /* pending */ ?>
      <div class="ic">⏳</div>
      <h2 id="g-title" data-en="Pending approval" data-ar="قيد المراجعة"><?= $ar?'قيد المراجعة':'Pending approval' ?></h2>
      <p id="g-msg"
         data-en="Your artist account is pending approval."
         data-ar="حسابك كفنان قيد المراجعة."><?= $ar?'حسابك كفنان قيد المراجعة.':'Your artist account is pending approval.' ?></p>
    <?php endif; ?>
    <a href="index.html" id="g-btn" data-en="Back to Home" data-ar="العودة للرئيسية"><?= $ar?'العودة للرئيسية':'Back to Home' ?></a>
  </div>

<?php else: ?>

  <div class="chat">
    <!-- ROOMS SIDEBAR -->
    <aside class="glass rooms" id="roomsBar">
      <h3 id="rooms-title"><?= $ar?'غرف دردشة الفنانين':'Artist Chat Rooms' ?></h3>
      <?php foreach ($rooms as $i => $room): ?>
        <div class="room <?= $i === 0 ? 'active' : '' ?>" data-id="<?= (int) $room['id'] ?>"
             data-en="<?= e($room['name_en']) ?>" data-ar="<?= e($room['name_ar']) ?>"
             onclick="selectRoom(<?= (int) $room['id'] ?>, this)">
          <span class="room-ic"><?= e($room['icon']) ?></span>
          <span class="room-name"><?= e($ar ? $room['name_ar'] : $room['name_en']) ?></span>
        </div>
      <?php endforeach; ?>
    </aside>

    <!-- MESSAGE PANEL -->
    <section class="glass panel">
      <div class="panel-head">
        <span class="ic" id="panelIcon"><?= e($rooms[0]['icon'] ?? '💬') ?></span>
        <h2 id="panelTitle"
            data-en="<?= e($rooms[0]['name_en'] ?? '') ?>"
            data-ar="<?= e($rooms[0]['name_ar'] ?? '') ?>"><?= e($ar ? ($rooms[0]['name_ar'] ?? '') : ($rooms[0]['name_en'] ?? '')) ?></h2>
      </div>
      <div class="messages" id="messages"></div>
      <div class="composer">
        <form id="sendForm" onsubmit="return sendMessage(event)">
          <input type="text" id="msgInput" maxlength="1000"
                 placeholder="<?= $ar?'اكتب رسالتك':'Type your message' ?>" autocomplete="off">
          <button type="submit" id="sendBtn"><?= $ar?'إرسال':'Send' ?></button>
        </form>
        <div class="send-error" id="sendError"></div>
      </div>
    </section>
  </div>

<?php endif; ?>
</div>

<script>
const L0 = <?= json_encode($lang) ?>;
let L = L0;
<?php if ($access === 'ok'): ?>
const CSRF = <?= json_encode(csrfToken()) ?>;
const ROOMS = <?= json_encode(array_map(fn($r) => [
    'id' => (int) $r['id'], 'icon' => $r['icon'],
    'name_en' => $r['name_en'], 'name_ar' => $r['name_ar'],
], $rooms), JSON_UNESCAPED_UNICODE) ?>;
let activeRoom = ROOMS.length ? ROOMS[0].id : 0;
let pollTimer = null;

const ERR = {
  rate:    {en:'Please wait a moment before sending again.', ar:'يرجى الانتظار قليلاً قبل الإرسال مرة أخرى.'},
  contact: {en:'Sharing contact information is not allowed in chat rooms.', ar:'لا يُسمح بمشاركة معلومات التواصل في غرف الدردشة.'},
  toolong: {en:'Message is too long (max 1000 characters).', ar:'الرسالة طويلة جداً (الحد 1000 حرف).'},
  empty:   {en:'Please type a message.', ar:'يرجى كتابة رسالة.'},
  csrf:    {en:'Security check failed. Please refresh.', ar:'فشل التحقق الأمني. يرجى التحديث.'},
  forbidden:{en:'Access denied.', ar:'تم رفض الوصول.'},
  auth:    {en:'Session expired. Please sign in again.', ar:'انتهت الجلسة. يرجى تسجيل الدخول مجدداً.'},
  net:     {en:'Network error. Please try again.', ar:'خطأ في الشبكة. حاول مرة أخرى.'},
};

function escAttr(s){return String(s==null?'':s);}

function renderMessages(list){
  const box = document.getElementById('messages');
  if(!list.length){
    box.innerHTML = '<div class="empty-chat">'+(L==='ar'?'لا توجد رسائل بعد.':'No messages yet.')+'</div>';
    return;
  }
  const atBottom = box.scrollHeight - box.scrollTop - box.clientHeight < 60;
  box.innerHTML = list.map(m=>{
    const name = L==='ar' ? m.name_ar : m.name_en;            // already escaped server-side
    const av = m.pic
      ? '<img class="av" src="'+m.pic+'" alt="">'
      : '<div class="av">'+m.initial+'</div>';
    return '<div class="msg'+(m.mine?' mine':'')+'">'+av+
      '<div class="bubble"><div class="who">'+name+'</div>'+
      '<div class="txt">'+m.text+'</div>'+        // text escaped server-side
      '<div class="tm">'+m.time+'</div></div></div>';
  }).join('');
  if(atBottom) box.scrollTop = box.scrollHeight;
}

function loadMessages(){
  fetch('chat.php?action=fetch&room_id='+activeRoom, {credentials:'same-origin'})
    .then(r=>r.json())
    .then(d=>{ if(d.ok) renderMessages(d.messages); })
    .catch(()=>{});
}

function selectRoom(id, el){
  activeRoom = id;
  document.querySelectorAll('.room').forEach(r=>r.classList.remove('active'));
  if(el) el.classList.add('active');
  const r = ROOMS.find(x=>x.id===id);
  if(r){
    document.getElementById('panelIcon').textContent = r.icon;
    const pt = document.getElementById('panelTitle');
    pt.dataset.en = r.name_en; pt.dataset.ar = r.name_ar;
    pt.textContent = L==='ar' ? r.name_ar : r.name_en;
  }
  document.getElementById('sendError').textContent='';
  document.getElementById('messages').innerHTML='';
  loadMessages();
}

function sendMessage(ev){
  ev.preventDefault();
  const input = document.getElementById('msgInput');
  const text = input.value.trim();
  const errBox = document.getElementById('sendError');
  errBox.textContent='';
  if(!text) return false;
  const body = new URLSearchParams();
  body.set('action','send'); body.set('room_id',activeRoom);
  body.set('message',text); body.set('csrf_token',CSRF);
  fetch('chat.php', {method:'POST', credentials:'same-origin',
      headers:{'Content-Type':'application/x-www-form-urlencoded'}, body})
    .then(r=>r.json())
    .then(d=>{
      if(d.ok){ input.value=''; loadMessages(); }
      else { const m=ERR[d.error]||ERR.net; errBox.textContent = L==='ar'?m.ar:m.en; }
    })
    .catch(()=>{ errBox.textContent = L==='ar'?ERR.net.ar:ERR.net.en; });
  return false;
}
<?php endif; ?>

/* ---- Bilingual nav + labels ---- */
const NAV={
  en:{lb:'العربية',studio:'The Studio',community:'Community',marketplace:'Marketplace',explore:'Explore Art Styles',support:'Support',
    s1:'Watercolor Workshop',s2:'Oil Painting Studio',s3:'Digital Art Lab',s4:'Charcoal & Ink',
    c1:'Artist Chat Room',c2:'Meet Fellow Artists',c3:'Share Your Work',c4:'Learn Together',
    sp1:'Contact Us',sp2:'How It Works',sp3:'Terms of Use',chat:'Artist Chat',login:'Sign In',reg:'Join Free',
    roomsTitle:'Artist Chat Rooms',typeMsg:'Type your message',send:'Send'},
  ar:{lb:'English',studio:'الاستوديو',community:'المجتمع',marketplace:'السوق',explore:'استكشف أساليب الرسم',support:'الدعم',
    s1:'ورشة الألوان المائية',s2:'استوديو الرسم الزيتي',s3:'مختبر الفن الرقمي',s4:'الفحم والحبر',
    c1:'غرفة محادثة الفنانين',c2:'تعرّف على فنانين',c3:'شارك أعمالك',c4:'تعلّم معاً',
    sp1:'تواصل معنا',sp2:'كيف يعمل الموقع',sp3:'شروط الاستخدام',chat:'محادثة الفنانين',login:'تسجيل الدخول',reg:'انضم مجاناً',
    roomsTitle:'غرف دردشة الفنانين',typeMsg:'اكتب رسالتك',send:'إرسال'}
};
function setTxt(id,v){const el=document.getElementById(id);if(el)el.textContent=v;}
function apply(l){
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
  // gate (if shown)
  ['g-title','g-msg','g-btn'].forEach(id=>{const el=document.getElementById(id);if(el)el.textContent=(l==='ar'?el.dataset.ar:el.dataset.en);});
  // chat labels (if shown)
  setTxt('rooms-title',n.roomsTitle);
  const inp=document.getElementById('msgInput');if(inp)inp.placeholder=n.typeMsg;
  setTxt('sendBtn',n.send);
  document.querySelectorAll('.room').forEach(r=>{
    const nm=r.querySelector('.room-name');if(nm)nm.textContent=(l==='ar'?r.dataset.ar:r.dataset.en);
  });
  const pt=document.getElementById('panelTitle');if(pt)pt.textContent=(l==='ar'?pt.dataset.ar:pt.dataset.en);
}
function tgl(){L=L==='en'?'ar':'en';apply(L);<?php if($access==='ok'):?>renderRefresh();<?php endif;?>}
<?php if($access==='ok'):?>
function renderRefresh(){ loadMessages(); }
<?php endif; ?>
apply(L);

const v=document.getElementById('vid');
if(v){v.addEventListener('canplay',()=>v.classList.add('on'),{once:true});v.play().catch(()=>{});}

<?php if ($access === 'ok'): ?>
loadMessages();
pollTimer = setInterval(loadMessages, 5000);   // auto-refresh every 5s
<?php endif; ?>
</script>
</body>
</html>
