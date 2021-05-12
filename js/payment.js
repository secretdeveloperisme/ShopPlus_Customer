$(function(){
  let $listProducts = $(".shop-app-payment-product-item");
  let products =[
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
    },
    {
      id : 4,
      name : "Lược Sử Loài Người",
      urlProduct : "/assets/images/products/8881955f7ad0ffc82cb7ac90dd871bd6.jfif",
      price : 15,
      number : 9
    },
  ]
  let $listProductContainer = $(".shop-app-payment-product-list");
  const $totalView =  $("#totalPrice");
  let $numberOfPProduct = $("#numberOfProduct");
  function render() {
    $listProductContainer.html("");
    products.forEach(function(value,index){
      let itemProductHTML = 
      `
      <li class="shop-app-payment-product-item" index="product${index}">
            <div class="shop-app-payment-product-item-image">
              <a href="#">
                <div class="shop-app-payment-product-item__image" style="background-image: url(${value.urlProduct});">
                </div>
              </a>
            </div>
            <div class="shop-app-payment-product-item-content">
              <div class="payment-item-content-desc">
                <a href="#" class="payment-item-content-desc__name">
                  ${value.name}
                </a>
                <div class="payment-item-content-desc__price">
                  <span>${value.price}</span> đ
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
      $listProductContainer.html(function(i, originText){
        return originText + itemProductHTML;
      });
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
    $listProducts.each(function(index,element){
      let price = $(element).find(".payment-item-content-desc__price > span").text();
      let amount = $(element).find(".payment-item-content__input").val();
      if(amount == "")
        amount = 0;
      totalPrice += parseFloat(price)*parseInt(amount);
      $totalView.text(totalPrice.toFixed(3));
    })
    if(products.length == 0){
      $totalView.text(0)
    }
  }
  function updateNumberOfProduct(){
    $numberOfPProduct.text($listProducts.length);
  }
  render();
})