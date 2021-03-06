<?php
  header('Content-Type: application/json');
  if(isset($_GET["action"])&&!empty($_GET["action"])){
    include("../../Controller/HandleProduct.php");
    if($_GET["action"] == "getAllProduct"){
      echo json_encode(getAllProductWithLimit(1,100));
    }
    if($_GET["action"] == "getProductViaId" && isset($_GET["id"])&& !empty($_GET["id"])){
      echo json_encode(getProductViaID($_GET["id"])->toArray());
    }
    if($_GET["action"] == "getSoldProductAmount" && isset($_GET["id"])&& !empty($_GET["id"])){
      echo json_encode(getSoldProductAmount($_GET["id"]));
    }
    if($_GET["action"] == "isBestSeller" && isset($_GET["id"])&& !empty($_GET["id"])){
      echo json_encode(isTopTenSeller($_GET["id"]));
    }
  }

?>