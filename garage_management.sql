-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2023 at 06:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garage_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('9p6l9o3nivn07or6oogn6pcbgognnu4a', '127.0.0.1', 1689436425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313638393433363432353b),
('u5rrlbletm3a8qgbf8bcdeul6arihb5t', '127.0.0.1', 1689436474, 0x5f5f63695f6c6173745f726567656e65726174657c693a313638393433363432353b);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `admin_username` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้งานระบบ',
  `admin_password` varchar(100) NOT NULL COMMENT 'รหัสผ่านเข้าสู่ระบบ',
  `admin_position` varchar(10) NOT NULL COMMENT 'ตำแหน่ง \r\n- admin \r\n-employee',
  `admin_status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'สถานะ\r\n- active (ใช้งาน)\r\n- inactive (ไม่ใช้งาน)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_username`, `admin_password`, `admin_position`, `admin_status`) VALUES
(1, 'Administrator', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `cus_id` int(11) NOT NULL,
  `cus_name` varchar(100) NOT NULL COMMENT 'ชื่อลูกค้า',
  `cus_tel` varchar(30) NOT NULL COMMENT 'เบอร์โทร',
  `cus_address` text NOT NULL COMMENT 'ที่อยู่',
  `cus_tax` varchar(20) DEFAULT NULL COMMENT 'เลขประจำตัวผู้เสียภาษี',
  `license_plate` varchar(50) NOT NULL COMMENT 'ทะเบียนรถ',
  `car_brand` varchar(50) NOT NULL COMMENT 'ยี่ห้อรถ',
  `car_model` varchar(50) NOT NULL COMMENT 'รุ่นรถ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL COMMENT 'ไอดีสินค้าและบริการ',
  `product_name` varchar(100) NOT NULL COMMENT 'ชื่อสินค้าและบริการ',
  `product_price` float(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE `tbl_service` (
  `service_id` int(11) NOT NULL,
  `service_invoice` varchar(20) NOT NULL COMMENT 'เลขที่ใบส่งซ่อม',
  `cus_name` varchar(100) NOT NULL COMMENT 'ชื่อลูกค้า',
  `cus_address` text NOT NULL COMMENT 'ที่อยู่ลูกค้า',
  `cus_tel` varchar(20) NOT NULL COMMENT 'เบอร์โทร',
  `cus_tax` varchar(20) DEFAULT NULL COMMENT 'เลขประจำตัวผู้เสียภาษี',
  `license_plate` varchar(30) NOT NULL COMMENT 'เลขทะเบียนรถ',
  `car_brand` varchar(30) NOT NULL COMMENT 'ยี่ห้อรถ',
  `car_model` varchar(30) NOT NULL COMMENT 'รุ่นรถ',
  `car_mile_number` varchar(6) NOT NULL COMMENT 'เลขไมล์รถ',
  `service_start` date NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ส่งซ่อม',
  `service_end` date DEFAULT NULL COMMENT 'วันกำหนดรับ',
  `service_status` varchar(10) NOT NULL DEFAULT 'created' COMMENT 'สถานะ\r\n-created สร้างใบแจ้งซ่อม\r\n-wait รับซ่อม/ระหว่างซ่อม\r\n- fixed รอรับ\r\n- done รับรถเรียบร้อย',
  `option_vat` varchar(3) DEFAULT 'no' COMMENT '- no ไม่มี vat\r\n- in รวม vat\r\n-out ไม่รวม vat',
  `service_vat` float(11,2) NOT NULL DEFAULT 0.00 COMMENT 'ยอดภาษี',
  `service_price` float(11,2) NOT NULL DEFAULT 0.00 COMMENT 'ยอดรวม',
  `service_discount` float(11,2) NOT NULL DEFAULT 0.00 COMMENT 'ส่วนลด',
  `service_total` float(11,2) NOT NULL DEFAULT 0.00 COMMENT 'ยอดสุทธิ',
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_detail`
--

CREATE TABLE `tbl_service_detail` (
  `id` int(11) NOT NULL,
  `service_invoice` varchar(13) NOT NULL COMMENT 'เลขใบสั่งซื้อ',
  `service_name` varchar(100) NOT NULL COMMENT 'ชื่อสินค้าและบริการ',
  `detail` varchar(250) DEFAULT NULL COMMENT 'รายละเอียด',
  `amount` int(5) NOT NULL COMMENT 'จำนวน',
  `price` float(11,2) NOT NULL COMMENT 'ราคาต่อหน่วย',
  `total` float NOT NULL COMMENT 'ราคารวม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_service`
--
ALTER TABLE `tbl_service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `tbl_service_detail`
--
ALTER TABLE `tbl_service_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีสินค้าและบริการ';

--
-- AUTO_INCREMENT for table `tbl_service`
--
ALTER TABLE `tbl_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_service_detail`
--
ALTER TABLE `tbl_service_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
