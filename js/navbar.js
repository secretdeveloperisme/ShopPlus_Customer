$(function(){
  updateNavUser()
  let $searchInput = $(".nav-search-form-input__box");
  let $searchAutoCompleteList = $(".nav-search-form-input-autocomplete-list")
  $searchInput.keypress((event)=>{
    let q = $searchInput.val()+ event.key;
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleAutoCompleteSearchAPI.php",
      type : "GET",
      data : {
        action : "getProductsViaString",
        "q" : q
      },
      dataType : "text",
      success : (response)=>{
       let products = JSON.parse(response);
       $searchAutoCompleteList.html("")
       if(products !== null){
          products.forEach((value,index)=>{
            let item = `
              <li class="nav-search-form-input-autocomplete-item">
                <a href="/ShopPlus_Customer/search/search.php?queryString=${value.name}&page=1">
                  <span class="nav-search-form-input-autocomplete-item__icon">
                  <i class="fas fa-search"></i>
                  </span>
                  <span class="nav-search-form-input-autocomplete-item__label">${value.name.trim()}</span>
                </a>
              </li>
              `
              $searchAutoCompleteList.html((index,current)=>{
                return current+item;
              })
          })
        }
      }
    })
  })
  $(".nav-search-form-input__box").focus((event)=>{
    $(".nav-search-form-input-autocomplete").css("display","block")
  })
  $(".nav-search-form-input__box").focusout((event)=>{
    setTimeout(()=>{
      $(".nav-search-form-input-autocomplete").css("display","none")
    },500)
  })
  // display all categories Mobile
  let $categoriesListTag = $("#categoriesList");
  if($categoriesListTag.length != 0){
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleCategoryAPI.php",
      type : "GET",
      data : {
        action : "getAllCategories"
      },
      dataType : "json",
      success : (response)=>{
        let categories = JSON.parse(response)
        categories.forEach((value,index)=>{
          let categoryItem = `
            <li class="nav-mobile-categories__item" categoryID="${value.id}"><a>${value.name}</a></li>
          `
          $categoriesListTag.html((i,current)=>{
            return current + categoryItem
          })
        })
        let $categoryItems = $categoriesListTag.children();
        $.each($categoryItems,(index,value)=>{
          $(value).click((event)=>{
            let queryString = {}
            queryString["categoryID"] = $(value).attr("categoryID")
            queryString["page"] = "1"
            let urlParameter = new URLSearchParams(queryString).toString()
            window.open("search/search.php?"+urlParameter,"_top")
          })
        })
      }
    })

  }
  updateNavUserMobile();
  function updateNavUserMobile(){
    let $navUser = $(".nav-mobile-user");
    let customer = null;
    customer = getLocalCustomer();
    updateNavUserName(customer);
    if(!hasCustomer(customer)){
      $navUser.find("nav-mobile-user__list").html("");
    }
    else
    {
      $.ajax({
        url : "/ShopPlus_Customer/php/Controller/API/HandleSessionAPI.php",
        type : "POST",
        data : {
          action : "setSession",
          content : JSON.stringify(customer)
        },
        dataType : "text",
        success : (response)=>{
          if(response != ""){
            console.log(JSON.parse(response))
          }
        }
      })
      $navUser.find(".nav-mobile-user__list").html(
        `
          <li class="nav-mobile-user__item" id="myOrderMobile"><a href="">Đơn hàng của tôi</a></li>
          <li class="nav-mobile-user__item" id="myInfoMobile"><a href="">Thông Tin Của tôi</a></li>
          <li class="nav-mobile-user__item" id="deleteMyInfoMobile"><a href="">Xóa Thông Tin Của Tôi</a></li>
        `
      );
      let $myOrder = $("#myOrderMobile");
      let $myInfo = $("#myInfoMobile");
      let $deleteMyInfo = $("#deleteMyInfoMobile");
      $myInfo.find("a").attr("href",`/ShopPlus_Customer/customer/info.php?customerID=${customer.id}&action=info`)
      $myOrder.find("a").attr("href",`/ShopPlus_Customer/customer/info.php?customerID=${customer.id}&action=order`)
      $deleteMyInfo.click(function (event) {
        removeLocalCustomer();
        updateNavUser();
      })
    }
  }
});
