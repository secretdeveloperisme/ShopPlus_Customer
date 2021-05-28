<?php
//  header('Content-Type: text/html');
  if (isset($_GET["action"]) && !empty($_GET["action"])) {
    include("../../Controller/HandleCustomer.php");
    if ($_GET["action"] == "getCustomerViaEmail" && isset($_GET["email"]) && !empty($_GET["email"])) {
      echo json_encode(getCustomerViaEmail($_GET["email"])->toArray());
    }
    if ($_GET["action"] == "isExistCustomer" && isset($_GET["email"]) && !empty($_GET["email"])) {
      echo json_encode(isExistCustomer($_GET["email"]));
    }
  }
  if(isset($_POST["action"])&& !empty($_POST["action"])){
    include("../../Controller/HandleCustomer.php");
    if($_POST["action"] == "insertCustomer"){
      if(!empty($_POST["name"]) && !(empty($_POST["phone"]))&& !empty($_POST["email"]) && isset($_POST["companyName"])){

          if(insertCustomer(
            new Customer("0",$_POST["name"],$_POST["companyName"],$_POST["phone"],$_POST["email"])
          )){
            echo json_encode(array("status"=>"success","msg"=>"bạn đã thên tài khoản thành công"));
          }
          else
            echo json_encode(array("status"=>"failed","msg"=>"thêm tài khoản thất bại"));
      }
    }
    if($_POST["action"]=="updateCustomer"){
      if(isset($_POST["id"])&&!empty($_POST["id"])){
        if(!(empty($_POST["name"])) && !(empty($_POST["phone"]))&&!(empty($_POST["email"]))&&!(empty($_POST["companyName"]))) {
          if (!isExistEmailAnotherAccount($_POST["email"], $_POST["id"])) {
            if (updateCustomer(
              new Customer($_POST["id"], $_POST["name"], $_POST["companyName"], $_POST["phone"], $_POST["email"])
            )) {
              echo json_encode(array("status" => "success", "msg" => "bạn đã chỉnh sửa tài khoản thành công"));
            } else
              echo json_encode(array("status" => "failed", "msg" => "chỉnh sửa tài khoản thất bại"));
          }
          else
            echo json_encode(array("status"=> "failed","msg"=>"email đã tồn tại"));
         }
        }
    }
  }
?>