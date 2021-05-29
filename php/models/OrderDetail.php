<?php
  class OrderDetail{
    private $orderId;
    private $idMerchandise;
    private $amount;
    private $orderPrice;
    private $discount;
    public function __construct($orderId, $idMerchandise, $amount, $orderPrice, $discount)
    {
      $this->orderId = $orderId;
      $this->idMerchandise = $idMerchandise;
      $this->amount = $amount;
      $this->orderPrice = $orderPrice;
      $this->discount = $discount;
    }
    public function getOrderId()
    {
      return $this->orderId;
    }
    public function setOrderId($orderId)
    {
      $this->orderId = $orderId;
    }
    public function getIdMerchandise()
    {
      return $this->idMerchandise;
    }
    public function setIdMerchandise($idMerchandise)
    {
      $this->idMerchandise = $idMerchandise;
    }
    public function getAmount()
    {
      return $this->amount;
    }
    public function setAmount($amount)
    {
      $this->amount = $amount;
    }
    public function getOrderPrice()
    {
      return $this->orderPrice;
    }
    public function setOrderPrice($oderPrice)
    {
      $this->orderPrice = $oderPrice;
    }
    public function getDiscount()
    {
      return $this->discount;
    }
    public function setDiscount($discount)
    {
      $this->discount = $discount;
    }
    public function toArray(){
      return array(
        "orderId" =>$this->getOrderId(),
        "idMerchandise" =>$this->getIdMerchandise(),
        "amount" =>$this->getAmount(),
        "orderPrice" =>$this->getOrderPrice(),
        "discount" =>$this->getDiscount()
      );
    }
  }
?>