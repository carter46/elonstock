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

    // Backfill chart fields from the static market registry only when empty (legacy seeded plans).
    try {
        $chk = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'plans' AND COLUMN_NAME = 'tv_symbol'");
        if ($chk && (int) $chk->fetchColumn() > 0) {
            if (!function_exists('market_instruments_all')) {
                require_once __DIR__ . '/market-instruments.php';
            }
            $upd = $pdo->prepare(
                'UPDATE plans SET
                    tv_symbol = COALESCE(NULLIF(tv_symbol, \'\'), ?),
                    chart_title = COALESCE(NULLIF(chart_title, \'\'), ?),
                    chart_pair_label = COALESCE(NULLIF(chart_pair_label, \'\'), ?)
                 WHERE slug = ?'
            );
            foreach (market_instruments_all() as $inst) {
                $sym = trim((string) ($inst['symbol'] ?? ''));
                $slug = trim((string) ($inst['slug'] ?? ''));
                if ($sym === '' || $slug === '') {
                    continue;
                }
                $upd->execute([
                    $sym,
                    (string) ($inst['name'] ?? ''),
                    (string) ($inst['pair_label'] ?? $sym),
                    $slug,
                ]);
            }
        }
    } catch (Throwable $e) {
        // Non-fatal
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

function plan_has_live_markets($planOrType): bool
{
    if (is_array($planOrType)) {
        return plan_market_instrument($planOrType) !== null;
    }
    return false;
}

/** Normalize TradingView symbol input (e.g. BINANCE:BTCUSDT). */
function normalize_plan_tv_symbol(?string $symbol): ?string
{
    $sym = strtoupper(trim((string) $symbol));
    if ($sym === '') {
        return null;
    }
    // Allow EXCHANGE:TICKER or plain TICKER
    if (!preg_match('/^[A-Z0-9._-]{1,40}(:[A-Z0-9._-]{1,40})?$/', $sym)) {
        return null;
    }
    return $sym;
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

/**
 * Build the View Trading chart config from plan DB fields (fully dynamic).
 * Falls back to the static market registry only when chart fields are empty and slug matches.
 */
function plan_market_instrument(array $plan): ?array
{
    $slug = strtolower(trim((string) ($plan['slug'] ?? '')));
    $tvSymbol = normalize_plan_tv_symbol($plan['tv_symbol'] ?? null);
    $tvEmbed = normalize_plan_tv_embed($plan['tv_embed'] ?? null);
    $category = plan_type_market_category($plan['plan_type'] ?? '') ?? 'crypto';
    $typeLabel = function_exists('plan_type_label')
        ? plan_type_label($plan['plan_type'] ?? 'crypto')
        : ucfirst($category);
    $title = trim((string) ($plan['chart_title'] ?? ''));
    if ($title === '') {
        $title = trim((string) ($plan['name'] ?? 'Market'));
    }
    $pair = trim((string) ($plan['chart_pair_label'] ?? ''));
    if ($pair === '') {
        $pair = $tvSymbol ?: $title;
    }

    if ($tvSymbol !== null || $tvEmbed !== null) {
        return [
            'slug' => $slug !== '' ? $slug : 'custom',
            'name' => $title,
            'symbol' => $tvSymbol ?? '',
            'embed_html' => $tvEmbed,
            'category' => $category,
            'coingecko_id' => null,
            'pair_label' => $pair,
            'intro' => (string) ($plan['description'] ?? ''),
            'snapshot' => [
                'market_type' => $typeLabel,
            ],
        ];
    }

    // Legacy: slug still matches a built-in market page instrument
    if ($slug !== '') {
        if (!function_exists('get_market_instrument')) {
            require_once __DIR__ . '/market-instruments.php';
        }
        return get_market_instrument($slug);
    }

    return null;
}
