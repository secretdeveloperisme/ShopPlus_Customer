CREATE USER customer@localhost IDENTIFIED BY 'CustomerShopPlus777';
GRANT SELECT ON hanghoa TO customer@localhost;
GRANT SELECT ON  loaihanghoa TO customer@localhost;
GRANT  SELECT ON dathang TO customer@localhost;
GRANT SELECT ON  chitietdathang TO customer@localhost;
GRANT  SELECT ON khachhang TO customer@localhost;
GRANT SELECT ON  diachikh TO customer@localhost;
GRANT  SELECT ON top_seller TO customer@localhost;
GRANT EXECUTE ON FUNCTION calculateMoneyOrder TO customer@localhost;
GRANT EXECUTE ON PROCEDURE getAllOrderDetail TO customer@localhost;
GRANT EXECUTE ON PROCEDURE getOrderViaCustomer TO customer@localhost;
GRANT EXECUTE ON FUNCTION get_sold_merchandise TO customer@localhost;
GRANT EXECUTE ON FUNCTION handleRawSearching TO customer@localhost;
GRANT EXECUTE ON FUNCTION isValidAmountOfProduct TO customer@localhost;
GRANT EXECUTE ON FUNCTION is_best_seller TO customer@localhost;
GRANT EXECUTE ON FUNCTION is_valid_login_customer TO customer@localhost;
GRANT INSERT ON khachhang TO customer@localhost;
GRANT INSERT ON dathang TO customer@localhost;
GRANT INSERT ON chitietdathang TO customer@localhost;
GRANT INSERT ON diachikh TO customer@localhost;


GRANT UPDATE(TRANGTHAI) ON dathang TO customer@localhost;
GRANT UPDATE ON khachhang to customer@localhost;
GRANT UPDATE ON diachikh to customer@localhost;