<?php
    include "../php/Controller/HandleCustomer.php";
    if(isset($_GET["customerID"])&&!empty($_GET["customerID"])){
        if(isset($_GET["action"])&&!empty($_GET["action"])){
            $action = $_GET["action"];
            $activeAction = 0;
            switch ($action){
              case "info" :
                  $activeAction = 1;
                  break;
              case "order":
                  $activeAction =2;
                  break;
              case "address" :
                  $activeAction =3;
                  break;
            }
            $customerID = $_GET["customerID"];
            $customer = getCustomerViaID($customerID);
            echo <<<HTML
                <!DOCTYPE html>
                <html lang="vi">
                <head>
                  <meta charset="UTF-8">
                  <title>ShopPlus</title>
                  <link rel="shortcut icon" href="/ShopPlus_Customer/assets/images/icons/shopplus.svg" type="image/x-icon">
                  <meta name="author" content="hoang linh plus">
                  <meta name="keywords" content="shopplus, cửa hàng plus, hoang linh plus">
                  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
                  <meta name="description" content="Chuyên cung cấp các sản phẩm vượt cả mong đợi của quý khách!">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                  <link rel="preconnect" href="https://fonts.gstatic.com">
                  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
                  <link rel="stylesheet" href="/ShopPlus_Customer/assets/css/base.css">
                  <link rel="stylesheet" href="/ShopPlus_Customer/assets/css/navbar.css">
                  <link rel="stylesheet" href="/ShopPlus_Customer/assets/css/Product-Detail.css">
                  <link rel="stylesheet" href="info.css">
                  <link rel="stylesheet" href="../assets/css/footer.css">
                  <script src="/ShopPlus_Customer/js/base.js"></script>
                  <script src="/ShopPlus_Customer/js/Controller/handleCart.js"></script>
                  <script src="info.js"></script>
                </head>
                <body>
                  <div id="toast"></div>
                  <div class="shop-app">
                    <div class="shop-app-header">
                      <div class="nav">
                        <div class="nav-home">
                          <a href="/ShopPlus_Customer/index.html" class="nav-home-link">
                            <span class="nav-home-link__logo">
                              <i class="fab fa-shopify"></i>
                            </span>
                            <h1 class="nav-home-link__name">ShopPlus</h1>
                          </a>
                         
                        </div>
                        <div class="nav-category dropdown">
                          <button class="dropdown-btn nav-category-btn">
                            <span class="nav-category-btn-logo">
                              <i class="fas fa-list"></i>
                            </span>
                            <span class="nav-category-btn-wrap">
                              <span class="nav-category-btn-wrap__category">
                                Danh Mục
                              </span>
                              <span class="nav-category-btn-wrap__product">
                                Sản Phẩm
                              </span>
                            </span>
                            <span class="nav-category-btn-expand">
                              <i class="fas fa-caret-down"></i>
                            </span>
                          </button>
                          <div class="dropdown-content nav-category-content">
                              <ul class="nav-category-content-list">
                                <li class="nav-category-content-item nav-category-content-item-dropdown dropdown">
                                  <a href="#" class="nav-category-content-item-link dropdown-btn nav-category-content-item-dropdown-btn"><i class="fas fa-mobile"></i> Điện Thoại - Máy tính Bảng</a>
                                  <div class="dropdown-content nav-category-content-item-dropdown-content">
                                    <h2><i class="fas fa-star"></i> Nổi Bật</h2>
                                    <ul class="nav-category-content-item-dropdown-list">
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">IPhone 12</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Galaxy S21 Ultra 5G</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Iphone XS Max</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Xiaomi Redmi Note 9</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Vsmart Aris </a></li>
                                    </ul>
                                  </div>
                                </li>
                                <li class="nav-category-content-item nav-category-content-item-dropdown dropdown">
                                  <a href="#" class="nav-category-content-item-link dropdown-btn nav-category-content-item-dropdown-btn"><i class="fas fa-laptop"></i> Laptop - Thiết Bị IT</a>
                                  <div class="dropdown-content nav-category-content-item-dropdown-content">
                                    <h2><i class="fas fa-star"></i> Nổi Bật</h2>
                                    <ul class="nav-category-content-item-dropdown-list">
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Dell XPS 13</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Apple MacBook Pro </a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Acer Swift 3</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">MacBook Pro</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Asus ZenBook 13 UX325EA </a></li>
                                    </ul>
                                  </div>
                                </li>
                                <li class="nav-category-content-item dropdown">
                                  <a href="#" class="nav-category-content-item-link dropdown-btn nav-category-content-item-dropdown-btn"><i class="fas fa-tshirt"></i> Thời Trang - Phụ Kiện</a>
                                  <div class="dropdown-content nav-category-content-item-dropdown-content">
                                    <h2><i class="fas fa-star"></i> Nổi Bật</h2>
                                    <ul class="nav-category-content-item-dropdown-list">
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Áo Gucci</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Ví Channel</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Giầy Sneaker</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Thắt Lưng lexus</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Nón Dior </a></li>
                                    </ul>
                                  </div>
                                </li>
                                <li class="nav-category-content-item dropdown">
                                  <a href="#" class="nav-category-content-item-link dropdown-btn nav-category-content-item-dropdown-btn"><i class="fas fa-futbol"></i> Thể Thao - Dã Ngoại</a>
                                  <div class="dropdown-content nav-category-content-item-dropdown-content">
                                    <h2><i class="fas fa-star"></i> Nổi Bật</h2>
                                    <ul class="nav-category-content-item-dropdown-list">
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Áo Cầu Lông</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Áo Đá banh</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Vợt Cầu Lông</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Quần Đá Banh</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Bóng Đá</a></li>
                                    </ul>
                                  </div>
                                </li>
                                <li class="nav-category-content-item dropdown">
                                  <a href="#" class="nav-category-content-item-link dropdown-btn nav-category-content-item-dropdown-btn"><i class="fas fa-book"></i> Sách - Văn Phòng Phẩm</a>
                                  <div class="dropdown-content nav-category-content-item-dropdown-content">
                                    <h2><i class="fas fa-star"></i> Nổi Bật</h2>
                                    <ul class="nav-category-content-item-dropdown-list">
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Đắc Nhân Tâm</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Lược Xử Loài Người </a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Harry Potter và Hòn đá phù thủy</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Tư duy phản biện</a></li>
                                      <li class="nav-category-content-item-dropdown-item"><a href="#">Người giàu nhất thành babylon</a></li>
                                    </ul>
                                  </div>
                                </li>
                              </ul>
                          </div>
                        </div>
                        <div class="nav-search">
                          <form name="querySearch" method="get" action="../search/search.php" class="nav-search-form">
                            <div class="nav-search-form-input">
                              <input type="text" class="nav-search-form-input__box" name="querySearch"  placeholder="Tìm Kiếm Sản Phẩm Bạn Muốn Mua, hoặc muốn...."> 
                              <div class="nav-search-form-input-autocomplete">
                                <ul class="nav-search-form-input-autocomplete-list">
                                  <li class="nav-search-form-input-autocomplete-item">
                                    <a href="#">
                                      <span class="nav-search-form-input-autocomplete-item__icon">
                                        <i class="fas fa-search"></i>
                                      </span>
                                      <span class="nav-search-form-input-autocomplete-item__label">Máy Tính</span>
                                    </a>
                                  </li>
                                  <li class="nav-search-form-input-autocomplete-item">
                                    <a href="#">
                                      <span class="nav-search-form-input-autocomplete-item__icon">
                                        <i class="fas fa-search"></i>
                                      </span>
                                      <span class="nav-search-form-input-autocomplete-item__label">Áo Khoác</span>
                                    </a>
                                  </li>
                                  <li class="nav-search-form-input-autocomplete-item">
                                    <a href="#">
                                      <span class="nav-search-form-input-autocomplete-item__icon">
                                        <i class="fas fa-search"></i>
                                      </span>
                                      <span class="nav-search-form-input-autocomplete-item__label">Cầu Lông</span>
                                    </a>
                                  </li>
                                  <li class="nav-search-form-input-autocomplete-item">
                                    <a href="#">
                                      <span class="nav-search-form-input-autocomplete-item__icon">
                                        <i class="fas fa-search"></i>
                                      </span>
                                      <span class="nav-search-form-input-autocomplete-item__label">Sách</span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>    
                            <button class="nav-search-form-btn">
                              <span class="nav-search-form-btn__logo">
                                <i class="fas fa-search"></i>
                              </span>
                              <span class="nav-search-form-btn__name">
                                Tìm Kiếm
                              </span>
                            </button>
                          </form>
                          <div class="nav-search-popular">
                            <ul class="nav-search-popular-list">
                              <li class="nav-search-popular-item"><a href="#">Iphone 12</a></li>
                              <li class="nav-search-popular-item"><a href="">Máy Tính</a></li>
                              <li class="nav-search-popular-item"><a href="">Laptop</a></li>
                              <li class="nav-search-popular-item"><a href="">Sách</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="nav-cart dropdown">
                          <div class="nav-cart-dropdown-btn dropdown-btn">
                            <div class="nav-cart-wrapper">
                              <div class="nav-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                              </div>
                              <div class="nav-cart-quantities">
                                0
                              </div>
                            </div>
                            <div class="nav-cart-label">
                              <h3>Giỏ Hàng</h3>
                            </div>
                          </div>
                          <div class="nav-cart-dropdown-content dropdown-content">
                            <h2 class="nav-cart-dropdown-content-label">Sản Phẩm mới thêm</h2>
                            <ul class="nav-cart-dropdown-content-list">
                            </ul>
                            <a href="../checkout/shopping_cart/shopping_cart.html" class="nav-cart-dropdown-content-btn">Xem Giỏ Hàng</a>
                          </div>
                        </div>
                      </div>
                      <div class="shop-app-header-path">
                        <ul class="shop-app-header-path-list">
                          <li class="shop-app-header-path-item"><a href="/ShopPlus_Customer">Trang chủ</a></li>
                          <li class="shop-app-header-path-item"><a href="">{$_GET["action"]}</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="shop-app-account">
                      <aside class="sidebar account-sidebar col-xl-3">
                        <h1 class="sidebar__label account-sidebar_label">
                          <div class="sidebar-label-user-name">{$customer->getName()}</div>
                        </h1>
                        <ul class="sidebar-list">
                          <li class="sidebar-item sidebar-item--active">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                            <span>Thông tin tài khoản</span>
                          </li>
                          <li class="sidebar-item">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M13 12h7v1.5h-7zm0-2.5h7V11h-7zm0 5h7V16h-7zM21 4H3c-1.1 0-2 .9-2 2v13c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 15h-9V6h9v13z"></path></svg>
                              <span>Quản Lý Đơn Hàng</span>
                          </li>
                          <li class="sidebar-item">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                              <span>Thêm Địa Chỉ</span>
                          </li>
                        </ul>
                      </aside>
                      <div class="shop-app-account-content col-xl-9">
                        <div class="shop-app-account-content-item">
                          <div class="account-content-label">
                            Thông Tin Tài Khoản
                          </div>
                          <!-- information content -->
                          <form class="account-content-form" id="infoForm" onsubmit="return false;">
                            <div class="account-content-info-control">
                              <label for="">Họ tên :</label>
                              <input type="text" name="" id="nameCustomer" value="{$customer->getName()}">
                            </div>
                            <div class="account-content-info-control">
                              <label for="">Số điện thoại : </label>
                              <input type="text" name="" id="phoneCustomer" value="{$customer->getPhone()}">
                            </div>
                            <div class="account-content-info-control">
                              <label for="">Email : </label>
                              <input type="text" name="" id="emailCustomer" value="{$customer->getEmail()}">
                            </div>
                            <div class="account-content-info-control">
                              <label for="">Tên Công Ty</label>
                              <input type="text" id="companyCustomer" value="{$customer->getCompanyName()}">
                            </div>
                            <input type="submit" class="info-btn btn" id="btnUpdateInfo" value="Cập Nhật">
                          </form>
                        </div>
                        <div class="shop-app-account-content-item">
                          <div class="account-content-label">
                            Quản lý đơn hàng 
                          </div>
                          <!-- order content -->
                          <table class="account-content-order-table">
                            <thead>
                              <tr>
                                <td>Mã đơn hàng</td>
                                <td>Ngày Mua</td>
                                <td>Sản Phẩm</td>
                                <td>Tổng Tiền</td>
                                <td>Trạng Thái Đơn Hàng</td>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                        <div class="shop-app-account-content-item">
                          <div class="account-content-label">
                            Địa Chỉ Của Tôi
                          </div>
                          <!-- address content -->
                          <form class="account-content-form-address" onsubmit="return false">
                            <input type="text" name="abc" id="addressCustomer" placeholder="Thêm Địa Chỉ">
                            <input type="button" class="btn info-btn" value="Thêm" id="btnAddAddress">
                          </form>
                          <ul class="content-address-list">
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="shop-app-footer gird">
                      <div class="footer-information grid-row">
                        <div class="footer-information-item col-xl-3">
                          <h1 class="footer-information-item__label">Hổ Trợ Khách Hàng</h1>
                          <ul class="footer-information-item-list">
                            <li class="footer-information-item-item"><strong>Hotline chăm sóc khách hàng:</strong> 1900-xxxx
                              (1000đ/phút , 8-21h kể cả T7, CN)</li>
                            <li class="footer-information-item-item">Các câu hỏi thường gặp</li>
                            <li class="footer-information-item-item">Hướng dẫn đặt hàng</li>
                            <li class="footer-information-item-item">Hỗ trợ khách hàng: hotro@shopplus.vn</li>
                            <li class="footer-information-item-item">Báo lỗi bảo mật: security@tiki.vn</li>
                          </ul>
                        </div>
                        <div class="footer-information-item col-xl-3">
                          <h1 class="footer-information-item__label">Về Shop Plus</h1>
                          <ul class="footer-information-item-list">
                            <li class="footer-information-item-item">Giới thiệu về shop</li>
                            <li class="footer-information-item-item"><strong>Chủ Trang web : </strong>Hoàng Linh</li>
                            <li class="footer-information-item-item"><strong>Ngày Thành Lập : </strong>dd/MM/YYYY</li>
                          </ul>
                        </div>
                        <div class="footer-information-item col-xl-3">
                          <h1 class="footer-information-item__label">Phương Thức Thanh Toán</h1>
                          <ul class="footer-information-item-list footer-information-item-list--wrap">
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/visa.svg" alt=""></a></li>
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/cash.svg" alt=""></a></li>
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/internet-banking.svg"
                                  alt=""></a></li>
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/installment.svg" alt=""></a>
                            </li>
                          </ul>
                        </div>
                        <div class="footer-information-item col-xl-3">
                          <h1 class="footer-information-item__label">Kết Nối với chúng tôi</h1>
                          <ul class="footer-information-item-list footer-information-item-list--wrap">
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/fb.svg"
                                  alt=""><span>Facebook</span></a></li>
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/zalo-seeklogo.com.svg"
                                  width="32" height="32" alt=""><span>Zalo</span></a></li>
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/youtube.svg"
                                  alt=""><span>Youtube</span></a></li>
                            <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/github-1.svg"
                                  alt=""><span>Github</span></a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="shop-app-footer-address">
                        <h1 class="shop-app-footer-address__label">Mọi chi tiết xin liên hệ : </h1>
                        <p class="shop-app-footer-address__description">
                          Đường 3/2, Phường Xuân Khánh, Quận Ninh Kiều, Thành Phố Cần Thơ.
                        </p>
                      </div>
                      <div class="shop-app-footer-copyright">
                        <h1 class="shop-app-footer-copyright__label">&copy; Bản quyền thuộc Hoang Linh Plus</h1>
                      </div>
                    </div>
                  </div>
                  <script>
                  $(function() {
                    document.querySelector(".sidebar-item:nth-of-type({$activeAction})").click()
                  })
                  </script>
                </body>
                </html>
            HTML;

        }
    }
?>
