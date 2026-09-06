<?php
/**
 * Admin audit log API
 * GET  /api/admin/audit-log.php?page=1&per_page=30&entity_type=&action=&search=
 * POST /api/admin/audit-log.php { "action": "clear" } — delete every audit log row
 */

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/includes/session-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-audit-log.php';

if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    $pdo = require dirname(__DIR__, 2) . '/includes/db.php';
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database unavailable']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input') ?: '{}', true) ?? $_POST ?? [];
    $action = trim((string) ($input['action'] ?? ''));
    if ($action !== 'clear' && $action !== 'reset') {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        exit;
    }
    try {
        $deleted = clear_admin_audit_logs($pdo);
        echo json_encode([
            'success' => true,
            'message' => 'Audit log history cleared',
            'deleted' => $deleted,
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Unable to clear audit log']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $perPage = (int) ($_GET['per_page'] ?? 30);
    $entityType = trim((string) ($_GET['entity_type'] ?? ''));
    $action = trim((string) ($_GET['action'] ?? ''));
    $search = trim((string) ($_GET['search'] ?? ''));
    $result = list_admin_audit_logs(
        $pdo,
        $page,
        $perPage,
        $entityType !== '' ? $entityType : null,
        $action !== '' ? $action : null,
        $search !== '' ? $search : null
    );
    echo json_encode([
        'success' => true,
        'data' => $result['data'],
        'pagination' => $result['pagination'],
        'entity_labels' => admin_audit_entity_labels(),
        'action_labels' => admin_audit_action_labels(),
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Unable to load audit log']);
}
