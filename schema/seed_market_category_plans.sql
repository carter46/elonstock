-- Seed one investment plan per trading-signals market instrument (12 total).
-- Plan slug matches market registry slug so /dashboard/user/investment-plans/usdjpy uses the USD/JPY widget.
-- Idempotent: safe to re-run. Disables old single-per-category umbrella plans if present.

UPDATE `plans` SET `enabled` = 0 WHERE `slug` IN ('market-crypto', 'market-stocks', 'market-forex');

-- Crypto (4)
INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Bitcoin', 'bitcoin', 'crypto', 'Invest in Bitcoin with live BTC/USD charts and AI trading signals.', 'currency_bitcoin', 'mid', 500.00, 50000.00, 6.00, 6.00, 30, 7, 25.00, 30, 30, '["Live BTC chart","AI trading signals","Daily yield accrual","24/7 market monitoring"]', 1, 20
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'bitcoin');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Ethereum', 'ethereum', 'crypto', 'Invest in Ethereum with live ETH/USD charts and AI trading signals.', 'currency_exchange', 'mid', 500.00, 50000.00, 6.00, 6.00, 30, 7, 25.00, 30, 30, '["Live ETH chart","AI trading signals","Daily yield accrual","24/7 market monitoring"]', 1, 21
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'ethereum');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'BNB', 'binancecoin', 'crypto', 'Invest in BNB with live BNB/USD charts and AI trading signals.', 'token', 'mid', 500.00, 50000.00, 5.50, 5.50, 30, 7, 25.00, 30, 30, '["Live BNB chart","AI trading signals","Daily yield accrual","24/7 market monitoring"]', 1, 22
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'binancecoin');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Solana', 'solana', 'crypto', 'Invest in Solana with live SOL/USD charts and AI trading signals.', 'bolt', 'high', 500.00, 50000.00, 6.50, 6.50, 30, 7, 25.00, 30, 30, '["Live SOL chart","AI trading signals","Daily yield accrual","24/7 market monitoring"]', 1, 23
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'solana');

-- Stocks (4)
INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Tesla', 'tsla', 'stocks', 'Invest in Tesla (TSLA) with live equity charts and AI trading signals.', 'electric_car', 'high', 500.00, 50000.00, 5.50, 5.50, 30, 7, 25.00, 30, 30, '["Live TSLA chart","AI trading signals","Daily yield accrual","US market hours tracking"]', 1, 30
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'tsla');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Microsoft', 'msft', 'stocks', 'Invest in Microsoft (MSFT) with live equity charts and AI trading signals.', 'business', 'low', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live MSFT chart","AI trading signals","Daily yield accrual","US market hours tracking"]', 1, 31
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'msft');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Alphabet (Google)', 'googl', 'stocks', 'Invest in Alphabet (GOOGL) with live equity charts and AI trading signals.', 'search', 'mid', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live GOOGL chart","AI trading signals","Daily yield accrual","US market hours tracking"]', 1, 32
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'googl');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'Meta Platforms', 'meta', 'stocks', 'Invest in Meta (META) with live equity charts and AI trading signals.', 'groups', 'mid', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live META chart","AI trading signals","Daily yield accrual","US market hours tracking"]', 1, 33
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'meta');

-- Forex (4)
INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'AUD/CAD', 'audcad', 'forex', 'Invest in AUD/CAD with live forex charts and AI trading signals.', 'sync_alt', 'mid', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live AUD/CAD chart","AI trading signals","Daily yield accrual","24/5 FX session tracking"]', 1, 40
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'audcad');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'USD/JPY', 'usdjpy', 'forex', 'Invest in USD/JPY with live forex charts and AI trading signals.', 'payments', 'mid', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live USD/JPY chart","AI trading signals","Daily yield accrual","24/5 FX session tracking"]', 1, 41
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'usdjpy');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'EUR/JPY', 'eurjpy', 'forex', 'Invest in EUR/JPY with live forex charts and AI trading signals.', 'euro', 'mid', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live EUR/JPY chart","AI trading signals","Daily yield accrual","24/5 FX session tracking"]', 1, 42
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'eurjpy');

INSERT INTO `plans` (`name`, `slug`, `plan_type`, `description`, `icon`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`)
SELECT 'NZD/USD', 'nzdusd', 'forex', 'Invest in NZD/USD with live forex charts and AI trading signals.', 'currency_exchange', 'mid', 500.00, 50000.00, 5.00, 5.00, 30, 7, 25.00, 30, 30, '["Live NZD/USD chart","AI trading signals","Daily yield accrual","24/5 FX session tracking"]', 1, 43
WHERE NOT EXISTS (SELECT 1 FROM `plans` WHERE `slug` = 'nzdusd');
