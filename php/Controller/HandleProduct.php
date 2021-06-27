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
  function getProductWithSearching($queryString,$categoryID,$orderAsc,$orderDesc,$lowPrice,$highPrice,$bestSeller,$page){
    $queryCategory = $queryOrderAsc = $queryOrderDesc = $queryPrice =$queryBestSeller= $queryPage = "";
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
    if(!empty($bestSeller)){
      $queryBestSeller = "AND is_best_seller(hanghoa.MSHH)";
    }
    if(!empty($page)){
      $page = ($page - 1)*10;
      $queryPage= "LIMIT $page,10";
    }
    $queryString = handleRawSearching($queryString);
    $products = array();
    $allProductQuery = "
        SELECT * FROM hanghoa
        JOIN loaihanghoa ON hanghoa.MALOAIHANG = loaihanghoa.MALOAIHANG
        WHERE 
              handleRawSearching(TENHH) LIKE '%$queryString%'
              $queryCategory 
              $queryPrice
              $queryBestSeller
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
  function getProductNumbersWithSearching($queryString,$categoryID,$lowPrice,$highPrice,$bestSeller){
    $queryCategory = $queryOrderAsc = $queryOrderDesc = $queryPrice = $queryBestSeller = $queryPage = "";
    if(!empty($categoryID)){
      $queryCategory = "AND loaihanghoa.MALOAIHANG = $categoryID";
    }
    if(!empty($lowPrice)&&!empty($highPrice)){
      $queryPrice = "AND hanghoa.GIA BETWEEN $lowPrice AND $highPrice ";
    }
    if(!empty($bestSeller)){
      $queryBestSeller = "AND is_best_seller(hanghoa.MSHH)";
    }
    $queryString = handleRawSearching($queryString);
    $allProductQuery = "
          SELECT COUNT(*) AS number_of_products FROM hanghoa
          JOIN loaihanghoa ON hanghoa.MALOAIHANG = loaihanghoa.MALOAIHANG
          WHERE 
                handleRawSearching(TENHH) LIKE '%$queryString%'
                $queryCategory 
                $queryPrice
                $queryBestSeller
          ";
    $result = $GLOBALS["connect"]->query($allProductQuery);
    return $result->fetch_assoc()["number_of_products"];
  }
  function isTopTenSeller($id){
    $result = $GLOBALS["connect"]->query("
        SELECT is_best_seller($id) as best_seller
    ");
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if($row["best_seller"] == 1)
        return true;
      else
        return false;
    }
    else
      return false;
  }
  function getProductsViaString($q){
    $q = handleRawSearching($q);  
    $products = array();
    $allProductQuery = "
      SELECT * FROM hanghoa
      WHERE handleRawSearching(TENHH) LIKE '%$q%' LIMIT 5" ;
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
  function handleRawSearching($raw){
    $raw = str_replace(" ","",$raw);
    $raw = str_replace("Đ","d",$raw);
    $raw = str_replace("đ","d",$raw);
    return $raw;
  }
?>