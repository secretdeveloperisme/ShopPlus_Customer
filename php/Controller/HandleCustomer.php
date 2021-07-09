<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Customer/php/models/Customer.php");
  include($rootPath."/ShopPlus_Customer/php/ConnectDB.php");
  global $connect;
  $connect = connectDB();
  function getCustomerViaEmail($email){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSKH,HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL,MATKHAU FROM khachhang WHERE EMAIL= '$email'");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Customer(
        $row["MSKH"],
        $row['HOTENKH'],$row["TENCONGTY"],
        $row["SODIENTHOAI"],$row["EMAIL"],
        $row["MATKHAU"]
      );
    }
    else
      return false;
  }
  function getCustomerViaID($id){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSKH,HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL,MATKHAU FROM khachhang WHERE MSKH = $id");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Customer(
        $row["MSKH"],
        $row['HOTENKH'],$row["TENCONGTY"],
        $row["SODIENTHOAI"],$row["EMAIL"],
        $row["MATKHAU"]
      );
    }
    else
      return false;
  }
  function isExistCustomer($email,$password){
    $prepare = $GLOBALS["connect"]->prepare("SELECT is_valid_login_customer(?,?) AS VALID");
    $prepare->bind_param("ss",$email,$password);
    $prepare->execute();
    $result = $prepare->get_result();
    $row = $result->fetch_assoc();
    $valid = $row["VALID"];
    if($valid == 1)
      return true;
    else
      return false;
  }
  function isExistEmailAnotherAccount($email,$id){
    $result = $GLOBALS["connect"]->query(
      "SELECT * FROM khachhang WHERE EMAIL = '$email' and MSKH != $id"
    );
    if($result->num_rows == 0){
      return false;
    }
    else
      return true;
    }
  function insertCustomer($customer){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO khachhang(HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL,MATKHAU)VALUES(?,?,?,?,?)");
    $name = $customer->getName();
    $companyName = $customer->getCompanyName();
    $phone = $customer->getPhone();
    $email = $customer->getEmail();
    $password = $customer->getPassword();
    $prepare->bind_param("sssss",$name,$companyName,$phone,$email,$password);
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
function updateCustomer($customer){
  $prepare = $GLOBALS["connect"]->prepare(
    "UPDATE khachhang SET HOTENKH = ?,TENCONGTY = ?,SODIENTHOAI = ?,EMAIL = ?,MATKHAU = ? WHERE MSKH = ?"
  );
  $name = $customer->getName();
  $companyName = $customer->getCompanyName();
  $phone = $customer->getPhone();
  $email = $customer->getEmail();
  $id = $customer->getId();
  $password = $customer->GetPassword();
  $prepare->bind_param("sssssi",$name,$companyName,$phone,$email,$password,$id);
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
?>