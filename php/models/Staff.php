<?php
  include("Person.php");
  class Staff extends Person{
    private $id;
    private $position;
    private $address;
    public function __construct($id,$name,$position,$address,$phone){
      parent::__construct($name,$phone);
      $this->id = $id;
      $this->position = $position;
      $this->address = $address;
    }
    public function getId(){
      return $this->id;
    }
    public function setId($id){
      $this->id = $id;
    }
    public function getPosition(){
      return $this->position;
    }
    public function setPosition($position){
      $this->position = $position;
    }
    public function getAddress(){
      return $this->address;
    }
    public function setAddress($address){
      $this->address = $address;
    }
    public function toArray(){
      return array(
        "id" => $this->getId(),
        "name" => parent::getName(),
        "position" => $this->getPosition(),
        "address" => $this->getAddress(),
        "phone" => parent::getPhone()
      );
    }
  }
?>