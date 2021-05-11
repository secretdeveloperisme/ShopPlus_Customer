$(function(){
  $listProducts = $(".shop-app-cart-product-item");
  const $totalView =  $("#totalPrice");
  $listProducts.each(function (index, element) {
    let $minusNumber = $(this).find(".cart-item-content__minus");
    let $plusNumber = $(this).find(".cart-item-content__plus");
    let $numberOfPurchase = $(this).find(".cart-item-content__input");
    //add event change value input
    let regexNumber = /^(\d|(Backspace))$/;
    $numberOfPurchase.on("input",function(){
      calculateTotal();
    })
    $numberOfPurchase.keydown(function (event) { 
      if(!regexNumber.test(event.key)){
        event.preventDefault();
      }     
    });
    $minusNumber.click(function (e) { 
      if(!($numberOfPurchase.val() == 0)){
        $numberOfPurchase.val(parseInt($numberOfPurchase.val())-1);
        calculateTotal();
      }
       
    });
    $plusNumber.click(function (e) { 
      if($numberOfPurchase.val() < 999){
        $numberOfPurchase.val(parseInt($numberOfPurchase.val())+1);
        calculateTotal();
      }
    });
  });
  function calculateTotal(){
    let totalPrice = 0;
    $listProducts.each(function(index,element){
      let price = $(element).find(".cart-item-content-desc__price > span").text();
      let amount = $(element).find(".cart-item-content__input").val();
      if(amount == "")
        amount = 0;
      totalPrice += parseFloat(price)*parseInt(amount);
      $totalView.text(totalPrice.toFixed(3));
    })
  }
  calculateTotal();
})