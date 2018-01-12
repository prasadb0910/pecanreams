-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2017 at 10:35 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `public_notices`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificate_no_types`
--

CREATE TABLE `certificate_no_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `certificate_no_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `certificate_no_types`
--

INSERT INTO `certificate_no_types` (`id`, `certificate_no_type`, `status`, `created_by`, `updated_by`, `approved_by`, `created_at`, `updated_at`, `approved_at`) VALUES
(1, 'Certificate no', 'approved', 1, 1, NULL, '2017-10-06 07:57:34', '2017-10-06 07:57:34', NULL),
(2, 'Distinctive no', 'approved', 1, 1, NULL, '2017-10-06 07:57:34', '2017-10-06 07:57:34', NULL),
(3, 'Folio no', 'approved', 1, 1, NULL, '2017-10-06 07:57:34', '2017-10-06 07:57:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location_types`
--

CREATE TABLE `location_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `location_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `location_types`
--

INSERT INTO `location_types` (`id`, `location_type`, `status`, `created_by`, `updated_by`, `approved_by`, `created_at`, `updated_at`, `approved_at`) VALUES
(1, 'Division', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(2, 'Taluka', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(3, 'Post', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(4, 'District', 'approved', 1, 1, NULL, '2017-10-06 07:57:34', '2017-10-06 07:57:34', NULL),
(5, 'Village', 'approved', 1, 1, NULL, '2017-10-06 07:57:34', '2017-10-06 07:57:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_07_19_145319_create_newspapers_table', 1),
(4, '2017_07_19_164707_create_notices_table', 1),
(5, '2017_07_20_102320_create_notice_types_table', 1),
(6, '2017_10_05_053630_create_legal_owner_names_table', 2),
(7, '2017_10_06_054941_create_property_no_types_table', 3),
(8, '2017_10_05_053630_create_notice_legal_owner_names_table', 4),
(9, '2017_10_06_063001_create_notice_property_no_details_table', 4),
(10, '2017_10_06_094255_create_notice_purchased_froms_table', 5),
(11, '2017_10_06_094518_create_notice_guarantors_table', 5),
(12, '2017_10_06_095343_create_notice_company_names_table', 5),
(13, '2017_10_06_111826_create_location_types_table', 5),
(14, '2017_10_06_112127_create_certificate_no_types_table', 5),
(15, '2017_10_06_112315_create_notice_location_details_table', 5),
(16, '2017_10_06_112450_create_notice_certificate_no_details_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `newspapers`
--

CREATE TABLE `newspapers` (
  `id` int(10) UNSIGNED NOT NULL,
  `paper_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_paper` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `newspapers`
--

INSERT INTO `newspapers` (`id`, `paper_name`, `language`, `e_paper`, `frequency`, `area`, `price`, `status`, `created_by`, `updated_by`, `approved_by`, `created_at`, `updated_at`, `approved_at`) VALUES
(1, 'Mid-Day', 'English/Gujrati', 'Available', 'Daily', 'Mumbai', 4.00, 'approved', 1, 1, NULL, '2017-07-23 03:30:32', '2017-07-23 03:30:32', NULL),
(2, 'The Indian Express', 'English', 'Available', 'Daily', 'Delhi/Mumbai/Pune/Chandigarh/Ahmedabad/Jaipur/Kolkata/Lucknow.', 4.00, 'approved', 1, 1, NULL, '2017-07-23 03:31:08', '2017-07-23 03:31:08', NULL),
(3, 'Hindustan Times', 'English', 'Available', 'Daily', 'Delhi/Gurgaon/Mumbai/Chandigarh/Jaipur/Lucknow/Patna/Noida.', 4.00, 'approved', 1, 1, NULL, '2017-07-24 02:31:08', '2017-07-24 02:31:08', NULL),
(4, 'DNA', 'English', 'Available', 'Daily', 'Mumbai/New Delhi/Ahmedabad/Jaipur.', 4.00, 'approved', 1, 1, NULL, '2017-07-28 01:40:00', '2017-07-28 01:40:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(10) UNSIGNED NOT NULL,
  `notice_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_notice` date DEFAULT NULL,
  `notice_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `fk_newspaper_id` int(10) UNSIGNED DEFAULT NULL,
  `days_for_respond` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_for_notice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issued_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_matter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_of_property` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_purchase` date DEFAULT NULL,
  `property_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wing` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_map_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cts_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `survey_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parking` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_owner_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_owner_pan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_owner_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_registration_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fk_notice_type_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `society_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `notice_title`, `date_of_notice`, `notice_file`, `details`, `fk_newspaper_id`, `days_for_respond`, `issued_by`, `reason_for_notice`, `issued_for`, `subject_matter`, `name_of_property`, `date_of_purchase`, `property_status`, `property_type`, `property_description`, `building_name`, `unit_no`, `floor`, `wing`, `address`, `landmark`, `village`, `city`, `pincode`, `state`, `country`, `google_map_address`, `cts_no`, `survey_number`, `area`, `parking`, `legal_owner_name`, `legal_owner_pan`, `legal_owner_address`, `company_name`, `company_registration_no`, `fk_notice_type_id`, `status`, `created_by`, `updated_by`, `approved_by`, `created_at`, `updated_at`, `approved_at`, `society_name`) VALUES
(1, 'Notice1', '2017-07-23', 'Notice_1.png', 'The (quick) (brownl {fox} jumps!\r\nOver the &43,456.78 <lazy> #90 dog\r\n& duck/goose, as 12.5% of E-mail\r\nfrom aspammerCwwebsite.com is spam.\r\nDer ,\\schnelle" braune Fuchs springt\r\nüber den faulen Hund. Le renard brun\r\n((rapide)) saute par-dessus le chien\r\nparesseux. La volpe marrone rapida\r\nsalta sopra il cane pigro. El zorro\r\nmarrón rápido salta sobre el perro\r\nperezoso. A raposa marrom rápida\r\nsalta sobre o cáo preguiCoso.', 1, '5', 'a', 'b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'approved', 1, 1, NULL, '2017-07-23 03:32:57', '2017-07-23 03:32:57', NULL, NULL),
(2, 'Notice2', '2017-07-25', 'Notice_2.jpg', '| : _\r\n\r\nNotice is hereby given to the\r\nPu blic that a ny/a | | rig ht_\r\ngranted to Bruder Ho_pitality\r\nPrt. Ltd by MarikeWy Food_ Pvt\r\nLtd to carry out busine__\r\noperations under the brand\r\nname \'\'THALASSA" currently\r\noperating at Hotel Shubhangan,\r\n21" Road, Khar. Danda, Khar\r\n(West), Mumbai 4000s2, are\r\npermanently revoked/cancelled.\r\nGeneral Public i_ hereby\r\ninformed not to deal wlth or\r\ncarry out any tran_action in\r\nre_pect of the above brand\r\n"THALASSA" with anyone\r\nexcept the under_igned entity,\r\nwhich (by and through it_\r\npromoters) is the sole owner/\r\nproprieter of the brand\r\n"THALASSA"\r\nForMARIKETTV FOODS PVT LTD\r\n\r\n. ± _\r\n\r\nUnder lnstructions and advise\r\ntrom my client(s) Kapil Mehta\r\nand others (Here in after\r\nreferred to as clients) this is to\r\ninform General Public lhal Lale\r\nShri Satish Mehta Slo Late Shri\r\nS.B.Mehta, Slo Late Shri B.B.\r\nMehta leW tor his heavenly\r\nabode on 10th November, 2016.\r\nThat as informed by my clienl(s),\r\nsaid Late Shri Satish Mehta a\r\nOthers is also the bonafide legal\r\nheirsl Successor(s) to both\r\nMovable and lmmouable Properfy\r\n(ies) related to Late Shri Beli\r\nRam Mehta 6 Ors the lact ol which\r\nhas been incidentally made known\r\nto my client5(s) upon demise ot\r\nsaid Late Shri Satish Mehta, aWer\r\nlinding some ot the documents\r\nrecords etc as leW over by said\r\nLate Shri Satish Mehta, without\r\ndisseminating any intormation to\r\nanyone in lhe "Mehta Family"\r\nregarding ancestral inheritances\r\nrelated to l lrom Late Shri Beli\r\nRam Mehta B Ors.\r\nThat |, on behalt ot my client(s)\r\nraise valid objeclion(5)l cliam(s)l\r\nright(s)l title(s) and interest(s), in\r\nanyl all Movable or lmmovable\r\nProperfy(ies) related to Late Shri\r\nBeli Ram Mehta B Ors it any, which,\r\nare not known to my clients, by\r\nway otthis PUBLIC NOTICE.\r\nThat in view of lhis PUBLIC\r\nNOTICE all or any such person\r\n(s), entity(ies), association(s),\r\nSociety(ies) etc are hereby cautio\r\nned not to indulge and take any\r\nsuch action(5) , step5(s) etc in\r\nany manner(s) whatsoever,\r\ntowards such Movable or lmmo\r\nvable Property(ies) related to\r\nLate Shri Beli Ram Mehta until\r\nsatisfactory disposal or valid\r\nOBJECTIONSl CLAIM(S) or my\r\nclient(s).\r\nAny person(s), entity(ies),\r\nassociation(s), Sociely(ies)\r\netc. dealing in any manner(5)\r\nwith the propertyEies) situaled\r\nnamely in the Region Mumbai,\r\nDistrict: Mumbai Suburban,\r\nTaluha,Borivali Village Dahisar,\r\nPostal Pin Code 400068, Local\r\nBody Mumbai Corporation or\r\nGreater Mumbai and any olher\r\nproperty(ies) related to Lale\r\nShri Beli Ram Mehta B Ors.,\r\nin any manner, shall solely do,\r\nat it l hisl her l[heir own\r\nrisk(s) and responsibility(ies)\r\nS.Jaina B Associates\r\nAdvocates and Solicitors\r\n84,Da_a Ganj,New Delhi .110002\r\nPh: 011.23267017', 2, '5', 'a', 'b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'approved', 1, 1, NULL, '2017-07-25 01:06:54', '2017-07-25 01:06:54', NULL, NULL),
(3, 'Notice3', '2017-07-28', 'Notice_3.jpeg', 'The qulck brown fo_\r\njumps ovcr lhe lazy\r\ndog.', 1, '2', 's', 's', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'approved', 1, 1, NULL, '2017-07-28 03:55:15', '2017-07-28 03:55:15', NULL, NULL),
(4, 'Test', '2017-10-05', 'Notice_4.jpg', '| : _\r\n\r\nNotice is hereby given to the\r\nPu blic that a ny/a | | rig ht_\r\ngranted to Bruder Ho_pitality\r\nPrt. Ltd by MarikeWy Food_ Pvt\r\nLtd to carry out busine__\r\noperations under the brand\r\nname \'\'THALASSA" currently\r\noperating at Hotel Shubhangan,\r\n21" Road, Khar. Danda, Khar\r\n(West), Mumbai 4000s2, are\r\npermanently revoked/cancelled.\r\nGeneral Public i_ hereby\r\ninformed not to deal wlth or\r\ncarry out any tran_action in\r\nre_pect of the above brand\r\n"THALASSA" with anyone\r\nexcept the under_igned entity,\r\nwhich (by and through it_\r\npromoters) is the sole owner/\r\nproprieter of the brand\r\n"THALASSA"\r\nForMARIKETTV FOODS PVT LTD\r\n\r\n. ± _\r\n\r\nUnder lnstructions and advise\r\ntrom my client(s) Kapil Mehta\r\nand others (Here in after\r\nreferred to as clients) this is to\r\ninform General Public lhal Lale\r\nShri Satish Mehta Slo Late Shri\r\nS.B.Mehta, Slo Late Shri B.B.\r\nMehta leW tor his heavenly\r\nabode on 10th November, 2016.\r\nThat as informed by my clienl(s),\r\nsaid Late Shri Satish Mehta a\r\nOthers is also the bonafide legal\r\nheirsl Successor(s) to both\r\nMovable and lmmouable Properfy\r\n(ies) related to Late Shri Beli\r\nRam Mehta 6 Ors the lact ol which\r\nhas been incidentally made known\r\nto my client5(s) upon demise ot\r\nsaid Late Shri Satish Mehta, aWer\r\nlinding some ot the documents\r\nrecords etc as leW over by said\r\nLate Shri Satish Mehta, without\r\ndisseminating any intormation to\r\nanyone in lhe "Mehta Family"\r\nregarding ancestral inheritances\r\nrelated to l lrom Late Shri Beli\r\nRam Mehta B Ors.\r\nThat |, on behalt ot my client(s)\r\nraise valid objeclion(5)l cliam(s)l\r\nright(s)l title(s) and interest(s), in\r\nanyl all Movable or lmmovable\r\nProperfy(ies) related to Late Shri\r\nBeli Ram Mehta B Ors it any, which,\r\nare not known to my clients, by\r\nway otthis PUBLIC NOTICE.\r\nThat in view of lhis PUBLIC\r\nNOTICE all or any such person\r\n(s), entity(ies), association(s),\r\nSociety(ies) etc are hereby cautio\r\nned not to indulge and take any\r\nsuch action(5) , step5(s) etc in\r\nany manner(s) whatsoever,\r\ntowards such Movable or lmmo\r\nvable Property(ies) related to\r\nLate Shri Beli Ram Mehta until\r\nsatisfactory disposal or valid\r\nOBJECTIONSl CLAIM(S) or my\r\nclient(s).\r\nAny person(s), entity(ies),\r\nassociation(s), Sociely(ies)\r\netc. dealing in any manner(5)\r\nwith the propertyEies) situaled\r\nnamely in the Region Mumbai,\r\nDistrict: Mumbai Suburban,\r\nTaluha,Borivali Village Dahisar,\r\nPostal Pin Code 400068, Local\r\nBody Mumbai Corporation or\r\nGreater Mumbai and any olher\r\nproperty(ies) related to Lale\r\nShri Beli Ram Mehta B Ors.,\r\nin any manner, shall solely do,\r\nat it l hisl her l[heir own\r\nrisk(s) and responsibility(ies)\r\nS.Jaina B Associates\r\nAdvocates and Solicitors\r\n84,Da_a Ganj,New Delhi .110002\r\nPh: 011.23267017', 1, NULL, 's', NULL, NULL, NULL, 'a', NULL, NULL, 'Land', 'r', 'b', NULL, 'e', 'f', 'g', NULL, NULL, 'i', '400050', 'j', 'k', NULL, NULL, NULL, NULL, 'l', NULL, NULL, NULL, NULL, NULL, 1, 'approved', 1, 1, NULL, '2017-10-05 00:56:40', '2017-10-05 01:26:06', NULL, 'c'),
(5, 'Title1', '2017-10-06', 'Notice_5.jpg', '| : _\r\n\r\nNotice is hereby given to the\r\nPu blic that a ny/a | | rig ht_\r\ngranted to Bruder Ho_pitality\r\nPrt. Ltd by MarikeWy Food_ Pvt\r\nLtd to carry out busine__\r\noperations under the brand\r\nname \'\'THALASSA" currently\r\noperating at Hotel Shubhangan,\r\n21" Road, Khar. Danda, Khar\r\n(West), Mumbai 4000s2, are\r\npermanently revoked/cancelled.\r\nGeneral Public i_ hereby\r\ninformed not to deal wlth or\r\ncarry out any tran_action in\r\nre_pect of the above brand\r\n"THALASSA" with anyone\r\nexcept the under_igned entity,\r\nwhich (by and through it_\r\npromoters) is the sole owner/\r\nproprieter of the brand\r\n"THALASSA"\r\nForMARIKETTV FOODS PVT LTD\r\n\r\n. ± _\r\n\r\nUnder lnstructions and advise\r\ntrom my client(s) Kapil Mehta\r\nand others (Here in after\r\nreferred to as clients) this is to\r\ninform General Public lhal Lale\r\nShri Satish Mehta Slo Late Shri\r\nS.B.Mehta, Slo Late Shri B.B.\r\nMehta leW tor his heavenly\r\nabode on 10th November, 2016.\r\nThat as informed by my clienl(s),\r\nsaid Late Shri Satish Mehta a\r\nOthers is also the bonafide legal\r\nheirsl Successor(s) to both\r\nMovable and lmmouable Properfy\r\n(ies) related to Late Shri Beli\r\nRam Mehta 6 Ors the lact ol which\r\nhas been incidentally made known\r\nto my client5(s) upon demise ot\r\nsaid Late Shri Satish Mehta, aWer\r\nlinding some ot the documents\r\nrecords etc as leW over by said\r\nLate Shri Satish Mehta, without\r\ndisseminating any intormation to\r\nanyone in lhe "Mehta Family"\r\nregarding ancestral inheritances\r\nrelated to l lrom Late Shri Beli\r\nRam Mehta B Ors.\r\nThat |, on behalt ot my client(s)\r\nraise valid objeclion(5)l cliam(s)l\r\nright(s)l title(s) and interest(s), in\r\nanyl all Movable or lmmovable\r\nProperfy(ies) related to Late Shri\r\nBeli Ram Mehta B Ors it any, which,\r\nare not known to my clients, by\r\nway otthis PUBLIC NOTICE.\r\nThat in view of lhis PUBLIC\r\nNOTICE all or any such person\r\n(s), entity(ies), association(s),\r\nSociety(ies) etc are hereby cautio\r\nned not to indulge and take any\r\nsuch action(5) , step5(s) etc in\r\nany manner(s) whatsoever,\r\ntowards such Movable or lmmo\r\nvable Property(ies) related to\r\nLate Shri Beli Ram Mehta until\r\nsatisfactory disposal or valid\r\nOBJECTIONSl CLAIM(S) or my\r\nclient(s).\r\nAny person(s), entity(ies),\r\nassociation(s), Sociely(ies)\r\netc. dealing in any manner(5)\r\nwith the propertyEies) situaled\r\nnamely in the Region Mumbai,\r\nDistrict: Mumbai Suburban,\r\nTaluha,Borivali Village Dahisar,\r\nPostal Pin Code 400068, Local\r\nBody Mumbai Corporation or\r\nGreater Mumbai and any olher\r\nproperty(ies) related to Lale\r\nShri Beli Ram Mehta B Ors.,\r\nin any manner, shall solely do,\r\nat it l hisl her l[heir own\r\nrisk(s) and responsibility(ies)\r\nS.Jaina B Associates\r\nAdvocates and Solicitors\r\n84,Da_a Ganj,New Delhi .110002\r\nPh: 011.23267017', 1, NULL, 'k', NULL, NULL, NULL, 'a', NULL, NULL, 'Land', 'j', 'b', NULL, 'd', 'e', 'f', NULL, NULL, 'Hyderabad', '500077', 'Telangana', 'India', NULL, NULL, NULL, NULL, 'g', NULL, NULL, NULL, NULL, NULL, 1, 'approved', 1, 1, NULL, '2017-10-06 04:01:59', '2017-10-06 04:01:59', NULL, 'c'),
(6, 'a', '2017-10-06', 'Notice_6.jpg', '| : _\r\n\r\nNotice is hereby given to the\r\nPu blic that a ny/a | | rig ht_\r\ngranted to Bruder Ho_pitality\r\nPrt. Ltd by MarikeWy Food_ Pvt\r\nLtd to carry out busine__\r\noperations under the brand\r\nname \'\'THALASSA" currently\r\noperating at Hotel Shubhangan,\r\n21" Road, Khar. Danda, Khar\r\n(West), Mumbai 4000s2, are\r\npermanently revoked/cancelled.\r\nGeneral Public i_ hereby\r\ninformed not to deal wlth or\r\ncarry out any tran_action in\r\nre_pect of the above brand\r\n"THALASSA" with anyone\r\nexcept the under_igned entity,\r\nwhich (by and through it_\r\npromoters) is the sole owner/\r\nproprieter of the brand\r\n"THALASSA"\r\nForMARIKETTV FOODS PVT LTD\r\n\r\n. ± _\r\n\r\nUnder lnstructions and advise\r\ntrom my client(s) Kapil Mehta\r\nand others (Here in after\r\nreferred to as clients) this is to\r\ninform General Public lhal Lale\r\nShri Satish Mehta Slo Late Shri\r\nS.B.Mehta, Slo Late Shri B.B.\r\nMehta leW tor his heavenly\r\nabode on 10th November, 2016.\r\nThat as informed by my clienl(s),\r\nsaid Late Shri Satish Mehta a\r\nOthers is also the bonafide legal\r\nheirsl Successor(s) to both\r\nMovable and lmmouable Properfy\r\n(ies) related to Late Shri Beli\r\nRam Mehta 6 Ors the lact ol which\r\nhas been incidentally made known\r\nto my client5(s) upon demise ot\r\nsaid Late Shri Satish Mehta, aWer\r\nlinding some ot the documents\r\nrecords etc as leW over by said\r\nLate Shri Satish Mehta, without\r\ndisseminating any intormation to\r\nanyone in lhe "Mehta Family"\r\nregarding ancestral inheritances\r\nrelated to l lrom Late Shri Beli\r\nRam Mehta B Ors.\r\nThat |, on behalt ot my client(s)\r\nraise valid objeclion(5)l cliam(s)l\r\nright(s)l title(s) and interest(s), in\r\nanyl all Movable or lmmovable\r\nProperfy(ies) related to Late Shri\r\nBeli Ram Mehta B Ors it any, which,\r\nare not known to my clients, by\r\nway otthis PUBLIC NOTICE.\r\nThat in view of lhis PUBLIC\r\nNOTICE all or any such person\r\n(s), entity(ies), association(s),\r\nSociety(ies) etc are hereby cautio\r\nned not to indulge and take any\r\nsuch action(5) , step5(s) etc in\r\nany manner(s) whatsoever,\r\ntowards such Movable or lmmo\r\nvable Property(ies) related to\r\nLate Shri Beli Ram Mehta until\r\nsatisfactory disposal or valid\r\nOBJECTIONSl CLAIM(S) or my\r\nclient(s).\r\nAny person(s), entity(ies),\r\nassociation(s), Sociely(ies)\r\netc. dealing in any manner(5)\r\nwith the propertyEies) situaled\r\nnamely in the Region Mumbai,\r\nDistrict: Mumbai Suburban,\r\nTaluha,Borivali Village Dahisar,\r\nPostal Pin Code 400068, Local\r\nBody Mumbai Corporation or\r\nGreater Mumbai and any olher\r\nproperty(ies) related to Lale\r\nShri Beli Ram Mehta B Ors.,\r\nin any manner, shall solely do,\r\nat it l hisl her l[heir own\r\nrisk(s) and responsibility(ies)\r\nS.Jaina B Associates\r\nAdvocates and Solicitors\r\n84,Da_a Ganj,New Delhi .110002\r\nPh: 011.23267017', 1, NULL, 'n', NULL, NULL, NULL, 'b', NULL, NULL, 'Others', 'm', 'c', NULL, 'e', 'f', 'g', NULL, NULL, 'h', 'i', 'j', 'k', NULL, NULL, NULL, NULL, 'l', NULL, NULL, NULL, NULL, NULL, 2, 'approved', 1, 1, NULL, '2017-10-06 08:13:37', '2017-10-06 08:15:08', NULL, 'd');

-- --------------------------------------------------------

--
-- Table structure for table `notice_certificate_no_details`
--

CREATE TABLE `notice_certificate_no_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `fk_certificate_no_type_id` int(10) UNSIGNED DEFAULT NULL,
  `certificate_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_certificate_no_details`
--

INSERT INTO `notice_certificate_no_details` (`id`, `fk_notice_id`, `fk_certificate_no_type_id`, `certificate_no`) VALUES
(2, 6, 3, 'f');

-- --------------------------------------------------------

--
-- Table structure for table `notice_company_names`
--

CREATE TABLE `notice_company_names` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_company_names`
--

INSERT INTO `notice_company_names` (`id`, `fk_notice_id`, `company_name`) VALUES
(2, 6, 'f');

-- --------------------------------------------------------

--
-- Table structure for table `notice_guarantors`
--

CREATE TABLE `notice_guarantors` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `guarantor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_guarantors`
--

INSERT INTO `notice_guarantors` (`id`, `fk_notice_id`, `guarantor`) VALUES
(3, 6, 'g');

-- --------------------------------------------------------

--
-- Table structure for table `notice_legal_owner_names`
--

CREATE TABLE `notice_legal_owner_names` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `legal_owner_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_legal_owner_names`
--

INSERT INTO `notice_legal_owner_names` (`id`, `fk_notice_id`, `legal_owner_name`) VALUES
(1, 5, 'a'),
(2, 5, 'b'),
(5, 6, 'a'),
(6, 6, 'b');

-- --------------------------------------------------------

--
-- Table structure for table `notice_location_details`
--

CREATE TABLE `notice_location_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `fk_location_type_id` int(10) UNSIGNED DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_location_details`
--

INSERT INTO `notice_location_details` (`id`, `fk_notice_id`, `fk_location_type_id`, `location`) VALUES
(4, 6, 2, 'c'),
(5, 6, 5, 'e');

-- --------------------------------------------------------

--
-- Table structure for table `notice_property_no_details`
--

CREATE TABLE `notice_property_no_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `fk_property_no_type_id` int(10) UNSIGNED DEFAULT NULL,
  `property_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_property_no_details`
--

INSERT INTO `notice_property_no_details` (`id`, `fk_notice_id`, `fk_property_no_type_id`, `property_no`) VALUES
(1, 5, 3, 'a'),
(2, 5, 10, 'b'),
(5, 6, 13, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `notice_purchased_froms`
--

CREATE TABLE `notice_purchased_froms` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `purchased_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_purchased_froms`
--

INSERT INTO `notice_purchased_froms` (`id`, `fk_notice_id`, `purchased_from`) VALUES
(4, 6, 'c'),
(5, 6, 'e');

-- --------------------------------------------------------

--
-- Table structure for table `notice_types`
--

CREATE TABLE `notice_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `notice_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notice_types`
--

INSERT INTO `notice_types` (`id`, `notice_type`, `status`, `created_by`, `updated_by`, `approved_by`, `created_at`, `updated_at`, `approved_at`) VALUES
(1, 'Claim of Property', 'approved', 1, 1, NULL, '2017-07-23 03:31:42', '2017-07-23 03:31:42', NULL),
(2, 'Lost of documents', 'approved', 1, 1, NULL, '2017-07-23 03:31:59', '2017-07-23 03:31:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `property_no_types`
--

CREATE TABLE `property_no_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_no_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_no_types`
--

INSERT INTO `property_no_types` (`id`, `property_no_type`, `status`, `created_by`, `updated_by`, `approved_by`, `created_at`, `updated_at`, `approved_at`) VALUES
(1, 'Sheet No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(2, 'Room No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(3, 'Block No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(4, 'Ward No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(5, 'Khata No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(6, 'Sr No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(7, 'Plot No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(8, 'Scheme No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(9, 'Unit No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(10, 'CTS No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(11, 'Survey No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(12, 'Gut No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL),
(13, 'Hissa No', 'approved', 1, 1, NULL, '2017-10-06 07:57:33', '2017-10-06 07:57:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$1Dg2foBa/.LlVbiAnn8YFeNZVsOlIQgqULRdN0fyP4yqUdpGcUpUu', 'JWxKyGvWupkQq5adg9JmLbD6lLetgyMaBHv8zfEC89K9XuMEiDy25b7pP60M', '2017-07-23 03:24:59', '2017-07-23 03:24:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificate_no_types`
--
ALTER TABLE `certificate_no_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_types`
--
ALTER TABLE `location_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newspapers`
--
ALTER TABLE `newspapers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_certificate_no_details`
--
ALTER TABLE `notice_certificate_no_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_company_names`
--
ALTER TABLE `notice_company_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_guarantors`
--
ALTER TABLE `notice_guarantors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_legal_owner_names`
--
ALTER TABLE `notice_legal_owner_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_location_details`
--
ALTER TABLE `notice_location_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_property_no_details`
--
ALTER TABLE `notice_property_no_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_purchased_froms`
--
ALTER TABLE `notice_purchased_froms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_types`
--
ALTER TABLE `notice_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `property_no_types`
--
ALTER TABLE `property_no_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificate_no_types`
--
ALTER TABLE `certificate_no_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `location_types`
--
ALTER TABLE `location_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `newspapers`
--
ALTER TABLE `newspapers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notice_certificate_no_details`
--
ALTER TABLE `notice_certificate_no_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notice_company_names`
--
ALTER TABLE `notice_company_names`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notice_guarantors`
--
ALTER TABLE `notice_guarantors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `notice_legal_owner_names`
--
ALTER TABLE `notice_legal_owner_names`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notice_location_details`
--
ALTER TABLE `notice_location_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `notice_property_no_details`
--
ALTER TABLE `notice_property_no_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `notice_purchased_froms`
--
ALTER TABLE `notice_purchased_froms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `notice_types`
--
ALTER TABLE `notice_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `property_no_types`
--
ALTER TABLE `property_no_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `group_users` ADD `assigned_role` INT NULL DEFAULT NULL AFTER `updated_at`;
UPDATE `group_users` SET `assigned_role` = '0' WHERE `group_users`.`gu_id` = 1;
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '0', 'Newspapers', '1', '1', '1', '1', '1', '1');
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '0', 'NoticeTypes', '1', '1', '1', '1', '1', '1');
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '0', 'Notices', '1', '1', '1', '1', '1', '1');
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '0', 'PropertyNotices', '1', '1', '1', '1', '1', '1');
INSERT INTO `group_users` (`gu_id`, `name`, `gu_email`, `gu_password`, `remember_token`, `created_at`, `updated_at`, `assigned_role`) 
VALUES (NULL, 'User', 'user@user.com', '$2y$10$1Dg2foBa/.LlVbiAnn8YFeNZVsOlIQgqULRdN0fyP4yqUdpGcUpUu', 'Ca1lAuUyvCKU53EE9NTL2f12YGcdN6SfczniNJCvekOx9InBUYc930luhThR', '2017-07-23 08:54:59', '2017-07-23 08:54:59', '2');
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '0', 'AdminDashboard', '1', '1', '1', '1', '1', '1');
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '2', 'UserDashboard', '1', '1', '1', '1', '1', '1');
INSERT INTO `user_role_options` (`op_id`, `role_id`, `section`, `r_view`, `r_insert`, `r_edit`, `r_delete`, `r_approvals`, `r_export`) 
VALUES (NULL, '2', 'UserNotices', '1', '1', '1', '1', '1', '1');

ALTER TABLE `pn_properties` 
ADD `legal_owner_name` VARCHAR(191) NULL DEFAULT NULL AFTER `folio_no`, 
ADD `parking_no` INT NULL DEFAULT NULL AFTER `legal_owner_name`, 
ADD `fk_group_id` INT NULL DEFAULT NULL AFTER `parking_no`;

ALTER TABLE `pn_property_notices` 
ADD `sent_by` INT NULL DEFAULT NULL AFTER `approved_at`, 
ADD `sent_at` TIMESTAMP NULL DEFAULT NULL AFTER `sent_by`;