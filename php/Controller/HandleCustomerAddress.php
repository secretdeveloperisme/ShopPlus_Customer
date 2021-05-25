<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Customer/php/models/AddressCustomer.php");
  include($rootPath."/ShopPlus_Customer/php/ConnectDB.php");
  global $connect ;
  $connect = connectDB();
  function insertCustomerAddress($addressCustomer){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO DIACHIKH(DIACHI,MSKH)VALUES(?,?)");
    $address = $addressCustomer->getAddressText();
    $id = $addressCustomer->getCustomerId();
    $prepare->bind_param("ss",$address,$id);
    if($prepare->execute()){
      $prepare->close();
      $GLOBALS["connect"]->close();
      return true;
    }
    else{
      $prepare->close();
      $GLOBALS["connect"]->close();
      return false;
    }
  }
  function updateCustomerAddress($id,$address){
    $result = $GLOBALS["connect"]->query("UPDATE DIACHIKH SET DIACHI = '$address' WHERE MADC = $id");
    return $result;
  }
  function getCustomerAddresses($id){
    $addresses = array();
    $result = $GLOBALS["connect"]->query("SELECT MADC,DIACHI,MSKH FROM DIACHIKH WHERE MSKH = $id");
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $address = new AddressCustomer("0",$row["DIACHI"],$row["MSKH"]);
        array_push($addresses ,$address->toArray());
      }
    }
    echo json_encode($addresses);
  }
  function getNumberOfAddress($id){
    $addresses = array();
    $result = $GLOBALS["connect"]->query("SELECT MADC,DIACHI,MSKH FROM DIACHIKH WHERE MSKH = $id");
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $address = new AddressCustomer("0",$row["DIACHI"],$row["MSKH"]);
        array_push($addresses ,$address->toArray());
      }
    }
    return count($addresses);
  }
  function getPrimaryCustomerAddress($idCustomer){
    $addresses = array();
    $result = $GLOBALS["connect"]->query("SELECT MADC,DIACHI,MSKH FROM DIACHIKH WHERE MSKH = $idCustomer");
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $address = new AddressCustomer("0",$row["DIACHI"],$row["MSKH"]);
        array_push($addresses ,$address->toArray());
      }
      return $addresses[0];
    }
    else
      return array("address"=>"Không Địa chỉ");
  }
?>