<?php
/**
 * Stock Wealth - Contact Form Notification Email (to support team)
 */
$config = $config ?? [];
$site_url = $site_url ?? '/';
require_once dirname(__DIR__) . '/helpers.php';
$siteName = get_site_name();
[$brandBase, $brandAccent] = get_site_brand_parts($siteName);
$name = $name ?? '';
$email = $email ?? '';
$subject = $subject ?? '';
$message = $message ?? '';
$message_escaped = htmlspecialchars($message);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= htmlspecialchars($siteName) ?> | Contact Form</title>
</head>
<body style="font-family:Arial,sans-serif;margin:0;padding:0;background:#eef2f8;color:#081422;line-height:1.6">
<div style="max-width:600px;margin:0 auto;padding:24px">
<div style="background:#fff;border:1px solid #d5dde8;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06)">
<div style="height:6px;width:100%;background:linear-gradient(90deg,#ff5c1a 0%,#c41e0a 55%,#8b0000 100%);background-color:#c41e0a"></div>
<div style="padding:32px 40px 24px;background:#fff;border-bottom:1px solid #e8eef6;text-align:center">
<span style="font-size:32px;font-weight:700;color:#081422;letter-spacing:-0.02em;line-height:1.2"><?= htmlspecialchars($brandBase) ?><?php if ($brandAccent !== ''): ?><span style="color:#c41e0a"><?= htmlspecialchars($brandAccent) ?></span><?php endif; ?></span>
</div>
<div style="padding:32px 40px">
<span style="display:inline-block;padding:6px 12px;background:rgba(196,30,10,0.15);color:#c41e0a;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px;margin-bottom:20px">Contact Form</span>
<h2 style="margin:0 0 24px;font-size:24px;font-weight:700;color:#081422">New message from <?= htmlspecialchars($siteName) ?> website</h2>
<table style="width:100%;border-collapse:collapse;margin-bottom:24px">
<tr><td style="padding:8px 0;color:#5a6578;font-weight:600;width:120px">Name</td><td style="padding:8px 0;color:#081422"><?= htmlspecialchars($name) ?></td></tr>
<tr><td style="padding:8px 0;color:#5a6578;font-weight:600">Email</td><td style="padding:8px 0"><a href="mailto:<?= htmlspecialchars($email) ?>" style="color:#c41e0a"><?= htmlspecialchars($email) ?></a></td></tr>
<tr><td style="padding:8px 0;color:#5a6578;font-weight:600">Subject</td><td style="padding:8px 0;color:#081422"><?= htmlspecialchars($subject) ?></td></tr>
</table>
<div style="padding:16px;background:#e8eef6;border-radius:8px;border-left:4px solid #c41e0a">
<div style="margin:0;color:#081422;line-height:1.7"><?= nl2br($message_escaped) ?></div>
</div>
<p style="margin-top:24px;font-size:13px;color:#7a8494">Reply directly to this email to respond to <?= htmlspecialchars($name) ?>.</p>
</div>
</div>
</div>
</body>
</html>
