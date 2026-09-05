<?php
/**
 * Idempotent database auto-migrator.
 * Runs pending PHP migrations from database/auto-migrations/ when an admin loads any admin page.
 *
 * Add a new file under database/auto-migrations/ named like:
 *   2026_09_06_120000_short_name.php
 * Returning:
 *   ['id' => '...', 'description' => '...', 'up' => function(PDO $pdo) { ... }]
 */

class DatabaseAutoMigrate {
    private static $ranThisRequest = false;
    /** @var PDO */
    private $pdo;
    private $dir;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'auto-migrations';
    }

    /**
     * Run once per request. Returns summary array.
     */
    public function run($appliedBy = null) {
        if (self::$ranThisRequest) {
            return $_SESSION['auto_migration_last_result'] ?? [
                'ran' => false,
                'applied' => [],
                'failed' => [],
                'skipped' => 0,
                'errors' => [],
            ];
        }
        self::$ranThisRequest = true;

        $result = [
            'ran' => true,
            'applied' => [],
            'failed' => [],
            'skipped' => 0,
            'errors' => [],
        ];

        try {
            $this->ensureTrackingTable();
            $migrations = $this->discoverMigrations();
            $appliedIds = $this->getSuccessfullyAppliedIds();

            foreach ($migrations as $migration) {
                $id = (string) $migration['id'];
                if (isset($appliedIds[$id])) {
                    $result['skipped']++;
                    continue;
                }

                try {
                    $up = $migration['up'];
                    if (!is_callable($up)) {
                        throw new Exception('Migration up() is not callable');
                    }
                    $up($this->pdo);
                    $this->recordSuccess($id, $migration['description'] ?? $id, $appliedBy);
                    $result['applied'][] = [
                        'id' => $id,
                        'description' => $migration['description'] ?? $id,
                    ];
                } catch (Throwable $e) {
                    $msg = $e->getMessage();
                    $this->recordFailure($id, $migration['description'] ?? $id, $msg, $appliedBy);
                    $result['failed'][] = [
                        'id' => $id,
                        'description' => $migration['description'] ?? $id,
                        'error' => $msg,
                    ];
                    $result['errors'][] = "{$id}: {$msg}";
                    error_log("Auto-migration failed [{$id}]: {$msg}");
                }
            }
        } catch (Throwable $e) {
            $result['errors'][] = 'Migrator bootstrap failed: ' . $e->getMessage();
            error_log('DatabaseAutoMigrate bootstrap error: ' . $e->getMessage());
        }

        $_SESSION['auto_migration_last_result'] = $result;

        if (!empty($result['failed']) || !empty($result['errors'])) {
            $_SESSION['auto_migration_errors'] = $result['errors'];
        } else {
            unset($_SESSION['auto_migration_errors']);
        }

        if (!empty($result['applied'])) {
            $_SESSION['auto_migration_success'] = array_map(static function ($row) {
                return ($row['description'] ?? $row['id']) . ' (' . $row['id'] . ')';
            }, $result['applied']);
        }

        return $result;
    }

    private function ensureTrackingTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `auto_migrations` (
            `id` varchar(191) NOT NULL,
            `description` varchar(255) DEFAULT NULL,
            `status` enum('success','failed') NOT NULL DEFAULT 'success',
            `error_message` text DEFAULT NULL,
            `applied_by` int(11) DEFAULT NULL,
            `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_status` (`status`),
            KEY `idx_applied_at` (`applied_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    private function getSuccessfullyAppliedIds() {
        $ids = [];
        $stmt = $this->pdo->query("SELECT id FROM auto_migrations WHERE status = 'success'");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) ?: [] as $row) {
            $ids[$row['id']] = true;
        }
        return $ids;
    }

    private function discoverMigrations() {
        if (!is_dir($this->dir)) {
            @mkdir($this->dir, 0755, true);
        }

        $files = glob($this->dir . DIRECTORY_SEPARATOR . '*.php') ?: [];
        sort($files, SORT_STRING);

        $migrations = [];
        foreach ($files as $file) {
            if (basename($file) === 'index.php') {
                continue;
            }
            $data = include $file;
            if (!is_array($data) || empty($data['id']) || !isset($data['up'])) {
                throw new Exception('Invalid migration file: ' . basename($file));
            }
            $migrations[] = $data;
        }
        return $migrations;
    }

    private function recordSuccess($id, $description, $appliedBy) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO auto_migrations (id, description, status, error_message, applied_by, applied_at)
             VALUES (?, ?, 'success', NULL, ?, NOW())
             ON DUPLICATE KEY UPDATE
                description = VALUES(description),
                status = 'success',
                error_message = NULL,
                applied_by = VALUES(applied_by),
                applied_at = NOW()"
        );
        $stmt->execute([$id, $description, $appliedBy]);
    }

    private function recordFailure($id, $description, $error, $appliedBy) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO auto_migrations (id, description, status, error_message, applied_by, applied_at)
             VALUES (?, ?, 'failed', ?, ?, NOW())
             ON DUPLICATE KEY UPDATE
                description = VALUES(description),
                status = 'failed',
                error_message = VALUES(error_message),
                applied_by = VALUES(applied_by),
                updated_at = NOW()"
        );
        $stmt->execute([$id, $description, $error, $appliedBy]);
    }

    /** Add a column if missing. Returns true if added. */
    public static function ensureColumn(PDO $pdo, $table, $column, $definitionSql) {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', (string) $table);
        $column = preg_replace('/[^a-zA-Z0-9_]/', '', (string) $column);

        $stmt = $pdo->prepare(
            "SELECT COUNT(*) AS cnt
             FROM information_schema.columns
             WHERE table_schema = DATABASE()
               AND table_name = ?
               AND column_name = ?"
        );
        $stmt->execute([$table, $column]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($row['cnt'])) {
            return false;
        }
        $pdo->exec("ALTER TABLE `{$table}` ADD COLUMN {$definitionSql}");
        return true;
    }

    /** Ensure a site_settings row exists (`key` / `value`). Returns true if inserted. */
    public static function ensureSetting(PDO $pdo, $key, $value, $description = null) {
        $stmt = $pdo->prepare('SELECT `key` FROM site_settings WHERE `key` = ? LIMIT 1');
        $stmt->execute([(string) $key]);
        if ($stmt->fetch()) {
            return false;
        }
        $ins = $pdo->prepare('INSERT INTO site_settings (`key`, value) VALUES (?, ?)');
        $ins->execute([(string) $key, (string) $value]);
        return true;
    }

    /** Run SQL and throw on failure. */
    public static function execOrFail(PDO $pdo, $sql, $label = null) {
        try {
            $pdo->exec($sql);
        } catch (Throwable $e) {
            throw new Exception(($label ?: 'Query failed') . ': ' . $e->getMessage());
        }
    }

    /** True if table exists in current database. */
    public static function tableExists(PDO $pdo, $table) {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', (string) $table);
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) AS cnt
             FROM information_schema.tables
             WHERE table_schema = DATABASE() AND table_name = ?"
        );
        $stmt->execute([$table]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($row['cnt']);
    }

    /** True if index exists on table. */
    public static function indexExists(PDO $pdo, $table, $indexName) {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', (string) $table);
        $indexName = preg_replace('/[^a-zA-Z0-9_]/', '', (string) $indexName);
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) AS cnt
             FROM information_schema.statistics
             WHERE table_schema = DATABASE()
               AND table_name = ?
               AND index_name = ?"
        );
        $stmt->execute([$table, $indexName]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($row['cnt']);
    }
}

/**
 * Run auto-migrations for the current admin session.
 */
function runAdminDatabaseAutoMigrations($adminUserId = null) {
    try {
        $pdo = require __DIR__ . '/db.php';
        if (!($pdo instanceof PDO)) {
            return null;
        }
    } catch (Throwable $e) {
        error_log('Auto-migration DB connect failed: ' . $e->getMessage());
        return null;
    }

    $adminUserId = $adminUserId ?? ($_SESSION['user_id'] ?? null);
    $migrator = new DatabaseAutoMigrate($pdo);
    return $migrator->run($adminUserId ? (int) $adminUserId : null);
}
