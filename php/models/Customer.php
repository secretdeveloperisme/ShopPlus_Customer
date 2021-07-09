<?php
  require("Person.php");
  class Customer extends Person{
    private $id;
    private $companyName;
    private $email;
    private $password;
    function __construct($id,$name,$companyName,$phone,$email,$password){
      parent::__construct($name,$phone);
      $this->id = $id;
      $this->companyName = $companyName;
      $this->email = $email;
      $this->password = $password;
    }
    public function getId(){
      return $this->id;
    }
    public function setId($id){
      $this->id = $id;
    }
    public function getCompanyName(){
      return $this->companyName;
    }
    public function setNameCompany($nameCompany){
      $this->companyName = $nameCompany;
    }
    public function getEmail(){
      return $this->email;
    }
    public function setEmail($email){
      $this->email = $email;
    }

    public function getPassword() {
      return $this->password;
    }

    public function setPassword($password): void {
      $this->password = $password;
    }

    public function toArray(){
      return array(
        "id" => $this->getId(),
        "name" => parent::getName(),
        "companyName" => $this->getCompanyName(),
        "phone" => parent::getPhone(),
        "email" => $this->getEmail(),
        "password" => $this->getPassword()
      );
    }
  }
?>