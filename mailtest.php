<?php
/* =====================================================================
 *  mailtest.php — TEMPORARY email diagnostic.
 *  Open once in your browser, read the result, then DELETE this file.
 *  It sends a test message to the address below using the SMTP settings
 *  in config.php (sendEmail()).
 * ===================================================================== */
require_once __DIR__ . '/config.php';

$to      = 'amro@elitport.com';
$subject = 'Oweili SMTP test · ' . date('Y-m-d H:i:s');
$body    = "This is a test email from oweili.com.\r\n\r\n"
         . "If you received this, authenticated SMTP is working correctly.\r\n"
         . "Sent at: " . date('r') . "\r\n";

$start = microtime(true);
$ok    = sendEmail($to, $subject, $body);
$ms    = round((microtime(true) - $start) * 1000);

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Oweili · Mail Test</title>
<style>
body{font-family:"Helvetica Neue",Arial,sans-serif;background:#f4f5f7;color:#111;display:flex;min-height:100vh;align-items:center;justify-content:center;margin:0;padding:20px;}
.card{background:#fff;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);padding:34px 40px;max-width:520px;width:100%;}
.badge{display:inline-block;padding:6px 16px;border-radius:999px;font-size:13px;font-weight:700;letter-spacing:.04em;}
.ok{background:rgba(0,180,100,.14);color:#00a050;}
.bad{background:rgba(255,0,85,.12);color:#ff0055;}
h1{font-size:20px;margin:18px 0 8px;}
p{font-size:14px;color:#555;line-height:1.7;margin:6px 0;}
code{background:#f4f5f7;padding:2px 6px;border-radius:6px;font-size:13px;}
.warn{margin-top:22px;padding:12px 16px;background:#fff8e1;border:1px solid #ffe08a;border-radius:10px;font-size:13px;color:#7a5b00;}
</style></head>
<body>
  <div class="card">
    <?php if ($ok): ?>
      <span class="badge ok">✓ SUCCESS</span>
      <h1>Test email sent</h1>
      <p>A message was sent to <code><?= htmlspecialchars($to, ENT_QUOTES) ?></code> in <?= $ms ?> ms.</p>
      <p>Check that inbox (and the spam folder). If it arrived, your SMTP setup works and registration / password-reset / welcome emails will send too.</p>
    <?php else: ?>
      <span class="badge bad">✕ FAILED</span>
      <h1>Email could not be sent</h1>
      <p>The SMTP send returned an error (took <?= $ms ?> ms). Common causes:</p>
      <p>• <code>SMTP_PASS</code> in config.php is wrong or still the placeholder.<br>
         • The mailbox <code><?= htmlspecialchars(SMTP_USER, ENT_QUOTES) ?></code> doesn't exist yet in hPanel.<br>
         • Port <?= (int) SMTP_PORT ?> is blocked — try <code>587</code> instead of <code>465</code>.</p>
      <p>Open your PHP error log (hPanel → Advanced → PHP error log) for the exact SMTP reply.</p>
    <?php endif; ?>
    <div class="warn">⚠️ Delete <code>mailtest.php</code> from the server after testing — it should not stay public.</div>
  </div>
</body>
</html>
