<?php
/**
 * Stock Wealth - Newsletter Welcome Email (to subscriber)
 */
$config = $config ?? [];
$site_url = $site_url ?? '/';
require_once dirname(__DIR__) . '/helpers.php';
$siteName = get_site_name();
[$brandBase, $brandAccent] = get_site_brand_parts($siteName);
$email = $email ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= htmlspecialchars($siteName) ?> | Welcome</title>
</head>
<body style="font-family:Arial,sans-serif;margin:0;padding:0;background:#eef2f8;color:#081422;line-height:1.6">
<div style="max-width:600px;margin:0 auto;padding:24px">
<div style="background:#fff;border:1px solid #d5dde8;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06)">
<div style="height:6px;width:100%;background:#4b8eff"></div>
<div style="padding:32px 40px 24px;background:#fff;border-bottom:1px solid #e8eef6;text-align:center">
<span style="font-size:32px;font-weight:700;color:#081422;letter-spacing:-0.02em;line-height:1.2"><?= htmlspecialchars($brandBase) ?><?php if ($brandAccent !== ''): ?><span style="color:#4b8eff"><?= htmlspecialchars($brandAccent) ?></span><?php endif; ?></span>
</div>
<div style="padding:32px 40px">
<span style="display:inline-block;padding:6px 12px;background:rgba(75,142,255,0.15);color:#005bc1;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px;margin-bottom:20px">Welcome</span>
<h2 style="margin:0 0 24px;font-size:28px;font-weight:700;color:#081422;line-height:1.3">Thanks for subscribing to <?= htmlspecialchars($siteName) ?></h2>
<p style="margin:0 0 16px;color:#5a6578;font-size:16px">You're now part of a community of forward-thinking investors who use AI to optimize their crypto portfolios.</p>
<p style="margin:0 0 24px;color:#5a6578;font-size:16px">Expect exclusive insights, market updates, and platform news delivered to your inbox.</p>
<div style="margin-top:32px;margin-bottom:32px;text-align:center">
<a href="<?= htmlspecialchars($site_url) ?>" style="display:inline-block;padding:16px 32px;background:#4b8eff;color:#ffffff;font-weight:700;font-size:16px;border-radius:8px;text-decoration:none;box-shadow:0 4px 14px rgba(75,142,255,0.35)">Visit <?= htmlspecialchars($siteName) ?> →</a>
</div>
<hr style="border:none;border-top:1px solid #d5dde8;margin:24px 0"/>
<div style="color:#7a8494;font-size:14px">
<p style="margin:0 0 4px">Best regards,</p>
<p style="margin:0;font-weight:700;color:#081422">The <?= htmlspecialchars($siteName) ?> Team</p>
</div>
</div>
<div style="background:#e8eef6;padding:24px 40px;border-top:1px solid #d5dde8">
<p style="margin:0;font-size:11px;color:#7a8494;text-align:center">You're receiving this because you subscribed at <?php
$subHost = parse_url((string) $site_url, PHP_URL_HOST);
echo htmlspecialchars($subHost ?: preg_replace('#^https?://#', '', rtrim((string) $site_url, '/')));
?>. <a href="<?= htmlspecialchars($site_url) ?>/legal_centre" style="color:#5a6578;text-decoration:underline">Unsubscribe</a></p>
<p style="margin:8px 0 0;font-size:12px;color:#7a8494;text-align:center">© <?= date('Y') ?> <?= htmlspecialchars($siteName) ?>. All rights reserved.</p>
</div>
</div>
</div>
</body>
</html>
