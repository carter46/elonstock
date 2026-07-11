-- Market replay engine tables (also appended to schema/migration.sql)
CREATE TABLE IF NOT EXISTS market_replay_candles (
  provider VARCHAR(16) NOT NULL,
  symbol VARCHAR(32) NOT NULL,
  ts INT UNSIGNED NOT NULL,
  open DECIMAL(20,8) NOT NULL,
  high DECIMAL(20,8) NOT NULL,
  low DECIMAL(20,8) NOT NULL,
  close DECIMAL(20,8) NOT NULL,
  volume DECIMAL(24,8) NOT NULL DEFAULT 0,
  PRIMARY KEY (provider, symbol, ts),
  KEY idx_symbol_ts (symbol, ts)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS market_replay_meta (
  provider VARCHAR(16) NOT NULL,
  symbol VARCHAR(32) NOT NULL,
  last_ingest_at INT UNSIGNED NOT NULL DEFAULT 0,
  last_candle_ts INT UNSIGNED NOT NULL DEFAULT 0,
  buffer_health_pct TINYINT UNSIGNED NOT NULL DEFAULT 100,
  PRIMARY KEY (provider, symbol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
