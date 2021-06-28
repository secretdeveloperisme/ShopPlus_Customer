$(function(){
  updateNavUser();
  const $minusNumber = $("#minusNumber");
  const $plusNumber = $("#plusNumber");
  const $numberOfPurchase = $("#numberOfPurchase");
  const regexNumber = /^(\d|(Backspace))$/;
  const $amountOfProduct = $("#amountOfProduct");
  const availableAmount = parseInt($amountOfProduct.text());
  $numberOfPurchase.keydown(function (event) {
    if(!regexNumber.test(event.key)){
      event.preventDefault();
    }
    if(event.key != "Backspace"){
      let numberInput = $(this).val() + event.key;
      if(parseInt(numberInput) > availableAmount)
        event.preventDefault();
    }

  });
  $minusNumber.click(function (e) {
    if(!($numberOfPurchase.val() == 0))
      $numberOfPurchase.val(parseInt($numberOfPurchase.val())-1)
  });
  $plusNumber.click(function (e) { 
    if($numberOfPurchase.val() < availableAmount)
      $numberOfPurchase.val(parseInt($numberOfPurchase.val())+1)
  });
  // add event for two button
  let $productItem = $("#productItem");
  let $btnAddCart = $("#btnAddCart");
  let $btnPurchase = $("#btnPurchase");
  $btnAddCart.click((event)=>{
    if(parseInt($numberOfPurchase.val()) > 0)
    {
      insertCartProduct(parseInt($productItem.attr("productId")),parseInt($numberOfPurchase.val()));
      toast({
        title: "Thêm Thành Công",
        message: "thêm sản phẩm vào giỏ hàng thành công, vui lòng check giỏ hàng ",
        type: "success",
        duration: 5000
      });
      updateCartList();
    }
    else
      toast({
        title: "Thêm Thất Bại",
        message: "Số lượng sản phẩm thêm vào giỏ hàng phải lớn hơn 0!",
        type: "error",
        duration: 5000
      });
  })
  $btnPurchase.click((event)=>{
    if(parseInt($numberOfPurchase.val()) !== 0){
      insertCartProduct(parseInt($productItem.attr("productId")),parseInt($numberOfPurchase.val()));
    }
    else {
      toast({
        title: "Thêm Thất Bại",
        message: "Số lượng sản phẩm thêm vào giỏ hàng phải lớn hơn 0!",
        type: "error",
        duration: 5000
      });
      return false;
    }
    if(getLocalCustomer() != null){
      window.open("/ShopPlus_Customer/checkout/payment/payment.html","_parent");
    }
    else{
      window.open("/ShopPlus_Customer/checkout/shopping_cart/shopping_cart.html","_parent")
    }

  })
  // add event for more description button
  let $btnMore = $("#btnMore")
  let $descriptionContent = $(".shop-app-product-description-content")
  if($descriptionContent.find(".description__text").height() <=150){
    $btnMore.remove()
    $descriptionContent.removeClass("disappear")
  }
  $btnMore.click((event)=>{
    if($descriptionContent.hasClass("disappear")){
      $descriptionContent.removeClass("disappear")
      $btnMore.text("Thu Gọn")
    }
    else{
      $descriptionContent.addClass("disappear")
      $btnMore.text("Xem Thêm")
    }
  })
});