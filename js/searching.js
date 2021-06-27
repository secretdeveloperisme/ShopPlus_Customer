$(()=>{
  let queryString = {}
  if(location.search !== "")
    queryString = getQueryStringURLasObject()
  queryString
  let $btnAscPrice = $("#btnAscPrice")
  let $btnDescPrice = $("#btnDescPrice")
  $btnAscPrice.click((event)=>{
    queryString["orderDesc"] = ""
    queryString["orderAsc"] = "true"
    queryString["page"] = "1"
    let urlParameter = new URLSearchParams(queryString).toString()
    window.open("./search.php?"+urlParameter,"_top")
  })
  $btnDescPrice.click((event)=>{
    queryString["orderAsc"] = ""
    queryString["orderDesc"] = "true"
    queryString["page"] = "1"
    let urlParameter = new URLSearchParams(queryString).toString()
    window.open("./search.php?"+urlParameter,"_top")
  })
  //
  let activeCategoryID = ""
  if (typeof queryString.categoryID !== "undefined")
    activeCategoryID = queryString.categoryID
  let $categoryFilter = $("#categoryFilter")
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
          <li class="container-shop-app-filter-category-item" categoryID="${value.id}"><a>${value.name}</a></li>
        `
        $categoryFilter.html((i,current)=>{
          return current + categoryItem
        })
      })
      let $categoryItems = $categoryFilter.children();
      $.each($categoryItems,(index,value)=>{
        if( $(value).attr("categoryID") === activeCategoryID )
          $(value).addClass("active")
        $(value).click((event)=>{
          queryString["categoryID"] = $(value).attr("categoryID")
          queryString["page"] = "1"
          let urlParameter = new URLSearchParams(queryString).toString()
          window.open("./search.php?"+urlParameter,"_top")
        })
      })
    }
  })
  let btnFilterPrice= $("#btnFilterPrice")
  let $priceFrom = $(".container-shop-app-filter-search-price-range__from")
  let $priceTo= $(".container-shop-app-filter-search-price-range__to")
  btnFilterPrice.click((event)=>{
    queryString["lowPrice"] = $priceFrom.val().length===0?"1":$priceFrom.val()
    queryString["highPrice"] =$priceTo.val().length===0?"9999999999":$priceTo.val()
    queryString["page"] = "1"
    let urlParameter = new URLSearchParams(queryString).toString()
    window.open("./search.php?"+urlParameter,"_top")
  })
  // handle BestSeller
  let $cbBestSeller = $("#cbBestSeller")
  let $btnBestSeller = $("#btnBestSeller")
  $btnBestSeller.click((event)=>{
    if($cbBestSeller.prop("checked")){
      queryString["bestSeller"] = "true";
      queryString["page"] = "1";
      let urlParameter = new URLSearchParams(queryString).toString()
      window.open("./search.php?"+urlParameter,"_top")
    }
    else{
        delete queryString["bestSeller"]
      let urlParameter = new URLSearchParams(queryString).toString()
      window.open("./search.php?"+urlParameter,"_top")
    }
  })
  //handle page btn left and right
  let $btnLeftPage = $("#btnLeftPage")
  let $btnRightPage = $("#btnRightPage")
  if($btnLeftPage.next().attr("class") == "active")
    $btnLeftPage.remove();
  if($btnRightPage.prev().attr("class") == "active")
    $btnRightPage.remove();


})