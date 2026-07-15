<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/session-bootstrap.php';
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'] ?? 'user';
    header('Location: ' . ($role === 'admin' ? '/dashboard/admin' : '/dashboard'));
    exit;
}
$siteName = get_site_name();
$pageTitle = 'Register | ' . $siteName;
$authBgStyle = 'register';
$refPrefill = isset($_GET['ref']) ? strtoupper(trim((string)$_GET['ref'])) : '';
?>
<!DOCTYPE html>
<html class="dark auth-fit-screen" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require_once __DIR__ . '/includes/auth-head.php'; ?>
</head>
<body class="auth-page auth-fit-screen font-body-md text-body-md">
<?php require_once __DIR__ . '/includes/auth-background.php'; ?>
<div class="auth-shell relative z-10 flex flex-col w-full">
<nav class="shrink-0 flex items-center px-4 md:px-margin-desktop h-14 md:h-16 w-full max-w-container-max mx-auto">
<a class="flex items-center gap-2 group transition-all" href="/">
<span class="material-symbols-outlined text-primary-container text-[20px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
<span class="font-label-sm text-label-sm text-on-surface-variant group-hover:text-primary-container">Back to home</span>
</a>
</nav>
<main class="auth-main flex items-center justify-center px-4 md:px-margin-mobile py-2 md:py-0">
<div class="w-full max-w-[480px]">
<div class="mb-4 md:mb-5 text-center md:text-left">
<h1 class="font-headline-md text-headline-md font-extrabold text-primary-container tracking-tight mb-1"><?php echo htmlspecialchars($siteName); ?></h1>
<h2 class="font-headline-md text-headline-md text-on-surface mb-1">Create Account</h2>
<p class="font-body-md text-body-md text-on-surface-variant text-sm md:text-base">Get started with your free account today.</p>
</div>
<div id="register-step-form" class="w-full">
<div class="auth-glass-card p-5 md:p-7 rounded-xl shadow-lg shadow-primary-container/5">
<form id="register-form" class="space-y-4" enctype="multipart/form-data">
<div class="w-full h-1 bg-surface-container rounded-full overflow-hidden">
<div id="register-progress" class="bg-primary-container h-full w-1/2 transition-all duration-300"></div>
</div>
<p class="font-label-xs text-label-xs text-on-surface-variant uppercase tracking-widest" id="register-step-label">Step 1 of 2 — Your details</p>
<div id="register-step-1" class="space-y-4">
<label class="flex items-center gap-3 border border-dashed border-border-low rounded-lg p-3 bg-white/5 hover:border-primary-container/50 transition-colors group cursor-pointer" for="avatar">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform overflow-hidden" id="avatar-preview">
<span class="material-symbols-outlined text-text-secondary text-xl">cloud_upload</span>
</div>
<div class="text-left min-w-0">
<span class="font-label-sm text-label-sm text-primary-container block">Upload Profile Photo <span class="text-text-secondary font-normal">(Optional)</span></span>
<span class="text-text-secondary text-xs">PNG, JPEG or WEBP. Max 2MB.</span>
</div>
<input name="avatar" id="avatar" class="sr-only" accept="image/png,image/jpeg,image/webp" type="file"/>
</label>
<div class="space-y-1.5">
<label class="font-label-sm text-label-sm text-on-surface-variant block uppercase tracking-widest" for="name">Full Name</label>
<div class="auth-field">
<span class="material-symbols-outlined auth-field-icon">person</span>
<input name="name" id="name" placeholder="John Doe" type="text" required autocomplete="name"/>
</div>
</div>
<div class="space-y-1.5">
<label class="font-label-sm text-label-sm text-on-surface-variant block uppercase tracking-widest" for="email">Email Address</label>
<div class="auth-field">
<span class="material-symbols-outlined auth-field-icon">mail</span>
<input name="email" id="email" placeholder="name@company.com" type="email" required autocomplete="email"/>
</div>
</div>
<div class="space-y-1.5">
<label class="font-label-sm text-label-sm text-on-surface-variant block uppercase tracking-widest" for="phone">Phone Number <span class="opacity-50">(Optional)</span></label>
<div class="auth-field">
<span class="material-symbols-outlined auth-field-icon">phone</span>
<input name="phone" id="phone" placeholder="+1 (555) 000-0000" type="tel" autocomplete="tel"/>
</div>
</div>
<div id="register-step1-message" class="text-sm text-red-400 hidden"></div>
<button type="button" id="register-step1-next" class="w-full bg-primary-container text-on-primary font-bold py-3 rounded-lg hover:bg-primary-container/90 transition-all shadow-lg shadow-primary-container/10 active:scale-95 flex items-center justify-center gap-2 group">
<span>Continue</span>
<span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</div>
<div id="register-step-2" class="space-y-4 hidden">
<div class="space-y-1.5">
<label class="font-label-sm text-label-sm text-on-surface-variant block uppercase tracking-widest" for="password">Password</label>
<div class="auth-field">
<span class="material-symbols-outlined auth-field-icon">lock</span>
<input name="password" id="password" placeholder="••••••••" type="password" required autocomplete="new-password"/>
<button type="button" data-password-toggle aria-label="Toggle password visibility">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
</div>
</div>
<div class="space-y-1.5">
<label class="font-label-sm text-label-sm text-on-surface-variant block uppercase tracking-widest" for="confirm-password">Confirm Password</label>
<div class="auth-field">
<span class="material-symbols-outlined auth-field-icon">lock_reset</span>
<input name="confirm_password" id="confirm-password" placeholder="••••••••" type="password" required autocomplete="new-password"/>
<button type="button" data-password-toggle aria-label="Toggle password visibility">
<span class="material-symbols-outlined text-[20px]">visibility</span>
</button>
</div>
</div>
<div class="space-y-1.5">
<label class="font-label-sm text-label-sm text-on-surface-variant block uppercase tracking-widest" for="referral">Referral Code <span class="opacity-50">(Optional)</span></label>
<div class="auth-field">
<span class="material-symbols-outlined auth-field-icon">card_giftcard</span>
<input class="uppercase tracking-widest" name="referral" id="referral" placeholder="FX-PRO-2024" type="text" value="<?php echo htmlspecialchars($refPrefill); ?>"/>
</div>
</div>
<div class="flex items-start gap-3 py-2">
<input class="mt-1 w-5 h-5 rounded border-border-low bg-bg-subtle text-primary-container focus:ring-primary-container/30" id="terms" type="checkbox"/>
<label class="font-body-md text-body-md text-on-surface-variant leading-tight text-sm" for="terms">
I agree to the <a class="text-primary-container hover:underline underline-offset-4" href="/legal_centre#terms">Terms of Service</a> and <a class="text-primary-container hover:underline underline-offset-4" href="/legal_centre#privacy">Privacy Policy</a>.
</label>
</div>
<div id="register-form-message" class="text-sm hidden"></div>
<div class="flex gap-3">
<button type="button" id="register-step2-back" class="flex-1 py-3 rounded-lg border border-border-low text-on-surface-variant font-bold hover:border-primary-container/50 transition-colors">
Back
</button>
<button type="submit" class="flex-[2] bg-primary-container text-on-primary font-bold py-3 rounded-lg hover:bg-primary-container/90 transition-all shadow-lg shadow-primary-container/10 active:scale-95 flex items-center justify-center gap-2 group">
<span>Create My Account</span>
<span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</div>
</div>
</form>
<div id="register-otp-step" class="space-y-4 hidden">
<h2 class="text-lg font-bold text-on-surface">Verify your email</h2>
<p class="text-on-surface-variant text-sm" id="register-otp-email-display"></p>
<p class="text-sm text-on-secondary-container">Enter the 6-digit code we sent to your email.</p>
<div class="flex gap-2 justify-center my-4" id="register-otp-inputs">
<?php for ($i = 1; $i <= 6; $i++): ?>
<input type="tel" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="<?php echo $i === 1 ? 'one-time-code' : 'off'; ?>" class="auth-otp-input w-11 h-12 text-center text-lg font-bold rounded-lg border border-outline-variant/30 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20" data-otp-digit aria-label="Digit <?php echo $i; ?>"/>
<?php endfor; ?>
</div>
<div id="register-otp-message" class="text-sm hidden"></div>
<button type="button" id="register-otp-resend" class="text-primary-container hover:underline text-sm font-medium disabled:opacity-50" disabled>Resend code (60s)</button>
<button type="button" id="register-otp-submit" class="w-full bg-primary-container hover:bg-primary-container/90 text-on-primary font-bold py-3 rounded-lg flex items-center justify-center gap-2">
Verify &amp; Continue
</button>
</div>
<div id="register-thank-you" class="hidden text-center py-6">
<div class="w-16 h-16 rounded-full bg-success/20 flex items-center justify-center mx-auto mb-4">
<span class="material-symbols-outlined text-success text-3xl">check_circle</span>
</div>
<h2 class="text-xl font-bold text-on-surface mb-2">Thank you!</h2>
<p class="text-on-surface-variant text-sm mb-4">Your account has been verified. Redirecting to your dashboard...</p>
</div>
<div class="mt-5 pt-5 border-t border-white/5 text-center">
<p class="font-label-xs text-label-xs text-on-surface-variant uppercase tracking-widest">Institutional grade security</p>
</div>
</div>
</div>
<p class="mt-4 text-center text-sm text-on-surface-variant" id="register-have-account">
Already have an account?
<a class="text-primary-fixed-dim font-bold hover:underline underline-offset-4 ml-1" href="/login">Log in here</a>
</p>
</div>
</main>
<footer class="shrink-0 h-10 md:h-12 flex items-center justify-center px-4 md:px-margin-desktop opacity-50">
<p class="font-label-xs text-label-xs text-on-surface-variant text-center leading-tight">
© <?php echo date('Y'); ?> <?php echo htmlspecialchars($siteName); ?>.
</p>
</footer>
</div>
<div class="gtranslate_wrapper"></div>
<?php require_once __DIR__ . '/includes/translation-widget.php'; ?>
<?php require_once __DIR__ . '/includes/live-chat-widget.php'; ?>
<?php require_once __DIR__ . '/includes/app-script.php'; ?>
<script>
(function () {
  var step1 = document.getElementById('register-step-1');
  var step2 = document.getElementById('register-step-2');
  var progress = document.getElementById('register-progress');
  var stepLabel = document.getElementById('register-step-label');
  var step1Msg = document.getElementById('register-step1-message');
  var form = document.getElementById('register-form');

  function showStep(n) {
    if (n === 1) {
      step1.classList.remove('hidden');
      step2.classList.add('hidden');
      progress.style.width = '50%';
      stepLabel.textContent = 'Step 1 of 2 — Your details';
    } else {
      step1.classList.add('hidden');
      step2.classList.remove('hidden');
      progress.style.width = '100%';
      stepLabel.textContent = 'Step 2 of 2 — Security & preferences';
    }
    step1Msg.classList.add('hidden');
  }

  document.getElementById('register-step1-next')?.addEventListener('click', function () {
    var name = form.querySelector('[name="name"]')?.value?.trim();
    var email = form.querySelector('[name="email"]')?.value?.trim();
    if (!name) {
      step1Msg.textContent = 'Full name is required.';
      step1Msg.classList.remove('hidden');
      return;
    }
    if (!email) {
      step1Msg.textContent = 'Email address is required.';
      step1Msg.classList.remove('hidden');
      return;
    }
    showStep(2);
    form.querySelector('[name="password"]')?.focus();
  });

  document.getElementById('register-step2-back')?.addEventListener('click', function () {
    showStep(1);
  });

  document.getElementById('avatar')?.addEventListener('change', function () {
    var f = this.files[0];
    var p = document.getElementById('avatar-preview');
    if (!p) return;
    if (f && /^image\/(png|jpeg|webp)$/.test(f.type)) {
      var r = new FileReader();
      r.onload = function () {
        p.innerHTML = '<img src="' + r.result + '" alt="" class="w-full h-full object-cover"/>';
      };
      r.readAsDataURL(f);
    } else {
      p.innerHTML = '<span class="material-symbols-outlined text-text-secondary text-xl">cloud_upload</span>';
    }
  });
})();
</script>
</body>
</html>
