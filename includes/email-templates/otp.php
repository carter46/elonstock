<?php
/**
 * Stock Wealth - OTP Email Template
 */
$config = $config ?? [];
$site_url = $site_url ?? '/';
$otp = $otp ?? '';
$name = $name ?? 'User';
$purpose_label = $purpose_label ?? 'verification';
require_once dirname(__DIR__) . '/helpers.php';
$siteName = get_site_name();
[$brandBase, $brandAccent] = get_site_brand_parts($siteName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= htmlspecialchars($siteName) ?> | <?= htmlspecialchars($purpose_label) ?></title>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;margin:0;padding:0;background:#eef2f8;color:#081422;line-height:1.6">
<div style="max-width:600px;margin:0 auto;padding:24px">
<div style="background:#fff;border:1px solid #d5dde8;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06)">
<div style="height:6px;width:100%;background:#4b8eff"></div>
<div style="padding:32px 40px 24px;background:#fff;border-bottom:1px solid #e8eef6;text-align:center">
<span style="font-size:32px;font-weight:700;color:#081422;letter-spacing:-0.02em;line-height:1.2"><?= htmlspecialchars($brandBase) ?><?php if ($brandAccent !== ''): ?><span style="color:#4b8eff"><?= htmlspecialchars($brandAccent) ?></span><?php endif; ?></span>
</div>
<div style="padding:32px 40px">
<span style="display:inline-block;padding:6px 12px;background:rgba(75,142,255,0.15);color:#005bc1;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px;margin-bottom:20px">Verification Code</span>
<h2 style="margin:0 0 24px;font-size:28px;font-weight:700;color:#081422;line-height:1.3">Your verification code</h2>
<p style="margin:0 0 16px;color:#5a6578;font-size:16px">Hi <strong style="color:#081422"><?= htmlspecialchars($name) ?></strong>,</p>
<p style="margin:0 0 24px;color:#5a6578;font-size:16px">Use the following 6-digit code to complete <?= htmlspecialchars($purpose_label) ?>:</p>
<div style="margin:24px 0;padding:20px;background:#eef2f8;border-radius:8px;text-align:center">
<code style="font-size:32px;font-weight:700;letter-spacing:0.25em;color:#081422"><?= htmlspecialchars($otp) ?></code>
</div>
<p style="margin:0 0 8px;color:#7a8494;font-size:14px">This code expires in 10 minutes. Do not share it with anyone.</p>
<hr style="border:none;border-top:1px solid #d5dde8;margin:24px 0"/>
<div style="color:#7a8494;font-size:14px">
<p style="margin:0 0 4px">Best regards,</p>
<p style="margin:0;font-weight:700;color:#081422">The <?= htmlspecialchars($siteName) ?> Team</p>
</div>
</div>
</div>
</div>
</body>
</html>
