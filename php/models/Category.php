<?php


class Category
{
  private $id;
  private $name;
  public function __construct($id, $name)
  {
    $this->id = $id;
    $this->name = $name;
  }
  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function toArray(){
    return array(
      "id" => $this->getId(),
      "name" => $this->getName()
    );
  }
}
?>