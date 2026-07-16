<?php
/**
 * Shared <head> for user dashboard pages. Set $pageTitle before including layout-start.
 * Stock Wealth institutional terminal tokens.
 */
$pageTitle = $pageTitle ?? (get_site_name() . ' | Dashboard');
?>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="theme-color" content="#081422"/>
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<?php if (function_exists('output_favicon_tags')) { output_favicon_tags(); } ?>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "on-background": "#d7e3f7",
        "on-secondary-fixed-variant": "#002ccd",
        "tertiary-fixed": "#e8deff",
        "secondary-fixed-dim": "#bbc3ff",
        "error-container": "#93000a",
        "surface-container": "#15202f",
        "secondary-fixed": "#dee0ff",
        "surface-tint": "#adc6ff",
        "on-tertiary-container": "#2f0084",
        "on-surface-variant": "#c1c6d7",
        "surface-bright": "#2f3a49",
        "on-tertiary-fixed-variant": "#4f00d0",
        "surface-container-high": "#1f2b3a",
        "on-primary-fixed-variant": "#004493",
        "surface-variant": "#2a3645",
        "on-error-container": "#ffdad6",
        "on-primary-container": "#00285c",
        "inverse-primary": "#005bc1",
        "on-secondary": "#001d93",
        "on-primary": "#002e69",
        "outline": "#8b90a0",
        "surface-container-low": "#111c2b",
        "on-secondary-fixed": "#000f5d",
        "on-secondary-container": "#b1bbff",
        "tertiary": "#cdbdff",
        "outline-variant": "#414755",
        "error": "#ffb4ab",
        "tertiary-fixed-dim": "#cdbdff",
        "inverse-surface": "#d7e3f7",
        "surface-container-lowest": "#040f1d",
        "on-tertiary-fixed": "#20005f",
        "surface-container-highest": "#2a3645",
        "secondary": "#bbc3ff",
        "primary-fixed": "#d8e2ff",
        "surface-dim": "#081422",
        "primary-fixed-dim": "#adc6ff",
        "on-tertiary": "#370096",
        "on-surface": "#d7e3f7",
        "background": "#081422",
        "tertiary-container": "#9a7bff",
        "on-primary-fixed": "#001a41",
        "surface": "#081422",
        "inverse-on-surface": "#263140",
        "secondary-container": "#0231de",
        "primary": "#adc6ff",
        "on-error": "#690005",
        "primary-container": "#4b8eff",
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
        "unit-xl": "48px",
        "unit-lg": "24px",
        "gutter": "24px",
        "unit-sm": "8px",
        "unit-md": "16px",
        "container-max": "1440px",
        "margin-mobile": "20px",
        "margin-desktop": "64px",
        "unit-xs": "4px"
      },
      fontFamily: {
        "headline-lg-mobile": ["Hanken Grotesk", "sans-serif"],
        "body-md": ["Inter", "sans-serif"],
        "display-lg": ["Hanken Grotesk", "sans-serif"],
        "headline-lg": ["Hanken Grotesk", "sans-serif"],
        "headline-md": ["Hanken Grotesk", "sans-serif"],
        "label-sm": ["Inter", "sans-serif"],
        "label-md": ["Inter", "sans-serif"],
        "label-xs": ["Inter", "sans-serif"],
        "display-sm": ["Hanken Grotesk", "sans-serif"],
        "body-lg": ["Inter", "sans-serif"],
        "display": ["Hanken Grotesk", "sans-serif"],
        "data-mono": ["Inter", "sans-serif"]
      },
      fontSize: {
        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
        "display-lg": ["72px", {"lineHeight": "80px", "letterSpacing": "-0.04em", "fontWeight": "700"}],
        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
        "label-xs": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
        "display-sm": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.03em", "fontWeight": "700"}],
        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
        "data-mono": ["16px", {"lineHeight": "1", "letterSpacing": "-0.02em", "fontWeight": "500"}],
        "display": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "700"}]
      }
    }
  }
};
</script>
<style>
body.user-dashboard {
  background-color: #071321;
  color: #d7e3f7;
  font-family: 'Inter', sans-serif;
  -webkit-font-smoothing: antialiased;
  overflow-x: hidden;
}
.font-headline { font-family: 'Hanken Grotesk', sans-serif; }
.glass-card,
.glass-panel {
  background: rgba(16, 27, 51, 0.4);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
}
.noise-overlay {
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  pointer-events: none;
  opacity: 0.012;
  z-index: 9999;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
}
.glow-line {
  filter: drop-shadow(0 0 4px rgba(173, 198, 255, 0.4));
}
.status-pill-green {
  background: rgba(34, 197, 94, 0.1);
  color: #4ade80;
  border: 1px solid rgba(34, 197, 94, 0.2);
}
.premium-gradient-btn {
  background: linear-gradient(135deg, #4B8EFF 0%, #002ccd 100%);
  box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
  color: #ffffff;
}
.chart-gradient, .trading-graph-bg {
  background: linear-gradient(180deg, rgba(75, 142, 255, 0.15) 0%, rgba(75, 142, 255, 0) 100%);
}
.scanning-animation {
  background: linear-gradient(90deg, transparent 0%, rgba(75, 142, 255, 0.12) 50%, transparent 100%);
  background-size: 200% 100%;
  animation: dash-scan 2s infinite linear;
}
@keyframes dash-scan {
  from { background-position: 200% 0; }
  to { background-position: -200% 0; }
}
.material-symbols-outlined {
  font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
  vertical-align: middle;
}
.dash-scrollbar::-webkit-scrollbar { width: 4px; }
.dash-scrollbar::-webkit-scrollbar-track { background: transparent; }
.dash-scrollbar::-webkit-scrollbar-thumb { background: rgba(75,142,255,0.3); border-radius: 10px; }
.user-dash-main {
  box-sizing: border-box;
  min-width: 0;
  max-width: 100%;
}
.user-dash-content {
  max-width: 1600px;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
  min-width: 0;
  overflow-x: clip;
}
.metric-balance-card,
.metric-balance-card.glass-card {
  background: linear-gradient(135deg, #0a1f3d 0%, #0d3b6e 45%, #002e69 100%);
  border: 1px solid rgba(75, 142, 255, 0.25);
  box-shadow: 0 4px 30px rgba(0, 46, 105, 0.25);
  backdrop-filter: none;
}
.dash-page,
.wallet-page {
  width: 100%;
  max-width: 100%;
  min-width: 0;
  overflow-x: clip;
}
.user-topbar {
  padding-top: env(safe-area-inset-top, 0px);
  min-height: calc(5rem + env(safe-area-inset-top, 0px));
}
#live-notification {
  transition: opacity 0.5s ease, transform 0.5s ease;
}
#live-notification.is-visible {
  opacity: 1 !important;
  transform: translateY(0);
}
#live-notification:not(.is-visible) {
  opacity: 0;
  transform: translateY(0.5rem);
}
.dash-trade-tab.is-active {
  color: #adc6ff;
  border-bottom-color: #4b8eff;
  font-weight: 700;
}
@keyframes fade-in {
  from { opacity: 0; transform: translateY(0.5rem); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.6s ease both; }
/* Hide TradingView “by TradingView” attribution under plan embeds */
.plan-tv-embed .tradingview-widget-copyright,
.plan-market-chart-wrap .tradingview-widget-copyright,
.plan-tv-embed .tv-widget-copyright,
.plan-market-chart-wrap a[href*="tradingview.com"]:not(iframe) {
  display: none !important;
  height: 0 !important;
  margin: 0 !important;
  padding: 0 !important;
  overflow: hidden !important;
  visibility: hidden !important;
  pointer-events: none !important;
}
/* Clip in-iframe TradingView footer when attribution can’t be removed from HTML */
.plan-tv-embed {
  max-height: 380px;
}
.plan-tv-embed iframe {
  margin-bottom: -28px !important;
}
</style>
<?php if (!empty($pageExtraStyles)) { echo $pageExtraStyles; } ?>
