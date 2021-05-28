<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Customer/php/models/Order.php");
  include($rootPath."/ShopPlus_Customer/php/models/OrderDetail.php");
  include($rootPath."/ShopPlus_Customer/php/Controller/HandleProduct.php");
  global $connect;
  $connect = connectDB();
  function insertOrder($order){
    $insertId = 0;
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO DATHANG(MSKH,NGAYDH,TRANGTHAI) VALUES (?,?,?)");
    $idCustomer = $order->getIdCustomer();
    $orderDate = $order->getOrderDate();
    $status = $order->getStatus();
    $prepare->bind_param("sss",$idCustomer,$orderDate,$status);
    if($prepare->execute()){
      $insertId = $GLOBALS["connect"]->insert_id;
      return $insertId;
    }
    else{
      return $insertId;
    }
  }
  function insertOrderDetail($orderDetail){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO CHITIETDATHANG(SODONDH,MSHH,SOLUONG,GIADATHANG,GIAMGIA) VALUES (?,?,?,?,?)");
    $orderId = $orderDetail->getOrderId();
    $orderMerchandiseId = $orderDetail->getIdMerchandise();
    $product = getProductViaID($orderMerchandiseId);
    $amount = $orderDetail->getAmount();
    $discount = $orderDetail->getDiscount();
    $orderPrice = ($product->getPrice() - $product->getPrice() * $discount);
    $prepare->bind_param("iiiid",$orderId,$orderMerchandiseId,$amount,$orderPrice,$discount);
    if($prepare->execute()){
      return true;
    }
    else{
      return false;
    }
  }
  function purchaseProducts($customer,$orderDetails){
    $order = new Order(0,$customer->getId(),0,date("Y-m-d"),"","processing");
    $isSuccess = true;
    if($orderID = insertOrder($order)){
      if($orderID != 0){
        foreach($orderDetails as $orderDetail){
          $orderDetail = new OrderDetail($orderID,$orderDetail->getIdMerchandise(),$orderDetail->getAmount(),0,0);
          if(!insertOrderDetail($orderDetail)){
            $isSuccess = false;
          }
        }
      }
    }
    else
      $isSuccess = false;
    return $isSuccess;
  }
  function getOrderViaCustomer($id){
    $orders = array();
    $prepare  = $GLOBALS["connect"]->prepare("CALL getOrderViaCustomer(?)");
    $id_customer = $id;
    $prepare->bind_param("i",$id_customer);
    if($prepare->execute()){
     $result = $prepare->get_result();
     if($result->num_rows > 0){
       while ($row = $result->fetch_assoc()){
         $order = new Order($row["SODONDH"],$row["MSKH"],$row["MSNV"],$row["NGAYDH"],$row["NGAYGH"],$row["TRANGTHAI"]);
         array_push($orders,$order->toArray());
       }
      }
    }
    return $orders;
  }