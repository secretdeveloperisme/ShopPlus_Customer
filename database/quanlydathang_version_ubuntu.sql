-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 11:45 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

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
    FROM chitietdathang
    WHERE SODONDH = id_order;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOrderViaCustomer` (IN `id_customer` INT)  BEGIN
    SELECT SODONDH,MSKH,MSNV,NGAYDH,NGAYGH,TRANGTHAI FROM dathang
    WHERE MSKH = id_customer;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calculateMoneyOrder` (`id` INT) RETURNS INT(11) BEGIN
	DECLARE total INT;
    set total := (SELECT SUM(chitietdathang.GIADATHANG) from dathang 
	join chitietdathang ON dathang.SODONDH = chitietdathang.SODONDH
	where dathang.SODONDH = id);
    return total;
END$$

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
    set amountOfProduct := (SELECT SOLUONGHANG FROM hanghoa WHERE MSHH = id);
    if amount > amountOfProduct then
        return 0;
    else 
        return 1;
    end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `STAFF_LOGIN` (`id` INT) RETURNS TINYINT(1) begin
  declare valid tinyint(1);
  set valid := (SELECT COUNT(MSNV) FROM nhanvien WHERE MSNV = id);
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
-- Triggers `chitietdathang`
--
DELIMITER $$
CREATE TRIGGER `minusAmountProductWhenPurChase` AFTER INSERT ON `chitietdathang` FOR EACH ROW BEGIN
    DECLARE amount INT;
    UPDATE hanghoa SET SOLUONGHANG = (SOLUONGHANG - NEW.SOLUONG) 
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

-- --------------------------------------------------------

--
-- Table structure for table `diachikh`
--

CREATE TABLE `diachikh` (
  `MADC` int(11) NOT NULL,
  `DIACHI` varchar(150) NOT NULL,
  `MSKH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(30, 'Thay ?????i Cu???c S???ng V???i Nh??n S??? H???c', '/ShopPlus_Customer/assets/images/products/56b303e000cb42faada663569fc5d7c9.jpg', 'quy???n', 156000, 6, 1, ''),
(31, 'M??nh Ch??? L?? Ng?????i B??nh Th?????ng (S??ch T?? M??u)', '/ShopPlus_Customer/assets/images/products/604b1691c5c135a711e6ed01f3e5a290.jpg', 'quy???n', 96100, 0, 1, ''),
(32, 'Mu??n Ki???p Nh??n Sinh 2', '/ShopPlus_Customer/assets/images/products/04ffa4c4673af50ef2e594bf8e4f6fa1.jpg', 'quy???n', 186300, 1, 1, ''),
(33, 'C??y Cam Ng???t C???a T??i', '/ShopPlus_Customer/assets/images/products/2a6154ba08df6ce6161c13f4303fa19e.jpg', 'quy???n', 79400, 0, 1, ''),
(34, 'Ki???p N??o Ta C??ng T??m Th???y Nhau', '/ShopPlus_Customer/assets/images/products/67db9bf2590d75f978e68f9dcfe0db9a.jpg', 'quy???n', 72250, 3, 1, ''),
(35, 'T??? ??i???n Ti???ng ???Em???', '/ShopPlus_Customer/assets/images/products/14338e7ae795f56d66996b611070b173.jpg', 'quy???n', 40000, 0, 1, ''),
(36, 'S??ch T??i Ch??nh C?? Nh??n Cho Ng?????i Vi???t Nam - T???ng K', '/ShopPlus_Customer/assets/images/products/2d35f5288ea643e3768c8f3361cafa5a.jpg', 'quy???n', 200000, 6, 1, ''),
(37, 'K??? Tr???m S??ch (T??i B???n)', '/ShopPlus_Customer/assets/images/products/ke-trom-sach.u5387.d20170720.t153804.332048.jpg', 'quy???n', 180000, 3, 1, ''),
(38, 'C??n B???ng C???m X??c, C??? L??c B??o Gi??ng', '/ShopPlus_Customer/assets/images/products/a19424cfe9d113c32732d93cf2d5f59a.jpg', 'quy???n', 63800, 0, 1, ''),
(39, 'C???M NANG MUA B??N ?????T', '/ShopPlus_Customer/assets/images/products/f797420579b8e0f5c84a1278d23053ec.jpg', 'quy???n', 150000, 0, 1, ''),
(40, 'USB Kingston DT100G3 32GB USB 3.0 - H??ng Ch??nh H??n', '/ShopPlus_Customer/assets/images/products/34e6ca6587338ccf18f312d7b9b2ea3c.jpg', 'c??i', 99000, 1, 2, ''),
(41, 'Router Wifi B??ng T???n K??p AC1200 TP-Link Archer C50', '/ShopPlus_Customer/assets/images/products/archer-c50-v3_s_01.u4064.d20170704.t180940.358348.jpg', 'c??i', 427000, 5, 2, ''),
(42, 'USB Kingston DT100G3 - 64GB - USB 3.0 ', '/ShopPlus_Customer/assets/images/products/64_1.jpg', 'c??i', 149000, 1, 2, ''),
(43, '??? C???ng Di ?????ng WD Elements 1TB 2.5 USB 3.0 - WDBUZ', '/ShopPlus_Customer/assets/images/products/wd elements 1tb - 2.5 usb 3.0_1.u579.d20160808.t172730.328870.jpg', 'c??i', 1395000, 3, 2, ''),
(44, 'B??? K??ch S??ng Wifi Repeater 300Mbps Totolink EX200 ', '/ShopPlus_Customer/assets/images/products/30d0c22525743d5a2e850e76dd52fe72.jpg', 'c??i', 198000, 9, 2, ''),
(45, 'Apple Macbook Pro 2020 M1 - 13 Inchs (Apple M1/ 8G', '/ShopPlus_Customer/assets/images/products/33d72e8efc6ef58d5fbe0cb1770c797e.jpg', 'c??i', 30899000, 8, 2, ''),
(46, 'M??n H??nh Dell U2419H 24inch FullHD 8ms 60Hz IPS - ', '/ShopPlus_Customer/assets/images/products/c220e39d6100924a66679bfb346b7544.jpg', 'c??i', 5090000, 8, 2, ''),
(47, 'Ph???n M???m Di???t Virus BKAV Profressional 12 Th??ng - ', '/ShopPlus_Customer/assets/images/products/f20ea1736b20a4ce9138382e51bbf75e.jpg', 'c??i', 190000, 9, 2, ''),
(48, 'Chu???t C?? D??y Logitech B100 - H??ng Ch??nh H??ng', '/ShopPlus_Customer/assets/images/products/a9c21fbe61ce96d66c06582a49791381.jpg', 'c??i', 68000, 3, 2, ''),
(49, '??? C???ng SSD Kingston A400 (240GB) - H??ng Ch??nh H??ng', '/ShopPlus_Customer/assets/images/products/9df3937c390fcc0b66161f4dbe783757.jpg', 'c??i', 815000, 3, 2, ''),
(50, '??i???n Tho???i Samsung Galaxy A51 (6GB/128GB) - H??ng C', '/ShopPlus_Customer/assets/images/products/3d5f9878e277d1244fe6b582e074e777.jpg', 'c??i', 5850000, 3, 4, ''),
(51, 'M??y T??nh B???ng Samsung Galaxy Tab S7 Wifi T870 (6GB', '/ShopPlus_Customer/assets/images/products/111e4d1c36ec7094cbfb9ea5e0334992.jpg', 'c??i', 14249100, 10, 4, ''),
(52, '??i???n Tho???i Oppo A12 (3GB/32GB) - H??ng Ch??nh H??ng', '/ShopPlus_Customer/assets/images/products/e9dc08e1a4e6eb6439442b2df5150aeb.jpg', 'c??i', 2390000, 3, 4, ''),
(53, '??i???n Tho???i Samsung Galaxy A52 (8GB/128GB) - H??ng C', '/ShopPlus_Customer/assets/images/products/10f12e9c3eef374bf72b385f1b70124c.jpg', 'c??i', 8990000, 7, 4, ''),
(54, 'M??y T??nh B???ng Samsung Galaxy Tab S7 Wifi T870 (6GB', '/ShopPlus_Customer/assets/images/products/dc0d6dcd10f4a31d5f6dcab75566637e.jpg', 'c??i', 14249100, 0, 4, ''),
(55, '??i???n Tho???i Realme C11 (2GB/32GB) - H??ng Ch??nh H??ng', '/ShopPlus_Customer/assets/images/products/b9f3e343440b02c54f95a9034990e0d5.jpg', 'c??i', 2120000, 6, 4, ''),
(56, '??i???n Tho???i Vsmart Live 4 (6GB/64GB) - H??ng Ch??nh H', '/ShopPlus_Customer/assets/images/products/3360d9dcb541dd5d2aaa59ae0ad6b1c5.jpg', 'c??i', 3489000, 4, 4, ''),
(57, '??i???n Tho???i Nokia 3.4 - H??ng Ch??nh H??ng', '/ShopPlus_Customer/assets/images/products/0ddf107a81ccf15f9e2d27ba67e25d6b.jpg', 'c??i', 2590000, 7, 4, ''),
(58, '??i???n Tho???i Samsung Galaxy M31 (6GB/128GB) - H??ng C', '/ShopPlus_Customer/assets/images/products/0df5a90d7bd5d327de2d25d510dd9b65.jpg', 'c??i', 4790000, 1, 4, ''),
(63, 'jennie', '/ShopPlus_Customer/assets/images/products/jeniekim.jpg', 'c??i', 777, 7, 18, '');

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
(4, 'Nguy???n Ho??ng Linh', 'C??ng Ty Ph???n M???m Ho??ng Linh Plus', '0849105289', 'dev777@gmail.com'),
(5, 'Hoang Linh Nguyen', 'upl', '0123456789', 'linh072217@gmail.com'),
(7, 'V?? Th??? Ng???c Th??', 'th?? july', '01234233333', 'vongocthu0719@gmail.com'),
(8, '??dsdfsdf', '', '0258795478', 'abc123@gmail.com'),
(9, 'Nguy???n Ho??ng Linh', '', '0123456784', 'linhb1809143@student.ctu.edu.vn'),
(11, 'Hoang Linh Nguyen', '', '0123456589', 'fsdf@gmail.com'),
(12, 'MAI H???U B???NG', '', '08574258964', 'bangb1803891@student.ctu.edu.vn'),
(13, 'qu???c huy', '', '0192938347', 'quochuy@gmail.com'),
(14, 'Hu???nh Th??? Di???u', 'c??ng ty di???u hi???n', '08765478382', 'dieu123@gmail.com'),
(15, 'okay', '', '07846283913', 'okay@gmail.com'),
(16, 'Nguy???n Ho??ng Linh', '22333', '01257589424', 'okay1@gmail.com'),
(17, 'MAI H???U B???NG', '22333', '0125758942', 'dev7717@gmail.com'),
(18, 'Nguy???n Ho??ng Linh', '', '0123456789', 'linhb18092143@student.ctu.edu.vn'),
(19, 'Hoang Linh Nguyen', 'C??ng Ty Ph???n M???m Ho??ng Linh Plus . CF', '0123456789', 'dev75577@gmail.com'),
(20, 'Hoang Linh Nguyen', '', '0123456789', 'dev777wwww@gmail.com'),
(21, 'Hoang Linh Nguyen', 'ssss', '0123456789', 'linh0722www17@gmail.com'),
(22, 'Nguy???n Ho??ng Linh', '', '0125758942', 'lin3h072217@gmail.com'),
(23, 'Hoang Linh Nguyen', '', '0123456789', 'linh0782217@gmail.com'),
(24, 'MAI H???U B???NG', 'ddd', '0123456789', 'linhb18e3309143@student.ctu.edu.vn'),
(25, 'nguyen ngoc dinh', '', '03434567890', 'dinh@gmail.com'),
(26, 'account', '', '0876543223', 'abc65@gmail.com'),
(27, 'ubuntu', 'unix', '0124589744', 'ubuntu@gmail.com');

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
(1, 'S??ch '),
(2, 'M??y T??nh'),
(3, 'Th??? Thao'),
(4, '??i???n Tho???i'),
(5, 'Th???c Ph???m'),
(6, 'Th???i Trang'),
(7, 'Laptop'),
(18, 'kh??c');

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
(777, 'Nguy???n Ho??ng Linh', 'Qu???n L?? ', 'Ki??n Giang', '0123456789');

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
  MODIFY `SODONDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `diachikh`
--
ALTER TABLE `diachikh`
  MODIFY `MADC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  MODIFY `MALOAIHANG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
