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
    $result = $GLOBALS["connect"]->query("SELECT MSHH FROM hanghoa WHERE MSHH = $id");
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
        SELECT TENLOAIHANG FROM loaihanghoa
        INNER JOIN hanghoa ON loaihanghoa.MALOAIHANG = hanghoa.MALOAIHANG
        WHERE MSHH = $id
    ");
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row["TENLOAIHANG"];
    }
    else
      return "Không có loại hàng";
  }
  function getSoldProductAmount($id){
    $result = $GLOBALS["connect"]->query("SELECT get_sold_merchandise($id) as amount");
    return $result->fetch_assoc()["amount"];
  }
  function getProductWithSearching($queryString,$categoryID,$orderAsc,$orderDesc,$lowPrice,$highPrice,$page){
    $queryCategory = $queryOrderAsc = $queryOrderDesc = $queryPrice = $queryPage = "";
    if(!empty($categoryID)){
      $queryCategory = "AND loaihanghoa.MALOAIHANG = $categoryID";
    }
    if(!empty($orderAsc)){
      $queryOrderAsc = "ORDER BY hanghoa.GIA ASC";
    }
    if(!empty($orderDesc)){
      $queryOrderDesc = "ORDER BY hanghoa.GIA DESC";
    }
    if(!empty($lowPrice)&&!empty($highPrice)){
      $queryPrice = "AND hanghoa.GIA BETWEEN $lowPrice AND $highPrice ";
    }
    if(!empty($page)){
      $page = ($page - 1)*10;
      $queryPage= "LIMIT $page,10";
    }
    $products = array();
    $allProductQuery = "
        SELECT * FROM hanghoa
        JOIN loaihanghoa ON hanghoa.MALOAIHANG = loaihanghoa.MALOAIHANG
        WHERE 
              LOWER(TENHH) REGEXP '$queryString'
              $queryCategory 
              $queryPrice
              $queryOrderAsc
              $queryOrderDesc
              $queryPage
        ";
    $result = $GLOBALS["connect"]->query($allProductQuery);
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        $merchandise = new Merchandise(
          $row["MSHH"],
          $row['TENHH'],$row["LOCATION"],
          $row["QUYCACH"],$row["GIA"],$row["SOLUONGHANG"],
          $row["MALOAIHANG"],$row["GHICHU"]
        );
        array_push($products,$merchandise);
      }
      return $products;
    }
    return $products;
  }
?>