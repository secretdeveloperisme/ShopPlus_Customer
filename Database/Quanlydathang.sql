-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2021 at 10:32 AM
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
    FROM chitietdathang
    WHERE SODONDH = id_order;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOrderViaCustomer` (IN `id_customer` INT)  BEGIN
    SELECT SODONDH,MSKH,MSNV,NGAYDH,NGAYGH,TRANGTHAI FROM dathang
    WHERE MSKH = id_customer;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `test` (IN `order_id` INT)  begin 
	DECLARE finished INT DEFAULT FALSE;
	DECLARE id int ;
	DECLARE product_id int ;
    DECLARE product_amount int;
    DECLARE  order_details CURSOR FOR 
	SELECT dathang.SODONDH,chitietdathang.MSHH,chitietdathang.SOLUONG from dathang JOIN chitietdathang on 
    dathang.SODONDH = chitietdathang.SODONDH 
    WHERE dathang.SODONDH = order_id;
    DECLARE CONTINUE HANDLER 
    FOR NOT FOUND SET finished = TRUE;
    OPEN order_details;
    get_order_detail:LOOP
    	FETCH order_details INTO 					id,product_id,product_amount;
		IF finished THEN 
			LEAVE get_order_detail;
		END IF;
        SELECT id,product_id,product_amount;
    END LOOP get_order_detail;
    CLOSE order_details;
end$$

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

CREATE DEFINER=`root`@`localhost` FUNCTION `handleRawSearching` (`raw` VARCHAR(100)) RETURNS VARCHAR(100) CHARSET utf8mb4 BEGIN 
    set raw = REPLACE(raw,' ','');
    set raw = REPLACE(raw,'Đ','d');
    set raw = REPLACE(raw,'đ','d');
    return raw;
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

CREATE DEFINER=`root`@`localhost` FUNCTION `is_best_seller` (`id` INT) RETURNS TINYINT(1) BEGIN
	DECLARE valid tinyint(1) DEFAULT 0;
    set valid = (
        select 1
        WHERE 
        id in (SELECT top_seller.top_10_seller from top_seller)
    );
    if valid = 1 then 
    	return valid;
    else 
    	return 0;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `is_valid_login` (`id` INT, `matkhau` CHAR(30)) RETURNS TINYINT(1) BEGIN
	DECLARE valid INT  ;
    set valid = (
        SELECT COUNT(*) FROM nhanvien
        WHERE 
        nhanvien.MSNV = id AND
        nhanvien.MATKHAU = matkhau
    );
    IF  valid = 1 THEN
    	RETURN 1;
    ELSE
    	RETURN 0;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `is_valid_login_customer` (`email_customer` CHAR(70), `matkhau` CHAR(50)) RETURNS TINYINT(1) BEGIN
	DECLARE valid INT ;
    set valid = (
        SELECT COUNT(*) FROM khachhang
        WHERE 
        khachhang.EMAIL = email_customer AND
        khachhang.MATKHAU = MATKHAU
    );
    IF  valid = 1 THEN
    	RETURN 1;
    ELSE
    	RETURN 0;
    END IF;
END$$

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
-- Dumping data for table `chitietdathang`
--

INSERT INTO `chitietdathang` (`SODONDH`, `MSHH`, `SOLUONG`, `GIADATHANG`, `GIAMGIA`) VALUES
(32, 38, 3, 191400, 0),
(32, 45, 1, 30899000, 0),
(32, 53, 1, 8990000, 0),
(32, 56, 1, 3489000, 0),
(34, 42, 1, 149000, 0),
(35, 44, 1, 198000, 0),
(36, 38, 1, 63800, 0),
(37, 32, 3, 558900, 0),
(38, 35, 3, 120000, 0),
(39, 32, 1, 186300, 0),
(39, 38, 2, 127600, 0),
(40, 35, 1, 40000, 0),
(40, 39, 1, 150000, 0),
(41, 43, 2, 2790000, 0),
(42, 54, 1, 14249100, 0),
(42, 58, 2, 9580000, 0),
(43, 31, 3, 288300, 0),
(44, 48, 2, 136000, 0),
(44, 55, 2, 4240000, 0),
(46, 35, 1, 40000, 0),
(47, 41, 1, 427000, 0),
(47, 46, 1, 5090000, 0),
(48, 40, 1, 99000, 0),
(48, 41, 1, 427000, 0),
(50, 45, 1, 30899000, 0),
(50, 57, 1, 2590000, 0),
(51, 44, 1, 198000, 0),
(51, 52, 1, 2390000, 0),
(52, 57, 1, 2590000, 0),
(53, 30, 1, 156000, 0),
(54, 41, 1, 427000, 0),
(55, 42, 1, 149000, 0),
(56, 52, 2, 4780000, 0),
(58, 35, 3, 120000, 0),
(59, 41, 1, 427000, 0),
(60, 57, 1, 2590000, 0),
(61, 46, 1, 5090000, 0),
(62, 43, 3, 4185000, 0),
(63, 41, 1, 427000, 0),
(63, 51, 2, 28498200, 0);

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

--
-- Dumping data for table `dathang`
--

INSERT INTO `dathang` (`SODONDH`, `MSKH`, `MSNV`, `NGAYDH`, `NGAYGH`, `TRANGTHAI`) VALUES
(32, 4, 777, '2021-05-29', '2021-06-09', 'canceled'),
(34, 16, 777, '2021-05-30', '2021-06-22', 'approved'),
(35, 5, 777, '2021-05-30', '2021-06-09', 'completed'),
(36, 5, 777, '2021-05-30', '2021-07-15', 'completed'),
(37, 4, NULL, '2021-05-30', NULL, 'processing'),
(38, 7, NULL, '2021-05-30', NULL, 'processing'),
(39, 25, NULL, '2021-06-01', NULL, 'processing'),
(40, 25, 777, '2021-06-02', '2021-06-04', 'approved'),
(41, 25, 777, '2021-06-02', '2021-06-24', 'completed'),
(42, 25, NULL, '2021-06-02', NULL, 'processing'),
(43, 4, NULL, '2021-06-03', NULL, 'processing'),
(44, 4, NULL, '2021-06-03', NULL, 'canceled'),
(46, 26, 777, '2021-06-07', '2021-06-22', 'completed'),
(47, 5, NULL, '2021-06-07', NULL, 'pending'),
(48, 28, NULL, '2021-06-07', NULL, 'pending'),
(50, 30, NULL, '2021-06-07', NULL, 'pending'),
(51, 30, NULL, '2021-06-08', NULL, 'pending'),
(52, 5, NULL, '2021-06-24', NULL, 'pending'),
(53, 4, NULL, '2021-07-01', NULL, 'canceled'),
(54, 4, NULL, '2021-07-02', NULL, 'canceled'),
(55, 31, NULL, '2021-07-02', NULL, 'canceled'),
(56, 31, NULL, '2021-07-04', NULL, 'completed'),
(58, 5, NULL, '2021-07-08', NULL, 'pending'),
(59, 65, NULL, '2021-07-10', NULL, 'pending'),
(60, 65, NULL, '2021-07-11', NULL, 'canceled'),
(61, 65, NULL, '2021-07-12', NULL, 'pending'),
(62, 65, NULL, '2021-07-12', NULL, 'canceled'),
(63, 66, NULL, '2021-07-12', NULL, 'canceled');

--
-- Triggers `dathang`
--
DELIMITER $$
CREATE TRIGGER `changeStatusOrder` AFTER UPDATE ON `dathang` FOR EACH ROW BEGIN 
	DECLARE finished INT DEFAULT FALSE;
	DECLARE id int ;
	DECLARE product_id int ;
    DECLARE product_amount int;
    DECLARE  order_details CURSOR FOR 
	SELECT dathang.SODONDH,chitietdathang.MSHH,chitietdathang.SOLUONG from dathang JOIN chitietdathang on 
    dathang.SODONDH = chitietdathang.SODONDH 
    WHERE dathang.SODONDH = NEW.SODONDH;
    DECLARE CONTINUE HANDLER 
    FOR NOT FOUND SET finished = TRUE;
    OPEN order_details;
    get_order_detail:LOOP
    	FETCH order_details INTO id,product_id,product_amount;
		IF finished THEN 
			LEAVE get_order_detail;
		END IF;
       IF new.TRANGTHAI = 'canceled'
		THEN 
        	UPDATE hanghoa SET hanghoa.SOLUONGHANG = hanghoa.SOLUONGHANG + product_amount WHERE hanghoa.MSHH = product_id;
       END IF;
       IF NEW.TRANGTHAI != 'canceled' AND OLD.TRANGTHAI = 'canceled'
		THEN 
        	UPDATE hanghoa SET hanghoa.SOLUONGHANG = hanghoa.SOLUONGHANG - product_amount WHERE hanghoa.MSHH = product_id;
       END IF;
    END LOOP get_order_detail;
    CLOSE order_details;
END
$$
DELIMITER ;

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
(26, 'bến tre', 25),
(27, 'alo', 4),
(30, 'Kiên Giang', 5),
(33, '324234', 30),
(34, 'LA', 31),
(35, 'ben tre', 64),
(36, 'ha noi', 64),
(37, 'Long An LA', 65),
(38, 'Cần Thơ', 65),
(39, 'Không Biết', 66);

-- --------------------------------------------------------

--
-- Table structure for table `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(11) NOT NULL,
  `TENHH` varchar(100) NOT NULL,
  `LOCATION` varchar(200) NOT NULL,
  `QUYCACH` varchar(50) NOT NULL,
  `GIA` int(11) NOT NULL,
  `SOLUONGHANG` int(11) NOT NULL,
  `MALOAIHANG` int(11) NOT NULL,
  `GHICHU` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TENHH`, `LOCATION`, `QUYCACH`, `GIA`, `SOLUONGHANG`, `MALOAIHANG`, `GHICHU`) VALUES
(30, 'Thay Đổi Cuộc Sống Với Nhân Số Học', '/ShopPlus_Customer/assets/images/products/56b303e000cb42faada663569fc5d7c9.jpg', 'quyển', 156000, 5, 1, ''),
(31, 'Mình Chỉ Là Người Bình Thường (Sách Tô Màu)', '/ShopPlus_Customer/assets/images/products/604b1691c5c135a711e6ed01f3e5a290.jpg', 'quyển', 96100, 0, 1, ''),
(32, 'Muôn Kiếp Nhân Sinh 2', '/ShopPlus_Customer/assets/images/products/04ffa4c4673af50ef2e594bf8e4f6fa1.jpg', 'quyển', 186300, 5, 1, NULL),
(33, 'Cây Cam Ngọt Của Tôi', '/ShopPlus_Customer/assets/images/products/2a6154ba08df6ce6161c13f4303fa19e.jpg', 'quyển', 79400, 0, 1, '“Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào khi khám phá ra những điều khiến cuộc đời này đáng số một tác phẩm kinh điển của Brazil.”  - Booklist  “Một cách nhìn cuộc sống gần như hoàn chỉnh từ con mắt trẻ thơ… có sức mạnh sưởi ấm và làm tan nát cõi lòng, dù người đọc ở lứa tuổi nào.”  - The National  Hãy làm quen với Zezé, cậu bé tinh nghịch siêu hạng đồng thời cũng đáng yêu bậc nhất, với ước mơ lớn lên trở thành nhà thơ cổ thắt nơ bướm. Chẳng phải ai cũng công nhận khoản “đáng yêu” kia đâu nhé. Bởi vì, ở cái xóm ngoại ô nghèo ấy, nỗi khắc khổ bủa vây đã che mờ mắt người ta trước trái tim thiện lương cùng trí tưởng tượng tuyệt vời của cậu bé con năm tuổi.  Có hề gì đâu bao nhiêu là hắt hủi, đánh mắng, vì Zezé đã có một người bạn đặc biệt để trút nỗi lòng: cây cam ngọt nơi vườn sau. Và cả một người bạn nữa, bằng xương bằng thịt, một ngày kia xuất hiện, cho cậu bé nhạy cảm khôn sớm biết thế nào là trìu mến, thế nào là nỗi đau, và mãi mãi thay đổi cuộc đời cậu. Mở đầu bằng những thanh âm trong sáng và kết thúc lắng lại trong những nốt trầm hoài niệm, Cây cam ngọt của tôi khiến ta nhận ra vẻ đẹp thực sự của cuộc sống đến từ những điều giản dị như bông hoa trắng của cái cây sau nhà, và rằng cuộc đời thật khốn khổ nếu thiếu đi lòng yêu thương và niềm trắc ẩn. Cuốn sách kinh điển này bởi thế không ngừng khiến trái tim người đọc khắp thế giới thổn thức, kể từ khi ra mắt lần đầu năm 1968 tại Brazil.  Tác giả:  JOSÉ MAURO DE VASCONCELOS (1920-1984) là nhà văn người Brazil. Sinh ra trong một gia đình nghèo ở ngoại ô Rio de Janeiro, lớn lên ông phải làm đủ nghề để kiếm sống. Nhưng với tài kể chuyện thiên bẩm, trí nhớ phi thường, trí tưởng tượng tuyệt vời cùng vốn sống phong phú, José cảm thấy trong mình thôi thúc phải trở thành nhà văn nên đã bắt đầu sáng tác năm 22 tuổi. Tác phẩm nổi tiếng nhất của ông là tiểu thuyết mang màu sắc tự truyện Cây cam ngọt của tôi. Cuốn sách được đưa vào chương trình tiểu học của Brazil, được bán bản quyền cho hai mươi quốc gia và chuyển thể thành phim điện ảnh. Ngoài ra, José còn rất thành công trong vai trò diễn viên điện ảnh và biên kịch.  Giá sản phẩm trên Tiki đã bao gồm thuế theo luật hiện hành. Tuy nhiên tuỳ vào từng loại sản phẩm hoặc phương thức, địa chỉ giao hàng mà có thể phát sinh thêm chi phí khác như phí vận chuyển, phụ phí hàng cồng kềnh, .....'),
(34, 'Kiếp Nào Ta Cũng Tìm Thấy Nhau', '/ShopPlus_Customer/assets/images/products/67db9bf2590d75f978e68f9dcfe0db9a.jpg', 'quyễn', 72250, 3, 1, ''),
(35, 'Từ Điển Tiếng “Em”', '/ShopPlus_Customer/assets/images/products/14338e7ae795f56d66996b611070b173.jpg', 'quyễn', 40000, 7, 1, 'tu dien tieng em'),
(36, 'Sách Tài Chính Cá Nhân Cho Người Việt Nam - Tặng K', '/ShopPlus_Customer/assets/images/products/2d35f5288ea643e3768c8f3361cafa5a.jpg', 'quyển', 200000, 4, 1, ''),
(37, 'Kẻ Trộm Sách (Tái Bản)', '/ShopPlus_Customer/assets/images/products/ke-trom-sach.u5387.d20170720.t153804.332048.jpg', 'quyển', 180000, 3, 1, ''),
(38, 'Cân Bằng Cảm Xúc, Cả Lúc Bão Giông', '/ShopPlus_Customer/assets/images/products/a19424cfe9d113c32732d93cf2d5f59a.jpg', 'quyển', 63800, 0, 1, ''),
(39, 'CẨM NANG MUA BÁN ĐẤT', '/ShopPlus_Customer/assets/images/products/f797420579b8e0f5c84a1278d23053ec.jpg', 'quyển', 150000, 0, 1, ''),
(40, 'USB Kingston DT100G3 32GB USB 3.0 - Hàng Chính Hãn', '/ShopPlus_Customer/assets/images/products/34e6ca6587338ccf18f312d7b9b2ea3c.jpg', 'cái', 99000, 0, 2, ''),
(41, 'Router Wifi Băng Tần Kép AC1200 TP-Link Archer C50', '/ShopPlus_Customer/assets/images/products/archer-c50-v3_s_01.u4064.d20170704.t180940.358348.jpg', 'cái', 427000, 1, 2, ''),
(42, 'USB Kingston DT100G3 - 64GB - USB 3.0 ', '/ShopPlus_Customer/assets/images/products/64_1.jpg', 'cái', 149000, 0, 2, ''),
(43, 'Ổ Cứng Di Động WD Elements 1TB 2.5 USB 3.0 - WDBUZ', '/ShopPlus_Customer/assets/images/products/wd elements 1tb - 2.5 usb 3.0_1.u579.d20160808.t172730.328870.jpg', 'cái', 1395000, 3, 2, ''),
(44, 'Bộ Kích Sóng Wifi Repeater 300Mbps Totolink EX200 ', '/ShopPlus_Customer/assets/images/products/30d0c22525743d5a2e850e76dd52fe72.jpg', 'cái', 198000, 8, 2, ''),
(45, 'Apple Macbook Pro 2020 M1 - 13 Inchs (Apple M1/ 8G', '/ShopPlus_Customer/assets/images/products/33d72e8efc6ef58d5fbe0cb1770c797e.jpg', 'cái', 30899000, 7, 2, ''),
(46, 'Màn Hình Dell U2419H 24inch FullHD 8ms 60Hz IPS - ', '/ShopPlus_Customer/assets/images/products/c220e39d6100924a66679bfb346b7544.jpg', 'cái', 5090000, 6, 2, ''),
(47, 'Phần Mềm Diệt Virus BKAV Profressional 12 Tháng - ', '/ShopPlus_Customer/assets/images/products/f20ea1736b20a4ce9138382e51bbf75e.jpg', 'cái', 190000, 9, 2, ''),
(48, 'Chuột Có Dây Logitech B100 - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/a9c21fbe61ce96d66c06582a49791381.jpg', 'cái', 68000, 2, 2, ''),
(49, 'Ổ Cứng SSD Kingston A400 (240GB) - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/9df3937c390fcc0b66161f4dbe783757.jpg', 'cái', 815000, 3, 2, ''),
(50, 'Điện Thoại Samsung Galaxy A51 (6GB/128GB) - Hàng C', '/ShopPlus_Customer/assets/images/products/3d5f9878e277d1244fe6b582e074e777.jpg', 'cái', 5850000, 3, 4, ''),
(51, 'Máy Tính Bảng Samsung Galaxy Tab S7 Wifi T870 (6GB', '/ShopPlus_Customer/assets/images/products/111e4d1c36ec7094cbfb9ea5e0334992.jpg', 'cái', 14249100, 10, 4, ''),
(52, 'Điện Thoại Oppo A12 (3GB/32GB) - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/e9dc08e1a4e6eb6439442b2df5150aeb.jpg', 'cái', 2390000, 0, 4, ''),
(53, 'Điện Thoại Samsung Galaxy A52 (8GB/128GB) - Hàng C', '/ShopPlus_Customer/assets/images/products/10f12e9c3eef374bf72b385f1b70124c.jpg', 'cái', 8990000, 7, 4, ''),
(54, 'Máy Tính Bảng Samsung Galaxy Tab S7 Wifi T870 (6GB', '/ShopPlus_Customer/assets/images/products/dc0d6dcd10f4a31d5f6dcab75566637e.jpg', 'cái', 14249100, 0, 4, ''),
(55, 'Điện Thoại Realme C11 (2GB/32GB) - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/b9f3e343440b02c54f95a9034990e0d5.jpg', 'cái', 2120000, 6, 4, ''),
(56, 'Điện Thoại Vsmart Live 4 (6GB/64GB) - Hàng Chính H', '/ShopPlus_Customer/assets/images/products/3360d9dcb541dd5d2aaa59ae0ad6b1c5.jpg', 'cái', 3489000, 4, 4, ''),
(57, 'Điện Thoại Nokia 3.4 - Hàng Chính Hãng', '/ShopPlus_Customer/assets/images/products/0ddf107a81ccf15f9e2d27ba67e25d6b.jpg', 'cái', 2590000, 5, 4, ''),
(58, 'Điện Thoại Samsung Galaxy M31 (6GB/128GB) - Hàng C', '/ShopPlus_Customer/assets/images/products/0df5a90d7bd5d327de2d25d510dd9b65.jpg', 'cái', 4790000, 1, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(11) NOT NULL,
  `HOTENKH` varchar(50) NOT NULL,
  `TENCONGTY` varchar(50) DEFAULT NULL,
  `SODIENTHOAI` varchar(11) NOT NULL,
  `EMAIL` varchar(70) DEFAULT NULL,
  `MATKHAU` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HOTENKH`, `TENCONGTY`, `SODIENTHOAI`, `EMAIL`, `MATKHAU`) VALUES
(4, 'Nguyễn Hoàng Linh', 'Công Ty Phần Mềm Hoàng Linh Plus', '0849105289', 'dev777@gmail.com', 'HoangLinhPlus&12345'),
(5, 'Hoang Linh Nguyen', 'upl', '0123456789', 'linh072217@gmail.com', '1'),
(7, 'Võ Thị Ngọc Thư', 'thư july', '01234233333', 'vongocthu0719@gmail.com', '2'),
(11, 'Hoang Linh Nguyen', '', '0123456589', 'fsdf@gmail.com', '3'),
(12, 'MAI HỮU BẰNG', '', '08574258964', 'bangb1803891@student.ctu.edu.vn', '4'),
(13, 'quốc huy', '', '0192938347', 'quochuy@gmail.com', '5'),
(14, 'Huỳnh Thị Diệu', 'công ty diệu hiền', '08765478382', 'dieu123@gmail.com', '6'),
(15, 'okay', '', '07846283913', 'okay@gmail.com', '7'),
(16, 'Nguyễn Hoàng Linh', '22333', '01257589424', 'okay1@gmail.com', '8'),
(17, 'MAI HỮU BẰNG', '22333', '0125758942', 'dev7717@gmail.com', '9'),
(18, 'Nguyễn Hoàng Linh', '', '0123456789', 'linhb18092143@student.ctu.edu.vn', '10'),
(19, 'Hoang Linh Nguyen', 'Công Ty Phần Mềm Hoàng Linh Plus . CF', '0123456789', 'dev75577@gmail.com', '11'),
(20, 'Hoang Linh Nguyen', '', '0123456789', 'dev777wwww@gmail.com', '12'),
(21, 'Hoang Linh Nguyen', 'ssss', '0123456789', 'linh0722www17@gmail.com', '13'),
(22, 'Nguyễn Hoàng Linh', '', '0125758942', 'lin3h072217@gmail.com', '14'),
(23, 'Hoang Linh Nguyen', '', '0123456789', 'linh0782217@gmail.com', '15'),
(24, 'MAI HỮU BẰNG', 'ddd', '0123456789', 'linhb18e3309143@student.ctu.edu.vn', '16'),
(25, 'nguyen ngoc dinh', '', '03434567890', 'dinh@gmail.com', '17'),
(26, 'account', '', '0876543223', 'abc65@gmail.com', '18'),
(28, 'ádfsdfsdf', 'sdfsdfsdfsd', '0258975648', 'hey@gmail.com', '19'),
(29, 'sasdfsdfsd', 'sdfsdfsdfsdf', '0125879457', 'now@gmail.com', '20'),
(30, '324', '324234', '0324235897', 'oweir@gmail.com', '21'),
(31, 'lin gmail ', 'khong co', '02587494258', 'linh@gmail.com', '22'),
(63, 'dfsd', '', '01258974859', 'linh7777@gmail.com', 'HoangLinhPlus&321'),
(64, 'nguyen hoang linh', 'now', '02589475895', 'nguyenlapnghiep4@gmail.com', 'HoangLinhPlus$235243'),
(65, 'Huỳnh Thị Diệu', 'Lộc Trời', '02589645895', 'huythidieu2504@gmail.com', 'HuynhThiDieu2504&Nghen'),
(66, 'Khách Hàng Thân Thiết ', '', '02589752875', 'khachhangthanthiet@gmail.com', 'KhachHang%123');

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
(7, 'Laptop'),
(18, 'khác');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(11) NOT NULL,
  `HOTENNV` varchar(50) NOT NULL,
  `MATKHAU` char(30) NOT NULL,
  `CHUCVU` varchar(30) NOT NULL,
  `DIACHI` varchar(200) NOT NULL,
  `SODIENTHOAI` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HOTENNV`, `MATKHAU`, `CHUCVU`, `DIACHI`, `SODIENTHOAI`) VALUES
(777, 'Nguyễn Hoàng Linh', 'adminshopplus777', 'Quản Lý ', 'Kiên Giang', '0123456789');

-- --------------------------------------------------------

--
-- Stand-in structure for view `top_seller`
-- (See below for the actual view)
--
CREATE TABLE `top_seller` (
`top_10_seller` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `top_seller`
--
DROP TABLE IF EXISTS `top_seller`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top_seller`  AS SELECT `chitietdathang`.`MSHH` AS `top_10_seller` FROM `chitietdathang` GROUP BY `chitietdathang`.`MSHH` ORDER BY sum(`chitietdathang`.`SOLUONG`) DESC LIMIT 0, 10 ;

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
  ADD UNIQUE KEY `U_KHACHHANG_MK` (`MATKHAU`),
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
  MODIFY `SODONDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `diachikh`
--
ALTER TABLE `diachikh`
  MODIFY `MADC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  MODIFY `MALOAIHANG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
