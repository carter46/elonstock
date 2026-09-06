<?php
/**
 * User dashboard sidebar — Stock Wealth institutional terminal.
 */
$current = $currentPage ?? '';
$siteName = $siteName ?? get_site_name();
$impersonating = isset($_SESSION['impersonate_admin_id']);
$navActive = function ($page) use ($current) {
    if ($current === $page) {
        return 'flex items-center gap-3 px-6 py-3 text-primary font-bold border-r-4 border-primary bg-primary/5 transition-all duration-200';
    }
    return 'flex items-center gap-3 px-6 py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-bright transition-all duration-200';
};
$iconFill = function ($page) use ($current) {
    return $current === $page ? " style=\"font-variation-settings: 'FILL' 1;\"" : '';
};
?>
<div id="user-sidebar-overlay" class="fixed inset-0 bg-black/60 z-[55] lg:hidden hidden" aria-hidden="true"></div>
<aside id="user-sidebar" class="h-full w-64 fixed left-0 top-0 bg-surface-container-lowest flex flex-col py-unit-lg h-screen z-[60] border-r border-white/5 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-out">
<div class="px-6 mb-10 shrink-0">
<a href="/dashboard/user/dashboard" class="block max-w-full" aria-label="<?php echo htmlspecialchars($siteName); ?>">
<?php echo site_brand_markup('h-11 w-auto max-w-full object-contain object-left', 'font-headline-md text-headline-md text-primary tracking-tighter'); ?>
</a>
<p class="text-[10px] text-on-surface-variant uppercase tracking-widest mt-1 opacity-60">Institutional Terminal</p>
</div>
<?php if ($impersonating): ?>
<a href="/api/admin/stop-impersonate.php" class="mx-4 mb-3 flex items-center gap-2 px-3 py-2 bg-primary-container/15 text-primary-container rounded-lg hover:bg-primary-container/25 transition-colors text-sm font-semibold shrink-0">
<span class="material-symbols-outlined text-lg">admin_panel_settings</span>
Switch back to Admin
</a>
<?php endif; ?>
<nav class="flex-grow min-h-0 space-y-1 overflow-y-auto dash-scrollbar overscroll-contain">
<div class="px-4 py-2 text-[10px] text-on-surface-variant font-bold uppercase tracking-widest opacity-40">Main Console</div>
<a class="<?php echo $navActive('dashboard'); ?>" href="/dashboard/user/dashboard">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('dashboard'); ?>>dashboard</span>
<span class="font-label-md text-label-md">Dashboard</span>
</a>
<a class="<?php echo $navActive('investment-plans'); ?>" href="/dashboard/user/investment-plans">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('investment-plans'); ?>>auto_awesome</span>
<span class="font-label-md text-label-md">Investment Plans</span>
</a>
<a class="<?php echo $navActive('wallet'); ?>" href="/dashboard/user/wallet">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('wallet'); ?>>account_balance_wallet</span>
<span class="font-label-md text-label-md">Wallet</span>
</a>
<a class="<?php echo $navActive('analytics'); ?>" href="/dashboard/user/analytics">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('analytics'); ?>>pie_chart</span>
<span class="font-label-md text-label-md">My Portfolio</span>
</a>
<a class="<?php echo $navActive('history'); ?>" href="/dashboard/user/transactions">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('history'); ?>>receipt_long</span>
<span class="font-label-md text-label-md">Orders</span>
</a>
<a class="<?php echo $navActive('referrals'); ?>" href="/dashboard/user/referrals">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('referrals'); ?>>group</span>
<span class="font-label-md text-label-md">Referrals</span>
</a>
<div class="px-4 py-6 text-[10px] text-on-surface-variant font-bold uppercase tracking-widest opacity-40">System</div>
<a class="<?php echo $navActive('profile'); ?>" href="/dashboard/user/profile">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('profile'); ?>>settings</span>
<span class="font-label-md text-label-md">Settings</span>
</a>
<a class="<?php echo $navActive('kyc'); ?>" href="/dashboard/user/kyc">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('kyc'); ?>>verified_user</span>
<span class="font-label-md text-label-md">KYC</span>
</a>
<a class="<?php echo $navActive('support'); ?>" href="/live_chat">
<span class="material-symbols-outlined text-[20px]"<?php echo $iconFill('support'); ?>>contact_support</span>
<span class="font-label-md text-label-md">Support</span>
</a>
</nav>
<div class="px-4 mt-auto space-y-3 shrink-0">
<a href="/dashboard/user/wallet?action=deposit" class="w-full premium-gradient-btn text-white font-label-md text-label-md py-3 rounded-lg flex items-center justify-center gap-2 hover:opacity-90 active:scale-[0.98] transition-all">
<span class="material-symbols-outlined text-[18px]">add_circle</span>
Deposit Funds
</a>
<button type="button" data-logout class="w-full text-on-surface-variant hover:text-error font-label-md text-label-md py-2 rounded-lg flex items-center justify-center gap-2 transition-colors">
<span class="material-symbols-outlined text-[18px]">logout</span>
Sign Out
</button>
</div>
</aside>
<style>
#user-sidebar {
  height: 100vh;
  height: 100dvh;
  max-height: 100dvh;
  padding-bottom: env(safe-area-inset-bottom, 0px);
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var overlay = document.getElementById('user-sidebar-overlay');
  var sidebar = document.getElementById('user-sidebar');
  var toggleBtn = document.getElementById('user-sidebar-toggle');
  function open() {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
  function close() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
  }
  if (toggleBtn) toggleBtn.addEventListener('click', open);
  if (overlay) overlay.addEventListener('click', close);
});
</script>
