/*==============================================================*/
/* DBMS name :     Quanlydathang                                */
/* Created by :  HoangLinhPlus			                        */
/*==============================================================*/


drop table if exists CHITIETDATHANG;

drop table if exists DATHANG;

drop table if exists DIACHIKH;

drop table if exists HANGHOA;

drop table if exists KHACHHANG;

drop table if exists LOAIHANGHOA;

drop table if exists NHANVIEN;

/*==============================================================*/
/* Table: CHITIETDATHANG                                        */
/*==============================================================*/
create table CHITIETDATHANG
(
   SODONDH              int not null,
   MSHH                 int not null,
   SOLUONG              int not null,
   GIADATHANG           int not null,
   GIAMGIA              float,
   primary key (SODONDH, MSHH)
);

/*==============================================================*/
/* Table: DATHANG                                               */
/*==============================================================*/
create table DATHANG
(
   SODONDH              int not null AUTO_INCREMENT,
   MSKH                 int not null,
   MSNV                 int,
   NGAYDH               date not null,
   NGAYGH               date,
   TRANGTHAI            varchar(20) not null,
   primary key (SODONDH)
);

/*==============================================================*/
/* Table: DIACHIKH                                              */
/*==============================================================*/
create table DIACHIKH
(
   MADC                 int not null AUTO_INCREMENT,
   DIACHI               varchar(150) not null,
   MSKH                 int not null,
   primary key (MADC)
);

/*==============================================================*/
/* Table: HANGHOA                                               */
/*==============================================================*/
create table HANGHOA
(
   MSHH                 int not null AUTO_INCREMENT,
   TENHH                varchar(50) not null,
   LOCATION             varchar(200) not null,
   QUYCACH              varchar(50) not null,
   GIA                  int not null,
   SOLUONGHANG          int not null,
   MALOAIHANG           int not null,
   GHICHU               varchar(200),
   primary key (MSHH)
);

/*==============================================================*/
/* Table: KHACHHANG                                             */
/*==============================================================*/
create table KHACHHANG
(
   MSKH                 int not null AUTO_INCREMENT,
   HOTENKH              varchar(50) not null,
   TENCONGTY            varchar(50),
   SODIENTHOAI          varchar(11) not null,
   EMAIL                varchar(70) not null,
   primary key (MSKH)
);

/*==============================================================*/
/* Table: LOAIHANGHOA                                           */
/*==============================================================*/
create table LOAIHANGHOA
(
   MALOAIHANG           int AUTO_INCREMENT,
   TENLOAIHANG          varchar(50) not null,
   primary key (MALOAIHANG)
);

/*==============================================================*/
/* Table: NHANVIEN                                              */
/*==============================================================*/
create table NHANVIEN
(
   MSNV                 int not null AUTO_INCREMENT,
   HOTENNV              varchar(50) not null,
   CHUCVU               varchar(30) not null,
   DIACHI               varchar(200) not null,
   SODIENTHOAI          varchar(11) not null,
   primary key (MSNV)
);

alter table CHITIETDATHANG add constraint FK_CHITIETDATHANG_DATHANG foreign key (SODONDH)
      references DATHANG (SODONDH) on delete restrict on update restrict;

alter table CHITIETDATHANG add constraint FK_CHITIETDATHANG_HANGHOA foreign key (MSHH)
      references HANGHOA (MSHH) on delete restrict on update restrict;

alter table DATHANG add constraint FK_DATHANG_KHACHHANG foreign key (MSKH)
      references KHACHHANG (MSKH) on delete restrict on update restrict;

alter table DATHANG add constraint FK_DATHANG_NHANVIEN foreign key (MSNV)
      references NHANVIEN (MSNV) on delete restrict on update restrict;

alter table DIACHIKH add constraint FK_DIACHIKH_KHACHHANG foreign key (MSKH)
      references KHACHHANG (MSKH) on delete restrict on update restrict;

alter table HANGHOA add constraint FK_HOANGHOA_LOAIHANGHOA foreign key (MALOAIHANG)
      references LOAIHANGHOA (MALOAIHANG) on delete restrict on update restrict;
alter table KHACHHANG add constraint U_KHACHHANG_EMAIL UNIQUE (EMAIL);
-- functions, procedure and trigger

---- function check product order less than available amount product
DELIMITER $$
CREATE FUNCTION isValidAmountOfProduct(id int, amount int)
returns tinyint(1)
DETERMINISTIC
begin
	declare amountOfProduct INT;
    set amountOfProduct := (SELECT SOLUONGHANG FROM HANGHOA WHERE MSHH = id);
    if amount > amountOfProduct then
        return 0;
    else
        return 1;
    end if;
end$$
---- trigger when we purchase a product, that amount of product will be minus from available amount of product
DELIMITER $$
CREATE TRIGGER minusAmountProductWhenPurChase
AFTER INSERT ON CHITIETDATHANG
FOR EACH ROW
BEGIN
    DECLARE amount INT;
    UPDATE HANGHOA SET SOLUONGHANG = (SOLUONGHANG - NEW.SOLUONG)
        WHERE NEW.MSHH = MSHH;
END$$
--- procedure get all order via customer id
DELIMITER $$
CREATE PROCEDURE getOrderViaCustomer( IN id_customer int)
BEGIN
    SELECT SODONDH,MSKH,MSNV,NGAYDH,NGAYGH,TRANGTHAI FROM DATHANG
    WHERE MSKH = id_customer;
END $$
---procedure get all order detail via order id
DELIMITER $$
CREATE PROCEDURE getAllOrderDetail( IN id_order int)
BEGIN
    SELECT SODONDH,MSHH,SOLUONG,GIADATHANG,GIAMGIA
    FROM CHITIETDATHANG
    WHERE SODONDH = id_order;
END $$