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
      $prepare->close();
      $GLOBALS["connect"]->close();
      return $insertId;
    }
    else{
      $prepare->close();
      $GLOBALS["connect"]->close();
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
    $orderPrice = $product->getPrice() - $product->getPrice() * $discount;
    $prepare->bind_param("iiiid",$orderId,$orderMerchandiseId,$amount,$orderPrice,$discount);
    if($prepare->execute()){
      $prepare->close();
      $GLOBALS["connect"]->close();
      return "true";
    }
    else{
      $prepare->close();
      $GLOBALS["connect"]->close();
      return "false";
    }
  }
  echo insertOrderDetail(new OrderDetail(1,42,7,250000,0.1));