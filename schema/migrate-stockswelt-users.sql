-- =============================================================================
-- Legacy Stockswelt → u502532383_stockwealthy migration
-- Source: stockswelt_uikvfiku76.sql
-- Target: select database u502532383_stockwealthy in phpMyAdmin, then run this.
--
-- Imports: 16 users, USD wallets (balance + interest), 2 active Professional invests
-- Does NOT: create plans, import SoftKing admin, overwrite existing passwords
-- Idempotent: safe to re-run (skips duplicate users/invests; replaces USD wallets)
-- =============================================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- -----------------------------------------------------------------------------
-- 0) Preflight
-- -----------------------------------------------------------------------------
SET @db_ok := (SELECT DATABASE() = 'u502532383_stockwealthy');
SET @users_ok := (
  SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'
    AND COLUMN_NAME IN ('email','password_hash','name','role','email_verified','active',
                        'phone_number','country','my_referral_code','last_balance_usd','last_balance_usd_updated_at')
) >= 11;
SET @wallet_ok := (
  SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'wallet_balances'
    AND COLUMN_NAME IN ('user_id','currency','amount')
) >= 3;
SET @inv_ok := (
  SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'user_investments'
    AND COLUMN_NAME IN ('user_id','plan_id','amount','duration_days','start_date','status','last_earnings_at','created_at')
) >= 8;
SET @plan_id := (
  SELECT id FROM plans WHERE slug = 'professional-plan' AND enabled = 1 LIMIT 1
);
SET @plan_ok := (@plan_id IS NOT NULL);

-- Fail early with a clear message (MariaDB/MySQL 5.7+)
SET @preflight_msg := CASE
  WHEN @db_ok = 0 OR @db_ok IS NULL THEN 'PREFLIGHT FAIL: Select database u502532383_stockwealthy before running this script.'
  WHEN @users_ok = 0 THEN 'PREFLIGHT FAIL: users table is missing required columns.'
  WHEN @wallet_ok = 0 THEN 'PREFLIGHT FAIL: wallet_balances table is missing required columns.'
  WHEN @inv_ok = 0 THEN 'PREFLIGHT FAIL: user_investments table is missing required columns.'
  WHEN @plan_ok = 0 THEN 'PREFLIGHT FAIL: enabled plan with slug professional-plan not found (expected id 38).'
  ELSE NULL
END;

-- Signal only when something failed
SET @sql_fail := IF(@preflight_msg IS NOT NULL,
  CONCAT('SIGNAL SQLSTATE ''45000'' SET MESSAGE_TEXT = ''', REPLACE(@preflight_msg, '''', ''''''), ''''),
  'SELECT ''Preflight OK: professional-plan id = '', @plan_id AS info'
);
PREPARE stmt_preflight FROM @sql_fail;
EXECUTE stmt_preflight;
DEALLOCATE PREPARE stmt_preflight;

SELECT CONCAT('Preflight OK — Professional Plan id = ', @plan_id) AS status;

START TRANSACTION;

-- -----------------------------------------------------------------------------
-- 1) Mapping / backup tables (scoped to this migration only)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `_migration_stockswelt_map` (
  `source_user_id` INT UNSIGNED NOT NULL PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `target_user_id` INT UNSIGNED NOT NULL,
  `action` ENUM('inserted','matched') NOT NULL,
  `usd_balance` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `migrated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_mig_email` (`email`),
  KEY `idx_mig_target` (`target_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `_migration_stockswelt_user_backup` (
  `target_user_id` INT UNSIGNED NOT NULL PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NULL,
  `phone_number` VARCHAR(50) NULL,
  `country` VARCHAR(100) NULL,
  `email_verified` TINYINT(1) NULL,
  `active` TINYINT(1) NULL,
  `last_balance_usd` DECIMAL(18,2) NULL,
  `backed_up_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `_migration_stockswelt_wallet_backup` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `currency` VARCHAR(20) NOT NULL,
  `amount` DECIMAL(36,18) NOT NULL,
  `backed_up_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_wallet_backup` (`user_id`, `currency`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `_migration_stockswelt_invest_map` (
  `source_invest_id` INT UNSIGNED NOT NULL PRIMARY KEY,
  `target_investment_id` INT UNSIGNED NOT NULL,
  `target_user_id` INT UNSIGNED NOT NULL,
  `plan_id` INT UNSIGNED NOT NULL,
  `amount` DECIMAL(18,2) NOT NULL,
  `migrated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2) Stage source users (sanitized names for XSS/phishing rows)
-- -----------------------------------------------------------------------------
DROP TEMPORARY TABLE IF EXISTS `_tmp_stockswelt_users`;
CREATE TEMPORARY TABLE `_tmp_stockswelt_users` (
  `source_user_id` INT UNSIGNED NOT NULL PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(50) NULL,
  `country` VARCHAR(100) NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `email_verified` TINYINT(1) NOT NULL DEFAULT 1,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `two_factor_enabled` TINYINT(1) NOT NULL DEFAULT 0,
  `usd_balance` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `created_at` DATETIME NOT NULL,
  UNIQUE KEY `uniq_tmp_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `_tmp_stockswelt_users`
  (`source_user_id`,`name`,`email`,`phone_number`,`country`,`password_hash`,`email_verified`,`active`,`two_factor_enabled`,`usd_balance`,`created_at`)
VALUES
(1,  'test test',            'trumanlandon47@gmail.com',              '+23446469854',      'Nigeria',        '$2y$10$0nsdWL40XYutJOKfdMpGH.MPs/qlMuZyFiD.LvpYbx1ymWBhZiz3.', 1, 1, 0, 0.00,     '2026-05-07 13:12:45'),
(2,  'Yannick',              'kjosh6340@gmail.com',                   '+2349134870045',    NULL,             '$2y$10$QZzs2PMJRVRAAIAgK.8FEe/U1N55ye1hIIXBFWpgDMjJh.kDn7Egq', 1, 1, 0, 834.00,   '2026-05-08 12:47:51'),
(3,  'Stockwealth5',         'youngtsamzy@gmail.com',                 '+234-9069270574',   'Nigeria',        '$2y$10$RaN4..634S93dEx.2DopBu/JcxHj/V7Z4feX5phbckLhYO9CllTNO', 1, 1, 0, 0.00,     '2026-05-10 19:37:18'),
(4,  'DONALD HYDE',          'donldhydevid@gmail.com',                '+1 (309) 678-2023', 'United States',  '$2y$10$G3Fbq84.8MSmEmCCdTGvUOpPY5b5VSnvItwsadUXoXW1nbOb.aE5u', 1, 1, 0, 15875.00, '2026-05-10 19:55:30'),
(5,  'Keith Baker',          'shipwreckcoast1@gmail.com',             '+19062039224',      'United States',  '$2y$10$gKyHhg2tNdwZxj9bK2fIA.F89zKh5DQtw1Tt3mBbFnHIEC1TVCtgi', 1, 1, 0, 35175.29, '2026-05-13 23:58:17'),
(6,  'Testing testing',      'testing@gmail.com',                     '+2347558486',       'Nigeria',        '$2y$10$.mFJHyOu5MuJnd3u0e.0cujHND4SeL2tP2ha3HZ3BwLDdyqmKPiLO', 1, 1, 0, 0.00,     '2026-05-21 16:17:21'),
(7,  'Dylan dreyer',         'martinhendersonprivate065@gmail.com',   '+55',               'Brazil',         '$2y$10$qZWawt5NExpYKrlYsOv1leJ1islr/2gb7KqxYc4acrq4oXPYkM/cC', 1, 1, 0, 625.00,   '2026-05-22 14:54:41'),
(8,  'Nocal',                'Nocal@mail.com',                        '1',                 'Australia',      '$2y$10$azIId3OdX8VBy01QlVrVpetIfThRQgTftfcc4K2qHVt1VktHMUY2m', 1, 1, 0, 0.00,     '2026-05-23 10:59:39'),
(9,  'xwglslvvyl',           'whrihuvo@immenseignite.info',           '+1-405-311-0112',   NULL,             '$2y$10$V6eUIb/E/Egn.RzP67VrPOvF.OcDxJCH1.hzRJa9Bne6lncAkjL6C', 1, 1, 0, 0.00,     '2026-05-24 06:13:07'),
(10, 'jumuezsfiz',           'mukgyorw@immenseignite.info',           '+1-737-338-5872',   NULL,             '$2y$10$LZO7WhNxYH6fitWMef5zoO8os4zotzyldMfEBLAyXm.vljhyykQ4K', 1, 1, 0, 0.00,     '2026-05-24 06:13:25'),
(11, 'Joshua',               'joshuagaming1984@gmail.com',            '+234',              'Nigeria',        '$2y$10$488rCWMBVGZnyLDw0mh7oeXXTtH4mdoSft.Ip4S9KOpnpiOQ0cj0u', 1, 1, 0, 0.00,     '2026-05-26 13:03:12'),
(12, 'Florencia Gabriella',  'florencia9400@gmail.com',               '+31657896919',      'Netherlands',    '$2y$10$u9Xtwas6yWawjZNQks8O6Ok7Ri3DGtqidgzDhRnQm535wSthDwhyG', 1, 1, 0, 0.00,     '2026-05-26 14:35:34'),
(13, 'Migrated Account',     'ydx~nwa9pwyxz@mailbox.in.ua',            '783359462030',      NULL,             '$2y$10$K6D5o9SjusLyvMjkJFmq3uoCmhnjBr/ZyXKq0u9fi4MZ/mS6hRAdS', 1, 1, 0, 0.00,     '2026-06-04 06:38:45'),
(14, 'xsjyBldb',             'testing@example.com',                   '987-65-4329',       'USA',            '$2y$10$hW/mTh7UbU5t3F7nOuzQ.Oz8h6Vp8I/l8WkJID8cpsMnpHtMhiJWC', 1, 1, 0, 0.00,     '2026-06-10 20:53:25'),
(15, 'Josh beel & Laura',    'beelj930@gmail.com',                    '+1 (870) 901-6341', 'United States',  '$2y$10$DwqWuyU2g4ywbO83ZcXzleXT3Y4jb2rrY21t5a0aRCbANfYCrcdYu', 1, 1, 0, 0.00,     '2026-06-18 19:11:15'),
(16, 'Nadiaa',               'nadia2968844@gmail.com',                '+9230634649499',    'Pakistan',       '$2y$10$rtK1V1Az7c2AZkiq0SWM9eCabv0A4zU4NSrsrJQlGXXnTq/LSjSZ2', 1, 1, 0, 0.00,     '2026-06-22 16:27:27');

-- -----------------------------------------------------------------------------
-- 3) Backup any pre-existing matching users / USD wallets (collision path)
-- -----------------------------------------------------------------------------
INSERT INTO `_migration_stockswelt_user_backup`
  (`target_user_id`,`email`,`name`,`phone_number`,`country`,`email_verified`,`active`,`last_balance_usd`)
SELECT u.id, u.email, u.name, u.phone_number, u.country, u.email_verified, u.active, u.last_balance_usd
FROM users u
INNER JOIN `_tmp_stockswelt_users` t ON LOWER(u.email) = LOWER(t.email)
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  phone_number = VALUES(phone_number),
  country = VALUES(country),
  email_verified = VALUES(email_verified),
  active = VALUES(active),
  last_balance_usd = VALUES(last_balance_usd),
  backed_up_at = CURRENT_TIMESTAMP;

INSERT INTO `_migration_stockswelt_wallet_backup` (`user_id`,`currency`,`amount`)
SELECT wb.user_id, wb.currency, wb.amount
FROM wallet_balances wb
INNER JOIN users u ON u.id = wb.user_id
INNER JOIN `_tmp_stockswelt_users` t ON LOWER(u.email) = LOWER(t.email)
WHERE UPPER(wb.currency) = 'USD'
ON DUPLICATE KEY UPDATE
  amount = VALUES(amount),
  backed_up_at = CURRENT_TIMESTAMP;

-- -----------------------------------------------------------------------------
-- 4) Insert new users (password_hash only on INSERT — never overwrite on match)
-- -----------------------------------------------------------------------------
INSERT INTO users (
  email, password_hash, name, role, email_verified, active, two_factor_enabled,
  phone_number, country, created_at, updated_at, kyc_status, last_balance_usd, last_balance_usd_updated_at
)
SELECT
  t.email,
  t.password_hash,
  t.name,
  'user',
  t.email_verified,
  t.active,
  t.two_factor_enabled,
  t.phone_number,
  t.country,
  t.created_at,
  t.created_at,
  'none',
  t.usd_balance,
  NOW()
FROM `_tmp_stockswelt_users` t
WHERE NOT EXISTS (
  SELECT 1 FROM users u WHERE LOWER(u.email) = LOWER(t.email)
);

-- Update profile fields for any email that already existed (preserve id/password/role/2FA/referral/kyc)
UPDATE users u
INNER JOIN `_tmp_stockswelt_users` t ON LOWER(u.email) = LOWER(t.email)
SET
  u.name = t.name,
  u.phone_number = COALESCE(t.phone_number, u.phone_number),
  u.country = COALESCE(t.country, u.country),
  u.email_verified = GREATEST(u.email_verified, t.email_verified),
  u.active = GREATEST(u.active, t.active),
  u.last_balance_usd = t.usd_balance,
  u.last_balance_usd_updated_at = NOW();

-- Record mapping (inserted vs matched)
INSERT INTO `_migration_stockswelt_map` (`source_user_id`,`email`,`target_user_id`,`action`,`usd_balance`)
SELECT
  t.source_user_id,
  t.email,
  u.id,
  IF(
    EXISTS (SELECT 1 FROM `_migration_stockswelt_user_backup` b WHERE b.target_user_id = u.id),
    'matched',
    'inserted'
  ),
  t.usd_balance
FROM `_tmp_stockswelt_users` t
INNER JOIN users u ON LOWER(u.email) = LOWER(t.email)
ON DUPLICATE KEY UPDATE
  target_user_id = VALUES(target_user_id),
  -- Keep original 'inserted' so rollback still knows which rows this migration created
  action = IF(`_migration_stockswelt_map`.action = 'inserted', 'inserted', VALUES(action)),
  usd_balance = VALUES(usd_balance),
  migrated_at = CURRENT_TIMESTAMP;

-- Assign my_referral_code for newly inserted users missing one
UPDATE users u
INNER JOIN `_migration_stockswelt_map` m ON m.target_user_id = u.id
SET u.my_referral_code = CONCAT('REF', u.id)
WHERE u.my_referral_code IS NULL OR u.my_referral_code = '';

-- -----------------------------------------------------------------------------
-- 5) Replace USD wallet balances (idempotent REPLACE via upsert)
-- -----------------------------------------------------------------------------
INSERT INTO wallet_balances (user_id, currency, amount)
SELECT m.target_user_id, 'USD', m.usd_balance
FROM `_migration_stockswelt_map` m
ON DUPLICATE KEY UPDATE
  amount = VALUES(amount);

-- Keep last_balance_usd in sync
UPDATE users u
INNER JOIN `_migration_stockswelt_map` m ON m.target_user_id = u.id
SET
  u.last_balance_usd = m.usd_balance,
  u.last_balance_usd_updated_at = NOW();

-- -----------------------------------------------------------------------------
-- 6) Active investments → Professional Plan (slug professional-plan / id 38)
--    Keith Baker: $500 (source invest 11), $544 (source invest 12)
--    Fresh 5-day term; stable via invest map so re-run does not duplicate
-- -----------------------------------------------------------------------------
-- Invest 11 — $500
INSERT INTO user_investments (
  user_id, plan_id, amount, duration_days, start_date, status, last_earnings_at, created_at
)
SELECT
  m.target_user_id,
  @plan_id,
  500.00,
  5,
  CURRENT_DATE(),
  'active',
  NULL,
  '2026-06-18 14:01:35'
FROM `_migration_stockswelt_map` m
WHERE m.source_user_id = 5
  AND NOT EXISTS (
    SELECT 1 FROM `_migration_stockswelt_invest_map` im WHERE im.source_invest_id = 11
  );

INSERT INTO `_migration_stockswelt_invest_map` (`source_invest_id`,`target_investment_id`,`target_user_id`,`plan_id`,`amount`)
SELECT
  11,
  (
    SELECT ui.id
    FROM user_investments ui
    WHERE ui.user_id = m.target_user_id
      AND ui.plan_id = @plan_id
      AND ui.amount = 500.00
      AND ui.created_at = '2026-06-18 14:01:35'
    ORDER BY ui.id DESC
    LIMIT 1
  ),
  m.target_user_id,
  @plan_id,
  500.00
FROM `_migration_stockswelt_map` m
WHERE m.source_user_id = 5
  AND NOT EXISTS (SELECT 1 FROM `_migration_stockswelt_invest_map` im WHERE im.source_invest_id = 11)
  AND EXISTS (
    SELECT 1 FROM user_investments ui
    WHERE ui.user_id = m.target_user_id
      AND ui.plan_id = @plan_id
      AND ui.amount = 500.00
      AND ui.created_at = '2026-06-18 14:01:35'
  );

-- Invest 12 — $544
INSERT INTO user_investments (
  user_id, plan_id, amount, duration_days, start_date, status, last_earnings_at, created_at
)
SELECT
  m.target_user_id,
  @plan_id,
  544.00,
  5,
  CURRENT_DATE(),
  'active',
  NULL,
  '2026-07-03 21:20:47'
FROM `_migration_stockswelt_map` m
WHERE m.source_user_id = 5
  AND NOT EXISTS (
    SELECT 1 FROM `_migration_stockswelt_invest_map` im WHERE im.source_invest_id = 12
  );

INSERT INTO `_migration_stockswelt_invest_map` (`source_invest_id`,`target_investment_id`,`target_user_id`,`plan_id`,`amount`)
SELECT
  12,
  (
    SELECT ui.id
    FROM user_investments ui
    WHERE ui.user_id = m.target_user_id
      AND ui.plan_id = @plan_id
      AND ui.amount = 544.00
      AND ui.created_at = '2026-07-03 21:20:47'
    ORDER BY ui.id DESC
    LIMIT 1
  ),
  m.target_user_id,
  @plan_id,
  544.00
FROM `_migration_stockswelt_map` m
WHERE m.source_user_id = 5
  AND NOT EXISTS (SELECT 1 FROM `_migration_stockswelt_invest_map` im WHERE im.source_invest_id = 12)
  AND EXISTS (
    SELECT 1 FROM user_investments ui
    WHERE ui.user_id = m.target_user_id
      AND ui.plan_id = @plan_id
      AND ui.amount = 544.00
      AND ui.created_at = '2026-07-03 21:20:47'
  );

COMMIT;

-- -----------------------------------------------------------------------------
-- 7) Verification queries (run after commit; safe to re-select anytime)
-- -----------------------------------------------------------------------------

SELECT '=== Mapped users (expect 16) ===' AS section;
SELECT
  m.source_user_id,
  m.email,
  m.target_user_id,
  m.action,
  m.usd_balance,
  u.name,
  u.role,
  u.email_verified,
  u.active,
  u.my_referral_code
FROM `_migration_stockswelt_map` m
INNER JOIN users u ON u.id = m.target_user_id
ORDER BY m.source_user_id;

SELECT '=== USD wallets for migrated users ===' AS section;
SELECT
  m.email,
  wb.amount AS wallet_usd,
  u.last_balance_usd,
  m.usd_balance AS expected_usd
FROM `_migration_stockswelt_map` m
INNER JOIN users u ON u.id = m.target_user_id
LEFT JOIN wallet_balances wb ON wb.user_id = m.target_user_id AND UPPER(wb.currency) = 'USD'
ORDER BY m.usd_balance DESC, m.source_user_id;

SELECT '=== Wallet total (expect 51634.29) ===' AS section;
SELECT ROUND(SUM(m.usd_balance), 2) AS migrated_usd_total
FROM `_migration_stockswelt_map` m;

SELECT '=== Professional plan ===' AS section;
SELECT id, name, slug, plan_type, min_deposit, max_deposit, yield_min, yield_max, duration_days, enabled
FROM plans
WHERE slug = 'professional-plan';

SELECT '=== Keith Baker active investments (expect 2 on professional-plan) ===' AS section;
SELECT
  im.source_invest_id,
  im.target_investment_id,
  ui.user_id,
  u.email,
  ui.plan_id,
  p.slug,
  p.plan_type,
  ui.amount,
  ui.duration_days,
  ui.start_date,
  ui.status,
  ui.last_earnings_at,
  ui.created_at
FROM `_migration_stockswelt_invest_map` im
INNER JOIN user_investments ui ON ui.id = im.target_investment_id
INNER JOIN users u ON u.id = ui.user_id
INNER JOIN plans p ON p.id = ui.plan_id
ORDER BY im.source_invest_id;

SELECT '=== Counts / sanity ===' AS section;
SELECT
  (SELECT COUNT(*) FROM `_migration_stockswelt_map`) AS mapped_users,
  (SELECT COUNT(*) FROM `_migration_stockswelt_invest_map`) AS mapped_invests,
  (SELECT COUNT(*) FROM wallet_balances wb
     INNER JOIN `_migration_stockswelt_map` m ON m.target_user_id = wb.user_id
     WHERE UPPER(wb.currency) = 'USD') AS usd_wallet_rows,
  (SELECT COUNT(*) FROM user_investments ui
     INNER JOIN `_migration_stockswelt_map` m ON m.target_user_id = ui.user_id
     WHERE ui.status = 'active' AND ui.plan_id = (SELECT id FROM plans WHERE slug = 'professional-plan' LIMIT 1)
  ) AS active_professional_invests;

-- =============================================================================
-- ROLLBACK (commented — run manually only if you need to undo THIS migration)
-- Does NOT delete pre-existing users that were only "matched".
-- =============================================================================
/*
START TRANSACTION;

-- Remove migrated investments
DELETE ui FROM user_investments ui
INNER JOIN `_migration_stockswelt_invest_map` im ON im.target_investment_id = ui.id;

-- Restore USD wallets from backup where available; otherwise remove inserted USD rows for inserted users
UPDATE wallet_balances wb
INNER JOIN `_migration_stockswelt_wallet_backup` b ON b.user_id = wb.user_id AND UPPER(b.currency) = 'USD'
SET wb.amount = b.amount
WHERE UPPER(wb.currency) = 'USD';

DELETE wb FROM wallet_balances wb
INNER JOIN `_migration_stockswelt_map` m ON m.target_user_id = wb.user_id AND m.action = 'inserted'
WHERE UPPER(wb.currency) = 'USD'
  AND NOT EXISTS (
    SELECT 1 FROM `_migration_stockswelt_wallet_backup` b WHERE b.user_id = wb.user_id AND UPPER(b.currency) = 'USD'
  );

-- Restore matched user profile fields from backup
UPDATE users u
INNER JOIN `_migration_stockswelt_user_backup` b ON b.target_user_id = u.id
SET
  u.name = b.name,
  u.phone_number = b.phone_number,
  u.country = b.country,
  u.email_verified = b.email_verified,
  u.active = b.active,
  u.last_balance_usd = b.last_balance_usd;

-- Delete only users that this migration inserted
DELETE u FROM users u
INNER JOIN `_migration_stockswelt_map` m ON m.target_user_id = u.id AND m.action = 'inserted';

-- Clear migration tracking (optional)
-- TRUNCATE TABLE `_migration_stockswelt_invest_map`;
-- TRUNCATE TABLE `_migration_stockswelt_map`;
-- TRUNCATE TABLE `_migration_stockswelt_user_backup`;
-- TRUNCATE TABLE `_migration_stockswelt_wallet_backup`;

COMMIT;
*/
