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
  //add event for update information button

  let $btnUpdateInfo = $("#btnUpdateInfo");
  let $nameCustomer  = $("#nameCustomer");
  let $phoneCustomer = $("#phoneCustomer");
  let $companyName = $("#companyCustomer");
  let $emailCustomer = $("#emailCustomer");
  let regexPhone =  /^0\d{9,10}$/;
  let regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  $btnUpdateInfo.click((event)=>{
    if(!regexPhone.test($phoneCustomer.val())){
      toast({
        title : "Thất Bại",
        message : "Số điện Thoại Không Hợp lệ Phải có dạng 0xxxxxxxxxx",
        type : "error",
        duration : 4000
      })
      return  false;
    }
    if(!regexEmail.test($emailCustomer.val())){
      toast({
        title : "Thất Bại",
        message : "email không hợp lệ",
        type : "error",
        duration : 4000
      })
      return  false;
    }
    if($nameCustomer.val() === ""){
     toast({
        title : "Thất Bại",
        message : "Tên Không Được Để Trống",
        type : "error",
        duration : 4000
      })
      return  false;
    }
    let objectQuery = getQueryStringURLasObject();
    let sendData = {
      action : "updateCustomer",
      name : $nameCustomer.val(),
      id : objectQuery.customerID,
      phone : $phoneCustomer.val(),
      email : $emailCustomer.val(),
      companyName : $companyName.val()
    }
    console.log(sendData);
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAPI.php",
      type : "POST",
      data : sendData,
      success : (response)=>{
        let responseObject = JSON.parse(response)
        if(responseObject.status === "success"){
          toast({
            title : "Thành Công",
            message : "Cập Nhật Thành Công",
            type : "success",
            duration : 4000
          })
          location.reload();
        }
        else
          toast({
            title : "Thất Bại",
            message : "Cập Nhật Thất Bại ! "+ responseObject.msg,
            type : "error",
            duration : 4000
          })
      }
    })
  })
})