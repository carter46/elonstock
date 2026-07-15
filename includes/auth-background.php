<?php
/**
 * Atmospheric background for auth pages.
 * $authBgStyle: 'login' | 'register' | 'simple'
 */
$authBgStyle = $authBgStyle ?? 'simple';
$chartBg = '/uploads/images/chart_bg.jpg';
$bannerBg = '/uploads/images/banner_bg.jpg';
$contactBg = '/uploads/images/contact_bg.png';
?>
<div class="fixed inset-0 z-0 overflow-hidden pointer-events-none" aria-hidden="true">
<?php if ($authBgStyle === 'login'): ?>
<div class="absolute inset-0 bg-[#071321]"></div>
<img alt="" class="absolute inset-0 w-full h-full object-cover opacity-35" src="<?php echo htmlspecialchars($chartBg); ?>"/>
<div class="absolute inset-0 bg-gradient-to-tr from-[#040f1d] via-[#081422]/70 to-[#081422]/40"></div>
<div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-container/10 blur-[120px] rounded-full auth-glow"></div>
<div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-primary/10 blur-[140px] rounded-full auth-glow"></div>
<?php elseif ($authBgStyle === 'register'): ?>
<div class="absolute inset-0 bg-[#071321]"></div>
<img alt="" class="absolute inset-0 w-full h-full object-cover opacity-30" src="<?php echo htmlspecialchars($bannerBg); ?>"/>
<div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#071321]/55 to-[#071321]"></div>
<div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-container/10 blur-[120px] rounded-full auth-glow"></div>
<div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-secondary-container/10 blur-[140px] rounded-full auth-glow"></div>
<?php else: ?>
<div class="absolute inset-0 bg-[#071321]"></div>
<img alt="" class="absolute inset-0 w-full h-full object-cover opacity-28" src="<?php echo htmlspecialchars($contactBg); ?>"/>
<div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#071321]/60 to-[#071321]"></div>
<div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-80 h-80 bg-primary-container/10 blur-[100px] rounded-full auth-glow"></div>
<?php endif; ?>
</div>
