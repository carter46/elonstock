<?php
/**
 * Stock Wealth - Newsletter Signup Notification (to admin)
 */
$config = $config ?? [];
require_once dirname(__DIR__) . '/helpers.php';
$siteName = get_site_name();
[$brandBase, $brandAccent] = get_site_brand_parts($siteName);
$email = $email ?? '';
$date = $date ?? date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= htmlspecialchars($siteName) ?> | New Newsletter Signup</title>
</head>
<body style="font-family:Arial,sans-serif;margin:0;padding:0;background:#eef2f8;color:#081422;line-height:1.6">
<div style="max-width:600px;margin:0 auto;padding:24px">
<div style="background:#fff;border:1px solid #d5dde8;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06)">
<div style="height:6px;width:100%;background:#4b8eff"></div>
<div style="padding:32px 40px 24px;background:#fff;border-bottom:1px solid #e8eef6;text-align:center">
<span style="font-size:32px;font-weight:700;color:#081422;letter-spacing:-0.02em;line-height:1.2"><?= htmlspecialchars($brandBase) ?><?php if ($brandAccent !== ''): ?><span style="color:#4b8eff"><?= htmlspecialchars($brandAccent) ?></span><?php endif; ?></span>
</div>
<div style="padding:32px 40px">
<span style="display:inline-block;padding:6px 12px;background:rgba(34,197,94,0.15);color:#16a34a;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px;margin-bottom:20px">New Signup</span>
<h2 style="margin:0 0 24px;font-size:24px;font-weight:700;color:#081422">New newsletter subscription</h2>
<p style="margin:0 0 8px;color:#5a6578"><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($email) ?>" style="color:#4b8eff"><?= htmlspecialchars($email) ?></a></p>
<p style="margin:0;color:#5a6578"><strong>Date:</strong> <?= htmlspecialchars($date) ?> UTC</p>
</div>
</div>
</div>
</body>
</html>
