-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2025 at 11:05 AM
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
-- Database: `bec_hall`
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
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `numaric_value` int(5) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `name`, `numaric_value`, `status`) VALUES
(1, '04 ', 4, 1),
(2, '03', 3, 1),
(3, '05', 5, 1),
(4, '01', 1, 1),
(5, '02', 2, 1),
(6, '06', 6, 1),
(7, '07', 7, 1);

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
(1, '4f6o0cjiki2rfm34kfdadl1eqq', '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b', 'sandboxTokenizedUser02', 'sandboxTokenizedUser02@12345', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta', 'eyJraWQiOiJvTVJzNU9ZY0wrUnRXQ2o3ZEJtdlc5VDBEcytrckw5M1NzY0VqUzlERXVzPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiJlODNlMDkwMC1jY2ZmLTQzYTctODhiNy0wNjE5NDJkMTVmOTYiLCJhdWQiOiI2cDdhcWVzZmljZTAxazltNWdxZTJhMGlhaCIsImV2ZW50X2lkIjoiMzU5YzFkMGEtOTc1Ny00MTc5LWEwNWQtZTAwYzYxNjQ3ZWViIiwidG9rZW5fdXNlIjoiaWQiLCJhdXRoX3RpbWUiOjE3NjMwOTk0ODksImlzcyI6Imh0dHBzOlwvXC9jb2duaXRvLWlkcC5hcC1zb3V0aGVhc3QtMS5hbWF6b25hd3MuY29tXC9hcC1zb3V0aGVhc3QtMV9yYTNuUFkzSlMiLCJjb2duaXRvOnVzZXJuYW1lIjoic2FuZGJveFRva2VuaXplZFVzZXIwMiIsImV4cCI6MTc2MzEwMzA4OSwiaWF0IjoxNzYzMDk5NDg5fQ.R8jp8zDWOivIxR9uH9h2bVlo81ilWDtYHOLdS_tbGqwxOsa1K3SO0ShX8qSrfuCHyX25F5xYwEwBYuDXxeQ1nEtcSgl5JsFiXBDCJDtRipx_n3OAuYexG8RhhNrnQT3gfZXYtd2uMm-hFkW8VWznu47sBQ9ZfNziuykcD6Gq_1VKzY-VhvAzTJZ9OEI0_x1kugvD3cXtR8pul8YxINaAV8izeE7LIESuXqiqwG-ZXu3XIyXsRYtj-ZaCQ4wf9qWqlE0j3ap-RyPixdImhPuOBl-OSpU6N40R3e19rKlzC_Jn111lFeuj9dpqgqc8hw_NCKOXy32uVsIKDXOJZ4wqfw', 'eyJjdHkiOiJKV1QiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiUlNBLU9BRVAifQ.d1qmqrPYpsYbqNLv_4jkBgrWDDO1ijx-xpw3k9w-Sg0vKy4JzEfk3S41vN-Kr52DDjKy6E5xIlg088nxSUtRd4kg9Q-mKKIw--INbBpvPBC0MkZjWTvOAOHWT3tvyu7_p4q7bmKdkwBLt2tPHAtUqWNwVZ2Gxfg1sSpl276aOSZn6due5NqyuaLbpxvNO6xVjd-pXHcS40QnQM6T9EgzcAHGtuFsy1DECwrJLTE1oVK4uoLguZoTnsW-xDW-dExSRUkQp2zWTzhGKFAC6Vaw-JfHX-qQdonPpRMS9vtwa9bZxYOT3BM3NgppoyYfPhA8SE5ZmhcLddoDoVXhda_cew.v1K5Se0tuIohRsjw.dadJVx-kEM9Sb_qAGD6oD3jiQz0_gNax0rF7iFzjQip77XYDlbtdNHO-n7GbOJYAZ7i7fToNmPjlg0whXHuXBrx8CuwpVxCNQnUC0WOheWDGrQ8afWvkzi2wQyIDZPzpbnAllRI9z_ExtvoLli5Pq1tiKAQWfK1cycc6A0FehUw19BTWAxVXTYOSaevlHfbJE-UW2jLjHcS82bk8uzv2BQ2CYdGHDn1A6l783zJRO4l_EN7raZf9mfScotBHELPsAAnQGuczR2WIHnSqKD4jiOCjvZNdGzi8xotayNCF8ggnMC8pfmPMKmDxYabyhZpym2aSce8PD8rWAyUM9oPaN0FCheRoU3RERjrW6optAor1mtKWXt_MW0fRmBxqII8sBedNX-QNOfupMOxXUDlTiVhNoTxDkLLh38yp3eLGM0PlzCyhXMYRTOPwNyU1hJozLAqUIC6z-cVfUbn5I9U-mbBMubHsv6yBAIgBdsB5vFPiBVETUHZy06-J4mitp-ZwnCb9sWwh2XtjxoDm7zxpqAEH4nRLKbsreSXcmVsioUzp6jkVTlfpo_beJPG7PujqUjimaQM131nUDsiSu3htEWiA-YK33zPRf8BA-SJiaY7L6O9J9o3rjBOjsnmYQqET930SDbBdu1lve3s4cy4MqvsoZUCxsrcUzGsWEtt1XecZFrHYKMUtszqZsiPWm2FBtGTWeLA4is8G79DOE9HDS2AByh3yK_gGZrBo7gw0H-FBIWSQTSxbo85qh152iypIRM2YW65krrw-Kk1JDkTxFKfbBMJsCr-0xmsJig25_cEXC495Jipxcf_q-fjyb2nQHRnZ5tFH8InEIejn8rjV_SIQGhG4NY7D8SFEdBMITOYctMWesaV_onPefK52FOJhPDwrFEfFhvUdXPs7FCMd1p20wj4cEtxNcqF2KJRdqDHMgg4qVzhbzReiLHrzw_i03reffHnNO-PH1uxQvLe8ODoR9gEJzQ-rbY2fr7jFFzjclTLTGEqzhgtErG9VEWpo-ivXKzn8HQCO_A-ZrCoSMu5Hw8mgErnKzQIqGa56hL_5mVbF-HWwbSYlg2HVkwx2mOwNsqa-MX8yP4RmxNFFkQ-dPYIvvwg87OMFaty9-bNmktQiHZ-vckgVnWshrm9wjeYugiVQtVIS9QSoil54EUumMOGkqtGH2rvHjBR9rNiKlodFDJmRocfF4G4qiE47dXQ2Ayj0J_U0RSFdeOtT2EUcI6tBa4YSPNNMjSu1lPNnfGcguVXXW0uyAy1Q7VaNMR1trKLCkmErwbgQ_c4QYs2vj4EipMZ4RSZQly2XrZ2d5P46BMI.G5EZ1x3ZvljNCKoyh5JbIg', '1763099489');

-- --------------------------------------------------------

--
-- Table structure for table `bkash_online_payment`
--

CREATE TABLE `bkash_online_payment` (
  `id` int(11) NOT NULL,
  `tran_id` varchar(50) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `month_id` varchar(5) NOT NULL,
  `bkash_payment_id` varchar(100) NOT NULL,
  `customerMsisdn` varchar(20) NOT NULL,
  `trxID` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `bkash_charge` int(5) NOT NULL,
  `statusMessage` varchar(50) NOT NULL,
  `added_on` varchar(50) NOT NULL,
  `updated_on` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bkash_online_payment`
--

INSERT INTO `bkash_online_payment` (`id`, `tran_id`, `user_id`, `month_id`, `bkash_payment_id`, `customerMsisdn`, `trxID`, `amount`, `bkash_charge`, `statusMessage`, `added_on`, `updated_on`, `status`) VALUES
(1, '6914a78693b3f', '6914a78693b66', '10', 'TR0011ufxtB1M1762961286914', '01929918378', 'CKC00NTL7A', 1683, 30, 'Successful', '2025-11-12T21:28:06:914 GMT+0600', '1762961313', 'Completed'),
(2, '6916c361df4a6', '6916c361df81c', '11', 'TR0011Hr2agnK1763099490222', '', '', 927, 16, 'Payment canceled by user.', '2025-11-14T11:51:30:222 GMT+0600', '1763099495', 'cancel');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_box`
--

CREATE TABLE `complaint_box` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(10) NOT NULL,
  `added_on` varchar(11) NOT NULL,
  `updated_on` varchar(11) NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaint_box`
--

INSERT INTO `complaint_box` (`id`, `content`, `user_id`, `category_id`, `added_on`, `updated_on`, `status`) VALUES
(1, '<blockquote><ol><li>akdnc</li></ol></blockquote><p>&nbsp;</p>', 1, 2, '1661872912', '1661873339', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contingency_fee_details`
--

CREATE TABLE `contingency_fee_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `contingency_amount` decimal(10,2) NOT NULL,
  `added_on` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contingency_fee_details`
--

INSERT INTO `contingency_fee_details` (`id`, `user_id`, `payment_id`, `month_id`, `contingency_amount`, `added_on`, `status`) VALUES
(1, 21, 1, 10, '300.00', 1762961313, 1),
(2, 20, 2, 10, '300.00', 1762962613, 1);

-- --------------------------------------------------------

--
-- Table structure for table `depts_lab_list`
--

CREATE TABLE `depts_lab_list` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `name_bn` text NOT NULL,
  `short_form` varchar(20) NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `depts_lab_list`
--

INSERT INTO `depts_lab_list` (`id`, `name`, `name_bn`, `short_form`, `status`) VALUES
(1, 'Civil Engineering', 'সিভিল ইঞ্জিনিয়ারিং', 'CE', 1),
(2, 'Electrical and Electronics Engineering', 'ইলেকট্রিক্যাল এন্ড ইলেকট্রনিক ইঞ্জিনিয়ারিং', 'EEE', 1),
(3, 'Naval Architecture & Marine Engineering ', 'নেভাল আর্কিটেকচার এন্ড মেরিন ইঞ্জিনিয়ারিং', 'NAME ', 1),
(4, 'General Science & Humanities', 'জেনারেল সায়েন্স এন্ড হিউম্যানিটিস\r\n', 'GSH', 1),
(5, 'Hostels', 'হোস্টেল সুপার', 'HS', 1),
(6, 'Cenreal Computer Center', 'সেন্ট্রাল কম্পিউটার সেন্টার', 'CCC', 1),
(7, 'Office', 'অফিস', 'Office', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `date` varchar(15) NOT NULL,
  `date_id` varchar(5) NOT NULL,
  `month` varchar(5) NOT NULL,
  `year` varchar(5) NOT NULL,
  `amount` varchar(11) NOT NULL,
  `expense_category_id` varchar(10) NOT NULL,
  `added_on` varchar(11) NOT NULL,
  `updated_on` varchar(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`id`, `name`, `status`) VALUES
(1, 'চাল', 1),
(2, 'বাজার', 1),
(3, 'ডাল', 1),
(4, 'কর্মচারী বেতন', 1),
(5, 'Decoration ', 1),
(6, 'NAME', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` varchar(11) NOT NULL,
  `every_month` varchar(3) NOT NULL,
  `show_payment_page` varchar(3) NOT NULL,
  `status` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `name`, `amount`, `every_month`, `show_payment_page`, `status`) VALUES
(1, 'Admission Fee', '5500', '0', '0', '1'),
(2, 'Contingency ', '300', '0', '1', '1'),
(3, 'Seat Range', '60', '0', '1', '1'),
(4, 'Electricity ', '10', '0', '0', '1'),
(6, 'id card', '150', '1', '0', '1'),
(7, 'Electricity ', '10', '0', '1', '1'),
(8, 'Examination FEE', '100', '0', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `fee_details`
--

CREATE TABLE `fee_details` (
  `id` int(11) NOT NULL,
  `user_id` varchar(5) NOT NULL,
  `payment_id` varchar(5) NOT NULL,
  `fee_id` varchar(11) NOT NULL,
  `fee_amount` varchar(11) NOT NULL,
  `added_on` varchar(20) NOT NULL,
  `status` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `general_informations`
--

CREATE TABLE `general_informations` (
  `id` int(11) NOT NULL,
  `last_bill_generated` varchar(20) NOT NULL,
  `fee_added` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `general_informations`
--

INSERT INTO `general_informations` (`id`, `last_bill_generated`, `fee_added`, `status`) VALUES
(1, '1724227453', 1724765216, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab_list`
--

CREATE TABLE `lab_list` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `name_bn` text NOT NULL,
  `dept_id` varchar(20) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_list`
--

INSERT INTO `lab_list` (`id`, `name`, `name_bn`, `dept_id`, `status`) VALUES
(1, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '1', 1),
(2, 'Structural Engineering Labratory', ' ', '1', 1),
(3, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '2', 1),
(4, 'Structural Engineering Labratory', ' ', '2', 1),
(5, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '2', 1),
(6, 'Structural Engineering Labratory', ' ', '2', 1),
(7, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '6', 1),
(8, 'Structural Engineering Labratory', ' ', '3', 1),
(9, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '4', 1),
(10, 'Structural Engineering Labratory', ' ', '3', 1),
(11, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '5', 1),
(12, 'Structural Engineering Labratory', ' ', '6', 1),
(13, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '7', 1),
(14, 'Structural Engineering Labratory', ' ', '2', 1),
(15, 'Geo-Technical Engineeirng Labratory', 'জিওটেক ', '7', 1),
(16, 'Structural Engineering Labratory', ' ', '4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meal_on_off_requests`
--

CREATE TABLE `meal_on_off_requests` (
  `id` int(11) NOT NULL,
  `user_id` varchar(5) NOT NULL,
  `date` varchar(15) NOT NULL,
  `status` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meal_table`
--

CREATE TABLE `meal_table` (
  `id` int(11) NOT NULL,
  `roll` varchar(8) NOT NULL,
  `meal_value` int(5) NOT NULL,
  `date_id` varchar(5) NOT NULL,
  `month_id` varchar(5) NOT NULL,
  `year` varchar(5) NOT NULL,
  `added_on` varchar(10) NOT NULL,
  `updated_on` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

CREATE TABLE `month` (
  `id` int(11) NOT NULL,
  `value` varchar(2) NOT NULL,
  `name` varchar(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`id`, `value`, `name`, `status`) VALUES
(1, '01', 'January', 1),
(2, '02', 'February', 1),
(3, '03', 'March', 1),
(4, '04', 'April', 1),
(5, '05', 'May', 1),
(6, '06', 'June', 1),
(7, '07', 'July', 1),
(8, '08', 'August', 1),
(9, '09', 'September', 1),
(10, '10', 'October', 1),
(11, '11', 'November', 1),
(12, '12', 'December', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_bill`
--

CREATE TABLE `monthly_bill` (
  `id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `month_id` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `paid_status` varchar(10) NOT NULL,
  `added_on` varchar(10) NOT NULL,
  `updated_on` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `monthly_bill`
--

INSERT INTO `monthly_bill` (`id`, `amount`, `user_id`, `month_id`, `year`, `paid_status`, `added_on`, `updated_on`, `status`) VALUES
(1, '2443', '24', '10', '2025', '0', '1762713470', '', 1),
(2, '2354', '23', '10', '2025', '0', '1762713470', '', 1),
(3, '2333', '22', '10', '2025', '0', '1762713470', '', 1),
(4, '1243', '21', '10', '2025', '1', '1762713470', '', 1),
(5, '4313', '20', '10', '2025', '1', '1762713470', '', 1),
(6, '1232', '19', '10', '2025', '0', '1762713470', '', 1),
(7, '3211', '18', '10', '2025', '0', '1762713470', '', 1),
(8, '3212', '17', '10', '2025', '0', '1762713470', '', 1),
(9, '3212', '16', '10', '2025', '0', '1762713470', '', 1),
(10, '3212', '15', '10', '2025', '0', '1762713470', '', 1),
(11, '3212', '14', '10', '2025', '0', '1762713470', '', 1),
(12, '3212', '13', '10', '2025', '0', '1762713470', '', 1),
(13, '3212', '12', '10', '2025', '0', '1762713470', '', 1),
(14, '3212', '11', '10', '2025', '0', '1762713470', '', 1),
(15, '3212', '10', '10', '2025', '0', '1762713470', '', 1),
(16, '3212', '9', '10', '2025', '0', '1762713470', '', 1),
(17, '3212', '8', '10', '2025', '0', '1762713470', '', 1),
(18, '3212', '7', '10', '2025', '0', '1762713470', '', 1),
(19, '3212', '6', '10', '2025', '0', '1762713470', '', 1),
(20, '3212', '5', '10', '2025', '0', '1762713470', '', 1),
(21, '3212', '4', '10', '2025', '0', '1762713470', '', 1),
(22, '3212', '3', '10', '2025', '0', '1762713470', '', 1),
(23, '3212', '2', '10', '2025', '0', '1762713470', '', 1),
(24, '3212', '1', '10', '2025', '0', '1762713470', '', 1),
(25, '1245', '24', '11', '2025', '0', '1762962549', '', 1),
(26, '2352', '23', '11', '2025', '0', '1762962549', '', 1),
(27, '2353', '22', '11', '2025', '0', '1762962549', '', 1),
(28, '500', '21', '11', '2025', '0', '1762962549', '', 1),
(29, '1220', '20', '11', '2025', '0', '1762962549', '', 1),
(30, '1223', '19', '11', '2025', '0', '1762962549', '', 1),
(31, '3123', '18', '11', '2025', '0', '1762962549', '', 1),
(32, '321', '17', '11', '2025', '0', '1762962549', '', 1),
(33, '3211', '16', '11', '2025', '0', '1762962549', '', 1),
(34, '2311', '15', '11', '2025', '0', '1762962549', '', 1),
(35, '1324', '14', '11', '2025', '0', '1762962549', '', 1),
(36, '3211', '13', '11', '2025', '0', '1762962549', '', 1),
(37, '3211', '12', '11', '2025', '0', '1762962549', '', 1),
(38, '2121', '11', '11', '2025', '0', '1762962549', '', 1),
(39, '1321', '10', '11', '2025', '0', '1762962549', '', 1),
(40, '1353', '9', '11', '2025', '0', '1762962549', '', 1),
(41, '1321', '8', '11', '2025', '0', '1762962549', '', 1),
(42, '3220', '7', '11', '2025', '0', '1762962549', '', 1),
(43, '2321', '6', '11', '2025', '0', '1762962549', '', 1),
(44, '1233', '5', '11', '2025', '0', '1762962549', '', 1),
(45, '2332', '4', '11', '2025', '0', '1762962549', '', 1),
(46, '1235', '3', '11', '2025', '0', '1762962549', '', 1),
(47, '312', '2', '11', '2025', '0', '1762962549', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_fee`
--

CREATE TABLE `monthly_fee` (
  `id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `month_id` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `paid_status` varchar(10) NOT NULL,
  `added_on` varchar(10) NOT NULL,
  `updated_on` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_fee_details`
--

CREATE TABLE `monthly_fee_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `month_id` int(11) DEFAULT NULL,
  `monthly_amount` decimal(10,2) DEFAULT NULL,
  `fee_type` varchar(50) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `monthly_fee_details`
--

INSERT INTO `monthly_fee_details` (`id`, `user_id`, `payment_id`, `month_id`, `monthly_amount`, `fee_type`, `added_on`, `status`) VALUES
(1, 21, 1, 10, '10.00', 'hall_fee', '1762961313', 1),
(2, 21, 1, 10, '100.00', 'electricity_fee', '1762961313', 1),
(3, 20, 2, 10, '10.00', 'hall_fee', '1762962613', 1),
(4, 20, 2, 10, '100.00', 'electricity_fee', '1762962613', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_payment_details`
--

CREATE TABLE `monthly_payment_details` (
  `id` int(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `payment_id` varchar(5) NOT NULL,
  `month_id` varchar(5) NOT NULL,
  `monthly_amount` varchar(11) NOT NULL,
  `added_on` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `monthly_payment_details`
--

INSERT INTO `monthly_payment_details` (`id`, `user_id`, `payment_id`, `month_id`, `monthly_amount`, `added_on`, `status`) VALUES
(1, '21', '1', '10', '1243', '1762961313', 1),
(2, '20', '2', '10', '4313', '1762962613', 1);

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
  `id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `tran_id` varchar(30) NOT NULL,
  `val_id` varchar(50) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `tran_date` varchar(20) NOT NULL,
  `card_issuer` varchar(50) NOT NULL,
  `card_no` varchar(80) NOT NULL,
  `error` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_type` varchar(30) NOT NULL,
  `tran_id` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` varchar(20) NOT NULL,
  `updated_at` varchar(11) NOT NULL,
  `created_at` varchar(11) NOT NULL,
  `paid_status` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_type`, `tran_id`, `user_id`, `total_amount`, `updated_at`, `created_at`, `paid_status`, `status`) VALUES
(1, 'bkash', 'becHall_6914a7a27cba3', 21, '1653', '', '1762961313', 1, 1),
(2, 'cash', 'becHall_6914acb5b8512', 20, '4723.00', '', '1762962613', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `value` varchar(5) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `value`, `status`) VALUES
(1, 'Meal Checker', '2', 1),
(2, 'Meal Auditor', '3', 1),
(3, 'Manager', '4', 1),
(4, 'Marketing Manager', '5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `students_eee`
--

CREATE TABLE `students_eee` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `reg_no` varchar(11) NOT NULL,
  `roll` varchar(11) NOT NULL,
  `dept` varchar(55) NOT NULL,
  `session` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students_eee`
--

INSERT INTO `students_eee` (`id`, `name`, `reg_no`, `roll`, `dept`, `session`) VALUES
(1, 'KOUSHIK SARKER DOLLAR', '892', '200302', 'Electrical & Electronic Engineering', '2020-2021'),
(2, 'MD. SADIKUR RAHMAN', '893', '200303', 'Electrical & Electronic Engineering', '2020-2021'),
(3, 'REFAT AHMMED', '894', '200304', 'Electrical & Electronic Engineering', '2020-2021'),
(4, 'Pallobe Sarker', '895', '200305', 'Electrical & Electronic Engineering', '2020-2021'),
(5, 'MD.NAZMUL HASAN', '896', '200306', 'Electrical & Electronic Engineering', '2020-2021'),
(6, 'MD. SHAKIB AHMED', '897', '200307', 'Electrical & Electronic Engineering', '2020-2021'),
(7, 'RAKIBUL ISLAM', '900', '200310', 'Electrical & Electronic Engineering', '2020-2021'),
(8, 'MD SAZZAD HOSSAN', '', '200312', 'Electrical & Electronic Engineering', '2020-2021'),
(9, 'Asikuzzaman Sojib', '', '200316', 'Electrical & Electronic Engineering', '2020-2021'),
(10, 'MD GOLAM RABBY', '905', '200317', 'Electrical & Electronic Engineering', '2020-2021'),
(11, 'MD. ABDUL ZABBAR', '906', '200319', 'Electrical & Electronic Engineering', '2020-2021'),
(12, 'SIMANTA DATTA RONOBIR', '907', '200320', 'Electrical & Electronic Engineering', '2020-2021'),
(13, 'MD. NAZMUS SHAHADAT ZIUS', '908', '200321', 'Electrical & Electronic Engineering', '2020-2021'),
(14, 'MD. ALAMGIR', '912', '200326', 'Electrical & Electronic Engineering', '2020-2021'),
(15, 'Nayem', '', '200328', 'Electrical & Electronic Engineering', '2020-2021'),
(16, 'ISTIAQ AHAMMED', '915', '200329', 'Electrical & Electronic Engineering', '2020-2021'),
(17, 'SHUVA CHANDRA SARKER', '917', '200332', 'Electrical & Electronic Engineering', '2020-2021'),
(18, 'JIHANUL HAQUE JIHAN', '918', '200333', 'Electrical & Electronic Engineering', '2020-2021'),
(19, 'SHAHRIAR TAMIM', '', '200334', 'Electrical & Electronic Engineering', '2020-2021'),
(20, 'MD. SHARIFUL ISLAM', '', '200341', 'Electrical & Electronic Engineering', '2020-2021'),
(21, 'Amin Anjim', '928', '200343', 'Electrical & Electronic Engineering', '2020-2021'),
(22, 'APURBA KUMAR DAS', '930', '200345', 'Electrical & Electronic Engineering', '2020-2021'),
(23, 'DHRUBO BISWAS', '931', '200346', 'Electrical & Electronic Engineering', '2020-2021'),
(24, 'ARIF RABBANI', '933', '200348', 'Electrical & Electronic Engineering', '2020-2021'),
(25, 'Abdullah Al Mamun', '', '200349', 'Electrical & Electronic Engineering', '2020-2021'),
(26, 'RIAJUL KAMAL', '935', '200350', 'Electrical & Electronic Engineering', '2020-2021'),
(27, 'Mahinur', '936', '200351', 'Electrical & Electronic Engineering', '2020-2021'),
(28, 'SK. MD. WALI ULLAH BULON', '938', '200353', 'Electrical & Electronic Engineering', '2020-2021'),
(29, 'Abid Kamal Rumi', '939', '200354', 'Electrical & Electronic Engineering', '2020-2021'),
(30, 'TANZID HASAN MUNNA', '940', '200356', 'Electrical & Electronic Engineering', '2020-2021'),
(31, 'ABDULLAH AL AZAD', '941', '200357', 'Electrical & Electronic Engineering', '2020-2021'),
(32, 'Amir Hamza Bodor', '942', '200358', 'Electrical & Electronic Engineering', '2020-2021'),
(33, 'FAHIM HOWLADER TONMOY', '943', '200359', 'Electrical & Electronic Engineering', '2020-2021');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roll` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `class_roll` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `reg_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fOccupation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mOccupation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `presentAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permanentAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `religion` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthId` text COLLATE utf8_unicode_ci NOT NULL,
  `ffQuata` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bloodGroup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dept_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `room_number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `block` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `batch` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `examRoll` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `merit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `legalGuardianName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `legalGuardianRelation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_notification` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `meal_status` varchar(3) CHARACTER SET utf8 NOT NULL,
  `meal_request_status` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `meal_request_pending` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `full_month_on` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `guest_meal` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `guest_meal_request_status` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `guest_meal_request_pending` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `roll`, `class_roll`, `reg_no`, `fName`, `fOccupation`, `mName`, `mOccupation`, `phoneNumber`, `presentAddress`, `permanentAddress`, `dob`, `gender`, `religion`, `birthId`, `ffQuata`, `bloodGroup`, `dept_id`, `room_number`, `block`, `batch`, `examRoll`, `merit`, `legalGuardianName`, `legalGuardianRelation`, `password`, `email`, `image`, `last_notification`, `role`, `meal_status`, `meal_request_status`, `meal_request_pending`, `full_month_on`, `guest_meal`, `guest_meal_request_status`, `guest_meal_request_pending`, `status`) VALUES
(2, 'Azad Ahammed Rocky ', '200151', '200151', '', 'Md. Muklesur Rahman', 'Business ', 'Most.Azema Begum', 'Housewife ', '01756123996', 'Barisal', 'Chapainawabganj ', '15/01/2020', 'Male', 'Islam', '0184545464848484', 'No', 'B+', '1', '105', 'B', '1', '467289', '1285', 'Cza', 'Zaz', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'azadahammed52@gmail.com', '359120038_Dhrubo.jpg', '1661531317', '4', '1', '0', '0', '1', '0', '0', '0', 1),
(3, 'Rocky ', '200151', '200151', '', 'Md. Muklesur Rahman', 'Business ', 'Most.Azema Begum', 'Housewife ', '01756123996', 'Barisal', 'Barisal', '15/01/2020', 'Male', 'Islam', '0184545464848484', 'No', 'B+', '1', '103', 'B', '1', '467289', '1285', 'Cza', 'Zaz', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'azadahammed52@gmail.com', '359120038_Dhrubo.jpg', '1661531321', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(4, 'Rafsan Jani Zenith', '200126', '200126', '', 'Late Nuruddin Ahmed', 'N/A', 'Nilufa Ahmed', 'Manager', '01833766239', 'South Hall, Room no. 507', 'Dist: Munshiganj, P.O: Zazira Syedpur, Vill: Zazira Kunjonagar', '02/06/2002', 'Male', 'Islam', '2002123123123', 'No', 'O+', '1', 'Not', 'B', '1', '417', '32', 'Nilufa Ahmed', 'Mother', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'rafsanjani0206@gmail.com', '359120038_Dhrubo.jpg', '1661531740', '3', '1', '0', '0', '1', '0', '0', '0', 1),
(5, 'Nazmul Haque Jahid', '200101', '200101', '', 'Abdul Haque', 'Farmer', 'Najma Begum', 'Housewife', '01882874194', 'South Hall, Room no. 505', 'Cumilla', '05/09/2001', 'Male', 'Islam', '2001132112312', 'No', 'O+', '1', 'Not', 'B', '1', '338', '15', 'Abdul Haque', 'Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'nhjahid202@gmail.com', '359120038_Dhrubo.jpg', '1661532063', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(6, 'Akash Saha', '200156', '200156', '', 'Nil Kamal Saha', 'Teacher', 'Mamata Saha', 'Housewife', '01306884250', 'South Hall Room No 407', 'Nager Bazar, Bagerhat', '13/12/2001', 'Male', 'Hinduism', '2001123132132', 'Yes', 'B+', '1', '407', 'B', '1', '450', '9', 'Nil Kamal Saha', 'Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'akashsaha100135@gmail.com', '359120038_Dhrubo.jpg', '1661532429', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(7, 'Orin Karmaker', '200125', '200125', '', 'Uttam Kumar ', 'Teacher', 'Mukti Rani Mojumder ', 'n/a', '01306081580', 'South Hall 407', 'South Hall 407', '12/07/2003', 'Male', 'Hinduism', '20036914495002014', 'No', 'O+', '1', 'Not', 'B', '1', '378', '1131', 'Uttam Kumar', 'Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'orinkarmaker03@gmail.com', '359120038_Dhrubo.jpg', '1661532864', '2', '0', '1', '0', '1', '0', '0', '0', 1),
(8, 'Tahsin', '200102', '200102', '', 'Demo', 'Demo', 'Demo', 'Demo', '01111111111', 'Demo', 'Demo', '01/01/2002', 'Male', 'Islam', '2002123123123', 'No', 'A+', '1', '101', 'B', '1', '123456', '12', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'tahsin@gmail.com', '359120038_Dhrubo.jpg', '1661533207', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(9, 'Moshiur', '200103', '200103', '', 'Demo', 'Demo', 'Demo', 'Demo', '01222222222', 'Demo', 'Demo', '01/02/2002', 'Male', 'Islam', '2002123456789', 'No', 'A-', '1', '108', 'B', '1', '456789', '12', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'moshiur@gmail.com', '359120038_Dhrubo.jpg', '1661533287', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(10, 'Sadik', '200301', '200301', '', 'Demo', 'Demo', 'Demo', 'Demo', '01233333333', 'Demo', 'Demo', '01/03/2002', 'Male', 'Islam', '2002123456789', 'No', 'B+', '2', '410', 'B', '1', '465', '2', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'sadik@gmail.com', '359120038_Dhrubo.jpg', '1661533483', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(11, 'Koushik', '200302', '200302', '', 'Demo', 'Demo', 'Demo', 'Demo', '01234444444', 'Demo', 'Demo', '01/03/2002', 'Male', 'Hinduism', '2002123456789', 'No', 'B+', '2', '505', 'B', '1', '456', '7', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'koushik@gmail.com', '359120038_Dhrubo.jpg', '1661533596', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(12, 'Zius ', '200322', '200322', '', 'Demo', 'Demo', 'Demo', 'Demo', '01244444444', 'Demo', 'Demo', '01/02/2002', 'Male', 'Islam', '2002123456798', 'No', 'O+', '2', '410', 'B', '1', '569', '21', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'zius@gmail.com', '359120038_Dhrubo.jpg', '1661533816', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(13, 'Ashik', '200117', '200117', '', 'Demo', 'Demo', 'Demo', 'Demo', '01255555555', 'Demo', 'Demo', 'Demo', 'Male', 'Islam', '2002123789456', 'No', 'O+', '1', '502', 'B', '1', '123', '45', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'ashik@gmail.com', '359120038_Dhrubo.jpg', '1661533902', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(14, 'Tamim', '200345', '200345', '', 'Demo', 'Demo', 'Demo', 'Demo', '01244555555', 'Demo', 'Demo', '01/08/2001', 'Male', 'Islam', '2001456789123', 'No', 'O+', '2', '107', 'A', '1', '45', '7', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'tamim@gmail.com', '359120038_Dhrubo.jpg', '1661537604', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(15, 'Alauddin', '200119', '200119', '', 'Demo', 'Demo', 'Demo', 'Demo', '01455555555', 'Demo', 'Demo', '02/01/2002', 'Male', 'Islam', '2002987654321', 'No', 'A+', '1', '407', 'B', '1', '123', '32', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'alauddin@gmail.com', '359120038_Dhrubo.jpg', '1661537724', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(16, 'Zihad', '200137', '200137', '', 'Demo', 'Demo', 'Demo', 'Demo', '01666666666', 'Demo', 'Demo', '03/02/2002', 'Male', 'Islam', '2002456879321', 'No', 'B+', '1', '507', 'B', '1', '21', '12', 'Demo', 'Demo', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'zihad@gmail.com', '359120038_Dhrubo.jpg', '1661537802', '1', '0', '1', '0', '1', '0', '0', '0', 1),
(17, 'Azad Ahammed Rocky ', '200151', '200151', '', 'Md. Muklesur Rahman', 'Business ', 'Most.Azema Begum', 'Housewife ', '01756123996', 'Barisal', 'Chapainawabganj ', '15/01/2020', 'Male', 'Islam', '0184545464848484', 'No', 'A+', '1', '507', 'B', '1', '467289', '1285', 'Md. Muklesur Rahman', ' Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'azadahammed52@gmail.com', '359120038_Dhrubo.jpg', '1661538420', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(18, 'Nazmul Haque Jahid', '200101', '200101', '', 'Abdul Haque', 'Farmer', 'Najma Begum', 'Housewife', ' 01882874194', 'South Hall, Room no. 505', 'Cumilla', '05/09/2001', 'Male', 'Islam', '2001132112312', 'No', 'A-', '1', '505', 'B', '1', '454', '25', 'Abdul Haque', 'Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'nhjahid202@gmail.com', '359120038_Dhrubo.jpg', '1661538741', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(19, 'Rafsan Jani Zenith', '200126', '200126', '', 'Late Nuruddin Ahmed', 'N/A', 'Nilufa Ahmed', 'Manager', '01833766239', 'South Hall, Room no. 507', 'Dist: Munshiganj, P.O: Zazira Syedpur, Vill: Zazira Kunjonagar', '02/06/2002', 'Male', 'Islam', '2002123123123', 'No', 'O+', '1', '507', 'B', '1', '417', '12', 'Nilufa Ahmed', 'Mother', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'rafsanjani0206@gmail.com', '359120038_Dhrubo.jpg', '1661538869', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(20, 'Orin Karmaker', '200125', '200125', '', 'Uttam Kumar ', 'Teacher', 'Mukti Rani Mojumder ', 'N/A', '01306081580', 'South Hall 407', 'South Hall 407', '12/07/2003', 'Male', 'Hinduism', '20036914495002014', 'No', 'A+', '1', '407', 'B', '1', '451', '12', 'Uttam Kumar ', 'Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'orinkarmaker03@gmail.com', '359120038_Dhrubo.jpg', '1661539127', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(21, 'Dhrubo Raj Roy ', '200130', '200130', '', 'Debendronath Bormon', 'Govt. Officer', 'Maloti Ray', 'Teacher', '01705927257', 'Adarsopara', 'Adarsopara', '30/11/2002', 'Male', 'Hinduism', '1234567890123', 'No', 'A+', '1', '407', 'B', '1', '12', '21', 'Debendronath Bormon', 'Father', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'dhruborajroy3@gmail.com', '359120038_Dhrubo.jpg', '1661539258', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(22, 'Ashik', '223911', '223911', '', 'Md altaf ', 'teacher', 'Anjumanara Begum', 'gfy', '01704304282', 'uyg', 'ugu', '16/01/2001', 'Male', 'Islam', '1111111111111', 'No', 'B+', '1', '506', 'B', '1', '344', '444', 'tfd', 'hvu', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'emashik2020@gmail.com', '359120038_Dhrubo.jpg', '1661587310', '1', '0', '0', '0', '1', '0', '0', '0', 1),
(23, 'Ragib', '228224', '228224', '', 'Jkk', 'Hhh', 'Fgh', 'Hhh', '01788888888', 'Hhh', 'Ggh', '29/09/2021', 'Male', 'Islam', '08154218715616', 'No', 'A+', '3', '509', 'A', '1', '205141', '1066', 'Ggsh', 'Gga', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'fghc@gmail.com', '359120038_Dhrubo.jpg', '1661592744', '1', '1', '0', '0', '1', '0', '0', '0', 1),
(24, 'A', '225665', '85540', '', 'Dh', 'Xb', 'Xv', 'Fc', '0821156418', 'Fg', 'ch', '01/08/2022', 'Male', 'Islam', '78521806584545', 'FF', 'B+', '3', '204', 'A', '4', '35773', '1074', 'Dgj', 'Vdh', '$2y$10$3xSV8g1xd.7b6leqDI08MOZS6CMMiYKfsL32wzasO7Sp9BqqF92im', 'gfsj@gmail.com', '359120038_Dhrubo.jpg', '1662187831', '1', '0', '0', '0', '1', '0', '0', '0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
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
-- Indexes for table `complaint_box`
--
ALTER TABLE `complaint_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contingency_fee_details`
--
ALTER TABLE `contingency_fee_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `depts_lab_list`
--
ALTER TABLE `depts_lab_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_details`
--
ALTER TABLE `fee_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_informations`
--
ALTER TABLE `general_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_list`
--
ALTER TABLE `lab_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal_on_off_requests`
--
ALTER TABLE `meal_on_off_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal_table`
--
ALTER TABLE `meal_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_bill`
--
ALTER TABLE `monthly_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_fee`
--
ALTER TABLE `monthly_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_fee_details`
--
ALTER TABLE `monthly_fee_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_payment_details`
--
ALTER TABLE `monthly_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `online_payment`
--
ALTER TABLE `online_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_eee`
--
ALTER TABLE `students_eee`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bkash_credentials`
--
ALTER TABLE `bkash_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bkash_online_payment`
--
ALTER TABLE `bkash_online_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaint_box`
--
ALTER TABLE `complaint_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contingency_fee_details`
--
ALTER TABLE `contingency_fee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `depts_lab_list`
--
ALTER TABLE `depts_lab_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fee_details`
--
ALTER TABLE `fee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_informations`
--
ALTER TABLE `general_informations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lab_list`
--
ALTER TABLE `lab_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `meal_on_off_requests`
--
ALTER TABLE `meal_on_off_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meal_table`
--
ALTER TABLE `meal_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_bill`
--
ALTER TABLE `monthly_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `monthly_fee`
--
ALTER TABLE `monthly_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_fee_details`
--
ALTER TABLE `monthly_fee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `monthly_payment_details`
--
ALTER TABLE `monthly_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `online_payment`
--
ALTER TABLE `online_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students_eee`
--
ALTER TABLE `students_eee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1090;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
