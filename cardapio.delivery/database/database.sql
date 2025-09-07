-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 23, 2024 at 06:25 AM
-- Server version: 5.7.39
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `up_qmenu_install`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `about_me` text,
  `video_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `about_content`
--

CREATE TABLE `about_content` (
  `id` int(11) NOT NULL,
  `about_id` int(11) DEFAULT NULL,
  `label` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `addons_list`
--

CREATE TABLE `addons_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `script_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `script_purchase_code` varchar(255) DEFAULT NULL,
  `license_name` varchar(255) DEFAULT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `active_key` varchar(255) DEFAULT NULL,
  `active_code` varchar(255) DEFAULT NULL,
  `license_code` varchar(255) DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `active_date` datetime DEFAULT NULL,
  `activated_date` datetime DEFAULT NULL,
  `is_active` int(11) DEFAULT '0',
  `is_install` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_config`
--

CREATE TABLE `admin_config` (
  `id` int(11) NOT NULL,
  `key` varchar(200) DEFAULT NULL,
  `value` longtext,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification`
--

CREATE TABLE `admin_notification` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `seen_status` int(11) NOT NULL DEFAULT '0',
  `is_admin_enable` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `seen_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification_list`
--

CREATE TABLE `admin_notification_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` longtext,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tutorial_list`
--

CREATE TABLE `admin_tutorial_list` (
  `id` int(11) NOT NULL,
  `page_title` text,
  `title` varchar(200) DEFAULT NULL,
  `uid` varchar(50) DEFAULT NULL,
  `details` longtext,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_payout_list`
--

CREATE TABLE `affiliate_payout_list` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `total_referel` int(11) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `ids` longtext,
  `referel_type` varchar(50) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `complete_date` datetime DEFAULT NULL,
  `payout_month` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `is_payment` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `allergens`
--

CREATE TABLE `allergens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `images` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `call_waiter_list`
--

CREATE TABLE `call_waiter_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_ring` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chat_list`
--

CREATE TABLE `chat_list` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL DEFAULT '0',
  `receiver_id` int(11) NOT NULL DEFAULT '0',
  `message` text,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('unseen','seen') NOT NULL DEFAULT 'unseen',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `code` varchar(2) NOT NULL,
  `dial_code` varchar(5) NOT NULL,
  `currency_name` varchar(20) NOT NULL,
  `currency_symbol` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `code`, `dial_code`, `currency_name`, `currency_symbol`, `currency_code`) VALUES
(1, 'Andorra', 'AD', '+376', 'Euro', '€', 'EUR'),
(2, 'United Arab Emirates', 'AE', '+971', 'United Arab Emirates', 'د.إ', 'AED'),
(3, 'Afghanistan', 'AF', '+93', 'Afghan afghani', '؋', 'AFN'),
(4, 'Antigua and Barbuda', 'AG', '+1268', 'East Caribbean dolla', '$', 'XCD'),
(5, 'Anguilla', 'AI', '+1264', 'East Caribbean dolla', '$', 'XCD'),
(6, 'Albania', 'AL', '+355', 'Albanian lek', 'L', 'ALL'),
(7, 'Armenia', 'AM', '+374', 'Armenian dram', '', 'AMD'),
(8, 'Angola', 'AO', '+244', 'Angolan kwanza', 'Kz', 'AOA'),
(9, 'Argentina', 'AR', '+54', 'Argentine peso', '$', 'ARS'),
(10, 'Austria', 'AT', '+43', 'Euro', '€', 'EUR'),
(11, 'Australia', 'AU', '+61', 'Australian dollar', '$', 'AUD'),
(12, 'Aruba', 'AW', '+297', 'Aruban florin', 'ƒ', 'AWG'),
(13, 'Azerbaijan', 'AZ', '+994', 'Azerbaijani manat', '', 'AZN'),
(14, 'Barbados', 'BB', '+1246', 'Barbadian dollar', '$', 'BBD'),
(15, 'Bangladesh', 'BD', '+880', 'Bangladeshi taka', '৳', 'BDT'),
(16, 'Belgium', 'BE', '+32', 'Euro', '€', 'EUR'),
(17, 'Burkina Faso', 'BF', '+226', 'West African CFA fra', 'Fr', 'XOF'),
(18, 'Bulgaria', 'BG', '+359', 'Bulgarian lev', 'лв', 'BGN'),
(19, 'Bahrain', 'BH', '+973', 'Bahraini dinar', '.د.ب', 'BHD'),
(20, 'Burundi', 'BI', '+257', 'Burundian franc', 'Fr', 'BIF'),
(21, 'Benin', 'BJ', '+229', 'West African CFA fra', 'Fr', 'XOF'),
(22, 'Bermuda', 'BM', '+1441', 'Bermudian dollar', '$', 'BMD'),
(23, 'Brazil', 'BR', '+55', 'Brazilian real', 'R$', 'BRL'),
(24, 'Bhutan', 'BT', '+975', 'Bhutanese ngultrum', 'Nu.', 'BTN'),
(25, 'Botswana', 'BW', '+267', 'Botswana pula', 'P', 'BWP'),
(26, 'Belarus', 'BY', '+375', 'Belarusian ruble', 'Br', 'BYR'),
(27, 'Belize', 'BZ', '+501', 'Belize dollar', '$', 'BZD'),
(28, 'Canada', 'CA', '+1', 'Canadian dollar', '$', 'CAD'),
(29, 'Switzerland', 'CH', '+41', 'Swiss franc', 'Fr', 'CHF'),
(30, 'Cote d\'Ivoire', 'CI', '+225', 'West African CFA fra', 'Fr', 'XOF'),
(31, 'Cook Islands', 'CK', '+682', 'New Zealand dollar', '$', 'NZD'),
(32, 'Chile', 'CL', '+56', 'Chilean peso', '$', 'CLP'),
(33, 'Cameroon', 'CM', '+237', 'Central African CFA ', 'Fr', 'XAF'),
(34, 'China', 'CN', '+86', 'Chinese yuan', '¥ or 元', 'CNY'),
(35, 'Colombia', 'CO', '+57', 'Colombian peso', '$', 'COP'),
(36, 'Costa Rica', 'CR', '+506', 'Costa Rican colón', '₡', 'CRC'),
(37, 'Cuba', 'CU', '+53', 'Cuban convertible pe', '$', 'CUC'),
(38, 'Cape Verde', 'CV', '+238', 'Cape Verdean escudo', 'Esc or $', 'CVE'),
(39, 'Cyprus', 'CY', '+357', 'Euro', '€', 'EUR'),
(40, 'Czech Republic', 'CZ', '+420', 'Czech koruna', 'Kč', 'CZK'),
(41, 'Germany', 'DE', '+49', 'Euro', '€', 'EUR'),
(42, 'Djibouti', 'DJ', '+253', 'Djiboutian franc', 'Fr', 'DJF'),
(43, 'Denmark', 'DK', '+45', 'Danish krone', 'kr', 'DKK'),
(44, 'Dominica', 'DM', '+1767', 'East Caribbean dolla', '$', 'XCD'),
(45, 'Dominican Republic', 'DO', '+1849', 'Dominican peso', '$', 'DOP'),
(46, 'Algeria', 'DZ', '+213', 'Algerian dinar', 'د.ج', 'DZD'),
(47, 'Ecuador', 'EC', '+593', 'United States dollar', '$', 'USD'),
(48, 'Estonia', 'EE', '+372', 'Euro', '€', 'EUR'),
(49, 'Egypt', 'EG', '+20', 'Egyptian pound', '£ or ج.م', 'EGP'),
(50, 'Eritrea', 'ER', '+291', 'Eritrean nakfa', 'Nfk', 'ERN'),
(51, 'Spain', 'ES', '+34', 'Euro', '€', 'EUR'),
(52, 'Ethiopia', 'ET', '+251', 'Ethiopian birr', 'Br', 'ETB'),
(53, 'Finland', 'FI', '+358', 'Euro', '€', 'EUR'),
(54, 'Fiji', 'FJ', '+679', 'Fijian dollar', '$', 'FJD'),
(55, 'Faroe Islands', 'FO', '+298', 'Danish krone', 'kr', 'DKK'),
(56, 'France', 'FR', '+33', 'Euro', '€', 'EUR'),
(57, 'Gabon', 'GA', '+241', 'Central African CFA ', 'Fr', 'XAF'),
(58, 'United Kingdom', 'GB', '+44', 'British pound', '£', 'GBP'),
(59, 'Grenada', 'GD', '+1473', 'East Caribbean dolla', '$', 'XCD'),
(60, 'Georgia', 'GE', '+995', 'Georgian lari', 'ლ', 'GEL'),
(61, 'Guernsey', 'GG', '+44', 'British pound', '£', 'GBP'),
(62, 'Ghana', 'GH', '+233', 'Ghana cedi', '₵', 'GHS'),
(63, 'Gibraltar', 'GI', '+350', 'Gibraltar pound', '£', 'GIP'),
(64, 'Guinea', 'GN', '+224', 'Guinean franc', 'Fr', 'GNF'),
(65, 'Equatorial Guinea', 'GQ', '+240', 'Central African CFA ', 'Fr', 'XAF'),
(66, 'Greece', 'GR', '+30', 'Euro', '€', 'EUR'),
(67, 'Guatemala', 'GT', '+502', 'Guatemalan quetzal', 'Q', 'GTQ'),
(68, 'Guinea-Bissau', 'GW', '+245', 'West African CFA fra', 'Fr', 'XOF'),
(69, 'Guyana', 'GY', '+595', 'Guyanese dollar', '$', 'GYD'),
(70, 'Hong Kong', 'HK', '+852', 'Hong Kong dollar', '$', 'HKD'),
(71, 'Honduras', 'HN', '+504', 'Honduran lempira', 'L', 'HNL'),
(72, 'Croatia', 'HR', '+385', 'Croatian kuna', 'kn', 'HRK'),
(73, 'Haiti', 'HT', '+509', 'Haitian gourde', 'G', 'HTG'),
(74, 'Hungary', 'HU', '+36', 'Hungarian forint', 'Ft', 'HUF'),
(75, 'Indonesia', 'ID', '+62', 'Indonesian rupiah', 'Rp', 'IDR'),
(76, 'Ireland', 'IE', '+353', 'Euro', '€', 'EUR'),
(77, 'Israel', 'IL', '+972', 'Israeli new shekel', '₪', 'ILS'),
(78, 'Isle of Man', 'IM', '+44', 'British pound', '£', 'GBP'),
(79, 'India', 'IN', '+91', 'Indian rupee', '₹', 'INR'),
(80, 'Iraq', 'IQ', '+964', 'Iraqi dinar', 'ع.د', 'IQD'),
(81, 'Iceland', 'IS', '+354', 'Icelandic króna', 'kr', 'ISK'),
(82, 'Italy', 'IT', '+39', 'Euro', '€', 'EUR'),
(83, 'Jersey', 'JE', '+44', 'British pound', '£', 'GBP'),
(84, 'Jamaica', 'JM', '+1876', 'Jamaican dollar', '$', 'JMD'),
(85, 'Jordan', 'JO', '+962', 'Jordanian dinar', 'د.ا', 'JOD'),
(86, 'Japan', 'JP', '+81', 'Japanese yen', '¥', 'JPY'),
(87, 'Kenya', 'KE', '+254', 'Kenyan shilling', 'Sh', 'KES'),
(88, 'Kyrgyzstan', 'KG', '+996', 'Kyrgyzstani som', 'лв', 'KGS'),
(89, 'Cambodia', 'KH', '+855', 'Cambodian riel', '៛', 'KHR'),
(90, 'Kiribati', 'KI', '+686', 'Australian dollar', '$', 'AUD'),
(91, 'Comoros', 'KM', '+269', 'Comorian franc', 'Fr', 'KMF'),
(92, 'Kuwait', 'KW', '+965', 'Kuwaiti dinar', 'د.ك', 'KWD'),
(93, 'Cayman Islands', 'KY', '+ 345', 'Cayman Islands dolla', '$', 'KYD'),
(94, 'Kazakhstan', 'KZ', '+7 7', 'Kazakhstani tenge', '₸', 'KZT'),
(95, 'Laos', 'LA', '+856', 'Lao kip', '₭', 'LAK'),
(96, 'Lebanon', 'LB', '+961', 'Lebanese pound', 'ل.ل', 'LBP'),
(97, 'Saint Lucia', 'LC', '+1758', 'East Caribbean dolla', '$', 'XCD'),
(98, 'Liechtenstein', 'LI', '+423', 'Swiss franc', 'Fr', 'CHF'),
(99, 'Sri Lanka', 'LK', '+94', 'Sri Lankan rupee', 'Rs or රු', 'LKR'),
(100, 'Liberia', 'LR', '+231', 'Liberian dollar', '$', 'LRD'),
(101, 'Lesotho', 'LS', '+266', 'Lesotho loti', 'L', 'LSL'),
(102, 'Lithuania', 'LT', '+370', 'Euro', '€', 'EUR'),
(103, 'Luxembourg', 'LU', '+352', 'Euro', '€', 'EUR'),
(104, 'Latvia', 'LV', '+371', 'Euro', '€', 'EUR'),
(105, 'Morocco', 'MA', '+212', 'Moroccan dirham', 'د.م.', 'MAD'),
(106, 'Monaco', 'MC', '+377', 'Euro', '€', 'EUR'),
(107, 'Moldova', 'MD', '+373', 'Moldovan leu', 'L', 'MDL'),
(108, 'Montenegro', 'ME', '+382', 'Euro', '€', 'EUR'),
(109, 'Madagascar', 'MG', '+261', 'Malagasy ariary', 'Ar', 'MGA'),
(110, 'Marshall Islands', 'MH', '+692', 'United States dollar', '$', 'USD'),
(111, 'Mali', 'ML', '+223', 'West African CFA fra', 'Fr', 'XOF'),
(112, 'Myanmar', 'MM', '+95', 'Burmese kyat', 'Ks', 'MMK'),
(113, 'Mongolia', 'MN', '+976', 'Mongolian tögrög', '₮', 'MNT'),
(114, 'Mauritania', 'MR', '+222', 'Mauritanian ouguiya', 'UM', 'MRO'),
(115, 'Montserrat', 'MS', '+1664', 'East Caribbean dolla', '$', 'XCD'),
(116, 'Malta', 'MT', '+356', 'Euro', '€', 'EUR'),
(117, 'Mauritius', 'MU', '+230', 'Mauritian rupee', '₨', 'MUR'),
(118, 'Maldives', 'MV', '+960', 'Maldivian rufiyaa', '.ރ', 'MVR'),
(119, 'Malawi', 'MW', '+265', 'Malawian kwacha', 'MK', 'MWK'),
(120, 'Mexico', 'MX', '+52', 'Mexican peso', '$', 'MXN'),
(121, 'Malaysia', 'MY', '+60', 'Malaysian ringgit', 'RM', 'MYR'),
(122, 'Mozambique', 'MZ', '+258', 'Mozambican metical', 'MT', 'MZN'),
(123, 'Namibia', 'NA', '+264', 'Namibian dollar', '$', 'NAD'),
(124, 'New Caledonia', 'NC', '+687', 'CFP franc', 'Fr', 'XPF'),
(125, 'Niger', 'NE', '+227', 'West African CFA fra', 'Fr', 'XOF'),
(126, 'Nigeria', 'NG', '+234', 'Nigerian naira', '₦', 'NGN'),
(127, 'Nicaragua', 'NI', '+505', 'Nicaraguan córdoba', 'C$', 'NIO'),
(128, 'Netherlands', 'NL', '+31', 'Euro', '€', 'EUR'),
(129, 'Norway', 'NO', '+47', 'Norwegian krone', 'kr', 'NOK'),
(130, 'Nepal', 'NP', '+977', 'Nepalese rupee', '₨', 'NPR'),
(131, 'Nauru', 'NR', '+674', 'Australian dollar', '$', 'AUD'),
(132, 'Niue', 'NU', '+683', 'New Zealand dollar', '$', 'NZD'),
(133, 'New Zealand', 'NZ', '+64', 'New Zealand dollar', '$', 'NZD'),
(134, 'Oman', 'OM', '+968', 'Omani rial', 'ر.ع.', 'OMR'),
(135, 'Panama', 'PA', '+507', 'Panamanian balboa', 'B/.', 'PAB'),
(136, 'Peru', 'PE', '+51', 'Peruvian nuevo sol', 'S/.', 'PEN'),
(137, 'French Polynesia', 'PF', '+689', 'CFP franc', 'Fr', 'XPF'),
(138, 'Papua New Guinea', 'PG', '+675', 'Papua New Guinean ki', 'K', 'PGK'),
(139, 'Philippines', 'PH', '+63', 'Philippine peso', '₱', 'PHP'),
(140, 'Pakistan', 'PK', '+92', 'Pakistani rupee', '₨', 'PKR'),
(141, 'Poland', 'PL', '+48', 'Polish z?oty', 'zł', 'PLN'),
(142, 'Portugal', 'PT', '+351', 'Euro', '€', 'EUR'),
(143, 'Palau', 'PW', '+680', 'Palauan dollar', '$', ''),
(144, 'Paraguay', 'PY', '+595', 'Paraguayan guaraní', '₲', 'PYG'),
(145, 'Qatar', 'QA', '+974', 'Qatari riyal', 'ر.ق', 'QAR'),
(146, 'Romania', 'RO', '+40', 'Romanian leu', 'lei', 'RON'),
(147, 'Serbia', 'RS', '+381', 'Serbian dinar', 'дин. or din.', 'RSD'),
(148, 'Russia', 'RU', '+7', 'Russian ruble', '', 'RUB'),
(149, 'Rwanda', 'RW', '+250', 'Rwandan franc', 'Fr', 'RWF'),
(150, 'Saudi Arabia', 'SA', '+966', 'Saudi riyal', 'ر.س', 'SAR'),
(151, 'Solomon Islands', 'SB', '+677', 'Solomon Islands doll', '$', 'SBD'),
(152, 'Seychelles', 'SC', '+248', 'Seychellois rupee', '₨', 'SCR'),
(153, 'Sudan', 'SD', '+249', 'Sudanese pound', 'ج.س.', 'SDG'),
(154, 'Sweden', 'SE', '+46', 'Swedish krona', 'kr', 'SEK'),
(155, 'Singapore', 'SG', '+65', 'Singapore Dollar', 'S$', 'SGD'),
(156, 'Slovenia', 'SI', '+386', 'Euro', '€', 'EUR'),
(157, 'Slovakia', 'SK', '+421', 'Euro', '€', 'EUR'),
(158, 'Sierra Leone', 'SL', '+232', 'Sierra Leonean leone', 'Le', 'SLL'),
(159, 'San Marino', 'SM', '+378', 'Euro', '€', 'EUR'),
(160, 'Senegal', 'SN', '+221', 'West African CFA fra', 'Fr', 'XOF'),
(161, 'Somalia', 'SO', '+252', 'Somali shilling', 'Sh', 'SOS'),
(162, 'Suriname', 'SR', '+597', 'Surinamese dollar', '$', 'SRD'),
(163, 'El Salvador', 'SV', '+503', 'United States dollar', '$', 'USD'),
(164, 'Swaziland', 'SZ', '+268', 'Swazi lilangeni', 'L', 'SZL'),
(165, 'Chad', 'TD', '+235', 'Central African CFA ', 'Fr', 'XAF'),
(166, 'Togo', 'TG', '+228', 'West African CFA fra', 'Fr', 'XOF'),
(167, 'Thailand', 'TH', '+66', 'Thai baht', '฿', 'THB'),
(168, 'Tajikistan', 'TJ', '+992', 'Tajikistani somoni', '₸', 'TJS'),
(169, 'Turkmenistan', 'TM', '+993', 'Turkmenistan manat', 'm', 'TMT'),
(170, 'Tunisia', 'TN', '+216', 'Tunisian dinar', 'د.ت', 'TND'),
(171, 'Tonga', 'TO', '+676', 'Tongan pa?anga', 'T$', 'TOP'),
(172, 'Turkey', 'TR', '+90', 'Turkish lira', '', 'TRY'),
(173, 'Trinidad and Tobago', 'TT', '+1868', 'Trinidad and Tobago ', '$', 'TTD'),
(174, 'Tuvalu', 'TV', '+688', 'Australian dollar', '$', 'AUD'),
(175, 'Taiwan', 'TW', '+886', 'New Taiwan dollar', '$', 'TWD'),
(176, 'Ukraine', 'UA', '+380', 'Ukrainian hryvnia', '₴', 'UAH'),
(177, 'Uganda', 'UG', '+256', 'Ugandan shilling', 'Sh', 'UGX'),
(178, 'United States', 'US', '+1', 'United States dollar', '$', 'USD'),
(179, 'Uruguay', 'UY', '+598', 'Uruguayan peso', '$', 'UYU'),
(180, 'Uzbekistan', 'UZ', '+998', 'Uzbekistani som', '', 'UZS'),
(181, 'Vietnam', 'VN', '+84', 'Vietnamese ??ng', '₫', 'VND'),
(182, 'Vanuatu', 'VU', '+678', 'Vanuatu vatu', 'Vt', 'VUV'),
(183, 'Wallis and Futuna', 'WF', '+681', 'CFP franc', 'Fr', 'XPF'),
(184, 'Samoa', 'WS', '+685', 'Samoan t?l?', 'T', 'WST'),
(185, 'Yemen', 'YE', '+967', 'Yemeni rial', '﷼', 'YER'),
(186, 'South Africa', 'ZA', '+27', 'South African rand', 'R', 'ZAR'),
(187, 'Zambia', 'ZM', '+260', 'Zambian kwacha', 'ZK', 'ZMW'),
(188, 'Zimbabwe', 'ZW', '+263', 'Botswana pula', 'P', 'BWP');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_list`
--

CREATE TABLE `coupon_list` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `discount` double NOT NULL,
  `total_limit` int(11) NOT NULL,
  `total_used` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_menu` int(2) NOT NULL DEFAULT '1',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `currency_code` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `time_zone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `country_name`, `currency_code`, `icon`, `time_zone`) VALUES
(1, 'Argentinian Peso', 'ARS', '&#36;', ''),
(2, 'Australian Dollar', 'AUD', '&#36;', ''),
(3, 'Brazilian Real', 'BRL', '&#36;', ''),
(4, 'Canadian Dollar', 'CAD', ' &#36;', ''),
(5, 'Swiss Franc', 'CHF', '&#67', ''),
(6, 'Czech Koruna', 'CZK', '&#75;&#269;', ''),
(7, 'Danish Krone', 'DKK', '&#107;&#114;', ''),
(8, 'Euro ', 'EUR', '&#8364;', ''),
(9, 'British Pound', 'GBP', ' &#163;', ''),
(10, 'Hong Kong Dollar', 'HKD', '&#36;', ''),
(11, 'Hungarian Forint', 'HUF', '&#70;&#116;', ''),
(12, 'Indian Rupee', 'INR', '&#8377;', ''),
(13, 'Israeli New Shekel', 'ILS', ' &#8362;', ''),
(14, 'Japanese Yen', 'JPY', ' &#165;', ''),
(15, 'Mexican Peso', 'MXN', '&#36;', ''),
(16, 'Malaysian Ringgit ', 'MYR', '&#82;&#77;', ''),
(17, 'Norwegian Krone', 'NOK', '  &#107;&#114;', ''),
(18, 'New Zealand Dollar', 'NZD', ' &#36;', ''),
(19, 'Philippine Peso', 'PHP', '&#8369;', ''),
(20, 'Polish Zloty', 'PLN', '&#122;&#322;', ''),
(21, 'Russian Ruble', 'RUB', '&#1088;&#1091;&#1073;', ''),
(22, 'Swedish Krona ', 'SEK', ' &#107;&#114;', ''),
(23, 'Singapore Dollar', 'SGD', ' &#36;', ''),
(24, 'Thai Baht', 'THB', '&#3647;', ''),
(25, 'Taiwan New Dollar', 'TWD', '&#78;&#84;&#36;', ''),
(26, 'United States Dollar', 'USD', ' &#36;', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_list`
--

CREATE TABLE `customer_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` text,
  `tax_number` varchar(255) DEFAULT NULL,
  `is_membership` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `is_pos` int(11) NOT NULL DEFAULT '0',
  `login_method` varchar(50) DEFAULT NULL,
  `uid` varchar(200) DEFAULT NULL,
  `photoUrl` varchar(200) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `images` varchar(200) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `gmap_link` varchar(200) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `question` longtext,
  `old_id` varchar(20) DEFAULT NULL,
  `is_update` int(11) NOT NULL DEFAULT '0',
  `role` varchar(30) NOT NULL DEFAULT 'customer',
  `dial_code` varchar(20) DEFAULT NULL,
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `custom_domain_list`
--

CREATE TABLE `custom_domain_list` (
  `id` int(11) NOT NULL,
  `request_id` varchar(25) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_subdomain` int(11) NOT NULL DEFAULT '0',
  `is_domain` int(11) NOT NULL DEFAULT '0',
  `approved_date` datetime NOT NULL,
  `request_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `is_ready` int(11) NOT NULL DEFAULT '0',
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `domain_type` varchar(255) NOT NULL,
  `comments` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `data_queue`
--

CREATE TABLE `data_queue` (
  `id` int(11) NOT NULL,
  `old_user_id` int(11) NOT NULL DEFAULT '0',
  `new_user_id` int(11) NOT NULL DEFAULT '0',
  `old_shop_id` int(11) NOT NULL DEFAULT '0',
  `new_shop_id` int(11) NOT NULL DEFAULT '0',
  `action_id` int(11) NOT NULL DEFAULT '0',
  `action_role` varchar(255) NOT NULL DEFAULT 'shop',
  `table_name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_area_list`
--

CREATE TABLE `delivery_area_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dine_in`
--

CREATE TABLE `dine_in` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `table_no` int(11) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `msg` longtext NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expense_category_list`
--

CREATE TABLE `expense_category_list` (
  `id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expense_list`
--

CREATE TABLE `expense_list` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `notes` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `extra_libraries`
--

CREATE TABLE `extra_libraries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `language` varchar(20) NOT NULL DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `extra_title_list`
--

CREATE TABLE `extra_title_list` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL,
  `is_required` int(2) NOT NULL DEFAULT '0',
  `is_single_select` int(2) NOT NULL DEFAULT '1',
  `orders` int(11) DEFAULT '0',
  `is_radio_btn` int(11) DEFAULT '1',
  `select_limit` int(11) NOT NULL DEFAULT '1',
  `select_max_limit` int(11) NOT NULL DEFAULT '1',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL,
  `is_default` int(2) NOT NULL DEFAULT '0',
  `max_qty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `heading`, `title`, `details`, `status`, `language`, `created_at`) VALUES
(1, '', 'How to create  Restaurant', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore repellat dicta officiis voluptates quas et enim facilis voluptatum esse cumque amet beatae assumenda, in, consequatur eos eius, eveniet temporibus asperiores?</p>', 1, 'english', '2021-02-25 16:16:51'),
(2, '', 'How to make payments', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore repellat dicta officiis voluptates quas et enim facilis voluptatum esse cumque amet beatae assumenda, in, consequatur eos eius, eveniet temporibus asperiores?</p>', 1, 'english', '2021-02-25 16:17:01'),
(3, '', 'How to subscribe', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore repellat dicta officiis voluptates quas et enim facilis voluptatum esse cumque amet beatae assumenda, in, consequatur eos eius, eveniet temporibus asperiores?</p>', 1, 'english', '2021-02-25 16:17:21'),
(4, NULL, 'How to create menu', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore repellat dicta<br></p>', 1, 'english', '2021-02-25 16:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `features` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_features` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `is_header` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `features`, `slug`, `status`, `is_features`, `created_at`, `is_header`) VALUES
(1, 'Welcome Page', 'welcome', 1, 1, '2020-09-27 11:21:49', 1),
(2, 'Menu ', 'menu', 1, 1, '2020-09-27 11:24:28', 1),
(3, 'Packages', 'packages', 1, 1, '2020-09-28 10:51:50', 1),
(4, 'specialities', 'specialities', 1, 1, '2020-09-27 17:17:21', 1),
(5, 'Qr code', 'qr-code', 1, 1, '2020-09-27 11:26:03', 0),
(6, 'Whatsapp Order', 'whatsapp', 1, 1, '2020-09-27 11:26:19', 0),
(7, 'Online Order', 'order', 1, 1, '2020-09-27 13:31:06', 0),
(8, 'Reservation', 'reservation', 1, 1, '2020-09-27 13:31:06', 1),
(9, 'Contacts', 'contacts', 1, 0, '2020-09-27 13:31:06', 1),
(10, 'Digital Payment', 'online-payment', 1, 1, '2021-06-05 12:39:21', 0),
(11, 'OneSignal & PWA', 'pwa-push', 1, 1, '2022-09-08 23:04:31', 0),
(13, 'Affiliate', 'affiliate', 1, 1, '2024-01-05 23:04:31', 0),
(14, 'Delivery Staff', 'dboy', 1, 1, '2024-08-20 23:04:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_list`
--

CREATE TABLE `hotel_list` (
  `id` int(11) NOT NULL,
  `hotel_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `room_numbers` longtext,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `how_it_works`
--

CREATE TABLE `how_it_works` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text,
  `icon` varchar(255) DEFAULT NULL,
  `is_icon` int(11) NOT NULL DEFAULT '1',
  `images` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `how_it_works`
--

INSERT INTO `how_it_works` (`id`, `title`, `details`, `icon`, `is_icon`, `images`, `thumb`, `status`, `language`, `created_at`) VALUES
(1, 'Create Your Restaurant', 'Create a new restaurant with scanning QR code or With a package', '<i class=\"fa fa-bath\" aria-hidden=\"true\"></i>', 0, 'uploads/big/d6a67c8dc3f91184f4c2461ac554d5ef.png', 'uploads/thumb/d6a67c8dc3f91184f4c2461ac554d5ef.png', 1, 'english', '2021-02-25 13:41:14'),
(2, 'Make Payment', 'After create your restaurant make a payment with PayPal, Stripe, Razorpay or Offline payment method', '<i class=\"fab fa-autoprefixer\"></i>', 1, 'uploads/big/112e1f4de3e7f5a7d39c9682b21b9913.png', 'uploads/thumb/112e1f4de3e7f5a7d39c9682b21b9913.png', 1, 'english', '2021-02-25 13:47:14'),
(3, 'Create  a menu', 'Select menus from our restaurant and make order easily with booking or home delivery', '', 0, 'uploads/big/359cf0722719344d9721ed0d5f605a82.png', 'uploads/thumb/359cf0722719344d9721ed0d5f605a82.png', 1, 'english', '2021-02-25 15:36:48'),
(4, 'Ordering via chat', 'After finalize create menu you can order via WhatsApp or can continue chat and confirm order', '<i class=\"fa fa-qrcode\" aria-hidden=\"true\"></i>', 1, 'uploads/big/73b481e4c9ee15d0e392d961600f36bf.png', 'uploads/thumb/73b481e4c9ee15d0e392d961600f36bf.png', 1, 'english', '2021-02-25 15:34:53'),
(5, 'Track order', 'Track your order by scanning QR code or send order with WhatsApp or quick response', '<i class=\"fa fa-credit-card-alt\" aria-hidden=\"true\"></i>', 1, 'uploads/big/e9a406638047f4c604b613735e05be27.png', 'uploads/thumb/e9a406638047f4c604b613735e05be27.png', 1, 'english', '2021-02-25 15:32:38'),
(6, 'Orders analytics', 'Get detailed report about your orders and earning with sales graph. Track your business grows', NULL, 1, 'uploads/big/00b9ebef97fe4be5f7a810d7197f01ca.png', 'uploads/thumb/00b9ebef97fe4be5f7a810d7197f01ca.png', 1, 'english', '2021-02-25 15:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `allergen_id` varchar(255) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `images` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `veg_type` int(11) NOT NULL DEFAULT '0',
  `price` longtext,
  `is_size` int(11) DEFAULT '0',
  `details` text NOT NULL,
  `overview` text NOT NULL,
  `is_features` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `remaining` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `img_type` int(11) NOT NULL DEFAULT '1',
  `img_url` varchar(255) DEFAULT NULL,
  `extra_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `orders` int(11) NOT NULL DEFAULT '0',
  `tax_fee` varchar(10) NOT NULL DEFAULT '0',
  `tax_status` varchar(10) NOT NULL DEFAULT '+',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `item_id` int(11) NOT NULL,
  `uid` varchar(50) DEFAULT NULL,
  `is_pos_only` int(11) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0',
  `previous_price` varchar(11) NOT NULL DEFAULT '0',
  `sub_category_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_category_list`
--

CREATE TABLE `item_category_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_content`
--

CREATE TABLE `item_content` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `label` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_extras`
--

CREATE TABLE `item_extras` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `ex_name` varchar(255) NOT NULL,
  `ex_price` double NOT NULL,
  `ex_id` int(11) NOT NULL DEFAULT '0',
  `extra_title_id` int(2) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_list`
--

CREATE TABLE `item_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `uid` varchar(50) DEFAULT NULL,
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_packages`
--

CREATE TABLE `item_packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `is_price` int(11) NOT NULL DEFAULT '0',
  `item_id` varchar(255) NOT NULL,
  `is_discount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `price` double NOT NULL,
  `final_price` double NOT NULL,
  `details` text NOT NULL,
  `overview` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `is_upcoming` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `live_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `is_special` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `is_home` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `remaining` int(11) NOT NULL,
  `table_no` int(11) NOT NULL DEFAULT '0',
  `qr_link` varchar(255) DEFAULT NULL,
  `img_type` int(11) NOT NULL DEFAULT '1',
  `img_url` varchar(255) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `uid` varchar(20) DEFAULT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `tax_fee` varchar(50) DEFAULT '0',
  `tax_status` varchar(2) DEFAULT '+',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_packages_list`
--

CREATE TABLE `item_packages_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `language` varchar(30) NOT NULL DEFAULT 'english',
  `is_special` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_sizes`
--

CREATE TABLE `item_sizes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `direction` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `lang_name`, `slug`, `direction`, `status`, `created_at`) VALUES
(3, 'English', 'english', 'ltr', 1, '2020-09-22 16:42:51'),
(6, 'Spanish', 'es', 'ltr', 1, '2021-04-14 15:15:20'),
(8, 'Arabics', 'ar', 'rtl', 1, '2021-04-15 11:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `language_data`
--

CREATE TABLE `language_data` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `details` text NOT NULL,
  `english` text NOT NULL,
  `ar` varchar(255) NOT NULL,
  `es` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language_data`
--

INSERT INTO `language_data` (`id`, `keyword`, `type`, `details`, `english`, `ar`, `es`) VALUES
(1, 'alert', 'admin', '', 'Alert!', 'تنبيه!', '¡Alerta!'),
(2, 'net_income', 'admin', '', 'Net income', 'صافي الدخل', 'Ingresos netos'),
(3, 'package_by_user', 'admin', '', 'Package by user', 'الحزمة من قبل المستخدم', 'Paquete por usuario'),
(4, 'total_user', 'admin', '', 'Total Users', 'إجمالي المستخدمين', 'Usuarios totales'),
(5, 'total_package', 'admin', '', 'Total Packages', 'إجمالي الحزم', 'Paquetes totales'),
(6, 'total_pages', 'admin', '', 'Total Pages', 'إجمالي الصفحات', 'Total de páginas'),
(7, 'new_payment_request', 'admin', '', 'New payment request', 'طلب دفع جديد', 'Nueva solicitud de pago'),
(8, 'not_verified', 'admin', '', 'Not Verified', 'لم يتم التحقق منه', 'No verificado'),
(9, 'expired_account', 'admin', '', 'Expired account', 'حساب منتهي الصلاحية', 'Cuenta caducada'),
(10, 'expired_date', 'admin', '', 'Expired Date', 'تاريخ انتهاء الصلاحية', 'Fecha de vencimiento'),
(11, 'toatl_revenue', 'admin', '', 'Total revenue', 'إجمالي الإيرادات', 'Ingresos totales'),
(12, 'revenue', 'admin', '', 'Revenue', 'الإيرادات', 'Ingresos'),
(13, 'profile', 'admin', '', 'Profile', 'الملف الشخصي', 'Perfil'),
(14, 'profile_link', 'admin', '', 'Profile link', 'رابط الملف الشخصي', 'Enlace de perfil'),
(15, 'copy', 'admin', '', 'Copy', 'نسخ', 'Copiar'),
(16, 'coppied', 'admin', '', 'Coppied', 'Coppied', 'Coppied'),
(17, 'free', 'user', '', 'Free', 'مجاني', 'Gratis'),
(18, 'trial', 'admin', '', 'Trial', 'تجربة', 'Prueba'),
(19, 'package_type', 'user', '', 'Package type', 'نوع الحزمة', 'Tipo de paquete'),
(20, 'features', 'admin', '', 'Features', 'الميزات', 'Funciones'),
(21, 'duration', 'admin', '', 'Duration', 'المدة', 'Duración'),
(22, 'package_name', 'admin', '', 'Package name', 'اسم الحزمة', 'Nombre del paquete'),
(23, 'using_trail_package', 'admin', '', 'You are using trail package', 'أنت تستخدم trail packge', 'Estás usando el paquete de ruta'),
(24, 'trail_package_expired', 'admin', '', 'Your account will expire soon', 'ستنتهي صلاحية حسابك بعد شهر واحد', 'Tu cuenta caducará pronto'),
(25, 'change_package', 'admin', '', 'Change Package', 'تغيير الحزمة', 'Cambiar paquete'),
(26, 'account_not_active', 'admin', '', 'Your Account is not active', 'حسابك غير نشط', 'Su cuenta no está activa'),
(27, 'active_now', 'admin', '', 'Active Now', 'نشط الآن', 'Activo ahora'),
(28, 're_subscription_msg', 'admin', '', 'You have to re-new your subscription to continue', 'يجب إعادة اشتراكك من جديد للمتابعة', 'Tienes que renovar tu suscripción para continuar'),
(29, 'active_account', 'admin', '', 'Active Account', 'حساب نشط', 'Cuenta activa'),
(30, 'expired_account_msg', 'admin', '', 'Sorry your account is expired', 'معذرةً , انتهت صلاحية حسابك', 'Lo sentimos, su cuenta ha caducado'),
(31, 'payment_pending_msg', 'admin', '', 'Your payment is pending', 'دفعتك معلقة', 'Su pago está pendiente'),
(32, 'can_pay_subscription', 'admin', '', 'You can pay from subscription', 'يمكنك الدفع من الاشتراك', 'Puede pagar desde la suscripción'),
(33, 'pay_now', 'admin', '', 'Pay now', 'ادفع الآن', 'Paga ahora'),
(34, 'pending_request_msg', 'admin', '', 'Your payment request is pending', 'طلب الدفع معلق', 'Su solicitud de pago está pendiente'),
(35, 'wait_for_confirmation', 'admin', '', 'Please Wait for the confirmation', 'انتظر التأكيد', 'Espere la confirmación'),
(36, 'try_another_method', 'admin', '', 'Try Another Method', 'جرب طريقة أخرى', 'Prueba con otro método'),
(37, 'account_not_verified', 'admin', '', 'Your Account is not Verified', 'لم يتم التحقق من حسابك', 'Su cuenta no está verificada'),
(38, 'resend_send_mail_link', 'admin', '', 'Already send a verification link on your email. if not found', 'أرسل بالفعل رابط التحقق على بريدك الإلكتروني. إذا لم يتم العثور عليه', 'Ya envié un enlace de verificación en su correo electrónico. Si no lo encuentra'),
(39, 'resend', 'admin', '', 'Resend', 'إعادة الإرسال', 'Reenviar'),
(40, 'if_mail_not_correct_msg', 'admin', '', 'If your email is not correct then change from profile option', 'إذا كان بريدك الإلكتروني غير صحيح , فغيّر من خيار الملف الشخصي', 'Si su correo electrónico no es correcto, cambie de la opción de perfil'),
(41, 'email', 'label', '', 'Email', 'بريد إلكتروني', 'Correo electrónico'),
(42, 'settings', 'label', '', 'Settings', 'إعدادات', 'Configuración'),
(43, 'email_sub', 'label', '', 'Email subjects', 'إعدادات', 'Asuntos de correo electrónico'),
(44, 'registration', 'label', '', 'Registration', 'تسجيل', 'Registro'),
(45, 'payment_gateway', 'label', '', 'Payment Gateway', 'بوابة الدفع', 'Pasarela de pago'),
(46, 'recovery_password', 'label', '', 'Recovery password', 'استعادة كلمة المرور', 'Contraseña de recuperación'),
(47, 'admin_email', 'label', '', 'Admin email', 'البريد الإلكتروني للمسؤول', 'Correo electrónico del administrador'),
(48, 'php_mail', 'label', '', 'PHP Mail', 'PHP Mail', 'Correo PHP'),
(49, 'smtp', 'label', '', 'SMTP', 'SMTP', 'SMTP'),
(50, 'smtp_host', 'label', '', 'SMTP HOST', 'SMTP HOST', 'SMTP HOST'),
(51, 'smtp_port', 'label', '', 'SMTP PORT', 'منفذ SMTP', 'PUERTO SMTP'),
(52, 'smtp_password', 'label', '', 'SMTP PASSWORD', 'كلمة مرور SMTP', 'CONTRASEÑA SMTP'),
(53, 'save_change', 'label', '', 'Save Change', 'حفظ التغيير', 'Guardar cambio'),
(54, 'paypal', 'label', '', 'Paypal', 'paypal', 'Paypal'),
(55, 'new_users', 'label', '', 'New Users', 'المستخدمون الجدد', 'Nuevos usuarios'),
(56, 'add_user', 'label', '', 'Add User', 'إضافة مستخدم', 'Agregar usuario'),
(57, 'sl', 'label', '', 'Sl', 'Sl', 'Sl'),
(58, 'username', 'label', '', 'Username', 'اسم المستخدم', 'Nombre de usuario'),
(59, 'active_date', 'label', '', 'Active Date', 'تاريخ نشط', 'Fecha activa'),
(60, 'account_type', 'label', '', 'Account type', 'نوع الحساب', 'Tipo de cuenta'),
(61, 'action', 'label', '', 'Action', 'إجراء', 'Acción'),
(62, 'users', 'label', '', 'Users', 'المستخدمون', 'Usuarios'),
(63, 'status', 'label', '', 'Status', 'الحالة', 'Estado'),
(64, 'view_profile', 'label', '', 'View Profile', 'عرض الملف الشخصي', 'Ver perfil'),
(65, 'start_date', 'label', '', 'Start Date', 'تاريخ البدء', 'Fecha de inicio'),
(66, 'free_account', 'label', '', 'Free account', 'حساب مجاني', 'Cuenta gratuita'),
(67, 'trial_package', 'label', '', 'Trial Package', 'الحزمة التجريبية', 'Paquete de prueba'),
(68, 'not_active', 'admin', '', 'Not active yet', 'غير نشط بعد', 'Aún no activo'),
(69, 'expired', 'label', '', 'Expired', 'منتهية الصلاحية', 'Caducado'),
(70, 'active', 'label', '', 'Active', 'نشط', 'Activo'),
(71, 'deactive', 'label', '', 'Deactive', 'غير نشط', 'Desactivado'),
(72, 'verified', 'label', '', 'Verified', 'متحقق منه', 'Verificado'),
(73, 'want_to_verify_this_account', 'admin', '', 'Do you want to verified this account?', 'هل تريد التحقق من هذا الحساب؟', '¿Quieres verificar esta cuenta?'),
(74, 'want_to_active_this_account', 'admin', '', 'Do you want to active this account?', 'هل تريد تنشيط هذا الحساب؟', '¿Quieres activar esta cuenta?'),
(75, 'payment_is_verified', 'admin', '', 'You payment is verified', 'تم التحقق من دفعتك', 'Su pago está verificado'),
(76, 'paid', 'admin', '', 'Paid', 'مدفوع', 'Pagado'),
(77, 'verified_offline_payment_msg', 'admin', '', ' Do You want to verify this payment? Payment will count as an offline payment', 'هل تريد التحقق من هذه الدفعة؟ سيتم احتساب الدفع كدفعة غير متصلة بالإنترنت', '¿Desea verificar este pago? El pago contará como un pago fuera de línea'),
(78, 'pending', 'admin', '', 'Pending', 'معلق', 'Pendiente'),
(79, 'delete_user_msg', 'admin', '', ' Want to delete this user? Be careful This user will remove permanently.', 'هل تريد حذف هذا المستخدم؟ انتبه , سيقوم هذا المستخدم بالإزالة نهائيًا.', '¿Quiere eliminar este usuario? Tenga cuidado. Este usuario eliminará permanentemente.'),
(80, 'current_package', 'label', '', 'Current package', 'الحزمة الحالية', 'Paquete actual'),
(81, 'submit', 'label', '', 'Submit', 'إرسال', 'Enviar'),
(82, 'click_here', 'label', '', 'Click here!', 'انقر هنا!', '¡Haga clic aquí!'),
(83, 'add_new_user', 'label', '', 'Add New User', 'إضافة مستخدم جديد', 'Agregar nuevo usuario'),
(84, 'restaurant_user_name', 'admin', '', 'Restaurant Username', 'اسم مستخدم المطعم', 'Nombre de usuario del restaurante'),
(85, 'select_package', 'label', '', 'Select Package', 'حدد الحزمة', 'Seleccionar paquete'),
(86, 'add_password', 'label', '', 'Add password', 'أضف كلمة مرور', 'Agregar contraseña'),
(87, 'password', 'label', '', 'Password', 'كلمة المرور', 'Contraseña'),
(88, 'password_msg_add_user', 'label', '', ' If you do not select add password, Password will create randomly and send user by email', 'إذا لم تحدد إضافة كلمة مرور , فسيتم إنشاء كلمة المرور بشكل عشوائي وإرسال المستخدم بالبريد الإلكتروني', 'Si no selecciona agregar contraseña, la contraseña se creará aleatoriamente y enviará al usuario por correo electrónico'),
(89, 'create_page', 'label', '', 'Create Page', 'إنشاء صفحة', 'Crear página'),
(90, 'title', 'label', '', 'Title', 'العنوان', 'Título'),
(91, 'slug', 'label', '', 'Slug', 'slug', 'Babosa'),
(92, 'details', 'label', '', 'Details', 'تفاصيل', 'Detalles'),
(93, 'live', 'label', '', 'Live', 'مباشر', 'En vivo'),
(94, 'hide', 'label', '', 'Hide', 'إخفاء', 'Ocultar'),
(95, 'cancel', 'label', '', 'Cancel', 'إلغاء', 'Cancelar'),
(96, 'all_pages', 'admin', '', 'All Pages', 'كل الصفحات', 'Todas las páginas'),
(97, 'edit', 'label', '', 'Edit', 'تحرير', 'Editar'),
(98, 'delete', 'label', '', 'Delete', 'حذف', 'Eliminar'),
(99, 'faq', 'label', '', 'Faq', 'التعليمات', 'Preguntas frecuentes'),
(100, 'faq_list', 'label', '', 'FAQ List', 'قائمة الأسئلة الشائعة', 'Lista de preguntas frecuentes'),
(101, 'want_to_delete', 'label', '', 'Want to delete?', 'هل تريد الحذف؟', '¿Quieres eliminar?'),
(102, 'how_it_works', 'label', '', 'How it works', 'كيف يعمل', 'Cómo funciona'),
(103, 'upload_image', 'label', '', 'Upload Image', 'تحميل الصورة', 'Subir imagen'),
(104, 'max', 'label', '', 'Max', 'ماكس', 'Máx'),
(105, 'image', 'label', '', 'Image', 'صورة', 'Imagen'),
(106, 'team', 'label', '', 'Team', 'فريق', 'Equipo'),
(107, 'designation', 'label', '', 'Designation', 'التعيين', 'Designación'),
(108, 'offline_payments', 'admin', '', 'Offline Payment', 'الدفع دون اتصال بالإنترنت', 'Pago sin conexión'),
(109, 'package', 'admin', '', 'Package', 'حزمة', 'Paquete'),
(110, 'txn_id', 'admin', '', 'Txn id', 'معرف Txn', 'ID de Txn'),
(111, 'request_date', 'label', '', 'Request Date', 'تاريخ الطلب', 'Fecha de solicitud'),
(112, 'approve', 'label', '', 'Approve', 'موافقة', 'Aprobar'),
(113, 'approved', 'label', '', 'Approved', 'موافق عليه', 'Aprobado'),
(114, 'cookie_privacy', 'label', '', 'Cookies & Privacy', 'ملفات تعريف الارتباط والخصوصية', 'Cookies y privacidad'),
(115, 'services', 'label', '', 'Services', 'خدمات', 'Servicios'),
(116, 'home_features', 'label', '', 'Home Features', 'الميزات الرئيسية', 'Funciones de la casa'),
(117, 'add_new', 'label', '', 'Add New', 'إضافة جديد', 'Agregar nuevo'),
(118, 'upload', 'admin', '', 'Upload', 'تحميل', 'Subir'),
(119, 'select_direction', 'admin', '', 'Select Direction', 'حدد الأوساخ', 'Seleccionar dirección'),
(120, 'left_side', 'label', '', 'Left Side', 'الجانب الأيسر', 'Lado izquierdo'),
(121, 'right_side', 'label', '', 'Right Side', 'الجانب الأيمن', 'Lado derecho'),
(122, 'max_character', 'label', '', 'Max character', 'أقصى حرف', 'Carácter máximo'),
(123, 'icon', 'label', '', 'Icon', 'رمز', 'Icono'),
(124, 'close', 'label', '', 'Close', 'إغلاق', 'Cerrar'),
(125, 'terms_condition', 'label', '', 'Terms & Conditions', 'الشروط والأحكام', 'Términos y condiciones'),
(126, 'payment_transaction', 'label', '', 'Payment Transaction', 'معاملة الدفع', 'Transacción de pago'),
(127, 'payment_by', 'label', '', 'Payment by', 'الدفع بواسطة', 'Pago por'),
(128, 'restaurant_details', 'home', '', 'Restaurant Details', 'تفاصيل المطعم', 'Detalles del restaurante'),
(129, 'restaurant_username', 'user', '', 'Restaurant username', 'اسم مستخدم المطعم', 'Nombre de usuario del restaurante'),
(130, 'must_unique_english', 'user', '', 'Must be in English & Unique', 'يجب أن يكون باللغة الإنجليزية وفريدة من نوعها', 'Debe estar en inglés y ser único'),
(131, 'county', 'user', '', 'County', 'مقاطعة', 'Condado'),
(132, 'currency', 'user', '', 'Currency', 'العملة', 'Moneda'),
(133, 'dial_code', 'user', '', 'Dial code', 'رمز الاتصال', 'Marcar código'),
(134, 'phone', 'user', '', 'Phone', 'هاتف', 'Teléfono'),
(135, 'restaurant_full_name', 'user', '', 'Restaurant full name', 'اسم المطعم بالكامل', 'Nombre completo del restaurante'),
(136, 'short_name', 'user', '', 'Short name', 'اسم قصير', 'Nombre corto'),
(137, 'location', 'user', '', 'Location', 'location', 'Ubicación'),
(138, 'gmap_link', 'user', '', 'Google Map link', 'رابط خريطة Google', 'Enlace a Google Map'),
(139, 'address', 'user', '', 'Address', 'العنوان', 'Dirección'),
(140, 'logo', 'user', '', 'Logo', 'شعار', 'Logotipo'),
(141, 'cover_photo', 'user', '', 'Cover Photo', 'صورة الغلاف', 'Foto de portada'),
(142, 'upload_cover_photo', 'user', '', 'Upload Cover Image', 'تحميل صورة الغلاف', 'Subir imagen de portada'),
(143, 'change_pass', 'user', '', 'Change password', 'تغيير كلمة المرور', 'Cambiar contraseña'),
(144, 'owner_name', 'user', '', 'Owner name', 'اسم المالك', 'Nombre del propietario'),
(145, 'select_county', 'user', '', 'Select Country', 'حدد الدولة', 'Seleccionar país'),
(146, 'gender', 'user', '', 'Gender', 'جنس', 'Sexo'),
(147, 'website', 'user', '', 'Website', 'موقع الويب', 'Sitio web'),
(148, 'old_pass', 'user', '', 'Old Password', 'كلمة المرور القديمة', 'Contraseña anterior'),
(149, 'new_pass', 'user', '', 'New Password', 'كلمة مرور جديدة', 'Nueva contraseña'),
(150, 'confirm_password', 'user', '', 'Confirm Password', 'تأكيد كلمة المرور', 'Confirmar contraseña'),
(151, 'profile_pic', 'user', '', 'Profile Picture', 'صورة الملف الشخصي', 'Imagen de perfil'),
(152, 'add_edit_info', 'label', '', 'Add / Edit Info', 'إضافة / تحرير المعلومات', 'Agregar / Editar información'),
(153, 'shop_name', 'user', '', 'Shop Name', 'اسم المتجر', 'Nombre de la tienda'),
(154, 'create_your_restaurant', 'user', '', 'Create Your Restaurant', 'أنشئ مطعمك', 'Crea tu restaurante'),
(155, 'warning', 'user', '', 'Warning!', 'تحذير!', '¡Advertencia!'),
(156, 'upload_images', 'user', '', 'Upload Images', 'تحميل الصور', 'Subir imágenes'),
(157, 'select', 'user', '', 'Select', 'حدد', 'Seleccionar'),
(158, 'you_have', 'user', '', 'You have', 'لديك', 'Tienes'),
(159, 'notifications', 'user', '', 'Notifications', 'إخطارات', 'Notificaciones'),
(160, 'new_orders_today', 'user', '', 'New Orders today', 'طلبات جديدة اليوم', 'Nuevos pedidos hoy'),
(161, 'reservation_today', 'user', '', 'Reservation Today', 'الحجز اليوم', 'Reserva hoy'),
(162, 'completed_orders', 'user', '', 'Completed orders', 'الطلبات المكتملة', 'Pedidos completados'),
(163, 'error', 'user', '', 'Error', 'خطأ', 'Error'),
(164, 'copyright', 'admin', '', 'Copyright', 'حقوق النشر', 'Copyright'),
(165, 'version', 'label', '', 'Version', 'الإصدار', 'Versión'),
(166, 'member_since', 'user', '', 'Member since', 'عضو منذ', 'Miembro desde'),
(167, 'last_login', 'admin', '', 'Last Login', 'آخر تسجيل دخول', 'Último inicio de sesión'),
(168, 'logout', 'label', '', 'Logout', 'تسجيل الخروج', 'Cerrar sesión'),
(169, 'dashboard', 'admin', '', 'Dashboard', 'لوحة القيادة', 'Panel de control'),
(170, 'account_management', 'admin', '', 'Account MANAGEMENT', 'إدارة الحساب', 'ADMINISTRACIÓN DE CUENTAS'),
(171, 'packages_management', 'admin', '', 'PACKAGES Management', 'إدارة الحزم', 'Gestión de PAQUETES'),
(172, 'package_list', 'admin', '', 'Package list', 'قائمة الحزم', 'Lista de paquetes'),
(173, 'order_types', 'admin', '', 'Order types', 'أنواع الطلبات', 'Tipos de pedido'),
(174, 'site_management', 'admin', '', 'Site management', 'إدارة الموقع', 'Gestión del sitio'),
(175, 'home', 'admin', '', 'Home', 'المنزل', 'Inicio'),
(176, 'site_features', 'user', '', 'Site Features', 'ميزات الموقع', 'Características del sitio'),
(177, 'international', 'admin', '', 'INTERNATIONAL', 'دولي', 'INTERNACIONAL'),
(178, 'languages', 'admin', '', 'Languages', 'اللغات', 'Idiomas'),
(179, 'add_languages', 'admin', '', 'Add Languages', 'إضافة لغات', 'Agregar idiomas'),
(180, 'dashboard_language', 'admin', '', 'Dashboard Languages', 'لغات لوحة المعلومات', 'Idiomas del panel de control'),
(181, 'fontend_language', 'admin', '', 'Frontend Languages', 'لغات Fontend', 'Idiomas Fontend'),
(182, 'site_setting', 'admin', '', 'Site Settings', 'إعدادات الموقع', 'Configuración del sitio'),
(183, 'site_settings', 'admin', '', 'Site settings', 'إعدادات الموقع', 'Configuración del sitio'),
(184, 'email_settings', 'admin', '', 'Email Settings', 'إعدادات البريد الإلكتروني', 'Configuración de correo electrónico'),
(185, 'payment_settings', 'admin', '', 'Payment settings', 'إعدادات الدفع', 'Configuración de pago'),
(186, 'home_banner_setting', 'admin', '', 'Banner settings', 'إعدادات البانر', 'Configuración de banner'),
(187, 'content', 'admin', '', 'Content', 'محتوى', 'Contenido'),
(188, 'pages', 'admin', '', 'Pages', 'صفحات', 'Páginas'),
(189, 'add_page', 'admin', '', 'Add page', 'إضافة صفحة', 'Agregar página'),
(190, 'cookies_privacy', 'admin', '', 'Cookie & Privacy', 'ملفات تعريف الارتباط والخصوصية', 'Cookies y privacidad'),
(191, 'user_transaction', 'admin', '', 'User\'s Transactions', 'معاملات المستخدم', 'Transacciones del usuario'),
(192, 'backup_database', 'admin', '', 'Backup Database', 'قاعدة بيانات النسخ الاحتياطي', 'Copia de seguridad de la base de datos'),
(193, 'subscriptions', 'user', '', 'Subscriptions', 'اشتراكات', 'Suscripciones'),
(194, 'menu', 'user', '', 'Menu', 'قائمة', 'Menú'),
(195, 'menu_categories', 'user', '', 'Menu Categories', 'فئات القائمة', 'Categorías de menú'),
(196, 'items', 'user', '', 'Items', 'عناصر', 'Elementos'),
(197, 'specialties', 'user', '', 'Specialties', 'التخصصات', 'Especialidades'),
(198, 'allergens', 'user', '', 'Allergens', 'مسببات الحساسية', 'Alergenos'),
(199, 'live_order', 'user', '', 'Live order', 'طلب مباشر', 'Orden en vivo'),
(200, 'reservation', 'user', '', 'Reservation', 'حجز', 'Reserva'),
(201, 'available_days', 'user', '', 'Available days', 'الأيام المتاحة', 'Días disponibles'),
(202, 'portfolio', 'user', '', 'Portfolio', 'محفظة', 'Portafolio'),
(203, 'social_sites', 'user', '', 'Social sites', 'مواقع اجتماعية', 'Sitios sociales'),
(204, 'add_cover_photo', 'user', '', 'Add Cover Photo', 'إضافة صورة الغلاف', 'Agregar foto de portada'),
(205, 'manage_features', 'user', '', 'Manage Features', 'إدارة الميزات', 'Administrar funciones'),
(206, 'order_config', 'user', '', 'Order Configuration', 'تكوين الطلب', 'Configuración de pedidos'),
(207, 'layouts', 'user', '', 'Layouts', 'تخطيطات', 'Diseños'),
(208, 'deactive_account', 'user', '', 'Deactivate account', 'حساب غير نشط', 'Cuenta desactivada'),
(209, 'success', 'label', '', 'Success', 'نجاح', 'Éxito'),
(210, 'show_details', 'label', '', 'Show Details', 'إظهار التفاصيل', 'Mostrar detalles'),
(211, 'keyword', 'label', '', 'Keyword', 'Keyword', 'Palabra clave'),
(212, 'values', 'label', '', 'Values', 'قيم', 'Valores'),
(213, 'types', 'label', '', 'Types', 'أنواع', 'Tipos'),
(214, 'admin_language', 'admin', '', 'Admin language', 'لغة المسؤول', 'Idioma del administrador'),
(215, 'user_dashboard', 'label', '', 'User dashboard', 'لوحة تحكم المستخدم', 'Panel de usuario'),
(216, 'fontend_languages', 'label', '', 'Frontend Language', 'لغة الخط', 'Idioma fuente'),
(217, 'others', 'label', '', 'Others', 'آخرون', 'Otros'),
(218, 'lang_name', 'admin', '', 'Language name', 'اسم اللغة', 'Nombre del idioma'),
(219, 'language_slug', 'admin', '', 'Language Slug', 'سبيكة اللغة', 'Lenguaje Slug'),
(220, 'left_to_right', 'label', '', 'Left to right', 'من اليسار إلى اليمين', 'De izquierda a derecha'),
(221, 'right_to_left', 'admin', '', 'Right to left', 'من اليمين إلى اليسار', 'De derecha a izquierda'),
(222, 'price', 'admin', '', 'Price', 'السعر', 'Precio'),
(223, 'name', 'label', '', 'Name', 'اسم', 'Nombre'),
(224, 'create_category', 'user', '', 'Create Category', 'إنشاء فئة', 'Crear categoría'),
(225, 'category_name', 'user', '', 'Category name', 'اسم الفئة', 'Nombre de categoría'),
(226, 'select_type', 'label', '', 'Select Type', 'اختر النوع', 'Seleccionar tipo'),
(227, 'pizza', 'user', '', 'Pizza', 'بيتزا', 'Pizza'),
(228, 'burger', 'user', '', 'Burger', 'برجر', 'Hamburguesa'),
(229, 'order', 'user', '', 'order', 'طلب', 'pedido'),
(230, 'sizes', 'user', '', 'Sizes', 'مقاسات', 'Tamaños'),
(231, 'size_name', 'user', '', 'Size Name', 'اسم الحجم', 'Nombre del tamaño'),
(232, 'insert_category', 'user', '', 'Please Insert Category', 'الرجاء إدخال فئة', 'Por favor, inserte una categoría'),
(233, 'insert_item_size', 'user', '', 'Please Insert Item Sizes', 'الرجاء إدخال مقاسات العناصر', 'Por favor, inserte los tamaños de los artículos'),
(234, 'insert_item_size_msg', 'user', '', 'you can set price depends on size (size available for pizza & Burger)', 'يمكنك تعيين السعر بناءً على الحجم (الحجم المتاح للبيتزا والبرغر)', 'puede establecer el precio según el tamaño (el tamaño disponible para pizza y hamburguesa)'),
(235, 'info', 'label', '', 'Info!', 'معلومات!', '¡Información!'),
(236, 'you_can_add', 'user', '', 'You can add', 'يمكنك الإضافة', 'Puedes agregar'),
(237, 'unlimited', 'user', '', 'Unlimited', 'غير محدود', 'Ilimitado'),
(238, 'you_reached_max_limit', 'user', '', 'You reached the maximum limit', 'لقد وصلت إلى الحد الأقصى', 'Has alcanzado el límite máximo'),
(239, 'you_have_remaining', 'user', '', 'You have remaining', 'المتبقي لديك', 'Te queda'),
(240, 'out_of', 'user', '', 'out of', 'خارج', 'fuera de'),
(241, 'add_items', 'user', '', 'add items', 'إضافة عناصر', 'agregar elementos'),
(242, 'is_size', 'user', '', 'Is Size', 'هو الحجم', 'Es el tamaño'),
(243, 'veg_type', 'label', '', 'veg type', 'نوع نباتي', 'tipo vegetal'),
(244, 'non_veg', 'label', '', 'Non veg', 'غير نباتي', 'No vegetariano'),
(245, 'veg', 'label', '', 'veg', 'نباتي', 'verduras'),
(246, 'small_description', 'user', '', 'small description', 'وصف صغير', 'pequeña descripción'),
(247, 'show_in_homepage', 'user', '', 'Show in home page', 'إظهار في الصفحة الرئيسية', 'Mostrar en la página de inicio'),
(248, 'add_packages', 'user', '', 'Add Package', 'إضافة حزمة', 'Agregar paquete'),
(249, 'is_discount', 'user', '', 'Is Discount', 'خصم', 'Es un descuento'),
(250, 'custom_price', 'user', '', 'Custom Price', 'سعر مخصص', 'Precio personalizado'),
(251, 'discount', 'user', '', 'discount', 'خصم', 'descuento'),
(252, 'is_upcoming', 'user', '', 'Is Upcoming', 'قادم', 'Próximamente'),
(253, 'days', 'user', '', 'days', 'أيام', 'días'),
(254, 'empty_item_package', 'user', '', 'Empty Item For Packages', 'إفراغ عنصر للحزم', 'Artículo vacío para paquetes'),
(255, 'empty_item_package_msg', 'user', '', 'You have to create item without size for package', 'عليك إنشاء عنصر بدون حجم للحزمة', 'Tienes que crear un artículo sin tamaño para el paquete'),
(256, 'is_price_msg_1', 'user', 'Is price is for custom price if you want to set custom price for package.', 'Is price is for custom price if you want to set custom price for package.', 'هو السعر لسعر مخصص إذا كنت تريد تعيين سعر مخصص للحزمة.', 'El precio es para el precio personalizado si desea establecer un precio personalizado para el paquete.'),
(257, 'is_price_msg_2', 'user', 'Otherwise price will set  after calculation all items prices', 'Otherwise price will set after calculation all items prices', 'وإلا فسيتم تعيين السعر بعد حساب أسعار جميع العناصر', 'De lo contrario, el precio se establecerá después del cálculo de los precios de todos los artículos'),
(258, 'discount_msg', 'user', 'If you want to set discount for this package', 'If you want to set discount for this package', 'إذا كنت تريد تعيين خصم لهذه الحزمة', 'Si desea establecer un descuento para este paquete'),
(259, 'featured', 'user', 'Featured', 'Featured', 'مميزة', 'Destacado'),
(260, 'overview', 'user', 'Overview', 'overview', 'نظرة عامة', 'descripción general'),
(261, 'order_id', 'user', 'Order ID', 'Order ID', 'معرف الطلب', 'ID de pedido'),
(262, 'order_details', 'user', 'Order Details', 'Order Details', 'تفاصيل الطلب', 'Detalles del pedido'),
(263, 'delivery_charge', 'user', 'Delivery charge', 'delivery charge', 'رسوم التوصيل', 'gastos de envío'),
(264, 'total_person', 'user', 'Total Person', 'Total Person', 'إجمالي عدد الأشخاص', 'Persona total'),
(265, 'pickup_time', 'user', 'Pickup time', 'Pickup time', 'وقت الاستلام', 'Hora de recogida'),
(266, 'accept', 'admin', 'accept', 'accept', 'قبول', 'aceptar'),
(267, 'completed', 'user', 'Completed', 'Completed', 'مكتمل', 'Completado'),
(268, 'accepted', 'user', 'Accepted', 'accepted', 'مقبول', 'aceptado'),
(269, 'cancled', 'user', 'Cancled', 'Cancled', 'ملغى', 'Cancelado'),
(270, 'order_list', 'user', 'Order list', 'order list', 'قائمة الطلبات', 'lista de pedidos'),
(271, 'item_name', 'user', 'Item name', 'item name', 'اسم العنصر', 'nombre del artículo'),
(272, 'live_orders', 'user', 'Live orders', 'live orders', 'أوامر مباشرة', 'pedidos en vivo'),
(273, 'all_orders', 'user', 'All orders', 'all orders', 'كل الطلبات', 'todos los pedidos'),
(274, 'order_number', 'user', 'Order number', 'order number', 'رقم الطلب', 'número de pedido'),
(275, 'order_type', 'user', 'Order type', 'order type', 'نوع الطلب', 'tipo de pedido'),
(276, 'canceled', 'user', 'Canceled', 'canceled', 'ملغاة', 'cancelado'),
(277, 'create_trail_package_msg', 'user', 'Please Create a Trail Package first', 'Please Create a Trail Package first', 'الرجاء إنشاء حزمة التتبع أولاً', 'Por favor, primero cree un paquete de senderos'),
(278, 'create_trail_package_msg_1', 'user', 'After create trial package you can able to create free/others packages', 'After creating trial package you can able to create free/others packages', 'بعد إنشاء حزمة تجريبية يمكنك إنشاء حزم مجانية / أخرى', 'Después de crear el paquete de prueba, puede crear paquetes gratuitos / otros'),
(279, 'trial_for_month', 'admin', 'Trial for 1 Month', 'Trial for 1 Month', 'تجربة لمدة شهر واحد', 'Prueba de 1 mes'),
(280, 'monthly', 'admin', 'monthly', 'monthly', 'شهريًا', 'mensual'),
(281, 'yearly', 'admin', 'yearly', 'yearly', 'سنوي', 'anual'),
(282, 'set_free_for_month', 'admin', 'Account will set Free for 1 month', 'Account will set Free for 1 month', 'سيتم تعيين الحساب مجانًا لمدة شهر واحد', 'La cuenta se liberará durante 1 mes'),
(283, 'limit_text_msg_1', 'admin', 'Set limit for Order & Items. How many Order & items will available for this package', 'Set limit for Orders. How many Order will available for this package', 'تعيين حد للطلب والعناصر. كم عدد الطلبات والعناصر التي ستتوفر لهذه الحزمة', 'Establecer límite para pedidos y artículos. Cuántos pedidos y artículos estarán disponibles para este paquete'),
(284, 'limit_text_msg_2', 'admin', 'Select limit from drop down. if you not select any limit then it will set by default', 'Select limit from dropdown. if you do not select any limit then it will set by default', 'حدد حدًا من القائمة المنسدلة. إذا لم تحدد أي حد , فسيتم تعيينه افتراضيًا', 'Seleccione el límite del menú desplegable. Si no selecciona ningún límite, se establecerá de forma predeterminada'),
(285, 'add_change_feature', 'admin', 'Change/add Features', 'Change/add Features', 'تغيير / إضافة ميزات', 'Cambiar / agregar funciones'),
(286, 'stripe', 'admin', 'stripe', 'stripe', 'شريط', 'raya'),
(287, 'razorpay', 'admin', 'razorpay', 'razorpay', 'رازورباي', 'razorpay'),
(288, 'offline', 'admin', 'offline', 'offline', 'غير متصل', 'sin conexión'),
(289, 'payment_via', 'admin', 'payment via', 'payment via', 'الدفع عن طريق', 'pago mediante'),
(290, 'send_payment_req', 'admin', 'Send a payment request', 'Send a payment request', 'إرسال طلب دفع', 'Enviar una solicitud de pago'),
(291, 'payment_verified_successfully', 'admin', 'Your payment verified successfully', 'Your payment verified successfully', 'تم التحقق من دفعتك بنجاح', 'Su pago verificado correctamente'),
(292, 'ok', 'admin', 'ok', 'ok', 'موافق', 'ok'),
(293, 'stripe_payment_gateway', 'admin', 'Stripe Payment Gateway', 'Stripe Payment Gateway', 'بوابة الدفع الشريطية', 'Pasarela de pago de Stripe'),
(294, 'name_on_card', 'label', 'name on card', 'name on card', 'الاسم على البطاقة', 'nombre en la tarjeta'),
(295, 'card_number', 'admin', 'Card number', 'Card number', 'رقم البطاقة', 'Número de tarjeta'),
(296, 'month', 'admin', 'month', 'month', 'شهر', 'mes'),
(297, 'year', 'admin', 'year', 'year', 'السنة', 'año'),
(298, 'cvc', 'admin', 'cvc', 'cvc', 'cvc', 'cvc'),
(299, 'whatsapp_number', 'label', 'whatsapp Number', 'whatsapp Number', 'رقم whatsapp', 'Número de WhatsApp'),
(300, 'youtube', 'home', 'youtube', 'youtube', 'youtube', 'youtube'),
(301, 'facebook', 'home', 'facebook', 'facebook', 'facebook', 'facebook'),
(302, 'facebook_link', 'home', 'facebook link', 'facebook link', 'رابط فيسبوك', 'enlace de Facebook'),
(303, 'twitter', 'home', 'twitter', 'twitter', 'twitter', 'twitter'),
(304, 'instagram', 'home', 'instagram', 'instagram', 'instagram', 'instagram'),
(305, 'about_short', 'home', 'about Short text', 'about Short text', 'حول نص قصير', 'sobre el texto corto'),
(306, 'profile_qr', 'home', 'Profile QR code', 'Profile QR code', 'رمز الاستجابة السريعة للملف الشخصي', 'Código QR de perfil'),
(307, 'download', 'home', 'Download', 'Download', 'تنزيل', 'Descargar'),
(308, 'start_time', 'home', 'start time', 'start time', 'وقت البدء', 'hora de inicio'),
(309, 'end_time', 'home', 'end time', 'end time', 'وقت الانتهاء', 'hora de finalización'),
(310, 'time_picker', 'home', 'Time picker', 'Time picker', 'منتقي الوقت', 'Selector de tiempo'),
(311, 'reservation_types', 'home', 'reservation types', 'reservation types', 'أنواع الحجز', 'tipos de reserva'),
(312, 'type_name', 'home', 'type name', 'type name', 'اسم النوع', 'nombre de tipo'),
(313, 'reservation_type_list', 'home', 'reservation type list', 'reservation type list', 'قائمة نوع الحجز', 'lista de tipos de reserva'),
(314, 'all_reservation_list', 'home', 'All Reservation list', 'All Reservation list', 'قائمة كافة الحجوزات', 'Lista de todas las reservas'),
(315, 'todays_reservations', 'home', 'Todays Reservation', 'Todays Reservation', 'حجز اليوم', 'Reserva de hoy'),
(316, 'comments', 'home', 'comments', 'comments', 'تعليقات', 'comentarios'),
(317, 'table_reservation', 'home', 'Table Reservation', 'Table Reservation', 'حجز منضدة', 'Reserva de mesa'),
(318, 'if_use_smtp', 'label', 'if You use SMTP Mail', 'if You use SMTP Mail', 'إذا كنت تستخدم بريد SMTP', 'si usa correo SMTP'),
(319, 'smtp_info_msg', 'label', 'Make sure SMTP MAIL, SMTP HOST, SMTP PORT and SMTP PASSWORD is correct', 'Make sure SMTP MAIL, SMTP HOST, SMTP PORT and SMTP PASSWORD is correct', 'تأكد من صحة بريد SMTP ومضيف SMTP ومنفذ SMTP وكلمة مرور SMTP', 'Asegúrese de que SMTP MAIL, SMTP HOST, SMTP PORT y SMTP PASSWORD sean correctos'),
(320, 'registration_subject', 'admin', 'Registration Email subject', 'Registration Email subject', 'موضوع البريد الإلكتروني للتسجيل', 'Asunto del correo electrónico de registro'),
(321, 'payment_mail_subject', 'label', 'Payment mail subject', 'Payment mail subject', 'موضوع بريد الدفع', 'Asunto del correo de pago'),
(322, 'recovery_password_heading', 'user', 'Recovery Passowrd', 'Recovery Passowrd', 'كلمة مرور الاسترداد', 'Contraseña de recuperación'),
(323, 'linkedin', 'label', 'linkedin', 'linkedin', 'ينكدين', 'linkedin'),
(324, 'home_banner', 'admin', 'Home Banner', 'Home Banner', 'لافتة الصفحة الرئيسية', 'Banner de inicio'),
(325, 'home_small_banner', 'admin', 'Home small banner', 'Home small banner', 'بانر صغير للمنزل', 'Banner pequeño de inicio'),
(326, 'section_banner', 'admin', 'section banner', 'section banner', 'بانر القسم', 'banner de sección'),
(327, 'add', 'admin', 'add', 'add', 'إضافة', 'agregar'),
(328, 'section_name', 'admin', 'section name', 'section name', 'اسم القسم', 'nombre de la sección'),
(329, 'pricing', 'admin', 'pricing', 'pricing', 'التسعير', 'precio'),
(330, 'reviews', 'admin', 'reviews', 'reviews', 'مراجعات', 'opiniones'),
(331, 'contacts', 'admin', 'contacts', 'contacts', 'جهات اتصال', 'contactos'),
(332, 'section', 'admin', 'section', 'section', 'قسم', 'sección'),
(333, 'heading', 'label', 'heading', 'heading', 'عنوان', 'título'),
(334, 'sub_heading', 'admin', 'sub heading', 'sub heading', 'عنوان فرعي', 'subtítulo'),
(335, 'banner', 'admin', 'banner', 'banner', 'بانر', 'banner'),
(336, 'paypal_payment', 'admin', 'paypal_ payment', 'paypal payment', 'دفع paypal', 'pago con paypal'),
(337, 'sandbox', 'admin', 'sandbox', 'sandbox', 'وضع الحماية', 'caja de arena'),
(338, 'paypal_email', 'admin', 'Paypal Email', 'Paypal Email', 'بريد باي بال', 'Correo electrónico de Paypal'),
(339, 'paypal_business_email', 'admin', 'Paypal Business Email', 'Paypal Business Email', 'البريد الإلكتروني للأعمال Paypal', 'Correo electrónico comercial de Paypal'),
(340, 'stripe_payment', 'admin', 'stripe Payment Gateway', 'stripe Payment Gateway', 'بوابة الدفع الشريطية', 'Pasarela de pago de banda'),
(341, 'stripe_public_key', 'admin', 'Stripe Public key', 'Stripe Public key', 'مفتاح شريطي عام', 'Clave pública de banda'),
(342, 'stripe_secret_key', 'admin', 'Stripe Secret key', 'Stripe Secret key', 'مفتاح الشريط السري', 'Clave secreta de banda'),
(343, 'razorpay_payment', 'admin', 'razorpay payment', 'razorpay payment', 'دفع razorpay', 'pago razorpay'),
(344, 'razorpay_key', 'admin', 'Razorpay Key', 'Razorpay Key', 'مفتاح Razorpay', 'Clave de Razorpay'),
(345, 'favicon', 'admin', 'favicon', 'favicon', 'الرمز المفضل', 'favicon'),
(346, 'site_logo', 'admin', 'site_logo', 'site logo', 'site logo', 'logotipo del sitio'),
(347, 'time_zone', 'admin', 'time zone', 'time zone', 'المنطقة الزمنية', 'zona horaria'),
(348, 'site_name', 'label', 'site name', 'site name', 'اسم الموقع', 'nombre del sitio'),
(349, 'description', 'admin', 'description', 'description', 'الوصف', 'descripción'),
(350, 'google_analytics', 'admin', 'Google Analytics', 'Google Analytics', 'تخطيط التسعي', 'Google Analytics'),
(351, 'pricing_layout', 'admin', 'pricing layout', 'pricing layout', 'تخطيط التسعير', 'diseño de precios'),
(352, 'style_1', 'admin', 'Style 1', 'Style 1', 'النمط 1', 'Estilo 1'),
(353, 'style_2', 'admin', 'Style 2', 'Style 2', 'النمط 2', 'Estilo 2'),
(354, 'reg_system', 'admin', 'Registration System', 'Registration System', 'نظام التسجيل', 'Sistema de registro'),
(355, 'auto_approval', 'label', 'auto approval', 'auto approval', 'موافقة تلقائية', 'aprobación automática'),
(356, 'email_verify', 'label', 'Email Verification', 'Email Verification', 'التحقق من البريد الإلكتروني', 'Verificación de correo electrónico'),
(357, 'free_verify', 'label', 'Free Verify', 'Free Verify', 'تحقق مجاني', 'Verificación gratuita'),
(358, 'user_invoice', 'label', 'user invoice', 'user invoice', 'فاتورة المستخدم', 'factura de usuario'),
(359, 'rating', 'label', 'rating', 'rating', 'تصنيف', 'valoración'),
(360, 'recaptcha', 'label', 'recaptcha', 'recaptcha', 'recaptcha', 'recaptcha'),
(361, 'g_site_key', 'label', 'recaptcha site key', 'recaptcha site key', 'مفتاح موقع recaptcha', 'recaptcha site key'),
(362, 'g_secret_key', 'label', 'secret Key', 'secret Key', 'مفتاح سري', 'clave secreta'),
(363, 'order_configuration', 'label', 'Order Configuration', 'Order Configuration', 'تكوين الطلب', 'Configuración de pedidos'),
(364, 'configuration', 'label', 'Configuration', 'Configuration', 'التكوين', 'Configuración'),
(365, 'whatsapp_order', 'label', 'Whatsapp Order', 'Whatsapp Order', 'ترتيب Whatsapp', 'Pedido de Whatsapp'),
(366, 'runing_package', 'user', 'Runing Package', 'Runing Package', 'حزمة Runing', 'Paquete de ejecución'),
(367, 'account_will_expired', 'user', 'Your package will expire after', 'Your package will expire after', 'ستنتهي الحزمة الخاصة بك بعد', 'Su paquete caducará después de'),
(368, 'package_expiration', 'user', 'Package expiration', 'Package expiration', 'انتهاء صلاحية الحزمة', 'Vencimiento del paquete'),
(369, 'lifetime', 'user', 'Lifetime', 'lifetime', 'مدى الحياة', 'de por vida'),
(370, 'payment_not_active_due_to_payment', 'user', 'Your package is not active due to payment. (Pending..)', 'Your package is not active due to payment. (Pending..)', 'الحزمة الخاصة بك غير نشطة بسبب السداد. (معلق ..)', 'Su paquete no está activo debido al pago. (Pendiente ..)'),
(371, 'package_reactive_msg', 'user', 'Your package is expired. you can re-active it again', 'Your package is expired. you can re-active it again', 'انتهت صلاحية الحزمة الخاصة بك. يمكنك إعادة تنشيطها مرة أخرى', 'Tu paquete ha caducado. Puedes reactivarlo de nuevo'),
(372, 'select_this_package', 'user', 'You can also select this package', 'You can also select this package', 'يمكنك أيضًا تحديد هذه الحزمة', 'También puede seleccionar este paquete'),
(373, 'contact_email', 'user', 'Contact email', 'contact email', 'البريد الإلكتروني للاتصال', 'correo electrónico de contacto'),
(374, 'colors', 'user', 'Colors', 'Colors', 'ألوان', 'Colores'),
(375, 'color_picker', 'user', 'Color picker', 'Color picker', 'منتقي الألوان', 'Selector de color'),
(376, 'preloader', 'user', 'Preloader', 'preloader', 'أداة التحميل المسبق', 'precargador'),
(377, 'choose_restaurant_name', 'home', 'Choose your Resaturant Name', 'Choose your Resaturant Name', 'اختر اسمك المقيم', 'Elija su nombre de restaurante'),
(379, 'create', 'home', 'Create', 'Create', 'إنشاء', 'Crear'),
(380, 'try_with_qr_code', 'home', 'Try With QR code', 'Try With QR code', 'جرب باستخدام رمز الاستجابة السريعة', 'Probar con código QR'),
(381, 'quick_links', 'home', 'quick links', 'quick links', 'روابط سريعة', 'enlaces rápidos'),
(382, 'cookies_msg_1', 'home', 'We use cookies in this website to give you the best experience on our', 'We use cookies in this website to give you the best experience on our', 'نحن نستخدم ملفات تعريف الارتباط في هذا الموقع لنمنحك أفضل تجربة على موقعنا', 'Usamos cookies en este sitio web para brindarle la mejor experiencia en nuestro'),
(383, 'cookies_msg_2', 'home', 'site and show you relevant ads. To find out more, read our', 'site and show you relevant ads. To find out more, read our', 'الموقع وعرض الإعلانات ذات الصلة. لمعرفة المزيد , اقرأ', 'y mostrarle anuncios relevantes. Para obtener más información, lea nuestro'),
(384, 'copyright_text', 'home', 'All rights reserved.', 'All rights reserved.', 'جميع الحقوق محفوظة.', 'Todos los derechos reservados.'),
(385, 'sign-up', 'home', 'Signup', 'Signup', 'تسجيل', 'Registrarse'),
(386, 'login', 'home', 'login', 'login', 'تسجيل الدخول', 'iniciar sesión'),
(387, 'track_order', 'home', 'track order', 'track order', 'تتبع الطلب', 'orden de seguimiento'),
(388, 'lets_work_together', 'home', 'Let\'s work together', 'Let\'s work together', 'لنعمل معًا', 'Trabajemos juntos'),
(389, 'join_our_team_text', 'home', 'Join my team so that together we can achieve success', 'Join my team so that together we can achieve success', 'انضم إلى فريقي حتى نتمكن معًا من تحقيق النجاح', 'Únete a mi equipo para que juntos podamos lograr el éxito'),
(390, 'forgot_password', 'home', 'Forgot Password', 'Forgot Password', 'نسيت كلمة المرور', 'Olvidé mi contraseña'),
(391, 'forget_pass_alert', 'home', 'Seems like you forgot your password for login? if true set your email to reset password', 'Seems like you forgot your password for login? if true set your email to reset password', 'يبدو أنك نسيت كلمة المرور لتسجيل الدخول؟ إذا كان هذا صحيحًا , فقم بتعيين بريدك الإلكتروني على إعادة تعيين كلمة المرور', '¿Parece que olvidó su contraseña para iniciar sesión? Si es verdadero, configure su correo electrónico para restablecer la contraseña'),
(392, 'remember_password', 'home', 'Remember Password?', 'Remember Password?', 'تذكر كلمة المرور؟', '¿Recordar contraseña?'),
(393, 'sign_in', 'home', 'Sign in', 'Sign in', 'تسجيل الدخول', 'Iniciar sesión'),
(394, 'sign_in_text', 'home', 'Signup to discover your shop', 'Sign-in to discover your shop', 'اشترك لاكتشاف متجرك', 'Regístrese para descubrir su tienda'),
(395, 'dont_have_account', 'home', 'Don\'t have account', 'Don\'t have account', 'ليس لديك حساب', 'No tengo cuenta'),
(396, 'read_terms', 'home', 'I have read the', 'I have read the', 'لقد قرأت', 'He leído el'),
(397, 'accept_them', 'home', 'accept them', 'accept them', 'اقبلهم', 'aceptarlos'),
(398, 'already_member', 'home', 'Already a Member?', 'Already a Member?', 'هل أنت عضو بالفعل؟', '¿Ya eres miembro?'),
(399, 'message', 'home', 'message', 'message', 'رسالة', 'mensaje'),
(400, 'send', 'home', 'send', 'send', 'إرسال', 'enviar'),
(401, 'get_start', 'home', 'Get Started', 'Get Started', 'البدء', 'Comenzar'),
(402, 'play_video', 'home', 'Play Video', 'Play Video', 'تشغيل الفيديو', 'Reproducir video'),
(403, 'read_more', 'home', 'Read More', 'Read More', 'قراءة المزيد', 'Leer más'),
(404, 'all', 'home', 'All', 'All', 'الكل', 'Todos'),
(405, 'has_been_add_to_cart', 'home', 'Has been added to the cart', 'has been added to the cart', 'تمت إضافته إلى عربة التسوق', 'se ha añadido al carrito'),
(406, 'view_cart', 'home', 'View Cart', 'View Cart', 'عرض عربة التسوق', 'Ver carrito'),
(407, 'size', 'home', 'size', 'size', 'الحجم', 'tamaño'),
(408, 'add_to_cart', 'home', 'Add cart', 'Add to cart', 'إضافة عربة التسوق', 'agregar carrito'),
(409, 'order_form', 'home', 'order form', 'order form', 'نموذج الطلب', 'formulario de pedido'),
(410, 'full_name', 'home', 'full name', 'full name', 'الاسم الكامل', 'nombre completo'),
(411, 'person', 'home', 'person', 'person', 'شخص', 'persona'),
(412, 'select_person', 'home', 'select person', 'select person', 'حدد الشخص', 'seleccionar persona'),
(413, 'confirm_order', 'home', 'confirm order', 'confirm order', 'تأكيد الطلب', 'confirmar pedido'),
(414, 'order_confirmed', 'home', '', 'order confirmed', 'تم تأكيد الطلب', 'pedido confirmado'),
(415, 'your_order_id', 'home', 'your order id', 'your order id', 'معرف طلبك', 'ID de su pedido'),
(416, 'track_your_order_using_phone', 'home', 'You can track you order using your phone number', 'You can track you order using your phone number', 'يمكنك تتبع طلبك باستخدام رقم هاتفك', 'Puede rastrear su pedido usando su número de teléfono'),
(417, 'total_qty', 'home', 'Total Qty', 'Total Qty', 'إجمالي الكمية', 'Cantidad total'),
(418, 'total_price', 'home', 'Total Price', 'Total Price', 'السعر الإجمالي', 'Precio total'),
(419, 'order_date', 'home', 'Order Date', 'Order Date', 'تاريخ الطلب', 'Fecha de pedido'),
(420, 'rejected', 'home', 'rejected', 'rejected', 'مرفوض', 'rechazado'),
(421, 'you_have_more', 'home', 'You have more', 'You have more', 'لديك المزيد', 'Tienes más'),
(422, 'item_name', 'home', 'Item name', 'item name', 'اسم العنصر', 'nombre del elemento'),
(423, 'delivery_address', 'home', 'Delivery address', 'Delivery address', 'عنوان التسليم', 'Dirección de entrega'),
(424, 'shop_address', 'home', 'shop address', 'shop address', 'عنوان المحل', 'dirección de la tienda'),
(425, 'share_your_location', 'home', 'Share your location here', 'Share your location here', 'شارك موقعك هنا', 'Comparte tu ubicación aquí'),
(426, 'order_on_whatsapp', 'home', 'Order On Whatsapp', 'Order On Whatsapp', 'اطلب عبر Whatsapp', 'Pedido por Whatsapp'),
(427, 'order_now', 'home', 'order now', 'order now', 'اطلب الآن', 'pedir ahora'),
(428, 'book_now', 'home', 'Book Now', 'Book Now', 'احجز الآن', 'Reserva ahora'),
(429, 'watch_video', 'home', 'Watch Video', 'Watch Video', 'شاهد الفيديو', 'Ver video'),
(430, 'fast_service', 'home', 'Fast Service', 'Fast Service', 'خدمة سريعة', 'Servicio rápido'),
(431, 'fresh_food', 'home', 'Fresh Food', 'Fresh Food', 'طعام طازج', 'Alimentos frescos'),
(432, '24_support', 'home', '24/7 Support', '24/7 Support', 'دعم على مدار الساعة طوال أيام الأسبوع', 'Soporte 24/7'),
(433, 'about_us', 'home', 'about us', 'about us', 'عنا', 'acerca de nosotros'),
(434, 'maximum_order_alert', 'home', 'Sorry! This Restaurant reached the maximum orders', 'Sorry! This Restaurant reached the maximum orders', 'معذرة! وصل هذا المطعم إلى الحد الأقصى من الطلبات', '¡Lo siento! Este restaurante alcanzó el máximo de pedidos'),
(435, 'contact_us', 'home', 'Contact Us', 'Contact Us', 'اتصل بنا', 'Contáctenos'),
(436, 'checkout', 'home', 'checkout', 'checkout', 'الخروج', 'pago'),
(437, 'sorry_cant_take_order', 'home', 'Sorry! We can not take any orders', 'Sorry! We can not take any orders', 'عذرًا! لا يمكننا تنفيذ أي طلبات', '¡Lo sentimos! No podemos aceptar ningún pedido'),
(438, '404_not', 'home', '404 Not Found', '404 Not Found', '404 غير موجود', '404 no encontrado'),
(439, 'subject', 'home', 'subject', 'subject', 'موضوع', 'asunto'),
(440, 'see_more', 'home', 'See More', 'See More', 'مشاهدة المزيد', 'Ver más'),
(441, 'number_of_guest', 'home', 'number of guest', 'number of guest', 'عدد الضيوف', 'número de invitados'),
(442, 'reservation_type', 'home', 'reservation type', 'reservation type', 'نوع الحجز', 'tipo de reserva'),
(443, 'any_special_request', 'home', 'Any Special Request?', 'Any Special Request?', 'أي طلب خاص؟', '¿Alguna solicitud especial?'),
(444, 'booking_availabiti_text', 'home', 'Before booking an reservation please check our availability', 'Before booking an reservation please check our availability', 'قبل الحجز يرجى التحقق من التوافر لدينا', 'Antes de reservar una reserva, compruebe nuestra disponibilidad'),
(445, 'phone_number', 'home', 'Phone Number', 'Phone Number', 'رقم الهاتف', 'Número de teléfono'),
(446, 'check', 'home', 'check', 'check', 'تحقق', 'comprobar'),
(447, 'search_with_username', 'home', 'Search with username', 'Search with username', 'بحث باسم المستخدم', 'Buscar con nombre de usuario'),
(448, 'search', 'home', 'search', 'search', 'بحث', 'buscar'),
(449, 'restaurant_name', 'home', 'Restaurant Name', 'Restaurant Name', 'اسم المطعم', 'Nombre del restaurante'),
(450, 'forgot', 'home', 'forgot', 'forgot?', 'نسيت؟', '¿Olvidaste?'),
(451, 'total', 'home', 'total', 'total', 'إجمالي', 'total'),
(452, 'select_order_type', 'home', 'select order type', 'select order type', 'حدد نوع الطلب', 'seleccionar tipo de orden'),
(453, 'quick_view', 'home', 'Quick View', 'Quick View', 'نظرة سريعة', 'Vista rápida'),
(454, 'reservation_date', 'home', 'reservation date', 'reservation date', 'تاريخ الحجز', 'fecha de reserva'),
(455, 'restaurant_list', 'admin', 'restaurant list', 'restaurant list', 'قائمة المطاعم', 'lista de restaurantes'),
(456, 'total_restaurant', 'admin', 'total restaurant', 'total restaurant', 'إجمالي المطعم', 'restaurante total'),
(457, 'add restaurant', 'admin', 'add_restaurant', 'Add Restaurant', 'إضافة مبلغ', 'Agregar restaurante'),
(458, 'packages', 'admin', 'packages', 'packages', 'الحزم', 'paquetes'),
(459, 'features_list', 'admin', 'features list', 'features list', 'قائمة الميزات', 'lista de características'),
(460, 'type', 'label', 'type', 'type', 'type', 'tipo'),
(461, 'save_change_successfully', 'admin', 'save change successfully', 'save change successfully', 'احفظ التغيير بنجاح', 'guardar el cambio correctamente'),
(462, 'success_text', 'admin', 'save change successfully', 'save change successfully', 'احفظ التغيير بنجاح', 'guardar el cambio correctamente'),
(463, 'error_text', 'admin', 'Somethings Were Wrong!!', 'Somethings Were Wrong!!', 'أشياء خاطئة !!', '¡¡Algo anda mal !!'),
(464, 'yes', 'label', 'yes', 'yes', 'نعم', 'sí'),
(465, 'no', 'label', 'no', 'no', 'لا', 'no'),
(466, 'are_you_sure', 'label', 'are_you_sure', 'are you sure', 'هل أنت متأكد', 'estás seguro'),
(467, 'item_deactive_now', 'label', 'This item is deactive now', 'This item is deactive now', 'هذا العنصر غير نشط الآن', 'Este elemento está desactivado ahora'),
(468, 'item_active_now', 'label', 'Item is active now', 'Item is active now', 'العنصر نشط الآن', 'El artículo está activo ahora'),
(469, 'want_to_reset_password', 'label', 'Want to reset Password?', 'Want to reset Password?', 'هل تريد إعادة تعيين كلمة المرور؟', '¿Desea restablecer la contraseña?'),
(470, 'sunday', 'user', 'Sunday', 'Sunday', 'الأحد', 'Domingo'),
(471, 'monday', 'user', 'Monday', 'Monday', 'الاثنين', 'Lunes'),
(472, 'tuesday', 'user', 'Tuesday', 'Tuesday', 'الثلاثاء', 'Martes'),
(473, 'wednesday', 'user', 'Wednesday', 'Wednesday', 'الأربعاء', 'Miércoles'),
(474, 'thursday', 'user', 'Thursday', 'Thursday', 'الخميس', 'Jueves'),
(475, 'friday', 'user', 'Friday', 'Friday', 'الجمعة', 'Viernes'),
(476, 'saturday', 'user', 'Saturday', 'Saturday', 'السبت', 'Sábado'),
(477, 'booking_date', 'admin', 'Booking Date', 'Booking Date', 'تاريخ الحجز', 'Fecha de reserva'),
(478, 'pickup_alert', 'admin', 'Sorry Pickup is not available', 'Sorry Pickup is not available', 'لا يوجد خيار آسف', 'Lo sentimos, la recogida no está disponible'),
(479, 'qty', 'user', 'Qty', 'qty', 'الكمية', 'cantidad'),
(480, 'item', 'user', 'Item', 'item', 'عنصر', 'elemento'),
(481, 'order_video', 'user', 'Order video link', 'Order video link', 'رابط طلب الفيديو', 'Solicitar enlace de video'),
(482, 'home_setting', 'user', 'Home Settings', 'Home Settings', 'إعدادات الصفحة الرئيسية', 'Configuración de inicio'),
(483, 'total_revenue', 'user', 'Total Revenue', 'Total Revenue', 'إجمالي الإيرادات', 'Ingresos totales'),
(484, 'categories', 'admin', 'categories', 'categories', 'فئات', 'categorías'),
(485, 'images', 'user', 'images', 'images', 'صور', 'imágenes'),
(486, 'want_to_deactive_account', 'user', 'Want to deactive your account?', 'Want to deactivate your account?', 'هل تريد إلغاء تنشيط حسابك؟', '¿Quieres desactivar tu cuenta?'),
(487, 'want_to_active_account', 'user', 'Want to active your account?', 'Want to activate your account?', 'هل تريد تنشيط حسابك؟', '¿Quiere activar su cuenta?'),
(488, 'back', 'user', 'Back', 'Back', 'رجوع', 'Atrás'),
(489, 'sorry_payment_faild', 'user', 'Sorry Payment Failed', 'Sorry Payment Failed', 'فشل الدفع آسفًا', 'Lo sentimos, el pago falló'),
(490, 'my_cart', 'user', 'My cart', 'My cart', 'عربة التسوق', 'Mi carrito'),
(491, 'shipping', 'user', 'shipping', 'shipping', 'شحن', 'envío'),
(492, 'sub_total', 'user', 'Sub Total', 'Sub Total', 'المجموع الفرعي', 'Subtotal'),
(493, 'payment_not_available', 'user', 'payment not available', 'payment not available', 'الدفع غير متوفر', 'pago no disponible'),
(494, 'stock_status', 'label', '', 'Stock Status', 'حالة المخزون', 'Estado de existencias'),
(495, 'in_stock', 'label', '', 'In stock', 'متوفر', 'En stock'),
(496, 'remaining', 'label', '', 'remaining', 'المتبقي', 'restante'),
(497, 'reset_counter', 'label', '', 'reset counter', 'إعادة تعيين العداد', 'restablecer contador'),
(498, 'reset_stock_count', 'label', '', 'Stock Count will reset', 'سيتم إعادة تعيين جرد المخزون', 'El recuento de existencias se reiniciará'),
(499, 'delete_success', 'label', '', 'Delete successfull', 'حذف بنجاح', 'Eliminación exitosa'),
(500, 'availability', 'label', '', 'Availability', 'التوفر', 'Disponibilidad'),
(501, 'out_of_stock', 'label', '', 'Out of stock', 'غير متوفر بالمخزون', 'Agotado'),
(502, 'set_stock', 'label', '', 'set stock', 'تعيين المخزون', 'establecer stock'),
(503, 'select_pickup_area', 'label', '', 'Select Pickup area', 'حدد منطقة الالتقاء', 'Seleccionar área de recogida'),
(504, 'show_map', 'label', '', 'show map', 'اعرض الخريطة', 'mostrar mapa');
INSERT INTO `language_data` (`id`, `keyword`, `type`, `details`, `english`, `ar`, `es`) VALUES
(505, 'google_map_api_key', 'label', '', 'Google map api key', 'مفتاح واجهة برمجة تطبيقات خرائط Google', 'Clave de API del mapa de Google'),
(506, 'pickup_point', 'label', '', 'Pickup Point', 'نقطة الالتقاء', 'Punto de recogida'),
(507, 'google_map_status', 'label', '', 'google map status', 'حالة خريطة google', 'estado del mapa de Google'),
(508, 'pickup_time_alert', 'label', '', 'Pickup time not set yet', 'لم يتم تحديد وقت الاستلام بعد', 'Aún no se ha establecido la hora de recogida'),
(509, 'dine-in', 'label', '', 'Dine in', 'تناول الطعام في', 'Cenar en'),
(510, 'create_table', 'label', '', 'Create table', 'إنشاء جدول', 'Crear tabla'),
(511, 'table', 'label', '', 'Table', 'جدول', 'Tabla'),
(512, 'area', 'label', '', 'area', 'منطقة', 'área'),
(513, 'areas', 'label', '', 'areas', 'مناطق', 'áreas'),
(514, 'size', 'label', '', 'size', 'الحجم', 'tamaño'),
(515, 'add_new_area', 'label', '', 'Add New Area', 'إضافة منطقة جديدة', 'Agregar nueva área'),
(516, 'select_area', 'label', '', 'Select area', 'حدد منطقة', 'Seleccionar área'),
(517, 'area_name', 'label', '', 'Area name', 'اسم المنطقة', 'Nombre del área'),
(518, 'add_new_table', 'label', '', 'Add New Table', 'إضافة جدول جديد', 'Agregar nueva tabla'),
(519, 'table_list', 'label', '', 'Table List', 'قائمة الجدول', 'Lista de tablas'),
(520, 'set_time', 'label', '', 'Set Time', 'ضبط الوقت', 'Establecer hora'),
(521, 'set_prepared_time', 'label', '', 'Set Prepared Time', 'تعيين وقت التحضير', 'Establecer tiempo de preparación'),
(522, 'prepared_time', 'label', '', 'Prepared Time', 'وقت التحضير', 'Tiempo preparado'),
(523, 'hours', 'label', '', 'hours', 'ساعات', 'horas'),
(524, 'minutes', 'label', '', 'Minutes', 'دقائق', 'Minutos'),
(525, 'order_status', 'label', '', 'order status', 'حالة الطلب', 'estado del pedido'),
(526, 'order_accept_msg', 'label', '', 'Order Accept by shop. order will shift after', 'قبول الطلب حسب المتجر. سيتحول الطلب بعد ذلك', 'Pedido aceptado por tienda. El pedido cambiará después de'),
(527, 'order_delivery_msg', 'label', '', 'Your order will on the way soon', 'طلبك قريبًا', 'Tu pedido estará pronto en camino'),
(528, 'select_table', 'label', '', 'Select Table', 'تحديد جدول', 'Seleccionar tabla'),
(529, 'seo_settings', 'admin', '', 'Seo Settings', 'إعدادات SEO', 'Configuración de SEO'),
(530, 'keyword', 'admin', '', 'Keyword', 'كلمات رئيسية', 'Palabra clave'),
(531, 'description', 'admin', '', 'description', 'الوصف', 'descripción'),
(532, 'keywords', 'admin', '', 'keywords', 'كلمات رئيسية', 'palabras clave'),
(533, 'confirm_oder', 'admin', '', 'confirm oder', 'تأكيد أودر', 'confirmar orden'),
(534, 'add_extras', 'admin', '', 'Add Extras', 'إضافة إضافات', 'Agregar extras'),
(535, 'add_new_extras', 'admin', '', 'Add new extras', 'إضافة إضافات جديدة', 'Agregar nuevos extras'),
(536, 'save', 'admin', '', 'save', 'حفظ', 'guardar'),
(537, 'write_you_name_here', 'user', '', 'Write Your Name Here', 'اكتب اسمك هنا', 'Escriba su nombre aquí'),
(538, 'order_tracking', 'admin', '', 'Order Tracking', 'تتبع الطلبات', 'Seguimiento de pedidos'),
(539, 'google_map_link', 'user', '', 'Google map link', 'رابط خرائط Google', 'Enlace de mapa de Google'),
(540, 'status_history', 'user', '', 'Status History', 'محفوظات الحالة', 'Historial de estado'),
(541, 'just_created', 'user', '', 'Just created', 'تم إنشاؤه للتو', 'Recién creado'),
(542, 'status_from', 'user', '', 'Status from', 'الحالة من', 'Estado de'),
(543, 'by_admin', 'user', '', 'By admin', 'بواسطة المسؤول', 'Por administrador'),
(544, 'admin', 'user', '', 'Admin', 'المسؤول', 'Administrador'),
(545, 'order_is_on_the_way', 'user', '', 'Order is on the way', 'الطلب في الطريق', 'El pedido está en camino'),
(546, 'complete', 'user', '', 'Complete', 'مكتمل', 'Completo'),
(547, 'new_order', 'user', '', 'New Order', 'طلب جديد', 'Nuevo pedido'),
(548, 'served', 'user', '', 'served', 'تقدم', 'servido'),
(549, 'serve', 'user', '', 'serve', 'تخدم', 'servir'),
(550, 'start_preparing', 'user', '', 'Start Preparing', 'بدء التحضير', 'Empezar a preparar'),
(551, 'today_remaining_off', 'user', '', 'Today is our off day', 'اليوم هو يوم إجازتنا', 'Hoy es nuestro día libre'),
(552, 'prepared_finish', 'user', '', 'Prepared finish', 'إنهاء مُجهز', 'Acabado preparado'),
(553, 'create_menu', 'user', '', 'Create Menu', 'إنشاء قائمة', 'Crear menú'),
(554, 'generate_qr_code', 'user', '', 'Generate QR code', 'إنشاء رمز الاستجابة السريعة', 'Generar código QR'),
(555, 'menu_name', 'user', '', 'Menu name', 'اسم القائمة', 'Nombre del menú');
(556, 'download_qr', 'user', '', 'Download QR', 'تنزيل QR', 'Descargar QR'),
(557, 'congratulations', 'user', '', 'Congratulations', 'تهانينا', 'Felicitaciones'),
(558, 'order_place_successfully', 'user', '', 'Order is completed and have been placed successfully', 'اكتمل الطلب وتم وضعه بنجاح', 'El pedido se completó y se realizó correctamente'),
(559, 'please_wait_msg', 'user', '', 'please wait..', 'من فضلك انتظر ..', 'por favor espere ..'),
(560, 'token_number', 'user', '', 'token number', 'token number', 'número de token'),
(561, 'create_qr', 'user', '', 'Create QR', 'إنشاء QR', 'Crear QR'),
(562, 'qr_builder', 'user', '', 'Qr Builder', 'ريال قطري البناء', 'Constructor de Qr'),
(563, 'new_dine_order', 'user', '', 'new dine order', 'طلب عشاء جديد', 'nueva orden de cena'),
(564, 'restaurant_dine_in', 'user', '', 'Restaurant Dine-in', 'تناول الطعام في المطعم', 'Restaurante para cenar'),
(565, 'kds', 'user', '', 'KDS', 'KDS', 'KDS'),
(566, 'qr_code_generate_msg', 'user', '', 'After generating Qr code download the Qr code and add in your custom flyer', 'بعد إنشاء رمز Qr , قم بتنزيل رمز Qr وأضف نشرة إعلانية مخصصة لك', 'Después de generar el código Qr, descargue el código Qr y agregue su folleto personalizado'),
(567, 'extras', 'label', '', 'Extras', 'إضافات', 'Extras'),
(568, 'order_running_msg', 'admin', '', 'Your order is still running! you cant order the same item until it is completed', 'طلبك لا يزال قيد التشغيل! لا يمكنك الحصول على نفس العنصر حتى يكتمل', '¡Tu pedido aún se está ejecutando! No puedes pedir el mismo artículo hasta que se complete'),
(569, 'staff', 'admin', '', 'Staff', 'طاقم العمل', 'Personal'),
(570, 'staff_list', 'admin', '', 'Staff list', 'قائمة الموظفين', 'Lista de personal'),
(571, 'permission_list', 'admin', '', 'permission list', 'إذن_قائمة', 'lista de permisos'),
(572, 'add_straff', 'admin', '', 'Add Staff', 'إضافة طاقم عمل', 'Agregar personal'),
(573, 'email_exits_in', 'admin', '', 'Email already exist into user table', 'البريد الإلكتروني موجود بالفعل في جدول المستخدم', 'El correo electrónico ya existe en la tabla de usuarios'),
(574, 'email_alreay_exits', 'admin', '', 'Email already exits', 'البريد الإلكتروني يخرج بالفعل', 'El correo electrónico ya existe'),
(575, 'available_permossion', 'admin', '', 'Available permission', 'السماح المتاح', 'Permosión disponible'),
(576, 'not_found', 'label', '', 'Not found', 'غير موجود', 'No encontrado'),
(577, 'live_order_status', 'label', '', 'Live order status', 'حالة الطلب المباشر', 'Estado del pedido en vivo'),
(578, 'extras', 'label', '', 'Extras', 'إضافات', 'Extras'),
(579, 'trial_for_week', 'admin', '', 'Trial for 1 week', 'تجربة لمدة أسبوع واحد', 'Prueba de 1 semana'),
(580, 'trial_for_fifteen', 'admin', '', 'Trial for 15 days', 'نسخة تجريبية لمدة 15 يومًا', 'Prueba de 15 días'),
(581, 'weekly', 'admin', '', 'Weekly', 'أسبوعي', 'Semanal'),
(582, '15_days', 'admin', '', '15 days', '15 يومًا', '15 días'),
(583, 'is_signup', 'admin', '', 'Show signup button', 'إظهار زر التسجيل', 'Mostrar botón de registro'),
(584, 'is_auto_verified', 'admin', '', 'Auto approved Trail user', 'مستخدم ممر معتمد تلقائيًا', 'Usuario de Trail aprobado automáticamente'),
(585, 'twillo_sms_settings', 'admin', '', 'Twilio SMS Settings', 'إعدادات Twillo SMS', 'Configuración de SMS Twillo'),
(586, 'account_sid', 'admin', '', 'Account SID', 'معرف الحساب', 'Cuenta SID'),
(587, 'auth_token', 'admin', '', 'Auth Token', 'رمز المصادقة', 'Token de autenticación'),
(588, 'twillo_virtual_number', 'admin', '', 'Twilio Virtual Number', 'رقم Twilio الظاهري', 'Número virtual Twillo'),
(589, 'inactive', 'admin', '', 'Inactive', 'غير نشط', 'Inactivo'),
(590, 'accept_sms', 'admin', '', 'Accept SMS', 'قبول الرسائل القصيرة', 'Aceptar SMS'),
(591, 'complete_sms', 'admin', '', 'Complete SMS', 'SMS كاملة', 'SMS completo'),
(592, 'sms_sent', 'admin', '', 'Message Sent', 'تم إرسال الرسالة', 'Mensaje enviado'),
(593, 'accept_message', 'admin', '', 'Accept Message', 'قبول الرسالة', 'Aceptar mensaje'),
(594, 'completed_message', 'admin', '', 'Completed Message', 'رسالة مكتملة', 'Mensaje completo'),
(595, 'upgrade', 'admin', '', 'Upgrade', 'ترقية', 'Actualizar'),
(596, 'show', 'label', '', 'show', 'عرض', 'mostrar'),
(597, 'sorry_we_are_closed', 'label', '', 'Sorry We are closed', 'معذرة لقد أغلقنا', 'Lo sentimos, estamos cerrados'),
(598, 'please_check_the_available_list', 'label', '', 'Please check the available list', 'تحقق من القائمة المتاحة', 'Por favor revise la lista disponible'),
(599, 'paypal_environment', 'label', '', 'Paypal Environment', 'بيئة Paypal', 'Entorno de Paypal'),
(600, 'pickup_points', 'label', '', 'Pickup Points', 'نقاط الالتقاء', 'Puntos de recogida'),
(601, 'order_is_waiting_for_picked', 'label', '', 'Order is waiting for picked', 'الطلب ينتظر الاختيار', 'El pedido está esperando ser recogido'),
(602, 'phone_already_exits', 'label', '', 'Phone already exits', 'الهاتف يخرج بالفعل', 'El teléfono ya sale'),
(603, 'customer_login', 'label', '', 'Customer Login', 'تسجيل دخول العميل', 'Inicio de sesión de cliente'),
(604, 'date', 'label', '', 'Date', 'التاريخ', 'Fecha'),
(605, 'order_status', 'label', '', 'Order status', 'حالة الطلب', 'Estado del pedido'),
(606, 'customer', 'label', '', 'Customer', 'العميل', 'Cliente'),
(607, 'unit_price', 'label', '', 'Unit price', 'سعر الوحدة', 'Precio unitario'),
(608, 'amount', 'label', '', 'Amount', 'المبلغ', 'Cantidad'),
(609, 'export', 'label', '', 'Export', 'تصدير', 'Exportar'),
(610, 'print', 'label', '', 'Print', 'طباعة', 'Imprimir'),
(611, 'customer_name', 'label', '', 'Customer Name', 'اسم العميل', 'Nombre del cliente'),
(612, 'delivery_staff_panel', 'label', '', 'Delivery Staff panel', 'لوحة طاقم التوصيل', 'Panel de personal de entrega'),
(613, 'delivery_staff', 'label', '', 'Delivery Staff', 'طاقم التوصيل', 'Personal de entrega'),
(614, 'default_prepared_time', 'label', '', 'Default Prepared time', 'وقت التحضير الافتراضي', 'Tiempo de preparación predeterminado'),
(615, 'total_earnings', 'label', '', 'Total Earnings', 'إجمالي الأرباح', 'Ingresos totales'),
(616, 'picked', 'label', '', 'Picked', 'منتقى', 'Elegido'),
(617, 'mark_as_picked', 'label', '', 'Mark as picked', 'وضع علامة على أنه مختار', 'Marcar como elegido'),
(618, 'mark_as_completed', 'label', '', 'Mark as completed', 'وضع علامة كمكتملة', 'Marcar como completado'),
(619, 'mark_as_accepted', 'label', '', 'Mark as Accepted', 'وضع علامة كمقبول', 'Marcar como aceptado'),
(620, 'account', 'label', '', 'Account', 'الحساب', 'Cuenta'),
(621, 'ongoing', 'label', '', 'On Going', 'قيد التنفيذ', 'Continuando'),
(622, 'earning', 'label', '', 'Earning', 'ربح', 'Ganancia'),
(623, 'cod', 'label', '', 'COD', 'COD', 'COD'),
(624, 'accepted_by_delivery_staff', 'label', '', 'Accepted By Delivery Staff', 'تم قبوله بواسطة طاقم التوصيل', 'Aceptado por el personal de entrega'),
(625, 'accepted_by', 'label', '', 'Accepted By', 'مقبول من قبل', 'Aceptado por'),
(626, 'delivery_staff', 'label', '', 'Delivery Staff', 'طاقم التوصيل', 'Personal de entrega'),
(627, 'picked_by_delivery_staff', 'label', '', 'Picked By Delivery Staff', 'اختارها طاقم التوصيل', 'Elegido por el personal de entrega'),
(628, 'picked_by', 'label', '', 'Picked By', 'انتقى بواسطة', 'Seleccionado por'),
(629, 'delivered_by', 'label', '', 'Delivered By', 'تم التسليم بواسطة', 'Entregado por'),
(630, 'customer_info', 'label', '', 'Customer info', 'معلومات العميل', 'Información del cliente'),
(631, 'delivered_by_delivery_staff', 'label', '', 'Delivered By Delivery Staff', 'تم التوصيل بواسطة طاقم التوصيل', 'Entregado por personal de entrega'),
(632, 'thank_you_purchase_msg', 'label', '', 'Thank you for shopping with us . Please come again', 'شكرًا لك على التسوق معنا. يرجى العودة مرة أخرى', 'Gracias por comprar con nosotros. Vuelva de nuevo'),
(633, 'ordered_placed', 'label', '', 'Order Placed', 'تم تقديم الطلب', 'Pedido realizado'),
(634, 'we_have_received_your_order', 'label', '', 'We have received your order', 'لقد تلقينا طلبك', 'Hemos recibido su pedido'),
(635, 'order_confirmed', 'label', '', 'Order confirmed', 'تم تأكيد الطلب', 'Pedido confirmado'),
(636, 'your_order_has_been_confirmed', 'label', '', 'Your order has beep confirmed', 'تم تأكيد طلب beeb الخاص بك', 'Tu pedido ha sido confirmado'),
(637, 'Order Processed', 'label', '', 'Order Processed', 'تمت معالجة الطلب', 'Pedido procesado'),
(638, 'date', 'label', '', 'Date', 'التاريخ', 'Fecha'),
(639, 'we_are_preparing_your_order', 'label', 'We are preparing your order', 'We are preparing your order', 'نحن نجهز طلبك', 'Estamos preparando su pedido'),
(640, 'ready_to_pickup', 'label', 'Ready to pickup', 'Ready to pickup', 'جاهز للاستلام', 'Listo para recoger'),
(641, 'your_order_is_ready_to_pickup', 'label', 'Your order is ready for pickup', 'Your order is ready for pickup', 'طلبك جاهز للاستلام', 'Su pedido está listo para ser recogido'),
(642, 'order_confirmed_by_dboy', 'label', 'Order confirm by delivery staff', 'Order confirm by delivery staff', 'تأكيد الطلب بواسطة طاقم التوصيل', 'Pedido confirmado por el personal de entrega'),
(643, 'order_accept_by_dboy', 'label', 'Order accepted by delivery staff', 'Order accepted by delivery staff', 'تم قبول الطلب من قبل طاقم التوصيل', 'Pedido aceptado por el personal de entrega'),
(644, 'order_picked', 'label', 'Order Picked', 'Order Picked', 'تم انتقاء الطلب', 'Pedido seleccionado'),
(645, 'order_picked_by_dboy', 'label', 'Order picked by delivery staff', 'Order picked by delivery staff', 'تم اختيار الطلب بواسطة طاقم التوصيل', 'Pedido recogido por el personal de entrega'),
(646, 'order_delivered', 'label', 'Order Delivered', 'Order Delivered', 'تم تسليم الطلب', 'Pedido entregado'),
(647, 'order_delivered_successfully', 'label', 'Order delivered successfully', 'Order delivered successfully', 'تم تسليم الطلب بنجاح', 'Pedido entregado correctamente'),
(648, 'filter', 'admin', 'Filter', 'Filter', 'عامل التصفية', 'Filtro'),
(649, 'clear', 'admin', 'Clear', 'Clear', 'مسح', 'Borrar'),
(650, 'shipping_address', 'admin', 'Shipping Address', 'Shipping Address', 'عنوان الشحن', 'Dirección de envío'),
(651, 'get_direction', 'admin', 'Get direction', 'Get direction', 'الحصول على الاتجاه', 'Obtener dirección'),
(652, 'call_now', 'admin', 'Call now', 'Call now', 'اتصل الآن', 'Llamar ahora'),
(653, 'order_items', 'admin', 'OrderItems', 'Order Items', 'عناصر الطلب', 'Artículos de pedido'),
(654, 'shop_configuration', 'admin', 'Shop Configuration', 'Shop Configuration', 'تكوين المتجر', 'Configuración de la tienda'),
(655, 'staffs', 'admin', 'Staffs', 'Staffs', 'طاقم العمل', 'Personal'),
(656, 'restaurants', 'admin', 'Restaurants', 'Restaurants', 'مطاعم', 'Restaurantes'),
(657, 'preferences', 'admin', 'Preferences', 'Preferences', 'التفضيلات', 'Preferencias'),
(658, 'recaptcha_settings', 'admin', 'Recaptcha Settings', 'ReCaptcha Settings', 'إعدادات Recaptcha', 'Configuración de Recaptcha'),
(659, 'on', 'admin', 'On', 'on', 'تشغيل', 'activado'),
(660, 'off', 'admin', 'Off', 'off', 'إيقاف', 'desactivado'),
(661, 'enable_to_allow_signup_system', 'admin', 'Enable to allow sign up users to your system', 'Enable to allow sign up users to your system', 'مكّن للسماح للمستخدمين بتسجيل الدخول إلى نظامك', 'Habilitar para permitir que los usuarios se registren en su sistema'),
(662, 'enable_to_allow_auto_approve', 'admin', 'Enable to allow auto-approved when users sign up to your system', 'Enable to allow auto-approved when users sign up to your system', 'مكّن للسماح بالموافقة التلقائية عند تسجيل المستخدمين في نظامك', 'Habilite para permitir la aprobación automática cuando los usuarios se registren en su sistema'),
(663, 'enable_to_allow_email_verification', 'admin', 'Enable to allow email verification when users sign up to your system', 'Enable to allow email verification when users sign up to your system', 'مكّن للسماح بالتحقق من البريد الإلكتروني عند قيام المستخدمين بالتسجيل في نظامك', 'Habilite para permitir la verificación de correo electrónico cuando los usuarios se registren en su sistema'),
(664, 'enable_to_allow_free_email_verification', 'admin', 'Enable to allow email verification when users sign up with free package to your system', 'Enable to allow email verification when users sign up with free package to your system', 'مكّن للسماح بالتحقق من البريد الإلكتروني عند قيام المستخدمين بالتسجيل باستخدام حزمة مجانية لنظامك', 'Habilite para permitir la verificación de correo electrónico cuando los usuarios se registren con un paquete gratuito en su sistema'),
(665, 'user_get_an_invoice', 'admin', 'Users get an invoice when signing up to your system', 'Users get an invoice when signing up to your system', 'يحصل المستخدمون على فاتورة عند التسجيل في نظامك', 'Los usuarios obtienen una factura al registrarse en su sistema'),
(666, 'rating_in_landing_page', 'admin', 'Show rating in landing page', 'Show rating in landing page', 'عرض التصنيف في الصفحة المقصودة', 'Mostrar calificación en la página de destino'),
(667, 'show_signup_button', 'admin', 'Enable to Show signup button in menu', 'Enable to Show signup button in menu', 'تمكين لإظهار زر التسجيل في القائمة', 'Habilitar para mostrar el botón de registro en el menú'),
(668, 'auto_approve_trial_user', 'admin', 'Enable to Auto Approved trial users when registration in system', 'Enable to Auto Approved trial users when registration in system', 'قم بتمكين مستخدمي الإصدار التجريبي المعتمد تلقائيًا عند التسجيل في النظام', 'Habilitar a los usuarios de prueba aprobados automáticamente al registrarse en el sistema'),
(669, 'add_restaurant', 'admin', 'Add New Restaurant', 'Add New Restaurant', 'إضافة مطعم جديد', 'Agregar nuevo restaurante'),
(670, 'country', 'admin', 'Country', 'Country', 'دولة', 'País'),
(671, 'fifteen', 'admin', 'Fifteen', 'Fifteen', 'خمسة عشر', 'Quince'),
(672, 'language_data', 'admin', 'Language Data', 'Language Data', 'بيانات اللغة', 'Datos de idioma'),
(673, 'enable_to_allow_in_your_system', 'admin', 'Enable to allow in your system', 'Enable to allow in your system', 'قم بتمكين السماح في نظامك', 'Habilitar para permitir en su sistema'),
(674, 'stock_counter', 'admin', 'Stock counter', 'Stock counter', 'عداد المخزون', 'Contador de existencias'),
(675, 'payment_history', 'admin', 'Payment History', 'Payment History', 'تاريخ الدفع', 'Historial de pagos'),
(676, 'default_email', 'admin', 'Default Email', 'Default Email', 'البريد الإلكتروني الافتراضي', 'Correo electrónico predeterminado'),
(677, 'invoice', 'admin', 'Invoice', 'Invoice', 'فاتورة', 'Factura'),
(678, 'table_order', 'admin', 'Table Order', 'Table Order', 'ترتيب الجدول', 'Orden de la tabla'),
(679, 'restaurant_configuration', 'admin', 'Restaurant configuration', 'Restaurant configuration', 'تكوين المطعم', 'Configuración del restaurante'),
(680, 'tables', 'admin', 'Tables', 'Tables', 'الجداول', 'Tablas'),
(681, 'img_url', 'admin', 'Image URL', 'Image URL', 'رابط الصورة', 'URL de la imagen'),
(682, 'dboy_list', 'admin', 'Delivery staff List', 'Delivery staff List', 'قائمة موظفي التوصيل', 'Lista de personal de entrega'),
(683, 'delivery_guy_login', 'admin', 'Delivery Guy Login', 'Delivery Guy Login', 'رجل التوصيل تسجيل الدخول', 'Inicio de sesión del repartidor'),
(684, 'personal_info', 'admin', 'Personal Info', 'Personal Info', 'معلومات شخصية', 'Información personal'),
(685, 'customer_panel', 'admin', 'Customer panel', 'Customer panel', 'لوحة العملاء', 'Panel de clientes'),
(686, 'orders', 'admin', 'Orders', 'Orders', 'الطلب #٪ s', 'Pedidos'),
(687, 'pos_print', 'admin', 'POS Print', 'POS Print', 'طباعة POS', 'Impresión POS'),
(688, 'change_password', 'admin', 'Change Password', 'Change Password', 'تغيير كلمة المرور', 'Cambiar contraseña'),
(689, 'order_processed', 'admin', 'Order Processed', 'Order Processed', 'تم انهاء الطلب', 'Pedido procesado'),
(690, 'new_registration', 'admin', 'New Registration', 'New Registration', 'تسجيل جديد', 'Nuevo registro'),
(691, 'already_have_account', 'admin', 'Already have account', 'Already have account', 'لديك حساب بالفعل', 'Ya tengo cuenta'),
(692, 'login_success', 'admin', 'Login successfull', 'Login successful', 'تم تسجيل الدخول بنجاح', 'Inicio de sesión exitoso'),
(693, 'welcome', 'admin', 'Welcome', 'Welcome', 'أهلا بك', 'Bienvenido'),
(694, 'invalid_login', 'admin', 'Invalid login', 'Invalid login', 'تسجيل الدخول غير صالح', 'Inicio de sesión no válido'),
(695, 'registration_successfull', 'admin', 'Registration successfull', 'Registration successful', 'تم التسجيل بنجاح', 'Registro exitoso'),
(696, 'sorry', 'admin', 'Sorry', 'Sorry', 'آسف', 'Lo siento'),
(697, 'top_10_selling_item', 'admin', 'Top 10 Selling Item', 'Top 10 Selling Item', 'أفضل 10 سلعة مبيعًا', 'Los 10 artículos más vendidos'),
(698, 'top_10_most_earning_items', 'admin', 'Top 10 Most Earning Items', 'Top 10 Most Earning Items', 'أعلى 10 عناصر ربحًا', 'Los 10 artículos con más ingresos'),
(699, 'total_amount', 'admin', 'Total Amount', 'Total Amount', 'إجمالي المبلغ', 'Importe total'),
(700, 'times', 'admin', 'Times', 'Times', 'تايمز', 'Tiempos'),
(701, 'tax_fee', 'admin', 'Tax Fee', 'Tax Fee', 'رسوم الضرائب', 'Tasa de impuestos'),
(702, 'minimum_order', 'admin', 'Minumum Order', 'Minimum Order', 'الحد الأدنى للطلب', 'Pedido mínimo'),
(703, 'tax', 'admin', 'Tax', 'Tax', 'ضريبة', 'Impuesto'),
(704, 'dine_in', 'admin', 'Dine-In', 'Dine-In', 'تناول الطعام', 'Cenar'),
(705, 'language_list', 'admin', 'Languages List', 'Languages List', 'قائمة اللغات', 'Lista de idiomas'),
(706, 'show_language_dropdown_in_home', 'admin', 'Show Languages Dropdown in landing page', 'Show Languages Dropdown in landing page', 'عرض قائمة اللغات المنسدلة في الصفحة المقصودة', 'Mostrar menú desplegable de idiomas en la página de destino'),
(707, 'cart_is_empty', 'admin', 'Cart is empty', 'Cart is empty', 'عربة التسوق فارغة', 'El carrito está vacío'),
(708, 'razorpay_key_id', 'admin', 'Razorpay Key Id', 'Razorpay Key Id', 'معرف مفتاح Razorpay', 'ID de clave de Razorpay'),
(709, 'secret_key', 'admin', 'Secret Key', 'Secret Key', 'المفتاح السري', 'Clave secreta'),
(710, 'view_shop', 'admin', 'View Shop', 'View Shop', 'عرض المتجر', 'Ver tienda'),
(711, 'give_your_feedback', 'admin', 'Please give your feedback', 'Please give your feedback', 'الرجاء تقديم ملاحظاتك', 'Por favor, envíenos sus comentarios'),
(712, 'sort_by_newest', 'admin', 'Sort By Newest', 'Sort By Newest', 'فرز حسب الأحدث', 'Ordenar por el más nuevo'),
(713, 'sort_by_highest_rating', 'admin', 'Sort BY Highest Rating', 'Sort BY Highest Rating', 'فرز حسب أعلى تقييم', 'Ordenar por clasificación más alta'),
(714, 'sort_by_lowest_rating', 'admin', 'Sort BY Lowest Rating', 'Sort BY Lowest Rating', 'فرز حسب أقل تقييم', 'Ordenar por calificación más baja'),
(715, 'one_min_ago', 'admin', 'One minute ago', 'One minute ago', 'قبل دقيقة واحدة', 'hace un minuto'),
(716, 'minutes_ago', 'admin', 'Minutes ago', 'Minutes ago', 'قبل دقيقة', 'hace minutos'),
(717, 'an_hour_ago', 'admin', 'An hour ago', 'An hour ago', 'قبل ساعة', 'hace una hora'),
(718, 'hrs_ago', 'admin', 'Hrs ago', 'Hrs ago', 'قبل ساعة', 'hace horas'),
(719, 'yesterday', 'admin', 'Yesterday', 'Yesterday', 'أمس', 'Ayer'),
(720, 'days_ago', 'admin', 'Days ago', 'Days ago', 'منذ أيام', 'hace días'),
(721, 'a_week_ago', 'admin', 'A week ago', 'A week ago', 'قبل أسبوع', 'hace una semana'),
(722, 'weeks_ago', 'admin', 'Weeks ago', 'Weeks ago', 'منذ أسابيع', 'hace semanas'),
(723, 'a_month_ago', 'admin', 'A month ago', 'A month ago', 'قبل شهر', 'hace un mes'),
(724, 'months_ago', 'admin', 'Months ago', 'Months ago', 'منذ شهور', 'hace meses'),
(725, 'one_year_ago', 'admin', 'One year ago', 'One year ago', 'منذ عام واحد', 'hace un año'),
(726, 'years_ago', 'admin', 'Years ago', 'Years ago', 'منذ سنوات', 'hace años'),
(727, 'statistics', 'admin', 'Statistics', 'Statistics', 'إحصائيات', 'Estadísticas'),
(728, 'total_purchased_item', 'admin', 'Total Purchased Items', 'Total Purchased Items', 'إجمالي العناصر المشتراة', 'Total de artículos comprados'),
(729, 'average_based_on', 'admin', 'Average based on', 'Average based on', 'متوسط على أساس', 'promedio basado en'),
(730, 'test_mail', 'admin', 'Test Mail', 'Test Mail', 'بريد تجريبي', 'Correo de prueba'),
(731, 'documentation', 'admin', 'Documentation', 'Documentation', 'التوثيق', 'Documentación'),
(732, 'customer_list', 'admin', 'Customer List', 'Customer List', 'قائمة العملاء', 'Lista de clientes'),
(733, 'total_orders', 'admin', 'Total Orders', 'Total Orders', 'إجمالي الطلبات', 'Total de pedidos'),
(734, 'add_customer', 'admin', 'Add Customer', 'Add Customer', 'إضافة عميل', 'Agregar cliente'),
(735, 'empty-phone', 'admin', 'Your phone is empty, please insert your phone number', 'Your phone is empty, please insert your phone number', 'هاتفك فارغ الرجاء إدخال رقم هاتفك', 'tu teléfono está vacío, ingresa tu número de teléfono'),
(736, 'empty-country-1', 'admin', 'Your country is empty, please Set your country', 'Your country is empty, please Set your country', 'دولتك فارغة , يرجى تحديد بلدك', 'Su país está vacío, por favor configure su país'),
(737, 'empty-country-2', 'admin', 'County will helps you to set your phone code and currency.', 'County will helps you to set your phone code and currency.', 'ستساعدك المقاطعة على تعيين رمز هاتفك وعملتك.', 'El condado le ayudará a configurar su código telefónico y moneda.'),
(738, 'empty-profile', 'admin', 'Your Profile picture is empty, Please Set your Profile picture.', 'Your Profile picture is empty, Please Set your Profile picture.', 'صورة ملفك الشخصي فارغة , يرجى تعيين صورة ملفك الشخصي.', 'Su foto de perfil está vacía, por favor configure su foto de perfil.'),
(739, 'restaurant_empty_msg-0', 'admin', 'If You do not find menu and other options', 'If You do not find menu and other options', 'إذا لم تجد القائمة والخيارات الأخرى', 'Si no encuentra el menú y otras opciones'),
(740, 'restaurant_empty_msg-1', 'admin', 'Make sure Restaurant profile is complete', 'Make sure Restaurant profile is complete', 'تأكد من اكتمال ملف تعريف المطعم', 'Asegúrese de que el perfil del restaurante esté completo'),
(741, 'restaurant_empty_msg-2', 'admin', 'You have to add phone, dial code and country', 'You have to add phone, dial code and country', 'يجب عليك إضافة رقم الهاتف ورمز الاتصال والدولة', 'Tienes que agregar teléfono, código de marcación y país'),
(742, 'staff_password_msg', 'admin', 'Staff password will set 1234', 'Staff password will set 1234', 'كلمة مرور الموظفين ستعيّن 1234', 'La contraseña del personal establecerá 1234'),
(743, 'staff_password_change_msg', 'admin', 'Staff can change their password after login', 'Staff can change their password after login', 'يمكن للموظفين تغيير كلمة المرور الخاصة بهم بعد تسجيل الدخول', 'El personal puede cambiar su contraseña después de iniciar sesión'),
(744, 'dboy_password_msg', 'admin', 'Delivery guy password will set 1234', 'Delivery guy password will set 1234', 'كلمة مرور مسؤول التوصيل ستعيّن 1234', 'La contraseña del repartidor establecerá 1234'),
(745, 'dboy_password_change_msg', 'admin', 'Delivery guy can change password after login', 'Delivery guy can change password after login', 'يستطيع عامل التوصيل تغيير كلمة المرور بعد تسجيل الدخول', 'El repartidor puede cambiar la contraseña después de iniciar sesión'),
(746, 'customer_password_msg', 'admin', 'Customer password will set 1234', 'Customer password will set 1234', 'كلمة مرور العميل ستعيّن 1234', 'La contraseña del cliente establecerá 1234'),
(747, 'customer_password_change_msg', 'admin', 'Customer can change their password after login', 'Customer can change their password after login', 'يمكن للعميل تغيير كلمة المرور الخاصة به بعد تسجيل الدخول', 'El cliente puede cambiar su contraseña después de iniciar sesión'),
(748, 'customer_details', 'admin', 'Customer Details', 'Customer Details', 'تفاصيل العميل', 'Detalles del cliente'),
(749, 'general', 'admin', 'General', 'General', 'عام', 'General'),
(750, 'update_with_my_old_information', 'admin', 'Update with my old information', 'Update with my old information', 'تحديث بمعلوماتي القديمة', 'Actualizar con mi información anterior'),
(751, 'minimum_price_msg_for_cod', 'admin', 'Price not sufficient for COD', 'Price not sufficient for COD', 'السعر غير كافٍ للدفع عند الاستلام', 'Precio no suficiente para COD'),
(752, 'minimum_price', 'admin', 'Minimum Price', 'Minimum Price', 'أدنى سعر', 'Precio mínimo'),
(753, 'add_new_location', 'admin', 'Add New Location', 'Add New Location', 'إضافة موقع جديد', 'Agregar nueva ubicación'),
(754, 'click_the_map_to_get_lan_ln', 'admin', 'Click the map to get Lat/Lng!', 'Click the map to get Lat/Lng!', 'انقر على الخريطة للحصول على Lat / Lng!', '¡Haz clic en el mapa para obtener Lat / Lng!'),
(755, 'customer_will_find_restaurant_with_location', 'admin', 'Customer will find your restaurant using this location', 'Customer will find your restaurant using this location', 'سيجد العميل مطعمك باستخدام هذا الموقع', 'El cliente encontrará su restaurante usando esta ubicación'),
(756, 'search_for_items', 'admin', 'Search For Items', 'Search For Items', 'بحث عن العناصر', 'Buscar artículos'),
(757, 'near_me', 'admin', 'Near Me', 'Near Me', 'بالقرب مني', 'Cerca de mí'),
(758, 'shop_rating', 'admin', 'Shop Rating', 'Shop Rating', 'تقييم المتجر', 'Calificación de la tienda'),
(759, 'available_time', 'admin', 'Available Time', 'Available Time', 'الوقت المتاح', 'Tiempo disponible'),
(760, 'variants', 'admin', 'Variants', 'Variants', 'المتغيرات', 'Variantes'),
(761, 'total_sell', 'admin', 'Total Sell', 'Total Sell', 'إجمالي البيع', 'Venta total'),
(762, 'popular_store', 'admin', 'Popular Store', 'Popular Store', 'متجر شعبي', 'Tienda popular'),
(763, 'popular_items', 'admin', 'Popular Items', 'Popular Items', 'عناصر مشهورة', 'Elementos populares'),
(764, 'item_search', 'admin', 'Item Search', 'Item Search', 'بحث عن عنصر', 'Búsqueda de artículos'),
(765, 'show_item_search_in_landing_page', 'admin', 'Show Item search  in landing page', 'Show Item search  in landing page', 'إظهار بحث العنصر في الصفحة المقصودة', 'Mostrar búsqueda de artículos en la página de destino'),
(766, 'locations', 'admin', 'Locations', 'Locations', 'المواقع', 'Ubicaciones'),
(767, 'latitude', 'admin', 'Latitude', 'Latitude', 'Latitude', 'Latitud'),
(768, 'longitude', 'admin', 'Longitude', 'Longitude', 'خط الطول', 'Longitud'),
(769, 'payment_configuration', 'admin', 'Payment configuration', 'Payment configuration', 'تهيئة الدفع', 'Configuración de pago'),
(770, 'virtual_number', 'admin', 'Virtual Number', 'Virtual Number', 'رقم افتراضي', 'Número virtual'),
(771, 'please_select_your_payment_menthod', 'admin', 'Please select your payment method', 'Please select your payment method', 'الرجاء تحديد طريقة الدفع الخاصة بك', 'Seleccione su método de pago'),
(772, 'none', 'admin', 'None', 'None', 'بلا', 'Ninguno'),
(773, 'add_image', 'admin', 'Add Image', 'Add Image', 'إضافة صورة', 'Agregar imagen'),
(774, 'add_new_images', 'admin', 'Add new images', 'Add new images', 'إضافة صور جديدة', 'Agregar nuevas imágenes'),
(775, 'customer_login_msg', 'admin', 'Enabled customer login in the checkout page', 'Enabled customer login in the checkout page', 'تمكين تسجيل دخول العميل في صفحة الخروج', 'Acceso de cliente habilitado en la página de pago'),
(776, 'reset', 'admin', 'Reset', 'Reset', 'إعادة تعيين', 'Reiniciar'),
(777, 'new', 'admin', 'New', 'New', 'جديد', 'Nuevo'),
(778, 'delivery_area', 'admin', 'Delivery Area', 'Delivery Area', 'منطقة التسليم', 'Área de entrega'),
(779, 'add_delivery_area', 'admin', 'Add delivery Area', 'Add delivery Area', 'إضافة منطقة التسليم', 'Agregar área de entrega'),
(780, 'call_waiter', 'admin', 'Call Waiter', 'Call Waiter', 'نادل الاتصال', 'Llamar al camarero'),
(781, 'call', 'admin', 'Call', 'Call', 'اتصال', 'Llamar'),
(782, 'enable_to_allow_call_waiter', 'admin', 'Enable to allow call waiter service', 'Enable to allow call waiter service', 'تمكين للسماح بخدمة النادل', 'Habilitar para permitir el servicio de llamada al camarero'),
(783, 'call_waiter_msg', 'admin', 'Waiter will get a notification and will available soon!', 'Waiter will get a notification and will available soon!', 'سيتلقى النادل إشعارًا وسيتوفر قريبًا!', '¡El camarero recibirá una notificación y estará disponible pronto!'),
(784, 'waiting_notification_msg', 'admin', 'Please wait waiter will be available soon', 'Please wait, Waiter will be available soon', 'الرجاء الانتظار , سيكون النادل متاحًا قريبًا', 'Espere, el camarero estará disponible pronto'),
(785, 'charge', 'admin', 'Charge', 'Charge', 'المسؤول', 'Cargar'),
(786, 'show_image', 'admin', 'Show Image', 'Show Image', 'إظهار الصورة', 'Mostrar imagen'),
(787, 'active_image', 'admin', 'Active Image', 'Active Image', 'الصورة النشطة', 'Imagen activa'),
(788, 'image_url', 'admin', 'Image URL', 'Image URL', 'عنوان URL للصورة', 'URL de la imagen'),
(789, 'is_svg', 'admin', 'Is SVG', 'Is SVG', 'هل SVG', 'Es SVG'),
(790, 'icon_settings', 'admin', 'Icon Settings', 'Icon Settings', 'إعدادات الرموز', 'Configuración de iconos'),
(791, 'qr_generator', 'admin', 'QR Code Generator', 'QR Code Generator', 'مولد رمز الاستجابة السريعة', 'Generador de códigos QR'),
(792, 'foreground_color', 'admin', 'Foreground Color', 'Foreground Color', 'لون المقدمة', 'Color de primer plano'),
(793, 'background_color', 'admin', 'Background Color', 'Background Color', 'لون الخلفية', 'Color de fondo'),
(794, 'mode', 'admin', 'Mode', 'Mode', 'الوضع', 'Modo'),
(795, 'text', 'admin', 'Text', 'Text', 'نص', 'Texto'),
(796, 'normal', 'admin', 'Normal', 'Normal', 'عادي', 'Normal'),
(797, 'text_color', 'admin', 'Text Color', 'Text Color', 'لون النص', 'Color del texto'),
(798, 'position_x', 'admin', 'Position X', 'Position X', 'المركز X', 'Posición X'),
(799, 'position_y', 'admin', 'Position Y', 'Position Y', 'الموضع Y', 'Posición Y'),
(800, 'qrcode', 'admin', 'Qr Code', 'Qr Code', 'رمز الاستجابة السريعة', 'Código QR'),
(801, 'padding', 'admin', 'Padding', 'Padding', 'حشوة', 'Relleno'),
(802, 'custom_landing_page', 'admin', 'Custom Landing Page', 'Custom Landing Page', 'الصفحة المقصودة المخصصة', 'Página de destino personalizada'),
(803, 'enable_custom_landing_page', 'admin', 'Enable Custom Landing page', 'Enable Custom Landing page', 'تمكين الصفحة المقصودة المخصصة', 'Habilitar página de destino personalizada'),
(804, 'landing_page_url', 'admin', 'Landing Page URL', 'Landing Page URL', 'عنوان URL للصفحة المقصودة', 'URL de la página de destino'),
(805, 'custom_landing_page_msg', 'admin', 'IF you enable this, the user will redirect in your customer page URL when they enter in systems landing page', 'IF you enable this, the user will redirect in your customer page URL when they enter in systems landing page', 'إذا قمت بتمكين هذا , فسيقوم المستخدم بإعادة التوجيه في عنوان URL لصفحة العميل عند الدخول في الصفحة المقصودة للأنظمة', 'SI habilita esto, el usuario redirigirá a la URL de la página de su cliente cuando ingrese a la página de destino del sistema'),
(806, 'installed', 'admin', 'Installed', 'Installed', 'مثبت', 'Instalado'),
(807, 'install', 'admin', 'Install', 'Install', 'تثبيت', 'Instalar'),
(808, 'uninstall', 'admin', 'Uninstall', 'Uninstall', 'إلغاء التثبيت', 'Desinstalar'),
(809, 'not_installed', 'admin', 'Not Installed', 'Not Installed', 'غير مثبت', 'No instalado'),
(810, 'paytm', 'admin', 'Paytm', 'Paytm', 'باوتم', 'Paytm'),
(811, 'stripe_fpx', 'admin', 'Stripe FPX', 'Stripe FPX', 'شريط FPX', 'Stripe FPX'),
(812, 'flutterwave', 'admin', 'Flutterwave', 'Flutterwave', 'Flutterwave', 'Flutterwave'),
(813, 'mercado', 'admin', 'Mercadopago', 'Mercadopago', 'ميركادوباغو', 'Mercadopago'),
(814, 'mercadopago', 'admin', 'Mercadopago', 'Mercadopago', 'ميركادوباغو', 'Mercadopago'),
(815, 'public_key', 'admin', 'Public key', 'Public key', 'المفتاح العمومي', 'Clave pública'),
(816, 'access_token', 'admin', 'Access Token', 'Access Token', 'رمز وصول', 'Token de acceso'),
(817, 'environment', 'admin', 'Environment', 'Environment', 'بيئة', 'Entorno'),
(818, 'area_based_delivery_charge', 'admin', 'Area based delivery charge', 'Area based delivery charge', 'رسوم التسليم على أساس المنطقة', 'Cargo de envío basado en área'),
(819, 'facebook_pixel', 'admin', 'Facebook Pixel', 'Facebook Pixel', 'فيسبوك بيكسل', 'Pixel de Facebook'),
(820, 'facebook_pixel_id', 'admin', 'Facebook Pixel ID', 'Facebook Pixel ID', 'معرف فيسبوك بيكسل', 'ID de píxel de Facebook'),
(821, 'google_analytics_id', 'admin', 'Google Analytics ID', 'Google Analytics ID', 'معرف تحليلات كوكل', 'Identificación de Google Analytics'),
(822, 'customer_waiting_msg', 'admin', 'Customer is waiting at table number', 'Customer is waiting at table number', 'الزبون ينتظر على رقم الجدول', 'El cliente está esperando en la mesa número'),
(823, 'weight', 'admin', 'Weight', 'Weight', 'الوزن', 'Peso'),
(824, 'calories', 'admin', 'Calories', 'Calories', 'السعرات الحرارية', 'Calorías'),
(825, 'is_variants', 'admin', 'Is variants', 'Is variants', 'متغيرات Is', 'Son variantes'),
(826, 'allow_access_google_map_key', 'admin', 'Allow to access google map api key', 'Allow to access google map api key', 'السماح بالوصول إلى مفتاح google map api', 'Permitir acceder a la clave de API de Google Map'),
(827, 'allow_gmap_access', 'admin', 'Allow Gmap Access', 'Allow Gmap Access', 'السماح بالوصول إلى Gmap', 'Permitir acceso a Gmap'),
(828, 'enable', 'admin', 'Enable', 'Enable', 'تمكين', 'Activar'),
(829, 'disable', 'admin', 'Disable', 'Disable', 'تعطيل', 'Desactivar'),
(830, 'add_more_item', 'admin', 'Add More Items', 'Add More Items', 'إضافة المزيد من العناصر', 'Agregar más elementos'),
(831, 'item_added_successfully', 'admin', 'Item Added Successfully', 'Item Added Successfully', 'تمت إضافة العنصر بنجاح', 'Elemento agregado exitosamente'),
(832, 'edit_order', 'admin', 'Edit Order', 'Edit Order', 'تحرير الأمر', 'Editar pedido'),
(833, 'duplicate_item', 'admin', 'Duplicate Item', 'Duplicate Item', 'عنصر مكرر', 'Elemento duplicado'),
(834, 'clone_item', 'admin', 'Clone Item', 'Clone Item', 'عنصر مستنسخ', 'Clonar elemento'),
(835, 'order_again', 'admin', 'Order again', 'Order again', 'اطلب مرة أخرى', 'Pedir de nuevo'),
(836, 'moved_successfull', 'admin', 'Moved successfully', 'Moved successfully', 'انتقلت بنجاح', 'Movido exitosamente'),
(837, 'add_new_item', 'admin', 'Add New Item', 'Add New Item', 'إضافة عنصر جديد', 'Agregar nuevo elemento'),
(838, 'add_those_extras_also', 'admin', 'Add those Extras also', 'Add those Extras also', 'أضف تلك الإضافات أيضًا', 'Agrega esos Extras también'),
(839, 'whatsapp_config', 'admin', 'WhatsApp Config', 'WhatsApp Config', 'تهيئة WhatsApp', 'Configuración de WhatsApp'),
(840, 'currency_position', 'admin', 'Currency Position', 'Currency Position', 'وضع العملة', 'Posición de moneda'),
(841, 'number_format', 'admin', 'Number Format', 'Number Format', 'تنسيق الأرقام', 'Formato de número'),
(842, 'pwa', 'admin', 'PWA', 'PWA', 'PWA', 'PWA'),
(843, 'pwa_config', 'admin', 'PWA Config', 'PWA Config', 'تكوين PWA', 'Configuración PWA'),
(844, 'enable_to_allow_for_all', 'admin', 'Enable to allow PWA in this system', 'Enable to allow PWA in this system', 'تمكين للسماح لـ PWA في هذا النظام', 'Habilitar para permitir PWA en este sistema'),
(845, 'google_font_name', 'admin', 'Google Font name', 'Google Font name', 'اسم خط Google', 'Nombre de fuente de Google'),
(846, 'menu_style', 'admin', 'Menu Style', 'Menu Style', 'نمط القائمة', 'Estilo de menú'),
(847, 'menu_bottom', 'admin', 'Menu Bottom', 'Menu Bottom', 'القائمة السفلية', 'Menú inferior'),
(848, 'menu_top', 'admin', 'Menu Top', 'Menu Top', 'أعلى القائمة', 'Menú superior'),
(849, 'more', 'admin', 'More', 'More', 'المزيد', 'Más'),
(850, 'today', 'admin', 'Today', 'Today', 'اليوم', 'Hoy'),
(851, 'pickup_date', 'admin', 'Pickup Date', 'Pickup Date', 'تاريخ الاستلام', 'Fecha de recogida'),
(852, 'pasta', 'admin', 'Pasta', 'Pasta', 'باستا', 'Pasta'),
(853, 'add_to_home_screen', 'admin', 'Add to home screen', 'Add to home screen', 'إضافة إلى الشاشة الرئيسية', 'Añadir a pantalla de inicio'),
(854, 'coupon_applied_successfully', 'admin', 'Coupon Applied Successfully', 'Coupon Applied Successfully', 'تم تطبيق القسيمة بنجاح', 'Cupón aplicado con éxito'),
(855, 'add_more_image', 'admin', 'Add More Images', 'Add More Images', 'إضافة المزيد من الصور', 'Agregar más imágenes'),
(856, 'custom_css', 'admin', 'Custom CSS', 'Custom CSS', 'CSS مخصص', 'CSS personalizado'),
(857, 'security_pin', 'admin', 'Security Pin', 'Security Pin', 'رقم التعريف الشخصي للأمان', 'Pin de seguridad'),
(858, 'enable_pin_when_customer_track_order', 'admin', 'Enable Pin when customer track their order and when they place call waiter', 'Enable Pin when customer track their order and when they place call waiter', 'تمكين رقم التعريف الشخصي عند تتبع العميل لطلبه وعندما يقوم بإجراء مكالمة النادل', 'Habilitar PIN cuando el cliente rastrea su pedido y cuando llama al camarero'),
(859, 'security_pin_not_match', 'admin', 'Security Pin doesn\'t Match', 'Security Pin doesn\'t Match', 'رقم التعريف الشخصي للأمان غير مطابق', 'El pin de seguridad no coincide'),
(860, 'date_format', 'admin', 'Date Format', 'Date Format', 'تنسيق التاريخ', 'Formato de fecha'),
(861, 'time_format', 'admin', 'Time Format', 'Time Format', 'تنسيق الوقت', 'Formato de hora'),
(862, 'upgrade_license', 'admin', 'Upgrade License', 'Upgrade License', 'ترخيص الترقية', 'Licencia de actualización'),
(863, 'change_domain', 'admin', 'Change Domain', 'Change Domain', 'تغيير المجال', 'Cambiar Dominio'),
(864, 'theme_color', 'admin', 'Theme Color', 'Theme Color', 'لون المظهر', 'Color del tema'),
(865, 'phone_number_is_missing', 'admin', 'Phone Number is missing', 'Phone Number is missing', 'رقم الهاتف مفقود', 'Falta el número de teléfono'),
(866, 'Please_add_your_phone_number', 'admin', 'Please add your phone number', 'Please add your phone number', 'الرجاء إضافة رقم هاتفك', 'Por favor agregue su número de teléfono'),
(867, 'site_name_is_missing', 'admin', 'Site Name is missing', 'Site Name is missing', 'اسم الموقع مفقود', 'Falta el nombre del sitio'),
(868, 'please_config_your_site_settings', 'admin', 'Please configure the site settings', 'Please configure the site settings', 'الرجاء تكوين إعدادات الموقع', 'Configure los ajustes del sitio'),
(869, 'email_is_missing', 'admin', 'Email is missing', 'Email is missing', 'البريد الإلكتروني مفقود', 'falta el correo electronico'),
(870, 'please_confing_the_email', 'admin', 'Please configure the Email settings', 'Please configure the Email settings', 'الرجاء تكوين إعدادات البريد الإلكتروني', 'Configure los ajustes de correo electrónico'),
(871, 'those_steps_are_most_important', 'admin', 'Those Steps are most important to configure first', 'Those Steps are most important to configure first', 'هذه الخطوات هي الأكثر أهمية للتهيئة أولاً', 'Esos pasos son los más importantes para configurar primero'),
(872, 'restaurant_name_is_missing', 'admin', 'Restaurant Name is missing', 'Restaurant Name is missing', 'اسم المطعم مفقود', 'Falta el nombre del restaurante'),
(873, 'please_config_the_shop_settings_configuration', 'admin', 'Please configure restaurant settings and shop configuration', 'Please configure restaurant settings and shop configuration', 'الرجاء تكوين إعدادات المطعم وتهيئة المتجر', 'Configure los ajustes del restaurante y la configuración de la tienda'),
(874, 'order_types_config', 'admin', 'Order Types Configuration', 'Order Types Configuration', 'تكوين أنواع الطلبات', 'Configuración de tipos de órdenes'),
(875, 'enable_payment', 'admin', 'Enable Payment', 'Enable Payment', 'تمكين الدفع', 'Habilitar pago'),
(876, 'pay_later', 'admin', 'Pay Later', 'Pay Later', 'ادفع لاحقًا', 'Paga después'),
(877, 'import', 'admin', 'Import', 'Import', 'استيراد', 'Importar'),
(878, 'required_alert', 'admin', 'Please fill up the % field', 'Please fill up the %s field', 'الرجاء ملء حقل٪ s', 'Por favor complete el campo %s'),
(879, 'pickup_area', 'admin', 'Pickup Area', 'Pickup Area', 'منطقة الالتقاء', 'Área de recogida'),
(880, 'restaurant_empty_alert_msg', 'admin', 'If You do not find menu and other options', 'If You do not find menu and other options, ', 'إذا لم تجد القائمة وخيارات أخرى ,', 'Si no encuentra el menú y otras opciones'),
(881, 'restaurant_empty_alert_msg-2', 'admin', 'Make sure Restaurant profile is complete', 'Make sure Restaurant profile is complete', 'تأكد من اكتمال ملف تعريف المطعم', 'Asegúrese de que el perfil del restaurante esté completo'),
(882, 'restaurant_empty_alert_msg-3', 'admin', 'You have to add phone, dial code and country', 'You have to add phone, dial code and country', 'عليك إضافة رقم الهاتف ورمز الاتصال والدولة', 'Tienes que añadir teléfono, código de marcación y país'),
(883, 'add_coupon', 'admin', 'Add Coupon', 'Add Coupon', 'إضافة قسيمة', 'Añadir Cupón'),
(884, 'used', 'admin', 'Used', 'Used', 'مستعملة', 'Usado'),
(885, 'use_coupon_code', 'admin', 'Use Coupon Code', 'Use Coupon Code', 'استخدم رمز القسيمة', 'Usar código de cupón'),
(886, 'import', 'admin', 'Import', 'Import', 'استيراد', 'Importar'),
(887, 'coupon_discount', 'admin', 'Coupon Discount', 'Coupon Discount', 'خصم القسيمة', 'Cupón de descuento'),
(888, 'limit', 'admin', 'Limit', 'Limit', 'حد', 'Límite'),
(889, 'apply', 'admin', 'Apply', 'Apply', 'تطبيق', 'Aplicar'),
(890, 'do_you_have_coupon', 'admin', 'Do you have coupon?', 'Do you have coupon?', 'هل لديك قسيمة؟', '¿Tienes cupón?'),
(891, 'end_date', 'admin', 'End Date', 'End Date', 'تاريخ الانتهاء', 'Fecha de finalización'),
(892, 'coupon_code', 'admin', 'Coupon Code', 'Coupon Code', 'رمز القسيمة', 'Código de cupón'),
(893, 'coupon_code_reached_the_max_limit', 'admin', 'Coupon code reached the maximum limit', 'Coupon code reached the maximum limit', 'وصل رمز القسيمة إلى الحد الأقصى', 'El código de cupón alcanzó el límite máximo'),
(894, 'coupon_code_not_exists', 'admin', 'Coupon code not exists', 'Coupon code not exists', 'رمز القسيمة غير موجود', 'El código de cupón no existe'),
(895, 'coupon_list', 'admin', 'Coupon List', 'Coupon List', 'قائمة القسيمة', 'Lista de cupones'),
(896, 'paystack', 'admin', 'Paystack', 'Paystack', 'Paystack', 'Pila de pago'),
(897, 'paystack_publick_key', 'admin', 'Paystack Public Key', 'Paystack Public Key', 'Paystack Public Key', 'Clave pública de la pila de pago'),
(898, 'paystack_secret_key', 'admin', 'Paystack Secret Key', 'Paystack Secret Key', 'مفتاح Paystack السري', 'Clave secreta de la pila de pago'),
(899, 'paystack_payment_gateways', 'admin', 'Paystack Payment Gateways', 'Paystack Payment Gateways', 'بوابات دفع Paystack', 'Pasarelas de pago de Paystack'),
(900, 'nearby_radius', 'admin', 'Nearby Radius', 'Nearby Radius', 'النطاق القريب', 'Radio Cercano'),
(901, 'all_extras', 'admin', 'All Extras', 'All Extras', 'كافة الإضافات', 'Todos los extras'),
(902, 'add_extra', 'admin', 'Add Extra', 'Add Extra', 'إضافة إضافي', 'Agregar adicional'),
(903, 'onsignal_api', 'admin', 'OnSignal  API', 'OnSignal  API', 'onSignal API', 'API onSignal'),
(904, 'onsignal_app_id', 'admin', 'Onesignal App ID', 'Onesignal App ID', 'معرف تطبيق Onesignal', 'ID de la aplicación Onesignal'),
(905, 'user_auth_key', 'admin', 'User Auth Key', 'User Auth Key', 'مفتاح مصادقة المستخدم', 'Clave de autenticación de usuario'),
(906, 'allow_onsignal_access', 'admin', 'Allow onSignal Notification', 'Allow onSignal Notification', 'السماح بالإعلام عند الإشارة', 'Permitir notificación onSignal'),
(907, 'disabled_onsignal_access', 'admin', 'Disabled onSignal Notification', 'Disabled onSignal Notification', 'معطل عند إعلام الإشارة', 'Notificación onSignal deshabilitada'),
(908, 'custom_link', 'admin', 'Custom Link', 'Custom Link', 'رابط مخصص', 'Enlace personalizado'),
(909, 'send_notifications', 'admin', 'Send Notification', 'Send Notification', 'إرسال إشعار', 'Enviar notificación'),
(910, 'notifications_send_successfully', 'admin', 'Notifications send successfully', 'Notifications send successfully', 'إرسال الإشعارات بنجاح', 'Notificaciones enviadas con éxito'),
(911, 'hide_pay_later', 'admin', 'Hide Pay later', 'Hide Pay later', 'إخفاء الدفع لاحقًا', 'Ocultar Pagar luego'),
(912, 'payment_required', 'admin', 'Payment Required', 'Payment Required', 'الدفع مطلوب', 'Pago requerido'),
(913, 'table_no', 'admin', 'Table No', 'Table No', 'جدول لا', 'Número de tabla'),
(914, '6_month', 'admin', 'Half Year / 6 month', 'Half Year / 6 month', 'نصف عام / 6 أشهر', 'Medio año / 6 meses'),
(915, 'half_yearly', 'admin', 'Half Year / 6 month', 'Half Year- 6 month', 'نصف عام- 6 أشهر', 'Medio año- 6 meses'),
(916, 'signup_questions', 'admin', 'Signup Questions', 'Signup Questions', 'أسئلة الاشتراك', 'Preguntas de registro'),
(917, 'security_question', 'admin', 'Security Question', 'Security Question', 'سؤال الأمان', 'Pregunta de seguridad'),
(918, 'write_your_answer_here', 'admin', 'Write your answer here', 'Write your answer here', 'اكتب إجابتك هنا', 'Escribe aquí tu respuesta'),
(919, 'enable_security_question', 'admin', 'Enable Security Question', 'Enable Security Question', 'تمكين سؤال الأمان', 'Habilitar pregunta de seguridad'),
(920, 'security_question_ans_not_correct', 'admin', 'Security Questions answer is not correct', 'Security Questions answer is not correct', 'إجابة أسئلة الأمان غير صحيحة', 'La respuesta a las preguntas de seguridad no es correcta'),
(921, 'change', 'admin', 'Change', 'Change', 'تغيير', 'Cambiar'),
(922, 'change_amount', 'admin', 'Change Amount', 'Change Amount', 'تغيير المبلغ', 'Cambiar Importe'),
(923, 'enable_radius_base_delivery', 'admin', 'Enable Raduis Based Delivery', 'Enable Radius Based Delivery', 'تمكين التسليم المستند إلى نصف القطر', 'Habilitar entrega basada en radio'),
(924, 'delivery_settings', 'admin', 'Delivery Settings', 'Delivery Settings', 'إعدادات التسليم', 'Configuración de entrega'),
(925, 'radius_base_delivery_settings', 'admin', 'Enable Radius Based Delivery Settings', 'Radius Based Delivery Settings', 'إعدادات التسليم على أساس نصف القطر', 'Configuración de entrega basada en el radio'),
(926, 'radius', 'admin', 'Radius', 'Radius', 'نصف القطر', 'Radio'),
(927, 'not_found_msg', 'admin', 'Not Found Message', 'Not Found Message', 'لم يتم العثور على الرسالة', 'Mensaje no encontrado');
INSERT INTO `language_data` (`id`, `keyword`, `type`, `details`, `english`, `ar`, `es`) VALUES
(928, 'price_tax_msg', 'admin', 'Tax are only for showing tax status in invoice. Set your price including/excluding tax', 'Tax are only for showing tax status in invoice. Set your price including/excluding tax', 'الضريبة هي فقط لعرض الحالة الضريبية في الفاتورة. حدد السعر بما في ذلك / باستثناء الضرائب', 'El impuesto es solo para mostrar el estado del impuesto en la factura. Establezca su precio con/sin impuestos'),
(929, 'item_tax_status', 'admin', 'Item Tax Status', 'Item Tax Status', 'حالة ضريبة العنصر', 'Estado fiscal del artículo'),
(930, 'tax_included', 'admin', 'Tax Included', 'Tax Included', 'شامل الضريبة', 'Impuestos Incluidos'),
(931, 'tax_excluded', 'admin', 'Tax Excluded', 'Tax Excluded', 'معفاة من الضرائب', 'Impuestos Excluidos'),
(932, 'kds_pin', 'admin', 'KDS Pin', 'KDS Pin', 'KDS Pin', 'Pin KDS'),
(933, 'enter_pin', 'admin', 'Enter Pin', 'Enter Pin', 'أدخل رقم التعريف الشخصي', 'Ingresar PIN'),
(934, 'Qr Code', 'admin', 'Qr code', 'Qr code', 'رمز الاستجابة السريعة', 'Código QR'),
(935, 'specialities', 'admin', 'Specialities', 'Specialities', 'التخصصات', 'Especialidades'),
(936, 'subscriber list', 'admin', 'Subscribers List', 'Subscribers List', 'قائمة المشتركين', 'Lista de suscriptores'),
(937, 'subscribers', 'admin', 'Subscribers', 'Subscribers', 'المشتركون', 'Suscriptores'),
(938, 'third-party_chatting_app', 'admin', 'Third-party chatting apps', 'Third-party chatting apps', 'تطبيقات الدردشة من جهات خارجية', 'Aplicaciones de chat de terceros'),
(939, 'choose_an_app', 'admin', 'Choose an App', 'Choose an App', 'اختر تطبيقًا', 'Elija una aplicación'),
(940, 'app_id', 'admin', 'App ID', 'App ID', 'معرف التطبيق', 'ID de la aplicación'),
(941, 'onesignal_configuration', 'admin', 'OneSignal Configuration', 'OneSignal Configuration', 'تكوين OneSignal', 'Configuración OneSignal'),
(942, 'verify_payment', 'admin', 'Verify Payment', 'Verify Payment', 'التحقق من الدفع', 'Verificar pago'),
(943, 'transaction_id', 'admin', 'Transaction ID', 'Transaction ID', 'معرف المعاملة', 'ID de transacción'),
(944, 'bank_details', 'admin', 'Bank Details', 'Bank Details', 'تفاصيل البنك', 'Datos bancarios'),
(945, 'enable_transaction_id_field', 'admin', 'Enable Transaction ID field', 'Enable Transaction ID field', 'تمكين حقل معرف المعاملة', 'Habilitar campo ID de transacción'),
(946, 'sendgrid_api_key', 'admin', 'SendGrid API KEy', 'SendGrid API Key', 'SendGrid API Key', 'Clave API SendGrid'),
(947, 'api_key', 'admin', 'API Key', 'API Key', 'مفتاح API', 'Clave API'),
(948, 'sendgrid', 'admin', 'SendGrid', 'SendGrid', 'SendGrid', 'EnviarCuadrícula'),
(949, 'activities', 'admin', 'Activities', 'Activities', 'أنشطة', 'Actividades'),
(950, 'mark_as_unread', 'admin', 'Mark as Unread', 'Mark as Unread', 'وضع علامة كغير مقروءة', 'Marcar como no leído'),
(951, 'mark_as_read', 'admin', 'Mark as read', 'Mark as read', 'وضع علامة كمقروء', 'Marcar como leído'),
(952, 'send_payment_mail_to_user', 'admin', 'Send Payment Mail to the user', 'Send Payment Mail to the user', 'إرسال بريد الدفع إلى المستخدم', 'Enviar correo de pago al usuario'),
(953, 'unseen_notification', 'admin', 'Unseen Notification', 'Unseen Notification', 'إعلام غير مرئي', 'Notificación no vista'),
(954, 'seen_notification', 'admin', 'Seen Notification', 'Seen Notification', 'إشعار مرئي', 'Notificación vista');
(955, 'unseen', 'admin', 'Unseen', 'Unseen', 'غير مرئي', 'Invisible'),
(956, 'unseen_last_notification', 'admin', 'Unseen Last Notification', 'Unseen Last Notification', 'آخر إشعار غير مرئي', 'Última notificación no vista'),
(957, 'send_notification', 'admin', 'Send Notification', 'Send Notification', 'إرسال إشعار', 'Enviar notificación'),
(958, 'seen', 'admin', 'Seen', 'Seen', 'مرئي', 'Visto'),
(959, 'send_time', 'admin', 'Send Time', 'Send Time', 'وقت الإرسال', 'Hora de envío'),
(960, 'select_notification', 'admin', 'Select Notification', 'Select Notification', 'تحديد إعلام', 'Seleccionar notificación'),
(961, 'notification_list', 'admin', 'Notification List', 'Notification List', 'قائمة التنبيهات', 'Lista de notificaciones'),
(962, 'create_notification', 'admin', 'Create Notification', 'Create Notification', 'إنشاء إعلام', 'Crear notificación'),
(963, 'manage_order_types', 'admin', 'Manage Order Types', 'Manage Order Types', 'إدارة أنواع الأوامر', 'Gestionar tipos de órdenes'),
(964, 'select_all', 'admin', 'Select All', 'Select All', 'تحديد الكل', 'Seleccionar todo'),
(965, 'checked_all', 'admin', 'Checked All', 'Checked All', 'تم تحديد الكل', 'Marcado todo'),
(966, 'custom_fields', 'admin', 'Custom Fields', 'Custom Fields', 'الحقول المخصصة', 'Campos personalizados'),
(967, 'demo', 'admin', 'Demo', 'Demo', 'عرض توضيحي', 'Demostración'),
(968, 'restaurant_demo', 'admin', 'Restaurant Demo ', 'Demo Restaurant', 'مطعم تجريبي', 'Restaurante de demostración'),
(969, 'mark_as_delivered', 'admin', 'Mark as delivered', 'Mark as delivered', 'وضع علامة تم التسليم', 'Marcar como entregado'),
(970, 'delivered', 'admin', 'Delivered', 'Delivered', 'تم التسليم', 'Entregado'),
(971, 'select_delivery_boy', 'admin', 'Select Delivery Boy', 'Select Delivery Boy', 'Select Delivery Boy', 'Seleccionar repartidor'),
(972, 'mark_as_paid', 'admin', 'Mark as Paid', 'Mark as Paid', 'وضع علامة كمدفوع', 'Marcar como pagado'),
(973, 'unpaid', 'admin', 'Unpaid', 'Unpaid', 'غير مدفوع', 'Sin pagar'),
(974, 'mark_as_completed_paid', 'admin', 'Mark as completed & Paid', 'Mark as completed & Paid', 'وضع علامة مكتمل ومدفوع', 'Marcar como completado y pagado'),
(975, 'completed_paid', 'admin', 'Completed & Paid', 'Completed & Paid', 'مكتمل ومدفوع', 'Completado y pagado'),
(976, 'add_delivery_boy', 'admin', 'Add delivery Boy', 'Add delivery guy', 'إضافة مندوب توصيل', 'Añadir repartidor'),
(977, 'dboy_name', 'admin', 'Delivery Guy', 'Delivery Guy', 'مندوب التوصيل', 'Repartidor'),
(978, 'selectd_by_restaurant', 'admin', 'Selected by Restaurant', 'Selected by Restaurant', 'محدد حسب المطعم', 'Seleccionado por Restaurante'),
(979, 'vendor', 'admin', 'Vendor', 'Vendor', 'بائع', 'Vendedor'),
(980, 'account_created_successfully', 'admin', 'Account Created Successfully', 'Account Created Successfully', 'تم إنشاء الحساب بنجاح', 'Cuenta creada con éxito'),
(981, 'account_confirmation_link_msg', 'admin', 'The account confirmation link has been emailed to you, follow the link in the email to continue.', 'The account confirmation link has been emailed to you, follow the link in the email to continue.', 'تم إرسال رابط تأكيد الحساب إليك عبر البريد الإلكتروني , اتبع الرابط الموجود في البريد الإلكتروني للمتابعة.', 'El enlace de confirmación de la cuenta se le ha enviado por correo electrónico, siga el enlace en el correo electrónico para continuar.'),
(982, 'please_login_to_continue', 'admin', 'Please Login to continue.', 'Please Login to continue.', 'الرجاء تسجيل الدخول للمتابعة.', 'Inicie sesión para continuar.'),
(983, 'sorry_today_pickup_time_is_not_available', 'admin', 'Sorry, Pickup Time is not available today', 'Sorry, Pickup Time is not available today', 'عذرًا , وقت الاستلام غير متاح اليوم', 'Lo sentimos, la hora de recogida no está disponible hoy'),
(984, 'table-dine-in', 'admin', 'Table / Dine-in', 'Table / Dine-in', 'طاولة / تناول طعام في', 'Mesa / Comedor'),
(985, 'enable_whatsapp_for_order', 'admin', 'Enable WhatsApp For order', 'Enable WhatsApp For order', 'تمكين WhatsApp للطلب', 'Habilitar WhatsApp para pedidos'),
(986, 'room_services', 'admin', 'Room services', 'Room services', 'خدمات الغرف', 'Servicio de habitaciones'),
(987, 'hotel_name', 'admin', 'Hotel Name', 'Hotel Name', 'اسم الفندق', 'Nombre del hotel'),
(988, 'hotel_list', 'admin', 'Hotel List', 'Hotel List', 'قائمة الفنادق', 'Lista de hoteles'),
(989, 'room_numbers', 'admin', 'Room Numbers', 'Room Numbers', 'أرقام الغرف', 'Números de habitaciones'),
(990, 'sorry_room_numbers_not_available', 'admin', 'Sorry Room Not found', 'Sorry Room Not found', 'لم يتم العثور على غرفة معذرة', 'Lo siento, habitación no encontrada'),
(991, 'room_number', 'admin', 'Room Number', 'Room Number', 'رقم الغرفة', 'Número de habitación'),
(992, 'package_restaurant_dine_in', 'admin', 'Package / Restaurant Dine-In', 'Package / Restaurant Dine-In', 'حزمة / تناول الطعام في المطعم', 'Paquete / Cena en restaurante'),
(993, 'open_24_hours', 'admin', 'Open 24 Hours', 'Open 24 Hours', 'مفتوح 24 ساعة', 'Abierto 24 Horas'),
(994, 'enable_24_hours', 'admin', 'Enable 24 Hours', 'Enable 24 Hours', 'تمكين 24 ساعة', 'Habilitar 24 Horas'),
(995, 'select_room_number', 'admin', 'Select Room Number', 'Select Room Number', 'حدد رقم الغرفة', 'Seleccionar número de habitación'),
(996, 'coupon', 'admin', 'Coupon', 'Coupon', 'قسيمة', 'Cupón'),
(997, 'check_coupon_code', 'admin', 'Check Coupon Code', 'Check Coupon Code', 'تحقق من رمز القسيمة', 'Ver código de cupón'),
(998, 'shipping_charge', 'admin', 'Shipping Charge', 'Shipping Charge', 'رسوم الشحن', 'Costo de envío'),
(999, 'remaining_person', 'admin', 'Remaining Person', 'Remaining Person', 'الشخص المتبقي', 'Persona Restante'),
(1000, 'booked', 'admin', 'Booked', 'Booked', 'محجوز', 'Reservado'),
(1001, 'process_to_complete', 'admin', 'Process to complete', 'Process to complete', 'إكمال العملية', 'Proceso a completar'),
(1002, 'payment_type', 'admin', 'Payment Type', 'Payment Type', 'نوع الدفع', 'Tipo de pago'),
(1003, 'received_amount', 'admin', 'Received Amount', 'Received Amount', 'المبلغ المستلم', 'Cantidad recibida'),
(1004, 'paying_amount', 'admin', 'Paying Amount', 'Paying Amount', 'دفع المبلغ', 'Importe a pagar'),
(1005, 'change_return', 'admin', 'Change Return', 'Change Return', 'تغيير العودة', 'Cambiar devolución'),
(1006, 'payment_notes', 'admin', 'Payment Notes', 'Payment Notes', 'ملاحظات الدفع', 'Notas de pago'),
(1007, 'sell_notes', 'admin', 'Sell Notes', 'Sell Notes', 'بيع الملاحظات', 'Notas de venta'),
(1008, 'cash', 'admin', 'Cash', 'Cash', 'نقدًا', 'Efectivo'),
(1009, 'cheques', 'admin', 'Cheques', 'Cheques', 'الشيكات', 'Cheques'),
(1010, 'bank_transfer', 'admin', 'Bank Transfer', 'Bank Transfer', 'التحويل المصرفي', 'Transferencia Bancaria'),
(1011, 'pos', 'admin', 'POS', 'POS', 'POS', 'POS'),
(1012, 'total_items', 'admin', 'Total Items', 'Total Items', 'إجمالي العناصر', 'Artículos Totales'),
(1013, 'pagination_limit', 'admin', 'Pagination Limit', 'Pagination Limit', 'حد ترقيم الصفحات', 'Límite de paginación'),
(1014, 'scroll_top_arrow', 'admin', 'Scroll Top Arrow', 'Scroll Top Arrow', 'التمرير للسهم العلوي', 'Flecha superior de desplazamiento'),
(1015, 'restaurant_email', 'admin', 'Restaurant Email', 'Restaurant Email', 'البريد الإلكتروني للمطعم', 'Correo electrónico del restaurante'),
(1016, 'next', 'admin', 'Next', 'Next', 'التالي', 'Siguiente'),
(1017, 'previous', 'admin', 'Previous', 'Previous', 'السابق', 'Anterior'),
(1018, 'first', 'admin', 'First', 'First', 'الأول', 'Primero'),
(1019, 'last', 'admin', 'Last', 'Last', 'الأخير', 'Último'),
(1020, 'entries', 'admin', 'Entries', 'Entries', 'إدخالات', 'Entradas'),
(1021, 'showing', 'admin', 'Showing', 'Showing', 'إظهار', 'Mostrando'),
(1022, 'to', 'admin', 'To', 'To', 'إلى', 'A'),
(1023, 'of', 'admin', 'Of', 'Of', 'من', 'De'),
(1024, 'earnings', 'admin', 'Earnings', 'Earnings', 'أرباح', 'Ganancias'),
(1025, 'reports', 'admin', 'Reports', 'Reports', 'تقارير', 'Informes'),
(1026, 'item_sales_count', 'admin', 'Item Sales Count', 'Item Sales Count', 'عدد مبيعات الصنف', 'Recuento de ventas de artículos'),
(1027, 'total_order', 'admin', 'Total Order', 'Total Orders', 'إجمالي الطلبات', 'Pedidos Totales'),
(1028, 'all_time', 'admin', 'All Time', 'All Time', 'كل الأوقات', 'Todo el tiempo'),
(1029, 'balance', 'admin', 'Balance', 'Balance', 'توازن', 'Saldo'),
(1030, 'todays_earning', 'admin', 'Today\'s Earning', 'Today\'s Earning', 'أرباح اليوم', 'Ganancias de hoy'),
(1031, 'monthly_earning', 'admin', 'Monthly Earning', 'Monthly Earning', 'الأرباح الشهرية', 'Ganancia mensual'),
(1032, 'previous_month_earning', 'admin', 'Previous Month  Earning', 'Previous Month  Earning', 'أرباح الشهر الماضي', 'Ganancias del mes anterior'),
(1033, 'weekly_earning', 'admin', 'Weekly Earning', 'Weekly Earning', 'الأرباح الأسبوعية', 'Ganancia semanal'),
(1034, 'previous_week_earning', 'admin', 'Previous Week Earning', 'Previous Week Earning', 'أرباح الأسبوع السابق', 'Ganancias de la semana anterior'),
(1035, 'order_mail', 'admin', 'Order Mail', 'Order Mail', 'بريد الطلب', 'Pedir correo'),
(1036, 'restaurant_owner', 'admin', 'Restaurant Owner', 'Restaurant Owner', 'صاحب المطعم', 'Dueño del Restaurante'),
(1037, 'enable_mail', 'admin', 'Enable Mail', 'Enable Mail', 'تمكين البريد', 'Habilitar correo'),
(1038, 'order_receive_mail', 'admin', 'Order Reveiver Mail', 'Order Receiver Mail', 'بريد استقبال الطلب', 'Correo del destinatario del pedido'),
(1039, 'customer_mail', 'admin', 'Customer mail', 'Customer mail', 'بريد العميل', 'Correo del cliente'),
(1040, 'enable_mail_in_checkout', 'admin', 'Enable Mail in checkout', 'Enable Mail in checkout', 'تمكين البريد في السداد', 'Habilitar correo al finalizar la compra'),
(1041, 'your_order_is_ready_to_delivery', 'admin', 'Your Order is ready to delivery', 'Your Order is ready to delivery', 'طلبك جاهز للتسليم', 'Su pedido está listo para ser entregado'),
(1042, 'waiting_for_picked', 'admin', 'Waiting For Picked', 'Waiting For Picked', 'في انتظار الاختيار', 'Esperando ser elegido'),
(1043, 'add_ons', 'admin', 'Add-Ons', 'Add-Ons', 'الوظائف الإضافية', 'Complementos'),
(1044, 'the_table_is_empty', 'admin', 'The Table is empty', 'The Table is empty', 'الجدول فارغ', 'la mesa esta vacia'),
(1045, 'there_are_customers', 'admin', 'There Are Customers', 'There Are Customers', 'هناك عملاء', 'hay clientes'),
(1046, 'have_a_new_order', 'admin', 'Have a new Order', 'Have a new Order', 'لديك طلب جديد', 'Tener un nuevo pedido'),
(1047, 'waiter_calling', 'admin', 'Waiter Calling', 'Waiter Calling', 'النادل يدعو', 'Camarero llamando'),
(1048, 'tax_number', 'admin', 'Tax Number', 'Tax Number', 'الرقم الضريبي', 'Número fiscal'),
(1049, 'city', 'admin', 'City', 'City', 'مدينة', 'Ciudad'),
(1050, 'i_need_change', 'admin', 'I need Change', 'I need Change', 'أحتاج إلى التغيير', 'Necesito Cambio'),
(1051, 'language_switcher', 'admin', 'Language switcher', 'Language switcher', 'محوّل اللغة', 'Cambiador de idioma'),
(1052, 'enable_coupon', 'admin', 'Enable Coupon', 'Enable Coupon', 'تمكين القسيمة', 'Habilitar cupón'),
(1053, 'package_qr_builder', 'admin', 'Package Qr Builder', 'Package Qr Builder', 'Package Qr Builder', 'Constructor Qr de paquetes'),
(1054, 'table_qr_builder', 'admin', 'Table Qr Builder', 'Table Qr Builder', 'Table Qr Builder', 'Creador QR de tablas'),
(1055, 'staff_login', 'admin', 'Staff Login', 'Staff Login', 'تسجيل دخول الموظفين', 'Inicio de sesión del personal'),
(1056, 'order_limits', 'admin', 'Order Limit', 'Order Limit', 'حد الطلب', 'Límite de pedido'),
(1057, 'item_limit', 'admin', 'Item Limit', 'Item Limit', 'حد العنصر', 'Límite de artículos'),
(1058, 'newly_added', 'admin', 'Newly added', 'Newly added', 'مضاف حديثًا', 'Recién agregado'),
(1059, 'renewal', 'admin', 'Renewal\\', 'Renewal', 'تجديد', 'Renovación'),
(1060, 'important_steps_to_fill', 'admin', 'Those Steps are most important to configure first', 'Those Steps are most important to configure first', 'هذه الخطوات هي الأكثر أهمية للتهيئة أولاً', 'Esos pasos son los más importantes para configurar primero'),
(1061, 'staff_activities', 'admin', 'Staff Activities', 'Staff Activities', 'أنشطة الموظفين', 'Actividades del personal'),
(1062, 'staff_name', 'admin', 'Staff Name', 'Staff Name', 'اسم طاقم العمل', 'Nombre del personal'),
(1063, 'table_already_booked_try_different_one', 'admin', 'Table already Booked try different one', 'Table already Booked try different one', 'طاولة محجوزة بالفعل جرب واحدة أخرى', 'Mesa ya Reservada probar otra diferente'),
(1064, 'supervised_by', 'admin', 'Supervised by', 'supervised by', 'تحت إشراف', 'supervisado por'),
(1065, 'permission', 'admin', 'Permission', 'Permission', 'إذن', 'Permiso'),
(1066, 'reset_password', 'admin', 'Reset Password', 'Reset Password', 'إعادة تعيين كلمة المرور', 'Restablecer contraseña'),
(1067, 'robot_verification_failed', 'admin', 'Robot verification Failed', 'Robot verification Failed', 'فشل التحقق من الروبوت', 'Verificación del robot fallida'),
(1068, 'username_already_exists', 'admin', 'Username Already Exists', 'Username Already Exists', 'اسم المستخدم موجود بالفعل', 'El nombre de usuario ya existe'),
(1069, 'custom_days', 'admin', 'Custom Days', 'Custom Days', 'أيام مخصصة', 'Días personalizados'),
(1070, 'set_duration', 'admin', 'Set Duration', 'Set Duration', 'تعيين المدة', 'Establecer duración'),
(1071, 'months', 'admin', 'Months', 'Months', 'شهور', 'Meses'),
(1072, 'years', 'admin', 'Years', 'Years', 'سنوات', 'Años'),
(1073, 'appearance', 'admin', 'Appearance', 'Appearance', 'المظهر', 'Apariencia'),
(1074, 'frontend_color', 'admin', 'Frontend Color', 'Frontend Color', 'لون الواجهة الأمامية', 'Color frontal'),
(1075, 'light', 'admin', 'Light', 'Light', 'فاتح', 'Luz'),
(1076, 'dark', 'admin', 'Dark', 'Dark', 'مظلم', 'Oscuro'),
(1077, 'add_extras_from_library', 'admin', 'Add Extras from library', 'Add Extras from library', 'إضافة إضافات من المكتبة', 'Agregar extras de la biblioteca'),
(1078, 'merge_with_previous_order', 'admin', 'Merge with previous order', 'Merge with previous order', 'دمج بالترتيب السابق', 'Fusionar con orden anterior'),
(1079, 'grand_total', 'admin', 'Grand Total', 'Grand Total', 'الإجمالي الكلي', 'Total general'),
(1080, 'previous_order', 'admin', 'Previous Order', 'Previous Order', 'الطلب السابق', 'Pedido anterior'),
(1081, 'enable_order_merge', 'admin', 'Enable Order merge', 'Enable Order merge', 'تمكين دمج الطلبات', 'Habilitar combinación de pedidos'),
(1082, 'merge_automatically', 'admin', 'Merge Automatically', 'Merge Automatically', 'دمج تلقائيًا', 'Combinar automáticamente'),
(1083, 'allow_customers_to_select', 'admin', 'Allow Customers to select', 'Allow Customers to select', 'السماح للعملاء بالاختيار', 'Permitir que los clientes seleccionen'),
(1084, 'order_merge', 'admin', 'Order Merge', 'Order Merge', 'ترتيب الدمج', 'Fusión de pedidos'),
(1085, 'make_it_as_single_order', 'admin', 'Make it as a single order', 'Make it as a single order', 'اجعله طلبًا واحدًا', 'Hacerlo como un solo pedido'),
(1086, 'edit_order_details', 'admin', 'Edit order details', 'Edit order details', 'تحرير تفاصيل الطلب', 'Editar detalles del pedido'),
(1087, 'hold', 'admin', 'Hold', 'Hold', 'تعليق', 'Esperar'),
(1088, 'request_id', 'admin', 'Request ID', 'Request ID', 'معرف الطلب', 'Solicitar ID'),
(1089, 'request_name', 'admin', 'Request Name', 'Request Name', 'اسم الطلب', 'Solicitar nombre'),
(1090, 'current_name', 'admin', 'Current Name', 'Current Name', 'الاسم الحالي', 'Nombre actual'),
(1091, 'url', 'admin', 'URL', 'URL', 'URL', 'URL'),
(1092, 'running', 'admin', 'Running', 'Running', 'قيد التشغيل', 'Corriendo'),
(1093, 'custom_domain', 'admin', 'Custom Domain', 'Custom Domain', 'مجال مخصص', 'Dominio personalizado'),
(1094, 'domain_list', 'admin', 'Domain List', 'Domain List', 'قائمة المجال', 'Lista de dominios'),
(1095, 'set_comments', 'admin', 'Set Comments', 'Set Comments', 'تعيين التعليقات', 'Establecer comentarios'),
(1096, 'approved_date', 'admin', 'Approved Date', 'Approved Date', 'التاريخ المعتمد', 'Fecha de aprobación'),
(1097, 'approved_message', 'admin', 'Approved message', 'Approved message', 'الرسالة المعتمدة', 'Mensaje aprobado'),
(1098, 'canceled_message', 'admin', 'Canceled Messge', 'Canceled Messge', 'الرسائل الملغاة', 'Mensaje cancelado'),
(1099, 'send_request', 'admin', 'Send Request', 'Send Request', 'ارسل طلب', 'Enviar petición'),
(1100, 'pagadito', 'admin', 'Pagadito', 'Pagadito', 'Pagadito', 'Pagadito'),
(1101, 'digital_payment', 'admin', 'Digital Payment', 'Digital Payment', 'الدفع الرقمي', 'Pago Digital'),
(1102, 'get_google_location', 'admin', 'Get Google locaction', 'Get Google location', 'الحصول على موقع Google', 'Obtener ubicación de Google'),
(1103, 'pusher', 'admin', 'Pusher', 'Pusher', 'انتهازي', 'Empujador'),
(1104, 'key', 'admin', 'Key', 'Key', 'مفتاح', 'Clave'),
(1105, 'secret', 'admin', 'Secret', 'Secret', 'سر', 'Secreto'),
(1106, 'cluster', 'admin', 'Cluster', 'Cluster', 'الكتلة', 'Clúster'),
(1107, 'auth_key', 'admin', 'Auth Key', 'Auth Key', 'مفتاح المصادقة', 'Clave de autenticación'),
(1108, 'a_new_order_is_merge', 'admin', 'A new order is merged', 'A new order is merged', 'تم دمج طلب جديد', 'Se ha fusionado un nuevo pedido'),
(1109, 'order_id_is_merged', 'admin', 'Order is merged', 'ORDER_ID is merged', 'تم دمج ORDER_ID', 'ORDER_ID se fusionó'),
(1110, 'merge_id', 'admin', 'Merge ID', 'Merge ID', 'معرّف الدمج', 'Combinar ID'),
(1111, 'order_merged', 'admin', 'Order Merged', 'Order Merged', 'تم دمج الطلب', 'Pedido fusionado'),
(1112, 'merged_item', 'admin', 'Merged Item', 'Merged Item', 'عنصر مدمج', 'Elemento combinado'),
(1113, 'disabled', 'admin', 'Disabled', 'Disabled', 'معطل', 'Deshabilitado'),
(1114, 'enabled', 'admin', 'Enabled', 'Enabled', 'ممكّن', 'Habilitado'),
(1115, 'enabled_for_restaurant', 'admin', 'Enable for restauratn', 'Status for restaurants', 'حالة المطاعم', 'Estado de los restaurantes'),
(1116, 'enable_development_mode', 'admin', 'Enable Development Mode', 'Enable Development Mode', 'تمكين وضع التطوير', 'Habilitar modo de desarrollo'),
(1117, 'expenses', 'admin', 'Expenses', 'Expenses', 'المصاريف', 'Gastos'),
(1118, 'notes', 'admin', 'Notes', 'Notes', 'ملاحظات', 'Notas'),
(1119, 'enable_to_allow_guest_login_for_dine_in_pay_cash', 'admin', 'Enable to allow guest login for Dine-in & pay in cash.', 'Enable to allow guest login for <b>Dine-in</b>', 'تمكين للسماح بتسجيل دخول الضيف لتناول الطعام', 'Habilitar para permitir el inicio de sesión de invitados para Dine-in'),
(1120, 'guest_login', 'admin', 'Guest Login', 'Guest Login', 'تسجيل دخول الضيف', 'Inicio de sesión de invitado'),
(1121, 'pay_cash', 'admin', 'Pay Cash', 'Pay Cash', 'الدفع نقدًا', 'Pagar en efectivo'),
(1122, 'login_as_guest', 'admin', 'Login as guest', 'Login as a guest', 'تسجيل الدخول كضيف', 'Iniciar sesión como invitado'),
(1123, 'or', 'admin', 'OR', 'OR', 'أو', 'O'),
(1124, 'walk_in_customer', 'admin', 'Walk in customer', 'Walk in customer', 'عميل مباشر', 'Cliente sin cita previa'),
(1125, 'username_is_available', 'admin', 'Congratulations! Username is available.', 'Congratulations! Username is available.', 'تهانينا! اسم المستخدم متاح.', '¡Felicitaciones! El nombre de usuario está disponible.'),
(1126, 'account_verified_successfully', 'admin', 'Your account verified successfully', 'Your account verified successfully', 'تم التحقق من حسابك بنجاح', 'Su cuenta verificada con éxito'),
(1127, 'login_invalid', 'admin', 'Login invalid', 'Login invalid', 'تسجيل الدخول غير صالح', 'Inicio de sesión no válido'),
(1128, 'tips', 'admin', 'Tip', 'Tip', 'نصيحة', 'Consejo'),
(1129, 'add_tip', 'admin', 'Add Tip', 'Add Tip', 'إضافة نصيحة', 'Agregar sugerencia'),
(1130, 'set_tip_percent', 'admin', 'Set tip percent', 'Set tip percent', 'تعيين نسبة الإكرامية', 'Establecer porcentaje de propina'),
(1131, 'thankyou_for_your_payment', 'admin', 'Thanks for your Payment!', 'Thanks for your Payment!', 'شكرًا على دفعتك!', '¡Gracias por su pago!'),
(1132, 'the_transaction_was_successfull', 'admin', 'The transaction was successful. Transaction details are given below:', 'The transaction was successful. Transaction details are given below:', 'تمت المعاملة بنجاح. تفاصيل المعاملة موضحة أدناه:', 'La transacción fue exitosa. Los detalles de la transacción se dan a continuación:'),
(1133, 'order_confirm_msg', 'admin', 'Order Confirm. Track you order using your phone number', 'Order Confirm. Track your order using your phone number', 'تأكيد الطلب. تتبع طلبك باستخدام رقم هاتفك', 'Confirmar pedido. Rastree su pedido usando su número de teléfono'),
(1134, 'order_cancel_msg', 'admin', 'Order not confirm please try again!', 'Order not confirmed please try again!', 'الطلب غير مؤكد , يرجى المحاولة مرة أخرى!', '¡Pedido no confirmado, inténtalo de nuevo!'),
(1135, 'payment_success', 'admin', 'Payment Successfull', 'Payment Successful', 'تم الدفع بنجاح', 'Pago Exitoso'),
(1136, 'payment_failed', 'admin', 'Payment Failed', 'Payment Failed', 'فشل الدفع', 'Pago fallido'),
(1137, 'hide_banner', 'admin', 'Hide Banner', 'Hide Banner', 'إخفاء البانر', 'Ocultar pancarta'),
(1138, 'hide_footer', 'admin', 'Hide Footer', 'Hide Footer', 'إخفاء التذييل', 'Ocultar pie de página'),
(1139, 'onesignal_user_id', 'admin', 'OneSignal User ID', 'OneSignal User ID', 'معرف مستخدم OneSignal', 'ID de usuario de OneSignal'),
(1140, 'a_new_order_placed', 'admin', 'A new order placed', 'A new order placed', 'تم وضع طلب جديد', 'Un nuevo pedido realizado'),
(1141, 'days_left', 'admin', 'Days Left', 'Days Left', 'الأيام المتبقية', 'Días Quedan'),
(1142, 'order_not_confirmed_please_try_again', 'admin', 'Order not confirm please try again!', 'Order not confirm please try again!', 'الطلب غير مؤكد, يرجى المحاولة مرة أخرى!', 'Pedido no confirmado, ¡inténtalo de nuevo!'),
(1143, 'payment_request_details', 'admin', 'Payement Request details are given below', 'Payment Request details are given below', 'تفاصيل طلب الدفع أدناه', 'Los detalles de la solicitud de pago se proporcionan a continuación'),
(1144, 'mail_send_successfully', 'admin', 'Mail send successfully.', 'Mail sent successfully.', 'تم إرسال البريد بنجاح.', 'Correo enviado con éxito.'),
(1145, 'thank_you_for_your_payment', 'admin', 'Thank you for your Payment!', 'Thank you for your Payment!', 'شكرًا لك على الدفع!', '¡Gracias por su pago!'),
(1146, 'enable_live_order_button', 'admin', 'Enable Live order Button', 'Enable Live order Button', 'تمكين زر الطلب المباشر', 'Habilitar botón de orden en vivo'),
(1147, 'set_as_default', 'admin', 'Set as Default', 'Set as Default', 'تعيين كافتراضي', 'Establecer como predeterminado'),
(1148, 'show_live_order_btn', 'admin', 'Show Live Order Button', 'Show Live Order Button', 'إظهار زر الطلب المباشر', 'Mostrar botón de orden en vivo'),
(1149, 'pos_print_size', 'admin', 'Pos Print size', 'Pos Print size', 'حجم طباعة نقاط البيع', 'Tamaño de impresión pos'),
(1150, 'font_size', 'admin', 'Font Size', 'Font Size', 'حجم الخط', 'Tamaño de fuente'),
(1151, 'welcome_message', 'admin', 'Welcome Message', 'Welcome Message', 'رسالة ترحيب', 'Mensaje de Bienvenida'),
(1152, 'rest_api_key', 'admin', 'Rest API key', 'Rest API key', 'Rest API key', 'Clave de API de descanso'),
(1153, 'enable_push_for_new_order', 'admin', 'Enable Push Notification for new order', 'Enable Push Notification for a new order', 'تمكين إعلام الدفع لطلب جديد', 'Habilitar notificación automática para un nuevo pedido'),
(1154, 'phone_with_international_format', 'admin', 'Phone with international format e.g. 1408XXXXXXX', 'Phone with international format e.g. 1408XXXXXXX', 'هاتف بتنسيق دولي, مثل 1408XXXXXXX', 'Teléfono con formato internacional, por ejemplo, 1408XXXXXXX'),
(1155, 'whatsapp_message', 'admin', 'Whatsapp Message', 'WhatsApp Message', 'رسالة WhatsApp', 'Mensaje de WhatsApp'),
(1156, 'whatsapp_share', 'admin', 'WhatsApp Share', 'WhatsApp Share', 'مشاركة WhatsApp', 'Compartir WhatsApp'),
(1157, 'whatsapp_message_for_order_status', 'admin', 'WhatsApp Message for order status', 'WhatsApp Message for order status', 'رسالة WhatsApp لحالة الطلب', 'Mensaje de WhatsApp para el estado del pedido'),
(1158, 'instance_id', 'admin', 'Instance ID', 'Instance ID', 'معرف المثيل', 'ID de instancia'),
(1159, 'token', 'admin', 'Token', 'Token', 'رمز', 'Ficha'),
(1160, 'just_now', 'admin', 'Just Now', 'Just Now', 'فقط الآن', 'Justo ahora'),
(1161, 'enable_to_allow', 'admin', 'Enable to allow', 'Enable to allow', 'تمكين للسماح', 'Habilitar para permitir'),
(1162, 'is_price', 'admin', 'Is Price', 'Is Price', 'هو السعر', 'Es Precio'),
(1163, 'select_items', 'admin', 'Select items', 'Select items', 'تحديد العناصر', 'Seleccionar elementos'),
(1164, 'email_template', 'admin', 'Email Template', 'Email Template', 'نموذج البريد الإلكتروني', 'Plantilla de correo electrónico'),
(1165, 'netseasy', 'admin', 'Netseasy', 'Netseasy', 'Netseasy', 'Netseasy'),
(1166, 'merchant_id', 'admin', 'Merchant Id', 'Merchant Id', 'معرّف التاجر', 'Identificación del comerciante'),
(1167, 'checkout_key', 'admin', 'Checkout Key', 'Checkout Key', 'مفتاح الخروج', 'Clave de pago'),
(1168, 'list_view', 'admin', 'List View', 'List View', 'عرض القائمة', 'Vista de lista'),
(1169, 'grid_view', 'admin', 'Grid View', 'Grid View', 'عرض الشبكة', 'Vista de cuadrícula'),
(1170, 'multi_merge', 'admin', 'Multipe Merge', 'Multiple Merge', 'دمج متعدد', 'Fusión múltiple'),
(1171, 'order_time', 'admin', 'Order Time', 'Order Time', 'وقت الطلب', 'Tiempo de pedido'),
(1172, 'merge', 'admin', 'Merge', 'Merge', 'دمج', 'Combinar'),
(1173, 'show_live_order_button', 'admin', 'Show live order button', 'Show live order button', 'إظهار زر الطلب المباشر', 'Mostrar botón de orden en vivo'),
(1174, 'recovery_mail', 'admin', 'Password Recovery Mail', 'Password Recovery Mail', 'بريد استعادة كلمة المرور', 'Correo de recuperación de contraseña'),
(1175, 'contact_mail', 'admin', 'Contact Mail', 'Contact Mail', 'بريد الاتصال', 'Correo de contacto'),
(1176, 'resend_verify_mail', 'admin', 'Resend account verification mail', 'Resend account verification mail', 'إعادة إرسال بريد التحقق من الحساب', 'Reenviar correo de verificación de cuenta'),
(1177, 'email_verification_mail', 'admin', 'Account verification mail', 'Account verification mail', 'بريد التحقق من الحساب', 'Correo de verificación de cuenta'),
(1178, 'account_create_invoice', 'admin', 'Account create invoice', 'Account create an invoice', 'إنشاء فاتورة الحساب', 'Cuenta crear una factura'),
(1179, 'new_user_mail', 'admin', 'New user subscription mail', 'New user subscription mail', 'بريد اشتراك مستخدم جديد', 'Correo de suscripción de nuevo usuario'),
(1180, 'offline_payment_request_mail', 'admin', 'Offline payment request mail', 'Offline payment request mail', 'بريد طلب الدفع دون اتصال', 'Correo de solicitud de pago sin conexión'),
(1181, 'send_payment_verified_email', 'admin', 'Payment verification mail', 'Payment verification mail', 'بريد التحقق من الدفع', 'Correo de verificación de pago'),
(1182, 'expire_reminder_mail', 'admin', 'Account expire reminder mail', 'Account expires reminder mail', 'رسالة تذكير بانتهاء صلاحية الحساب', 'Correo de recordatorio de vencimiento de la cuenta'),
(1183, 'account_expire_mail', 'admin', 'Account expire mail', 'Accounts expire mail', 'بريد تنتهي صلاحيته', 'Cuentas caducan correo'),
(1184, 'enable_multi_lang_category_items', 'admin', 'Enable Multi-language categories & Items', 'Enable Multi-language categories & Items', 'تمكين الفئات والعناصر متعددة اللغات', 'Habilitar categorías y elementos en varios idiomas'),
(1185, 'install_app', 'admin', 'Install App', 'Install App', 'تثبيت التطبيق', 'Instalar aplicación'),
(1186, 'billing_cycle', 'admin', 'Billing Cycle', 'Billing Cycle', 'دورة الفوترة', 'Ciclo de facturación'),
(1187, 'last_billing', 'admin', 'Last Billing', 'Last Billing', 'آخر فاتورة', 'Última facturación'),
(1188, 'payment_status', 'admin', 'Payment Status', 'Payment Status', 'حالة الدفع', 'Estado del pago'),
(1189, 'expire_date', 'admin', 'Expire_date', 'Expire date', 'تاريخ انتهاء الصلاحية', 'Fecha de caducidad'),
(1190, 'order_no', 'admin', 'Order NO', 'Order NO', 'رقم الطلب', 'Nº de pedido'),
(1191, 'tax_percent_for_subscription', 'admin', 'Tax Percent for subscription', 'Tax Percent for subscription', 'نسبة ضريبة الاشتراك', 'Porcentaje de impuestos por suscripción'),
(1192, 'subscription_invoice', 'admin', 'Subscriptions invoice', 'Subscriptions invoice', 'فاتورة الاشتراكات', 'Factura de suscripciones'),
(1193, 'billing_address', 'admin', 'Billing Address', 'Billing Address', 'عنوان إرسال الفواتير', 'Dirección de facturación'),
(1194, 'cash-on-delivery', 'admin', 'Delivery / Pay on receipt', 'Delivery / Pay on receipt', 'التسليم / الدفع عند الاستلام', 'Entrega / Pago al recibir'),
(1195, 'booking', 'admin', 'Booking', 'Booking', 'حجز', 'Reserva'),
(1196, 'pickup', 'admin', 'Pickup', 'Pickup', 'بيك أب', 'Recogida'),
(1197, 'pay-in-cash', 'admin', 'Delivery / Digital Payment', 'Delivery / Digital Payment', 'التسليم / الدفع الرقمي', 'Entrega / Pago Digital'),
(1198, 'package-dine-in', 'admin', 'Package / Restaurant Dine-in', 'Package / Restaurant Dine-in', 'حزمة / تناول الطعام في المطعم', 'Paquete / Cena en restaurante'),
(1199, 'room-service', 'admin', 'Room Service', 'Room Service', 'خدمة الغرف', 'Servicio de habitaciones'),
(1200, 'pay-cash', 'admin', 'Pay cash', 'Pay cash', 'الدفع نقدًا', 'Pagar en efectivo'),
(1201, 'shop_reviews', 'admin', 'Shop Reviews', 'Shop Reviews', 'تسوق المراجعات', 'Reseñas de la tienda'),
(1202, 'reject', 'admin', 'Reject', 'Reject', 'رفض', 'Rechazar'),
(1203, 'by', 'admin', 'By', 'by', 'بواسطة', 'por'),
(1204, 'category_id', 'admin', 'Category ID', 'Category ID', 'معرف الفئة', 'ID de categoría'),
(1205, 'company_details', 'admin', 'Company / Organization Details', 'Company / Organization Details', 'تفاصيل الشركة / المنظمة', 'Detalles de la empresa/organización'),
(1206, 'start_new_cart', 'admin', 'Start a new cart?', 'Start a new cart?', 'هل تريد بدء عربة جديدة؟', '¿Iniciar un carrito nuevo?'),
(1207, 'your_cart_alreay_contains_items_from', 'admin', 'Your cart already contain items from', 'Your cart already contains items from', 'عربة التسوق الخاصة بك تحتوي بالفعل على عناصر من', 'Su carrito ya contiene artículos de'),
(1208, 'would_you_like_to_clear_the_cart', 'admin', 'Would you like to clear the cart?', 'Would you like to clear the cart?', 'هل ترغب في مسح سلة التسوق؟', '¿Le gustaría borrar el carrito?'),
(1210, 'default_language', 'admin', 'Default Language', 'Default Language', 'اللغة الافتراضية', 'Idioma predeterminado'),
(1211, 'site_language', 'admin', 'Site Language', 'Site Language', 'لغة الموقع', 'Idioma del sitio'),
(1212, 'google_translator', 'admin', 'Google translator', 'Google translator', 'مترجم جوجل', 'Traductor de Google'),
(1213, 'system_language', 'admin', 'System Language', 'System Language', 'لغة النظام', 'Idioma del sistema'),
(1214, 'todays_orders', 'admin', 'Today\'s orders', 'Today\'s orders', 'طلبات اليوم', 'Pedidos de hoy'),
(1215, 'draft', 'admin', 'Draft', 'Draft', 'مسودة', 'Borrador'),
(1216, 'all_categories', 'admin', 'All Categories', 'All Categories', 'جميع الفئات', 'Todas las categorías'),
(1217, 'save_and_new_order', 'admin', 'Save and new order', 'Save and new order', 'حفظ وترتيب جديد', 'Guardar y nuevo pedido'),
(1218, 'add_variants', 'admin', 'Add Variants', 'Add Variants', 'إضافة متغيرات', 'Agregar variantes'),
(1219, 'select_category', 'admin', 'Select Category', 'Select Category', 'اختر فئة', 'Seleccionar categoría'),
(1220, 'variant_name', 'admin', 'Variant Name', 'Variant Name', 'اسم البديل', 'Nombre de variante'),
(1221, 'login_btn_in_menu', 'admin', 'Login button in menu bar', 'Login button in menu bar', 'زر تسجيل الدخول في شريط القائمة', 'Botón de inicio de sesión en la barra de menú'),
(1222, 'new_cart', 'admin', 'New Cart', 'New Cart', 'عربة التسوق الجديدة', 'Nuevo carrito'),
(1223, 'show_in_menu_bar', 'admin', 'Show in Menu bar', 'Show in Menu bar', 'عرض في شريط القائمة', 'Mostrar en la barra de menú'),
(1224, 'question_list', 'admin', 'Question List', 'Question List', 'قائمة الأسئلة', 'Lista de preguntas'),
(1225, 'reject_reasons', 'admin', 'Reject Reasons', 'Reject Reasons', 'أسباب الرفض', 'Motivos del rechazo'),
(1226, 'reason_list', 'admin', 'Reason List', 'Reason List', 'قائمة الأسباب', 'Lista de motivos'),
(1227, 'add_reason', 'admin', 'Add Reason', 'Add Reason', 'إضافة سبب', 'Agregar motivo'),
(1228, 'order_reject', 'admin', 'Order Reject', 'Order Reject', 'رفض الطلب', 'Pedido Rechazado'),
(1229, 'access_for', 'admin', 'Access for', 'Access for', 'الوصول لـ', 'Acceso para'),
(1230, 'delivery_guy', 'admin', 'Delivery Guys', 'Delivery Guys', 'رجال التوصيل', 'Repartidores'),
(1231, 'created_by', 'admin', 'Created by', 'Created by', 'تم الإنشاء بواسطة', 'Creado por'),
(1232, 'branding', 'admin', 'Branding', 'Branding', 'العلامة التجارية', 'Marca'),
(1233, 'tutorials', 'admin', 'Tutorials', 'Tutorials', 'البرامج التعليمية', 'Tutoriales'),
(1234, 'page_title', 'admin', 'Page Titles', 'Page Titles', 'عناوين الصفحات', 'Títulos de página'),
(1235, 'dboy', 'admin', 'Delivery Guys', 'Delivery Guys', 'رجال التوصيل', 'Repartidores'),
(1236, 'whatsapp_support', 'admin', 'WhatsApp support', 'WhatsApp support', 'دعم الواتساب', 'Soporte de WhatsApp'),
(1237, 'support_until', 'admin', 'Support Until', 'Support Until', 'الدعم حتى', 'Soporte hasta'),
(1238, 'template', 'admin', 'Template', 'Template', 'القالب', 'Plantilla'),
(1239, 'sign_up_text', 'admin', 'Signup to discover your shop', 'Signup to discover your shop', 'قم بالتسجيل لاكتشاف متجرك', 'Regístrate para descubrir tu tienda'),
(1240, 'shipping_address_not_found', 'admin', 'Delivery area/shipping address not found', 'Delivery area/shipping address not found', 'لم يتم العثور على منطقة التسليم/عنوان الشحن', 'Zona de entrega/dirección de envío no encontrada'),
(1241, 'week', 'admin', 'Week', 'Week', 'أسبوع', 'Semana'),
(1242, 'mark_as_served', 'admin', 'Mark as served', 'Mark as served', 'وضع علامة تم تقديمه', 'Marcar como servido'),
(1243, 'add_new_order', 'admin', 'Create New Order', 'Create a new order', 'إنشاء طلب جديد', 'Crear un nuevo pedido'),
(1244, 'pos_font_size', 'admin', 'Pos invoice font size', 'pos invoice font size', 'حجم خط فاتورة نقاط البيع', 'tamaño de fuente de la factura pos'),
(1245, 'order_amount', 'admin', 'Ordered amount', 'Ordered amount', 'الكمية المطلوبة', 'Cantidad pedida'),
(1246, 'this_job_already_handle_by_someone', 'admin', 'Sorry this job already handle by someone', 'Sorry, this job is already handled by someone', 'عذرًا, هذه المهمة يتولىها شخص ما بالفعل', 'Lo sentimos, este trabajo ya está a cargo de alguien'),
(1247, 'email_already_exists', 'admin', 'The email is already Exists', 'The email already Exists', 'البريد الإلكتروني موجود بالفعل', 'El correo electrónico ya existe'),
(1248, 'by_staff', 'admin', 'By staff', 'by staff', 'من قبل الموظفين', 'por personal'),
(1249, 'by_kds', 'admin', 'From KDS', 'From KDS', 'من KDS', 'De KDS'),
(1250, 'a_new_order_is_placed', 'admin', 'A new order is placed', 'A new order is placed', 'تم تقديم طلب جديد', 'Se realiza un nuevo pedido'),
(1251, 'order_placed_successfully', 'admin', 'Order placed successfully', 'Order placed successfully', 'تم تقديم الطلب بنجاح', 'Pedido realizado correctamente'),
(1252, 'please_wait_its_working', 'admin', 'Please Wait, It\'s working........', 'Please Wait, It\'s working........', 'من فضلك انتظر, إنه يعمل.........', 'Por favor, espera, está funcionando...'),
(1253, 'orders_email_settings', 'admin', 'Orders email settings', 'Orders email settings', 'إعدادات البريد الإلكتروني للطلبات', 'Configuración de correo electrónico de pedidos'),
(1254, 'orders_mail', 'admin', 'Orders Mail', 'Orders Mail', 'بريد الطلبات', 'Pedidos por correo'),
(1255, 'reservation_mail', 'admin', 'Reservation Mail', 'Reservation Mail', 'بريد الحجز', 'Correo de reserva'),
(1256, 'enable_reservation_mail', 'admin', 'Enable Reservation Mail', 'Enable Reservation Mail', 'تمكين بريد الحجز', 'Habilitar correo de reserva'),
(1257, 'reservation_placed_successfully', 'admin', 'Reservation Placed successfully', 'Reservation Placed successfully', 'تم الحجز بنجاح', 'Reserva realizada correctamente'),
(1258, 'mail_change_details', 'admin', 'Send mail with changes', 'Send a mail with the changes', 'إرسال بريد بالتغييرات', 'Enviar un correo con los cambios'),
(1259, 'walk-in-customer', 'admin', 'Walk in customer', 'Walk-in customer', 'العميل الزائر', 'Cliente sin cita previa'),
(1260, 'crop', 'admin', 'Crop', 'Crop', 'اقتصاص', 'Recortar'),
(1261, 'upload_by_cropper', 'admin', 'Upload by cropper', 'Upload by cropper', 'تحميل بواسطة كروبر', 'Subir por recortador'),
(1262, 'deleted_successfully', 'admin', 'Deleted Successfully', 'Deleted Successfully', 'تم الحذف بنجاح', 'Eliminado correctamente'),
(1263, 'orientation', 'admin', 'Orientation', 'Orientation', 'الاتجاه', 'Orientación'),
(1264, 'only_for_pos', 'admin', 'Only for pos', 'Only for pos', 'فقط لنقاط البيع', 'Sólo para pos'),
(1265, 'affiliate', 'admin', 'Affiliate', 'Affiliate', 'شركة تابعة', 'Afiliado'),
(1266, 'total_referal', 'admin', 'Total Referal', 'Total Referal', 'إجمالي الإحالة', 'Referencia total'),
(1267, 'blance', 'admin', 'Balance', 'Balance', 'الرصيد', 'Saldo'),
(1268, 'total_withdraw', 'admin', 'Total Withdraw', 'Total Withdraw', 'إجمالي السحب', 'Retiro Total'),
(1269, 'referal_url', 'admin', 'Referal URL', 'Referal URL', 'عنوان URL للإحالة', 'URL de referencia'),
(1270, 'send_invitation', 'admin', 'Send Invitation', 'Send Invitation', 'إرسال دعوة', 'Enviar invitación'),
(1271, 'invitation_details', 'admin', 'Send your referral link to your friends and tell them how cool is this!', 'Send your referral link to your friends and tell them how cool this is!', 'أرسل رابط الإحالة الخاص بك إلى أصدقائك وأخبرهم كم هو رائع هذا!', '¡Envía tu enlace de referencia a tus amigos y cuéntales lo genial que es esto!'),
(1272, 'affiliate_registration_details', 'admin', 'Let them register using your referral link.', 'Let them register using your referral link.', 'اسمح لهم بالتسجيل باستخدام رابط الإحالة الخاص بك.', 'Permítales registrarse usando su enlace de referencia.'),
(1273, 'get_comminsions', 'admin', 'Get Commissions', 'Get Commissions', 'الحصول على العمولات', 'Obtener Comisiones'),
(1274, 'get_commision_details', 'admin', 'Earn commission for their first subscription plan payments!', 'Earn commission for their first subscription plan payments!', 'احصل على عمولة مقابل دفعات خطة الاشتراك الأولى!', '¡Gana comisión por los primeros pagos del plan de suscripción!'),
(1275, 'referral_guidelines', 'admin', 'Referral Guidelines', 'Referral Guidelines', 'إرشادات الإحالة', 'Pautas de referencia'),
(1276, 'payout_request', 'admin', 'Payout Request', 'Payout Request', 'طلب الدفع', 'Solicitud de pago'),
(1277, 'affiliate_list', 'admin', 'Affiliate List', 'Affiliate List', 'قائمة الشركات التابعة', 'Lista de afiliados'),
(1278, 'payout', 'admin', 'Payout', 'Payout', 'الدفع', 'Pago'),
(1279, 'complete_date', 'admin', 'Complete Date', 'Complete Date', 'التاريخ الكامل', 'Fecha completa'),
(1280, 'payout_list', 'admin', 'Payout List', 'Payout List', 'قائمة العوائد', 'Lista de pagos'),
(1281, 'pending_payment', 'admin', 'Pending Payment', 'Pending Payment', 'في انتظار الدفع', 'Pago Pendiente'),
(1282, 'subscriber', 'admin', 'Subscriber', 'Subscriber', 'مشترك', 'Suscriptor'),
(1283, 'commision_price', 'admin', 'Commission Price', 'Commission Price', 'سعر العمولة', 'Precio de comisión'),
(1284, 'created_at', 'admin', 'Created at', 'Created at', 'تم الإنشاء في', 'Creado en'),
(1285, 'total_income', 'admin', 'Total Income', 'Total Income', 'إجمالي الدخل', 'Ingresos Totales'),
(1286, 'payment_method', 'admin', 'Payment Method', 'Payment Method', 'طريقة الدفع', 'Método de pago'),
(1287, 'payment_email', 'admin', 'Payment Email', 'Payment Email', 'البريد الإلكتروني للدفع', 'Correo electrónico de pago'),
(1288, 'payment_details', 'admin', 'Payment Details', 'Payment Details', 'تفاصيل الدفع', 'Detalles de pago'),
(1289, 'login_btn', 'admin', 'Login Button', 'Login Button', 'زر تسجيل الدخول', 'Botón de inicio de sesión'),
(1290, 'hide_product_image', 'admin', 'Hide Product Image', 'Hide Product Image', 'إخفاء صورة المنتج', 'Ocultar imagen del producto'),
(1291, 'dropdown', 'admin', 'Dropdown', 'Dropdown', 'قائمة منسدلة', 'Desplegable'),
(1292, 'vendor_name', 'admin', 'Vendor Name', 'Vendor Name', 'اسم البائع', 'Nombre del proveedor'),
(1293, 'in_progress', 'admin', 'In-progress', 'In-progress', 'قيد التقدم', 'En curso'),
(1294, 'package_price', 'admin', 'Package Price', 'Package Price', 'سعر العبوة', 'Precio del paquete'),
(1295, 'affiliate_from', 'admin', 'Affiliate From', 'Affiliate From', 'التابع من', 'Afiliado de'),
(1296, 'enable_affiliate', 'admin', 'Enable Affiliate', 'Enable Affiliate', 'تمكين الشركة التابعة', 'Habilitar afiliado'),
(1297, 'commission_rate', 'admin', 'Commission Rate', 'Commission Rate', 'سعر العمولة', 'Tasa de comisión'),
(1298, 'subscriber_commission_rate', 'admin', 'Subscriber Commission Rate', 'Subscriber Commission Rate', 'معدل عمولة المشترك', 'Tarifa de comisión del suscriptor'),
(1299, 'minimum_payout', 'admin', 'Minimum Payout', 'Minimum Payout', 'الحد الأدنى للدفع', 'Pago mínimo'),
(1300, 'flat', 'admin', 'Flat', 'Flat', 'مسطحة', 'Plano'),
(1301, 'transactions', 'admin', 'Transactions', 'Transactions', 'المعاملات', 'Transacciones'),
(1302, 'referal_code', 'admin', 'Referral Code', 'Referral Code', 'رمز الإحالة', 'Código de referencia'),
(1303, 'completed_payout', 'admin', 'Completed Payout', 'Completed Payout', 'اكتمل الدفع', 'Pago completado'),
(1304, 'mark_as_hold', 'admin', 'Mark as hold', 'Mark as hold', 'وضع علامة تعليق', 'Marcar como retenido'),
(1305, 'sales_graph', 'admin', 'Sales Graph', 'Sales Graph', 'الرسم البياني للمبيعات', 'Gráfico de ventas'),
(1306, 'service_charge', 'admin', 'Service Charge', 'Service Charge', 'تكلفة الخدمة', 'Cargo por servicio'),
(1307, 'language', 'admin', 'Language', 'Language', 'اللغة', 'Idioma'),
(1308, 'referal_discount', 'admin', 'Referral Discount', 'Referral Discount', 'خصم الإحالة', 'Descuento por recomendación'),
(1309, 'new_code', 'admin', 'New Code', 'New Code', 'الرمز الجديد', 'Nuevo Código'),
(1310, 'value', 'admin', 'Value', 'Value', 'القيمة', 'Valor'),
(1311, 'preparing', 'admin', 'Preparing', 'Preparing', 'التحضير', 'Preparando'),
(1312, 'ready', 'admin', 'Ready', 'Ready', 'جاهز', 'Listo'),
(1313, 'category', 'admin', 'Category', 'Category', 'الفئة', 'Categoría'),
(1314, 'expensereport', 'admin', 'Expense Report', 'Expense Report', 'تقرير النفقات', 'Informe de gastos'),
(1315, 'summaryreport', 'admin', 'Summary Report', 'Summary Report', 'تقرير ملخص', 'Informe resumido'),
(1316, 'xreport', 'admin', 'Xreport', 'Xreport', 'Xreport', 'Informe X'),
(1317, 'csv', 'admin', 'CSV', 'CSV', 'CSV', 'CSV'),
(1318, 'pdf', 'admin', 'PDF', 'PDF', 'PDF', 'PDF'),
(1319, 'excel', 'admin', 'EXCEL', 'EXCEL', 'إكسل', 'EXCEL'),
(1320, 'add_breaks', 'admin', 'Add Breaks', 'Add Breaks', 'إضافة فواصل', 'Agregar descansos'),
(1321, 'create_order', 'admin', 'Order Create', 'Order Create', 'إنشاء الطلب', 'Crear pedido'),
(1322, 'cities', 'admin', 'Cities', 'Cities', 'المدن', 'Ciudades'),
(1323, 'city_name', 'admin', 'City Name', 'City Name', 'اسم المدينة', 'Nombre de la ciudad'),
(1324, 'zip_code', 'admin', 'Zip code', 'Zipcode', 'الرمز البريدي', 'Código postal'),
(1325, 'variant_options', 'admin', 'Variant options', 'Variant options', 'الخيارات المتنوعة', 'Opciones variantes'),
(1326, 'enable_push_for_call_waiter', 'admin', 'Enable push for call waiter', 'Enable push for call waiter', 'تمكين الضغط من أجل استدعاء النادل', 'Habilitar push para llamar al camarero'),
(1327, 'slogan', 'admin', 'Slogan', 'Slogan', 'الشعار', 'Lema'),
(1328, 'payment_link', 'admin', 'Payment Link', 'Payment Link', 'رابط الدفع', 'Enlace de pago'),
(1329, 'restaurant', 'admin', 'Restaurant', 'vendor', 'البائع', 'vendedor'),
(1330, 'custom', 'admin', 'Custom', 'Custom', 'مخصص', 'Personalizado'),
(1331, 'confirmed', 'admin', 'Confirmed', 'Confirmed', 'تم التأكيد', 'Confirmado'),
(1332, 'show_in_landing_page', 'admin', 'Show in the landing page', 'Show in the landing page', 'عرض في الصفحة المقصودة', 'Mostrar en la página de inicio'),
(1333, 'add_new_extra_title', 'admin', 'Add new extra / addons title', 'Add new extra/addons title', 'أضف عنوانًا إضافيًا/إضافات جديدة', 'Agregar nuevo título extra/complementos'),
(1334, 'single_select', 'admin', 'Single select', 'single select', 'اختيار فردي', 'selección única'),
(1335, 'multiple_select', 'admin', 'Multiple select', 'Multiple select', 'اختيار متعدد', 'Selección múltiple'),
(1336, 'is_required', 'admin', 'Is required', 'Is required', 'مطلوب', 'Es necesario'),
(1337, 'required', 'admin', 'Required', 'Required', 'مطلوب', 'Obligatorio'),
(1338, 'select_limit', 'admin', 'Select Limit', 'Select Limit', 'حدد الحد', 'Seleccionar límite'),
(1339, 'please_select_at_least', 'admin', 'Please select at least', 'Please select at least', 'يُرجى التحديد على الأقل', 'Por favor seleccione al menos'),
(1340, 'options', 'admin', 'Option(s)', 'option(s)', 'الخيار (الخيارات)', 'opción(es)'),
(1341, 'at_least', 'admin', 'At least', 'at least', 'على الأقل', 'al menos'),
(1342, 'optional', 'admin', 'Optional', 'Optional', 'اختياري', 'Opcional'),
(1343, 'select_minimum', 'admin', 'Select minumum', 'select minimum', 'اختر الحد الأدنى', 'seleccionar mínimo'),
(1344, 'list', 'admin', 'List', 'List', 'قائمة', 'Lista'),
(1345, 'addons', 'admin', 'Addons', 'addons', 'إضافات', 'complementos'),
(1346, 'only_for_package', 'admin', 'Only for package', 'Only for package', 'للحزمة فقط', 'Sólo para paquete'),
(1347, 'required_fields', 'admin', 'Please fill-up the required fields', 'Please fill up the required fields', 'يرجى ملء الحقول المطلوبة', 'Por favor complete los campos requeridos'),
(1348, 'show_customer_comments_invoice', 'admin', 'Show customer comments invoice', 'Show customer comments invoice', 'إظهار فاتورة تعليقات العملاء', 'Mostrar factura de comentarios del cliente'),
(1349, 'slider', 'admin', 'Slider', 'Slider', 'شريط التمرير', 'Control deslizante'),
(1350, 'variant_description', 'admin', 'Variant Options separated by|pipe symbol, i.e Black|Blue|Red', 'Variant Options separated by|pipe symbol, i.e Black|Blue|Red', 'الخيارات المتباينة مفصولة بواسطة|رمز الأنبوب, أي أسود|أزرق|أحمر', 'Opciones variantes separadas por|símbolo de tubería, es decir, Negro|Azul|Rojo'),
(1351, 'variant_name_details', 'admin', 'Variant Name, i.e size, color etc', 'Variant Name, i.e size, color, etc', 'اسم المتغير, مثل الحجم واللون وما إلى ذلك', 'Nombre de la variante, es decir, tamaño, color, etc'),
(1352, 'select_max_limit', 'admin', 'Maximum choose/select limit', 'Maximum choose/select limit', 'الحد الأقصى للاختيار/التحديد', 'Límite máximo de elección/selección'),
(1353, 'menu_list', 'admin', 'Menu List', 'Menu List', 'قائمة القائمة', 'Lista de menús'),
(1354, 'is_dropdown', 'admin', 'Is Dropdown', 'Is Dropdown', 'قائمة منسدلة', 'Es desplegable'),
(1355, 'total_sales', 'admin', 'Total sales', 'Total sales', 'إجمالي المبيعات', 'Ventas totales'),
(1356, 'payment_with_cash', 'admin', 'Cash Payment', 'Cash Payment', 'الدفع نقدًا', 'Pago en efectivo'),
(1357, 'you_have_some_test_data_like_items', 'admin', 'You have some test/default data like items, categories', 'You have some test/default data like items, categories', 'لديك بعض البيانات الاختبارية/الافتراضية مثل العناصر والفئات', 'Tienes algunos datos de prueba/predeterminados como elementos, categorías');
INSERT INTO `language_data` (`id`, `keyword`, `type`, `details`, `english`, `ar`, `es`) VALUES
(1358, 'do_you_want_to_remove_them', 'admin', 'Do you want to remove them?\',\'Do you want to remove them?', 'Do you want to remove them?', 'هل تريد إزالتها؟', '¿Quieres eliminarlos?'),
(1359, 'moyasar', 'admin', 'Moyasar', 'Moyasar', 'مُيسر', 'Moyásar'),
(1360, 'max_qty', 'admin', 'Maximum qty select limit', 'Maximum qty select limit', 'الحد الأقصى لتحديد الكمية', 'Límite de selección de cantidad máxima'),
(1361, 'default', 'admin', 'Default', 'default', 'افتراضي', 'predeterminado'),
(1362, 'tax_system', 'admin', 'Tax system', 'Tax system', 'النظام الضريبي', 'Sistema tributario'),
(1363, 'including_tax', 'admin', 'Tax including Formula (EU)', 'Tax including Formula (EU)', 'الضريبة شاملة الصيغة (الاتحاد الأوروبي)', 'Impuesto incluido Fórmula (UE)'),
(1364, 'please_configure_the_mail_first', 'admin', 'Please configure your email first', 'Please configure your email first', 'يرجى ضبط بريدك الإلكتروني أولاً', 'Primero configure su correo electrónico'),
(1365, 'if_you_want_to_set_custom_price', 'admin', 'If you want to set custom Price', 'If you want to set a custom Price', 'إذا كنت تريد تحديد سعر مخصص', 'Si desea establecer un precio personalizado'),
(1366, 'current_price', 'admin', 'Current Price', 'Current Price', 'السعر الحالي', 'Precio Actual'),
(1367, 'previous_price', 'admin', 'Previous price', 'Previous price', 'السعر السابق', 'Precio anterior'),
(1368, 'mark_as_default', 'admin', 'Mark as default', 'Mark as default', 'وضع علامة كافتراضي', 'Marcar como predeterminado'),
(1369, 'city_based_delivery_boy', 'admin', 'City Based Delivery guys', 'City Based Delivery guys', 'رجال التوصيل في المدينة', 'Repartidores de la ciudad'),
(1370, 'order_placed_message', 'admin', 'Order place message', 'Order placed/welcome message', 'تم تقديم الطلب/رسالة ترحيب', 'Pedido realizado/mensaje de bienvenida'),
(1371, 'please_select_the_payment_method', 'admin', 'Please select the payment method', 'Please select the payment method', 'يُرجى تحديد طريقة الدفع', 'Por favor seleccione el método de pago'),
(1372, 'upload_payment_document', 'admin', 'Upload payment document', 'Upload payment document', 'رفع مستند الدفع', 'Subir documento de pago'),
(1373, 'enable_payment_documemt_uploader', 'admin', 'Enable payment document uploader', 'Enable payment document uploader', 'تفعيل أداة تحميل مستندات الدفع', 'Habilitar cargador de documentos de pago'),
(1374, 'chat', 'admin', 'Chat', 'Chat', 'دردشة', 'Chatear'),
(1375, 'order_checkout_config', 'admin', 'Checkout / order config', 'Checkout/order config', 'إعدادات الخروج/الطلب', 'Configuración de pago/pedido'),
(1376, 'shipping_config', 'admin', 'Shipping config', 'Shipping config', 'إعدادات الشحن', 'Configuración de envío'),
(1377, 'email_based_customer_login', 'admin', 'Email_based_staff/customer_login', 'Email-based staff/customer login', 'تسجيل دخول الموظفين/العميل عبر البريد الإلكتروني', 'Inicio de sesión de cliente/personal basado en correo electrónico'),
(1378, 'login_with_email_or_phone', 'admin', 'Login with email or phone', 'Login with email or phone', 'تسجيل الدخول باستخدام البريد الإلكتروني أو الهاتف', 'Iniciar sesión con correo electrónico o teléfono'),
(1379, 'phone_or_email_cannot_be_empty', 'admin', 'Phone or email cannot be empty', 'Phone or email cannot be empty', 'لا يمكن ترك حقل الهاتف أو البريد الإلكتروني فارغًا', 'El teléfono o el correo electrónico no pueden estar vacíos'),
(1380, 'email_already_exits', 'admin', 'Email already exists', 'Email already exists', 'البريد الإلكتروني موجود بالفعل', 'El correo electrónico ya existe'),
(1381, 'required_fields_cannot_be_empty', 'admin', 'Required fields cannot be empty', 'Required fields cannot be empty', 'لا يمكن ترك الحقول المطلوبة فارغة', 'Los campos obligatorios no pueden estar vacíos'),
(1382, 'quick_access', 'admin', 'Quick access', 'Quick access', 'وصول سريع', 'Acceso rápido'),
(1383, 'start_chat', 'admin', 'Start Chat', 'Start Chat', 'بدء الدردشة', 'Iniciar chat'),
(1384, 'opening_system', 'admin', 'Opening System', 'Opening System', 'نظام الفتح', 'Sistema de Apertura'),
(1385, 'multiple_close', 'admin', 'Multiple close', 'Multiple close slots', 'فتحات إغلاق متعددة', 'Múltiples ranuras de cierre'),
(1386, 'multiple_open', 'admin', 'Multiple Open slots', 'Multiple Open slots', 'فتحات متعددة مفتوحة', 'Múltiples espacios abiertos'),
(1387, 'add_opening_slots', 'admin', 'Add opening slots', 'Add opening slots', 'إضافة فتحات الافتتاح', 'Agregar ranuras de apertura'),
(1388, 'show_allergen_image', 'admin', 'Show allergen image', 'Show allergen image', 'عرض صورة مسببة للحساسية', 'Mostrar imagen de alérgeno'),
(1389, 'show_pending_order_in_kds', 'admin', 'Show pending orders in KDS', 'Show pending orders in KDS', 'إظهار الأوامر المعلقة بالـKDS', 'Mostrar órdenes pendientes en KDS'),
(1390, 'promotion', 'admin', 'Promotion', 'Promotion', 'الترويج', 'Promoción'),
(1391, 'checkout_customers', 'admin', 'Checkout Customers', 'Checkout Customers', 'عملاء السداد', 'Pagar clientes'),
(1392, 'addmore', 'admin', 'Add more', 'Add more', 'إضافة المزيد', 'Agregar más'),
(1393, 'sitemap', 'admin', 'Sitemap', 'Sitemap', 'خريطة الموقع', 'Mapa del sitio'),
(1394, 'changefreq', 'admin', 'Change frequency', 'change frequency', 'تغيير التردد', 'cambiar frecuencia'),
(1395, 'ip_address', 'admin', 'IP Address', 'IP Address', 'عنوان IP', 'Dirección IP'),
(1396, 'block', 'admin', 'Block', 'Block', 'الحظر', 'Bloquear'),
(1397, 'attempts', 'admin', 'Attempts', 'Attempts', 'المحاولات', 'Intentos'),
(1398, 'too_many_attempts_please_try_later', 'admin', 'Too many  attempts. Please try again later', 'Too many  attempts. Please try again later', 'محاولات كثيرة جدًا. يُرجى المحاولة مرة أخرى لاحقًا', 'Demasiados intentos. Inténtalo de nuevo más tarde'),
(1399, 'malicious', 'admin', 'Malicious', 'Malicious', 'الهجمات الضارة', 'Malicioso'),
(1400, 'allow_attempts', 'admin', 'Allow attempts', 'Allow attempts', 'السماح بالمحاولات', 'Permitir intentos'),
(1401, 'spam/attack', 'admin', 'Spam/Attack', 'Spam/Attack', 'الرسائل غير المرغوب فيها/الهجمات', 'Spam/ataques'),
(1402, 'user_attempts', 'admin', 'User Attempts', 'User Attempts', 'محاولات المستخدم', 'Intentos de usuario'),
(1403, 'allow_max_attempts_for_checkout', 'admin', 'Allow Max Attempts for checkout', 'Allow Max Attempts for checkout', 'السماح بأقصى عدد من المحاولات للدفع', 'Permitir máximo de intentos de pago'),
(1404, 'enable_detect_spam_attack', 'admin', 'Enable to detect spamming / attack', 'Enable to detect spamming / attack', 'تمكين الكشف عن الرسائل غير المرغوب فيها/الهجمات', 'Habilitar detección de spam/ataques'),
(1405, 'enable_detect_user_attempts', 'admin', 'Enable to detect user attempts', 'Enable to detect user attempts', 'تمكين الكشف عن محاولات المستخدم', 'Habilitar para detectar intentos de usuario'),
(1406, 'card', 'admin', 'Card', 'Card', 'البطاقة', 'Tarjeta'),
(1407, 'online', 'admin', 'Online', 'Online', 'الدفع عبر الإنترنت', 'En línea'),
(1408, 'offers', 'admin', 'Offers', 'Offers', 'العروض', 'Ofertas'),
(1409, 'promo', 'admin', 'Promo', 'Promo', 'العروض الترويجية', 'Promoción'),
(1410, 'featured_items', 'admin', 'Featured Items', 'Featured Items', 'العناصر المميزة', 'Artículos destacados'),
(1411, 'midtrans', 'admin', 'Midtrans', 'Midtrans', 'Midtrans', 'Midtrans'),
(1412, 'cashfree', 'admin', 'Cashfree', 'Cashfree', 'الدفع بدون نقد', 'Cashfree'),
(1413, 'qr-code', 'admin', 'Qr code', 'Qr code', 'رمز الاستجابة السريعة', 'Código QR'),
(1414, 'online-payment', 'admin', 'Online Payment', 'Online Payment', 'الدفع عبر الإنترنت', 'Pago en línea'),
(1415, 'pwa-push', 'admin', 'OneSignal & PWA', 'OneSignal & PWA', 'OneSignal وتطبيقات الويب التقدمية', 'OneSignal y PWA'),
(1416, 'welcome_page', 'admin', 'Welcome / Landing Page', 'Welcome / Landing Page', 'صفحة الترحيب / الصفحة المقصودة', 'Página de bienvenida/inicio'),
(1417, 'online_order', 'admin', 'Online Order', 'Online Order', 'الطلب عبر الإنترنت', 'Pedido en línea'),
(1418, 'custom_js', 'admin', 'Custom js', 'Custom js', 'Custom Js', 'JS personalizado'),
(1419, 'myfatoorah', 'admin', 'My Fatoorah', 'My Fatoorah', 'My Fatoorah', 'My Fatoorah'),
(1420, 'vccode', 'admin', 'VcCode', 'vcCode', 'vcCode', 'vcCode'),
(1421, 'with_popular_feature_items', 'admin', 'With popular and feature items', 'With popular and feature items', 'مع عناصر شائعة ومميزة', 'Con elementos populares y destacados'),
(1422, 'without_popular_feature_items', 'admin', 'Without popular and feature items / old page', 'Without popular and feature items / old page', 'بدون عناصر شائعة ومميزة / الصفحة القديمة', 'Sin elementos populares y destacados / página antigua'),
(1423, 'iyzico', 'admin', 'Iyzico', 'Iyzico', 'Iyzico', 'Iyzico'),
(1424, 'site_description', 'admin', 'Site Details / description', 'Site Details / description', 'تفاصيل/وصف الموقع', 'Detalles/Descripción del sitio'),
(1425, 'goes_to_live_order', 'admin', 'Goes To live Order', 'Goes To live Order', 'تخمين الترتيب المباشر', 'orden de adivinación en vivo'),
(1426, 'offline_payment', 'admin', 'Offline Payment', 'Offline Payment', 'الدفع دون الاتصال بالإنترنت', 'Pago sin conexión'),
(1427, 'enable_theme_toggle', 'admin', 'Enable theme toggle', 'Enable theme toggle', 'تمكين تبديل السمة', 'Habilitar alternancia de tema');

-- --------------------------------------------------------

--
-- Table structure for table `menu_type`
--

CREATE TABLE `menu_type` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `orders` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `category_id` int(11) NOT NULL,
  `is_pos_only` int(11) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offer_list`
--

CREATE TABLE `offer_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `item_ids` longtext,
  `discount` int(11) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `thumb` varchar(100) DEFAULT NULL,
  `images` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offline_payment`
--

CREATE TABLE `offline_payment` (
  `txn_id` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `package` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `approve_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_item_list`
--

CREATE TABLE `order_item_list` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` double NOT NULL,
  `item_price` double NOT NULL,
  `is_package` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `is_size` int(11) NOT NULL,
  `size_slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_extras` int(11) NOT NULL DEFAULT '0',
  `extra_id` varchar(255) DEFAULT NULL,
  `item_comments` text,
  `is_merge` int(11) NOT NULL DEFAULT '0',
  `merge_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `extra_qty` longtext,
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_payment_info`
--

CREATE TABLE `order_payment_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(200) DEFAULT NULL,
  `shop_id` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `currency_code` varchar(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `payment_by` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `order_type` int(11) NOT NULL DEFAULT '0',
  `all_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `offline_payment_info` longtext,
  `offline_type` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_types`
--

CREATE TABLE `order_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_order_types` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_types`
--

INSERT INTO `order_types` (`id`, `name`, `slug`, `status`, `is_order_types`, `created_at`) VALUES
(1, 'Cash on delivery', 'cash-on-delivery', 1, 1, '2021-04-06 16:48:57'),
(2, 'Booking', 'booking', 1, 1, '2021-04-06 16:50:12'),
(3, 'Reservation', 'reservation', 1, 0, '2021-04-06 16:50:38'),
(4, 'Pickup', 'pickup', 1, 1, '2021-04-06 16:50:38'),
(5, 'Pay in cash', 'pay-in-cash', 1, 0, '2021-04-06 16:50:38'),
(6, 'Dine-in', 'dine-in', 1, 1, '2021-04-06 16:50:38'),
(7, 'Package / Restaurant Dine-in', 'package-dine-in', 1, 0, '2022-09-20 23:04:31'),
(8, 'Room Service', 'room-service', 1, 1, '2022-09-20 23:04:31'),
(9, 'Pay cash', 'pay-cash', 1, 1, '2022-09-20 23:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_user_list`
--

CREATE TABLE `order_user_list` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0==panding,\r\n1==approve,2==completed,3==reject',
  `created_at` datetime NOT NULL,
  `reservation_date` datetime NOT NULL,
  `order_type` int(11) NOT NULL DEFAULT '1',
  `table_no` int(11) NOT NULL DEFAULT '0',
  `total_person` int(11) NOT NULL,
  `total` varchar(255) NOT NULL,
  `cancel_time` datetime NOT NULL,
  `accept_time` datetime DEFAULT NULL,
  `completed_time` datetime DEFAULT NULL,
  `g_map` varchar(255) NOT NULL,
  `is_ring` int(11) NOT NULL DEFAULT '0',
  `is_table` int(11) NOT NULL,
  `reservation_type` int(11) NOT NULL,
  `comments` text NOT NULL,
  `qr_link` varchar(255) NOT NULL,
  `delivery_charge` double NOT NULL,
  `is_payment` int(11) NOT NULL,
  `payment_by` varchar(255) NOT NULL,
  `pickup_point` int(11) NOT NULL,
  `es_time` varchar(10) NOT NULL,
  `time_slot` varchar(10) NOT NULL,
  `estimate_time` datetime DEFAULT NULL,
  `is_extras` int(11) NOT NULL DEFAULT '0',
  `delivery_area` varchar(255) DEFAULT NULL,
  `is_preparing` int(11) NOT NULL DEFAULT '0',
  `token_number` varchar(255) DEFAULT NULL,
  `dine_id` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `dboy_id` int(11) NOT NULL,
  `dboy_status` int(11) NOT NULL,
  `is_picked` int(11) NOT NULL,
  `discount` double NOT NULL,
  `dboy_accept_time` datetime DEFAULT NULL,
  `dboy_picked_time` datetime DEFAULT NULL,
  `dboy_completed_time` datetime DEFAULT NULL,
  `is_db_accept` int(11) NOT NULL DEFAULT '0',
  `is_db_completed` int(11) NOT NULL DEFAULT '0',
  `tax_fee` double NOT NULL,
  `sub_total` double NOT NULL,
  `pickup_time` varchar(255) DEFAULT NULL,
  `customer_rating` varchar(50) DEFAULT NULL,
  `customer_review` text,
  `rating_time` datetime DEFAULT NULL,
  `shipping_id` int(11) NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `is_coupon` int(11) NOT NULL DEFAULT '0',
  `coupon_percent` varchar(255) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `use_payment` int(11) NOT NULL DEFAULT '0',
  `tips` double DEFAULT NULL,
  `is_change` int(11) NOT NULL DEFAULT '0',
  `change_amount` varchar(50) NOT NULL DEFAULT '0',
  `is_restaurant_payment` int(11) NOT NULL DEFAULT '0',
  `is_db_request` int(11) NOT NULL DEFAULT '0',
  `db_completed_by` varchar(255) NOT NULL DEFAULT 'staff',
  `hotel_id` int(11) NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `payment_notes` text,
  `sell_notes` text,
  `received_amount` varchar(255) DEFAULT NULL,
  `is_pos` int(11) NOT NULL DEFAULT '0',
  `is_live_order` int(11) NOT NULL DEFAULT '1',
  `is_draft` int(11) NOT NULL DEFAULT '0',
  `is_order_merge` int(11) NOT NULL DEFAULT '0',
  `merge_status` int(11) NOT NULL DEFAULT '0',
  `is_guest_login` int(11) NOT NULL DEFAULT '0',
  `merge_ids` longtext,
  `is_rating_approved` int(11) NOT NULL DEFAULT '0',
  `staff_id` int(10) DEFAULT NULL,
  `staff_action` varchar(10) DEFAULT NULL,
  `reject_reason` text,
  `action_by` varchar(50) DEFAULT 'vendor',
  `is_item_tax` int(11) NOT NULL DEFAULT '0',
  `is_confirm` int(11) NOT NULL DEFAULT '1',
  `confirm_at` datetime DEFAULT NULL,
  `service_charge` varchar(30) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(250) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `previous_price` double NOT NULL DEFAULT '0',
  `package_type` varchar(255) NOT NULL DEFAULT 'year',
  `order_limit` int(11) NOT NULL DEFAULT '0',
  `item_limit` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `custom_fields_config` longtext,
  `duration` varchar(20) DEFAULT NULL,
  `is_default` int(2) NOT NULL DEFAULT '0',
  `order_types` longtext,
  `duration_period` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `slug`, `price`, `previous_price`, `package_type`, `order_limit`, `item_limit`, `status`, `created_at`, `custom_fields_config`, `duration`, `is_default`, `order_types`, `duration_period`) VALUES
(1, 'Trial Basic', 'trial-basic', 0, 0, 'fifteen', 3, 4, 1, '2021-09-07 11:27:33', NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `details` longtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `currency_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `all_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_self` int(11) NOT NULL DEFAULT '0',
  `billing_address` longtext,
  `expire_date` datetime DEFAULT NULL,
  `is_running` int(11) NOT NULL DEFAULT '0',
  `package_price` varchar(10) DEFAULT NULL,
  `referal_code` varchar(10) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `is_payment` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_list`
--

CREATE TABLE `payment_method_list` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `active_slug` varchar(255) DEFAULT NULL,
  `status_slug` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_method_list`
--

INSERT INTO `payment_method_list` (`id`, `name`, `slug`, `active_slug`, `status_slug`, `status`) VALUES
(1, 'Paypal', 'paypal', 'paypal_status', 'is_paypal', 1),
(2, 'Stripe', 'stripe', 'stripe_status', 'is_stripe', 1),
(3, 'Razorpay', 'razorpay', 'razorpay_status', 'is_razorpay', 1),
(4, 'Stripe FPX', 'stripe_fpx', 'stripe_fpx_status', 'is_fpx', 1),
(5, 'Paytm', 'paytm', 'paytm_status', 'is_paytm', 1),
(6, 'Mercadopago', 'mercado', 'mercado_status', 'is_mercado', 1),
(7, 'Flutterwave', 'flutterwave', 'flutterwave_status', 'is_flutterwave', 1),
(8, 'Paystack', 'paystack', 'paystack_status', 'is_paystack', 1),
(9, 'Offline', 'offline', 'offline_status', 'is_offline', 1),
(10, 'Pagadito', 'pagadito', 'pagadito_status', 'is_pagadito', 1),
(11, 'Moyasar', 'moyasar', 'moyasar_status', 'is_moyasar', 1),
(12, 'Midtrans', 'midtrans', 'midtrans_status', 'is_midtrans', 1),
(13, 'Cashfree', 'cashfree', 'cashfree_status', 'is_cashfree', 1),
(14, 'My fatoorah', 'myfatoorah', 'myfatoorah_status', 'is_myfatoorah', 1),
(15, 'Iyzico', 'iyzico', 'iyzico_status', 'is_iyzico', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_list`
--

CREATE TABLE `permission_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_list`
--

INSERT INTO `permission_list` (`id`, `title`, `slug`, `status`, `role`) VALUES
(1, 'Add New Item', 'add', 1, 'user'),
(2, 'Update', 'update', 1, 'user'),
(3, 'Delete', 'delete', 1, 'user'),
(4, 'Settings Control', 'setting-control', 1, 'user'),
(5, 'Order Control', 'order-control', 1, 'user'),
(6, 'Profile Control', 'profile-control', 1, 'user'),
(7, 'Change status', 'change-status', 1, 'user'),
(8, 'Order cancel', 'order-cancel', 1, 'user'),
(9, 'POS Order', 'pos-order', 1, 'user'),
(10, 'POS Settings', 'pos-settings', 1, 'user'),
(11, 'Add New User', 'add-user', 1, 'admin_staff'),
(12, 'Change Package', 'change-package', 1, 'admin_staff'),
(13, 'Package Control', 'package-control', 1, 'admin_staff'),
(14, 'Language Control', 'language-control', 1, 'admin_staff'),
(15, 'Home Control', 'home-control', 1, 'admin_staff'),
(16, 'Reset Password', 'reset-password', 1, 'admin_staff'),
(17, 'Access User Account', 'access-user-account', 1, 'admin_staff'),
(18, 'Page Control', 'page-control', 1, 'admin_staff'),
(19, 'Settings Control', 'settings-control', 1, 'admin_staff'),
(20, 'Change user operation', 'change-user-operation', 1, 'admin_staff'),
(21, 'Delete', 'admin-delete', 1, 'admin_staff'),
(22, 'Reviews Control', 'review-control', 1, 'admin_staff'),
(23, 'KDS', 'kds', 1, 'user'),
(24, 'Reports', 'reports', 1, 'user'),
(25, 'Menu', 'menu', 1, 'user'),
(26, 'Affiliate', 'affiliate', 1, 'user'),
(27, 'Coupon List', 'coupon', 1, 'user'),
(28, 'Customer List', 'customer', 1, 'user'),
(29, 'Page List', 'pages', 1, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `pickup_points_area`
--

CREATE TABLE `pickup_points_area` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `images` varchar(250) DEFAULT NULL,
  `thumb` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `is_video` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `feature_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`id`, `package_id`, `feature_id`, `status`, `created_at`) VALUES
(1, 1, 1, 1, '2021-09-07 11:27:33'),
(2, 1, 2, 1, '2021-09-07 11:27:33'),
(3, 1, 3, 1, '2021-09-07 11:27:33'),
(4, 1, 4, 1, '2021-09-07 11:27:33'),
(5, 1, 5, 1, '2021-09-07 11:27:33'),
(6, 1, 6, 1, '2021-09-07 11:27:33'),
(7, 1, 7, 1, '2021-09-07 11:27:33'),
(8, 1, 8, 1, '2021-09-07 11:27:34'),
(9, 1, 9, 1, '2021-09-07 11:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `privacy`
--

CREATE TABLE `privacy` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile_home`
--

CREATE TABLE `profile_home` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `whatsapp_text` text,
  `document` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text,
  `google_map` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question_list`
--

CREATE TABLE `question_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_date`
--

CREATE TABLE `reservation_date` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_24` int(11) NOT NULL DEFAULT '0',
  `is_multiple` int(2) NOT NULL DEFAULT '0',
  `time_config` longtext,
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_types`
--

CREATE TABLE `reservation_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_city_list`
--

CREATE TABLE `restaurant_city_list` (
  `id` int(11) NOT NULL,
  `city_name` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_list`
--

CREATE TABLE `restaurant_list` (
  `id` int(11) NOT NULL,
  `shop_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(266) NOT NULL,
  `email` varchar(255) NOT NULL,
  `about` longtext,
  `about_short` varchar(255) NOT NULL,
  `is_order` int(11) NOT NULL DEFAULT '1',
  `delivery_charge_in` double NOT NULL DEFAULT '0',
  `delivery_charge_out` double NOT NULL DEFAULT '0',
  `timing` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `cover_photo` varchar(255) NOT NULL,
  `cover_photo_thumb` varchar(255) NOT NULL,
  `is_reservation` int(11) NOT NULL DEFAULT '1',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `off_day` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `social_list` text NOT NULL,
  `created_at` datetime NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `icon` varchar(10) NOT NULL,
  `dial_code` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  `is_whatsapp` int(11) NOT NULL DEFAULT '1',
  `paypal_config` varchar(255) NOT NULL,
  `stripe_config` varchar(255) NOT NULL,
  `razorpay_config` varchar(255) NOT NULL,
  `stock_status` int(11) NOT NULL,
  `is_stock_count` int(11) NOT NULL,
  `gmap_key` varchar(255) NOT NULL,
  `is_gmap` int(11) NOT NULL,
  `is_kds` int(11) NOT NULL DEFAULT '0',
  `es_time` int(11) NOT NULL,
  `time_slot` varchar(20) DEFAULT NULL,
  `tax_fee` double NOT NULL,
  `min_order` double NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `pickup_time_slots` longtext,
  `is_review` int(11) NOT NULL DEFAULT '1',
  `slogan` varchar(255) DEFAULT NULL,
  `is_customer_login` int(11) NOT NULL DEFAULT '1',
  `currency_position` int(11) NOT NULL DEFAULT '1',
  `number_formats` int(11) NOT NULL DEFAULT '1',
  `is_area_delivery` int(11) NOT NULL DEFAULT '0',
  `is_call_waiter` int(11) NOT NULL DEFAULT '1',
  `is_paypal` int(11) NOT NULL DEFAULT '1',
  `is_stripe` int(11) NOT NULL DEFAULT '1',
  `is_razorpay` int(11) NOT NULL DEFAULT '1',
  `paypal_status` int(11) NOT NULL DEFAULT '1',
  `stripe_status` int(11) NOT NULL DEFAULT '1',
  `razorpay_status` int(11) NOT NULL DEFAULT '1',
  `stripe_fpx_status` int(11) NOT NULL DEFAULT '0',
  `mercado_status` int(11) NOT NULL DEFAULT '0',
  `paytm_status` int(11) NOT NULL DEFAULT '0',
  `flutterwave_status` int(11) NOT NULL DEFAULT '0',
  `is_fpx` int(11) NOT NULL DEFAULT '1',
  `fpx_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_mercado` int(11) NOT NULL DEFAULT '0',
  `mercado_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_paytm` int(11) NOT NULL DEFAULT '0',
  `paytm_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_flutterwave` int(11) NOT NULL DEFAULT '0',
  `flutterwave_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_admin_gmap` int(11) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `whatsapp_msg` text,
  `is_language` int(11) NOT NULL DEFAULT '0',
  `is_pin` int(11) NOT NULL DEFAULT '0',
  `pin_number` varchar(255) DEFAULT NULL,
  `date_format` int(11) NOT NULL DEFAULT '8',
  `time_format` int(11) NOT NULL DEFAULT '1',
  `is_coupon` int(11) NOT NULL DEFAULT '0',
  `paystack_status` int(11) NOT NULL DEFAULT '1',
  `is_paystack` int(11) NOT NULL DEFAULT '0',
  `paystack_config` longtext,
  `is_admin_onsignal` int(11) NOT NULL DEFAULT '0',
  `is_question` int(11) NOT NULL DEFAULT '0',
  `is_radius` int(11) NOT NULL DEFAULT '0',
  `radius_config` longtext,
  `is_tax` int(11) NOT NULL DEFAULT '0',
  `tax_status` varchar(10) NOT NULL DEFAULT '+',
  `is_kds_pin` int(11) NOT NULL DEFAULT '0',
  `kds_pin` varchar(20) DEFAULT NULL,
  `order_view_style` int(11) NOT NULL DEFAULT '1',
  `whatsapp_enable_for` longtext,
  `is_db_request` int(11) NOT NULL DEFAULT '0',
  `db_completed_by` varchar(255) NOT NULL DEFAULT 'staff',
  `hotel_id` int(11) NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `time_zone` varchar(255) NOT NULL DEFAULT 'Asia/Dhaka',
  `is_checkout_mail` int(11) NOT NULL DEFAULT '0',
  `order_merge_config` longtext,
  `is_cart` int(11) NOT NULL DEFAULT '1',
  `pagadito_config` longtext,
  `is_pagadito` int(11) NOT NULL DEFAULT '0',
  `pagadito_status` int(11) NOT NULL DEFAULT '0',
  `guest_config` longtext,
  `tips_config` longtext,
  `is_multi_lang` int(11) NOT NULL DEFAULT '0',
  `whatsapp_message_config` longtext,
  `netseasy_config` longtext,
  `is_netseasy` int(11) NOT NULL DEFAULT '0',
  `netseasy_status` int(11) NOT NULL DEFAULT '0',
  `is_image` int(11) NOT NULL DEFAULT '0',
  `is_login` int(11) NOT NULL DEFAULT '1',
  `is_branding` int(11) NOT NULL DEFAULT '1',
  `whatsapp_support` longtext,
  `referal_code` varchar(10) DEFAULT NULL,
  `service_charge_config` longtext,
  `tax_number` varchar(50) DEFAULT NULL,
  `delivery_area_style` int(11) NOT NULL DEFAULT '1',
  `city_id` int(11) NOT NULL DEFAULT '0',
  `moyasar_config` longtext,
  `is_moyasar` int(11) NOT NULL DEFAULT '0',
  `moyasar_status` int(11) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0',
  `is_offline` int(2) NOT NULL DEFAULT '0',
  `offline_status` int(2) NOT NULL DEFAULT '0',
  `offline_config` longtext,
  `is_email_based` int(11) NOT NULL DEFAULT '0',
  `available_type` varchar(20) NOT NULL DEFAULT 'close',
  `is_quick_access` int(2) NOT NULL DEFAULT '1',
  `others_config` longtext,
  `latitude` varchar(200) DEFAULT NULL,
  `longitude` varchar(200) DEFAULT NULL,
  `midtrans_config` longtext,
  `is_midtrans` int(11) NOT NULL DEFAULT '0',
  `midtrans_status` int(11) NOT NULL DEFAULT '0',
  `cashfree_config` longtext,
  `is_cashfree` int(11) NOT NULL DEFAULT '0',
  `cashfree_status` int(11) NOT NULL DEFAULT '0',
  `myfatoorah_config` longtext,
  `is_myfatoorah` int(11) NOT NULL DEFAULT '0',
  `myfatoorah_status` int(11) NOT NULL DEFAULT '0',
  `iyzico_config` longtext,
  `is_iyzico` int(11) NOT NULL DEFAULT '0',
  `iyzico_status` int(11) NOT NULL DEFAULT '0',
  `is_order_qr` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_offline_payemnt_list`
--

CREATE TABLE `restaurant_offline_payemnt_list` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `section_banners`
--

CREATE TABLE `section_banners` (
  `id` int(11) NOT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `sub_heading` text,
  `images` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section_banners`
--

INSERT INTO `section_banners` (`id`, `section_name`, `heading`, `sub_heading`, `images`, `status`, `language`, `created_at`) VALUES
(1, 'home', 'Build Your Brand With', 'We are team of talanted designers making websites with Bootstrap', 'uploads/site_banners/17352a0601cfc7d6903ef8ed691a257c.jpg', 1, 'english', '2021-02-20 10:35:54'),
(2, 'features', 'AMAZING FEATURES PROJECT', 'Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Consequatur neque tenetur dolores laudantium quod facere qua', 'uploads/big/54140304836f646b3a46f5e0ebc9a900.png', 1, 'english', '2020-10-01 15:25:47'),
(3, 'faq', 'FAQ', 'Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Consequatur neque tenetur dolores laudantium quod facere qua', 'uploads/site_banners/db6862f2f5907b6d9a5c7b4b0efe3404.png', 1, 'english', '2021-02-25 16:21:58'),
(4, 'how_it_works', 'HOW IT WORKS', 'Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Consequatur neque tenetur dolores laudantium quod facere qua', NULL, 1, 'english', '2020-10-01 15:34:33'),
(5, 'teams', 'MEET WITH OUR TEAMS', 'Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Consequatur neque tenetur dolores laudantium quod facere qua', NULL, 1, 'english', '2020-10-01 15:35:01'),
(6, 'services', 'OUR SERVICES', 'Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Consequatur neque tenetur dolores laudantium quod facere qua', NULL, 1, 'english', '2020-10-01 15:40:10'),
(7, 'reviews', 'Reviews', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde, eum vel recusandae, voluptas dolore dicta! Lorem ipsum dolor sit amet consectetur', NULL, 1, 'english', '2020-10-18 10:46:53'),
(8, 'pricing', 'Select a package to continue', 'Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Consequatur neque tenetur dolores laudantium quod facere qua', NULL, 0, 'english', '2020-10-16 16:29:29'),
(9, 'contacts', 'Contacts', 'Need any help. Please contact with us', NULL, 1, 'english', '2021-02-20 17:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `security_attempts`
--

CREATE TABLE `security_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `keywords` text,
  `created_at` varchar(45) DEFAULT NULL,
  `timestamp` int(11) NOT NULL,
  `total_attempts` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `icon` varchar(250) NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `title`, `icon`, `details`, `status`, `created_at`) VALUES
(1, 8, 'Click to Call', '<i class=\"fas fa-phone\"></i>', 'Your customers will reach you by just tapping on mobile number on vCard.', 1, '2020-10-12 11:35:47'),
(3, 8, 'Click to Call', '<i class=\"fas fa-home\"></i>', 'Your customers will reach you by just tapping on mobile number on vCard.', 1, '2020-10-13 16:23:00'),
(4, 8, 'Click to Call', '<i class=\"fas fa-phone\"></i>', 'Your customers will reach you by just tapping on mobile number on vCard.Your customers will reach you by just tapping on mobile number on vCard. Your customers will reach you by just tapping on mobile number on vCard.', 1, '2020-10-12 11:35:47'),
(5, 8, 'Click to Call', '<i class=\"fas fa-phone\"></i>', 'Your customers will reach you by just tapping on mobile number on vCard.', 1, '2020-10-12 11:35:47'),
(6, 8, 'Click to Call', '<i class=\"fas fa-phone\"></i>', 'Your customers will reach you by just tapping on mobile number on vCard.', 0, '2020-10-12 11:35:47'),
(7, 8, 'Click to Call', '<i class=\"fas fa-phone\"></i>', 'Your customers will reach you by just tapping on mobile number on vCard.', 0, '2020-10-12 11:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(250) NOT NULL,
  `copyright` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `analytics` text NOT NULL,
  `smtp_mail` varchar(255) NOT NULL,
  `email_type` int(11) NOT NULL DEFAULT '1',
  `smtp_config` varchar(255) NOT NULL,
  `subjects` varchar(255) NOT NULL,
  `is_paypal` int(11) NOT NULL DEFAULT '0',
  `paypal_config` varchar(255) NOT NULL,
  `is_stripe` int(11) NOT NULL DEFAULT '0',
  `stripe_config` varchar(255) NOT NULL,
  `is_recaptcha` int(11) NOT NULL DEFAULT '0',
  `recaptcha_config` varchar(255) NOT NULL,
  `social_sites` longtext,
  `pricing_layout` int(11) NOT NULL DEFAULT '1',
  `time_zone` varchar(255) NOT NULL DEFAULT 'Asia/Dhaka',
  `is_registration` tinyint(11) NOT NULL DEFAULT '1',
  `auto_approval` int(11) NOT NULL DEFAULT '1',
  `is_email_verification` int(11) NOT NULL DEFAULT '0',
  `new_user_mail` int(11) NOT NULL DEFAULT '1',
  `is_email_verify_free` int(11) NOT NULL DEFAULT '1',
  `user_invoice` int(11) NOT NULL DEFAULT '1',
  `language` varchar(255) NOT NULL DEFAULT '''''''english''''''',
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `user_count` int(11) NOT NULL DEFAULT '0',
  `home_banner` varchar(255) NOT NULL,
  `home_banner_thumb` varchar(255) NOT NULL,
  `site_qr_link` varchar(255) NOT NULL,
  `site_qr_logo` varchar(255) NOT NULL,
  `active_code` varchar(255) NOT NULL,
  `site_id` int(11) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `razorpay_key` varchar(255) DEFAULT NULL,
  `razorpay_key_id` varchar(255) DEFAULT NULL,
  `is_razorpay` int(11) NOT NULL DEFAULT '0',
  `currency` int(11) NOT NULL DEFAULT '26',
  `is_ads` int(11) NOT NULL DEFAULT '0',
  `is_rating` int(11) NOT NULL DEFAULT '1',
  `site_info` varchar(255) DEFAULT NULL,
  `purchase_code` varchar(255) NOT NULL,
  `supported_until` datetime DEFAULT NULL,
  `is_user` int(11) NOT NULL DEFAULT '1',
  `is_order_video` int(11) NOT NULL DEFAULT '1',
  `site_url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `seo_settings` text,
  `active_key` varchar(155) DEFAULT NULL,
  `is_signup` int(11) NOT NULL DEFAULT '1',
  `is_auto_verified` int(11) NOT NULL DEFAULT '0',
  `twillo_sms_settings` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `is_lang_list` int(11) NOT NULL DEFAULT '1',
  `purchase_date` datetime DEFAULT NULL,
  `license_code` varchar(255) DEFAULT NULL,
  `is_update` int(11) NOT NULL DEFAULT '0',
  `is_item_search` int(11) NOT NULL DEFAULT '1',
  `environment` varchar(255) NOT NULL DEFAULT 'live',
  `is_landing_page` int(11) NOT NULL DEFAULT '0',
  `landing_page_url` varchar(255) DEFAULT NULL,
  `paypal_status` int(11) NOT NULL DEFAULT '1',
  `stripe_status` int(11) NOT NULL DEFAULT '1',
  `razorpay_status` int(11) NOT NULL DEFAULT '1',
  `stripe_fpx_status` int(11) NOT NULL DEFAULT '0',
  `mercado_status` int(11) NOT NULL DEFAULT '0',
  `paytm_status` int(11) NOT NULL DEFAULT '0',
  `flutterwave_status` int(11) NOT NULL DEFAULT '0',
  `is_fpx` int(11) NOT NULL DEFAULT '1',
  `fpx_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_mercado` int(11) NOT NULL DEFAULT '0',
  `mercado_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_paytm` int(11) NOT NULL DEFAULT '0',
  `paytm_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_flutterwave` int(11) NOT NULL DEFAULT '0',
  `flutterwave_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pixel_id` varchar(255) DEFAULT NULL,
  `gmap_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_pwa` int(11) NOT NULL DEFAULT '0',
  `pwa_config` text,
  `system_fonts` varchar(255) DEFAULT NULL,
  `custom_css` longtext,
  `long_description` longtext,
  `license_name` varchar(255) NOT NULL,
  `paystack_status` int(11) NOT NULL DEFAULT '1',
  `is_paystack` int(11) NOT NULL DEFAULT '0',
  `paystack_config` longtext,
  `nearby_length` varchar(20) DEFAULT '5',
  `extras` longtext,
  `notifications` longtext,
  `restaurant_demo` varchar(50) DEFAULT NULL,
  `sendgrid_api_key` longtext,
  `currency_position` int(11) NOT NULL DEFAULT '1',
  `number_formats` int(11) NOT NULL DEFAULT '1',
  `offline_status` int(11) NOT NULL DEFAULT '1',
  `is_offline` int(11) NOT NULL DEFAULT '1',
  `offline_config` longtext,
  `site_color` varchar(50) NOT NULL DEFAULT '29c7ac',
  `site_theme` int(11) NOT NULL DEFAULT '1',
  `custom_domain_comments` longtext,
  `pagadito_config` longtext,
  `is_pagadito` int(11) NOT NULL DEFAULT '0',
  `pagadito_status` int(11) NOT NULL DEFAULT '0',
  `is_custom_domain` int(11) NOT NULL DEFAULT '0',
  `pusher_config` longtext,
  `email_template_config` longtext,
  `is_dynamic_mail` int(11) NOT NULL DEFAULT '1',
  `netseasy_config` longtext,
  `is_netseasy` int(11) NOT NULL DEFAULT '0',
  `netseasy_status` int(11) NOT NULL DEFAULT '0',
  `invoice_config` longtext,
  `language_type` varchar(10) NOT NULL DEFAULT 'system',
  `glanguage` text,
  `moyasar_config` longtext,
  `is_moyasar` int(11) NOT NULL DEFAULT '0',
  `moyasar_status` int(11) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0',
  `tax_system` varchar(20) NOT NULL DEFAULT 'percentage',
  `is_city_delivery` int(11) NOT NULL DEFAULT '1',
  `ip_address` int(11) NOT NULL,
  `attempt_config` longtext,
  `midtrans_config` longtext,
  `is_midtrans` int(11) NOT NULL DEFAULT '0',
  `midtrans_status` int(11) NOT NULL DEFAULT '0',
  `cashfree_config` longtext,
  `is_cashfree` int(11) NOT NULL DEFAULT '0',
  `cashfree_status` int(11) NOT NULL DEFAULT '0',
  `custom_js` longtext,
  `myfatoorah_config` longtext,
  `is_myfatoorah` int(11) NOT NULL DEFAULT '0',
  `myfatoorah_status` int(11) NOT NULL DEFAULT '0',
  `iyzico_config` longtext,
  `is_iyzico` int(11) NOT NULL DEFAULT '0',
  `iyzico_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shop_location_list`
--

CREATE TABLE `shop_location_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sitemap_list`
--

CREATE TABLE `sitemap_list` (
  `id` int(11) NOT NULL,
  `url` text,
  `changefreq` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_features`
--

CREATE TABLE `site_features` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `images` varchar(200) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `details` text,
  `dir` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `langauge` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL,
  `language` varchar(50) NOT NULL DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_features`
--

INSERT INTO `site_features` (`id`, `user_id`, `title`, `images`, `thumb`, `icon`, `details`, `dir`, `status`, `langauge`, `created_at`, `language`) VALUES
(1, 1, 'Choose a name of your  Restaurant', '', '', '<i class=\"icofont-newspaper\"></i>', 'Choose you name and create your restaurant easily', 'left', 1, 'english', '2021-02-25 15:54:09', 'english'),
(2, 1, 'Create Menu', '', '', '<i class=\"icofont-list\"></i>', 'Add to cart your item and make a menu', 'right', 1, 'english', '2021-02-25 16:00:05', 'english'),
(3, 1, 'Make an order', '', '', '<i class=\"icofont-fast-delivery\"></i>', 'After select all items make an order select order type like  booking or home delivery ', 'right', 1, 'english', '2021-02-25 16:03:50', 'english'),
(4, 1, 'Mail verification', '', '', '<i class=\"icofont-envelope-open\"></i>', 'After create you account , verify you account by mail verification', 'left', 1, 'english', '2021-02-25 15:55:40', 'english'),
(6, 1, 'Make  Payment', NULL, NULL, '<i class=\"icofont-pay\"></i>', 'Make a payment if your not a free user. Make payment using Stripe,Paypal,Razorpay', 'left', 1, 'english', '2021-02-25 15:56:58', 'english'),
(7, 1, 'QR code', NULL, NULL, '<i class=\"icofont-qr-code\"></i>', 'After create account dynamically create your account QR code. Share your account via QR code', 'left', 1, 'english', '2021-02-25 15:58:46', 'english'),
(8, 1, 'Ordering via Whatsapp', NULL, NULL, '<i class=\"icofont-wechat\"></i>', 'After complete order confirm order via WhatsApp,  continue chat & finalize order', 'right', 1, 'english', '2021-02-25 16:10:34', 'english'),
(9, 1, 'Track your order', NULL, NULL, '<i class=\"icofont-search-restaurant\"></i>', 'Track your order using your phone & Order id or QR code', 'right', 1, 'english', '2021-02-25 16:12:15', 'english');

-- --------------------------------------------------------

--
-- Table structure for table `site_services`
--

CREATE TABLE `site_services` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `details` text,
  `images` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_services`
--

INSERT INTO `site_services` (`id`, `title`, `details`, `images`, `thumb`, `status`, `language`, `created_at`) VALUES
(1, 'Create Your Restaurant Profile', '<p>Make you restaurant profile with unique design, Dynamic color, Social sites.</p>', 'uploads/big/e003eb0309f4315d253ec4ffb31b2ca1.png', 'uploads/thumb/e003eb0309f4315d253ec4ffb31b2ca1.png', 1, 'english', '2021-02-25 16:34:19'),
(2, 'Check Order and orders statistics', '<p>Check your order, reservation , revenue and all statistics with strong dashboard  </p>', 'uploads/big/cb082005e089ae453eae2cc6f41f2acd.png', 'uploads/thumb/cb082005e089ae453eae2cc6f41f2acd.png', 1, 'english', '2021-02-25 16:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `site_team`
--

CREATE TABLE `site_team` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `images` varchar(200) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_team`
--

INSERT INTO `site_team` (`id`, `user_id`, `name`, `designation`, `images`, `thumb`, `status`, `language`, `created_at`) VALUES
(1, 1, 'Mr. Alex', 'CEO', 'uploads/big/c31f02324e2cc2ded3a1286d48be5030.jpg', 'uploads/thumb/c31f02324e2cc2ded3a1286d48be5030.jpg', 1, 'english', '2021-02-25 16:30:25'),
(2, 1, 'Mr. Smith', 'Client', 'uploads/big/38ceda12ce3cc859232f10e6c563e8fe.jpg', 'uploads/thumb/38ceda12ce3cc859232f10e6c563e8fe.jpg', 1, 'english', '2021-02-25 16:29:57'),
(3, 1, 'Miss Arenda', 'Client', 'uploads/big/aa01e93ee641057da403846721c66d8c.jpg', 'uploads/thumb/aa01e93ee641057da403846721c66d8c.jpg', 1, 'english', '2021-02-22 10:43:48'),
(6, 1, 'Mr. Beak', 'Manager', 'uploads/big/ffa2b9a5422b2f745d0c3febd07027e0.jpg', 'uploads/thumb/ffa2b9a5422b2f745d0c3febd07027e0.jpg', 1, 'english', '2021-02-25 16:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `social_sites`
--

CREATE TABLE `social_sites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `bg_color` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_sites`
--

INSERT INTO `social_sites` (`id`, `user_id`, `name`, `icon`, `type`, `link`, `color`, `bg_color`, `status`, `created_at`) VALUES
(1, 8, 'facebook', '<i class=\"fa fa-facebook\" aria-hidden=\"true\"></i>', '', 'https://www.facebook.com/nazmul.nm/', NULL, NULL, 1, '2020-10-12 10:59:05'),
(2, 8, 'twitter', '<i class=\"fa fa-twitter\" aria-hidden=\"true\"></i>', 'others', 'https://www.twitter.com/nazmul.nm/', NULL, NULL, 1, '2020-11-01 17:55:16'),
(3, 8, 'instagram', '<i class=\"fa fa-instagram\" aria-hidden=\"true\"></i>', '', 'https://www.twitter.com/nazmul.nm/', NULL, NULL, 1, '2020-11-01 17:55:30'),
(4, 8, 'github', '<i class=\"fa fa-github\" aria-hidden=\"true\"></i>', '', 'https://www.github.com/nazmul.nm/', NULL, NULL, 1, '2020-11-01 17:55:40'),
(5, 8, 'youtube', '<i class=\"fa fa-youtube\" aria-hidden=\"true\"></i>', '', '', NULL, NULL, 1, '2019-12-03 16:32:02'),
(6, 8, 'whatsapp', '<i class=\"fa fa-whatsapp\" aria-hidden=\"true\"></i>', 'whatsapp', '01745419093', NULL, NULL, 1, '2020-11-01 17:55:53'),
(7, 8, 'behance', '<i class=\"fa fa-behance\" aria-hidden=\"true\"></i>', '', '', NULL, NULL, 1, '2019-12-03 16:33:19'),
(8, 8, 'dribbble', '<i class=\"fa fa-dribbble\" aria-hidden=\"true\"></i>', '', '', NULL, NULL, 1, '2019-12-03 16:34:32'),
(10, 8, 'pinterest', '<i class=\"fab fa-pinterest-p\"></i>', 'others', '', NULL, NULL, 1, '2020-10-12 10:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `staff_activities`
--

CREATE TABLE `staff_activities` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `active_date` datetime NOT NULL,
  `is_renewal` int(11) NOT NULL DEFAULT '0',
  `old_package_id` int(11) NOT NULL DEFAULT '0',
  `renew_date` datetime NOT NULL,
  `is_change_package` int(11) NOT NULL DEFAULT '0',
  `is_new` int(11) NOT NULL DEFAULT '0',
  `price` double DEFAULT NULL,
  `package_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_list`
--

CREATE TABLE `staff_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `permission` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'staff',
  `country_id` varchar(5) DEFAULT NULL,
  `address` text,
  `gmap_link` text,
  `question` longtext,
  `city_id` int(5) NOT NULL DEFAULT '0',
  `shop_id` int(5) NOT NULL DEFAULT '0',
  `is_default` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_order_activity_logs`
--

CREATE TABLE `staff_order_activity_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `staff_role` varchar(50) NOT NULL DEFAULT 'staff',
  `action_type` varchar(50) DEFAULT NULL,
  `is_pos` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_list`
--

CREATE TABLE `subscriber_list` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `auth_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_list`
--

CREATE TABLE `sub_category_list` (
  `id` int(11) NOT NULL,
  `sub_category_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `orders` int(11) NOT NULL,
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_pos_only` int(11) NOT NULL DEFAULT '0',
  `images` varchar(200) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_areas`
--

CREATE TABLE `table_areas` (
  `id` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_list`
--

CREATE TABLE `table_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `images` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `address` mediumtext,
  `account_type` int(11) DEFAULT NULL,
  `user_role` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_verify` int(11) NOT NULL DEFAULT '0',
  `is_payment` int(11) NOT NULL DEFAULT '0',
  `is_expired` int(11) NOT NULL DEFAULT '0',
  `is_request` int(11) NOT NULL DEFAULT '0',
  `designation` varchar(250) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `verify_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `theme` int(11) NOT NULL DEFAULT '1',
  `documents` varchar(255) DEFAULT NULL,
  `theme_color` int(11) NOT NULL DEFAULT '0',
  `colors` varchar(255) NOT NULL DEFAULT '29c7ac',
  `cover_photo` varchar(255) DEFAULT NULL,
  `vcf_qr` varchar(255) DEFAULT NULL,
  `qr_link` varchar(255) DEFAULT NULL,
  `share_link` int(11) NOT NULL,
  `is_deactived` int(11) NOT NULL DEFAULT '0',
  `site_info` varchar(255) NOT NULL,
  `dial_code` varchar(20) NOT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  `menu_style` int(11) NOT NULL DEFAULT '1',
  `staff_id` int(11) NOT NULL DEFAULT '1',
  `company_name` varchar(50) DEFAULT NULL,
  `referal_code` varchar(10) DEFAULT NULL,
  `home_page_style` int(11) DEFAULT '1',
  `is_theme_toggle` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_active_features`
--

CREATE TABLE `users_active_features` (
  `id` int(11) NOT NULL,
  `feature_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `sub_heading` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `language` varchar(20) NOT NULL DEFAULT 'english'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_active_order_types`
--

CREATE TABLE `users_active_order_types` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `is_payment` int(11) NOT NULL DEFAULT '0',
  `is_required` int(11) NOT NULL DEFAULT '0',
  `is_admin_enable` int(11) NOT NULL DEFAULT '1',
  `is_package` int(11) NOT NULL DEFAULT '1',
  `is_service_charge` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_active_order_types`
--

INSERT INTO `users_active_order_types` (`id`, `user_id`, `shop_id`, `type_id`, `status`, `created_at`, `is_payment`, `is_required`, `is_admin_enable`, `is_package`, `is_service_charge`) VALUES
(1, 8, 0, 1, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(2, 8, 0, 2, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(3, 8, 0, 3, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(4, 8, 0, 4, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(5, 8, 0, 5, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(6, 8, 0, 6, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(7, 8, 0, 7, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(8, 8, 0, 8, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1),
(9, 8, 0, 9, 1, '2024-12-23 12:09:52', 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_rating`
--

CREATE TABLE `users_rating` (
  `id` int(11) NOT NULL,
  `action_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `rating` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `msg` text,
  `rating_type` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_action_attempts`
--

CREATE TABLE `user_action_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `action` varchar(20) NOT NULL,
  `total_attempts` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `preloader` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `is_download` int(11) NOT NULL DEFAULT '0',
  `smtp_mail` varchar(255) DEFAULT NULL,
  `smtp_config` text,
  `email_type` int(11) NOT NULL DEFAULT '1',
  `is_facebook` int(11) NOT NULL DEFAULT '1',
  `seo_settings` text,
  `twillo_sms_settings` text,
  `pixel_id` varchar(255) DEFAULT NULL,
  `analytics_id` varchar(255) DEFAULT NULL,
  `icon_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `qr_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pwa_config` text,
  `table_qr_config` longtext,
  `onesignal_config` longtext,
  `extra_config` longtext,
  `pos_config` longtext,
  `order_mail_config` longtext,
  `sendgrid_api_key` text,
  `site_theme` int(11) NOT NULL DEFAULT '1',
  `pusher_config` longtext,
  `is_banner` int(11) NOT NULL DEFAULT '0',
  `is_footer` int(11) NOT NULL DEFAULT '0',
  `vendor_affiliate_settings` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_affiliate_list`
--

CREATE TABLE `vendor_affiliate_list` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  `refer_from_id` int(11) NOT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `package_price` varchar(20) DEFAULT NULL,
  `commision_amount` varchar(20) DEFAULT NULL,
  `referal_code` varchar(20) DEFAULT NULL,
  `ref_type` varchar(80) DEFAULT NULL,
  `commision_rate` varchar(20) DEFAULT NULL,
  `commision_type` varchar(20) DEFAULT NULL,
  `subscriber_commision_rate` varchar(20) DEFAULT NULL,
  `subscriber_commision_type` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_request` int(11) NOT NULL DEFAULT '0',
  `is_payment` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_menu_list`
--

CREATE TABLE `vendor_menu_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_dropdown` int(2) NOT NULL DEFAULT '0',
  `dropdown_id` int(11) NOT NULL DEFAULT '0',
  `is_quick_link` int(2) NOT NULL DEFAULT '0',
  `is_extranal_url` int(2) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_page_list`
--

CREATE TABLE `vendor_page_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `title` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `details` longtext,
  `is_menu_bar` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_question_list`
--

CREATE TABLE `vendor_question_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `language` varchar(80) NOT NULL DEFAULT 'english',
  `title` varchar(200) DEFAULT NULL,
  `access_for` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_slider_list`
--

CREATE TABLE `vendor_slider_list` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `shop_id` int(11) NOT NULL,
  `details` longtext NOT NULL,
  `thumb` varchar(250) DEFAULT NULL,
  `images` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addons_list`
--
ALTER TABLE `addons_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_config`
--
ALTER TABLE `admin_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notification_list`
--
ALTER TABLE `admin_notification_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_tutorial_list`
--
ALTER TABLE `admin_tutorial_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_payout_list`
--
ALTER TABLE `affiliate_payout_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allergens`
--
ALTER TABLE `allergens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_waiter_list`
--
ALTER TABLE `call_waiter_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_list`
--
ALTER TABLE `chat_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupon_list`
--
ALTER TABLE `coupon_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_list`
--
ALTER TABLE `customer_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_domain_list`
--
ALTER TABLE `custom_domain_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_queue`
--
ALTER TABLE `data_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_area_list`
--
ALTER TABLE `delivery_area_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dine_in`
--
ALTER TABLE `dine_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category_list`
--
ALTER TABLE `expense_category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_list`
--
ALTER TABLE `expense_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_libraries`
--
ALTER TABLE `extra_libraries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_title_list`
--
ALTER TABLE `extra_title_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_list`
--
ALTER TABLE `hotel_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_works`
--
ALTER TABLE `how_it_works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_category_list`
--
ALTER TABLE `item_category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_content`
--
ALTER TABLE `item_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_extras`
--
ALTER TABLE `item_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_list`
--
ALTER TABLE `item_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_packages`
--
ALTER TABLE `item_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_packages_list`
--
ALTER TABLE `item_packages_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_sizes`
--
ALTER TABLE `item_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_data`
--
ALTER TABLE `language_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_type`
--
ALTER TABLE `menu_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_list`
--
ALTER TABLE `offer_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `offline_payment`
--
ALTER TABLE `offline_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item_list`
--
ALTER TABLE `order_item_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `order_payment_info`
--
ALTER TABLE `order_payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_types`
--
ALTER TABLE `order_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_user_list`
--
ALTER TABLE `order_user_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `order_type` (`order_type`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_method_list`
--
ALTER TABLE `payment_method_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_list`
--
ALTER TABLE `permission_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pickup_points_area`
--
ALTER TABLE `pickup_points_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacy`
--
ALTER TABLE `privacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_home`
--
ALTER TABLE `profile_home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_list`
--
ALTER TABLE `question_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation_date`
--
ALTER TABLE `reservation_date`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation_types`
--
ALTER TABLE `reservation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_city_list`
--
ALTER TABLE `restaurant_city_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_list`
--
ALTER TABLE `restaurant_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_offline_payemnt_list`
--
ALTER TABLE `restaurant_offline_payemnt_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_banners`
--
ALTER TABLE `section_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security_attempts`
--
ALTER TABLE `security_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_location_list`
--
ALTER TABLE `shop_location_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sitemap_list`
--
ALTER TABLE `sitemap_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_features`
--
ALTER TABLE `site_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_services`
--
ALTER TABLE `site_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_team`
--
ALTER TABLE `site_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_sites`
--
ALTER TABLE `social_sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_activities`
--
ALTER TABLE `staff_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_list`
--
ALTER TABLE `staff_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `staff_order_activity_logs`
--
ALTER TABLE `staff_order_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `subscriber_list`
--
ALTER TABLE `subscriber_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category_list`
--
ALTER TABLE `sub_category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_areas`
--
ALTER TABLE `table_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_list`
--
ALTER TABLE `table_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `account_type` (`account_type`);

--
-- Indexes for table `users_active_features`
--
ALTER TABLE `users_active_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_active_order_types`
--
ALTER TABLE `users_active_order_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_rating`
--
ALTER TABLE `users_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_action_attempts`
--
ALTER TABLE `user_action_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_action_index` (`ip_address`,`action`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_affiliate_list`
--
ALTER TABLE `vendor_affiliate_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_menu_list`
--
ALTER TABLE `vendor_menu_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_page_list`
--
ALTER TABLE `vendor_page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_question_list`
--
ALTER TABLE `vendor_question_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_slider_list`
--
ALTER TABLE `vendor_slider_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `about_content`
--
ALTER TABLE `about_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addons_list`
--
ALTER TABLE `addons_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_config`
--
ALTER TABLE `admin_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notification`
--
ALTER TABLE `admin_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notification_list`
--
ALTER TABLE `admin_notification_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_tutorial_list`
--
ALTER TABLE `admin_tutorial_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_payout_list`
--
ALTER TABLE `affiliate_payout_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allergens`
--
ALTER TABLE `allergens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_waiter_list`
--
ALTER TABLE `call_waiter_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_list`
--
ALTER TABLE `chat_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `coupon_list`
--
ALTER TABLE `coupon_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customer_list`
--
ALTER TABLE `customer_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_domain_list`
--
ALTER TABLE `custom_domain_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_queue`
--
ALTER TABLE `data_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_area_list`
--
ALTER TABLE `delivery_area_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dine_in`
--
ALTER TABLE `dine_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_category_list`
--
ALTER TABLE `expense_category_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_list`
--
ALTER TABLE `expense_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extra_libraries`
--
ALTER TABLE `extra_libraries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extra_title_list`
--
ALTER TABLE `extra_title_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hotel_list`
--
ALTER TABLE `hotel_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `how_it_works`
--
ALTER TABLE `how_it_works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_category_list`
--
ALTER TABLE `item_category_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_content`
--
ALTER TABLE `item_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_extras`
--
ALTER TABLE `item_extras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_packages`
--
ALTER TABLE `item_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_packages_list`
--
ALTER TABLE `item_packages_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_sizes`
--
ALTER TABLE `item_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `language_data`
--
ALTER TABLE `language_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1428;

--
-- AUTO_INCREMENT for table `menu_type`
--
ALTER TABLE `menu_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_list`
--
ALTER TABLE `offer_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_payment`
--
ALTER TABLE `offline_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_item_list`
--
ALTER TABLE `order_item_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payment_info`
--
ALTER TABLE `order_payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_types`
--
ALTER TABLE `order_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_user_list`
--
ALTER TABLE `order_user_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_method_list`
--
ALTER TABLE `payment_method_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permission_list`
--
ALTER TABLE `permission_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pickup_points_area`
--
ALTER TABLE `pickup_points_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricing`
--
ALTER TABLE `pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `privacy`
--
ALTER TABLE `privacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_home`
--
ALTER TABLE `profile_home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_list`
--
ALTER TABLE `question_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_date`
--
ALTER TABLE `reservation_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_types`
--
ALTER TABLE `reservation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_city_list`
--
ALTER TABLE `restaurant_city_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_list`
--
ALTER TABLE `restaurant_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_offline_payemnt_list`
--
ALTER TABLE `restaurant_offline_payemnt_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_banners`
--
ALTER TABLE `section_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `security_attempts`
--
ALTER TABLE `security_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_location_list`
--
ALTER TABLE `shop_location_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sitemap_list`
--
ALTER TABLE `sitemap_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_features`
--
ALTER TABLE `site_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_services`
--
ALTER TABLE `site_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_team`
--
ALTER TABLE `site_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `social_sites`
--
ALTER TABLE `social_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff_activities`
--
ALTER TABLE `staff_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_list`
--
ALTER TABLE `staff_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_order_activity_logs`
--
ALTER TABLE `staff_order_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriber_list`
--
ALTER TABLE `subscriber_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category_list`
--
ALTER TABLE `sub_category_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_areas`
--
ALTER TABLE `table_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_list`
--
ALTER TABLE `table_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_active_features`
--
ALTER TABLE `users_active_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_active_order_types`
--
ALTER TABLE `users_active_order_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users_rating`
--
ALTER TABLE `users_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_action_attempts`
--
ALTER TABLE `user_action_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_affiliate_list`
--
ALTER TABLE `vendor_affiliate_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_menu_list`
--
ALTER TABLE `vendor_menu_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_page_list`
--
ALTER TABLE `vendor_page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_question_list`
--
ALTER TABLE `vendor_question_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_slider_list`
--
ALTER TABLE `vendor_slider_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
