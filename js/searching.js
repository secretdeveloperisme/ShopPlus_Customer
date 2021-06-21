$(()=>{
  let queryString = {}
  if(location.search !== "")
    queryString = getQueryStringURLasObject()
  let $btnAscPrice = $("#btnAscPrice")
  let $btnDescPrice = $("#btnDescPrice")
  $btnAscPrice.click((event)=>{
    queryString["orderDesc"] = ""
    queryString["orderAsc"] = "true"
    let urlParameter = new URLSearchParams(queryString).toString()
    window.open("./search.php?"+urlParameter,"_top")
  })
  $btnDescPrice.click((event)=>{
    queryString["orderAsc"] = ""
    queryString["orderDesc"] = "true"
    let urlParameter = new URLSearchParams(queryString).toString()
    window.open("./search.php?"+urlParameter,"_top")
  })
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
      console.log(categories)
      categories.forEach((value,index)=>{
        let categoryItem = `
          <li class="container-shop-app-filter-category-item"><a href="#">${value.name}</a></li>
        `
        $categoryFilter.html((i,current)=>{
          return current + categoryItem
        })
      })
    }
  })
})