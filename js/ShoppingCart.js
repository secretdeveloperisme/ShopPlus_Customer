$(function(){
  // render info customer nav bar
  let $navUserName = $(".nav-user-info__username");
  //customer handle
  let customer = null;
  customer = getLocalCustomer();
  updateNavUser(customer);
  //render product items
  function updateLocalProducts(products){
    window.localStorage.setItem("listCartProduct",JSON.stringify(products));
  }
  let $listProducts = $(".shop-app-cart-product-item");
  let productsJson = window.localStorage.getItem("listCartProduct");
  let products = JSON.parse(productsJson);
  products = products.map(function (value) {
    let product;
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleProductAPI.php?action=getProductViaId&id="+value.id,
      type: "GET",
      async : false,
      dataType : "text",
      success :function (response){
       product = JSON.parse(response);
       product.number = value.number;
      }
    })
    return product;
  });
  // valid product to submit payment
  let isValidProduct = ()=>{
    if(products.length < 1){
      return false;
    }
    return products.some(e=>e.number > 0);
  }
  function deleteProduct(index){
    products.splice(index,1);
  }
  function updateNumberOfProduct(){
    $numberOfPProduct.text($listProducts.length);
  }
  let $listProductContainer = $(".shop-app-cart-product-list");
  const $totalView =  $("#totalPrice");
  let $numberOfPProduct = $("#numberOfProduct");
  function render() {
    $listProductContainer.html("");
    products.forEach(function(value,index){
      let itemProductHTML = 
      `
      <li class="shop-app-cart-product-item" index="product${index}">
            <div class="shop-app-cart-product-item-image">
              <a href="#">
                <div class="shop-app-cart-product-item__image" style="background-image: url('${value.location}');">
                </div>
              </a>
            </div>
            <div class="shop-app-cart-product-item-content">
              <div class="cart-item-content-desc">
                <a href="#" class="cart-item-content-desc__name">
                  ${value.name}
                </a>
                <div class="cart-item-content-desc__price">
                  <span>${numberWithCommas(value.price)}</span> đ
                </div>
                <div class="cart-item-content-desc-action">
                  <button class="btn">Xóa</button>
                </div>
              </div>
              <div class="cart-item-content-amount">
                <div class="cart-item-content-input">
                  <button class="cart-item-content__minus btn" id="minusNumber">
                    <i class="fas fa-minus"></i>
                  </button>
                  <input type="text" class="cart-item-content__input" maxlength="3" value="${value.number}"  placeholder="0">
                  <button class="cart-item-content__plus btn" id="plusNumber">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
            </div>
          </li>
      `;
      $listProductContainer.html(function(i, originText){
        return originText + itemProductHTML;
      });
    })
    $listProducts = $(".shop-app-cart-product-item");
    renderEvent();
    calculateTotal();
    updateNumberOfProduct();
  }
  function renderEvent(){
    $listProducts.each(function (index, element) {
      let $minusNumber = $(this).find(".cart-item-content__minus");
      let $plusNumber = $(this).find(".cart-item-content__plus");
      let $numberOfPurchase = $(this).find(".cart-item-content__input");
      //add event change value input
      let $deleteProduct = $(element).find(".cart-item-content-desc-action button")
      $deleteProduct.click(function(){
        deleteProduct(index);
        updateLocalProducts(products);
        render();
      })
      let regexNumber = /^(\d|(Backspace))$/;
      $numberOfPurchase.on("input",function(){
        if($(this).val()=== ""){
          products[index].number = 0;
          console.log(products)
          updateLocalProducts(products);
        }
        else{
          products[index].number =Number.parseInt($(this).val());
          updateLocalProducts(products);
          console.log(products)
          calculateTotal();
        }
        
      })
      $numberOfPurchase.keydown(function (event) { 
        if(!regexNumber.test(event.key)){
          event.preventDefault();
        }     
      });
      $minusNumber.click(function (e) { 
        if(!($numberOfPurchase.val() == 0)){
          $numberOfPurchase.val(parseInt($numberOfPurchase.val())-1);
          products[index].number = (products[index].number - 1);
          updateLocalProducts(products);
          calculateTotal();
        }
         
      });
      $plusNumber.click(function (e) { 
        if($numberOfPurchase.val() < 999){
          $numberOfPurchase.val(parseInt($numberOfPurchase.val())+1);
          products[index].number = (products[index].number + 1);
          updateLocalProducts(products);
          calculateTotal();
        }
      });
    });
  }
  function calculateTotal(){
    let totalPrice = 0;
    products.forEach(function(element,index){
      let price = element.price;
      let amount = element.number;
      if(amount === "")
        amount = 0;
      totalPrice += parseFloat(price)*parseInt(amount);
      $totalView.text(numberWithCommas(totalPrice));
    })
    if(products.length === 0){
      $totalView.text(0)
    }
  }
  render();
  // add event for modal 
  let $btnCloseModal = $("#btnCloseModal");
  let $modal = $("#modal");
  $btnCloseModal.on("click",function(){
    $modal.fadeOut();
  });
  // add event order Button
  let storage = window.localStorage;
  let $orderForm = $("#orderForm");
  $orderForm.submit(function(event){
    if(!hasCustomer(customer)){
      $modal.fadeIn().css("display","flex");
      return false;
    }
    if(!isValidProduct()){
      showToast("Phải có ít nhất 1 sản phẩm  và số lượng là 1");
      return false;
    }
  });
  //add event login or sign up account customer
  let $inputUserEmail =  $(".input-user-email");
  let $emailCustomer = $("#emailCustomer");
  let regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  let $btnEmailButton = $inputUserEmail.find(".input-user-email-btn");
  $btnEmailButton.click(function(event){
    if(!regexEmail.test($emailCustomer.val())){
      toast({
        title : "Cảnh báo",
        message :"Email Không Hợp lệ",
        type: "warning",
        duration : 5000
      })
      return false;
    }
    if(!hasCustomerFormDB($emailCustomer.val())){
      $inputUserEmail.css("display","none");
      $inputUserEmail.next().css("display","flex")
    }
    else{
     updateLocalCustomer(getCustomerFromDB($emailCustomer.val()));
     customer = getLocalCustomer();
     updateNavUser();
      $modal.fadeOut();
    }
  })
  //add event input customer information
  let $btnSubmitInfo = $(".input-user-info__btn-submit");
  let $nameCustomer =$("#nameCustomer");
  let $companyCustomer =$("#companyCustomer");
  let $phoneCustomer= $("#phoneCustomer");
  let $addressCustomer= $("#addressCustomer");
  let regexPhone =  /^0\d{9,10}$/;
  $btnSubmitInfo.click(()=>{
    if($nameCustomer.val() == ""){
      toast({
        title : "Cảnh báo",
        message :"Tên Không Được Để trống",
        type: "warning",
        duration : 5000
      })
      return false;
    }
    if($emailCustomer.val() == ""){
      toast({
        title : "Cảnh báo",
        message :"Email Không Được Để trống",
        type: "warning",
        duration : 5000
      })
      return false;
    }
    if($phoneCustomer.val() == ""){
      toast({
        title : "Cảnh báo",
        message :"Số Điện Không Được Để trống",
        type: "warning",
        duration : 5000
      })
      return false;
    }
    if(!regexPhone.test($phoneCustomer.val())){
      toast({
        title : "Cảnh báo",
        message :"Số Điện Không Không Hợp lệ",
        type: "warning",
        duration : 5000
      });
      return false;
    }
    if($addressCustomer.val() == ""){
      toast({
        title : "Cảnh báo",
        message :"Địa Chỉ Không Được Để trống",
        type: "warning",
        duration : 5000
      });
      return false;
    }
    let customer = {
      name : $nameCustomer.val(),
      phone : $phoneCustomer.val(),
      email : $emailCustomer.val(),
      address : $addressCustomer.val(),
      companyName : $companyCustomer.val(),
    }
    let resultInsertObject =  insertCustomerIntoDB(customer);
    console.log(resultInsertObject);
    if(resultInsertObject.status == "success"){
      toast({
        title : "Thành công",
        message : resultInsertObject.msg,
        type : "success",
        duration : 5000
      });
      updateLocalCustomer(getCustomerFromDB(customer.email));
      customer = getLocalCustomer();
      updateNavUserName();
      $modal.fadeOut();
    }
    else{
      toast({
        title : "Thất Bại",
        message : resultInsertObject.msg,
        type : "error",
        duration : 5000
      });
    }

  });
})