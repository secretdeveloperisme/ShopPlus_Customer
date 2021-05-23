$(function(){
  updateNavUser();
  const $minusNumber = $("#minusNumber");
  const $plusNumber = $("#plusNumber");
  const $numberOfPurchase = $("#numberOfPurchase");
  const regexNumber = /^(\d|(Backspace))$/;
  $numberOfPurchase.keydown(function (event) { 
    console.log(event);
    if(!regexNumber.test(event.key)){
      event.preventDefault();
    }
  });
  $minusNumber.click(function (e) { 
    if(!($numberOfPurchase.val() == 0))
      $numberOfPurchase.val(parseInt($numberOfPurchase.val())-1)
  });
  $plusNumber.click(function (e) { 
    if($numberOfPurchase.val() < 999)
      $numberOfPurchase.val(parseInt($numberOfPurchase.val())+1)
  });
  // add event for two button
  let $productItem = $("#productItem");
  let $btnAddCart = $("#btnAddCart");
  let $btnPurchase = $("#btnPurChase");
  $btnAddCart.click((event)=>{
    insertCartProduct(parseInt($productItem.attr("productId")),parseInt($numberOfPurchase.val()));
    toast({
        title: "Thêm Thành Công",
        message: "thêm sản phẩm vào giỏ hàng thành công, vui lòng check giỏ hàng ",
        type: "success",
        duration: 5000
      });
    updateCartList();
  })
})