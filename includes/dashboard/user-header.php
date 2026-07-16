<?php
/**
 * Sticky top bar — sticks within the scrolling main column.
 */
$u = get_current_user_data() ?? [];
$userName = $u['name'] ?? 'User';
$avatarUrl = $u['avatar_url'] ?? null;
$initials = strtoupper(substr($userName ?: 'U', 0, 2));
$isVerified = !empty($u['verified']) || (($u['kyc_status'] ?? '') === 'approved');
$tierLabel = $isVerified ? 'Verified Institutional' : 'Member';
?>
<header class="user-topbar fixed top-0 left-0 right-0 lg:left-64 z-50 h-20 w-auto flex justify-between items-center px-4 md:px-8 border-b border-white/10 bg-surface-dim/95 backdrop-blur-xl shrink-0 gap-3">
<div class="flex items-center gap-3 md:gap-4">
<button type="button" id="user-sidebar-toggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-container-high transition-colors" aria-label="Toggle menu">
<span class="material-symbols-outlined text-on-surface">menu</span>
</button>
<div class="flex items-center gap-2 bg-surface-container rounded-full px-4 py-1.5 border border-white/5">
<span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
<span class="text-[12px] font-medium text-on-surface-variant">Systems Operational</span>
</div>
</div>
<a href="/dashboard/user/profile" class="flex items-center gap-3 group">
<div class="text-right hidden sm:block">
<p class="text-label-md font-bold text-on-surface leading-none truncate max-w-[140px]"><?php echo htmlspecialchars($userName); ?></p>
<p class="text-[11px] text-on-surface-variant mt-1"><?php echo htmlspecialchars($tierLabel); ?></p>
</div>
<div class="w-10 h-10 rounded-full border-2 border-primary/20 p-0.5 overflow-hidden group-hover:border-primary transition-colors shrink-0">
<?php if ($avatarUrl): ?>
<img alt="" class="w-full h-full object-cover rounded-full" src="<?php echo htmlspecialchars($avatarUrl); ?>"/>
<?php else: ?>
<div class="w-full h-full rounded-full bg-surface-container-highest flex items-center justify-center text-primary font-bold text-sm"><?php echo htmlspecialchars($initials); ?></div>
<?php endif; ?>
</div>
</a>
</header>
<div class="gtranslate_wrapper"></div>
<?php require_once __DIR__ . '/../translation-widget.php'; ?>
<style>
.gtranslate_wrapper { left: auto !important; right: 20px !important; bottom: 20px !important; top: auto !important; }
@media (max-width: 768px) { .gtranslate_wrapper { right: 12px !important; bottom: 12px !important; } }
</style>
