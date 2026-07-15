<?php
/**
 * Shared marketing page head assets (fonts, Tailwind config, base styles).
 * Include inside <head> on marketing pages.
 */
$pageTitle = $pageTitle ?? get_site_name();
?>
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<meta name="theme-color" content="#081422"/>
<?php output_favicon_tags(); ?>
<?php output_site_brand_meta_tags(); ?>
<?php require_once __DIR__ . '/pwa-head.php'; ?>
<?php if (!defined('BB_TV_MINI_CHART_SCRIPT')) { define('BB_TV_MINI_CHART_SCRIPT', true); ?>
<script type="module" src="https://widgets.tradingview-widget.com/w/en/tv-mini-chart.js"></script>
<?php } ?>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
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
        "on-tertiary-fixed": "#20005f",
        "tertiary-fixed": "#e8deff",
        "on-surface-variant": "#c1c6d7",
        "inverse-on-surface": "#263140",
        "primary": "#adc6ff",
        "on-tertiary-container": "#2f0084",
        "on-primary-fixed-variant": "#004493",
        "on-secondary-fixed": "#000f5d",
        "primary-fixed-dim": "#adc6ff",
        "on-tertiary": "#370096",
        "surface-container": "#15202f",
        "error": "#ffb4ab",
        "secondary-fixed": "#dee0ff",
        "tertiary": "#cdbdff",
        "on-primary": "#002e69",
        "primary-fixed": "#d8e2ff",
        "on-secondary": "#001d93",
        "on-error": "#690005",
        "on-primary-fixed": "#001a41",
        "on-tertiary-fixed-variant": "#4f00d0",
        "surface-dim": "#081422",
        "surface-bright": "#2f3a49",
        "secondary-container": "#0231de",
        "primary-container": "#4b8eff",
        "tertiary-fixed-dim": "#cdbdff",
        "background": "#081422",
        "secondary": "#bbc3ff",
        "on-primary-container": "#00285c",
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
        "unit-lg": "24px",
        "margin-desktop": "64px",
        "unit-xl": "48px",
        "unit-md": "16px",
        "gutter": "24px",
        "unit-sm": "8px",
        "container-max": "1440px",
        "margin-mobile": "20px",
        "unit-xs": "4px",
        "section-padding": "160px"
      },
      fontFamily: {
        "body-md": ["Inter", "sans-serif"],
        "headline-md": ["Hanken Grotesk", "sans-serif"],
        "label-sm": ["Inter", "sans-serif"],
        "label-md": ["Inter", "sans-serif"],
        "label-xs": ["Inter", "sans-serif"],
        "body-lg": ["Inter", "sans-serif"],
        "display-sm": ["Hanken Grotesk", "sans-serif"],
        "headline-lg-mobile": ["Hanken Grotesk", "sans-serif"],
        "headline-lg": ["Hanken Grotesk", "sans-serif"],
        "display-lg": ["Hanken Grotesk", "sans-serif"],
        "display": ["Hanken Grotesk", "sans-serif"],
        "data-mono": ["Inter", "sans-serif"]
      },
      fontSize: {
        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
        "label-xs": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
        "display-sm": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.03em", "fontWeight": "700"}],
        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
        "display-lg": ["72px", {"lineHeight": "80px", "letterSpacing": "-0.04em", "fontWeight": "700"}],
        "display": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "700"}],
        "data-mono": ["16px", {"lineHeight": "1", "letterSpacing": "-0.02em", "fontWeight": "500"}]
      }
    }
  }
}
</script>
<style>
#bb-global-loader,
#bb-global-loader-style {
  display: none !important;
  visibility: hidden !important;
  pointer-events: none !important;
}
body.marketing-page {
  background-color: #071321;
  color: #d7e3f7;
  overflow-x: hidden;
  scroll-behavior: smooth;
  -webkit-font-smoothing: antialiased;
}
.glass-nav {
  backdrop-filter: blur(24px);
  background: rgba(8, 20, 34, 0.8);
}
.glass-panel {
  background: rgba(21, 32, 47, 0.8);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.08);
}
.text-glow {
  text-shadow: 0 0 20px rgba(173, 198, 255, 0.4);
}
.marquee-track {
  display: flex;
  width: fit-content;
  animation: marquee 40s linear infinite;
}
@keyframes marquee {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}
.institutional-border {
  border: 1px solid rgba(255, 255, 255, 0.08);
}
.gradient-button,
.btn-get-started {
  background: linear-gradient(135deg, #4b8eff 0%, #002e69 100%);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
  color: #ffffff;
  border-radius: 9999px;
  transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
}
.gradient-button:hover,
.btn-get-started:hover {
  filter: brightness(1.06);
  transform: translateY(-1px);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 8px 24px rgba(75, 142, 255, 0.25);
}
.btn-secondary {
  background: transparent;
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #d7e3f7;
  border-radius: 9999px;
  transition: background 0.2s ease, border-color 0.2s ease;
}
.btn-secondary:hover {
  background: rgba(255, 255, 255, 0.05);
}
.refined-gradient {
  background: radial-gradient(circle at 50% 50%, rgba(173, 198, 255, 0.05) 0%, transparent 70%);
}
.atmosphere-grid {
  background-image:
    linear-gradient(rgba(173, 198, 255, 0.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(173, 198, 255, 0.04) 1px, transparent 1px);
  background-size: 64px 64px;
  mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
}
.atmosphere-noise {
  background-image: radial-gradient(rgba(173, 198, 255, 0.03) 1px, transparent 1px);
  background-size: 3px 3px;
  opacity: 0.35;
}
.reveal-up {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal-up.active {
  opacity: 1;
  transform: translateY(0);
}
.trading-card {
  background: rgba(21, 32, 47, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: 1.25rem;
  transition: all 0.3s ease;
  backdrop-filter: blur(8px);
}
.trading-card:hover {
  background: rgba(21, 32, 47, 0.9);
  border-color: rgba(173, 198, 255, 0.2);
  transform: translateY(-4px);
}
.glow-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #4b8eff;
  box-shadow: 0 0 10px #4b8eff;
}
.hero-section {
  background-color: #081422;
}
.hero-gradient {
  background: radial-gradient(circle at top right, rgba(173, 198, 255, 0.08), transparent 50%),
              radial-gradient(circle at bottom left, rgba(8, 20, 34, 1), transparent 80%);
}
.hero-bg {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-color: #071321;
}
.hero-bg-overlay {
  background:
    linear-gradient(
      to bottom,
      rgba(7, 19, 33, 0.88) 0%,
      rgba(7, 19, 33, 0.78) 35%,
      rgba(7, 19, 33, 0.92) 70%,
      rgba(7, 19, 33, 0.98) 100%
    ),
    rgba(7, 19, 33, 0.55);
}
.img-institutional {
  filter: saturate(0.85) contrast(1.05) brightness(0.92);
}
.market-card-link {
  position: relative;
}
.market-view-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #d7e3f7;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid transparent;
  transition: background 0.2s ease;
  text-decoration: none;
}
.market-view-btn:hover {
  background: rgba(255, 255, 255, 0.1);
}
.pulse-live {
  box-shadow: 0 0 0 0 rgba(75, 142, 255, 0.7);
  animation: pulse-blue 2s infinite;
}
@keyframes pulse-blue {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(75, 142, 255, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(75, 142, 255, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(75, 142, 255, 0); }
}
.market-detail-chart-wrap {
  position: relative;
  overflow: hidden;
}
.market-detail-chart-wrap tv-mini-chart {
  display: block;
  width: 100% !important;
  max-width: 100%;
  height: 360px !important;
  margin-bottom: -32px;
}
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
.stock-market-card,
.forex-market-card {
  min-height: 168px;
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: hidden;
}
.stock-market-card tv-mini-chart,
.forex-market-card tv-mini-chart {
  display: block;
  width: 100% !important;
  max-width: 100%;
  height: 220px !important;
  max-height: 220px;
  margin: 0 auto -20px;
}
@media (max-width: 640px) {
  .stock-market-card tv-mini-chart,
  .forex-market-card tv-mini-chart {
    height: 180px !important;
    max-height: 180px;
  }
}
.section-large { padding-top: 160px; padding-bottom: 160px; }
.section-medium { padding-top: 128px; padding-bottom: 128px; }
.section-small { padding-top: 96px; padding-bottom: 96px; }
@media (max-width: 768px) {
  .section-large { padding-top: 96px; padding-bottom: 96px; }
  .section-medium { padding-top: 80px; padding-bottom: 80px; }
  .section-small { padding-top: 64px; padding-bottom: 64px; }
  .font-display-lg.text-display-lg,
  h1.font-display-lg {
    font-size: 40px !important;
    line-height: 48px !important;
  }
  .font-display-sm.text-display-sm,
  h2.font-display-sm {
    font-size: 32px !important;
    line-height: 40px !important;
  }
}
</style>
<script>
(function () {
  function stripLoader() {
    var el = document.getElementById('bb-global-loader');
    var style = document.getElementById('bb-global-loader-style');
    if (el) el.remove();
    if (style) style.remove();
  }
  stripLoader();
  document.addEventListener('DOMContentLoaded', stripLoader);
  if (typeof MutationObserver !== 'undefined' && document.documentElement) {
    new MutationObserver(stripLoader).observe(document.documentElement, { childList: true, subtree: true });
  }
})();
</script>
