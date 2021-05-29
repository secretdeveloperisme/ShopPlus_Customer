<?php
  if(isset($_GET["action"]) && !empty($_GET["action"])){
    include("../../Controller/HandleCustomerAddress.php");
    if ($_GET["action"] == "getPrimaryCustomerAddress" && isset($_GET["idCustomer"]) && !empty($_GET["idCustomer"])){
      echo json_encode(getPrimaryCustomerAddress($_GET["idCustomer"]));
    }
    if ($_GET["action"] == "getNumberOfAddress" && isset($_GET["idCustomer"]) && !empty($_GET["idCustomer"])){
      echo json_encode(getNumberOfAddress($_GET["idCustomer"]));
    }
    if ($_GET["action"] == "getCustomerAddress" && isset($_GET["idCustomer"]) && !empty($_GET["idCustomer"])){
      echo json_encode(getCustomerAddresses($_GET["idCustomer"]));
    }
  }
  if(isset($_POST["action"]) && !empty($_POST["action"])){
    include("../../Controller/HandleCustomerAddress.php");
    if ($_POST["action"] == "insertAddress" && isset($_POST["idCustomer"]) && !empty($_POST["idCustomer"])){
      if((isset($_POST["addressText"])&&!empty($_POST["addressText"]))){
        echo json_encode(insertCustomerAddress(new AddressCustomer(0,$_POST["addressText"],$_POST["idCustomer"])));
      }
    }
    if ($_POST["action"] == "deleteAddress" && isset($_POST["addressID"]) && !empty($_POST["addressID"])){
      echo json_encode(deleteCustomerAddress(new AddressCustomer($_POST["addressID"],"","")));
    }
    if ($_POST["action"] == "updateAddress" && isset($_POST["addressText"]) && !empty($_POST["addressText"])){
      if((isset($_POST["addressID"])&&!empty($_POST["addressID"]))){
        if((isset($_POST["customerID"])&&!empty($_POST["customerID"]))){
          echo json_encode(updateCustomerAddress(new AddressCustomer($_POST["addressID"],$_POST["addressText"],$_POST["customerID"])));
        }
      }
    }
  }
?>