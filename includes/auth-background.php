<?php
/**
 * Atmospheric background for auth pages.
 * $authBgStyle: 'login' | 'register' | 'simple'
 * Desktop: full-bleed photo background. Mobile: solid only (hero image is in-page).
 */
$authBgStyle = $authBgStyle ?? 'simple';
$loginBg = '/uploads/images/fleets_tuk.webp';
$registerBg = '/uploads/images/msjd_spadd.jpg';
$contactBg = '/uploads/images/contact_bg.png';

if ($authBgStyle === 'login') {
    $authDesktopBg = $loginBg;
    $authMobileHero = $loginBg;
    $authDesktopOpacity = '0.40';
} elseif ($authBgStyle === 'register') {
    $authDesktopBg = $registerBg;
    $authMobileHero = $registerBg;
    $authDesktopOpacity = '0.38';
} else {
    $authDesktopBg = $contactBg;
    $authMobileHero = null;
    $authDesktopOpacity = '0.28';
}
?>
<div class="fixed inset-0 z-0 overflow-hidden pointer-events-none" aria-hidden="true">
<div class="absolute inset-0 bg-[#071321]"></div>
<?php if ($authBgStyle === 'login' || $authBgStyle === 'register'): ?>
<img alt="" class="auth-desktop-bg absolute inset-0 w-full h-full object-cover hidden md:block" style="opacity: <?php echo htmlspecialchars($authDesktopOpacity); ?>" src="<?php echo htmlspecialchars($authDesktopBg); ?>"/>
<div class="absolute inset-0 hidden md:block bg-gradient-to-tr from-[#040f1d] via-[#081422]/75 to-[#081422]/45"></div>
<div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-container/10 blur-[120px] rounded-full auth-glow hidden md:block"></div>
<div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-primary/10 blur-[140px] rounded-full auth-glow hidden md:block"></div>
<?php else: ?>
<img alt="" class="absolute inset-0 w-full h-full object-cover opacity-28" src="<?php echo htmlspecialchars($authDesktopBg); ?>"/>
<div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#071321]/60 to-[#071321]"></div>
<div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-80 h-80 bg-primary-container/10 blur-[100px] rounded-full auth-glow"></div>
<?php endif; ?>
</div>
<?php if (!empty($authMobileHero)): ?>
<?php
// Mobile hero markup for inclusion inside auth-main (caller echoes $authMobileHeroHtml).
ob_start();
?>
<section class="auth-mobile-hero md:hidden w-full shrink-0" aria-hidden="true">
<img alt="" class="block w-full h-[38vh] min-h-[200px] max-h-[320px] object-cover" src="<?php echo htmlspecialchars($authMobileHero); ?>"/>
<div class="h-3 bg-gradient-to-b from-transparent to-[#071321]"></div>
</section>
<?php
$authMobileHeroHtml = ob_get_clean();
?>
<?php endif; ?>
