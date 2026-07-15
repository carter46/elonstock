<?php
/**
 * Bloombit - Chart Data API
 * GET /api/user/chart-data.php?period=1D|1W|1M|1Y
 */

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/includes/session-bootstrap.php';
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$period = $_GET['period'] ?? '1M';
$type = $_GET['type'] ?? 'dashboard'; // 'dashboard' or 'analytics'
$days = match($period) {
    '1D' => 1,
    '1W' => 7,
    '1M' => 30,
    '1Y' => 365,
    'ALL' => 9999,
    default => 30
};

require_once dirname(__DIR__, 2) . '/includes/investment-lifecycle.php';
require_once dirname(__DIR__, 2) . '/includes/usd-wallet.php';

try {
    $pdo = require dirname(__DIR__, 2) . '/includes/db.php';
    $userId = (int) $_SESSION['user_id'];
    $chartData = [];

    if ($type === 'analytics') {
        $intervalClause = $period === 'ALL' ? '' : ' AND created_at >= DATE_SUB(NOW(), INTERVAL ' . (int)$days . ' DAY)';
        $chartExclude = portfolio_chart_reference_exclude_sql();
        $stmt = $pdo->prepare("SELECT DATE(created_at) as date, type, SUM(COALESCE(amount_usd, amount)) as total FROM transactions WHERE user_id = ? AND status = 'completed' AND type IN ('deposit','withdrawal','payout','profit_adjustment'){$chartExclude} $intervalClause GROUP BY DATE(created_at), type ORDER BY date ASC");
        $stmt->execute([$userId]);
        $dailyData = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $date = $row['date'];
            if (!isset($dailyData[$date])) $dailyData[$date] = ['deposit' => 0, 'withdrawal' => 0, 'payout' => 0];
            $txType = $row['type'] === 'profit_adjustment' ? 'payout' : $row['type'];
            if (isset($dailyData[$date][$txType])) {
                $dailyData[$date][$txType] += (float)$row['total'];
            }
        }
        $cumulative = 0;
        if ($period === 'ALL') {
            foreach ($dailyData as $date => $amounts) {
                $cumulative += (float)($amounts['deposit'] ?? 0) - (float)($amounts['withdrawal'] ?? 0) + (float)($amounts['payout'] ?? 0);
                $chartData[] = ['date' => $date, 'value' => $cumulative];
            }
        } else {
            $openStmt = $pdo->prepare("SELECT COALESCE(SUM(CASE WHEN type IN ('deposit','payout') OR (type = 'profit_adjustment' AND COALESCE(amount_usd, amount) >= 0) THEN COALESCE(amount_usd, amount) WHEN type = 'withdrawal' OR (type = 'profit_adjustment' AND COALESCE(amount_usd, amount) < 0) THEN -ABS(COALESCE(amount_usd, amount)) ELSE 0 END), 0) FROM transactions WHERE user_id = ? AND status = 'completed' AND type IN ('deposit','withdrawal','payout','profit_adjustment')" . portfolio_chart_reference_exclude_sql() . " AND created_at < DATE_SUB(CURDATE(), INTERVAL ? DAY)");
            $openStmt->execute([$userId, max(0, $days - 1)]);
            $cumulative = (float) $openStmt->fetchColumn();
            $endDay = new DateTimeImmutable('today');
            $startDay = $endDay->modify('-' . max(0, $days - 1) . ' days');
            for ($d = $startDay; $d <= $endDay; $d = $d->modify('+1 day')) {
                $key = $d->format('Y-m-d');
                if (isset($dailyData[$key])) {
                    $cumulative += (float)($dailyData[$key]['deposit'] ?? 0) - (float)($dailyData[$key]['withdrawal'] ?? 0) + (float)($dailyData[$key]['payout'] ?? 0);
                }
                $chartData[] = ['date' => $key, 'value' => $cumulative];
            }
        }
    } else {
        $lookback = max(0, $days - 1);
        $openStmt = $pdo->prepare("SELECT COALESCE(SUM(CASE WHEN type = 'deposit' THEN amount WHEN type = 'withdrawal' THEN -amount ELSE 0 END), 0) FROM transactions WHERE user_id = ? AND type IN ('deposit', 'withdrawal') AND created_at < DATE_SUB(CURDATE(), INTERVAL ? DAY)");
        $openStmt->execute([$userId, $lookback]);
        $openingBalance = (float) $openStmt->fetchColumn();
        $stmt = $pdo->prepare("SELECT DATE(created_at) as date, type, SUM(amount) as total FROM transactions WHERE user_id = ? AND type IN ('deposit', 'withdrawal') AND created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY) GROUP BY DATE(created_at), type ORDER BY date ASC");
        $stmt->execute([$userId, $lookback]);
        $dailyData = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $date = $row['date'];
            if (!isset($dailyData[$date])) $dailyData[$date] = ['deposit' => 0, 'withdrawal' => 0];
            $dailyData[$date][$row['type']] = (float)$row['total'];
        }
        $cumulative = $openingBalance;
        $endDay = new DateTimeImmutable('today');
        $startDay = $endDay->modify('-' . $lookback . ' days');
        for ($d = $startDay; $d <= $endDay; $d = $d->modify('+1 day')) {
            $key = $d->format('Y-m-d');
            if (isset($dailyData[$key])) {
                $cumulative += (float)$dailyData[$key]['deposit'] - (float)$dailyData[$key]['withdrawal'];
            }
            $chartData[] = ['date' => $key, 'value' => $cumulative];
        }
        $hasMovement = abs($cumulative - $openingBalance) > 0.0001;
        if (!$hasMovement) {
            $balance = get_user_spendable_usd_balance($pdo, $userId);
            if ($balance > 0) {
                foreach ($chartData as $i => $point) {
                    $chartData[$i]['value'] = (float) $balance;
                }
            }
        }
        // Ensure at least two points so the line renders for 1D
        if (count($chartData) === 1) {
            $only = $chartData[0];
            $prev = (new DateTimeImmutable($only['date']))->modify('-1 day')->format('Y-m-d');
            array_unshift($chartData, ['date' => $prev, 'value' => $only['value']]);
        }
    }

    echo json_encode(['success' => true, 'data' => $chartData]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to load chart data']);
}
