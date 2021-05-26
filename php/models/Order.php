<?php
  class Order{
    private $id;
    private $idCustomer;
    private $idStaff;
    private $orderDate;
    private $deliverDate;
    private $status;
    public function __construct($id, $idCustomer, $idStaff, $orderDate, $deliverDate, $status)
    {
      $this->id = $id;
      $this->idCustomer = $idCustomer;
      $this->idStaff = $idStaff;
      $this->orderDate = $orderDate;
      $this->deliverDate = $deliverDate;
      $this->status = $status;
    }
    public function getId()
    {
      return $this->id;
    }
    public function setId($id)
    {
      $this->id = $id;
    }
    public function getIdCustomer()
    {
      return $this->idCustomer;
    }
    public function setIdCustomer($idCustomer)
    {
      $this->idCustomer = $idCustomer;
    }
    public function getIdStaff()
    {
      return $this->idStaff;
    }
    public function setIdStaff($idStaff)
    {
      $this->idStaff = $idStaff;
    }
    public function getOrderDate()
    {
      return $this->orderDate;
    }
    public function setOrderDate($orderDate)
    {
      $this->orderDate = $orderDate;
    }
    public function getDeliverDate()
    {
      return $this->deliverDate;
    }
    public function setDeliverDate($deliverDate)
    {
      $this->deliverDate = $deliverDate;
    }
    public function getStatus()
    {
      return $this->status;
    }
    public function setStatus($status)
    {
      $this->status = $status;
    }
    public function toArray(){
      return array(
        "id" => $this->getId(),
        "idCustomer" => $this->getIdCustomer(),
        "idStaff" => $this->getIdStaff(),
        "orderDate" => $this->getOrderDate(),
        "deliverDate" => $this->getDeliverDate(),
        "status" => $this->getStatus()
      );
    }
  }

?>