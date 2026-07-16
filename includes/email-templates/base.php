<?php
/**
 * Stock Wealth - Base HTML Email Template
 * Uses inline styles for email client compatibility.
 * Variables: $badge, $heading, $content_html, $cta_text, $cta_url
 */
$badge = $badge ?? 'Account Notification';
$heading = $heading ?? ('Your ' . get_site_name() . ' update');
$content_html = $content_html ?? '<p>Your message content here.</p>';
$cta_text = $cta_text ?? null;
$cta_url = $cta_url ?? '#';
$site_url = $site_url ?? '/';
$siteName = $siteName ?? get_site_name();
$siteLogo = trim((string) (get_site_setting('site_logo', '') ?? ''));
if ($siteLogo !== '' && strpos($siteLogo, 'http') !== 0 && rtrim((string) $site_url, '/') !== '') {
    $siteLogo = rtrim((string) $site_url, '/') . (strpos($siteLogo, '/') === 0 ? $siteLogo : '/' . $siteLogo);
}
[$brandBase, $brandAccent] = get_site_brand_parts($siteName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title><?= htmlspecialchars($siteName) ?> | Transactional Email</title>
<style>
body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:0;background-color:#eef2f8;color:#081422}
a{color:#4b8eff;text-decoration:none}
</style>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;margin:0;padding:0;background-color:#eef2f8;color:#081422;line-height:1.6">
<div style="max-width:600px;margin:0 auto;padding:24px">
<div style="background:#fff;border:1px solid #d5dde8;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(8,20,34,0.08)">
<div style="height:6px;width:100%;background:linear-gradient(90deg,#4b8eff 0%,#002e69 100%);background-color:#4b8eff"></div>
<div style="padding:32px 40px 24px;background:#fff;border-bottom:1px solid #e8eef6;text-align:center">
<?php if ($siteLogo !== ''): ?>
<img src="<?= htmlspecialchars($siteLogo) ?>" alt="<?= htmlspecialchars($siteName) ?>" style="max-height:48px;max-width:220px;width:auto;height:auto;display:inline-block"/>
<?php else: ?>
<span style="font-size:32px;font-weight:700;color:#081422;letter-spacing:-0.02em;line-height:1.2"><?= htmlspecialchars($brandBase) ?><?php if ($brandAccent !== ''): ?><span style="color:#4b8eff"><?= htmlspecialchars($brandAccent) ?></span><?php endif; ?></span>
<?php endif; ?>
</div>
<div style="padding:32px 40px">
<div style="margin-bottom:24px;text-align:center">
<span style="display:inline-block;padding:6px 12px;background:rgba(75,142,255,0.12);color:#005bc1;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px"><?= htmlspecialchars($badge) ?></span>
</div>
<h2 style="margin:0 0 24px;font-size:28px;font-weight:700;color:#081422;line-height:1.3"><?= htmlspecialchars($heading) ?></h2>
<div style="color:#5a6578;font-size:16px;line-height:1.7">
<?= $content_html ?>
</div>
<?php if ($cta_text): ?>
<div style="margin-top:32px;margin-bottom:32px;text-align:center">
<a href="<?= htmlspecialchars($cta_url) ?>" style="display:inline-block;padding:16px 32px;background:#4b8eff;color:#ffffff;font-weight:700;font-size:16px;border-radius:8px;text-decoration:none;box-shadow:0 4px 14px rgba(75,142,255,0.35)"><?= htmlspecialchars($cta_text) ?> →</a>
</div>
<?php endif; ?>
<hr style="border:none;border-top:1px solid #d5dde8;margin:24px 0"/>
<div style="color:#7a8494;font-size:14px">
<p style="margin:0 0 4px">Best regards,</p>
<p style="margin:0;font-weight:700;color:#081422">The <?= htmlspecialchars($siteName) ?> Team</p>
</div>
</div>
<div style="background:#e8eef6;padding:24px 40px;border-top:1px solid #d5dde8">
<div style="text-align:center;margin-bottom:16px">
<a href="#" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;margin:0 4px;background:#fff;border:1px solid #d5dde8;border-radius:50%;color:#5a6578;text-decoration:none">𝕏</a>
<a href="#" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;margin:0 4px;background:#fff;border:1px solid #d5dde8;border-radius:50%;color:#5a6578;text-decoration:none">in</a>
</div>
<p style="margin:0 0 4px;font-size:11px;color:#7a8494;text-transform:uppercase;letter-spacing:0.1em;font-weight:700"><?= strtoupper(htmlspecialchars($siteName)) ?></p>
<div style="margin-top:20px;padding-top:20px;border-top:1px solid #d5dde8;text-align:center">
<p style="margin:0;font-size:11px;color:#7a8494">You're receiving this because you're a <?= htmlspecialchars($siteName) ?> customer. <a href="<?= htmlspecialchars($site_url) ?>/legal_centre" style="color:#5a6578;text-decoration:underline">Manage Preferences</a> · <a href="<?= htmlspecialchars($site_url) ?>/legal_centre" style="color:#5a6578;text-decoration:underline">Unsubscribe</a></p>
</div>
</div>
</div>
<div style="margin-top:24px;text-align:center">
<p style="margin:0;font-size:13px;color:#7a8494">Questions? Visit our <a href="<?= htmlspecialchars($site_url) ?>/help_centre" style="color:#5a6578;text-decoration:underline">Help Center</a> or reply to this email.</p>
<p style="margin:8px 0 0;font-size:12px;color:#7a8494">© <?= date('Y') ?> <?= htmlspecialchars($siteName) ?>. All rights reserved.</p>
</div>
</div>
</body>
</html>
