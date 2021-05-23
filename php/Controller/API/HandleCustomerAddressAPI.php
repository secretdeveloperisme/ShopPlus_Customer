<?php
  if(isset($_GET["action"]) && !empty($_GET["action"])){
    include("../../Controller/HandleCustomerAddress.php");
    if ($_GET["action"] == "getPrimaryCustomerAddress" && isset($_GET["idCustomer"]) && !empty($_GET["idCustomer"])){
      echo json_encode(getPrimaryCustomerAddress($_GET["idCustomer"]));
    }
  }
?>