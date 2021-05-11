$(function(){
  let $listProducts = $(".shop-app-cart-product-item");
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
    }
  ]
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
        products[index].number = $(this).val();
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
  function deleteProduct(index){
    products.splice(index,1);
    console.log(products);
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
  function updateNumberOfProduct(){
    $numberOfPProduct.text($listProducts.length);
  }
  render();
})