<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Customer/php/models/Merchandise.php");
  include($rootPath."/ShopPlus_Customer/php/ConnectDB.php");
  global $connect;
  $connect = connectDB();
  function getAllProductWithLimit($begin,$end){
    $products = array();
    $allProductQuery = "SELECT * FROM hanghoa LIMIT $begin,$end";
    $result = $GLOBALS["connect"]->query($allProductQuery);
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        $merchandise = new Merchandise(
          $row["MSHH"],
          $row['TENHH'],$row["LOCATION"],
          $row["QUYCACH"],$row["GIA"],$row["SOLUONGHANG"],
          $row["MALOAIHANG"],$row["GHICHU"]
        );
        array_push($products,$merchandise->toArray());
      }
      return $products;
    }
  }
  function isExistProduct($id){
    $result = $GLOBALS["connect"]->query("SELECT MSHH FROM HANGHOA WHERE MSHH = $id");
    if(($result->num_rows) > 0)
      return true;
    else 
      return false;
  }
  function getProductViaID($id){
    $result = $GLOBALS["connect"]->query(
                                    "SELECT MSHH,TENHH,
                                    LOCATION,QUYCACH,
                                    GIA,SOLUONGHANG,
                                    MALOAIHANG,GHICHU
                                     FROM hanghoa WHERE MSHH= $id");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Merchandise(
        $row["MSHH"],
        $row['TENHH'],$row["LOCATION"],
        $row["QUYCACH"],$row["GIA"],$row["SOLUONGHANG"],
        $row["MALOAIHANG"],$row["GHICHU"]
      );
    }  
    else 
      return null;
  }
  function getCategoryWithIdProduct($id)
  {
    $result = $GLOBALS["connect"]->query("
        SELECT TENLOAIHANG FROM LOAIHANGHOA
        INNER JOIN HANGHOA ON LOAIHANGHOA.MALOAIHANG = HANGHOA.MALOAIHANG
        WHERE MSHH = $id
    ");
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row["TENLOAIHANG"];
    }
    else
      return "Không có loại hàng";
  }
?>