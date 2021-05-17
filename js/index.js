$(function(){
  // base function
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
  //render slideshow
  let $slideshow = $(".container-shop-app-ad__slideshow");
  let $slides = $(".container-shop-app__slides");
  let lengthOfSlides = $slides.children().length;
  let slideshowWidth = $slideshow.outerWidth();
  let $nextBtn = $(".slideshow-btn--next");
  let $backBtn = $(".slideshow-btn--previous");
  let $slidePagination = $(".slideshow-pagination")
  $nextBtn.click(nextSlide);
  $backBtn.click(backSlide);
  let indexSlide = 1;
  $slidePagination.children().each(function(index){    
    $(this).click(function(){
      $slidePagination.children().eq(indexSlide-1).removeClass("slideshow-pagination__item--active");
      showSlide(index+1);
      $(this).addClass("slideshow-pagination__item--active");
    });
  })
  function nextSlide() {
    $slidePagination.children().eq(indexSlide-1).removeClass("slideshow-pagination__item--active");  
    if(indexSlide > (lengthOfSlides-1)){
      indexSlide = 1;
      $slides.css("transform",`translateX(${slideshowWidth*(indexSlide-1)}px)`);
    }
    else{
      $slides.css("transform",`translateX(-${slideshowWidth*indexSlide}px)`);
      indexSlide++;
    }
    $slidePagination.children().eq(indexSlide-1).addClass("slideshow-pagination__item--active");
  }
  
  function showSlide(i){
    if(i > indexSlide){
      let n = (i-indexSlide);
      for(let j = 0 ; j < n ;j++){
          nextSlide();
      }
      console.log(indexSlide);
    }
    else if(i < indexSlide){
      let n = (indexSlide -i);
      console.log(n);
      for(let j = 0 ; j < n;j++){
          backSlide();
      }
    }

  }
  function backSlide() {  
    $slidePagination.children().eq(indexSlide-1).removeClass("slideshow-pagination__item--active"); 
    if(indexSlide <= 1){
      indexSlide = lengthOfSlides;
      $slides.css("transform",`translateX(-${slideshowWidth*(lengthOfSlides-1)}px)`)
    }
    else{
      $slides.css("transform",`translateX(-${slideshowWidth*(indexSlide)-2*slideshowWidth}px)`);
    indexSlide--;
    }
    $slidePagination.children().eq(indexSlide-1).addClass("slideshow-pagination__item--active");
  }
  setInterval(function(){
    nextSlide();
  },3000);
  // render products
  let $displayProductsContainer = $(".shop-app-product-display");
  function updateProduct(){
    let products = [];
    $.ajax({
      type: "GET",
      async : false,
      url: "php/Controller/HandleProductAPI.php?action=getAllProduct",
      data: "",
      dataType: "text",
      success: function (response) {
        products = JSON.parse(response);
       
      }
    });
    if(products.length != 0){
      products.forEach(function(value,index){
        let productItem = `
        <div class="shop-app-product-display-item col-xl-2 col-es-6">
        <a href="#">
          <div class="product-display-item-container">
            <div class="product-display-container-box-shadow">
              <div class="product-display-item__img" style="background-image: url('${value.location}');"></div>
              <div class="product-display-item__favorite">
                Yêu thích
              </div>
              <div class="product-display-item-description">
                <div class="product-display-item-description__name">
                  ${value.name}
                </div>
                <div class="product-display-item-description-sell">
                  <h2 class="product-display-item-description-sell__price">${numberWithCommas(value.price)} đ</h2>
                  <h2 class="product-display-item-description-sell__sold">Đã bán <span class="price">2</span></h2>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
        `;
        $displayProductsContainer.html(
          function (index,currentContent){
            return currentContent + productItem;
          }
        )
      })
    }
  }
  updateProduct();
});