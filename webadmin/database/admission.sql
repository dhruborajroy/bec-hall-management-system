-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 26, 2022 at 06:01 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admission`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_notification` varchar(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phoneNumber`, `password`, `last_notification`, `image`, `status`) VALUES
(1, 'Dhrubo Raj Roy', 'Dhruborajroy3@gmail.com', '01705927257', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `roll` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `class_roll` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `presentAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permanentAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `religion` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthId` text COLLATE utf8_unicode_ci NOT NULL,
  `quota` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bloodGroup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `examRoll` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `merit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `legalGuardianName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `legalGuardianRelation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `final_submit` int(2) NOT NULL,
  `last_notification` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `first_name`, `last_name`, `roll`, `class_roll`, `fName`, `mName`, `phoneNumber`, `presentAddress`, `permanentAddress`, `dob`, `gender`, `religion`, `birthId`, `quota`, `bloodGroup`, `examRoll`, `merit`, `legalGuardianName`, `legalGuardianRelation`, `password`, `email`, `code`, `image`, `final_submit`, `last_notification`, `status`) VALUES
('6327203d06a83', 'Dhruboraj', 'Roy', '228770', '', 'Debendra Nath Roy', 'Malati Roy', '01705927257', 'Adarsopara, Sadar, Lalmonirhat', 'Adarsopara, Sadar, Lalmonirhat', '2022-09-19', 'Male', 'Hinduism', '', 'N/A', 'A+', '228770', '', 'Dhrubo', 'Father', '$2y$10$giMipHwaaI1ohNc3WV0Mx.CXpHfiQQ9jfijs9ydzfMehAIIsEW9Bi', 'Dhruborajroy3@gmail.com', '233034', '1663508541.jpg', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bkash_credentials`
--

CREATE TABLE `bkash_credentials` (
  `id` int(11) NOT NULL,
  `app_key` text NOT NULL,
  `app_secret` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `base_url` text NOT NULL,
  `id_token` text NOT NULL,
  `refresh_token` text NOT NULL,
  `time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bkash_credentials`
--

INSERT INTO `bkash_credentials` (`id`, `app_key`, `app_secret`, `username`, `password`, `base_url`, `id_token`, `refresh_token`, `time`) VALUES
(1, '4f6o0cjiki2rfm34kfdadl1eqq', '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b', 'sandboxTokenizedUser02', 'sandboxTokenizedUser02@12345', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta', 'eyJraWQiOiJvTVJzNU9ZY0wrUnRXQ2o3ZEJtdlc5VDBEcytrckw5M1NzY0VqUzlERXVzPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiJlODNlMDkwMC1jY2ZmLTQzYTctODhiNy0wNjE5NDJkMTVmOTYiLCJhdWQiOiI2cDdhcWVzZmljZTAxazltNWdxZTJhMGlhaCIsImV2ZW50X2lkIjoiNjFlMzViNmItMWU1Ni00MzMzLWEzOGItZDQ5NmJkMTY5MzY0IiwidG9rZW5fdXNlIjoiaWQiLCJhdXRoX3RpbWUiOjE2NjQxNjQ0NDksImlzcyI6Imh0dHBzOlwvXC9jb2duaXRvLWlkcC5hcC1zb3V0aGVhc3QtMS5hbWF6b25hd3MuY29tXC9hcC1zb3V0aGVhc3QtMV9yYTNuUFkzSlMiLCJjb2duaXRvOnVzZXJuYW1lIjoic2FuZGJveFRva2VuaXplZFVzZXIwMiIsImV4cCI6MTY2NDE2ODA0OSwiaWF0IjoxNjY0MTY0NDQ5fQ.EWbwJBkknNeKbIYHRQjbL_REzARomim4Nsrn4O05oyUMQSD1sux1MVgK_IuXo8b3FR3FSkAGZSP12ZEwTaQbgWtcKw0s2CwYumFVo4Mun2frtFKVuQHPlYfQZL6H-HH7Q1qbTTR3w4odLskxwYOXacFlaO48hi245CAD9VoE1lt8HOv3x-8uwKyMPt6rsGD-aOJm3zgFWSDwCBrNEcZHt2V35t-m9P0fONA96yMXN662BoGTlq22esHKOxDpjplbkxoECeov5ML0VDFyCN5tbeYf0OTAJqbqcsIwCKWaul9uJ29cCk1NwFmWKckjD_eNIY8QrQVckF-9N9Gq4A_VVw', 'eyJjdHkiOiJKV1QiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiUlNBLU9BRVAifQ.GyobVV59E6_U4npZiyge-FYXwGENY0_-kj17PXEuASIcAsccAyj7qubzKCO2nJs3VE7HhF83a_5_xKUigVOnE2AihafXrfjZy5Mbxal4IMTCfYJkRD_6P-57BIW2nBhuIDr7CaOOIZiiujpn5T0SX2bnYi_ScFQp90XeoDRRSQA6xREAiUQazau0aTaRZD-SY4-ReZIusGKG8ygBvaZlmpP6HamSzhFdZRxtyoUk-198PRy5oju41TJWVJWizuQZf_OHC_uEooFtkJNMLmkmf2wp_cAdv2XwnhfVZbVA94AHJG03f5DfvD_ZCHH1aU1_sL6YDUZsF5mKUB1L5ohJpA.8_horBA5FasapUsI.yKhQGsQ-QLTNVc4nR9rlrxciUZ3p7M1C285nEBZJ9QzVaWfCOPgxTCYkmVYohFoCf5CsZAX5gpfpD_ZlFCFY9nn-68LgF3uCSvRdamQPp0WAMwZ9T7xmSjZFmA8lN07cxQaIBzbAWNoRdHNok_pkSjCtP2Hbt3aMREwmzQV118w_Cc_iLr2Yio_zM42eicoHGZlicsCAlWRvFTRkzBjPt7FtyF-nTPdYzbVSihcKYp555WVF16QfsUeQPGyfXmSOPQxFX2AY1nXFuzYd8piG7HiqWu1LezzYXu1YGRrwMTNm7ZznT9cMQsTdlJ-0lySQiqaMAw5xhCOT6J1gTSpD-_MHiVELO5KtnjIp7kbZyVjfrzhFdrw64gGZUoyjmQBvG_ITUHdgqbeOzZ9z0b3DOiX2qYUWnmWBmkQJKhmsq5OWbobm-pqIx22GZDj77hEoLf5_xQHSh1YKGHgvUGcm7RST4xkZB5k6KrVS28SP1U35askrUOl0x-2_9pThulQ9yjBgAH0GnQbNWfJz-gqfjhUqb6WrY6kJhUBuFq5rO2EA-8WC9QnNLpLN4t1PBMu-kamytoNmoMJN0fBrw83rnrDf6syyE1LMVZSCex8iVrv22nPy1yqYuB3eUY_4ACp_PU9DmzDAsNF5yK6x3zlK49kWsLiQgcSyM4YcnBW7vQU8Q_HFeLlY236ClFyfQMRgU69Lf79Gyrhh0jv9I1boAebItACGMS3qXTj0d3-BP6S75UoMll6SF4twVLGbPJP8Fi2PvPOkrKu4jaqSg8Fr4xkH_6ephBfPoYgnuyHHmdSANHZRnlYIiLkSH4e5Grp3f7eISueh0XkJjQsDW2nmLMca1JkhAI3ocDV-lKZGICz-bE6KOs1OCTM4of2VXjxu9lhdW0d2-ht7d-F3i7W61CD39ZKor99auADCsCGTaqorBc_V47FXg2SYx_WcNeUgOaF8-Cvx5QagayZqX0zJ3Q-DULetzODxYSm3EAyFN7ThuA32S_8eZvsD6YVd9dE_Q-Ok1o29mBjnf7baZToFnOaqJI6weCLgbgmLPnjJu5FCMWJNsNeo9qOGVW4O5eC0KyuefyXLlpxLwxVCDXmNvoEU5djXshCGuZTEqh_pw-OlotNm6Uq7WCwsJLGaQSytTCsBSildXsUriVtCWE2D-QFGLB3gaVsDwEukXp7YL_b3jIjBJgRshEDlUEOIY-2OXv8L-JZB5LUJ0zUr_gUeDnB9FZciiWiLRYgFy7cOvy30mmZhTzXgfoGYTHfjnrqwy_64AL3cEyN7U_KD2Y7QndsN9A9SsYfpUydT1yU3i5nnM43C8nc.0tfaqAIt9gP0dpnzVKdHyQ', '1664164474');

-- --------------------------------------------------------

--
-- Table structure for table `bkash_online_payment`
--

CREATE TABLE `bkash_online_payment` (
  `id` int(11) NOT NULL,
  `tran_id` varchar(50) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `bkash_payment_id` varchar(100) NOT NULL,
  `customerMsisdn` varchar(20) NOT NULL,
  `trxID` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `statusMessage` varchar(50) NOT NULL,
  `added_on` varchar(50) NOT NULL,
  `updated_on` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bkash_online_payment`
--

INSERT INTO `bkash_online_payment` (`id`, `tran_id`, `user_id`, `bkash_payment_id`, `customerMsisdn`, `trxID`, `amount`, `statusMessage`, `added_on`, `updated_on`, `status`) VALUES
(1, 'admission_632fcff8550d2', '6327203d06a83', 'TR0011E41664077793331', '', '', 24, '', '2022-09-25T09:49:53:766 GMT+0600', '', 'pending'),
(2, 'admission_632fd01934427', '6327203d06a83', 'TR0011V31664077826206', '01770618575', '9IP207V31A', 124, 'Successful', '2022-09-25T09:50:26:486 GMT+0600', '1664077882', 'Completed'),
(3, 'admission_632fd528468e0', '6327203d06a83', 'TR0011LK1664079130890', '01770618575', '9IP507V32R', 124, 'Successful', '2022-09-25T10:12:16:183 GMT+0600', '1664079256', 'Completed'),
(4, 'admission_632fd57e7e055', '6327203d06a83', 'TR0011VS1664079208209', '', '', 124, 'Duplicate for All Transactions', '2022-09-25T10:13:28:683 GMT+0600', '1664079305', 'Duplicate'),
(5, 'admission_632fd61195ad9', '6327203d06a83', 'TR0011N61664079354701', '01770618575', '9IP107V32X', 124, 'Successful', '2022-09-25T10:15:55:078 GMT+0600', '1664079399', 'Completed'),
(6, 'admission_632fd63145aee', '6327203d06a83', 'TR0011GH1664079386376', '', '', 124, 'OTP was not valid', '2022-09-25T10:16:26:663 GMT+0600', '1664079439', 'failure'),
(7, 'admission_632fd64c0f3cb', '6327203d06a83', 'TR0011SN1664079413024', '', '', 124, 'Payment canceled by user.', '2022-09-25T10:16:53:152 GMT+0600', '1664079558', 'cancel'),
(8, 'admission_6331227b81311', '6327203d06a83', 'TR00118I1664164459342', '', '', 124, 'OTP was not valid', '2022-09-26T09:54:24:699 GMT+0600', '1664164691', 'failure'),
(9, 'admission_633123562d7dd', '6327203d06a83', 'TR00117J1664164668729', '', '', 124, 'Payment canceled by user.', '2022-09-26T09:57:49:220 GMT+0600', '1664164730', 'cancel');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `reference` text NOT NULL,
  `added_on` varchar(20) NOT NULL,
  `updated_on` varchar(20) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`id`, `title`, `details`, `reference`, `added_on`, `updated_on`, `user_id`, `status`) VALUES
('630078a5ef84d', 'Vacation!', 'All activities of Oporajeyo Ekattor Hall will be on hold from 01/10/2022 to 10/10/2022 Due to Durgapuja. From 11/10/2022 , all activities will continue as before.', 'বইক/ছাত্রাবাস/২০২২-০৯', '1660975269', '1661542138', '1', 1),
('630079a47c1b9', 'Appointment of new Meal Manager', '<p>New Meal Manager&nbsp;</p><figure class=\"table\"><table><tbody><tr><td>Name</td><td>Roll</td></tr><tr><td>Dhrubo</td><td>200130</td></tr></tbody></table></figure>', 'বইক/ছাত্রাবাস/২০২২-০৮', '1660975524', '1661542338', '1', 1),
('63090b99ae3c4', 'দূর্গাপূজা', 'আগামী ১ অক্টোবর থেকে ১০অক্টোবর দূর্গাপূজা উপলক্ষে হলের সকল কার্যক্রম বন্ধ থাকবে। ১১ অক্টোবর হতে পুনরায় সকল কার্যক্রম অব্যাহত থাকিবে।\r\n', '01', '1661537177', '1661539974', '', 1),
('63090c3006496', 'খাবারের নোটিশ  ', 'আগামী কাল মিলের সময় সূচী\r\nদুপুর _ ২-৩ টা\r\nরাত_৯-১০টা', '02', '1661537328', '', '', 1),
('630927ffd7a88', 'শীতকালীন অবকাশ ', '<ol><li>আগামী ১ ডিসেম্বর থেকে ১২ ডিসেম্বর পর্যন্ত হলের সকল কার্যক্রম বন্ধ থাকবে।</li><li>১৩ ডিসেম্বর থেকে সকল কার্যক্রম পুনরায় অব্যাহত থাকবে।</li></ol>', '05', '1661544447', '', '1', 1),
('630b408d4a4b4', 'Title', '<p>Demo</p>', 'বইক/ছাত্রাবাস/২০২২-০৮', '1661681805', '', '1', 1),
('631b45772386f', 'sdfwekfn', '<p>wdfihio</p><ol><li>week</li><li>jwefh</li><li>efvn</li></ol>', 'sdjbsdj', '1662731639', '', '1', 1),
('6322f7a195081', 'ষ', '<p><i>গসকসকসকসকসহ</i></p>', 'হ ০১', '1663236001', '', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `online_payment`
--

CREATE TABLE `online_payment` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tran_id` varchar(30) NOT NULL,
  `val_id` varchar(50) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `tran_date` varchar(20) NOT NULL,
  `card_issuer` varchar(50) NOT NULL,
  `card_no` varchar(80) NOT NULL,
  `error` varchar(255) NOT NULL,
  `added_on` varchar(11) NOT NULL,
  `updated_on` varchar(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_payment`
--

INSERT INTO `online_payment` (`id`, `user_id`, `tran_id`, `val_id`, `amount`, `card_type`, `tran_date`, `card_issuer`, `card_no`, `error`, `added_on`, `updated_on`, `status`) VALUES
('admission_632723ae57d82', '6327203d06a83', 'admission_632723ae0a037', '2209181959201mOHBpYqMI8SLyt', '122.00', 'ABBANKIB-AB Bank', '2022-09-18 19:59:14', 'AB Bank Limited', '', '', '1663509422', '1663509433', 'VALID'),
('admission_632723c1df582', '6327203d06a83', 'admission_632723c145331', '', '122.00', '', '2022-09-18 19:59:33', 'Bank Asia Limited', '', 'Invalid expiration date', '1663509441', '1663509455', 'FAILED'),
('admission_632832a9bbea2', '6327203d06a83', 'admission_632832a97f447', '220919151905lwuUsYPWZrbDfbP', '122.00', 'NAGAD-Nagad', '2022-09-19 15:15:23', 'Nagad', '', '', '1663578793', '1663579019', 'VALID'),
('admission_632876a9b2db4', '6327203d06a83', 'admission_632876a8c2a81', '220919200538eyGYY1fur5hEEID', '122.00', 'ABBANKIB-AB Bank', '2022-09-19 20:05:31', 'AB Bank Limited', '', '', '1663596201', '1663596213', 'VALID'),
('admission_63287765887af', '6327203d06a83', 'admission_632877652af55', '220919200848VztSSwiu4wv5OOF', '122.00', 'BKASH-BKash', '2022-09-19 20:08:39', 'BKash Mobile Banking', '', '', '1663596389', '1663596403', 'VALID'),
('admission_63288ed655b61', '6327203d06a83', 'admission_63288ed61c010', '22091921485411Fayd9TCqmrlSK', '122.00', 'BKASH-BKash', '2022-09-19 21:48:39', 'BKash Mobile Banking', '', '', '1663602390', '1663602409', 'VALID'),
('admission_632c399e924c1', '6327203d06a83', 'admission_632c399e4f18e', '2209221634130lVAX0R6Q96pM7h', '122.00', 'BKASH-BKash', '2022-09-22 16:34:01', 'BKash Mobile Banking', '', '', '1663842718', '1663842734', 'VALID');

-- --------------------------------------------------------

--
-- Table structure for table `refund_payment`
--

CREATE TABLE `refund_payment` (
  `id` int(11) NOT NULL,
  `statusMessage` varchar(20) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `tran_id` varchar(50) NOT NULL,
  `originalTrxID` varchar(20) NOT NULL,
  `refundTrxID` varchar(20) NOT NULL,
  `transactionStatus` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `completedTime` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `refund_payment`
--

INSERT INTO `refund_payment` (`id`, `statusMessage`, `user_id`, `tran_id`, `originalTrxID`, `refundTrxID`, `transactionStatus`, `amount`, `completedTime`) VALUES
(1, 'Successful', '6327203d06a83', 'admission_632c4f615fcc4', '9IM507UBXJ', '9IN007UY8Q', 'Completed', '100', '1663874387'),
(2, 'Successful', '6327203d06a8', 'admission_632d1e52e34cf', '9IN807UY9S', '9IN007UY9U', 'Completed', '100', '1663901992'),
(3, 'Successful', '', 'admission_632d9dc869def', '9IN407V0DS', '9IO207V0G8', 'Completed', '20', '1663991610'),
(4, 'Successful', '', 'admission_632fd01934427', '9IP207V31A', '9IP607V328', 'Completed', '100', '1664078923');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sub_code` varchar(50) NOT NULL,
  `full_mark` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `sub_code`, `full_mark`, `status`) VALUES
(1, 'Bangla', 'BAN 101', '100', 1),
(2, 'Bangla', 'BAN 101', '100', 1),
(3, 'English', 'EN 101', '100', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bkash_credentials`
--
ALTER TABLE `bkash_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bkash_online_payment`
--
ALTER TABLE `bkash_online_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `refund_payment`
--
ALTER TABLE `refund_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
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
-- AUTO_INCREMENT for table `bkash_credentials`
--
ALTER TABLE `bkash_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bkash_online_payment`
--
ALTER TABLE `bkash_online_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `refund_payment`
--
ALTER TABLE `refund_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
