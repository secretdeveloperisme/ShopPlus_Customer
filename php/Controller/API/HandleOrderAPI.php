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