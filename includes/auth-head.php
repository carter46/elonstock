<?php
/**
 * Shared head assets for auth pages (login, register, forgot/reset password).
 * Set $pageTitle before including.
 * Tokens / fonts aligned with Stock Wealth marketing-head.php.
 */
$pageTitle = $pageTitle ?? get_site_name();
?>
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<meta name="theme-color" content="#081422"/>
<?php output_favicon_tags(); ?>
<?php output_site_brand_meta_tags(); ?>
<?php require_once __DIR__ . '/pwa-head.php'; ?>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&amp;family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "on-secondary-fixed-variant": "#002ccd",
        "tertiary-container": "#9a7bff",
        "surface-container-high": "#1f2b3a",
        "secondary-fixed-dim": "#bbc3ff",
        "outline-variant": "#414755",
        "surface-container-low": "#111c2b",
        "on-surface": "#d7e3f7",
        "on-background": "#d7e3f7",
        "surface": "#081422",
        "outline": "#8b90a0",
        "on-surface-variant": "#c1c6d7",
        "inverse-on-surface": "#263140",
        "primary": "#adc6ff",
        "on-primary-fixed-variant": "#004493",
        "primary-fixed-dim": "#adc6ff",
        "surface-container": "#15202f",
        "error": "#ffb4ab",
        "tertiary": "#cdbdff",
        "on-primary": "#ffffff",
        "primary-fixed": "#d8e2ff",
        "on-primary-fixed": "#001a41",
        "surface-dim": "#081422",
        "surface-bright": "#2f3a49",
        "secondary-container": "#0231de",
        "primary-container": "#4b8eff",
        "background": "#081422",
        "secondary": "#bbc3ff",
        "on-primary-container": "#ffffff",
        "surface-variant": "#2a3645",
        "surface-container-lowest": "#040f1d",
        "inverse-surface": "#d7e3f7",
        "inverse-primary": "#005bc1",
        "error-container": "#93000a",
        "on-secondary-container": "#b1bbff",
        "surface-tint": "#adc6ff",
        "on-error-container": "#ffdad6",
        "surface-container-highest": "#2a3645",
        "border-low": "rgba(255, 255, 255, 0.08)",
        "text-secondary": "#c1c6d7",
        "text-primary": "#FFFFFF",
        "bg-subtle": "#111c2b",
        "success": "#20B26C",
        "critical": "#EF454A"
      },
      borderRadius: {
        "DEFAULT": "0.25rem",
        "lg": "0.5rem",
        "xl": "0.75rem",
        "full": "9999px"
      },
      spacing: {
        "container-max": "1440px",
        "section-padding": "96px",
        "margin-desktop": "32px",
        "margin-mobile": "16px",
        "gutter": "16px"
      },
      fontFamily: {
        "label-sm": ["Inter", "sans-serif"],
        "body-lg": ["Inter", "sans-serif"],
        "headline-lg": ["Hanken Grotesk", "sans-serif"],
        "headline-md": ["Hanken Grotesk", "sans-serif"],
        "body-md": ["Inter", "sans-serif"],
        "label-xs": ["Inter", "sans-serif"],
        "display": ["Hanken Grotesk", "sans-serif"]
      },
      fontSize: {
        "label-sm": ["14px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700"}],
        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
        "headline-lg": ["32px", {"lineHeight": "1.2", "fontWeight": "700"}],
        "headline-md": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
        "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
        "label-xs": ["12px", {"lineHeight": "1", "letterSpacing": "0.1em", "fontWeight": "800"}],
        "display": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "800"}]
      }
    }
  }
}
</script>
<style>
body.auth-page {
  background-color: #071321;
  color: #d7e3f7;
  -webkit-font-smoothing: antialiased;
}
html.auth-fit-screen,
body.auth-fit-screen {
  height: 100%;
  overflow: hidden;
}
body.auth-fit-screen {
  height: 100dvh;
}
.auth-shell {
  height: 100%;
  min-height: 0;
}
body.auth-fit-screen .auth-shell {
  height: 100dvh;
  overflow: hidden;
}
body.auth-fit-screen .auth-main {
  flex: 1 1 auto;
  min-height: 0;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  padding-top: 0;
  padding-bottom: 0.75rem;
  display: flex;
  flex-direction: column;
  align-items: stretch;
  justify-content: flex-start;
}
body.auth-fit-screen .auth-main-inner {
  width: 100%;
  max-width: 440px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 1rem;
  padding-right: 1rem;
  padding-top: 0.75rem;
}
body.auth-fit-screen .auth-main-inner.auth-main-inner--wide {
  max-width: 480px;
}
.auth-mobile-hero {
  width: 100%;
  margin: 0;
}
@media (min-width: 768px) {
  body.auth-fit-screen .auth-main {
    padding-top: 0.75rem;
    align-items: safe center;
    justify-content: center;
  }
  body.auth-fit-screen .auth-main-inner {
    padding-left: 0;
    padding-right: 0;
    padding-top: 0;
  }
}
.auth-glass-card {
  background: rgba(21, 32, 47, 0.88);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.08);
}
.auth-glass-panel {
  background: rgba(17, 28, 43, 0.8);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.08);
}
.auth-field {
  position: relative;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  background: #15202f;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 0.75rem;
  padding: 0.7rem 1rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.auth-field:focus-within {
  border-color: #4b8eff;
  box-shadow: 0 0 0 2px rgba(75, 142, 255, 0.25);
}
.auth-field-icon {
  flex-shrink: 0;
  color: #8b90a0;
  font-size: 20px;
  line-height: 1;
  pointer-events: none;
}
.auth-field input {
  flex: 1 1 auto;
  min-width: 0;
  width: 100%;
  background: transparent;
  border: none;
  padding: 0;
  margin: 0;
  color: #d7e3f7;
  font-size: 1rem;
  line-height: 1.5;
  outline: none;
  box-shadow: none;
}
.auth-field input::placeholder {
  color: #8b90a0;
}
.auth-field [data-password-toggle] {
  flex-shrink: 0;
  color: #8b90a0;
  padding: 0.125rem;
  margin-left: 0.25rem;
}
.auth-field [data-password-toggle]:hover {
  color: #4b8eff;
}
.auth-otp-input {
  background: #15202f !important;
  color: #d7e3f7 !important;
  border-color: rgba(255, 255, 255, 0.12) !important;
}
.auth-otp-input:focus {
  border-color: #4b8eff !important;
  box-shadow: 0 0 0 2px rgba(75, 142, 255, 0.22);
}
.gradient-button {
  background: linear-gradient(135deg, #ff5c1a 0%, #c41e0a 55%, #8b0000 100%);
  color: #ffffff;
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
  transition: filter 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.gradient-button:hover {
  filter: brightness(1.06);
  transform: translateY(-1px);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 8px 24px rgba(196, 30, 10, 0.35);
}
.material-symbols-outlined {
  font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}
@keyframes auth-glow {
  0%, 100% { opacity: 0.5; }
  50% { opacity: 0.85; }
}
.auth-glow { animation: auth-glow 4s ease-in-out infinite; }
</style>
