<?php
  if(isset($_POST["action"]) && !empty($_POST["action"])){
    include "../../models/Customer.php";
    include("../../Controller/HandleOrder.php");
    if ($_POST["action"] == "order"){
      if(isset($_POST["customer"]) && !empty($_POST["customer"])){
        $rawCustomer = json_decode($_POST["customer"]);
        $customer = new Customer( $rawCustomer->id,"","","","");
        if(isset($_POST["products"]) && !empty($_POST["products"])){
          $rawProducts = json_decode($_POST["products"]);
          $orderDetails = array();
          foreach ($rawProducts as $rawProduct){
            $orderDetail = new OrderDetail(0,$rawProduct->id,$rawProduct->number,"","");
            array_push($orderDetails,$orderDetail);
          }
          $status =purchaseProducts($customer,$orderDetails)?"success":"error";
          echo json_encode(array("status" =>$status,"msg"=>"Mua hàng thành công"));
        }
      }
    }
  }
  if(isset($_GET["action"]) && !empty($_GET["action"])){
    include "../../models/Customer.php";
    include("../../Controller/HandleOrder.php");
    if ($_GET["action"] == "getOrdersViaCustomer"){
      if(isset($_GET["customerID"]) && !empty($_GET["customerID"])) {
        echo json_encode(getOrderViaCustomer($_GET["customerID"]));
      }
    }
    if ($_GET["action"] == "getDetailOrdersViaOrderID"){
      if(isset($_GET["orderID"]) && !empty($_GET["orderID"])) {
        echo json_encode(getDetailOrdersViaOrderID($_GET["orderID"]));
      }
    }
  }