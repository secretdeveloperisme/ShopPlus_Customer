$(function(){
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
})