<?php
  header('Content-Type: application/json');
  include ("../models/Merchandise.php");
  if(isset($_GET["action"])&&!empty($_GET["action"])){
    if($_GET["action"] == "getAllProduct"){
      include("../Controller/HandleProduct.php");
      echo json_encode(getAllProductWithLimit(1,20));
    }
  }

?>