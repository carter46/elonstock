<?php
/**
 * Bootstrap core schema patches from schema/migration.sql + existing ensure_* helpers.
 * Safe to re-run: ensureColumn / CREATE IF NOT EXISTS / ensure_* are idempotent.
 */

return [
    'id' => '2026_09_06_core_schema_bootstrap',
    'description' => 'Core users/plans/transactions columns, supporting tables, and existing ensure_* helpers',
    'up' => function (PDO $pdo) {
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

        // --- plans (base columns before ensure_plan_schema) ---
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

        // --- supporting tables ---
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

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS email_otp_codes (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          email VARCHAR(255) NOT NULL,
          purpose VARCHAR(64) NOT NULL,
          code_hash VARCHAR(255) NOT NULL,
          expires_at DATETIME NOT NULL,
          consumed_at DATETIME NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_email_otp_email_purpose (email, purpose),
          INDEX idx_email_otp_expires (expires_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create email_otp_codes');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS pending_registrations (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          email VARCHAR(255) NOT NULL,
          name VARCHAR(255) NOT NULL DEFAULT '',
          password_hash VARCHAR(255) NOT NULL,
          referral_code VARCHAR(100) NULL,
          referred_by_user_id INT UNSIGNED NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          UNIQUE KEY uniq_pending_registrations_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create pending_registrations');

        DatabaseAutoMigrate::ensureColumn($pdo, 'pending_registrations', 'referred_by_user_id', '`referred_by_user_id` INT UNSIGNED NULL');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS kyc_submissions (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          user_id INT UNSIGNED NOT NULL,
          status VARCHAR(32) NOT NULL DEFAULT 'pending',
          document_type VARCHAR(64) NULL,
          document_front VARCHAR(500) NULL,
          document_back VARCHAR(500) NULL,
          selfie_url VARCHAR(500) NULL,
          admin_notes TEXT NULL,
          submitted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          reviewed_at DATETIME NULL,
          INDEX idx_kyc_user (user_id),
          INDEX idx_kyc_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create kyc_submissions');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS broadcast_campaigns (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          subject VARCHAR(255) NOT NULL,
          body_html MEDIUMTEXT NOT NULL,
          audience VARCHAR(64) NOT NULL DEFAULT 'all',
          sent_count INT UNSIGNED NOT NULL DEFAULT 0,
          created_by INT UNSIGNED NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create broadcast_campaigns');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS admin_mailbox (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          folder ENUM('inbox','sent') NOT NULL DEFAULT 'inbox',
          from_email VARCHAR(255) NULL,
          to_email VARCHAR(255) NULL,
          subject VARCHAR(500) NULL,
          body_text MEDIUMTEXT NULL,
          body_html MEDIUMTEXT NULL,
          message_id VARCHAR(255) NULL,
          in_reply_to VARCHAR(255) NULL,
          thread_key VARCHAR(255) NULL,
          imap_uid VARCHAR(64) NULL,
          is_read TINYINT(1) NOT NULL DEFAULT 0,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_admin_mailbox_folder (folder),
          INDEX idx_admin_mailbox_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create admin_mailbox');

        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'message_id', '`message_id` VARCHAR(255) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'in_reply_to', '`in_reply_to` VARCHAR(255) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'thread_key', '`thread_key` VARCHAR(255) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'imap_uid', '`imap_uid` VARCHAR(64) NULL');
        DatabaseAutoMigrate::ensureColumn($pdo, 'admin_mailbox', 'is_read', '`is_read` TINYINT(1) NOT NULL DEFAULT 0');

        DatabaseAutoMigrate::execOrFail($pdo, "CREATE TABLE IF NOT EXISTS referral_earnings (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          referrer_user_id INT UNSIGNED NOT NULL,
          referred_user_id INT UNSIGNED NOT NULL,
          source VARCHAR(64) NOT NULL,
          amount DECIMAL(18,8) NOT NULL DEFAULT 0,
          currency VARCHAR(20) NOT NULL DEFAULT 'USD',
          transaction_id INT UNSIGNED NULL,
          created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_referral_earnings_referrer (referrer_user_id),
          INDEX idx_referral_earnings_referred (referred_user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'Create referral_earnings');

        // --- site settings defaults ---
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
