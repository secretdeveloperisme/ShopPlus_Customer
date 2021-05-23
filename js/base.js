$(()=>{

});
function toast({title,message,type,duration}){
  const main = document.getElementById("toast");
  var toast = document.createElement("div");
  var icon = {
                success : "fas fa-check-circle",
                error : "fas fa-exclamation-circle",
                warning : "fas fa-exclamation-triangle"
              };
  toast.innerHTML = `
              <div class="toast__icon">
                  <i class="${icon[type]}"></i>
              </div>
              <div class="toast__body">
                  <h2 class="body__title">
                      ${title}
                  </h2>
                  <p class="body__msg">
                      ${message}
                  </p>
              </div>
              <div class="toast__close">
                  &times;
              </div> 
  `; 
  var delay = (duration / 1000).toFixed(2);
  toast.classList.add("toast","toast--"+type);
  toast.style.animation =`slideInLeft 1s linear forwards,fadeOut 1s linear ${delay}s forwards`;
  main.appendChild(toast);

  var t = setTimeout(()=>main.removeChild(toast),duration+1000);
  toast.onclick = function(evt){
      if(evt.target.closest(".toast__close")){
          main.removeChild(toast);
          clearTimeout(t);
      }
  }
};
// base function
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
// handle Customer Information
function updateLocalCustomer(customer){
  window.localStorage.setItem("customer",JSON.stringify(customer))
}
function getLocalCustomer(){
  return JSON.parse(localStorage.getItem("customer"));
}
function hasCustomer(customer){
 return (customer != null)
}
function getCustomerFromDB(email){
  let resultObject = {};
  $.ajax({
    url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAPI.php",
    data : {
      action : "getCustomerViaEmail",
      email : email,
    },
    async : false,
    type : "GET",
    success : (response)=>{
      resultObject = JSON.parse(response);
    }
  });
  return resultObject;
}
function insertCustomerIntoDB(customer){
  let resultObject = {};
  $.ajax({
    url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAPI.php",
    data : {
      action : "insertCustomer",
      name : customer.name,
      companyName :customer.companyName,
      phone : customer.phone,
      email : customer.email
    },
    async : false,
    type : "POST",
    success : (response)=>{
      resultObject = JSON.parse(response);
    }
  })
  return resultObject;
}
function hasCustomerFormDB(email){
  let isExist = false;
  $.ajax(
  {
    url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAPI.php",
    data : {
      "action" : "isExistCustomer",
      "email": email
    },
    async : false,
    type : "GET",
    success : (response)=>{
      console.log(response)
      isExist = JSON.parse(response);
    }
  })
  return isExist;
}
function updateNavUserName(customer){
  let $navUserName = $(".nav-user-info__username");
  if(customer == null){
    $navUserName.text("Guest")
  }
  else{
    $navUserName.text(customer.name );
  }
}
function updateNavUser(){
  let $navUser = $(".nav-user");
  let customer = null;
  customer = getLocalCustomer();
  updateNavUserName(customer);
  if(!hasCustomer(customer)){
    $navUser.find(".nav-user-dropdown-content").remove();
  }
  else
  {
    $("#myOrder > a").attr("href","/ShopPlus_Customer/customer/info.html")
    $("#myInfo > a").attr("href","/ShopPlus_Customer/customer/info.html")
    $("#deleteMyInfo > a").attr("href","/ShopPlus_Customer/customer//info.html")
  }
}