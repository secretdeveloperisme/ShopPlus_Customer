//window.localStorage.setItem("listCartProduct","[ { \"id\": 30, \"amount\": 2 }, { \"id\": 31, \"amount\": 2 }, { \"id\": 32, \"amount\": 2 } ]");
$(()=>{
  uploadCartList();
})
function uploadCartList(){
  $navCart = $(".nav-cart");
  let $cartList = $(".nav-cart-dropdown-content-list");
  $cartList.html("");
  let localCartProductsString = window.localStorage.getItem("listCartProduct");
  let localCartProducts = JSON.parse(localCartProductsString);
  $navCart.find(".nav-cart-quantities").text(localCartProducts.length);
  localCartProducts.forEach(function(value,index){
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleProductAPI.php?action=getProductViaId&id="+value.id,
      type: "GET",
      dataType : "text",
      success :function (response) {
        let product = JSON.parse(response);
        let itemCartView =`
              <li class="nav-cart-dropdown-content-item">
                <a href="/ShopPlus_Customer/ProductDetail/product_detail.php?id= ${product.id}">
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(${product.location});"></div>
                  <div class="nav-cart-dropdown-content-item__name">${product.name}</div>
                  <div class="nav-cart-dropdown-content-item__price">${numberWithCommas(product.price)} đ</div>
                </a>
              </li>
        `;
        $cartList.html(function(index,current){
          return current + itemCartView;
        });
      }
    })
  })
}
