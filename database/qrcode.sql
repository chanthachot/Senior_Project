-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2021 at 02:59 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `bird`
--

CREATE TABLE `bird` (
  `id` int(5) NOT NULL,
  `bird_id` int(5) NOT NULL,
  `bird_name` varchar(500) NOT NULL,
  `bird_family_name` varchar(500) NOT NULL,
  `bird_lat` varchar(500) NOT NULL,
  `bird_lng` varchar(500) NOT NULL,
  `bird_sciname` varchar(500) NOT NULL,
  `bird_description` mediumtext NOT NULL,
  `bird_pic` varchar(1000) NOT NULL,
  `point_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bird`
--

INSERT INTO `bird` (`id`, `bird_id`, `bird_name`, `bird_family_name`, `bird_lat`, `bird_lng`, `bird_sciname`, `bird_description`, `bird_pic`, `point_id`) VALUES
(1, 1, 'นกเป็ดแดง', 'วงศ์เป็ดและห่าน : Duck, Geese & Swans', '16.475743260350225', '102.82329804496938', 'Dendrocygna javanica', 'ลำตัวทั่วไปสีน้ำตาลแกมเหลือง กระหม่อม ท้ายทอย และหลังสีน้ำตาลเข้ม ขนคลุมไหล่และหางสีน้ำตาลแดง ขนปลายปีกเทาดำ ปากและขาดำ ขณะบินต่างจากนกเป็ดน้ำชนิดอื่นที่หัวและคออยู่ในระดับต่ำกว่าลำตัวเล็กน้อย ปีกกว้างและกลมกว่านกเป็ดน้ำอื่น ๆ บินตรง กระพือปีกไม่เร็วมาก', 'Lesser Whistling-duck.jpg', 2),
(2, 2, 'นกเป็ดคับแค', 'วงศ์เป็ดและห่าน : Duck, Geese & Swans', '16.475753548658833', '102.82306201057607', 'Nettapus coromandelianus', 'ปากและแข้งสีดำ ตัวผู้ : หัวและลำตัวสีขาว กระหม่อมสีดำ มีเส้นรอบคอสีดำเหลือบเขียว หลังสีดำเหลือบเขียว ข้างลำตัวสีเทา ท้องสีขาว ขณะบินเห็นแถบขาวขนาดใหญ่พาดตลอดปีก, ตัวเมีย : แถบคาดตาสีน้ำตาลเข้ม หัว คอ และลำตัวด้านล่างสีเนื้อ กระหม่อมสีน้ำตาลเข้ม อกมีลายประสีน้ำตาลกระจาย ขณะบินปีกดำมีขอบจากปลายขนกลางปีกสีขาว', 'Cotton Pygmy-goose.jpg', 2),
(3, 3, 'นกเป็ดลาย', 'วงศ์เป็ดและห่าน : Duck, Geese & Swans', '16.47540374586012', '102.82379157142812', 'Anas querquedula', 'ปากสีเทาดำ ตัวผู้ : หัวสีน้ำตาลเข้ม คิ้วยาวหนา ไหล่และหลังมีขนยาวสีขาวสลับดำ ข้างลำตัวสีเทา ท้องขาว ขณะบินแถบปีกสีเขียวและขาว, ตัวเมีย : ลำตัวเป็นลายสีน้ำตาล ใบหน้ามีแถบสีน้ำตาลเข้มสองแถบ แถบปีกสีน้ำตาลเข้ม', 'Garganey.jpg', 2),
(6, 28, 'เหยี่ยวออสเปร', 'วงศ์เหยี่ยวออสเปธ : Ospreys', '16.475506629101766', '102.8236628253954', 'Pandion haliaetus', 'ตัวผู้ : ท้ายทอยมีหงอนสั้น ๆ หัวและลำตัวด้านล่างขาวตัดกับแถบตาและลำตัวด้านบนน้ำตาลเข้ม แถบคาดอกสีน้ำตาล ขณะบินปีกเรียวและยาวมาก ขนคลุมใต้ปีกขาว หัวปีกมีแถบดำใหญ่ ปลายปีกดำ หางบั้งถี่สีเข้ม, ตัวเมีย : แถบคาดอกกว้างกว่า, นกวัยอ่อน : แถบคาดอกไม่ชัดเจน ลำตัวด้านบนน้ำตาลมีลายจากขอบขนสีอ่อน', 'Western Osprey.jpg', 2),
(7, 10, 'นกปากห่าง', 'วงศ์นกกระสาและนกตะกรุม : Storks', '16.475537494063616', '102.82372719841176', 'Anastomus oscitans', 'ปากสีน้ำตาลแกมเหลือง กลางปากค่อนไปทางปลายเปิดเป็นช่องว่าง ขนลำตัวเทา ขนโคนปีก ขนปีกบิน และหางดำ แข้งและตีนชมพูคล้ำ ขนชุดผสมพันธุ์ : ขนลำตัวขาวมากขึ้น แข้งและตีนแดง', 'Asian Openbill.jpg', 2),
(8, 63, 'นกโป่งวิด', 'วงศ์นกโป่งวิด : Painted Snipes', '16.47569181879906', '102.82373792724782', 'Rostratula benghalensis', 'ตัวผู้  : คล้ายนกปากซ่อม แต่ปากสั้นกว่าปลายโค้งลง แถบกลางหัว แถบตา และหนังรอบตาสีน้ำตาลเหลือง หัว อก และหลังน้ำตาลเข้มแกมเทา ปีกและลำตัวด้านบนมีลายสีน้ำตาลสลับน้ำตาลเข้ม ลำตัวด้านล่างขาว, ตัวเมีย : แถบกลางหัวน้ำตาลเหลือง หัวตอนบนดำตัดกับแถบตาและวงรอบขาว หัว คอ อก และหลังตอนบนน้ำตาลแดงแกมเลือดหมู อกด้านล่างมีแถบดำต่อเนื่องกับลำตัวด้านล่างสีขาว ปีกน้ำตาลเข้ม', 'Greater Painted-snipe.jpg', 2),
(9, 130, 'นกแต้วแล้วอกเขียว', 'วงศ์นกแต้วแล้ว : Pittas', '16.475763836966877', '102.82329804496938', 'Pitta sordida', 'ตัวผู้และตัวเมียเหมือนกันมาก มีหน้าผาก กระหม่อม ท้ายทอยเป็นสีน้ำตาลเข้ม หน้าจนถึงคอเป็นสีดำ ปากหนาสีดำ ลำตัวเป็นสีเขียวกลมกลืนกับสภาพป่า ขนคลุมท้องดำต่อด้วยสีแดงถึงก้น ขนคลุมโคนหางด้านบนและตะโพกสีฟ้าสดใสเป็นมัน ขนหางสั้น ขาและนิ้วเท้ายาว นกชนิดนี้เป็นนกที่หวงอาณาเขตมาก ไม่ว่าจะเป็นช่วงฤดูผสมพันธุ์หรือไม่ นอกฤดูผสมพันธุ์', 'Hooded Pitta.jpg', 2),
(10, 9, 'นกเป็ดผีเล็ก', 'วงศ์นกเป็ดผี : Grebes', '16.486299860539134', '102.81635776322939', 'Tachybaptus ruficollis', 'คล้ายนกเป็ดน้ำหางสั้นกุด ปากแหลมสีเหลืองอ่อน หน้าผาก ท้ายทอยถึงหลังน้ำตาลเข้ม หน้า ข้างคอ อก และท้องน้ำตาลแกมเหลือง  ขนชุดผสมพันธุ์ : หน้า ข้างคอน้ำตาลแดงเข้ม สีข้างน้ำตาลเข้ม ปากดำ โคนปากเหลือง ตาเหลือง', 'Little Grebe.jpg', 19);

-- --------------------------------------------------------

--
-- Table structure for table `path`
--

CREATE TABLE `path` (
  `path_id` int(11) NOT NULL,
  `path_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `path`
--

INSERT INTO `path` (`path_id`, `path_name`) VALUES
(26, 'คณะวิทยาศาสตร์');

-- --------------------------------------------------------

--
-- Table structure for table `point`
--

CREATE TABLE `point` (
  `point_id` int(5) NOT NULL,
  `point_name` varchar(500) NOT NULL,
  `point_lat` varchar(500) NOT NULL,
  `point_lng` varchar(500) NOT NULL,
  `path_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `point`
--

INSERT INTO `point` (`point_id`, `point_name`, `point_lat`, `point_lng`, `path_id`) VALUES
(2, 'อาคาร SC08 คณะวิทย์', '16.475753548658833', '102.82306201057607', 26),
(14, 'SC03', '16.476424398946122', '102.82524246494825', 26),
(19, 'future 2', '16.486239101505387', '102.81560366801783', 26);

-- --------------------------------------------------------

--
-- Table structure for table `qrcode`
--

CREATE TABLE `qrcode` (
  `qrcode_id` int(5) NOT NULL,
  `qrcode_bird_name` longtext NOT NULL,
  `qrcode_bird_lat` longtext NOT NULL,
  `qrcode_bird_lng` longtext NOT NULL,
  `qrcode_bird_sciname` longtext NOT NULL,
  `qrcode_bird_description` mediumtext NOT NULL,
  `qrcode_bird_pic` longtext NOT NULL,
  `qrcode_image` longtext NOT NULL,
  `qrcode_timestamp` varchar(100) NOT NULL,
  `point_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `qrcode`
--

INSERT INTO `qrcode` (`qrcode_id`, `qrcode_bird_name`, `qrcode_bird_lat`, `qrcode_bird_lng`, `qrcode_bird_sciname`, `qrcode_bird_description`, `qrcode_bird_pic`, `qrcode_image`, `qrcode_timestamp`, `point_id`) VALUES
(33, 'นกเป็ดผีเล็ก/', '16.486299860539134/', '102.81635776322939/', 'Tachybaptus ruficollis/', 'คล้ายนกเป็ดน้ำหางสั้นกุด ปากแหลมสีเหลืองอ่อน หน้าผาก ท้ายทอยถึงหลังน้ำตาลเข้ม หน้า ข้างคอ อก และท้องน้ำตาลแกมเหลือง  ขนชุดผสมพันธุ์ : หน้า ข้างคอน้ำตาลแดงเข้ม สีข้างน้ำตาลเข้ม ปากดำ โคนปากเหลือง ตาเหลือง/', 'Little Grebe.jpg/', 'a316f2f618f5e3422199f0ba1ac1fc2b.png', '22-04-2021 - 03:26', 19),
(39, 'นกเป็ดแดง/นกเป็ดคับแค/นกเป็ดลาย/เหยี่ยวออสเปร/นกปากห่าง/นกโป่งวิด/นกแต้วแล้วอกเขียว/', '16.475743260350225/16.475753548658833/16.47540374586012/16.475506629101766/16.475537494063616/16.47569181879906/16.475763836966877/', '102.82329804496938/102.82306201057607/102.82379157142812/102.8236628253954/102.82372719841176/102.82373792724782/102.82329804496938/', 'Dendrocygna javanica/Nettapus coromandelianus/Anas querquedula/Pandion haliaetus/Anastomus oscitans/Rostratula benghalensis/Pitta sordida/', 'ลำตัวทั่วไปสีน้ำตาลแกมเหลือง กระหม่อม ท้ายทอย และหลังสีน้ำตาลเข้ม ขนคลุมไหล่และหางสีน้ำตาลแดง ขนปลายปีกเทาดำ ปากและขาดำ ขณะบินต่างจากนกเป็ดน้ำชนิดอื่นที่หัวและคออยู่ในระดับต่ำกว่าลำตัวเล็กน้อย ปีกกว้างและกลมกว่านกเป็ดน้ำอื่น ๆ บินตรง กระพือปีกไม่เร็วมาก/ปากและแข้งสีดำ ตัวผู้ : หัวและลำตัวสีขาว กระหม่อมสีดำ มีเส้นรอบคอสีดำเหลือบเขียว หลังสีดำเหลือบเขียว ข้างลำตัวสีเทา ท้องสีขาว ขณะบินเห็นแถบขาวขนาดใหญ่พาดตลอดปีก, ตัวเมีย : แถบคาดตาสีน้ำตาลเข้ม หัว คอ และลำตัวด้านล่างสีเนื้อ กระหม่อมสีน้ำตาลเข้ม อกมีลายประสีน้ำตาลกระจาย ขณะบินปีกดำมีขอบจากปลายขนกลางปีกสีขาว/ปากสีเทาดำ ตัวผู้ : หัวสีน้ำตาลเข้ม คิ้วยาวหนา ไหล่และหลังมีขนยาวสีขาวสลับดำ ข้างลำตัวสีเทา ท้องขาว ขณะบินแถบปีกสีเขียวและขาว, ตัวเมีย : ลำตัวเป็นลายสีน้ำตาล ใบหน้ามีแถบสีน้ำตาลเข้มสองแถบ แถบปีกสีน้ำตาลเข้ม/ตัวผู้ : ท้ายทอยมีหงอนสั้น ๆ หัวและลำตัวด้านล่างขาวตัดกับแถบตาและลำตัวด้านบนน้ำตาลเข้ม แถบคาดอกสีน้ำตาล ขณะบินปีกเรียวและยาวมาก ขนคลุมใต้ปีกขาว หัวปีกมีแถบดำใหญ่ ปลายปีกดำ หางบั้งถี่สีเข้ม, ตัวเมีย : แถบคาดอกกว้างกว่า, นกวัยอ่อน : แถบคาดอกไม่ชัดเจน ลำตัวด้านบนน้ำตาลมีลายจากขอบขนสีอ่อน/ปากสีน้ำตาลแกมเหลือง กลางปากค่อนไปทางปลายเปิดเป็นช่องว่าง ขนลำตัวเทา ขนโคนปีก ขนปีกบิน และหางดำ แข้งและตีนชมพูคล้ำ ขนชุดผสมพันธุ์ : ขนลำตัวขาวมากขึ้น แข้งและตีนแดง/ตัวผู้  : คล้ายนกปากซ่อม แต่ปากสั้นกว่าปลายโค้งลง แถบกลางหัว แถบตา และหนังรอบตาสีน้ำตาลเหลือง หัว อก และหลังน้ำตาลเข้มแกมเทา ปีกและลำตัวด้านบนมีลายสีน้ำตาลสลับน้ำตาลเข้ม ลำตัวด้านล่างขาว, ตัวเมีย : แถบกลางหัวน้ำตาลเหลือง หัวตอนบนดำตัดกับแถบตาและวงรอบขาว หัว คอ อก และหลังตอนบนน้ำตาลแดงแกมเลือดหมู อกด้านล่างมีแถบดำต่อเนื่องกับลำตัวด้านล่างสีขาว ปีกน้ำตาลเข้ม/ตัวผู้และตัวเมียเหมือนกันมาก มีหน้าผาก กระหม่อม ท้ายทอยเป็นสีน้ำตาลเข้ม หน้าจนถึงคอเป็นสีดำ ปากหนาสีดำ ลำตัวเป็นสีเขียวกลมกลืนกับสภาพป่า ขนคลุมท้องดำต่อด้วยสีแดงถึงก้น ขนคลุมโคนหางด้านบนและตะโพกสีฟ้าสดใสเป็นมัน ขนหางสั้น ขาและนิ้วเท้ายาว นกชนิดนี้เป็นนกที่หวงอาณาเขตมาก ไม่ว่าจะเป็นช่วงฤดูผสมพันธุ์หรือไม่ นอกฤดูผสมพันธุ์/', 'Lesser Whistling-duck.jpg/Cotton Pygmy-goose.jpg/Garganey.jpg/Western Osprey.jpg/Asian Openbill.jpg/Greater Painted-snipe.jpg/Hooded Pitta.jpg/', '138cc4538794b31f0d753e5281f6fc65.png', '23-04-2021 - 06:52', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(3) NOT NULL,
  `username` varchar(13) NOT NULL,
  `password` varchar(10) NOT NULL,
  `type_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `type_id`) VALUES
(1, 'admin', '123456', 1),
(8, 'admin2', '1234', 2),
(11, 'aaa', 'aaa', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(1) NOT NULL,
  `type_name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `type_name`) VALUES
(1, 'Super Admin'),
(2, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bird`
--
ALTER TABLE `bird`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `path`
--
ALTER TABLE `path`
  ADD PRIMARY KEY (`path_id`);

--
-- Indexes for table `point`
--
ALTER TABLE `point`
  ADD PRIMARY KEY (`point_id`);

--
-- Indexes for table `qrcode`
--
ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`qrcode_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bird`
--
ALTER TABLE `bird`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `path`
--
ALTER TABLE `path`
  MODIFY `path_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `point`
--
ALTER TABLE `point`
  MODIFY `point_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `qrcode`
--
ALTER TABLE `qrcode`
  MODIFY `qrcode_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
