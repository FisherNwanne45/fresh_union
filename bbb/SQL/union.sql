-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2023 at 10:36 AM
-- Server version: 5.7.42-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcanxeig_Union`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `adminimage` text COLLATE utf8_unicode_ci,
  `admin_email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 
--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `adminimage`, `admin_email`, `admin_password`) VALUES
(1, 'Ofofonobs', 'Developer', 'user.png', 'support@dirtyscripts.shop', '$2y$10$GvESYvpe6vYllRs5GvquiOCieanLtQIFp2cc4mT/fFc.DHmyKAv5O');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `seria_key` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_number` text COLLATE utf8_unicode_ci NOT NULL,
  `card_name` text COLLATE utf8_unicode_ci NOT NULL,
  `card_expiration` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `card_security` text COLLATE utf8_unicode_ci NOT NULL,
  `card_limit` double NOT NULL DEFAULT '5000',
  `card_limit_remain` double NOT NULL DEFAULT '5000',
  `card_status` int(11) DEFAULT '2' COMMENT '1=Active,2=Process,3=hold, 4=PAUSE',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_currency`
--

CREATE TABLE `crypto_currency` (
  `id` int(11) NOT NULL,
  `crypto_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `wallet_address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `crypto_currency`
--

INSERT INTO `crypto_currency` (`id`, `crypto_name`, `wallet_address`, `created_at`) VALUES
(1, 'Bitcoin', 'bc1qz90y4ydmcwzy3fl55rammn5x2cuncxl0d998ld', '2022-11-06 21:58:35'),
(5, 'Etheruem', '0x1A3e0a84031b2F655684473D7FE96072cBb9807E', '2022-11-06 21:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `url_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Name',
  `url_tel` varchar(15) DEFAULT NULL COMMENT 'Company Number',
  `url_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Email',
  `url_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Address',
  `image` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Company Logo',
  `twillio_status` int(11) NOT NULL DEFAULT '0' COMMENT '1=Activate, 0=Disactivate',
  `billing_code` int(11) NOT NULL DEFAULT '0' COMMENT '1=Activate, 0=Disactivate',
  `transfer` int(11) NOT NULL DEFAULT '1' COMMENT '1=Activate, 0=Disactivate',
  `cot_code` int(11) NOT NULL DEFAULT '0' COMMENT '1=Activate, 0=Disactivate',
  `tax_code` int(11) NOT NULL DEFAULT '0' COMMENT '1=Activate, 0=Disactivate',
  `imf_code` int(11) NOT NULL DEFAULT '0' COMMENT '1=Activate, 0=Disactivate',
  `cardfee` text NOT NULL,
  `wirefee` text,
  `domesticfee` text,
  `loanlimit` varchar(255) DEFAULT '1000000',
  `domesticlimit` varchar(255) DEFAULT '50000000',
  `wirelimit` varchar(255) DEFAULT '50000000',
  `currency` varchar(255) DEFAULT '$',
  `stocks` double NOT NULL DEFAULT '10',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `url_name`, `url_tel`, `url_email`, `url_address`, `image`, `twillio_status`, `billing_code`,`transfer`, `cot_code`, `tax_code`, `imf_code`, `cardfee`, `wirefee`, `domesticfee`, `loanlimit`, `domesticlimit`, `wirelimit`, `currency`, `stocks`, `created_at`) VALUES
(1, 'Union Demo Scripts', '2348114313795', 'support@dirtyscripts.shop', '3 Abbey Road, San Francisco CA 94102', 'logo.png', 0, 1,1, 1, 1, 1, '20', '35', '30', '1000000', '50000000', '50000000', '$', 10, '2023-03-28 14:51:33');

-- --------------------------------------------------------
--
-- Table structure for table `smtp_setting`
--

CREATE TABLE `smtp_setting` (
  `id` int(11) NOT NULL,
  `host` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `port` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `smtp_auth` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smtp_setting`
--

INSERT INTO `smtp_setting` (`id`, `host`, `username`, `password`, `port`, `display_name`, `smtp_auth`) VALUES
(1, 'dirtyscripts.shop', 'support@dirtyscripts.shop', 'Password', '465', 'Union Demo Scripts', 'ssl');

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `stock_name` text,
  `stock_price` double DEFAULT NULL,
  `stock_percentage` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `stock_name`, `stock_price`, `stock_percentage`, `created_at`) VALUES
(1, 'Walmat', 289, 7, '2023-03-28 17:53:14'),
(2, 'Starlinks', 782, 1, '2023-03-28 17:53:14'),
(3, 'Facebook', 592, 3, '2023-03-28 17:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `temp_trans`
--

CREATE TABLE `temp_trans` (
  `trans_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `account_number` text COLLATE utf8_unicode_ci,
  `account_name` text COLLATE utf8_unicode_ci,
  `bank_name` text COLLATE utf8_unicode_ci,
  `routine_number` text COLLATE utf8_unicode_ci,
  `account_type` text COLLATE utf8_unicode_ci,
  `swift_code` text COLLATE utf8_unicode_ci,
  `bank_country` text COLLATE utf8_unicode_ci,
  `trans_type` text COLLATE utf8_unicode_ci,
  `transaction_type` text COLLATE utf8_unicode_ci,
  `refrence_id` text COLLATE utf8_unicode_ci,
  `trans_status` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_message` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `trans_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crypto_id` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `account_number` text COLLATE utf8_unicode_ci,
  `account_name` text COLLATE utf8_unicode_ci,
  `bank_name` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `routine_number` text COLLATE utf8_unicode_ci,
  `account_type` text COLLATE utf8_unicode_ci,
  `swift_code` text COLLATE utf8_unicode_ci,
  `bank_country` text COLLATE utf8_unicode_ci,
  `trans_type` text COLLATE utf8_unicode_ci,
  `transaction_type` text COLLATE utf8_unicode_ci,
  `refrence_id` text COLLATE utf8_unicode_ci,
  `image` text COLLATE utf8_unicode_ci,
  `trans_status` text COLLATE utf8_unicode_ci COMMENT 'completed, pending, processing, failed.',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acct_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'user.png',
  `acct_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acct_type` text COLLATE utf8_unicode_ci,
  `acct_currency` varchar(55) DEFAULT '$',
  `acct_balance` double DEFAULT '0',
  `loan_balance` double DEFAULT '0',
  `limit_remain` double DEFAULT '500000',
  `acct_status` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'hold' COMMENT 'active, hold',
  `acct_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acct_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acct_gender` text COLLATE utf8_unicode_ci,
  `acct_dob` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` text COLLATE utf8_unicode_ci,
  `state` text COLLATE utf8_unicode_ci,
  `acct_address` text COLLATE utf8_unicode_ci,
  `acct_password` text COLLATE utf8_unicode_ci,
  `resettoken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resettokenexp` date DEFAULT NULL,
  `billing_code` int(55) DEFAULT 0,
  `transfer` int(55) DEFAULT 1,  
  `acct_pin` varchar(4) COLLATE utf8_unicode_ci DEFAULT '1234',
  `acct_otp` int(11) DEFAULT NULL,
  `acct_cot` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1234',
  `acct_imf` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1234',
  `acct_tax` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1234',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `developer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '''Ofofonobs''',
  `Developer_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT '''2348114313795'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `acct_image`, `acct_no`, `acct_type`, `acct_currency`, `acct_balance`, `loan_balance`, `limit_remain`, `acct_status`, `acct_email`, `acct_phone`, `acct_gender`, `acct_dob`, `zipcode`, `state`, `acct_address`, `acct_password`, `resettoken`, `resettokenexp`, `billing_code`,`transfer`, `acct_pin`, `acct_otp`, `acct_cot`, `acct_imf`, `acct_tax`, `createdAt`, `developer_name`, `Developer_phone`) VALUES
(1, 'Ofofonobs', 'Developer', 'user.png', '3000615625', 'Savings', '$', 19277, 789, 500000, 'active', 'ofofonobs@gmail.com', '2348114313795', 'Male', '1997-08-06', '10001', 'Ibadan', '54, Old Ife Road', '$2y$10$GvESYvpe6vYllRs5GvquiOCieanLtQIFp2cc4mT/fFc.DHmyKAv5O', NULL, NULL, 0, 1, '1234', 8768, '1234', '1234', '1234', '2023-06-07 10:24:46', '\'Ofofonobs\'', '\'2348114313795\'');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_currency`
--
ALTER TABLE `crypto_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);
--
-- Indexes for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_trans`
--
ALTER TABLE `temp_trans`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crypto_currency`
--
ALTER TABLE `crypto_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_trans`
--
ALTER TABLE `temp_trans`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
