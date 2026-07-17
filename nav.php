<?php
/* Shared brand navbar — include with: <?php include __DIR__ . "/nav.php"; ?>
   Assumes config.php was already required by the host page (session started). */
if (!function_exists('currentUser')) { @require_once __DIR__ . '/config.php'; }
$navUser  = function_exists('currentUser') ? currentUser() : null;
$navIsAdmin = function_exists('isAdmin') && isAdmin();
$navName  = $navUser ? trim((string)($navUser['full_name_en'] ?: ($navUser['full_name_ar'] ?: $navUser['email']))) : '';
if ($navName === '') { $navName = 'Account'; }
$navFirst = $navUser ? (explode(' ', $navName)[0]) : '';
$navId    = $navUser ? (int) $navUser['id'] : 0;
?>
<script>
/* Apply the saved language direction as early as possible to avoid a flash
   of the wrong direction before the page's own script runs. */
(function(){try{var l=localStorage.getItem('lang');if(l==='ar'){document.documentElement.setAttribute('dir','rtl');document.documentElement.setAttribute('lang','ar');}}catch(e){}})();
</script>
<nav class="topnav" id="topnav">
  <a class="nav-logo" href="index.html">
    <span style="display:inline-block;background:linear-gradient(90deg,#ff0055,#aa00ff,#0066ff);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:transparent;font-weight:800;font-size:15px;letter-spacing:0.14em;">OWEILI</span>
    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><defs><linearGradient id="navLogoGrad" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#ff0055"/><stop offset="55%" stop-color="#aa00ff"/><stop offset="100%" stop-color="#0066ff"/></linearGradient></defs><path fill="url(#navLogoGrad)" d="M12 0C12 6 18 12 24 12C18 12 12 18 12 24C12 18 6 12 0 12C6 12 12 6 12 0Z"/></svg>
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
        <a href="mailto:contact@oweili.com"><svg class="d-icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span id="dd-sp1">Contact Us</span></a>
        <a href="support.php#how"><svg class="d-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg><span id="dd-sp2">How It Works</span></a>
        <a href="support.php#terms"><svg class="d-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span id="dd-sp3">Terms of Use</span></a>
      </div>
    </div>
  </div>
  <div class="nav-right">
    <?php if ($navUser): ?>
      <?php if ($navIsAdmin): ?>
      <a class="nav-btn" href="admin.php" id="n-admin"><span class="nav-i18n" data-en="Admin" data-ar="الإدارة">Admin</span></a>
      <?php endif; ?>
      <a class="nav-btn" href="<?= e(dashboardUrl($navUser['role'] ?? '')) ?>" id="n-acct"><span><?= htmlspecialchars($navFirst, ENT_QUOTES) ?></span></a>
      <a class="nav-btn" href="logout.php" id="n-logout"><span class="nav-i18n" data-en="Sign Out" data-ar="تسجيل الخروج">Sign Out</span></a>
    <?php else: ?>
      <a class="nav-btn" href="login.php" id="n-login"><span id="n-login-t">Sign In</span></a>
      <a class="nav-btn" href="register.php" id="n-reg"><span id="n-reg-t">Join Free</span></a>
    <?php endif; ?>
    <button class="lang-btn" onclick="tgl()" id="lb">العربية</button>
  </div>
</nav>
<script>
/* =====================================================================
 *  Language persistence — shared across every page that includes nav.php.
 *  Saves the EN/AR choice in localStorage and re-applies it on each load,
 *  so switching to Arabic sticks when navigating between pages.
 * ===================================================================== */
(function(){
  var KEY = 'lang';

  // Capture the saved preference NOW, before the page's own apply('en') runs
  // (it runs later, at the end of the body) and before the observer below can
  // overwrite storage with an intermediate value.
  var want = null;
  try { want = localStorage.getItem(KEY); } catch (e) {}

  function curLang(){
    return (document.documentElement.getAttribute('dir') === 'rtl' ||
            document.documentElement.lang === 'ar') ? 'ar' : 'en';
  }
  function save(l){ try { localStorage.setItem(KEY, l); } catch (e) {} }

  function syncNavI18n(){
    var ar = curLang() === 'ar';
    document.querySelectorAll('.nav-i18n').forEach(function(el){
      el.textContent = ar ? (el.dataset.ar || el.dataset.en) : el.dataset.en;
    });
  }

  // Persist whatever language the page settles on (toggle, or our re-apply).
  new MutationObserver(function(){ syncNavI18n(); save(curLang()); })
    .observe(document.documentElement, { attributes: true, attributeFilter: ['dir', 'lang'] });

  // Re-apply the saved language after the page's inline script has run.
  function applySaved(){
    if (want && want !== curLang() && typeof window.tgl === 'function') {
      // Use the page's own toggle so its internal language state stays in sync.
      window.tgl();
    } else if (want && want !== curLang()) {
      // Fallback for pages without a tgl(): set direction directly.
      var ar = want === 'ar';
      document.documentElement.setAttribute('dir', ar ? 'rtl' : 'ltr');
      document.documentElement.setAttribute('lang', want);
    }
    syncNavI18n();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', applySaved);
  } else {
    applySaved();
  }
})();
</script>
