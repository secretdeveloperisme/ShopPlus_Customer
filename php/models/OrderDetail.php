<?php
  class OrderDetail{
    private $orderId;
    private $idMerchandise;
    private $amount;
    private $oderPrice;
    private $discount;
    public function __construct($orderId, $idMerchandise, $amount, $oderPrice, $discount)
    {
      $this->orderId = $orderId;
      $this->idMerchandise = $idMerchandise;
      $this->amount = $amount;
      $this->oderPrice = $oderPrice;
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
    public function getOderPrice()
    {
      return $this->oderPrice;
    }
    public function setOderPrice($oderPrice)
    {
      $this->oderPrice = $oderPrice;
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
        "oderPrice" =>$this->getOderPrice(),
        "discount" =>$this->getDiscount()
      );
    }
  }
?>