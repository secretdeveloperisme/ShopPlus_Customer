$(()=>{
  $.ajax({
    url : "/ShopPlus_Customer/php/Controller/API/HandleSessionAPI.php",
    type : "POST",
    data : {
      action : "getSession"
    },
    dataType : "text",
    success : (response)=>{
      let result = JSON.parse(response);
      if(result.status === "error"){
        document.write("You are not authorized!")
        return false;
      }
      else{
        let customerSession = JSON.parse(result.content);
        if(customerSession.id !== objectQuery.customerID){
          document.write("You are not authorized!")
          return false;
        }
      }


    }
  })
  let $modal = $("#modal")
  let $btnCloseModal = $(".modal-content-btn-close")
  $btnCloseModal.click(()=>{
    $modal.fadeOut()
  })
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
  let $passwordCustomer = $("#passwordCustomer");
  let regexPhone =  /^0\d{9,10}$/;
  let regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,16})/;
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
    if(!regexPassword.test($passwordCustomer.val())){
      toast({
        title : "Cảnh báo",
        message :"Mật Khẩu phải có ít nhất 8 kí tự, chữ in hoa, in thường, số, và kí tự đặc biệt",
        type: "warning",
        duration : 5000
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
      password : $passwordCustomer.val(),
      companyName : $companyName.val()
    }
    $.ajax({
      url : "/ShopPlus_Customer/php/Controller/API/HandleCustomerAPI.php",
      type : "POST",
      data : sendData,
      success : (response)=>{
        console.log(response)
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
              case "pending" :
                status = "Đang chờ"
                break;
              case "processing" :
                status = "Đang Xử lý"
                break;
              case "approved" :
                status = "Đã Duyệt"
                break;
              case "completed" :
                status = "Đã Giao"
                break;
              case "canceled" :
                status = "Đã Hũy"
                break;
            }
            let tr = `
                <tr>
                  <td>${value.id}</td>
                  <td>${value.orderDate}</td>
                  <td>${listProduct.join(",").toString()}</td>
                  <td>${numberWithCommas(totalPrice)}</td>
                  <td><span class="status status--${value.status}">${status}</span></td>
                </tr>
                `
            $ordersTBody.html((index, old) => {
              return old + tr;
            })
          }
        })
      })
      // add event for row order
      let $rowOrder = $ordersTBody.find("tr")
      let  $modalOrderTableBody= $("#modalOrderTableBody")
      $.each($rowOrder,(index,element)=>{
        $(element).click((event)=>{
          $modal.fadeIn()

          let orderID = $(element).find("td:first").text()
          $.ajax({
            url : "/ShopPlus_Customer/php/Controller/API/HandleOrderAPI.php",
            type : "GET",
            data : {
              action : "getOrderViaID",
              "orderID" : orderID
            },
            dataType : "text",
            success : (responseOrder)=>{

              let order = JSON.parse(responseOrder)
              $("#modalOrderID").text(order.id)
              $("#modalOrderDate").text(order.orderDate)
              $("#modalDeliverDate").text(order.deliverDate)
              $modalOrderTableBody.html("")
              $.ajax({
                url : "/ShopPlus_Customer/php/Controller/API/HandleOrderAPI.php",
                type : "GET",
                data : {
                  action : "getDetailOrdersViaOrderID",
                  orderID : order.id
                },
                async : false,
                success : (responseOrderDetail)=> {
                  let orderDetails = JSON.parse(responseOrderDetail);
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
                        let modalOrderRow = ` 
                         <tr>
                            <td role="id">${product.id}</td>
                            <td role="location"><img src="${product.location}" width="32px" height="32px"></td>
                            <td role="name">${product.name}</td>
                            <td role="amount">${orderDetail.amount}</td>
                            <td role="price">${numberWithCommas(orderDetail.orderPrice)}</td>
                         </tr>`
                        $modalOrderTableBody.html((i,current)=>{
                          return current+modalOrderRow;
                        })

                      }
                    });
                  });
                  let status = "";
                  switch (order.status.trim()) {
                    case "pending" :
                      status = "Đang chờ"
                      break;
                    case "processing" :
                      status = "Đang Xử lý"
                      break;
                    case "approved" :
                      status = "Đã Duyệt"
                      break;
                    case "completed" :
                      status = "Đã Giao"
                      break;
                    case "canceled" :
                      status = "Đã Hũy"
                      break;
                  }
                  $(".btn-cancel-order").remove()
                  if(order.status.trim() == "pending"){
                    $("#modalOrderTable").after('<button class="btn btn-cancel-order"  id="btnCancelOrder">Hũy Đơn Hàng</button>')
                    $("#btnCancelOrder").click((event)=>{
                      $.ajax({
                        url : "/ShopPlus_Customer/php/Controller/API/HandleOrderAPI.php",
                        type : "POST",
                        data : {
                          action : "cancelOrder",
                          "orderID" : orderID
                        },
                        dataType : "text",
                        success : (response)=>{
                          console.log(response)
                          let result = JSON.parse(response)
                          if(result){
                            toast({
                              title : "Thành Công",
                              message : "Hủy Đặt Hàng Hóa Đơn Thành Công",
                              type : "success",
                              duration : 5000
                            })
                            location.reload()
                          }
                          else
                            toast({
                              title : "Thất Bại",
                              message : "Hũy Đặt Hàng Thất Bại",
                              type : "error",
                              duration : 5000
                            })

                        }
                      })
                    })
                  }
                  $("#modalOrderStatus").attr("class","btn").addClass("status--"+order.status).text(status)
                  $("#modalOrderTotalPrice").text(numberWithCommas(totalPrice) + "đ")
                }
              })
            }
          })
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