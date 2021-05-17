<?php
  class Person{
    protected $name = "unknown";
    protected $phone ="0";
    function __construct($name,$phone){
      $this->name = $name;
      $this->phone = $phone;
    }
    public function getName(){
      return $this->name;
    }
    public function setName($name){
      $this->name = $name;
    }
    public function getPhone(){
      return $this->phone;
    }
    public function setPhone($phone){
      $this->phone = $phone;
    }
    public function toArray(){
      return array(
        "id" => $this->getName(),
        "phone" => $this->getPhone()
      );
    }
  }
?>