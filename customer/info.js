$(()=>{
  //add event navigation layout
  let objectQuery = getQueryStringURLasObject();
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
    let sendData = {
      action : "updateCustomer",
      name : $nameCustomer.val(),
      id : objectQuery.customerID,
      phone : $phoneCustomer.val(),
      email : $emailCustomer.val(),
      companyName : $companyName.val()
    }
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAPI.php",
      type : "POST",
      data : sendData,
      success : (response)=>{
        let responseObject = JSON.parse(response)
        if(responseObject.status === "success") {
          toast({
            title: "Thành Công",
            message: "Cập Nhật Thành Công",
            type: "success",
            duration: 4000
          })
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
  //render customer's orders
  let $ordersTable = $(".account-content-order-table");
  let $ordersTBody = $ordersTable.find("tbody");
  let customerOrders = [];
  $.ajax({
    url : "/ShopPlus_Customer/php/Controller/API/HandleOrderAPI.php",
    type : "GET",
    data : {
      action : "getOrdersViaCustomer",
      customerID : objectQuery.customerID
    },
    success : (responseOrder)=>{
      customerOrders = JSON.parse(responseOrder);
      customerOrders.forEach((value,index)=>{
        $.ajax({
          url : "/ShopPlus_Customer/php/Controller/API/HandleOrderAPI.php",
          type : "GET",
          data : {
            action : "getDetailOrdersViaOrderID",
            orderID : value.id
          },
          async : false,
          success : (responseOrderDetail)=> {
            let orderDetails = JSON.parse(responseOrderDetail);
            let listProduct = [];
            let totalPrice = 0;
            orderDetails.forEach((orderDetail, i) => {
              totalPrice += parseInt(orderDetail.orderPrice);
              let product = {};
              $.ajax({
                url: "/ShopPlus_Customer/php/Controller/API/HandleProductAPI.php",
                type: "GET",
                data: {
                  action: "getProductViaId",
                  id: orderDetail.idMerchandise
                },
                async: false,
                dataType: "text",
                success: (responseProduct) => {
                  product = JSON.parse(responseProduct);
                }
              });
              listProduct.push(`<span>${product.name}</span><span class="red-color"> x${orderDetail.amount} </span>`);
            });
            let status = "";
            switch (value.status.trim()) {
              case "processing" :
                status = "Đang Xủ Lý"
                break;
              case "approved" :
                status = "Đã Duyệt"
                break;
              case "shipped" :
                status = "Đã Giao"
                break;
            }
            let tr = `
                <tr>
                  <td>${value.id}</td>
                  <td>${value.orderDate}</td>
                  <td>${listProduct.join(",").toString()}</td>
                  <td>${numberWithCommas(totalPrice)}</td>
                  <td>${status}</td>
                </tr>
                `
            $ordersTBody.html((index, old) => {
              return old + tr;
            })
          }
        })
      })
    }
  })
  //render customer addresses
  let $addressList = $(".content-address-list");
  function renderAddress(){
    $addressList.html("");
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAddressAPI.php",
      type : "GET",
      data : {
        action : "getCustomerAddress",
        idCustomer: objectQuery.customerID
      },
      async : false,
      dataType: "json",
      success : (response)=>{
        let addresses = JSON.parse(response);
        addresses.forEach((value,index)=>{
          let item = `
          <li class="content-address-item" id="${value.addressId}">
            <input type="text" class="address" value="${value.addressText}">
            <button class="btn" role="update">sửa</button>
            <button class="btn btn--red" role="delete">Xóa</button>
          </li>
        `
          $addressList.html((i,currentHtml)=>{
            return currentHtml + item;
          })
        })
      }
    })
  }
  renderAddress();
  //add event for button add address
  let $btnAddAddress = $("#btnAddAddress");
  let $addressCustomer = $("#addressCustomer");
  $btnAddAddress.click((event)=>{
    if($addressCustomer.val()==="")
    {
      toast({
        title : "Cảnh Báo",
        message : "Địa Chỉ Không Được Để Trống",
        type : "warning",
        duration : 4000
      })
      return false;
    }
    $.ajax({
      url: "/ShopPlus_Customer/php/Controller/API/HandleCustomerAddressAPI.php",
      type: "POST",
      data: {
        action: "insertAddress",
        idCustomer: objectQuery.customerID,
        addressText : $addressCustomer.val()
      },
      dataType: "json",
      success: (response) => {
        console.log(response,"fjd")
        if(JSON.parse(response) === true){
          toast({
            title : "Thành Công",
            message : "Thêm Địa Chỉ Thành Công",
            type : "success",
            duration : 4000
          })
          renderAddress();
          renderEventAddress();
        }
        else
        {
          toast({
            title : "Thất Bại ",
            message : "Thêm Địa Chỉ Thất Bại",
            type : "success",
            duration : 4000
          })
        }
      }
    })
  })
  //render event for address
  function renderEventAddress() {
    let $addressViewItems = $addressList.children();
    $.each($addressViewItems,(index,element)=>{
      $(element).find('[role="update"]').click(function (event) {
        console.log($(element).attr("id"),$(element).find("[type='text'].address").val())
        $.ajax({
          url: "/ShopPlus_Customer/php/Controller/API/HandleCustomerAddressAPI.php",
          type: "POST",
          data: {
            action: "updateAddress",
            addressID: $(element).attr("id"),
            addressText : $(element).find("[type='text'].address").val(),
            "customerID" : objectQuery.customerID
          },
          dataType: "text",
          success: (response) => {
            if( response.trim() === "true"){
              toast({
                title : "Thành Công",
                message : "Cập Nhật Địa Chỉ Thành Công",
                type : "success",
                duration : 4000
              })
            }
            else
            {
              toast({
                title : "Thất Bại ",
                message : "Cập Nhật Địa Chỉ Thất Bại",
                type : "error",
                duration : 4000
              })
            }
          }
        })
      })
      $(element).find('[role="delete"]').click(function (event) {
        console.log($(element).attr("id"),$(element).find("[type='text'].address").val())
        $.ajax({
          url: "/ShopPlus_Customer/php/Controller/API/HandleCustomerAddressAPI.php",
          type: "POST",
          data: {
            action: "deleteAddress",
            addressID: $(element).attr("id")
          },
          dataType: "text",
          success: (response) => {
            if( response.trim() === "true"){
              toast({
                title : "Thành Công",
                message : "Xóa Địa Chỉ Thành Công",
                type : "success",
                duration : 4000
              })
              $(element).remove();
            }
            else
            {
              toast({
                title : "Thất Bại ",
                message : "Xóa Địa Chỉ Thất Bại",
                type : "error",
                duration : 4000
              })
            }
          }
        })
      })
    })
  }
  renderAddress();
  renderEventAddress()
})