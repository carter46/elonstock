<?php
require_once __DIR__ . '/../../includes/admin-check.php';
require_once __DIR__ . '/../../includes/helpers.php';
$currentPage = 'settings';
$siteName = get_site_name();

$settings = [
    'site_name' => get_site_setting('site_name', $siteName),
    'site_logo' => get_site_setting('site_logo', ''),
    'site_favicon' => get_site_setting('site_favicon', ''),
    'contact_email' => get_site_setting('contact_email', ''),
    'mail_smtp_host' => get_site_setting('mail_smtp_host', ''),
    'mail_smtp_port' => get_site_setting('mail_smtp_port', '587'),
    'mail_smtp_username' => get_site_setting('mail_smtp_username', ''),
    'mail_smtp_encryption' => get_site_setting('mail_smtp_encryption', 'tls'),
    'mail_from_email' => get_site_setting('mail_from_email', ''),
    'mail_from_name' => get_site_setting('mail_from_name', ''),
    'mail_reply_to' => get_site_setting('mail_reply_to', ''),
    'mail_imap_host' => get_site_setting('mail_imap_host', ''),
    'mail_imap_port' => get_site_setting('mail_imap_port', '993'),
    'mail_imap_username' => get_site_setting('mail_imap_username', ''),
    'mail_imap_encryption' => get_site_setting('mail_imap_encryption', 'ssl'),
    'mail_imap_sent_folder' => get_site_setting('mail_imap_sent_folder', 'Sent'),
    'homepage_youtube_url' => get_site_setting('homepage_youtube_url', ''),
    'homepage_youtube_start_seconds' => get_site_setting('homepage_youtube_start_seconds', '0'),
    'homepage_modal_image' => get_site_setting('homepage_modal_image', ''),
    'header_image' => get_site_setting('header_image', '/bloombit.jpg'),
    'office_title' => get_site_setting('office_title', 'Registered Office'),
    'office_address' => get_site_setting('office_address', "Lindeyer Francis Ferguson\nNorth House, 198 High Street\nTonbridge, Kent, TN9 1BE"),
    'smartsupp_key' => get_site_setting('smartsupp_key', ''),
    'jivo_widget_id' => get_site_setting('jivo_widget_id', ''),
    'live_chat_provider' => get_site_setting('live_chat_provider', ''),
    'deposit_countdown_minutes' => get_site_setting('deposit_countdown_minutes', '30'),
    'referral_enabled' => get_site_setting('referral_enabled', '0'),
    'referral_percentage' => get_site_setting('referral_percentage', '15'),
    'referral_level2_percentage' => get_site_setting('referral_level2_percentage', '10'),
    'deposit_bonus_percentage' => get_site_setting('deposit_bonus_percentage', '10'),
];
$adminEmail = '';
$adminName = '';
if (isset($_SESSION['user_id'])) {
    try {
        $pdo = require __DIR__ . '/../../includes/db.php';
        $stmt = $pdo->prepare('SELECT email, name FROM users WHERE id = ? AND role = ?');
        $stmt->execute([$_SESSION['user_id'], 'admin']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $adminEmail = $row['email'] ?? '';
            $adminName = $row['name'] ?? '';
        }
    } catch (Throwable $e) {}
}

$pageTitle = $siteName . ' | Admin Settings';
require_once __DIR__ . '/../../includes/dashboard/admin-layout-start.php';
$pageHeading = 'Admin Settings';
$pageSubtitle = 'Site branding, admin account, and testing tools.';
include __DIR__ . '/../../includes/dashboard/admin-page-title.php';
?>

<div class="mb-6">
  <div class="inline-flex flex-wrap gap-2 bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-xl p-2">
    <button type="button" id="settings-tab-admin" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors">Admin Account</button>
    <button type="button" id="settings-tab-branding" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors">Branding</button>
    <button type="button" id="settings-tab-email" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors">Email Settings</button>
  </div>
</div>

<div class="space-y-8">

<!-- Admin Account Tab -->
<div id="settings-panel-admin">
<section class="bg-white dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800 p-6">
<h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary">admin_panel_settings</span> Admin Account</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Admin Email</label>
<input id="settings-admin-email" type="email" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars($adminEmail); ?>" placeholder="admin@example.com"/>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Current Password</label>
<input id="settings-current-pw" type="password" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" placeholder="Required to change password"/>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">New Password</label>
<input id="settings-new-pw" type="password" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" placeholder="Leave blank to keep"/>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Confirm New Password</label>
<input id="settings-confirm-pw" type="password" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" placeholder="Confirm new password"/>
</div>
</div>
<button type="button" id="settings-save-admin" class="mt-4 px-6 py-2.5 bg-primary text-slate-900 font-bold rounded-lg hover:opacity-90">Update Admin Account</button>
<div id="settings-admin-msg" class="text-sm mt-2 hidden"></div>
</section>
</div>

<!-- Branding Tab -->
<div id="settings-panel-branding" class="hidden">
<!-- Site Branding -->
<section class="bg-white dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800 p-6">
<h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary">palette</span> Site Branding</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Site Name</label>
<input id="settings-site-name" type="text" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars($settings['site_name']); ?>" placeholder="<?php echo htmlspecialchars($siteName); ?>"/>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Support / Contact Email</label>
<input id="settings-contact-email" type="email" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars($settings['contact_email']); ?>" placeholder="support@yourdomain.com"/>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">Help Centre contact form submissions will be emailed here.</p>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Logo</label>
<div class="flex items-center gap-4">
<div id="settings-logo-preview" class="w-16 h-16 rounded-lg bg-slate-100 dark:bg-zinc-800 flex items-center justify-center overflow-hidden shrink-0">
<?php if (!empty($settings['site_logo'])): ?><img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" alt="Logo" class="w-full h-full object-contain"/><?php else: ?><span class="material-symbols-outlined text-slate-400">image</span><?php endif; ?>
</div>
<input type="file" id="settings-logo-input" accept="image/png,image/jpeg,image/webp" class="text-sm"/>
</div>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Favicon</label>
<div class="flex items-center gap-4">
<div id="settings-favicon-preview" class="w-10 h-10 rounded bg-slate-100 dark:bg-zinc-800 flex items-center justify-center overflow-hidden shrink-0">
<?php if (!empty($settings['site_favicon'])): ?><img src="<?php echo htmlspecialchars($settings['site_favicon']); ?>" alt="Favicon" class="w-full h-full object-contain"/><?php else: ?><span class="material-symbols-outlined text-slate-400 text-lg">star</span><?php endif; ?>
</div>
<input type="file" id="settings-favicon-input" accept="image/png,image/x-icon,image/ico" class="text-sm"/>
</div>
</div>
<div class="md:col-span-2">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Homepage YouTube Video URL</label>
<input id="settings-homepage-youtube" type="text" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars($settings['homepage_youtube_url']); ?>" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/..."/>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Shown on the homepage between <strong>Live Market Performance</strong> and <strong>Choose Your Plan</strong>. Click <strong>Save Branding</strong> after pasting. Leave empty to hide.</p>
</div>
<div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Homepage Video Start Time (seconds)</label>
<input id="settings-homepage-youtube-start" type="number" min="0" step="1" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars((string) max(0, (int) $settings['homepage_youtube_start_seconds'])); ?>" placeholder="0"/>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">Playback starts at this second when the video enters view (e.g. 30 = 0:30).</p>
</div>
<div class="md:col-span-2">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Homepage Floating Modal Image</label>
<div class="flex items-center gap-4">
<div id="settings-modal-image-preview" class="w-32 h-32 rounded-lg bg-slate-100 dark:bg-zinc-800 flex items-center justify-center overflow-hidden shrink-0 border border-slate-200 dark:border-zinc-700">
<?php if (!empty($settings['homepage_modal_image'])): ?><img src="<?php echo htmlspecialchars($settings['homepage_modal_image']); ?>" alt="Modal Image" class="w-full h-full object-contain"/><?php else: ?><span class="material-symbols-outlined text-slate-400">image</span><?php endif; ?>
</div>
<input type="file" id="settings-modal-image-input" accept="image/png,image/jpeg,image/webp,image/jpg" class="text-sm"/>
</div>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">Image shown in the floating button modal on homepage. Leave empty to hide the button.</p>
</div>
<div class="md:col-span-2">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Header Image (About Page)</label>
<div class="flex items-center gap-4">
<div id="settings-header-image-preview" class="w-32 h-32 rounded-lg bg-slate-100 dark:bg-zinc-800 flex items-center justify-center overflow-hidden shrink-0 border border-slate-200 dark:border-zinc-700">
<?php if (!empty($settings['header_image'])): ?><img src="<?php echo htmlspecialchars($settings['header_image']); ?>" alt="Header Image" class="w-full h-full object-contain"/><?php else: ?><span class="material-symbols-outlined text-slate-400">image</span><?php endif; ?>
</div>
<input type="file" id="settings-header-image-input" accept="image/png,image/jpeg,image/webp,image/jpg" class="text-sm"/>
</div>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">Image shown on the About Us page header. Default: /bloombit.jpg</p>
</div>
<div class="md:col-span-2">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Office Title</label>
<input id="settings-office-title" type="text" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars($settings['office_title']); ?>" placeholder="Registered Office"/>
</div>
<div class="md:col-span-2">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Office Address</label>
<textarea id="settings-office-address" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" rows="3" placeholder="Lindeyer Francis Ferguson&#10;North House, 198 High Street&#10;Tonbridge, Kent, TN9 1BE"><?php echo htmlspecialchars($settings['office_address']); ?></textarea>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">Office address shown on Help Centre page. Use &lt;br/&gt; for line breaks.</p>
</div>
<?php
$liveChatProvider = strtolower(trim((string) ($settings['live_chat_provider'] ?? '')));
if (!in_array($liveChatProvider, ['smartsupp', 'jivo', 'none'], true)) {
    $liveChatProvider = trim((string) ($settings['smartsupp_key'] ?? '')) !== '' ? 'smartsupp' : 'none';
}
?>
<div class="md:col-span-2 border-t border-slate-200 dark:border-zinc-700 pt-6 mt-2">
<h3 class="text-sm font-bold text-slate-700 dark:text-zinc-300 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-lg">forum</span> Live Chat Providers</h3>
<p class="text-xs text-slate-500 dark:text-zinc-400 mb-4">Enable only one provider at a time. The widget loads on the Live Chat page.</p>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
<div class="rounded-xl border border-slate-200 dark:border-zinc-700 p-4 space-y-3 bg-slate-50/50 dark:bg-zinc-800/30">
<div class="flex items-center justify-between gap-3">
<div>
<p class="text-sm font-bold">Smartsupp</p>
<p class="text-[11px] text-slate-500 dark:text-zinc-400">Use your Smartsupp account key</p>
</div>
<div class="flex items-center gap-2">
<input id="settings-smartsupp-enabled" class="sr-only peer" type="checkbox" <?php echo $liveChatProvider === 'smartsupp' ? 'checked' : ''; ?>/>
<label for="settings-smartsupp-enabled" class="relative w-11 h-6 bg-slate-200 dark:bg-zinc-700 rounded-full cursor-pointer peer-focus:ring-2 peer-focus:ring-primary/50 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5 peer-checked:bg-primary"></label>
</div>
</div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-1.5">Smartsupp Key</label>
<input id="settings-smartsupp-key" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-3 py-2.5 text-sm" value="<?php echo htmlspecialchars($settings['smartsupp_key']); ?>" placeholder="Your Smartsupp key"/>
</div>
<div class="rounded-xl border border-slate-200 dark:border-zinc-700 p-4 space-y-3 bg-slate-50/50 dark:bg-zinc-800/30">
<div class="flex items-center justify-between gap-3">
<div>
<p class="text-sm font-bold">JivoChat</p>
<p class="text-[11px] text-slate-500 dark:text-zinc-400">Paste widget ID from Jivo installation code</p>
</div>
<div class="flex items-center gap-2">
<input id="settings-jivo-enabled" class="sr-only peer" type="checkbox" <?php echo $liveChatProvider === 'jivo' ? 'checked' : ''; ?>/>
<label for="settings-jivo-enabled" class="relative w-11 h-6 bg-slate-200 dark:bg-zinc-700 rounded-full cursor-pointer peer-focus:ring-2 peer-focus:ring-primary/50 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5 peer-checked:bg-primary"></label>
</div>
</div>
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-1.5">Jivo Widget ID</label>
<input id="settings-jivo-widget-id" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-3 py-2.5 text-sm" value="<?php echo htmlspecialchars($settings['jivo_widget_id']); ?>" placeholder="e.g. AbCdEfGhIj"/>
<p class="text-[11px] text-slate-500 dark:text-zinc-400">From Jivo → Manage → Channels → Settings → Installation. You can paste the full script; we extract the ID.</p>
</div>
</div>
</div>
<div class="md:col-span-2">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Deposit Countdown Duration</label>
<?php $depMins = (int)($settings['deposit_countdown_minutes'] ?? '30'); if (!in_array($depMins, [5,15,30], true)) $depMins = 30; ?>
<select id="settings-deposit-countdown" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary">
  <option value="5" <?php echo $depMins===5?'selected':''; ?>>5 minutes</option>
  <option value="15" <?php echo $depMins===15?'selected':''; ?>>15 minutes</option>
  <option value="30" <?php echo $depMins===30?'selected':''; ?>>30 minutes</option>
</select>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">How long a user has to click “Done” after creating a deposit request before it auto-fails.</p>
</div>
<!-- Referral system -->
<div class="md:col-span-2 border-t border-slate-200 dark:border-zinc-700 pt-6 mt-4">
<h3 class="text-sm font-bold text-slate-700 dark:text-zinc-300 mb-3 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-lg">group_add</span> Referral System</h3>
<div class="flex flex-wrap items-center gap-6">
<div class="flex items-center gap-3">
<input id="settings-referral-enabled" class="sr-only peer" type="checkbox" <?php echo ($settings['referral_enabled'] ?? '0') === '1' ? 'checked' : ''; ?>/>
<label for="settings-referral-enabled" class="relative w-11 h-6 bg-slate-200 dark:bg-zinc-700 rounded-full cursor-pointer peer-focus:ring-2 peer-focus:ring-primary/50 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5 peer-checked:bg-primary"></label>
<span class="text-sm font-medium">Enable referral program</span>
</div>
<div class="flex items-center gap-2">
<label class="text-sm font-medium text-slate-700 dark:text-zinc-300">Direct referral (%)</label>
<input id="settings-referral-percentage" type="number" min="0" max="100" step="0.5" class="w-20 bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm" value="<?php echo htmlspecialchars($settings['referral_percentage'] ?? '15'); ?>"/>
</div>
<div class="flex items-center gap-2">
<label class="text-sm font-medium text-slate-700 dark:text-zinc-300">Upline / level 2 (%)</label>
<input id="settings-referral-level2-percentage" type="number" min="0" max="100" step="0.5" class="w-20 bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm" value="<?php echo htmlspecialchars($settings['referral_level2_percentage'] ?? '10'); ?>"/>
</div>
<div class="flex items-center gap-2">
<label class="text-sm font-medium text-slate-700 dark:text-zinc-300">Deposit bonus (%)</label>
<input id="settings-deposit-bonus-percentage" type="number" min="0" max="100" step="0.5" class="w-20 bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm" value="<?php echo htmlspecialchars($settings['deposit_bonus_percentage'] ?? '10'); ?>" title="Bonus credited to depositor on every approved deposit"/>
</div>
</div>
<p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">When enabled, users share a referral code at signup. Direct referrers earn the first rate on each referee&rsquo;s <strong>first approved deposit</strong> and on <strong>ongoing daily earnings</strong>. Their upline earns the level-2 rate on the same events (one level deep only). Deposit bonus is credited to the depositor separately.</p>
</div>
</div>
<button type="button" id="settings-save-branding" class="mt-4 px-6 py-2.5 bg-primary text-slate-900 font-bold rounded-lg hover:opacity-90">Save Branding</button>
<div id="settings-branding-msg" class="text-sm mt-2 hidden"></div>
</section>
</div>

<!-- Email Settings Tab -->
<div id="settings-panel-email" class="hidden">
<!-- Email Configuration -->
<section class="bg-white dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800 p-6">
<h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary">mail</span> Email Configuration</h2>
<p class="text-sm text-slate-500 dark:text-zinc-400 mb-6">Configure SMTP for sending and IMAP for receiving. Passwords are write-only (leave blank to keep current).</p>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <div class="bg-slate-50 dark:bg-zinc-800/50 border border-slate-200 dark:border-zinc-700 rounded-xl p-5">
    <h3 class="font-bold mb-4">SMTP (Sending)</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">SMTP Host</label>
        <input id="settings-smtp-host" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_smtp_host']); ?>" placeholder="smtp.yourdomain.com"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">SMTP Port</label>
        <input id="settings-smtp-port" type="number" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_smtp_port']); ?>" placeholder="587"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Encryption</label>
        <select id="settings-smtp-encryption" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5">
          <?php $smtpEnc = $settings['mail_smtp_encryption'] ?: 'tls'; ?>
          <option value="tls" <?php echo $smtpEnc==='tls'?'selected':''; ?>>TLS</option>
          <option value="ssl" <?php echo $smtpEnc==='ssl'?'selected':''; ?>>SSL</option>
          <option value="none" <?php echo $smtpEnc==='none'?'selected':''; ?>>None</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">SMTP Username</label>
        <input id="settings-smtp-username" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_smtp_username']); ?>" placeholder="user@yourdomain.com"/>
      </div>
      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300">SMTP Password</label>
          <span id="settings-smtp-pass-status" class="text-[11px] font-bold text-slate-500 dark:text-zinc-400"></span>
        </div>
        <input id="settings-smtp-password" type="password" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="" placeholder="Leave blank to keep"/>
      </div>
    </div>
  </div>

  <div class="bg-slate-50 dark:bg-zinc-800/50 border border-slate-200 dark:border-zinc-700 rounded-xl p-5">
    <h3 class="font-bold mb-4">From / Reply-To</h3>
    <div class="grid grid-cols-1 gap-4">
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">From Email</label>
        <input id="settings-mail-from-email" type="email" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_from_email']); ?>" placeholder="noreply@yourdomain.com"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">From Name</label>
        <input id="settings-mail-from-name" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_from_name']); ?>" placeholder="<?php echo htmlspecialchars($siteName); ?>"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Reply-To Email</label>
        <input id="settings-mail-reply-to" type="email" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_reply_to']); ?>" placeholder="support@yourdomain.com"/>
        <p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">Help Centre emails will be sent using the From above, and will reply back to this address.</p>
      </div>
    </div>
  </div>

  <div class="bg-slate-50 dark:bg-zinc-800/50 border border-slate-200 dark:border-zinc-700 rounded-xl p-5 lg:col-span-2">
    <h3 class="font-bold mb-4">IMAP (Receiving) — optional</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">IMAP Host</label>
        <input id="settings-imap-host" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_imap_host']); ?>" placeholder="imap.yourdomain.com"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">IMAP Port</label>
        <input id="settings-imap-port" type="number" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_imap_port']); ?>" placeholder="993"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">IMAP Username</label>
        <input id="settings-imap-username" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_imap_username']); ?>" placeholder="inbox@yourdomain.com"/>
      </div>
      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300">IMAP Password</label>
          <span id="settings-imap-pass-status" class="text-[11px] font-bold text-slate-500 dark:text-zinc-400"></span>
        </div>
        <input id="settings-imap-password" type="password" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="" placeholder="Leave blank to keep"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Encryption</label>
        <select id="settings-imap-encryption" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5">
          <?php $imapEnc = $settings['mail_imap_encryption'] ?: 'ssl'; ?>
          <option value="ssl" <?php echo $imapEnc==='ssl'?'selected':''; ?>>SSL</option>
          <option value="tls" <?php echo $imapEnc==='tls'?'selected':''; ?>>TLS</option>
          <option value="none" <?php echo $imapEnc==='none'?'selected':''; ?>>None</option>
        </select>
      </div>
      <div class="md:col-span-3">
        <label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Sent Folder Name</label>
        <input id="settings-imap-sent-folder" type="text" class="w-full bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5" value="<?php echo htmlspecialchars($settings['mail_imap_sent_folder']); ?>" placeholder="Sent (or [Gmail]/Sent Mail)"/>
        <p class="text-xs text-slate-500 dark:text-zinc-400 mt-2">Used for syncing your mailbox “Sent” items. Common values: <code>Sent</code>, <code>Sent Items</code>, <code>[Gmail]/Sent Mail</code>.</p>
      </div>
    </div>
  </div>
</div>

<button type="button" id="settings-save-email" class="mt-6 px-6 py-2.5 bg-primary text-slate-900 font-bold rounded-lg hover:opacity-90">Save Email Settings</button>
<div id="settings-email-msg" class="text-sm mt-2 hidden"></div>
</section>

<!-- Testing Section (after IMAP) -->
<section class="bg-white dark:bg-zinc-900 rounded-xl border border-slate-200 dark:border-zinc-800 p-6">
<h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary">science</span> Testing</h2>
<p class="text-sm text-slate-500 dark:text-zinc-400 mb-4">After saving your email configuration, send a test email to confirm everything works.</p>
<div class="flex flex-wrap gap-4 items-end mb-4">
<div class="flex-1 min-w-[200px]">
<label class="block text-sm font-medium text-slate-700 dark:text-zinc-300 mb-2">Email to receive test</label>
<input id="settings-test-email-to" type="email" class="w-full bg-slate-50 dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary" value="<?php echo htmlspecialchars($adminEmail); ?>" placeholder="test@example.com"/>
</div>
<button type="button" id="settings-send-test-email" class="px-6 py-2.5 bg-slate-800 text-white font-bold rounded-lg hover:bg-slate-700">Send Test Email</button>
</div>
<div id="settings-test-msg" class="text-sm mt-2 hidden"></div>
</section>
</div>

<?php require_once __DIR__ . '/../../includes/dashboard/admin-layout-end.php'; ?>
<?php require_once __DIR__ . '/../../includes/app-script.php'; ?>
<script>
(function(){
  var showMsg = function(el, text, ok){
    if (window.AdminUI && typeof window.AdminUI.showMsg === 'function') {
      window.AdminUI.showMsg(el, text, ok);
      return;
    }
    if (!el) return;
    el.textContent = text;
    el.className = 'text-sm mt-2 ' + (ok ? 'text-green-600' : 'text-red-600');
    el.classList.remove('hidden');
  };
  var setLoading = function(btn, loading, label){
    if (window.AdminUI && typeof window.AdminUI.setButtonLoading === 'function') {
      window.AdminUI.setButtonLoading(btn, loading, { label: label || 'Saving…' });
      return;
    }
    if (!btn) return;
    btn.disabled = !!loading;
  };

  // Tabs
  var tabBtns = {
    admin: document.getElementById('settings-tab-admin'),
    branding: document.getElementById('settings-tab-branding'),
    email: document.getElementById('settings-tab-email'),
  };
  var panels = {
    admin: document.getElementById('settings-panel-admin'),
    branding: document.getElementById('settings-panel-branding'),
    email: document.getElementById('settings-panel-email'),
  };
  function setActiveTab(key){
    Object.keys(panels).forEach(function(k){
      if (panels[k]) panels[k].classList.toggle('hidden', k !== key);
    });
    Object.keys(tabBtns).forEach(function(k){
      var b = tabBtns[k];
      if (!b) return;
      var active = (k === key);
      b.className = 'px-4 py-2 rounded-lg text-sm font-bold transition-colors ' +
        (active
          ? 'bg-primary text-slate-900'
          : 'bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-zinc-800');
    });
    try { localStorage.setItem('bloombit_admin_settings_tab', key); } catch (e) {}
  }
  if (tabBtns.admin) tabBtns.admin.addEventListener('click', function(){ setActiveTab('admin'); });
  if (tabBtns.branding) tabBtns.branding.addEventListener('click', function(){ setActiveTab('branding'); });
  if (tabBtns.email) tabBtns.email.addEventListener('click', function(){ setActiveTab('email'); });
  var initialTab = 'admin';
  try { initialTab = localStorage.getItem('bloombit_admin_settings_tab') || 'admin'; } catch (e) {}
  if (!panels[initialTab]) initialTab = 'admin';
  setActiveTab(initialTab);

  document.getElementById('settings-save-branding').addEventListener('click', function(){
    var siteName = document.getElementById('settings-site-name').value.trim();
    var contactEmail = document.getElementById('settings-contact-email').value.trim();
    var homepageYoutube = document.getElementById('settings-homepage-youtube').value.trim();
    var homepageYoutubeStart = parseInt((document.getElementById('settings-homepage-youtube-start') || {}).value || '0', 10);
    if (isNaN(homepageYoutubeStart) || homepageYoutubeStart < 0) homepageYoutubeStart = 0;
    var officeTitle = document.getElementById('settings-office-title').value.trim();
    var officeAddress = document.getElementById('settings-office-address').value.trim();
    var smartsuppKey = document.getElementById('settings-smartsupp-key').value.trim();
    var jivoWidgetId = (document.getElementById('settings-jivo-widget-id') || {}).value || '';
    jivoWidgetId = String(jivoWidgetId).trim();
    var smartsuppOn = !!(document.getElementById('settings-smartsupp-enabled') || {}).checked;
    var jivoOn = !!(document.getElementById('settings-jivo-enabled') || {}).checked;
    var liveChatProvider = 'none';
    if (smartsuppOn && jivoOn) {
      if (document.getElementById('settings-smartsupp-enabled')) document.getElementById('settings-smartsupp-enabled').checked = false;
      if (document.getElementById('settings-jivo-enabled')) document.getElementById('settings-jivo-enabled').checked = false;
      showMsg(document.getElementById('settings-branding-msg'), 'Only one live chat provider can be enabled at a time.', false);
      return;
    } else if (smartsuppOn) {
      if (!smartsuppKey) {
        showMsg(document.getElementById('settings-branding-msg'), 'Enter a Smartsupp key before enabling Smartsupp.', false);
        return;
      }
      liveChatProvider = 'smartsupp';
    } else if (jivoOn) {
      if (!jivoWidgetId) {
        showMsg(document.getElementById('settings-branding-msg'), 'Enter a JivoChat widget ID before enabling JivoChat.', false);
        return;
      }
      liveChatProvider = 'jivo';
    }
    var depositCountdown = (document.getElementById('settings-deposit-countdown') || {}).value || '30';
    var referralEnabled = (document.getElementById('settings-referral-enabled') || {}).checked ? '1' : '0';
    var referralPct = (document.getElementById('settings-referral-percentage') || {}).value;
    if (referralPct === '' || isNaN(parseFloat(referralPct))) referralPct = '15';
    var referralL2Pct = (document.getElementById('settings-referral-level2-percentage') || {}).value;
    if (referralL2Pct === '' || isNaN(parseFloat(referralL2Pct))) referralL2Pct = '10';
    var depositBonusPct = (document.getElementById('settings-deposit-bonus-percentage') || {}).value;
    if (depositBonusPct === '' || isNaN(parseFloat(depositBonusPct))) depositBonusPct = '10';
    var btn = this;
    var msgEl = document.getElementById('settings-branding-msg');
    showMsg(msgEl, 'Saving branding…', true);
    setLoading(btn, true, 'Saving…');
    fetch('/api/admin/site-settings.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify({
        site_name: siteName || <?php echo json_encode($siteName); ?>,
        contact_email: contactEmail || '',
        homepage_youtube_url: homepageYoutube || '',
        homepage_youtube_start_seconds: String(homepageYoutubeStart),
        office_title: officeTitle || '',
        office_address: officeAddress || '',
        smartsupp_key: smartsuppKey || '',
        jivo_widget_id: jivoWidgetId || '',
        live_chat_provider: liveChatProvider,
        deposit_countdown_minutes: depositCountdown,
        referral_enabled: referralEnabled,
        referral_percentage: referralPct,
        referral_level2_percentage: referralL2Pct,
        deposit_bonus_percentage: depositBonusPct
      })
    }).then(function(r){ return r.json(); }).then(function(res){
      showMsg(msgEl, res.success ? 'Branding saved successfully.' : (res.error || 'Failed'), res.success);
      setLoading(btn, false);
    }).catch(function(){
      showMsg(msgEl, 'Request failed.', false);
      setLoading(btn, false);
    });
  });

  (function setupLiveChatToggles(){
    var smartsuppCb = document.getElementById('settings-smartsupp-enabled');
    var jivoCb = document.getElementById('settings-jivo-enabled');
    if (!smartsuppCb || !jivoCb) return;
    smartsuppCb.addEventListener('change', function(){
      if (smartsuppCb.checked) jivoCb.checked = false;
    });
    jivoCb.addEventListener('change', function(){
      if (jivoCb.checked) smartsuppCb.checked = false;
    });
  })();

  function uploadAsset(type, fileInput, previewEl){
    if (!fileInput.files || !fileInput.files[0]) return Promise.resolve();
    var fd = new FormData();
    fd.append('type', type);
    fd.append('file', fileInput.files[0]);
    return fetch('/api/admin/upload-site-asset.php', { method: 'POST', credentials: 'same-origin', body: fd })
      .then(function(r){ return r.json(); })
      .then(function(res){
        if (res.success && res.data && res.data.url && previewEl) {
          previewEl.innerHTML = '<img src="' + res.data.url + '" alt="" class="w-full h-full object-contain"/>';
        }
        return res;
      });
  }

  document.getElementById('settings-logo-input').addEventListener('change', function(){
    var p = document.getElementById('settings-logo-preview');
    uploadAsset('logo', this, p).then(function(res){
      if (res && res.success) {
        fetch('/api/admin/site-settings.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, credentials: 'same-origin', body: JSON.stringify({ site_logo: res.data.url }) });
      }
    });
  });
  document.getElementById('settings-favicon-input').addEventListener('change', function(){
    var p = document.getElementById('settings-favicon-preview');
    uploadAsset('favicon', this, p).then(function(res){
      if (res && res.success) {
        fetch('/api/admin/site-settings.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, credentials: 'same-origin', body: JSON.stringify({ site_favicon: res.data.url }) });
      }
    });
  });
  document.getElementById('settings-modal-image-input').addEventListener('change', function(){
    var p = document.getElementById('settings-modal-image-preview');
    uploadAsset('modal_image', this, p).then(function(res){
      if (res && res.success) {
        fetch('/api/admin/site-settings.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, credentials: 'same-origin', body: JSON.stringify({ homepage_modal_image: res.data.url }) });
      }
    });
  });
  document.getElementById('settings-header-image-input').addEventListener('change', function(){
    var p = document.getElementById('settings-header-image-preview');
    uploadAsset('header_image', this, p).then(function(res){
      if (res && res.success) {
        fetch('/api/admin/site-settings.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, credentials: 'same-origin', body: JSON.stringify({ header_image: res.data.url }) });
      }
    });
  });

  document.getElementById('settings-save-admin').addEventListener('click', function(){
    var email = document.getElementById('settings-admin-email').value.trim();
    var curr = document.getElementById('settings-current-pw').value;
    var pw = document.getElementById('settings-new-pw').value;
    var conf = document.getElementById('settings-confirm-pw').value;
    var msgEl = document.getElementById('settings-admin-msg');
    if (pw && pw.length < 8) { showMsg(msgEl, 'New password must be at least 8 characters.', false); return; }
    if (pw && pw !== conf) { showMsg(msgEl, 'Passwords do not match.', false); return; }
    if (pw && !curr) { showMsg(msgEl, 'Current password required to change password.', false); return; }
    var payload = { email: email || undefined };
    if (pw) { payload.current_password = curr; payload.password = pw; }
    var btn = this;
    showMsg(msgEl, 'Updating account…', true);
    setLoading(btn, true, 'Updating…');
    fetch('/api/admin/admin-account.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify(payload)
    }).then(function(r){ return r.json(); }).then(function(res){
      showMsg(msgEl, res.success ? 'Account updated.' : (res.error || 'Failed'), res.success);
      setLoading(btn, false);
    }).catch(function(){
      showMsg(msgEl, 'Request failed.', false);
      setLoading(btn, false);
    });
  });

  document.getElementById('settings-send-test-email').addEventListener('click', function(){
    var btn = this;
    var msgEl = document.getElementById('settings-test-msg');
    var emailTo = (document.getElementById('settings-test-email-to') || {}).value.trim();
    if (!emailTo) { showMsg(msgEl, 'Enter an email address to receive the test.', false); return; }
    showMsg(msgEl, 'Sending test email…', true);
    setLoading(btn, true, 'Sending…');
    fetch('/api/admin/send-test-email.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify({ to: emailTo })
    })
      .then(function(r){ return r.json(); })
      .then(function(res){
        showMsg(msgEl, res.success ? (res.data && res.data.message) : (res.error || 'Failed'), res.success);
        setLoading(btn, false);
      })
      .catch(function(){
        showMsg(msgEl, 'Request failed.', false);
        setLoading(btn, false);
      });
  });

  // Load password-set flags (write-only fields)
  fetch('/api/admin/site-settings.php', { credentials: 'same-origin' })
    .then(function(r){ return r.json(); })
    .then(function(res){
      if (!res || !res.success || !res.data) return;
      var smtpSet = (res.data.mail_smtp_password_set === '1');
      var imapSet = (res.data.mail_imap_password_set === '1');
      var smtpEl = document.getElementById('settings-smtp-pass-status');
      var imapEl = document.getElementById('settings-imap-pass-status');
      if (smtpEl) smtpEl.textContent = smtpSet ? 'Password set' : 'Not set';
      if (imapEl) imapEl.textContent = imapSet ? 'Password set' : 'Not set';
    }).catch(function(){});

  document.getElementById('settings-save-email').addEventListener('click', function(){
    var msgEl = document.getElementById('settings-email-msg');
    var btn = this;
    var payload = {
      mail_smtp_host: document.getElementById('settings-smtp-host').value.trim(),
      mail_smtp_port: document.getElementById('settings-smtp-port').value.trim(),
      mail_smtp_encryption: document.getElementById('settings-smtp-encryption').value,
      mail_smtp_username: document.getElementById('settings-smtp-username').value.trim(),
      mail_smtp_password: document.getElementById('settings-smtp-password').value,
      mail_from_email: document.getElementById('settings-mail-from-email').value.trim(),
      mail_from_name: document.getElementById('settings-mail-from-name').value.trim(),
      mail_reply_to: document.getElementById('settings-mail-reply-to').value.trim(),
      mail_imap_host: document.getElementById('settings-imap-host').value.trim(),
      mail_imap_port: document.getElementById('settings-imap-port').value.trim(),
      mail_imap_encryption: document.getElementById('settings-imap-encryption').value,
      mail_imap_username: document.getElementById('settings-imap-username').value.trim(),
      mail_imap_password: document.getElementById('settings-imap-password').value,
      mail_imap_sent_folder: document.getElementById('settings-imap-sent-folder').value.trim(),
    };
    // Don't send blank passwords (keeps existing)
    if (!payload.mail_smtp_password) delete payload.mail_smtp_password;
    if (!payload.mail_imap_password) delete payload.mail_imap_password;
    showMsg(msgEl, 'Saving email settings…', true);
    setLoading(btn, true, 'Saving…');
    fetch('/api/admin/site-settings.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify(payload)
    }).then(function(r){ return r.json(); }).then(function(res){
      showMsg(msgEl, res.success ? 'Email settings saved.' : (res.error || 'Failed'), res.success);
      // clear password fields after save
      var sp = document.getElementById('settings-smtp-password'); if (sp) sp.value = '';
      var ip = document.getElementById('settings-imap-password'); if (ip) ip.value = '';
      setLoading(btn, false);
      if (res && res.success) {
        // refresh password-set flags
        fetch('/api/admin/site-settings.php', { credentials: 'same-origin' }).then(function(r){ return r.json(); }).then(function(r2){
          if (!r2 || !r2.success || !r2.data) return;
          var smtpEl = document.getElementById('settings-smtp-pass-status');
          var imapEl = document.getElementById('settings-imap-pass-status');
          if (smtpEl) smtpEl.textContent = (r2.data.mail_smtp_password_set === '1') ? 'Password set' : 'Not set';
          if (imapEl) imapEl.textContent = (r2.data.mail_imap_password_set === '1') ? 'Password set' : 'Not set';
        }).catch(function(){});
      }
    }).catch(function(){
      showMsg(msgEl, 'Request failed.', false);
      setLoading(btn, false);
    });
  });
})();
</script>
<?php require_once __DIR__ . '/../../includes/dashboard/admin-layout-close.php'; ?>