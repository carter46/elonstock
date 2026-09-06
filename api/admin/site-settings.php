<?php
/**
 * Bloombit - Admin Site Settings API
 * GET /api/admin/site-settings.php - Get global parameters
 * POST /api/admin/site-settings.php - Update global parameters
 */

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/includes/session-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/helpers.php';
require_once dirname(__DIR__, 2) . '/includes/admin-audit-log.php';
if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$allowedKeys = [
    'max_active_plans_per_user',
    'compounding_enabled',
    'referral_enabled',
    'referral_percentage',
    'referral_level2_percentage',
    'deposit_bonus_percentage',
    'site_name',
    'site_logo',
    'site_favicon',
    'site_description',
    'og_image',
    'contact_email',
    // Mail (SMTP + identity)
    'mail_smtp_host',
    'mail_smtp_port',
    'mail_smtp_username',
    'mail_smtp_password',
    'mail_smtp_encryption',
    'mail_from_email',
    'mail_from_name',
    'mail_reply_to',
    // Mail receiving (IMAP) - stored for future sync tools
    'mail_imap_host',
    'mail_imap_port',
    'mail_imap_username',
    'mail_imap_password',
    'mail_imap_encryption',
    'mail_imap_sent_folder',
    'homepage_youtube_url',
    'homepage_youtube_start_seconds',
    'homepage_modal_image',
    'header_image',
    'office_title',
    'office_address',
    'smartsupp_key',
    'jivo_widget_id',
    'live_chat_provider',
    'deposit_countdown_minutes',
];
$sensitiveKeys = ['mail_smtp_password', 'mail_imap_password'];

try {
    $pdo = require dirname(__DIR__, 2) . '/includes/db.php';
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database unavailable']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $placeholders = implode(',', array_fill(0, count($allowedKeys), '?'));
    $stmt = $pdo->prepare("SELECT `key`, value FROM site_settings WHERE `key` IN ($placeholders)");
    $stmt->execute($allowedKeys);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = [
        'max_active_plans_per_user' => '3',
        'compounding_enabled' => '0',
        'referral_enabled' => '0',
        'referral_percentage' => '15',
        'referral_level2_percentage' => '10',
        'deposit_bonus_percentage' => '10',
        'site_name' => '',
        'site_logo' => '',
        'site_favicon' => '',
        'contact_email' => '',
        'mail_smtp_host' => '',
        'mail_smtp_port' => '587',
        'mail_smtp_username' => '',
        'mail_smtp_encryption' => 'tls',
        'mail_from_email' => '',
        'mail_from_name' => '',
        'mail_reply_to' => '',
        'mail_imap_host' => '',
        'mail_imap_port' => '993',
        'mail_imap_username' => '',
        'mail_imap_encryption' => 'ssl',
        'mail_imap_sent_folder' => 'Sent',
        'homepage_youtube_url' => '',
        'homepage_youtube_start_seconds' => '0',
        'homepage_modal_image' => '',
        'header_image' => '/bloombit.jpg',
        'office_title' => 'London Office',
        'office_address' => '40 Bank Street, Canary Wharf<br/>London, E14 5NR<br/>United Kingdom',
        'smartsupp_key' => '',
        'jivo_widget_id' => '',
        'live_chat_provider' => 'none',
        'deposit_countdown_minutes' => '30',
        // write-only flags
        'mail_smtp_password_set' => '0',
        'mail_imap_password_set' => '0',
    ];
    foreach ($rows as $r) {
        if (in_array($r['key'], $allowedKeys, true)) {
            if (in_array($r['key'], $sensitiveKeys, true)) {
                if (!empty($r['value'])) {
                    if ($r['key'] === 'mail_smtp_password') $data['mail_smtp_password_set'] = '1';
                    if ($r['key'] === 'mail_imap_password') $data['mail_imap_password_set'] = '1';
                }
                continue;
            }
            $data[$r['key']] = $r['value'] ?? '';
        }
    }
    // Normalize live chat provider: only smartsupp | jivo | none
    $provider = strtolower(trim((string) ($data['live_chat_provider'] ?? 'none')));
    if (!in_array($provider, ['smartsupp', 'jivo', 'none'], true)) {
        $provider = trim((string) ($data['smartsupp_key'] ?? '')) !== '' ? 'smartsupp' : 'none';
    }
    $data['live_chat_provider'] = $provider;
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $updates = [];
    foreach ($allowedKeys as $k) {
        if (!array_key_exists($k, $input)) continue;
        $v = trim((string) $input[$k]);
        if (in_array($k, $sensitiveKeys, true)) {
            // Passwords are write-only; blank means "keep existing"
            if ($v === '') continue;
        }
        if ($k === 'compounding_enabled') {
            $v = in_array(strtolower($v), ['1', 'true', 'yes', 'on'], true) ? '1' : '0';
        }
        if (in_array($k, ['mail_smtp_port', 'mail_imap_port'], true)) {
            $port = (int) $v;
            if ($port <= 0 || $port > 65535) continue;
            $v = (string) $port;
        }
        if (in_array($k, ['mail_smtp_encryption', 'mail_imap_encryption'], true)) {
            $vv = strtolower($v);
            if ($vv === 'starttls') $vv = 'tls';
            if (!in_array($vv, ['tls', 'ssl', 'none'], true)) continue;
            $v = $vv;
        }
        if ($k === 'deposit_countdown_minutes') {
            $m = (int) $v;
            if (!in_array($m, [5, 15, 30], true)) continue;
            $v = (string) $m;
        }
        if ($k === 'referral_enabled') {
            $v = in_array(strtolower($v), ['1', 'true', 'yes', 'on'], true) ? '1' : '0';
        }
        if ($k === 'live_chat_provider') {
            $vv = strtolower($v);
            if (!in_array($vv, ['smartsupp', 'jivo', 'none', ''], true)) {
                continue;
            }
            $v = $vv === '' ? 'none' : $vv;
        }
        if ($k === 'jivo_widget_id') {
            // Allow pasting full script snippet; store widget id when possible.
            if (preg_match('#code\.jivosite\.com/(?:script/)?widget/([A-Za-z0-9_-]+)#i', $v, $m)) {
                $v = $m[1];
            } elseif (preg_match('#(?:jv-id|data-jv-id)=[\'"]?([A-Za-z0-9_-]+)#i', $v, $m)) {
                $v = $m[1];
            } elseif (preg_match('#widget_id\s*=\s*[\'"]?([A-Za-z0-9_-]+)#i', $v, $m)) {
                $v = $m[1];
            }
            $v = preg_replace('/[^A-Za-z0-9_-]/', '', $v) ?? '';
        }
        if ($k === 'referral_percentage' || $k === 'referral_level2_percentage' || $k === 'deposit_bonus_percentage') {
            $pct = (float) $v;
            $pct = max(0, min(100, $pct));
            $v = (string) round($pct, 2);
        }
        if ($k === 'homepage_youtube_start_seconds') {
            $v = (string) max(0, (int) $v);
        }
        if ($k === 'homepage_youtube_url') {
            // Accept bare IDs and normalize to a canonical watch URL when possible.
            $ytId = get_youtube_video_id($v);
            if ($v !== '' && $ytId === null) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid Homepage YouTube URL. Paste a youtube.com or youtu.be link.']);
                exit;
            }
            if ($ytId) {
                $v = 'https://www.youtube.com/watch?v=' . $ytId;
            } else {
                $v = '';
            }
        }
        $updates[$k] = $v;
    }
    // Enforce only one live-chat provider at a time, and require credentials.
    if (isset($updates['live_chat_provider'])) {
        $p = $updates['live_chat_provider'];
        if (!in_array($p, ['smartsupp', 'jivo', 'none'], true)) {
            $p = 'none';
        }
        $smartKey = $updates['smartsupp_key'] ?? null;
        $jivoId = $updates['jivo_widget_id'] ?? null;
        if ($smartKey === null || $jivoId === null) {
            // Pull current values when only provider changes.
            try {
                $cur = $pdo->query("SELECT `key`, value FROM site_settings WHERE `key` IN ('smartsupp_key','jivo_widget_id')");
                $map = [];
                if ($cur) {
                    while ($row = $cur->fetch(PDO::FETCH_ASSOC)) {
                        $map[$row['key']] = (string) ($row['value'] ?? '');
                    }
                }
                if ($smartKey === null) $smartKey = $map['smartsupp_key'] ?? '';
                if ($jivoId === null) $jivoId = $map['jivo_widget_id'] ?? '';
            } catch (Throwable $e) {
                $smartKey = (string) ($smartKey ?? '');
                $jivoId = (string) ($jivoId ?? '');
            }
        }
        if ($p === 'smartsupp' && trim((string) $smartKey) === '') {
            $p = 'none';
        }
        if ($p === 'jivo' && trim((string) $jivoId) === '') {
            $p = 'none';
        }
        $updates['live_chat_provider'] = $p;
    }
    $stmt = $pdo->prepare('INSERT INTO site_settings (`key`, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)');
    foreach ($updates as $k => $v) {
        $stmt->execute([$k, $v]);
    }
    admin_audit_log(
        $pdo,
        'update',
        'settings',
        null,
        'Updated site settings (' . count($updates) . ' key(s))',
        null,
        $updates
    );
    echo json_encode(['success' => true, 'data' => ['message' => 'Settings updated']]);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']);
