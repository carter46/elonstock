<?php
/**
 * Investment plan types and display helpers.
 */

function get_plan_types(): array
{
    return [
        'crypto' => 'Crypto',
        'stocks' => 'Stocks',
        'forex' => 'Forex',
        'equities' => 'Equities',
        'shares' => 'Shares',
        'real_estate' => 'Real Estate',
        'commodities' => 'Commodities',
    ];
}

function normalize_plan_type(?string $type): string
{
    $types = get_plan_types();
    $key = strtolower(trim((string) $type));
    return isset($types[$key]) ? $key : 'crypto';
}

function plan_type_label(?string $type): string
{
    $types = get_plan_types();
    $key = normalize_plan_type($type);
    return $types[$key];
}

function plan_display_initial(string $name): string
{
    $name = trim($name);
    if ($name === '') {
        return '?';
    }
    if (preg_match('/\(([^)]+)\)/', $name, $m)) {
        $inner = trim($m[1]);
        if ($inner !== '') {
            return strtoupper(substr($inner, 0, 1));
        }
    }
    return strtoupper(substr($name, 0, 1));
}

function plan_logo_markup(?string $logoUrl, string $name, string $sizeClass = 'w-10 h-10', string $textClass = 'text-sm'): string
{
    $initial = htmlspecialchars(plan_display_initial($name), ENT_QUOTES, 'UTF-8');
    if (!empty($logoUrl)) {
        return '<img src="' . htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') . '" alt="" class="' . htmlspecialchars($sizeClass, ENT_QUOTES, 'UTF-8') . ' rounded-full object-cover shrink-0 bg-surface-container"/>';
    }
    return '<div class="' . htmlspecialchars($sizeClass, ENT_QUOTES, 'UTF-8') . ' rounded-full bg-surface-container flex items-center justify-center text-primary-container font-bold shrink-0 ' . htmlspecialchars($textClass, ENT_QUOTES, 'UTF-8') . '">' . $initial . '</div>';
}

function ensure_plan_schema(PDO $pdo): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    $columns = [
        'plan_type' => "ALTER TABLE plans ADD COLUMN plan_type VARCHAR(32) NOT NULL DEFAULT 'crypto' AFTER slug",
        'logo_url' => 'ALTER TABLE plans ADD COLUMN logo_url VARCHAR(255) NULL AFTER icon',
        'investment_risk' => "ALTER TABLE plans ADD COLUMN investment_risk VARCHAR(16) NOT NULL DEFAULT 'mid' AFTER logo_url",
        'liquidation_cost' => 'ALTER TABLE plans ADD COLUMN liquidation_cost DECIMAL(18,2) NOT NULL DEFAULT 0.00 AFTER withdrawal_days',
        'tv_symbol' => 'ALTER TABLE plans ADD COLUMN tv_symbol VARCHAR(80) NULL AFTER investment_risk',
        'tv_embed' => 'ALTER TABLE plans ADD COLUMN tv_embed LONGTEXT NULL AFTER tv_symbol',
        'chart_title' => 'ALTER TABLE plans ADD COLUMN chart_title VARCHAR(120) NULL AFTER tv_embed',
        'chart_pair_label' => 'ALTER TABLE plans ADD COLUMN chart_pair_label VARCHAR(64) NULL AFTER chart_title',
        'chart_market_type' => 'ALTER TABLE plans ADD COLUMN chart_market_type VARCHAR(64) NULL AFTER chart_pair_label',
        'chart_exchange' => 'ALTER TABLE plans ADD COLUMN chart_exchange VARCHAR(80) NULL AFTER chart_market_type',
        'chart_hours' => 'ALTER TABLE plans ADD COLUMN chart_hours VARCHAR(80) NULL AFTER chart_exchange',
        'chart_volatility' => 'ALTER TABLE plans ADD COLUMN chart_volatility VARCHAR(64) NULL AFTER chart_hours',
        'chart_suitable_for' => 'ALTER TABLE plans ADD COLUMN chart_suitable_for VARCHAR(160) NULL AFTER chart_volatility',
    ];

    foreach ($columns as $column => $ddl) {
        try {
            $stmt = $pdo->prepare(
                'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?'
            );
            $stmt->execute(['plans', $column]);
            if ((int) $stmt->fetchColumn() === 0) {
                $pdo->exec($ddl);
            }
        } catch (Throwable $e) {
            // Ignore if INFORMATION_SCHEMA is restricted; API save may still fail with a clear error.
        }
    }
}

function format_plan_period_return(float $dailyYieldPercent, int $durationDays): string
{
    if ($durationDays < 1) {
        $durationDays = 1;
    }
    $totalPercent = $dailyYieldPercent * $durationDays;
    return number_format($totalPercent, 2) . '%';
}

function get_investment_risk_options(): array
{
    return [
        'high' => 'High Risk',
        'mid' => 'Mid Risk',
        'low' => 'Low Risk',
    ];
}

function normalize_investment_risk(?string $risk): string
{
    $options = get_investment_risk_options();
    $key = strtolower(trim((string) $risk));
    if ($key === 'medium' || $key === 'med') {
        $key = 'mid';
    }
    return isset($options[$key]) ? $key : 'mid';
}

/** @return array{label: string, class: string} */
function plan_investment_risk_badge(?string $risk): array
{
    $key = normalize_investment_risk($risk);
    $label = get_investment_risk_options()[$key];
    $classes = [
        'high' => 'bg-critical text-white',
        'mid' => 'bg-primary-container text-on-primary',
        'low' => 'bg-success text-white',
    ];
    return ['label' => $label, 'class' => $classes[$key]];
}

function plan_duration_days(array $plan): int
{
    if (isset($plan['min_duration_days']) && $plan['min_duration_days'] !== null) {
        return max(1, (int) $plan['min_duration_days']);
    }
    if (isset($plan['duration_days'])) {
        return max(1, (int) $plan['duration_days']);
    }
    return 1;
}

/** Maps investment plan_type to market-instruments category (crypto, stock, forex). */
function plan_type_market_category(?string $type): ?string
{
    $key = strtolower(trim((string) $type));
    $map = [
        'crypto' => 'crypto',
        'stocks' => 'stock',
        'equities' => 'stock',
        'shares' => 'stock',
        'forex' => 'forex',
    ];
    return $map[$key] ?? null;
}

/** Every investment plan has a View Trading page (chart widget is optional). */
function plan_has_live_markets($planOrType): bool
{
    return is_array($planOrType);
}

/** Short display name for chart features (strips trailing ticker in parentheses). */
function plan_chart_display_name(array $plan): string
{
    $name = trim((string) ($plan['chart_title'] ?? ''));
    if ($name === '') {
        $name = trim((string) ($plan['name'] ?? 'Asset'));
    }
    $name = preg_replace('/\s*\([^)]*\)\s*$/', '', $name) ?? $name;
    return $name !== '' ? $name : 'Asset';
}

/**
 * Feature bullets for View Trading.
 * Defaults: Live {Name} chart + 3 fixed lines. First line is always dynamic.
 * If admin set custom features, first line is still Live {Name} chart, then their extras.
 */
function plan_display_features(array $plan): array
{
    $live = 'Live ' . plan_chart_display_name($plan) . ' chart';
    $defaults = [
        $live,
        'AI trading signals',
        'Daily yield accrual',
        '24/7 market monitoring',
    ];
    $custom = $plan['features'] ?? [];
    if (!is_array($custom) || $custom === []) {
        return $defaults;
    }
    $rest = [];
    foreach ($custom as $feature) {
        $text = trim((string) $feature);
        if ($text === '' || preg_match('/^Live\s+.+\s+chart$/i', $text)) {
            continue;
        }
        $rest[] = $text;
    }
    return array_values(array_unique(array_merge([$live], $rest)));
}

/** Light cleanup for admin-pasted TradingView embed HTML. */
function normalize_plan_tv_embed(?string $html): ?string
{
    $html = trim((string) $html);
    if ($html === '') {
        return null;
    }
    // Strip event-handler attributes; admin-sourced embeds from TradingView are otherwise kept.
    $html = preg_replace('/\son[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? $html;
    if (strlen($html) > 100000) {
        return null;
    }
    return $html;
}

/** Extract symbol from a pasted <tv-mini-chart symbol="..."> snippet. */
function plan_extract_tv_mini_symbol(?string $html): ?string
{
    $html = (string) $html;
    if ($html === '') {
        return null;
    }
    if (preg_match('/<tv-mini-chart\b[^>]*\bsymbol\s*=\s*["\']([^"\']+)["\']/i', $html, $m)) {
        $symbol = trim($m[1]);
        return $symbol !== '' ? $symbol : null;
    }
    return null;
}

/**
 * Best-effort symbol from pasted TradingView HTML (mini-chart, widget JSON, or copyright links).
 */
function plan_extract_tv_symbol_from_embed(?string $html): ?string
{
    $mini = plan_extract_tv_mini_symbol($html);
    if ($mini) {
        return $mini;
    }
    $html = (string) $html;
    if ($html === '') {
        return null;
    }
    if (preg_match('/"symbol"\s*:\s*"([A-Za-z0-9_.:\-]+)"/', $html, $m)) {
        $symbol = trim($m[1]);
        return $symbol !== '' ? $symbol : null;
    }
    // Market overview / multi-symbol widgets: [["EXCHANGE:TICKER|1D"]] or [["Label","EXCHANGE:TICKER|1D"]]
    if (preg_match('/"symbols"\s*:\s*\[\s*\[\s*(?:"[^"]*"\s*,\s*)?"([A-Za-z0-9_.:\-]+)(?:\|[^"]*)?"/', $html, $m)) {
        $symbol = trim($m[1]);
        return $symbol !== '' ? $symbol : null;
    }
    if (preg_match('#tradingview\.com/symbols/([A-Za-z0-9_]+)-([A-Za-z0-9_]+)/#i', $html, $m)) {
        return strtoupper($m[1] . ':' . $m[2]);
    }
    return null;
}

/**
 * Resolve the live chart symbol for a plan.
 * Pasted embed always wins over a stale tv_symbol left from older crypto plans.
 */
function plan_resolve_tv_symbol(array $plan, ?string $tvEmbed = null): string
{
    if ($tvEmbed === null && array_key_exists('tv_embed', $plan)) {
        $tvEmbed = normalize_plan_tv_embed($plan['tv_embed'] ?? null);
    }
    $stored = trim((string) ($plan['tv_symbol'] ?? ''));
    $fromEmbed = plan_extract_tv_symbol_from_embed($tvEmbed);
    if ($fromEmbed) {
        return $fromEmbed;
    }
    if ($tvEmbed !== null && trim((string) $tvEmbed) !== '') {
        // Full widget embed drives the chart; ignore leftover DB symbols.
        return '';
    }
    if ($stored === '') {
        return '';
    }
    $planType = normalize_plan_type($plan['plan_type'] ?? 'crypto');
    // Renamed non-crypto plans often still have BINANCE:BTCUSDT etc. in tv_symbol.
    if ($planType !== 'crypto' && preg_match('/^(BINANCE|BITSTAMP|COINBASE|KRAKEN|BITFINEX|BYBIT):/i', $stored)) {
        return '';
    }
    return $stored;
}

/**
 * True when embed is only a tv-mini-chart (optional script tag) — prefer native widget render.
 */
function plan_tv_embed_is_mini_chart_only(?string $html): bool
{
    $html = trim((string) $html);
    if ($html === '' || stripos($html, 'tv-mini-chart') === false) {
        return false;
    }
    $stripped = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;
    $stripped = preg_replace('/<tv-mini-chart\b[^>]*\/?>/i', '', $stripped) ?? $stripped;
    $stripped = trim(html_entity_decode(strip_tags($stripped), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    return $stripped === '';
}

/**
 * Build View Trading panel config entirely from the plan row.
 * Chart widget (tv_embed) is optional — page still works without it.
 */
function plan_market_instrument(array $plan): array
{
    $slug = strtolower(trim((string) ($plan['slug'] ?? '')));
    $tvEmbed = normalize_plan_tv_embed($plan['tv_embed'] ?? null);
    $tvSymbol = plan_resolve_tv_symbol($plan, $tvEmbed);
    // Prefer native <tv-mini-chart> path (homepage-sized) over clipped raw embed HTML.
    if ($tvEmbed !== null && plan_tv_embed_is_mini_chart_only($tvEmbed)) {
        $tvEmbed = null;
    }
    $category = plan_type_market_category($plan['plan_type'] ?? '') ?? 'crypto';
    $defaultType = function_exists('plan_type_label')
        ? plan_type_label($plan['plan_type'] ?? 'crypto')
        : ucfirst($category);
    $marketType = trim((string) ($plan['chart_market_type'] ?? ''));
    if ($marketType === '') {
        $marketType = $defaultType;
    }
    $title = plan_chart_display_name($plan);
    $pair = trim((string) ($plan['chart_pair_label'] ?? ''));
    $exchange = trim((string) ($plan['chart_exchange'] ?? ''));
    $hours = trim((string) ($plan['chart_hours'] ?? ''));
    $volatility = trim((string) ($plan['chart_volatility'] ?? ''));
    $suitable = trim((string) ($plan['chart_suitable_for'] ?? ''));

    return [
        'slug' => $slug !== '' ? $slug : 'custom',
        'name' => $title,
        'symbol' => $tvSymbol,
        'embed_html' => $tvEmbed,
        'category' => $category,
        'coingecko_id' => null,
        'pair_label' => $pair,
        'intro' => (string) ($plan['description'] ?? ''),
        'snapshot' => [
            'market_type' => $marketType !== '' ? $marketType : '—',
            'exchange' => $exchange !== '' ? $exchange : '—',
            'hours' => $hours !== '' ? $hours : '—',
            'volatility' => $volatility !== '' ? $volatility : '—',
            'suitable_for' => $suitable !== '' ? $suitable : '—',
        ],
    ];
}
