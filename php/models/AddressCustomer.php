<?php


class AddressCustomer
{
  private $addressId;
  private $addressText;
  private $customerId;
  public function __construct($addressId, $addressText, $customerId)
  {
    $this->addressId = $addressId;
    $this->addressText = $addressText;
    $this->customerId = $customerId;
  }
  public function getAddressId()
  {
    return $this->addressId;
  }
  public function setAddressId($addressId)
  {
    $this->addressId = $addressId;
  }
  public function getAddressText()
  {
    return $this->addressText;
  }
  public function setAddressText($addressText)
  {
    $this->addressText = $addressText;
  }
  public function getCustomerId()
  {
    return $this->customerId;
  }
  public function setCustomerId($customerId)
  {
    $this->customerId = $customerId;
  }
  public function toArray(){
    return array(
      "addressId" => $this->getAddressId(),
      "addressText" => $this->getAddressText(),
      "customerId" => $this->getCustomerId()
    );
  }
}
?>