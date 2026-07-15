<?php
/**
 * Shared Marketing Header
 */
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/session-bootstrap.php';
$siteName = get_site_name();
$currentUser = get_current_user_data();
$isLoggedIn = !empty($currentUser);
$current = $currentPage ?? '';

$navClass = function ($active) {
    return $active
        ? 'font-label-md text-label-md text-primary'
        : 'font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors';
};
$helpActive = ($current === 'help_centre' || $current === 'live_chat');
$mobileClass = function ($active) {
    return $active ? 'text-primary' : 'text-on-surface-variant';
};
?>
<nav class="fixed top-0 w-full z-[100] glass-nav h-20 border-b border-white/5" id="marketing-nav">
<div class="max-w-container-max mx-auto h-full flex justify-between items-center px-margin-mobile md:px-margin-desktop">
<a href="/" class="font-display-sm text-headline-lg text-primary tracking-tighter shrink-0 truncate">
<?php echo htmlspecialchars($siteName); ?>
</a>
<div class="hidden md:flex items-center gap-unit-lg">
<a class="<?php echo $navClass($current === 'home'); ?>" href="/">Home</a>
<a class="<?php echo $navClass($current === 'trading_signals'); ?>" href="/trading_signals">Markets</a>
<a class="<?php echo $navClass($current === 'about_us'); ?>" href="/about_us">About Us</a>
<a class="<?php echo $navClass($helpActive); ?>" href="/help_centre">Help Center</a>
<a class="<?php echo $navClass($current === 'legal_centre'); ?>" href="/legal_centre">Legal</a>
</div>
<div class="flex items-center gap-unit-md shrink-0">
<?php if ($isLoggedIn): ?>
<a href="/logout" class="hidden sm:inline-flex px-4 py-2 font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors">Logout</a>
<a href="/dashboard" class="hidden md:inline-flex gradient-button px-unit-lg py-2.5 font-label-sm text-label-sm uppercase tracking-widest items-center">Dashboard</a>
<?php else: ?>
<a href="/login" class="hidden sm:inline-flex px-4 py-2 font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors">Login</a>
<a href="/register" class="hidden md:inline-flex gradient-button px-unit-lg py-2.5 font-label-sm text-label-sm uppercase tracking-widest items-center">Get Started</a>
<?php endif; ?>
<button type="button" id="mobile-menu-btn" class="md:hidden w-11 h-11 flex items-center justify-center rounded-full hover:bg-white/5 transition-colors text-on-surface-variant" aria-label="Open menu" aria-expanded="false">
<span class="material-symbols-outlined">menu</span>
</button>
</div>
</div>
<div id="mobile-menu" class="hidden md:hidden border-t border-white/5 bg-surface-container-lowest">
<div class="max-w-container-max mx-auto px-margin-mobile py-4 flex flex-col gap-1">
<a class="py-3 px-4 rounded-xl hover:bg-white/5 font-label-md <?php echo $mobileClass($current === 'home'); ?>" href="/">Home</a>
<a class="py-3 px-4 rounded-xl hover:bg-white/5 font-label-md <?php echo $mobileClass($current === 'trading_signals'); ?>" href="/trading_signals">Markets</a>
<a class="py-3 px-4 rounded-xl hover:bg-white/5 font-label-md <?php echo $mobileClass($current === 'about_us'); ?>" href="/about_us">About Us</a>
<a class="py-3 px-4 rounded-xl hover:bg-white/5 font-label-md <?php echo $mobileClass($helpActive); ?>" href="/help_centre">Help Center</a>
<a class="py-3 px-4 rounded-xl hover:bg-white/5 font-label-md <?php echo $mobileClass($current === 'legal_centre'); ?>" href="/legal_centre">Legal</a>
<button type="button" data-pwa-install="menu" class="hidden py-3 px-4 rounded-xl hover:bg-white/5 font-label-md text-on-surface-variant text-left w-full border border-white/10" data-pwa-label>Install App</button>
<?php if ($isLoggedIn): ?>
<a class="py-3 px-4 mt-2 border-t border-white/5 pt-4 font-label-sm text-white font-bold gradient-button text-center uppercase tracking-widest" href="/dashboard">Dashboard</a>
<a class="py-3 px-4 font-label-md text-on-surface-variant" href="/logout">Logout</a>
<?php else: ?>
<a class="py-3 px-4 mt-2 border-t border-white/5 pt-4 font-label-md text-on-surface-variant" href="/login">Login</a>
<a class="py-3 px-4 font-label-sm text-white font-bold gradient-button text-center uppercase tracking-widest" href="/register">Get Started</a>
<?php endif; ?>
</div>
</div>
</nav>
<script>
(function(){
var btn=document.getElementById('mobile-menu-btn');
var menu=document.getElementById('mobile-menu');
if(btn&&menu){
btn.addEventListener('click',function(){
var open=menu.classList.toggle('hidden');
btn.setAttribute('aria-expanded',!open);
btn.querySelector('.material-symbols-outlined').textContent=open?'menu':'close';
});
menu.querySelectorAll('a, button[data-pwa-install]').forEach(function(el){el.addEventListener('click',function(){menu.classList.add('hidden');btn.setAttribute('aria-expanded','false');btn.querySelector('.material-symbols-outlined').textContent='menu';});});
}
})();
</script>
