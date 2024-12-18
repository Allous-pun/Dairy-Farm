-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 18, 2024 at 08:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dfsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bulls`
--

CREATE TABLE `bulls` (
  `Bull_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Category` enum('Young','Prime','Old') NOT NULL,
  `Breed` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `Health_Status` text DEFAULT NULL,
  `Last_Vaccination` date DEFAULT NULL,
  `Breeding_Status` enum('Active','Inactive') NOT NULL,
  `Assigned_Cows` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Assigned_Cows`)),
  `Weight_Record` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Weight_Record`)),
  `Location` varchar(255) NOT NULL,
  `Treatment_History` text DEFAULT NULL,
  `Notes` text DEFAULT NULL,
  `Next_Checkup` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulls`
--

INSERT INTO `bulls` (`Bull_ID`, `Name`, `Category`, `Breed`, `DOB`, `Health_Status`, `Last_Vaccination`, `Breeding_Status`, `Assigned_Cows`, `Weight_Record`, `Location`, `Treatment_History`, `Notes`, `Next_Checkup`) VALUES
(1, 'Bull 1', 'Prime', 'Angus', '2020-05-15', 'Healthy', '2023-03-01', 'Active', '[\"Cow1\", \"Cow2\"]', '[80, 85, 90]', 'Pen 1', 'Vaccination against Foot and Mouth Disease on 2023-03-01', 'No major issues', '2024-03-01'),
(2, 'Bull 2', 'Young', 'Hereford', '2021-07-10', 'Minor illness', '2023-02-12', 'Inactive', '[\"Cow3\", \"Cow4\"]', '[70, 75, 78]', 'Pen 2', 'Treatment for fever on 2023-02-12', 'Currently recovering from fever', '2024-02-12'),
(3, 'toldo', 'Young', 'angus', '2024-10-28', 'healthy', '2024-11-06', 'Active', '\"123,123\"', '\"200kg\"', 'herd', 'none', 'this is a healthy bull', '2024-11-20');

-- --------------------------------------------------------

--
-- Table structure for table `cows`
--

CREATE TABLE `cows` (
  `Cow_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Tag_Code` varchar(50) NOT NULL,
  `Breed` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `Category` enum('Lactating','Expectant','Delivered','Dry','Young','Needing Breeding') NOT NULL,
  `Health_Status` text DEFAULT NULL,
  `Last_Vaccination` date DEFAULT NULL,
  `Last_Treatment` text DEFAULT NULL,
  `Breeding_Status` enum('Pregnant','Ready for Breeding','Inactive') NOT NULL,
  `Last_Breeding_Date` date DEFAULT NULL,
  `Expected_Delivery_Date` date DEFAULT NULL,
  `Number_of_Calves` int(11) DEFAULT 0,
  `Total_Milk_Produced` decimal(10,2) DEFAULT 0.00,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cows`
--

INSERT INTO `cows` (`Cow_ID`, `Name`, `Tag_Code`, `Breed`, `DOB`, `Category`, `Health_Status`, `Last_Vaccination`, `Last_Treatment`, `Breeding_Status`, `Last_Breeding_Date`, `Expected_Delivery_Date`, `Number_of_Calves`, `Total_Milk_Produced`, `Notes`) VALUES
(1, 'Bella', 'COW001', 'Holstein Friesian', '2018-03-15', 'Lactating', 'Healthy', '2024-11-01', 'Regular hoof trimming', 'Pregnant', '2024-08-15', '2025-05-20', 4, 7500.50, 'Top producer in the herd.'),
(2, 'Daisy', 'COW002', 'Jersey', '2019-06-20', 'Expectant', 'Good condition', '2024-10-20', 'Vitamin supplementation', 'Pregnant', '2024-09-01', '2025-06-01', 2, 5000.00, 'Expected to deliver twins.'),
(3, 'Rosie', 'COW003', 'Guernsey', '2017-12-25', 'Dry', 'Healthy', '2024-09-10', 'Dewormed', 'Inactive', NULL, NULL, 3, 6200.25, 'Retired from milk production.'),
(4, 'Luna', 'COW004', 'Ayrshire', '2020-08-14', 'Delivered', 'Recovering from delivery', '2024-11-10', 'Post-delivery checkup', 'Inactive', '2024-01-20', NULL, 1, 0.00, 'Monitoring for lactation potential.'),
(5, 'Maggie', 'COW005', 'Brown Swiss', '2022-05-30', 'Young', 'Healthy', '2024-08-01', 'General health checkup', 'Ready for Breeding', NULL, NULL, 0, 0.00, 'Will be bred in the next cycle.'),
(6, 'Ellie', 'COW006', 'Red Poll', '2019-11-10', 'Needing Breeding', 'Good condition', '2024-11-05', 'Routine deworming', 'Ready for Breeding', NULL, NULL, 2, 4800.75, 'Eager for insemination.'),
(7, 'Mickey', 'COW007', 'Mixed', '2018-03-20', 'Dry', 'Healthy', '2024-02-15', 'Critical weight loss recovery', 'Inactive', '2024-03-20', '2025-03-30', 0, 0.00, 'Additional check-ups from first owner.');

-- --------------------------------------------------------

--
-- Table structure for table `FeedManagement`
--

CREATE TABLE `FeedManagement` (
  `Feed_ID` int(11) NOT NULL,
  `Feed_Name` varchar(255) NOT NULL,
  `Feed_Type` enum('Forage','Grain','Supplements') NOT NULL,
  `Nutritional_Composition` text DEFAULT NULL,
  `Current_Stock` float NOT NULL,
  `Stock_Unit` enum('kg','bags','liters') NOT NULL,
  `Minimum_Stock_Level` float NOT NULL,
  `Cost_Per_Unit` float NOT NULL,
  `Supplier_Name` varchar(255) DEFAULT NULL,
  `Last_Purchase_Date` date DEFAULT NULL,
  `Quantity_Per_Day` float NOT NULL,
  `Feeding_Frequency` enum('Once','Twice','Thrice daily') NOT NULL,
  `Animal_Type` enum('Cows','Bulls','Heifers','All') NOT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `FeedManagement`
--

INSERT INTO `FeedManagement` (`Feed_ID`, `Feed_Name`, `Feed_Type`, `Nutritional_Composition`, `Current_Stock`, `Stock_Unit`, `Minimum_Stock_Level`, `Cost_Per_Unit`, `Supplier_Name`, `Last_Purchase_Date`, `Quantity_Per_Day`, `Feeding_Frequency`, `Animal_Type`, `Remarks`) VALUES
(1, 'Hay', 'Forage', 'Protein: 8%, Fiber: 30%, Energy: 6.5 MJ/kg', 500, 'kg', 50, 2.5, 'Green Farms Ltd', '2024-10-15', 30, 'Twice', 'Cows', 'Store in a cool dry place.'),
(2, 'Silage', 'Forage', 'Protein: 12%, Fiber: 18%, Energy: 8.0 MJ/kg', 200, 'kg', 20, 3, 'Farm Supply Co.', '2024-10-10', 25, 'Thrice daily', 'Heifers', 'Requires refrigeration.'),
(3, 'Concentrates', 'Grain', 'Protein: 20%, Fiber: 5%, Energy: 12.0 MJ/kg', 300, 'bags', 30, 8, 'FeedMax Inc.', '2024-10-05', 40, 'Once', 'All', 'Keep in a dry, cool place.'),
(4, 'Mineral Supplements', 'Supplements', 'Minerals: Calcium 30%, Phosphorus 10%', 150, 'kg', 10, 5, 'NutriFeeds', '2024-10-12', 10, 'Twice', 'Cows', 'Ensure proper storage away from moisture.'),
(5, 'Grain Mix', 'Grain', 'Protein: 15%, Fiber: 7%, Energy: 10.0 MJ/kg', 100, 'liters', 15, 4, 'AgriSource Ltd', '2024-10-20', 20, 'Once', 'Bulls', 'For bulls with high-energy needs.');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(5) NOT NULL,
  `AdminName` varchar(45) DEFAULT NULL,
  `UserName` char(45) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`, `UpdationDate`) VALUES
(1, 'Admin', 'admin', 1234567899, 'admin@test.com', 'f925916e2754e5e03f75dd58a5733251', '2019-12-22 18:30:00', '2019-12-25 14:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `CategoryCode` varchar(50) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `CategoryCode`, `PostingDate`) VALUES
(2, 'Butter', 'BT01', '2019-12-24 16:27:59'),
(3, 'Bread', 'BD01', '2019-12-24 16:28:12'),
(4, 'Paneer', 'PN01', '2019-12-24 16:29:18'),
(5, 'Soya', 'SY01', '2019-12-24 16:29:58'),
(7, 'Ghee', 'GH01', '2019-12-25 14:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `tblcompany`
--

CREATE TABLE `tblcompany` (
  `id` int(11) NOT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcompany`
--

INSERT INTO `tblcompany` (`id`, `CompanyName`, `PostingDate`) VALUES
(1, 'Amul', '2019-12-25 03:30:51'),
(2, 'Mother Diary', '2019-12-25 03:30:59'),
(3, 'Patanjali', '2019-12-25 03:31:09'),
(4, 'Namaste India', '2019-12-25 03:31:21'),
(10, 'Paras', '2019-12-25 14:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblfertility_managers`
--

CREATE TABLE `tblfertility_managers` (
  `id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `AssignedAnimals` text DEFAULT NULL,
  `FertilityStatus` text DEFAULT NULL,
  `StartDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfertility_managers`
--

INSERT INTO `tblfertility_managers` (`id`, `Name`, `AssignedAnimals`, `FertilityStatus`, `StartDate`) VALUES
(1, 'James Brown', 'Heifers', 'Breeding', '2024-03-01'),
(3, 'Festus', 'cows', 'pregnant', '2024-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `tblhealth_managers`
--

CREATE TABLE `tblhealth_managers` (
  `id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `AssignedAnimals` text DEFAULT NULL,
  `StartDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblhealth_managers`
--

INSERT INTO `tblhealth_managers` (`id`, `Name`, `AssignedAnimals`, `StartDate`) VALUES
(2, 'Jane Smith', 'Cows, Bulls', '2024-02-01'),
(3, 'Festus', 'bulls', '2024-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `tblherd_managers`
--

CREATE TABLE `tblherd_managers` (
  `id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `AssignedHerd` text DEFAULT NULL,
  `StartDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblherd_managers`
--

INSERT INTO `tblherd_managers` (`id`, `Name`, `AssignedHerd`, `StartDate`) VALUES
(2, 'John Doe', 'Cows, Heifers', '2024-01-01'),
(4, 'Festus', 'cows', '2024-11-19'),
(5, 'choge', 'bulls', '2024-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `tblmilk_weight_managers`
--

CREATE TABLE `tblmilk_weight_managers` (
  `id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `AssignedAnimals` text DEFAULT NULL,
  `MilkProduction` text DEFAULT NULL,
  `WeightRecords` text DEFAULT NULL,
  `StartDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblmilk_weight_managers`
--

INSERT INTO `tblmilk_weight_managers` (`id`, `Name`, `AssignedAnimals`, `MilkProduction`, `WeightRecords`, `StartDate`) VALUES
(1, 'Anna White', 'Lactating Cows', '25 Liters per day', '550kg, 600kg', '2024-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `InvoiceNumber` int(11) DEFAULT NULL,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerContactNo` bigint(12) DEFAULT NULL,
  `PaymentMode` varchar(100) DEFAULT NULL,
  `InvoiceGenDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`id`, `ProductId`, `Quantity`, `InvoiceNumber`, `CustomerName`, `CustomerContactNo`, `PaymentMode`, `InvoiceGenDate`) VALUES
(1, 4, 2, 753947547, 'Anuj', 9354778033, 'cash', '2019-12-25 08:32:47'),
(2, 1, 1, 753947547, 'Anuj', 9354778033, 'cash', '2019-12-25 08:32:47'),
(3, 1, 1, 979148350, 'Sanjeen', 1234567890, 'card', '2019-12-25 11:38:08'),
(4, 4, 1, 979148350, 'Sanjeen', 1234567890, 'card', '2019-12-25 11:38:08'),
(5, 1, 1, 861354457, 'Rahul', 9876543210, 'cash', '2019-12-24 11:43:48'),
(6, 5, 1, 861354457, 'Rahul', 9876543210, 'cash', '2019-12-24 11:43:48'),
(7, 5, 1, 276794782, 'Sarita', 1122334455, 'cash', '2019-12-25 11:48:06'),
(8, 6, 1, 276794782, 'Sarita', 1122334455, 'cash', '2019-12-25 11:48:06'),
(9, 6, 2, 744608164, 'Babu Pandey', 123458962, 'card', '2019-12-25 12:07:50'),
(10, 2, 2, 744608164, 'Babu Pandey', 123458962, 'card', '2019-12-25 12:07:50'),
(11, 7, 1, 139640585, 'John', 45632147892, 'cash', '2019-12-25 14:54:24'),
(12, 5, 1, 139640585, 'John', 45632147892, 'cash', '2019-12-25 14:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `CompanyName` varchar(150) DEFAULT NULL,
  `ProductName` varchar(150) DEFAULT NULL,
  `ProductPrice` decimal(10,0) DEFAULT current_timestamp(),
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `CategoryName`, `CompanyName`, `ProductName`, `ProductPrice`, `PostingDate`, `UpdationDate`) VALUES
(1, 'Milk', 'Amul', 'Toned milk 500ml', 22, '2019-12-25 05:22:37', '2019-12-25 05:22:37'),
(2, 'Milk', 'Amul', 'Toned milk 1ltr', 42, '2019-12-25 04:25:20', NULL),
(3, 'Milk', 'Mother Diary', 'Full Cream Milk 500ml', 26, '2019-12-25 06:42:24', '2019-12-25 06:42:24'),
(4, 'Milk', 'Mother Diary', 'Full Cream Milk 1ltr', 50, '2019-12-25 06:42:39', '2019-12-25 06:42:39'),
(5, 'Butter', 'Amul', 'Butter 100mg', 46, '2019-12-25 11:42:56', '2019-12-25 11:42:56'),
(6, 'Bread', 'Patanjali', 'Sandwich Bread', 30, '2019-12-25 11:40:10', NULL),
(7, 'Ghee', 'Paras', 'Ghee 500mg', 350, '2019-12-25 14:53:33', '2019-12-25 14:53:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulls`
--
ALTER TABLE `bulls`
  ADD PRIMARY KEY (`Bull_ID`);

--
-- Indexes for table `cows`
--
ALTER TABLE `cows`
  ADD PRIMARY KEY (`Cow_ID`),
  ADD UNIQUE KEY `Tag_Code` (`Tag_Code`);

--
-- Indexes for table `FeedManagement`
--
ALTER TABLE `FeedManagement`
  ADD PRIMARY KEY (`Feed_ID`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcompany`
--
ALTER TABLE `tblcompany`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblfertility_managers`
--
ALTER TABLE `tblfertility_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblhealth_managers`
--
ALTER TABLE `tblhealth_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblherd_managers`
--
ALTER TABLE `tblherd_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmilk_weight_managers`
--
ALTER TABLE `tblmilk_weight_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulls`
--
ALTER TABLE `bulls`
  MODIFY `Bull_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cows`
--
ALTER TABLE `cows`
  MODIFY `Cow_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `FeedManagement`
--
ALTER TABLE `FeedManagement`
  MODIFY `Feed_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblcompany`
--
ALTER TABLE `tblcompany`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblfertility_managers`
--
ALTER TABLE `tblfertility_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblhealth_managers`
--
ALTER TABLE `tblhealth_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblherd_managers`
--
ALTER TABLE `tblherd_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblmilk_weight_managers`
--
ALTER TABLE `tblmilk_weight_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;