<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/ShopPlus_Customer/php/ConnectDB.php";
  include($path);
  global $connect ;
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
    
  }
  
?>