<?php
  header('Content-Type: application/json');
  include ("../models/Merchandise.php");
  if(isset($_GET["action"])&&!empty($_GET["action"])){
    $products = array();
    include("../ConnectDB.php");
    if($_GET["action"] == "getAllProduct"){
      $allProductQuery = "SELECT * FROM hanghoa";
      $result = $connect->query($allProductQuery);
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
        echo json_encode($products);
      }
    }
  }

?>