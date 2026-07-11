-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 27, 2026 at 01:14 PM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u502532383_bloomberg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_mailbox`
--

CREATE TABLE `admin_mailbox` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `direction` enum('in','out') NOT NULL,
  `source` varchar(32) NOT NULL DEFAULT 'system',
  `mailbox_folder` varchar(255) DEFAULT NULL,
  `imap_uid` bigint(20) UNSIGNED DEFAULT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `in_reply_to` varchar(255) DEFAULT NULL,
  `references` text DEFAULT NULL,
  `mail_date` datetime DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `to_emails` text DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `body_html` longtext DEFAULT NULL,
  `body_text` longtext DEFAULT NULL,
  `status` enum('received','sent','failed') NOT NULL DEFAULT 'sent',
  `error_text` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_mailbox`
--

INSERT INTO `admin_mailbox` (`id`, `direction`, `source`, `mailbox_folder`, `imap_uid`, `message_id`, `in_reply_to`, `references`, `mail_date`, `from_email`, `from_name`, `to_emails`, `subject`, `body_html`, `body_text`, `status`, `error_text`, `created_at`) VALUES
(1, 'out', 'admin_compose', NULL, NULL, NULL, NULL, NULL, NULL, 'support@bloombitfx.com', 'Bloombit', 'mr.carter.tech07@gmail.com', 'reminder of event meeeting', NULL, 'ggggs', 'sent', NULL, '2026-02-18 17:46:55'),
(2, 'out', 'admin_compose', NULL, NULL, NULL, NULL, NULL, NULL, 'support@bloombitfx.com', 'Bloombit', 'j.donovan@gmail.com, billyfredrickgibbons@gmail.com', 'reminder of event meeeting', NULL, 'ggggs', 'sent', NULL, '2026-02-18 17:46:56'),
(3, 'in', 'contact_form', NULL, NULL, NULL, NULL, NULL, NULL, 'folusho27@yahoo.com', 'Folusho. Ofemu', 'legal@bloombit.com', 'Technical Issue', '<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"utf-8\"/>\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>\n<title>Bloombit FX | Contact Form</title>\n</head>\n<body style=\"font-family:Arial,sans-serif;margin:0;padding:0;background:#f8f8f5;color:#1d180c;line-height:1.6\">\n<div style=\"max-width:600px;margin:0 auto;padding:24px\">\n<div style=\"background:#fff;border:1px solid #e5e5e0;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06)\">\n<div style=\"height:6px;width:100%;background:#ffc105\"></div>\n<div style=\"padding:32px 40px 24px;background:#fff;border-bottom:1px solid #f0f0f0;text-align:center\">\n<span style=\"font-size:32px;font-weight:700;color:#1d180c;letter-spacing:-0.02em;line-height:1.2\">Bloombit <span style=\"color:#ffc105\">FX</span></span>\n</div>\n<div style=\"padding:32px 40px\">\n<span style=\"display:inline-block;padding:6px 12px;background:rgba(255,193,5,0.15);color:#b8860b;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px;margin-bottom:20px\">Contact Form</span>\n<h2 style=\"margin:0 0 24px;font-size:24px;font-weight:700;color:#1d180c\">New message from Bloombit FX website</h2>\n<table style=\"width:100%;border-collapse:collapse;margin-bottom:24px\">\n<tr><td style=\"padding:8px 0;color:#5c5c52;font-weight:600;width:120px\">Name</td><td style=\"padding:8px 0;color:#1d180c\">Folusho. Ofemu</td></tr>\n<tr><td style=\"padding:8px 0;color:#5c5c52;font-weight:600\">Email</td><td style=\"padding:8px 0\"><a href=\"mailto:folusho27@yahoo.com\" style=\"color:#ffc105\">folusho27@yahoo.com</a></td></tr>\n<tr><td style=\"padding:8px 0;color:#5c5c52;font-weight:600\">Subject</td><td style=\"padding:8px 0;color:#1d180c\">Technical Issue</td></tr>\n</table>\n<div style=\"padding:16px;background:#f5f5f0;border-radius:8px;border-left:4px solid #ffc105\">\n<div style=\"margin:0;color:#1d180c;line-height:1.7\">Upliner sent 200 dollars to invest but is showing transaction failed   Funds is reflecting transfer failed <br />\r\nWe sent trc20 tether for 200 <br />\r\nHer referal code is REF71. Please look into it</div>\n</div>\n<p style=\"margin-top:24px;font-size:13px;color:#8a8a7d\">Reply directly to this email to respond to Folusho. Ofemu.</p>\n</div>\n</div>\n</div>\n</body>\n</html>\n', 'Name: Folusho. Ofemu\nEmail: folusho27@yahoo.com\nSubject: Technical Issue\n\nMessage:\nUpliner sent 200 dollars to invest but is showing transaction failed   Funds is reflecting transfer failed \r\nWe sent trc20 tether for 200 \r\nHer referal code is REF71. Please look into it', 'received', NULL, '2026-06-24 02:23:59'),
(4, 'in', 'contact_form', NULL, NULL, NULL, NULL, NULL, NULL, 'folusho27@yahoo.com', 'Folusho Ofemu', 'legal@bloombit.com', 'Technical Issue', '<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"utf-8\"/>\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>\n<title>Bloombit FX | Contact Form</title>\n</head>\n<body style=\"font-family:Arial,sans-serif;margin:0;padding:0;background:#f8f8f5;color:#1d180c;line-height:1.6\">\n<div style=\"max-width:600px;margin:0 auto;padding:24px\">\n<div style=\"background:#fff;border:1px solid #e5e5e0;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06)\">\n<div style=\"height:6px;width:100%;background:#ffc105\"></div>\n<div style=\"padding:32px 40px 24px;background:#fff;border-bottom:1px solid #f0f0f0;text-align:center\">\n<span style=\"font-size:32px;font-weight:700;color:#1d180c;letter-spacing:-0.02em;line-height:1.2\">Bloombit <span style=\"color:#ffc105\">FX</span></span>\n</div>\n<div style=\"padding:32px 40px\">\n<span style=\"display:inline-block;padding:6px 12px;background:rgba(255,193,5,0.15);color:#b8860b;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;border-radius:9999px;margin-bottom:20px\">Contact Form</span>\n<h2 style=\"margin:0 0 24px;font-size:24px;font-weight:700;color:#1d180c\">New message from Bloombit FX website</h2>\n<table style=\"width:100%;border-collapse:collapse;margin-bottom:24px\">\n<tr><td style=\"padding:8px 0;color:#5c5c52;font-weight:600;width:120px\">Name</td><td style=\"padding:8px 0;color:#1d180c\">Folusho Ofemu</td></tr>\n<tr><td style=\"padding:8px 0;color:#5c5c52;font-weight:600\">Email</td><td style=\"padding:8px 0\"><a href=\"mailto:folusho27@yahoo.com\" style=\"color:#ffc105\">folusho27@yahoo.com</a></td></tr>\n<tr><td style=\"padding:8px 0;color:#5c5c52;font-weight:600\">Subject</td><td style=\"padding:8px 0;color:#1d180c\">Technical Issue</td></tr>\n</table>\n<div style=\"padding:16px;background:#f5f5f0;border-radius:8px;border-left:4px solid #ffc105\">\n<div style=\"margin:0;color:#1d180c;line-height:1.7\">I have uploaded transfer information regarding 1000 dollars I transferred to my account. It still has not reflected yet on my deposit</div>\n</div>\n<p style=\"margin-top:24px;font-size:13px;color:#8a8a7d\">Reply directly to this email to respond to Folusho Ofemu.</p>\n</div>\n</div>\n</div>\n</body>\n</html>\n', 'Name: Folusho Ofemu\nEmail: folusho27@yahoo.com\nSubject: Technical Issue\n\nMessage:\nI have uploaded transfer information regarding 1000 dollars I transferred to my account. It still has not reflected yet on my deposit', 'received', NULL, '2026-06-25 14:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast_campaigns`
--

CREATE TABLE `broadcast_campaigns` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `recipients_filter` varchar(50) NOT NULL DEFAULT 'all',
  `total_recipients` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('sent','draft') NOT NULL DEFAULT 'sent',
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `broadcast_campaigns`
--

INSERT INTO `broadcast_campaigns` (`id`, `subject`, `recipients_filter`, `total_recipients`, `status`, `sent_at`, `created_at`) VALUES
(1, 'reminder of event meeeting', 'manual', 1, 'sent', '2026-02-18 17:46:55', '2026-02-18 17:46:55'),
(2, 'reminder of event meeeting', 'all', 2, 'sent', '2026-02-18 17:46:56', '2026-02-18 17:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `coins`
--

CREATE TABLE `coins` (
  `id` int(10) UNSIGNED NOT NULL,
  `coin_key` varchar(50) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coins`
--

INSERT INTO `coins` (`id`, `coin_key`, `display_name`, `symbol`, `logo`, `enabled`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'bitcoin', 'Bitcoin', 'BTC', 'https://assets.coingecko.com/coins/images/1/large/bitcoin.png', 1, 1, '2026-02-15 23:56:22', '2026-02-15 23:56:22'),
(2, 'ethereum', 'Ethereum', 'ETH', 'https://assets.coingecko.com/coins/images/279/large/ethereum.png', 1, 2, '2026-02-15 23:56:22', '2026-02-15 23:56:22'),
(3, 'tether', 'Tether', 'USDT', 'https://assets.coingecko.com/coins/images/325/large/Tether.png', 1, 3, '2026-02-15 23:56:22', '2026-02-15 23:56:22'),
(4, 'solana', 'Solana', 'SOL', 'https://assets.coingecko.com/coins/images/4128/large/solana.png', 1, 4, '2026-02-15 23:56:22', '2026-02-15 23:56:22'),
(5, 'bnb', 'BNB', 'BNB', 'https://assets.coingecko.com/coins/images/825/large/bnb-icon2_2x.png', 1, 5, '2026-02-15 23:56:22', '2026-02-15 23:56:22'),
(6, 'ripple', 'XRP', 'XRP', 'https://assets.coingecko.com/coins/images/44/large/xrp-symbol-white-128.png', 1, 6, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(7, 'cardano', 'Cardano', 'ADA', 'https://assets.coingecko.com/coins/images/975/large/cardano.png', 1, 7, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(8, 'dogecoin', 'Dogecoin', 'DOGE', 'https://assets.coingecko.com/coins/images/5/large/dogecoin.png', 1, 8, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(9, 'polkadot', 'Polkadot', 'DOT', 'https://assets.coingecko.com/coins/images/12171/large/polkadot.png', 1, 9, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(10, 'avalanche-2', 'Avalanche', 'AVAX', 'https://assets.coingecko.com/coins/images/12559/large/Avalanche_Circle_RedWhite_Trans.png', 1, 10, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(11, 'matic-network', 'Polygon', 'MATIC', 'https://assets.coingecko.com/coins/images/4713/large/matic-token-icon.png', 1, 11, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(12, 'chainlink', 'Chainlink', 'LINK', 'https://assets.coingecko.com/coins/images/877/large/chainlink-new-logo.png', 1, 12, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(13, 'uniswap', 'Uniswap', 'UNI', 'https://assets.coingecko.com/coins/images/12504/large/uni.jpg', 1, 13, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(14, 'cosmos', 'Cosmos', 'ATOM', 'https://assets.coingecko.com/coins/images/1481/large/cosmos_hub.png', 1, 14, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(15, 'litecoin', 'Litecoin', 'LTC', 'https://assets.coingecko.com/coins/images/2/large/litecoin.png', 1, 15, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(16, 'bitcoin-cash', 'Bitcoin Cash', 'BCH', 'https://assets.coingecko.com/coins/images/780/large/bitcoin-cash-circle.png', 1, 16, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(17, 'stellar', 'Stellar', 'XLM', 'https://assets.coingecko.com/coins/images/100/large/Stellar_symbol_black_RGB.png', 1, 17, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(18, 'algorand', 'Algorand', 'ALGO', 'https://assets.coingecko.com/coins/images/4380/large/download.png', 1, 18, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(19, 'tron', 'TRON', 'TRX', 'https://assets.coingecko.com/coins/images/1094/large/tron-logo.png', 1, 19, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(20, 'monero', 'Monero', 'XMR', 'https://assets.coingecko.com/coins/images/69/large/monero_logo.png', 1, 20, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(21, 'ethereum-classic', 'Ethereum Classic', 'ETC', 'https://assets.coingecko.com/coins/images/453/large/ethereum-classic-logo.png', 1, 21, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(22, 'filecoin', 'Filecoin', 'FIL', 'https://assets.coingecko.com/coins/images/12817/large/filecoin.png', 1, 22, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(23, 'dai', 'Dai', 'DAI', 'https://assets.coingecko.com/coins/images/9956/large/Badge_Dai.png', 1, 23, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(24, 'shiba-inu', 'Shiba Inu', 'SHIB', 'https://assets.coingecko.com/coins/images/11939/large/shiba.png', 1, 24, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(25, 'near', 'NEAR Protocol', 'NEAR', 'https://assets.coingecko.com/coins/images/10365/large/near.jpg', 1, 25, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(26, 'aptos', 'Aptos', 'APT', 'https://assets.coingecko.com/coins/images/26455/large/aptos_round.png', 1, 26, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(27, 'arbitrum', 'Arbitrum', 'ARB', 'https://assets.coingecko.com/coins/images/16547/large/photo_2023-03-29_21.47.00.jpeg', 1, 27, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(28, 'optimism', 'Optimism', 'OP', 'https://assets.coingecko.com/coins/images/25244/large/Optimism.png', 1, 28, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(29, 'vechain', 'VeChain', 'VET', 'https://assets.coingecko.com/coins/images/1167/large/VeChain-Logo-768x725.png', 1, 29, '2026-02-16 00:42:41', '2026-02-16 00:42:41'),
(30, 'hedera-hashgraph', 'Hedera', 'HBAR', 'https://assets.coingecko.com/coins/images/3688/large/hbar.png', 1, 30, '2026-02-16 00:42:41', '2026-02-16 00:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `email_otp_codes`
--

CREATE TABLE `email_otp_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` char(6) NOT NULL,
  `purpose` enum('register','login','disable_2fa') NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_otp_codes`
--

INSERT INTO `email_otp_codes` (`id`, `email`, `otp`, `purpose`, `expires_at`, `used`, `created_at`) VALUES
(1, 'billyfredrickgibbons@gmail.com', '577084', 'disable_2fa', '2026-02-18 03:43:20', 0, '2026-02-18 03:33:20'),
(2, 'j.ani.cem.endo.zz.a.a@gmail.com', '585178', 'register', '2026-02-18 21:34:03', 0, '2026-02-18 21:24:03'),
(3, 'e.l.ian.tr.a.v.is.s.s@gmail.com', '571074', 'register', '2026-02-18 21:43:51', 0, '2026-02-18 21:33:51'),
(4, 'j.o.n.n.a.r.uel.in@gmail.com', '974977', 'register', '2026-02-18 21:53:44', 0, '2026-02-18 21:43:44'),
(5, 'mr.carter.tech07@gmail.com', '738084', 'register', '2026-02-19 10:12:30', 1, '2026-02-19 10:02:30'),
(6, 'mr.carter.tech07@gmail.com', '567563', 'register', '2026-02-19 17:37:57', 1, '2026-02-19 17:27:57'),
(7, 'mr.carter.tech07@gmail.com', '672961', 'register', '2026-02-19 19:23:01', 1, '2026-02-19 19:13:01'),
(8, 'billyfredrickgibbons@gmail.com', '596500', 'register', '2026-02-19 19:42:14', 1, '2026-02-19 19:32:14'),
(9, 'billyfredrickgibbons@gmail.com', '131047', 'register', '2026-02-19 19:44:36', 1, '2026-02-19 19:34:36'),
(10, 'mr.carter.tech07@gmail.com', '421096', 'register', '2026-02-19 20:15:42', 1, '2026-02-19 20:05:42'),
(11, 'mr.carter.tech07@gmail.com', '300548', 'register', '2026-02-19 20:17:12', 1, '2026-02-19 20:07:12'),
(12, 'mr.carter.tech07@gmail.com', '211105', 'register', '2026-02-19 20:45:29', 1, '2026-02-19 20:35:29'),
(13, 'mr.carter.tech07@gmail.com', '486287', 'register', '2026-02-19 20:47:00', 1, '2026-02-19 20:37:00'),
(14, 'mr.carter.tech07@gmail.com', '107239', 'register', '2026-02-19 22:21:17', 1, '2026-02-19 22:11:17'),
(15, 'murungibetty621@gmail.com', '986487', 'register', '2026-02-20 08:39:07', 1, '2026-02-20 08:29:07'),
(16, 'mr.carter.tech07@gmail.com', '326753', 'login', '2026-02-21 10:16:41', 1, '2026-02-21 10:06:41'),
(17, 'mr.carter.tech07@gmail.com', '890391', 'login', '2026-02-21 10:19:26', 1, '2026-02-21 10:09:26'),
(18, 'mr.carter.tech07@gmail.com', '934305', 'login', '2026-02-21 14:11:47', 1, '2026-02-21 14:01:47'),
(19, 'mr.carter.tech07@gmail.com', '943846', 'login', '2026-02-21 14:24:24', 1, '2026-02-21 14:14:24'),
(20, 'diididududjjdjd@gmail10p.com', '956095', 'register', '2026-02-24 10:45:54', 1, '2026-02-24 10:35:54'),
(21, 'goldfranklin1@gmail.com', '587338', 'register', '2026-02-25 13:27:51', 1, '2026-02-25 13:17:51'),
(22, 'beverlypowell231@gmail.com', '731696', 'register', '2026-02-28 01:16:05', 1, '2026-02-28 01:06:05'),
(23, 'cbh3570@gmail.com', '680797', 'register', '2026-02-28 14:27:14', 1, '2026-02-28 14:17:14'),
(24, 'benjaminraynold07@gmail.com', '775725', 'register', '2026-03-02 21:42:29', 1, '2026-03-02 21:32:29'),
(25, 'benjaminraynold07@gmail.com', '354945', 'login', '2026-03-03 11:31:55', 1, '2026-03-03 11:21:55'),
(26, 'benjaminraynold07@gmail.com', '795275', 'login', '2026-03-03 12:07:45', 1, '2026-03-03 11:57:45'),
(27, 'beverlypowell231@gmail.com', '430464', 'login', '2026-03-03 12:21:04', 1, '2026-03-03 12:11:04'),
(28, 'beverlypowell231@gmail.com', '128930', 'login', '2026-03-03 12:22:15', 1, '2026-03-03 12:12:15'),
(29, 'benjaminraynold07@gmail.com', '817420', 'login', '2026-03-03 12:31:49', 1, '2026-03-03 12:21:49'),
(30, 'cbh3570@gmail.com', '430240', 'login', '2026-03-03 13:11:33', 1, '2026-03-03 13:01:33'),
(31, 'cbh3570@gmail.com', '694578', 'login', '2026-03-03 14:03:57', 1, '2026-03-03 13:53:57'),
(32, 'cbh3570@gmail.com', '901679', 'login', '2026-03-03 14:06:37', 1, '2026-03-03 13:56:37'),
(33, 'cbh3570@gmail.com', '421726', 'login', '2026-03-03 14:07:55', 1, '2026-03-03 13:57:55'),
(34, 'cbh3570@gmail.com', '903074', 'login', '2026-03-03 14:08:02', 1, '2026-03-03 13:58:02'),
(35, 'cbh3570@gmail.com', '550167', 'login', '2026-03-03 14:08:14', 1, '2026-03-03 13:58:14'),
(36, 'cbh3570@gmail.com', '252224', 'login', '2026-03-03 14:10:53', 1, '2026-03-03 14:00:53'),
(37, 'cbh3570@gmail.com', '838984', 'login', '2026-03-03 14:11:55', 1, '2026-03-03 14:01:55'),
(38, 'cbh3570@gmail.com', '163036', 'login', '2026-03-03 14:12:25', 1, '2026-03-03 14:02:25'),
(39, 'beverlypowell231@gmail.com', '416279', 'login', '2026-03-03 15:29:05', 1, '2026-03-03 15:19:05'),
(40, 'beverlypowell231@gmail.com', '880288', 'login', '2026-03-03 17:03:24', 1, '2026-03-03 16:53:24'),
(41, 'beverlypowell231@gmail.com', '359792', 'login', '2026-03-03 17:07:22', 1, '2026-03-03 16:57:22'),
(42, 'beverlypowell231@gmail.com', '157054', 'login', '2026-03-03 17:07:30', 1, '2026-03-03 16:57:30'),
(43, 'beverlypowell231@gmail.com', '867269', 'login', '2026-03-03 17:08:21', 1, '2026-03-03 16:58:21'),
(44, 'mr.carter.tech07@gmail.com', '350656', 'login', '2026-03-03 19:02:36', 1, '2026-03-03 18:52:36'),
(45, 'mr.carter.tech07@gmail.com', '194527', 'login', '2026-03-03 19:06:47', 1, '2026-03-03 18:56:47'),
(46, 'mr.carter.tech07@gmail.com', '936409', 'login', '2026-03-03 19:08:22', 1, '2026-03-03 18:58:22'),
(47, 'mr.carter.tech07@gmail.com', '930793', 'login', '2026-03-03 19:09:58', 0, '2026-03-03 18:59:58'),
(48, 'benjaminraynold07@gmail.com', '689064', 'login', '2026-03-03 19:11:17', 1, '2026-03-03 19:01:17'),
(49, 'beverlypowell231@gmail.com', '952522', 'login', '2026-03-03 21:24:50', 1, '2026-03-03 21:14:50'),
(50, 'cbh3570@gmail.com', '346120', 'login', '2026-03-03 22:04:07', 1, '2026-03-03 21:54:07'),
(51, 'murungibetty621@gmail.com', '616771', 'login', '2026-03-03 22:15:38', 1, '2026-03-03 22:05:38'),
(52, 'cbh3570@gmail.com', '773153', 'login', '2026-03-03 22:19:08', 1, '2026-03-03 22:09:08'),
(53, 'cbh3570@gmail.com', '734683', 'login', '2026-03-03 22:20:41', 1, '2026-03-03 22:10:41'),
(54, 'cbh3570@gmail.com', '271169', 'login', '2026-03-03 22:21:44', 1, '2026-03-03 22:11:44'),
(55, 'murungibetty621@gmail.com', '888944', 'login', '2026-03-03 23:34:37', 1, '2026-03-03 23:24:37'),
(56, 'murungibetty621@gmail.com', '555153', 'login', '2026-03-03 23:36:27', 1, '2026-03-03 23:26:27'),
(57, 'beverlypowell231@gmail.com', '243804', 'login', '2026-03-04 13:54:58', 1, '2026-03-04 13:44:58'),
(58, 'beverlypowell231@gmail.com', '933139', 'login', '2026-03-04 13:56:10', 1, '2026-03-04 13:46:10'),
(59, 'beverlypowell231@gmail.com', '578277', 'login', '2026-03-04 20:09:52', 1, '2026-03-04 19:59:52'),
(60, 'cbh3570@gmail.com', '554012', 'login', '2026-03-04 23:17:17', 1, '2026-03-04 23:07:17'),
(61, 'beverlypowell231@gmail.com', '627022', 'login', '2026-03-04 23:58:32', 1, '2026-03-04 23:48:32'),
(62, 'beverlypowell231@gmail.com', '487176', 'login', '2026-03-05 01:46:03', 1, '2026-03-05 01:36:03'),
(63, 'beverlypowell231@gmail.com', '763602', 'login', '2026-03-05 10:28:01', 1, '2026-03-05 10:18:01'),
(64, 'beverlypowell231@gmail.com', '349525', 'login', '2026-03-06 13:25:13', 1, '2026-03-06 13:15:13'),
(65, 'beverlypowell231@gmail.com', '670057', 'login', '2026-03-07 16:32:23', 1, '2026-03-07 16:22:23'),
(66, 'beverlypowell231@gmail.com', '327081', 'login', '2026-03-08 19:37:44', 1, '2026-03-08 19:27:44'),
(67, 'beverlypowell231@gmail.com', '798962', 'login', '2026-03-08 20:31:01', 1, '2026-03-08 20:21:01'),
(68, 'beverlypowell231@gmail.com', '187983', 'login', '2026-03-09 22:36:03', 1, '2026-03-09 22:26:03'),
(69, 'murungibetty621@gmail.com', '520788', 'login', '2026-03-09 22:40:23', 1, '2026-03-09 22:30:23'),
(70, 'murungibetty621@gmail.com', '314614', 'login', '2026-03-09 22:42:55', 1, '2026-03-09 22:32:55'),
(71, 'beverlypowell231@gmail.com', '645221', 'login', '2026-03-09 23:17:41', 1, '2026-03-09 23:07:41'),
(72, 'cbh3570@gmail.com', '438627', 'login', '2026-03-09 23:22:30', 1, '2026-03-09 23:12:30'),
(73, 'cbh3570@gmail.com', '533618', 'login', '2026-03-09 23:35:58', 1, '2026-03-09 23:25:58'),
(74, 'cbh3570@gmail.com', '270983', 'login', '2026-03-09 23:38:24', 1, '2026-03-09 23:28:24'),
(75, 'beverlypowell231@gmail.com', '184510', 'login', '2026-03-10 12:46:08', 1, '2026-03-10 12:36:08'),
(76, 'beverlypowell231@gmail.com', '844616', 'login', '2026-03-10 12:47:31', 1, '2026-03-10 12:37:31'),
(77, 'cbh3570@gmail.com', '412991', 'login', '2026-03-10 14:20:25', 1, '2026-03-10 14:10:25'),
(78, 'cbh3570@gmail.com', '212612', 'login', '2026-03-10 20:20:37', 1, '2026-03-10 20:10:37'),
(79, 'cbh3570@gmail.com', '639034', 'login', '2026-03-10 20:22:20', 1, '2026-03-10 20:12:20'),
(80, 'beverlypowell231@gmail.com', '890141', 'login', '2026-03-11 01:07:40', 1, '2026-03-11 00:57:40'),
(81, 'beverlypowell231@gmail.com', '724607', 'login', '2026-03-11 12:39:54', 1, '2026-03-11 12:29:54'),
(82, 'beverlypowell231@gmail.com', '831967', 'login', '2026-03-11 20:05:50', 1, '2026-03-11 19:55:50'),
(83, 'beverlypowell231@gmail.com', '829051', 'login', '2026-03-12 00:34:55', 1, '2026-03-12 00:24:55'),
(84, 'beverlypowell231@gmail.com', '268354', 'login', '2026-03-12 11:56:36', 1, '2026-03-12 11:46:36'),
(85, 'cbh3570@gmail.com', '406594', 'login', '2026-03-12 13:12:50', 1, '2026-03-12 13:02:50'),
(86, 'beverlypowell231@gmail.com', '959891', 'login', '2026-03-13 00:16:05', 1, '2026-03-13 00:06:05'),
(87, 'cbh3570@gmail.com', '268046', 'login', '2026-03-13 12:17:09', 1, '2026-03-13 12:07:09'),
(88, 'cbh3570@gmail.com', '603439', 'login', '2026-03-13 12:18:24', 1, '2026-03-13 12:08:24'),
(89, 'beverlypowell231@gmail.com', '508763', 'login', '2026-03-15 02:45:42', 1, '2026-03-15 02:35:42'),
(90, 'beverlypowell231@gmail.com', '342316', 'login', '2026-03-15 04:12:01', 1, '2026-03-15 04:02:01'),
(91, 'beverlypowell231@gmail.com', '512642', 'login', '2026-03-15 20:39:49', 1, '2026-03-15 20:29:49'),
(92, 'beverlypowell231@gmail.com', '886893', 'login', '2026-03-15 20:42:00', 1, '2026-03-15 20:32:00'),
(93, 'beverlypowell231@gmail.com', '469352', 'login', '2026-03-16 17:13:07', 1, '2026-03-16 17:03:07'),
(94, 'beverlypowell231@gmail.com', '217639', 'login', '2026-03-16 20:39:08', 1, '2026-03-16 20:29:08'),
(95, 'beverlypowell231@gmail.com', '239890', 'login', '2026-03-16 20:53:16', 1, '2026-03-16 20:43:16'),
(96, 'beverlypowell231@gmail.com', '392172', 'login', '2026-03-16 22:33:51', 1, '2026-03-16 22:23:51'),
(97, 'beverlypowell231@gmail.com', '895384', 'login', '2026-03-17 17:19:37', 1, '2026-03-17 17:09:37'),
(98, 'beverlypowell231@gmail.com', '872193', 'login', '2026-03-17 17:29:44', 1, '2026-03-17 17:19:44'),
(99, 'cbh3570@gmail.com', '331075', 'login', '2026-03-17 18:54:30', 1, '2026-03-17 18:44:30'),
(100, 'beverlypowell231@gmail.com', '425966', 'login', '2026-03-18 00:58:21', 1, '2026-03-18 00:48:21'),
(101, 'beverlypowell231@gmail.com', '715734', 'login', '2026-03-18 03:00:47', 1, '2026-03-18 02:50:47'),
(102, 'cbh3570@gmail.com', '740477', 'login', '2026-03-18 13:38:51', 1, '2026-03-18 13:28:51'),
(103, 'cbh3570@gmail.com', '758702', 'login', '2026-03-19 13:59:50', 1, '2026-03-19 13:49:50'),
(104, 'cbh3570@gmail.com', '792605', 'login', '2026-03-20 14:44:16', 1, '2026-03-20 14:34:16'),
(105, 'beverlypowell231@gmail.com', '867413', 'login', '2026-03-20 21:45:31', 1, '2026-03-20 21:35:31'),
(106, 'cbh3570@gmail.com', '354137', 'login', '2026-03-21 13:54:37', 1, '2026-03-21 13:44:37'),
(107, 'cbh3570@gmail.com', '925678', 'login', '2026-03-25 18:56:37', 1, '2026-03-25 18:46:37'),
(108, 'beverlypowell231@gmail.com', '155066', 'login', '2026-03-26 14:28:51', 1, '2026-03-26 14:18:51'),
(109, 'beverlypowell231@gmail.com', '584834', 'login', '2026-03-26 17:29:19', 1, '2026-03-26 17:19:19'),
(110, 'cbh3570@gmail.com', '745451', 'login', '2026-03-27 22:56:17', 1, '2026-03-27 22:46:17'),
(111, 'beverlypowell231@gmail.com', '996467', 'login', '2026-03-28 02:58:57', 1, '2026-03-28 02:48:57'),
(112, 'cbh3570@gmail.com', '239082', 'login', '2026-03-28 18:12:51', 1, '2026-03-28 18:02:51'),
(113, 'beverlypowell231@gmail.com', '374270', 'login', '2026-03-31 02:44:19', 1, '2026-03-31 02:34:19'),
(114, 'Kandros74@gmail.com', '398175', 'register', '2026-03-31 17:51:47', 1, '2026-03-31 17:41:47'),
(115, 'cbh3570@gmail.com', '460871', 'login', '2026-03-31 19:53:15', 1, '2026-03-31 19:43:15'),
(116, 'cbh3570@gmail.com', '890022', 'login', '2026-03-31 19:54:34', 1, '2026-03-31 19:44:34'),
(117, 'cbh3570@gmail.com', '688317', 'login', '2026-04-02 11:46:28', 1, '2026-04-02 11:36:28'),
(118, 'beverlypowell231@gmail.com', '876942', 'login', '2026-04-03 03:19:40', 1, '2026-04-03 03:09:40'),
(119, 'beverlypowell231@gmail.com', '745186', 'login', '2026-04-04 12:03:03', 1, '2026-04-04 11:53:03'),
(120, 'cbh3570@gmail.com', '953085', 'login', '2026-04-04 16:18:08', 1, '2026-04-04 16:08:08'),
(121, 'beverlypowell231@gmail.com', '262224', 'login', '2026-04-04 16:57:31', 1, '2026-04-04 16:47:31'),
(122, 'beverlypowell231@gmail.com', '884246', 'login', '2026-04-04 17:00:50', 1, '2026-04-04 16:50:50'),
(123, 'beverlypowell231@gmail.com', '288817', 'login', '2026-04-04 17:01:07', 1, '2026-04-04 16:51:07'),
(124, 'beverlypowell231@gmail.com', '821014', 'login', '2026-04-04 17:02:33', 1, '2026-04-04 16:52:33'),
(125, 'beverlypowell231@gmail.com', '512527', 'login', '2026-04-04 17:35:45', 1, '2026-04-04 17:25:45'),
(126, 'beverlypowell231@gmail.com', '300792', 'login', '2026-04-04 17:37:34', 1, '2026-04-04 17:27:34'),
(127, 'cbh3570@gmail.com', '752614', 'login', '2026-04-04 17:48:29', 1, '2026-04-04 17:38:29'),
(128, 'beverlypowell231@gmail.com', '297641', 'login', '2026-04-04 18:36:34', 1, '2026-04-04 18:26:34'),
(129, 'beverlypowell231@gmail.com', '829052', 'login', '2026-04-04 18:37:45', 1, '2026-04-04 18:27:45'),
(130, 'beverlypowell231@gmail.com', '612622', 'login', '2026-04-04 18:39:02', 1, '2026-04-04 18:29:02'),
(131, 'beverlypowell231@gmail.com', '770767', 'login', '2026-04-04 21:45:22', 1, '2026-04-04 21:35:22'),
(132, 'beverlypowell231@gmail.com', '577323', 'login', '2026-04-04 22:43:18', 1, '2026-04-04 22:33:18'),
(133, 'cbh3570@gmail.com', '309811', 'login', '2026-04-06 03:14:04', 1, '2026-04-06 03:04:04'),
(134, 'cbh3570@gmail.com', '124087', 'login', '2026-04-06 15:51:11', 1, '2026-04-06 15:41:11'),
(135, 'cbh3570@gmail.com', '879317', 'login', '2026-04-06 19:19:27', 1, '2026-04-06 19:09:27'),
(136, 'beverlypowell231@gmail.com', '763769', 'login', '2026-04-07 01:50:05', 1, '2026-04-07 01:40:05'),
(137, 'cbh3570@gmail.com', '568808', 'login', '2026-04-08 17:23:10', 1, '2026-04-08 17:13:10'),
(138, 'cbh3570@gmail.com', '233035', 'login', '2026-04-12 17:20:01', 1, '2026-04-12 17:10:01'),
(139, 'beverlypowell231@gmail.com', '321040', 'login', '2026-04-14 00:48:10', 1, '2026-04-14 00:38:10'),
(140, 'beverlypowell231@gmail.com', '620529', 'login', '2026-04-14 01:07:49', 1, '2026-04-14 00:57:49'),
(141, 'beverlypowell231@gmail.com', '979079', 'login', '2026-04-14 01:16:35', 1, '2026-04-14 01:06:35'),
(142, 'beverlypowell231@gmail.com', '536705', 'login', '2026-04-14 11:01:20', 1, '2026-04-14 10:51:20'),
(143, 'beverlypowell231@gmail.com', '613286', 'login', '2026-04-14 11:04:06', 1, '2026-04-14 10:54:06'),
(144, 'beverlypowell231@gmail.com', '427533', 'login', '2026-04-14 12:27:57', 1, '2026-04-14 12:17:57'),
(145, 'beverlypowell231@gmail.com', '356597', 'login', '2026-04-14 12:29:52', 1, '2026-04-14 12:19:52'),
(146, 'beverlypowell231@gmail.com', '853934', 'login', '2026-04-16 13:22:30', 1, '2026-04-16 13:12:30'),
(147, 'cbh3570@gmail.com', '530417', 'login', '2026-04-22 15:19:15', 0, '2026-04-22 15:09:15'),
(148, 'beverlypowell231@gmail.com', '962466', 'login', '2026-04-23 18:34:47', 1, '2026-04-23 18:24:47'),
(149, 'lawmichealxx@gmail.com', '475805', 'register', '2026-04-28 17:05:45', 1, '2026-04-28 16:55:45'),
(150, 'y6hnckvzin@ozsaip.com', '657154', 'register', '2026-04-29 07:42:05', 1, '2026-04-29 07:32:05'),
(151, 'y6hnckvzin@ozsaip.com', '995961', 'register', '2026-04-29 07:43:58', 1, '2026-04-29 07:33:58'),
(152, '9phnz7a4f8@wnbaldwy.com', '739474', 'register', '2026-05-06 10:52:26', 1, '2026-05-06 10:42:26'),
(153, 'jamesjohnson53g@gmail.com', '588295', 'register', '2026-05-22 22:07:03', 1, '2026-05-22 21:57:03'),
(154, 'benjaminraynold07@gmail.com', '970772', 'login', '2026-05-25 22:57:29', 1, '2026-05-25 22:47:29'),
(155, 'benjaminraynold07@gmail.com', '416623', 'login', '2026-05-26 16:25:21', 1, '2026-05-26 16:15:21'),
(156, 'benjaminraynold07@gmail.com', '698884', 'login', '2026-05-26 18:00:23', 1, '2026-05-26 17:50:23'),
(157, 'goldfranklin1@gmail.com', '978610', 'login', '2026-06-09 13:43:20', 1, '2026-06-09 13:33:20'),
(158, 'goldfranklin1@gmail.com', '384361', 'login', '2026-06-09 13:52:05', 1, '2026-06-09 13:42:05'),
(159, 'goldfranklin1@gmail.com', '704505', 'login', '2026-06-09 14:10:34', 1, '2026-06-09 14:00:34'),
(160, 'folusho27@yahoo.com', '751859', 'register', '2026-06-10 11:19:32', 1, '2026-06-10 11:09:32'),
(161, 'sandychan538@gmail.com', '247843', 'register', '2026-06-12 09:22:55', 1, '2026-06-12 09:12:55'),
(162, 'justymighty70@gmail.com', '418848', 'register', '2026-06-21 21:08:08', 1, '2026-06-21 20:58:08'),
(163, 'nickygoldhairs4@gmail.com', '321620', 'register', '2026-06-21 23:54:44', 1, '2026-06-21 23:44:44'),
(164, 'akharohfaith@gmail.com', '165827', 'register', '2026-06-22 19:52:04', 1, '2026-06-22 19:42:04'),
(165, 'omolaraolanipekun27@gmail.com', '983946', 'register', '2026-06-22 23:16:13', 1, '2026-06-22 23:06:13'),
(166, 'emmanueloratokhai44@gmail.com', '991306', 'register', '2026-06-23 00:52:46', 1, '2026-06-23 00:42:46'),
(167, 'kokomadavidson@gmail.com', '643608', 'register', '2026-06-23 06:23:27', 1, '2026-06-23 06:13:27'),
(168, 'tegaovus@gmail.com', '647855', 'register', '2026-06-23 06:53:22', 1, '2026-06-23 06:43:22'),
(169, 'luvvylizzy@gmail.com', '288957', 'register', '2026-06-23 07:30:38', 1, '2026-06-23 07:20:38'),
(170, 'marcelinendifor@gmail.com', '626905', 'register', '2026-06-23 15:11:14', 1, '2026-06-23 15:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `kyc_submissions`
--

CREATE TABLE `kyc_submissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `document_type` enum('passport','id_card','driver_license') NOT NULL,
  `front_path` varchar(500) NOT NULL,
  `back_path` varchar(500) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `reviewed_by` int(10) UNSIGNED DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kyc_submissions`
--

INSERT INTO `kyc_submissions` (`id`, `user_id`, `document_type`, `front_path`, `back_path`, `full_name`, `date_of_birth`, `address`, `status`, `rejection_reason`, `reviewed_by`, `reviewed_at`, `created_at`) VALUES
(1, 9, 'passport', 'uploads/kyc/9/front_1771331346_32c66798.jpg', 'uploads/kyc/9/back_1771331346_498d4063.jpg', 'James Donovan', '2026-02-11', 'fssfsf', 'approved', NULL, 1, '2026-02-17 12:29:32', '2026-02-17 12:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `method_type` enum('crypto','bank','card') NOT NULL,
  `label` varchar(120) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `coin_id` int(10) UNSIGNED DEFAULT NULL,
  `wallet_address` varchar(255) DEFAULT NULL,
  `bank_name` varchar(120) DEFAULT NULL,
  `account_name` varchar(120) DEFAULT NULL,
  `account_number` varchar(80) DEFAULT NULL,
  `routing_number` varchar(80) DEFAULT NULL,
  `swift_code` varchar(50) DEFAULT NULL,
  `iban` varchar(80) DEFAULT NULL,
  `bank_address` text DEFAULT NULL,
  `bank_branch` varchar(120) DEFAULT NULL,
  `bank_notes` text DEFAULT NULL,
  `card_brand` enum('visa','mastercard','amex') DEFAULT NULL,
  `card_holder_name` varchar(120) DEFAULT NULL,
  `card_number` varchar(32) DEFAULT NULL,
  `card_expiry` varchar(10) DEFAULT NULL,
  `card_cvc` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_type`, `label`, `enabled`, `coin_id`, `wallet_address`, `bank_name`, `account_name`, `account_number`, `routing_number`, `swift_code`, `iban`, `bank_address`, `bank_branch`, `bank_notes`, `card_brand`, `card_holder_name`, `card_number`, `card_expiry`, `card_cvc`, `created_at`, `updated_at`) VALUES
(1, 'crypto', NULL, 1, 1, 'bc1q75catla8uzsmeq2rzvn6zctwgypzp4dh9zljze', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-15 23:57:29', '2026-06-27 11:32:57'),
(2, 'crypto', NULL, 1, 2, '0x59d682AA0253e8884F08cf25E29420674dEf26eD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-15 23:57:49', '2026-06-27 11:32:57'),
(3, 'crypto', NULL, 1, 3, 'TXSFTYTrTqEb9VDorqb8MHoYFYoVp19nzr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-15 23:57:58', '2026-06-27 11:32:57'),
(4, 'crypto', NULL, 1, 4, 'GgQsdK8EWYBZaDWu2pBBEUp3kQB6JpySkVkQ2Uqbdtic', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 00:21:13', '2026-06-27 11:32:57'),
(5, 'crypto', NULL, 1, 5, '0x59d682AA0253e8884F08cf25E29420674dEf26eD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 00:21:20', '2026-06-27 11:32:57'),
(6, 'crypto', NULL, 1, 15, 'ltc1qywjdl9t4jtk7zsr7sw0e2qhmkwm25yn3svaq2m', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 00:44:41', '2026-06-27 11:32:57'),
(7, 'crypto', NULL, 1, 16, 'qq7754q80c8hmhek47mgcf3860e6j5deqge8uks3wk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 00:44:57', '2026-06-27 11:32:57'),
(8, 'crypto', NULL, 1, 19, 'TXSFTYTrTqEb9VDorqb8MHoYFYoVp19nzr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 00:45:09', '2026-06-27 11:32:57'),
(9, 'crypto', NULL, 1, 8, 'DR2Be6KTeiZSnDhMBv6SrV7bp9kSSaqEsU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16 00:45:19', '2026-06-27 11:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `pending_registrations`
--

CREATE TABLE `pending_registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT '',
  `phone_number` varchar(50) DEFAULT NULL,
  `referral_code` varchar(50) DEFAULT NULL,
  `referred_by_user_id` int(10) UNSIGNED DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `plan_type` varchar(32) NOT NULL DEFAULT 'crypto',
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `investment_risk` varchar(16) NOT NULL DEFAULT 'mid',
  `min_deposit` decimal(18,2) NOT NULL DEFAULT 0.00,
  `max_deposit` decimal(18,2) DEFAULT NULL,
  `yield_min` decimal(5,2) NOT NULL DEFAULT 0.00,
  `yield_max` decimal(5,2) NOT NULL DEFAULT 0.00,
  `duration_days` int(10) UNSIGNED NOT NULL DEFAULT 30,
  `withdrawal_days` int(10) UNSIGNED DEFAULT 7,
  `liquidation_cost` decimal(18,2) NOT NULL DEFAULT 0.00,
  `min_duration_months` int(10) UNSIGNED DEFAULT NULL,
  `max_duration_months` int(10) UNSIGNED DEFAULT NULL,
  `min_duration_days` int(10) UNSIGNED DEFAULT NULL,
  `max_duration_days` int(10) UNSIGNED DEFAULT NULL,
  `features_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `slug`, `plan_type`, `description`, `icon`, `logo_url`, `investment_risk`, `min_deposit`, `max_deposit`, `yield_min`, `yield_max`, `duration_days`, `withdrawal_days`, `liquidation_cost`, `min_duration_months`, `max_duration_months`, `min_duration_days`, `max_duration_days`, `features_json`, `enabled`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'basic', 'crypto', 'Ideal for new comers and beginners', 'trending_up', NULL, 'mid', 200.00, 599.00, 5.00, 5.00, 6, 6, 0.00, 1, 3, 6, 6, '[\"Advanced AI Strategy\",\"Bi-Weekly Withdrawals\",\"10 Active Trading Bots\",\"Priority AI Sentiment Core\",\"24/7 Live Chat Support\",\"Advanced Analytics Pro\"]', 1, 0, '2026-02-15 01:07:56', '2026-02-21 11:40:27'),
(2, 'Standard', 'standard', 'crypto', 'For intermediary and risk takers', 'rocket_launch', NULL, 'mid', 600.00, 4999.00, 6.50, 6.50, 7, 7, 0.00, NULL, NULL, 7, 7, '[\"Advanced AI Strategy\",\"Bi-Weekly Withdrawals\",\"15 Active Trading Bots\",\"Priority AI Sentiment Core\",\"24/7 Live Chat Support\",\"Advanced Analytics Pro\"]', 1, 0, '2026-02-15 01:07:56', '2026-02-21 11:40:18'),
(3, 'Premium', 'premium', 'crypto', 'Best for Seasoned traders with high stakes', 'diamond', NULL, 'mid', 5000.00, 11999.00, 9.00, 9.00, 10, 10, 0.00, NULL, NULL, 10, 10, '[\"Advanced AI Strategy\",\"Bi-Weekly Withdrawals\",\"20 Active Trading Bots\",\"Priority AI Sentiment Core\",\"24/7 Live Chat Support\",\"Advanced Analytics Pro\"]', 1, 0, '2026-02-15 01:07:56', '2026-02-21 11:41:35'),
(33, 'Supreme', 'supreme', 'crypto', 'Best for Seasoned traders with high stakes', 'token', NULL, 'mid', 12000.00, 49999.00, 12.00, 12.00, 30, 30, 0.00, NULL, NULL, 30, 30, '[\"Advanced AI Strategy\",\"Bi-Weekly Withdrawals\",\"Unlimited Active Trading Bots\",\"Priority AI Sentiment Core\",\"24/7 Live Chat Support\",\"Advanced Analytics Pro\"]', 1, 0, '2026-02-20 03:01:29', '2026-06-26 23:16:05'),
(35, 'Ultra', 'ultra', 'crypto', 'For premium investors', 'diamond', NULL, 'mid', 50000.00, 200000.00, 13.00, 13.00, 30, 30, 0.00, NULL, NULL, 30, 30, '[\"Advanced AI Strategy\",\"Bi-Weekly Withdrawals\",\"unlimited Active Trading Bots\",\"Priority AI Sentiment Core\",\"24/7 Live Chat Support\",\"Advanced Analytics Pro\"]', 1, 0, '2026-02-21 11:45:54', '2026-06-16 21:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `referral_earnings`
--

CREATE TABLE `referral_earnings` (
  `id` int(10) UNSIGNED NOT NULL,
  `referrer_user_id` int(10) UNSIGNED NOT NULL,
  `referred_user_id` int(10) UNSIGNED NOT NULL,
  `source` enum('plan_subscription','first_deposit','referred_payout','first_deposit_l2','referred_payout_l2') NOT NULL,
  `amount_usd` decimal(18,2) NOT NULL,
  `currency` varchar(20) NOT NULL DEFAULT 'USDT',
  `percent_used` decimal(5,2) NOT NULL,
  `reference_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'e.g. user_investments.id or transactions.id',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referral_earnings`
--

INSERT INTO `referral_earnings` (`id`, `referrer_user_id`, `referred_user_id`, `source`, `amount_usd`, `currency`, `percent_used`, `reference_id`, `created_at`) VALUES
(1, 49, 55, 'plan_subscription', 25.00, 'USDT', 5.00, 14, '2026-03-02 21:57:15'),
(2, 49, 55, 'referred_payout', 1.25, 'USDT', 5.00, 14, '2026-03-02 21:57:54'),
(3, 49, 55, 'first_deposit', 50.00, 'USDT', 5.00, 153, '2026-03-03 11:25:27'),
(4, 50, 52, 'plan_subscription', 150.00, 'USDT', 5.00, 16, '2026-03-05 00:14:32'),
(5, 49, 55, 'referred_payout', 1.25, 'USDT', 5.00, 14, '2026-03-05 09:00:04'),
(6, 49, 55, 'referred_payout', 1.25, 'USDT', 5.00, 14, '2026-03-06 09:00:04'),
(7, 50, 52, 'referred_payout', 9.75, 'USDT', 5.00, 16, '2026-03-06 09:00:05'),
(8, 49, 55, 'referred_payout', 1.25, 'USDT', 5.00, 14, '2026-03-07 09:00:04'),
(9, 50, 52, 'referred_payout', 9.75, 'USDT', 5.00, 16, '2026-03-07 09:00:04'),
(10, 50, 52, 'referred_payout', 9.75, 'USDT', 5.00, 16, '2026-03-08 09:00:04'),
(11, 50, 52, 'referred_payout', 9.75, 'USDT', 5.00, 16, '2026-03-09 09:00:09'),
(12, 50, 52, 'referred_payout', 9.75, 'USDT', 5.00, 16, '2026-03-10 09:00:04'),
(13, 50, 52, 'referred_payout', 9.75, 'USDT', 5.00, 16, '2026-03-11 09:00:03'),
(14, 50, 52, 'first_deposit', 100.00, 'USDT', 5.00, 528, '2026-06-09 13:44:39'),
(15, 52, 61, 'first_deposit', 10.00, 'USDT', 5.00, 536, '2026-06-10 15:47:53'),
(16, 52, 61, 'plan_subscription', 10.00, 'USDT', 5.00, 23, '2026-06-10 16:40:02'),
(17, 52, 61, 'referred_payout', 0.50, 'USDT', 5.00, 23, '2026-06-11 09:00:04'),
(18, 50, 52, 'referred_payout', 28.76, 'USDT', 5.00, 24, '2026-06-11 09:00:04'),
(19, 52, 61, 'referred_payout', 0.50, 'USDT', 5.00, 23, '2026-06-12 09:00:04'),
(20, 50, 52, 'referred_payout', 28.76, 'USDT', 5.00, 24, '2026-06-12 09:00:04'),
(21, 52, 61, 'referred_payout', 0.50, 'USDT', 5.00, 23, '2026-06-13 09:00:04'),
(22, 50, 52, 'referred_payout', 28.76, 'USDT', 5.00, 24, '2026-06-13 09:00:04'),
(23, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 23, '2026-06-14 09:00:04'),
(24, 50, 52, 'referred_payout', 86.27, 'USDT', 15.00, 24, '2026-06-14 09:00:04'),
(25, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 23, '2026-06-15 09:00:04'),
(26, 50, 52, 'referred_payout', 86.27, 'USDT', 15.00, 24, '2026-06-15 09:00:05'),
(27, 50, 52, 'referred_payout', 86.27, 'USDT', 15.00, 24, '2026-06-16 09:00:04'),
(28, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 25, '2026-06-16 09:00:04'),
(29, 50, 52, 'first_deposit', 8041.50, 'USDT', 15.00, 574, '2026-06-16 21:49:39'),
(30, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 25, '2026-06-17 09:00:09'),
(31, 50, 61, 'referred_payout_l2', 1.00, 'USDT', 10.00, 25, '2026-06-17 09:00:09'),
(32, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 25, '2026-06-18 09:00:03'),
(33, 50, 61, 'referred_payout_l2', 1.00, 'USDT', 10.00, 25, '2026-06-18 09:00:03'),
(34, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-18 09:00:06'),
(35, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 25, '2026-06-19 09:00:04'),
(36, 50, 61, 'referred_payout_l2', 1.00, 'USDT', 10.00, 25, '2026-06-19 09:00:04'),
(37, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-19 09:00:05'),
(38, 52, 61, 'referred_payout', 1.50, 'USDT', 15.00, 25, '2026-06-20 09:00:04'),
(39, 50, 61, 'referred_payout_l2', 1.00, 'USDT', 10.00, 25, '2026-06-20 09:00:04'),
(40, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-20 09:00:06'),
(41, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-21 09:00:04'),
(42, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-22 09:00:04'),
(43, 52, 61, 'referred_payout', 1.58, 'USDT', 15.00, 28, '2026-06-22 09:00:05'),
(44, 50, 61, 'referred_payout_l2', 1.05, 'USDT', 10.00, 28, '2026-06-22 09:00:05'),
(45, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-23 09:00:05'),
(46, 52, 61, 'referred_payout', 1.58, 'USDT', 15.00, 28, '2026-06-23 09:00:06'),
(47, 50, 61, 'referred_payout_l2', 1.05, 'USDT', 10.00, 28, '2026-06-23 09:00:06'),
(48, 61, 71, 'first_deposit', 30.00, 'USDT', 15.00, 666, '2026-06-24 03:13:24'),
(49, 52, 71, 'first_deposit_l2', 20.00, 'USDT', 10.00, 666, '2026-06-24 03:13:24'),
(50, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-24 09:00:04'),
(51, 52, 61, 'referred_payout', 1.58, 'USDT', 15.00, 28, '2026-06-24 09:00:04'),
(52, 50, 61, 'referred_payout_l2', 1.05, 'USDT', 10.00, 28, '2026-06-24 09:00:04'),
(53, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-25 09:00:04'),
(54, 52, 61, 'referred_payout', 1.58, 'USDT', 15.00, 28, '2026-06-25 09:00:04'),
(55, 50, 61, 'referred_payout_l2', 1.05, 'USDT', 10.00, 28, '2026-06-25 09:00:04'),
(56, 50, 52, 'referred_payout', 1170.00, 'USDT', 15.00, 27, '2026-06-26 09:00:04'),
(57, 52, 61, 'referred_payout', 1.58, 'USDT', 15.00, 28, '2026-06-26 09:00:05'),
(58, 50, 61, 'referred_payout_l2', 1.05, 'USDT', 10.00, 28, '2026-06-26 09:00:05'),
(59, 61, 71, 'referred_payout', 1.50, 'USDT', 15.00, 29, '2026-06-26 09:00:07'),
(60, 52, 71, 'referred_payout_l2', 1.00, 'USDT', 10.00, 29, '2026-06-26 09:00:07'),
(61, 52, 61, 'referred_payout', 9.75, 'USDT', 15.00, 30, '2026-06-26 09:00:08'),
(62, 50, 61, 'referred_payout_l2', 6.50, 'USDT', 10.00, 30, '2026-06-26 09:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`key`, `value`, `updated_at`) VALUES
('about_youtube_url', 'https://youtu.be/z1tXFH36_kM', '2026-02-21 17:01:36'),
('active_traders', '12.8M+', '2026-02-15 01:07:56'),
('btc_dominance', '52.4%', '2026-02-15 01:07:56'),
('compounding_enabled', '0', '2026-02-15 21:51:02'),
('contact_email', 'legal@bloombit.com', '2026-02-15 01:07:56'),
('deposit_bonus_percentage', '10', '2026-03-03 11:20:15'),
('deposit_countdown_minutes', '5', '2026-02-19 23:43:21'),
('distribution_interval', 'daily', '2026-03-03 19:07:55'),
('distribution_start_time', '09:00:00', '2026-02-17 21:53:51'),
('earnings_paused', '0', '2026-02-17 21:53:51'),
('footer_description', 'Leading the future of decentralized finance with advanced artificial intelligence and machine learning technologies.', '2026-02-15 01:07:56'),
('header_image', '/uploads/site/header_image_1771519971.jpg', '2026-02-19 16:52:51'),
('hero_badge', 'AI ENGINE V4.0 NOW LIVE', '2026-02-15 01:07:56'),
('hero_subtitle', 'Automate your wealth with institutional-grade machine learning algorithms. Deploy sophisticated bots that trade 24/7 while you sleep.', '2026-02-15 01:33:55'),
('hero_title', 'Smarter Crypto Investing Powered by Advanced AI', '2026-02-15 01:33:55'),
('homepage_modal_image', '/uploads/site/modal_image_1771676441.jpg', '2026-02-21 12:20:41'),
('homepage_youtube_url', 'https://youtu.be/-Z3Oa5UpcDw', '2026-02-21 17:01:36'),
('investors_count', '45000', '2026-02-15 01:07:56'),
('mail_from_email', 'support@bloombitfx.com', '2026-02-18 17:35:18'),
('mail_from_name', 'Bloombit', '2026-02-18 16:48:37'),
('mail_imap_encryption', 'ssl', '2026-02-18 16:48:37'),
('mail_imap_host', 'imap.hostinger.com', '2026-02-18 17:35:18'),
('mail_imap_password', 'Secretpass0721//', '2026-02-18 17:35:18'),
('mail_imap_port', '993', '2026-02-18 16:48:37'),
('mail_imap_sent_folder', 'Sent', '2026-02-18 16:48:37'),
('mail_imap_username', 'support@bloombitfx.com', '2026-02-18 17:35:18'),
('mail_reply_to', 'support@bloombitfx.com', '2026-02-18 17:35:18'),
('mail_smtp_encryption', 'ssl', '2026-02-18 17:35:18'),
('mail_smtp_host', 'smtp.hostinger.com', '2026-02-18 17:35:18'),
('mail_smtp_password', 'Secretpass0721//', '2026-02-18 17:35:18'),
('mail_smtp_port', '465', '2026-02-18 17:35:18'),
('mail_smtp_username', 'support@bloombitfx.com', '2026-02-18 17:35:18'),
('market_cap', '$2.45T', '2026-02-15 01:07:56'),
('max_active_plans_per_user', '3', '2026-02-15 21:51:02'),
('max_withdrawal_limit', '50000', '2026-02-17 21:53:51'),
('min_withdrawal_limit', '10', '2026-02-15 21:51:02'),
('office_address', '40 Bank Street, Canary Wharf<br/>London, E14 5NR<br/>United Kingdom', '2026-02-19 16:52:54'),
('office_title', 'London Office', '2026-02-19 16:52:54'),
('referral_enabled', '1', '2026-02-24 22:46:40'),
('referral_level2_percentage', '10', '2026-06-16 23:31:27'),
('referral_percentage', '15', '2026-06-13 17:23:07'),
('site_favicon', '/uploads/site/favicon_1771518481.png', '2026-02-19 16:28:01'),
('site_name', 'Bloombit FX', '2026-02-20 09:29:08'),
('smartsupp_key', '4b4c6c405a57a64771ab73106400aad1faa7f909', '2026-02-21 13:48:30'),
('stats_assets', '$4.2B+', '2026-02-15 01:07:56'),
('stats_bots', '85k+', '2026-02-15 01:07:56'),
('stats_roi', '12.4%', '2026-02-15 01:07:56'),
('stats_uptime', '99.9%', '2026-02-15 01:07:56'),
('support_email', 'support@bloombit.com', '2026-02-15 01:33:55'),
('tagline', 'AI Crypto Trading', '2026-02-15 01:07:56'),
('volume_24h', '$84.2B', '2026-02-15 01:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('deposit','withdrawal','payout','investment','referral_bonus','deposit_bonus','profit_adjustment','referral_bonus_adjustment') NOT NULL,
  `amount` decimal(36,18) NOT NULL,
  `amount_usd` decimal(18,2) DEFAULT NULL,
  `currency` varchar(20) NOT NULL DEFAULT 'USD',
  `payment_method_id` int(10) UNSIGNED DEFAULT NULL,
  `payout_details` text DEFAULT NULL,
  `status` enum('pending','completed','rejected','failed','cancelled') NOT NULL DEFAULT 'pending',
  `reference` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  `user_confirmed_at` datetime DEFAULT NULL,
  `proof_url` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `amount_usd`, `currency`, `payment_method_id`, `payout_details`, `status`, `reference`, `created_at`, `expires_at`, `user_confirmed_at`, `proof_url`) VALUES
(4, 9, 'deposit', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-15 14:50:08', NULL, NULL, NULL),
(5, 9, 'withdrawal', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'pending', NULL, '2026-02-15 14:50:08', NULL, NULL, NULL),
(7, 9, 'deposit', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-15 18:17:55', NULL, NULL, NULL),
(8, 9, 'withdrawal', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'pending', NULL, '2026-02-15 18:17:55', NULL, NULL, NULL),
(10, 9, 'deposit', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-15 20:59:03', NULL, NULL, NULL),
(11, 9, 'withdrawal', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'pending', NULL, '2026-02-15 20:59:03', NULL, NULL, NULL),
(13, 9, 'deposit', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-15 21:51:03', NULL, NULL, NULL),
(14, 9, 'withdrawal', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'pending', NULL, '2026-02-15 21:51:03', NULL, NULL, NULL),
(16, 9, 'deposit', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-15 23:56:22', NULL, NULL, NULL),
(17, 9, 'withdrawal', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'pending', NULL, '2026-02-15 23:56:22', NULL, NULL, NULL),
(19, 9, 'deposit', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-16 00:42:41', NULL, NULL, NULL),
(20, 9, 'withdrawal', 500.000000000000000000, NULL, 'USD', NULL, NULL, 'pending', NULL, '2026-02-16 00:42:41', NULL, NULL, NULL),
(22, 9, 'deposit', 500.000000000000000000, NULL, 'ETH', NULL, NULL, 'rejected', NULL, '2026-02-16 11:40:11', NULL, NULL, NULL),
(23, 9, 'deposit', 2000.000000000000000000, NULL, 'USDT', NULL, NULL, 'rejected', NULL, '2026-02-17 00:32:33', NULL, NULL, NULL),
(24, 9, 'investment', 0.010000000000000000, NULL, 'BTC', NULL, NULL, 'completed', NULL, '2026-02-17 01:00:09', NULL, NULL, NULL),
(26, 9, 'deposit', 25000.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', NULL, '2026-02-17 01:27:55', NULL, NULL, NULL),
(29, 9, 'payout', 384.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'earnings_inv_5', '2026-02-17 21:59:03', NULL, NULL, NULL),
(30, 9, 'payout', 2.995000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'earnings_inv_7', '2026-02-17 21:59:03', NULL, NULL, NULL),
(33, 9, 'deposit', 599.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-18 00:32:12', NULL, NULL, NULL),
(34, 9, 'deposit', 1200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-18 00:32:14', NULL, NULL, NULL),
(35, 9, 'withdrawal', 1.239500000000000046, NULL, 'BTC', NULL, NULL, 'completed', 'admin_debit_1_9_20260218_003310', '2026-02-18 00:33:10', NULL, NULL, NULL),
(36, 9, 'withdrawal', 25000.000000000000000000, NULL, 'USD', NULL, NULL, 'completed', 'admin_debit_1_9_20260218_003326', '2026-02-18 00:33:26', NULL, NULL, NULL),
(37, 9, 'withdrawal', 2185.994999999999890861, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_9_20260218_003346', '2026-02-18 00:33:46', NULL, NULL, NULL),
(38, 9, 'withdrawal', 4.820999999999999730, NULL, 'ETH', NULL, NULL, 'completed', 'admin_debit_1_9_20260218_003405', '2026-02-18 00:34:05', NULL, NULL, NULL),
(57, 49, 'deposit', 0.007470156723888067, 500.00, 'BTC', NULL, NULL, 'pending', NULL, '2026-02-19 23:39:29', NULL, NULL, NULL),
(58, 49, 'deposit', 0.089659294680215176, 6000.00, 'BTC', NULL, NULL, 'completed', NULL, '2026-02-19 23:43:59', '2026-02-19 23:48:59', '2026-02-19 23:45:17', NULL),
(59, 49, 'deposit', 0.134442734863988778, 9000.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-02-19 23:46:26', '2026-02-19 23:51:26', NULL, NULL),
(60, 50, 'deposit', 11000.000000000000000000, 11000.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-20 08:33:37', '2026-02-20 08:38:37', '2026-02-20 08:34:02', NULL),
(61, 50, 'investment', 11000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-20 10:25:45', NULL, NULL, NULL),
(62, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11', '2026-02-20 11:05:03', NULL, NULL, NULL),
(63, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_63', '2026-02-20 11:10:03', NULL, NULL, NULL),
(64, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_64', '2026-02-20 11:15:03', NULL, NULL, NULL),
(65, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_65', '2026-02-20 11:20:04', NULL, NULL, NULL),
(66, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_66', '2026-02-20 11:30:03', NULL, NULL, NULL),
(67, 9, 'deposit', 0.008792110546136600, 600.00, 'BTC', NULL, NULL, 'completed', NULL, '2026-02-21 17:08:53', '2026-02-21 17:13:53', '2026-02-21 17:09:03', NULL),
(68, 50, 'deposit', 1000.000000000000000000, 1000.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-22 08:41:29', '2026-02-22 08:46:29', '2026-02-22 08:41:52', NULL),
(69, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_69', '2026-02-22 09:00:04', NULL, NULL, NULL),
(70, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_70', '2026-02-23 09:00:03', NULL, NULL, NULL),
(71, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_71', '2026-02-24 09:00:03', NULL, NULL, NULL),
(72, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_72', '2026-02-25 09:00:04', NULL, NULL, NULL),
(73, 52, 'deposit', 2000.000000000000000000, 2000.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-25 13:21:45', '2026-02-25 13:26:45', '2026-02-25 13:21:54', NULL),
(74, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_74', '2026-02-26 09:00:03', NULL, NULL, NULL),
(75, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_75', '2026-02-27 09:00:03', NULL, NULL, NULL),
(76, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_76', '2026-02-28 09:00:05', NULL, NULL, NULL),
(77, 53, 'deposit', 2085.000000000000000000, 2085.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-28 13:25:49', '2026-02-28 13:30:49', '2026-02-28 13:26:00', NULL),
(78, 53, 'investment', 2085.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-02-28 13:29:29', NULL, NULL, NULL),
(79, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_79', '2026-03-01 09:00:03', NULL, NULL, NULL),
(80, 53, 'payout', 135.525000000000005684, 135.53, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12', '2026-03-01 09:00:04', NULL, NULL, NULL),
(81, 54, 'deposit', 710.929999999999949978, 710.93, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-01 09:03:07', '2026-03-01 09:08:07', '2026-03-01 09:03:13', NULL),
(82, 54, 'investment', 710.930000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-01 09:06:22', NULL, NULL, NULL),
(83, 53, 'payout', 135.525000000000005684, 135.53, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_83', '2026-03-02 09:00:04', NULL, NULL, NULL),
(84, 54, 'payout', 46.210450000000001580, 46.21, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13', '2026-03-02 09:00:04', NULL, NULL, NULL),
(85, 55, 'deposit', 0.008624040773428165, 599.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-03-02 21:47:23', '2026-03-02 21:52:23', NULL, NULL),
(86, 55, 'deposit', 0.007200460829493088, 500.00, 'BTC', NULL, NULL, 'completed', 'getette', '2026-03-02 21:55:25', '2026-03-02 22:00:25', '2026-03-02 21:55:37', NULL),
(87, 55, 'investment', 0.007196315486470900, NULL, 'BTC', NULL, NULL, 'completed', NULL, '2026-03-02 21:57:15', NULL, NULL, NULL),
(88, 49, 'referral_bonus', 25.000000000000000000, 25.00, 'USDT', NULL, NULL, 'completed', 'ref_inv_14', '2026-03-02 21:57:15', NULL, NULL, NULL),
(89, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_11_dup_89', '2026-03-02 21:57:52', NULL, NULL, NULL),
(90, 53, 'payout', 135.525000000000005684, 135.53, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_90', '2026-03-02 21:57:53', NULL, NULL, NULL),
(91, 54, 'payout', 46.210450000000001580, 46.21, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_91', '2026-03-02 21:57:53', NULL, NULL, NULL),
(92, 55, 'payout', 25.000000000000000000, 25.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14', '2026-03-02 21:57:54', NULL, NULL, NULL),
(93, 49, 'referral_bonus', 1.250000000000000000, 1.25, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_14', '2026-03-02 21:57:54', NULL, NULL, NULL),
(94, 50, 'investment', 11000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-03 08:02:08', NULL, NULL, NULL),
(95, 50, 'deposit', 12000.000000000000000000, 12000.00, 'USDT', NULL, NULL, 'pending', 'ggggvbbbbbbbb', '2026-03-03 08:10:17', '2026-03-03 08:15:17', '2026-03-03 08:11:16', '/uploads/deposit-proofs/tx_95_1772525476.jpg'),
(96, 50, 'withdrawal', 3860.000000000000000000, 3860.00, 'USDT', NULL, NULL, 'completed', 'ggvccgggghhhbbbbb', '2026-03-03 08:18:18', NULL, NULL, NULL),
(97, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_97', '2026-03-03 10:00:03', NULL, NULL, NULL),
(98, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_98', '2026-03-03 10:00:04', NULL, NULL, NULL),
(99, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_99', '2026-03-03 10:00:04', NULL, NULL, NULL),
(100, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15', '2026-03-03 10:00:05', NULL, NULL, NULL),
(101, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_101', '2026-03-03 10:05:03', NULL, NULL, NULL),
(102, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_102', '2026-03-03 10:05:04', NULL, NULL, NULL),
(103, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_103', '2026-03-03 10:05:04', NULL, NULL, NULL),
(104, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_104', '2026-03-03 10:05:05', NULL, NULL, NULL),
(105, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_105', '2026-03-03 10:10:03', NULL, NULL, NULL),
(106, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_106', '2026-03-03 10:10:04', NULL, NULL, NULL),
(107, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_107', '2026-03-03 10:10:04', NULL, NULL, NULL),
(108, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_108', '2026-03-03 10:10:05', NULL, NULL, NULL),
(109, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_109', '2026-03-03 10:15:03', NULL, NULL, NULL),
(110, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_110', '2026-03-03 10:15:04', NULL, NULL, NULL),
(111, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_111', '2026-03-03 10:15:04', NULL, NULL, NULL),
(112, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_112', '2026-03-03 10:15:04', NULL, NULL, NULL),
(113, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_113', '2026-03-03 10:20:03', NULL, NULL, NULL),
(114, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_114', '2026-03-03 10:20:03', NULL, NULL, NULL),
(115, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_115', '2026-03-03 10:20:04', NULL, NULL, NULL),
(116, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_116', '2026-03-03 10:20:04', NULL, NULL, NULL),
(117, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_117', '2026-03-03 10:25:03', NULL, NULL, NULL),
(118, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_118', '2026-03-03 10:25:04', NULL, NULL, NULL),
(119, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_119', '2026-03-03 10:25:04', NULL, NULL, NULL),
(120, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_120', '2026-03-03 10:25:04', NULL, NULL, NULL),
(121, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_121', '2026-03-03 10:30:04', NULL, NULL, NULL),
(122, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_122', '2026-03-03 10:30:05', NULL, NULL, NULL),
(123, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_123', '2026-03-03 10:30:05', NULL, NULL, NULL),
(124, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_124', '2026-03-03 10:30:06', NULL, NULL, NULL),
(125, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_125', '2026-03-03 10:40:03', NULL, NULL, NULL),
(126, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_126', '2026-03-03 10:40:04', NULL, NULL, NULL),
(127, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_127', '2026-03-03 10:40:04', NULL, NULL, NULL),
(128, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_128', '2026-03-03 10:40:04', NULL, NULL, NULL),
(129, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_129', '2026-03-03 10:45:03', NULL, NULL, NULL),
(130, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_130', '2026-03-03 10:45:03', NULL, NULL, NULL),
(131, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_131', '2026-03-03 10:45:03', NULL, NULL, NULL),
(132, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_132', '2026-03-03 10:45:04', NULL, NULL, NULL),
(133, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_133', '2026-03-03 10:50:03', NULL, NULL, NULL),
(134, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_134', '2026-03-03 10:50:03', NULL, NULL, NULL),
(135, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_135', '2026-03-03 10:50:04', NULL, NULL, NULL),
(136, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_136', '2026-03-03 10:50:04', NULL, NULL, NULL),
(137, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_137', '2026-03-03 11:00:04', NULL, NULL, NULL),
(138, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_138', '2026-03-03 11:00:04', NULL, NULL, NULL),
(139, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_139', '2026-03-03 11:00:05', NULL, NULL, NULL),
(140, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_140', '2026-03-03 11:00:05', NULL, NULL, NULL),
(141, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_141', '2026-03-03 11:10:03', NULL, NULL, NULL),
(142, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_142', '2026-03-03 11:10:03', NULL, NULL, NULL),
(143, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_143', '2026-03-03 11:10:04', NULL, NULL, NULL),
(144, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_144', '2026-03-03 11:10:05', NULL, NULL, NULL),
(145, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_145', '2026-03-03 11:15:04', NULL, NULL, NULL),
(146, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_146', '2026-03-03 11:15:04', NULL, NULL, NULL),
(147, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_147', '2026-03-03 11:15:05', NULL, NULL, NULL),
(148, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_148', '2026-03-03 11:15:05', NULL, NULL, NULL),
(149, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_149', '2026-03-03 11:20:04', NULL, NULL, NULL),
(150, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_150', '2026-03-03 11:20:04', NULL, NULL, NULL),
(151, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_151', '2026-03-03 11:20:05', NULL, NULL, NULL),
(152, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_152', '2026-03-03 11:20:05', NULL, NULL, NULL),
(153, 55, 'deposit', 1000.000000000000000000, 1000.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-03 11:24:50', '2026-03-03 11:29:50', '2026-03-03 11:25:02', NULL),
(154, 49, 'referral_bonus', 50.000000000000000000, 50.00, 'USDT', NULL, NULL, 'completed', 'ref_deposit_153', '2026-03-03 11:25:27', NULL, NULL, NULL),
(155, 55, 'deposit_bonus', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_153', '2026-03-03 11:25:27', NULL, NULL, NULL),
(156, 49, 'deposit', 11.896264572924101444, 1000.00, 'SOL', NULL, NULL, 'completed', NULL, '2026-03-03 11:26:35', '2026-03-03 11:31:35', '2026-03-03 11:26:39', NULL),
(157, 49, 'deposit_bonus', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_156', '2026-03-03 11:26:59', NULL, NULL, NULL),
(158, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_158', '2026-03-03 11:30:03', NULL, NULL, NULL),
(159, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_159', '2026-03-03 11:30:04', NULL, NULL, NULL),
(160, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_160', '2026-03-03 11:30:05', NULL, NULL, NULL),
(161, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_161', '2026-03-03 11:30:05', NULL, NULL, NULL),
(162, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_162', '2026-03-03 11:35:03', NULL, NULL, NULL),
(163, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_163', '2026-03-03 11:35:03', NULL, NULL, NULL),
(164, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_164', '2026-03-03 11:35:03', NULL, NULL, NULL),
(165, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_165', '2026-03-03 11:35:04', NULL, NULL, NULL),
(166, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_166', '2026-03-03 11:40:03', NULL, NULL, NULL),
(167, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_167', '2026-03-03 11:40:03', NULL, NULL, NULL),
(168, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_168', '2026-03-03 11:40:04', NULL, NULL, NULL),
(169, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_169', '2026-03-03 11:40:04', NULL, NULL, NULL),
(170, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_170', '2026-03-03 11:50:03', NULL, NULL, NULL),
(171, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_171', '2026-03-03 11:50:04', NULL, NULL, NULL),
(172, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_172', '2026-03-03 11:50:04', NULL, NULL, NULL),
(173, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_173', '2026-03-03 11:50:05', NULL, NULL, NULL),
(174, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_174', '2026-03-03 11:55:03', NULL, NULL, NULL),
(175, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_175', '2026-03-03 11:55:04', NULL, NULL, NULL),
(176, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_176', '2026-03-03 11:55:04', NULL, NULL, NULL),
(177, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_177', '2026-03-03 11:55:04', NULL, NULL, NULL),
(178, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_178', '2026-03-03 12:00:04', NULL, NULL, NULL),
(179, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_179', '2026-03-03 12:00:04', NULL, NULL, NULL),
(180, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_180', '2026-03-03 12:00:04', NULL, NULL, NULL),
(181, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_181', '2026-03-03 12:00:05', NULL, NULL, NULL),
(182, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_182', '2026-03-03 12:10:03', NULL, NULL, NULL),
(183, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_183', '2026-03-03 12:10:04', NULL, NULL, NULL),
(184, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_184', '2026-03-03 12:10:04', NULL, NULL, NULL),
(185, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_185', '2026-03-03 12:10:04', NULL, NULL, NULL),
(186, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_186', '2026-03-03 12:15:03', NULL, NULL, NULL),
(187, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_187', '2026-03-03 12:15:03', NULL, NULL, NULL),
(188, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_188', '2026-03-03 12:15:04', NULL, NULL, NULL),
(189, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_189', '2026-03-03 12:15:04', NULL, NULL, NULL),
(190, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_190', '2026-03-03 12:20:03', NULL, NULL, NULL),
(191, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_191', '2026-03-03 12:20:04', NULL, NULL, NULL),
(192, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_192', '2026-03-03 12:20:04', NULL, NULL, NULL),
(193, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_193', '2026-03-03 12:20:04', NULL, NULL, NULL),
(194, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_194', '2026-03-03 12:25:03', NULL, NULL, NULL),
(195, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_195', '2026-03-03 12:25:03', NULL, NULL, NULL),
(196, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_196', '2026-03-03 12:25:04', NULL, NULL, NULL),
(197, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_197', '2026-03-03 12:25:04', NULL, NULL, NULL),
(198, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_198', '2026-03-03 12:30:10', NULL, NULL, NULL),
(199, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_199', '2026-03-03 12:30:10', NULL, NULL, NULL),
(200, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_200', '2026-03-03 12:30:11', NULL, NULL, NULL),
(201, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_201', '2026-03-03 12:30:11', NULL, NULL, NULL),
(202, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_202', '2026-03-03 12:40:03', NULL, NULL, NULL),
(203, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_203', '2026-03-03 12:40:03', NULL, NULL, NULL),
(204, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_204', '2026-03-03 12:40:04', NULL, NULL, NULL),
(205, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_205', '2026-03-03 12:40:04', NULL, NULL, NULL),
(206, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_206', '2026-03-03 12:45:04', NULL, NULL, NULL),
(207, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_207', '2026-03-03 12:45:04', NULL, NULL, NULL),
(208, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_208', '2026-03-03 12:45:05', NULL, NULL, NULL),
(209, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_209', '2026-03-03 12:45:05', NULL, NULL, NULL),
(210, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_210', '2026-03-03 12:55:02', NULL, NULL, NULL),
(211, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_211', '2026-03-03 12:55:03', NULL, NULL, NULL),
(212, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_212', '2026-03-03 12:55:03', NULL, NULL, NULL),
(213, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_213', '2026-03-03 12:55:03', NULL, NULL, NULL),
(214, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_214', '2026-03-03 13:00:04', NULL, NULL, NULL),
(215, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_215', '2026-03-03 13:00:23', NULL, NULL, NULL),
(216, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_216', '2026-03-03 13:00:23', NULL, NULL, NULL),
(217, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_217', '2026-03-03 13:00:23', NULL, NULL, NULL),
(218, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_218', '2026-03-03 13:10:03', NULL, NULL, NULL),
(219, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_219', '2026-03-03 13:10:04', NULL, NULL, NULL),
(220, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_220', '2026-03-03 13:10:04', NULL, NULL, NULL),
(221, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_221', '2026-03-03 13:10:05', NULL, NULL, NULL),
(222, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_222', '2026-03-03 13:15:03', NULL, NULL, NULL),
(223, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_223', '2026-03-03 13:15:03', NULL, NULL, NULL),
(224, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_224', '2026-03-03 13:15:04', NULL, NULL, NULL),
(225, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_225', '2026-03-03 13:15:04', NULL, NULL, NULL),
(226, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_226', '2026-03-03 13:25:02', NULL, NULL, NULL),
(227, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_227', '2026-03-03 13:25:03', NULL, NULL, NULL),
(228, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_228', '2026-03-03 13:25:03', NULL, NULL, NULL),
(229, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_229', '2026-03-03 13:25:03', NULL, NULL, NULL),
(230, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_230', '2026-03-03 13:30:04', NULL, NULL, NULL),
(231, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_231', '2026-03-03 13:30:04', NULL, NULL, NULL),
(232, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_232', '2026-03-03 13:30:04', NULL, NULL, NULL),
(233, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_233', '2026-03-03 13:30:04', NULL, NULL, NULL),
(234, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_234', '2026-03-03 13:40:03', NULL, NULL, NULL),
(235, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_235', '2026-03-03 13:40:03', NULL, NULL, NULL),
(236, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_236', '2026-03-03 13:40:04', NULL, NULL, NULL),
(237, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_237', '2026-03-03 13:40:04', NULL, NULL, NULL),
(238, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_238', '2026-03-03 13:45:03', NULL, NULL, NULL),
(239, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_239', '2026-03-03 13:45:03', NULL, NULL, NULL),
(240, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_240', '2026-03-03 13:45:03', NULL, NULL, NULL),
(241, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_241', '2026-03-03 13:45:03', NULL, NULL, NULL),
(242, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_242', '2026-03-03 13:50:04', NULL, NULL, NULL),
(243, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_243', '2026-03-03 13:50:06', NULL, NULL, NULL),
(244, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_244', '2026-03-03 13:50:06', NULL, NULL, NULL),
(245, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_245', '2026-03-03 13:50:06', NULL, NULL, NULL),
(246, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_246', '2026-03-03 14:00:08', NULL, NULL, NULL),
(247, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_247', '2026-03-03 14:00:08', NULL, NULL, NULL),
(248, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_248', '2026-03-03 14:00:09', NULL, NULL, NULL),
(249, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_249', '2026-03-03 14:00:09', NULL, NULL, NULL),
(250, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_250', '2026-03-03 14:10:04', NULL, NULL, NULL),
(251, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_251', '2026-03-03 14:10:04', NULL, NULL, NULL),
(252, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_252', '2026-03-03 14:10:04', NULL, NULL, NULL),
(253, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_253', '2026-03-03 14:10:04', NULL, NULL, NULL),
(254, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_254', '2026-03-03 14:20:05', NULL, NULL, NULL),
(255, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_255', '2026-03-03 14:20:06', NULL, NULL, NULL),
(256, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_256', '2026-03-03 14:20:06', NULL, NULL, NULL),
(257, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_257', '2026-03-03 14:20:07', NULL, NULL, NULL),
(258, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_258', '2026-03-03 14:30:03', NULL, NULL, NULL),
(259, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_259', '2026-03-03 14:30:03', NULL, NULL, NULL),
(260, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_260', '2026-03-03 14:30:04', NULL, NULL, NULL),
(261, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_261', '2026-03-03 14:30:04', NULL, NULL, NULL),
(262, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_262', '2026-03-03 14:35:04', NULL, NULL, NULL),
(263, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_263', '2026-03-03 14:35:05', NULL, NULL, NULL),
(264, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_264', '2026-03-03 14:35:05', NULL, NULL, NULL),
(265, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_265', '2026-03-03 14:35:06', NULL, NULL, NULL),
(266, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_266', '2026-03-03 14:45:03', NULL, NULL, NULL),
(267, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_267', '2026-03-03 14:45:03', NULL, NULL, NULL),
(268, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_268', '2026-03-03 14:45:03', NULL, NULL, NULL),
(269, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_269', '2026-03-03 14:45:04', NULL, NULL, NULL),
(270, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_270', '2026-03-03 14:50:03', NULL, NULL, NULL),
(271, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_271', '2026-03-03 14:50:04', NULL, NULL, NULL),
(272, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_272', '2026-03-03 14:50:04', NULL, NULL, NULL),
(273, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_273', '2026-03-03 14:50:04', NULL, NULL, NULL),
(274, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_274', '2026-03-03 14:55:03', NULL, NULL, NULL),
(275, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_275', '2026-03-03 14:55:04', NULL, NULL, NULL),
(276, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_276', '2026-03-03 14:55:04', NULL, NULL, NULL),
(277, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_277', '2026-03-03 14:55:04', NULL, NULL, NULL),
(278, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_278', '2026-03-03 15:00:04', NULL, NULL, NULL),
(279, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_279', '2026-03-03 15:00:04', NULL, NULL, NULL),
(280, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_280', '2026-03-03 15:00:04', NULL, NULL, NULL),
(281, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_281', '2026-03-03 15:00:05', NULL, NULL, NULL),
(282, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_282', '2026-03-03 15:10:03', NULL, NULL, NULL),
(283, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_283', '2026-03-03 15:10:04', NULL, NULL, NULL),
(284, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_284', '2026-03-03 15:10:04', NULL, NULL, NULL),
(285, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_285', '2026-03-03 15:10:04', NULL, NULL, NULL),
(286, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_286', '2026-03-03 15:15:03', NULL, NULL, NULL),
(287, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_287', '2026-03-03 15:15:03', NULL, NULL, NULL),
(288, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_288', '2026-03-03 15:15:03', NULL, NULL, NULL),
(289, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_289', '2026-03-03 15:15:04', NULL, NULL, NULL),
(290, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_290', '2026-03-03 15:20:03', NULL, NULL, NULL),
(291, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_291', '2026-03-03 15:20:03', NULL, NULL, NULL),
(292, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_292', '2026-03-03 15:20:03', NULL, NULL, NULL),
(293, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_293', '2026-03-03 15:20:04', NULL, NULL, NULL),
(294, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_294', '2026-03-03 15:25:03', NULL, NULL, NULL),
(295, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_295', '2026-03-03 15:25:03', NULL, NULL, NULL),
(296, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_296', '2026-03-03 15:25:03', NULL, NULL, NULL),
(297, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_297', '2026-03-03 15:25:04', NULL, NULL, NULL),
(298, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_298', '2026-03-03 15:30:05', NULL, NULL, NULL),
(299, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_299', '2026-03-03 15:30:05', NULL, NULL, NULL),
(300, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_300', '2026-03-03 15:30:05', NULL, NULL, NULL),
(301, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_301', '2026-03-03 15:30:06', NULL, NULL, NULL),
(302, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_302', '2026-03-03 15:40:03', NULL, NULL, NULL),
(303, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_303', '2026-03-03 15:40:03', NULL, NULL, NULL),
(304, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_304', '2026-03-03 15:40:04', NULL, NULL, NULL),
(305, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_305', '2026-03-03 15:40:04', NULL, NULL, NULL),
(306, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_306', '2026-03-03 15:45:03', NULL, NULL, NULL),
(307, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_307', '2026-03-03 15:45:03', NULL, NULL, NULL),
(308, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_308', '2026-03-03 15:45:04', NULL, NULL, NULL),
(309, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_309', '2026-03-03 15:45:04', NULL, NULL, NULL),
(310, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_310', '2026-03-03 15:55:03', NULL, NULL, NULL),
(311, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_311', '2026-03-03 15:55:03', NULL, NULL, NULL),
(312, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_312', '2026-03-03 15:55:04', NULL, NULL, NULL),
(313, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_313', '2026-03-03 15:55:04', NULL, NULL, NULL),
(314, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_314', '2026-03-03 16:00:03', NULL, NULL, NULL),
(315, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_315', '2026-03-03 16:00:04', NULL, NULL, NULL),
(316, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_316', '2026-03-03 16:00:04', NULL, NULL, NULL),
(317, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_317', '2026-03-03 16:00:04', NULL, NULL, NULL),
(318, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_318', '2026-03-03 16:10:03', NULL, NULL, NULL),
(319, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_319', '2026-03-03 16:10:04', NULL, NULL, NULL),
(320, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_320', '2026-03-03 16:10:04', NULL, NULL, NULL),
(321, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_321', '2026-03-03 16:10:04', NULL, NULL, NULL),
(322, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_322', '2026-03-03 16:15:03', NULL, NULL, NULL),
(323, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_323', '2026-03-03 16:15:03', NULL, NULL, NULL),
(324, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_324', '2026-03-03 16:15:04', NULL, NULL, NULL),
(325, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_325', '2026-03-03 16:15:04', NULL, NULL, NULL),
(326, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_326', '2026-03-03 16:20:03', NULL, NULL, NULL),
(327, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_327', '2026-03-03 16:20:03', NULL, NULL, NULL),
(328, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_328', '2026-03-03 16:20:04', NULL, NULL, NULL),
(329, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_329', '2026-03-03 16:20:04', NULL, NULL, NULL),
(330, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_330', '2026-03-03 16:25:03', NULL, NULL, NULL),
(331, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_331', '2026-03-03 16:25:04', NULL, NULL, NULL),
(332, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_332', '2026-03-03 16:25:04', NULL, NULL, NULL),
(333, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_333', '2026-03-03 16:25:04', NULL, NULL, NULL),
(334, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_334', '2026-03-03 16:30:04', NULL, NULL, NULL),
(335, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_335', '2026-03-03 16:30:05', NULL, NULL, NULL),
(336, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_336', '2026-03-03 16:30:06', NULL, NULL, NULL),
(337, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_337', '2026-03-03 16:30:06', NULL, NULL, NULL),
(338, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_338', '2026-03-03 16:40:03', NULL, NULL, NULL),
(339, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_339', '2026-03-03 16:40:03', NULL, NULL, NULL),
(340, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_340', '2026-03-03 16:40:03', NULL, NULL, NULL),
(341, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_341', '2026-03-03 16:40:03', NULL, NULL, NULL),
(342, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_342', '2026-03-03 16:45:03', NULL, NULL, NULL),
(343, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_343', '2026-03-03 16:45:04', NULL, NULL, NULL),
(344, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_344', '2026-03-03 16:45:04', NULL, NULL, NULL),
(345, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_345', '2026-03-03 16:45:04', NULL, NULL, NULL),
(346, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_346', '2026-03-03 16:50:04', NULL, NULL, NULL),
(347, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_347', '2026-03-03 16:50:05', NULL, NULL, NULL),
(348, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_348', '2026-03-03 16:50:05', NULL, NULL, NULL),
(349, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_349', '2026-03-03 16:50:05', NULL, NULL, NULL),
(350, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_350', '2026-03-03 16:55:05', NULL, NULL, NULL),
(351, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_351', '2026-03-03 16:55:05', NULL, NULL, NULL),
(352, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_352', '2026-03-03 16:55:06', NULL, NULL, NULL),
(353, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_353', '2026-03-03 16:55:06', NULL, NULL, NULL),
(354, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_354', '2026-03-03 17:05:03', NULL, NULL, NULL),
(355, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_355', '2026-03-03 17:05:03', NULL, NULL, NULL),
(356, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_356', '2026-03-03 17:05:03', NULL, NULL, NULL),
(357, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_357', '2026-03-03 17:05:04', NULL, NULL, NULL),
(358, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_358', '2026-03-03 17:10:03', NULL, NULL, NULL),
(359, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_359', '2026-03-03 17:10:04', NULL, NULL, NULL),
(360, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_360', '2026-03-03 17:10:04', NULL, NULL, NULL),
(361, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_361', '2026-03-03 17:10:05', NULL, NULL, NULL),
(362, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_362', '2026-03-03 17:20:03', NULL, NULL, NULL),
(363, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_363', '2026-03-03 17:20:03', NULL, NULL, NULL),
(364, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_364', '2026-03-03 17:20:04', NULL, NULL, NULL),
(365, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_365', '2026-03-03 17:20:04', NULL, NULL, NULL),
(366, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_366', '2026-03-03 17:30:02', NULL, NULL, NULL),
(367, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_367', '2026-03-03 17:30:03', NULL, NULL, NULL),
(368, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_368', '2026-03-03 17:30:03', NULL, NULL, NULL),
(369, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_369', '2026-03-03 17:30:03', NULL, NULL, NULL);
INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `amount_usd`, `currency`, `payment_method_id`, `payout_details`, `status`, `reference`, `created_at`, `expires_at`, `user_confirmed_at`, `proof_url`) VALUES
(370, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_370', '2026-03-03 17:35:03', NULL, NULL, NULL),
(371, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_371', '2026-03-03 17:35:03', NULL, NULL, NULL),
(372, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_372', '2026-03-03 17:35:03', NULL, NULL, NULL),
(373, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_373', '2026-03-03 17:35:04', NULL, NULL, NULL),
(374, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_374', '2026-03-03 17:40:03', NULL, NULL, NULL),
(375, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_375', '2026-03-03 17:40:04', NULL, NULL, NULL),
(376, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_376', '2026-03-03 17:40:04', NULL, NULL, NULL),
(377, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_377', '2026-03-03 17:40:04', NULL, NULL, NULL),
(378, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_378', '2026-03-03 17:45:03', NULL, NULL, NULL),
(379, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_379', '2026-03-03 17:45:11', NULL, NULL, NULL),
(380, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_380', '2026-03-03 17:45:11', NULL, NULL, NULL),
(381, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_381', '2026-03-03 17:45:11', NULL, NULL, NULL),
(382, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_382', '2026-03-03 17:50:03', NULL, NULL, NULL),
(383, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_383', '2026-03-03 17:50:03', NULL, NULL, NULL),
(384, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_384', '2026-03-03 17:50:04', NULL, NULL, NULL),
(385, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_385', '2026-03-03 17:50:04', NULL, NULL, NULL),
(386, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_386', '2026-03-03 17:55:03', NULL, NULL, NULL),
(387, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_387', '2026-03-03 17:55:03', NULL, NULL, NULL),
(388, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_388', '2026-03-03 17:55:04', NULL, NULL, NULL),
(389, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_389', '2026-03-03 17:55:14', NULL, NULL, NULL),
(390, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_390', '2026-03-03 18:00:04', NULL, NULL, NULL),
(391, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_391', '2026-03-03 18:00:05', NULL, NULL, NULL),
(392, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_392', '2026-03-03 18:00:05', NULL, NULL, NULL),
(393, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_393', '2026-03-03 18:00:06', NULL, NULL, NULL),
(394, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_394', '2026-03-03 18:05:06', NULL, NULL, NULL),
(395, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_395', '2026-03-03 18:05:06', NULL, NULL, NULL),
(396, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_396', '2026-03-03 18:05:06', NULL, NULL, NULL),
(397, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_397', '2026-03-03 18:05:07', NULL, NULL, NULL),
(398, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_398', '2026-03-03 18:15:03', NULL, NULL, NULL),
(399, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_399', '2026-03-03 18:15:04', NULL, NULL, NULL),
(400, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_400', '2026-03-03 18:15:04', NULL, NULL, NULL),
(401, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_401', '2026-03-03 18:15:04', NULL, NULL, NULL),
(402, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_402', '2026-03-03 18:20:05', NULL, NULL, NULL),
(403, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_403', '2026-03-03 18:20:05', NULL, NULL, NULL),
(404, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_404', '2026-03-03 18:20:06', NULL, NULL, NULL),
(405, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_405', '2026-03-03 18:20:06', NULL, NULL, NULL),
(406, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_406', '2026-03-03 18:30:03', NULL, NULL, NULL),
(407, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_407', '2026-03-03 18:30:03', NULL, NULL, NULL),
(408, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_408', '2026-03-03 18:30:03', NULL, NULL, NULL),
(409, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_409', '2026-03-03 18:30:04', NULL, NULL, NULL),
(410, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_410', '2026-03-03 18:40:02', NULL, NULL, NULL),
(411, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_411', '2026-03-03 18:40:03', NULL, NULL, NULL),
(412, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_412', '2026-03-03 18:40:03', NULL, NULL, NULL),
(413, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_413', '2026-03-03 18:40:03', NULL, NULL, NULL),
(414, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_414', '2026-03-03 18:45:03', NULL, NULL, NULL),
(415, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_415', '2026-03-03 18:45:04', NULL, NULL, NULL),
(416, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_416', '2026-03-03 18:45:04', NULL, NULL, NULL),
(417, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_417', '2026-03-03 18:45:04', NULL, NULL, NULL),
(418, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_418', '2026-03-03 18:50:04', NULL, NULL, NULL),
(419, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_419', '2026-03-03 18:50:04', NULL, NULL, NULL),
(420, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_420', '2026-03-03 18:50:04', NULL, NULL, NULL),
(421, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_421', '2026-03-03 18:50:04', NULL, NULL, NULL),
(422, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_422', '2026-03-03 19:00:03', NULL, NULL, NULL),
(423, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_423', '2026-03-03 19:00:04', NULL, NULL, NULL),
(424, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_424', '2026-03-03 19:00:04', NULL, NULL, NULL),
(425, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_425', '2026-03-03 19:00:04', NULL, NULL, NULL),
(426, 53, 'payout', 0.470572916666666674, 0.47, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_426', '2026-03-03 19:05:03', NULL, NULL, NULL),
(427, 54, 'payout', 0.160452951388888876, 0.16, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_427', '2026-03-03 19:05:03', NULL, NULL, NULL),
(428, 55, 'payout', 0.086805555555555552, 0.09, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_428', '2026-03-03 19:05:04', NULL, NULL, NULL),
(429, 50, 'payout', 3.437500000000000000, 3.44, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_429', '2026-03-03 19:05:04', NULL, NULL, NULL),
(430, 49, 'deposit', 0.008756285814524617, 599.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-03-03 19:11:13', '2026-03-03 19:16:13', NULL, NULL),
(431, 52, 'withdrawal', 1000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260305_001029', '2026-03-05 00:10:29', NULL, NULL, NULL),
(432, 52, 'deposit', 2000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260305_001318', '2026-03-05 00:13:18', NULL, NULL, NULL),
(433, 52, 'investment', 3000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-05 00:14:32', NULL, NULL, NULL),
(434, 50, 'referral_bonus', 150.000000000000000000, 150.00, 'USDT', NULL, NULL, 'completed', 'ref_inv_16', '2026-03-05 00:14:32', NULL, NULL, NULL),
(435, 53, 'payout', 135.525000000000005684, 135.53, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_435', '2026-03-05 09:00:03', NULL, NULL, NULL),
(436, 54, 'payout', 46.210450000000001580, 46.21, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_436', '2026-03-05 09:00:03', NULL, NULL, NULL),
(437, 55, 'payout', 25.000000000000000000, 25.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_437', '2026-03-05 09:00:04', NULL, NULL, NULL),
(438, 49, 'referral_bonus', 1.250000000000000000, 1.25, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_14_dup_438', '2026-03-05 09:00:04', NULL, NULL, NULL),
(439, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_439', '2026-03-05 09:00:04', NULL, NULL, NULL),
(440, 53, 'payout', 135.525000000000005684, 135.53, 'USDT', NULL, NULL, 'completed', 'earnings_inv_12_dup_440', '2026-03-06 09:00:03', NULL, NULL, NULL),
(441, 54, 'payout', 46.210450000000001580, 46.21, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_441', '2026-03-06 09:00:03', NULL, NULL, NULL),
(442, 55, 'payout', 25.000000000000000000, 25.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_442', '2026-03-06 09:00:04', NULL, NULL, NULL),
(443, 49, 'referral_bonus', 1.250000000000000000, 1.25, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_14_dup_443', '2026-03-06 09:00:04', NULL, NULL, NULL),
(444, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_444', '2026-03-06 09:00:04', NULL, NULL, NULL),
(445, 52, 'payout', 195.000000000000000000, 195.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_16', '2026-03-06 09:00:05', NULL, NULL, NULL),
(446, 50, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_16', '2026-03-06 09:00:05', NULL, NULL, NULL),
(447, 54, 'payout', 46.210450000000001580, 46.21, 'USDT', NULL, NULL, 'completed', 'earnings_inv_13_dup_447', '2026-03-07 09:00:03', NULL, NULL, NULL),
(448, 55, 'payout', 25.000000000000000000, 25.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_14_dup_448', '2026-03-07 09:00:04', NULL, NULL, NULL),
(449, 49, 'referral_bonus', 1.250000000000000000, 1.25, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_14_dup_449', '2026-03-07 09:00:04', NULL, NULL, NULL),
(450, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_450', '2026-03-07 09:00:04', NULL, NULL, NULL),
(451, 52, 'payout', 195.000000000000000000, 195.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_16_dup_451', '2026-03-07 09:00:04', NULL, NULL, NULL),
(452, 50, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_16_dup_452', '2026-03-07 09:00:04', NULL, NULL, NULL),
(453, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_453', '2026-03-08 09:00:04', NULL, NULL, NULL),
(454, 52, 'payout', 195.000000000000000000, 195.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_16_dup_454', '2026-03-08 09:00:04', NULL, NULL, NULL),
(455, 50, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_16_dup_455', '2026-03-08 09:00:04', NULL, NULL, NULL),
(456, 53, 'deposit', 271.050000000000011369, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_53_20260308_183608', '2026-03-08 18:36:08', NULL, NULL, NULL),
(457, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_457', '2026-03-09 09:00:03', NULL, NULL, NULL),
(458, 52, 'payout', 195.000000000000000000, 195.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_16_dup_458', '2026-03-09 09:00:09', NULL, NULL, NULL),
(459, 50, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_16_dup_459', '2026-03-09 09:00:09', NULL, NULL, NULL),
(460, 50, 'deposit', 2000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_50_20260309_223836', '2026-03-09 22:38:36', NULL, NULL, NULL),
(461, 50, 'withdrawal', 6200.000000000000000000, 6200.00, 'USDT', NULL, NULL, 'completed', 'TXSFTYTrTqEb9VDorqb8MHoYFYoVp19nzr', '2026-03-09 22:41:08', NULL, NULL, NULL),
(462, 53, 'deposit', 2085.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-09 23:04:46', NULL, NULL, NULL),
(463, 53, 'investment', 3072.260000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-09 23:21:42', NULL, NULL, NULL),
(464, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_464', '2026-03-10 09:00:03', NULL, NULL, NULL),
(465, 52, 'payout', 195.000000000000000000, 195.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_16_dup_465', '2026-03-10 09:00:04', NULL, NULL, NULL),
(466, 50, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_16_dup_466', '2026-03-10 09:00:04', NULL, NULL, NULL),
(467, 53, 'payout', 199.696900000000027831, 199.70, 'USDT', NULL, NULL, 'completed', 'earnings_inv_17', '2026-03-10 09:00:04', NULL, NULL, NULL),
(468, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_468', '2026-03-11 09:00:03', NULL, NULL, NULL),
(469, 52, 'payout', 195.000000000000000000, 195.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_16_dup_469', '2026-03-11 09:00:03', NULL, NULL, NULL),
(470, 50, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_16_dup_470', '2026-03-11 09:00:03', NULL, NULL, NULL),
(471, 53, 'payout', 199.696900000000027831, 199.70, 'USDT', NULL, NULL, 'completed', 'earnings_inv_17_dup_471', '2026-03-11 09:00:04', NULL, NULL, NULL),
(472, 54, 'deposit', 46.210500000000003240, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_54_20260312_085341', '2026-03-12 08:53:42', NULL, NULL, NULL),
(473, 54, 'deposit', 46.210500000000003240, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_54_20260312_085427', '2026-03-12 08:54:27', NULL, NULL, NULL),
(474, 54, 'withdrawal', 13.156499999999999417, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_54_20260312_085737', '2026-03-12 08:57:37', NULL, NULL, NULL),
(475, 54, 'deposit', 710.930000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-12 08:57:54', NULL, NULL, NULL),
(476, 50, 'payout', 990.000000000000000000, 990.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_15_dup_476', '2026-03-12 09:00:04', NULL, NULL, NULL),
(477, 53, 'payout', 199.696900000000027831, 199.70, 'USDT', NULL, NULL, 'completed', 'earnings_inv_17_dup_477', '2026-03-12 09:00:04', NULL, NULL, NULL),
(478, 54, 'investment', 1034.400000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-12 13:08:30', NULL, NULL, NULL),
(479, 53, 'payout', 199.696900000000027831, 199.70, 'USDT', NULL, NULL, 'completed', 'earnings_inv_17_dup_479', '2026-03-13 09:00:04', NULL, NULL, NULL),
(480, 54, 'payout', 67.236000000000004206, 67.24, 'USDT', NULL, NULL, 'completed', 'earnings_inv_18', '2026-03-13 09:00:04', NULL, NULL, NULL),
(481, 53, 'payout', 199.696900000000027831, 199.70, 'USDT', NULL, NULL, 'completed', 'earnings_inv_17_dup_481', '2026-03-14 09:00:03', NULL, NULL, NULL),
(482, 54, 'payout', 67.236000000000004206, 67.24, 'USDT', NULL, NULL, 'completed', 'earnings_inv_18_dup_482', '2026-03-14 09:00:04', NULL, NULL, NULL),
(483, 53, 'payout', 199.696900000000027831, 199.70, 'USDT', NULL, NULL, 'completed', 'earnings_inv_17_dup_483', '2026-03-15 09:00:04', NULL, NULL, NULL),
(484, 54, 'payout', 67.236000000000004206, 67.24, 'USDT', NULL, NULL, 'completed', 'earnings_inv_18_dup_484', '2026-03-15 09:00:04', NULL, NULL, NULL),
(485, 54, 'payout', 67.236000000000004206, 67.24, 'USDT', NULL, NULL, 'completed', 'earnings_inv_18_dup_485', '2026-03-16 09:00:03', NULL, NULL, NULL),
(486, 53, 'deposit', 3072.260000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-17 08:39:12', NULL, NULL, NULL),
(487, 54, 'payout', 67.236000000000004206, 67.24, 'USDT', NULL, NULL, 'completed', 'earnings_inv_18_dup_487', '2026-03-17 09:00:04', NULL, NULL, NULL),
(488, 53, 'investment', 4270.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-17 17:18:50', NULL, NULL, NULL),
(489, 53, 'deposit', 4270.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-18 00:02:37', NULL, NULL, NULL),
(490, 54, 'payout', 67.236000000000004206, 67.24, 'USDT', NULL, NULL, 'completed', 'earnings_inv_18_dup_490', '2026-03-18 09:00:03', NULL, NULL, NULL),
(491, 54, 'deposit', 1034.400000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-22 08:21:36', NULL, NULL, NULL),
(492, 54, 'investment', 1437.810000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-25 18:57:56', NULL, NULL, NULL),
(493, 54, 'payout', 93.457650000000001000, 93.46, 'USDT', NULL, NULL, 'completed', 'earnings_inv_20', '2026-03-26 09:00:03', NULL, NULL, NULL),
(494, 53, 'investment', 4270.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-03-26 17:20:32', NULL, NULL, NULL),
(495, 54, 'payout', 93.457650000000001000, 93.46, 'USDT', NULL, NULL, 'completed', 'earnings_inv_20_dup_495', '2026-03-27 09:00:03', NULL, NULL, NULL),
(496, 53, 'payout', 277.550000000000011369, 277.55, 'USDT', NULL, NULL, 'completed', 'earnings_inv_21', '2026-03-27 09:00:05', NULL, NULL, NULL),
(497, 54, 'payout', 93.457650000000001000, 93.46, 'USDT', NULL, NULL, 'completed', 'earnings_inv_20_dup_497', '2026-03-28 09:00:04', NULL, NULL, NULL),
(498, 53, 'payout', 277.550000000000011369, 277.55, 'USDT', NULL, NULL, 'completed', 'earnings_inv_21_dup_498', '2026-03-28 09:00:04', NULL, NULL, NULL),
(499, 54, 'payout', 93.457650000000001000, 93.46, 'USDT', NULL, NULL, 'completed', 'earnings_inv_20_dup_499', '2026-03-29 09:00:03', NULL, NULL, NULL),
(500, 53, 'payout', 277.550000000000011369, 277.55, 'USDT', NULL, NULL, 'completed', 'earnings_inv_21_dup_500', '2026-03-29 09:00:04', NULL, NULL, NULL),
(501, 54, 'payout', 93.457650000000001000, 93.46, 'USDT', NULL, NULL, 'completed', 'earnings_inv_20_dup_501', '2026-03-30 09:00:03', NULL, NULL, NULL),
(502, 53, 'payout', 277.550000000000011369, 277.55, 'USDT', NULL, NULL, 'completed', 'earnings_inv_21_dup_502', '2026-03-30 09:00:04', NULL, NULL, NULL),
(503, 54, 'payout', 93.457650000000001000, 93.46, 'USDT', NULL, NULL, 'completed', 'earnings_inv_20_dup_503', '2026-03-31 09:00:04', NULL, NULL, NULL),
(504, 53, 'payout', 277.550000000000011369, 277.55, 'USDT', NULL, NULL, 'completed', 'earnings_inv_21_dup_504', '2026-03-31 09:00:05', NULL, NULL, NULL),
(506, 53, 'payout', 277.550000000000011369, 277.55, 'USDT', NULL, NULL, 'completed', 'earnings_inv_21_dup_506', '2026-04-01 09:00:05', NULL, NULL, NULL),
(507, 54, 'investment', 560.750000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-04-04 16:10:54', NULL, NULL, NULL),
(508, 53, 'deposit', 4270.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-04-04 16:36:20', NULL, NULL, NULL),
(509, 53, 'deposit', 335.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_53_20260404_182751', '2026-04-04 18:27:51', NULL, NULL, NULL),
(510, 53, 'deposit', 335.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_53_20260404_182751_dup_510', '2026-04-04 18:27:51', NULL, NULL, NULL),
(511, 53, 'withdrawal', 335.740000000000009095, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_53_20260404_183111', '2026-04-04 18:31:11', NULL, NULL, NULL),
(512, 54, 'payout', 28.037500000000001421, 28.04, 'USDT', NULL, NULL, 'completed', 'earnings_inv_22', '2026-04-05 09:00:07', NULL, NULL, NULL),
(513, 54, 'payout', 28.037500000000001421, 28.04, 'USDT', NULL, NULL, 'completed', 'earnings_inv_22_dup_513', '2026-04-06 09:00:03', NULL, NULL, NULL),
(514, 54, 'payout', 28.037500000000001421, 28.04, 'USDT', NULL, NULL, 'completed', 'earnings_inv_22_dup_514', '2026-04-07 09:00:04', NULL, NULL, NULL),
(515, 54, 'payout', 28.037500000000001421, 28.04, 'USDT', NULL, NULL, 'completed', 'earnings_inv_22_dup_515', '2026-04-08 09:00:03', NULL, NULL, NULL),
(516, 54, 'payout', 28.037500000000001421, 28.04, 'USDT', NULL, NULL, 'completed', 'earnings_inv_22_dup_516', '2026-04-09 09:00:05', NULL, NULL, NULL),
(524, 60, 'deposit', 50000.000000000000000000, 50000.00, 'USDT', NULL, NULL, 'pending', NULL, '2026-05-22 21:58:51', '2026-05-22 22:03:51', '2026-05-22 21:59:13', NULL),
(525, 60, 'deposit', 5.000000000000000000, 5.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-05-22 22:00:02', '2026-05-22 22:05:02', NULL, NULL),
(526, 60, 'deposit', 5.000000000000000000, 5.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-05-22 22:00:03', '2026-05-22 22:05:03', NULL, NULL),
(527, 55, 'deposit', 0.007898478226528356, 600.00, 'BTC', NULL, NULL, 'pending', NULL, '2026-05-26 17:54:29', '2026-05-26 17:59:29', '2026-05-26 17:54:39', NULL),
(528, 52, 'deposit', 2000.000000000000000000, 2000.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-09 13:36:31', '2026-06-09 13:41:31', '2026-06-09 13:38:29', '/uploads/deposit-proofs/tx_528_1781012309.jpg'),
(529, 52, 'deposit', 2000.000000000000000000, 2000.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-09 13:39:12', '2026-06-09 13:44:12', NULL, NULL),
(530, 50, 'referral_bonus', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'completed', 'ref_deposit_528', '2026-06-09 13:44:39', NULL, NULL, NULL),
(531, 52, 'deposit_bonus', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_528', '2026-06-09 13:44:39', NULL, NULL, NULL),
(532, 52, 'deposit', 3000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-09 14:03:56', NULL, NULL, NULL),
(533, 52, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-10 11:42:07', '2026-06-10 11:47:07', NULL, NULL),
(534, 52, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-10 11:42:07', '2026-06-10 11:47:07', NULL, NULL),
(535, 61, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-10 15:23:46', '2026-06-10 15:28:46', NULL, NULL),
(536, 61, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-10 15:38:04', '2026-06-10 15:43:04', '2026-06-10 15:39:45', '/uploads/deposit-proofs/tx_536_1781105985.jpg'),
(537, 52, 'referral_bonus', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'ref_deposit_536', '2026-06-10 15:47:53', NULL, NULL, NULL),
(538, 61, 'deposit_bonus', 20.000000000000000000, 20.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_536', '2026-06-10 15:47:53', NULL, NULL, NULL),
(539, 61, 'withdrawal', 20.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_61_20260610_154908', '2026-06-10 15:49:08', NULL, NULL, NULL),
(540, 61, 'investment', 200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-10 16:40:02', NULL, NULL, NULL),
(541, 52, 'referral_bonus', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'ref_inv_23', '2026-06-10 16:40:02', NULL, NULL, NULL),
(542, 52, 'investment', 6390.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-10 17:45:08', NULL, NULL, NULL),
(543, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_23', '2026-06-11 09:00:04', NULL, NULL, NULL),
(544, 52, 'referral_bonus', 0.500000000000000000, 0.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_23', '2026-06-11 09:00:04', NULL, NULL, NULL),
(545, 52, 'payout', 575.100000000000022737, 575.10, 'USDT', NULL, NULL, 'completed', 'earnings_inv_24', '2026-06-11 09:00:04', NULL, NULL, NULL),
(546, 50, 'referral_bonus', 28.760000000000000000, 28.76, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_24', '2026-06-11 09:00:04', NULL, NULL, NULL),
(547, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_23_dup_547', '2026-06-12 09:00:04', NULL, NULL, NULL),
(548, 52, 'referral_bonus', 0.500000000000000000, 0.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_23_dup_548', '2026-06-12 09:00:04', NULL, NULL, NULL),
(549, 52, 'payout', 575.100000000000022737, 575.10, 'USDT', NULL, NULL, 'completed', 'earnings_inv_24_dup_549', '2026-06-12 09:00:04', NULL, NULL, NULL),
(550, 50, 'referral_bonus', 28.760000000000000000, 28.76, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_24_dup_550', '2026-06-12 09:00:04', NULL, NULL, NULL),
(551, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_23_dup_551', '2026-06-13 09:00:04', NULL, NULL, NULL),
(552, 52, 'referral_bonus', 0.500000000000000000, 0.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_23_dup_552', '2026-06-13 09:00:04', NULL, NULL, NULL),
(553, 52, 'payout', 575.100000000000022737, 575.10, 'USDT', NULL, NULL, 'completed', 'earnings_inv_24_dup_553', '2026-06-13 09:00:04', NULL, NULL, NULL),
(554, 50, 'referral_bonus', 28.760000000000000000, 28.76, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_24_dup_554', '2026-06-13 09:00:04', NULL, NULL, NULL),
(555, 49, 'withdrawal', 0.009374414099118804, 600.00, 'BTC', NULL, NULL, 'pending', 'sfsfgdgggdgdgdgd', '2026-06-13 17:23:59', NULL, NULL, NULL),
(556, 49, 'withdrawal', 59.000000000000000000, 59.00, 'USDT', NULL, NULL, 'pending', 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', '2026-06-13 17:25:02', NULL, NULL, NULL),
(557, 52, 'withdrawal', 1000.000000000000000000, 1000.00, 'USDT', NULL, NULL, 'completed', 'ltc1qw2k36awete5sf2gg55hkp9v8evx6rn95aj6g47', '2026-06-13 17:57:56', NULL, NULL, NULL),
(558, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_23_dup_558', '2026-06-14 09:00:04', NULL, NULL, NULL),
(559, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_23_dup_559', '2026-06-14 09:00:04', NULL, NULL, NULL),
(560, 52, 'payout', 575.100000000000022737, 575.10, 'USDT', NULL, NULL, 'completed', 'earnings_inv_24_dup_560', '2026-06-14 09:00:04', NULL, NULL, NULL),
(561, 50, 'referral_bonus', 86.270000000000000000, 86.27, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_24_dup_561', '2026-06-14 09:00:04', NULL, NULL, NULL),
(562, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_23_dup_562', '2026-06-15 09:00:04', NULL, NULL, NULL),
(563, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_23_dup_563', '2026-06-15 09:00:04', NULL, NULL, NULL),
(564, 52, 'payout', 575.100000000000022737, 575.10, 'USDT', NULL, NULL, 'completed', 'earnings_inv_24_dup_564', '2026-06-15 09:00:05', NULL, NULL, NULL),
(565, 50, 'referral_bonus', 86.270000000000000000, 86.27, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_24_dup_565', '2026-06-15 09:00:05', NULL, NULL, NULL),
(566, 61, 'deposit', 200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-15 09:43:48', NULL, NULL, NULL),
(567, 61, 'withdrawal', 50.000000000000000000, 50.00, 'USDT', NULL, NULL, 'completed', 'TSrJNLaShW8wJwJHjjSfP5317ga7cJmeCN', '2026-06-15 22:24:06', NULL, NULL, NULL),
(568, 61, 'investment', 200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-15 23:00:34', NULL, NULL, NULL),
(569, 52, 'payout', 575.100000000000022737, 575.10, 'USDT', NULL, NULL, 'completed', 'earnings_inv_24_dup_569', '2026-06-16 09:00:04', NULL, NULL, NULL),
(570, 50, 'referral_bonus', 86.270000000000000000, 86.27, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_24_dup_570', '2026-06-16 09:00:04', NULL, NULL, NULL),
(571, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_25', '2026-06-16 09:00:04', NULL, NULL, NULL),
(572, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_25', '2026-06-16 09:00:04', NULL, NULL, NULL),
(573, 52, 'deposit', 53610.000000000000000000, 53610.00, 'USDT', NULL, NULL, 'pending', NULL, '2026-06-16 21:46:37', '2026-06-16 21:51:37', '2026-06-16 21:47:32', '/uploads/deposit-proofs/tx_573_1781646452.png'),
(574, 52, 'deposit', 53610.000000000000000000, 53610.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-16 21:48:18', '2026-06-16 21:53:18', NULL, NULL),
(575, 52, 'deposit', 53610.000000000000000000, 53610.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-16 21:48:18', '2026-06-16 21:53:18', '2026-06-16 21:48:52', '/uploads/deposit-proofs/tx_575_1781646532.png'),
(576, 50, 'referral_bonus', 8041.500000000000000000, 8041.50, 'USDT', NULL, NULL, 'completed', 'ref_deposit_574', '2026-06-16 21:49:39', NULL, NULL, NULL),
(577, 52, 'deposit_bonus', 5361.000000000000000000, 5361.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_574', '2026-06-16 21:49:39', NULL, NULL, NULL),
(578, 52, 'withdrawal', 1427.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260616_215053', '2026-06-16 21:50:53', NULL, NULL, NULL),
(579, 52, 'withdrawal', 1427.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260616_215058', '2026-06-16 21:50:58', NULL, NULL, NULL),
(580, 52, 'withdrawal', 1427.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260616_215059', '2026-06-16 21:50:59', NULL, NULL, NULL),
(581, 52, 'withdrawal', 1427.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260616_215100', '2026-06-16 21:51:00', NULL, NULL, NULL),
(582, 52, 'deposit', 300.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260616_215154', '2026-06-16 21:51:54', NULL, NULL, NULL),
(583, 52, 'withdrawal', 2000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260616_215335', '2026-06-16 21:53:35', NULL, NULL, NULL),
(584, 52, 'withdrawal', 2000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260616_215335_dup_584', '2026-06-16 21:53:35', NULL, NULL, NULL),
(585, 52, 'deposit', 2000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260616_215433', '2026-06-16 21:54:33', NULL, NULL, NULL),
(586, 52, 'investment', 54019.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-16 21:56:05', NULL, NULL, NULL),
(587, 52, 'deposit', 31412.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260616_221027', '2026-06-16 22:10:27', NULL, NULL, NULL),
(588, 49, 'profit_adjustment', 500.000000000000000000, 500.00, 'USD', NULL, NULL, 'completed', 'admin_profit_credit_1_49_20260616_233215', '2026-06-16 23:32:15', NULL, NULL, NULL),
(589, 55, 'profit_adjustment', 1000.000000000000000000, 1000.00, 'USD', NULL, NULL, 'completed', 'admin_profit_credit_1_55_20260616_233455', '2026-06-16 23:34:55', NULL, NULL, NULL),
(590, 52, 'deposit', 54019.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-17 00:11:50', NULL, NULL, NULL),
(591, 52, 'deposit', 6390.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-17 00:11:53', NULL, NULL, NULL),
(592, 52, 'investment', 60000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-17 00:13:56', NULL, NULL, NULL),
(593, 52, 'withdrawal', 31821.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_52_20260617_001551', '2026-06-17 00:15:51', NULL, NULL, NULL),
(594, 52, 'profit_adjustment', 31200.000000000000000000, 31200.00, 'USD', NULL, NULL, 'completed', 'admin_profit_credit_1_52_20260617_001800', '2026-06-17 00:18:00', NULL, NULL, NULL),
(595, 52, 'profit_adjustment', -4620.000000000000000000, -4620.00, 'USD', NULL, NULL, 'completed', 'admin_profit_debit_1_52_20260617_001944', '2026-06-17 00:19:44', NULL, NULL, NULL),
(596, 49, 'referral_bonus_adjustment', 400.000000000000000000, 400.00, 'USD', NULL, NULL, 'completed', 'admin_ref_bonus_credit_1_49_20260617_001945', '2026-06-17 00:19:45', NULL, NULL, NULL),
(597, 52, 'referral_bonus_adjustment', 1000.000000000000000000, 1000.00, 'USD', NULL, NULL, 'completed', 'admin_ref_bonus_credit_1_52_20260617_002104', '2026-06-17 00:21:04', NULL, NULL, NULL),
(598, 52, 'deposit', 31200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260617_002426', '2026-06-17 00:24:26', NULL, NULL, NULL),
(599, 52, 'referral_bonus_adjustment', 3000.000000000000000000, 3000.00, 'USD', NULL, NULL, 'completed', 'admin_ref_bonus_credit_1_52_20260617_002516', '2026-06-17 00:25:16', NULL, NULL, NULL),
(600, 52, 'deposit', 4026.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260617_002638', '2026-06-17 00:26:38', NULL, NULL, NULL),
(601, 52, 'deposit', 4026.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_52_20260617_002638_dup_601', '2026-06-17 00:26:38', NULL, NULL, NULL),
(602, 52, 'deposit', 2000.000000000000000000, 2000.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-17 07:19:32', '2026-06-17 07:24:32', NULL, NULL),
(603, 52, 'deposit', 0.030545076897231089, 2000.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-06-17 07:24:53', '2026-06-17 07:29:53', NULL, NULL),
(604, 52, 'deposit', 1.121082517278684243, 2000.00, 'ETH', NULL, NULL, 'failed', NULL, '2026-06-17 07:25:57', '2026-06-17 07:30:57', NULL, NULL),
(605, 52, 'deposit', 6283.735806611746738781, 2000.00, 'TRX', NULL, NULL, 'failed', NULL, '2026-06-17 07:27:04', '2026-06-17 07:32:04', NULL, NULL),
(606, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_25_dup_606', '2026-06-17 09:00:09', NULL, NULL, NULL),
(607, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_25_dup_607', '2026-06-17 09:00:09', NULL, NULL, NULL),
(608, 50, 'referral_bonus', 1.000000000000000000, 1.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_25', '2026-06-17 09:00:09', NULL, NULL, NULL),
(609, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_25_dup_609', '2026-06-18 09:00:03', NULL, NULL, NULL),
(610, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_25_dup_610', '2026-06-18 09:00:03', NULL, NULL, NULL),
(611, 50, 'referral_bonus', 1.000000000000000000, 1.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_25_dup_611', '2026-06-18 09:00:03', NULL, NULL, NULL),
(612, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27', '2026-06-18 09:00:06', NULL, NULL, NULL),
(613, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27', '2026-06-18 09:00:06', NULL, NULL, NULL),
(614, 61, 'deposit', 1450.000000000000000000, 1450.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-18 15:32:29', '2026-06-18 15:37:29', NULL, NULL),
(615, 61, 'deposit', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-18 15:36:28', '2026-06-18 15:41:28', NULL, NULL),
(616, 61, 'deposit', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-18 15:51:45', '2026-06-18 15:56:45', NULL, NULL),
(617, 61, 'deposit', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-18 15:55:31', '2026-06-18 16:00:31', NULL, NULL),
(618, 61, 'deposit', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-18 22:57:32', '2026-06-18 23:02:32', NULL, NULL),
(619, 61, 'deposit', 0.000159344774288127, 10.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-06-18 23:24:01', '2026-06-18 23:29:01', NULL, NULL),
(620, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_25_dup_620', '2026-06-19 09:00:04', NULL, NULL, NULL),
(621, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_25_dup_621', '2026-06-19 09:00:04', NULL, NULL, NULL),
(622, 50, 'referral_bonus', 1.000000000000000000, 1.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_25_dup_622', '2026-06-19 09:00:04', NULL, NULL, NULL),
(623, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_623', '2026-06-19 09:00:05', NULL, NULL, NULL),
(624, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_624', '2026-06-19 09:00:05', NULL, NULL, NULL),
(625, 61, 'deposit', 0.000158679784195493, 10.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-06-19 14:21:25', '2026-06-19 14:26:25', NULL, NULL),
(626, 61, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_25_dup_626', '2026-06-20 09:00:04', NULL, NULL, NULL),
(627, 52, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_25_dup_627', '2026-06-20 09:00:04', NULL, NULL, NULL),
(628, 50, 'referral_bonus', 1.000000000000000000, 1.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_25_dup_628', '2026-06-20 09:00:04', NULL, NULL, NULL),
(629, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_629', '2026-06-20 09:00:05', NULL, NULL, NULL),
(630, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_630', '2026-06-20 09:00:05', NULL, NULL, NULL),
(631, 61, 'withdrawal', 50.000000000000000000, 50.00, 'USDT', NULL, NULL, 'completed', 'TSrJNLaShW8wJwJHjjSfP5317ga7cJmeCN_dup_631', '2026-06-20 16:42:21', NULL, NULL, NULL),
(632, 61, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-20 17:13:18', '2026-06-20 17:18:18', NULL, NULL),
(633, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_633', '2026-06-21 09:00:04', NULL, NULL, NULL),
(634, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_634', '2026-06-21 09:00:04', NULL, NULL, NULL),
(635, 61, 'deposit', 200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-21 10:27:55', NULL, NULL, NULL),
(636, 61, 'profit_adjustment', 10.000000000000000000, 10.00, 'USD', NULL, NULL, 'completed', 'admin_profit_credit_1_61_20260621_102833', '2026-06-21 10:28:33', NULL, NULL, NULL),
(637, 61, 'deposit', 10.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_credit_1_61_20260621_102947', '2026-06-21 10:29:47', NULL, NULL, NULL),
(638, 61, 'investment', 210.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-21 15:38:52', NULL, NULL, NULL),
(639, 52, 'deposit', 1.566587815079974355, 100000.00, 'BTC', NULL, NULL, 'failed', NULL, '2026-06-22 04:04:25', '2026-06-22 04:09:25', NULL, NULL),
(640, 52, 'deposit', 100000.000000000000000000, 100000.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-22 04:06:36', '2026-06-22 04:11:36', NULL, NULL),
(641, 52, 'deposit', 57.847271633433408056, 100000.00, 'ETH', NULL, NULL, 'failed', NULL, '2026-06-22 04:07:27', '2026-06-22 04:12:27', NULL, NULL),
(642, 52, 'deposit', 2225.189141076991745649, 100000.00, 'LTC', NULL, NULL, 'failed', NULL, '2026-06-22 04:10:30', '2026-06-22 04:15:30', NULL, NULL),
(643, 52, 'deposit', 2225.189141076991745649, 100000.00, 'LTC', NULL, NULL, 'failed', NULL, '2026-06-22 04:10:30', '2026-06-22 04:15:30', NULL, NULL),
(644, 52, 'deposit', 503.651473180559037246, 100000.00, 'BCH', NULL, NULL, 'failed', NULL, '2026-06-22 04:12:01', '2026-06-22 04:17:01', NULL, NULL),
(645, 52, 'deposit', 304979.398641621752176434, 100000.00, 'TRX', NULL, NULL, 'failed', NULL, '2026-06-22 04:19:09', '2026-06-22 04:24:09', NULL, NULL),
(646, 52, 'deposit', 1204804.761388416867703199, 100000.00, 'DOGE', NULL, NULL, 'failed', NULL, '2026-06-22 04:20:15', '2026-06-22 04:25:15', NULL, NULL),
(647, 52, 'deposit', 1359.619306594153613332, 100000.00, 'SOL', NULL, NULL, 'failed', NULL, '2026-06-22 04:24:01', '2026-06-22 04:29:01', NULL, NULL),
(648, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_648', '2026-06-22 09:00:04', NULL, NULL, NULL),
(649, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_649', '2026-06-22 09:00:04', NULL, NULL, NULL),
(650, 61, 'payout', 10.500000000000000000, 10.50, 'USDT', NULL, NULL, 'completed', 'earnings_inv_28', '2026-06-22 09:00:05', NULL, NULL, NULL),
(651, 52, 'referral_bonus', 1.580000000000000071, 1.58, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_28', '2026-06-22 09:00:05', NULL, NULL, NULL),
(652, 50, 'referral_bonus', 1.050000000000000044, 1.05, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_28', '2026-06-22 09:00:05', NULL, NULL, NULL),
(653, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_653', '2026-06-23 09:00:05', NULL, NULL, NULL),
(654, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_654', '2026-06-23 09:00:05', NULL, NULL, NULL),
(655, 61, 'payout', 10.500000000000000000, 10.50, 'USDT', NULL, NULL, 'completed', 'earnings_inv_28_dup_655', '2026-06-23 09:00:06', NULL, NULL, NULL),
(656, 52, 'referral_bonus', 1.580000000000000071, 1.58, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_28_dup_656', '2026-06-23 09:00:06', NULL, NULL, NULL),
(657, 50, 'referral_bonus', 1.050000000000000044, 1.05, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_28_dup_657', '2026-06-23 09:00:06', NULL, NULL, NULL),
(658, 52, 'withdrawal', 15500.000000000000000000, 15500.00, 'USDT', NULL, NULL, 'pending', 'TXSFTYTrTqEb9VDorqb8MHoYFYoVp19nzr_dup_658', '2026-06-23 09:34:31', NULL, NULL, NULL),
(659, 49, 'withdrawal', 0.000160459556168868, 10.00, 'BTC', NULL, NULL, 'pending', 'TQ3U1Zz3XX5AqKHzbMZkjJ4UZpQfKHLN2v', '2026-06-23 11:04:59', NULL, NULL, NULL),
(660, 71, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-24 01:07:17', '2026-06-24 01:12:17', NULL, NULL),
(661, 61, 'deposit', 975.000000000000000000, 975.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-24 01:14:37', '2026-06-24 01:19:37', NULL, NULL),
(662, 52, 'deposit', 5000.000000000000000000, 5000.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-24 02:31:59', '2026-06-24 02:36:59', '2026-06-24 02:32:20', '/uploads/deposit-proofs/tx_662_1782268340.jpg'),
(663, 52, 'deposit_bonus', 500.000000000000000000, 500.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_662', '2026-06-24 02:33:22', NULL, NULL, NULL),
(664, 52, 'deposit_bonus', 5361.000000000000000000, 5361.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_575', '2026-06-24 02:33:44', NULL, NULL, NULL),
(665, 52, 'deposit', 5000.000000000000000000, 5000.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-24 02:40:39', '2026-06-24 02:45:39', NULL, NULL),
(666, 71, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-24 03:07:27', '2026-06-24 03:12:27', '2026-06-24 03:08:02', NULL),
(667, 71, 'deposit', 200.000000000000000000, 200.00, 'USDT', NULL, NULL, 'failed', NULL, '2026-06-24 03:10:29', '2026-06-24 03:15:29', NULL, NULL),
(668, 61, 'referral_bonus', 30.000000000000000000, 30.00, 'USDT', NULL, NULL, 'completed', 'ref_deposit_666', '2026-06-24 03:13:24', NULL, NULL, NULL),
(669, 52, 'referral_bonus', 20.000000000000000000, 20.00, 'USDT', NULL, NULL, 'completed', 'ref_deposit_l2_666', '2026-06-24 03:13:24', NULL, NULL, NULL),
(670, 71, 'deposit_bonus', 20.000000000000000000, 20.00, 'USDT', NULL, NULL, 'completed', 'dep_bonus_666', '2026-06-24 03:13:24', NULL, NULL, NULL),
(671, 71, 'withdrawal', 20.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', 'admin_debit_1_71_20260624_031601', '2026-06-24 03:16:01', NULL, NULL, NULL),
(672, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_672', '2026-06-24 09:00:04', NULL, NULL, NULL),
(673, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_673', '2026-06-24 09:00:04', NULL, NULL, NULL),
(674, 61, 'payout', 10.500000000000000000, 10.50, 'USDT', NULL, NULL, 'completed', 'earnings_inv_28_dup_674', '2026-06-24 09:00:04', NULL, NULL, NULL),
(675, 52, 'referral_bonus', 1.580000000000000071, 1.58, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_28_dup_675', '2026-06-24 09:00:04', NULL, NULL, NULL),
(676, 50, 'referral_bonus', 1.050000000000000044, 1.05, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_28_dup_676', '2026-06-24 09:00:04', NULL, NULL, NULL),
(677, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_677', '2026-06-25 09:00:04', NULL, NULL, NULL),
(678, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_678', '2026-06-25 09:00:04', NULL, NULL, NULL),
(679, 61, 'payout', 10.500000000000000000, 10.50, 'USDT', NULL, NULL, 'completed', 'earnings_inv_28_dup_679', '2026-06-25 09:00:04', NULL, NULL, NULL),
(680, 52, 'referral_bonus', 1.580000000000000071, 1.58, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_28_dup_680', '2026-06-25 09:00:04', NULL, NULL, NULL),
(681, 50, 'referral_bonus', 1.050000000000000044, 1.05, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_28_dup_681', '2026-06-25 09:00:04', NULL, NULL, NULL),
(682, 71, 'investment', 200.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-25 12:34:15', NULL, NULL, NULL),
(683, 61, 'deposit', 991.000000000000000000, 991.00, 'USDT', NULL, NULL, 'pending', NULL, '2026-06-25 13:13:50', '2026-06-25 13:18:50', '2026-06-25 13:17:07', NULL),
(684, 61, 'deposit', 993.000000000000000000, 993.00, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-25 14:12:38', '2026-06-25 14:17:38', '2026-06-25 14:13:56', '/uploads/deposit-proofs/tx_684_1782396836.png'),
(685, 61, 'withdrawal', 50.000000000000000000, 50.00, 'USDT', NULL, NULL, 'completed', 'TGTW2m9vPqHuHsMWew4VbrWVH612TGP8MR', '2026-06-25 16:56:10', NULL, NULL, NULL),
(686, 61, 'deposit_bonus', 99.300000000000000000, 99.30, 'USDT', NULL, NULL, 'completed', 'dep_bonus_684', '2026-06-25 18:22:12', NULL, NULL, NULL),
(687, 61, 'investment', 1000.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-25 20:51:10', NULL, NULL, NULL),
(688, 52, 'payout', 7800.000000000000000000, 7800.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_27_dup_688', '2026-06-26 09:00:04', NULL, NULL, NULL),
(689, 50, 'referral_bonus', 1170.000000000000000000, 1170.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_27_dup_689', '2026-06-26 09:00:04', NULL, NULL, NULL),
(690, 61, 'payout', 10.500000000000000000, 10.50, 'USDT', NULL, NULL, 'completed', 'earnings_inv_28_dup_690', '2026-06-26 09:00:05', NULL, NULL, NULL),
(691, 52, 'referral_bonus', 1.580000000000000071, 1.58, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_28_dup_691', '2026-06-26 09:00:05', NULL, NULL, NULL),
(692, 50, 'referral_bonus', 1.050000000000000044, 1.05, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_28_dup_692', '2026-06-26 09:00:05', NULL, NULL, NULL),
(693, 71, 'payout', 10.000000000000000000, 10.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_29', '2026-06-26 09:00:07', NULL, NULL, NULL),
(694, 61, 'referral_bonus', 1.500000000000000000, 1.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_29', '2026-06-26 09:00:07', NULL, NULL, NULL),
(695, 52, 'referral_bonus', 1.000000000000000000, 1.00, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_29', '2026-06-26 09:00:07', NULL, NULL, NULL),
(696, 61, 'payout', 65.000000000000000000, 65.00, 'USDT', NULL, NULL, 'completed', 'earnings_inv_30', '2026-06-26 09:00:08', NULL, NULL, NULL),
(697, 52, 'referral_bonus', 9.750000000000000000, 9.75, 'USDT', NULL, NULL, 'completed', 'ref_payout_inv_30', '2026-06-26 09:00:08', NULL, NULL, NULL),
(698, 50, 'referral_bonus', 6.500000000000000000, 6.50, 'USDT', NULL, NULL, 'completed', 'ref_payout_l2_inv_30', '2026-06-26 09:00:08', NULL, NULL, NULL),
(699, 61, 'deposit', 210.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-26 09:34:05', NULL, NULL, NULL),
(700, 61, 'withdrawal', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'completed', 'TSrJNLaShW8wJwJHjjSfP5317ga7cJmeCN_dup_700', '2026-06-26 10:21:59', NULL, NULL, NULL),
(701, 61, 'withdrawal', 100.000000000000000000, 100.00, 'USDT', NULL, NULL, 'completed', 'TGTW2m9vPqHuHsMWew4VbrWVH612TGP8MR_dup_701', '2026-06-26 10:23:59', NULL, NULL, NULL),
(702, 61, 'investment', 201.000000000000000000, NULL, 'USDT', NULL, NULL, 'completed', NULL, '2026-06-26 10:27:48', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_notes` text DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `referral_code` varchar(100) DEFAULT NULL,
  `referred_by_user_id` int(10) UNSIGNED DEFAULT NULL,
  `my_referral_code` varchar(32) DEFAULT NULL,
  `last_balance_usd` decimal(18,2) NOT NULL DEFAULT 0.00,
  `last_balance_usd_updated_at` datetime DEFAULT NULL,
  `kyc_status` enum('none','pending','verified','rejected') NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `name`, `role`, `email_verified`, `active`, `two_factor_enabled`, `created_at`, `updated_at`, `admin_notes`, `avatar_url`, `phone_number`, `country`, `referral_code`, `referred_by_user_id`, `my_referral_code`, `last_balance_usd`, `last_balance_usd_updated_at`, `kyc_status`) VALUES
(1, 'support@bloombitfx.com', '$2y$10$FEbqa0Ix/ZHjVBJI41R5k.kp.3TQQAAXylHzMrXDmgD/L/dtyeMKe', 'Admin', 'admin', 1, 1, 0, '2026-02-15 01:25:45', '2026-02-24 22:43:16', NULL, NULL, NULL, NULL, NULL, NULL, 'REF1', 0.00, NULL, 'none'),
(9, 'j.donovan@gmail.com', '$2y$10$JTg6nQYebZOEaKheTc.O0u3xuTML8itKcWuq18p8q/zqHLAVjx.3e', 'James Donovan', 'user', 1, 1, 1, '2026-02-15 14:50:08', '2026-06-27 12:43:10', NULL, '/uploads/avatars/9_1771167884.jpg', NULL, 'United States', NULL, NULL, 'REF9', 0.00, '2026-06-27 12:43:10', 'verified'),
(49, 'mr.carter.tech07@gmail.com', '$2y$10$437lyEG9BVfV0JYwBqIcbO03nChjWcb0LM96Y1cxCyZ0jnzQ4ObFq', 'carter tech', 'user', 1, 1, 0, '2026-02-19 22:12:09', '2026-06-27 12:43:10', NULL, NULL, '+24391347593', NULL, NULL, NULL, 'REF49', 121.00, '2026-06-27 12:43:10', 'none'),
(50, 'murungibetty621@gmail.com', '$2y$10$kYf1LKJlgLhsFfQgIlGHsuz0JhHaCiqe60fmp50RklYzVmLKMQUe.', 'Franklin Joel', 'user', 1, 1, 1, '2026-02-20 08:30:11', '2026-06-27 12:43:10', NULL, NULL, '09164592654', NULL, NULL, NULL, 'REF50', 23242.72, '2026-06-27 12:43:10', 'verified'),
(51, 'diididududjjdjd@gmail10p.com', '$2y$10$8lOvqu7DguWu3BO4CR4uFeJHZDPEfmzvHYfxmuFBf7h8/l54yHcDu', 'robin', 'user', 1, 1, 1, '2026-02-24 10:36:14', '2026-03-03 11:20:15', NULL, NULL, '07084555455', NULL, NULL, NULL, 'REF51', 0.00, '2026-02-24 22:43:16', 'none'),
(52, 'goldfranklin1@gmail.com', '$2y$10$LbroIaZdgcb0oMJNvtVc3uaFXthi9K2cJ0/yWuRP5xm0KbJOjhfH6', 'Fabian Dion', 'user', 1, 1, 0, '2026-02-25 13:21:11', '2026-06-27 12:43:10', NULL, '/uploads/avatars/52_1781647616.jpg', '+125398555522', 'United States', 'REF50', 50, 'REF52', 158468.25, '2026-06-27 12:43:10', 'none'),
(53, 'beverlypowell231@gmail.com', '$2y$10$XVxYJBrvrvKjAUSj.Q4NnOqy3v2nN1ZtnqgkXyRq8mAz7xAW.p8ji', 'Beverley Powell', 'user', 1, 1, 1, '2026-02-28 01:06:56', '2026-06-27 12:43:10', NULL, NULL, '14376606835', NULL, NULL, NULL, 'REF53', 6270.00, '2026-06-27 12:43:10', 'none'),
(54, 'cbh3570@gmail.com', '$2y$10$7jA1M1lvqgoSGU4S0WW.BeWHjjBmKqzVbAWnrFTwGgJm7QWsOawAS', 'Courtney Harris', 'user', 1, 1, 1, '2026-02-28 14:24:35', '2026-06-27 12:43:10', NULL, '/uploads/avatars/reg_1772288234_e1daa3b3.jpg', '18762879605', NULL, NULL, NULL, 'REF54', 140.19, '2026-06-27 12:43:10', 'none'),
(55, 'benjaminraynold07@gmail.com', '$2y$10$h/EoV3zCfuCsjA86sbmgZO4j0axRLvSiEVmosWxSIrJO7QaAxR6pW', 'ben murray', 'user', 1, 1, 1, '2026-03-02 21:33:11', '2026-06-27 12:43:10', NULL, NULL, '+2347404470490', NULL, 'REF49', 49, 'REF55', 1207.12, '2026-06-27 12:43:10', 'none'),
(60, 'jamesjohnson53g@gmail.com', '$2y$10$.CY.rGOOEGmx.dvOmYrTPOnTPl0HyThDWwRCWaruXcBOMcN61Y5SO', 'James Joyce', 'user', 1, 1, 0, '2026-05-22 21:57:30', '2026-06-13 17:23:07', NULL, NULL, '08023855272', NULL, NULL, NULL, 'REF60', 0.00, '2026-06-13 17:23:07', 'none'),
(61, 'folusho27@yahoo.com', '$2y$10$TRz.aGFIWJVPAWbsJoqJyuGU7KNccQc/e8ENmlS0j/D2o6Eu429BW', 'Folusho ofemu', 'user', 1, 1, 0, '2026-06-10 11:09:49', '2026-06-27 12:43:10', NULL, NULL, '4133280799', NULL, 'REF52', 52, 'REF61', 0.30, '2026-06-27 12:43:10', 'none'),
(62, 'sandychan538@gmail.com', '$2y$10$inH.J5XAWZ.i99rVfunsq.FSenZWahBibkea1JmUk.mpmOtfiVXpi', 'Jaak Mary', 'user', 1, 1, 0, '2026-06-12 09:13:22', '2026-06-13 17:23:07', NULL, NULL, '08167394022', NULL, NULL, NULL, 'REF62', 0.00, '2026-06-13 17:23:07', 'none'),
(63, 'justymighty70@gmail.com', '$2y$10$MxJUIRoxkcMv3mjCJaV40OLV.vWZmxs2o5II6vcMB1R67A53hwHOm', 'Sama Abo-oluwa', 'user', 1, 1, 0, '2026-06-21 20:58:44', '2026-06-27 00:14:36', NULL, NULL, '+2348101899089', NULL, 'REF61', 61, 'REF63', 0.00, '2026-06-27 00:14:36', 'none'),
(64, 'nickygoldhairs4@gmail.com', '$2y$10$W.Wp/yXJoa3ZlHF2yp9RruCqph1OEiRbkMWc73OMWnCECOa5IysWW', 'Adewale Adenike', 'user', 1, 1, 0, '2026-06-21 23:45:19', '2026-06-27 00:14:36', NULL, NULL, '+2349071870086', NULL, 'REF61', 61, 'REF64', 0.00, '2026-06-27 00:14:36', 'none'),
(65, 'akharohfaith@gmail.com', '$2y$10$89NAE2gNGWWC/yg4IwlsweIl7Qh1.JD2uNsEZIrUjSJZadCW903Mu', 'Faith I Izevbijie', 'user', 1, 1, 0, '2026-06-22 19:43:08', '2026-06-27 00:14:36', NULL, NULL, '19783371669', NULL, 'REF61', 61, 'REF65', 0.00, '2026-06-27 00:14:36', 'none'),
(66, 'omolaraolanipekun27@gmail.com', '$2y$10$cOFEprF7P8a0HnXGRqQoTuAa5e6XOA7T2NwZUcncPUWWAgjd9yBPO', 'Olanipekun Adewumi', 'user', 1, 1, 0, '2026-06-22 23:10:18', '2026-06-27 00:14:36', NULL, NULL, '+2347039101714', NULL, 'REF61', 61, 'REF66', 0.00, '2026-06-27 00:14:36', 'none'),
(67, 'emmanueloratokhai44@gmail.com', '$2y$10$BxDWEYf/7SbgG/qEl2aGVOzcNCmWsZGyV0ce.9C5.F5NMmpuDu5H.', 'Emmanuel Oratokhai', 'user', 1, 1, 0, '2026-06-23 00:43:20', '2026-06-27 00:14:36', NULL, NULL, NULL, NULL, 'REF61', 61, 'REF67', 0.00, '2026-06-27 00:14:36', 'none'),
(68, 'kokomadavidson@gmail.com', '$2y$10$OF6kgAeRRm9aoKFBcDIUaOv4UeS84OEya/eSQVjbF2ut7yJv5lgPK', 'Esther Kokomma Davidson', 'user', 1, 1, 0, '2026-06-23 06:14:07', '2026-06-27 00:14:36', NULL, NULL, '09167160270', NULL, 'REF61', 61, 'REF68', 0.00, '2026-06-27 00:14:36', 'none'),
(69, 'tegaovus@gmail.com', '$2y$10$fbAcoFBDhu6OLnGtDEdsmOvcR6.up0keqLr7zLG7y2UgO.lyBBaja', 'Tega ovus', 'user', 1, 1, 0, '2026-06-23 06:43:51', '2026-06-27 00:14:36', NULL, NULL, '+2349167131893', NULL, NULL, NULL, 'REF69', 0.00, '2026-06-27 00:14:36', 'none'),
(70, 'luvvylizzy@gmail.com', '$2y$10$AfJbiGQ2nfiv.SQuGULklO66c8II6tUA3uTtkMihqNaTHHPkeZORm', 'Elizabeth Agbali', 'user', 1, 1, 0, '2026-06-23 07:20:57', '2026-06-27 00:14:36', NULL, NULL, '+2348100304944', NULL, 'REF61', 61, 'REF70', 0.00, '2026-06-27 00:14:36', 'none'),
(71, 'marcelinendifor@gmail.com', '$2y$10$XXvJlBzRMuCLh1ErhLpY5ezQz7I1PO6mGApgXQ4pZpUfTJ2PBnqn2', 'Marceline Ndifor', 'user', 1, 1, 0, '2026-06-23 15:01:55', '2026-06-27 12:43:10', NULL, NULL, NULL, NULL, 'REF61', 61, 'REF71', 10.00, '2026-06-27 12:43:10', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `user_investments`
--

CREATE TABLE `user_investments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `duration_days` int(10) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `status` enum('active','paused','completed','cancelled','liquidated') NOT NULL DEFAULT 'active',
  `last_earnings_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_investments`
--

INSERT INTO `user_investments` (`id`, `user_id`, `plan_id`, `amount`, `duration_days`, `start_date`, `status`, `last_earnings_at`, `created_at`) VALUES
(5, 9, 1, 1200.00, NULL, '2025-12-15', 'cancelled', '2026-02-17 21:59:03', '2026-02-15 14:50:08'),
(6, 9, 2, 25000.00, NULL, '2026-02-01', 'cancelled', NULL, '2026-02-15 14:50:08'),
(7, 9, 1, 599.00, 45, '2026-02-17', 'cancelled', '2026-02-17 21:59:03', '2026-02-17 01:00:09'),
(11, 50, 3, 11000.00, 10, '2026-02-20', 'completed', '2026-03-02 00:00:00', '2026-02-20 10:25:45'),
(12, 53, 2, 2085.00, 7, '2026-02-28', 'cancelled', '2026-03-06 09:00:00', '2026-02-28 13:29:29'),
(13, 54, 2, 710.93, 7, '2026-03-01', 'cancelled', '2026-03-07 09:00:00', '2026-03-01 09:06:22'),
(14, 55, 1, 500.00, 6, '2026-03-02', 'active', '2026-03-07 09:00:00', '2026-03-02 21:57:15'),
(15, 50, 3, 11000.00, 10, '2026-03-03', 'active', '2026-03-12 09:00:00', '2026-03-03 08:02:08'),
(16, 52, 2, 3000.00, 7, '2026-03-05', 'cancelled', '2026-03-11 09:00:00', '2026-03-05 00:14:32'),
(17, 53, 2, 3072.26, 7, '2026-03-09', 'cancelled', '2026-03-15 09:00:00', '2026-03-09 23:21:42'),
(18, 54, 2, 1034.40, 7, '2026-03-12', 'cancelled', '2026-03-18 09:00:00', '2026-03-12 13:08:30'),
(19, 53, 2, 4270.00, 7, '2026-03-17', 'cancelled', NULL, '2026-03-17 17:18:50'),
(20, 54, 2, 1437.81, 7, '2026-03-25', 'active', '2026-03-31 09:00:00', '2026-03-25 18:57:56'),
(21, 53, 2, 4270.00, 7, '2026-03-26', 'cancelled', '2026-04-01 09:00:00', '2026-03-26 17:20:32'),
(22, 54, 1, 560.75, 6, '2026-04-04', 'active', '2026-04-09 09:00:00', '2026-04-04 16:10:54'),
(23, 61, 1, 200.00, 6, '2026-06-10', 'cancelled', '2026-06-15 09:00:00', '2026-06-10 16:40:02'),
(24, 52, 3, 6390.00, 10, '2026-06-10', 'cancelled', '2026-06-16 09:00:00', '2026-06-10 17:45:08'),
(25, 61, 1, 200.00, 6, '2026-06-15', 'cancelled', '2026-06-20 09:00:00', '2026-06-15 23:00:34'),
(26, 52, 35, 54019.00, 30, '2026-06-16', 'cancelled', NULL, '2026-06-16 21:56:05'),
(27, 52, 35, 60000.00, 30, '2026-06-17', 'active', '2026-06-26 09:00:00', '2026-06-17 00:13:56'),
(28, 61, 1, 210.00, 6, '2026-06-21', 'cancelled', '2026-06-26 09:00:00', '2026-06-21 15:38:52'),
(29, 71, 1, 200.00, 6, '2026-06-25', 'active', '2026-06-26 09:00:00', '2026-06-25 12:34:15'),
(30, 61, 2, 1000.00, 7, '2026-06-25', 'active', '2026-06-26 09:00:00', '2026-06-25 20:51:10'),
(31, 61, 1, 201.00, 6, '2026-06-26', 'active', NULL, '2026-06-26 10:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_addresses`
--

CREATE TABLE `wallet_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `coin_id` int(10) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_addresses`
--

INSERT INTO `wallet_addresses` (`id`, `coin_id`, `address`, `created_at`) VALUES
(1, 1, 'bc1q75catla8uzsmeq2rzvn6zctwgypzp4dh9zljze', '2026-02-15 23:57:29'),
(2, 2, '0x59d682AA0253e8884F08cf25E29420674dEf26eD', '2026-02-15 23:57:49'),
(3, 3, 'TXSFTYTrTqEb9VDorqb8MHoYFYoVp19nzr', '2026-02-15 23:57:58'),
(4, 4, 'GgQsdK8EWYBZaDWu2pBBEUp3kQB6JpySkVkQ2Uqbdtic', '2026-02-16 00:21:13'),
(5, 5, '0x59d682AA0253e8884F08cf25E29420674dEf26eD', '2026-02-16 00:21:20'),
(7, 15, 'ltc1qywjdl9t4jtk7zsr7sw0e2qhmkwm25yn3svaq2m', '2026-02-16 00:44:41'),
(8, 16, 'qq7754q80c8hmhek47mgcf3860e6j5deqge8uks3wk', '2026-02-16 00:44:57'),
(9, 19, 'TXSFTYTrTqEb9VDorqb8MHoYFYoVp19nzr', '2026-02-16 00:45:09'),
(10, 8, 'DR2Be6KTeiZSnDhMBv6SrV7bp9kSSaqEsU', '2026-02-16 00:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_balances`
--

CREATE TABLE `wallet_balances` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `currency` varchar(20) NOT NULL,
  `amount` decimal(36,18) NOT NULL DEFAULT 0.000000000000000000,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_balances`
--

INSERT INTO `wallet_balances` (`id`, `user_id`, `currency`, `amount`, `updated_at`) VALUES
(9, 9, 'BTC', 0.008792290642575251, '2026-02-21 17:10:14'),
(10, 9, 'ETH', 0.000000000000000000, '2026-02-18 00:34:05'),
(39, 9, 'USD', 0.000000000000000000, '2026-02-18 00:33:26'),
(44, 9, 'USDT', 0.000000000000000000, '2026-02-18 00:33:46'),
(59, 49, 'BTC', 0.080124421024927500, '2026-06-23 11:04:59'),
(60, 50, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(73, 52, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(77, 53, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(81, 54, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(85, 55, 'BTC', 0.000004145343022188, '2026-03-02 21:57:15'),
(87, 49, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(91, 55, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(154, 49, 'SOL', 11.896264572924101444, '2026-03-03 11:26:59'),
(514, 61, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(603, 71, 'USDT', 0.000000000000000000, '2026-06-27 10:37:40'),
(637, 49, 'USD', 121.000000000000000000, '2026-06-27 10:37:40'),
(638, 50, 'USD', 23242.715000000000000220, '2026-06-27 10:37:40'),
(639, 52, 'USD', 158468.250000000000000213, '2026-06-27 10:37:40'),
(640, 53, 'USD', 6270.003379166667000000, '2026-06-27 10:37:40'),
(641, 54, 'USD', 140.193292013888942904, '2026-06-27 10:37:40'),
(642, 55, 'USD', 1207.118055555555555264, '2026-06-27 10:37:40'),
(643, 61, 'USD', 0.299999999999954500, '2026-06-27 10:37:40'),
(644, 71, 'USD', 10.000000000000000000, '2026-06-27 10:37:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_mailbox`
--
ALTER TABLE `admin_mailbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_folder_uid` (`mailbox_folder`,`imap_uid`),
  ADD KEY `idx_direction_created` (`direction`,`created_at`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_message_id` (`message_id`);

--
-- Indexes for table `broadcast_campaigns`
--
ALTER TABLE `broadcast_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coin_key` (`coin_key`),
  ADD KEY `idx_coins_enabled` (`enabled`),
  ADD KEY `idx_coins_sort` (`sort_order`);

--
-- Indexes for table `email_otp_codes`
--
ALTER TABLE `email_otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email_purpose` (`email`,`purpose`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `kyc_submissions`
--
ALTER TABLE `kyc_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kyc_user` (`user_id`),
  ADD KEY `idx_kyc_status` (`status`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_payment_methods_crypto_coin` (`coin_id`),
  ADD KEY `idx_payment_methods_type` (`method_type`),
  ADD KEY `idx_payment_methods_enabled` (`enabled`),
  ADD KEY `idx_payment_methods_coin` (`coin_id`);

--
-- Indexes for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_plans_enabled` (`enabled`),
  ADD KEY `idx_plans_sort` (`sort_order`);

--
-- Indexes for table `referral_earnings`
--
ALTER TABLE `referral_earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_referrer` (`referrer_user_id`),
  ADD KEY `idx_referred` (`referred_user_id`),
  ADD KEY `idx_referred_source` (`referred_user_id`,`source`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_transactions_reference` (`reference`),
  ADD KEY `idx_tx_user` (`user_id`),
  ADD KEY `idx_tx_type` (`type`),
  ADD KEY `idx_tx_status` (`status`),
  ADD KEY `idx_tx_created` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uniq_my_referral_code` (`my_referral_code`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_referred_by` (`referred_by_user_id`);

--
-- Indexes for table `user_investments`
--
ALTER TABLE `user_investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_inv_user` (`user_id`),
  ADD KEY `idx_inv_plan` (`plan_id`),
  ADD KEY `idx_inv_status` (`status`);

--
-- Indexes for table `wallet_addresses`
--
ALTER TABLE `wallet_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_wallet_addresses_coin` (`coin_id`);

--
-- Indexes for table `wallet_balances`
--
ALTER TABLE `wallet_balances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_wallet_user_currency` (`user_id`,`currency`),
  ADD KEY `idx_wallet_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_mailbox`
--
ALTER TABLE `admin_mailbox`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `broadcast_campaigns`
--
ALTER TABLE `broadcast_campaigns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `email_otp_codes`
--
ALTER TABLE `email_otp_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `kyc_submissions`
--
ALTER TABLE `kyc_submissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `referral_earnings`
--
ALTER TABLE `referral_earnings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=703;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user_investments`
--
ALTER TABLE `user_investments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wallet_addresses`
--
ALTER TABLE `wallet_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wallet_balances`
--
ALTER TABLE `wallet_balances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=654;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kyc_submissions`
--
ALTER TABLE `kyc_submissions`
  ADD CONSTRAINT `kyc_submissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_ibfk_1` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `referral_earnings`
--
ALTER TABLE `referral_earnings`
  ADD CONSTRAINT `referral_earnings_ibfk_1` FOREIGN KEY (`referrer_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referral_earnings_ibfk_2` FOREIGN KEY (`referred_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_investments`
--
ALTER TABLE `user_investments`
  ADD CONSTRAINT `user_investments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_investments_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_addresses`
--
ALTER TABLE `wallet_addresses`
  ADD CONSTRAINT `wallet_addresses_ibfk_1` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_balances`
--
ALTER TABLE `wallet_balances`
  ADD CONSTRAINT `wallet_balances_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
