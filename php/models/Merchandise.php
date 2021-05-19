<?php
  class Merchandise{
    private $id;
    private $name;
    private $location;
    private $amount;
    private $unit;
    private $price;
    private $categoryId;
    private $note;
    public function __construct($id,$name,$location,$unit,$price,$amount,$categoryId,$note){
      $this->id = $id;
      $this->name = $name;
      $this-> location = $location;
      $this->unit = $unit;
      $this->price = $price;
      $this->categoryId = $categoryId;
      $this->note = $note;
      $this->amount = $amount;
    }
  public function getId(){
    return $this->id;
  }
  public function getName(){
    return $this->name;
  }
  public function getLocation(){
    return $this->location;
  }
  public function geUnit(){
    return $this->unit;
  }
  public function getPrice(){
    return $this->price;
  }
  public function getCategoryId(){
    return $this->categoryId;
  }
  public function getNote(){
    return $this->note;
  }
  public function setId($id)
  {
      $this->id = $id;
  }
  public function setName($name)
  {
      $this->name = $name;
  }
  public function setLocation($location)
  {
      $this->location = $location;
  }
  public function setUnit($unit)
  {
      $this->unit = $unit;
  }
  public function setPrice($price)
  {
      $this->price = $price;
  }

  public function setCategoryId($categoryId)
  {
      $this->categoryId = $categoryId;
  }
  public function setNote($note)
  {
      $this->note = $note;
  }

    /**
     * @return mixed
     */
    public function getAmount()
    {
      return $this->amount;
    }
    public function setAmount($amount): void
    {
      $this->amount = $amount;
    }
  public function getPriceWithComma(){
      return preg_replace("/\B(?=(\d{3})+(?!\d))/",",",$this->getPrice());
  }
  public function toArray(){
    return array(
      "id"=>$this->id,
      "name"=>$this->name,
      "location"=>$this->location,
      "unit"=>$this->unit,
      "price"=>$this->price,
      "amount"=>$this->amount,
      "categoryId"=>$this->categoryId,
      "note"=>$this->note);
  }
  }
?>