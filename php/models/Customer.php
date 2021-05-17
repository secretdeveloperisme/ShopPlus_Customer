<?php
  require("Person.php");
  class Customer extends Person{
    private $id;
    private $nameCompany;
    private $email;
    function __construct($id,$name,$nameCompany,$phone,$email){
      parent::__construct($name,$phone);
      $this->id = $id;
      $this->nameCompany = $nameCompany;
      $this->email = $email;
    }
    public function getId(){
      return $this->id;
    }
    public function setId($id){
      $this->id = $id;
    }
    public function getNameCompany(){
      return $this->nameCompany;
    }
    public function setNameCompany($nameCompany){
      $this->nameCompany = $nameCompany;
    }
    public function getEmail(){
      return $this->email;
    }
    public function setEmail($email){
      $this->email = $email;
    }
  }
?>