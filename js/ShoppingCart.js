$(function(){
  // render info customer nav bar
  let $navUserName = $(".nav-user-info__username");
  //customer handle
  let customer = null;
  let updateLocalCustomer = () =>{
    customer = JSON.parse(localStorage.getItem("customer"));
  }
  function hasCustomer(){
    return customer != null;
  }
  let customerDB = null;
  function getCustomerFromDB(email){
    customerDB ={"name":"Nguyễn Hoàng Linh","phone":"0354882574","email":"linh072217@gmail.com","address":"Cần Thơ","company":""};
  }
  function hasCustomerFormDB(email){
    return false;
  }
  updateLocalCustomer();
  function updateNavUserName(){
    if(customer == null){
      $navUserName.text("Guest")
    }
    else{
      $navUserName.text(customer.name);
    }
  }
  updateNavUserName();
  //render product items
  let $listProducts = $(".shop-app-cart-product-item");
  products =[
    {
      id : 1,
      name : "Lược Sử Loài Người",
      urlProduct : "/assets/images/products/1f934d3ae7dba14ba9a0636b878b5a88_tn.jfif",
      price : 1,
      number : 1
    },
    {
      id : 2,
      name : "USB Máy Tính",
      urlProduct : "/assets/images/products/1f24a67376c5e98b3c3c08c6300e5c9b_tn.jfif",
      price : 2,
      number : 2
    },
    {
      id : 3,
      name : "Lược Sử Loài Người",
      urlProduct : "/assets/images/products/f9523e45a1a8a80b76f2eec49eeffe3c_tn.jfif",
      price : 3,
      number : 3
    }
  ];
  // valid product to submit payment
   isValidProduct = ()=>{
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
  };
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
                <div class="shop-app-cart-product-item__image" style="background-image: url(${value.urlProduct});">
                </div>
              </a>
            </div>
            <div class="shop-app-cart-product-item-content">
              <div class="cart-item-content-desc">
                <a href="#" class="cart-item-content-desc__name">
                  ${value.name}
                </a>
                <div class="cart-item-content-desc__price">
                  <span>${value.price}</span> đ
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
        render();
      })
      let regexNumber = /^(\d|(Backspace))$/;
      $numberOfPurchase.on("input",function(){
        calculateTotal();
        products[index].number =Number.parseInt($(this).val());
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
          products[index].number = (products[index].number - 1)
        }
         
      });
      $plusNumber.click(function (e) { 
        if($numberOfPurchase.val() < 999){
          $numberOfPurchase.val(parseInt($numberOfPurchase.val())+1);
          calculateTotal();
          products[index].number = (products[index].number + 1)
        }
      });
    });
  }
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
    if(products.length == 0){
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
    if(!hasCustomer()){
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
      company : $companyCustomer.val(),
    }
    storage.setItem("customer",JSON.stringify(customer));
    updateLocalCustomer();
    updateNavUserName();
    $modal.fadeOut();
    toast({
      title : "Thành Công",
      message : "Bạn đã điền thông tin thành công",
      type : "success",
      duration : 5000
    });

  }); 
})