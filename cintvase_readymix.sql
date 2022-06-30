-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2022 at 01:35 PM
-- Server version: 10.3.34-MariaDB-log-cll-lve
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cintvase_readymix`
--

-- --------------------------------------------------------

--
-- Table structure for table `applied_leave_days`
--

CREATE TABLE `applied_leave_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `period` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_master`
--

CREATE TABLE `appointment_master` (
  `id` int(11) NOT NULL,
  `member_id` varchar(125) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `gender` enum('M','F','O') DEFAULT 'M',
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `total_work_hr` time DEFAULT NULL,
  `extra_hour` int(11) NOT NULL DEFAULT 0,
  `extra_min` int(11) NOT NULL DEFAULT 0,
  `less_hour` int(11) NOT NULL DEFAULT 0,
  `less_min` int(11) NOT NULL DEFAULT 0,
  `status` enum('Present','Absent','Holiday','Week Off') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `start_time`, `end_time`, `total_work_hr`, `extra_hour`, `extra_min`, `less_hour`, `less_min`, `status`, `date`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, '16:42:33', '16:49:07', NULL, 0, 0, 0, 0, NULL, '2022-02-16', NULL, '2022-02-16 21:49:07', '2022-02-16 21:49:07'),
(2, 1, '01:42:45', '01:42:49', NULL, 0, 0, 0, 0, NULL, '2022-04-26', NULL, '2022-04-26 05:42:49', '2022-04-26 05:42:49'),
(3, 1, '12:26:28', '12:35:17', NULL, 0, 0, 0, 0, NULL, '2022-05-24', NULL, '2022-05-24 16:35:17', '2022-05-24 16:35:17'),
(4, 14121254, '13:35:33', '13:35:38', NULL, 0, 0, 0, 0, NULL, '2022-06-16', NULL, '2022-06-16 17:35:38', '2022-06-16 17:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

CREATE TABLE `barcodes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` double(22,4) DEFAULT NULL,
  `height` double(22,4) DEFAULT NULL,
  `paper_width` double(22,4) DEFAULT NULL,
  `paper_height` double(22,4) DEFAULT NULL,
  `top_margin` double(22,4) DEFAULT NULL,
  `left_margin` double(22,4) DEFAULT NULL,
  `row_distance` double(22,4) DEFAULT NULL,
  `col_distance` double(22,4) DEFAULT NULL,
  `stickers_in_one_row` int(11) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_continuous` tinyint(1) NOT NULL DEFAULT 0,
  `stickers_in_one_sheet` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `break`
--

CREATE TABLE `break` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pay_type` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `mode` enum('automatic','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'automatic',
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `allowed_duration` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applicable_shifts` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commodity_groups`
--

CREATE TABLE `commodity_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `slug` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `sortname` varchar(3) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `name_ar` varchar(125) DEFAULT NULL,
  `phonecode` int(11) NOT NULL,
  `is_active` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `sortname`, `name_en`, `name_ar`, `phonecode`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', 'أفغانستان', 93, '1', NULL, '0000-00-00 00:00:00'),
(2, 'AL', 'Albania', 'ألبانيا', 355, '1', NULL, '0000-00-00 00:00:00'),
(3, 'DZ', 'Algeria', 'الجزائر', 213, '1', NULL, '0000-00-00 00:00:00'),
(4, 'AS', 'American Samoa', 'ساموا الأمريكية', 1684, '1', NULL, '0000-00-00 00:00:00'),
(5, 'AD', 'Andorra', 'أندورا', 376, '1', NULL, '0000-00-00 00:00:00'),
(6, 'AO', 'Angola', 'أنغولا', 244, '1', NULL, '0000-00-00 00:00:00'),
(7, 'AI', 'Anguilla', 'أنغيلا', 1264, '1', NULL, '0000-00-00 00:00:00'),
(8, 'AQ', 'Antarctica', 'القارة القطبية الجنوبية', 0, '1', NULL, '0000-00-00 00:00:00'),
(9, 'AG', 'Antigua And Barbuda', 'أنتيغوا وبربودا', 1268, '1', NULL, '0000-00-00 00:00:00'),
(10, 'AR', 'Argentina', 'الأرجنتين', 54, '1', NULL, '0000-00-00 00:00:00'),
(11, 'AM', 'Armenia', 'أرمينيا', 374, '1', NULL, NULL),
(12, 'AW', 'Aruba', 'أروبا', 297, '1', NULL, NULL),
(13, 'AU', 'Australia', 'أستراليا', 61, '1', NULL, NULL),
(14, 'AT', 'Austria', 'النمسا', 43, '1', NULL, NULL),
(15, 'AZ', 'Azerbaijan', 'أذربيجان', 994, '1', NULL, NULL),
(16, 'BS', 'Bahamas The', 'جزر البهاما', 1242, '1', NULL, NULL),
(17, 'BH', 'Bahrain', 'البحرين', 973, '1', NULL, NULL),
(18, 'BD', 'Bangladesh', 'بنغلاديش', 880, '1', NULL, NULL),
(19, 'BB', 'Barbados', 'بربادوس', 1246, '1', NULL, NULL),
(20, 'BY', 'Belarus', 'بيلاروسيا', 375, '1', NULL, NULL),
(21, 'BE', 'Belgium', 'بلجيكا', 32, '1', NULL, NULL),
(22, 'BZ', 'Belize', 'بليز', 501, '1', NULL, NULL),
(23, 'BJ', 'Benin', 'بنين', 229, '1', NULL, NULL),
(24, 'BM', 'Bermuda', 'برمودا', 1441, '1', NULL, NULL),
(25, 'BT', 'Bhutan', 'بوتان', 975, '1', NULL, NULL),
(26, 'BO', 'Bolivia', 'بوليفيا', 591, '1', NULL, NULL),
(27, 'BA', 'Bosnia and Herzegovina', 'البوسنة والهرسك', 387, '1', NULL, NULL),
(28, 'BW', 'Botswana', 'بوتسوانا', 267, '1', NULL, NULL),
(29, 'BV', 'Bouvet Island', 'جزيرة بوفيت', 0, '1', NULL, NULL),
(30, 'BR', 'Brazil', 'البرازيل', 55, '1', NULL, NULL),
(31, 'IO', 'British Indian Ocean Territory', 'إقليم المحيط البريطاني الهندي', 246, '1', NULL, NULL),
(32, 'BN', 'Brunei', 'بروناي', 673, '1', NULL, NULL),
(33, 'BG', 'Bulgaria', 'بلغاريا', 359, '1', NULL, NULL),
(34, 'BF', 'Burkina Faso', 'بوركينا فاسو', 226, '1', NULL, NULL),
(35, 'BI', 'Burundi', 'بوروندي', 257, '1', NULL, NULL),
(36, 'KH', 'Cambodia', 'كمبوديا', 855, '1', NULL, NULL),
(37, 'CM', 'Cameroon', 'الكاميرون', 237, '1', NULL, NULL),
(38, 'CA', 'Canada', 'كندا', 1, '1', NULL, NULL),
(39, 'CV', 'Cape Verde', 'الرأس الأخضر', 238, '1', NULL, NULL),
(40, 'KY', 'Cayman Islands', 'جزر كايمان', 1345, '1', NULL, NULL),
(41, 'CF', 'Central African Republic', 'جمهورية افريقيا الوسطى', 236, '1', NULL, NULL),
(42, 'TD', 'Chad', 'تشاد', 235, '1', NULL, NULL),
(43, 'CL', 'Chile', 'تشيلي', 56, '1', NULL, NULL),
(44, 'CN', 'China', 'الصين', 86, '1', NULL, NULL),
(45, 'CX', 'Christmas Island', 'جزيرة الكريسماس', 61, '1', NULL, NULL),
(46, 'CC', 'Cocos (Keeling) Islands', 'جزر كوكوس (كيلينغ)', 672, '1', NULL, NULL),
(47, 'CO', 'Colombia', 'كولومبيا', 57, '1', NULL, NULL),
(48, 'KM', 'Comoros', 'جزر القمر', 269, '1', NULL, NULL),
(49, 'CG', 'Republic Of The Congo', 'جمهورية الكونغو', 242, '1', NULL, NULL),
(50, 'CD', 'Democratic Republic Of The Congo', 'جمهورية الكونغو الديموقراطية', 242, '1', NULL, NULL),
(51, 'CK', 'Cook Islands', 'جزر كوك', 682, '1', NULL, NULL),
(52, 'CR', 'Costa Rica', 'كوستا ريكا', 506, '1', NULL, NULL),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', 'Cote D\'Ivoire (Ivory Coast)', 225, '1', NULL, NULL),
(54, 'HR', 'Croatia (Hrvatska)', 'كرواتيا (هرفاتسكا)', 385, '1', NULL, NULL),
(55, 'CU', 'Cuba', 'كوبا', 53, '1', NULL, NULL),
(56, 'CY', 'Cyprus', 'قبرص', 357, '1', NULL, NULL),
(57, 'CZ', 'Czech Republic', 'جمهورية التشيك', 420, '1', NULL, NULL),
(58, 'DK', 'Denmark', 'الدنمارك', 45, '1', NULL, NULL),
(59, 'DJ', 'Djibouti', 'جيبوتي', 253, '1', NULL, NULL),
(60, 'DM', 'Dominica', 'دومينيكا', 1767, '1', NULL, NULL),
(61, 'DO', 'Dominican Republic', 'جمهورية الدومنيكان', 1809, '1', NULL, NULL),
(62, 'TP', 'East Timor', 'تيمور الشرقية', 670, '1', NULL, NULL),
(63, 'EC', 'Ecuador', 'الاكوادور', 593, '1', NULL, NULL),
(64, 'EG', 'Egypt', 'مصر', 20, '1', NULL, NULL),
(65, 'SV', 'El Salvador', 'السلفادور', 503, '1', NULL, NULL),
(66, 'GQ', 'Equatorial Guinea', 'غينيا الإستوائية', 240, '1', NULL, NULL),
(67, 'ER', 'Eritrea', 'إريتريا', 291, '1', NULL, NULL),
(68, 'EE', 'Estonia', 'إستونيا', 372, '1', NULL, NULL),
(69, 'ET', 'Ethiopia', 'أثيوبيا', 251, '1', NULL, NULL),
(70, 'XA', 'External Territories of Australia', 'الأقاليم الخارجية لأستراليا', 61, '1', NULL, NULL),
(71, 'FK', 'Falkland Islands', 'جزر فوكلاند', 500, '1', NULL, NULL),
(72, 'FO', 'Faroe Islands', 'جزر فاروس', 298, '1', NULL, NULL),
(73, 'FJ', 'Fiji Islands', 'جزر فيجي', 679, '1', NULL, NULL),
(74, 'FI', 'Finland', 'فنلندا', 358, '1', NULL, NULL),
(75, 'FR', 'France', 'فرنسا', 33, '1', NULL, NULL),
(76, 'GF', 'French Guiana', 'غيانا الفرنسية', 594, '1', NULL, NULL),
(77, 'PF', 'French Polynesia', 'بولينيزيا الفرنسية', 689, '1', NULL, NULL),
(78, 'TF', 'French Southern Territories', 'المناطق الجنوبية لفرنسا', 0, '1', NULL, NULL),
(79, 'GA', 'Gabon', 'الجابون', 241, '1', NULL, NULL),
(80, 'GM', 'Gambia The', 'غامبيا', 220, '1', NULL, NULL),
(81, 'GE', 'Georgia', 'جورجيا', 995, '1', NULL, NULL),
(82, 'DE', 'Germany', 'ألمانيا', 49, '1', NULL, NULL),
(83, 'GH', 'Ghana', 'غانا', 233, '1', NULL, NULL),
(84, 'GI', 'Gibraltar', 'جبل طارق', 350, '1', NULL, NULL),
(85, 'GR', 'Greece', 'اليونان', 30, '1', NULL, NULL),
(86, 'GL', 'Greenland', 'الأرض الخضراء', 299, '1', NULL, NULL),
(87, 'GD', 'Grenada', 'غرينادا', 1473, '1', NULL, NULL),
(88, 'GP', 'Guadeloupe', 'جوادلوب', 590, '1', NULL, NULL),
(89, 'GU', 'Guam', 'غوام', 1671, '1', NULL, NULL),
(90, 'GT', 'Guatemala', 'غواتيمالا', 502, '1', NULL, NULL),
(91, 'XU', 'Guernsey and Alderney', 'غيرنزي وألدرني', 44, '1', NULL, NULL),
(92, 'GN', 'Guinea', 'غينيا', 224, '1', NULL, NULL),
(93, 'GW', 'Guinea-Bissau', 'غينيا بيساو', 245, '1', NULL, NULL),
(94, 'GY', 'Guyana', 'غيانا', 592, '1', NULL, NULL),
(95, 'HT', 'Haiti', 'هايتي', 509, '1', NULL, NULL),
(96, 'HM', 'Heard and McDonald Islands', 'جزر هيرد وماكدونالد', 0, '1', NULL, NULL),
(97, 'HN', 'Honduras', 'هندوراس', 504, '1', NULL, NULL),
(98, 'HK', 'Hong Kong S.A.R.', 'هونج كونج S.A.R.', 852, '1', NULL, NULL),
(99, 'HU', 'Hungary', 'هنغاريا', 36, '1', NULL, NULL),
(100, 'IS', 'Iceland', 'أيسلندا', 354, '1', NULL, NULL),
(101, 'IN', 'India', 'الهند', 91, '1', NULL, NULL),
(102, 'ID', 'Indonesia', 'إندونيسيا', 62, '1', NULL, NULL),
(103, 'IR', 'Iran', 'إيران', 98, '1', NULL, NULL),
(104, 'IQ', 'Iraq', 'العراق', 964, '1', NULL, NULL),
(105, 'IE', 'Ireland', 'أيرلندا', 353, '1', NULL, NULL),
(106, 'IL', 'Israel', 'إسرائيل', 972, '1', NULL, NULL),
(107, 'IT', 'Italy', 'إيطاليا', 39, '1', NULL, NULL),
(108, 'JM', 'Jamaica', 'جامايكا', 1876, '1', NULL, NULL),
(109, 'JP', 'Japan', 'اليابان', 81, '1', NULL, NULL),
(110, 'XJ', 'Jersey', 'جيرسي', 44, '1', NULL, NULL),
(111, 'JO', 'Jordan', 'الأردن', 962, '1', NULL, NULL),
(112, 'KZ', 'Kazakhstan', 'كازاخستان', 7, '1', NULL, NULL),
(113, 'KE', 'Kenya', 'كينيا', 254, '1', NULL, NULL),
(114, 'KI', 'Kiribati', 'كيريباتي', 686, '1', NULL, NULL),
(115, 'KP', 'Korea North', 'كوريا الشمالية', 850, '1', NULL, NULL),
(116, 'KR', 'Korea South', 'كوريا، جنوب', 82, '1', NULL, NULL),
(117, 'KW', 'Kuwait', 'الكويت', 965, '1', NULL, NULL),
(118, 'KG', 'Kyrgyzstan', 'قيرغيزستان', 996, '1', NULL, NULL),
(119, 'LA', 'Laos', 'لاوس', 856, '1', NULL, NULL),
(120, 'LV', 'Latvia', 'لاتفيا', 371, '1', NULL, NULL),
(121, 'LB', 'Lebanon', 'لبنان', 961, '1', NULL, NULL),
(122, 'LS', 'Lesotho', 'ليسوتو', 266, '1', NULL, NULL),
(123, 'LR', 'Liberia', 'ليبيريا', 231, '1', NULL, NULL),
(124, 'LY', 'Libya', 'ليبيا', 218, '1', NULL, NULL),
(125, 'LI', 'Liechtenstein', 'ليختنشتاين', 423, '1', NULL, NULL),
(126, 'LT', 'Lithuania', 'ليتوانيا', 370, '1', NULL, NULL),
(127, 'LU', 'Luxembourg', 'لوكسمبورغ', 352, '1', NULL, NULL),
(128, 'MO', 'Macau S.A.R.', 'ماكاو S.A.R.', 853, '1', NULL, NULL),
(129, 'MK', 'Macedonia', 'مقدونيا', 389, '1', NULL, NULL),
(130, 'MG', 'Madagascar', 'مدغشقر', 261, '1', NULL, NULL),
(131, 'MW', 'Malawi', 'ملاوي', 265, '1', NULL, NULL),
(132, 'MY', 'Malaysia', 'ماليزيا', 60, '1', NULL, NULL),
(133, 'MV', 'Maldives', 'جزر المالديف', 960, '1', NULL, NULL),
(134, 'ML', 'Mali', 'مالي', 223, '1', NULL, NULL),
(135, 'MT', 'Malta', 'مالطا', 356, '1', NULL, NULL),
(136, 'XM', 'Man (Isle of)', 'رجل (جزيرة)', 44, '1', NULL, NULL),
(137, 'MH', 'Marshall Islands', 'جزر مارشال', 692, '1', NULL, NULL),
(138, 'MQ', 'Martinique', 'مارتينيك', 596, '1', NULL, NULL),
(139, 'MR', 'Mauritania', 'موريتانيا', 222, '1', NULL, NULL),
(140, 'MU', 'Mauritius', 'موريشيوس', 230, '1', NULL, NULL),
(141, 'YT', 'Mayotte', 'مايوت', 269, '1', NULL, NULL),
(142, 'MX', 'Mexico', 'المكسيك', 52, '1', NULL, NULL),
(143, 'FM', 'Micronesia', 'ميكرونيزيا', 691, '1', NULL, NULL),
(144, 'MD', 'Moldova', 'مولدوفا', 373, '1', NULL, NULL),
(145, 'MC', 'Monaco', 'موناكو', 377, '1', NULL, NULL),
(146, 'MN', 'Mongolia', 'منغوليا', 976, '1', NULL, NULL),
(147, 'MS', 'Montserrat', 'مونتسيرات', 1664, '1', NULL, NULL),
(148, 'MA', 'Morocco', 'المغرب', 212, '1', NULL, NULL),
(149, 'MZ', 'Mozambique', 'موزمبيق', 258, '1', NULL, NULL),
(150, 'MM', 'Myanmar', 'ميانمار', 95, '1', NULL, NULL),
(151, 'NA', 'Namibia', 'ناميبيا', 264, '1', NULL, NULL),
(152, 'NR', 'Nauru', 'ناورو', 674, '1', NULL, NULL),
(153, 'NP', 'Nepal', 'نيبال', 977, '1', NULL, NULL),
(154, 'AN', 'Netherlands Antilles', 'جزر الأنتيل الهولندية', 599, '1', NULL, NULL),
(155, 'NL', 'Netherlands The', 'هولندا', 31, '1', NULL, NULL),
(156, 'NC', 'New Caledonia', 'كاليدونيا الجديدة', 687, '1', NULL, NULL),
(157, 'NZ', 'New Zealand', 'نيوزيلندا', 64, '1', NULL, NULL),
(158, 'NI', 'Nicaragua', 'نيكاراغوا', 505, '1', NULL, NULL),
(159, 'NE', 'Niger', 'النيجر', 227, '1', NULL, NULL),
(160, 'NG', 'Nigeria', 'نيجيريا', 234, '1', NULL, NULL),
(161, 'NU', 'Niue', 'نيوي', 683, '1', NULL, NULL),
(162, 'NF', 'Norfolk Island', 'جزيرة نورفولك', 672, '1', NULL, NULL),
(163, 'MP', 'Northern Mariana Islands', 'جزر مريانا الشمالية', 1670, '1', NULL, NULL),
(164, 'NO', 'Norway', 'النرويج', 47, '1', NULL, NULL),
(165, 'OM', 'Oman', 'سلطنة عمان', 968, '1', NULL, NULL),
(166, 'PK', 'Pakistan', 'باكستان', 92, '1', NULL, NULL),
(167, 'PW', 'Palau', 'بالاو', 680, '1', NULL, NULL),
(168, 'PS', 'Palestinian Territory Occupied', 'الأراضي الفلسطينية المحتلة', 970, '1', NULL, NULL),
(169, 'PA', 'Panama', 'بنما', 507, '1', NULL, NULL),
(170, 'PG', 'Papua new Guinea', 'بابوا غينيا الجديدة', 675, '1', NULL, NULL),
(171, 'PY', 'Paraguay', 'باراغواي', 595, '1', NULL, NULL),
(172, 'PE', 'Peru', 'بيرو', 51, '1', NULL, NULL),
(173, 'PH', 'Philippines', 'الفلبين', 63, '1', NULL, NULL),
(174, 'PN', 'Pitcairn Island', 'جزيرة بيتكيرن', 0, '1', NULL, NULL),
(175, 'PL', 'Poland', 'بولندا', 48, '1', NULL, NULL),
(176, 'PT', 'Portugal', 'البرتغال', 351, '1', NULL, NULL),
(177, 'PR', 'Puerto Rico', 'بورتوريكو', 1787, '1', NULL, NULL),
(178, 'QA', 'Qatar', 'دولة قطر', 974, '1', NULL, NULL),
(179, 'RE', 'Reunion', 'جمع شمل', 262, '1', NULL, NULL),
(180, 'RO', 'Romania', 'رومانيا', 40, '1', NULL, NULL),
(181, 'RU', 'Russia', 'روسيا', 70, '1', NULL, NULL),
(182, 'RW', 'Rwanda', 'رواندا', 250, '1', NULL, NULL),
(183, 'SH', 'Saint Helena', 'سانت هيلانة', 290, '1', NULL, NULL),
(184, 'KN', 'Saint Kitts And Nevis', 'سانت كيتس ونيفيس', 1869, '1', NULL, NULL),
(185, 'LC', 'Saint Lucia', 'القديسة لوسيا', 1758, '1', NULL, NULL),
(186, 'PM', 'Saint Pierre and Miquelon', 'سانت بيير وميكلون', 508, '1', NULL, NULL),
(187, 'VC', 'Saint Vincent And The Grenadines', 'سانت فنسنت وجزر غرينادين', 1784, '1', NULL, NULL),
(188, 'WS', 'Samoa', 'ساموا', 684, '1', NULL, NULL),
(189, 'SM', 'San Marino', 'سان مارينو', 378, '1', NULL, NULL),
(190, 'ST', 'Sao Tome and Principe', 'ساو تومي وبرينسيبي', 239, '1', NULL, NULL),
(191, 'SA', 'Saudi Arabia', 'المملكة العربية السعودية', 966, '1', NULL, NULL),
(192, 'SN', 'Senegal', 'السنغال', 221, '1', NULL, NULL),
(193, 'RS', 'Serbia', 'صربيا', 381, '1', NULL, NULL),
(194, 'SC', 'Seychelles', 'سيشيل', 248, '1', NULL, NULL),
(195, 'SL', 'Sierra Leone', 'سيرا ليون', 232, '1', NULL, NULL),
(196, 'SG', 'Singapore', 'سنغافورة', 65, '1', NULL, NULL),
(197, 'SK', 'Slovakia', 'سلوفاكيا', 421, '1', NULL, NULL),
(198, 'SI', 'Slovenia', 'سلوفينيا', 386, '1', NULL, NULL),
(199, 'XG', 'Smaller Territories of the UK', 'أقاليم أصغر في المملكة المتحدة', 44, '1', NULL, NULL),
(200, 'SB', 'Solomon Islands', 'جزر سليمان', 677, '1', NULL, NULL),
(201, 'SO', 'Somalia', 'الصومال', 252, '1', NULL, NULL),
(202, 'ZA', 'South Africa', 'جنوب أفريقيا', 27, '1', NULL, NULL),
(203, 'GS', 'South Georgia', 'جورجيا الجنوبية', 0, '1', NULL, NULL),
(204, 'SS', 'South Sudan', 'جنوب السودان', 211, '1', NULL, NULL),
(205, 'ES', 'Spain', 'إسبانيا', 34, '1', NULL, NULL),
(206, 'LK', 'Sri Lanka', 'سيريلانكا', 94, '1', NULL, NULL),
(207, 'SD', 'Sudan', 'السودان', 249, '1', NULL, NULL),
(208, 'SR', 'Suriname', 'سورينام', 597, '1', NULL, NULL),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', 'جزر سفالبارد وجان ماين', 47, '1', NULL, NULL),
(210, 'SZ', 'Swaziland', 'سوازيلاند', 268, '1', NULL, NULL),
(211, 'SE', 'Sweden', 'السويد', 46, '1', NULL, NULL),
(212, 'CH', 'Switzerland', 'سويسرا', 41, '1', NULL, NULL),
(213, 'SY', 'Syria', 'سوريا', 963, '1', NULL, NULL),
(214, 'TW', 'Taiwan', 'تايوان', 886, '1', NULL, NULL),
(215, 'TJ', 'Tajikistan', 'طاجيكستان', 992, '1', NULL, NULL),
(216, 'TZ', 'Tanzania', 'تنزانيا', 255, '1', NULL, NULL),
(217, 'TH', 'Thailand', 'تايلاند', 66, '1', NULL, NULL),
(218, 'TG', 'Togo', 'توجو', 228, '1', NULL, NULL),
(219, 'TK', 'Tokelau', 'توكيلاو', 690, '1', NULL, NULL),
(220, 'TO', 'Tonga', 'تونغا', 676, '1', NULL, NULL),
(221, 'TT', 'Trinidad And Tobago', 'ترينداد وتوباغو', 1868, '1', NULL, NULL),
(222, 'TN', 'Tunisia', 'تونس', 216, '1', NULL, NULL),
(223, 'TR', 'Turkey', 'ديك رومي', 90, '1', NULL, NULL),
(224, 'TM', 'Turkmenistan', 'تركمانستان', 7370, '1', NULL, NULL),
(225, 'TC', 'Turks And Caicos Islands', 'جزر تركس وكايكوس', 1649, '1', NULL, NULL),
(226, 'TV', 'Tuvalu', 'توفالو', 688, '1', NULL, NULL),
(227, 'UG', 'Uganda', 'أوغندا', 256, '1', NULL, NULL),
(228, 'UA', 'Ukraine', 'أوكرانيا', 380, '1', NULL, NULL),
(229, 'AE', 'United Arab Emirates', 'الإمارات العربية المتحدة', 971, '1', NULL, '0000-00-00 00:00:00'),
(230, 'GB', 'United Kingdom', 'المملكة المتحدة', 44, '1', NULL, NULL),
(231, 'US', 'United States', 'الولايات المتحدة الأمريكية', 1, '1', NULL, NULL),
(232, 'UM', 'United States Minor Outlying Islands', 'جزر الولايات المتحدة البعيدة الصغرى', 1, '1', NULL, NULL),
(233, 'UY', 'Uruguay', 'أوروغواي', 598, '1', NULL, NULL),
(234, 'UZ', 'Uzbekistan', 'أوزبكستان', 998, '1', NULL, NULL),
(235, 'VU', 'Vanuatu', 'فانواتو', 678, '1', NULL, NULL),
(236, 'VA', 'Vatican City State (Holy See)', 'دولة الفاتيكان (الكرسي الرسولي)', 39, '1', NULL, NULL),
(237, 'VE', 'Venezuela', 'فنزويلا', 58, '1', NULL, NULL),
(238, 'VN', 'Vietnam', 'فيتنام', 84, '1', NULL, NULL),
(239, 'VG', 'Virgin Islands (British)', 'جزر العذراء البريطانية)', 1284, '1', NULL, NULL),
(240, 'VI', 'Virgin Islands (US)', 'جزر فيرجن (الولايات المتحدة)', 1340, '1', NULL, NULL),
(241, 'WF', 'Wallis And Futuna Islands', 'جزر واليس وفوتونا', 681, '1', NULL, NULL),
(242, 'EH', 'Western Sahara', 'الصحراء الغربية', 212, '1', NULL, NULL),
(243, 'YE', 'Yemen', 'اليمن', 967, '1', NULL, NULL),
(244, 'YU', 'Yugoslavia', 'يوغوسلافيا', 38, '1', NULL, NULL),
(245, 'ZM', 'Zambia', 'زامبيا', 260, '1', NULL, NULL),
(246, 'ZW', 'Zimbabwe', 'زمبابوي', 263, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cron_check`
--

CREATE TABLE `cron_check` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `time` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cron_check`
--

INSERT INTO `cron_check` (`id`, `created_at`, `updated_at`, `time`) VALUES
(1, '2022-04-12 18:16:15', '2022-04-12 18:16:15', '02:16 PM'),
(2, '2022-04-12 18:19:23', '2022-04-12 18:19:23', '02:19 PM'),
(3, '2022-04-12 18:40:08', '2022-04-12 18:40:08', '02:40 PM'),
(4, '2022-04-12 18:45:15', '2022-04-12 18:45:15', '02:45 PM'),
(5, '2022-04-13 11:00:36', '2022-04-13 11:00:36', '07:00 AM'),
(6, '2022-04-14 11:00:17', '2022-04-14 11:00:17', '07:00 AM'),
(7, '2022-04-15 11:00:08', '2022-04-15 11:00:08', '07:00 AM'),
(8, '2022-04-16 11:00:48', '2022-04-16 11:00:48', '07:00 AM'),
(9, '2022-04-17 11:00:27', '2022-04-17 11:00:27', '07:00 AM'),
(10, '2022-04-18 11:00:52', '2022-04-18 11:00:52', '07:00 AM'),
(11, '2022-04-19 11:00:15', '2022-04-19 11:00:15', '07:00 AM'),
(12, '2022-04-20 11:00:45', '2022-04-20 11:00:45', '07:00 AM'),
(13, '2022-04-21 11:00:03', '2022-04-21 11:00:03', '07:00 AM'),
(14, '2022-04-22 11:00:25', '2022-04-22 11:00:25', '07:00 AM'),
(15, '2022-04-23 11:00:35', '2022-04-23 11:00:35', '07:00 AM'),
(16, '2022-04-24 11:00:06', '2022-04-24 11:00:06', '07:00 AM'),
(17, '2022-04-25 11:00:06', '2022-04-25 11:00:06', '07:00 AM'),
(18, '2022-04-26 11:00:44', '2022-04-26 11:00:44', '07:00 AM'),
(19, '2022-04-27 11:00:44', '2022-04-27 11:00:44', '07:00 AM'),
(20, '2022-04-28 11:00:48', '2022-04-28 11:00:48', '07:00 AM'),
(21, '2022-04-29 11:00:10', '2022-04-29 11:00:10', '07:00 AM'),
(22, '2022-04-30 11:00:22', '2022-04-30 11:00:22', '07:00 AM'),
(23, '2022-05-01 11:00:20', '2022-05-01 11:00:20', '07:00 AM'),
(24, '2022-05-02 11:00:50', '2022-05-02 11:00:50', '07:00 AM'),
(25, '2022-05-03 11:00:24', '2022-05-03 11:00:24', '07:00 AM'),
(26, '2022-05-04 11:00:15', '2022-05-04 11:00:15', '07:00 AM'),
(27, '2022-05-05 11:00:33', '2022-05-05 11:00:33', '07:00 AM'),
(28, '2022-05-06 11:00:19', '2022-05-06 11:00:19', '07:00 AM'),
(29, '2022-05-07 11:00:28', '2022-05-07 11:00:28', '07:00 AM'),
(30, '2022-05-08 11:00:50', '2022-05-08 11:00:50', '07:00 AM'),
(31, '2022-05-09 11:00:49', '2022-05-09 11:00:49', '07:00 AM'),
(32, '2022-05-10 11:00:49', '2022-05-10 11:00:49', '07:00 AM'),
(33, '2022-05-11 11:00:24', '2022-05-11 11:00:24', '07:00 AM'),
(34, '2022-05-12 11:00:30', '2022-05-12 11:00:30', '07:00 AM'),
(35, '2022-05-13 11:00:38', '2022-05-13 11:00:38', '07:00 AM'),
(36, '2022-05-14 11:00:25', '2022-05-14 11:00:25', '07:00 AM'),
(37, '2022-05-15 11:00:46', '2022-05-15 11:00:46', '07:00 AM'),
(38, '2022-05-16 11:00:23', '2022-05-16 11:00:23', '07:00 AM'),
(39, '2022-05-17 11:00:17', '2022-05-17 11:00:17', '07:00 AM'),
(40, '2022-05-18 11:00:18', '2022-05-18 11:00:18', '07:00 AM'),
(41, '2022-05-19 11:00:51', '2022-05-19 11:00:51', '07:00 AM'),
(42, '2022-05-20 11:00:15', '2022-05-20 11:00:15', '07:00 AM'),
(43, '2022-05-21 11:00:03', '2022-05-21 11:00:03', '07:00 AM'),
(44, '2022-05-22 11:00:25', '2022-05-22 11:00:25', '07:00 AM'),
(45, '2022-05-23 11:00:47', '2022-05-23 11:00:47', '07:00 AM'),
(46, '2022-05-24 11:00:44', '2022-05-24 11:00:44', '07:00 AM'),
(47, '2022-05-25 11:00:39', '2022-05-25 11:00:39', '07:00 AM'),
(48, '2022-05-26 11:00:11', '2022-05-26 11:00:11', '07:00 AM'),
(49, '2022-05-27 11:00:20', '2022-05-27 11:00:20', '07:00 AM'),
(50, '2022-05-28 11:00:30', '2022-05-28 11:00:30', '07:00 AM'),
(51, '2022-05-29 11:00:50', '2022-05-29 11:00:50', '07:00 AM'),
(52, '2022-05-30 11:00:16', '2022-05-30 11:00:16', '07:00 AM'),
(53, '2022-05-31 11:00:28', '2022-05-31 11:00:28', '07:00 AM'),
(54, '2022-06-01 11:00:35', '2022-06-01 11:00:35', '07:00 AM'),
(55, '2022-06-02 11:00:14', '2022-06-02 11:00:14', '07:00 AM'),
(56, '2022-06-03 11:00:35', '2022-06-03 11:00:35', '07:00 AM'),
(57, '2022-06-04 11:00:39', '2022-06-04 11:00:39', '07:00 AM'),
(58, '2022-06-05 11:00:11', '2022-06-05 11:00:11', '07:00 AM'),
(59, '2022-06-06 11:00:05', '2022-06-06 11:00:05', '07:00 AM'),
(60, '2022-06-07 11:00:05', '2022-06-07 11:00:05', '07:00 AM'),
(61, '2022-06-08 11:00:51', '2022-06-08 11:00:51', '07:00 AM'),
(62, '2022-06-09 11:00:28', '2022-06-09 11:00:28', '07:00 AM'),
(63, '2022-06-10 11:00:41', '2022-06-10 11:00:41', '07:00 AM'),
(64, '2022-06-11 11:00:10', '2022-06-11 11:00:10', '07:00 AM'),
(65, '2022-06-12 11:00:34', '2022-06-12 11:00:34', '07:00 AM'),
(66, '2022-06-13 11:00:37', '2022-06-13 11:00:37', '07:00 AM'),
(67, '2022-06-14 11:00:42', '2022-06-14 11:00:42', '07:00 AM'),
(68, '2022-06-15 11:00:31', '2022-06-15 11:00:31', '07:00 AM'),
(69, '2022-06-16 11:00:13', '2022-06-16 11:00:13', '07:00 AM'),
(70, '2022-06-17 11:00:11', '2022-06-17 11:00:11', '07:00 AM'),
(71, '2022-06-18 11:00:18', '2022-06-18 11:00:18', '07:00 AM'),
(72, '2022-06-19 11:00:18', '2022-06-19 11:00:18', '07:00 AM'),
(73, '2022-06-20 11:00:18', '2022-06-20 11:00:18', '07:00 AM'),
(74, '2022-06-21 11:00:17', '2022-06-21 11:00:17', '07:00 AM'),
(75, '2022-06-22 11:00:32', '2022-06-22 11:00:32', '07:00 AM');

-- --------------------------------------------------------

--
-- Table structure for table `customer_contact`
--

CREATE TABLE `customer_contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_position` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cust_contract_attachment`
--

CREATE TABLE `cust_contract_attachment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_cont_id` int(11) NOT NULL,
  `contract` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `quotation` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bala_per` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `owner_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `credit_form` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `purchase_order` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pay_grnt` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_note`
--

CREATE TABLE `delivery_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_detail_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `helper_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `pump` int(11) DEFAULT NULL,
  `load_no` int(11) NOT NULL,
  `reject_by` int(11) DEFAULT NULL,
  `reject_qty` int(11) DEFAULT NULL,
  `excess_qty` int(11) DEFAULT NULL,
  `extra_qty` int(11) DEFAULT NULL,
  `remark` text CHARACTER SET utf8 DEFAULT NULL,
  `delivery_date` date NOT NULL,
  `status` enum('pending','loaded','dispatched','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `slump` int(11) DEFAULT NULL,
  `no_of_cubes` int(11) DEFAULT NULL,
  `comp_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `air_content` float(10,2) DEFAULT NULL,
  `sampled_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avg_at_days` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cylinder_slump` int(11) DEFAULT NULL,
  `cylinder_no_of_cubes` int(11) DEFAULT NULL,
  `cylinder_comp_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cylinder_air_content` float(10,2) DEFAULT NULL,
  `cylinder_sampled_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cylinder_avg_at_days` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_transfer` int(11) DEFAULT NULL COMMENT '1.Transfer , 2.Lost/Wastage',
  `transfer_to` int(11) DEFAULT NULL COMMENT '1.New Customer , 2.Same Customer',
  `to_customer_id` int(11) DEFAULT NULL,
  `from_customer_id` int(11) DEFAULT NULL,
  `to_delivery_id` int(11) DEFAULT NULL,
  `gate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canceled_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pushed_to_erp` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_note`
--

INSERT INTO `delivery_note` (`id`, `delivery_no`, `order_detail_id`, `vehicle_id`, `driver_id`, `operator_id`, `helper_id`, `quantity`, `pump`, `load_no`, `reject_by`, `reject_qty`, `excess_qty`, `extra_qty`, `remark`, `delivery_date`, `status`, `slump`, `no_of_cubes`, `comp_method`, `air_content`, `sampled_by`, `avg_at_days`, `cylinder_slump`, `cylinder_no_of_cubes`, `cylinder_comp_method`, `cylinder_air_content`, `cylinder_sampled_by`, `cylinder_avg_at_days`, `is_transfer`, `transfer_to`, `to_customer_id`, `from_customer_id`, `to_delivery_id`, `gate`, `canceled_reason`, `is_pushed_to_erp`, `created_at`, `updated_at`) VALUES
(1, 'DLN-00001', 5, 1, 7, 159, 18, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-22', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-22 20:53:01', '2022-02-22 20:53:01'),
(2, 'DLN-00002', 9, 2, 7, 74, 117, 3, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 00:35:28', '2022-02-24 00:35:28'),
(3, 'DLN-00003', 7, 2, 7, 74, 117, 3, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 00:35:28', '2022-02-24 00:35:28'),
(4, 'DLN-00004', 9, 2, 7, 74, 117, 3, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 00:35:28', '2022-02-24 00:35:28'),
(5, 'DLN-00005', 7, 1, 7, 74, 117, 10, 3, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 00:36:02', '2022-02-24 00:36:02'),
(6, 'DLN-00006', 8, 1, 7, 77, 118, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 00:36:23', '2022-02-24 00:36:23'),
(7, 'DLN-00007', 8, 1, 7, 77, 118, 4, 3, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 00:36:45', '2022-02-24 00:36:45'),
(8, 'DLN-00008', 10, 2, 157, 74, 117, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-23', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 03:34:46', '2022-02-24 03:34:46'),
(9, 'DLN-00009', 12, 3, 156, 133, 172, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 06:16:51', '2022-02-24 06:16:51'),
(10, 'DLN-00010', 13, 1, 155, 124, 167, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 08:00:24', '2022-02-24 08:00:24'),
(11, 'DLN-00011', 13, 1, 155, 124, 167, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 08:00:24', '2022-02-24 08:00:24'),
(12, 'DLN-00012', 13, 1, 155, 124, 167, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 08:00:24', '2022-02-24 08:00:24'),
(13, 'DLN-00013', 13, 1, 155, 124, 167, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 08:00:24', '2022-02-24 08:00:24'),
(14, 'DLN-00014', 13, 1, 155, 124, 167, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 08:00:24', '2022-02-24 08:00:24'),
(15, 'DLN-00015', 14, 3, 141, 129, 170, 10, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:23:07', '2022-02-24 16:23:07'),
(16, 'DLN-00016', 14, 3, 141, 129, 170, 5, 4, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:23:41', '2022-02-24 16:23:41'),
(17, 'DLN-00017', 12, 2, 141, 129, 170, 4, 4, 3, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:24:59', '2022-02-24 16:24:59'),
(18, 'DLN-00018', 14, 2, 141, 129, 170, 4, 4, 3, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:24:59', '2022-02-24 16:24:59'),
(19, 'DLN-00019', 14, 2, 141, 129, 170, 4, 4, 3, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:24:59', '2022-02-24 16:24:59'),
(20, 'DLN-00020', 16, 2, 141, 129, 172, 10, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:48:59', '2022-02-24 16:48:59'),
(21, 'DLN-00021', 15, 2, 141, 129, 172, 10, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:48:59', '2022-02-24 16:48:59'),
(22, 'DLN-00022', 15, 2, 141, 129, 172, 10, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 16:49:00', '2022-02-24 16:49:00'),
(23, 'DLN-00023', 16, 3, 141, 129, 172, 3, 4, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:11:31', '2022-02-24 17:11:31'),
(24, 'DLN-00024', 15, 3, 141, 129, 172, 3, 4, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:11:31', '2022-02-24 17:11:31'),
(25, 'DLN-00025', 16, 3, 141, 129, 172, 3, 4, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:11:31', '2022-02-24 17:11:31'),
(26, 'DLN-00026', 15, 3, 141, 129, 172, 2, 4, 4, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:12:59', '2022-02-24 17:12:59'),
(27, 'DLN-00027', 16, 3, 141, 129, 172, 2, 4, 4, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:12:59', '2022-02-24 17:12:59'),
(28, 'DLN-00028', 15, 3, 141, 129, 172, 2, 4, 4, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:12:59', '2022-02-24 17:12:59'),
(29, 'DLN-00029', 15, 3, 141, 129, 172, 2, 4, 4, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:12:59', '2022-02-24 17:12:59'),
(30, 'DLN-00030', 17, 3, 141, 129, 170, 10, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:16:08', '2022-02-24 17:16:08'),
(31, 'DLN-00031', 18, 3, 141, 129, 172, 5, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:19:39', '2022-02-24 17:19:39'),
(32, 'DLN-00032', 18, 3, 141, 129, 172, 5, 4, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 17:19:39', '2022-02-24 17:19:39'),
(33, 'DLN-00033', 17, 3, 141, 129, 170, 6, 4, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:39:44', '2022-02-24 22:39:44'),
(34, 'DLN-00034', 17, 1, 141, 129, 172, 8, 4, 3, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:39:59', '2022-02-24 22:39:59'),
(35, 'DLN-00035', 18, 1, 141, 129, 172, 8, 4, 3, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:39:59', '2022-02-24 22:39:59'),
(36, 'DLN-00036', 17, 1, 158, 133, 172, 10, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:40:12', '2022-02-24 22:40:12'),
(37, 'DLN-00037', 19, 1, 158, 133, 172, 10, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:40:12', '2022-02-24 22:40:12'),
(38, 'DLN-00038', 18, 1, 158, 133, 172, 10, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:40:12', '2022-02-24 22:40:12'),
(39, 'DLN-00039', 19, 2, 158, 133, 172, 5, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:40:33', '2022-02-24 22:40:33'),
(40, 'DLN-00040', 20, 3, 157, 133, 13, 5, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:46:06', '2022-02-24 22:46:06'),
(41, 'DLN-00041', 20, 3, 157, 133, 13, 5, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-24', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-24 22:46:06', '2022-02-24 22:46:06'),
(42, 'DLN-00042', 21, 1, 158, 133, 172, 10, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-02-25', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-02-25 05:05:24', '2022-02-25 05:05:24'),
(43, 'DLN-00043', 23, 1, 14121187, 63, 14121203, 11, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-08', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-08 22:24:37', '2022-05-20 00:26:25'),
(44, 'DLN-00044', 23, 5, 14121187, 63, 14121203, 9, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-08', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-08 22:31:58', '2022-03-08 22:31:58'),
(45, 'DLN-00045', 24, 17, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:33:31', '2022-03-09 21:33:31'),
(46, 'DLN-00046', 24, 17, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:33:31', '2022-03-09 21:33:31'),
(47, 'DLN-00047', 26, 36, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:36:33', '2022-03-09 21:36:33'),
(48, 'DLN-00048', 26, 23, 14121187, 63, 14121203, 11, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:42:12', '2022-03-09 21:42:12'),
(49, 'DLN-00049', 26, 23, 14121187, 63, 14121203, 11, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:42:12', '2022-03-09 21:42:12'),
(50, 'DLN-00050', 25, 1, 14121194, 18, 13, 11, 7, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:43:04', '2022-03-09 21:43:04'),
(51, 'DLN-00051', 27, 29, 14121195, 85, 14121198, 11, 8, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:45:28', '2022-03-09 21:45:28'),
(52, 'DLN-00052', 25, 13, 14121194, 18, 13, 11, 7, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:46:38', '2022-03-09 21:46:38'),
(53, 'DLN-00053', 25, 10, 14121194, 18, 13, 11, 7, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:48:37', '2022-03-09 21:48:37'),
(54, 'DLN-00054', 25, 41, 14121187, 63, 14121203, 10, 1, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:49:17', '2022-03-09 21:49:17'),
(55, 'DLN-00055', 26, 41, 14121187, 63, 14121203, 10, 1, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:49:17', '2022-03-09 21:49:17'),
(56, 'DLN-00056', 25, 34, 14121187, 63, 14121203, 11, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:49:40', '2022-03-09 21:49:40'),
(57, 'DLN-00057', 26, 34, 14121187, 63, 14121203, 11, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:49:40', '2022-03-09 21:49:40'),
(58, 'DLN-00058', 26, 34, 14121187, 63, 14121203, 11, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:49:40', '2022-03-09 21:49:40'),
(59, 'DLN-00059', 25, 42, 14121195, 85, 14121198, 10, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:50:10', '2022-03-09 21:50:10'),
(60, 'DLN-00060', 27, 42, 14121195, 85, 14121198, 10, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:50:10', '2022-03-09 21:50:10'),
(61, 'DLN-00061', 26, 42, 14121195, 85, 14121198, 10, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:50:10', '2022-03-09 21:50:10'),
(62, 'DLN-00062', 26, 42, 14121195, 85, 14121198, 10, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:50:10', '2022-03-09 21:50:10'),
(63, 'DLN-00063', 25, 28, 14121194, 85, 14121198, 11, 7, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:51:04', '2022-03-09 21:51:04'),
(64, 'DLN-00064', 25, 4, 14121187, 85, 14121198, 11, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:51:39', '2022-03-09 21:51:39'),
(65, 'DLN-00065', 26, 4, 14121187, 85, 14121198, 11, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:51:39', '2022-03-09 21:51:39'),
(66, 'DLN-00066', 27, 33, 14121195, 85, 14121198, 11, 8, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:52:15', '2022-03-09 21:52:15'),
(67, 'DLN-00067', 25, 21, 14121194, 85, 14121198, 10, 7, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:52:33', '2022-03-09 21:52:33'),
(68, 'DLN-00068', 27, 21, 14121194, 85, 14121198, 10, 7, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:52:33', '2022-03-09 21:52:33'),
(69, 'DLN-00069', 27, 20, 14121194, 85, 14121198, 10, 7, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:52:50', '2022-03-09 21:52:50'),
(70, 'DLN-00070', 25, 20, 14121194, 85, 14121198, 10, 7, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:52:50', '2022-03-09 21:52:50'),
(71, 'DLN-00071', 25, 20, 14121194, 85, 14121198, 10, 7, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:52:50', '2022-03-09 21:52:50'),
(72, 'DLN-00072', 25, 37, 14121195, 85, 14121198, 10, 8, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:07', '2022-03-09 21:53:07'),
(73, 'DLN-00073', 25, 37, 14121195, 85, 14121198, 10, 8, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:07', '2022-03-09 21:53:07'),
(74, 'DLN-00074', 27, 37, 14121195, 85, 14121198, 10, 8, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:07', '2022-03-09 21:53:07'),
(75, 'DLN-00075', 27, 37, 14121195, 85, 14121198, 10, 8, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:07', '2022-03-09 21:53:07'),
(76, 'DLN-00076', 27, 32, 14121187, 85, 14121198, 11, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:33', '2022-03-09 21:53:33'),
(77, 'DLN-00077', 25, 32, 14121187, 85, 14121198, 11, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:34', '2022-03-09 21:53:34'),
(78, 'DLN-00078', 26, 32, 14121187, 85, 14121198, 11, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:34', '2022-03-09 21:53:34'),
(79, 'DLN-00079', 27, 32, 14121187, 85, 14121198, 11, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:34', '2022-03-09 21:53:34'),
(80, 'DLN-00080', 25, 32, 14121187, 85, 14121198, 11, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:34', '2022-03-09 21:53:34'),
(81, 'DLN-00081', 25, 14, 14121194, 85, 14121198, 11, 7, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:55', '2022-03-09 21:53:55'),
(82, 'DLN-00082', 27, 14, 14121194, 85, 14121198, 11, 7, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:55', '2022-03-09 21:53:55'),
(83, 'DLN-00083', 25, 14, 14121194, 85, 14121198, 11, 7, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:55', '2022-03-09 21:53:55'),
(84, 'DLN-00084', 27, 14, 14121194, 85, 14121198, 11, 7, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:55', '2022-03-09 21:53:55'),
(85, 'DLN-00085', 25, 14, 14121194, 85, 14121198, 11, 7, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:55', '2022-03-09 21:53:55'),
(86, 'DLN-00086', 26, 14, 14121194, 85, 14121198, 11, 7, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:53:55', '2022-03-09 21:53:55'),
(87, 'DLN-00087', 26, 43, 14121187, 85, 14121198, 10, 1, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 21:55:28', '2022-03-09 21:55:28'),
(88, 'DLN-00088', 26, 5, 14121187, 85, 14121198, 11, 1, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:02:40', '2022-03-09 22:02:40'),
(89, 'DLN-00089', 26, 5, 14121187, 85, 14121198, 11, 1, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:02:40', '2022-03-09 22:02:40'),
(90, 'DLN-00090', 26, 16, 14121187, 85, 14121198, 11, 1, 15, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:04', '2022-03-09 22:03:04'),
(91, 'DLN-00091', 26, 16, 14121187, 85, 14121198, 11, 1, 15, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:04', '2022-03-09 22:03:04'),
(92, 'DLN-00092', 26, 16, 14121187, 85, 14121198, 11, 1, 15, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:04', '2022-03-09 22:03:04'),
(93, 'DLN-00093', 26, 1, 14121187, 85, 14121198, 11, 1, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:35', '2022-03-09 22:03:35'),
(94, 'DLN-00094', 26, 1, 14121187, 85, 14121198, 11, 1, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:35', '2022-03-09 22:03:35'),
(95, 'DLN-00095', 26, 1, 14121187, 85, 14121198, 11, 1, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:35', '2022-03-09 22:03:35'),
(96, 'DLN-00096', 26, 1, 14121187, 85, 14121198, 11, 1, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:03:35', '2022-03-09 22:03:35'),
(97, 'DLN-00097', 28, 21, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:05:16', '2022-03-09 22:05:16'),
(98, 'DLN-00098', 28, 28, 14121187, 63, 14121203, 11, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:05:48', '2022-03-09 22:05:48'),
(99, 'DLN-00099', 28, 28, 14121187, 63, 14121203, 11, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:05:48', '2022-03-09 22:05:48'),
(100, 'DLN-00100', 28, 37, 14121192, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:06:46', '2022-03-09 22:06:46'),
(101, 'DLN-00101', 28, 37, 14121192, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:06:46', '2022-03-09 22:06:46'),
(102, 'DLN-00102', 28, 37, 14121192, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:06:46', '2022-03-09 22:06:46'),
(103, 'DLN-00103', 29, 37, 14121192, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:06:46', '2022-03-09 22:06:46'),
(104, 'DLN-00104', 28, 14, 14121192, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:07:09', '2022-03-09 22:07:09'),
(105, 'DLN-00105', 28, 14, 14121192, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:07:09', '2022-03-09 22:07:09'),
(106, 'DLN-00106', 29, 14, 14121192, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:07:09', '2022-03-09 22:07:09'),
(107, 'DLN-00107', 28, 14, 14121192, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:07:09', '2022-03-09 22:07:09'),
(108, 'DLN-00108', 29, 14, 14121192, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:07:09', '2022-03-09 22:07:09'),
(109, 'DLN-00109', 33, 44, 14121193, 46, 14121201, 11, 6, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:09:21', '2022-03-09 22:09:21'),
(110, 'DLN-00110', 33, 1, 14121193, 46, 14121201, 11, 6, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:09:36', '2022-03-09 22:09:36'),
(111, 'DLN-00111', 33, 1, 14121193, 46, 14121201, 11, 6, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:09:36', '2022-03-09 22:09:36'),
(112, 'DLN-00112', 33, 30, 14121193, 46, 14121201, 11, 6, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:09:53', '2022-03-09 22:09:53'),
(113, 'DLN-00113', 33, 30, 14121193, 46, 14121201, 11, 6, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:09:53', '2022-03-09 22:09:53'),
(114, 'DLN-00114', 33, 30, 14121193, 46, 14121201, 11, 6, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:09:53', '2022-03-09 22:09:53'),
(115, 'DLN-00115', 33, 26, 14121193, 46, 14121201, 11, 6, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:08', '2022-03-09 22:10:08'),
(116, 'DLN-00116', 33, 26, 14121193, 46, 14121201, 11, 6, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:08', '2022-03-09 22:10:08'),
(117, 'DLN-00117', 33, 26, 14121193, 46, 14121201, 11, 6, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:08', '2022-03-09 22:10:08'),
(118, 'DLN-00118', 33, 26, 14121193, 46, 14121201, 11, 6, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:08', '2022-03-09 22:10:08'),
(119, 'DLN-00119', 33, 17, 14121191, 39, 14121202, 11, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:46', '2022-03-09 22:10:46'),
(120, 'DLN-00120', 32, 17, 14121191, 39, 14121202, 11, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:46', '2022-03-09 22:10:46'),
(121, 'DLN-00121', 33, 17, 14121191, 39, 14121202, 11, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:46', '2022-03-09 22:10:46'),
(122, 'DLN-00122', 33, 17, 14121191, 39, 14121202, 11, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:46', '2022-03-09 22:10:46'),
(123, 'DLN-00123', 33, 17, 14121191, 39, 14121202, 11, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:10:46', '2022-03-09 22:10:46'),
(124, 'DLN-00124', 33, 9, 14121191, 39, 14121202, 11, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:12', '2022-03-09 22:11:12'),
(125, 'DLN-00125', 32, 9, 14121191, 39, 14121202, 11, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:12', '2022-03-09 22:11:12'),
(126, 'DLN-00126', 33, 9, 14121191, 39, 14121202, 11, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:12', '2022-03-09 22:11:12'),
(127, 'DLN-00127', 32, 9, 14121191, 39, 14121202, 11, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:12', '2022-03-09 22:11:12'),
(128, 'DLN-00128', 33, 9, 14121191, 39, 14121202, 11, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:12', '2022-03-09 22:11:12'),
(129, 'DLN-00129', 33, 9, 14121191, 39, 14121202, 11, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:12', '2022-03-09 22:11:12'),
(130, 'DLN-00130', 30, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(131, 'DLN-00131', 33, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(132, 'DLN-00132', 33, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(133, 'DLN-00133', 32, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(134, 'DLN-00134', 33, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(135, 'DLN-00135', 32, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(136, 'DLN-00136', 33, 13, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:32', '2022-03-09 22:11:32'),
(137, 'DLN-00137', 33, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(138, 'DLN-00138', 33, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(139, 'DLN-00139', 32, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(140, 'DLN-00140', 30, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(141, 'DLN-00141', 33, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(142, 'DLN-00142', 33, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(143, 'DLN-00143', 33, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(144, 'DLN-00144', 32, 21, 14121193, 117, 14121197, 10, 6, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:11:56', '2022-03-09 22:11:56'),
(145, 'DLN-00145', 33, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(146, 'DLN-00146', 33, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(147, 'DLN-00147', 30, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(148, 'DLN-00148', 33, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(149, 'DLN-00149', 33, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(150, 'DLN-00150', 32, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(151, 'DLN-00151', 33, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(152, 'DLN-00152', 32, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(153, 'DLN-00153', 33, 35, 14121193, 117, 14121197, 2, 6, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:12:29', '2022-03-09 22:12:29'),
(154, 'DLN-00154', 32, 29, 14121191, 117, 14121197, 11, 5, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:13:05', '2022-03-09 22:13:05'),
(155, 'DLN-00155', 32, 24, 14121191, 117, 14121197, 11, 5, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:13:25', '2022-03-09 22:13:25'),
(156, 'DLN-00156', 32, 24, 14121191, 117, 14121197, 11, 5, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:13:25', '2022-03-09 22:13:25'),
(157, 'DLN-00157', 32, 40, 14121191, 117, 14121197, 11, 5, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:15:33', '2022-03-09 22:15:33'),
(158, 'DLN-00158', 32, 40, 14121191, 117, 14121197, 11, 5, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:15:33', '2022-03-09 22:15:33'),
(159, 'DLN-00159', 32, 40, 14121191, 117, 14121197, 11, 5, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:15:33', '2022-03-09 22:15:33'),
(160, 'DLN-00160', 31, 36, 14121240, 14121242, 14121243, 9, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:20:07', '2022-03-09 22:20:07'),
(161, 'DLN-00161', 31, 4, 14121191, 117, 14121197, 7, 5, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:26:23', '2022-03-09 22:26:23'),
(162, 'DLN-00162', 32, 4, 14121191, 117, 14121197, 7, 5, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:26:23', '2022-03-09 22:26:23'),
(163, 'DLN-00163', 30, 1, 14121189, 117, 14121197, 10, 3, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:30:41', '2022-03-09 22:30:41'),
(164, 'DLN-00164', 39, 2, 14121192, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:34:39', '2022-03-09 22:34:39'),
(165, 'DLN-00165', 36, 1, 14121191, 39, 14121202, 10, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:35:35', '2022-03-09 22:35:35'),
(166, 'DLN-00166', 36, 4, 14121191, 39, 14121202, 10, 5, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:36:11', '2022-03-09 22:36:11'),
(167, 'DLN-00167', 36, 4, 14121191, 39, 14121202, 10, 5, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:36:30', '2022-03-09 22:36:30'),
(168, 'DLN-00168', 36, 4, 14121191, 39, 14121202, 7, 5, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:37:11', '2022-03-09 22:37:11'),
(169, 'DLN-00169', 36, 4, 14121191, 39, 14121202, 3, 5, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:37:39', '2022-03-09 22:37:39'),
(170, 'DLN-00170', 48, 3, 14121189, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:44:38', '2022-03-09 22:44:38'),
(171, 'DLN-00171', 48, 3, 14121189, 117, 14121197, 10, 3, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:45:06', '2022-03-09 22:45:06'),
(172, 'DLN-00172', 48, 3, 14121189, 117, 14121197, 10, 3, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:45:06', '2022-03-09 22:45:06'),
(173, 'DLN-00173', 30, 24, 14121189, 117, 14121197, 10, 3, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:45:40', '2022-03-09 22:45:40'),
(174, 'DLN-00174', 29, 11, 14121192, 118, 14121204, 10, 2, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:46:27', '2022-03-09 22:46:27'),
(175, 'DLN-00175', 28, 3, 14121192, 118, 14121204, 10, 2, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:47:07', '2022-03-09 22:47:07'),
(176, 'DLN-00176', 29, 3, 14121192, 118, 14121204, 10, 2, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:47:07', '2022-03-09 22:47:07'),
(177, 'DLN-00177', 28, 10, 14121187, 118, 14121204, 11, 1, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:47:43', '2022-03-09 22:47:43'),
(178, 'DLN-00178', 28, 5, 14121187, 118, 14121204, 11, 1, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:48:15', '2022-03-09 22:48:15');
INSERT INTO `delivery_note` (`id`, `delivery_no`, `order_detail_id`, `vehicle_id`, `driver_id`, `operator_id`, `helper_id`, `quantity`, `pump`, `load_no`, `reject_by`, `reject_qty`, `excess_qty`, `extra_qty`, `remark`, `delivery_date`, `status`, `slump`, `no_of_cubes`, `comp_method`, `air_content`, `sampled_by`, `avg_at_days`, `cylinder_slump`, `cylinder_no_of_cubes`, `cylinder_comp_method`, `cylinder_air_content`, `cylinder_sampled_by`, `cylinder_avg_at_days`, `is_transfer`, `transfer_to`, `to_customer_id`, `from_customer_id`, `to_delivery_id`, `gate`, `canceled_reason`, `is_pushed_to_erp`, `created_at`, `updated_at`) VALUES
(179, 'DLN-00179', 30, 30, 14121189, 117, 14121197, 8, 3, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:48:56', '2022-03-09 22:48:56'),
(180, 'DLN-00180', 28, 1, 14121187, 118, 14121204, 11, 1, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:49:39', '2022-03-09 22:49:39'),
(181, 'DLN-00181', 28, 34, 14121187, 118, 14121204, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:50:10', '2022-03-09 22:50:10'),
(182, 'DLN-00182', 28, 9, 14121187, 118, 14121204, 10, 1, 15, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:50:32', '2022-03-09 22:50:32'),
(183, 'DLN-00183', 35, 21, 14121194, 18, 13, 10, 7, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:50:53', '2022-03-09 22:50:53'),
(184, 'DLN-00184', 28, 35, 14121187, 118, 14121204, 10, 1, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:51:43', '2022-03-09 22:51:43'),
(185, 'DLN-00185', 28, 13, 14121187, 118, 14121204, 10, 1, 17, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:52:01', '2022-03-09 22:52:01'),
(186, 'DLN-00186', 38, 7, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:54:04', '2022-03-09 22:54:04'),
(187, 'DLN-00187', 38, 6, 14121240, 14121242, 14121243, 10, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:54:33', '2022-03-09 22:54:33'),
(188, 'DLN-00188', 38, 31, 14121240, 14121242, 14121243, 10, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:54:55', '2022-03-09 22:54:55'),
(189, 'DLN-00189', 29, 15, 14121192, 118, 14121204, 10, 2, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:55:21', '2022-03-09 22:55:21'),
(190, 'DLN-00190', 47, 14, 14121194, 18, 13, 10, 7, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:55:44', '2022-03-09 22:55:44'),
(191, 'DLN-00191', 38, 18, 14121240, 14121242, 14121243, 10, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:56:15', '2022-03-09 22:56:15'),
(192, 'DLN-00192', 28, 28, 14121187, 118, 14121204, 10, 1, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:56:41', '2022-03-09 22:56:41'),
(193, 'DLN-00193', 28, 16, 14121187, 118, 14121204, 10, 1, 19, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:57:08', '2022-03-09 22:57:08'),
(194, 'DLN-00194', 38, 27, 14121240, 14121242, 14121243, 10, 11, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:57:47', '2022-03-09 22:57:47'),
(195, 'DLN-00195', 38, 8, 14121240, 14121242, 14121243, 10, 11, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:58:19', '2022-03-09 22:58:19'),
(196, 'DLN-00196', 38, 22, 14121240, 14121242, 14121243, 10, 11, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:58:43', '2022-03-09 22:58:43'),
(197, 'DLN-00197', 28, 43, 14121187, 118, 14121204, 10, 1, 20, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 22:59:03', '2022-03-09 22:59:03'),
(198, 'DLN-00198', 38, 43, 14121240, 14121242, 14121243, 10, 11, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:02:26', '2022-03-09 23:02:26'),
(199, 'DLN-00199', 38, 12, 14121240, 14121242, 14121243, 10, 11, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:03:31', '2022-03-09 23:03:31'),
(200, 'DLN-00200', 38, 12, 14121240, 14121242, 14121243, 10, 11, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:03:31', '2022-03-09 23:03:31'),
(201, 'DLN-00201', 28, 12, 14121240, 14121242, 14121243, 10, 11, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:03:31', '2022-03-09 23:03:31'),
(202, 'DLN-00202', 38, 20, 14121240, 14121242, 14121243, 10, 11, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:04:07', '2022-03-09 23:04:07'),
(203, 'DLN-00203', 38, 42, 14121240, 14121242, 14121243, 10, 11, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:04:33', '2022-03-09 23:04:33'),
(204, 'DLN-00204', 28, 44, 14121187, 14121242, 14121243, 10, 1, 22, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:04:55', '2022-03-09 23:04:55'),
(205, 'DLN-00205', 28, 33, 14121187, 14121242, 14121243, 10, 1, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:05:26', '2022-03-09 23:05:26'),
(206, 'DLN-00206', 35, 40, 14121194, 18, 13, 10, 7, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:05:54', '2022-03-09 23:05:54'),
(207, 'DLN-00207', 38, 37, 14121240, 14121242, 14121243, 10, 11, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:06:27', '2022-03-09 23:06:27'),
(208, 'DLN-00208', 45, 5, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:06:59', '2022-03-09 23:06:59'),
(209, 'DLN-00209', 42, 36, 14121193, 46, 14121201, 10, 6, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:08:19', '2022-03-09 23:08:19'),
(210, 'DLN-00210', 42, 36, 14121193, 46, 14121201, 10, 6, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:08:19', '2022-03-09 23:08:19'),
(211, 'DLN-00211', 43, 36, 14121193, 46, 14121201, 10, 6, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:08:19', '2022-03-09 23:08:19'),
(212, 'DLN-00212', 45, 4, 14121240, 14121242, 14121243, 10, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:09:11', '2022-03-09 23:09:11'),
(213, 'DLN-00213', 45, 32, 14121240, 14121242, 14121243, 10, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:09:39', '2022-03-09 23:09:39'),
(214, 'DLN-00214', 45, 17, 14121240, 14121242, 14121243, 10, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:10:05', '2022-03-09 23:10:05'),
(215, 'DLN-00215', 45, 2, 14121240, 14121242, 14121243, 10, 11, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:10:37', '2022-03-09 23:10:37'),
(216, 'DLN-00216', 45, 30, 14121240, 14121242, 14121243, 10, 11, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:11:21', '2022-03-09 23:11:21'),
(217, 'DLN-00217', 35, 11, 14121194, 18, 13, 5, 7, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:11:46', '2022-03-09 23:11:46'),
(218, 'DLN-00218', 45, 10, 14121240, 14121242, 14121243, 10, 11, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:12:35', '2022-03-09 23:12:35'),
(219, 'DLN-00219', 45, 34, 14121240, 14121242, 14121243, 10, 11, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:13:07', '2022-03-09 23:13:07'),
(220, 'DLN-00220', 45, 1, 14121240, 14121242, 14121243, 10, 11, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:13:27', '2022-03-09 23:13:27'),
(221, 'DLN-00221', 45, 7, 14121240, 14121242, 14121243, 10, 11, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:13:47', '2022-03-09 23:13:47'),
(222, 'DLN-00222', 45, 3, 14121240, 14121242, 14121243, 10, 11, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:14:06', '2022-03-09 23:14:06'),
(223, 'DLN-00223', 45, 23, 14121240, 14121242, 14121243, 10, 11, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:14:25', '2022-03-09 23:14:25'),
(224, 'DLN-00224', 39, 6, 14121192, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:14:46', '2022-03-09 23:14:46'),
(225, 'DLN-00225', 39, 6, 14121192, 118, 14121204, 10, 2, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:15:05', '2022-03-09 23:15:05'),
(226, 'DLN-00226', 39, 31, 14121192, 118, 14121204, 10, 2, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:15:25', '2022-03-09 23:15:25'),
(227, 'DLN-00227', 39, 8, 14121192, 118, 14121204, 10, 2, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:15:55', '2022-03-09 23:15:55'),
(228, 'DLN-00228', 39, 29, 14121192, 118, 14121204, 10, 2, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:16:20', '2022-03-09 23:16:20'),
(229, 'DLN-00229', 45, 35, 14121240, 14121242, 14121243, 10, 11, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:16:40', '2022-03-09 23:16:40'),
(230, 'DLN-00230', 39, 20, 14121192, 118, 14121204, 10, 2, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:17:21', '2022-03-09 23:17:21'),
(231, 'DLN-00231', 39, 22, 14121192, 118, 14121204, 10, 2, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:17:41', '2022-03-09 23:17:41'),
(232, 'DLN-00232', 39, 9, 14121192, 118, 14121204, 10, 2, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:17:57', '2022-03-09 23:17:57'),
(233, 'DLN-00233', 39, 27, 14121192, 118, 14121204, 10, 2, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:18:16', '2022-03-09 23:18:16'),
(234, 'DLN-00234', 39, 12, 14121192, 118, 14121204, 10, 2, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:18:38', '2022-03-09 23:18:38'),
(235, 'DLN-00235', 40, 37, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:19:13', '2022-03-09 23:19:13'),
(236, 'DLN-00236', 40, 43, 14121187, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:19:37', '2022-03-09 23:19:37'),
(237, 'DLN-00237', 40, 16, 14121187, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:19:51', '2022-03-09 23:19:51'),
(238, 'DLN-00238', 40, 42, 14121187, 63, 14121203, 10, 1, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:20:05', '2022-03-09 23:20:05'),
(239, 'DLN-00239', 40, 5, 14121187, 63, 14121203, 10, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:20:24', '2022-03-09 23:20:24'),
(240, 'DLN-00240', 40, 24, 14121187, 63, 14121203, 10, 1, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:20:50', '2022-03-09 23:20:50'),
(241, 'DLN-00241', 39, 18, 14121192, 118, 14121204, 10, 2, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:21:07', '2022-03-09 23:21:07'),
(242, 'DLN-00242', 39, 30, 14121192, 118, 14121204, 10, 2, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:21:47', '2022-03-09 23:21:47'),
(243, 'DLN-00243', 40, 38, 14121187, 63, 14121203, 10, 1, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:22:40', '2022-03-09 23:22:40'),
(244, 'DLN-00244', 47, 1, 14121194, 18, 13, 8, 7, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:28:26', '2022-03-09 23:28:26'),
(245, 'DLN-00245', 46, 1, 14121195, 85, 14121198, 12, 8, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:28:46', '2022-03-09 23:28:46'),
(246, 'DLN-00246', 46, 1, 14121195, 85, 14121198, 12, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:28:59', '2022-03-09 23:28:59'),
(247, 'DLN-00247', 46, 1, 14121195, 85, 14121198, 12, 8, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:29:11', '2022-03-09 23:29:11'),
(248, 'DLN-00248', 46, 1, 14121195, 85, 14121198, 10, 8, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:29:24', '2022-03-09 23:29:24'),
(249, 'DLN-00249', 46, 1, 14121195, 85, 14121198, 10, 8, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:29:33', '2022-03-09 23:29:33'),
(250, 'DLN-00250', 46, 1, 14121195, 85, 14121198, 10, 8, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:29:33', '2022-03-09 23:29:33'),
(251, 'DLN-00251', 46, 1, 14121195, 85, 14121198, 10, 8, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:29:43', '2022-03-09 23:29:43'),
(252, 'DLN-00252', 46, 1, 14121195, 85, 14121198, 10, 8, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:29:52', '2022-03-09 23:29:52'),
(253, 'DLN-00253', 46, 1, 14121195, 85, 14121198, 4, 8, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:30:01', '2022-03-09 23:30:01'),
(254, 'DLN-00254', 34, 1, 14121195, 85, 14121198, 10, 8, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:30:11', '2022-03-09 23:30:11'),
(255, 'DLN-00255', 34, 1, 14121195, 85, 14121198, 10, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:30:19', '2022-03-09 23:30:19'),
(256, 'DLN-00256', 44, 1, 14121195, 85, 14121198, 10, 8, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:30:30', '2022-03-09 23:30:30'),
(257, 'DLN-00257', 31, 1, 14121240, 117, 14121197, 2, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:30:39', '2022-03-09 23:30:39'),
(258, 'DLN-00258', 41, 1, 14121189, 117, 14121197, 11, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:30:51', '2022-03-09 23:30:51'),
(259, 'DLN-00259', 28, 1, 14121187, 14121242, 14121243, 10, 1, 24, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:31:01', '2022-03-09 23:31:01'),
(260, 'DLN-00260', 28, 1, 14121187, 14121242, 14121243, 5, 1, 25, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:31:16', '2022-03-09 23:31:16'),
(261, 'DLN-00261', 37, 1, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:31:26', '2022-03-09 23:31:26'),
(262, 'DLN-00262', 37, 1, 14121240, 14121242, 14121243, 10, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:31:37', '2022-03-09 23:31:37'),
(263, 'DLN-00263', 37, 1, 14121240, 14121242, 14121243, 10, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:31:45', '2022-03-09 23:31:45'),
(264, 'DLN-00264', 44, 1, 14121195, 85, 14121198, 10, 8, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:18', '2022-03-09 23:37:18'),
(265, 'DLN-00265', 44, 1, 14121195, 85, 14121198, 10, 8, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:25', '2022-03-09 23:37:25'),
(266, 'DLN-00266', 44, 1, 14121195, 85, 14121198, 10, 8, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:25', '2022-03-09 23:37:25'),
(267, 'DLN-00267', 44, 1, 14121195, 85, 14121198, 10, 8, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:30', '2022-03-09 23:37:30'),
(268, 'DLN-00268', 44, 1, 14121195, 85, 14121198, 10, 8, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:30', '2022-03-09 23:37:30'),
(269, 'DLN-00269', 44, 1, 14121195, 85, 14121198, 10, 8, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:30', '2022-03-09 23:37:30'),
(270, 'DLN-00270', 44, 1, 14121195, 85, 14121198, 10, 8, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:36', '2022-03-09 23:37:36'),
(271, 'DLN-00271', 44, 1, 14121195, 85, 14121198, 10, 8, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:36', '2022-03-09 23:37:36'),
(272, 'DLN-00272', 44, 1, 14121195, 85, 14121198, 10, 8, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:36', '2022-03-09 23:37:36'),
(273, 'DLN-00273', 44, 1, 14121195, 85, 14121198, 10, 8, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:36', '2022-03-09 23:37:36'),
(274, 'DLN-00274', 44, 1, 14121195, 85, 14121198, 10, 8, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:43', '2022-03-09 23:37:43'),
(275, 'DLN-00275', 44, 1, 14121195, 85, 14121198, 10, 8, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:43', '2022-03-09 23:37:43'),
(276, 'DLN-00276', 44, 1, 14121195, 85, 14121198, 10, 8, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:43', '2022-03-09 23:37:43'),
(277, 'DLN-00277', 44, 1, 14121195, 85, 14121198, 10, 8, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:43', '2022-03-09 23:37:43'),
(278, 'DLN-00278', 44, 1, 14121195, 85, 14121198, 10, 8, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:43', '2022-03-09 23:37:43'),
(279, 'DLN-00279', 40, 1, 14121187, 63, 14121203, 10, 1, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:37:57', '2022-03-09 23:37:57'),
(280, 'DLN-00280', 40, 1, 14121187, 63, 14121203, 10, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:06', '2022-03-09 23:38:06'),
(281, 'DLN-00281', 40, 1, 14121187, 63, 14121203, 10, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:06', '2022-03-09 23:38:06'),
(282, 'DLN-00282', 40, 1, 14121187, 63, 14121203, 10, 1, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:11', '2022-03-09 23:38:11'),
(283, 'DLN-00283', 40, 1, 14121187, 63, 14121203, 10, 1, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:11', '2022-03-09 23:38:11'),
(284, 'DLN-00284', 40, 1, 14121187, 63, 14121203, 10, 1, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:11', '2022-03-09 23:38:11'),
(285, 'DLN-00285', 40, 1, 14121187, 63, 14121203, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:17', '2022-03-09 23:38:17'),
(286, 'DLN-00286', 40, 1, 14121187, 63, 14121203, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:17', '2022-03-09 23:38:17'),
(287, 'DLN-00287', 40, 1, 14121187, 63, 14121203, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:17', '2022-03-09 23:38:17'),
(288, 'DLN-00288', 40, 1, 14121187, 63, 14121203, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-09 23:38:17', '2022-03-09 23:38:17'),
(289, 'DLN-00289', 50, 1, 14121192, 118, 14121204, 11, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:00:11', '2022-03-10 22:00:11'),
(290, 'DLN-00290', 50, 14, 14121192, 118, 14121204, 11, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:01:17', '2022-03-10 22:01:17'),
(291, 'DLN-00291', 50, 30, 14121192, 118, 14121204, 11, 2, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:02:05', '2022-03-10 22:02:05'),
(292, 'DLN-00292', 50, 20, 14121192, 118, 14121204, 10, 2, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:02:33', '2022-03-10 22:02:33'),
(293, 'DLN-00293', 50, 36, 14121192, 118, 14121204, 10, 2, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:02:59', '2022-03-10 22:02:59'),
(294, 'DLN-00294', 50, 31, 14121192, 118, 14121204, 11, 2, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:03:30', '2022-03-10 22:03:30'),
(295, 'DLN-00295', 50, 16, 14121192, 118, 14121204, 11, 2, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:03:50', '2022-03-10 22:03:50'),
(296, 'DLN-00296', 50, 10, 14121192, 118, 14121204, 11, 2, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:04:14', '2022-03-10 22:04:14'),
(297, 'DLN-00297', 50, 44, 14121192, 118, 14121204, 11, 2, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:04:33', '2022-03-10 22:04:33'),
(298, 'DLN-00298', 50, 5, 14121192, 118, 14121204, 11, 2, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:05:01', '2022-03-10 22:05:01'),
(299, 'DLN-00299', 50, 32, 14121192, 118, 14121204, 11, 2, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:05:44', '2022-03-10 22:05:44'),
(300, 'DLN-00300', 50, 27, 14121192, 118, 14121204, 11, 2, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:06:07', '2022-03-10 22:06:07'),
(301, 'DLN-00301', 50, 15, 14121192, 118, 14121204, 11, 2, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:06:34', '2022-03-10 22:06:34'),
(302, 'DLN-00302', 50, 7, 14121192, 118, 14121204, 11, 2, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:07:02', '2022-03-10 22:07:02'),
(303, 'DLN-00303', 50, 42, 14121192, 118, 14121204, 10, 2, 15, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:07:48', '2022-03-10 22:07:48'),
(304, 'DLN-00304', 50, 36, 14121192, 118, 14121204, 10, 2, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:08:04', '2022-03-10 22:08:04'),
(305, 'DLN-00305', 50, 35, 14121192, 118, 14121204, 11, 2, 17, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:08:38', '2022-03-10 22:08:38'),
(306, 'DLN-00306', 50, 44, 14121192, 118, 14121204, 11, 2, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:11:27', '2022-03-10 22:11:27'),
(307, 'DLN-00307', 50, 32, 14121192, 118, 14121204, 11, 2, 19, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:27:53', '2022-03-10 22:27:53'),
(308, 'DLN-00308', 50, 39, 14121192, 118, 14121204, 10, 2, 20, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:48:33', '2022-03-10 22:48:33'),
(309, 'DLN-00309', 50, 7, 14121192, 118, 14121204, 11, 2, 21, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:49:17', '2022-03-10 22:49:17'),
(310, 'DLN-00310', 50, 15, 14121192, 118, 14121204, 11, 2, 22, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:49:48', '2022-03-10 22:49:48'),
(311, 'DLN-00311', 50, 10, 14121192, 118, 14121204, 11, 2, 23, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:51:42', '2022-03-10 22:51:42'),
(312, 'DLN-00312', 50, 2, 14121192, 118, 14121204, 11, 2, 24, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:52:07', '2022-03-10 22:52:07'),
(313, 'DLN-00313', 50, 6, 14121192, 118, 14121204, 11, 2, 25, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:52:32', '2022-03-10 22:52:32'),
(314, 'DLN-00314', 50, 17, 14121192, 118, 14121204, 10, 2, 26, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 22:55:46', '2022-03-10 22:55:46'),
(315, 'DLN-00315', 50, 36, 14121192, 118, 14121204, 10, 2, 27, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:05:54', '2022-03-10 23:05:54'),
(316, 'DLN-00316', 50, 3, 14121192, 118, 14121204, 10, 2, 28, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:06:20', '2022-03-10 23:06:20'),
(317, 'DLN-00317', 50, 32, 14121192, 118, 14121204, 10, 2, 29, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:15:07', '2022-03-10 23:15:07'),
(318, 'DLN-00318', 50, 43, 14121192, 118, 14121204, 10, 2, 30, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:29:40', '2022-03-10 23:29:40'),
(319, 'DLN-00319', 50, 12, 14121192, 118, 14121204, 10, 2, 31, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:29:59', '2022-03-10 23:29:59'),
(320, 'DLN-00320', 50, 15, 14121192, 118, 14121204, 10, 2, 32, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:33:11', '2022-03-10 23:33:11'),
(321, 'DLN-00321', 50, 23, 14121192, 118, 14121204, 10, 2, 33, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:35:09', '2022-03-10 23:35:09'),
(322, 'DLN-00322', 50, 36, 14121192, 118, 14121204, 10, 2, 34, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:39:06', '2022-03-10 23:39:06'),
(323, 'DLN-00323', 50, 39, 14121192, 118, 14121204, 10, 2, 35, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:39:29', '2022-03-10 23:39:29'),
(324, 'DLN-00324', 50, 30, 14121192, 118, 14121204, 10, 2, 36, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:47:50', '2022-03-10 23:47:50'),
(325, 'DLN-00325', 50, 40, 14121192, 118, 14121204, 10, 2, 37, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:48:12', '2022-03-10 23:48:12'),
(326, 'DLN-00326', 50, 24, 14121192, 118, 14121204, 10, 2, 38, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:48:40', '2022-03-10 23:48:40'),
(327, 'DLN-00327', 50, 2, 14121192, 118, 14121204, 11, 2, 39, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:58:21', '2022-03-10 23:58:21'),
(328, 'DLN-00328', 50, 39, 14121192, 118, 14121204, 5, 2, 40, NULL, NULL, NULL, NULL, NULL, '2022-03-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-10 23:58:55', '2022-03-10 23:58:55'),
(329, 'DLN-00329', 51, 40, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:47:00', '2022-03-14 17:47:00'),
(330, 'DLN-00330', 51, 6, 14121240, 14121242, 14121243, 11, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:48:28', '2022-03-14 17:48:28'),
(331, 'DLN-00331', 51, 4, 14121240, 14121242, 14121243, 10, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:49:06', '2022-03-14 17:49:06'),
(332, 'DLN-00332', 51, 35, 14121240, 14121242, 14121243, 11, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:49:39', '2022-03-14 17:49:39'),
(333, 'DLN-00333', 51, 27, 14121240, 14121242, 14121243, 11, 11, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:50:11', '2022-03-14 17:50:11'),
(334, 'DLN-00334', 51, 31, 14121240, 14121242, 14121243, 11, 11, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:50:38', '2022-03-14 17:50:38'),
(335, 'DLN-00335', 51, 36, 14121240, 14121242, 14121243, 10, 11, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:51:10', '2022-03-14 17:51:10'),
(336, 'DLN-00336', 51, 24, 14121240, 14121242, 14121243, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:51:40', '2022-03-14 17:51:40'),
(337, 'DLN-00337', 51, 33, 14121240, 14121242, 14121243, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:52:09', '2022-03-14 17:52:09'),
(338, 'DLN-00338', 51, 34, 14121240, 14121242, 14121243, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:52:45', '2022-03-14 17:52:45'),
(339, 'DLN-00339', 51, 20, 14121240, 14121242, 14121243, 10, 11, 11, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:53:05', '2022-03-14 17:53:05'),
(340, 'DLN-00340', 51, 19, 14121240, 14121242, 14121243, 10, 11, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:53:24', '2022-03-14 17:53:24'),
(341, 'DLN-00341', 51, 17, 14121240, 14121242, 14121243, 11, 11, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:53:44', '2022-03-14 17:53:44'),
(342, 'DLN-00342', 51, 35, 14121240, 14121242, 14121243, 10, 11, 14, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:54:12', '2022-03-14 17:54:12'),
(343, 'DLN-00343', 51, 26, 14121240, 14121242, 14121243, 11, 11, 15, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:54:34', '2022-03-14 17:54:34'),
(344, 'DLN-00344', 51, 41, 14121240, 14121242, 14121243, 10, 11, 16, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:55:09', '2022-03-14 17:55:09'),
(345, 'DLN-00345', 51, 42, 14121240, 14121242, 14121243, 10, 11, 17, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:55:33', '2022-03-14 17:55:33'),
(346, 'DLN-00346', 51, 30, 14121240, 14121242, 14121243, 11, 11, 18, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:55:54', '2022-03-14 17:55:54'),
(347, 'DLN-00347', 51, 11, 14121240, 14121242, 14121243, 11, 11, 19, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 17:59:36', '2022-03-14 17:59:36'),
(348, 'DLN-00348', 51, 11, 14121240, 14121242, 14121243, 10, 11, 20, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:01:01', '2022-03-14 18:01:01'),
(349, 'DLN-00349', 51, 11, 14121240, 14121242, 14121243, 10, 11, 20, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:01:01', '2022-03-14 18:01:01'),
(350, 'DLN-00350', 51, 18, 14121240, 14121242, 14121243, 9, 11, 22, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:04:48', '2022-03-14 18:04:48'),
(351, 'DLN-00351', 52, 1, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:26:35', '2022-03-14 18:26:35'),
(352, 'DLN-00352', 52, 1, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:26:35', '2022-03-14 18:26:35');
INSERT INTO `delivery_note` (`id`, `delivery_no`, `order_detail_id`, `vehicle_id`, `driver_id`, `operator_id`, `helper_id`, `quantity`, `pump`, `load_no`, `reject_by`, `reject_qty`, `excess_qty`, `extra_qty`, `remark`, `delivery_date`, `status`, `slump`, `no_of_cubes`, `comp_method`, `air_content`, `sampled_by`, `avg_at_days`, `cylinder_slump`, `cylinder_no_of_cubes`, `cylinder_comp_method`, `cylinder_air_content`, `cylinder_sampled_by`, `cylinder_avg_at_days`, `is_transfer`, `transfer_to`, `to_customer_id`, `from_customer_id`, `to_delivery_id`, `gate`, `canceled_reason`, `is_pushed_to_erp`, `created_at`, `updated_at`) VALUES
(353, 'DLN-00353', 52, 3, 14121240, 14121242, 14121243, 10, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:28:08', '2022-03-14 18:28:08'),
(354, 'DLN-00354', 52, 2, 14121240, 14121242, 14121243, 10, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:29:12', '2022-03-14 18:29:12'),
(355, 'DLN-00355', 52, 2, 14121240, 14121242, 14121243, 10, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:29:12', '2022-03-14 18:29:12'),
(356, 'DLN-00356', 52, 4, 14121240, 14121242, 14121243, 10, 11, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:30:14', '2022-03-14 18:30:14'),
(357, 'DLN-00357', 52, 4, 14121240, 14121242, 14121243, 10, 11, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:30:14', '2022-03-14 18:30:14'),
(358, 'DLN-00358', 52, 4, 14121240, 14121242, 14121243, 10, 11, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 18:30:14', '2022-03-14 18:30:14'),
(359, 'DLN-00359', 53, 3, 14121240, 14121242, 14121243, 12, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 19:11:27', '2022-03-14 19:11:27'),
(360, 'DLN-00360', 53, 4, 14121240, 14121242, 14121243, 10, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 19:13:28', '2022-03-14 19:13:28'),
(361, 'DLN-00361', 53, 4, 14121240, 14121242, 14121243, 10, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 19:13:28', '2022-03-14 19:13:28'),
(362, 'DLN-00362', 54, 4, 14121240, 14121242, 14121243, 12, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 21:06:15', '2022-03-14 21:06:15'),
(363, 'DLN-00363', 54, 4, 14121240, 14121242, 14121243, 12, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 21:08:18', '2022-03-14 21:08:18'),
(364, 'DLN-00364', 54, 4, 14121240, 14121242, 14121243, 12, 11, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-14 21:08:18', '2022-03-14 21:08:18'),
(365, 'DLN-00365', 56, 1, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-16 04:44:50', '2022-03-16 04:44:50'),
(366, 'DLN-00366', 56, 2, 14121187, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-16 04:45:19', '2022-03-16 04:45:19'),
(367, 'DLN-00367', 56, 2, 14121187, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-16 04:45:19', '2022-03-16 04:45:19'),
(368, 'DLN-00368', 57, 1, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 03:19:36', '2022-03-17 03:19:36'),
(369, 'DLN-00369', 57, 2, 14121187, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 03:20:13', '2022-03-17 03:20:13'),
(370, 'DLN-00370', 57, 2, 14121187, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 03:20:13', '2022-03-17 03:20:13'),
(371, 'DLN-00371', 61, 1, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 15:43:56', '2022-03-17 15:43:56'),
(372, 'DLN-00372', 61, 1, 14121240, 14121242, 14121243, 10, 11, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 15:43:57', '2022-03-17 15:43:57'),
(373, 'DLN-00373', 61, 5, 14121240, 14121242, 14121243, 9, 11, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 15:44:48', '2022-03-17 15:44:48'),
(374, 'DLN-00374', 61, 2, 14121240, 14121242, 14121243, 1, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 16:30:51', '2022-03-17 16:30:51'),
(375, 'DLN-00375', 62, 2, 14121240, 14121242, 14121243, 1, 11, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 16:30:51', '2022-03-17 16:30:51'),
(376, 'DLN-00376', 62, 1, 55, 14121242, 14121243, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 17:44:47', '2022-03-17 17:44:47'),
(377, 'DLN-00377', 62, 1, 55, 14121242, 14121243, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 17:44:47', '2022-03-17 17:44:47'),
(378, 'DLN-00378', 62, 3, 115, 14121242, 14121243, 1, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 17:45:29', '2022-03-17 17:45:29'),
(379, 'DLN-00379', 63, 1, 55, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 17:54:18', '2022-03-17 17:54:18'),
(380, 'DLN-00380', 60, 1, 55, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 19:52:25', '2022-03-17 19:52:25'),
(381, 'DLN-00381', 64, 3, 158, 14121242, 14121243, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 19:56:24', '2022-03-17 19:56:24'),
(382, 'DLN-00382', 64, 3, 158, 14121242, 14121243, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 19:56:24', '2022-03-17 19:56:24'),
(383, 'DLN-00383', 64, 5, 158, 14121242, 14121243, 10, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 19:57:15', '2022-03-17 19:57:15'),
(384, 'DLN-00384', 64, 14, 158, 14121242, 14121243, 10, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-17 19:57:50', '2022-03-17 19:57:50'),
(385, 'DLN-00385', 65, 1, 55, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:09:29', '2022-03-18 03:09:29'),
(386, 'DLN-00386', 65, 1, 55, 144, 167, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:09:49', '2022-03-18 03:09:49'),
(387, 'DLN-00387', 65, 2, 64, 144, 167, 2, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:10:07', '2022-03-18 03:10:07'),
(388, 'DLN-00388', 63, 2, 64, 144, 167, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:10:24', '2022-03-18 03:10:24'),
(389, 'DLN-00389', 63, 1, 55, 144, 167, 2, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:10:48', '2022-03-18 03:10:48'),
(390, 'DLN-00390', 60, 2, 64, 144, 167, 230, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:11:18', '2022-03-18 03:11:18'),
(391, 'DLN-00391', 60, 2, 64, 144, 167, 230, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:11:18', '2022-03-18 03:11:18'),
(392, 'DLN-00392', 64, 2, 158, 14121242, 14121243, 5, NULL, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-18 03:11:40', '2022-03-18 03:11:40'),
(393, 'DLN-00393', 66, 3, 115, 144, 167, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 18:38:24', '2022-03-20 18:38:24'),
(394, 'DLN-00394', 67, 4, 97, 14121242, 14121243, 11, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 18:41:29', '2022-03-20 18:41:29'),
(395, 'DLN-00395', 67, 5, 111, 14121242, 14121243, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 18:50:37', '2022-03-20 18:50:37'),
(396, 'DLN-00396', 67, 2, 64, 14121242, 14121243, 4, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 18:53:58', '2022-03-20 18:53:58'),
(397, 'DLN-00397', 68, 3, 115, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 20:41:32', '2022-03-20 20:41:32'),
(398, 'DLN-00398', 68, 3, 115, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 20:41:32', '2022-03-20 20:41:32'),
(399, 'DLN-00399', 69, 3, 116, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 21:10:27', '2022-03-20 21:10:27'),
(400, 'DLN-00400', 70, 3, 116, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 21:18:23', '2022-03-20 21:18:23'),
(401, 'DLN-00401', 70, 3, 116, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 21:18:23', '2022-03-20 21:18:23'),
(402, 'DLN-00402', 70, 3, 116, 144, 167, 10, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-20', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-20 21:20:14', '2022-03-20 21:20:14'),
(403, 'DLN-00403', 74, 2, 64, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:33:38', '2022-03-26 16:33:38'),
(404, 'DLN-00404', 74, 4, 97, 133, 167, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:35:41', '2022-03-26 16:35:41'),
(405, 'DLN-00405', 74, 5, 111, 133, 167, 10, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:50:33', '2022-03-26 16:50:33'),
(406, 'DLN-00406', 74, 5, 111, 133, 167, 10, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:54:55', '2022-03-26 16:54:55'),
(407, 'DLN-00407', 74, 5, 111, 133, 167, 10, NULL, 5, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:55:09', '2022-03-26 16:55:09'),
(408, 'DLN-00408', 74, 5, 111, 133, 167, 10, NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:55:24', '2022-03-26 16:55:24'),
(409, 'DLN-00409', 74, 5, 111, 133, 167, 10, NULL, 7, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 16:56:06', '2022-03-26 16:56:06'),
(410, 'DLN-00410', 74, 5, 111, 133, 167, 10, NULL, 8, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 17:33:36', '2022-03-26 17:33:36'),
(411, 'DLN-00411', 77, 8, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 20:32:15', '2022-03-26 20:32:15'),
(412, 'DLN-00412', 77, 4, 14121187, 63, 14121203, 5, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 20:34:22', '2022-03-26 20:34:22'),
(413, 'DLN-00413', 78, 13, 89, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-26 20:36:39', '2022-03-26 20:36:39'),
(414, 'DLN-00414', 80, 3, 14121187, 78, 14121202, 7, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-27', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-27 22:56:43', '2022-03-27 23:03:20'),
(415, 'DLN-00415', 80, 3, 14121187, 78, 14121202, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-27', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-27 23:02:52', '2022-03-27 23:02:52'),
(416, 'DLN-00416', 81, 1, 55, 63, 14121203, 10, 1, 1, 3, NULL, 5, NULL, NULL, '2022-03-28', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 418, NULL, NULL, '1', '2022-03-28 17:27:12', '2022-03-28 17:35:16'),
(417, 'DLN-00417', 81, 5, 111, 63, 14121203, 5, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-28', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-28 17:27:57', '2022-03-28 17:31:25'),
(418, 'DLN-00418', 0, 1, 55, 63, 14121203, 5, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-28', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-28 17:30:51', '2022-03-28 17:34:55'),
(419, 'DLN-00419', 81, 3, 115, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-28', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-28 17:32:46', '2022-03-28 17:34:56'),
(420, 'DLN-00420', 81, 3, 115, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-03-28', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-28 17:32:46', '2022-03-28 17:34:58'),
(421, 'DLN-00421', 82, 1, 14121192, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-28', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-28 19:33:56', '2022-03-28 19:33:56'),
(422, 'DLN-00422', 83, 4, 97, 63, 14121203, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-28', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-28 19:34:29', '2022-03-28 19:34:29'),
(423, 'DLN-00423', 84, 3, 115, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-29', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 20:48:39', '2022-03-29 20:50:10'),
(424, 'DLN-00424', 84, 3, 115, NULL, NULL, 10, NULL, 2, 1, 5, NULL, NULL, NULL, '2022-03-29', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 14121178, 14121175, 426, NULL, NULL, '0', '2022-03-29 20:49:29', '2022-03-29 21:00:21'),
(425, 'DLN-00425', 84, 4, 97, NULL, NULL, 10, NULL, 3, 2, 5, NULL, NULL, NULL, '2022-03-29', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 20:49:43', '2022-03-29 21:00:23'),
(426, 'DLN-00426', 85, 3, 115, NULL, NULL, 5, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-29', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 20:53:20', '2022-03-29 21:00:37'),
(427, 'DLN-00427', 84, NULL, 149, NULL, NULL, 10, NULL, 4, 3, NULL, 5, NULL, NULL, '2022-03-29', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 20:56:58', '2022-03-29 21:00:33'),
(428, 'DLN-00428', 85, 3, 115, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-29', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 20:59:34', '2022-03-29 21:00:31'),
(429, 'DLN-00429', 86, 4, 14121187, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-03-29', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 21:07:07', '2022-03-29 21:07:31'),
(430, 'DLN-00430', 86, 3, 14121187, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-03-29', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-03-29 21:08:01', '2022-03-29 21:34:23'),
(431, 'DLN-00431', 87, 1, 65, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-09', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-09 10:34:33', '2022-04-22 03:19:30'),
(432, 'DLN-00432', 87, NULL, NULL, 63, 14121203, 5, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-09 21:09:42', '2022-04-09 21:09:42'),
(433, 'DLN-00433', 87, NULL, NULL, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-09', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-09 21:12:11', '2022-04-09 21:12:11'),
(434, 'DLN-00434', 89, 1, 55, 144, 167, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 04:09:47', '2022-04-10 04:09:47'),
(435, 'DLN-00435', 90, NULL, 158, 63, 14121203, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 16:27:57', '2022-04-10 16:27:57'),
(436, 'DLN-00436', 91, NULL, 158, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 16:31:21', '2022-04-10 16:31:21'),
(437, 'DLN-00437', 91, NULL, 158, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 16:31:21', '2022-04-10 16:31:21'),
(438, 'DLN-00438', 89, NULL, NULL, 144, 167, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 16:32:40', '2022-04-10 16:32:40'),
(439, 'DLN-00439', 92, NULL, 155, 39, 14121202, 1, 5, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 16:36:00', '2022-04-10 16:36:00'),
(440, 'DLN-00440', 93, NULL, 141, 22, 14, 10, 9, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 16:43:44', '2022-04-10 16:43:44'),
(441, 'DLN-00441', 94, NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 17:07:51', '2022-04-10 17:07:51'),
(442, 'DLN-00442', 95, NULL, 126, 133, 14121199, 10, 10, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 18:22:39', '2022-04-10 18:22:39'),
(443, 'DLN-00443', 95, NULL, 126, 133, 14121199, 10, 10, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 18:22:39', '2022-04-10 18:22:39'),
(444, 'DLN-00444', 93, NULL, 141, 22, 14, 3, 9, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 18:29:47', '2022-04-10 18:29:47'),
(445, 'DLN-00445', 94, NULL, NULL, NULL, NULL, 5, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-10', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-10 18:30:00', '2022-04-10 18:30:00'),
(446, 'DLN-00446', 96, NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-11', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-11 16:15:47', '2022-04-11 16:15:47'),
(447, 'DLN-00447', 97, NULL, 152, 133, 14121199, 12, 10, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-11', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-11 16:41:48', '2022-04-11 16:41:48'),
(448, 'DLN-00448', 97, NULL, 152, 133, 14121199, 1, 10, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-11', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-11 17:02:23', '2022-04-11 17:02:23'),
(449, 'DLN-00449', 98, NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-11', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-11 17:26:33', '2022-04-11 17:26:33'),
(450, 'DLN-00450', 99, NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-11', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 01:24:15', '2022-04-12 01:24:15'),
(451, 'DLN-00451', 100, 3, 158, 144, 167, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 07:25:45', '2022-04-12 07:25:45'),
(452, 'DLN-00452', 100, NULL, 158, 144, 167, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 19:03:25', '2022-04-12 19:03:25'),
(453, 'DLN-00453', 100, NULL, 158, 144, 167, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 19:03:27', '2022-04-12 19:03:27'),
(454, 'DLN-00454', 99, NULL, NULL, NULL, NULL, 7, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 19:03:35', '2022-04-12 19:03:35'),
(455, 'DLN-00455', 100, NULL, 158, 144, 167, 12, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 19:03:52', '2022-04-12 19:03:52'),
(456, 'DLN-00456', 100, NULL, 158, 144, 167, 12, NULL, 5, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-12 19:04:08', '2022-04-12 19:04:08'),
(457, 'DLN-00457', 101, NULL, NULL, NULL, NULL, 10, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-12', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-13 00:19:42', '2022-04-13 00:19:42'),
(458, 'DLN-00458', 101, NULL, NULL, NULL, NULL, 10, NULL, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-13', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-13 14:32:31', '2022-04-13 14:32:31'),
(459, 'DLN-00459', 101, NULL, NULL, NULL, NULL, 1, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-13', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-13 18:18:20', '2022-04-13 18:18:20'),
(460, 'DLN-00460', 101, NULL, NULL, NULL, NULL, 1, NULL, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-13', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-13 18:18:20', '2022-04-13 18:18:20'),
(461, 'DLN-00461', 102, 1, 157, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-14 04:21:01', '2022-04-14 04:21:01'),
(462, 'DLN-00462', 103, 3, 115, 118, 14121204, 10, 2, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-14', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-14 04:22:19', '2022-04-14 04:22:19'),
(463, 'DLN-00463', 102, NULL, 157, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-17', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2022-04-17 17:27:41', '2022-04-20 20:48:11'),
(464, 'DLN-00464', 103, NULL, NULL, 118, 14121204, 10, 2, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-17', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2022-04-17 17:28:01', '2022-04-20 20:48:12'),
(465, 'DLN-00465', 103, NULL, NULL, 118, 14121204, 5, 2, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-17', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2022-04-17 17:28:52', '2022-04-20 20:48:13'),
(466, 'DLN-00466', 104, NULL, 158, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:14:41', '2022-04-20 20:43:54'),
(467, 'DLN-00467', 104, NULL, 158, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:15:03', '2022-04-20 20:44:05'),
(468, 'DLN-00468', 104, NULL, 158, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:15:15', '2022-04-20 20:43:57'),
(469, 'DLN-00469', 104, NULL, 158, 63, 14121203, 10, 1, 4, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:15:26', '2022-04-20 20:43:59'),
(470, 'DLN-00470', 104, NULL, 158, 63, 14121203, 10, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:15:34', '2022-04-20 20:44:00'),
(471, 'DLN-00471', 104, NULL, 158, 63, 14121203, 10, 1, 6, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:15:44', '2022-04-20 20:44:01'),
(472, 'DLN-00472', 104, NULL, 158, 63, 14121203, 10, 1, 7, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:15:53', '2022-04-20 20:44:04'),
(473, 'DLN-00473', 104, NULL, 158, 63, 14121203, 10, 1, 8, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:16:02', '2022-04-20 20:47:42'),
(474, 'DLN-00474', 104, NULL, 158, 63, 14121203, 10, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:16:11', '2022-04-20 20:47:43'),
(475, 'DLN-00475', 104, NULL, 158, 63, 14121203, 10, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 17:16:20', '2022-04-20 20:47:44'),
(476, 'DLN-00476', 105, 5, 158, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:10:24', '2022-04-20 20:47:45'),
(477, 'DLN-00477', 105, 20, 158, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:12:29', '2022-04-19 18:12:29'),
(478, 'DLN-00478', 105, 1, 158, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:13:49', '2022-04-19 18:13:49'),
(479, 'DLN-00479', 105, 42, 158, 63, 14121203, 10, 1, 4, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:33:23', '2022-04-19 18:33:23'),
(480, 'DLN-00480', 105, 31, 158, 63, 14121203, 10, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:33:53', '2022-04-19 18:33:53'),
(481, 'DLN-00481', 105, 41, 158, 63, 14121203, 10, 1, 6, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:34:18', '2022-04-19 18:34:18'),
(482, 'DLN-00482', 105, 38, 158, 63, 14121203, 10, 1, 7, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:36:50', '2022-04-19 18:36:50'),
(483, 'DLN-00483', 105, 19, 158, 63, 14121203, 9, 1, 8, NULL, NULL, NULL, NULL, NULL, '2022-04-19', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-19 18:37:34', '2022-04-19 18:37:34'),
(484, 'DLN-00484', 105, 1, 158, 63, 14121203, 10, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-04-21', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-21 17:42:10', '2022-04-21 17:42:10'),
(485, 'DLN-00485', 105, 2, 158, 63, 14121203, 11, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-04-21', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-21 17:42:24', '2022-04-21 17:42:24'),
(486, 'DLN-00486', 105, NULL, 158, 63, 14121203, 10, 1, 11, NULL, NULL, NULL, NULL, NULL, '2022-04-21', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-21 17:42:36', '2022-04-21 17:42:36'),
(487, 'DLN-00487', 105, NULL, 158, 63, 14121203, 10, 1, 12, NULL, NULL, NULL, NULL, NULL, '2022-04-21', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-21 17:42:45', '2022-04-21 17:42:45'),
(488, 'DLN-00488', 105, NULL, 158, 63, 14121203, 10, 1, 13, NULL, NULL, NULL, NULL, NULL, '2022-04-21', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-21 17:42:54', '2022-04-21 17:42:54'),
(489, 'DLN-00489', 105, NULL, 158, 63, 14121203, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-04-21', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-21 17:43:02', '2022-04-21 17:43:02'),
(490, 'DLN-00490', 106, NULL, NULL, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:27:45', '2022-04-26 16:27:45'),
(491, 'DLN-00491', 106, NULL, NULL, 63, 14121203, 6, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:27:56', '2022-04-26 16:27:56'),
(492, 'DLN-00492', 108, NULL, NULL, 63, 14121203, 10, 1, 1, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:28:05', '2022-04-26 16:28:05'),
(493, 'DLN-00493', 108, NULL, NULL, 63, 14121203, 10, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:28:15', '2022-04-26 16:28:15'),
(494, 'DLN-00494', 108, NULL, NULL, 63, 14121203, 10, 1, 3, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:28:23', '2022-04-26 16:28:23'),
(495, 'DLN-00495', 108, NULL, NULL, 63, 14121203, 10, 1, 4, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:28:33', '2022-04-26 16:28:33'),
(496, 'DLN-00496', 108, NULL, NULL, 63, 14121203, 10, 1, 5, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:28:46', '2022-04-26 16:28:46'),
(497, 'DLN-00497', 108, NULL, NULL, 63, 14121203, 10, 1, 6, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:28:54', '2022-04-26 16:28:54'),
(498, 'DLN-00498', 108, NULL, NULL, 63, 14121203, 10, 1, 7, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:29:05', '2022-04-26 16:29:05'),
(499, 'DLN-00499', 108, NULL, NULL, 63, 14121203, 10, 1, 8, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:29:14', '2022-04-26 16:29:14'),
(500, 'DLN-00500', 108, NULL, NULL, 63, 14121203, 10, 1, 9, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:29:29', '2022-04-26 16:29:29'),
(501, 'DLN-00501', 108, NULL, NULL, 63, 14121203, 10, 1, 10, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:29:38', '2022-04-26 16:29:38'),
(502, 'DLN-00502', 108, NULL, NULL, 63, 14121203, 10, 1, 11, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:29:47', '2022-04-26 16:29:47'),
(503, 'DLN-00503', 108, NULL, NULL, 63, 14121203, 10, 1, 12, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:29:55', '2022-04-26 16:29:55'),
(504, 'DLN-00504', 108, NULL, NULL, 63, 14121203, 10, 1, 13, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:30:17', '2022-04-26 16:30:17'),
(505, 'DLN-00505', 108, NULL, NULL, 63, 14121203, 10, 1, 14, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:30:25', '2022-04-26 16:30:25'),
(506, 'DLN-00506', 108, NULL, NULL, 63, 14121203, 10, 1, 15, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:30:34', '2022-04-26 16:30:34'),
(507, 'DLN-00507', 108, NULL, NULL, 63, 14121203, 10, 1, 16, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:30:42', '2022-04-26 16:30:42'),
(508, 'DLN-00508', 108, NULL, NULL, 63, 14121203, 10, 1, 17, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:30:50', '2022-04-26 16:30:50'),
(509, 'DLN-00509', 108, NULL, NULL, 63, 14121203, 5, 1, 18, NULL, NULL, NULL, NULL, NULL, '2022-04-26', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-04-26 16:31:00', '2022-04-26 16:31:00'),
(510, 'DLN-00510', 130, 30, 96, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-05-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-05-16 18:54:29', '2022-05-16 18:54:29'),
(511, 'DLN-00511', 130, 1, 55, 117, 14121197, 3, 3, 2, NULL, NULL, NULL, NULL, NULL, '2022-05-16', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-05-16 19:03:14', '2022-05-16 19:03:14'),
(512, 'DLN-00512', 150, 18, 156, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-05-17', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-05-17 18:31:23', '2022-05-17 18:33:08'),
(513, 'DLN-00513', 150, 18, 156, 117, 14121197, 10, 3, 1, NULL, NULL, NULL, NULL, NULL, '2022-05-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-05-17 18:31:23', '2022-05-17 18:31:23'),
(514, 'DLN-00514', 140, 1, 65, 133, 14121199, 10, 10, 1, NULL, NULL, NULL, NULL, NULL, '2022-05-17', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2022-05-18 02:26:56', '2022-05-18 02:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `del_note_qc_cube_detail`
--

CREATE TABLE `del_note_qc_cube_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_note_id` int(11) NOT NULL,
  `date_tested` date DEFAULT NULL,
  `age_days` int(11) DEFAULT NULL,
  `weight` double(10,2) DEFAULT NULL,
  `s_area` double(10,2) DEFAULT NULL,
  `height` double(10,2) DEFAULT NULL,
  `density` varchar(125) CHARACTER SET utf8 DEFAULT NULL,
  `m_load` double(10,2) DEFAULT NULL,
  `c_strength` double(10,2) DEFAULT NULL,
  `type_of_fraction` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `c_strength_kg` double(10,2) DEFAULT NULL,
  `type` enum('cube','cylinder') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_alias` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `mail_alias`, `lead_user_id`, `parent_id`, `is_active`, `added_by`, `created_at`, `updated_at`) VALUES
(1000, 'admin', NULL, 1, 2, '1', 1, NULL, '2021-04-17 10:39:48'),
(11, 'Purchases', NULL, NULL, NULL, '1', 1, '2022-02-13 15:45:00', '2022-02-13 15:45:00'),
(12, 'Administrative Affairs', NULL, NULL, NULL, '1', 1, '2022-02-13 15:45:00', '2022-02-13 15:45:00'),
(7, 'Maintenance', NULL, 90, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:24:37'),
(6, 'Quality Control', NULL, 59, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:26:13'),
(3, 'Finance', NULL, 62, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:25:11'),
(4, 'Sales', NULL, 56, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:27:57'),
(8, 'Workshop', NULL, 98, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:28:30'),
(5, 'Production', NULL, 5, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:27:12'),
(10, 'Operation', NULL, 95, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:26:36'),
(1, 'Executive', NULL, 2, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:28:55'),
(9, 'Services', NULL, NULL, NULL, '1', 1, '2022-02-13 15:45:00', '2022-02-13 15:45:00'),
(2, 'Human Resources', NULL, 143, 0, '1', 1, '2022-02-13 15:45:00', '2022-03-14 17:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `name`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'General Manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(2, 'Manufacturing Engineer', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(3, 'Executive Secretary', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(4, 'Operation Manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(5, 'mixer driver', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(6, 'workshop supervisor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(7, 'Plant operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(8, 'water tank driver', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(9, 'Internal Foreman', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(10, 'pump operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(11, 'Dispatcher', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(12, 'Pump driver & operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(13, 'Sales Representative', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(14, 'accountant', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(15, 'pump labor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(16, 'Welder', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(17, 'Lab supervisor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(18, 'pump driver', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(19, 'Labor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(20, 'plant electrician', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(21, 'Laboratory Technician (site)', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(22, 'Sales Manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(23, 'Government Relations Officer', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(24, 'Quality Manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(25, 'tipper driver', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(26, 'chief accountant', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(27, 'Purchases Representative', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(28, 'tire man', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(29, 'Scale operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(30, 'mechanical - electrical', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(31, 'loader operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(32, 'Site Foreman', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(33, 'Lab technician (site) + driver', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(34, 'Lab Labor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(35, 'Maintenance manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(36, 'store keeper', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(37, 'Material foreman', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(38, 'Production Manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(39, 'workshop manager', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(40, 'Mechanic', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(41, 'service driver', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(42, 'Lab Technician (site)', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(43, 'Cooker', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(44, 'electrician', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(45, 'Plant Labor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(46, 'painter', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(47, 'HR Supervisor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(48, 'station operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(49, 'Sales Coordinator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(50, 'Gate Labor', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(51, 'diesel filler', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(52, 'office Boy', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(53, 'Lab technician (check point)', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(54, 'Helper', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(55, 'Camp cleaner', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00'),
(56, 'Bobcat Operator', 1, '2022-02-13 04:54:00', '2022-02-13 04:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `earning_type`
--

CREATE TABLE `earning_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_cal_type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_cal_val` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_pay_type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `org_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `additional_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `user_id`, `org_name`, `degree_name`, `faculty_name`, `completion_date`, `additional_note`, `created_at`, `updated_at`) VALUES
(4, 14121184, 'AMC', 'BSC', 'IT', '2021-12-07', 'nt', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emp_active_status`
--

CREATE TABLE `emp_active_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emp_active_status`
--

INSERT INTO `emp_active_status` (`id`, `user_id`, `start_time`, `end_time`, `date`, `created_at`, `updated_at`) VALUES
(2, 1, '01:09:50', NULL, '2022-03-18', '2022-03-18 05:09:50', '2022-03-18 05:09:50'),
(4, 1, '14:22:35', NULL, '2022-05-12', '2022-05-12 18:22:35', '2022-05-12 18:22:35'),
(6, 1, '14:58:22', NULL, '2022-05-29', '2022-05-29 18:58:22', '2022-05-29 18:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave_policy`
--

CREATE TABLE `emp_leave_policy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `leave_types_id` int(11) DEFAULT NULL,
  `type` enum('paid','unpaid','on_duty','restricted_holidays') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `unit` enum('days','hours') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'days',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `paid_days` int(11) DEFAULT NULL,
  `unpaid_days` int(11) DEFAULT NULL,
  `genders` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designations` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_types` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effective_period` int(11) DEFAULT NULL,
  `effective_unit` enum('days','months','years') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_field` enum('date_of_join','date_of_conf') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_period` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_time` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_month` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_no_days` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_mode` enum('current_accrual','next_accrual') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_period` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_time` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_month` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cf_mode` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_carry` int(11) DEFAULT NULL,
  `reset_carry_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_carry_limit` int(11) DEFAULT NULL,
  `reset_carry_expire_in` int(11) DEFAULT NULL,
  `reset_carry_expire_unit` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carry_forword_overall_limit` int(11) DEFAULT NULL,
  `take_overall_limit` int(11) DEFAULT NULL,
  `reset_encash_num` int(11) DEFAULT NULL,
  `encash_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_encash_limit` int(11) DEFAULT NULL,
  `include_weekends` int(11) DEFAULT NULL,
  `inc_weekends_after` int(11) DEFAULT NULL,
  `inc_holidays` int(11) DEFAULT NULL,
  `incholidays_after` int(11) DEFAULT NULL,
  `exceed_maxcount` int(11) DEFAULT NULL,
  `exceed_allow_opt` int(11) DEFAULT NULL,
  `duration_allowed` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_display` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_display` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pastbooking_enable` int(11) DEFAULT NULL,
  `pastbooking_limit_enable` int(11) DEFAULT NULL,
  `pastbooking_limit` int(11) DEFAULT NULL,
  `futurebooking_enable` int(11) DEFAULT NULL,
  `futurebooking_limit_enable` int(11) DEFAULT NULL,
  `futurebooking_limit` int(11) DEFAULT NULL,
  `futurebooking_notice_enable` int(11) DEFAULT NULL,
  `futurebooking_notice` int(11) DEFAULT NULL,
  `min_leave_enable` int(11) DEFAULT NULL,
  `min_leave` int(11) DEFAULT NULL,
  `max_leave_enable` int(11) DEFAULT NULL,
  `max_leave` int(11) DEFAULT NULL,
  `max_consecutive_enable` int(11) DEFAULT NULL,
  `max_consecutive` int(11) DEFAULT NULL,
  `min_gap_enable` int(11) DEFAULT NULL,
  `min_gap` int(11) DEFAULT NULL,
  `show_fileupload_after_enable` int(11) DEFAULT NULL,
  `show_fileupload_after` int(11) DEFAULT NULL,
  `frequency_count` int(11) DEFAULT NULL,
  `frequency_period` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applydates` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked_clubs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_shifts`
--

CREATE TABLE `emp_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comp_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `comp_name`, `job_title`, `from_date`, `to_date`, `description`, `created_at`, `updated_at`) VALUES
(4, 14121184, 'pi tech', 'Dev', '2021-12-07', '2022-01-11', 'jd', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `for` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medium` enum('google','facebook','email','physical') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_delivery_voucher`
--

CREATE TABLE `inventory_delivery_voucher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_number` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `accounting_date` date NOT NULL,
  `day_vouchers` date NOT NULL,
  `customer_name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `order_no` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `receiver_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8 DEFAULT NULL,
  `sales_user_id` int(11) NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `subtotal` double(10,2) NOT NULL,
  `total_dicount` double(10,2) NOT NULL,
  `total_payment` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_delivery_voucher_detail`
--

CREATE TABLE `inventory_delivery_voucher_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deliv_voucher_id` int(11) NOT NULL,
  `comm_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double(10,2) DEFAULT NULL,
  `tax_id` int(11) NOT NULL,
  `sub_total` double(10,2) DEFAULT NULL,
  `discount_percentage` double(10,2) DEFAULT NULL,
  `discount_amount` double(10,2) DEFAULT NULL,
  `total_payment` double(10,2) DEFAULT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_receiving_voucher`
--

CREATE TABLE `inventory_receiving_voucher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `docket_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accounting_date` date NOT NULL,
  `day_vouchers` date NOT NULL,
  `supplier_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `deliver_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `buyer_id` int(11) NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `total_tax_amount` double(10,2) NOT NULL,
  `total_goods_amount` double(10,2) NOT NULL,
  `value_of_inventory` double(10,2) NOT NULL,
  `total_payment` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_requests`
--

CREATE TABLE `inventory_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ord_id` int(11) NOT NULL,
  `req_title` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `reuirement_date` date NOT NULL,
  `production` date NOT NULL,
  `requester_id` int(11) NOT NULL,
  `status` enum('requested','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_requests_details`
--

CREATE TABLE `inventory_requests_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `req_id` int(11) NOT NULL,
  `comm_code` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `net_total` double(10,2) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `discount_type` enum('fixed','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `grand_tot` double(10,2) DEFAULT NULL,
  `adjustment` text CHARACTER SET utf8 DEFAULT NULL,
  `billing_street` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `billing_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `billing_state` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `billing_zip` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `billing_country` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `include_shipping` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `shipping_street` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_state` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_zip` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_country` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('draft','sent','open','revised','declined','accepted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `order_id`, `invoice_number`, `invoice_date`, `due_date`, `currency`, `net_total`, `discount`, `discount_type`, `grand_tot`, `adjustment`, `billing_street`, `billing_city`, `billing_state`, `billing_zip`, `billing_country`, `include_shipping`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV-DRAFT', '2022-02-16', NULL, NULL, 100.00, NULL, 'percentage', 115.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-16 05:03:27', '2022-02-16 05:03:27'),
(2, 2, 'INV-DRAFT', '2022-02-17', NULL, NULL, 8000.00, NULL, 'percentage', 9200.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-16 22:36:17', '2022-02-16 22:36:17'),
(3, 3, 'INV-DRAFT', '2022-02-22', NULL, NULL, 200.00, NULL, 'percentage', 230.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-22 18:57:21', '2022-02-22 18:57:21'),
(4, 4, 'INV-DRAFT', '2022-02-22', NULL, NULL, 60.00, NULL, 'percentage', 69.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-22 20:34:53', '2022-02-22 20:34:53'),
(5, 5, 'INV-DRAFT', '2022-02-22', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-22 20:50:53', '2022-02-22 20:50:53'),
(6, 6, 'INV-DRAFT', '2022-02-22', NULL, NULL, 4000.00, NULL, 'percentage', 4600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-22 23:59:05', '2022-02-22 23:59:05'),
(7, 7, 'INV-DRAFT', '2022-02-23', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-23 23:57:48', '2022-02-23 23:57:48'),
(8, 8, 'INV-DRAFT', '2022-02-23', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 00:14:57', '2022-02-24 00:14:57'),
(9, 9, 'INV-DRAFT', '2022-02-23', NULL, NULL, 6.00, NULL, 'percentage', 6.90, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 00:34:18', '2022-02-24 00:34:18'),
(10, 10, 'INV-DRAFT', '2022-02-23', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 00:47:27', '2022-02-24 00:47:27'),
(11, 11, 'INV-DRAFT', '2022-02-23', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 03:34:07', '2022-02-24 03:34:07'),
(12, 12, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 06:16:14', '2022-02-24 06:16:14'),
(13, 13, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 07:56:06', '2022-02-24 07:56:06'),
(14, 14, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 16:22:31', '2022-02-24 16:22:31'),
(15, 15, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 16:26:08', '2022-02-24 16:26:08'),
(16, 16, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 16:47:55', '2022-02-24 16:47:55'),
(17, 17, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 17:15:28', '2022-02-24 17:15:28'),
(18, 18, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 17:18:34', '2022-02-24 17:18:34'),
(19, 19, 'INV-DRAFT', '2022-02-24', NULL, NULL, 30.00, NULL, 'percentage', 34.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 17:27:16', '2022-02-24 17:27:16'),
(20, 20, 'INV-DRAFT', '2022-02-24', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-24 22:42:25', '2022-02-24 22:42:25'),
(21, 21, 'INV-DRAFT', '2022-02-25', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-02-25 05:05:02', '2022-02-25 05:05:02'),
(22, 22, 'INV-DRAFT', '2022-03-07', NULL, NULL, 40000.00, NULL, 'percentage', 46000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-07 11:21:54', '2022-03-07 11:21:54'),
(23, 23, 'INV-DRAFT', '2022-03-08', NULL, NULL, 7800.00, NULL, 'percentage', 8970.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-08 22:23:09', '2022-03-08 22:23:09'),
(24, 24, 'INV-DRAFT', '2022-03-09', NULL, NULL, 3900.00, NULL, 'percentage', 4485.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 18:30:12', '2022-03-09 18:30:12'),
(25, 25, 'INV-DRAFT', '2022-03-09', NULL, NULL, 76000.00, NULL, 'percentage', 87400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 18:38:57', '2022-03-09 18:38:57'),
(26, 26, 'INV-DRAFT', '2022-03-09', NULL, NULL, 85280.00, NULL, 'percentage', 98072.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 18:55:59', '2022-03-09 18:55:59'),
(27, 27, 'INV-DRAFT', '2022-03-09', NULL, NULL, 42000.00, NULL, 'percentage', 48300.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 19:02:45', '2022-03-09 19:02:45'),
(28, 28, 'INV-DRAFT', '2022-03-09', NULL, NULL, 115000.00, NULL, 'percentage', 132250.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 19:16:15', '2022-03-09 19:16:15'),
(29, 29, 'INV-DRAFT', '2022-03-09', NULL, NULL, 26400.00, NULL, 'percentage', 30360.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 19:27:19', '2022-03-09 19:27:19'),
(30, 30, 'INV-DRAFT', '2022-03-09', NULL, NULL, 20000.00, NULL, 'percentage', 23000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 19:33:19', '2022-03-09 19:33:19'),
(31, 31, 'INV-DRAFT', '2022-03-09', NULL, NULL, 8208.00, NULL, 'percentage', 9439.20, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 19:47:37', '2022-03-09 19:47:37'),
(32, 32, 'INV-DRAFT', '2022-03-09', NULL, NULL, 58500.00, NULL, 'percentage', 67275.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 19:53:52', '2022-03-09 19:53:52'),
(33, 33, 'INV-DRAFT', '2022-03-09', NULL, NULL, 127600.00, NULL, 'percentage', 146740.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:03:13', '2022-03-09 20:03:13'),
(34, 34, 'INV-DRAFT', '2022-03-09', NULL, NULL, 8000.00, NULL, 'percentage', 9200.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:11:27', '2022-03-09 20:11:27'),
(35, 35, 'INV-DRAFT', '2022-03-09', NULL, NULL, 10000.00, NULL, 'percentage', 11500.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:14:28', '2022-03-09 20:14:28'),
(36, 36, 'INV-DRAFT', '2022-03-09', NULL, NULL, 18400.00, NULL, 'percentage', 21160.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:21:15', '2022-03-09 20:21:15'),
(37, 37, 'INV-DRAFT', '2022-03-09', NULL, NULL, 13800.00, NULL, 'percentage', 15870.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:26:16', '2022-03-09 20:26:16'),
(38, 38, 'INV-DRAFT', '2022-03-09', NULL, NULL, 52000.00, NULL, 'percentage', 59800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:27:09', '2022-03-09 20:27:09'),
(39, 39, 'INV-DRAFT', '2022-03-09', NULL, NULL, 50700.00, NULL, 'percentage', 58305.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:31:25', '2022-03-09 20:31:25'),
(40, 40, 'INV-DRAFT', '2022-03-09', NULL, NULL, 60000.00, NULL, 'percentage', 69000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:44:26', '2022-03-09 20:44:26'),
(41, 41, 'INV-DRAFT', '2022-03-09', NULL, NULL, 4840.00, NULL, 'percentage', 5566.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:46:57', '2022-03-09 20:46:57'),
(42, 42, 'INV-DRAFT', '2022-03-09', NULL, NULL, 20.00, NULL, 'percentage', 23.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:54:28', '2022-03-09 20:54:28'),
(43, 43, 'INV-DRAFT', '2022-03-09', NULL, NULL, 20.00, NULL, 'percentage', 23.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 20:55:10', '2022-03-09 20:55:10'),
(44, 44, 'INV-DRAFT', '2022-03-09', NULL, NULL, 50700.00, NULL, 'percentage', 58305.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 21:00:41', '2022-03-09 21:00:41'),
(45, 45, 'INV-DRAFT', '2022-03-09', NULL, NULL, 52000.00, NULL, 'percentage', 59800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 21:03:07', '2022-03-09 21:03:07'),
(46, 46, 'INV-DRAFT', '2022-03-09', NULL, NULL, 36000.00, NULL, 'percentage', 41400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 21:07:02', '2022-03-09 21:07:02'),
(47, 47, 'INV-DRAFT', '2022-03-09', NULL, NULL, 7020.00, NULL, 'percentage', 8073.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 21:10:16', '2022-03-09 21:10:16'),
(48, 48, 'INV-DRAFT', '2022-03-09', NULL, NULL, 7800.00, NULL, 'percentage', 8970.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-09 21:21:31', '2022-03-09 21:21:31'),
(49, 49, 'INV-DRAFT', '2022-03-09', NULL, NULL, 78000.00, NULL, 'percentage', 89700.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-10 00:14:55', '2022-03-10 00:14:55'),
(50, 50, 'INV-DRAFT', '2022-03-10', NULL, NULL, 202840.00, NULL, 'percentage', 233266.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-10 21:56:43', '2022-03-10 21:56:43'),
(51, 51, 'INV-DRAFT', '2022-03-14', NULL, NULL, 92000.00, NULL, 'percentage', 105800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-14 17:44:21', '2022-03-14 17:44:21'),
(52, 52, 'INV-DRAFT', '2022-03-14', NULL, NULL, 390.00, NULL, 'percentage', 448.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-14 18:19:00', '2022-03-14 18:19:00'),
(53, 53, 'INV-DRAFT', '2022-03-14', NULL, NULL, 9750.00, NULL, 'percentage', 11212.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-14 19:10:51', '2022-03-14 19:10:51'),
(54, 54, 'INV-DRAFT', '2022-03-14', NULL, NULL, 9750.00, NULL, 'percentage', 11212.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-14 21:05:10', '2022-03-14 21:05:10'),
(55, 55, 'INV-DRAFT', '2022-03-15', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-16 04:41:35', '2022-03-16 04:41:35'),
(56, 56, 'INV-DRAFT', '2022-03-16', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-16 04:43:27', '2022-03-16 04:43:27'),
(57, 57, 'INV-DRAFT', '2022-03-16', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-16 23:10:50', '2022-03-16 23:10:50'),
(58, 58, 'INV-DRAFT', '2022-03-16', NULL, NULL, 6630.00, NULL, 'percentage', 7624.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 01:08:36', '2022-03-17 01:08:36'),
(59, 59, 'INV-DRAFT', '2022-03-16', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 03:23:56', '2022-03-17 03:23:56'),
(60, 60, 'INV-DRAFT', '2022-03-17', NULL, NULL, 97500.00, NULL, 'percentage', 112125.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 15:34:32', '2022-03-17 15:34:32'),
(61, 61, 'INV-DRAFT', '2022-03-17', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 15:43:08', '2022-03-17 15:43:08'),
(62, 62, 'INV-DRAFT', '2022-03-17', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 16:29:47', '2022-03-17 16:29:47'),
(63, 63, 'INV-DRAFT', '2022-03-17', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 17:53:21', '2022-03-17 17:53:21'),
(64, 64, 'INV-DRAFT', '2022-03-17', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-17 19:54:51', '2022-03-17 19:54:51'),
(65, 65, 'INV-DRAFT', '2022-03-17', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-18 03:08:56', '2022-03-18 03:08:56'),
(66, 66, 'INV-DRAFT', '2022-03-20', NULL, NULL, 460.00, NULL, 'percentage', 529.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-20 18:37:16', '2022-03-20 18:37:16'),
(67, 67, 'INV-DRAFT', '2022-03-20', NULL, NULL, 11500.00, NULL, 'percentage', 13225.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-20 18:40:28', '2022-03-20 18:40:28'),
(68, 68, 'INV-DRAFT', '2022-03-20', NULL, NULL, 7800.00, NULL, 'percentage', 8970.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-20 20:27:42', '2022-03-20 20:27:42'),
(69, 69, 'INV-DRAFT', '2022-03-20', NULL, NULL, 13800.00, NULL, 'percentage', 15870.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-20 20:53:42', '2022-03-20 20:53:42'),
(70, 70, 'INV-DRAFT', '2022-03-20', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-20 21:16:12', '2022-03-20 21:16:12'),
(71, 71, 'INV-DRAFT', '2022-03-22', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-22 14:58:30', '2022-03-22 14:58:30'),
(72, 72, 'INV-DRAFT', '2022-03-23', NULL, NULL, 8580.00, NULL, 'percentage', 9867.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-23 23:43:14', '2022-03-23 23:43:36'),
(73, 73, 'INV-DRAFT', '2022-03-26', NULL, NULL, 19500.00, NULL, 'percentage', 22425.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-26 16:28:01', '2022-03-26 16:28:01'),
(74, 74, 'INV-DRAFT', '2022-03-26', NULL, NULL, 6900.00, NULL, 'percentage', 7935.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-26 20:30:12', '2022-03-26 20:31:20'),
(75, 75, 'INV-DRAFT', '2022-03-26', NULL, NULL, 9750.00, NULL, 'percentage', 11212.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-26 20:35:48', '2022-03-26 20:35:48'),
(76, 76, 'INV-DRAFT', '2022-03-27', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-27 22:53:05', '2022-03-27 22:53:53'),
(77, 77, 'INV-DRAFT', '2022-03-28', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-28 17:26:39', '2022-03-28 17:26:39'),
(78, 78, 'INV-DRAFT', '2022-03-28', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-28 19:32:48', '2022-03-28 19:32:48'),
(79, 79, 'INV-DRAFT', '2022-03-28', NULL, NULL, 390.00, NULL, 'percentage', 448.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-28 19:33:33', '2022-03-28 19:33:33'),
(80, 80, 'INV-DRAFT', '2022-03-29', NULL, NULL, 460.00, NULL, 'percentage', 529.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-29 20:47:46', '2022-03-29 20:47:46'),
(81, 81, 'INV-DRAFT', '2022-03-29', NULL, NULL, 32000.00, NULL, 'percentage', 36800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-29 20:52:11', '2022-03-29 20:52:11'),
(82, 82, 'INV-DRAFT', '2022-03-29', NULL, NULL, 11700.00, NULL, 'percentage', 13455.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-03-29 21:06:21', '2022-03-29 21:06:21'),
(83, 83, 'INV-DRAFT', '2022-04-09', NULL, NULL, 11700.00, NULL, 'percentage', 13455.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-09 10:33:25', '2022-04-09 10:33:25'),
(84, 84, 'INV-DRAFT', '2022-04-09', NULL, NULL, 5460.00, NULL, 'percentage', 6279.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-09 21:09:20', '2022-04-09 21:09:20'),
(85, 85, 'INV-DRAFT', '2022-04-10', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 04:09:12', '2022-04-10 04:09:12'),
(86, 86, 'INV-DRAFT', '2022-04-10', NULL, NULL, 390.00, NULL, 'percentage', 448.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 16:27:40', '2022-04-10 16:27:40'),
(87, 87, 'INV-DRAFT', '2022-04-10', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 16:30:41', '2022-04-10 16:30:41'),
(88, 88, 'INV-DRAFT', '2022-04-10', NULL, NULL, 460.00, NULL, 'percentage', 529.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 16:35:48', '2022-04-10 16:35:48'),
(89, 89, 'INV-DRAFT', '2022-04-10', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 16:43:20', '2022-04-10 16:43:20'),
(90, 90, 'INV-DRAFT', '2022-04-10', NULL, NULL, 5850.00, NULL, 'percentage', 6727.50, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 17:07:04', '2022-04-10 17:07:04'),
(91, 91, 'INV-DRAFT', '2022-04-10', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-10 18:21:51', '2022-04-10 18:21:51'),
(92, 92, 'INV-DRAFT', '2022-04-11', NULL, NULL, 6240.00, NULL, 'percentage', 7176.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-11 16:15:09', '2022-04-11 16:15:09'),
(93, 93, 'INV-DRAFT', '2022-04-11', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-11 16:41:24', '2022-04-11 16:41:24'),
(94, 94, 'INV-DRAFT', '2022-04-11', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-11 17:26:08', '2022-04-11 17:26:08'),
(95, 95, 'INV-DRAFT', '2022-04-11', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-12 01:23:56', '2022-04-12 01:23:56'),
(96, 96, 'INV-DRAFT', '2022-04-12', NULL, NULL, 20000.00, NULL, 'percentage', 23000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-12 07:24:57', '2022-04-12 07:24:57'),
(97, 97, 'INV-DRAFT', '2022-04-12', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-13 00:19:13', '2022-04-13 00:19:13'),
(98, 98, 'INV-DRAFT', '2022-04-14', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-14 04:19:43', '2022-04-14 04:19:43'),
(99, 99, 'INV-DRAFT', '2022-04-14', NULL, NULL, 11500.00, NULL, 'percentage', 13225.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-14 04:20:10', '2022-04-14 04:20:10'),
(100, 100, 'INV-DRAFT', '2022-04-19', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-19 17:14:22', '2022-04-19 17:14:22'),
(101, 101, 'INV-DRAFT', '2022-04-19', NULL, NULL, 56000.00, NULL, 'percentage', 64400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-19 18:01:26', '2022-04-19 18:01:26'),
(102, 102, 'INV-DRAFT', '2022-04-22', NULL, NULL, 6400.00, NULL, 'percentage', 7360.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-22 22:01:55', '2022-04-22 22:01:55'),
(103, 103, 'INV-DRAFT', '2022-04-22', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-22 22:03:30', '2022-04-22 22:07:33'),
(104, 104, 'INV-DRAFT', '2022-04-28', NULL, NULL, 56000.00, NULL, 'percentage', 64400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-26 05:40:40', '2022-04-26 05:40:40'),
(105, 105, 'INV-DRAFT', '2022-04-28', NULL, NULL, 56000.00, NULL, 'percentage', 64400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-26 05:40:41', '2022-04-26 05:40:41'),
(106, 106, 'INV-DRAFT', '2022-04-28', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-26 05:42:32', '2022-04-26 05:42:32'),
(107, 107, 'INV-DRAFT', '2022-04-28', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-04-26 05:45:47', '2022-04-26 05:45:47'),
(108, 108, 'INV-DRAFT', '2022-05-11', NULL, NULL, 100.00, NULL, 'percentage', 115.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-10 19:44:28', '2022-05-10 19:44:28'),
(109, 109, 'INV-DRAFT', '2022-05-11', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-10 19:50:25', '2022-05-10 19:50:25'),
(110, 110, 'INV-DRAFT', '2022-05-11', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-10 19:50:26', '2022-05-10 19:50:26'),
(111, 111, 'INV-DRAFT', '2022-05-11', NULL, NULL, 8000.00, NULL, 'percentage', 9200.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-10 19:51:12', '2022-05-10 19:51:12'),
(112, 112, 'INV-DRAFT', '2022-05-11', NULL, NULL, 84000.00, NULL, 'percentage', 96600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-10 19:52:24', '2022-05-10 19:52:24'),
(113, 113, 'INV-DRAFT', '2022-05-11', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-10 19:54:00', '2022-05-10 19:54:00'),
(114, 114, 'INV-DRAFT', '2022-05-14', NULL, NULL, 58500.00, NULL, 'percentage', 67275.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:07:44', '2022-05-12 18:07:44'),
(115, 115, 'INV-DRAFT', '2022-05-14', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:08:51', '2022-05-12 18:08:51'),
(116, 116, 'INV-DRAFT', '2022-05-14', NULL, NULL, 460.00, NULL, 'percentage', 529.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:09:41', '2022-05-12 18:09:41'),
(117, 117, 'INV-DRAFT', '2022-05-14', NULL, NULL, 58500.00, NULL, 'percentage', 67275.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:10:27', '2022-05-12 18:10:27'),
(118, 118, 'INV-DRAFT', '2022-05-14', NULL, NULL, 58500.00, NULL, 'percentage', 67275.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:11:05', '2022-05-12 18:11:05'),
(119, 119, 'INV-DRAFT', '2022-05-14', NULL, NULL, 46000.00, NULL, 'percentage', 52900.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:12:50', '2022-05-12 18:12:50'),
(120, 120, 'INV-DRAFT', '2022-05-14', NULL, NULL, 44000.00, NULL, 'percentage', 50600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:13:26', '2022-05-12 18:13:26'),
(121, 121, 'INV-DRAFT', '2022-05-14', NULL, NULL, 44000.00, NULL, 'percentage', 50600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:13:32', '2022-05-12 18:13:32'),
(122, 122, 'INV-DRAFT', '2022-05-14', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:15:07', '2022-05-12 18:15:07'),
(123, 123, 'INV-DRAFT', '2022-05-14', NULL, NULL, 16000.00, NULL, 'percentage', 18400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:15:55', '2022-05-12 18:15:55'),
(124, 124, 'INV-DRAFT', '2022-05-14', NULL, NULL, 0.00, NULL, 'percentage', 0.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:16:32', '2022-05-12 18:16:32'),
(125, 125, 'INV-DRAFT', '2022-05-14', NULL, NULL, 5980.00, NULL, 'percentage', 6877.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-12 18:18:42', '2022-05-12 18:18:42'),
(126, 126, 'INV-DRAFT', '2022-05-17', NULL, NULL, 80000.00, NULL, 'percentage', 92000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:12:09', '2022-05-16 15:12:09'),
(127, 127, 'INV-DRAFT', '2022-05-17', NULL, NULL, 400.00, NULL, 'percentage', 460.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:17:06', '2022-05-17 17:59:00'),
(128, 128, 'INV-DRAFT', '2022-05-17', NULL, NULL, 10580.00, NULL, 'percentage', 12167.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:18:05', '2022-05-16 15:18:05'),
(129, 129, 'INV-DRAFT', '2022-05-17', NULL, NULL, 16000.00, NULL, 'percentage', 18400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:18:46', '2022-05-16 15:18:46'),
(130, 130, 'INV-DRAFT', '2022-05-17', NULL, NULL, 72000.00, NULL, 'percentage', 82800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:19:38', '2022-05-16 15:19:38'),
(131, 131, 'INV-DRAFT', '2022-05-17', NULL, NULL, 72000.00, NULL, 'percentage', 82800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:19:39', '2022-05-16 15:19:39'),
(132, 132, 'INV-DRAFT', '2022-05-17', NULL, NULL, 46000.00, NULL, 'percentage', 52900.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:20:23', '2022-05-16 15:20:23'),
(133, 133, 'INV-DRAFT', '2022-05-17', NULL, NULL, 40000.00, NULL, 'percentage', 46000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:21:49', '2022-05-16 15:21:49'),
(134, 134, 'INV-DRAFT', '2022-05-17', NULL, NULL, 122500.00, NULL, 'percentage', 140875.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:22:42', '2022-05-16 15:22:42'),
(135, 135, 'INV-DRAFT', '2022-05-17', NULL, NULL, 18000.00, NULL, 'percentage', 20700.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:23:33', '2022-05-16 15:23:33'),
(136, 136, 'INV-DRAFT', '2022-05-17', NULL, NULL, 48000.00, NULL, 'percentage', 55200.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:24:10', '2022-05-16 15:24:10'),
(137, 137, 'INV-DRAFT', '2022-05-17', NULL, NULL, 23000.00, NULL, 'percentage', 26450.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:25:05', '2022-05-16 15:25:05'),
(138, 138, 'INV-DRAFT', '2022-05-17', NULL, NULL, 12000.00, NULL, 'percentage', 13800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-16 15:26:51', '2022-05-17 18:17:00'),
(139, 139, 'INV-DRAFT', '2022-05-18', NULL, NULL, 38000.00, NULL, 'percentage', 43700.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-17 18:05:39', '2022-05-17 18:15:49'),
(140, 140, 'INV-DRAFT', '2022-05-18', NULL, NULL, 49000.00, NULL, 'percentage', 56350.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-17 18:08:39', '2022-05-17 18:08:39'),
(141, 141, 'INV-DRAFT', '2022-05-18', NULL, NULL, 78200.00, NULL, 'percentage', 89930.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-17 18:25:51', '2022-05-17 18:25:51'),
(142, 142, 'INV-DRAFT', '2022-05-19', NULL, NULL, 6000.00, NULL, 'percentage', 6900.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-20 00:22:32', '2022-05-20 00:22:32'),
(143, 143, 'INV-DRAFT', '2022-05-21', NULL, NULL, 20000.00, NULL, 'percentage', 23000.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-22 02:28:58', '2022-05-22 02:28:58'),
(144, 144, 'INV-DRAFT', '2022-05-25', NULL, NULL, 16560.00, NULL, 'percentage', 19044.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:23:50', '2022-05-24 16:26:21'),
(145, 145, 'INV-DRAFT', '2022-05-25', NULL, NULL, 92000.00, NULL, 'percentage', 105800.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:32:19', '2022-05-24 16:32:19'),
(146, 146, 'INV-DRAFT', '2022-05-25', NULL, NULL, 460.00, NULL, 'percentage', 529.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:33:52', '2022-05-24 16:33:52'),
(147, 147, 'INV-DRAFT', '2022-05-25', NULL, NULL, 36800.00, NULL, 'percentage', 42320.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:36:35', '2022-05-24 16:36:35'),
(148, 148, 'INV-DRAFT', '2022-05-25', NULL, NULL, 85200.00, NULL, 'percentage', 97980.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:38:35', '2022-05-24 16:38:35'),
(149, 149, 'INV-DRAFT', '2022-05-25', NULL, NULL, 10800.00, NULL, 'percentage', 12420.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:39:16', '2022-05-24 16:39:16'),
(150, 150, 'INV-DRAFT', '2022-05-25', NULL, NULL, 12420.00, NULL, 'percentage', 14283.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-24 16:41:04', '2022-05-24 16:41:04'),
(151, 151, 'INV-DRAFT', '2022-05-30', NULL, NULL, 6000.00, NULL, 'percentage', 6900.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 18:51:04', '2022-05-29 18:51:04'),
(152, 152, 'INV-DRAFT', '2022-05-30', NULL, NULL, 84000.00, NULL, 'percentage', 96600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 18:51:46', '2022-05-29 18:51:46'),
(153, 153, 'INV-DRAFT', '2022-05-30', NULL, NULL, 64000.00, NULL, 'percentage', 73600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 18:52:46', '2022-05-29 18:52:46'),
(154, 154, 'INV-DRAFT', '2022-05-30', NULL, NULL, 64000.00, NULL, 'percentage', 73600.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 18:52:47', '2022-05-29 18:52:47'),
(155, 155, 'INV-DRAFT', '2022-05-30', NULL, NULL, 230000.00, NULL, 'percentage', 264500.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 18:56:13', '2022-05-29 18:56:13'),
(156, 156, 'INV-DRAFT', '2022-05-30', NULL, NULL, 20700.00, NULL, 'percentage', 23805.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 18:57:08', '2022-05-29 18:57:08'),
(157, 157, 'INV-DRAFT', '2022-05-30', NULL, NULL, 9600.00, NULL, 'percentage', 11040.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 19:07:18', '2022-05-29 19:07:18'),
(158, 158, 'INV-DRAFT', '2022-05-30', NULL, NULL, 28000.00, NULL, 'percentage', 32200.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 19:10:14', '2022-05-29 19:10:14'),
(159, 159, 'INV-DRAFT', '2022-05-30', NULL, NULL, 14000.00, NULL, 'percentage', 16100.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 19:11:13', '2022-05-29 19:11:13'),
(160, 160, 'INV-DRAFT', '2022-05-30', NULL, NULL, 400.00, NULL, 'percentage', 460.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 19:11:57', '2022-05-29 19:11:57'),
(161, 161, 'INV-DRAFT', '2022-05-30', NULL, NULL, 16000.00, NULL, 'percentage', 18400.00, NULL, NULL, NULL, NULL, NULL, '1', '0', NULL, NULL, NULL, NULL, '1', 'draft', '2022-05-29 19:13:14', '2022-05-29 19:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payment`
--

CREATE TABLE `invoice_payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `pay_method_id` int(11) NOT NULL,
  `pay_date` date NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments_methods`
--

CREATE TABLE `invoice_payments_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `pay_method_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iqamas`
--

CREATE TABLE `iqamas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `iqama_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iqama_expiry_date` date DEFAULT NULL,
  `passport_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `gosi_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_period` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `iqamas`
--

INSERT INTO `iqamas` (`id`, `user_id`, `iqama_no`, `iqama_expiry_date`, `passport_no`, `passport_expiry_date`, `gosi_no`, `contract_period`, `created_at`, `updated_at`) VALUES
(6, 14121184, 'iqama1234', '2022-02-15', 'passport1234', '2022-07-30', 'gosi1234', '2 Years', NULL, '2022-05-27 22:08:25'),
(7, 14121197, '2429049824', '2022-12-28', 'EH0307602', '2025-12-08', NULL, '2 Years', NULL, '2022-03-06 22:42:46'),
(8, 14121198, '2447787132', '2023-02-08', '08201082', '2024-12-08', NULL, '2 Years', NULL, NULL),
(9, 14121199, '2449810874', '2022-09-01', '06257462', '2023-01-06', NULL, '2 Years', NULL, NULL),
(10, 14121200, '2441034408', '2022-08-06', 'BN0562497', '2022-03-06', NULL, '2 Years', NULL, '2022-03-06 22:57:18'),
(11, 14121202, '2500148347', '2022-03-06', '9802999', '2026-05-30', NULL, '2 Years', NULL, NULL),
(12, 14121203, '2498864434', '2023-04-11', '09743195', '2026-04-28', NULL, '2 Years', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `commodity_code` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `commodity_name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `commodity_barcode` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `sku_code` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `sku_name` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `commodity_group` int(11) DEFAULT NULL,
  `sub_group` int(11) DEFAULT NULL,
  `tags` text CHARACTER SET utf8 DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  `purchase_price` double(10,2) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `dept_id`, `commodity_code`, `commodity_name`, `commodity_barcode`, `sku_code`, `sku_name`, `description`, `units`, `commodity_group`, `sub_group`, `tags`, `rate`, `purchase_price`, `tax_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 10, NULL, 'water pump', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2022-05-17 19:12:01', '2022-05-17 19:12:01'),
(2, 10, NULL, 'Gear', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2022-06-04 02:55:00', '2022-06-04 02:55:00'),
(3, 10, NULL, 'coolent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2022-06-11 19:07:45', '2022-06-11 19:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('warm','hot','junks') COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` enum('google','facebook','email','physical') COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned` int(11) DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(260) CHARACTER SET utf8 DEFAULT NULL,
  `address` text CHARACTER SET utf8 DEFAULT NULL,
  `position` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `website` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_value` double(10,2) DEFAULT NULL,
  `default_language` int(11) DEFAULT NULL,
  `company` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `contacted_date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_applicables`
--

CREATE TABLE `leave_applicables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `genders` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designations` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_types` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `type` enum('date','hours') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_with` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_balance`
--

CREATE TABLE `leave_balance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `valid_till` date NOT NULL,
  `valid_from` date NOT NULL,
  `balance` int(11) NOT NULL,
  `taken_leave` int(11) DEFAULT NULL,
  `expire_count` int(11) DEFAULT NULL,
  `lop` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_entitlement`
--

CREATE TABLE `leave_entitlement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `effective_period` int(11) DEFAULT NULL,
  `effective_unit` enum('days','months','years') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_field` enum('date_of_join','date_of_conf') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_period` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_time` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_month` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_no_days` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accrual_mode` enum('current_accrual','next_accrual') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_period` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_time` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_month` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cf_mode` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_carry` int(11) DEFAULT NULL,
  `reset_carry_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_carry_limit` int(11) DEFAULT NULL,
  `reset_carry_expire_in` int(11) DEFAULT NULL,
  `reset_carry_expire_unit` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_encash_num` int(11) DEFAULT NULL,
  `encash_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_encash_limit` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_exceptions`
--

CREATE TABLE `leave_exceptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `departments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designations` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_types` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_restrictions`
--

CREATE TABLE `leave_restrictions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `include_weekends` int(11) DEFAULT NULL,
  `inc_weekends_after` int(11) DEFAULT NULL,
  `inc_holidays` int(11) DEFAULT NULL,
  `incholidays_after` int(11) DEFAULT NULL,
  `exceed_maxcount` int(11) DEFAULT NULL,
  `exceed_allow_opt` int(11) DEFAULT NULL,
  `duration_allowed` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_display` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_display` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pastbooking_enable` int(11) DEFAULT NULL,
  `pastbooking_limit_enable` int(11) DEFAULT NULL,
  `pastbooking_limit` int(11) DEFAULT NULL,
  `futurebooking_enable` int(11) DEFAULT NULL,
  `futurebooking_limit_enable` int(11) DEFAULT NULL,
  `futurebooking_limit` int(11) DEFAULT NULL,
  `futurebooking_notice_enable` int(11) DEFAULT NULL,
  `futurebooking_notice` int(11) DEFAULT NULL,
  `min_leave_enable` int(11) DEFAULT NULL,
  `min_leave` int(11) DEFAULT NULL,
  `max_leave_enable` int(11) DEFAULT NULL,
  `max_leave` int(11) DEFAULT NULL,
  `max_consecutive_enable` int(11) DEFAULT NULL,
  `max_consecutive` int(11) DEFAULT NULL,
  `min_gap_enable` int(11) DEFAULT NULL,
  `min_gap` int(11) DEFAULT NULL,
  `show_fileupload_after_enable` int(11) DEFAULT NULL,
  `show_fileupload_after` int(11) DEFAULT NULL,
  `frequency_count` int(11) DEFAULT NULL,
  `frequency_period` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applydates` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked_clubs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `code` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `type` enum('paid','unpaid','on_duty','restricted_holidays') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `unit` enum('days','hours') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'days',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `paid_days` int(11) DEFAULT NULL,
  `unpaid_days` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_categories`
--

CREATE TABLE `maintenance_categories` (
  `id` int(11) NOT NULL,
  `name_english` varchar(145) DEFAULT NULL,
  `name_arabic` varchar(145) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance_categories`
--

INSERT INTO `maintenance_categories` (`id`, `name_english`, `name_arabic`, `created_at`, `updated_at`) VALUES
(5, 'Vehicle', 'النباتات', '2022-05-27 21:49:35', '2022-05-27 21:49:35'),
(6, 'Plants', 'النباتات12', '2022-05-27 21:50:01', '2022-05-27 21:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Valovo', NULL, '1', '2022-05-17 19:13:29', '2022-05-17 19:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `master_earning`
--

CREATE TABLE `master_earning` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `earning_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `name_payslip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cal_type` enum('percentage','flat') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cal_value` double(10,2) DEFAULT NULL,
  `pay_type` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `pay_on` enum('CTC','Basic') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Basic',
  `is_extra` int(11) DEFAULT 0,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_reimbursement`
--

CREATE TABLE `master_reimbursement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reimbursement_type_id` int(11) NOT NULL,
  `name_payslip` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_salary`
--

CREATE TABLE `master_salary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `basic` double(10,2) DEFAULT NULL,
  `monthly_total` double(10,2) DEFAULT NULL,
  `annualy_total` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_salary_details`
--

CREATE TABLE `master_salary_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_sal_id` int(11) NOT NULL,
  `earning_id` int(11) NOT NULL,
  `cal_value` int(11) DEFAULT NULL,
  `monthly_amt` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2021_01_20_084001_create_inquiry_table', 1),
(4, '2021_01_20_102454_create_invoice_table', 1),
(5, '2021_01_20_103347_create_invoice_payments_methods_table', 1),
(6, '2021_01_20_103659_create_user_meta_table', 1),
(7, '2021_01_20_103916_create_orders_table', 1),
(8, '2021_01_20_104730_create_payment_methods_table', 1),
(9, '2021_01_20_105043_create_product_table', 1),
(10, '2021_01_20_111740_create_taxes_table', 1),
(11, '2021_01_20_111949_create_item_table', 1),
(12, '2021_01_20_112306_create_item_images_table', 1),
(13, '2021_01_20_112424_create_purchase_units_table', 1),
(14, '2021_01_20_112625_create_commodity_groups_table', 1),
(15, '2021_01_20_112752_create_purchase_request_table', 1),
(16, '2021_01_20_112948_create_purchase_items_table', 1),
(17, '2021_01_20_113505_create_purchase_request_details_table', 1),
(18, '2021_01_20_113629_create_quotations_table', 1),
(19, '2021_01_20_114054_create_quotations_detail_table', 1),
(20, '2021_01_20_115504_create_purchase_orders_table', 1),
(21, '2021_01_20_120322_create_purchase_orders_detail_table', 1),
(22, '2021_01_20_120803_create_inventory_receiving_voucher_table', 1),
(23, '2021_01_20_121532_create_stock_received_docket_detail_table', 1),
(24, '2021_01_20_122104_create_inventory_delivery_voucher_table', 1),
(25, '2021_01_20_122836_create_inventory_delivery_voucher_detail_table', 1),
(26, '2021_01_20_123132_create_inventory_requests_table', 1),
(27, '2021_01_20_123354_create_inventory_requests_details_table', 1),
(28, '2021_01_21_061617_create_reset_pass_token_table', 1),
(29, '2021_01_21_141639_create_users_table', 1),
(30, '2021_01_22_103020_create_leads_table', 1),
(31, '2021_01_30_071740_create_purchase_estimate_table', 1),
(32, '2021_01_30_071817_create_purchase_estimate_details_table', 1),
(33, '2021_02_01_125715_create_purchase_contract_table', 1),
(34, '2021_02_01_131554_create_purchase_contract_attachments_table', 1),
(35, '2021_02_02_063730_create_sales_invoice_details_table', 1),
(36, '2021_02_02_134836_create_vendor_note_table', 1),
(37, '2021_02_02_135010_create_vendor_attachment_table', 1),
(38, '2021_02_02_135054_create_vendor_payment_table', 1),
(39, '2021_02_03_060102_create_vendor_contact_table', 1),
(40, '2021_02_03_123826_create_invoice_payment_table', 1),
(41, '2021_02_05_101222_create_product_attributes_table', 1),
(42, '2021_02_05_104339_create_product_attribute_values_table', 1),
(43, '2021_02_08_054000_create_site_setting_table', 1),
(44, '2021_02_08_062146_create_order_details_table', 1),
(45, '2021_02_10_064924_create_vehicle_table', 1),
(46, '2021_02_10_140045_create_delivery_note_table', 1),
(47, '2021_02_22_090716_create_sales_estimate_table', 1),
(48, '2021_02_22_090848_create_sales_estimate_product_quantity_table', 1),
(49, '2021_02_22_091411_create_sales_proposal_table', 1),
(50, '2021_02_22_091447_create_sales_proposal_details_table', 1),
(51, '2021_02_23_105613_create_customer_contact_table', 1),
(52, '2021_02_25_061438_create_designation_table', 1),
(53, '2021_02_25_063026_create_experiences_table', 1),
(54, '2021_02_25_063842_create_education_table', 1),
(55, '2021_02_25_100101_create_department_table', 1),
(56, '2021_02_27_092920_create_work_shift_table', 1),
(57, '2021_03_01_121254_create_emp_shifts_table', 1),
(58, '2021_03_02_090039_create_sales_contract_table', 1),
(59, '2021_03_02_090209_create_sales_contract_details_table', 1),
(60, '2021_03_02_102122_create_transactions_table', 1),
(61, '2021_03_08_054404_create_pump_table', 1),
(62, '2021_03_09_072058_create_break_table', 1),
(63, '2021_03_10_050850_create_attendance_table', 1),
(64, '2021_03_10_123810_create_emp_active_status_table', 1),
(65, '2021_03_15_125312_create_cust_contract_attachment_table', 1),
(66, '2021_03_16_173430_create_leave_types_table', 1),
(67, '2021_03_17_173051_create_leave_entitlement_table', 1),
(68, '2021_03_17_190437_create_leave_applicables_table', 1),
(69, '2021_03_17_191428_create_leave_exceptions_table', 1),
(70, '2021_03_19_160049_create_leave_restrictions_table', 1),
(71, '2021_03_22_190148_create_leave_application_table', 1),
(72, '2021_03_22_190938_create_applied_leave_days_table', 1),
(73, '2021_03_24_121010_create_manufacturer_table', 1),
(74, '2021_03_24_142003_create_vechicle_make_table', 1),
(75, '2021_03_24_142239_create_vechicle_model_table', 1),
(76, '2021_03_24_142303_create_vechicle_year_table', 1),
(77, '2021_03_24_182128_create_vhc_purchase_parts_table', 1),
(78, '2021_03_24_183400_create_vhc_pur_parts_details_table', 1),
(79, '2021_03_26_102306_create_vechicle_repair_table', 1),
(80, '2021_03_27_170614_create_supply_order_table', 1),
(81, '2021_03_27_170801_create_vhc_part_supply_detail_table', 1),
(82, '2021_03_31_110244_create_permission_tables', 1),
(83, '2021_04_08_184150_create_del_note_qc_cube_detail_table', 2),
(84, '2021_04_19_100318_create_leave_balance_table', 2),
(85, '2021_04_19_161742_create_emp_leave_policy_table', 2),
(86, '2021_04_30_182212_create_holidays_table', 2),
(87, '2021_05_06_164009_create_earning_type_table', 2),
(88, '2021_05_06_164133_create_reimbursement_type_table', 2),
(89, '2021_05_06_175419_create_master_earning_table', 2),
(90, '2021_05_06_175518_create_master_reimbursement_table', 2),
(91, '2021_05_08_132528_create_pay_schedule_table', 3),
(92, '2021_05_13_143910_create_master_salary_table', 3),
(93, '2021_05_13_144018_create_master_salary_details_table', 3),
(94, '2021_05_17_144618_create_salary_table', 4),
(95, '2021_05_17_144745_create_salary_details_table', 4),
(96, '2021_05_17_181820_create_pay_run_table', 5),
(97, '2021_05_24_155921_create_overhead_expances_table', 6),
(98, '2021_05_25_123111_create_weekends_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 145),
(6, 'App\\Models\\User', 97),
(6, 'App\\Models\\User', 111),
(6, 'App\\Models\\User', 112),
(6, 'App\\Models\\User', 127),
(6, 'App\\Models\\User', 155),
(6, 'App\\Models\\User', 156),
(6, 'App\\Models\\User', 157),
(6, 'App\\Models\\User', 158),
(6, 'App\\Models\\User', 14121187),
(6, 'App\\Models\\User', 14121188),
(6, 'App\\Models\\User', 14121189),
(6, 'App\\Models\\User', 14121190),
(6, 'App\\Models\\User', 14121191),
(6, 'App\\Models\\User', 14121192),
(6, 'App\\Models\\User', 14121193),
(6, 'App\\Models\\User', 14121194),
(6, 'App\\Models\\User', 14121195),
(6, 'App\\Models\\User', 14121196),
(6, 'App\\Models\\User', 14121240),
(10, 'App\\Models\\User', 14121184),
(12, 'App\\Models\\User', 14121242),
(13, 'App\\Models\\User', 13),
(13, 'App\\Models\\User', 14),
(13, 'App\\Models\\User', 15),
(13, 'App\\Models\\User', 14121197),
(13, 'App\\Models\\User', 14121198),
(13, 'App\\Models\\User', 14121199),
(13, 'App\\Models\\User', 14121200),
(13, 'App\\Models\\User', 14121201),
(13, 'App\\Models\\User', 14121202),
(13, 'App\\Models\\User', 14121203),
(13, 'App\\Models\\User', 14121204),
(13, 'App\\Models\\User', 14121205),
(13, 'App\\Models\\User', 14121243),
(14, 'App\\Models\\User', 33),
(14, 'App\\Models\\User', 59),
(18, 'App\\Models\\User', 17),
(20, 'App\\Models\\User', 150),
(21, 'App\\Models\\User', 9),
(21, 'App\\Models\\User', 16),
(21, 'App\\Models\\User', 86),
(21, 'App\\Models\\User', 154),
(22, 'App\\Models\\User', 14121254),
(23, 'App\\Models\\User', 14121291);

-- --------------------------------------------------------

--
-- Table structure for table `new_roles`
--

CREATE TABLE `new_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_roles`
--

INSERT INTO `new_roles` (`id`, `name`, `slug`, `guard_name`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'web', 1000, NULL, NULL),
(110, 'pump operator', 'pumpoperator', 'web', 5, NULL, NULL),
(10, 'Internal Foreman', 'InternalForeman', 'web', 5, NULL, NULL),
(9, 'water tank driver', 'watertankdriver', 'web', 5, NULL, NULL),
(8, 'Plant operator', 'Plantoperator', 'web', 5, NULL, NULL),
(7, 'workshop supervisor', 'workshopsupervisor', 'web', 8, NULL, NULL),
(6, 'Mixer driver', 'mixerdriver', 'web', 5, NULL, NULL),
(5, 'Operation Manager', 'OperationManager', 'web', 10, NULL, NULL),
(400, 'Executive Secretary', 'ExecutiveSecretary', 'web', 1, NULL, NULL),
(300, 'Manufacturing Engineer', 'ManufEngineer', 'web', 1, NULL, NULL),
(2, 'General Manager', 'GeneralManager', 'web', 1, NULL, NULL),
(12, 'Dispatcher', 'Dispatcher', 'web', 5, NULL, NULL),
(13, 'Pump driver & operator', 'Pumpdriver&operator', 'web', 5, NULL, NULL),
(14, 'Sales Representative', 'SalesRepresentative', 'web', 4, NULL, NULL),
(15, 'accountant', 'accountant', 'web', 3, NULL, NULL),
(16, 'pump labor', 'pumplabor', 'web', 5, NULL, NULL),
(17, 'Welder', 'Welder', 'web', 8, NULL, NULL),
(18, 'Lab supervisor', 'Labsupervisor', 'web', 6, NULL, NULL),
(19, 'pump driver', 'pumpdriver', 'web', 5, NULL, NULL),
(20, 'Labor', 'Labor', 'web', 5, NULL, NULL),
(21, 'plant electrician', 'plantelectrician', 'web', 7, NULL, NULL),
(22, 'Laboratory Technician (site)', 'LaboratoryTechnician', 'web', 6, NULL, NULL),
(23, 'Sales Manager', 'SalesManager', 'web', 4, NULL, NULL),
(24, 'Government Relations Officer', 'GovernmentRelationsOfficer', 'web', 12, NULL, NULL),
(25, 'Quality Manager', 'QualityManager', 'web', 6, NULL, NULL),
(26, 'tipper driver', 'tipperdriver', 'web', 5, NULL, NULL),
(27, 'chief accountant', 'chiefaccountant', 'web', 3, NULL, NULL),
(28, 'Purchases Representative', 'PurchasesRepresentative', 'web', 11, NULL, NULL),
(29, 'tire man', 'tireman', 'web', 5, NULL, NULL),
(30, 'Scale operator', 'Scaleoperator', 'web', 10, NULL, NULL),
(31, 'mechanical - electrical', 'mechanical-electrical', 'web', 5, NULL, NULL),
(32, 'loader operator', 'loaderoperator', 'web', 5, NULL, NULL),
(33, 'Site Foreman', 'SiteForeman', 'web', 5, NULL, NULL),
(34, 'Lab technician (site) + driver', 'Labtechniciandriver', 'web', 6, NULL, NULL),
(35, 'Lab Labor', 'LabLabor', 'web', 6, NULL, NULL),
(36, 'Maintenance manager', 'Maintenancemanager', 'web', 7, NULL, NULL),
(37, 'store keeper', 'storekeeper', 'web', 8, NULL, NULL),
(38, 'Material foreman', 'Materialforeman', 'web', 10, NULL, NULL),
(39, 'Production Manager', 'ProductionManager', 'web', 5, NULL, NULL),
(40, 'workshop manager', 'workshopmanager', 'web', 8, NULL, NULL),
(41, 'Mechanic', 'Mechanic', 'web', 8, NULL, NULL),
(42, 'service driver', 'servicedriver', 'web', 5, NULL, NULL),
(43, 'Lab Technician (site)', 'LabTechnician', 'web', 6, NULL, NULL),
(44, 'Cooker', 'Cooker', 'web', 9, NULL, NULL),
(45, 'electrician', 'electrician', 'web', 8, NULL, NULL),
(46, 'Plant Labor', 'PlantLabor', 'web', 5, NULL, NULL),
(47, 'painter', 'painter', 'web', 8, NULL, NULL),
(48, 'HR Supervisor', 'HRSupervisor', 'web', 2, NULL, NULL),
(49, 'station operator', 'stationoperator', 'web', 5, NULL, NULL),
(50, 'Sales Coordinator', 'SalesCoordinator', 'web', 4, NULL, NULL),
(51, 'Gate Labor', 'GateLabor', 'web', 10, NULL, NULL),
(52, 'diesel filler', 'dieselfiller', 'web', 5, NULL, NULL),
(53, 'office Boy', 'officeBoy', 'web', 9, NULL, NULL),
(54, 'Lab technician (check point)', 'Labtechniciancheckpoint', 'web', 6, NULL, NULL),
(55, 'Helper', 'Helper', 'web', 7, NULL, NULL),
(56, 'Camp cleaner', 'Campcleaner', 'web', 9, NULL, NULL),
(57, 'Bobcat Operator', 'BobcatOperator', 'web', 5, NULL, NULL),
(3, 'Customer', 'customer', 'web', 2000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` int(11) NOT NULL,
  `estimation_id` int(11) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `order_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_time` time DEFAULT NULL,
  `pump` int(11) DEFAULT NULL,
  `pump_op_id` int(11) DEFAULT NULL,
  `pump_helper_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `sales_agent` int(11) DEFAULT NULL,
  `admin_note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_conditions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` double(10,2) DEFAULT NULL,
  `disc_amnt` double(10,2) DEFAULT NULL,
  `grand_tot` double(10,2) DEFAULT NULL,
  `structure` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `remark` text CHARACTER SET utf8 DEFAULT NULL,
  `order_status` enum('pending','in-progress','testing','re-build','re-testing','granted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `advance_payment` double(10,2) NOT NULL DEFAULT 0.00,
  `balance` double(10,2) NOT NULL DEFAULT 0.00,
  `extended_date` date DEFAULT NULL,
  `adv_plus_bal` double(10,2) NOT NULL DEFAULT 0.00,
  `is_previous_order` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cust_id`, `estimation_id`, `contract_id`, `order_no`, `delivery_date`, `delivery_time`, `pump`, `pump_op_id`, `pump_helper_id`, `driver_id`, `sales_agent`, `admin_note`, `client_note`, `terms_conditions`, `sub_total`, `disc_amnt`, `grand_tot`, `structure`, `remark`, `order_status`, `advance_payment`, `balance`, `extended_date`, `adv_plus_bal`, `is_previous_order`, `created_at`, `updated_at`) VALUES
(1, 14121185, NULL, 2, 'ORD-00001', '2022-02-16', '09:00:00', 1, 17, 18, 7, 2, NULL, 'Ignore it just for testing', NULL, 100.00, 0.00, 115.00, NULL, NULL, 'granted', 0.00, -115.00, '2022-02-16', 0.00, '0', '2022-02-16 05:03:27', '2022-02-16 05:03:27'),
(2, 14121178, NULL, 3, 'ORD-00002', '2022-02-17', '09:00:00', 1, 17, 18, 7, 2, NULL, NULL, NULL, 8000.00, 0.00, 9200.00, NULL, NULL, 'granted', 0.00, -9200.00, '2022-02-17', 0.00, '0', '2022-02-16 22:36:17', '2022-02-16 22:36:17'),
(3, 14121185, NULL, 2, 'ORD-00003', '2022-02-22', '09:00:00', 2, 144, 117, 157, NULL, NULL, NULL, NULL, 200.00, 0.00, 230.00, NULL, NULL, 'granted', 0.00, -345.00, '2022-02-22', -115.00, '0', '2022-02-22 18:57:21', '2022-02-22 18:57:21'),
(4, 14121185, NULL, 2, 'ORD-00004', '2022-02-22', '09:00:00', 1, 159, 118, 158, 2, NULL, NULL, NULL, 60.00, 0.00, 69.00, NULL, NULL, 'granted', 0.00, -414.00, '2022-02-22', -345.00, '0', '2022-02-22 20:34:53', '2022-02-22 20:34:53'),
(5, 14121174, NULL, 11, 'ORD-00005', '2022-02-22', '09:00:00', 1, 159, 18, 7, 2, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-02-22', 0.00, '0', '2022-02-22 20:50:53', '2022-02-22 20:50:53'),
(6, 14121174, NULL, 11, 'ORD-00006', '2022-02-22', '09:00:00', 3, 144, 117, 157, 2, NULL, NULL, NULL, 4000.00, 0.00, 4600.00, NULL, NULL, 'granted', 0.00, -4600.00, '2022-02-22', 0.00, '0', '2022-02-22 23:59:05', '2022-02-22 23:59:05'),
(7, 14121185, NULL, 1, 'ORD-00007', '2022-02-23', '09:00:00', 3, 74, 117, 158, 2, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -414.00, '2022-02-23', -414.00, '0', '2022-02-23 23:57:48', '2022-02-24 00:35:28'),
(8, 14121185, NULL, 1, 'ORD-00008', '2022-02-23', '09:00:00', 3, 77, 118, 158, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -414.00, '2022-02-23', -414.00, '0', '2022-02-24 00:14:57', '2022-02-24 00:14:57'),
(9, 14121185, NULL, 2, 'ORD-00009', '2022-02-23', '09:00:00', 3, 74, 117, 157, NULL, NULL, NULL, NULL, 6.00, 0.00, 6.90, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-23', -414.00, '0', '2022-02-24 00:34:18', '2022-02-24 00:34:18'),
(10, 14121185, NULL, 10, 'ORD-00010', '2022-02-23', '09:00:00', 3, 74, 117, 157, 2, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-23', -420.90, '0', '2022-02-24 00:47:27', '2022-02-24 00:47:27'),
(11, 14121185, NULL, 10, 'ORD-00011', '2022-02-23', '09:00:00', 3, 74, 117, 157, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-23', -420.90, '0', '2022-02-24 03:34:07', '2022-02-24 03:34:07'),
(12, 14121185, NULL, 10, 'ORD-00012', '2022-02-24', '09:00:00', 3, 129, 170, 156, 75, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-24', -420.90, '0', '2022-02-24 06:16:14', '2022-02-24 16:24:59'),
(13, 14121186, NULL, 15, 'ORD-00013', '2022-02-24', '09:00:00', 1, 124, 167, 155, 145, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-02-24', 0.00, '0', '2022-02-24 07:56:06', '2022-02-24 07:56:06'),
(14, 14121185, NULL, 1, 'ORD-00014', '2022-02-24', '09:00:00', 4, 129, 170, 141, 75, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-24', -420.90, '0', '2022-02-24 16:22:31', '2022-02-24 16:22:31'),
(15, 14121185, NULL, 10, 'ORD-00015', '2022-02-24', '09:00:00', 4, 129, 172, 141, 75, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-24', -420.90, '0', '2022-02-24 16:26:08', '2022-02-24 16:26:08'),
(16, 14121185, NULL, 10, 'ORD-00016', '2022-02-24', '09:00:00', 4, 129, 172, 141, 75, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-24', -420.90, '0', '2022-02-24 16:47:55', '2022-02-24 16:48:59'),
(17, 14121185, NULL, 10, 'ORD-00017', '2022-02-24', '09:00:00', 4, 133, 172, 141, 75, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-24', -420.90, '0', '2022-02-24 17:15:28', '2022-02-24 22:40:12'),
(18, 14121185, NULL, 10, 'ORD-00018', '2022-02-24', '09:00:00', 4, 133, 172, 141, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -420.90, '2022-02-24', -420.90, '0', '2022-02-24 17:18:34', '2022-02-24 22:40:12'),
(19, 14121185, NULL, 2, 'ORD-00019', '2022-02-24', '09:00:00', 5, 133, 172, 158, 145, NULL, NULL, NULL, 30.00, 0.00, 34.50, NULL, NULL, 'granted', 0.00, -455.40, '2022-02-24', -420.90, '0', '2022-02-24 17:27:16', '2022-02-24 17:27:16'),
(20, 14121185, NULL, 10, 'ORD-00020', '2022-02-24', '09:00:00', 5, 133, 13, 157, 88, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -455.40, '2022-02-24', -455.40, '0', '2022-02-24 22:42:25', '2022-02-24 22:42:25'),
(21, 14121185, NULL, 1, 'ORD-00021', '2022-02-25', '09:00:00', 5, 133, 172, 158, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -455.40, '2022-02-25', -455.40, '0', '2022-02-25 05:05:02', '2022-02-25 05:05:02'),
(22, 14121174, NULL, 11, 'ORD-00022', '2022-03-07', '09:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 40000.00, 0.00, 46000.00, NULL, NULL, 'granted', 0.00, -50600.00, '2022-03-07', -4600.00, '0', '2022-03-07 11:21:54', '2022-03-07 11:21:54'),
(23, 14121174, NULL, 11, 'ORD-00023', '2022-03-08', '10:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 7800.00, 0.00, 8970.00, NULL, NULL, 'granted', 0.00, -59570.00, '2022-03-08', -50600.00, '0', '2022-03-08 22:23:09', '2022-03-08 22:23:09'),
(24, 14121235, NULL, 49, 'ORD-00024', '2022-03-09', '01:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 3900.00, 0.00, 4485.00, NULL, NULL, 'granted', 0.00, -4485.00, '2022-03-09', 0.00, '0', '2022-03-09 18:30:12', '2022-03-09 18:30:12'),
(25, 14121236, NULL, 50, 'ORD-00025', '2022-03-09', '01:00:00', 7, 85, 14121198, 14121194, NULL, NULL, NULL, NULL, 76000.00, 0.00, 87400.00, NULL, NULL, 'granted', 0.00, -87400.00, '2022-03-09', 0.00, '0', '2022-03-09 18:38:57', '2022-03-09 21:50:10'),
(26, 14121237, NULL, 51, 'ORD-00026', '2022-03-09', '01:00:00', 1, 85, 14121198, 14121187, NULL, NULL, NULL, NULL, 85280.00, 0.00, 98072.00, NULL, NULL, 'granted', 0.00, -98072.00, '2022-03-09', 0.00, '0', '2022-03-09 18:55:59', '2022-03-09 21:50:10'),
(27, 14121238, NULL, 52, 'ORD-00027', '2022-03-09', '01:00:00', 8, 85, 14121198, 14121195, NULL, NULL, NULL, NULL, 42000.00, 0.00, 48300.00, NULL, NULL, 'granted', 0.00, -48300.00, '2022-03-09', 0.00, '0', '2022-03-09 19:02:45', '2022-03-09 19:02:45'),
(28, 14121175, NULL, 53, 'ORD-00028', '2022-03-09', '16:00:00', 1, 14121242, 14121243, 14121187, NULL, NULL, NULL, NULL, 115000.00, 0.00, 132250.00, NULL, NULL, 'granted', 0.00, -132250.00, '2022-03-09', 0.00, '0', '2022-03-09 19:16:15', '2022-03-09 23:03:31'),
(29, 14121180, NULL, 6, 'ORD-00029', '2022-03-09', '17:00:00', 2, 118, 14121204, 14121192, NULL, NULL, NULL, NULL, 26400.00, 0.00, 30360.00, NULL, NULL, 'granted', 0.00, -30360.00, '2022-03-09', 0.00, '0', '2022-03-09 19:27:19', '2022-03-09 19:27:19'),
(30, 14121239, NULL, 54, 'ORD-00030', '2022-03-09', '17:00:00', 3, 117, 14121197, 14121189, NULL, NULL, NULL, NULL, 20000.00, 0.00, 23000.00, NULL, NULL, 'granted', 0.00, -23000.00, '2022-03-09', 0.00, '0', '2022-03-09 19:33:19', '2022-03-09 19:33:19'),
(31, 14121241, NULL, 55, 'ORD-00031', '2022-03-09', '17:00:00', 11, 117, 14121197, 14121240, NULL, NULL, NULL, NULL, 8208.00, 0.00, 9439.20, NULL, NULL, 'granted', 0.00, -9439.20, '2022-03-09', 0.00, '0', '2022-03-09 19:47:37', '2022-03-09 22:26:23'),
(32, 14121244, NULL, 56, 'ORD-00032', '2022-03-09', '17:00:00', 5, 117, 14121197, 14121191, NULL, NULL, NULL, NULL, 58500.00, 0.00, 67275.00, NULL, NULL, 'granted', 0.00, -67275.00, '2022-03-09', 0.00, '0', '2022-03-09 19:53:52', '2022-03-09 22:11:32'),
(33, 14121177, NULL, 14, 'ORD-00033', '2022-03-09', '17:00:00', 6, 117, 14121197, 14121193, NULL, NULL, NULL, NULL, 127600.00, 0.00, 146740.00, NULL, NULL, 'granted', 0.00, -146740.00, '2022-03-09', 0.00, '0', '2022-03-09 20:03:13', '2022-03-09 22:11:32'),
(34, 14121245, NULL, 57, 'ORD-00034', '2022-03-09', '22:00:00', 8, 85, 14121198, 14121195, NULL, NULL, NULL, NULL, 8000.00, 0.00, 9200.00, NULL, NULL, 'granted', 0.00, -9200.00, '2022-03-09', 0.00, '0', '2022-03-09 20:11:27', '2022-03-09 20:11:27'),
(35, 14121246, NULL, 58, 'ORD-00035', '2022-03-09', '22:00:00', 7, 18, 13, 14121194, NULL, NULL, NULL, NULL, 10000.00, 0.00, 11500.00, NULL, NULL, 'granted', 0.00, -11500.00, '2022-03-09', 0.00, '0', '2022-03-09 20:14:28', '2022-03-09 20:14:28'),
(36, 14121228, NULL, 59, 'ORD-00036', '2022-03-09', '23:00:00', 5, 39, 14121202, 14121191, NULL, NULL, NULL, NULL, 18400.00, 0.00, 21160.00, NULL, NULL, 'granted', 0.00, -21160.00, '2022-03-09', 0.00, '0', '2022-03-09 20:21:15', '2022-03-09 20:21:15'),
(37, 14121219, NULL, 38, 'ORD-00037', '2022-03-09', '23:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 13800.00, 0.00, 15870.00, NULL, NULL, 'granted', 0.00, -15870.00, '2022-03-09', 0.00, '0', '2022-03-09 20:26:16', '2022-03-09 20:26:16'),
(38, 14121219, NULL, 38, 'ORD-00038', '2022-03-09', '23:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 52000.00, 0.00, 59800.00, NULL, NULL, 'granted', 0.00, -75670.00, '2022-03-09', -15870.00, '0', '2022-03-09 20:27:09', '2022-03-09 20:27:09'),
(39, 14121247, NULL, 60, 'ORD-00039', '2022-03-09', '00:00:00', 2, 118, 14121204, 14121192, NULL, NULL, NULL, NULL, 50700.00, 0.00, 58305.00, NULL, NULL, 'granted', 0.00, -58305.00, '2022-03-09', 0.00, '0', '2022-03-09 20:31:25', '2022-03-09 20:31:25'),
(40, 14121178, NULL, 61, 'ORD-00040', '2022-03-09', '13:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 60000.00, 0.00, 69000.00, NULL, NULL, 'granted', 0.00, -78200.00, '2022-03-09', -9200.00, '0', '2022-03-09 20:44:26', '2022-03-09 20:44:26'),
(41, 14121211, NULL, 25, 'ORD-00041', '2022-03-09', '13:00:00', 3, 117, 14121197, 14121189, NULL, NULL, NULL, NULL, 4840.00, 0.00, 5566.00, NULL, NULL, 'granted', 0.00, -5566.00, '2022-03-09', 0.00, '0', '2022-03-09 20:46:57', '2022-03-09 20:46:57'),
(42, 14121210, NULL, 20, 'ORD-00042', '2022-03-09', '13:00:00', 6, 46, 14121201, 14121193, NULL, NULL, NULL, NULL, 20.00, 0.00, 23.00, NULL, NULL, 'granted', 0.00, -23.00, '2022-03-09', 0.00, '0', '2022-03-09 20:54:28', '2022-03-09 20:54:28'),
(43, 14121210, NULL, 21, 'ORD-00043', '2022-03-09', '13:00:00', 6, 46, 14121201, 14121193, NULL, NULL, NULL, NULL, 20.00, 0.00, 23.00, NULL, NULL, 'granted', 0.00, -46.00, '2022-03-09', -23.00, '0', '2022-03-09 20:55:10', '2022-03-09 20:55:10'),
(44, 14121245, NULL, 62, 'ORD-00044', '2022-03-09', '14:00:00', 8, 85, 14121198, 14121195, NULL, NULL, NULL, NULL, 50700.00, 0.00, 58305.00, NULL, NULL, 'granted', 0.00, -67505.00, '2022-03-09', -9200.00, '0', '2022-03-09 21:00:41', '2022-03-09 21:00:41'),
(45, 14121219, NULL, 38, 'ORD-00045', '2022-03-09', '14:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 52000.00, 0.00, 59800.00, NULL, NULL, 'granted', 0.00, -135470.00, '2022-03-09', -75670.00, '0', '2022-03-09 21:03:07', '2022-03-09 21:03:07'),
(46, 14121248, NULL, 63, 'ORD-00046', '2022-03-09', '15:00:00', 8, 85, 14121198, 14121195, NULL, NULL, NULL, NULL, 36000.00, 0.00, 41400.00, NULL, NULL, 'granted', 0.00, -41400.00, '2022-03-09', 0.00, '0', '2022-03-09 21:07:02', '2022-03-09 21:07:02'),
(47, 14121249, NULL, 64, 'ORD-00047', '2022-03-09', '15:00:00', 7, 18, 13, 14121194, NULL, NULL, NULL, NULL, 7020.00, 0.00, 8073.00, NULL, NULL, 'granted', 0.00, -8073.00, '2022-03-09', 0.00, '0', '2022-03-09 21:10:16', '2022-03-09 21:10:16'),
(48, 14121234, NULL, 66, 'ORD-00048', '2022-03-09', '16:00:00', 3, 117, 14121197, 14121189, NULL, NULL, NULL, NULL, 7800.00, 0.00, 8970.00, NULL, NULL, 'granted', 0.00, -8970.00, '2022-03-09', 0.00, '0', '2022-03-09 21:21:31', '2022-03-09 21:21:31'),
(49, 14121174, NULL, 11, 'ORD-00049', '2022-03-09', '16:00:00', 3, 117, 14121197, 14121189, NULL, NULL, NULL, NULL, 78000.00, 0.00, 89700.00, NULL, NULL, 'granted', 0.00, -149270.00, '2022-03-09', -59570.00, '0', '2022-03-10 00:14:55', '2022-03-10 00:14:55'),
(50, 14121224, NULL, 40, 'ORD-00050', '2022-03-10', '04:00:00', 2, 118, 14121204, 14121192, NULL, NULL, NULL, NULL, 202840.00, 0.00, 233266.00, NULL, NULL, 'granted', 0.00, -233266.00, '2022-03-10', 0.00, '0', '2022-03-10 21:56:43', '2022-03-10 21:56:43'),
(51, 14121227, NULL, 43, 'ORD-00051', '2022-03-14', '14:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 92000.00, 0.00, 105800.00, NULL, NULL, 'granted', 0.00, -105800.00, '2022-03-14', 0.00, '0', '2022-03-14 17:44:21', '2022-03-14 17:44:21'),
(52, 14121251, NULL, 67, 'ORD-00052', '2022-03-14', '09:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 390.00, 0.00, 448.50, NULL, NULL, 'granted', 0.00, -448.50, '2022-03-14', 0.00, '0', '2022-03-14 18:19:00', '2022-03-14 18:19:00'),
(53, 14121174, NULL, 11, 'ORD-00053', '2022-03-14', '09:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 9750.00, 0.00, 11212.50, NULL, NULL, 'granted', 0.00, -160482.50, '2022-03-14', -149270.00, '0', '2022-03-14 19:10:51', '2022-03-14 19:10:51'),
(54, 14121174, NULL, 11, 'ORD-00054', '2022-03-14', '09:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 9750.00, 0.00, 11212.50, NULL, NULL, 'granted', 0.00, -171695.00, '2022-03-14', -160482.50, '0', '2022-03-14 21:05:10', '2022-03-14 21:05:10'),
(55, 14121174, NULL, 11, 'ORD-00055', '2022-03-15', '09:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -181562.00, '2022-03-15', -171695.00, '0', '2022-03-16 04:41:35', '2022-03-16 04:41:35'),
(56, 14121174, NULL, 11, 'ORD-00056', '2022-03-16', '09:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -191429.00, '2022-03-16', -181562.00, '0', '2022-03-16 04:43:27', '2022-03-16 04:43:27'),
(57, 14121174, NULL, 11, 'ORD-00057', '2022-03-16', '09:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -201296.00, '2022-03-16', -191429.00, '0', '2022-03-16 23:10:50', '2022-03-16 23:10:50'),
(58, 14121174, NULL, 11, 'ORD-00058', '2022-03-16', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6630.00, 0.00, 7624.50, NULL, NULL, 'granted', 0.00, -208920.50, '2022-03-16', -201296.00, '0', '2022-03-17 01:08:36', '2022-03-17 01:08:36'),
(59, 14121174, NULL, 11, 'ORD-00059', '2022-03-16', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -208920.50, '2022-03-16', -208920.50, '0', '2022-03-17 03:23:56', '2022-03-17 03:23:56'),
(60, 14121174, NULL, 11, 'ORD-00060', '2022-03-17', '09:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 97500.00, 0.00, 112125.00, NULL, NULL, 'granted', 0.00, -321045.50, '2022-03-17', -208920.50, '0', '2022-03-17 15:34:32', '2022-03-17 19:52:25'),
(61, 14121176, NULL, 13, 'ORD-00061', '2022-03-17', '09:00:00', 11, 14121242, 14121243, 14121240, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-03-17', 0.00, '0', '2022-03-17 15:43:08', '2022-03-17 15:43:08'),
(62, 14121174, NULL, 11, 'ORD-00062', '2022-03-17', '09:00:00', NULL, 14121242, 14121243, NULL, NULL, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -330912.50, '2022-03-17', -321045.50, '0', '2022-03-17 16:29:47', '2022-03-17 16:30:51'),
(63, 14121174, NULL, 11, 'ORD-00063', '2022-03-17', '09:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -340779.50, '2022-03-17', -330912.50, '0', '2022-03-17 17:53:21', '2022-03-17 17:54:18'),
(64, 14121180, NULL, 5, 'ORD-00064', '2022-03-17', '09:00:00', NULL, 14121242, 14121243, 158, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -30360.00, '2022-03-17', -30360.00, '0', '2022-03-17 19:54:51', '2022-03-17 19:56:24'),
(65, 14121174, NULL, 11, 'ORD-00065', '2022-03-17', '09:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -350646.50, '2022-03-17', -340779.50, '0', '2022-03-18 03:08:56', '2022-03-18 03:09:29'),
(66, 14121175, NULL, 53, 'ORD-00066', '2022-03-20', '13:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 460.00, 0.00, 529.00, NULL, NULL, 'granted', 0.00, -132779.00, '2022-03-20', -132250.00, '0', '2022-03-20 18:37:16', '2022-03-20 18:38:24'),
(67, 14121179, NULL, 9, 'ORD-00067', '2022-03-20', '13:00:00', NULL, 14121242, 14121243, NULL, NULL, NULL, NULL, NULL, 11500.00, 0.00, 13225.00, NULL, NULL, 'granted', 0.00, -13225.00, '2022-03-20', 0.00, '0', '2022-03-20 18:40:28', '2022-03-20 18:41:29'),
(68, 14121174, NULL, 11, 'ORD-00068', '2022-03-20', '21:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 7800.00, 0.00, 8970.00, NULL, NULL, 'granted', 0.00, -359616.50, '2022-03-20', -350646.50, '0', '2022-03-20 20:27:42', '2022-03-20 20:41:32'),
(69, 14121175, NULL, 53, 'ORD-00069', '2022-03-20', '16:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 13800.00, 0.00, 15870.00, NULL, NULL, 'granted', 0.00, -148649.00, '2022-03-20', -132779.00, '0', '2022-03-20 20:53:42', '2022-03-20 21:10:27'),
(70, 14121180, NULL, 5, 'ORD-00070', '2022-03-20', '15:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -30360.00, '2022-03-20', -30360.00, '0', '2022-03-20 21:16:12', '2022-03-20 21:18:23'),
(71, 14121176, NULL, 13, 'ORD-00071', '2022-03-22', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-03-22', 0.00, '0', '2022-03-22 14:58:30', '2022-03-22 14:58:30'),
(72, 14121174, NULL, 11, 'ORD-00072', '2022-03-23', '09:05:00', 1, 63, 14121203, 14121187, 145, NULL, NULL, NULL, 8580.00, 0.00, 9867.00, NULL, NULL, 'granted', 0.00, -369483.50, '2022-03-23', -359616.50, '0', '2022-03-23 23:43:14', '2022-03-23 23:43:36'),
(73, 14121176, NULL, 13, 'ORD-00073', '2022-03-26', '11:00:00', NULL, 133, 167, NULL, NULL, NULL, NULL, NULL, 19500.00, 0.00, 22425.00, NULL, NULL, 'granted', 0.00, -22425.00, '2022-03-26', 0.00, '0', '2022-03-26 16:28:01', '2022-03-26 16:35:41'),
(74, 14121180, NULL, 6, 'ORD-00074', '2022-03-26', '15:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 6900.00, 0.00, 7935.00, NULL, NULL, 'granted', 0.00, -38295.00, '2022-03-26', -30360.00, '0', '2022-03-26 20:30:12', '2022-03-26 20:31:20'),
(75, 14121177, NULL, 14, 'ORD-00075', '2022-03-26', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9750.00, 0.00, 11212.50, NULL, NULL, 'granted', 0.00, -157952.50, '2022-03-26', -146740.00, '0', '2022-03-26 20:35:47', '2022-03-26 20:35:48'),
(76, 14121174, NULL, 11, 'ORD-00076', '2022-03-27', '09:00:00', 2, 78, 14121202, 14121187, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -369483.50, '2022-03-27', -369483.50, '0', '2022-03-27 22:53:05', '2022-03-27 22:53:53'),
(77, 14121185, NULL, 1, 'ORD-00077', '2022-03-28', '12:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -455.40, '2022-03-28', -455.40, '0', '2022-03-28 17:26:39', '2022-03-28 17:26:39'),
(78, 14121176, NULL, 13, 'ORD-00078', '2022-03-28', '09:00:00', 2, 118, 14121204, 14121192, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -22425.00, '2022-03-28', -22425.00, '0', '2022-03-28 19:32:48', '2022-03-28 19:32:48'),
(79, 14121235, NULL, 49, 'ORD-00079', '2022-03-28', '14:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 390.00, 0.00, 448.50, NULL, NULL, 'granted', 0.00, -4933.50, '2022-03-28', -4485.00, '0', '2022-03-28 19:33:33', '2022-03-28 19:33:33'),
(80, 14121175, NULL, 53, 'ORD-00080', '2022-03-29', '17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 460.00, 0.00, 529.00, NULL, NULL, 'granted', 0.00, -149178.00, '2022-03-29', -148649.00, '0', '2022-03-29 20:47:46', '2022-03-29 20:47:46'),
(81, 14121178, NULL, 3, 'ORD-00081', '2022-03-29', '17:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 32000.00, 0.00, 36800.00, NULL, NULL, 'granted', 0.00, -115000.00, '2022-03-29', -78200.00, '0', '2022-03-29 20:52:11', '2022-03-29 20:52:11'),
(82, 14121174, NULL, 11, 'ORD-00082', '2022-03-29', '19:00:00', 1, 63, 14121203, 14121187, NULL, NULL, NULL, NULL, 11700.00, 0.00, 13455.00, NULL, NULL, 'granted', 0.00, -382938.50, '2022-03-29', -369483.50, '0', '2022-03-29 21:06:21', '2022-03-29 21:06:21'),
(83, 14121174, NULL, 11, 'ORD-00083', '2022-04-09', '09:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 11700.00, 0.00, 13455.00, NULL, NULL, 'granted', 0.00, -396393.50, '2022-04-09', -382938.50, '0', '2022-04-09 10:33:25', '2022-04-09 10:33:25'),
(84, 14121174, NULL, 11, 'ORD-00084', '2022-04-09', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5460.00, 0.00, 6279.00, NULL, NULL, 'granted', 0.00, -402672.50, '2022-04-09', -396393.50, '0', '2022-04-09 21:09:18', '2022-04-09 21:09:20'),
(85, 14121176, NULL, 13, 'ORD-00085', '2022-04-10', '09:00:00', NULL, 144, 167, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -22425.00, '2022-04-10', -22425.00, '0', '2022-04-10 04:09:11', '2022-04-10 04:09:47'),
(86, 14121174, NULL, 11, 'ORD-00086', '2022-04-10', '09:00:00', 1, 63, 14121203, 158, NULL, NULL, NULL, NULL, 390.00, 0.00, 448.50, NULL, NULL, 'granted', 0.00, -403121.00, '2022-04-10', -402672.50, '0', '2022-04-10 16:27:40', '2022-04-10 16:27:40'),
(87, 14121176, NULL, 13, 'ORD-00087', '2022-04-10', '09:00:00', 1, 63, 14121203, 158, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -22425.00, '2022-04-10', -22425.00, '0', '2022-04-10 16:30:41', '2022-04-10 16:30:41'),
(88, 14121175, NULL, 53, 'ORD-00088', '2022-04-10', '09:00:00', 5, 39, 14121202, 155, NULL, NULL, NULL, NULL, 460.00, 0.00, 529.00, NULL, NULL, 'granted', 0.00, -149707.00, '2022-04-10', -149178.00, '0', '2022-04-10 16:35:48', '2022-04-10 16:35:48'),
(89, 14121185, NULL, 1, 'ORD-00089', '2022-04-10', '09:00:00', 9, 22, 14, 141, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -455.40, '2022-04-10', -455.40, '0', '2022-04-10 16:43:20', '2022-04-10 16:43:20'),
(90, 14121174, NULL, 11, 'ORD-00090', '2022-04-10', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5850.00, 0.00, 6727.50, NULL, NULL, 'granted', 0.00, -409848.50, '2022-04-10', -403121.00, '0', '2022-04-10 17:07:04', '2022-04-10 17:07:04'),
(91, 14121214, NULL, 29, 'ORD-00091', '2022-04-10', '09:00:00', 10, 133, 14121199, 126, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-04-10', 0.00, '0', '2022-04-10 18:21:51', '2022-04-10 18:21:51'),
(92, 14121174, NULL, 11, 'ORD-00092', '2022-04-11', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6240.00, 0.00, 7176.00, NULL, NULL, 'granted', 0.00, -417024.50, '2022-04-10', -409848.50, '0', '2022-04-11 16:15:09', '2022-04-11 16:15:09'),
(93, 14121214, NULL, 29, 'ORD-00093', '2022-04-11', '09:00:00', 10, 133, 14121199, 152, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-04-11', 0.00, '0', '2022-04-11 16:41:24', '2022-04-11 16:41:24'),
(94, 14121174, NULL, 11, 'ORD-00094', '2022-04-11', '21:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -417024.50, '2022-04-10', -417024.50, '0', '2022-04-11 17:26:08', '2022-04-11 17:26:08'),
(95, 14121174, NULL, 11, 'ORD-00095', '2022-04-11', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -417024.50, '2022-04-12', -417024.50, '0', '2022-04-12 01:23:56', '2022-04-12 18:16:15'),
(96, 14121176, NULL, 13, 'ORD-00096', '2022-04-12', '09:00:00', NULL, 144, 167, 158, NULL, NULL, NULL, NULL, 20000.00, 0.00, 23000.00, NULL, NULL, 'granted', 0.00, -45425.00, '2022-04-12', -22425.00, '0', '2022-04-12 07:24:57', '2022-04-12 07:25:45'),
(97, 14121174, NULL, 11, 'ORD-00097', '2022-04-12', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -417024.50, '2022-04-13', -417024.50, '0', '2022-04-13 00:19:13', '2022-04-13 11:00:36'),
(98, 14121181, NULL, 4, 'ORD-00098', '2022-04-14', '09:00:00', 2, 118, 14121204, 157, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-04-17', 0.00, '0', '2022-04-14 04:19:43', '2022-04-17 11:00:28'),
(99, 14121175, NULL, 53, 'ORD-00099', '2022-04-14', '10:00:00', 2, 118, 14121204, NULL, NULL, NULL, NULL, NULL, 11500.00, 0.00, 13225.00, NULL, NULL, 'granted', 0.00, -162932.00, '2022-04-17', -149707.00, '0', '2022-04-14 04:20:10', '2022-04-17 11:00:28'),
(100, 14121176, NULL, 13, 'ORD-00100', '2022-04-19', '09:00:00', 1, 63, 14121203, 158, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -45425.00, '2022-04-19', -45425.00, '0', '2022-04-19 17:14:22', '2022-04-19 17:14:22'),
(101, 14121236, NULL, 50, 'ORD-00101', '2022-04-19', '09:00:00', 1, 63, 14121203, 158, NULL, NULL, NULL, NULL, 56000.00, 0.00, 64400.00, NULL, NULL, 'granted', 0.00, -151800.00, '2022-04-21', -87400.00, '0', '2022-04-19 18:01:26', '2022-04-21 11:00:03'),
(102, 14121236, NULL, 50, 'ORD-00102', '2022-04-22', '20:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 6400.00, 0.00, 7360.00, NULL, NULL, 'granted', 0.00, -159160.00, '2022-04-26', -151800.00, '0', '2022-04-22 22:01:55', '2022-04-26 11:00:44'),
(103, 14121218, NULL, 37, 'ORD-00103', '2022-04-22', '03:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-04-26', 0.00, '0', '2022-04-22 22:03:30', '2022-04-26 11:00:44'),
(104, 14121236, NULL, 50, 'ORD-00104', '2022-04-28', '13:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 56000.00, 0.00, 64400.00, NULL, NULL, 'granted', 0.00, -223560.00, '2022-06-22', -159160.00, '0', '2022-04-26 05:40:40', '2022-06-22 11:00:32'),
(105, 14121236, NULL, 50, 'ORD-00105', '2022-04-28', '13:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 56000.00, 0.00, 64400.00, NULL, NULL, 'granted', 0.00, -287960.00, '2022-06-22', -223560.00, '0', '2022-04-26 05:40:41', '2022-06-22 11:00:32'),
(106, 14121181, NULL, 4, 'ORD-00106', '2022-04-28', '19:00:00', 9, 22, 14, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-04-26 05:42:32', '2022-06-22 11:00:32'),
(107, 14121217, NULL, 36, 'ORD-00107', '2022-04-28', '04:00:00', 9, 22, 14, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-04-26 05:45:47', '2022-06-22 11:00:32'),
(108, 14121210, NULL, 20, 'ORD-00108', '2022-05-11', '09:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 100.00, 0.00, 115.00, NULL, NULL, 'granted', 0.00, -161.00, '2022-06-22', -46.00, '0', '2022-05-10 19:44:28', '2022-06-22 11:00:32'),
(109, 14121226, NULL, 42, 'ORD-00109', '2022-05-11', '01:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-05-10 19:50:25', '2022-06-22 11:00:32'),
(110, 14121226, NULL, 42, 'ORD-00110', '2022-05-11', '01:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-05-10 19:50:26', '2022-06-22 11:00:32'),
(111, 14121236, NULL, 50, 'ORD-00111', '2022-05-11', '09:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 8000.00, 0.00, 9200.00, NULL, NULL, 'granted', 0.00, -297160.00, '2022-06-22', -287960.00, '0', '2022-05-10 19:51:12', '2022-06-22 11:00:32'),
(112, 14121227, NULL, 43, 'ORD-00112', '2022-05-11', '13:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 84000.00, 0.00, 96600.00, NULL, NULL, 'granted', 0.00, -202400.00, '2022-06-22', -105800.00, '0', '2022-05-10 19:52:24', '2022-06-22 11:00:32'),
(113, 14121218, NULL, 37, 'ORD-00113', '2022-05-11', '05:00:00', 5, 39, 14121202, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-05-10 19:54:00', '2022-06-22 11:00:32'),
(114, 14121222, NULL, 90, 'ORD-00114', '2022-05-14', '09:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 58500.00, 0.00, 67275.00, NULL, NULL, 'granted', 0.00, -67275.00, '2022-06-22', 0.00, '0', '2022-05-12 18:07:44', '2022-06-22 11:00:32'),
(115, 14121179, NULL, 26, 'ORD-00115', '2022-05-14', '09:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, -13225.00, '2022-06-22', -13225.00, '0', '2022-05-12 18:08:51', '2022-06-22 11:00:32'),
(116, 14121256, NULL, 91, 'ORD-00116', '2022-05-14', '09:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 460.00, 0.00, 529.00, NULL, NULL, 'granted', 0.00, -529.00, '2022-06-22', 0.00, '0', '2022-05-12 18:09:41', '2022-06-22 11:00:32'),
(117, 14121251, NULL, 67, 'ORD-00117', '2022-05-14', '13:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 58500.00, 0.00, 67275.00, NULL, NULL, 'granted', 0.00, -67723.50, '2022-06-22', -448.50, '0', '2022-05-12 18:10:27', '2022-06-22 11:00:32'),
(118, 14121251, NULL, 67, 'ORD-00118', '2022-05-14', '13:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 58500.00, 0.00, 67275.00, NULL, NULL, 'granted', 0.00, -134998.50, '2022-06-22', -67723.50, '0', '2022-05-12 18:11:05', '2022-06-22 11:00:32'),
(119, 14121231, NULL, 87, 'ORD-00119', '2022-05-14', '13:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 46000.00, 0.00, 52900.00, NULL, NULL, 'granted', 0.00, -52900.00, '2022-06-22', 0.00, '0', '2022-05-12 18:12:50', '2022-06-22 11:00:32'),
(120, 14121257, NULL, 92, 'ORD-00120', '2022-05-14', '05:00:00', 6, 46, 14121201, NULL, NULL, NULL, NULL, NULL, 44000.00, 0.00, 50600.00, NULL, NULL, 'granted', 0.00, -50600.00, '2022-06-22', 0.00, '0', '2022-05-12 18:13:26', '2022-06-22 11:00:32'),
(121, 14121257, NULL, 92, 'ORD-00121', '2022-05-14', '05:00:00', 6, 46, 14121201, NULL, NULL, NULL, NULL, NULL, 44000.00, 0.00, 50600.00, NULL, NULL, 'granted', 0.00, -101200.00, '2022-06-22', -50600.00, '0', '2022-05-12 18:13:32', '2022-06-22 11:00:32'),
(122, 14121259, NULL, 94, 'ORD-00122', '2022-05-14', '09:00:00', 4, 35, 15, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-05-12 18:15:07', '2022-06-22 11:00:32'),
(123, 14121253, NULL, 69, 'ORD-00123', '2022-05-14', '13:00:00', 2, 118, 14121204, NULL, NULL, NULL, NULL, NULL, 16000.00, 0.00, 18400.00, NULL, NULL, 'granted', 0.00, -18400.00, '2022-06-22', 0.00, '0', '2022-05-12 18:15:55', '2022-06-22 11:00:32'),
(124, 14121206, NULL, 16, 'ORD-00124', '2022-05-14', '01:00:00', 4, 35, 15, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 'granted', 0.00, 0.00, '2022-06-22', 0.00, '0', '2022-05-12 18:16:32', '2022-06-22 11:00:32'),
(125, 14121262, NULL, 97, 'ORD-00125', '2022-05-14', '06:00:00', 3, 117, 14121197, NULL, NULL, NULL, NULL, NULL, 5980.00, 0.00, 6877.00, NULL, NULL, 'granted', 0.00, -6877.00, '2022-05-16', 0.00, '0', '2022-05-12 18:18:42', '2022-05-16 11:00:23'),
(126, 14121259, NULL, 94, 'ORD-00126', '2022-05-17', '09:00:00', 5, 39, 14121202, NULL, NULL, NULL, NULL, NULL, 80000.00, 0.00, 92000.00, NULL, NULL, 'granted', 0.00, -92000.00, '2022-06-22', 0.00, '0', '2022-05-16 15:12:09', '2022-06-22 11:00:32'),
(127, 14121214, NULL, 102, 'ORD-00127', '2022-05-17', '09:00:00', 3, 63, 14121203, NULL, NULL, 'alrayan - column - 0554530290', NULL, NULL, 400.00, 0.00, 460.00, NULL, NULL, 'granted', 0.00, -460.00, '2022-06-22', 0.00, '0', '2022-05-16 15:17:06', '2022-06-22 11:00:32'),
(128, 14121233, NULL, 46, 'ORD-00128', '2022-05-17', '09:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 10580.00, 0.00, 12167.00, NULL, NULL, 'granted', 0.00, -12167.00, '2022-06-22', 0.00, '0', '2022-05-16 15:18:05', '2022-06-22 11:00:32'),
(129, 14121227, NULL, 43, 'ORD-00129', '2022-05-17', '14:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 16000.00, 0.00, 18400.00, NULL, NULL, 'granted', 0.00, -220800.00, '2022-06-22', -202400.00, '0', '2022-05-16 15:18:46', '2022-06-22 11:00:32'),
(130, 14121180, NULL, 6, 'ORD-00130', '2022-05-17', '03:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 72000.00, 0.00, 82800.00, NULL, NULL, 'granted', 0.00, -121095.00, '2022-06-22', -38295.00, '0', '2022-05-16 15:19:38', '2022-06-22 11:00:32'),
(131, 14121180, NULL, 6, 'ORD-00131', '2022-05-17', '03:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 72000.00, 0.00, 82800.00, NULL, NULL, 'granted', 0.00, -203895.00, '2022-06-22', -121095.00, '0', '2022-05-16 15:19:39', '2022-06-22 11:00:32'),
(132, 14121179, NULL, 9, 'ORD-00132', '2022-05-17', '11:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 46000.00, 0.00, 52900.00, NULL, NULL, 'granted', 0.00, -66125.00, '2022-06-22', -13225.00, '0', '2022-05-16 15:20:23', '2022-06-22 11:00:32'),
(133, 14121214, NULL, 29, 'ORD-00133', '2022-05-17', '05:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 40000.00, 0.00, 46000.00, NULL, NULL, 'granted', 0.00, -46460.00, '2022-06-22', -460.00, '0', '2022-05-16 15:21:49', '2022-06-22 11:00:32'),
(134, 14121175, NULL, 12, 'ORD-00134', '2022-05-17', '02:00:00', 10, 133, 14121199, NULL, NULL, NULL, NULL, NULL, 122500.00, 0.00, 140875.00, NULL, NULL, 'granted', 0.00, -303807.00, '2022-06-22', -162932.00, '0', '2022-05-16 15:22:42', '2022-06-22 11:00:32'),
(135, 14121266, NULL, 103, 'ORD-00135', '2022-05-17', '13:00:00', 10, 133, 14121199, NULL, NULL, NULL, NULL, NULL, 18000.00, 0.00, 20700.00, NULL, NULL, 'granted', 0.00, -20700.00, '2022-06-22', 0.00, '0', '2022-05-16 15:23:33', '2022-06-22 11:00:32'),
(136, 14121185, NULL, 10, 'ORD-00136', '2022-05-17', '05:00:00', 4, 35, 15, NULL, NULL, NULL, NULL, NULL, 48000.00, 0.00, 55200.00, NULL, NULL, 'granted', 0.00, -55655.40, '2022-06-22', -455.40, '0', '2022-05-16 15:24:10', '2022-06-22 11:00:32'),
(137, 14121211, NULL, 104, 'ORD-00137', '2022-05-17', '11:00:00', 5, 39, 14121202, NULL, NULL, NULL, NULL, NULL, 23000.00, 0.00, 26450.00, NULL, NULL, 'granted', 0.00, -32016.00, '2022-06-22', -5566.00, '0', '2022-05-16 15:25:05', '2022-06-22 11:00:32'),
(138, 14121267, NULL, 105, 'ORD-00138', '2022-05-17', '01:00:00', 3, 117, 14121197, NULL, NULL, NULL, NULL, NULL, 12000.00, 0.00, 13800.00, NULL, NULL, 'granted', 0.00, -13800.00, '2022-06-22', 0.00, '0', '2022-05-16 15:26:51', '2022-06-22 11:00:32'),
(139, 14121176, NULL, 13, 'ORD-00139', '2022-05-18', '22:00:00', 3, 133, 14121203, 26, NULL, NULL, NULL, NULL, 38000.00, 0.00, 43700.00, NULL, NULL, 'granted', 0.00, -89125.00, '2022-06-22', -45425.00, '0', '2022-05-17 18:05:39', '2022-06-22 11:00:32'),
(140, 14121175, NULL, 12, 'ORD-00140', '2022-05-18', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49000.00, 0.00, 56350.00, NULL, NULL, 'granted', 0.00, -360157.00, '2022-06-22', -303807.00, '0', '2022-05-17 18:08:39', '2022-06-22 11:00:32'),
(141, 14121262, NULL, 97, 'ORD-00141', '2022-05-18', '09:00:00', 8, 85, 14121198, 158, NULL, NULL, NULL, NULL, 78200.00, 0.00, 89930.00, NULL, NULL, 'granted', 0.00, -96807.00, '2022-06-22', -6877.00, '0', '2022-05-17 18:25:51', '2022-06-22 11:00:32'),
(142, 14121174, NULL, 11, 'ORD-00142', '2022-05-19', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6000.00, 0.00, 6900.00, NULL, NULL, 'granted', 0.00, -423924.50, '2022-06-22', -417024.50, '0', '2022-05-20 00:22:32', '2022-06-22 11:00:32'),
(143, 14121174, NULL, 11, 'ORD-00143', '2022-05-21', '14:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20000.00, 0.00, 23000.00, NULL, NULL, 'granted', 0.00, -446924.50, '2022-06-22', -423924.50, '0', '2022-05-22 02:28:58', '2022-06-22 11:00:32'),
(144, 14121272, NULL, 111, 'ORD-00144', '2022-05-25', '01:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 16560.00, 0.00, 19044.00, NULL, 'algamaa - column -', 'granted', 0.00, -19044.00, '2022-06-22', 0.00, '0', '2022-05-24 16:23:50', '2022-06-22 11:00:32'),
(145, 14121272, NULL, 110, 'ORD-00145', '2022-05-25', '01:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 92000.00, 0.00, 105800.00, NULL, NULL, 'granted', 0.00, -124844.00, '2022-06-22', -19044.00, '0', '2022-05-24 16:32:19', '2022-06-22 11:00:32'),
(146, 14121272, NULL, 110, 'ORD-00146', '2022-05-25', '01:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 460.00, 0.00, 529.00, NULL, NULL, '', 0.00, -125373.00, '2022-06-22', -124844.00, '0', '2022-05-24 16:33:52', '2022-06-22 11:00:32'),
(147, 14121263, NULL, 98, 'ORD-00147', '2022-05-25', '01:00:00', 10, 133, 14121199, NULL, NULL, NULL, NULL, NULL, 36800.00, 0.00, 42320.00, NULL, NULL, 'granted', 0.00, -42320.00, '2022-06-22', 0.00, '0', '2022-05-24 16:36:35', '2022-06-22 11:00:32'),
(148, 14121176, NULL, 13, 'ORD-00148', '2022-05-25', '10:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 85200.00, 0.00, 97980.00, NULL, NULL, 'granted', 0.00, -187105.00, '2022-06-22', -89125.00, '0', '2022-05-24 16:38:35', '2022-06-22 11:00:32'),
(149, 14121271, NULL, 109, 'ORD-00149', '2022-05-25', '01:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 10800.00, 0.00, 12420.00, NULL, NULL, 'granted', 0.00, -12420.00, '2022-06-22', 0.00, '0', '2022-05-24 16:39:16', '2022-06-22 11:00:32'),
(150, 14121211, NULL, 33, 'ORD-00150', '2022-05-25', '10:00:00', 8, 85, 14121198, NULL, NULL, NULL, NULL, NULL, 12420.00, 0.00, 14283.00, NULL, NULL, 'granted', 0.00, -46299.00, '2022-06-22', -32016.00, '0', '2022-05-24 16:41:04', '2022-06-22 11:00:32'),
(151, 14121236, NULL, 50, 'ORD-00151', '2022-05-30', '04:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 6000.00, 0.00, 6900.00, NULL, NULL, 'granted', 0.00, -304060.00, '2022-06-22', -297160.00, '0', '2022-05-29 18:51:04', '2022-06-22 11:00:32'),
(152, 14121227, NULL, 43, 'ORD-00152', '2022-05-30', '10:00:00', 1, 63, 14121203, NULL, NULL, NULL, NULL, NULL, 84000.00, 0.00, 96600.00, NULL, NULL, 'granted', 0.00, -317400.00, '2022-06-22', -220800.00, '0', '2022-05-29 18:51:46', '2022-06-22 11:00:32'),
(153, 14121251, NULL, 67, 'ORD-00153', '2022-05-30', '04:00:00', 10, 133, 14121199, NULL, NULL, NULL, NULL, NULL, 64000.00, 0.00, 73600.00, NULL, NULL, 'granted', 0.00, -208598.50, '2022-06-22', -134998.50, '0', '2022-05-29 18:52:46', '2022-06-22 11:00:32'),
(154, 14121251, NULL, 67, 'ORD-00154', '2022-05-30', '04:00:00', 10, 133, 14121199, NULL, NULL, NULL, NULL, NULL, 64000.00, 0.00, 73600.00, NULL, NULL, 'granted', 0.00, -282198.50, '2022-06-22', -208598.50, '0', '2022-05-29 18:52:47', '2022-06-22 11:00:32'),
(155, 14121211, NULL, 104, 'ORD-00155', '2022-05-30', '01:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 230000.00, 0.00, 264500.00, NULL, NULL, 'granted', 0.00, -310799.00, '2022-06-22', -46299.00, '0', '2022-05-29 18:56:13', '2022-06-22 11:00:32'),
(156, 14121259, NULL, 94, 'ORD-00156', '2022-05-30', '11:00:00', 7, 18, 13, NULL, NULL, NULL, NULL, NULL, 20700.00, 0.00, 23805.00, NULL, NULL, 'granted', 0.00, -115805.00, '2022-06-22', -92000.00, '0', '2022-05-29 18:57:08', '2022-06-22 11:00:32'),
(157, 14121209, NULL, 18, 'ORD-00157', '2022-05-30', '14:00:00', 3, 117, 14121197, NULL, NULL, NULL, NULL, NULL, 9600.00, 0.00, 11040.00, NULL, NULL, 'granted', 0.00, -11040.00, '2022-06-22', 0.00, '0', '2022-05-29 19:07:18', '2022-06-22 11:00:32'),
(158, 14121281, NULL, 125, 'ORD-00158', '2022-05-30', '01:00:00', 5, 39, 14121202, NULL, NULL, NULL, NULL, NULL, 28000.00, 0.00, 32200.00, NULL, NULL, 'granted', 0.00, -32200.00, '2022-06-22', 0.00, '0', '2022-05-29 19:10:14', '2022-06-22 11:00:32'),
(159, 14121252, NULL, 71, 'ORD-00159', '2022-05-30', '04:00:00', 4, 35, 15, NULL, NULL, NULL, NULL, NULL, 14000.00, 0.00, 16100.00, NULL, NULL, 'granted', 0.00, -16100.00, '2022-06-22', 0.00, '0', '2022-05-29 19:11:13', '2022-06-22 11:00:32'),
(160, 14121276, NULL, 120, 'ORD-00160', '2022-05-30', '14:00:00', 6, 46, 14121201, NULL, NULL, NULL, NULL, NULL, 400.00, 0.00, 460.00, NULL, NULL, 'granted', 0.00, -460.00, '2022-06-22', 0.00, '0', '2022-05-29 19:11:57', '2022-06-22 11:00:32'),
(161, 14121287, NULL, 135, 'ORD-00161', '2022-05-30', '14:00:00', 10, 133, 14121199, NULL, NULL, NULL, NULL, NULL, 16000.00, 0.00, 18400.00, NULL, NULL, 'granted', 0.00, -18400.00, '2022-06-22', 0.00, '0', '2022-05-29 19:13:14', '2022-06-22 11:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_delivered` int(11) NOT NULL DEFAULT 0,
  `edit_quantity` int(11) DEFAULT NULL,
  `rate` double(10,2) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `opc_1_rate` double(10,2) DEFAULT NULL,
  `src_5_rate` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `quantity_delivered`, `edit_quantity`, `rate`, `tax_id`, `tax_rate`, `opc_1_rate`, `src_5_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 50, 0, 60, 2.00, 1, 15.00, 1.00, 1.00, NULL, '2022-02-16 22:28:39'),
(2, 2, 17, 20, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(3, 3, 3, 100, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(4, 4, 3, 30, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(5, 5, 1, 17, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(6, 6, 9, 10, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(7, 7, 1, 13, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(8, 8, 1, 14, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(9, 9, 3, 3, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(10, 10, 1, 13, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(11, 11, 1, 13, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(12, 12, 1, 13, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(13, 13, 2, 30, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(14, 14, 1, 19, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(15, 15, 1, 25, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(16, 16, 1, 17, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(17, 17, 1, 16, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(18, 18, 1, 18, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(19, 19, 3, 15, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(20, 20, 1, 17, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(21, 21, 1, 21, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(22, 22, 9, 100, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(23, 23, 9, 20, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(24, 24, 59, 10, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(25, 25, 17, 190, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(26, 26, 73, 208, 0, NULL, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(27, 27, 17, 105, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(28, 28, 81, 250, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(29, 29, 13, 60, 0, NULL, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(30, 30, 17, 50, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(31, 31, 21, 18, 0, NULL, 456.00, 1, 15.00, 223.00, 233.00, NULL, NULL),
(32, 32, 9, 150, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(33, 33, 13, 290, 0, NULL, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(34, 34, 17, 20, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(35, 35, 17, 25, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(36, 36, 25, 40, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(37, 37, 25, 30, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(38, 38, 17, 130, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(39, 39, 9, 130, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(40, 40, 17, 150, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(41, 41, 21, 11, 0, NULL, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(42, 42, 3, 10, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(43, 43, 3, 10, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(44, 44, 9, 130, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(45, 45, 17, 130, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(46, 46, 17, 90, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(47, 47, 9, 18, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(48, 48, 9, 20, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(49, 49, 9, 200, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(50, 50, 21, 461, 416, 416, 440.00, 1, 15.00, 215.00, 225.00, NULL, '2022-03-10 23:59:38'),
(51, 51, 17, 230, 220, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-03-14 18:04:48'),
(52, 52, 9, 1, 60, 300, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-14 18:30:14'),
(53, 53, 9, 25, 32, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-14 19:13:28'),
(54, 54, 9, 25, 36, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-14 21:08:18'),
(55, 55, 9, 22, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(56, 56, 9, 22, 20, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-16 04:45:19'),
(57, 57, 9, 22, 30, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-17 03:20:13'),
(58, 58, 9, 17, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(59, 59, 1, 22, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(60, 60, 9, 250, 470, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-18 03:11:18'),
(61, 61, 1, 30, 30, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-03-17 16:30:51'),
(62, 62, 9, 22, 12, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-17 17:45:29'),
(63, 63, 9, 22, 22, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-18 03:10:48'),
(64, 64, 1, 45, 35, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-03-18 03:11:40'),
(65, 65, 9, 22, 22, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-18 03:10:07'),
(66, 66, 81, 1, 1, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-03-20 18:38:24'),
(67, 67, 25, 25, 25, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-03-20 18:53:58'),
(68, 68, 9, 20, 10, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-20 20:41:32'),
(69, 69, 81, 30, 10, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-03-20 21:10:27'),
(70, 70, 1, 30, 30, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-03-20 21:20:14'),
(71, 71, 1, 20, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(73, 72, 9, 22, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(74, 73, 9, 50, 80, 80, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-26 17:33:36'),
(77, 74, 25, 15, 15, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-03-26 20:34:22'),
(78, 75, 9, 25, 10, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-26 20:36:39'),
(80, 76, 1, 21, 17, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-03-27 23:02:52'),
(81, 77, 1, 30, 25, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-03-28 17:32:46'),
(82, 78, 1, 20, 10, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-03-28 19:33:56'),
(83, 79, 59, 1, 1, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-28 19:34:29'),
(84, 80, 81, 1, 40, 50, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-03-29 20:56:58'),
(85, 81, 17, 80, 10, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-03-29 20:59:34'),
(86, 82, 9, 30, 20, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-03-29 21:08:01'),
(87, 83, 9, 30, 25, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-04-09 21:12:11'),
(88, 84, 9, 14, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(89, 85, 1, 20, 20, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-10 16:32:40'),
(90, 86, 9, 1, 1, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-04-10 16:27:57'),
(91, 87, 1, 13, 10, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-10 16:31:21'),
(92, 88, 81, 1, 1, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-04-10 16:36:00'),
(93, 89, 1, 13, 13, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-10 18:29:47'),
(94, 90, 9, 15, 15, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-04-10 18:30:00'),
(95, 91, 1, 13, 10, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-10 18:22:39'),
(96, 92, 9, 16, 10, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, '2022-04-11 16:15:47'),
(97, 93, 1, 13, 13, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-11 17:02:23'),
(98, 94, 1, 13, 5, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-11 17:26:33'),
(99, 95, 1, 17, 17, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-12 19:03:35'),
(100, 96, 17, 50, 54, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-04-12 19:04:08'),
(101, 97, 1, 21, 21, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-13 18:18:20'),
(102, 98, 1, 20, 20, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-17 17:27:41'),
(103, 99, 81, 25, 25, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-04-17 17:28:52'),
(104, 100, 1, 100, 100, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-19 17:16:20'),
(105, 101, 17, 140, 140, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-04-21 17:43:02'),
(106, 102, 17, 16, 16, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-04-26 16:27:56'),
(108, 103, 1, 175, 175, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, '2022-04-26 16:31:00'),
(109, 104, 17, 140, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(110, 105, 17, 140, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(111, 106, 1, 400, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(112, 107, 1, 115, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(113, 108, 3, 50, 0, NULL, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(114, 109, 1, 250, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(115, 110, 1, 250, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(116, 111, 17, 20, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(117, 112, 17, 210, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(118, 113, 1, 13, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(119, 114, 9, 150, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(120, 115, 1, 25, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(121, 116, 25, 1, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(122, 117, 9, 150, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(123, 118, 9, 150, 0, NULL, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(124, 119, 25, 100, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(125, 120, 17, 110, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(126, 121, 17, 110, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(127, 122, 1, 120, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(128, 123, 17, 40, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(129, 124, 1, 13, 0, NULL, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(130, 125, 25, 13, 13, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, '2022-05-16 19:03:14'),
(131, 126, 17, 200, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(145, 127, 17, 1, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(133, 128, 25, 23, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(134, 129, 17, 40, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(135, 130, 17, 180, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(136, 131, 17, 180, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(137, 132, 9, 115, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(138, 133, 17, 100, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(139, 134, 33, 250, 0, NULL, 490.00, 1, 15.00, 240.00, 250.00, NULL, NULL),
(140, 135, 17, 45, 10, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-05-18 02:26:56'),
(141, 136, 9, 120, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(142, 137, 25, 50, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(150, 138, 17, 30, 10, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, '2022-05-17 18:31:23'),
(149, 139, 5, 100, 0, NULL, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(147, 140, 33, 100, 0, NULL, 490.00, 1, 15.00, 240.00, 250.00, NULL, NULL),
(151, 141, 25, 170, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(152, 142, 9, 15, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(153, 143, 9, 50, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(155, 144, 25, 36, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(156, 145, 25, 200, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(157, 146, 25, 1, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(158, 147, 25, 80, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(159, 148, 9, 213, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(160, 149, 17, 27, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(161, 150, 25, 27, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(162, 151, 17, 15, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(163, 152, 9, 210, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(164, 153, 9, 160, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(165, 154, 9, 160, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(166, 155, 25, 500, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(167, 156, 25, 45, 0, NULL, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(168, 157, 17, 24, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(169, 158, 17, 70, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(170, 159, 17, 35, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(171, 160, 17, 1, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(172, 161, 17, 40, 0, NULL, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `overhead_expances`
--

CREATE TABLE `overhead_expances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) CHARACTER SET utf8 NOT NULL,
  `type` enum('percentage','flat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'flat',
  `value` double(10,2) DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overhead_expances`
--

INSERT INTO `overhead_expances` (`id`, `name`, `type`, `value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'GOSI', 'percentage', 2.00, '1', '2021-05-25 18:32:39', '2021-05-25 18:32:39'),
(2, 'Mediacl Insurance', 'flat', 1200.00, '1', '2021-05-25 18:32:53', '2021-05-25 18:32:53'),
(3, 'Labour Fee', 'flat', 1000.00, '1', '2021-05-25 18:33:07', '2021-05-25 18:33:07'),
(4, 'Work Permit Fee', 'flat', 1400.00, '1', '2021-05-25 18:33:26', '2021-05-25 18:33:26'),
(5, 'Ticket', 'flat', 1000.00, '1', '2021-05-30 13:52:50', '2021-05-30 13:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `parent_department`
--

CREATE TABLE `parent_department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `is_active` enum('1','0') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(66) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_run`
--

CREATE TABLE `pay_run` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `for_month` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `for_year` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_pay` double(10,2) DEFAULT NULL,
  `no_of_emp` int(11) DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1-Done ,0-Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_schedule`
--

CREATE TABLE `pay_schedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salary_on` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0-Actual days in month , 1-Org working days',
  `days_per_month` int(11) DEFAULT NULL,
  `pay_on` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0-last working day of every month , 1- day of every month',
  `on_every_month` int(11) DEFAULT NULL,
  `start_payroll` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_schedule`
--

INSERT INTO `pay_schedule` (`id`, `salary_on`, `days_per_month`, `pay_on`, `on_every_month`, `start_payroll`, `first_pay_date`, `created_at`, `updated_at`) VALUES
(1, '0', 0, '0', 0, '04/2021', '2021-04-30', '2021-05-21 19:28:09', '2021-05-21 19:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'employee-list', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(2, 'employee-create', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(3, 'employee-update', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(4, 'customers-list', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(5, 'customers-create', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(6, 'customers-update', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(7, 'site-setting-list', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(8, 'site-setting-create', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(9, 'site-setting-update', 'web', '2021-04-02 12:34:28', '2021-04-02 12:34:28'),
(10, 'taxes-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(11, 'taxes-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(12, 'taxes-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(13, 'units-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(14, 'units-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(15, 'units-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(16, 'payment-methods-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(17, 'payment-methods-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(18, 'payment-methods-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(19, 'pumps-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(20, 'pumps-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(21, 'pumps-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(22, 'product-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(23, 'product-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(24, 'product-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(25, 'leads-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(26, 'leads-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(27, 'leads-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(28, 'sales-inquirie-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(29, 'sales-inquirie-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(30, 'sales-inquirie-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(31, 'sales-estimates-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(32, 'sales-estimates-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(33, 'sales-estimates-update', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(34, 'sales-proposals-list', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(35, 'sales-proposals-create', 'web', '2021-04-02 12:34:29', '2021-04-02 12:34:29'),
(36, 'sales-proposals-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(37, 'sales-bookings-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(38, 'sales-bookings-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(39, 'sales-bookings-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(40, 'sales-invoice-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(41, 'sales-invoice-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(42, 'sales-invoice-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(43, 'sales-payments-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(44, 'sales-payments-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(45, 'sales-payments-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(46, 'sales-account-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(47, 'sales-account-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(48, 'sales-account-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(49, 'sales-account-statement-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(50, 'sales-account-statement-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(51, 'sales-account-statement-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(52, 'sales-rservations-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(53, 'sales-rservations-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(54, 'sales-rservations-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(55, 'dispatch-order-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(56, 'dispatch-order-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(57, 'dispatch-order-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(58, 'dispatch-driver-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(59, 'dispatch-driver-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(60, 'dispatch-driver-update', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(61, 'dispatch-vechicle-list', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(62, 'dispatch-vechicle-create', 'web', '2021-04-02 12:34:30', '2021-04-02 12:34:30'),
(63, 'dispatch-vechicle-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(64, 'booking-statement-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(65, 'booking-statement-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(66, 'booking-statement-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(67, 'purchase-commodity-group-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(68, 'purchase-commodity-group-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(69, 'purchase-commodity-group-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(70, 'purchase-item-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(71, 'purchase-item-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(72, 'purchase-item-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(73, 'purchase-vendor-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(74, 'purchase-vendor-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(75, 'purchase-vendor-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(76, 'purchase-request-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(77, 'purchase-request-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(78, 'purchase-request-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(79, 'purchase-estimates-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(80, 'purchase-estimates-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(81, 'purchase-estimates-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(82, 'purchase-orders-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(83, 'purchase-orders-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(84, 'purchase-orders-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(85, 'parts-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(86, 'parts-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(87, 'parts-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(88, 'supplier-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(89, 'supplier-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(90, 'supplier-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(91, 'manufacturer-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(92, 'manufacturer-create', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(93, 'manufacturer-update', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(94, 'make/model/year-list', 'web', '2021-04-02 12:34:31', '2021-04-02 12:34:31'),
(95, 'make/model/year-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(96, 'make/model/year-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(97, 'parts-stock-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(98, 'parts-stock-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(99, 'parts-stock-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(100, 'purchase-parts-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(101, 'purchase-parts-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(102, 'purchase-parts-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(103, 'repair-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(104, 'repair-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(105, 'repair-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(106, 'print-labels-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(107, 'print-labels-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(108, 'print-labels-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(109, 'roles-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(110, 'roles-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(111, 'roles-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(112, 'attendance-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(113, 'attendance-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(114, 'attendance-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(115, 'leave-tracker-list', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(116, 'leave-tracker-create', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(117, 'leave-tracker-update', 'web', '2021-04-02 12:34:32', '2021-04-02 12:34:32'),
(118, 'pump-operator-list', 'web', NULL, NULL),
(119, 'pump-operator-create', 'web', NULL, NULL),
(120, 'pump-operator-update', 'web', NULL, NULL),
(121, 'pump-helper-list', 'web', NULL, NULL),
(122, 'pump-helper-create', 'web', NULL, NULL),
(123, 'pump-helper-update', 'web', NULL, NULL),
(124, 'product-price-update', 'web', NULL, NULL),
(125, 'qc-cube-create', 'web', NULL, NULL),
(126, 'qc-cylinder-create', 'web', NULL, NULL),
(127, 'department-list', 'web', NULL, NULL),
(128, 'department-create', 'web', NULL, NULL),
(129, 'department-update', 'web', NULL, NULL),
(131, 'reports', 'web', '2021-04-20 14:34:36', '2021-04-20 15:05:15'),
(132, 'finance-delivery-invoice-list', 'web', NULL, NULL),
(133, 'finance-confirmed-invoice-list', 'web', NULL, NULL),
(134, 'hr', 'web', NULL, NULL),
(135, 'payroll', 'web', NULL, NULL),
(136, 'pay-run', 'web', NULL, NULL),
(137, 'earning-update', 'web', NULL, NULL),
(138, 'earning-create', 'web', NULL, NULL),
(139, 'earning-list', 'web', NULL, NULL),
(140, 'pay-schedule', 'web', NULL, NULL),
(141, 'payroll-employee-list', 'web', NULL, NULL),
(142, 'salary-details-update', 'web', NULL, NULL),
(143, 'salary-details-create', 'web', NULL, NULL),
(144, 'salary-details-list', 'web', NULL, NULL),
(145, 'main-department-list', 'web', NULL, NULL),
(146, 'main-department-create', 'web', NULL, NULL),
(147, 'main-department-update', 'web', NULL, NULL),
(148, 'overhead-expances-list', 'web', NULL, NULL),
(149, 'overhead-expances-create', 'web', NULL, NULL),
(150, 'overhead-expances-update', 'web', NULL, NULL),
(151, 'inventory', 'web', NULL, NULL),
(152, 'maintenance-category-list', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name_english` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mix_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  `opc_1_rate` float(10,2) DEFAULT NULL,
  `src_5_rate` float(10,2) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `min_quant` int(11) NOT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `name_english`, `mix_code`, `description`, `rate`, `opc_1_rate`, `src_5_rate`, `tax_id`, `min_quant`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '15MPa - OPC  - CUB', '', 'G15I20B013', '15MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 13, '1', '2021-02-09 01:50:00', '2022-06-12 21:20:02'),
(2, '15MPA - OPC - SCREED - CUB', '', 'G15I10B02', '15MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(3, '15MPa - SRC  - CUB', '', 'G15V20B03', '15MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(4, '15MPA - SRC - SCREED - CUB', '', 'G15V10B04', '15MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(5, '20MPa - OPC  - CUB', '', 'G20I20B01', '20MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(6, '20MPA - OPC - SCREED - CUB', '', 'G20I10B02', '20MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(7, '20MPa - SRC  - CUB', '', 'G20V20B03', '20MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(8, '20MPA - SRC - SCREED - CUB', '', 'G20V10B04', '20MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(9, '25MPa - OPC  - CUB', '', 'G25I20B01', '25MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(10, '25MPA - OPC - SCREED - CUB', '', 'G25I10B02', '25MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(11, '25MPa - OPC -WP - CUB', '', 'G25I20BWP', '25MPa - OPC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(12, '25MPA - OPC - SCREED -WP - CUB', '', 'G25I10BWP', '25MPA - OPC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(13, '25MPa - SRC  - CUB', '', 'G25V20B05', '25MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(14, '25MPA - SRC - SCREED - CUB', '', 'G25V10B06', '25MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(15, '25MPa - SRC -WP - CUB', '', 'G25V20BWP', '25MPa - SRC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(16, '25MPA - SRC - SCREED -WP - CUB', '', 'G25V10BWP', '25MPA - SRC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(17, '30MPa - OPC  - CUB', '', 'G30I20B01', '30MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(18, '30MPA - OPC - SCREED - CUB', '', 'G30I10B02', '30MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(19, '30MPa - OPC -WP - CUB', '', 'G30I20BWP', '30MPa - OPC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(20, '30MPA - OPC - SCREED -WP - CUB', '', 'G30I10BWP', '30MPA - OPC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(21, '30MPa - SRC  - CUB', '', 'G30V20B05', '30MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(22, '30MPA - SRC - SCREED - CUB', '', 'G30V10B06', '30MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(23, '30MPa - SRC -WP - CUB', '', 'G30V20BWP', '30MPa - SRC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(24, '30MPA - SRC - SCREED -WP - CUB', '', 'G30V10BWP', '30MPA - SRC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(25, '35MPa - OPC  - CUB', '', 'G35I20B01', '35MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(26, '35MPA - OPC - SCREED - CUB', '', 'G35I10B02', '35MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(27, '35MPa - OPC -WP - CUB', '', 'G35I20BWP', '35MPa - OPC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(28, '35MPA - OPC - SCREED -WP - CUB', '', 'G35I10BWP', '35MPA - OPC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(29, '35MPa - SRC  - CUB', '', 'G35V20B05', '35MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(30, '35MPA - SRC - SCREED - CUB', '', 'G35V10B06', '35MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(31, '35MPa - SRC -WP - CUB', '', 'G35V20BWP', '35MPa - SRC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(32, '35MPA - SRC - SCREED -WP - CUB', '', 'G35V10BWP', '35MPA - SRC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(33, '40MPa - OPC  - CUB', '', 'G40I20B01', '40MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(34, '40MPA - OPC - SCREED - CUB', '', 'G40I10B02', '40MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(35, '40MPa - OPC -WP - CUB', '', 'G40I20BWP', '40MPa - OPC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(36, '40MPA - OPC - SCREED -WP - CUB', '', 'G40I10BWP', '40MPA - OPC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(37, '40MPa - SRC  - CUB', '', 'G40V20B05', '40MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(38, '40MPA - SRC - SCREED - CUB', '', 'G40V10B06', '40MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(39, '40MPa - SRC -WP - CUB', '', 'G40V20BWP', '40MPa - SRC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(40, '40MPA - SRC - SCREED -WP - CUB', '', 'G40V10BWP', '40MPA - SRC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(41, '45MPa - OPC  - CUB', '', 'G45I20B01', '45MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(42, '45MPA - OPC - SCREED - CUB', '', 'G45I10B02', '45MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(43, '45MPa - OPC -WP - CUB', '', 'G45I20BWP', '45MPa - OPC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(44, '45MPA - OPC - SCREED -WP - CUB', '', 'G45I10BWP', '45MPA - OPC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(45, '45MPa - SRC  - CUB', '', 'G45V20B05', '45MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(46, '45MPA - SRC - SCREED - CUB', '', 'G45V10B06', '45MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(47, '45MPa - SRC -WP - CUB', '', 'G45V20BWP', '45MPa - SRC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(48, '45MPA - SRC - SCREED -WP - CUB', '', 'G45V10BWP', '45MPA - SRC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(49, '50MPa - OPC  - CUB', '', 'G50I20B01', '50MPa - OPC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(50, '50MPA - OPC - SCREED - CUB', '', 'G50I10B02', '50MPA - OPC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(51, '50MPa - OPC -WP - CUB', '', 'G50I20BWP', '50MPa - OPC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(52, '50MPA - OPC - SCREED -WP - CUB', '', 'G50I10BWP', '50MPA - OPC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(53, '50MPa - SRC  - CUB', '', 'G50V20B05', '50MPa - SRC  - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(54, '50MPA - SRC - SCREED - CUB', '', 'G50V10B06', '50MPA - SRC - SCREED - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(55, '50MPa - SRC -WP - CUB', '', 'G50V20BWP', '50MPa - SRC -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(56, '50MPA - SRC - SCREED -WP - CUB', '', 'G50V10BWP', '50MPA - SRC - SCREED -WP - CUB', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(57, '15MPa - OPC  - Cyl', '', 'G15I20A01', '15MPa - OPC  - Cyl', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(58, '15MPA - OPC - SCREED - CYL', '', 'G15I10A02', '15MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(59, '15MPa - SRC  - CYL', '', 'G15V20A03', '15MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(60, '15MPA - SRC - SCREED - CYL', '', 'G15V10A04', '15MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(61, '20MPa - OPC  - CYL', '', 'G20I20A01', '20MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(62, '20MPA - OPC - SCREED - CYL', '', 'G20I10A02', '20MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(63, '20MPa - SRC  - CYL', '', 'G20V20A03', '20MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(64, '20MPA - SRC - SCREED - CYL', '', 'G20V10A04', '20MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(65, '25MPa - OPC  - CYL', '', 'G25I20A01', '25MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(66, '25MPA - OPC - SCREED - CYL', '', 'G25I10A02', '25MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(67, '25MPa - OPC -WP - CYL', '', 'G25I20AWP', '25MPa - OPC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(68, '25MPA - OPC - SCREED -WP - CYL', '', 'G25I10AWP', '25MPA - OPC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(69, '25MPa - SRC  - CYL', '', 'G25V20A05', '25MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(70, '25MPA - SRC - SCREED - CYL', '', 'G25V10A06', '25MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(71, '25MPa - SRC -WP - CYL', '', 'G25V20AWP', '25MPa - SRC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(72, '25MPA - SRC - SCREED -WP - CYL', '', 'G25V10AWP', '25MPA - SRC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(73, '30MPa - OPC  - CYL', '', 'G30I20A01', '30MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(74, '30MPA - OPC - SCREED - CYL', '', 'G30I10A02', '30MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(75, '30MPa - OPC -WP - CYL', '', 'G30I20AWP', '30MPa - OPC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(76, '30MPA - OPC - SCREED -WP - CYL', '', 'G30I10AWP', '30MPA - OPC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(77, '30MPa - SRC  - CYL', '', 'G30V20A05', '30MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(78, '30MPA - SRC - SCREED - CYL', '', 'G30V10A06', '30MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(79, '30MPa - SRC -WP - CYL', '', 'G30V20AWP', '30MPa - SRC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(80, '30MPA - SRC - SCREED -WP - CYL', '', 'G30V10AWP', '30MPA - SRC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(81, '35MPa - OPC  - CYL', '', 'G35I20A01', '35MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(82, '35MPA - OPC - SCREED - CYL', '', 'G35I10A02', '35MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(83, '35MPa - OPC -WP - CYL', '', 'G35I20AWP', '35MPa - OPC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(84, '35MPA - OPC - SCREED -WP - CYL', '', 'G35I10AWP', '35MPA - OPC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(85, '35MPa - SRC  - CYL', '', 'G35V20A05', '35MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(86, '35MPA - SRC - SCREED - CYL', '', 'G35V10A06', '35MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(87, '35MPa - SRC -WP - CYL', '', 'G35V20AWP', '35MPa - SRC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(88, '35MPA - SRC - SCREED -WP - CYL', '', 'G35V10AWP', '35MPA - SRC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(89, '40MPa - OPC  - CYL', '', 'G40I20A01', '40MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(90, '40MPA - OPC - SCREED - CYL', '', 'G40I10A02', '40MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(91, '40MPa - OPC -WP - CYL', '', 'G40I20AWP', '40MPa - OPC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(92, '40MPA - OPC - SCREED -WP - CYL', '', 'G40I10BAWP', '40MPA - OPC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(93, '40MPa - SRC  - CYL', '', 'G40V20A05', '40MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(94, '40MPA - SRC - SCREED - CYL', '', 'G40V10A06', '40MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(95, '40MPa - SRC -WP - CYL', '', 'G40V20AWP', '40MPa - SRC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(96, '40MPA - SRC - SCREED -WP - CYL', '', 'G40V10AWP', '40MPA - SRC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(97, '45MPa - OPC  - CYL', '', 'G45I20A01', '45MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(98, '45MPA - OPC - SCREED - CYL', '', 'G45I10A02', '45MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(99, '45MPa - OPC -WP - CYL', '', 'G45I20AWP', '45MPa - OPC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(100, '45MPA - OPC - SCREED -WP - CYL', '', 'G45I10AWP', '45MPA - OPC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(101, '45MPa - SRC  - CYL', '', 'G45V20A05', '45MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-12-01 15:41:43'),
(102, '45MPA - SRC - SCREED - CYL', '', 'G45V10A06', '45MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(103, '45MPa - SRC -WP - CYL', '', 'G45V20AWP', '45MPa - SRC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(104, '45MPA - SRC - SCREED -WP - CYL', '', 'G45V10AWP', '45MPA - SRC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(105, '50MPa - OPC  - CYL', '', 'G50I20A01', '50MPa - OPC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(106, '50MPA - OPC - SCREED - CYL', '', 'G50I10A02', '50MPA - OPC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(107, '50MPa - OPC -WP - CYL', '', 'G50I20AWP', '50MPa - OPC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(108, '50MPA - OPC - SCREED -WP - CYL', '', 'G50I10AWP', '50MPA - OPC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(109, '50MPa - SRC  - CYL', '', 'G50V20A05', '50MPa - SRC  - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(110, '50MPA - SRC - SCREED - CYL', '', 'G50V10A06', '50MPA - SRC - SCREED - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(111, '50MPa - SRC -WP - CYL', '', 'G50V20BWP', '50MPa - SRC -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(112, '50MPA - SRC - SCREED -WP - CYL', '', 'G50V10AWP', '50MPA - SRC - SCREED -WP - CYL', 0.00, 0.00, 0.00, 1, 1, '1', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(113, '15MPa - OPC  - CUB', '', 'G15I20B012', 'dsf', NULL, NULL, NULL, NULL, 19, '1', '2022-01-09 23:52:40', '2022-01-09 23:52:40'),
(114, '15MPa - SRC  - CUB', '', 'G15V10B041', '', NULL, NULL, NULL, NULL, 21, '1', '2022-01-09 23:56:29', '2022-01-09 23:56:29'),
(115, 'mix design1', '', 'Raza Product Test', '', NULL, NULL, NULL, NULL, 22, '1', '2022-01-10 00:02:58', '2022-01-10 00:02:58'),
(116, '15MPa - OPC  - CUB', '', 'T101I20B01', '', NULL, NULL, NULL, NULL, 15, '1', '2022-01-10 16:31:01', '2022-01-10 16:31:01'),
(117, 'mix design2', '', 'G15I20B0135', '', NULL, NULL, NULL, NULL, 11, '1', '2022-01-10 16:34:15', '2022-01-10 16:34:15'),
(118, 'test1', '', NULL, '', NULL, NULL, NULL, NULL, 1, '1', '2022-02-10 22:32:30', '2022-02-10 22:32:30'),
(119, 'test2', '', NULL, '', NULL, NULL, NULL, NULL, 1, '1', '2022-02-10 22:32:40', '2022-02-10 22:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_type` int(11) NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `order_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_type`, `name`, `slug`, `is_required`, `order_number`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cement', 'cement', '1', 1, NULL, NULL),
(2, 1, 'Water', 'water', '1', 2, NULL, NULL),
(3, 1, 'Agg 3/4', 'agg_3_4', '1', 12, NULL, NULL),
(4, 1, 'Agg 3/8', 'agg_3_8', '1', 13, NULL, NULL),
(5, 1, 'C. Sand', 'sand', '1', 14, NULL, NULL),
(6, 1, 'RP', 'rp', '1', 15, NULL, NULL),
(7, 1, 'SP', 'sp', '1', 17, NULL, NULL),
(8, 1, 'Micro Silica', 'micro_silica', '0', 3, NULL, NULL),
(9, 1, 'Fly Ash', 'fly_ash', '0', 4, NULL, NULL),
(11, 1, 'Age ½', 'age_1_2', '0', 6, NULL, NULL),
(12, 1, 'Fsand', 'fsand', '0', 7, NULL, NULL),
(13, 1, 'W/C Ratio', 'w_c_ratio', '0', 8, NULL, NULL),
(14, 1, 'Slamp', 'slamp', '0', 9, NULL, NULL),
(15, 1, 'Air Content', 'air_content', '0', 10, NULL, NULL),
(16, 1, 'Other', 'other', '0', 11, NULL, NULL),
(17, 1, 'Cement Type', 'cement_type', '0', 2, NULL, NULL),
(18, 1, 'WP', 'wp', '0', 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values`
--

CREATE TABLE `product_attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_attr_id` int(11) NOT NULL,
  `value` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_val` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attribute_values`
--

INSERT INTO `product_attribute_values` (`id`, `product_id`, `product_attr_id`, `value`, `other_val`, `created_at`, `updated_at`) VALUES
(1962, 1, 6, '1.5', '', NULL, NULL),
(1961, 1, 5, '1028', '', NULL, NULL),
(1960, 1, 4, '385', '', NULL, NULL),
(1959, 1, 3, '590', '', NULL, NULL),
(1958, 1, 16, '0', '', NULL, NULL),
(1957, 1, 0, '', '', NULL, NULL),
(1956, 1, 15, '1.99%', '', NULL, NULL),
(1955, 1, 0, '', '', NULL, NULL),
(1954, 1, 14, '125±25', '', NULL, NULL),
(1953, 1, 13, '0', '', NULL, NULL),
(1952, 1, 12, '1', '', NULL, NULL),
(1951, 1, 11, '1', '', NULL, NULL),
(1950, 1, 9, '0', '', NULL, NULL),
(18, 2, 1, '250', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(19, 2, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(20, 2, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(21, 2, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(22, 2, 5, '1068', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(23, 2, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(24, 2, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(25, 2, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(26, 2, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(27, 2, 6, '1.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(28, 2, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(29, 2, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(30, 2, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(31, 2, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(32, 2, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(33, 2, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(34, 2, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(35, 3, 1, '250', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(36, 3, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(37, 3, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(38, 3, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(39, 3, 5, '1068', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(40, 3, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(41, 3, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(42, 3, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(43, 3, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(44, 3, 6, '1.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(45, 3, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(46, 3, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(47, 3, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(48, 3, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(49, 3, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(50, 3, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(51, 3, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(52, 4, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(53, 4, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(54, 4, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(55, 4, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(56, 4, 5, '998', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(57, 4, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(58, 4, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(59, 4, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(60, 4, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(61, 4, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(62, 4, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(63, 4, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(64, 4, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(65, 4, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(66, 4, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(67, 4, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(68, 4, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(69, 5, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(70, 5, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(71, 5, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(72, 5, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(73, 5, 5, '998', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(74, 5, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(75, 5, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(76, 5, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(77, 5, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(78, 5, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(79, 5, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(80, 5, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(81, 5, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(82, 5, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(83, 5, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(84, 5, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(85, 5, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(86, 6, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(87, 6, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(88, 6, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(89, 6, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(90, 6, 5, '1038', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(91, 6, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(92, 6, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(93, 6, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(94, 6, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(95, 6, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(96, 6, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(97, 6, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(98, 6, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(99, 6, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(100, 6, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(101, 6, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(102, 6, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(103, 7, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(104, 7, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(105, 7, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(106, 7, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(107, 7, 5, '998', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(108, 7, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(109, 7, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(110, 7, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(111, 7, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(112, 7, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(113, 7, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(114, 7, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(115, 7, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(116, 7, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(117, 7, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(118, 7, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(119, 7, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(120, 8, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(121, 8, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(122, 8, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(123, 8, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(124, 8, 5, '1038', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(125, 8, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(126, 8, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(127, 8, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(128, 8, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(129, 8, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(130, 8, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(131, 8, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(132, 8, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(133, 8, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(134, 8, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(135, 8, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(136, 8, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(137, 9, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(138, 9, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(139, 9, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(140, 9, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(141, 9, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(142, 9, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(143, 9, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(144, 9, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(145, 9, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(146, 9, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(147, 9, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(148, 9, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(149, 9, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(150, 9, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(151, 9, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(152, 9, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(153, 9, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(154, 10, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(155, 10, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(156, 10, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(157, 10, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(158, 10, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(159, 10, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(160, 10, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(161, 10, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(162, 10, 7, '4.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(163, 10, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(164, 10, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(165, 10, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(166, 10, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(167, 10, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(168, 10, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(169, 10, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(170, 10, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(171, 11, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(172, 11, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(173, 11, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(174, 11, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(175, 11, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(176, 11, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(177, 11, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(178, 11, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(179, 11, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(180, 11, 6, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(181, 11, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(182, 11, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(183, 11, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(184, 11, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(185, 11, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(186, 11, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(187, 11, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(188, 12, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(189, 12, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(190, 12, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(191, 12, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(192, 12, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(193, 12, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(194, 12, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(195, 12, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(196, 12, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(197, 12, 6, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(198, 12, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(199, 12, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(200, 12, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(201, 12, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(202, 12, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(203, 12, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(204, 12, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(205, 13, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(206, 13, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(207, 13, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(208, 13, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(209, 13, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(210, 13, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(211, 13, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(212, 13, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(213, 13, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(214, 13, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(215, 13, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(216, 13, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(217, 13, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(218, 13, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(219, 13, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(220, 13, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(221, 13, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(222, 14, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(223, 14, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(224, 14, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(225, 14, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(226, 14, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(227, 14, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(228, 14, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(229, 14, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(230, 14, 7, '4.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(231, 14, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(232, 14, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(233, 14, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(234, 14, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(235, 14, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(236, 14, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(237, 14, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(238, 14, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(239, 15, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(240, 15, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(241, 15, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(242, 15, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(243, 15, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(244, 15, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(245, 15, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(246, 15, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(247, 15, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(248, 15, 6, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(249, 15, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(250, 15, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(251, 15, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(252, 15, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(253, 15, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(254, 15, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(255, 15, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(256, 16, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(257, 16, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(258, 16, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(259, 16, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(260, 16, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(261, 16, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(262, 16, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(263, 16, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(264, 16, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(265, 16, 6, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(266, 16, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(267, 16, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(268, 16, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(269, 16, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(270, 16, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(271, 16, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(272, 16, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(273, 17, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(274, 17, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(275, 17, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(276, 17, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(277, 17, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(278, 17, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(279, 17, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(280, 17, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(281, 17, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(282, 17, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(283, 17, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(284, 17, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(285, 17, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(286, 17, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(287, 17, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(288, 17, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(289, 17, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(290, 18, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(291, 18, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(292, 18, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(293, 18, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(294, 18, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(295, 18, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(296, 18, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(297, 18, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(298, 18, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(299, 18, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(300, 18, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(301, 18, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(302, 18, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(303, 18, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(304, 18, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(305, 18, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(306, 18, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(307, 19, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(308, 19, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(309, 19, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(310, 19, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(311, 19, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(312, 19, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(313, 19, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(314, 19, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(315, 19, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(316, 19, 6, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(317, 19, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(318, 19, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(319, 19, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(320, 19, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(321, 19, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(322, 19, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(323, 19, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(324, 20, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(325, 20, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(326, 20, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(327, 20, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(328, 20, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(329, 20, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(330, 20, 3, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(331, 20, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(332, 20, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(333, 20, 6, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(334, 20, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(335, 20, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(336, 20, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(337, 20, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(338, 20, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(339, 20, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(340, 20, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(341, 21, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(342, 21, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(343, 21, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(344, 21, 12, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(345, 21, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(346, 21, 11, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(347, 21, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(348, 21, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(349, 21, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(350, 21, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(351, 21, 18, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(352, 21, 8, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(353, 21, 9, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(354, 21, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(355, 21, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(356, 21, 13, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(357, 21, 16, '0', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(358, 22, 1, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(359, 22, 17, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(360, 22, 2, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(361, 22, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(362, 22, 5, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(363, 22, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(364, 22, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(365, 22, 4, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(366, 22, 7, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(367, 22, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(368, 22, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(369, 22, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(370, 22, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(371, 22, 14, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(372, 22, 15, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(373, 22, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(374, 22, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(375, 23, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(376, 23, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(377, 23, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(378, 23, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(379, 23, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(380, 23, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(381, 23, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(382, 23, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(383, 23, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(384, 23, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(385, 23, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(386, 23, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(387, 23, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(388, 23, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(389, 23, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(390, 23, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(391, 23, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(392, 24, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(393, 24, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(394, 24, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(395, 24, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(396, 24, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(397, 24, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(398, 24, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(399, 24, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(400, 24, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(401, 24, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(402, 24, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(403, 24, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(404, 24, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(405, 24, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(406, 24, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(407, 24, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(408, 24, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(409, 25, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(410, 25, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(411, 25, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(412, 25, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(413, 25, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(414, 25, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(415, 25, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(416, 25, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(417, 25, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(418, 25, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(419, 25, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(420, 25, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(421, 25, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(422, 25, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(423, 25, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(424, 25, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(425, 25, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(426, 26, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(427, 26, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(428, 26, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(429, 26, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(430, 26, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(431, 26, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(432, 26, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(433, 26, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(434, 26, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(435, 26, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(436, 26, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(437, 26, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(438, 26, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(439, 26, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(440, 26, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(441, 26, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(442, 26, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(443, 27, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(444, 27, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(445, 27, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(446, 27, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(447, 27, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(448, 27, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(449, 27, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(450, 27, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(451, 27, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(452, 27, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(453, 27, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(454, 27, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(455, 27, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(456, 27, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(457, 27, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(458, 27, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(459, 27, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(460, 28, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(461, 28, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(462, 28, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(463, 28, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(464, 28, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(465, 28, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(466, 28, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(467, 28, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(468, 28, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(469, 28, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(470, 28, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(471, 28, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(472, 28, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(473, 28, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(474, 28, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(475, 28, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(476, 28, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(477, 29, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(478, 29, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(479, 29, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(480, 29, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(481, 29, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(482, 29, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(483, 29, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(484, 29, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(485, 29, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(486, 29, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(487, 29, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(488, 29, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(489, 29, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(490, 29, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(491, 29, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(492, 29, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(493, 29, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(494, 30, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(495, 30, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(496, 30, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(497, 30, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(498, 30, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(499, 30, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(500, 30, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(501, 30, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(502, 30, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(503, 30, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(504, 30, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(505, 30, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(506, 30, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(507, 30, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(508, 30, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(509, 30, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(510, 30, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(511, 31, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(512, 31, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(513, 31, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(514, 31, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(515, 31, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(516, 31, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(517, 31, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(518, 31, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(519, 31, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(520, 31, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(521, 31, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(522, 31, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(523, 31, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(524, 31, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(525, 31, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(526, 31, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(527, 31, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(528, 32, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(529, 32, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(530, 32, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(531, 32, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(532, 32, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(533, 32, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(534, 32, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(535, 32, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(536, 32, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(537, 32, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(538, 32, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(539, 32, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(540, 32, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(541, 32, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(542, 32, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(543, 32, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(544, 32, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(545, 33, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(546, 33, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(547, 33, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(548, 33, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(549, 33, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(550, 33, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(551, 33, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(552, 33, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(553, 33, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(554, 33, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(555, 33, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(556, 33, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(557, 33, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(558, 33, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(559, 33, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(560, 33, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(561, 33, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(562, 34, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(563, 34, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(564, 34, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(565, 34, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(566, 34, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(567, 34, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(568, 34, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(569, 34, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(570, 34, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(571, 34, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(572, 34, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(573, 34, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(574, 34, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(575, 34, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(576, 34, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(577, 34, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(578, 34, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(579, 35, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(580, 35, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(581, 35, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(582, 35, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(583, 35, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(584, 35, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(585, 35, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(586, 35, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(587, 35, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(588, 35, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(589, 35, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(590, 35, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(591, 35, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(592, 35, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(593, 35, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(594, 35, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(595, 35, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(596, 36, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(597, 36, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(598, 36, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(599, 36, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(600, 36, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(601, 36, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(602, 36, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(603, 36, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(604, 36, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(605, 36, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(606, 36, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(607, 36, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(608, 36, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(609, 36, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(610, 36, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(611, 36, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(612, 36, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(613, 37, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(614, 37, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(615, 37, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(616, 37, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(617, 37, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(618, 37, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(619, 37, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(620, 37, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(621, 37, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(622, 37, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(623, 37, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(624, 37, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(625, 37, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(626, 37, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(627, 37, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(628, 37, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(629, 37, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(630, 38, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(631, 38, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(632, 38, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(633, 38, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(634, 38, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(635, 38, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(636, 38, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(637, 38, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(638, 38, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(639, 38, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(640, 38, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(641, 38, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(642, 38, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(643, 38, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(644, 38, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(645, 38, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(646, 38, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(647, 39, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(648, 39, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(649, 39, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(650, 39, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(651, 39, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(652, 39, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(653, 39, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(654, 39, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(655, 39, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(656, 39, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(657, 39, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(658, 39, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(659, 39, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(660, 39, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(661, 39, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(662, 39, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(663, 39, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(664, 40, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(665, 40, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(666, 40, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(667, 40, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(668, 40, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(669, 40, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(670, 40, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(671, 40, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(672, 40, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(673, 40, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(674, 40, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(675, 40, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(676, 40, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(677, 40, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(678, 40, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(679, 40, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(680, 40, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(681, 41, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(682, 41, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(683, 41, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(684, 41, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(685, 41, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(686, 41, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(687, 41, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(688, 41, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(689, 41, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(690, 41, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(691, 41, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(692, 41, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(693, 41, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(694, 41, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(695, 41, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(696, 41, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(697, 41, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(698, 42, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(699, 42, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(700, 42, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(701, 42, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(702, 42, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(703, 42, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(704, 42, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(705, 42, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(706, 42, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(707, 42, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(708, 42, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(709, 42, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(710, 42, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(711, 42, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(712, 42, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(713, 42, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(714, 42, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(715, 43, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(716, 43, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(717, 43, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(718, 43, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(719, 43, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(720, 43, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(721, 43, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(722, 43, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(723, 43, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(724, 43, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(725, 43, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(726, 43, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(727, 43, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(728, 43, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(729, 43, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(730, 43, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(731, 43, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(732, 44, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(733, 44, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(734, 44, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(735, 44, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(736, 44, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(737, 44, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(738, 44, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(739, 44, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(740, 44, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(741, 44, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00');
INSERT INTO `product_attribute_values` (`id`, `product_id`, `product_attr_id`, `value`, `other_val`, `created_at`, `updated_at`) VALUES
(742, 44, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(743, 44, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(744, 44, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(745, 44, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(746, 44, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(747, 44, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(748, 44, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(749, 45, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(750, 45, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(751, 45, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(752, 45, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(753, 45, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(754, 45, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(755, 45, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(756, 45, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(757, 45, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(758, 45, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(759, 45, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(760, 45, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(761, 45, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(762, 45, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(763, 45, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(764, 45, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(765, 45, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(766, 46, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(767, 46, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(768, 46, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(769, 46, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(770, 46, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(771, 46, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(772, 46, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(773, 46, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(774, 46, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(775, 46, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(776, 46, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(777, 46, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(778, 46, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(779, 46, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(780, 46, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(781, 46, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(782, 46, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(783, 47, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(784, 47, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(785, 47, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(786, 47, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(787, 47, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(788, 47, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(789, 47, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(790, 47, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(791, 47, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(792, 47, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(793, 47, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(794, 47, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(795, 47, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(796, 47, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(797, 47, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(798, 47, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(799, 47, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(800, 48, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(801, 48, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(802, 48, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(803, 48, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(804, 48, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(805, 48, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(806, 48, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(807, 48, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(808, 48, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(809, 48, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(810, 48, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(811, 48, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(812, 48, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(813, 48, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(814, 48, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(815, 48, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(816, 48, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(817, 49, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(818, 49, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(819, 49, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(820, 49, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(821, 49, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(822, 49, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(823, 49, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(824, 49, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(825, 49, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(826, 49, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(827, 49, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(828, 49, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(829, 49, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(830, 49, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(831, 49, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(832, 49, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(833, 49, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(834, 50, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(835, 50, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(836, 50, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(837, 50, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(838, 50, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(839, 50, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(840, 50, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(841, 50, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(842, 50, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(843, 50, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(844, 50, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(845, 50, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(846, 50, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(847, 50, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(848, 50, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(849, 50, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(850, 50, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(851, 51, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(852, 51, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(853, 51, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(854, 51, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(855, 51, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(856, 51, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(857, 51, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(858, 51, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(859, 51, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(860, 51, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(861, 51, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(862, 51, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(863, 51, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(864, 51, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(865, 51, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(866, 51, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(867, 51, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(868, 52, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(869, 52, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(870, 52, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(871, 52, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(872, 52, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(873, 52, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(874, 52, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(875, 52, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(876, 52, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(877, 52, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(878, 52, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(879, 52, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(880, 52, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(881, 52, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(882, 52, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(883, 52, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(884, 52, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(885, 53, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(886, 53, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(887, 53, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(888, 53, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(889, 53, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(890, 53, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(891, 53, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(892, 53, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(893, 53, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(894, 53, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(895, 53, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(896, 53, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(897, 53, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(898, 53, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(899, 53, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(900, 53, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(901, 53, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(902, 54, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(903, 54, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(904, 54, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(905, 54, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(906, 54, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(907, 54, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(908, 54, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(909, 54, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(910, 54, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(911, 54, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(912, 54, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(913, 54, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(914, 54, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(915, 54, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(916, 54, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(917, 54, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(918, 54, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(919, 55, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(920, 55, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(921, 55, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(922, 55, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(923, 55, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(924, 55, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(925, 55, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(926, 55, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(927, 55, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(928, 55, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(929, 55, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(930, 55, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(931, 55, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(932, 55, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(933, 55, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(934, 55, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(935, 55, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(936, 56, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(937, 56, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(938, 56, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(939, 56, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(940, 56, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(941, 56, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(942, 56, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(943, 56, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(944, 56, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(945, 56, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(946, 56, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(947, 56, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(948, 56, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(949, 56, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(950, 56, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(951, 56, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(952, 56, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(953, 57, 1, '250', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(954, 57, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(955, 57, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(956, 57, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(957, 57, 5, '1028', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(958, 57, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(959, 57, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(960, 57, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(961, 57, 7, '2.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(962, 57, 6, '1.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(963, 57, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(964, 57, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(965, 57, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(966, 57, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(967, 57, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(968, 57, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(969, 57, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(970, 58, 1, '250', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(971, 58, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(972, 58, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(973, 58, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(974, 58, 5, '1068', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(975, 58, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(976, 58, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(977, 58, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(978, 58, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(979, 58, 6, '1.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(980, 58, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(981, 58, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(982, 58, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(983, 58, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(984, 58, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(985, 58, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(986, 58, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(987, 59, 1, '250', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(988, 59, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(989, 59, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(990, 59, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(991, 59, 5, '1028', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(992, 59, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(993, 59, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(994, 59, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(995, 59, 7, '2.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(996, 59, 6, '1.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(997, 59, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(998, 59, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(999, 59, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1000, 59, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1001, 59, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1002, 59, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1003, 59, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1004, 60, 1, '250', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1005, 60, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1006, 60, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1007, 60, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1008, 60, 5, '1068', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1009, 60, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1010, 60, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1011, 60, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1012, 60, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1013, 60, 6, '1.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1014, 60, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1015, 60, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1016, 60, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1017, 60, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1018, 60, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1019, 60, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1020, 60, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1021, 61, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1022, 61, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1023, 61, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1024, 61, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1025, 61, 5, '998', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1026, 61, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1027, 61, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1028, 61, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1029, 61, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1030, 61, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1031, 61, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1032, 61, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1033, 61, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1034, 61, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1035, 61, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1036, 61, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1037, 61, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1038, 62, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1039, 62, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1040, 62, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1041, 62, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1042, 62, 5, '1038', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1043, 62, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1044, 62, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1045, 62, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1046, 62, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1047, 62, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1048, 62, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1049, 62, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1050, 62, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1051, 62, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1052, 62, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1053, 62, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1054, 62, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1055, 63, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1056, 63, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1057, 63, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1058, 63, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1059, 63, 5, '998', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1060, 63, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1061, 63, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1062, 63, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1063, 63, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1064, 63, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1065, 63, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1066, 63, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1067, 63, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1068, 63, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1069, 63, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1070, 63, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1071, 63, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1072, 64, 1, '300', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1073, 64, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1074, 64, 2, '189', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1075, 64, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1076, 64, 5, '1038', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1077, 64, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1078, 64, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1079, 64, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1080, 64, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1081, 64, 6, '1.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1082, 64, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1083, 64, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1084, 64, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1085, 64, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1086, 64, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1087, 64, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1088, 64, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1089, 65, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1090, 65, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1091, 65, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1092, 65, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1093, 65, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1094, 65, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1095, 65, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1096, 65, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1097, 65, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1098, 65, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1099, 65, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1100, 65, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1101, 65, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1102, 65, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1103, 65, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1104, 65, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1105, 65, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1106, 66, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1107, 66, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1108, 66, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1109, 66, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1110, 66, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1111, 66, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1112, 66, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1113, 66, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1114, 66, 7, '4.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1115, 66, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1116, 66, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1117, 66, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1118, 66, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1119, 66, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1120, 66, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1121, 66, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1122, 66, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1123, 67, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1124, 67, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1125, 67, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1126, 67, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1127, 67, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1128, 67, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1129, 67, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1130, 67, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1131, 67, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1132, 67, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1133, 67, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1134, 67, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1135, 67, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1136, 67, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1137, 67, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1138, 67, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1139, 67, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1140, 68, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1141, 68, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1142, 68, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1143, 68, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1144, 68, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1145, 68, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1146, 68, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1147, 68, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1148, 68, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1149, 68, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1150, 68, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1151, 68, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1152, 68, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1153, 68, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1154, 68, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1155, 68, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1156, 68, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1157, 69, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1158, 69, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1159, 69, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1160, 69, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1161, 69, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1162, 69, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1163, 69, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1164, 69, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1165, 69, 7, '3.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1166, 69, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1167, 69, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1168, 69, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1169, 69, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1170, 69, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1171, 69, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1172, 69, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1173, 69, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1174, 70, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1175, 70, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1176, 70, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1177, 70, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1178, 70, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1179, 70, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1180, 70, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1181, 70, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1182, 70, 7, '4.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1183, 70, 6, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1184, 70, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1185, 70, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1186, 70, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1187, 70, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1188, 70, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1189, 70, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1190, 70, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1191, 71, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1192, 71, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1193, 71, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1194, 71, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1195, 71, 5, '939', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1196, 71, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1197, 71, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1198, 71, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1199, 71, 7, '3.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1200, 71, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1201, 71, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1202, 71, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1203, 71, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1204, 71, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1205, 71, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1206, 71, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1207, 71, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1208, 72, 1, '350', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1209, 72, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1210, 72, 2, '186', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1211, 72, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1212, 72, 5, '978', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1213, 72, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1214, 72, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1215, 72, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1216, 72, 7, '3.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1217, 72, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1218, 72, 18, '1.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1219, 72, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1220, 72, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1221, 72, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1222, 72, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1223, 72, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1224, 72, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1225, 73, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1226, 73, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1227, 73, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1228, 73, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1229, 73, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1230, 73, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1231, 73, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1232, 73, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1233, 73, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1234, 73, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1235, 73, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1236, 73, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1237, 73, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1238, 73, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1239, 73, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1240, 73, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1241, 73, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1242, 74, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1243, 74, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1244, 74, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1245, 74, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1246, 74, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1247, 74, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1248, 74, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1249, 74, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1250, 74, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1251, 74, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1252, 74, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1253, 74, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1254, 74, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1255, 74, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1256, 74, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1257, 74, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1258, 74, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1259, 75, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1260, 75, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1261, 75, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1262, 75, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1263, 75, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1264, 75, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1265, 75, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1266, 75, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1267, 75, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1268, 75, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1269, 75, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1270, 75, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1271, 75, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1272, 75, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1273, 75, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1274, 75, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1275, 75, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1276, 76, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1277, 76, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1278, 76, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1279, 76, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1280, 76, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1281, 76, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1282, 76, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1283, 76, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1284, 76, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1285, 76, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1286, 76, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1287, 76, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1288, 76, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1289, 76, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1290, 76, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1291, 76, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1292, 76, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1293, 77, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1294, 77, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1295, 77, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1296, 77, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1297, 77, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1298, 77, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1299, 77, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1300, 77, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1301, 77, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1302, 77, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1303, 77, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1304, 77, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1305, 77, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1306, 77, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1307, 77, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1308, 77, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1309, 77, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1310, 78, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1311, 78, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1312, 78, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1313, 78, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1314, 78, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1315, 78, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1316, 78, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1317, 78, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1318, 78, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1319, 78, 6, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1320, 78, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1321, 78, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1322, 78, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1323, 78, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1324, 78, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1325, 78, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1326, 78, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1327, 79, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1328, 79, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1329, 79, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1330, 79, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1331, 79, 5, '897', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1332, 79, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1333, 79, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1334, 79, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1335, 79, 7, '4.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1336, 79, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1337, 79, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1338, 79, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1339, 79, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1340, 79, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1341, 79, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1342, 79, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1343, 79, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1344, 80, 1, '400', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1345, 80, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1346, 80, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1347, 80, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1348, 80, 5, '955', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1349, 80, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1350, 80, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1351, 80, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1352, 80, 7, '4.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1353, 80, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1354, 80, 18, '2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1355, 80, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1356, 80, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1357, 80, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1358, 80, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1359, 80, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1360, 80, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1361, 81, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1362, 81, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1363, 81, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1364, 81, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1365, 81, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1366, 81, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1367, 81, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1368, 81, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1369, 81, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1370, 81, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1371, 81, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1372, 81, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1373, 81, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1374, 81, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1375, 81, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1376, 81, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1377, 81, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1378, 82, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1379, 82, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1380, 82, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1381, 82, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1382, 82, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1383, 82, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1384, 82, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1385, 82, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1386, 82, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1387, 82, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1388, 82, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1389, 82, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1390, 82, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1391, 82, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1392, 82, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1393, 82, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1394, 82, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1395, 83, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1396, 83, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1397, 83, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1398, 83, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1399, 83, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1400, 83, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1401, 83, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1402, 83, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1403, 83, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1404, 83, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1405, 83, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1406, 83, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1407, 83, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1408, 83, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1409, 83, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1410, 83, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1411, 83, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1412, 84, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1413, 84, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1414, 84, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1415, 84, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1416, 84, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1417, 84, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1418, 84, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1419, 84, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1420, 84, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1421, 84, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1422, 84, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1423, 84, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1424, 84, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1425, 84, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1426, 84, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1427, 84, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1428, 84, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1429, 85, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1430, 85, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1431, 85, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1432, 85, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1433, 85, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1434, 85, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1435, 85, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1436, 85, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1437, 85, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1438, 85, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1439, 85, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1440, 85, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1441, 85, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1442, 85, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1443, 85, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1444, 85, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1445, 85, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1446, 86, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1447, 86, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1448, 86, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1449, 86, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1450, 86, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1451, 86, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1452, 86, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1453, 86, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1454, 86, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1455, 86, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1456, 86, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1457, 86, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1458, 86, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1459, 86, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1460, 86, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1461, 86, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1462, 86, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1463, 87, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00');
INSERT INTO `product_attribute_values` (`id`, `product_id`, `product_attr_id`, `value`, `other_val`, `created_at`, `updated_at`) VALUES
(1464, 87, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1465, 87, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1466, 87, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1467, 87, 5, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1468, 87, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1469, 87, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1470, 87, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1471, 87, 7, '5.6', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1472, 87, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1473, 87, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1474, 87, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1475, 87, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1476, 87, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1477, 87, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1478, 87, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1479, 87, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1480, 88, 1, '450', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1481, 88, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1482, 88, 2, '193', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1483, 88, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1484, 88, 5, '907', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1485, 88, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1486, 88, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1487, 88, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1488, 88, 7, '6.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1489, 88, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1490, 88, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1491, 88, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1492, 88, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1493, 88, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1494, 88, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1495, 88, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1496, 88, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1497, 89, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1498, 89, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1499, 89, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1500, 89, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1501, 89, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1502, 89, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1503, 89, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1504, 89, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1505, 89, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1506, 89, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1507, 89, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1508, 89, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1509, 89, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1510, 89, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1511, 89, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1512, 89, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1513, 89, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1514, 90, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1515, 90, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1516, 90, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1517, 90, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1518, 90, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1519, 90, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1520, 90, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1521, 90, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1522, 90, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1523, 90, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1524, 90, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1525, 90, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1526, 90, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1527, 90, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1528, 90, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1529, 90, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1530, 90, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1531, 91, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1532, 91, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1533, 91, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1534, 91, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1535, 91, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1536, 91, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1537, 91, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1538, 91, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1539, 91, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1540, 91, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1541, 91, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1542, 91, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1543, 91, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1544, 91, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1545, 91, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1546, 91, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1547, 91, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1548, 92, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1549, 92, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1550, 92, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1551, 92, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1552, 92, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1553, 92, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1554, 92, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1555, 92, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1556, 92, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1557, 92, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1558, 92, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1559, 92, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1560, 92, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1561, 92, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1562, 92, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1563, 92, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1564, 92, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1565, 93, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1566, 93, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1567, 93, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1568, 93, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1569, 93, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1570, 93, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1571, 93, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1572, 93, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1573, 93, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1574, 93, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1575, 93, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1576, 93, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1577, 93, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1578, 93, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1579, 93, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1580, 93, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1581, 93, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1582, 94, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1583, 94, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1584, 94, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1585, 94, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1586, 94, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1587, 94, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1588, 94, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1589, 94, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1590, 94, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1591, 94, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1592, 94, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1593, 94, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1594, 94, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1595, 94, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1596, 94, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1597, 94, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1598, 94, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1599, 95, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1600, 95, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1601, 95, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1602, 95, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1603, 95, 5, '828', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1604, 95, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1605, 95, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1606, 95, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1607, 95, 7, '6.7', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1608, 95, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1609, 95, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1610, 95, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1611, 95, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1612, 95, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1613, 95, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1614, 95, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1615, 95, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1616, 96, 1, '480', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1617, 96, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1618, 96, 2, '188', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1619, 96, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1620, 96, 5, '855', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1621, 96, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1622, 96, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1623, 96, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1624, 96, 7, '7.5', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1625, 96, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1626, 96, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1627, 96, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1628, 96, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1629, 96, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1630, 96, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1631, 96, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1632, 96, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1633, 97, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1634, 97, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1635, 97, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1636, 97, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1637, 97, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1638, 97, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1639, 97, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1640, 97, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1641, 97, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1642, 97, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1643, 97, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1644, 97, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1645, 97, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1646, 97, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1647, 97, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1648, 97, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1649, 97, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1650, 98, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1651, 98, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1652, 98, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1653, 98, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1654, 98, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1655, 98, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1656, 98, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1657, 98, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1658, 98, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1659, 98, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1660, 98, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1661, 98, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1662, 98, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1663, 98, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1664, 98, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1665, 98, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1666, 98, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1667, 99, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1668, 99, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1669, 99, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1670, 99, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1671, 99, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1672, 99, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1673, 99, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1674, 99, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1675, 99, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1676, 99, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1677, 99, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1678, 99, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1679, 99, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1680, 99, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1681, 99, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1682, 99, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1683, 99, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1684, 100, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1685, 100, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1686, 100, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1687, 100, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1688, 100, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1689, 100, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1690, 100, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1691, 100, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1692, 100, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1693, 100, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1694, 100, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1695, 100, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1696, 100, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1697, 100, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1698, 100, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1699, 100, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1700, 100, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1701, 101, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1702, 101, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1703, 101, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1704, 101, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1705, 101, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1706, 101, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1707, 101, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1708, 101, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1709, 101, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1710, 101, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1711, 101, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1712, 101, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1713, 101, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1714, 101, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1715, 101, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1716, 101, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1717, 101, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1718, 102, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1719, 102, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1720, 102, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1721, 102, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1722, 102, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1723, 102, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1724, 102, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1725, 102, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1726, 102, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1727, 102, 6, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1728, 102, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1729, 102, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1730, 102, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1731, 102, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1732, 102, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1733, 102, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1734, 102, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1735, 103, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1736, 103, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1737, 103, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1738, 103, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1739, 103, 5, '819', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1740, 103, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1741, 103, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1742, 103, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1743, 103, 7, '7.8', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1744, 103, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1745, 103, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1746, 103, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1747, 103, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1748, 103, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1749, 103, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1750, 103, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1751, 103, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1752, 104, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1753, 104, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1754, 104, 2, '184', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1755, 104, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1756, 104, 5, '836', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1757, 104, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1758, 104, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1759, 104, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1760, 104, 7, '8.9', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1761, 104, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1762, 104, 18, '2.1', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1763, 104, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1764, 104, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1765, 104, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1766, 104, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1767, 104, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1768, 104, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1769, 105, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1770, 105, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1771, 105, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1772, 105, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1773, 105, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1774, 105, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1775, 105, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1776, 105, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1777, 105, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1778, 105, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1779, 105, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1780, 105, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1781, 105, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1782, 105, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1783, 105, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1784, 105, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1785, 105, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1786, 106, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1787, 106, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1788, 106, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1789, 106, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1790, 106, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1791, 106, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1792, 106, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1793, 106, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1794, 106, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1795, 106, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1796, 106, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1797, 106, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1798, 106, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1799, 106, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1800, 106, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1801, 106, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1802, 106, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1803, 107, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1804, 107, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1805, 107, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1806, 107, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1807, 107, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1808, 107, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1809, 107, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1810, 107, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1811, 107, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1812, 107, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1813, 107, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1814, 107, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1815, 107, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1816, 107, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1817, 107, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1818, 107, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1819, 107, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1820, 108, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1821, 108, 17, 'OPC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1822, 108, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1823, 108, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1824, 108, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1825, 108, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1826, 108, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1827, 108, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1828, 108, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1829, 108, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1830, 108, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1831, 108, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1832, 108, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1833, 108, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1834, 108, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1835, 108, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1836, 108, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1837, 109, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1838, 109, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1839, 109, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1840, 109, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1841, 109, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1842, 109, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1843, 109, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1844, 109, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1845, 109, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1846, 109, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1847, 109, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1848, 109, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1849, 109, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1850, 109, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1851, 109, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1852, 109, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1853, 109, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1854, 110, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1855, 110, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1856, 110, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1857, 110, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1858, 110, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1859, 110, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1860, 110, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1861, 110, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1862, 110, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1863, 110, 6, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1864, 110, 18, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1865, 110, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1866, 110, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1867, 110, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1868, 110, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1869, 110, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1870, 110, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1871, 111, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1872, 111, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1873, 111, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1874, 111, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1875, 111, 5, '825', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1876, 111, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1877, 111, 3, '590', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1878, 111, 4, '385', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1879, 111, 7, '9.4', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1880, 111, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1881, 111, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1882, 111, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1883, 111, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1884, 111, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1885, 111, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1886, 111, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1887, 111, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1888, 112, 1, '500', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1889, 112, 17, 'SRC', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1890, 112, 2, '174', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1891, 112, 12, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1892, 112, 5, '839', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1893, 112, 11, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1894, 112, 3, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1895, 112, 4, '845', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1896, 112, 7, '10.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1897, 112, 6, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1898, 112, 18, '2.2', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1899, 112, 8, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1900, 112, 9, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1901, 112, 14, '150 + 25', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1902, 112, 15, '2%', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1903, 112, 13, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1904, 112, 16, '', '', '2021-02-09 01:50:00', '2021-04-05 18:30:00'),
(1905, 113, 1, '250', '', NULL, NULL),
(1906, 113, 2, '193', '', NULL, NULL),
(1907, 113, 17, 'OPC', '', NULL, NULL),
(1908, 113, 0, '', '', NULL, NULL),
(1909, 113, 8, '0', '', NULL, NULL),
(1910, 113, 9, '1', '', NULL, NULL),
(1911, 113, 11, '1', '', NULL, NULL),
(1912, 113, 12, '0', '', NULL, NULL),
(1913, 113, 13, '1', '', NULL, NULL),
(1914, 113, 14, '150±25', '', NULL, NULL),
(1915, 113, 0, '', '', NULL, NULL),
(1916, 113, 15, '1.5%', '', NULL, NULL),
(1917, 113, 0, '', '', NULL, NULL),
(1918, 113, 16, '0', '', NULL, NULL),
(1919, 113, 3, '590', '', NULL, NULL),
(1920, 113, 4, '385', '', NULL, NULL),
(1921, 113, 5, '1068', '', NULL, NULL),
(1922, 113, 6, '1.5', '', NULL, NULL),
(1923, 113, 18, '0', '', NULL, NULL),
(1924, 113, 7, '3.5', '', NULL, NULL),
(1949, 1, 8, '0', '', NULL, NULL),
(1948, 1, 0, '', '', NULL, NULL),
(1947, 1, 17, 'OPC', '', NULL, NULL),
(1946, 1, 2, '193', '', NULL, NULL),
(1945, 1, 1, '250', '', NULL, NULL),
(1963, 1, 18, '0', '', NULL, NULL),
(1964, 1, 7, '2.8', '', NULL, NULL),
(1965, 114, 1, '250', '', NULL, NULL),
(1966, 114, 2, '189', '', NULL, NULL),
(1967, 114, 17, 'OPC', '', NULL, NULL),
(1968, 114, 0, '', '', NULL, NULL),
(1969, 114, 8, '0', '', NULL, NULL),
(1970, 114, 9, '1', '', NULL, NULL),
(1971, 114, 11, '0', '', NULL, NULL),
(1972, 114, 12, '0', '', NULL, NULL),
(1973, 114, 13, '0', '', NULL, NULL),
(1974, 114, 14, '125±25', '', NULL, NULL),
(1975, 114, 0, '', '', NULL, NULL),
(1976, 114, 15, '1.99%', '', NULL, NULL),
(1977, 114, 0, '', '', NULL, NULL),
(1978, 114, 16, '0', '', NULL, NULL),
(1979, 114, 3, '590', '', NULL, NULL),
(1980, 114, 4, '385', '', NULL, NULL),
(1981, 114, 5, '1068', '', NULL, NULL),
(1982, 114, 6, '1.5', '', NULL, NULL),
(1983, 114, 18, '0', '', NULL, NULL),
(1984, 114, 7, '9.4', '', NULL, NULL),
(1985, 115, 1, '300', '', NULL, NULL),
(1986, 115, 2, '189', '', NULL, NULL),
(1987, 115, 17, 'OTHERS', 'c tt', NULL, NULL),
(1988, 115, 0, 'c tt', '', NULL, NULL),
(1989, 115, 8, '1', '', NULL, NULL),
(1990, 115, 9, '1', '', NULL, NULL),
(1991, 115, 11, '0', '', NULL, NULL),
(1992, 115, 12, '0', '', NULL, NULL),
(1993, 115, 13, '1', '', NULL, NULL),
(1994, 115, 14, 'OTHERS', 's tt', NULL, NULL),
(1995, 115, 0, 's tt', '', NULL, NULL),
(1996, 115, 15, 'OTHERS', 'a tt', NULL, NULL),
(1997, 115, 0, 'a tt', '', NULL, NULL),
(1998, 115, 16, '0', '', NULL, NULL),
(1999, 115, 3, '0', '', NULL, NULL),
(2000, 115, 4, '385', '', NULL, NULL),
(2001, 115, 5, '1068', '', NULL, NULL),
(2002, 115, 6, '1.5', '', NULL, NULL),
(2003, 115, 18, '2.2', '', NULL, NULL),
(2004, 115, 7, '3.5', '', NULL, NULL),
(2005, 116, 1, '250', '', NULL, NULL),
(2006, 116, 2, '193', '', NULL, NULL),
(2007, 116, 17, 'SRC', '', NULL, NULL),
(2008, 116, 0, '', '', NULL, NULL),
(2009, 116, 8, '0', '', NULL, NULL),
(2010, 116, 9, '0', '', NULL, NULL),
(2011, 116, 11, '0', '', NULL, NULL),
(2012, 116, 12, '1', '', NULL, NULL),
(2013, 116, 13, '0', '', NULL, NULL),
(2014, 116, 14, '125±25', '', NULL, NULL),
(2015, 116, 0, '', '', NULL, NULL),
(2016, 116, 15, '1.5%', '', NULL, NULL),
(2017, 116, 0, '', '', NULL, NULL),
(2018, 116, 16, '0', '', NULL, NULL),
(2019, 116, 3, '590', '', NULL, NULL),
(2020, 116, 4, '385', '', NULL, NULL),
(2021, 116, 5, '998', '', NULL, NULL),
(2022, 116, 6, '1.5', '', NULL, NULL),
(2023, 116, 18, '0', '', NULL, NULL),
(2024, 116, 7, '9.4', '', NULL, NULL),
(2025, 117, 1, '250', '', NULL, NULL),
(2026, 117, 2, '193', '', NULL, NULL),
(2027, 117, 17, 'PPC', '', NULL, NULL),
(2028, 117, 0, '', '', NULL, NULL),
(2029, 117, 8, '0', '', NULL, NULL),
(2030, 117, 9, '0', '', NULL, NULL),
(2031, 117, 11, '0', '', NULL, NULL),
(2032, 117, 12, '0', '', NULL, NULL),
(2033, 117, 13, '0', '', NULL, NULL),
(2034, 117, 14, 'OTHERS', 's t three', NULL, NULL),
(2035, 117, 0, 's t three', '', NULL, NULL),
(2036, 117, 15, '1.99%', '', NULL, NULL),
(2037, 117, 0, '', '', NULL, NULL),
(2038, 117, 16, '0', '', NULL, NULL),
(2039, 117, 3, '590', '', NULL, NULL),
(2040, 117, 4, '385', '', NULL, NULL),
(2041, 117, 5, '839', '', NULL, NULL),
(2042, 117, 6, '1.5', '', NULL, NULL),
(2043, 117, 18, '0', '', NULL, NULL),
(2044, 117, 7, '3.2', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pump`
--

CREATE TABLE `pump` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `location` text CHARACTER SET utf8 DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `operator_id` int(11) DEFAULT NULL,
  `helper_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pump`
--

INSERT INTO `pump` (`id`, `name`, `location`, `lat`, `lng`, `is_active`, `operator_id`, `helper_id`, `driver_id`, `created_at`, `updated_at`) VALUES
(1, 'Pump 01', '', '39.272141', '21.696681', '1', 63, 14121203, 14121187, '2022-02-16 05:00:32', '2022-03-07 11:12:35'),
(2, 'Pump 06', '', '39.223863', '21.696681', '1', 118, 14121204, 14121192, '2022-02-16 05:01:10', '2022-03-08 22:21:49'),
(3, 'Pump 03', '', '39.223863', '21.696681', '1', 117, 14121197, 14121189, '2022-02-22 23:57:44', '2022-03-07 11:14:10'),
(4, 'Pump 04', '', NULL, NULL, '1', 35, 15, 14121190, '2022-02-24 07:43:31', '2022-03-07 11:13:59'),
(5, 'Pump 05', '', NULL, NULL, '1', 39, 14121202, 14121191, '2022-02-24 17:25:57', '2022-03-07 11:14:34'),
(6, 'Pump 07', '', NULL, NULL, '1', 46, 14121201, 14121193, '2022-03-07 11:15:29', '2022-03-07 11:15:29'),
(7, 'Pump 08', '', NULL, NULL, '1', 18, 13, 14121194, '2022-03-07 11:16:06', '2022-03-07 11:16:06'),
(8, 'Pump 09', '', NULL, NULL, '1', 85, 14121198, 14121195, '2022-03-07 11:16:29', '2022-03-07 11:16:29'),
(9, 'Pump 10', '', NULL, NULL, '1', 22, 14, 14121196, '2022-03-07 11:16:56', '2022-03-07 11:16:56'),
(10, 'Pump 11', '', NULL, NULL, '1', 133, 14121199, 14121188, '2022-03-07 11:17:22', '2022-03-07 11:17:22'),
(11, 'No Pump', '', NULL, NULL, '1', 14121242, 14121243, 14121240, '2022-03-09 19:46:06', '2022-03-09 19:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_contract`
--

CREATE TABLE `purchase_contract` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_id` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pur_order_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `contract_value` double(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `pay_days` int(11) DEFAULT NULL,
  `sign_status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1-Signed , 0-Not Signed',
  `signed_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_contract_attachments`
--

CREATE TABLE `purchase_contract_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_contract_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_estimate`
--

CREATE TABLE `purchase_estimate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estimate_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `pur_req_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `estimate_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1-Not yet approve , 2-Approved , 3-Reject',
  `sub_total` double(10,2) DEFAULT NULL,
  `dc_percent` double(10,2) DEFAULT NULL,
  `dc_total` double(10,2) DEFAULT NULL,
  `after_discount` double(10,2) DEFAULT NULL,
  `total` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_estimate_details`
--

CREATE TABLE `purchase_estimate_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_estimate_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `net_total` double(10,2) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `net_total_after_tax` double(10,2) DEFAULT NULL,
  `discount_per` double(10,2) DEFAULT NULL,
  `discount_money` double(10,2) DEFAULT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_req_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL DEFAULT 0.00,
  `qunatity` int(11) NOT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `estimate_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_number` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_days_owned` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_Date` date DEFAULT NULL,
  `vendor_note` text CHARACTER SET utf8 DEFAULT NULL,
  `terms_conditions` text CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1-Not yet approve , 2-Approved , 3-Reject , 4-Cancel',
  `sub_total` double(10,2) DEFAULT NULL,
  `dc_percent` double(10,2) DEFAULT NULL,
  `dc_total` double(10,2) DEFAULT NULL,
  `after_discount` double(10,2) DEFAULT NULL,
  `total` double(10,2) DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL,
  `manufact_id` int(11) DEFAULT NULL,
  `condition` enum('old','new') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `buy_price` double(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sell_price` double(10,2) DEFAULT NULL,
  `part_no` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warrenty` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_amount` double(10,2) DEFAULT NULL,
  `pending_amount` double(10,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `dept_id`, `name`, `vendor_id`, `estimate_id`, `order_date`, `user_id`, `order_number`, `no_of_days_owned`, `delivery_Date`, `vendor_note`, `terms_conditions`, `status`, `sub_total`, `dc_percent`, `dc_total`, `after_discount`, `total`, `part_id`, `manufact_id`, `condition`, `buy_price`, `quantity`, `sell_price`, `part_no`, `warrenty`, `given_amount`, `pending_amount`, `image`, `created_at`, `updated_at`) VALUES
(1, 10, NULL, 14121283, NULL, '2022-05-23', 1, 'ORD-00001', NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 200.00, 1, 1, 'new', 100.00, 2, NULL, '123456', NULL, 200.00, 0.00, NULL, '2022-05-23 20:33:47', '2022-05-23 20:33:47'),
(2, 10, NULL, 14121283, NULL, '2022-05-27', 1, 'ORD-00002', NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 500.00, 1, 1, 'new', 100.00, 5, 90.00, '123', '1', 90.00, 410.00, NULL, '2022-05-27 21:52:57', '2022-05-27 21:52:57'),
(3, 10, NULL, 14121283, NULL, '2022-06-03', 1, 'ORD-00003', NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 500.00, 2, 1, 'new', 100.00, 5, NULL, '123', '1', 100.00, 400.00, NULL, '2022-06-04 02:55:42', '2022-06-04 03:01:01'),
(4, 10, NULL, 14121283, NULL, '2022-06-03', 1, 'ORD-00004', NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 1000.00, 2, 1, 'new', 100.00, 10, 0.00, '123', '1', 500.00, 500.00, NULL, '2022-06-11 19:13:06', '2022-06-11 19:15:15'),
(5, 10, NULL, 14121283, NULL, '2022-05-27', 1, 'ORD-00005', NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, 100.00, 1, 1, 'new', 100.00, 1, 90.00, '123', '1', 100.00, 0.00, NULL, '2022-06-22 00:25:23', '2022-06-22 00:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders_detail`
--

CREATE TABLE `purchase_orders_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_ord_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `net_total` double(10,2) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `net_total_after_tax` double(10,2) DEFAULT NULL,
  `discount_per` double(10,2) DEFAULT NULL,
  `discount_money` double(10,2) DEFAULT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_invoices`
--

CREATE TABLE `purchase_order_invoices` (
  `id` int(11) NOT NULL,
  `p_order_id` int(11) NOT NULL,
  `order_number` varchar(45) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `invoice_id` varchar(45) DEFAULT NULL,
  `received` enum('YES','NO') DEFAULT 'YES',
  `bin_id` varchar(45) DEFAULT NULL,
  `received_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_order_invoices`
--

INSERT INTO `purchase_order_invoices` (`id`, `p_order_id`, `order_number`, `supplier_id`, `invoice_id`, `received`, `bin_id`, `received_by`, `created_at`, `updated_at`) VALUES
(11, 3, 'ORD-00003', NULL, '1234', 'YES', '123456', NULL, '2022-06-04 03:01:01', '2022-06-04 03:01:01'),
(12, 4, 'ORD-00004', NULL, '1001', 'YES', 'A101', NULL, '2022-06-11 19:15:15', '2022-06-11 19:15:15'),
(13, 5, 'ORD-00005', NULL, '1001', 'YES', 'A1001', NULL, '2022-06-22 00:26:05', '2022-06-22 00:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_code` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `purchase_request_name` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1-Not yet approve , 2-Approved , 3-Reject',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request_details`
--

CREATE TABLE `purchase_request_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_req_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_units`
--

CREATE TABLE `purchase_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_code` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `unit_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `unit_symbol` text CHARACTER SET utf8 DEFAULT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `pur_req_id` int(11) NOT NULL,
  `estimate_number` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `sub_total` double(10,2) NOT NULL,
  `discount_percentage` double(10,2) NOT NULL,
  `discount_amount` double(10,2) NOT NULL,
  `grand_total` double(10,2) NOT NULL,
  `vendor_note` text CHARACTER SET utf8 DEFAULT NULL,
  `terms_conditions` text CHARACTER SET utf8 DEFAULT NULL,
  `estimate_date` date DEFAULT NULL,
  `expiry_Date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations_detail`
--

CREATE TABLE `quotations_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `net_total` double(10,2) NOT NULL,
  `tax` double(10,2) NOT NULL,
  `gross_total` double(10,2) NOT NULL,
  `discount_percentage` double(10,2) NOT NULL,
  `discount_amount` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `estimate_date` date NOT NULL,
  `expiry_Date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reimbursement_type`
--

CREATE TABLE `reimbursement_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_pass_token`
--

CREATE TABLE `reset_pass_token` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `token` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `guard_name`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'web', 1, NULL, NULL),
(2, 'Sales', 'sales', 'web', 2, NULL, NULL),
(3, 'Customer', 'customer', 'web', 3, NULL, NULL),
(4, 'Vendor', 'vendor', 'web', 4, NULL, NULL),
(5, 'Contact', 'contact', 'web', 4, NULL, NULL),
(6, 'Driver', 'driver', 'web', 5, NULL, NULL),
(7, 'Delivery', 'delivery', 'web', 6, NULL, NULL),
(8, 'Purchase', 'purchase', 'web', 7, NULL, NULL),
(9, 'Inventory', 'inventory', 'web', 9, NULL, NULL),
(10, 'Mechanics', 'mechanics', 'web', 10, NULL, NULL),
(11, 'Vechicle parts supplier', 'vechicle_parts_supplier', 'web', 10, NULL, NULL),
(12, 'Pump Operator', 'pump_operator', 'web', 5, NULL, NULL),
(13, 'Pump Helper', 'pump_helper', 'web', 5, NULL, NULL),
(14, 'QC', 'qc', 'web', 6, '2021-04-18 07:53:23', '2021-04-18 07:53:23'),
(15, 'FinanceManager', 'financemanager', 'web', 12, '2021-05-23 19:02:02', '2021-05-23 19:02:02'),
(16, 'Accts-Staff', 'accts-staff', 'web', 12, '2021-05-23 19:05:53', '2021-05-23 19:05:53'),
(17, 'HR Manager', 'hr-manager', 'web', 9, '2021-05-23 19:50:01', '2021-05-23 19:50:01'),
(18, 'Dispatcher', 'dispatcher', 'web', 5, '2021-09-18 18:58:14', '2021-09-18 18:58:14'),
(19, 'reservation', 'reservation', 'web', 8, '2021-10-02 18:18:18', '2021-10-02 18:18:18'),
(20, 'scaleoperator', 'scaleoperator', 'web', 10, '2022-02-24 07:20:45', '2022-02-24 07:20:45'),
(21, 'Plant Operator', 'plant-operator', 'web', 5, '2022-03-03 23:38:00', '2022-03-03 23:38:00'),
(22, 'Workshop Manager', 'workshop-manager', 'web', 7, '2022-04-24 19:33:40', '2022-04-24 19:33:40'),
(23, 'Storekeeper', 'storekeeper', 'web', 7, '2022-06-06 14:09:49', '2022-06-06 14:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 13),
(1, 20),
(1, 21),
(2, 1),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 14),
(23, 1),
(23, 14),
(24, 1),
(24, 14),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(66, 1),
(66, 2),
(67, 1),
(67, 23),
(68, 1),
(68, 23),
(69, 1),
(69, 23),
(70, 1),
(70, 23),
(71, 1),
(71, 23),
(72, 1),
(72, 23),
(73, 1),
(73, 23),
(74, 1),
(74, 23),
(75, 1),
(75, 23),
(76, 1),
(76, 23),
(77, 1),
(77, 23),
(78, 1),
(78, 23),
(79, 1),
(79, 23),
(80, 1),
(80, 23),
(81, 1),
(81, 23),
(82, 1),
(82, 23),
(83, 1),
(83, 23),
(84, 1),
(84, 23),
(85, 1),
(85, 10),
(85, 22),
(85, 23),
(86, 1),
(86, 22),
(86, 23),
(87, 1),
(87, 10),
(87, 22),
(87, 23),
(88, 1),
(88, 22),
(88, 23),
(89, 1),
(89, 22),
(89, 23),
(90, 1),
(90, 22),
(90, 23),
(91, 1),
(91, 22),
(92, 1),
(92, 22),
(93, 1),
(93, 22),
(94, 1),
(94, 22),
(95, 1),
(95, 22),
(96, 1),
(96, 22),
(97, 1),
(97, 22),
(97, 23),
(98, 1),
(98, 22),
(98, 23),
(99, 1),
(99, 22),
(99, 23),
(100, 1),
(100, 22),
(100, 23),
(101, 1),
(101, 22),
(101, 23),
(102, 1),
(102, 22),
(102, 23),
(103, 1),
(103, 22),
(104, 1),
(104, 22),
(105, 1),
(105, 22),
(106, 1),
(106, 22),
(106, 23),
(107, 1),
(107, 22),
(107, 23),
(108, 1),
(108, 22),
(108, 23),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(118, 2),
(119, 1),
(119, 2),
(120, 1),
(120, 2),
(121, 1),
(121, 2),
(122, 1),
(122, 2),
(123, 1),
(123, 2),
(124, 1),
(125, 1),
(125, 14),
(126, 1),
(126, 14),
(127, 1),
(128, 1),
(129, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_run_id` int(11) NOT NULL,
  `basic` double(10,2) DEFAULT NULL,
  `overtime_pay` double(10,2) DEFAULT NULL,
  `lac_pay` double(10,2) DEFAULT NULL,
  `monthly_total` double(10,2) DEFAULT NULL,
  `gross_total` double(10,2) DEFAULT NULL,
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci DEFAULT 'unpaid',
  `payment_date` date DEFAULT NULL,
  `paid_days` int(11) DEFAULT NULL,
  `unpaid_days` int(11) DEFAULT NULL,
  `payment_type` enum('cheque','cash','online') COLLATE utf8mb4_unicode_ci DEFAULT 'cash',
  `is_added_on_erp` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_sal_id` int(11) NOT NULL,
  `earning_id` int(11) NOT NULL,
  `cal_value` int(11) DEFAULT NULL,
  `monthly_amt` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_contract`
--

CREATE TABLE `sales_contract` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cust_id` int(11) NOT NULL,
  `title` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `sales_agent` int(11) DEFAULT NULL,
  `admin_note` longtext CHARACTER SET utf8 DEFAULT NULL,
  `client_note` longtext CHARACTER SET utf8 DEFAULT NULL,
  `site_location` text CHARACTER SET utf8 DEFAULT NULL,
  `excepted_m3` double(10,2) DEFAULT NULL,
  `terms_conditions` longtext CHARACTER SET utf8 DEFAULT NULL,
  `compressive_strength` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `structure_element` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `slump` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `concrete_temp` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `quantity` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('unsigned','signed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unsigned',
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_contract`
--

INSERT INTO `sales_contract` (`id`, `contract_no`, `cust_id`, `title`, `sales_agent`, `admin_note`, `client_note`, `site_location`, `excepted_m3`, `terms_conditions`, `compressive_strength`, `structure_element`, `slump`, `concrete_temp`, `quantity`, `status`, `delivery_address`, `created_at`, `updated_at`) VALUES
(1, 'SCO-00001', 14121185, 'Site 12', 2, NULL, NULL, 'site 1 location', 30.00, NULL, '1', '1', '1', '1', '10', 'signed', 'test address', '2022-02-16 04:54:31', '2022-02-17 16:56:27'),
(2, 'SCO-00002', 14121185, 'Site 2', 2, NULL, NULL, 'site 2 location', 30.00, NULL, '1', '1', '1', '1', '10', 'signed', 'test address', '2022-02-16 04:56:09', '2022-02-16 04:56:09'),
(3, 'SCO-00003', 14121178, 'المروة', 56, NULL, NULL, 'المروة', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', '2المروة', '2022-02-16 21:53:55', '2022-03-08 19:42:47'),
(4, 'SCO-00004', 14121181, 'درب الحرمين 216', 88, NULL, NULL, 'درب الحرمين 216', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-17 17:26:08', '2022-05-10 19:59:46'),
(5, 'SCO-00005', 14121180, 'المورة 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-02-17 18:14:21', '2022-02-17 18:14:21'),
(6, 'SCO-00006', 14121180, 'الورود', 56, NULL, NULL, 'الورود', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-18 20:37:38', '2022-03-09 20:05:40'),
(7, 'SCO-00007', 14121180, 'test 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-18 20:41:34', '2022-02-18 20:41:34'),
(8, 'SCO-00008', 14121181, 'الصفا 229', 88, NULL, NULL, 'الصفا 229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 17:42:37', '2022-05-10 20:00:25'),
(9, 'SCO-00009', 14121179, 'Alworod', 56, NULL, NULL, 'Alworod', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 17:58:11', '2022-05-16 13:39:27'),
(10, 'SCO-00010', 14121185, 'الريان', 58, NULL, NULL, 'الريان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 18:01:14', '2022-05-16 13:54:22'),
(11, 'SCO-00011', 14121174, 'ذهبان', 56, NULL, NULL, 'ذهبان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 23:12:54', '2022-03-09 23:54:16'),
(12, 'SCO-00012', 14121175, 'Khoja', 19, NULL, NULL, 'Khoja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 23:15:08', '2022-05-12 17:24:02'),
(13, 'SCO-00013', 14121176, 'مخطط الموسى فيو', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 23:17:04', '2022-03-08 19:43:41'),
(14, 'SCO-00014', 14121177, 'ايكون', 58, NULL, NULL, 'ايكون', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-02-20 23:19:00', '2022-03-09 20:01:31'),
(15, 'SCO-00015', 14121186, '87', 56, NULL, NULL, '87', 30.00, NULL, '10', '20', '30', '40', NULL, 'signed', NULL, '2022-02-24 07:11:14', '2022-05-12 18:18:54'),
(16, 'SCO-00016', 14121206, 'Alnahda 4', 56, NULL, NULL, 'Alnahda 4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-07 22:26:41', '2022-05-12 14:01:32'),
(17, 'SCO-00017', 14121208, 'السلامه', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 18:34:07', '2022-03-08 19:16:19'),
(18, 'SCO-00018', 14121209, '24', 56, NULL, NULL, '24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 18:37:50', '2022-05-12 12:32:14'),
(19, 'SCO-00019', 14121207, 'Suondos', 58, NULL, NULL, 'Suondos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 18:46:39', '2022-05-12 12:14:09'),
(20, 'SCO-00020', 14121210, '603 A الحمدانية', 19, NULL, NULL, '603 A الحمدانية', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 18:51:47', '2022-03-09 20:52:39'),
(21, 'SCO-00021', 14121210, '604 A الحمدانية', 19, NULL, NULL, '604 A الحمدانية', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 18:55:41', '2022-03-09 20:51:16'),
(22, 'SCO-00022', 14121210, '604 B - Alhamdania', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 18:56:27', '2022-03-08 19:11:45'),
(23, 'SCO-00023', 14121210, '602 B Alhamdania', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 19:14:35', '2022-03-08 20:00:36'),
(99, 'SCO-00099', 14121264, 'Alfaal', 19, NULL, NULL, 'Alfaal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 17:47:44', '2022-05-12 17:47:44'),
(24, 'SCO-00024', 14121210, '603 B Alhamdania', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:01:38', '2022-03-08 20:02:15'),
(25, 'SCO-00025', 14121211, 'Lamasat 63', 56, NULL, NULL, 'Lamasat 63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:04:14', '2022-05-24 17:32:53'),
(26, 'SCO-00026', 14121179, 'Altiser 7', 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:05:37', '2022-03-08 20:05:37'),
(27, 'SCO-00027', 14121212, 'النزهة', 58, NULL, NULL, 'النزهة', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:08:23', '2022-05-17 13:02:55'),
(28, 'SCO-00028', 14121213, 'الصفا', 56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:11:02', '2022-03-08 20:11:02'),
(29, 'SCO-00029', 14121214, 'الريان 11', 58, NULL, NULL, 'الريان 11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:13:12', '2022-05-16 13:41:23'),
(30, 'SCO-00030', 14121210, '602 الحمدانية', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:14:13', '2022-03-08 20:14:13'),
(31, 'SCO-00031', 14121210, '601 الحمدانية', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:14:46', '2022-03-08 20:14:46'),
(32, 'SCO-00032', 14121210, '563 النهضه', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:15:33', '2022-03-08 20:15:33'),
(33, 'SCO-00033', 14121211, '3 (233-235-237)', 58, NULL, NULL, '3 (233-235-237)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:18:20', '2022-05-24 17:20:55'),
(34, 'SCO-00034', 14121216, '116', 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:21:33', '2022-03-08 20:21:33'),
(35, 'SCO-00035', 14121210, 'فيلا المحمدية', 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:22:26', '2022-03-08 20:22:26'),
(36, 'SCO-00036', 14121217, '2', 56, NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:25:10', '2022-05-12 18:07:39'),
(37, 'SCO-00037', 14121218, '167', 56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:53:35', '2022-03-08 20:53:35'),
(38, 'SCO-00038', 14121219, 'المروة 34-43', 56, NULL, NULL, 'المروة 34-43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 20:58:27', '2022-03-09 20:25:19'),
(39, 'SCO-00039', 14121221, 'بروج الحرمين 3', 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:02:12', '2022-03-08 21:02:12'),
(40, 'SCO-00040', 14121224, 'النزهه', 58, NULL, NULL, 'النزهه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:07:19', '2022-03-10 21:53:51'),
(41, 'SCO-00041', 14121225, 'باجنيد البنيان', 56, NULL, NULL, 'باجنيد البنيان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:08:23', '2022-05-11 19:43:48'),
(42, 'SCO-00042', 14121226, 'النزهه', 58, NULL, NULL, 'النزهه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:09:12', '2022-05-11 19:30:50'),
(43, 'SCO-00043', 14121227, 'الريان فيصل', 58, NULL, NULL, 'الريان فيصل', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:10:20', '2022-05-11 19:28:34'),
(44, 'SCO-00044', 14121228, 'Andijani', 56, NULL, NULL, 'Andijani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:11:25', '2022-05-24 17:53:21'),
(45, 'SCO-00045', 14121232, 'الريان 103', 58, NULL, NULL, 'الريان 103', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:15:14', '2022-05-11 17:57:44'),
(46, 'SCO-00046', 14121233, 'Alwrood 115', 58, NULL, NULL, 'Alwrood 115', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:15:54', '2022-05-12 17:08:30'),
(47, 'SCO-00047', 14121234, '5', 56, NULL, NULL, '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:16:21', '2022-05-11 17:20:53'),
(48, 'SCO-00048', 14121226, 'سندس', 58, NULL, NULL, 'سندس', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-08 21:16:56', '2022-05-11 19:32:12'),
(49, 'SCO-00049', 14121235, 'بنك الجزيرة', 56, NULL, NULL, 'بنك الجزيرة', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 18:27:33', '2022-05-11 17:15:24'),
(50, 'SCO-00050', 14121236, 'الحرمين', 56, NULL, NULL, 'الحرمين', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 18:37:22', '2022-05-11 17:59:51'),
(51, 'SCO-00051', 14121237, 'الفيصليه', 58, NULL, NULL, 'الفيصليه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 18:55:05', '2022-05-11 16:35:37'),
(52, 'SCO-00052', 14121238, 'الحرمين2', 56, NULL, NULL, 'الحرمين2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 19:01:51', '2022-05-11 15:55:19'),
(53, 'SCO-00053', 14121175, 'شارع حراء', 19, NULL, NULL, 'شارع حراء', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 19:14:59', '2022-03-09 20:06:16'),
(54, 'SCO-00054', 14121239, 'الريان', 58, NULL, NULL, 'الريان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 19:32:11', '2022-05-11 15:48:00'),
(55, 'SCO-00055', 14121241, 'الريان', 56, NULL, NULL, 'الريان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 19:36:51', '2022-05-11 15:44:33'),
(56, 'SCO-00056', 14121244, 'الريان', 58, NULL, NULL, 'الريان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 19:52:48', '2022-05-12 17:42:46'),
(57, 'SCO-00057', 14121245, '7', 56, NULL, NULL, '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 20:10:28', '2022-05-11 15:35:54'),
(58, 'SCO-00058', 14121246, 'المنار', 56, NULL, NULL, 'المنار', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 20:13:46', '2022-05-11 15:24:48'),
(59, 'SCO-00059', 14121228, 'Alsafa', 56, NULL, NULL, 'Alsafa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 20:20:26', '2022-05-24 17:53:45'),
(60, 'SCO-00060', 14121247, 'الزهراء', 56, NULL, NULL, 'الزهراء', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 20:30:36', '2022-05-11 15:09:28'),
(61, 'SCO-00061', 14121178, 'الحمراء', 56, NULL, NULL, 'الحمراء', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 20:43:04', '2022-03-09 20:43:04'),
(62, 'SCO-00062', 14121245, '10', 56, NULL, NULL, '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 20:59:46', '2022-05-11 15:34:21'),
(63, 'SCO-00063', 14121248, 'اريج 10', 58, NULL, NULL, 'اريج 10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 21:06:17', '2022-05-11 15:01:34'),
(64, 'SCO-00064', 14121249, 'Alfal', 19, NULL, NULL, 'Alfal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 21:09:16', '2022-05-11 14:59:43'),
(65, 'SCO-00065', 14121250, 'المنح', 56, NULL, NULL, 'المنح', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 21:13:56', '2022-05-11 14:55:00'),
(66, 'SCO-00066', 14121234, '4', 56, NULL, NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-09 21:20:50', '2022-05-11 17:27:09'),
(67, 'SCO-00067', 14121251, 'Alrayan 1-2', 56, NULL, NULL, 'Alrayan 1-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-03-14 18:16:49', '2022-05-11 14:41:58'),
(68, 'SCO-00068', 14121253, 'Alrabwa', 56, NULL, NULL, 'Alrabwa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'signed', NULL, '2022-04-17 18:58:57', '2022-05-11 14:29:09'),
(69, 'SCO-00069', 14121253, 'Tibaa', 56, NULL, NULL, 'Tibaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:32:22', '2022-05-11 18:03:47'),
(70, 'SCO-00070', 14121253, 'Aljwaher .Co', 56, NULL, NULL, 'Aljwaher .Co', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:35:29', '2022-05-11 18:03:53'),
(71, 'SCO-00071', 14121252, 'Almusa', 19, NULL, NULL, 'Almusa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:38:31', '2022-05-11 18:03:29'),
(72, 'SCO-00072', 14121251, 'Alrayan 3-4', 56, NULL, NULL, 'Alrayan 3-4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:45:22', '2022-05-11 18:02:56'),
(73, 'SCO-00073', 14121251, 'Alrayan 5', 56, NULL, NULL, 'Alrayan 5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:50:01', '2022-05-11 18:03:03'),
(74, 'SCO-00074', 14121251, 'Alrayan6', 56, NULL, NULL, 'Alrayan6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:52:58', '2022-05-11 18:03:09'),
(75, 'SCO-00075', 14121250, 'Alryad', 56, NULL, NULL, 'Alryad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 14:57:33', '2022-05-11 18:02:37'),
(76, 'SCO-00076', 14121248, 'Arij 7', 58, NULL, NULL, 'Arij 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 15:07:21', '2022-05-11 18:02:08'),
(77, 'SCO-00077', 14121246, 'Alzomord', 56, NULL, NULL, 'Alzomord', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 15:28:15', '2022-05-11 18:01:42'),
(78, 'SCO-00078', 14121245, '5', 56, NULL, NULL, '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 15:37:11', '2022-05-11 18:01:15'),
(79, 'SCO-00079', 14121245, '6', 56, NULL, NULL, '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 15:38:42', '2022-05-11 18:01:24'),
(80, 'SCO-00080', 14121238, 'الحرمين1', 56, NULL, NULL, 'الحرمين1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 15:57:24', '2022-05-11 18:00:27'),
(81, 'SCO-00081', 14121234, '3', 56, NULL, NULL, '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 17:38:05', '2022-05-11 17:58:41'),
(82, 'SCO-00082', 14121234, '2', 56, NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 17:39:34', '2022-05-11 17:58:50'),
(83, 'SCO-00083', 14121234, '1', 56, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 17:46:29', '2022-05-11 17:58:56'),
(84, 'SCO-00084', 14121232, 'الريان 102', 58, NULL, NULL, 'الريان 102', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 18:11:51', '2022-05-11 18:11:51'),
(85, 'SCO-00085', 14121232, 'الريان 105', 58, NULL, NULL, 'الريان 105', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 18:13:29', '2022-05-11 18:13:29'),
(86, 'SCO-00086', 14121232, 'الريان 106', 58, NULL, NULL, 'الريان 106', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 18:14:52', '2022-05-11 18:14:52'),
(87, 'SCO-00087', 14121231, 'النعيم', 56, NULL, NULL, 'النعيم', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 18:18:27', '2022-05-12 12:26:18'),
(88, 'SCO-00088', 14121230, 'السلامه', 58, NULL, NULL, 'السلامه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-11 18:20:47', '2022-05-11 18:20:47'),
(89, 'SCO-00089', 14121255, 'Albghdadia', 56, NULL, NULL, 'Albghdadia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 12:09:56', '2022-05-12 12:09:56'),
(90, 'SCO-00090', 14121222, 'Alfaisalia', 56, NULL, NULL, 'Alfaisalia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 12:18:39', '2022-05-12 12:18:39'),
(91, 'SCO-00091', 14121256, 'Alsafa', 56, NULL, NULL, 'Alsafa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 12:23:40', '2022-05-12 12:23:40'),
(92, 'SCO-00092', 14121257, 'Alsulimanih', 56, NULL, NULL, 'Alsulimanih', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 12:38:46', '2022-05-12 12:38:46'),
(93, 'SCO-00093', 14121258, 'Tibaa', 56, NULL, NULL, 'Tibaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 12:44:38', '2022-05-12 12:44:38'),
(94, 'SCO-00094', 14121259, 'Alzahid', 56, NULL, NULL, 'Alzahid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 13:05:39', '2022-05-12 13:05:39'),
(95, 'SCO-00095', 14121260, 'Alshati', 56, NULL, NULL, 'Alshati', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 13:28:12', '2022-05-12 13:28:12'),
(96, 'SCO-00096', 14121261, 'Alflaah', 56, NULL, NULL, 'Alflaah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 13:57:00', '2022-05-12 13:57:00'),
(97, 'SCO-00097', 14121262, 'Alrahily', 56, NULL, NULL, 'Alrahily', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 14:05:16', '2022-05-12 14:05:16'),
(98, 'SCO-00098', 14121263, 'Bin Dawood', 56, NULL, NULL, 'Bin Dawood', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 17:16:58', '2022-05-12 17:16:58'),
(100, 'SCO-00100', 14121265, 'Alryan', 19, NULL, NULL, 'Alryan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 18:02:01', '2022-05-12 18:02:01'),
(101, 'SCO-00101', 14121186, '88', 56, NULL, NULL, '88', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-12 18:20:46', '2022-05-12 18:20:46'),
(102, 'SCO-00102', 14121214, '8-9', 58, NULL, NULL, '8-9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 13:34:20', '2022-05-16 13:34:20'),
(103, 'SCO-00103', 14121266, 'Alraboah', 58, NULL, NULL, 'Alraboah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 13:52:41', '2022-05-16 13:52:41'),
(104, 'SCO-00104', 14121211, 'Alfal 7', 56, NULL, NULL, 'Alfal 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 13:56:02', '2022-05-29 19:18:41'),
(105, 'SCO-00105', 14121267, 'Drb Alharamin', 56, NULL, NULL, 'Drb Alharamin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 14:02:19', '2022-05-16 14:02:19'),
(106, 'SCO-00106', 14121268, 'Alfaisalia', 56, NULL, NULL, 'Alfaisalia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 14:06:46', '2022-05-16 14:06:46'),
(107, 'SCO-00107', 14121269, 'Alsalahia', 56, NULL, NULL, 'Alsalahia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 14:10:57', '2022-05-16 14:10:57'),
(108, 'SCO-00108', 14121270, 'Alrawdah', 88, NULL, NULL, 'Alrawdah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-16 14:14:22', '2022-05-16 14:14:22'),
(109, 'SCO-00109', 14121271, 'Alrawda', 56, NULL, NULL, 'Alrawda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:01:34', '2022-05-17 12:01:34'),
(110, 'SCO-00110', 14121272, '230', 88, NULL, NULL, '230', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:39:40', '2022-05-17 12:39:40'),
(111, 'SCO-00111', 14121272, '231', 88, NULL, NULL, '231', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:41:52', '2022-05-17 12:41:52'),
(112, 'SCO-00112', 14121217, '1', 56, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:47:11', '2022-05-17 12:47:11'),
(113, 'SCO-00113', 14121217, '10', 56, NULL, NULL, '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:49:10', '2022-05-17 12:49:10'),
(114, 'SCO-00114', 14121217, '80', 56, NULL, NULL, '80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:50:54', '2022-05-17 12:50:54'),
(115, 'SCO-00115', 14121217, '750', 56, NULL, NULL, '750', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:54:49', '2022-05-17 12:54:49'),
(116, 'SCO-00116', 14121273, 'Alolia', 56, NULL, NULL, 'Alolia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 12:59:23', '2022-05-17 12:59:23'),
(117, 'SCO-00117', 14121274, 'Alwafaa', 56, NULL, NULL, 'Alwafaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 13:07:23', '2022-05-17 13:07:23'),
(118, 'SCO-00118', 14121275, 'Alrawdah', 56, NULL, NULL, 'Alrawdah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 16:17:48', '2022-05-17 16:17:48'),
(119, 'SCO-00119', 14121276, 'Alryan', 58, NULL, NULL, 'Alryan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 16:39:49', '2022-05-17 16:39:49'),
(120, 'SCO-00120', 14121276, '102', 58, NULL, NULL, '102', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 16:40:59', '2022-05-17 16:40:59'),
(121, 'SCO-00121', 14121277, 'Alnahdaa', 56, NULL, NULL, 'Alnahdaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 16:55:58', '2022-05-17 16:55:58'),
(122, 'SCO-00122', 14121278, 'Arab Hospital', 56, NULL, NULL, 'Arab Hospital', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 17:49:51', '2022-05-17 17:49:51'),
(123, 'SCO-00123', 14121279, 'Alrawda', 19, NULL, NULL, 'Alrawda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 17:54:15', '2022-05-17 17:54:15'),
(124, 'SCO-00124', 14121280, '103', 58, NULL, NULL, '103', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 18:03:48', '2022-05-17 18:03:48'),
(125, 'SCO-00125', 14121281, 'Drb Alharamen', 56, NULL, NULL, 'Drb Alharamen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-17 18:11:29', '2022-05-29 19:56:53'),
(126, 'SCO-00126', 14121282, 'Alrahili', 56, NULL, NULL, 'Alrahili', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-18 13:04:33', '2022-05-18 13:04:33'),
(127, 'SCO-00127', 14121272, '227', 88, NULL, NULL, '227', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 16:40:58', '2022-05-24 16:40:58'),
(128, 'SCO-00128', 14121272, '228', 88, NULL, NULL, '228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 16:42:18', '2022-05-24 16:42:18'),
(129, 'SCO-00129', 14121272, '229', 88, NULL, NULL, '229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 16:42:47', '2022-05-24 16:43:58'),
(130, 'SCO-00130', 14121211, 'Aleyman', 56, NULL, NULL, 'Aleyman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 17:30:43', '2022-05-24 17:30:43'),
(131, 'SCO-00131', 14121211, 'Almutamiz', 56, NULL, NULL, 'Almutamiz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 17:32:30', '2022-05-24 17:32:30'),
(132, 'SCO-00132', 14121284, 'Armada', 56, NULL, NULL, 'Armada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 17:37:24', '2022-05-24 17:37:24'),
(133, 'SCO-00133', 14121285, 'Alrahili 8', 56, NULL, NULL, 'Alrahili 8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-24 17:51:03', '2022-05-24 17:51:03'),
(134, 'SCO-00134', 14121286, 'Alfaisalia', 56, NULL, NULL, 'Alfaisalia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-29 19:05:04', '2022-05-29 19:05:04'),
(135, 'SCO-00135', 14121287, 'Almousa', 19, NULL, NULL, 'Almousa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-29 19:09:07', '2022-05-29 19:09:07'),
(136, 'SCO-00136', 14121223, 'Alfal', 56, NULL, NULL, 'Alfal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-29 19:21:29', '2022-05-29 19:21:29'),
(137, 'SCO-00137', 14121288, 'المروة 101', 56, NULL, NULL, 'المروة 101', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-29 19:35:57', '2022-06-12 16:50:24'),
(138, 'SCO-00138', 14121289, 'Alsalamah', 56, NULL, NULL, 'Alsalamah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-29 19:47:57', '2022-05-29 19:47:57'),
(139, 'SCO-00139', 14121290, '110', 56, NULL, NULL, '110', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-05-29 19:53:02', '2022-05-29 19:53:02'),
(140, 'SCO-00140', 14121244, 'الريان3', 58, NULL, NULL, 'الريان3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 15:58:49', '2022-06-12 15:58:49'),
(141, 'SCO-00141', 14121225, 'مدائن الفهد البنيان', 56, NULL, NULL, 'مدائن الفهد البنيان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:01:04', '2022-06-12 16:01:04'),
(142, 'SCO-00142', 14121225, 'النخيل', 56, NULL, NULL, 'النخيل', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:02:50', '2022-06-12 16:02:50'),
(143, 'SCO-00143', 14121293, 'الكهرباء', 58, NULL, NULL, 'الكهرباء', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:06:23', '2022-06-12 16:06:23'),
(144, 'SCO-00144', 14121293, 'النزهه', 58, NULL, NULL, 'النزهه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:07:26', '2022-06-12 16:07:26'),
(145, 'SCO-00145', 14121293, 'المربع الذهبي', 58, NULL, NULL, 'المربع الذهبي', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:08:50', '2022-06-12 16:08:50'),
(146, 'SCO-00146', 14121294, 'الموسى فيو', 19, NULL, NULL, 'الموسى فيو', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:42:59', '2022-06-12 16:42:59'),
(147, 'SCO-00147', 14121295, 'الريان', 88, NULL, NULL, 'الريان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:45:54', '2022-06-12 16:45:54'),
(148, 'SCO-00148', 14121296, 'الريان', 88, NULL, NULL, 'الريان', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:49:11', '2022-06-12 16:49:11'),
(149, 'SCO-00149', 14121288, 'المروة 102', 56, NULL, NULL, 'المروة 102', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 16:51:56', '2022-06-12 16:51:56'),
(150, 'SCO-00150', 14121297, 'النهضه', 56, NULL, NULL, 'النهضه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unsigned', NULL, '2022-06-12 17:05:33', '2022-06-12 17:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `sales_contract_details`
--

CREATE TABLE `sales_contract_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contr_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` double(10,2) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `opc_1_rate` double(10,2) DEFAULT NULL,
  `src_5_rate` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_contract_details`
--

INSERT INTO `sales_contract_details` (`id`, `contr_id`, `product_id`, `quantity`, `rate`, `tax_id`, `tax_rate`, `opc_1_rate`, `src_5_rate`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(2, 2, 3, 1, 2.00, 1, 15.00, 1.00, 1.00, NULL, NULL),
(86, 3, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(194, 4, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(6, 5, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(164, 6, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(8, 7, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(199, 8, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(655, 9, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(666, 10, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(198, 8, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(197, 8, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(196, 8, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(195, 8, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(163, 6, 13, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(162, 6, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(161, 6, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(160, 6, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(654, 9, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(653, 9, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(652, 9, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(651, 9, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(187, 11, 9, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(186, 11, 1, 1, 160.00, 1, 15.00, 160.00, 0.00, NULL, NULL),
(599, 12, 29, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(598, 12, 33, 1, 490.00, 1, 15.00, 240.00, 250.00, NULL, NULL),
(597, 12, 37, 1, 510.00, 1, 15.00, 250.00, 260.00, NULL, NULL),
(596, 12, 2, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(91, 13, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(90, 13, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(89, 13, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(88, 13, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(87, 13, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(156, 14, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(155, 14, 13, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(154, 14, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(153, 14, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(152, 14, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(637, 15, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(636, 15, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(576, 16, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(62, 17, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(550, 18, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(521, 19, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(179, 20, 3, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(177, 21, 3, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(56, 22, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(103, 23, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(549, 18, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(105, 24, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(833, 25, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(107, 26, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(736, 27, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(110, 28, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(656, 29, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(112, 30, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(113, 31, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(114, 32, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(818, 33, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(116, 34, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(117, 35, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(620, 36, 29, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(119, 37, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(170, 38, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(121, 39, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(188, 40, 21, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(511, 41, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(501, 42, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(497, 43, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(844, 44, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(381, 45, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(590, 46, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(351, 47, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(506, 48, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(346, 49, 25, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(405, 50, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(336, 51, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(326, 52, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(165, 53, 81, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(159, 6, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(321, 54, 25, 1, 440.50, 1, 15.00, 215.25, 225.25, NULL, NULL),
(316, 55, 25, 1, 436.00, 1, 15.00, 213.00, 223.00, NULL, NULL),
(609, 56, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(151, 14, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(290, 57, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(275, 58, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(853, 59, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(171, 38, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(172, 38, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(270, 60, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(174, 61, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(832, 25, 25, 1, 2450.00, 1, 15.00, 220.00, 2230.00, NULL, NULL),
(178, 21, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(180, 20, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(285, 62, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(260, 63, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(255, 64, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(244, 65, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(356, 66, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(189, 40, 1, 1, 0.00, 1, 15.00, 0.00, 0.00, NULL, NULL),
(496, 43, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(224, 67, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(205, 68, 17, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(204, 68, 25, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(206, 68, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(207, 68, 9, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(208, 68, 1, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(460, 69, 1, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(459, 69, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(458, 69, 9, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(457, 69, 17, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(456, 69, 25, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(465, 70, 1, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(464, 70, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(463, 70, 9, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(462, 70, 17, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(461, 70, 25, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(455, 71, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(454, 71, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(453, 71, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(452, 71, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(451, 71, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(225, 67, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(226, 67, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(227, 67, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(228, 67, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(440, 72, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(439, 72, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(438, 72, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(437, 72, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(436, 72, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(445, 73, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(444, 73, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(443, 73, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(442, 73, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(441, 73, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(450, 74, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(449, 74, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(448, 74, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(447, 74, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(446, 74, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(245, 65, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(246, 65, 13, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(247, 65, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(248, 65, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(249, 65, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(435, 75, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(434, 75, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(433, 75, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(432, 75, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(431, 75, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(256, 64, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(257, 64, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(258, 64, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(259, 64, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(261, 63, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(262, 63, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(263, 63, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(264, 63, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(430, 76, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(429, 76, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(428, 76, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(427, 76, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(426, 76, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(271, 60, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(272, 60, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(273, 60, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(274, 60, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(276, 58, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(277, 58, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(278, 58, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(279, 58, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(425, 77, 1, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(424, 77, 5, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(423, 77, 9, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(422, 77, 17, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(421, 77, 25, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(286, 62, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(287, 62, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(288, 62, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(289, 62, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(291, 57, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(292, 57, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(293, 57, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(294, 57, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(415, 78, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(414, 78, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(413, 78, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(412, 78, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(411, 78, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(420, 79, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(419, 79, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(418, 79, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(417, 79, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(416, 79, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(608, 56, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(607, 56, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(606, 56, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(605, 56, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(317, 55, 17, 1, 416.00, 1, 15.00, 203.00, 213.00, NULL, NULL),
(318, 55, 9, 1, 396.00, 1, 15.00, 193.00, 203.00, NULL, NULL),
(319, 55, 5, 1, 376.00, 1, 15.00, 183.00, 193.00, NULL, NULL),
(320, 55, 1, 1, 356.00, 1, 15.00, 173.00, 183.00, NULL, NULL),
(322, 54, 17, 1, 420.50, 1, 15.00, 205.25, 215.25, NULL, NULL),
(323, 54, 9, 1, 400.50, 1, 15.00, 195.25, 205.25, NULL, NULL),
(324, 54, 5, 1, 380.50, 1, 15.00, 185.25, 195.25, NULL, NULL),
(325, 54, 1, 1, 360.50, 1, 15.00, 175.25, 185.25, NULL, NULL),
(327, 52, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(328, 52, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(329, 52, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(330, 52, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(410, 80, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(409, 80, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(408, 80, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(407, 80, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(406, 80, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(337, 51, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(338, 51, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(339, 51, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(340, 51, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(404, 50, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(403, 50, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(402, 50, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(401, 50, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(347, 49, 17, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(348, 49, 9, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(349, 49, 5, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(350, 49, 1, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(352, 47, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(353, 47, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(354, 47, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(355, 47, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(357, 66, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(358, 66, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(359, 66, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(360, 66, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(390, 81, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(389, 81, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(388, 81, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(387, 81, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(386, 81, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(395, 82, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(394, 82, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(393, 82, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(392, 82, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(391, 82, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(400, 83, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(399, 83, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(398, 83, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(397, 83, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(396, 83, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(589, 46, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(588, 46, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(587, 46, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(586, 46, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(382, 45, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(383, 45, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(384, 45, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(385, 45, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(466, 84, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(467, 84, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(468, 84, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(469, 84, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(470, 84, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(471, 85, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(472, 85, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(473, 85, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(474, 85, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(475, 85, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(476, 86, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(477, 86, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(478, 86, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(479, 86, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(480, 86, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(540, 87, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(539, 87, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(538, 87, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(537, 87, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(536, 87, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(486, 88, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(487, 88, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(488, 88, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(489, 88, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(490, 88, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(852, 59, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(851, 59, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(850, 59, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(849, 59, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(498, 43, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(499, 43, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(500, 43, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(502, 42, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(503, 42, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(504, 42, 7, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(505, 42, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(507, 48, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(508, 48, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(509, 48, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(510, 48, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(512, 41, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(513, 41, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(514, 41, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(515, 41, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(516, 89, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(517, 89, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(518, 89, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(519, 89, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(520, 89, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(522, 19, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(523, 19, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(524, 19, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(525, 19, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(526, 90, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(527, 90, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(528, 90, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(529, 90, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(530, 90, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(531, 91, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(532, 91, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(533, 91, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(534, 91, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(535, 91, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(548, 18, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(547, 18, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(546, 18, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(551, 92, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(552, 92, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(553, 92, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(554, 92, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(555, 92, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(556, 93, 25, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(557, 93, 17, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(558, 93, 9, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(559, 93, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(560, 93, 1, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(561, 94, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(562, 94, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(563, 94, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(564, 94, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(565, 94, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(566, 95, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(567, 95, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(568, 95, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(569, 95, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(570, 95, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(571, 96, 25, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(572, 96, 17, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(573, 96, 9, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(574, 96, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(575, 96, 1, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(577, 16, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(578, 16, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(579, 16, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(580, 16, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(581, 97, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(582, 97, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(583, 97, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(584, 97, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(585, 97, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(591, 98, 25, 1, 500.00, 1, 15.00, 245.00, 255.00, NULL, NULL),
(592, 98, 17, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(593, 98, 9, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(594, 98, 5, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(595, 98, 1, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(600, 12, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(601, 12, 21, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(602, 12, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(603, 12, 7, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(604, 12, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(610, 99, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(611, 99, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(612, 99, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(613, 99, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(614, 99, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(615, 100, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(616, 100, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(617, 100, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(618, 100, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(619, 100, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(621, 36, 21, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(622, 36, 13, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(623, 36, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(624, 36, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(625, 36, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(626, 36, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(627, 36, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(817, 33, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(816, 33, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(815, 33, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(814, 33, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(813, 33, 13, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(812, 33, 21, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(811, 33, 29, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(638, 15, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(639, 15, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(640, 15, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(641, 101, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(642, 101, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(643, 101, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(644, 101, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(645, 101, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(646, 102, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(647, 102, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(648, 102, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(649, 102, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(650, 102, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(657, 29, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(658, 29, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(659, 29, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(660, 29, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(661, 103, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(662, 103, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(663, 103, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(664, 103, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(665, 103, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(667, 10, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(668, 10, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(669, 10, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(670, 10, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(868, 104, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(867, 104, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(866, 104, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(865, 104, 21, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(864, 104, 29, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(676, 105, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(677, 105, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(678, 105, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(679, 105, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(680, 105, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(681, 106, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(682, 106, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(683, 106, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(684, 106, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(685, 106, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(686, 107, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(687, 107, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(688, 107, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(689, 107, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(690, 107, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(691, 108, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(692, 108, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(693, 108, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(694, 108, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(695, 108, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(696, 109, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(697, 109, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(698, 109, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(699, 109, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(700, 109, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(701, 110, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(702, 110, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(703, 110, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(704, 110, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(705, 110, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(706, 111, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(707, 111, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(708, 111, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(709, 111, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(710, 111, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(711, 112, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(712, 112, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(713, 112, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(714, 112, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(715, 112, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(716, 113, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(717, 113, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(718, 113, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(719, 113, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(720, 113, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(721, 114, 25, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(722, 114, 17, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(723, 114, 9, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(724, 114, 5, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(725, 114, 1, 1, 340.00, 1, 15.00, 165.00, 175.00, NULL, NULL),
(726, 115, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(727, 115, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(728, 115, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(729, 115, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(730, 115, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(731, 116, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(732, 116, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(733, 116, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(734, 116, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(735, 116, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(737, 27, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(738, 27, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(739, 27, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(740, 27, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(741, 117, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(742, 117, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(743, 117, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(744, 117, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(745, 117, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(746, 118, 41, 1, 570.00, 1, 15.00, 280.00, 290.00, NULL, NULL),
(747, 118, 33, 1, 550.00, 1, 15.00, 270.00, 280.00, NULL, NULL),
(748, 119, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(749, 119, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(750, 119, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(751, 119, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(752, 119, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(753, 120, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(754, 120, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(755, 120, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(756, 120, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(757, 120, 1, 1, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(758, 121, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(759, 121, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(760, 121, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(761, 121, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(762, 121, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(763, 122, 21, 1, 510.00, 1, 15.00, 250.00, 260.00, NULL, NULL),
(764, 122, 17, 1, 490.00, 1, 15.00, 240.00, 250.00, NULL, NULL),
(765, 123, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(766, 123, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(767, 123, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(768, 123, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(769, 123, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(770, 124, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(771, 124, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(772, 124, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(773, 124, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(774, 124, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(897, 125, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(896, 125, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(895, 125, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(894, 125, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(893, 125, 21, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(780, 126, 25, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(781, 126, 17, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(782, 126, 9, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(783, 126, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(784, 126, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(785, 127, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(786, 127, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(787, 127, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(788, 127, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(789, 127, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(790, 128, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(791, 128, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(792, 128, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(793, 128, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(794, 128, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(796, 129, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(797, 129, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(798, 129, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(799, 129, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(800, 129, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(831, 25, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(830, 25, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(829, 25, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(819, 130, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(820, 130, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(821, 130, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(822, 130, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(823, 130, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(824, 131, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(825, 131, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(826, 131, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(827, 131, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(828, 131, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(834, 132, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(835, 132, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(836, 132, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(837, 132, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(838, 132, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(839, 133, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(840, 133, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(841, 133, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(842, 133, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(843, 133, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(845, 44, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(846, 44, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(847, 44, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(848, 44, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(854, 134, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(855, 134, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(856, 134, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(857, 134, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(858, 134, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(859, 135, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(860, 135, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(861, 135, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(862, 135, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(863, 135, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(869, 104, 5, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(870, 104, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(871, 136, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(872, 136, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(873, 136, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(874, 136, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(875, 136, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(949, 137, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(948, 137, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(947, 137, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(946, 137, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(945, 137, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(944, 137, 13, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(882, 138, 25, 1, 490.00, 1, 15.00, 240.00, 250.00, NULL, NULL),
(883, 138, 17, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(884, 138, 9, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(885, 138, 5, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(886, 138, 1, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(887, 139, 29, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(888, 139, 25, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(889, 139, 17, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(890, 139, 9, 1, 430.00, 1, 15.00, 205.00, 225.00, NULL, NULL),
(891, 139, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(892, 139, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(898, 125, 1, 1, 360.00, 1, 15.00, 175.00, 185.00, NULL, NULL),
(899, 140, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(900, 140, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(901, 140, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(902, 140, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(903, 140, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(904, 141, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(905, 141, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(906, 141, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(907, 141, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(908, 141, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(909, 142, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(910, 142, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(911, 142, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(912, 142, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(913, 142, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(914, 143, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(915, 143, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(916, 143, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(917, 143, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(918, 143, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(919, 144, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(920, 144, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(921, 144, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(922, 144, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(923, 144, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(924, 145, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(925, 145, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(926, 145, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(927, 145, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(928, 145, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(929, 146, 25, 1, 470.00, 1, 15.00, 230.00, 240.00, NULL, NULL),
(930, 146, 17, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(931, 146, 9, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(932, 146, 5, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(933, 146, 1, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(934, 147, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(935, 147, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(936, 147, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(937, 147, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(938, 147, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(939, 148, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL),
(940, 148, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(941, 148, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(942, 148, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(943, 148, 1, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(950, 149, 25, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(951, 149, 17, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(952, 149, 9, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(953, 149, 5, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL),
(954, 149, 1, 1, 380.00, 1, 15.00, 185.00, 195.00, NULL, NULL),
(955, 150, 25, 1, 480.00, 1, 15.00, 235.00, 245.00, NULL, NULL),
(956, 150, 17, 1, 460.00, 1, 15.00, 225.00, 235.00, NULL, NULL),
(957, 150, 9, 1, 440.00, 1, 15.00, 215.00, 225.00, NULL, NULL),
(958, 150, 5, 1, 420.00, 1, 15.00, 205.00, 215.00, NULL, NULL),
(959, 150, 1, 1, 400.00, 1, 15.00, 195.00, 205.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_estimate`
--

CREATE TABLE `sales_estimate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(120) CHARACTER SET utf8 NOT NULL,
  `related` varchar(120) CHARACTER SET utf8 NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `open_till` date DEFAULT NULL,
  `tags` text CHARACTER SET utf8 DEFAULT NULL,
  `allow_comments` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','sent','open','revised','declined','accepted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(191) CHARACTER SET utf8 NOT NULL,
  `address` text CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `state` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` int(11) NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_total` double(10,2) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `discount_type` enum('fixed','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `grand_tot` double(10,2) DEFAULT NULL,
  `adjustment` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_estimate_product_quantity`
--

CREATE TABLE `sales_estimate_product_quantity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `opc_1_rate` double(10,2) DEFAULT NULL,
  `src_5_rate` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_details`
--

CREATE TABLE `sales_invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_proposal`
--

CREATE TABLE `sales_proposal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `est_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','sent','open','revised','declined','accepted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `tags` text CHARACTER SET utf8 DEFAULT NULL,
  `admin_note` text CHARACTER SET utf8 DEFAULT NULL,
  `client_note` text CHARACTER SET utf8 DEFAULT NULL,
  `terms_n_cond` text CHARACTER SET utf8 DEFAULT NULL,
  `net_total` double(10,2) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `discount_type` enum('fixed','percentage') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `grand_tot` double(10,2) DEFAULT NULL,
  `adjustment` text CHARACTER SET utf8 DEFAULT NULL,
  `billing_street` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `billing_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `billing_state` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `billing_zip` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `billing_country` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `include_shipping` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `shipping_street` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_state` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_zip` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `shipping_country` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_proposal`
--

INSERT INTO `sales_proposal` (`id`, `proposal_id`, `cust_id`, `est_num`, `ref_num`, `status`, `assigned_to`, `date`, `expiry_date`, `tags`, `admin_note`, `client_note`, `terms_n_cond`, `net_total`, `discount`, `discount_type`, `grand_tot`, `adjustment`, `billing_street`, `billing_city`, `billing_state`, `billing_zip`, `billing_country`, `include_shipping`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `created_at`, `updated_at`) VALUES
(1, NULL, 14121174, 'PRO-00001', NULL, 'draft', 88, '2022-04-20', '2022-04-30', NULL, NULL, NULL, NULL, 43010.00, NULL, 'percentage', 43010.00, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '2022-04-20 20:40:48', '2022-04-20 20:40:48'),
(2, NULL, 14121185, 'PRO-00002', NULL, 'declined', 145, '2022-04-21', '2022-04-28', NULL, NULL, NULL, NULL, 448.50, NULL, 'percentage', 448.50, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '2022-04-21 17:57:36', '2022-04-26 17:10:24'),
(3, NULL, 14121207, 'PRO-00003', NULL, 'sent', 145, '2022-04-21', '2022-04-28', NULL, NULL, NULL, NULL, 7072.50, NULL, 'percentage', 7072.50, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '2022-04-21 19:21:37', '2022-04-21 19:21:37'),
(4, NULL, 14121212, 'PRO-00004', NULL, 'sent', 145, '2022-04-21', '2022-04-28', NULL, NULL, NULL, NULL, 7072.50, NULL, 'percentage', 7072.50, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '2022-04-21 19:36:23', '2022-04-21 19:36:23'),
(5, NULL, 14121219, 'PRO-00005', NULL, 'draft', 145, '2022-04-26', '2022-05-03', NULL, NULL, NULL, NULL, 7463.50, NULL, 'percentage', 7463.50, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL, '1', '2022-04-26 17:09:23', '2022-04-26 17:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `sales_proposal_details`
--

CREATE TABLE `sales_proposal_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estimation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_rate` double(10,2) DEFAULT NULL,
  `opc_1_rate` double(10,2) DEFAULT NULL,
  `src_5_rate` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_proposal_details`
--

INSERT INTO `sales_proposal_details` (`id`, `estimation_id`, `product_id`, `quantity`, `rate`, `tax_id`, `tax_rate`, `opc_1_rate`, `src_5_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, 374.00, 1, 15.00, 159.00, 215.00, NULL, NULL),
(2, 2, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(3, 3, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(4, 3, 17, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(5, 3, 9, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(6, 3, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(7, 3, 1, 13, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(8, 4, 1, 13, 350.00, 1, 15.00, 170.00, 180.00, NULL, NULL),
(9, 4, 5, 1, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(10, 4, 13, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(11, 4, 21, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(12, 4, 25, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(13, 5, 1, 13, 370.00, 1, 15.00, 180.00, 190.00, NULL, NULL),
(14, 5, 5, 1, 390.00, 1, 15.00, 190.00, 200.00, NULL, NULL),
(15, 5, 9, 1, 410.00, 1, 15.00, 200.00, 210.00, NULL, NULL),
(16, 5, 17, 1, 430.00, 1, 15.00, 210.00, 220.00, NULL, NULL),
(17, 5, 25, 1, 450.00, 1, 15.00, 220.00, 230.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_setting`
--

CREATE TABLE `site_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_with_workflow` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1-With Workflow , 0-Without Work Flow',
  `purchase_with_workflow` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1-With Workflow , 0-Without Work Flow',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_setting`
--

INSERT INTO `site_setting` (`id`, `sales_with_workflow`, `purchase_with_workflow`, `created_at`, `updated_at`) VALUES
(1, '0', '0', NULL, '2021-11-27 15:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `stock_received_docket_detail`
--

CREATE TABLE `stock_received_docket_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `comm_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double(10,2) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `goods_amount` double(10,2) NOT NULL,
  `tax_amount` double(10,2) NOT NULL,
  `lot_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacture_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_order`
--

CREATE TABLE `supply_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `order_no` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `vechicle_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Delivered') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `assignee_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `time` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jobcard_no` int(11) NOT NULL,
  `door_no` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `km_count` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hours_meter` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complaint` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supply_order`
--

INSERT INTO `supply_order` (`id`, `dept_id`, `order_no`, `delivery_date`, `vechicle_id`, `status`, `note`, `assignee_id`, `created_date`, `time`, `jobcard_no`, `door_no`, `km_count`, `hours_meter`, `complaint`, `diagnosis`, `action`, `remark`, `created_at`, `updated_at`) VALUES
(1, 10, 'SUP-00001', '2022-05-19', 1, 'Delivered', 'heat', 0, '0000-00-00', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-17 19:19:05', '2022-05-17 19:19:36'),
(2, 10, 'SUP-00002', '2022-06-15', 1, 'Delivered', 'Note *', 0, '0000-00-00', '20:20', 3062, '123', '111', '0', 'Complaint', 'Diagnosis', 'Actions *', '4', '2022-05-27 21:53:27', '2022-06-08 15:13:17'),
(3, 10, 'SUP-00003', NULL, 2, 'Pending', '0', 0, '0000-00-00', '12:13', 8811, '102', '12000', NULL, '0', '0', '0', NULL, '2022-06-08 15:14:23', '2022-06-08 15:14:23'),
(4, 10, 'SUP-00004', '2022-06-12', 1, 'Delivered', 'dfgfd', 0, '0000-00-00', '15:16', 9225, 'M101', '102222', '5', 'fkjh dslfh dsfjh sdfjh jdsfh', 'fnds fndf dfdlkjf dflj dslkfjsdlk', 'fgfdgfdg', 'dgfdgdfg fggdfgn df,gmfg fgmdf', '2022-06-11 19:18:09', '2022-06-11 19:19:39'),
(5, 10, 'SUP-00005', NULL, 20, 'Delivered', 'nill', 0, '0000-00-00', '13:30', 3533, '127', '285545', NULL, 'water leak', 'water pump damage', 'need to change water pump', NULL, '2022-06-16 17:32:33', '2022-06-16 17:32:54'),
(6, 10, 'SUP-00006', NULL, 1, 'Pending', 'sdfds', 0, '0000-00-00', '06:18', 1753, 'M101', '200000', NULL, 'snd saldkj saldkj salkdjas', 'asdasdas', 'asdsad', NULL, '2022-06-22 00:20:07', '2022-06-22 00:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tax_rate` double(10,2) NOT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `tax_rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'VAT', 15.00, '1', '2021-04-02 18:26:08', '2021-04-02 18:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `type` enum('credit','debit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'credit',
  `pay_method_id` int(11) DEFAULT NULL,
  `pay_date` date NOT NULL,
  `trans_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `dept_id`, `invoice_id`, `user_id`, `contract_id`, `order_id`, `amount`, `type`, `pay_method_id`, `pay_date`, `trans_no`, `note`, `is_show`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 14121185, 2, 1, 115.00, 'debit', NULL, '2022-02-16', NULL, NULL, NULL, '2022-02-16 05:03:27', '2022-02-16 05:03:27', NULL),
(2, NULL, NULL, 14121178, 3, 2, 9200.00, 'debit', NULL, '2022-02-16', NULL, NULL, NULL, '2022-02-16 22:36:17', '2022-02-16 22:36:17', NULL),
(3, NULL, NULL, 14121185, 2, 3, 230.00, 'debit', NULL, '2022-02-22', NULL, NULL, NULL, '2022-02-22 18:57:21', '2022-02-22 18:57:21', NULL),
(4, NULL, NULL, 14121185, 2, 4, 69.00, 'debit', NULL, '2022-02-22', NULL, NULL, NULL, '2022-02-22 20:34:53', '2022-02-22 20:34:53', NULL),
(5, NULL, NULL, 14121174, 11, 5, 0.00, 'debit', NULL, '2022-02-22', NULL, NULL, NULL, '2022-02-22 20:50:53', '2022-02-22 20:50:53', NULL),
(6, NULL, NULL, 14121174, 11, 6, 4600.00, 'debit', NULL, '2022-02-22', NULL, NULL, NULL, '2022-02-22 23:59:05', '2022-02-22 23:59:05', NULL),
(7, NULL, NULL, 14121185, 1, 7, 0.00, 'debit', NULL, '2022-02-23', NULL, NULL, NULL, '2022-02-23 23:57:48', '2022-02-23 23:57:48', NULL),
(8, NULL, NULL, 14121185, 1, 8, 0.00, 'debit', NULL, '2022-02-23', NULL, NULL, NULL, '2022-02-24 00:14:57', '2022-02-24 00:14:57', NULL),
(9, NULL, NULL, 14121185, 2, 9, 6.90, 'debit', NULL, '2022-02-23', NULL, NULL, NULL, '2022-02-24 00:34:18', '2022-02-24 00:34:18', NULL),
(10, NULL, NULL, 14121185, 10, 10, 0.00, 'debit', NULL, '2022-02-23', NULL, NULL, NULL, '2022-02-24 00:47:27', '2022-02-24 00:47:27', NULL),
(11, NULL, NULL, 14121185, 10, 11, 0.00, 'debit', NULL, '2022-02-23', NULL, NULL, NULL, '2022-02-24 03:34:07', '2022-02-24 03:34:07', NULL),
(12, NULL, NULL, 14121185, 10, 12, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 06:16:14', '2022-02-24 06:16:14', NULL),
(13, NULL, NULL, 14121186, 15, 13, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 07:56:06', '2022-02-24 07:56:06', NULL),
(14, NULL, NULL, 14121185, 1, 14, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 16:22:31', '2022-02-24 16:22:31', NULL),
(15, NULL, NULL, 14121185, 10, 15, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 16:26:08', '2022-02-24 16:26:08', NULL),
(16, NULL, NULL, 14121185, 10, 16, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 16:47:55', '2022-02-24 16:47:55', NULL),
(17, NULL, NULL, 14121185, 10, 17, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 17:15:28', '2022-02-24 17:15:28', NULL),
(18, NULL, NULL, 14121185, 10, 18, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 17:18:34', '2022-02-24 17:18:34', NULL),
(19, NULL, NULL, 14121185, 2, 19, 34.50, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 17:27:16', '2022-02-24 17:27:16', NULL),
(20, NULL, NULL, 14121185, 10, 20, 0.00, 'debit', NULL, '2022-02-24', NULL, NULL, NULL, '2022-02-24 22:42:25', '2022-02-24 22:42:25', NULL),
(21, NULL, NULL, 14121185, 1, 21, 0.00, 'debit', NULL, '2022-02-25', NULL, NULL, NULL, '2022-02-25 05:05:02', '2022-02-25 05:05:02', NULL),
(22, NULL, NULL, 14121174, 11, 22, 46000.00, 'debit', NULL, '2022-03-07', NULL, NULL, NULL, '2022-03-07 11:21:54', '2022-03-07 11:21:54', NULL),
(23, NULL, NULL, 14121174, 11, 23, 8970.00, 'debit', NULL, '2022-03-08', NULL, NULL, NULL, '2022-03-08 22:23:09', '2022-03-08 22:23:09', NULL),
(24, NULL, NULL, 14121235, 49, 24, 4485.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 18:30:12', '2022-03-09 18:30:12', NULL),
(25, NULL, NULL, 14121236, 50, 25, 87400.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 18:38:57', '2022-03-09 18:38:57', NULL),
(26, NULL, NULL, 14121237, 51, 26, 98072.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 18:55:59', '2022-03-09 18:55:59', NULL),
(27, NULL, NULL, 14121238, 52, 27, 48300.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 19:02:45', '2022-03-09 19:02:45', NULL),
(28, NULL, NULL, 14121175, 53, 28, 132250.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 19:16:15', '2022-03-09 19:16:15', NULL),
(29, NULL, NULL, 14121180, 6, 29, 30360.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 19:27:19', '2022-03-09 19:27:19', NULL),
(30, NULL, NULL, 14121239, 54, 30, 23000.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 19:33:19', '2022-03-09 19:33:19', NULL),
(31, NULL, NULL, 14121241, 55, 31, 9439.20, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 19:47:37', '2022-03-09 19:47:37', NULL),
(32, NULL, NULL, 14121244, 56, 32, 67275.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 19:53:52', '2022-03-09 19:53:52', NULL),
(33, NULL, NULL, 14121177, 14, 33, 146740.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:03:13', '2022-03-09 20:03:13', NULL),
(34, NULL, NULL, 14121245, 57, 34, 9200.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:11:27', '2022-03-09 20:11:27', NULL),
(35, NULL, NULL, 14121246, 58, 35, 11500.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:14:28', '2022-03-09 20:14:28', NULL),
(36, NULL, NULL, 14121228, 59, 36, 21160.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:21:15', '2022-03-09 20:21:15', NULL),
(37, NULL, NULL, 14121219, 38, 37, 15870.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:26:16', '2022-03-09 20:26:16', NULL),
(38, NULL, NULL, 14121219, 38, 38, 59800.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:27:09', '2022-03-09 20:27:09', NULL),
(39, NULL, NULL, 14121247, 60, 39, 58305.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:31:25', '2022-03-09 20:31:25', NULL),
(40, NULL, NULL, 14121178, 61, 40, 69000.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:44:26', '2022-03-09 20:44:26', NULL),
(41, NULL, NULL, 14121211, 25, 41, 5566.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:46:57', '2022-03-09 20:46:57', NULL),
(42, NULL, NULL, 14121210, 20, 42, 23.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:54:28', '2022-03-09 20:54:28', NULL),
(43, NULL, NULL, 14121210, 21, 43, 23.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 20:55:10', '2022-03-09 20:55:10', NULL),
(44, NULL, NULL, 14121245, 62, 44, 58305.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 21:00:41', '2022-03-09 21:00:41', NULL),
(45, NULL, NULL, 14121219, 38, 45, 59800.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 21:03:07', '2022-03-09 21:03:07', NULL),
(46, NULL, NULL, 14121248, 63, 46, 41400.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 21:07:02', '2022-03-09 21:07:02', NULL),
(47, NULL, NULL, 14121249, 64, 47, 8073.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 21:10:16', '2022-03-09 21:10:16', NULL),
(48, NULL, NULL, 14121234, 66, 48, 8970.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-09 21:21:31', '2022-03-09 21:21:31', NULL),
(49, NULL, NULL, 14121174, 11, 49, 89700.00, 'debit', NULL, '2022-03-09', NULL, NULL, NULL, '2022-03-10 00:14:55', '2022-03-10 00:14:55', NULL),
(50, NULL, NULL, 14121224, 40, 50, 233266.00, 'debit', NULL, '2022-03-10', NULL, NULL, NULL, '2022-03-10 21:56:43', '2022-03-10 21:56:43', NULL),
(51, NULL, NULL, 14121227, 43, 51, 105800.00, 'debit', NULL, '2022-03-14', NULL, NULL, NULL, '2022-03-14 17:44:21', '2022-03-14 17:44:21', NULL),
(52, NULL, NULL, 14121251, 67, 52, 448.50, 'debit', NULL, '2022-03-14', NULL, NULL, NULL, '2022-03-14 18:19:00', '2022-03-14 18:19:00', NULL),
(53, NULL, NULL, 14121174, 11, 53, 11212.50, 'debit', NULL, '2022-03-14', NULL, NULL, NULL, '2022-03-14 19:10:51', '2022-03-14 19:10:51', NULL),
(54, NULL, NULL, 14121174, 11, 54, 11212.50, 'debit', NULL, '2022-03-14', NULL, NULL, NULL, '2022-03-14 21:05:10', '2022-03-14 21:05:10', NULL),
(55, NULL, NULL, 14121174, 11, 55, 9867.00, 'debit', NULL, '2022-03-16', NULL, NULL, NULL, '2022-03-16 04:41:35', '2022-03-16 04:41:35', NULL),
(56, NULL, NULL, 14121174, 11, 56, 9867.00, 'debit', NULL, '2022-03-16', NULL, NULL, NULL, '2022-03-16 04:43:27', '2022-03-16 04:43:27', NULL),
(57, NULL, NULL, 14121174, 11, 57, 9867.00, 'debit', NULL, '2022-03-16', NULL, NULL, NULL, '2022-03-16 23:10:50', '2022-03-16 23:10:50', NULL),
(58, NULL, NULL, 14121174, 11, 58, 7624.50, 'debit', NULL, '2022-03-16', NULL, NULL, NULL, '2022-03-17 01:08:36', '2022-03-17 01:08:36', NULL),
(59, NULL, NULL, 14121174, 11, 59, 0.00, 'debit', NULL, '2022-03-16', NULL, NULL, NULL, '2022-03-17 03:23:56', '2022-03-17 03:23:56', NULL),
(60, NULL, NULL, 14121174, 11, 60, 112125.00, 'debit', NULL, '2022-03-17', NULL, NULL, NULL, '2022-03-17 15:34:32', '2022-03-17 15:34:32', NULL),
(61, NULL, NULL, 14121176, 13, 61, 0.00, 'debit', NULL, '2022-03-17', NULL, NULL, NULL, '2022-03-17 15:43:08', '2022-03-17 15:43:08', NULL),
(62, NULL, NULL, 14121174, 11, 62, 9867.00, 'debit', NULL, '2022-03-17', NULL, NULL, NULL, '2022-03-17 16:29:47', '2022-03-17 16:29:47', NULL),
(63, NULL, NULL, 14121174, 11, 63, 9867.00, 'debit', NULL, '2022-03-17', NULL, NULL, NULL, '2022-03-17 17:53:21', '2022-03-17 17:53:21', NULL),
(64, NULL, NULL, 14121180, 5, 64, 0.00, 'debit', NULL, '2022-03-17', NULL, NULL, NULL, '2022-03-17 19:54:51', '2022-03-17 19:54:51', NULL),
(65, NULL, NULL, 14121174, 11, 65, 9867.00, 'debit', NULL, '2022-03-17', NULL, NULL, NULL, '2022-03-18 03:08:56', '2022-03-18 03:08:56', NULL),
(66, NULL, NULL, 14121175, 53, 66, 529.00, 'debit', NULL, '2022-03-20', NULL, NULL, NULL, '2022-03-20 18:37:16', '2022-03-20 18:37:16', NULL),
(67, NULL, NULL, 14121179, 9, 67, 13225.00, 'debit', NULL, '2022-03-20', NULL, NULL, NULL, '2022-03-20 18:40:28', '2022-03-20 18:40:28', NULL),
(68, NULL, NULL, 14121174, 11, 68, 8970.00, 'debit', NULL, '2022-03-20', NULL, NULL, NULL, '2022-03-20 20:27:42', '2022-03-20 20:27:42', NULL),
(69, NULL, NULL, 14121175, 53, 69, 15870.00, 'debit', NULL, '2022-03-20', NULL, NULL, NULL, '2022-03-20 20:53:42', '2022-03-20 20:53:42', NULL),
(70, NULL, NULL, 14121180, 5, 70, 0.00, 'debit', NULL, '2022-03-20', NULL, NULL, NULL, '2022-03-20 21:16:12', '2022-03-20 21:16:12', NULL),
(71, NULL, NULL, 14121176, 13, 71, 0.00, 'debit', NULL, '2022-03-22', NULL, NULL, NULL, '2022-03-22 14:58:30', '2022-03-22 14:58:30', NULL),
(72, NULL, NULL, 14121174, 11, 72, 9867.00, 'debit', NULL, '2022-03-23', NULL, NULL, NULL, '2022-03-23 23:43:14', '2022-03-23 23:43:14', NULL),
(73, NULL, NULL, 14121176, 13, 73, 22425.00, 'debit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 16:28:01', '2022-03-26 16:28:01', NULL),
(74, NULL, NULL, 14121180, 6, 74, 529.00, 'debit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 20:30:12', '2022-03-26 20:30:12', NULL),
(75, NULL, NULL, 14121180, 6, 74, 529.00, 'credit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 20:30:48', '2022-03-26 20:30:48', NULL),
(76, NULL, NULL, 14121180, 6, 74, 26450.00, 'debit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 20:30:48', '2022-03-26 20:30:48', NULL),
(77, NULL, NULL, 14121180, 6, 74, 26450.00, 'credit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 20:31:20', '2022-03-26 20:31:20', NULL),
(78, NULL, NULL, 14121180, 6, 74, 7935.00, 'debit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 20:31:20', '2022-03-26 20:31:20', NULL),
(79, NULL, NULL, 14121177, 14, 75, 11212.50, 'debit', NULL, '2022-03-26', NULL, NULL, NULL, '2022-03-26 20:35:48', '2022-03-26 20:35:48', NULL),
(80, NULL, NULL, 14121174, 11, 76, 0.00, 'debit', NULL, '2022-03-27', NULL, NULL, NULL, '2022-03-27 22:53:05', '2022-03-27 22:53:05', NULL),
(81, NULL, NULL, 14121185, 1, 77, 0.00, 'debit', NULL, '2022-03-28', NULL, NULL, NULL, '2022-03-28 17:26:39', '2022-03-28 17:26:39', NULL),
(82, NULL, NULL, 14121176, 13, 78, 0.00, 'debit', NULL, '2022-03-28', NULL, NULL, NULL, '2022-03-28 19:32:48', '2022-03-28 19:32:48', NULL),
(83, NULL, NULL, 14121235, 49, 79, 448.50, 'debit', NULL, '2022-03-28', NULL, NULL, NULL, '2022-03-28 19:33:33', '2022-03-28 19:33:33', NULL),
(84, NULL, NULL, 14121175, 53, 80, 529.00, 'debit', NULL, '2022-03-29', NULL, NULL, NULL, '2022-03-29 20:47:46', '2022-03-29 20:47:46', NULL),
(85, NULL, NULL, 14121178, 3, 81, 36800.00, 'debit', NULL, '2022-03-29', NULL, NULL, NULL, '2022-03-29 20:52:11', '2022-03-29 20:52:11', NULL),
(86, NULL, NULL, 14121174, 11, 82, 13455.00, 'debit', NULL, '2022-03-29', NULL, NULL, NULL, '2022-03-29 21:06:21', '2022-03-29 21:06:21', NULL),
(87, NULL, NULL, 14121174, 11, 83, 13455.00, 'debit', NULL, '2022-04-09', NULL, NULL, NULL, '2022-04-09 10:33:25', '2022-04-09 10:33:25', NULL),
(88, NULL, NULL, 14121174, 11, 84, 6279.00, 'debit', NULL, '2022-04-09', NULL, NULL, NULL, '2022-04-09 21:09:20', '2022-04-09 21:09:20', NULL),
(89, NULL, NULL, 14121176, 13, 85, 0.00, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 04:09:11', '2022-04-10 04:09:11', NULL),
(90, NULL, NULL, 14121174, 11, 86, 448.50, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 16:27:40', '2022-04-10 16:27:40', NULL),
(91, NULL, NULL, 14121176, 13, 87, 0.00, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 16:30:41', '2022-04-10 16:30:41', NULL),
(92, NULL, NULL, 14121175, 53, 88, 529.00, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 16:35:48', '2022-04-10 16:35:48', NULL),
(93, NULL, NULL, 14121185, 1, 89, 0.00, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 16:43:20', '2022-04-10 16:43:20', NULL),
(94, NULL, NULL, 14121174, 11, 90, 6727.50, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 17:07:04', '2022-04-10 17:07:04', NULL),
(95, NULL, NULL, 14121214, 29, 91, 0.00, 'debit', NULL, '2022-04-10', NULL, NULL, NULL, '2022-04-10 18:21:51', '2022-04-10 18:21:51', NULL),
(96, NULL, NULL, 14121174, 11, 92, 7176.00, 'debit', NULL, '2022-04-11', NULL, NULL, NULL, '2022-04-11 16:15:09', '2022-04-11 16:15:09', NULL),
(97, NULL, NULL, 14121214, 29, 93, 0.00, 'debit', NULL, '2022-04-11', NULL, NULL, NULL, '2022-04-11 16:41:24', '2022-04-11 16:41:24', NULL),
(98, NULL, NULL, 14121174, 11, 94, 0.00, 'debit', NULL, '2022-04-11', NULL, NULL, NULL, '2022-04-11 17:26:08', '2022-04-11 17:26:08', NULL),
(99, NULL, NULL, 14121174, 11, 95, 0.00, 'debit', NULL, '2022-04-11', NULL, NULL, NULL, '2022-04-12 01:23:56', '2022-04-12 01:23:56', NULL),
(100, NULL, NULL, 14121176, 13, 96, 23000.00, 'debit', NULL, '2022-04-12', NULL, NULL, NULL, '2022-04-12 07:24:57', '2022-04-12 07:24:57', NULL),
(101, NULL, NULL, 14121174, 11, 97, 0.00, 'debit', NULL, '2022-04-12', NULL, NULL, NULL, '2022-04-13 00:19:13', '2022-04-13 00:19:13', NULL),
(102, NULL, NULL, 14121181, 4, 98, 0.00, 'debit', NULL, '2022-04-14', NULL, NULL, NULL, '2022-04-14 04:19:43', '2022-04-14 04:19:43', NULL),
(103, NULL, NULL, 14121175, 53, 99, 13225.00, 'debit', NULL, '2022-04-14', NULL, NULL, NULL, '2022-04-14 04:20:10', '2022-04-14 04:20:10', NULL),
(104, NULL, NULL, 14121176, 13, 100, 0.00, 'debit', NULL, '2022-04-19', NULL, NULL, NULL, '2022-04-19 17:14:22', '2022-04-19 17:14:22', NULL),
(105, NULL, NULL, 14121236, 50, 101, 64400.00, 'debit', NULL, '2022-04-19', NULL, NULL, NULL, '2022-04-19 18:01:26', '2022-04-19 18:01:26', NULL),
(106, NULL, NULL, 14121236, 50, 102, 7360.00, 'debit', NULL, '2022-04-22', NULL, NULL, NULL, '2022-04-22 22:01:55', '2022-04-22 22:01:55', NULL),
(107, NULL, NULL, 14121218, 37, 103, 0.00, 'debit', NULL, '2022-04-22', NULL, NULL, NULL, '2022-04-22 22:03:30', '2022-04-22 22:03:30', NULL),
(108, NULL, NULL, 14121236, 50, 104, 64400.00, 'debit', NULL, '2022-04-26', NULL, NULL, NULL, '2022-04-26 05:40:40', '2022-04-26 05:40:40', NULL),
(109, NULL, NULL, 14121236, 50, 105, 64400.00, 'debit', NULL, '2022-04-26', NULL, NULL, NULL, '2022-04-26 05:40:41', '2022-04-26 05:40:41', NULL),
(110, NULL, NULL, 14121181, 4, 106, 0.00, 'debit', NULL, '2022-04-26', NULL, NULL, NULL, '2022-04-26 05:42:32', '2022-04-26 05:42:32', NULL),
(111, NULL, NULL, 14121217, 36, 107, 0.00, 'debit', NULL, '2022-04-26', NULL, NULL, NULL, '2022-04-26 05:45:47', '2022-04-26 05:45:47', NULL),
(112, NULL, NULL, 14121210, 20, 108, 115.00, 'debit', NULL, '2022-05-10', NULL, NULL, NULL, '2022-05-10 19:44:28', '2022-05-10 19:44:28', NULL),
(113, NULL, NULL, 14121226, 42, 109, 0.00, 'debit', NULL, '2022-05-10', NULL, NULL, NULL, '2022-05-10 19:50:25', '2022-05-10 19:50:25', NULL),
(114, NULL, NULL, 14121226, 42, 110, 0.00, 'debit', NULL, '2022-05-10', NULL, NULL, NULL, '2022-05-10 19:50:26', '2022-05-10 19:50:26', NULL),
(115, NULL, NULL, 14121236, 50, 111, 9200.00, 'debit', NULL, '2022-05-10', NULL, NULL, NULL, '2022-05-10 19:51:12', '2022-05-10 19:51:12', NULL),
(116, NULL, NULL, 14121227, 43, 112, 96600.00, 'debit', NULL, '2022-05-10', NULL, NULL, NULL, '2022-05-10 19:52:24', '2022-05-10 19:52:24', NULL),
(117, NULL, NULL, 14121218, 37, 113, 0.00, 'debit', NULL, '2022-05-10', NULL, NULL, NULL, '2022-05-10 19:54:00', '2022-05-10 19:54:00', NULL),
(118, NULL, NULL, 14121222, 90, 114, 67275.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:07:44', '2022-05-12 18:07:44', NULL),
(119, NULL, NULL, 14121179, 26, 115, 0.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:08:51', '2022-05-12 18:08:51', NULL),
(120, NULL, NULL, 14121256, 91, 116, 529.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:09:41', '2022-05-12 18:09:41', NULL),
(121, NULL, NULL, 14121251, 67, 117, 67275.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:10:27', '2022-05-12 18:10:27', NULL),
(122, NULL, NULL, 14121251, 67, 118, 67275.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:11:05', '2022-05-12 18:11:05', NULL),
(123, NULL, NULL, 14121231, 87, 119, 52900.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:12:50', '2022-05-12 18:12:50', NULL),
(124, NULL, NULL, 14121257, 92, 120, 50600.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:13:26', '2022-05-12 18:13:26', NULL),
(125, NULL, NULL, 14121257, 92, 121, 50600.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:13:32', '2022-05-12 18:13:32', NULL),
(126, NULL, NULL, 14121259, 94, 122, 0.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:15:07', '2022-05-12 18:15:07', NULL),
(127, NULL, NULL, 14121253, 69, 123, 18400.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:15:55', '2022-05-12 18:15:55', NULL),
(128, NULL, NULL, 14121206, 16, 124, 0.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:16:32', '2022-05-12 18:16:32', NULL),
(129, NULL, NULL, 14121262, 97, 125, 6877.00, 'debit', NULL, '2022-05-12', NULL, NULL, NULL, '2022-05-12 18:18:42', '2022-05-12 18:18:42', NULL),
(130, NULL, NULL, 14121259, 94, 126, 92000.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:12:09', '2022-05-16 15:12:09', NULL),
(131, NULL, NULL, 14121214, 102, 127, 460.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:17:06', '2022-05-16 15:17:06', NULL),
(132, NULL, NULL, 14121233, 46, 128, 12167.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:18:05', '2022-05-16 15:18:05', NULL),
(133, NULL, NULL, 14121227, 43, 129, 18400.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:18:46', '2022-05-16 15:18:46', NULL),
(134, NULL, NULL, 14121180, 6, 130, 82800.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:19:38', '2022-05-16 15:19:38', NULL),
(135, NULL, NULL, 14121180, 6, 131, 82800.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:19:39', '2022-05-16 15:19:39', NULL),
(136, NULL, NULL, 14121179, 9, 132, 52900.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:20:23', '2022-05-16 15:20:23', NULL),
(137, NULL, NULL, 14121214, 29, 133, 46000.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:21:49', '2022-05-16 15:21:49', NULL),
(138, NULL, NULL, 14121175, 12, 134, 140875.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:22:42', '2022-05-16 15:22:42', NULL),
(139, NULL, NULL, 14121266, 103, 135, 20700.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:23:33', '2022-05-16 15:23:33', NULL),
(140, NULL, NULL, 14121185, 10, 136, 55200.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:24:10', '2022-05-16 15:24:10', NULL),
(141, NULL, NULL, 14121211, 104, 137, 26450.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:25:05', '2022-05-16 15:25:05', NULL),
(142, NULL, NULL, 14121267, 105, 138, 13800.00, 'debit', NULL, '2022-05-16', NULL, NULL, NULL, '2022-05-16 15:26:51', '2022-05-16 15:26:51', NULL),
(143, NULL, NULL, 14121176, 13, 139, 43700.00, 'debit', NULL, '2022-05-17', NULL, NULL, NULL, '2022-05-17 18:05:39', '2022-05-17 18:05:39', NULL),
(144, NULL, NULL, 14121175, 12, 140, 56350.00, 'debit', NULL, '2022-05-17', NULL, NULL, NULL, '2022-05-17 18:08:39', '2022-05-17 18:08:39', NULL),
(145, NULL, NULL, 14121262, 97, 141, 89930.00, 'debit', NULL, '2022-05-17', NULL, NULL, NULL, '2022-05-17 18:25:51', '2022-05-17 18:25:51', NULL),
(146, NULL, NULL, 14121174, 11, 142, 6900.00, 'debit', NULL, '2022-05-19', NULL, NULL, NULL, '2022-05-20 00:22:32', '2022-05-20 00:22:32', NULL),
(147, NULL, NULL, 14121174, 11, 143, 23000.00, 'debit', NULL, '2022-05-21', NULL, NULL, NULL, '2022-05-22 02:28:58', '2022-05-22 02:28:58', NULL),
(148, 10, NULL, 14121283, NULL, 1, 200.00, 'credit', NULL, '2022-05-23', NULL, NULL, NULL, '2022-05-23 20:33:47', '2022-05-23 20:33:47', NULL),
(149, NULL, NULL, 14121272, 111, 144, 19044.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:23:50', '2022-05-24 16:23:50', NULL),
(150, NULL, NULL, 14121272, 110, 145, 105800.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:32:19', '2022-05-24 16:32:19', NULL),
(151, NULL, NULL, 14121272, 110, 146, 529.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:33:52', '2022-05-24 16:33:52', NULL),
(152, NULL, NULL, 14121263, 98, 147, 42320.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:36:35', '2022-05-24 16:36:35', NULL),
(153, NULL, NULL, 14121176, 13, 148, 97980.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:38:35', '2022-05-24 16:38:35', NULL),
(154, NULL, NULL, 14121271, 109, 149, 12420.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:39:16', '2022-05-24 16:39:16', NULL),
(155, NULL, NULL, 14121211, 33, 150, 14283.00, 'debit', NULL, '2022-05-24', NULL, NULL, NULL, '2022-05-24 16:41:04', '2022-05-24 16:41:04', NULL),
(156, 10, NULL, 14121283, NULL, 2, 90.00, 'credit', NULL, '2022-05-27', NULL, NULL, NULL, '2022-05-27 21:52:57', '2022-05-27 21:52:57', NULL),
(157, NULL, NULL, 14121236, 50, 151, 6900.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 18:51:04', '2022-05-29 18:51:04', NULL),
(158, NULL, NULL, 14121227, 43, 152, 96600.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 18:51:46', '2022-05-29 18:51:46', NULL),
(159, NULL, NULL, 14121251, 67, 153, 73600.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 18:52:46', '2022-05-29 18:52:46', NULL),
(160, NULL, NULL, 14121251, 67, 154, 73600.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 18:52:47', '2022-05-29 18:52:47', NULL),
(161, NULL, NULL, 14121211, 104, 155, 264500.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 18:56:13', '2022-05-29 18:56:13', NULL),
(162, NULL, NULL, 14121259, 94, 156, 23805.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 18:57:08', '2022-05-29 18:57:08', NULL),
(163, NULL, NULL, 14121209, 18, 157, 11040.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 19:07:18', '2022-05-29 19:07:18', NULL),
(164, NULL, NULL, 14121281, 125, 158, 32200.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 19:10:14', '2022-05-29 19:10:14', NULL),
(165, NULL, NULL, 14121252, 71, 159, 16100.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 19:11:13', '2022-05-29 19:11:13', NULL),
(166, NULL, NULL, 14121276, 120, 160, 460.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 19:11:57', '2022-05-29 19:11:57', NULL),
(167, NULL, NULL, 14121287, 135, 161, 18400.00, 'debit', NULL, '2022-05-29', NULL, NULL, NULL, '2022-05-29 19:13:14', '2022-05-29 19:13:14', NULL),
(168, 10, NULL, 14121283, NULL, 3, 100.00, 'credit', NULL, '2022-06-03', NULL, NULL, NULL, '2022-06-04 02:55:42', '2022-06-04 02:55:42', NULL),
(169, 10, NULL, 14121283, NULL, 4, 500.00, 'credit', NULL, '2022-06-11', NULL, NULL, NULL, '2022-06-11 19:13:06', '2022-06-11 19:13:06', NULL),
(170, 10, NULL, 14121283, NULL, 5, 100.00, 'credit', NULL, '2022-06-21', NULL, NULL, NULL, '2022-06-22 00:25:23', '2022-06-22 00:25:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_to_id` int(11) DEFAULT NULL,
  `source_of_hire` enum('direct','referrel','web','newspaper','advertisement') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `confirm_date` date DEFAULT NULL,
  `status` enum('active','terminated','deceased','resigned') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_type` enum('permanant','on-contract','temporary','trainee') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) NOT NULL DEFAULT 1,
  `postal_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` enum('single','married','divorcee') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `driving_licence` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `pay_overtime` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `initial_trip` int(11) NOT NULL,
  `initial_rate` int(11) NOT NULL,
  `additional_trip` int(11) NOT NULL,
  `additional_rate` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_id`, `first_name`, `last_name`, `email`, `role_id`, `department_id`, `mobile_no`, `report_to_id`, `source_of_hire`, `designation_id`, `join_date`, `confirm_date`, `status`, `emp_type`, `profile_image`, `address`, `city`, `state`, `country_id`, `postal_code`, `dob`, `marital_status`, `gender`, `email_token`, `email_verified_at`, `password`, `is_active`, `driving_licence`, `remember_token`, `id_number`, `nationality_id`, `pay_overtime`, `initial_trip`, `initial_rate`, `additional_trip`, `additional_rate`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin', 'Panel', 'admin@webtech.com', 1, 1000, '8888888888', NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, NULL, NULL),
(168, '259', 'يحيى إدريس', 'Yahya Idris', NULL, 56, 9, NULL, 254, 'direct', 55, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(161, '154', 'عثمان عبدالله', 'Osman Abdullah', NULL, 52, 5, NULL, 254, 'direct', 51, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(162, '156', 'محمد محمود', 'Mohamed Mahmoud', NULL, 46, 5, NULL, 254, 'direct', 45, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(163, '157', 'عيسى محمد', 'Issa Muhammad', NULL, 53, 9, NULL, 1, 'direct', 52, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(164, '161', 'إدريس أول', 'Idris Owl', NULL, 46, 5, NULL, 254, 'direct', 45, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(165, '213', 'إسماعيل محمد', 'Ismaiel Muhammad', NULL, 54, 6, NULL, 123, 'direct', 53, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(166, '246', 'صدام حسين', 'Saddam Hussein', NULL, 46, 5, NULL, 254, 'direct', 45, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(167, '255', 'إبراهيم موسى', 'Ibrahim Musa', NULL, 13, 7, NULL, 221, 'direct', 54, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(159, '148', 'أبو بكر ادريس', 'Abu Bakr Idris', NULL, 20, 10, NULL, 5, 'direct', 29, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(160, '152', 'على محمد', 'Ali Muhammad', NULL, 51, 10, NULL, 5, 'direct', 50, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(158, '380', 'نسيم شوكت', 'Naseem Shawkat', NULL, 6, 5, '1234567890', 95, 'direct', 5, '2022-01-29', '2022-01-29', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'yes', 3, 10, 2, 15, '2022-02-13 10:55:00', '2022-03-24 20:06:11'),
(14121174, NULL, 'نايف الحارثي', 'Nayef Al-Harthy', NULL, 3, NULL, '0571864723', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ذهبان', 'Jeddah', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$kElJz/iDNsJDoJoKi2dy/OE4OKFQx9AqRYiVr4DhC/igRu9cEjap.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-14 20:30:39', '2022-03-08 20:51:52'),
(157, '379', 'محمد ساجد', 'Mohammed Sajid', NULL, 6, 5, NULL, 95, 'direct', 5, '2022-01-29', '2022-04-29', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-17 17:56:07'),
(156, '378', 'عمران قاسم', 'Imran Qassem', NULL, 6, 5, NULL, 95, 'direct', 5, '2022-01-29', '2022-04-29', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-17 17:57:28'),
(155, '377', 'شكيل خان', 'Shakil Khan', NULL, 6, 5, NULL, 95, 'direct', 5, '2022-01-29', '2022-04-29', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-17 17:58:08'),
(154, '376', 'رامبوكار ماندال', 'Rambokar Mandal', NULL, 21, 5, NULL, NULL, 'direct', 19, '2022-01-29', '2022-04-29', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-17 17:58:58'),
(153, '375', 'محمد زبير', 'Muhammed Zubair', NULL, 10, 8, NULL, 258, 'direct', 40, '2022-01-27', '2022-01-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(152, '374', 'شاندانا روان', 'chandana rawan', NULL, 6, 5, NULL, 254, 'direct', 5, '2022-01-23', '2022-01-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(151, '373', 'فارمان بوتان', 'Farman Bhutan', NULL, 20, 5, NULL, 254, 'direct', 19, '2022-01-22', '2022-01-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(150, '372', 'رحمان منجهي', 'Rahman Munjhi', NULL, 20, 5, NULL, NULL, 'direct', 5, '2022-01-22', '2022-01-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-05 06:22:09'),
(149, '371', 'محمد انصاري', 'Muhammad Ansari', NULL, 6, 5, NULL, 254, 'direct', 5, '2022-01-22', '2022-01-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(148, '370', 'عدي عدنان محمد احمد', 'Uday Adnan Mohamed Ahmed', NULL, 20, 8, NULL, 258, 'direct', 19, '2022-01-17', '2022-01-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(147, '369', 'اكرم فضل محمد احمد', 'Akram Fadel Mohamed Ahmed', NULL, 20, 8, NULL, 258, 'direct', 19, '2022-01-17', '2022-01-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(146, '368', 'ناجي محمد سيف محسن', 'Naji Muhammed Seif Mohsen', NULL, 20, 8, NULL, 258, 'direct', 19, '2022-01-17', '2022-01-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(145, '367', 'انيس محمد باني', 'Anis Muhammed Bani', 'a.bani@pwr.sa', 2, 4, NULL, 56, 'direct', 49, '2022-01-16', '2022-04-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'married', 'male', NULL, NULL, '$2y$10$f3laJEGJKnZl4Dyout8LmeiCSkpA92FT8k9emI1eYOQrWZlDwlwRK', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-07 19:54:26'),
(144, '366', 'محمود سهيل', 'Mahmoud Shohel', NULL, 12, 5, NULL, 254, 'direct', 48, '2022-01-16', '2022-01-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(143, '364', 'علي ماهر العزوني', 'Ali Maher El Azouny', NULL, 48, 2, NULL, 1, 'direct', 47, '2022-01-01', '2022-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(142, '363', 'مبارك خان', 'Mubarak Khan', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-12-31', '2021-12-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(141, '362', 'غفار خان', 'Ghaffar Khan', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-12-30', '2021-12-30', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(139, '358', 'محمد جامروز', 'Muhammad Jamrooz', NULL, 6, 5, NULL, 255, 'direct', 5, '2021-12-29', '2021-12-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(140, '359', 'عثمان خان', 'Usman Khan', NULL, 47, 8, NULL, 258, 'direct', 46, '2021-12-27', '2021-12-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(138, '357', 'محمد رضاه', 'Mohammed Reza', NULL, 46, 5, NULL, 254, 'direct', 45, '2021-12-23', '2021-12-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(137, '356', 'محمد أزاد', 'Muhammad Azad', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(136, '355', 'شعيب حيدر', 'Shoaib Haider', NULL, 46, 5, NULL, 254, 'direct', 45, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(135, '354', 'مجاهد شيخ', 'Mujahid Sheikh', NULL, 46, 5, NULL, 254, 'direct', 45, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(134, '353', 'ذو الفقار أحمد', 'Zulfiqar Ahmed', NULL, 45, 8, NULL, 258, 'direct', 44, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(133, '352', 'محمد عمران', 'Muhammad Imran', NULL, 12, 5, NULL, 254, 'direct', 10, '2021-12-16', '2021-12-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(132, '351', 'عبدالغني', 'Abdul Ghani', NULL, 44, 9, NULL, 1, 'direct', 43, '2021-11-28', '2021-11-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(131, '350', 'منصور القحطاني', 'Mansour Al-Qahtani', NULL, 24, 12, NULL, 1, 'direct', 23, '2021-12-18', '2021-12-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 191, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(130, '348', 'أحمد الفرح', 'Ahmed Al Farah', NULL, 20, 8, NULL, 258, 'direct', 19, '2021-12-01', '2021-12-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(129, '347', 'برامود كومار', 'Pramod Kumar', NULL, 12, 5, NULL, 254, 'direct', 10, '2021-11-14', '2021-11-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(128, '346', 'بابلو باداش جوسوامي', 'BABLU BADSAH GOSWAMI', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-11-14', '2021-11-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2506534037', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(127, '345', 'محمد حبيب', 'MOHAMMAD HABIB MIR MAST KHAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-11-05', '2021-11-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2313865178', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(126, '344', 'كيشان شوهدري', 'KISHAN CHAUDHARY', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-11-05', '2021-11-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2421168291', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(125, '343', 'طالب مانجار إمام', 'TALIB MANJAR IMAM', NULL, 43, 6, NULL, 123, 'direct', 42, '2021-11-06', '2021-11-06', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2506533526', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(124, '342', 'محمد رحمن', 'Muhammad Rahman', NULL, 12, 5, NULL, 254, 'direct', 31, '2021-10-28', '2021-10-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(122, '338', 'محمد عارف', 'Mohammed Arif', NULL, 12, 5, NULL, 254, 'direct', 31, '2021-07-29', '2021-07-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(123, '341', 'صدام جاه الله', 'Saddam Jah Allah', NULL, 6, 5, NULL, 254, 'direct', 41, '2021-10-28', '2021-10-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 207, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(121, '336', 'عادل شهر زاد صابر زمان', 'ADIL SHAHZAD SABIR ZAMAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-10-07', '2021-10-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2314618840', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(120, '335', 'زيد علي احمد محسن', 'Zaid Ali Ahmed Mohsen', NULL, 10, 8, NULL, 258, 'direct', 40, '2021-09-14', '2021-09-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2134516216', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(119, '334', 'كبيندرا شريستا', 'KHUPENDRA SHRESTHA', NULL, 12, 5, NULL, 254, 'direct', 10, '2021-09-20', '2021-09-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2506534763', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(118, '333', 'موتي لال تمانغ', 'MOTI LAL TAMANG', NULL, 12, 5, NULL, 254, 'direct', 12, '2021-08-26', '2021-08-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2503861128', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(117, '332', 'تريبهان كوات', 'TRIBHAN KEWAT', NULL, 12, 5, NULL, 254, 'direct', 12, '2021-08-26', '2021-08-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2503861201', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(116, '331', 'فورهاد حسين مد فاروق حسين', 'FORHAD HOSSAIN MD FARUQ HOSSAIN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-08-01', '2021-08-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2499663983', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(115, '330', 'صابر حسين محمد اسلم', 'SABIR HUSSAIN MUHAMMAD ASLAM', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-08-09', '2021-08-09', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2325122584', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(114, '324', 'بلجيندر كومار سوليندر كومار', 'BALJINDER KUMAR SURINDER KUMAR', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-08-07', '2021-08-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2378076364', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(113, '323', 'ساجد محمود همت خان', 'SAJID MEHMOOD HIMAT KHAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-06-03', '2019-06-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2424552699', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(112, '314', 'محمد شميم شريف', 'Muhammad Shamim Sharif', 'admin@webtech.co', 6, 5, NULL, NULL, 'direct', 5, '2021-06-27', '2021-09-25', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-15 19:50:27'),
(111, '310', 'اشيش باريلي', 'Ashish Bareilly', NULL, 6, 5, NULL, NULL, 'direct', 5, '2021-06-05', '2021-09-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 153, 'no', 0, 10, 5, 20, '2022-02-13 10:55:00', '2022-03-26 17:36:00'),
(110, '309', 'رام بهادر سونار', 'Ram Bahadur Sonar', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-06-05', '2021-06-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(109, '308', 'سانجاي ماهاتو', 'Sanjay Mahato', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-06-05', '2021-06-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(108, '296', 'إميت كومار شاراما', 'Emit Kumar Sharma', NULL, 10, 8, NULL, 258, 'direct', 40, '2021-05-20', '2021-05-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(107, '295', 'محفوظ علام بوهيان', 'MAFUZ ALAM BHUIYAN', NULL, 6, 6, NULL, 123, 'direct', 33, '2021-06-01', '2021-06-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2437882687', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(106, '294', 'دولال شمس الحق', 'DULAL - - SAMSULHAQ', NULL, 48, 8, NULL, 258, 'direct', 16, '2021-05-05', '2021-05-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2202537664', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(105, '290', 'داوود خان ناثو خان', 'DAWAD KHAN NATTHU KHAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-04-26', '2021-04-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2374286959', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(104, '289', 'محمد حسين ياسين', 'MOHD HUSSAIN YASEEN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-04-26', '2021-04-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2369100363', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(103, '288', 'جانج إكرار راجاك خان', 'JANG IKRAR RAJAKH KHAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-04-26', '2021-04-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2317014120', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(102, '286', 'مانسارام علي', 'MANSARAM OLI', NULL, 27, 5, NULL, 254, 'direct', 15, '2021-04-10', '2021-04-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2498864434', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(101, '285', 'بوهيرا بير بهادور', 'Bohera Bir Bahadur', NULL, 27, 5, NULL, 254, 'direct', 15, '2021-04-10', '2021-04-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2500148347', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(100, '284', 'خير الابرار الماس خان', 'KHAIR UL ABRAR ALMS KHAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-04-14', '2021-04-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2486676378', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(99, '282', 'مد عاشق ناداف', 'MD AASHIK NADAF', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-04-08', '2021-04-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2484292111', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(98, '258', 'سيف محمد عبدالرحيم الخرابشه', 'Saif Muhammad Abdul Rahim Al-Kharabsheh', NULL, 40, 8, NULL, 1, 'direct', 39, '2021-01-16', '2021-01-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2493438861', 111, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(97, '257', 'مدثر حسين', 'Muddathir Hussain', NULL, 6, 5, NULL, NULL, 'direct', 5, '2021-01-14', '2021-04-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2495190320', 166, 'no', 4, 10, 0, 20, '2022-02-13 10:55:00', '2022-03-26 16:47:50'),
(96, '256', 'محمد إبراهيم', 'Mohamed Ibrahim', NULL, 6, 5, NULL, 254, 'direct', 5, '2021-01-14', '2021-01-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2495190411', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(95, '254', 'محمد فرحات السعيد بسيونى', 'Mohamed Farhat Al-Saeed Bassiouni', NULL, 19, 5, NULL, 1, 'direct', 38, '2021-01-07', '2021-01-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2493438804', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(94, '248', 'حسين مياه', 'Hussein Miah', NULL, 27, 5, NULL, 254, 'direct', 15, '2021-01-01', '2021-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(93, '244', 'محمد تنفير محمد عارف', 'MUHAMMAD TANVEER MUHAMMAD ARIF', NULL, 6, 5, NULL, 254, 'direct', 5, '2020-11-23', '2020-11-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2339432979', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(92, '243', 'محمد عبدالرحمن العوض محمد', 'Muhammad Abdul Rahman Al-Awad Muhammad', NULL, 38, 10, NULL, 5, 'direct', 37, '2020-11-02', '2020-11-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2253791806', 207, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(91, '222', 'إمتيار خان', 'IMTEAZ - - KHAN', NULL, 37, 8, NULL, 258, 'direct', 36, '2020-09-20', '2020-09-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2146203498', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(90, '221', 'التوم ارباب عبدالرحمن كرم الدين', 'Altom Arbab Abdul Rahman Karam Al-Din', NULL, 36, 7, NULL, 1, 'direct', 23, '2020-09-14', '2020-09-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2146258781', 207, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(89, '217', 'جويل رواتقيو نوزا', 'JEOWELL RUTAQUIO NUZA', NULL, 6, 5, NULL, 254, 'direct', 5, '2020-09-15', '2020-09-15', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2296064492', 173, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(88, '212', 'احمد جميل خليل بركات', 'Ahmed gamil Khalil Barakat', NULL, 2, 4, NULL, 119, 'direct', 13, '2020-08-10', '2020-08-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2204968396', 168, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(87, '211', 'رشيد خليل اليوبي', 'Rashid Khalil El Youbi', NULL, 24, 12, NULL, 1, 'direct', 23, '2020-08-01', '2020-08-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '1009594894', 191, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(86, '206', 'كينيث إسكوبيلا', 'KENNETH - ESCOBILLA AMANDORON', NULL, 21, 5, NULL, NULL, 'direct', 7, '2020-07-01', '2020-09-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2290846514', 173, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-03 23:39:21'),
(85, '201', 'فتحي جاد', 'Fathi Gad', NULL, 12, 5, NULL, 254, 'direct', 12, '2020-05-12', '2020-05-12', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(84, '181', 'محمد اكثر حسين', 'MOHAMMAD AKTHER HOSSAIN', NULL, 35, 6, NULL, 123, 'direct', 19, '2020-03-13', '2020-03-13', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2489656922', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(83, '180', 'منيب حيات', 'MUNIB HAYAT PAINDA KHAN', NULL, 21, 7, NULL, 221, 'direct', 20, '2020-03-07', '2020-03-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2492646738', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(82, '178', 'محمد شارق فهيم الدين', 'MOHAMMAD SHARIQ FAHIMUDDIN', NULL, 6, 6, NULL, 123, 'direct', 33, '2020-02-22', '2020-02-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2349840377', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(81, '176', 'بينود كومار شاه', 'BINOD KUMAR SAH', NULL, 6, 5, NULL, 254, 'direct', 5, '2020-02-26', '2020-02-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2492646845', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(80, '171', 'محمد المجتبي يوسف احمد محمد علي', 'Muhammad al-Mujtabi Yusuf Ahmad Muhammad Ali', NULL, 33, 5, NULL, 254, 'direct', 32, '2020-02-13', '2020-02-13', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2325224570', 207, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(79, '170', 'احمد الخير على حموده', 'Ahmed Al Khair Ali Hammouda', NULL, 27, 3, NULL, 127, 'direct', 14, '2020-02-15', '2020-02-15', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2487926871', 207, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(78, '169', 'إقبال خان', 'IQBAL KHAN KAYAMKHANI', NULL, 12, 5, NULL, 254, 'direct', 31, '2020-02-11', '2020-02-11', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2322075595', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(76, '160', 'عبدالله على', 'Abdullah Ali', NULL, 12, 5, NULL, 254, 'direct', 31, '2019-04-19', '2019-04-19', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(77, '164', 'محمد نعيم شمروز خان', 'MUHAMMAD NAEEM SHAMROZ KHAN', NULL, 18, 5, NULL, 254, 'direct', 11, '2020-02-04', '2020-02-04', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2487570513', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(75, '151', 'محمد عبد المنعم عبد اللطيف علي', 'Mohamed Abdel Moneim Abdel Latif Ali', NULL, 2, 4, NULL, 119, 'direct', 13, '2019-11-03', '2019-11-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(74, '150', 'محمود مجدى', 'Mahmoud Majdi', NULL, 18, 5, NULL, 254, 'direct', 11, '2019-03-14', '2019-03-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(73, '147', 'عدنان خان', 'Adnan Khan', NULL, 31, 8, NULL, 258, 'direct', 30, '2019-10-02', '2019-10-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(71, '144', 'إسلام فرحات', 'Islam Farhat', NULL, 10, 5, NULL, 254, 'direct', 9, '2018-01-01', '2018-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(72, '145', 'محمد شكيل', 'Mohamed Shakeel', NULL, 29, 8, NULL, 258, 'direct', 28, '2018-10-22', '2018-10-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(70, '142', 'بالكال عبد الرازق', 'PALACKAL ABDULRAZACK', NULL, 20, 10, NULL, 5, 'direct', 29, '2020-01-25', '2020-01-25', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2171867035', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(68, '135', 'محمد إرشاد', 'Muhammad Irshad', NULL, 29, 8, NULL, 258, 'direct', 28, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(69, '136', 'بير بهادور كومار', 'BIR BAHADUR KUWAR', NULL, 6, 5, NULL, 254, 'direct', 5, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2492646803', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(67, '134', 'راجويندر ملكيت سينغ', 'RAJWINDER MALKIT SINGH', NULL, 6, 5, NULL, 254, 'direct', 5, '2020-01-04', '2020-01-04', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2486925395', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(66, '133', 'عبدالله عبدالرحمن هبه قاسم', 'Abdullah Abdul Rahman Heba Qassem', NULL, 28, 11, NULL, 1, 'direct', 27, '2020-01-01', '2020-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2056710904', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(65, '132', 'بيد بركاش بال', 'BED PRAKASH PAL', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-12-22', '2019-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2487176832', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(64, '130', 'ناريندرا بهادور بوهارا', 'NARENDRA BAHADUR BOHARA', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-12-20', '2019-12-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2482723125', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(63, '129', 'محمد نصرت سروار خان', 'MOHAMMAD NASRAT SARWAR KHAN', NULL, 12, 5, NULL, 254, 'direct', 12, '2019-12-02', '2019-12-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2482722820', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(62, '127', 'خالد محمد البيومى سويدان', 'Khaled Mohammed Al-Bayoumi Swedan', NULL, 27, 3, NULL, 1, 'direct', 26, '2019-11-02', '2019-11-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2297275923', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(61, '126', 'كولديب كانيل سينغ', 'KULDEEP KAENAIL SINGH', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-11-03', '2019-11-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2282035928', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(60, '125', 'محمد مجيب محمد شكيل', 'MOHAMMAD MOJIB MOHAMMAD SHAKIL', NULL, 6, 5, NULL, 254, 'direct', 25, '2019-11-02', '2019-11-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2408179105', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(59, '123', 'محمد محمد شعبان التهامي', 'Mohamed Mohamed Shaaban Tohamy', 'm.tohamy@pwr.sa', 14, 6, NULL, NULL, 'direct', 24, '2019-09-22', '2019-12-21', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'married', 'male', NULL, NULL, '$2y$10$oGKok0oSbYlkSGRvDDP1v.yM/BouLp0oV5a9oTMepl2KCpkTUaIYq', '1', NULL, NULL, '2357717764', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-14 17:08:31'),
(58, '122', 'عبداللة احمد عبدالله محمد الاصبحي', 'Abdullah Ahmed Abdullah Mohammed Al-Asbahi', NULL, 2, 4, NULL, 119, 'direct', 13, '2019-09-21', '2019-09-21', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2052964943', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(57, '120', 'محمد الشهراني', 'Mohammed Al Shahrani', NULL, 24, 12, NULL, 1, 'direct', 23, '2019-09-15', '2019-09-15', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 191, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(56, '119', 'محمد عادل ابو الحمص', 'Mohamed Adel Abu Al-Homs', NULL, 2, 4, NULL, 1, 'direct', 22, '2019-09-03', '2019-09-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 191, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(55, '117', 'محمد مسلم فيباري', 'MOHAMMED MUSLEEM VEPARI', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-06-13', '2019-06-13', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2470579620', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(54, '116', 'ساجد - احمد', 'SAJID - - AHMED', NULL, 22, 6, NULL, 123, 'direct', 21, '2019-06-03', '2019-06-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2246083808', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(53, '113', 'ماني مغراسيا جالينديز', 'MANNY MAGRACIA GALINDEZ', NULL, 21, 7, NULL, 221, 'direct', 20, '2019-08-28', '2019-08-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2365151808', 173, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(52, '112', 'مد نور محمد ميلون', 'MD NUR MUHAMMAD MILON', NULL, 20, 8, NULL, 258, 'direct', 19, '2019-08-18', '2019-08-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2441221831', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(51, '111', 'منير عبد راشد', 'MONIR ABDUR RASHID', NULL, 27, 5, NULL, 254, 'direct', 15, '2019-08-17', '2019-08-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2441034408', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(50, '110', 'محمد حسين عبد الرشيد', 'MOHAMMED HOSSAIN ABDURRASHID', NULL, 12, 5, NULL, 254, 'direct', 12, '2019-08-17', '2019-08-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2187903162', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(49, '109', 'ديبندرا كومار ماندال', 'DIPENDRA KUMAR MANDAL', NULL, 12, 5, NULL, 254, 'direct', 10, '2019-05-02', '2019-05-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2468050915', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(48, '108', 'سوجيت كومار بوربي', 'SUJIT KUMAR PURBEY', NULL, 12, 5, NULL, 254, 'direct', 10, '2019-05-02', '2019-05-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2468052135', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(47, '107', 'تاجيندر سينغ نيرمال سينغ', 'TAJINDER SINGH NIRMAL SINGH', NULL, 7, 8, NULL, 258, 'direct', 6, '2019-08-08', '2019-08-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2477729590', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(46, '106', 'محمد عزيز خان', 'MOHAMMED AJIJ KHAN', NULL, 12, 5, NULL, 254, 'direct', 12, '2019-06-23', '2019-06-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2472198288', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(45, '105', 'سانتوش رامناث', 'SANTOSH RAMNATH', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-08-01', '2019-08-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2472272752', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(44, '102', 'حسام الدين أنصاري مصطفى أنصاري', 'HASMUDDIN ANSARI MUSTKIM ANSARI', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-09-29', '2019-09-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2470302668', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(43, '101', 'محمد شافعي باتاني', 'MUHAMMED SHAFI PATTANI', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-07-09', '2019-07-09', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2440229884', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(42, '100', 'فيجاي كومار مويندر بال', 'VIJAY KUMAR MOHINDER PAL', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-05-10', '2019-05-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2347395044', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(41, '97', 'أجيجو رحمان', 'AJIJU RAHAMAN', NULL, 12, 5, NULL, 254, 'direct', 10, '2019-07-01', '2019-07-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2438469104', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(40, '94', 'جورميت شاند سيتا رام', 'GURMEET CHAND SITA RAM', NULL, 12, 5, NULL, 254, 'direct', 12, '2019-06-19', '2019-06-19', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2394989194', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(39, '93', 'جانجا راج بومجان', 'GANGA RAJ BHOMJAN', NULL, 12, 5, NULL, 254, 'direct', 12, '2019-06-18', '2019-06-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2383719891', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(38, '89', 'تاج الدين خان شمشاد خان', 'TAJUDDIN KHAN SHAMSHAD KHAN', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-05-29', '2019-05-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2337006338', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(37, '88', 'شفيق الرحمن عاطف خان', 'SHAFIQUR RAHMAN ATIF KHAN', NULL, 19, 5, NULL, 254, 'direct', 18, '2019-05-29', '2019-05-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2336523457', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00');
INSERT INTO `users` (`id`, `emp_id`, `first_name`, `last_name`, `email`, `role_id`, `department_id`, `mobile_no`, `report_to_id`, `source_of_hire`, `designation_id`, `join_date`, `confirm_date`, `status`, `emp_type`, `profile_image`, `address`, `city`, `state`, `country_id`, `postal_code`, `dob`, `marital_status`, `gender`, `email_token`, `email_verified_at`, `password`, `is_active`, `driving_licence`, `remember_token`, `id_number`, `nationality_id`, `pay_overtime`, `initial_trip`, `initial_rate`, `additional_trip`, `additional_rate`, `created_at`, `updated_at`) VALUES
(36, '86', 'مونا خان حديش', 'MUNNA KHAN HADISH', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-05-22', '2019-05-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2405390663', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(35, '82', 'تول بهادور بوهاكمي', 'TUL BAHADUR PHAKAMI PUN', NULL, 12, 5, NULL, 254, 'direct', 12, '2019-05-01', '2019-05-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2300413511', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(34, '81', 'نوشاد بوزهيكتوهو', 'NOUSHAD POOZHIKUTHU ABDULLA POOZHIKUTHU', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-04-21', '2019-04-21', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2337007930', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(33, '80', 'مأمون علام بهويان', 'MAMUN ALAM - BHUIYAN', NULL, 14, 6, NULL, 123, 'direct', 17, '2019-04-11', '2019-04-12', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2256117207', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-05 09:46:24'),
(32, '79', 'محمد زيشان محمد حنيف', 'MOHAMMAD ZEESHAN MOHAMMAD HANEEF', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-09-14', '2019-09-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2466944549', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(31, '78', 'قمر الزمان حسين حسين', 'QUAMRUZZAMA HUSAIN HUSAIN', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-04-14', '2019-04-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2318362114', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(30, '77', 'أغني بهادر سيواكوتي', 'AGNI BAHADUR SIWAKOTI', NULL, 27, 5, NULL, 254, 'direct', 15, '2018-12-31', '2018-12-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2449810874', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(29, '76', 'جيت بهادور غرتي', 'JIT BAHADUR GHARTI', NULL, 27, 5, NULL, 254, 'direct', 15, '2018-12-31', '2018-12-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2447787132', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(28, '75', 'مانيبال مهافير سينغ', 'MANIPAL MAHAVEER SINGH', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-04-03', '2019-04-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2465184972', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(27, '73', 'رام راتان جيرنام سينغ', 'RAM RATTAN GURNAM SINGH', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-02-16', '2019-02-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2328383233', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(26, '72', 'ريبان سينغ جيندر سينغ', 'RIPAN SINGH GINDER SINGH', NULL, 6, 5, NULL, 254, 'direct', 5, '2019-02-16', '2019-02-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2379711456', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(25, '70', 'محمد عبد الكليم', 'MOHAMMED ABDUL KHALEEM', NULL, 48, 8, NULL, 258, 'direct', 16, '2019-02-10', '2019-02-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2316749239', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(24, '69', 'محمد نور علم', 'MOHAMMOD NURUL ALAM', NULL, 27, 5, NULL, 254, 'direct', 15, '2018-10-01', '2018-10-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2429049824', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(23, '68', 'محمد عويس محمد عبد الغني', 'Mohamed Owais Mohamed Abdel Ghani', NULL, 27, 3, NULL, 127, 'direct', 14, '2019-01-09', '2019-01-09', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2464784954', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(22, '67', 'رفيق خان قمر الدين خان', 'RAFIK KHAN KAMRUDDIN KHAN', NULL, 12, 5, NULL, 254, 'direct', 12, '2018-12-22', '2018-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2461699031', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(21, '66', 'بيريندرا بهادور دهانك', 'BIRENDRA BAHADUR DHANUK', NULL, 6, 5, NULL, 254, 'direct', 5, '2018-11-24', '2018-11-24', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2424415855', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(20, '65', 'كولديب سينغ سانتوش سينغ', 'KULDEEP SINGH SANTOKH SINGH', NULL, 6, 5, NULL, 254, 'direct', 5, '2018-11-17', '2018-11-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2460635366', 101, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(19, '63', 'عمرو محمود محمد مرعى', 'Amr Mahmoud Mohamed Maree', NULL, 2, 4, NULL, 119, 'direct', 13, '2018-11-08', '2018-11-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2326459407', 64, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(18, '59', 'بشارات حسين محمد بشير', 'BASHARAT HUSSAIN MOHAMMED BASHIR', NULL, 12, 5, NULL, 254, 'direct', 12, '2018-10-22', '2018-10-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2459447088', NULL, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(17, '53', 'دارميندرا كومار ساه', 'DHARMENDRA KUMAR SAH', 'Dhirushah05@gmail.com', 18, 5, '0567894900', NULL, 'direct', 11, '2018-09-08', '2018-09-09', 'active', 'permanant', NULL, NULL, 'Jeddah', 'Makkah', 1, NULL, '1986-09-03', 'married', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2458087901', 153, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-05 09:43:19'),
(16, '49', 'توفيل حسين', 'TOFAYEL HOSSEN', NULL, 21, 5, NULL, NULL, 'direct', 10, '2018-06-18', '2018-09-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2457076616', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-03 23:41:52'),
(15, '48', 'نظيم الدين', 'NAZIM UDDIN', NULL, 13, 5, NULL, NULL, 'direct', 10, '2018-05-16', '2018-08-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2439999885', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-26 22:08:38'),
(14, '47', 'منير الزمان سومان', 'MANIRRUZZAMAN SUMAN', NULL, 13, 5, NULL, NULL, 'direct', 10, '2018-05-16', '2018-08-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2441859309', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-03 23:31:26'),
(13, '46', 'اكبر مد اكاس علي', 'AKABBAR MD AKKAS ALI', NULL, 13, 5, NULL, NULL, 'direct', 10, '2018-05-16', '2018-08-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2435293341', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-24 21:01:59'),
(12, '40', 'محمد مصطفى رستم خان', 'MUHAMMAD MUSTAFA RUSTAM KHAN', NULL, 10, 5, NULL, 254, 'direct', 9, '2018-03-31', '2018-03-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2452965821', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(11, '33', 'مختار أحمد علي محمد', 'MUKHTAR AHMAD ALI MUHAMMAD', NULL, 6, 5, NULL, 254, 'direct', 8, '2018-03-27', '2018-03-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2452969252', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(10, '31', 'طارق محمود محمد رزاق', 'TARIQ MEHMOOD MUHAMMAD RAZZAQ', NULL, 6, 5, NULL, 254, 'direct', 5, '2018-03-27', '2018-03-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2452969112', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(9, '23', 'محمد ياسين عبد الصبحان', 'MOHAMMAD YASIN ABDULSOBHAN', NULL, 21, 5, NULL, NULL, 'direct', 7, '2018-04-11', '2018-07-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2295793927', 18, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-03-03 23:40:33'),
(8, '18', 'ناصر خان منير خان', 'NASEER KHAN MUNIR KHAN', NULL, 7, 8, NULL, 258, 'direct', 6, '2018-03-18', '2018-03-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2452970425', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(2, '1', 'محيا سعود سفير الذيابي', 'Mahaya Saud Safeer Al Dhiyabi', NULL, 2, 1, NULL, NULL, 'direct', 1, NULL, NULL, 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(3, '3', 'محمد ماشع العتيبى', 'Mohammed Masha Al-Otaibi', NULL, 300, 1, NULL, NULL, 'direct', 2, NULL, NULL, 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(4, '4', 'عبدالمجيد شايع حسن عبدالله', 'Abdul Majeed Shaya Hassan Abdullah', NULL, 400, 1, NULL, 1, 'direct', 3, '2017-08-17', '2017-08-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2150676886', 243, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(5, '5', 'عدنان محمد ناصر خشفي', 'Adnan Muhammed Nasir Khashafi', NULL, 5, 10, NULL, 1, 'direct', 4, '2018-02-03', '2018-02-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2238766642', 213, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(6, '12', 'إحسان علي عناية محمد', 'AHSAN ALI INAYAT MUHAMMAD', NULL, 6, 5, NULL, 254, 'direct', 5, '2018-03-18', '2018-03-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2452971001', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(7, '17', 'أمجد علي هذرات عمر', 'AMJED ALI HAZRAT UMAR', NULL, 6, 5, NULL, 254, 'direct', 5, '2018-03-18', '2018-03-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, '2452970318', 166, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(169, '265', 'نور جمال', 'Noor Jamal', NULL, 36, 8, NULL, 258, 'direct', 19, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(170, '266', 'إبراهيم سراج', 'Ibrahim Siraj', NULL, 13, 7, NULL, 221, 'direct', 54, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(171, '304', 'محمد عابدين أندركي', 'Mohamed Abdeen Andreki', NULL, 12, 5, NULL, 254, 'direct', 56, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(172, '306', 'عبده علي داوود', 'Abdo Ali Dawood', NULL, 13, 7, NULL, 221, 'direct', 54, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(173, '307', 'أدم حسن محمد', 'Adam Hassan Muhammed', NULL, 46, 5, NULL, 254, 'direct', 45, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(174, '329', 'محمد أمين', 'Mohammed Ameen', NULL, 46, 5, NULL, 254, 'direct', 45, '0000-00-00', '0000-00-00', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', '1', NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022-02-13 10:55:00', '2022-02-13 10:55:00'),
(14121176, NULL, 'مؤسسة سعد سفر عايض الحارثي للتطوير العقاري', 'Saad Safar Ayed Al Harthy Real Estate Development Corporation', NULL, 3, NULL, '0583839833', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'مخطط الموسى', 'Jeddah', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$uJRg4ZfSyBv8.rwnhNFVCObABZ7o8cXwR.wK9ukeI0QlJWMALoDYC', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-14 20:45:24', '2022-03-08 20:51:17'),
(14121175, NULL, 'شركة المباني الخليجية المتطورة للمقاولات', 'Gulf Advanced Contracting Co', NULL, 3, NULL, '0555548000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'شارع صاري', 'Jeddah', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$KKvEdpzawn5KuU0h868WrOkZlZYxOLldlSIAuMegYb.AiF7A/KKf.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-14 20:34:51', '2022-03-08 21:49:06'),
(14121177, NULL, 'مؤسسة حصاد التمليك للمقاولات', 'Hassad Al Tamleek Contracting Est', 'Hassad@webtech.com', 3, NULL, '0534465327', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الريان', 'جدة', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$7HOKk2AUxvsazaZLl6oE9eYQSaL8Qtq2/BHOv199NqiWKXeYKbfd.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-14 23:32:54', '2022-03-08 20:52:13'),
(14121178, NULL, 'شركة مجموعة جدة الأولى للاستثمارات العقارية', 'First Jeddah Real Estate Investment Group Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$yWiGA2xRQbwMx91VnnWFWuPpOSpMhSORdTWbgcy94fFLok2AcM3Fm', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-15 00:00:14', '2022-03-08 20:50:40'),
(14121179, NULL, 'مؤسسة البنيان المتقدمة للتطوير العقاري', 'Al-Bunyan Advanced Real Estate Development Corporation', NULL, 3, NULL, '0556667880', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الورود', 'مكة', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$4LCe8zRkuR0k/yJJchcK/.1n75Kabo/ao6qYoUYmlisefZmnb.V/O', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-15 00:17:14', '2022-03-08 20:49:26'),
(14121180, NULL, 'مؤسسة احمد عطية جيران الراجحي للتطوير العقاري', 'Ahmed Attia Jeeran Al Rajhi Real Estate Development Corporation', NULL, 3, NULL, '0541058651', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الورود', 'مكة', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$./c8o4ZZuLkJgO/BWXCU6.GSMaV6c9Su8eszNAfKYh7/Q2/SNvTpy', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-15 00:20:32', '2022-03-08 20:48:48'),
(14121181, NULL, 'مؤسسة رسوخ العمرانية للخدمات العقارية', 'Rusuk Al Omrania Real Estate Services Corporation', NULL, 3, NULL, '0542516666', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'حي الصفا', 'جدة', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$//BtRUwXQjK5Z.B0XE5bv.GGODGpnVof0jycWnRQGt5C7/WE6EsQi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-15 00:24:27', '2022-03-08 20:48:10'),
(14121184, '14121184', 'رضا شيخ', 'Raza Shekh cust testing', 'mechanic@webtech.sa', 10, 11, '1234567890', NULL, 'direct', 1, '2022-02-01', '2022-05-01', 'active', 'permanant', NULL, NULL, 'Jeddah', 'Riyadh', 1, '400078', '2013-02-23', 'single', 'male', NULL, NULL, '$2y$10$eJcMfrtuhfrjeSsDgmD9GuvRR0DUsury7eQ3FouPEmu9kPl0yMbCq', '1', NULL, NULL, '123', 101, 'yes', 0, 0, 0, 0, '2022-02-16 02:25:29', '2022-05-27 22:08:25'),
(14121185, NULL, 'مؤسسة كرسال العقارية', 'Karsal Real Estate Corporation', NULL, 3, NULL, '0503001815', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'الريان', 'Jeddah', 'مكة', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$.XlY5bZ2.Ylimn8vMXaZ9O155YX6lgidjJM59K8AlcIGmRcH2aVaG', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-16 04:45:16', '2022-03-08 20:45:08'),
(14121186, NULL, 'ابراهيم ضيف الله السلمي', 'Ibrahim Difallah Alsulami', NULL, 3, NULL, '0555590533', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alryad', 'Alryad', 'Alryad', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$.WBU6i03edYTbhis6cpjge456KFTzIeBTSQUmR74Ey.9zqLODmqka', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-02-24 07:03:41', '2022-05-12 18:16:46'),
(14121187, '14121187', 'وهمي 1', 'Dummy 1', NULL, 6, 5, NULL, 95, 'direct', 18, '2022-03-01', '2029-09-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$bBSATql8MeEhtvG493myKOOsodvJj8avU.YuGqvO4neV8MWKnXdEy', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-01 22:46:12', '2022-03-02 22:51:46'),
(14121188, '14121188', 'وهمي 2', 'Dummy 2', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$Q/wzE24ua1JfOg0GlrcZ6e2AChJB69Dro3d2EqEDVEn8i4Lx3VT3S', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-02 22:51:23', '2022-03-02 22:51:23'),
(14121189, '14121189', 'وهمي 3', 'Dummy 3', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$VMSHReNLQLVTWmjOg7ffCue6cBJcMfJ8wAJ8teAdce6uVzzNCXUVS', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-02 22:54:05', '2022-03-02 22:54:05'),
(14121190, '14121190', 'وهمي 4', 'Dummy 4', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$F3Jmqb2Kve3j6RYnYZJm7Oa1tBOFo2lPMpsV7aFkApBrF606MtluS', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-02 22:55:04', '2022-03-02 22:55:04'),
(14121191, '14121191', 'وهمي 5', 'Dummy 5', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$MVHODtRMk37iaVG0cUgCDOrbpgMOxbJove1Og4qBmQYvK3oPqPfu2', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-02 22:56:02', '2022-03-02 22:56:02'),
(14121192, '14121192', 'وهمي 6', 'Dummy 6', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$8v23QMxLJ5W7nZOIdbkzgu4dL5Ek6Oh/BwZGYdF7DfMVaZPF7uHk.', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-03 23:07:42', '2022-03-03 23:07:42'),
(14121193, '14121193', 'وهمي 7', 'Dummy 7', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$W8PbRSAebF.ZqislwMcwqesN0fW8VFuCGmMAulyKD7DPaUTtHr6Va', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-03 23:08:44', '2022-03-03 23:08:44'),
(14121194, '14121194', 'وهمي 8', 'Dummy 8', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$SuZf8Cu4VFP.E5tYRcy4oupd9zIQGFW720rvoY/vUOYqq3l2k1IpO', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-03 23:09:32', '2022-03-03 23:09:32'),
(14121195, '14121195', 'وهمي 9', 'Dummy 9', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$K7YUbkzGdxKu5agyxsgZgeO6lmWgtxSjA7qTIs7ZcYUQ46cHSnBCq', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-03 23:10:41', '2022-03-03 23:10:41'),
(14121196, '14121196', 'وهمي 10', 'Dummy 10', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$YPf.Fn2LtyFC9rRPN2JBeuVjXJXa6dni8pMBZt88lEn8qisIWyEKu', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-03 23:11:20', '2022-03-03 23:11:20'),
(14121197, '14121197', 'محمد نور علم', 'MOHAMMOD NURUL ALAM', NULL, 13, 5, NULL, 95, 'direct', 15, '2018-10-01', '2019-01-01', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'married', 'male', NULL, NULL, '$2y$10$MfurLbUJu3d3p6pz6U..COc.HnySZwkz0uyFMMZDsku4UYVYnoJaq', '1', NULL, NULL, '0069', 18, 'yes', 0, 0, 0, 0, '2022-03-06 22:40:13', '2022-03-06 22:42:46'),
(14121198, '14121198', 'جيت بهادور غرتي', 'JIT BAHADUR GHARTI', NULL, 13, 5, NULL, 95, 'direct', 15, '2018-12-31', '2018-12-31', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$4VmZ8eYWRtJh7PDbDeFc2.9Qdf9ey7TdTfKodqYPW9/JifMAB9MKK', '1', NULL, NULL, '0076', 153, 'yes', 0, 0, 0, 0, '2022-03-06 22:47:32', '2022-03-06 22:47:32'),
(14121199, '14121199', 'أغني بهادر سيواكوتي', 'AGNI BAHADUR SIWAKOTI', NULL, 13, 5, NULL, 95, 'direct', 15, '2018-12-31', '2018-12-31', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$p342cwgE.Qfk9SX6P5bRiOYbcs0WBn63L1U8/M90lOKS5EnuPTQJi', '1', NULL, NULL, '0077', 153, 'yes', 0, 0, 0, 0, '2022-03-06 22:49:56', '2022-03-06 22:49:56'),
(14121200, '14121200', 'منير عبد الرشيد', 'MONIR ABDUR RASHID', NULL, 13, 5, NULL, 95, 'direct', 15, '2019-08-17', '2019-11-17', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$aPGuS9mSsK71fkGUab4WSeCMlMcstRZXSEvBKS3Ky14BzEY1QMTPu', '1', NULL, NULL, '0111', 18, 'yes', 0, 0, 0, 0, '2022-03-06 22:56:34', '2022-03-06 22:57:18'),
(14121201, '14121201', 'حسين مياه', 'Hussein Miah', NULL, 13, 5, NULL, 95, 'direct', 15, '2021-01-01', '2021-01-01', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$iJ72csxKtPNWul3.MF/97eCe3gMSfkWyZmDzujVuevaWVYzh6I03.', '1', NULL, NULL, '0248', 18, 'yes', 0, 0, 0, 0, '2022-03-06 23:01:35', '2022-03-06 23:01:35'),
(14121202, '14121202', 'بوهيرا بير بهادور', 'Bohera Bir Bahadur', NULL, 13, 5, NULL, 95, 'direct', 15, '2021-04-10', '2021-04-10', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$2ylKPg.DM3/udKdSaEA6vu0S8TWy7Ww2T94JEmDSDrDi8AXLm.S6q', '1', NULL, NULL, '0285', 153, 'yes', 0, 0, 0, 0, '2022-03-06 23:04:58', '2022-03-06 23:04:58'),
(14121203, '14121203', 'مانسارام علي', 'MANSARAM OLI', NULL, 13, 5, NULL, 95, 'direct', 15, '2021-04-10', '2021-04-10', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$JWciQL50GI3ilvwoyWt2pe5fEJnsEA0snbE0gBzzMD8VOxjGspBSG', '1', NULL, NULL, '0286', 153, 'yes', 0, 0, 0, 0, '2022-03-06 23:07:26', '2022-03-06 23:07:26'),
(14121204, '14121204', 'شعيب حيدر', 'Shoaib Haider', NULL, 13, 5, NULL, 95, 'direct', 15, '2021-12-22', '2021-12-22', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$oMQYzp3rMNaH1aS4f1jS5uwPVhjRcrnBfuAYFfyJ/yTJd4ZwjaASS', '1', NULL, NULL, '0355', 101, 'yes', 0, 0, 0, 0, '2022-03-07 18:19:18', '2022-03-07 18:19:18'),
(14121205, '14121205', 'رامبوكار ماندال', 'Rambokar Mandal', NULL, 13, 5, NULL, 95, 'direct', 15, '2022-01-29', '2022-01-29', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$n0.fTc5YDRubPx160YGxr.DZJx0i261rg16WO0NlRwhzuc1llpS3i', '1', NULL, NULL, '0376', 101, 'yes', 0, 0, 0, 0, '2022-03-07 18:21:06', '2022-03-07 18:21:06'),
(14121206, NULL, 'بدر عبدالله الخماش', 'Badr Abdullah Alkhmash', NULL, 3, NULL, '0556644441', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alnahda', 'Alnahda', 'Alnahda', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$diYRUOt/fEb4oR/k1lWyk.QTy5FHxm3RNrayNzmp/FD4tXKipTSbO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-07 22:23:38', '2022-05-12 14:00:08'),
(14121207, NULL, 'مؤسسة تحقيق الامل للمقاولات', 'Tahqeq Alamal Est', NULL, 3, NULL, '0551056724', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soundos', 'جدة', 'جدة', 1, '310086976900003', NULL, NULL, NULL, NULL, NULL, '$2y$10$S5CfMGdZYQiKhx/TwEC6zORB7UuVpj1LEAixjfvWvnYoTJVpK6aF6', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-07 22:36:11', '2022-05-12 12:12:36'),
(14121208, NULL, 'هبه سالم محمد الشقاع', 'Heba Salem Mohammed Al Shaqaa', NULL, 3, NULL, '0565972997', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AlSalama', 'jeddah', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$aanv1FEijGhkRkBw9CTyKOIvwJVkhS5x3x4EpHkiAPFGOrO8G85L.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-07 23:18:59', '2022-03-08 20:30:45'),
(14121209, NULL, 'معيوض رداد المالكي', 'Maeiwad Radad Almaliki', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alryan', 'Alryan', 'Alryan', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$V90R4ZlXZdV.D4yMh5dpKu8fy1TDYtQGdElZwO8qpX.Q7lLZf0n8S', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 18:36:12', '2022-05-12 12:29:24'),
(14121210, NULL, 'شركة ديار الرائدة للمقاولات العامة', 'Diyar Al Raeda General Contracting Co', NULL, 3, NULL, '0554747375', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$plDpXm1kUzGgrc8fFMaO3eyrdx/IQfOVBKW.nuugisSM74zLGtL7K', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 18:50:57', '2022-03-08 20:30:07'),
(14121211, NULL, 'مؤسسة مروان إبراهيم انديجاني', 'Marwan Ibrahim Andijani EST', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$nBuiS7yLjYqZHRF64wXUXOLyaG1aFJ08TtL544MHfbc7QkI8q0A5G', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:03:36', '2022-03-08 20:29:40'),
(14121212, NULL, 'مؤسسة هواي غير للمقاولات العامة', 'Hawaii Gear General Contracting Est', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$e/BFgfpNzfyOR3Gjy619aemmG5FN.riInc.PStGB7Afx3PYJemSy.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:07:50', '2022-03-08 20:28:21'),
(14121213, NULL, 'سليمان رميح محمد الرميح', 'Suleiman Rumaih Muhammad Al Rumaih', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Zde4b6vXYe/QnLKTpUCza.BUVE69geGuMOneCp9XymtoMjbhZSL7S', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:10:33', '2022-03-08 20:28:02'),
(14121214, NULL, 'مؤسسة الصروح الحديثة للمقاولات المعمارية', 'Al Sorouh Modern Architectural Contracting Est', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$3MOQZEzhxSfrDYQRAW8GI.DsPQZMqj2XWOz09Il70qJn05GY.shoO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:12:32', '2022-03-08 20:44:30'),
(14121215, NULL, 'شركة الموسع التجارية', 'Expanded Trading Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$EWbnCLgFq3lhgfMdROFvf.o5RE6mhWG86BC6siolCJZjZYaNPreAa', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:19:54', '2022-03-08 21:48:24'),
(14121216, NULL, 'مؤسسة لمسات التمليك العقارية', 'Lamasat Real Estate Ownership Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$0ONW7Q9y3RdQjNPEdWBAMuBHdCFNw3k0gVbH092aVWxHakBFK94Cm', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:21:06', '2022-03-08 20:25:50'),
(14121217, NULL, 'شركة بان للتطوير العقاري', 'Pan Real Estate Development Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$/u9Of3MxRq1yOJ26OWdgd.wqVNWnRlbpWnsayoCri3Gce1SwjI.7q', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:24:29', '2022-03-08 20:24:29'),
(14121262, NULL, 'هاني سالم احمد الخنبشي', 'Hani Salem Ahmed Alkhambshi', NULL, 3, NULL, '0504693410', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrahily', 'Alrahily', 'Alrahily', 1, '310299142700003', NULL, NULL, NULL, NULL, NULL, '$2y$10$nXv3TPYj55LWuVX5nwl67uYBnJbsnSxQtovW3TbNjwoA1rtuXhu/K', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 14:03:39', '2022-05-12 14:03:39'),
(14121218, NULL, 'شركة روز للمقاولات', 'Rose Contracting Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Fj0C20/yefX98fW7XoXEMesbj5nw/q6xzGNr8/ItFh0Xf45Q27nEy', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:53:09', '2022-03-08 21:48:10'),
(14121219, NULL, 'شركة بروج التمليك العقارية', 'Bruges Real Estate Ownership Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$p7fB3RX6/EfNoiDqvXIV7OMK/bKZfi7DRMmIYhKh5thNgPPTnShUi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:55:02', '2022-03-08 21:47:53'),
(14121220, NULL, 'مؤسسة البراق الذهبي للتطوير العقاري', 'Al Buraq Al Dahabi Real Estate Development Est', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$8O9fcgh7OPuUDiOw9fkJleZMlnJ.qvjMeAszjI8lhbKqo.FnSjhQq', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 20:59:21', '2022-03-08 21:01:00'),
(14121221, NULL, 'شركة نخبة المباني', 'Elite Buildings Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Ut.O.lGn3T4w51WlGCqmh.u72o3THpjhtT03AMt.u59TaKhCmqDpm', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:01:37', '2022-03-08 21:47:40'),
(14121222, NULL, 'مؤسسة روعة الاتقان للتطوير العقاري', 'Rawaat Alatqan EST', NULL, 3, NULL, '0553338509', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alfaisalia', 'Alfaisalia', 'Alfaisalia', 1, '30092498200013', NULL, NULL, NULL, NULL, NULL, '$2y$10$LNXcNQ0JEGaEBtDB7TelNuLiXTPUX2sWEgma6dvNJfd5epI5x0Zky', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:03:06', '2022-05-12 12:16:48'),
(14121223, NULL, 'خالد إبراهيم علي الدوسري', 'Khaled Ibrahim Ali Al-Dossary', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$xRfQhrJjA5Kwf1uorb1qsOtMYwtTaWg016r9dNe2MY3nx3r01lp7S', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:06:13', '2022-03-08 21:06:13'),
(14121224, NULL, 'مؤسسة ملقا للعقارات', 'Malacca Real Estate Corporation', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$mtHhSysWfZws9hMsoUIrSux4/VhMEC9KRVAm5UV9NtMVJU8eeN7pm', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:06:50', '2022-03-08 21:06:50'),
(14121225, NULL, 'مؤسسة عمر المربعي للمقاولات', 'Omar Al Marbai Contracting Est', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$a643X4P3KdUn2gAyJibQG.ctLzechJ8oDEhAkyNUNTi.3.dEe1ylq', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:07:54', '2022-03-08 21:07:54'),
(14121226, NULL, 'شركة ماسة المدائن العقارية', 'Masa Al Madaen Real Estate Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Rsiks4xX8Yf9biY84Ts3K./GKQNCa1uoVeiQ9luGqusxkVeKv1N.K', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:08:46', '2022-03-08 21:44:20'),
(14121227, NULL, 'مؤسسة المسكن الريادي للمقاولات', 'Pioneering Housing Contracting Est', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$kMWujIygkVkXaOuX6O2RxOX8oQtgspjMWkINGj8fsMOp5kODydrzm', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:09:39', '2022-03-08 21:09:39'),
(14121228, NULL, 'عبدالملك عبدالحميد زيني - انديجاني', 'Abdul Malik Abdul Hamid Zaini', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$JpJ9imxIHE/OyCL2ziKcOeLVw7/SwUEG3AnZWjFpDt2Nny/YAAZri', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:10:59', '2022-05-24 17:54:23'),
(14121229, NULL, 'محمد احمد سعيد الشيباني', 'Mohammed Ahmed Saeed Al-Shaibani', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$MxOjQLZ.MW5NoTJ2JcEkBOmuZByhqEaiXi3VzrBFyYNgvHC4MJDO6', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:11:53', '2022-03-08 21:11:53'),
(14121230, NULL, 'طلال صالح ماطر الحربي', 'Talal Saleh Mater Al-Harbi', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$.7wClHdOhzdMcziA7G0oZeHE03lTZLnJoqGUu/bVg/5a3bJcEvOp.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:12:11', '2022-03-08 21:12:11'),
(14121231, NULL, 'شركة الفراس التعليمية المحدودة', 'Alfras Altalimia Co', NULL, 3, NULL, '0504304029', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alnaim', 'Alnaim', 'Alnaim', 1, '300253932600003', NULL, NULL, NULL, NULL, NULL, '$2y$10$7SfX5fFStmC7jxDmlpfOHe5zTW6sLMvFBThm8cnM3MKc/UYTe3S5G', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:12:28', '2022-05-12 12:25:49'),
(14121232, NULL, 'مؤسسة عوض محمد خليل مرضاح', 'Awad Muhammad Khalil Merdah EST', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ZM82Gt7NmO5wGrtjz48p.eZY53N6q6CAEsoHJkVX/BQJ./gUjV9Qi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:13:11', '2022-03-08 21:13:11'),
(14121233, NULL, 'شركة اوتار العالمية للتطوير العقاري', 'Awtar Alalamya Co', NULL, 3, NULL, '0558606622', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alwrood', 'Alwrood', 'Alwrood', 1, '310111442800003', NULL, NULL, NULL, NULL, NULL, '$2y$10$N09ft.4Tb4ElYeuwijtgAOXcc6D8KnANZLLXR1lyW5Luu6G57aWf2', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:13:34', '2022-05-12 17:07:49'),
(14121234, NULL, 'محمد عقيل عبدالعزيز العقيل', 'Mohammed Aqil Abdulaziz Al-Aqeel', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$GIt0MqmyAWAxpHX7f9vkoO2UuGTEJucrVREGeMldYjLdZk9TCjwx6', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-08 21:14:19', '2022-03-08 21:14:19'),
(14121235, NULL, 'شركة شرق الدلتا السعودية', 'East Delta Saudi Company', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$YpziyJXhZ/rs1TFkGxyF0./ZwOUzefZXndN5YzygJOj2ogM2x6S0u', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 17:44:32', '2022-03-09 17:44:32'),
(14121236, NULL, 'شركة بيوت النهضة العقارية', 'Bayut Al Nahda Real Estate Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$1hx0lhYh21i7z4ohY.uaheLYosb6pL9nmxp/Zf8hcT4nka9yjJSIu', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 18:36:05', '2022-03-09 18:36:05'),
(14121237, NULL, 'شركة الوزان المتحدة لتقديم الوجبات', 'Al Wazzan United Meals Co.', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$QdfFJJhcwcIPKvbOvRldgOdvm.ApAVw10YVBLlmtOrCgKh3BgRl4S', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 18:52:55', '2022-03-09 18:52:55'),
(14121238, NULL, 'شركة ديار العصرية العقارية', 'Dyar Al-Asriya Real Estate Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$OUCvBcp4MPg5UCCeSCfY3ehZVyUjqXmvtGyI1NfqW6Nf1loS2eblC', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 18:59:35', '2022-03-09 18:59:35'),
(14121239, NULL, 'مؤسسة حسين راجح الزهراني', 'Hussein Rajeh Al-Zahrani EST', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$IQeiA2qKnA.whmx2iMDra.cA.Mimm33UbawonUTFbYrBz/H722D4O', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 19:30:18', '2022-03-09 19:30:18'),
(14121240, '14121240', 'وهمي 11', 'Dummy 11', NULL, 6, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', 'active', 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$wTPlcGEw5OSybye62bZY0eUN3yqNycgaBlrckA8bDJ4Lt2YqQsqn2', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-09 19:33:47', '2022-03-09 19:33:47'),
(14121241, NULL, 'احمد عبود باحسن', 'Ahmed Aboud Bahsan', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$dmWbY.rYHSu5BxCm8koNDOfoIpsRI43WRavJjp5HqBJ3Aw.arkxGK', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 19:34:09', '2022-03-09 19:34:09'),
(14121242, '14121242', 'مشغل وهمي', 'Dummy Operator', NULL, 12, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$BpqrBOsNLvuh8ymjxljCIeJFM.T2TNjCYpuXhsgNWS0rpd4xDoowG', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-09 19:41:29', '2022-03-09 19:41:29'),
(14121243, '14121243', 'عامل وهمي', 'Dummy Helper', NULL, 13, NULL, NULL, NULL, NULL, NULL, '2022-03-01', '2022-03-01', NULL, 'temporary', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$Dx5Al82HR9EfDRXuU42HDuddRyrxYYCHEtKGUt49Q.hReSp5UTWEq', '1', NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022-03-09 19:43:13', '2022-03-09 19:43:13'),
(14121244, NULL, 'مؤسسة ديار التمليك العقارية', 'Dear Altamlik EST', NULL, 3, NULL, '0536146403', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrayan', 'Alrayan', 'Alrayan', 1, '302216976500003', NULL, NULL, NULL, NULL, NULL, '$2y$10$wphyqS5yr7cYCwct49eENeNh3xZOmjS7NBG338bBQ3i53sWEbsKWG', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 19:51:21', '2022-05-12 17:41:57'),
(14121245, NULL, 'مؤسسة صالح يوسف الزهراني', 'Saleh Yousef Al-Zahrani EST', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$I5U83F2nbpL6oMgk3.ihqOmegiY.yOjU2pf2F6Ch4niBIMWjLmtMW', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 20:08:19', '2022-03-09 20:08:19'),
(14121246, NULL, 'مؤسسة صرح الجزيرة للتطوير العقاري', 'Sarh Al Jazeera Real Estate Development Corporation', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$0to9RS0jlspw5.BoFZp2aOYYPhg8Z.4FPkwIa5QjHayBqoKj6J5Wi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 20:12:24', '2022-03-09 20:12:24'),
(14121247, NULL, 'شركة ايان الدولية العقارية', 'Ayan International Real Estate Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$XuLDzB4wliT4/9SedD5G.e/2ovHtUnj09aJJynBN6b2yAYDf7W.Pq', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 20:29:09', '2022-03-09 20:29:09'),
(14121248, NULL, 'مؤسسة سكون الحديثة للمقاولات', 'Skoun Modern Contracting Est', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Gez53whvSzZveSQDBU/pXOJLeG9zrErFt5ImqZXpYFA1ZGxp6.evS', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 21:04:53', '2022-03-09 21:04:53'),
(14121249, NULL, 'توفيق محمد عبدالواحد', 'Tawfiq Mohamed Abdel Wahed', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$DVRDh1i7LI.L6l0ZsugJmugYzZ05ZR28pVyRwdFS5vGXmPN98CELe', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 21:07:55', '2022-03-09 21:07:55'),
(14121250, NULL, 'مؤسسة اتقان الرائدة', 'Etqan Leading Institution', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ZY5f4oZA1vhb0rXmkXM2jOtjV65VMxmynDvich.2qQ15srv0AtP1.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-09 21:11:52', '2022-03-09 21:11:52'),
(14121251, NULL, 'مؤسسة عبدالله عوض محمد خالد التجارية', 'Abdullah Awad Mohammed Khaled Trading Est', NULL, 3, NULL, '0551861235', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$BA18H.Cct/wp7bfV4A5pxOdKFSSYbRN3cBzxE8lkdOR8Gdoso3CHO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-03-14 18:13:14', '2022-03-14 18:13:14'),
(14121252, NULL, 'عبدالكريم دخيل الدميحي', 'Abdulkarim Dakhil AlDumaihi', NULL, 3, NULL, '05639015718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mukhatat Almusaa', 'Jeddah', 'Jeddah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$4D7VXp51WHbyAwSdsXTIO.mu6Z9xnqzH5pX7oxZ00Esx8YqkNa7AO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-04-17 18:33:32', '2022-04-17 18:33:32'),
(14121253, NULL, 'عبدالرحمن ماشع', 'Abdulrahman Masha', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jeddah', 'Jeddah', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$KY4xZC5OjfgZY7LF1AnfquN8.kQsGtjSTda5j533rvuH3rW3kjXO6', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-04-17 18:56:09', '2022-04-17 18:56:09'),
(14121254, '14121254', 'سيف محمد الخرابشة', 'Seif Mohammad Alkharabsheh', 'saif@pwr.sa', 22, 7, NULL, 2, NULL, 39, '2021-10-21', '2022-01-21', 'active', 'on-contract', NULL, NULL, NULL, NULL, 1, NULL, NULL, 'married', 'male', NULL, NULL, '$2y$10$opxFtCyj2AhhCYALKh8TsONTseK/4fNyiDADBoAGfvtRAirZvziJe', '1', NULL, NULL, NULL, 111, 'no', 0, 0, 0, 0, '2022-04-24 19:31:36', '2022-04-24 19:35:32'),
(14121255, NULL, 'مؤسسة  عبدالمحسن محمد عثمان شوك للمقاولات العامة', 'Abdulmohsen Mohamed Shuk EST Albaghdadia', NULL, 3, NULL, '0501974774', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Albghdadia', 'jeddah', 'jeddah', 1, '310412959700013', NULL, NULL, NULL, NULL, NULL, '$2y$10$vei6sJIqFA6xDiCbPypFxemQ3aUyiTZ6po1WAJwS9rRB6Xb4hlEPi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 12:06:27', '2022-05-12 12:07:24'),
(14121256, NULL, 'صباح محمد سويلم الشريف', 'Sabah Muhammed Alsharif', NULL, 3, NULL, '0554171441', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alsafa', 'Alsafa', 'Alsafa', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$c3bjTLfr3CnO6NUv9QURIeE83S9lRCKnxuMzsNZCgNT8JGUvHIEIC', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 12:21:44', '2022-05-12 12:21:44'),
(14121257, NULL, 'عبدالعزيز مصلح عبدالله الشيخ', 'Abdulaziz Mosleh Alsheikh', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alsulimanih', 'Alsulimanih', 'Alsulimanih', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$GotAMJ9Cc3NV/zqY6GjnA.gm65bUQwJGBdFRBHK.YAm9CvfTWIPZu', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 12:35:38', '2022-05-12 12:35:38'),
(14121258, NULL, 'احمد ماشع العتيبي', 'Ahmed Masha Alotaibi', NULL, 3, NULL, '0564989444', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tibaa', 'Tibaa', 'Tibaa', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$smyq2IpaWHLwiEFxBuhEQ.hrEebWxJQi0ikCrU07gbNmLORKmwVoi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 12:42:42', '2022-05-12 12:42:42'),
(14121259, NULL, 'شركة اتحاد الماسة للمقاولات', 'Etihad Almasah Co', NULL, 3, NULL, '0503594355', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alzahid', 'Alzahid', 'Alzahid', 1, '310330228600003', NULL, NULL, NULL, NULL, NULL, '$2y$10$IYccvrvr3bmv.DtSJoy4ZOzlIoTIMecBo7MrtadYWXOwjv1x8vX96', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 12:50:56', '2022-05-12 12:50:56'),
(14121260, NULL, 'مؤسسة عطا الخير للمقاولات العامة', 'Atta Alkhair EST', NULL, 3, NULL, '0500092577', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alshati', 'Alshati', 'Alshati', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$MTqJKXce84kM32za/K1sr.DBxP2DddkupE1v1KVQOJedOcEnLZ6Fq', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 13:26:29', '2022-05-12 13:26:29'),
(14121261, NULL, 'عبدالرحمن فارس الذيابي', 'Abdualrhman Fares Althiabi', NULL, 3, NULL, '0535863255', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alflaah', 'Alflaah', 'Alflaah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$O3HMT5rjSOiE54m/LjhSY.Qo4JbfG38uWA9nYzxSgRrHp26iYx8.m', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 13:54:47', '2022-05-12 13:54:47'),
(14121263, NULL, 'شركة المقاول الدولي المتكامل المحدودة', 'Almqawel Adwali Co', NULL, 3, NULL, '0551838426', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alkhaldia', 'Alkhaldia', 'Alkhaldia', 1, '300119494600003', NULL, NULL, NULL, NULL, NULL, '$2y$10$BzkP3IgzKuYTaRZpwYRtauLekFfHQ.twO4gliQBqENI3qSN5Z4DeO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 17:13:35', '2022-05-12 17:13:35'),
(14121264, NULL, 'سعد محمد سعد العجلان', 'Saad Mohamed Saad Alajlan', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alfaal', 'Alfaal', 'Alfaal', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$6tOcyuostX.ol7aD33ZkK.Wwo23ZAAr8GSFucr.XBKO7CEdp2gj.i', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 17:45:55', '2022-05-12 17:45:55'),
(14121265, NULL, 'شركة رموز المباني للمقاولات', 'Rumuz Almabani Co', NULL, 3, NULL, '0535195823', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alryan', 'Alryan', 'Alryan', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$qGAR6lOqED9IiTftUyIhpunH7yJF/PQtwIFygy6mFKPEnsENcE8OC', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-12 18:00:18', '2022-05-12 18:00:18'),
(14121266, NULL, 'سامي حامد السفري', 'Sami Hamed Alsefri', NULL, 3, NULL, '058330744', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alraboah', NULL, 'Alraboah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$YinKiZPycxAe69R2B5bWvO0u5NjiAkYBXLM9EyNoJieEpEwqP7Sd2', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-16 13:51:20', '2022-05-16 13:51:20'),
(14121267, NULL, 'مؤسسة ابيات التمليك العقارية', 'Abyat Altmlik EST', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Drb Alharamin', 'Drb Alharamin', 'Drb Alharamin', 1, '311019383200003', NULL, NULL, NULL, NULL, NULL, '$2y$10$TjzcJIewp3aU/EuEoGKpzOZyZD8DV2nXU0jbCOezXIFaVxa00uWAO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-16 14:00:58', '2022-05-16 14:00:58');
INSERT INTO `users` (`id`, `emp_id`, `first_name`, `last_name`, `email`, `role_id`, `department_id`, `mobile_no`, `report_to_id`, `source_of_hire`, `designation_id`, `join_date`, `confirm_date`, `status`, `emp_type`, `profile_image`, `address`, `city`, `state`, `country_id`, `postal_code`, `dob`, `marital_status`, `gender`, `email_token`, `email_verified_at`, `password`, `is_active`, `driving_licence`, `remember_token`, `id_number`, `nationality_id`, `pay_overtime`, `initial_trip`, `initial_rate`, `additional_trip`, `additional_rate`, `created_at`, `updated_at`) VALUES
(14121268, NULL, 'شركة ديار النهضه للمقاولات', 'Dear Alnahda Co', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alfaisalia', 'Alfaisalia', 'Alfaisalia', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$nJChz1BMcNOBaGU6kuc/lebzgi2RQXkxhBzEl4EuIhjdLMHPjp9BG', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-16 14:04:23', '2022-05-16 14:04:23'),
(14121269, NULL, 'عمر زين عمور الحربي', 'Omar Zain Amour Alharbi', NULL, 3, NULL, '0544440882', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alsalahia', 'Alsalahia', 'Alsalahia', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$CpwyFUXV5xXV9kjbWFNM3ekfBCCMQpchQBc//pQ4nThp7NMiGlGpW', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-16 14:09:38', '2022-05-16 14:09:38'),
(14121270, NULL, 'مؤسسة المنارة للتطوير العقاري', 'Almanara Real Estate EST', NULL, 3, NULL, '0596080044', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrawdah', 'Alrawdah', 'Alrawdah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$hjLrLhNOZAoFfhVQGdWzAuXzW8uE3ZM3ts/S.Z58c.ZsmzCqdkt9C', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-16 14:13:08', '2022-05-16 14:13:08'),
(14121271, NULL, 'شركة نمو الديار العقارية', 'Nmo Aldear Co', NULL, 3, NULL, '0500092577', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrawda', 'Alrawda', 'Alrawda', 1, '310803879600003', NULL, NULL, NULL, NULL, NULL, '$2y$10$mLfvx9dwK170zxp/81tZIedyAqXsP0uCyb.3ekx4sFCS6FcDs9LaW', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 12:00:04', '2022-05-17 12:00:04'),
(14121272, NULL, 'مؤسسة رسوخ المتقدمه للمقاولات العامة', 'Rosoukh Almotqadema EST', NULL, 3, NULL, '0542516666', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Drb Alharamin', 'Drb Alharamin', 'Drb Alharamin', 1, '300089252300003', NULL, NULL, NULL, NULL, NULL, '$2y$10$p1KENc3pFOndODq9mxCTb.fQRazEiA4T3xI0U1FcJsABOznSkbrIG', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 12:24:31', '2022-05-17 12:24:31'),
(14121273, NULL, 'مؤسسة مسكن العالم الفريد للتطوير العقاري', 'Maskan Alalam Alfared EST', NULL, 3, NULL, '0550066658', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lolia', 'lolia', 'lolia', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ynedPLWzk1nKfFA6AIjpWuUiTwTEx2.B7wMHVIZwgFqgOm4YRJuMO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 12:57:05', '2022-05-17 12:57:22'),
(14121274, NULL, 'عبدالله مناور العتيبي', 'Abdullah Mnawer Alotaibi', NULL, 3, NULL, '0558009013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alwafaa', 'Alwafaa', 'Alwafaa', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$AD.3ZL46EaxFoJZXlkeeW.wVSoHvAvnI39dUNOyd9hux6jNsFvD9.', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 13:06:00', '2022-05-17 13:06:00'),
(14121275, NULL, 'شركة زمام للمقاولات', 'Zimam Contracting Co', NULL, 3, NULL, '0503691941', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrawdah', 'Alrawdah', 'Alrawdah', 1, '310802832600003', NULL, NULL, NULL, NULL, NULL, '$2y$10$uwbom9ptJ0TwysHZpUStlujUtZOOajyHph4qn5Lj4Sg5/9rPaNn5O', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 16:15:01', '2022-05-17 16:15:01'),
(14121276, NULL, 'مؤسسة ركاز التمليك للتطوير العقاري', 'Rikaz Altamleek EST', NULL, 3, NULL, '0542131291', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alryan', 'Alryan', 'Alryan', 1, '310928333600003', NULL, NULL, NULL, NULL, NULL, '$2y$10$XelMlWGtqbl22icxQXldh.EtLuLGAUZA/aDJAmubJPxxI8Bks1vk2', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 16:38:16', '2022-05-17 16:38:16'),
(14121277, NULL, 'عثمان عبدالله سعيد العمودي', 'Othman Abdullah Alamoudi', NULL, 3, NULL, '0504599639', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alnahdaa', 'Alnahdaa', 'Alnahdaa', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$1xknH4NRA6uQAhuvQTdz6uSIiJKfeJNOArx9f2ptSk5zpBZdwKTUq', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 16:43:13', '2022-05-17 17:51:19'),
(14121278, NULL, 'مؤسسة اساسات برج النيل للمقاولات', 'Nile Tower Foundation EST', NULL, 3, NULL, '0505516377', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'King Fahed Street', 'King Fahed Street', 'King Fahed Street', 1, '310024228800003', NULL, NULL, NULL, NULL, NULL, '$2y$10$CXWXIDkOGDgru2UkEn3xmuMQGYCJcPI/tQJQ/wcADYA7ftZ2/5tTy', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 17:48:29', '2022-05-17 17:48:29'),
(14121279, NULL, 'شركة الاندلس الخضراء للخدمات التعليمية والتربوية', 'Alandalus Alkhadra Co', NULL, 3, NULL, '0591616240', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrawda', '300219765200003', 'Alrawda', 1, 'Alrawda', NULL, NULL, NULL, NULL, NULL, '$2y$10$G9l7.MuUFKnwW/GkLAu/HOl3NOCJDqP.Q0zj9OMrxD6nP6JTTvHRG', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 17:52:46', '2022-05-17 17:52:46'),
(14121280, NULL, 'شركة عراب التمليك للتطوير العقاري', 'Arab Altamleek Co', NULL, 3, NULL, '0539377388', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrayan', 'Alrayan', 'Alrayan', 1, '310900291400003', NULL, NULL, NULL, NULL, NULL, '$2y$10$js.uZryJvo202l67Ihal3ebO3wucVLCaIC2N2UM6EmYri0YPZcu5K', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 18:00:48', '2022-05-17 18:00:48'),
(14121281, NULL, 'شركة اعمار الحياة', 'Emaar Life Co', NULL, 3, NULL, '0505566225', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Drb Alharamen', 'Drb Alharamen', 'Drb Alharamen', 1, '310771856100003', NULL, NULL, NULL, NULL, NULL, '$2y$10$ei5/wM7Ihee.XhNjUe0hDeqpXi.9iVsnKgD9E4b/iuTh3JUsCCy3G', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-17 18:06:06', '2022-05-17 18:06:06'),
(14121282, NULL, 'مؤسسة ماجد تيسير سكيك للمقاولات', 'Majid Tayseer skaik EST', NULL, 3, NULL, '0505516377', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alrahili', 'Alrahili', 'Alrahili', 1, '300845718100003', NULL, NULL, NULL, NULL, NULL, '$2y$10$CoOQKiBP2x5BigbuAxrR2.YYCS/0ux9yKyAHdPQj4arAMe0WpBxaa', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-18 13:03:19', '2022-05-18 13:03:19'),
(14121283, NULL, 'syed', 'shafiullah', 'ss@ss.com', 11, 10, '966', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$OzbAV4MmX7mc998UYjEPve9UO2RPvESZE9uovIH3cgFUNhAS4bILi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-23 20:32:46', '2022-05-23 20:32:46'),
(14121284, NULL, 'مراد ابراهيم بازار انديجاني', 'Murad Ebrahim Andijani', NULL, 3, NULL, '0530796791', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alsafa', 'Alsafa', 'Alsafa', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$90XJDorO9CaY.QB0dZ.Kf.WcgM/LxuDrHanBW7AdioyYUPxExiL1e', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-24 17:34:46', '2022-05-24 17:34:46'),
(14121285, NULL, 'فؤاد انديجاني', 'Fouad Andijani', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jeddah', 'jeddah', 'jeddah', 1, '310250694100003', NULL, NULL, NULL, NULL, NULL, '$2y$10$qqnUMDfocNP72hKxHGKkdOByAaaiAIFprBjvpy4weowyhsteWdWi2', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-24 17:43:03', '2022-05-24 17:43:03'),
(14121286, NULL, 'نبيل عبدالله محمود قاري', 'Nabil Abdullah Moamoud Kari', NULL, 3, NULL, '0555593599', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alfaisalia', 'Alfaisalia', 'Alfaisalia', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$j40aKrsL/Hr6k1Or4q5FKua3ITIn9Ggsu7y8vdKO/jR.q5mP8wPny', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-29 19:02:48', '2022-05-29 19:03:00'),
(14121287, NULL, 'علي سعيد ظافر القحطاني', 'Ali Saeed Dhafer Alqahtani', NULL, 3, NULL, '05575120000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Almousa', 'Almousa', 'Almousa', 1, '310274319400003', NULL, NULL, NULL, NULL, NULL, '$2y$10$fgKicHXuBKAQphX576..PermcCq9cS3VTO6of5sfV8mel1jeZD2.2', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-29 19:07:18', '2022-05-29 19:10:34'),
(14121288, NULL, 'شركة تلال العربية للتطوير العقاري', 'Telal Alarabia Real Estate Co', NULL, 3, NULL, '0505893441', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Almarwa', 'Almarwa', 'Almarwa', 1, '311190651500003', NULL, NULL, NULL, NULL, NULL, '$2y$10$sQ1vDNx3fJySVaVJQ5gCbOWN7PwfnkUvJxIXyZ6l6bkg5FYMHb.Su', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-29 19:23:36', '2022-05-29 19:23:36'),
(14121289, NULL, 'زهير عبدالله صالح بشبيشي', 'Zuhair Abdullah Saleh Bashbeshi', NULL, 3, NULL, '0556666981', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alsalamah', 'Alsalamah', 'Alsalamah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$fNAs8PQ/MDwcOdgRBVjVgO0IN5o8Vhvq2lx0IwrKnN/ggp/AxRgaO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-29 19:43:18', '2022-05-29 19:43:18'),
(14121290, NULL, 'ابراهيم سالم اليافعي', 'brahim Salem Alyafei', NULL, 3, NULL, '0547486513', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Drb Alharamen', 'Drb Alharamen', 'Drb Alharamen', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$7dQIWMEx1rsON1vmxf.Q7OIFr4T/oOCoXc3kB3gABIO3b8fn.QQtO', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-05-29 19:50:32', '2022-05-29 19:50:32'),
(14121291, '14121291', 'IMTEAZ KHAN', 'امتياز خان', 'i.khan@pwr.sa', 23, NULL, NULL, 14121254, NULL, 36, '2022-09-20', '2022-09-20', 'active', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'single', 'male', NULL, NULL, '$2y$10$8IdPvSN9SVwtRNzr4Ju30uMcyPuFdHnUwHa54dW1IiLiAThq7Hs4C', '1', NULL, NULL, '2146203498', 101, 'yes', 0, 0, 0, 0, '2022-06-06 14:16:29', '2022-06-06 14:16:29'),
(14121292, NULL, 'Mize', 'Toyota', 'info@mize.com', 11, 10, '966', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$oxlMaVu/By5ynUXd7/QM4e6WvjvlwAltI3uPskGudb0VbFKL27b52', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-06-11 19:08:34', '2022-06-11 19:08:34'),
(14121293, NULL, 'مؤسسة باسل صالح الصحفي للمقاولات المعمارية', 'Basil Alsahafi EST', NULL, 3, NULL, '0553368688', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jeddah', 'jeddah', 'jeddah', 1, '310203604400003', NULL, NULL, NULL, NULL, NULL, '$2y$10$lsaUV8WG2AlPoOn/LpKngOH94vQYUkGvzcQG.0d05jhwNPXqUxs/e', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-06-12 16:04:41', '2022-06-12 16:04:41'),
(14121294, NULL, 'عبدالعزيز عاشور عبيد السيد', 'Abdulaziz Ashour Obaid Alsayed', NULL, 3, NULL, '0533937139', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jeddah', 'jeddah', 'jeddah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$.o2X5/sB1ElwtFOLzYS5a.HSJxZr2F2PPxUHY/ykI20EPI6h63PVy', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-06-12 16:37:32', '2022-06-12 16:37:32'),
(14121295, NULL, 'صالح عبدالله احمد الهمامي', 'Saleh Abdullah Ahmed Alhamami', NULL, 3, NULL, '0564965840', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jeddah', 'jeddah', 'jeddah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Qe.MEQ.YX82WG0uNlhPw9uVHvPBLn/fmFxRaneElOV7HZ4cbGzCSi', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-06-12 16:44:46', '2022-06-12 16:44:46'),
(14121296, NULL, 'علي عبده نصر الهبوب', 'Ali Abdo Nasr Alhaboub', NULL, 3, NULL, '0501468811', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jeddah', 'jeddah', 'jeddah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$R9MO/IpFfxjzsgCe68moNOwFB8euUgkSrnXJZ4LWYAahabFLnmeI2', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-06-12 16:47:29', '2022-06-12 16:47:29'),
(14121297, NULL, 'عبدالله عوض ملاهي عسيري', 'Abdullah Awad Malahi Asiri', NULL, 3, NULL, '0500408828', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jeddah', 'jeddah', 'jeddah', 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$rH99SRrHiNdYUNGS.QKp2OW9JH/bMYMkfHbVTHzC85kBDxV6qMU5i', '1', NULL, NULL, NULL, NULL, 'no', 0, 0, 0, 0, '2022-06-12 16:53:26', '2022-06-12 16:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `users-blank-test`
--

CREATE TABLE `users-blank-test` (
  `id` int(3) DEFAULT NULL,
  `emp_id` int(3) DEFAULT NULL,
  `first_name` varchar(33) DEFAULT NULL,
  `last_name` varchar(44) DEFAULT NULL,
  `email` varchar(10) DEFAULT NULL,
  `role_id` int(2) DEFAULT NULL,
  `department_id` int(2) DEFAULT NULL,
  `mobile_no` varchar(10) DEFAULT NULL,
  `report_to_id` varchar(4) DEFAULT NULL,
  `source_of_hire` varchar(6) DEFAULT NULL,
  `designation_id` int(2) DEFAULT NULL,
  `join_date` varchar(10) DEFAULT NULL,
  `confirm_date` varchar(10) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `emp_type` varchar(9) DEFAULT NULL,
  `profile_image` varchar(10) DEFAULT NULL,
  `address` varchar(10) DEFAULT NULL,
  `city` varchar(10) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `country_id` int(1) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `marital_status` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email_token` varchar(10) DEFAULT NULL,
  `email_verified_at` varchar(10) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `driving_licence` varchar(10) DEFAULT NULL,
  `remember_token` varchar(10) DEFAULT NULL,
  `id_number` varchar(10) DEFAULT NULL,
  `nationality_id` int(3) DEFAULT NULL,
  `pay_overtime` varchar(2) DEFAULT NULL,
  `initial_trip` int(1) DEFAULT NULL,
  `initial_rate` int(1) DEFAULT NULL,
  `additional_trip` int(1) DEFAULT NULL,
  `additional_rate` int(1) DEFAULT NULL,
  `created_at` varchar(16) DEFAULT NULL,
  `updated_at` varchar(16) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users-blank-test`
--

INSERT INTO `users-blank-test` (`id`, `emp_id`, `first_name`, `last_name`, `email`, `role_id`, `department_id`, `mobile_no`, `report_to_id`, `source_of_hire`, `designation_id`, `join_date`, `confirm_date`, `status`, `emp_type`, `profile_image`, `address`, `city`, `state`, `country_id`, `postal_code`, `dob`, `marital_status`, `gender`, `email_token`, `email_verified_at`, `password`, `is_active`, `driving_licence`, `remember_token`, `id_number`, `nationality_id`, `pay_overtime`, `initial_trip`, `initial_rate`, `additional_trip`, `additional_rate`, `created_at`, `updated_at`) VALUES
(2, 1, 'محيا سعود سفير الذيابي', 'Mahaya Saud Safeer Al Dhiyabi', NULL, 2, 1, NULL, NULL, 'direct', 1, NULL, NULL, 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(3, 3, 'محمد ماشع العتيبى', 'Mohammed Masha Al-Otaibi', NULL, 3, 1, NULL, NULL, 'direct', 2, NULL, NULL, 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, NULL, 191, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(4, 4, 'عبدالمجيد شايع حسن عبدالله', 'Abdul Majeed Shaya Hassan Abdullah', NULL, 4, 1, NULL, '1', 'direct', 3, '2017-08-17', '2017-08-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2150676886', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(5, 5, 'عدنان محمد ناصر خشفي', 'Adnan Muhammed Nasir Khashafi', NULL, 5, 10, NULL, '1', 'direct', 4, '2018-02-03', '2018-02-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2238766642', 213, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(6, 12, 'إحسان علي عناية محمد', 'AHSAN ALI INAYAT MUHAMMAD', NULL, 6, 5, NULL, '254', 'direct', 5, '2018-03-18', '2018-03-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2452971001', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(7, 17, 'أمجد علي هذرات عمر', 'AMJED ALI HAZRAT UMAR', NULL, 6, 5, NULL, '254', 'direct', 5, '2018-03-18', '2018-03-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2452970318', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(8, 18, 'ناصر خان منير خان', 'NASEER KHAN MUNIR KHAN', NULL, 7, 8, NULL, '258', 'direct', 6, '2018-03-18', '2018-03-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2452970425', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(9, 23, 'محمد ياسين عبد الصبحان', 'MOHAMMAD YASIN ABDULSOBHAN', NULL, 8, 5, NULL, '254', 'direct', 7, '2018-04-11', '2018-04-11', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2295793927', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(10, 31, 'طارق محمود محمد رزاق', 'TARIQ MEHMOOD MUHAMMAD RAZZAQ', NULL, 6, 5, NULL, '254', 'direct', 5, '2018-03-27', '2018-03-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2452969112', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(11, 33, 'مختار أحمد علي محمد', 'MUKHTAR AHMAD ALI MUHAMMAD', NULL, 9, 5, NULL, '254', 'direct', 8, '2018-03-27', '2018-03-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2452969252', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(12, 40, 'محمد مصطفى رستم خان', 'MUHAMMAD MUSTAFA RUSTAM KHAN', NULL, 10, 5, NULL, '254', 'direct', 9, '2018-03-31', '2018-03-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2452965821', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(13, 46, 'اكبر مد اكاس علي', 'AKABBAR MD AKKAS ALI', NULL, 11, 5, NULL, '254', 'direct', 10, '2018-05-16', '2018-05-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2435293341', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(14, 47, 'منير الزمان سومان', 'MANIRRUZZAMAN SUMAN', NULL, 11, 5, NULL, '254', 'direct', 10, '2018-05-16', '2018-05-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2441859309', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(15, 48, 'نظيم الدين', 'NAZIM UDDIN', NULL, 11, 5, NULL, '254', 'direct', 10, '2018-05-16', '2018-05-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2439999885', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(16, 49, 'توفيل حسين', 'TOFAYEL HOSSEN', NULL, 11, 5, NULL, '254', 'direct', 10, '2018-06-18', '2018-06-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2457076616', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(17, 53, 'دارميندرا كومار ساه', 'DHARMENDRA KUMAR SAH', NULL, 12, 5, NULL, '254', 'direct', 11, '2018-09-08', '2018-09-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2458087901', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(18, 59, 'بشارات حسين محمد بشير', 'BASHARAT HUSSAIN MOHAMMED BASHIR', NULL, 13, 5, NULL, '254', 'direct', 12, '2018-10-22', '2018-10-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2459447088', NULL, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(19, 63, 'عمرو محمود محمد مرعى', 'Amr Mahmoud Mohamed Maree', NULL, 14, 4, NULL, '0119', 'direct', 13, '2018-11-08', '2018-11-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2326459407', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(20, 65, 'كولديب سينغ سانتوش سينغ', 'KULDEEP SINGH SANTOKH SINGH', NULL, 6, 5, NULL, '254', 'direct', 5, '2018-11-17', '2018-11-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2460635366', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(21, 66, 'بيريندرا بهادور دهانك', 'BIRENDRA BAHADUR DHANUK', NULL, 6, 5, NULL, '254', 'direct', 5, '2018-11-24', '2018-11-24', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2424415855', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(22, 67, 'رفيق خان قمر الدين خان', 'RAFIK KHAN KAMRUDDIN KHAN', NULL, 13, 5, NULL, '254', 'direct', 12, '2018-12-22', '2018-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2461699031', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(23, 68, 'محمد عويس محمد عبد الغني', 'Mohamed Owais Mohamed Abdel Ghani', NULL, 15, 3, NULL, '127', 'direct', 14, '2019-01-09', '2019-01-09', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2464784954', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(24, 69, 'محمد نور علم', 'MOHAMMOD NURUL ALAM', NULL, 16, 5, NULL, '254', 'direct', 15, '2018-10-01', '2018-10-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2429049824', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(25, 70, 'محمد عبد الكليم', 'MOHAMMED ABDUL KHALEEM', NULL, 17, 8, NULL, '258', 'direct', 16, '2019-02-10', '2019-02-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2316749239', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(26, 72, 'ريبان سينغ جيندر سينغ', 'RIPAN SINGH GINDER SINGH', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-02-16', '2019-02-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2379711456', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(27, 73, 'رام راتان جيرنام سينغ', 'RAM RATTAN GURNAM SINGH', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-02-16', '2019-02-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2328383233', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(28, 75, 'مانيبال مهافير سينغ', 'MANIPAL MAHAVEER SINGH', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-04-03', '2019-04-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2465184972', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(29, 76, 'جيت بهادور غرتي', 'JIT BAHADUR GHARTI', NULL, 16, 5, NULL, '254', 'direct', 15, '2018-12-31', '2018-12-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2447787132', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(30, 77, 'أغني بهادر سيواكوتي', 'AGNI BAHADUR SIWAKOTI', NULL, 16, 5, NULL, '254', 'direct', 15, '2018-12-31', '2018-12-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2449810874', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(31, 78, 'قمر الزمان حسين حسين', 'QUAMRUZZAMA HUSAIN HUSAIN', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-04-14', '2019-04-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2318362114', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(32, 79, 'محمد زيشان محمد حنيف', 'MOHAMMAD ZEESHAN MOHAMMAD HANEEF', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-09-14', '2019-09-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2466944549', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(33, 80, 'مأمون علام بهويان', 'MAMUN ALAM - BHUIYAN', NULL, 18, 6, NULL, '123', 'direct', 17, '2019-04-11', '2019-04-11', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2256117207', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(34, 81, 'نوشاد بوزهيكتوهو', 'NOUSHAD POOZHIKUTHU ABDULLA POOZHIKUTHU', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-04-21', '2019-04-21', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2337007930', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(35, 82, 'تول بهادور بوهاكمي', 'TUL BAHADUR PHAKAMI PUN', NULL, 13, 5, NULL, '254', 'direct', 12, '2019-05-01', '2019-05-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2300413511', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(36, 86, 'مونا خان حديش', 'MUNNA KHAN HADISH', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-05-22', '2019-05-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2405390663', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(37, 88, 'شفيق الرحمن عاطف خان', 'SHAFIQUR RAHMAN ATIF KHAN', NULL, 19, 5, NULL, '254', 'direct', 18, '2019-05-29', '2019-05-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2336523457', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(38, 89, 'تاج الدين خان شمشاد خان', 'TAJUDDIN KHAN SHAMSHAD KHAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-05-29', '2019-05-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2337006338', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(39, 93, 'جانجا راج بومجان', 'GANGA RAJ BHOMJAN', NULL, 13, 5, NULL, '254', 'direct', 12, '2019-06-18', '2019-06-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2383719891', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(40, 94, 'جورميت شاند سيتا رام', 'GURMEET CHAND SITA RAM', NULL, 13, 5, NULL, '254', 'direct', 12, '2019-06-19', '2019-06-19', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2394989194', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(41, 97, 'أجيجو رحمان', 'AJIJU RAHAMAN', NULL, 11, 5, NULL, '254', 'direct', 10, '2019-07-01', '2019-07-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2438469104', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(42, 100, 'فيجاي كومار مويندر بال', 'VIJAY KUMAR MOHINDER PAL', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-05-10', '2019-05-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2347395044', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(43, 101, 'محمد شافعي باتاني', 'MUHAMMED SHAFI PATTANI', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-07-09', '2019-07-09', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2440229884', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(44, 102, 'حسام الدين أنصاري مصطفى أنصاري', 'HASMUDDIN ANSARI MUSTKIM ANSARI', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-09-29', '2019-09-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2470302668', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(45, 105, 'سانتوش رامناث', 'SANTOSH RAMNATH', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-08-01', '2019-08-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2472272752', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(46, 106, 'محمد عزيز خان', 'MOHAMMED AJIJ KHAN', NULL, 13, 5, NULL, '254', 'direct', 12, '2019-06-23', '2019-06-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2472198288', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(47, 107, 'تاجيندر سينغ نيرمال سينغ', 'TAJINDER SINGH NIRMAL SINGH', NULL, 7, 8, NULL, '258', 'direct', 6, '2019-08-08', '2019-08-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2477729590', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(48, 108, 'سوجيت كومار بوربي', 'SUJIT KUMAR PURBEY', NULL, 11, 5, NULL, '254', 'direct', 10, '2019-05-02', '2019-05-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2468052135', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(49, 109, 'ديبندرا كومار ماندال', 'DIPENDRA KUMAR MANDAL', NULL, 11, 5, NULL, '254', 'direct', 10, '2019-05-02', '2019-05-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2468050915', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(50, 110, 'محمد حسين عبد الرشيد', 'MOHAMMED HOSSAIN ABDURRASHID', NULL, 13, 5, NULL, '254', 'direct', 12, '2019-08-17', '2019-08-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2187903162', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(51, 111, 'منير عبد راشد', 'MONIR ABDUR RASHID', NULL, 16, 5, NULL, '254', 'direct', 15, '2019-08-17', '2019-08-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2441034408', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(52, 112, 'مد نور محمد ميلون', 'MD NUR MUHAMMAD MILON', NULL, 20, 8, NULL, '258', 'direct', 19, '2019-08-18', '2019-08-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2441221831', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(53, 113, 'ماني مغراسيا جالينديز', 'MANNY MAGRACIA GALINDEZ', NULL, 21, 7, NULL, '221', 'direct', 20, '2019-08-28', '2019-08-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2365151808', 173, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(54, 116, 'ساجد - احمد', 'SAJID - - AHMED', NULL, 22, 6, NULL, '123', 'direct', 21, '2019-06-03', '2019-06-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2246083808', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(55, 117, 'محمد مسلم فيباري', 'MOHAMMED MUSLEEM VEPARI', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-06-13', '2019-06-13', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2470579620', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(56, 119, 'محمد عادل ابو الحمص', 'Mohamed Adel Abu Al-Homs', NULL, 23, 4, NULL, '1', 'direct', 22, '2019-09-03', '2019-09-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 191, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(57, 120, 'محمد الشهراني', 'Mohammed Al Shahrani', NULL, 24, 12, NULL, '1', 'direct', 23, '2019-09-15', '2019-09-15', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 191, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(58, 122, 'عبداللة احمد عبدالله محمد الاصبحي', 'Abdullah Ahmed Abdullah Mohammed Al-Asbahi', NULL, 14, 4, NULL, '0119', 'direct', 13, '2019-09-21', '2019-09-21', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2052964943', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(59, 123, 'محمد محمد شعبان التهامي', 'Mohamed Mohamed Shaaban Tohamy', NULL, 25, 6, NULL, '1', 'direct', 24, '2019-09-22', '2019-09-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2357717764', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(60, 125, 'محمد مجيب محمد شكيل', 'MOHAMMAD MOJIB MOHAMMAD SHAKIL', NULL, 26, 5, NULL, '254', 'direct', 25, '2019-11-02', '2019-11-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2408179105', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(61, 126, 'كولديب كانيل سينغ', 'KULDEEP KAENAIL SINGH', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-11-03', '2019-11-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2282035928', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(62, 127, 'خالد محمد البيومى سويدان', 'Khaled Mohammed Al-Bayoumi Swedan', NULL, 15, 3, NULL, '1', 'direct', 26, '2019-11-02', '2019-11-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2297275923', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(63, 129, 'محمد نصرت سروار خان', 'MOHAMMAD NASRAT SARWAR KHAN', NULL, 13, 5, NULL, '254', 'direct', 12, '2019-12-02', '2019-12-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2482722820', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(64, 130, 'ناريندرا بهادور بوهارا', 'NARENDRA BAHADUR BOHARA', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-12-20', '2019-12-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2482723125', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(65, 132, 'بيد بركاش بال', 'BED PRAKASH PAL', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-12-22', '2019-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2487176832', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(66, 133, 'عبدالله عبدالرحمن هبه قاسم', 'Abdullah Abdul Rahman Heba Qassem', NULL, 28, 11, NULL, '1', 'direct', 27, '2020-01-01', '2020-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2056710904', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(67, 134, 'راجويندر ملكيت سينغ', 'RAJWINDER MALKIT SINGH', NULL, 6, 5, NULL, '254', 'direct', 5, '2020-01-04', '2020-01-04', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2486925395', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(68, 135, 'محمد إرشاد', 'Muhammad Irshad', NULL, 29, 8, NULL, '258', 'direct', 28, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(69, 136, 'بير بهادور كومار', 'BIR BAHADUR KUWAR', NULL, 6, 5, NULL, '254', 'direct', 5, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2492646803', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(70, 142, 'بالكال عبد الرازق', 'PALACKAL ABDULRAZACK', NULL, 30, 10, NULL, '5', 'direct', 29, '2020-01-25', '2020-01-25', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2171867035', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(71, 144, 'إسلام فرحات', 'Islam Farhat', NULL, 10, 5, NULL, '254', 'direct', 9, '2018-01-01', '2018-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(72, 145, 'محمد شكيل', 'Mohamed Shakeel', NULL, 29, 8, NULL, '258', 'direct', 28, '2018-10-22', '2018-10-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(73, 147, 'عدنان خان', 'Adnan Khan', NULL, 31, 8, NULL, '258', 'direct', 30, '2019-10-02', '2019-10-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(74, 150, 'محمود مجدى', 'Mahmoud Majdi', NULL, 12, 5, NULL, '254', 'direct', 11, '2019-03-14', '2019-03-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(75, 151, 'محمد عبد المنعم عبد اللطيف علي', 'Mohamed Abdel Moneim Abdel Latif Ali', NULL, 14, 4, NULL, '0119', 'direct', 13, '2019-11-03', '2019-11-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(76, 160, 'عبدالله على', 'Abdullah Ali', NULL, 32, 5, NULL, '254', 'direct', 31, '2019-04-19', '2019-04-19', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(77, 164, 'محمد نعيم شمروز خان', 'MUHAMMAD NAEEM SHAMROZ KHAN', NULL, 12, 5, NULL, '254', 'direct', 11, '2020-02-04', '2020-02-04', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2487570513', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(78, 169, 'إقبال خان', 'IQBAL KHAN KAYAMKHANI', NULL, 32, 5, NULL, '254', 'direct', 31, '2020-02-11', '2020-02-11', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2322075595', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(79, 170, 'احمد الخير على حموده', 'Ahmed Al Khair Ali Hammouda', NULL, 15, 3, NULL, '127', 'direct', 14, '2020-02-15', '2020-02-15', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2487926871', 207, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(80, 171, 'محمد المجتبي يوسف احمد محمد علي', 'Muhammad al-Mujtabi Yusuf Ahmad Muhammad Ali', NULL, 33, 5, NULL, '254', 'direct', 32, '2020-02-13', '2020-02-13', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2325224570', 207, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(81, 176, 'بينود كومار شاه', 'BINOD KUMAR SAH', NULL, 6, 5, NULL, '254', 'direct', 5, '2020-02-26', '2020-02-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2492646845', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(82, 178, 'محمد شارق فهيم الدين', 'MOHAMMAD SHARIQ FAHIMUDDIN', NULL, 34, 6, NULL, '123', 'direct', 33, '2020-02-22', '2020-02-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2349840377', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(83, 180, 'منيب حيات', 'MUNIB HAYAT PAINDA KHAN', NULL, 21, 7, NULL, '221', 'direct', 20, '2020-03-07', '2020-03-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2492646738', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(84, 181, 'محمد اكثر حسين', 'MOHAMMAD AKTHER HOSSAIN', NULL, 35, 6, NULL, '123', 'direct', 19, '2020-03-13', '2020-03-13', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2489656922', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(85, 201, 'فتحي جاد', 'Fathi Gad', NULL, 13, 5, NULL, '254', 'direct', 12, '2020-05-12', '2020-05-12', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(86, 206, 'كينيث إسكوبيلا', 'KENNETH - ESCOBILLA AMANDORON', NULL, 8, 5, NULL, '254', 'direct', 7, '2020-07-01', '2020-07-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2290846514', 173, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(87, 211, 'رشيد خليل اليوبي', 'Rashid Khalil El Youbi', NULL, 24, 12, NULL, '1', 'direct', 23, '2020-08-01', '2020-08-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '1009594894', 191, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(88, 212, 'احمد جميل خليل بركات', 'Ahmed gamil Khalil Barakat', NULL, 14, 4, NULL, '0119', 'direct', 13, '2020-08-10', '2020-08-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2204968396', 168, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(89, 217, 'جويل رواتقيو نوزا', 'JEOWELL RUTAQUIO NUZA', NULL, 6, 5, NULL, '254', 'direct', 5, '2020-09-15', '2020-09-15', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2296064492', 173, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(90, 221, 'التوم ارباب عبدالرحمن كرم الدين', 'Altom Arbab Abdul Rahman Karam Al-Din', NULL, 36, 7, NULL, '1', 'direct', 23, '2020-09-14', '2020-09-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2146258781', 207, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(91, 222, 'إمتيار خان', 'IMTEAZ - - KHAN', NULL, 37, 8, NULL, '258', 'direct', 36, '2020-09-20', '2020-09-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2146203498', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(92, 243, 'محمد عبدالرحمن العوض محمد', 'Muhammad Abdul Rahman Al-Awad Muhammad', NULL, 38, 10, NULL, '5', 'direct', 37, '2020-11-02', '2020-11-02', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2253791806', 207, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(93, 244, 'محمد تنفير محمد عارف', 'MUHAMMAD TANVEER MUHAMMAD ARIF', NULL, 6, 5, NULL, '254', 'direct', 5, '2020-11-23', '2020-11-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2339432979', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(94, 248, 'حسين مياه', 'Hussein Miah', NULL, 16, 5, NULL, '254', 'direct', 15, '2021-01-01', '2021-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(95, 254, 'محمد فرحات السعيد بسيونى', 'Mohamed Farhat Al-Saeed Bassiouni', NULL, 19, 5, NULL, '1', 'direct', 38, '2021-01-07', '2021-01-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2493438804', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(96, 256, 'محمد إبراهيم', 'Mohamed Ibrahim', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-01-14', '2021-01-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2495190411', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(97, 257, 'مدثر حسين', 'Muddathir Hussain', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-01-14', '2021-01-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2495190320', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(98, 258, 'سيف محمد عبدالرحيم الخرابشه', 'Saif Muhammad Abdul Rahim Al-Kharabsheh', NULL, 40, 8, NULL, '1', 'direct', 39, '2021-01-16', '2021-01-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2493438861', 111, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(99, 282, 'مد عاشق ناداف', 'MD AASHIK NADAF', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-04-08', '2021-04-08', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2484292111', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(100, 284, 'خير الابرار الماس خان', 'KHAIR UL ABRAR ALMS KHAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-04-14', '2021-04-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2486676378', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(101, 285, 'بوهيرا بير بهادور', 'Bohera Bir Bahadur', NULL, 16, 5, NULL, '254', 'direct', 15, '2021-04-10', '2021-04-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2500148347', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(102, 286, 'مانسارام علي', 'MANSARAM OLI', NULL, 16, 5, NULL, '254', 'direct', 15, '2021-04-10', '2021-04-10', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2498864434', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(103, 288, 'جانج إكرار راجاك خان', 'JANG IKRAR RAJAKH KHAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-04-26', '2021-04-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2317014120', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(104, 289, 'محمد حسين ياسين', 'MOHD HUSSAIN YASEEN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-04-26', '2021-04-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2369100363', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(105, 290, 'داوود خان ناثو خان', 'DAWAD KHAN NATTHU KHAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-04-26', '2021-04-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2374286959', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(106, 294, 'دولال شمس الحق', 'DULAL - - SAMSULHAQ', NULL, 17, 8, NULL, '258', 'direct', 16, '2021-05-05', '2021-05-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2202537664', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(107, 295, 'محفوظ علام بوهيان', 'MAFUZ ALAM BHUIYAN', NULL, 34, 6, NULL, '123', 'direct', 33, '2021-06-01', '2021-06-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2437882687', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(108, 296, 'إميت كومار شاراما', 'Emit Kumar Sharma', NULL, 41, 8, NULL, '258', 'direct', 40, '2021-05-20', '2021-05-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(109, 308, 'سانجاي ماهاتو', 'Sanjay Mahato', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-06-05', '2021-06-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(110, 309, 'رام بهادر سونار', 'Ram Bahadur Sonar', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-06-05', '2021-06-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(111, 310, 'اشيش باريلي', 'Ashish Bareilly', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-06-05', '2021-06-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(112, 314, 'محمد شميم شريف', 'Muhammad Shamim Sharif', NULL, 39, 5, NULL, '255', 'direct', 18, '2021-06-27', '2021-06-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(113, 323, 'ساجد محمود همت خان', 'SAJID MEHMOOD HIMAT KHAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2019-06-03', '2019-06-03', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2424552699', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(114, 324, 'بلجيندر كومار سوليندر كومار', 'BALJINDER KUMAR SURINDER KUMAR', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-08-07', '2021-08-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2378076364', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(115, 330, 'صابر حسين محمد اسلم', 'SABIR HUSSAIN MUHAMMAD ASLAM', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-08-09', '2021-08-09', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2325122584', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(116, 331, 'فورهاد حسين مد فاروق حسين', 'FORHAD HOSSAIN MD FARUQ HOSSAIN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-08-01', '2021-08-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2499663983', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(117, 332, 'تريبهان كوات', 'TRIBHAN KEWAT', NULL, 13, 5, NULL, '254', 'direct', 12, '2021-08-26', '2021-08-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2503861201', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(118, 333, 'موتي لال تمانغ', 'MOTI LAL TAMANG', NULL, 13, 5, NULL, '254', 'direct', 12, '2021-08-26', '2021-08-26', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2503861128', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(119, 334, 'كبيندرا شريستا', 'KHUPENDRA SHRESTHA', NULL, 11, 5, NULL, '254', 'direct', 10, '2021-09-20', '2021-09-20', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2506534763', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(120, 335, 'زيد علي احمد محسن', 'Zaid Ali Ahmed Mohsen', NULL, 41, 8, NULL, '258', 'direct', 40, '2021-09-14', '2021-09-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2134516216', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(121, 336, 'عادل شهر زاد صابر زمان', 'ADIL SHAHZAD SABIR ZAMAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-10-07', '2021-10-07', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2314618840', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(122, 338, 'محمد عارف', 'Mohammed Arif', NULL, 32, 5, NULL, '254', 'direct', 31, '2021-07-29', '2021-07-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(123, 341, 'صدام جاه الله', 'Saddam Jah Allah', NULL, 42, 5, NULL, '254', 'direct', 41, '2021-10-28', '2021-10-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 207, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(124, 342, 'محمد رحمن', 'Muhammad Rahman', NULL, 32, 5, NULL, '254', 'direct', 31, '2021-10-28', '2021-10-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(125, 343, 'طالب مانجار إمام', 'TALIB MANJAR IMAM', NULL, 43, 6, NULL, '123', 'direct', 42, '2021-11-06', '2021-11-06', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2506533526', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(126, 344, 'كيشان شوهدري', 'KISHAN CHAUDHARY', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-11-05', '2021-11-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2421168291', 153, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(127, 345, 'محمد حبيب', 'MOHAMMAD HABIB MIR MAST KHAN', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-11-05', '2021-11-05', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2313865178', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(128, 346, 'بابلو باداش جوسوامي', 'BABLU BADSAH GOSWAMI', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-11-14', '2021-11-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, '2506534037', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(129, 347, 'برامود كومار', 'Pramod Kumar', NULL, 11, 5, NULL, '254', 'direct', 10, '2021-11-14', '2021-11-14', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(130, 348, 'أحمد الفرح', 'Ahmed Al Farah', NULL, 20, 8, NULL, '258', 'direct', 19, '2021-12-01', '2021-12-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(131, 350, 'منصور القحطاني', 'Mansour Al-Qahtani', NULL, 24, 12, NULL, '1', 'direct', 23, '2021-12-18', '2021-12-18', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 191, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(132, 351, 'عبدالغني', 'Abdul Ghani', NULL, 44, 9, NULL, '1', 'direct', 43, '2021-11-28', '2021-11-28', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(133, 352, 'محمد عمران', 'Muhammad Imran', NULL, 11, 5, NULL, '254', 'direct', 10, '2021-12-16', '2021-12-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(134, 353, 'ذو الفقار أحمد', 'Zulfiqar Ahmed', NULL, 45, 8, NULL, '258', 'direct', 44, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(135, 354, 'مجاهد شيخ', 'Mujahid Sheikh', NULL, 46, 5, NULL, '254', 'direct', 45, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(136, 355, 'شعيب حيدر', 'Shoaib Haider', NULL, 46, 5, NULL, '254', 'direct', 45, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(137, 356, 'محمد أزاد', 'Muhammad Azad', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-12-22', '2021-12-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55');
INSERT INTO `users-blank-test` (`id`, `emp_id`, `first_name`, `last_name`, `email`, `role_id`, `department_id`, `mobile_no`, `report_to_id`, `source_of_hire`, `designation_id`, `join_date`, `confirm_date`, `status`, `emp_type`, `profile_image`, `address`, `city`, `state`, `country_id`, `postal_code`, `dob`, `marital_status`, `gender`, `email_token`, `email_verified_at`, `password`, `is_active`, `driving_licence`, `remember_token`, `id_number`, `nationality_id`, `pay_overtime`, `initial_trip`, `initial_rate`, `additional_trip`, `additional_rate`, `created_at`, `updated_at`) VALUES
(138, 357, 'محمد رضاه', 'Mohammed Reza', NULL, 46, 5, NULL, '254', 'direct', 45, '2021-12-23', '2021-12-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(139, 358, 'محمد جامروز', 'Muhammad Jamrooz', NULL, 6, 5, NULL, '255', 'direct', 5, '2021-12-29', '2021-12-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(140, 359, 'عثمان خان', 'Usman Khan', NULL, 47, 8, NULL, '258', 'direct', 46, '2021-12-27', '2021-12-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(141, 362, 'غفار خان', 'Ghaffar Khan', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-12-30', '2021-12-30', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(142, 363, 'مبارك خان', 'Mubarak Khan', NULL, 6, 5, NULL, '254', 'direct', 5, '2021-12-31', '2021-12-31', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(143, 364, 'علي ماهر العزوني', 'Ali Maher El Azouny', NULL, 48, 2, NULL, '1', 'direct', 47, '2022-01-01', '2022-01-01', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 64, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(144, 366, 'محمود سهيل', 'Mahmoud Shohel', NULL, 49, 5, NULL, '254', 'direct', 48, '2022-01-16', '2022-01-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 18, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(145, 367, 'انيس محمد باني', 'Anis Muhammed Bani', NULL, 50, 4, NULL, '0119', 'direct', 49, '2022-01-16', '2022-01-16', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(146, 368, 'ناجي محمد سيف محسن', 'Naji Muhammed Seif Mohsen', NULL, 20, 8, NULL, '258', 'direct', 19, '2022-01-17', '2022-01-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(147, 369, 'اكرم فضل محمد احمد', 'Akram Fadel Mohamed Ahmed', NULL, 20, 8, NULL, '258', 'direct', 19, '2022-01-17', '2022-01-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(148, 370, 'عدي عدنان محمد احمد', 'Uday Adnan Mohamed Ahmed', NULL, 20, 8, NULL, '258', 'direct', 19, '2022-01-17', '2022-01-17', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 243, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(149, 371, 'محمد انصاري', 'Muhammad Ansari', NULL, 6, 5, NULL, '254', 'direct', 5, '2022-01-22', '2022-01-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(150, 372, 'رحمان منجهي', 'Rahman Munjhi', NULL, 20, 5, NULL, '254', 'direct', 19, '2022-01-22', '2022-01-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(151, 373, 'فارمان بوتان', 'Farman Bhutan', NULL, 20, 5, NULL, '254', 'direct', 19, '2022-01-22', '2022-01-22', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(152, 374, 'شاندانا روان', 'chandana rawan', NULL, 6, 5, NULL, '254', 'direct', 5, '2022-01-23', '2022-01-23', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(153, 375, 'محمد زبير', 'Muhammed Zubair', NULL, 41, 8, NULL, '258', 'direct', 40, '2022-01-27', '2022-01-27', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 166, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(154, 376, 'رامبوكار ماندال', 'Rambokar Mandal', NULL, 20, 5, NULL, '254', 'direct', 19, '2022-01-29', '2022-01-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(155, 377, 'شكيل خان', 'Shakil Khan', NULL, 6, 5, NULL, '254', 'direct', 5, '2022-01-29', '2022-01-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(156, 378, 'عمران قاسم', 'Imran Qassem', NULL, 6, 5, NULL, '254', 'direct', 5, '2022-01-29', '2022-01-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(157, 379, 'محمد ساجد', 'Mohammed Sajid', NULL, 6, 5, NULL, '254', 'direct', 5, '2022-01-29', '2022-01-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(158, 380, 'نسيم شوكت', 'Naseem Shawkat', NULL, 6, 5, NULL, '254', 'direct', 5, '2022-01-29', '2022-01-29', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 101, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(159, 148, 'أبو بكر ادريس', 'Abu Bakr Idris', NULL, 30, 10, NULL, '5', 'direct', 29, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(160, 152, 'على محمد', 'Ali Muhammad', NULL, 51, 10, NULL, '5', 'direct', 50, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(161, 154, 'عثمان عبدالله', 'Osman Abdullah', NULL, 52, 5, NULL, '254', 'direct', 51, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(162, 156, 'محمد محمود', 'Mohamed Mahmoud', NULL, 46, 5, NULL, '254', 'direct', 45, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(163, 157, 'عيسى محمد', 'Issa Muhammad', NULL, 53, 9, NULL, '1', 'direct', 52, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(164, 161, 'إدريس أول', 'Idris Owl', NULL, 46, 5, NULL, '254', 'direct', 45, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(165, 213, 'إسماعيل محمد', 'Ismaiel Muhammad', NULL, 54, 6, NULL, '123', 'direct', 53, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(166, 246, 'صدام حسين', 'Saddam Hussein', NULL, 46, 5, NULL, '254', 'direct', 45, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(167, 255, 'إبراهيم موسى', 'Ibrahim Musa', NULL, 55, 7, NULL, '221', 'direct', 54, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(168, 259, 'يحيى إدريس', 'Yahya Idris', NULL, 56, 9, NULL, '254', 'direct', 55, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(169, 265, 'نور جمال', 'Noor Jamal', NULL, 36, 8, NULL, '258', 'direct', 19, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(170, 266, 'إبراهيم سراج', 'Ibrahim Siraj', NULL, 55, 7, NULL, '221', 'direct', 54, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(171, 304, 'محمد عابدين أندركي', 'Mohamed Abdeen Andreki', NULL, 57, 5, NULL, '254', 'direct', 56, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(172, 306, 'عبده علي داوود', 'Abdo Ali Dawood', NULL, 55, 7, NULL, '221', 'direct', 54, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(173, 307, 'أدم حسن محمد', 'Adam Hassan Muhammed', NULL, 46, 5, NULL, '254', 'direct', 45, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55'),
(174, 329, 'محمد أمين', 'Mohammed Ameen', NULL, 46, 5, NULL, '254', 'direct', 45, 'null', 'null', 'active', 'permanant', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$i2656Rch.N/SE/UoMJpC4eAoJ6Sf9zQbtILlaYMCXn/1q9DkDKhSq', 1, NULL, NULL, 'null', 69, 'no', 0, 0, 0, 0, '2022/02/13 10:55', '2022/02/13 10:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`id`, `user_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 127, 'probation_count', '1', '2022-02-14 09:24:06', '2022-02-14 09:24:06'),
(2, 127, 'probation_unit', 'day', '2022-02-14 09:24:06', '2022-02-14 09:24:06'),
(3, 14121172, 'company', 'sadas', NULL, NULL),
(4, 14121173, 'company', 'gggg', NULL, NULL),
(5, 158, 'probation_count', '0', '2022-02-14 18:23:07', '2022-02-14 20:17:12'),
(6, 158, 'probation_unit', 'day', '2022-02-14 18:23:07', '2022-02-14 20:17:12'),
(137, 14121174, 'company', 'Nayef Al-Harthy', NULL, NULL),
(138, 14121177, 'company', 'مؤسسة حصاد التمليك للمقاولات', NULL, NULL),
(134, 14121178, 'company', 'مجموعة جدة الأولى', NULL, NULL),
(164, 14121175, 'company', 'شركة المباني الخليجية المتطورة للمقاولات', NULL, NULL),
(132, 14121180, 'company', 'مؤسسة احمد عطية جيران الراجحي للتطوير العقاري', NULL, NULL),
(133, 14121179, 'company', 'مؤسسة البنيان المتقدمة للتطوير العقاري', NULL, NULL),
(135, 14121176, 'company', 'مؤسسة سعد سفر عايض الحارثي للتطوير العقاري', NULL, NULL),
(131, 14121181, 'company', 'مؤسسة رسوخ العمرانية للخدمات العقارية', NULL, NULL),
(29, 14121182, 'company', 'Test Company', NULL, NULL),
(30, 14121183, 'company', 'test', NULL, NULL),
(31, 112, 'probation_count', '90', '2022-02-15 19:50:27', '2022-02-15 19:50:27'),
(32, 112, 'probation_unit', 'day', '2022-02-15 19:50:27', '2022-02-15 19:50:27'),
(33, 14121184, 'probation_count', '3', NULL, NULL),
(34, 14121184, 'probation_unit', 'month', NULL, NULL),
(221, 14121186, 'company', 'ابراهيم ضيف الله السلمي', NULL, NULL),
(37, 13, 'probation_count', '90', '2022-02-24 21:01:59', '2022-02-24 21:01:59'),
(38, 13, 'probation_unit', 'day', '2022-02-24 21:01:59', '2022-02-24 21:01:59'),
(39, 15, 'probation_count', '90', '2022-02-26 22:08:38', '2022-02-26 22:08:38'),
(40, 15, 'probation_unit', 'day', '2022-02-26 22:08:38', '2022-02-26 22:08:38'),
(41, 14121187, 'probation_count', '90', NULL, NULL),
(42, 14121187, 'probation_unit', 'month', NULL, NULL),
(43, 14121188, 'probation_count', '3', NULL, NULL),
(44, 14121188, 'probation_unit', 'month', NULL, NULL),
(45, 14121189, 'probation_count', '3', NULL, NULL),
(46, 14121189, 'probation_unit', 'month', NULL, NULL),
(47, 14121190, 'probation_count', '3', NULL, NULL),
(48, 14121190, 'probation_unit', 'month', NULL, NULL),
(49, 14121191, 'probation_count', '3', NULL, NULL),
(50, 14121191, 'probation_unit', 'month', NULL, NULL),
(51, 145, 'probation_count', '90', '2022-03-03 23:02:32', '2022-03-03 23:02:32'),
(52, 145, 'probation_unit', 'day', '2022-03-03 23:02:32', '2022-03-03 23:02:32'),
(53, 14121192, 'probation_count', '3', NULL, NULL),
(54, 14121192, 'probation_unit', 'month', NULL, NULL),
(55, 14121193, 'probation_count', '3', NULL, NULL),
(56, 14121193, 'probation_unit', 'month', NULL, NULL),
(57, 14121194, 'probation_count', '3', NULL, NULL),
(58, 14121194, 'probation_unit', 'month', NULL, NULL),
(59, 14121195, 'probation_count', '3', NULL, NULL),
(60, 14121195, 'probation_unit', 'month', NULL, NULL),
(61, 14121196, 'probation_count', '3', NULL, NULL),
(62, 14121196, 'probation_unit', 'month', NULL, NULL),
(63, 14, 'probation_count', '90', '2022-03-03 23:31:26', '2022-03-03 23:31:26'),
(64, 14, 'probation_unit', 'day', '2022-03-03 23:31:26', '2022-03-03 23:31:26'),
(65, 86, 'probation_count', '90', '2022-03-03 23:39:21', '2022-03-03 23:39:21'),
(66, 86, 'probation_unit', 'day', '2022-03-03 23:39:21', '2022-03-03 23:39:21'),
(67, 9, 'probation_count', '90', '2022-03-03 23:40:33', '2022-03-03 23:40:33'),
(68, 9, 'probation_unit', 'day', '2022-03-03 23:40:33', '2022-03-03 23:40:33'),
(69, 16, 'probation_count', '90', '2022-03-03 23:41:52', '2022-03-03 23:41:52'),
(70, 16, 'probation_unit', 'day', '2022-03-03 23:41:52', '2022-03-03 23:41:52'),
(71, 150, 'probation_count', '0', '2022-03-05 06:22:09', '2022-03-05 06:22:09'),
(72, 150, 'probation_unit', 'day', '2022-03-05 06:22:09', '2022-03-05 06:22:09'),
(73, 154, 'probation_count', '90', '2022-03-05 06:24:42', '2022-03-17 17:58:58'),
(74, 154, 'probation_unit', 'day', '2022-03-05 06:24:42', '2022-03-05 06:24:42'),
(75, 17, 'probation_count', '1', '2022-03-05 09:43:19', '2022-03-05 09:43:19'),
(76, 17, 'probation_unit', 'day', '2022-03-05 09:43:19', '2022-03-05 09:43:19'),
(77, 33, 'probation_count', '1', '2022-03-05 09:46:24', '2022-03-05 09:46:24'),
(78, 33, 'probation_unit', 'day', '2022-03-05 09:46:24', '2022-03-05 09:46:24'),
(79, 14121197, 'probation_count', '3', NULL, NULL),
(80, 14121197, 'probation_unit', 'month', NULL, NULL),
(81, 14121198, 'probation_count', '3', NULL, NULL),
(82, 14121198, 'probation_unit', 'month', NULL, NULL),
(83, 14121199, 'probation_count', '3', NULL, NULL),
(84, 14121199, 'probation_unit', 'month', NULL, NULL),
(85, 14121200, 'probation_count', '3', NULL, NULL),
(86, 14121200, 'probation_unit', 'month', NULL, NULL),
(87, 14121201, 'probation_count', '3', NULL, NULL),
(88, 14121201, 'probation_unit', 'month', NULL, NULL),
(89, 14121202, 'probation_count', '3', NULL, NULL),
(90, 14121202, 'probation_unit', 'month', NULL, NULL),
(91, 14121203, 'probation_count', '3', NULL, NULL),
(92, 14121203, 'probation_unit', 'month', NULL, NULL),
(93, 14121204, 'probation_count', '3', NULL, NULL),
(94, 14121204, 'probation_unit', 'month', NULL, NULL),
(95, 14121205, 'probation_count', '3', NULL, NULL),
(96, 14121205, 'probation_unit', 'month', NULL, NULL),
(130, 14121185, 'company', 'مؤسسة كرسال العقارية', NULL, NULL),
(214, 14121206, 'company', 'بدر عبدالله الخماش', NULL, NULL),
(203, 14121207, 'company', 'مؤسسة تحقيق الامل للمقاولات', NULL, NULL),
(124, 14121208, 'company', 'هبه سالم محمد الشقاع', NULL, NULL),
(208, 14121209, 'company', 'معيوض رداد المالكي', NULL, NULL),
(122, 14121210, 'company', 'شركة ديار الرائدة للمقاولات العامة 604 أ', NULL, NULL),
(121, 14121211, 'company', 'مؤسسة مروان إبراهيم انديجاني', NULL, NULL),
(120, 14121212, 'company', 'مؤسسة هواي غير للمقاولات العامة', NULL, NULL),
(119, 14121213, 'company', 'سليمان رميح محمد الرميح', NULL, NULL),
(129, 14121214, 'company', 'مؤسسة الصروح الحديثة للمقاولات المعمارية', NULL, NULL),
(163, 14121215, 'company', 'شركة الموسع التجارية', NULL, NULL),
(116, 14121216, 'company', 'مؤسسة لمسات التمليك العقارية', NULL, NULL),
(115, 14121217, 'company', 'شركة بان للتطوير العقاري', NULL, NULL),
(162, 14121218, 'company', 'شركة روز للمقاولات', NULL, NULL),
(161, 14121219, 'company', 'شركة بروج التمليك العقارية', NULL, NULL),
(142, 14121220, 'company', 'مؤسسة البراق الذهبي للتطير العقاري', NULL, NULL),
(160, 14121221, 'company', 'شركة نخبة المباني', NULL, NULL),
(205, 14121222, 'company', 'مؤسسة روعة الاتقان للتطوير العقاري', NULL, NULL),
(145, 14121223, 'company', 'خالد إبراهيم علي الدوسري', NULL, NULL),
(146, 14121224, 'company', 'مؤسسة ملقا للعقارات', NULL, NULL),
(147, 14121225, 'company', 'مؤسسة عمر المربعي للمقاولات', NULL, NULL),
(159, 14121226, 'company', 'شركة ماسة المدائن العقارية', NULL, NULL),
(149, 14121227, 'company', 'مؤسسة المسكن الريادي للمقاولات', NULL, NULL),
(246, 14121228, 'company', 'عبدالملك عبدالحميد زيني - انديجاني', NULL, NULL),
(151, 14121229, 'company', 'محمد احمد سعيد الشيباني', NULL, NULL),
(152, 14121230, 'company', 'طلال صالح ماطر الحربي', NULL, NULL),
(207, 14121231, 'company', 'شركة الفراس التعليمية المحدودة', NULL, NULL),
(154, 14121232, 'company', 'مؤسسة عوض محمد خليل مرضاح', NULL, NULL),
(216, 14121233, 'company', 'شركة اوتار العالمية للتطوير العقاري', NULL, NULL),
(156, 14121234, 'company', 'محمد عقيل عبدالعزيز العقيل', NULL, NULL),
(165, 14121235, 'company', 'شركة شرق الدلتا السعودية', NULL, NULL),
(166, 14121236, 'company', 'شركة بيوت النهضة العقارية', NULL, NULL),
(167, 14121237, 'company', 'شركة الوزان المتحدة لتقديم الوجبات', NULL, NULL),
(168, 14121238, 'company', 'شركة ديار العصرية العقارية', NULL, NULL),
(169, 14121239, 'company', 'مؤسسة حسين راجح الزهراني', NULL, NULL),
(170, 14121240, 'probation_count', '3', NULL, NULL),
(171, 14121240, 'probation_unit', 'month', NULL, NULL),
(172, 14121241, 'company', 'احمد عبود باحسن', NULL, NULL),
(173, 14121242, 'probation_count', '3', NULL, NULL),
(174, 14121242, 'probation_unit', 'month', NULL, NULL),
(175, 14121243, 'probation_count', '3', NULL, NULL),
(176, 14121243, 'probation_unit', 'month', NULL, NULL),
(218, 14121244, 'company', 'مؤسسة ديار التمليك العقارية', NULL, NULL),
(178, 14121245, 'company', 'مؤسسة صالح يوسف الزهراني', NULL, NULL),
(179, 14121246, 'company', 'مؤسسة صرح الجزيرة للتطوير العقاري', NULL, NULL),
(180, 14121247, 'company', 'شركة ايان الدولية العقارية', NULL, NULL),
(181, 14121248, 'company', 'مؤسسة سكون الحديثة للمقاولات', NULL, NULL),
(182, 14121249, 'company', 'توفيق محمد عبدالواحد', NULL, NULL),
(183, 14121250, 'company', 'مؤسسة اتقان الرائدة', NULL, NULL),
(184, 59, 'probation_count', '90', '2022-03-14 17:08:31', '2022-03-14 17:08:31'),
(185, 59, 'probation_unit', 'day', '2022-03-14 17:08:31', '2022-03-14 17:08:31'),
(186, 14121251, 'company', 'مؤسسة عبدالله عوض محمد خالد التجارية', NULL, NULL),
(187, 157, 'probation_count', '90', '2022-03-17 17:56:07', '2022-03-17 17:56:07'),
(188, 157, 'probation_unit', 'day', '2022-03-17 17:56:07', '2022-03-17 17:56:07'),
(189, 156, 'probation_count', '90', '2022-03-17 17:57:28', '2022-03-17 17:57:28'),
(190, 156, 'probation_unit', 'day', '2022-03-17 17:57:28', '2022-03-17 17:57:28'),
(191, 155, 'probation_count', '90', '2022-03-17 17:58:08', '2022-03-17 17:58:08'),
(192, 155, 'probation_unit', 'day', '2022-03-17 17:58:08', '2022-03-17 17:58:08'),
(193, 97, 'probation_count', '90', '2022-03-26 16:47:40', '2022-03-26 16:47:40'),
(194, 97, 'probation_unit', 'day', '2022-03-26 16:47:40', '2022-03-26 16:47:40'),
(195, 111, 'probation_count', '90', '2022-03-26 16:53:29', '2022-03-26 16:53:29'),
(196, 111, 'probation_unit', 'day', '2022-03-26 16:53:29', '2022-03-26 16:53:29'),
(197, 14121252, 'company', 'عبدالكريم دخيل الدميحي', NULL, NULL),
(198, 14121253, 'company', 'عبدالرحمن ماشع', NULL, NULL),
(199, 14121254, 'probation_count', '3', NULL, NULL),
(200, 14121254, 'probation_unit', 'month', NULL, NULL),
(202, 14121255, 'company', 'Abdulmohsen Mohamed Shuk EST Albaghdadia', NULL, NULL),
(206, 14121256, 'company', 'صباح محمد سويلم الشريف', NULL, NULL),
(209, 14121257, 'company', 'عبدالعزيز مصلح عبدالله الشيخ', NULL, NULL),
(210, 14121258, 'company', 'احمد ماشع العتيبي', NULL, NULL),
(211, 14121259, 'company', 'شركة اتحاد الماسة للمقاولات', NULL, NULL),
(212, 14121260, 'company', 'مؤسسة عطا الخير للمقاولات العامة', NULL, NULL),
(213, 14121261, 'company', 'عبدالرحمن فارس الذيابي', NULL, NULL),
(215, 14121262, 'company', 'هاني سالم احمد الخنبشي', NULL, NULL),
(217, 14121263, 'company', 'شركة المقاول الدولي المتكامل المحدودة', NULL, NULL),
(219, 14121264, 'company', 'سعد محمد سعد العجلان', NULL, NULL),
(220, 14121265, 'company', 'شركة رموز المباني للمقاولات', NULL, NULL),
(222, 14121266, 'company', 'سامي حامد السفري', NULL, NULL),
(223, 14121267, 'company', 'مؤسسة ابيات التمليك العقارية', NULL, NULL),
(224, 14121268, 'company', 'شركة ديار النهضه للمقاولات', NULL, NULL),
(225, 14121269, 'company', 'عمر زين عمور الحربي', NULL, NULL),
(226, 14121270, 'company', 'مؤسسة المنارة للتطوير العقاري', NULL, NULL),
(227, 14121271, 'company', 'شركة نمو الديار العقارية', NULL, NULL),
(228, 14121272, 'company', 'مؤسسة رسوخ المتقدمه للمقاولات العامة', NULL, NULL),
(230, 14121273, 'company', 'مؤسسة مسكن العالم الفريد للتطوير العقاري', NULL, NULL),
(231, 14121274, 'company', 'عبدالله مناور العتيبي', NULL, NULL),
(232, 14121275, 'company', 'شركة زمام للمقاولات', NULL, NULL),
(233, 14121276, 'company', 'مؤسسة ركاز التمليك للتطوير العقاري', NULL, NULL),
(236, 14121277, 'company', 'عثمان عبدالله سعيد العمودي', NULL, NULL),
(235, 14121278, 'company', 'مؤسسة اساسات برج النيل للمقاولات', NULL, NULL),
(237, 14121279, 'company', 'شركة الاندلس الخضراء للخدمات التعليمية والتربوية', NULL, NULL),
(238, 14121280, 'company', 'شركة عراب التمليك للتطوير العقاري', NULL, NULL),
(239, 14121281, 'company', 'شركة اعمار الحياة', NULL, NULL),
(240, 14121282, 'company', 'مؤسسة ماجد تيسير سكيك للمقاولات', NULL, NULL),
(241, 14121283, 'company', 'abc', NULL, NULL),
(242, 14121283, 'phone', '', NULL, NULL),
(243, 14121283, 'vat_number', '', NULL, NULL),
(244, 14121284, 'company', 'مراد ابراهيم بازار انديجاني', NULL, NULL),
(245, 14121285, 'company', 'فؤاد انديجاني', NULL, NULL),
(248, 14121286, 'company', 'نبيل  عبدالله محمود قاري', NULL, NULL),
(251, 14121287, 'company', 'علي سعيد ظاهر القحطاني', NULL, NULL),
(252, 14121288, 'company', 'شركة تلال العربية للتطوير العقاري', NULL, NULL),
(253, 14121289, 'company', 'زهير عبدالله صالح بشبيشي', NULL, NULL),
(254, 14121290, 'company', 'ابراهيم سالم اليافعي', NULL, NULL),
(255, 14121291, 'probation_count', '3', NULL, NULL),
(256, 14121291, 'probation_unit', 'month', NULL, NULL),
(257, 14121292, 'company', 'Mize Auto parts', NULL, NULL),
(258, 14121292, 'phone', '', NULL, NULL),
(259, 14121292, 'vat_number', '', NULL, NULL),
(260, 14121293, 'company', 'مؤسسة باسل صالح الصحفي للمقاولات المعمارية', NULL, NULL),
(261, 14121294, 'company', 'عبدالعزيز عاشور عبيد السيد', NULL, NULL),
(262, 14121295, 'company', 'صالح عبدالله احمد الهمامي', NULL, NULL),
(263, 14121296, 'company', 'علي عبده نصر الهبوب', NULL, NULL),
(264, 14121297, 'company', 'عبدالله عوض ملاهي عسيري', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vechicle_make`
--

CREATE TABLE `vechicle_make` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `make_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vechicle_make`
--

INSERT INTO `vechicle_make` (`id`, `make_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mercedes', '1', '2022-02-14 17:09:13', '2022-02-14 17:09:13'),
(2, 'volvo', '1', '2022-06-11 19:10:24', '2022-06-11 19:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `vechicle_model`
--

CREATE TABLE `vechicle_model` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vechicle_model`
--

INSERT INTO `vechicle_model` (`id`, `make_id`, `model_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Actros', '1', '2022-02-14 17:09:43', '2022-02-14 17:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `vechicle_repair`
--

CREATE TABLE `vechicle_repair` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `repair_id` int(11) NOT NULL,
  `vechicle_id` int(11) NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `chasis_no` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regs_no` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vin` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vechicle_year`
--

CREATE TABLE `vechicle_year` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year` varchar(10) CHARACTER SET utf8 NOT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vechicle_year`
--

INSERT INTO `vechicle_year` (`id`, `make_id`, `model_id`, `year`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2016', '1', '2022-02-14 17:10:14', '2022-02-14 17:10:14'),
(2, 1, 1, '2017', '1', '2022-02-14 17:10:24', '2022-02-14 17:10:24'),
(3, 1, 1, '2018', '1', '2022-02-14 17:10:36', '2022-02-14 17:10:36'),
(4, 1, 1, '2019', '1', '2022-02-14 17:10:53', '2022-02-14 17:10:53'),
(5, 1, 1, '2020', '1', '2022-02-14 17:11:02', '2022-02-14 17:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `maker` int(11) DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `plate_no` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `plate_letter` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `vehicle_reg` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `engine_type` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `model` int(11) DEFAULT NULL,
  `horse_power` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `color` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `vin_no` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `regs_no` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `chasis_no` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `avg` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `license_plate` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `initial_mileage` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `registration_expiry_date` date DEFAULT NULL,
  `is_active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `maker`, `name`, `driver_id`, `plate_no`, `plate_letter`, `vehicle_reg`, `engine_type`, `model`, `horse_power`, `type`, `color`, `year`, `vin_no`, `regs_no`, `chasis_no`, `avg`, `license_plate`, `initial_mileage`, `license_expiry_date`, `registration_expiry_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'M101', 55, '5422', 'ZJB', '16448218176209fd392c19b.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139759', '707044610', 'WDB93331750139759', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-14 17:22:13', '2022-02-14 17:26:57'),
(2, 1, 'M102', 64, '5423', 'ZJB', '1644822532620a00045e15b.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139768', '907044610', 'WDB93331750139768', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-14 17:38:52', '2022-02-14 17:38:52'),
(3, 1, 'M103', 115, '5424', 'ZJB', '1644843267620a51038ea4a.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139758', '696044610', 'WDB93331750139758', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-14 23:24:27', '2022-02-14 23:24:27'),
(4, 1, 'M104', 97, '5425', 'ZJB', '1644843406620a518e52dfa.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750154486', '796044610', 'WDB93331750154486', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-14 23:26:46', '2022-02-14 23:26:46'),
(5, 1, 'M105', 111, '5426', 'ZJB', '1644843888620a5370bc48d.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750154487', '307044610', 'WDB93331750154487', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-14 23:34:48', '2022-02-14 23:34:48'),
(6, 1, 'M106', 34, '5427', 'ZJB', '1644844397620a556d7280d.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139771', '7044610', 'WDB93331750139771', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-14 23:43:17', '2022-02-14 23:43:17'),
(7, 1, 'M107', 32, '5428', 'ZJB', '1644846078620a5bfe9aa0f.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750154485', '896044610', 'WDB93331750154485', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:11:18', '2022-02-15 00:11:18'),
(8, 1, 'M108', 142, '6602', 'ZJB', '1644846187620a5c6be8d09.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139757', '496044610', 'WDB93331750139757', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:13:07', '2022-02-15 00:13:07'),
(9, 1, 'M109', 103, '6603', 'ZJB', '1644846334620a5cfe32bef.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139756', '296044610', 'WDB93331750139756', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:15:34', '2022-02-15 00:15:34'),
(10, 1, 'M110', 105, '6635', 'ZJB', '1644846447620a5d6fef0b0.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139769', '676044610', 'WDB93331750139769', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:17:27', '2022-02-15 00:17:27'),
(11, 1, 'M111', 44, '6639', 'ZJB', '1644846512620a5db0774c3.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139770', '976044610', 'WDB93331750139770', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:18:32', '2022-02-15 00:18:32'),
(12, 1, 'M113', 6, '6642', 'ZJB', '1644846976620a5f80d1b99.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139737', '486044610', 'WDB93331750139737', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:26:16', '2022-02-15 00:26:16'),
(13, 1, 'M114', 89, '6643', 'ZJB', '1644847075620a5fe33cd7e.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139738', '286044610', 'WDB93331750139738', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:27:55', '2022-02-15 00:27:55'),
(14, 1, 'M115', 137, '6645', 'ZJB', '1644847152620a603092a00.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139739', '196044610', 'WDB93331750139739', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:29:12', '2022-02-15 00:29:12'),
(15, 1, 'M121', 126, '8998', 'ARB', '1644847600620a61f05bf9b.jpg', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93331750224327', '760512710', 'WDB93331750224327', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:36:40', '2022-02-15 00:36:40'),
(16, 1, 'M123', 113, '9705', 'ARB', '1644847717620a626501480.jpg', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93331750224329', '158031710', 'WDB93331750224329', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:38:37', '2022-02-15 00:38:37'),
(17, 1, 'M124', 81, '9706', 'ARB', '1644847778620a62a21e908.jpg', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93331750224330', '538031710', 'WDB93331750224330', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:39:38', '2022-02-15 00:39:38'),
(18, 1, 'M125', 156, '9703', 'ARB', '1644847841620a62e139f02.jpg', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93331750224136', '678031710', 'WDB93331750224136', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:40:41', '2022-02-15 00:40:41'),
(19, 1, 'M126', 110, '7502', 'SRB', '1644847939620a634342463.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331750344683', '85303710', 'WDB93331750344683', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:42:19', '2022-02-15 00:42:19'),
(20, 1, 'M127', 45, '7503', 'SRB', '1644848012620a638c979bc.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331750344686', '895303710', 'WDB93331750344686', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:43:32', '2022-02-15 00:43:32'),
(21, 1, 'M128', 67, '7504', 'SRB', '1644848073620a63c982806.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331750344685', '506303710', 'WDB93331750344685', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:44:33', '2022-02-15 00:44:33'),
(22, 1, 'M130', 127, '7506', 'SRB', '1644848175620a642f36983.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331750335983', '616303710', 'WDB93331750335983', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:46:15', '2022-02-15 00:46:15'),
(23, 1, 'M131', 121, '3590', 'GEA', '1644848248620a6478c1337.jpg', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93331750353325', '996334710', 'WDB93331750353325', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:47:28', '2022-02-15 00:47:28'),
(24, 1, 'M132', 141, '3591', 'GEA', '1644848309620a64b58ceaf.jpg', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93331750353323', '407334710', 'WDB93331750353323', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:48:29', '2022-02-15 00:48:29'),
(25, 1, 'M133', 109, '2552', 'VDB', '1644848386620a650275181.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331710367841', '526555710', 'WDB93331710367841', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:49:46', '2022-02-15 00:49:46'),
(26, 1, 'M134', 104, '2553', 'VDB', '1644848460620a654c36356.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331710370392', '366555710', 'WDB93331710370392', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:51:00', '2022-02-15 00:51:00'),
(27, 1, 'M135', 157, '2554', 'VDB', '1644848557620a65ad2f4c0.jpg', NULL, 1, NULL, NULL, NULL, 2020, 'WDB93331710368547', '886555710', 'WDB93331710368547', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:52:37', '2022-02-15 00:52:37'),
(28, 1, 'M137', 93, '3324', 'TSB', '1644848698620a663a3178d.pdf', NULL, 1, NULL, NULL, NULL, 2020, 'WDB933317K0333260', '913662810', 'WDB933317K0333260', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:54:58', '2022-02-15 00:54:58'),
(29, 1, 'M138', 100, '3325', 'TSB', '1644848773620a6685bb90f.pdf', NULL, 1, NULL, NULL, NULL, 2019, 'WDB933317K0333255', '903662810', 'WDB933317K0333255', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:56:13', '2022-02-15 00:56:13'),
(30, 1, 'M139', 96, '3327', 'TSB', '1644848837620a66c5aa831.pdf', NULL, 1, NULL, NULL, NULL, 2019, 'WDB933317K0334493', '592662810', 'WDB933317K0334493', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:57:17', '2022-02-15 00:57:17'),
(31, 1, 'M140', 27, '8359', 'DSB', '1644848909620a670dd6a84.pdf', NULL, 1, NULL, NULL, NULL, 2019, 'WDB933317K0334492', '881813810', 'WDB933317K0334492', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:58:29', '2022-02-15 00:58:29'),
(32, 1, 'M141', 114, '8354', 'DSB', '1644848977620a67516b569.pdf', NULL, 1, NULL, NULL, NULL, 2020, 'WDB933317K0333251', '242813810', 'WDB933317K0333251', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 00:59:37', '2022-02-15 00:59:37'),
(33, 1, 'M142', 10, '8357', 'DSB', '1644849038620a678e6f3fd.pdf', NULL, 1, NULL, NULL, NULL, 2020, 'WDB933317K0333252', '122813810', 'WDB933317K0333252', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 01:00:38', '2022-02-15 01:00:38'),
(34, 1, 'M143', 26, '8353', 'DSB', '1644849100620a67cc06bdf.pdf', NULL, 1, NULL, NULL, NULL, 2020, 'WDB933317K0333253', '642813810', 'WDB933317K0333253', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 01:01:40', '2022-02-15 01:01:40'),
(35, 1, 'M145', 31, '8358', 'DSB', '1644849187620a6823dc182.pdf', NULL, 1, NULL, NULL, NULL, 2020, 'WDB933317K0337510', '702813810', 'WDB933317K0337510', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 01:03:07', '2022-02-15 01:03:07'),
(36, 1, 'M116', 69, '9270', 'JDB', '1644883515620aee3b1720f.jpg', NULL, 1, NULL, NULL, NULL, 2016, 'WDANHBAA1GL98655', '398834610', 'WDANHBAA1GL98655', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 10:35:15', '2022-02-15 10:35:15'),
(37, 1, 'M117', 155, '9271', 'JDB', '1644883998620af01e8fb08.jpg', NULL, 1, NULL, NULL, NULL, 2016, 'WDANHBAA9GL986240', '298834610', 'WDANHBAA9GL986240', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 10:43:18', '2022-02-15 10:43:18'),
(38, 1, 'M118', 99, '9272', 'JDB', '1644884063620af05f48766.jpg', NULL, 1, NULL, NULL, NULL, 2016, 'WDANHBAA7GL985135', '309834615', 'WDANHBAA7GL985135', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 10:44:23', '2022-02-15 10:44:23'),
(39, 1, 'M120', 43, '9274', 'JDB', '1644884130620af0a2c747f.jpg', NULL, 1, NULL, NULL, NULL, 2016, 'WDANHBAA2GL986239', '288834610', 'WDANHBAA2GL986239', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 10:45:30', '2022-02-15 10:45:30'),
(40, 1, 'M112', 112, '6641', 'ZJB', '1644928783620b9f0f50c01.jpg', NULL, 1, NULL, NULL, NULL, 2018, 'WDB93331750139736', '586044610', 'WDB93331750139736', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 23:09:43', '2022-02-15 23:09:43'),
(41, 1, 'M146', 28, '069081', '1020', '1644929985620ba3c1e9f59.pdf', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93330410365957', '1020069081', 'WDB93330410365957', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-15 23:29:45', '2022-02-15 23:29:45'),
(42, 1, 'M122', 65, '156619', '1020', '1645011130620ce0bac2242.pdf', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93330410370386', '1020156619', 'WDB93330410370386', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-16 22:02:10', '2022-02-16 22:02:10'),
(43, 1, 'M147', 61, '156606', '1020', '1645012100620ce48434442.pdf', NULL, 1, NULL, NULL, NULL, 2019, 'WDB93330410365605', '1020156606', 'WDB93330410365605', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-16 22:18:20', '2022-02-16 22:18:20'),
(44, 1, 'M136', 149, '8356', 'DSB', '1645012456620ce5e8506f0.pdf', NULL, 1, NULL, NULL, NULL, 2020, 'WDB933317K0333259', '922813810', 'WDB933317K0333259', NULL, NULL, NULL, NULL, NULL, '1', '2022-02-16 22:24:16', '2022-02-16 22:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_attachment`
--

CREATE TABLE `vendor_attachment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `og_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_contact`
--

CREATE TABLE `vendor_contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_position` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_note`
--

CREATE TABLE `vendor_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_payment`
--

CREATE TABLE `vendor_payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `pay_method_id` int(11) NOT NULL,
  `trans_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_date` date NOT NULL,
  `note` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vhc_part_supply_detail`
--

CREATE TABLE `vhc_part_supply_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supply_order_id` int(11) NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1-Not yet approve , 2-Approved , 3-Reject , 4-Cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vhc_part_supply_detail`
--

INSERT INTO `vhc_part_supply_detail` (`id`, `supply_order_id`, `make_id`, `model_id`, `year_id`, `part_id`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2018, 0, 0, '2', '2022-05-17 19:19:05', '2022-06-22 00:22:03'),
(4, 2, 1, 1, 2022, 1, 1, '1', '2022-06-08 15:07:10', '2022-06-08 15:07:10'),
(6, 4, 1, 1, 2017, 1, 1, '1', '2022-06-11 19:19:27', '2022-06-11 19:19:27'),
(7, 5, 1, 1, 2020, 1, 1, '1', '2022-06-16 17:32:33', '2022-06-16 17:32:33'),
(8, 6, 2, 0, 2018, 1, 2, '1', '2022-06-22 00:20:07', '2022-06-22 00:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `vhc_purchase_parts`
--

CREATE TABLE `vhc_purchase_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `part_id` int(11) NOT NULL,
  `order_id` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supply_id` int(11) NOT NULL,
  `manufact_id` int(11) NOT NULL,
  `condition` enum('old','new') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `buy_price` double(10,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `sell_price` double(10,2) DEFAULT NULL,
  `part_no` varchar(255) CHARACTER SET utf8 NOT NULL,
  `purch_date` date DEFAULT NULL,
  `warrenty_days` int(11) DEFAULT NULL,
  `warrenty_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warrenty` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double(10,2) DEFAULT NULL,
  `given_amount` double(10,2) DEFAULT NULL,
  `pending_amount` double(10,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vhc_pur_parts_details`
--

CREATE TABLE `vhc_pur_parts_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `part_id` int(11) NOT NULL,
  `pur_order_id` int(11) NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vhc_pur_parts_details`
--

INSERT INTO `vhc_pur_parts_details` (`id`, `part_id`, `pur_order_id`, `make_id`, `model_id`, `year_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 1, 2022, '2022-05-27 21:52:57', '2022-05-27 21:52:57'),
(2, 1, 2, 0, 0, 0, '2022-05-27 21:52:57', '2022-05-27 21:52:57'),
(3, 2, 3, 1, 1, 2022, '2022-06-04 02:55:42', '2022-06-04 02:55:42'),
(4, 2, 4, 1, 1, 2022, '2022-06-11 19:13:06', '2022-06-11 19:13:06'),
(5, 1, 5, 1, 1, 2022, '2022-06-22 00:25:23', '2022-06-22 00:25:23'),
(6, 1, 5, 0, 0, 0, '2022-06-22 00:25:23', '2022-06-22 00:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `weekends`
--

CREATE TABLE `weekends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(125) CHARACTER SET utf8 NOT NULL,
  `dept_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_shift`
--

CREATE TABLE `work_shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` time DEFAULT NULL,
  `to` time DEFAULT NULL,
  `shift_margin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `margin_before` time DEFAULT NULL,
  `margin_after` time DEFAULT NULL,
  `departments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applied_leave_days`
--
ALTER TABLE `applied_leave_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_master`
--
ALTER TABLE `appointment_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `break`
--
ALTER TABLE `break`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commodity_groups`
--
ALTER TABLE `commodity_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_index` (`id`,`sortname`,`name_en`,`name_ar`,`phonecode`,`is_active`) USING BTREE;

--
-- Indexes for table `cron_check`
--
ALTER TABLE `cron_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_contact`
--
ALTER TABLE `customer_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cust_contract_attachment`
--
ALTER TABLE `cust_contract_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_note`
--
ALTER TABLE `delivery_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `del_note_qc_cube_detail`
--
ALTER TABLE `del_note_qc_cube_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earning_type`
--
ALTER TABLE `earning_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_active_status`
--
ALTER TABLE `emp_active_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_leave_policy`
--
ALTER TABLE `emp_leave_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_shifts`
--
ALTER TABLE `emp_shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_delivery_voucher`
--
ALTER TABLE `inventory_delivery_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_delivery_voucher_detail`
--
ALTER TABLE `inventory_delivery_voucher_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_receiving_voucher`
--
ALTER TABLE `inventory_receiving_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_requests`
--
ALTER TABLE `inventory_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_requests_details`
--
ALTER TABLE `inventory_requests_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments_methods`
--
ALTER TABLE `invoice_payments_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iqamas`
--
ALTER TABLE `iqamas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applicables`
--
ALTER TABLE `leave_applicables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_balance`
--
ALTER TABLE `leave_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_entitlement`
--
ALTER TABLE `leave_entitlement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_exceptions`
--
ALTER TABLE `leave_exceptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_restrictions`
--
ALTER TABLE `leave_restrictions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_categories`
--
ALTER TABLE `maintenance_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_earning`
--
ALTER TABLE `master_earning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_reimbursement`
--
ALTER TABLE `master_reimbursement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_salary`
--
ALTER TABLE `master_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_salary_details`
--
ALTER TABLE `master_salary_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `new_roles`
--
ALTER TABLE `new_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overhead_expances`
--
ALTER TABLE `overhead_expances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_department`
--
ALTER TABLE `parent_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_run`
--
ALTER TABLE `pay_run`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_schedule`
--
ALTER TABLE `pay_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pump`
--
ALTER TABLE `pump`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_contract`
--
ALTER TABLE `purchase_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_contract_attachments`
--
ALTER TABLE `purchase_contract_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_estimate`
--
ALTER TABLE `purchase_estimate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_estimate_details`
--
ALTER TABLE `purchase_estimate_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders_detail`
--
ALTER TABLE `purchase_orders_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_invoices`
--
ALTER TABLE `purchase_order_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_request_details`
--
ALTER TABLE `purchase_request_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_units`
--
ALTER TABLE `purchase_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations_detail`
--
ALTER TABLE `quotations_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reimbursement_type`
--
ALTER TABLE `reimbursement_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_pass_token`
--
ALTER TABLE `reset_pass_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_contract`
--
ALTER TABLE `sales_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_contract_details`
--
ALTER TABLE `sales_contract_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_estimate`
--
ALTER TABLE `sales_estimate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_estimate_product_quantity`
--
ALTER TABLE `sales_estimate_product_quantity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_proposal`
--
ALTER TABLE `sales_proposal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_proposal_details`
--
ALTER TABLE `sales_proposal_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_setting`
--
ALTER TABLE `site_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_received_docket_detail`
--
ALTER TABLE `stock_received_docket_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply_order`
--
ALTER TABLE `supply_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vechicle_make`
--
ALTER TABLE `vechicle_make`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vechicle_model`
--
ALTER TABLE `vechicle_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vechicle_repair`
--
ALTER TABLE `vechicle_repair`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vechicle_year`
--
ALTER TABLE `vechicle_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_attachment`
--
ALTER TABLE `vendor_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_contact`
--
ALTER TABLE `vendor_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_note`
--
ALTER TABLE `vendor_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_payment`
--
ALTER TABLE `vendor_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vhc_part_supply_detail`
--
ALTER TABLE `vhc_part_supply_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vhc_purchase_parts`
--
ALTER TABLE `vhc_purchase_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vhc_pur_parts_details`
--
ALTER TABLE `vhc_pur_parts_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekends`
--
ALTER TABLE `weekends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_shift`
--
ALTER TABLE `work_shift`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applied_leave_days`
--
ALTER TABLE `applied_leave_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_master`
--
ALTER TABLE `appointment_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barcodes`
--
ALTER TABLE `barcodes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `break`
--
ALTER TABLE `break`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodity_groups`
--
ALTER TABLE `commodity_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `cron_check`
--
ALTER TABLE `cron_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `customer_contact`
--
ALTER TABLE `customer_contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_contract_attachment`
--
ALTER TABLE `cust_contract_attachment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_note`
--
ALTER TABLE `delivery_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT for table `del_note_qc_cube_detail`
--
ALTER TABLE `del_note_qc_cube_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `earning_type`
--
ALTER TABLE `earning_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `emp_active_status`
--
ALTER TABLE `emp_active_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `emp_leave_policy`
--
ALTER TABLE `emp_leave_policy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_shifts`
--
ALTER TABLE `emp_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_delivery_voucher`
--
ALTER TABLE `inventory_delivery_voucher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_delivery_voucher_detail`
--
ALTER TABLE `inventory_delivery_voucher_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_receiving_voucher`
--
ALTER TABLE `inventory_receiving_voucher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_requests`
--
ALTER TABLE `inventory_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_requests_details`
--
ALTER TABLE `inventory_requests_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_payments_methods`
--
ALTER TABLE `invoice_payments_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iqamas`
--
ALTER TABLE `iqamas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_applicables`
--
ALTER TABLE `leave_applicables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_balance`
--
ALTER TABLE `leave_balance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_entitlement`
--
ALTER TABLE `leave_entitlement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_exceptions`
--
ALTER TABLE `leave_exceptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_restrictions`
--
ALTER TABLE `leave_restrictions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_categories`
--
ALTER TABLE `maintenance_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_earning`
--
ALTER TABLE `master_earning`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_reimbursement`
--
ALTER TABLE `master_reimbursement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_salary`
--
ALTER TABLE `master_salary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_salary_details`
--
ALTER TABLE `master_salary_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `new_roles`
--
ALTER TABLE `new_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `overhead_expances`
--
ALTER TABLE `overhead_expances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `parent_department`
--
ALTER TABLE `parent_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_run`
--
ALTER TABLE `pay_run`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_schedule`
--
ALTER TABLE `pay_schedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2045;

--
-- AUTO_INCREMENT for table `pump`
--
ALTER TABLE `pump`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchase_contract`
--
ALTER TABLE `purchase_contract`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_contract_attachments`
--
ALTER TABLE `purchase_contract_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_estimate`
--
ALTER TABLE `purchase_estimate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_estimate_details`
--
ALTER TABLE `purchase_estimate_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_orders_detail`
--
ALTER TABLE `purchase_orders_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_invoices`
--
ALTER TABLE `purchase_order_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_request_details`
--
ALTER TABLE `purchase_request_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_units`
--
ALTER TABLE `purchase_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations_detail`
--
ALTER TABLE `quotations_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reimbursement_type`
--
ALTER TABLE `reimbursement_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reset_pass_token`
--
ALTER TABLE `reset_pass_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_contract`
--
ALTER TABLE `sales_contract`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `sales_contract_details`
--
ALTER TABLE `sales_contract_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=960;

--
-- AUTO_INCREMENT for table `sales_estimate`
--
ALTER TABLE `sales_estimate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_estimate_product_quantity`
--
ALTER TABLE `sales_estimate_product_quantity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_proposal`
--
ALTER TABLE `sales_proposal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_proposal_details`
--
ALTER TABLE `sales_proposal_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `site_setting`
--
ALTER TABLE `site_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_received_docket_detail`
--
ALTER TABLE `stock_received_docket_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_order`
--
ALTER TABLE `supply_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14121298;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `vechicle_make`
--
ALTER TABLE `vechicle_make`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vechicle_model`
--
ALTER TABLE `vechicle_model`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vechicle_repair`
--
ALTER TABLE `vechicle_repair`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vechicle_year`
--
ALTER TABLE `vechicle_year`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `vendor_attachment`
--
ALTER TABLE `vendor_attachment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_contact`
--
ALTER TABLE `vendor_contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_note`
--
ALTER TABLE `vendor_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_payment`
--
ALTER TABLE `vendor_payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vhc_part_supply_detail`
--
ALTER TABLE `vhc_part_supply_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vhc_purchase_parts`
--
ALTER TABLE `vhc_purchase_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vhc_pur_parts_details`
--
ALTER TABLE `vhc_pur_parts_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `weekends`
--
ALTER TABLE `weekends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_shift`
--
ALTER TABLE `work_shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
