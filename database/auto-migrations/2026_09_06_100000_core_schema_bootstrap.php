<?php
/**
 * Bootstrap core schema patches from schema/migration.sql + existing ensure_* helpers.
 * Safe / idempotent: CREATE IF NOT EXISTS + ensureColumn + ensure_*.
 *
 * v2: CREATE TABLE defs corrected to match schema/migration.sql (not invented columns).
 */

return [
    'id' => '2026_09_06_core_schema_bootstrap_v2',
    'description' => 'Core schema bootstrap (users/plans/tx columns, real supporting tables, ensure_* helpers)',
    'up' => function (PDO $pdo) {
        // site_settings must exist before ensureSetting / payment migration flag
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS site_settings (
          `key` VARCHAR(100) NOT NULL,
          `value` TEXT NULL,
          `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", 'Create site_settings');

        // --- users ---
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'email_verified', '`email_verified` TINYINT(1) NOT NULL DEFAULT 0');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'two_factor_enabled', '`two_factor_enabled` TINYINT(1) NOT NULL DEFAULT 0');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'admin_notes', '`admin_notes` TEXT NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'avatar_url', '`avatar_url` VARCHAR(500) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'phone_number', '`phone_number` VARCHAR(50) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'country', '`country` VARCHAR(100) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'kyc_status', "`kyc_status` VARCHAR(32) NOT NULL DEFAULT 'none'");
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'referral_code', '`referral_code` VARCHAR(100) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'referred_by_user_id', '`referred_by_user_id` INT UNSIGNED NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'my_referral_code', '`my_referral_code` VARCHAR(32) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'last_balance_usd', '`last_balance_usd` DECIMAL(18,2) NOT NULL DEFAULT 0');
        DatabaseAutoMigrate::ensureColumn($pdo, 'users', 'last_balance_usd_updated_at', '`last_balance_usd_updated_at` DATETIME NULL');

        // --- plans ---
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'description', '`description` TEXT NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'icon', '`icon` VARCHAR(50) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'features_json', '`features_json` LONGTEXT NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'min_duration_months', '`min_duration_months` INT UNSIGNED NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'max_duration_months', '`max_duration_months` INT UNSIGNED NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'min_duration_days', '`min_duration_days` INT UNSIGNED NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'plans', 'max_duration_days', '`max_duration_days` INT UNSIGNED NULL');

        // --- user_investments ---
        DatabaseAutoMigrate::ensureColumn($pdo, 'user_investments', 'duration_days', '`duration_days` INT UNSIGNED NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'user_investments', 'last_earnings_at', '`last_earnings_at` DATETIME NULL');

        // --- transactions ---
        DatabaseAutoMigrate::ensureColumn($pdo, 'transactions', 'expires_at', '`expires_at` DATETIME NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'transactions', 'user_confirmed_at', '`user_confirmed_at` DATETIME NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'transactions', 'proof_url', '`proof_url` VARCHAR(500) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'transactions', 'amount_usd', '`amount_usd` DECIMAL(18,2) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'transactions', 'payment_method_id', '`payment_method_id` INT UNSIGNED NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'transactions', 'payout_details', '`payout_details` TEXT NULL');

        // --- coins / wallet_addresses (from migration.sql) ---
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS coins (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          coin_key VARCHAR(50) NOT NULL UNIQUE,
          display_name VARCHAR(100) NOT NULL,
          symbol VARCHAR(20) NOT NULL,
          logo VARCHAR(500) DEFAULT NULL,
          enabled TINYINT(1) NOT NULL DEFAULT 1,
          sort_order INT NOT NULL DEFAULT 0,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          INDEX idx_coins_enabled (enabled),
          INDEX idx_coins_sort (sort_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create coins');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS wallet_addresses (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          coin_id INT UNSIGNED NOT NULL,
          address VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_wallet_addresses_coin (coin_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create wallet_addresses');

        // --- OTP / pending registration (match migration.sql exactly) ---
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS email_otp_codes (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          email VARCHAR(255) NOT NULL,
          otp CHAR(6) NOT NULL,
          purpose ENUM('register','login','disable_2fa') NOT NULL,
          expires_at DATETIME NOT NULL,
          used TINYINT(1) DEFAULT 0,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_email_purpose (email, purpose),
          INDEX idx_expires (expires_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", 'Create email_otp_codes');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS pending_registrations (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          email VARCHAR(255) NOT NULL,
          password_hash VARCHAR(255) NOT NULL,
          name VARCHAR(255) DEFAULT '',
          phone_number VARCHAR(50) NULL,
          referral_code VARCHAR(50) NULL,
          avatar_url VARCHAR(500) NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          expires_at DATETIME NOT NULL,
          UNIQUE KEY uniq_email (email),
          INDEX idx_expires (expires_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", 'Create pending_registrations');

        DatabaseAutoMigrate::ensureColumn($pdo, 'pending_registrations', 'referred_by_user_id', '`referred_by_user_id` INT UNSIGNED NULL AFTER `referral_code`');

        // --- KYC (match migration.sql) ---
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS kyc_submissions (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          user_id INT UNSIGNED NOT NULL,
          document_type ENUM('passport', 'id_card', 'driver_license') NOT NULL,
          front_path VARCHAR(500) NOT NULL,
          back_path VARCHAR(500) NULL,
          full_name VARCHAR(255) NOT NULL,
          date_of_birth DATE NULL,
          address TEXT NULL,
          status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
          rejection_reason TEXT NULL,
          reviewed_by INT UNSIGNED NULL,
          reviewed_at DATETIME NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_kyc_user (user_id),
          INDEX idx_kyc_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create kyc_submissions');

        // --- broadcast (match migration.sql) ---
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS broadcast_campaigns (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          subject VARCHAR(255) NOT NULL,
          recipients_filter VARCHAR(50) NOT NULL DEFAULT 'all',
          total_recipients INT UNSIGNED NOT NULL DEFAULT 0,
          status ENUM('sent','draft') NOT NULL DEFAULT 'sent',
          sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", 'Create broadcast_campaigns');

        // --- admin_mailbox (match migration.sql + IMAP columns) ---
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS admin_mailbox (
          id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          direction ENUM('in','out') NOT NULL,
          source VARCHAR(32) NOT NULL DEFAULT 'system',
          from_email VARCHAR(255) NULL,
          from_name VARCHAR(255) NULL,
          to_emails TEXT NULL,
          subject VARCHAR(255) NOT NULL,
          body_html LONGTEXT NULL,
          body_text LONGTEXT NULL,
          status ENUM('received','sent','failed') NOT NULL DEFAULT 'sent',
          error_text TEXT NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_direction_created (direction, created_at),
          INDEX idx_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", 'Create admin_mailbox');

        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'mailbox_folder', '`mailbox_folder` VARCHAR(255) NULL AFTER `source`');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'imap_uid', '`imap_uid` BIGINT UNSIGNED NULL AFTER `mailbox_folder`');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'message_id', '`message_id` VARCHAR(255) NULL AFTER `imap_uid`');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'in_reply_to', '`in_reply_to` VARCHAR(255) NULL AFTER `message_id`');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'references', '`references` TEXT NULL AFTER `in_reply_to`');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'mail_date', '`mail_date` DATETIME NULL AFTER `references`');

        // Drop accidental columns from bootstrap v1 (if any)
        foreach (['folder', 'is_read', 'thread_key'] as $bogusCol) {
            $chk = $pdo->prepare(
                "SELECT COUNT(*) FROM information_schema.columns
                 WHERE table_schema = DATABASE() AND table_name = 'admin_mailbox' AND column_name = ?"
            );
            $chk->execute([$bogusCol]);
            if ((int) $chk->fetchColumn() > 0) {
                $safe = preg_replace('/[^a-zA-Z0-9_]/', '', $bogusCol);
                $pdo->exec("ALTER TABLE `admin_mailbox` DROP COLUMN `{$safe}`");
            }
        }

        // --- referral_earnings (match migration.sql; no FK to avoid order issues on partial DBs) ---
        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS referral_earnings (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          referrer_user_id INT UNSIGNED NOT NULL,
          referred_user_id INT UNSIGNED NOT NULL,
          source ENUM('plan_subscription','first_deposit','referred_payout','first_deposit_l2','referred_payout_l2') NOT NULL,
          amount_usd DECIMAL(18,2) NOT NULL,
          currency VARCHAR(20) NOT NULL DEFAULT 'USDT',
          percent_used DECIMAL(5,2) NOT NULL,
          reference_id INT UNSIGNED NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_referrer (referrer_user_id),
          INDEX idx_referred (referred_user_id),
          INDEX idx_referred_source (referred_user_id, source)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", 'Create referral_earnings');

        // --- site settings defaults (insert only if missing) ---
        DatabaseAutoMigrate::ensureSetting($pdo, 'referral_enabled', '0');
        DatabaseAutoMigrate::ensureSetting($pdo, 'referral_percentage', '15');
        DatabaseAutoMigrate::ensureSetting($pdo, 'referral_level2_percentage', '10');
        DatabaseAutoMigrate::ensureSetting($pdo, 'deposit_bonus_percentage', '0');
        DatabaseAutoMigrate::ensureSetting($pdo, 'deposit_countdown_minutes', '30');
        DatabaseAutoMigrate::ensureSetting($pdo, 'earnings_paused', '0');
        DatabaseAutoMigrate::ensureSetting($pdo, 'distribution_interval', 'daily');
        DatabaseAutoMigrate::ensureSetting($pdo, 'distribution_start_time', '09:00:00');

        // --- existing app ensure helpers ---
        require_once dirname(__DIR__, 2) . '/includes/plan-types.php';
        require_once dirname(__DIR__, 2) . '/includes/payment-methods.php';
        require_once dirname(__DIR__, 2) . '/includes/investment-lifecycle.php';
        require_once dirname(__DIR__, 2) . '/includes/admin-audit-log.php';

        ensure_plan_schema($pdo);
        ensure_payment_methods_schema($pdo);
        ensure_investment_lifecycle_schema($pdo);
        ensure_admin_audit_log_schema($pdo);
    },
];
