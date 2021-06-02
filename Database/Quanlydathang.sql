-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 09:28 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlydathang`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllOrderDetail` (IN `id_order` INT)  BEGIN
    SELECT SODONDH,MSHH,SOLUONG,GIADATHANG,GIAMGIA
    FROM CHITIETDATHANG
    WHERE SODONDH = id_order;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOrderViaCustomer` (IN `id_customer` INT)  BEGIN
    SELECT SODONDH,MSKH,MSNV,NGAYDH,NGAYGH,TRANGTHAI FROM DATHANG
    WHERE MSKH = id_customer;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_sold_merchandise` (`merchandise_id` INT) RETURNS INT(11) BEGIN
	DECLARE amount int ;
    SET amount := 
    (
        SELECT SUM(SOLUONG) 
        FROM chitietdathang 
        where MSHH = merchandise_id
        GROUP BY MSHH
    );
    IF amount IS NULL THEN
    	RETURN 0;
    ELSE
    	return amount;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `isValidAmountOfProduct` (`id` INT, `amount` INT) RETURNS TINYINT(1) begin
	declare amountOfProduct INT;
    set amountOfProduct := (SELECT SOLUONGHANG FROM HANGHOA WHERE MSHH = id);
    if amount > amountOfProduct then
        return 0;
    else 
        return 1;
    end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `STAFF_LOGIN` (`id` INT) RETURNS TINYINT(1) begin
  declare valid tinyint(1);
  set valid := (SELECT COUNT(MSNV) FROM NHANVIEN WHERE MSNV = id);
  return valid;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SODONDH` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `SOLUONG` int(11) NOT NULL,
  `GIADATHANG` int(11) NOT NULL,
  `GIAMGIA` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitietdathang`
--

INSERT INTO `chitietdathang` (`SODONDH`, `MSHH`, `SOLUONG`, `GIADATHANG`, `GIAMGIA`) VALUES
(31, 33, 1, 79400, 0),
(31, 40, 2, 198000, 0),
(32, 38, 3, 191400, 0),
(32, 45, 1, 30899000, 0),
(32, 53, 1, 8990000, 0),
(32, 56, 1, 3489000, 0),
(33, 48, 1, 68000, 0),
(34, 42, 1, 149000, 0),
(35, 44, 1, 198000, 0),
(36, 38, 1, 63800, 0),
(37, 32, 3, 558900, 0),
(38, 35, 3, 120000, 0),
(39, 32, 1, 186300, 0),
(39, 38, 2, 127600, 0),
(40, 35, 1, 40000, 0),
(40, 39, 1, 150000, 0);

--
-- Triggers `chitietdathang`
--
DELIMITER $$
CREATE TRIGGER `minusAmountProductWhenPurChase` AFTER INSERT ON `chitietdathang` FOR EACH ROW BEGIN
    DECLARE amount INT;
    UPDATE HANGHOA SET SOLUONGHANG = (SOLUONGHANG - NEW.SOLUONG) 
        WHERE NEW.MSHH = MSHH;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dathang`
--

CREATE TABLE `dathang` (
  `SODONDH` int(11) NOT NULL,
  `MSKH` int(11) NOT NULL,
  `MSNV` int(11) DEFAULT NULL,
  `NGAYDH` date NOT NULL,
  `NGAYGH` date DEFAULT NULL,
  `TRANGTHAI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dathang`
--

INSERT INTO `dathang` (`SODONDH`, `MSKH`, `MSNV`, `NGAYDH`, `NGAYGH`, `TRANGTHAI`) VALUES
(31, 4, NULL, '2021-05-29', NULL, 'processing'),
(32, 4, NULL, '2021-05-29', NULL, 'processing'),
(33, 14, NULL, '2021-05-29', NULL, 'processing'),
(34, 16, NULL, '2021-05-30', NULL, 'processing'),
(35, 5, NULL, '2021-05-30', NULL, 'processing'),
(36, 5, NULL, '2021-05-30', NULL, 'processing'),
(37, 4, NULL, '2021-05-30', NULL, 'processing'),
(38, 7, NULL, '2021-05-30', NULL, 'processing'),
(39, 25, NULL, '2021-06-01', NULL, 'processing'),
(40, 25, NULL, '2021-06-02', NULL, 'processing');

-- --------------------------------------------------------

--
-- Table structure for table `diachikh`
--

CREATE TABLE `diachikh` (
  `MADC` int(11) NOT NULL,
  `DIACHI` varchar(150) NOT NULL,
  `MSKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diachikh`
--

INSERT INTO `diachikh` (`MADC`, `DIACHI`, `MSKH`) VALUES
(5, 'Nghệ An bắc ninh', 4),
(11, 'Long An', 14),
(12, 'test', 4),
(13, 'abc', 15),
(14, 'afdfsdfsdfsdfsdfsdfdsf', 16),
(15, 'haksdfsdfsdfdsfsdf', 17),
(16, 'Long An', 18),
(17, 'Cần Thơ', 19),
(18, 'wwww', 20),
(19, 'ssss', 21),
(20, 'sdsdasdsdas', 22),
(21, 'cần thơ', 23),
(22, 'dddd', 24),
(23, 'Long An', 5),
(24, 'kien giang', 7),
(26, 'bến tre', 25);

-- --------------------------------------------------------

--
-- Table structure for table `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(11) NOT NULL,
  `TENHH` varchar(50) NOT NULL,
  `LOCATION` varchar(200) NOT NULL,
  `QUYCACH` varchar(50) NOT NULL,
  `GIA` int(11) NOT NULL,
  `SOLUONGHANG` int(11) NOT NULL,
  `MALOAIHANG` int(11) NOT NULL,
  `GHICHU` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TENHH`, `LOCATION`, `QUYCACH`, `GIA`, `SOLUONGHANG`, `MALOAIHANG`, `GHICHU`) VALUES
(30, 'Thay Đổi Cuộc Sống Với Nhân Số Học', '/ShopPlus_Customer/assets/images/products/56b303e000cb42faada663569fc5d7c9.jpg', 'quyển', 156000, 6, 1, ''),
(31, 'Mình Chỉ Là Người Bình Thường (Sách Tô Màu)', '/ShopPlus_Customer/assets/images/products/604b1691c5c135a711e6ed01f3e5a290.jpg', 'quyển', 96100, 3, 1, ''),
(32, 'Muôn Kiếp Nhân Sinh 2', '/ShopPlus_Customer/assets/images/products/04ffa4c4673af50ef2e594bf8e4f6fa1.jpg', 'quyển', 186300, 5, 1, ''),
(33, 'Cây Cam Ngọt Của Tôi', '/ShopPlus_Customer/assets/images/products/2a6154ba08df6ce6161c13f4303fa19e.jpg', 'quyển', 79400, 0, 1, ''),
(34, 'Kiếp Nào Ta Cũng Tìm Thấy Nhau', '/ShopPlus_Customer/assets/images/products/67db9bf2590d75f978e68f9dcfe0db9a.jpg', 'quyển', 72250, -2, 1, ''),
(35, 'Từ Điển Tiếng “Em”', '/ShopPlus_Customer/assets/images/products/14338e7ae795f56d66996b611070b173.jpg', 'quyển', 40000, 1, 1, ''),
(36, 'Sách Tài Chính Cá Nhân Cho Người Việt Nam - Tặng K', '/ShopPlus_Customer/assets/images/products/2d35f5288ea643e3768c8f3361cafa5a.jpg', 'quyển', 200000, 6, 1, ''),
(37, 'Kẻ Trộm Sách (Tái Bản)', '/ShopPlus_Customer/assets/images/products/ke-trom-sach.u5387.d20170720.t153804.332048.jpg', 'quyển', 180000, 3, 1, ''),
(38, 'Cân Bằng Cảm Xúc, Cả Lúc Bão Giông', '/ShopPlus_Customer/assets/images/products/a19424cfe9d113c32732d93cf2d5f59a.jpg', 'quyển', 63800, 2, 1, ''),
(39, 'CẨM NANG MUA BÁN ĐẤT', '/ShopPlus_Customer/assets/images/products/f797420579b8e0f5c84a1278d23053ec.jpg', 'quyển', 150000, 0, 1, ''),
(40, 'USB Kingston DT100G3 32GB USB 3.0 - Hàng Chính Hãn', '/ShopPlus_Customer/assets/images/products/34e6ca6587338ccf18f312d7b9b2ea3c.jpg', 'cái', 99000, 1, 2, ''),
(41, 'Router Wifi Băng Tần Kép AC1200 TP-Link Archer C50', '/ShopPlus_Customer/assets/images/products/archer-c50-v3_s_01.u4064.d20170704.t180940.358348.jpg', 'cái', 427000, -4, 2, ''),
(42, 'USB Kingston DT100G3 - 64GB - USB 3.0 - Hàng Chính', '/ShopPlus_Customer/assets/images/products/64_1.jpg', 'cái', 149000, 1, 2, ''),
(43, 'Ổ Cứng Di Động WD Elements 1TB 2.5 USB 3.0 - WDBUZ', '/ShopPlus_Customer/assets/images/products/wd elements 1tb - 2.5 usb 3.0_1.u579.d20160808.t172730.328870.jpg', 'cái', 1395000, 5, 2, ''),
(44, 'Bộ Kích Sóng Wifi Repeater 300Mbps Totolink EX200 ', '/ShopPlus_Customer/assets/images/products/30d0c22525743d5a2e850e76dd52fe72.jpg', 'cái', 198000, 9, 2, ''),
(45, 'Apple Macbook Pro 2020 M1 - 13 Inchs (Apple M1/ 8G', '/ShopPlus_Customer/assets/images/products/33d72e8efc6ef58d5fbe0cb1770c797e.jpg', 'cái', 30899000, 8, 2, ''),
(46, 'Màn Hình Dell U2419H 24inch FullHD 8ms 60Hz IPS - ', '/ShopPlus_Customer/assets/images/products/c220e39d6100924a66679bfb346b7544.jpg', 'cái', 5090000, 8, 2, ''),
(47, 'Phần Mềm Diệt Virus BKAV Profressional 12 Tháng - ', '/ShopPlus_Customer/assets/images/products/f20ea1736b20a4ce9138382e51bbf75e.jpg', 'cái', 190000, 9, 2, ''),
(48, 'Chuột Có Dây Logitech B100 - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/a9c21fbe61ce96d66c06582a49791381.jpg', 'cái', 68000, 5, 2, ''),
(49, 'Ổ Cứng SSD Kingston A400 (240GB) - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/9df3937c390fcc0b66161f4dbe783757.jpg', 'cái', 815000, 3, 2, ''),
(50, 'Điện Thoại Samsung Galaxy A51 (6GB/128GB) - Hàng C', '/ShopPlus_Customer/assets/images/products/3d5f9878e277d1244fe6b582e074e777.jpg', 'cái', 5850000, 3, 4, ''),
(51, 'Máy Tính Bảng Samsung Galaxy Tab S7 Wifi T870 (6GB', '/ShopPlus_Customer/assets/images/products/111e4d1c36ec7094cbfb9ea5e0334992.jpg', 'cái', 14249100, 10, 4, ''),
(52, 'Điện Thoại Oppo A12 (3GB/32GB) - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/e9dc08e1a4e6eb6439442b2df5150aeb.jpg', 'cái', 2390000, 3, 4, ''),
(53, 'Điện Thoại Samsung Galaxy A52 (8GB/128GB) - Hàng C', '/ShopPlus_Customer/assets/images/products/10f12e9c3eef374bf72b385f1b70124c.jpg', 'cái', 8990000, 7, 4, ''),
(54, 'Máy Tính Bảng Samsung Galaxy Tab S7 Wifi T870 (6GB', '/ShopPlus_Customer/assets/images/products/dc0d6dcd10f4a31d5f6dcab75566637e.jpg', 'cái', 14249100, 1, 4, ''),
(55, 'Điện Thoại Realme C11 (2GB/32GB) - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/b9f3e343440b02c54f95a9034990e0d5.jpg', 'cái', 2120000, 8, 4, ''),
(56, 'Điện Thoại Vsmart Live 4 (6GB/64GB) - Hàng Chính H', '/ShopPlus_Customer/assets/images/products/3360d9dcb541dd5d2aaa59ae0ad6b1c5.jpg', 'cái', 3489000, 4, 4, ''),
(57, 'Điện Thoại Nokia 3.4 - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/0ddf107a81ccf15f9e2d27ba67e25d6b.jpg', 'cái', 2590000, 7, 4, ''),
(58, 'Điện Thoại Samsung Galaxy M31 (6GB/128GB) - Hàng C', '/ShopPlus_Customer/assets/images/products/0df5a90d7bd5d327de2d25d510dd9b65.jpg', 'cái', 4790000, 3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(11) NOT NULL,
  `HOTENKH` varchar(50) NOT NULL,
  `TENCONGTY` varchar(50) DEFAULT NULL,
  `SODIENTHOAI` varchar(11) NOT NULL,
  `EMAIL` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HOTENKH`, `TENCONGTY`, `SODIENTHOAI`, `EMAIL`) VALUES
(4, 'Nguyễn Hoàng Linh', 'Công Ty Phần Mềm Hoàng Linh Plus', '0849105289', 'dev777@gmail.com'),
(5, 'Hoang Linh Nguyen', 'upl', '0123456789', 'linh072217@gmail.com'),
(7, 'Võ Thị Ngọc Thư', 'thư july', '01234233333', 'vongocthu0719@gmail.com'),
(8, 'àdsdfsdf', '', '0258795478', 'abc123@gmail.com'),
(9, 'Nguyễn Hoàng Linh', '', '0123456784', 'linhb1809143@student.ctu.edu.vn'),
(11, 'Hoang Linh Nguyen', '', '0123456589', 'fsdf@gmail.com'),
(12, 'MAI HỮU BẰNG', '', '08574258964', 'bangb1803891@student.ctu.edu.vn'),
(13, 'quốc huy', '', '0192938347', 'quochuy@gmail.com'),
(14, 'Huỳnh Thị Diệu', 'công ty diệu hiền', '08765478382', 'dieu123@gmail.com'),
(15, 'okay', '', '07846283913', 'okay@gmail.com'),
(16, 'Nguyễn Hoàng Linh', '22333', '01257589424', 'okay1@gmail.com'),
(17, 'MAI HỮU BẰNG', '22333', '0125758942', 'dev7717@gmail.com'),
(18, 'Nguyễn Hoàng Linh', '', '0123456789', 'linhb18092143@student.ctu.edu.vn'),
(19, 'Hoang Linh Nguyen', 'Công Ty Phần Mềm Hoàng Linh Plus . CF', '0123456789', 'dev75577@gmail.com'),
(20, 'Hoang Linh Nguyen', '', '0123456789', 'dev777wwww@gmail.com'),
(21, 'Hoang Linh Nguyen', 'ssss', '0123456789', 'linh0722www17@gmail.com'),
(22, 'Nguyễn Hoàng Linh', '', '0125758942', 'lin3h072217@gmail.com'),
(23, 'Hoang Linh Nguyen', '', '0123456789', 'linh0782217@gmail.com'),
(24, 'MAI HỮU BẰNG', 'ddd', '0123456789', 'linhb18e3309143@student.ctu.edu.vn'),
(25, 'nguyen ngoc dinh', '', '03434567890', 'dinh@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `loaihanghoa`
--

CREATE TABLE `loaihanghoa` (
  `MALOAIHANG` int(11) NOT NULL,
  `TENLOAIHANG` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaihanghoa`
--

INSERT INTO `loaihanghoa` (`MALOAIHANG`, `TENLOAIHANG`) VALUES
(1, 'Sách '),
(2, 'Máy Tính'),
(3, 'Thể Thao'),
(4, 'Điện Thoại'),
(5, 'Thực Phẩm'),
(6, 'Thời Trang'),
(7, 'Laptop');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(11) NOT NULL,
  `HOTENNV` varchar(50) NOT NULL,
  `CHUCVU` varchar(30) NOT NULL,
  `DIACHI` varchar(200) NOT NULL,
  `SODIENTHOAI` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HOTENNV`, `CHUCVU`, `DIACHI`, `SODIENTHOAI`) VALUES
(777, 'Nguyễn Hoàng Linh', 'Quản Lý ', 'Kiên Giang', '0123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SODONDH`,`MSHH`),
  ADD KEY `FK_CHITIETDATHANG_HANGHOA` (`MSHH`);

--
-- Indexes for table `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SODONDH`),
  ADD KEY `FK_DATHANG_KHACHHANG` (`MSKH`),
  ADD KEY `FK_DATHANG_NHANVIEN` (`MSNV`);

--
-- Indexes for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD PRIMARY KEY (`MADC`),
  ADD KEY `FK_DIACHIKH_KHACHHANG` (`MSKH`);

--
-- Indexes for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD KEY `FK_HOANGHOA_LOAIHANGHOA` (`MALOAIHANG`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`),
  ADD UNIQUE KEY `U_KHACHHANG_EMAIL` (`EMAIL`);

--
-- Indexes for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  ADD PRIMARY KEY (`MALOAIHANG`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dathang`
--
ALTER TABLE `dathang`
  MODIFY `SODONDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `diachikh`
--
ALTER TABLE `diachikh`
  MODIFY `MADC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  MODIFY `MALOAIHANG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MSNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=778;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `FK_CHITIETDATHANG_DATHANG` FOREIGN KEY (`SODONDH`) REFERENCES `dathang` (`SODONDH`),
  ADD CONSTRAINT `FK_CHITIETDATHANG_HANGHOA` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Constraints for table `dathang`
--
ALTER TABLE `dathang`
  ADD CONSTRAINT `FK_DATHANG_KHACHHANG` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`),
  ADD CONSTRAINT `FK_DATHANG_NHANVIEN` FOREIGN KEY (`MSNV`) REFERENCES `nhanvien` (`MSNV`);

--
-- Constraints for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD CONSTRAINT `FK_DIACHIKH_KHACHHANG` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`);

--
-- Constraints for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `FK_HOANGHOA_LOAIHANGHOA` FOREIGN KEY (`MALOAIHANG`) REFERENCES `loaihanghoa` (`MALOAIHANG`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
