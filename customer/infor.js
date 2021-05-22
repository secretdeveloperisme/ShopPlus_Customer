$(()=>{
  //add event navigation layout 
  let $sidebarItems= $(".sidebar-item");
  let $contentItems = $(".shop-app-account-content-item");
  $contentItems.eq(0).css("display","block");
  $sidebarItems.each(function(index,value){
    $(value).click(function(){
      $contentItems.css("display","none");
      $contentItems.eq(index).css("display","block"); 
      $sidebarItems.filter(".sidebar-item--active").removeClass("sidebar-item--active");
      $(value).addClass("sidebar-item--active");
    })
  });
})