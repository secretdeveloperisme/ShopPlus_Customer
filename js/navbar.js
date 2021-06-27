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
});
