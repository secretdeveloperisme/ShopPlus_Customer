<?php
  class Merchandise{
    private $id;
    private $name;
    private $location;
    private $unit;
    private $price;
    private $categoryId;
    private $note;
    public function __construct($id,$name,$location,$unit,$price,$categoryId,$note){
      $this->id = $id;
      $this->name = $name;
      $this-> location = $location;
      $this->unit = $unit;
      $this->price = $price;
      $this->categoryId = $categoryId;
      $this->note = $note; 
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

  }
?>