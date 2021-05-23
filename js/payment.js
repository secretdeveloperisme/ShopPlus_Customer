$(function(){
  let $listProducts = $(".shop-app-payment-product-item");
  let $customerName = $("#customerName");
  let $customerPhone = $("#customerPhoneNumber");
  let $customerAddress = $("#customerAddress");
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
  let $listProductContainer = $(".shop-app-payment-product-list");
  const $totalView =  $("#totalPrice");
  let $numberOfPProduct = $("#numberOfProduct");
  function renderProductList() {
    $listProductContainer.html("");
    products.forEach(function(value,index){
      let itemProductHTML = 
      `
      <li class="shop-app-payment-product-item" index="product${index}">
            <div class="shop-app-payment-product-item-image">
              <a href="#">
                <div class="shop-app-payment-product-item__image" style="background-image: url('${value.location}');">
                </div>
              </a>
            </div>
            <div class="shop-app-payment-product-item-content">
              <div class="payment-item-content-desc">
                <a href="#" class="payment-item-content-desc__name">
                  ${value.name}
                </a>
                <div class="payment-item-content-desc__price">
                  <span>${numberWithCommas(value.price)}</span> đ
                </div>    
              </div>
              <div class="payment-item-content-amount">
                <div class="payment-item-content-input">
                  <span class="payment-item-content__label"> Số Lượng :</span>
                  <input type="text" class="payment-item-content__input" maxlength="3" value="${value.number}"  disabled placeholder="0">
                </div>
              </div>
            </div>
          </li>
      `;
      if(value.number != 0){
        $listProductContainer.html(function(i, originText){
          return originText + itemProductHTML;
        });
      }

    })
    $listProducts = $(".shop-app-payment-product-item");
    calculateTotal();
    updateNumberOfProduct();
  }
  function deleteProduct(index){
    products.splice(index,1);
    console.log(products);
  }
  function calculateTotal(){
    let totalPrice = 0;
    products.forEach(function(value,index){
      let price = value.price;
      let amount = value.number;
      if(amount === "")
        amount = 0;
      totalPrice += parseInt(price)*amount;
      $totalView.text(numberWithCommas(totalPrice));
    });
    if(products.length === 0){
      $totalView.text(0)
    }
  }
  function updateNumberOfProduct(){
    $numberOfPProduct.text($listProducts.length);
  }
  function renderCustomerInFo(){
    let customer = getLocalCustomer();
    $customerName.text(customer.name);
    $customerPhone.text(customer.phone);
    $customerAddress.text(customer.address)
  }
  renderCustomerInFo();
  renderProductList();
});