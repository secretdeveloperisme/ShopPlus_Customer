<?php
  if(isset($_GET["action"]) && !empty($_GET["action"])){
    include("../../Controller/HandleCustomerAddress.php");
    if ($_GET["action"] == "getPrimaryCustomerAddress" && isset($_GET["idCustomer"]) && !empty($_GET["idCustomer"])){
      echo json_encode(getPrimaryCustomerAddress($_GET["idCustomer"]));
    }
    if ($_GET["action"] == "getNumberOfAddress" && isset($_GET["idCustomer"]) && !empty($_GET["idCustomer"])){
      echo json_encode(getNumberOfAddress($_GET["idCustomer"]));
    }
  }
?>