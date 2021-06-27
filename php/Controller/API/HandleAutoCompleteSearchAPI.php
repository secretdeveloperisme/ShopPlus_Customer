<?php
  if(isset($_GET["action"]) && !empty($_GET["action"])){
    include("../../Controller/HandleProduct.php");
    if ($_GET["action"] == "getProductsViaString"){
      if(isset($_GET["q"])&&!empty($_GET["q"]))
        echo json_encode(getProductsViaString($_GET["q"]));
    }
  }