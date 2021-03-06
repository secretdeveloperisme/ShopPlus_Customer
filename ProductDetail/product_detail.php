<?php
  include("../php/Controller/HandleProduct.php");
  if(isset($_GET["id"])&&!empty($_GET["id"])){
    $isValidProduct = 0;
    $idProduct = $_GET["id"];
    if(IsExistProduct($idProduct)){
      if($merchandise = getProductViaID($idProduct)){
        $categoryName = getCategoryWithIdProduct($merchandise->getId());
        if($merchandise->getAmount() <=0){
          $amountCanAdd = 0;
        }
        else {
          $amountCanAdd = 1;
        }
        $soldProductAmount = getSoldProductAmount($merchandise->getId());
        $bestSellerHTML = "";
        if(isTopTenSeller($merchandise->getId()))
          $bestSellerHTML =  '<h2 class="shop-app-product-sell-sold__favorite">Best Seller</h2>';
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="vi">
        <head>
          <meta charset="UTF-8">
          <title>ShopPlus</title>
          <link rel="shortcut icon" href="/assets/images/icons/shopplus.svg" type="image/x-icon">
          <meta name="author" content="hoang linh plus">
          <meta name="keywords" content="shopplus, cửa hàng plus, hoang linh plus">
          <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
          <meta name="description" content="Chuyên cung cấp các sản phẩm vượt cả mong đợi của quý khách!">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <link rel="preconnect" href="https://fonts.gstatic.com">
          <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
          <link rel="stylesheet" href="../assets/css/base.css">
          <link rel="stylesheet" href="../assets/css/navbar.css">
          <link rel="stylesheet" href="../assets/css/Product-Detail.css">
          <link rel="stylesheet" href="../assets/css/footer.css">
          <script src="../js/base.js"></script>
          <script src="../js/navbar.js"></script>
          <script src="../js/Controller/handleCart.js" ></script>
          <script src="../js/ProductDetail.js"></script>
        </head>
        <body>
          <div id="toast"></div>
          <div class="shop-app">
            <div class="shop-app-header">
              <div class="nav">
                <div class="nav-home">
                  <a href="../index.html" class="nav-home-link">
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
                  <form name="querySearch" method="get" action="../search/search.php" class="nav-search-form" autocomplete="off">
                    <div class="nav-search-form-input">
                      <input type="hidden" name="page" value="1">
                      <input type="text" class="nav-search-form-input__box" name="queryString"  placeholder="Tìm Kiếm Sản Phẩm Bạn Muốn Mua, hoặc muốn...."> 
                      <div class="nav-search-form-input-autocomplete">
                        <ul class="nav-search-form-input-autocomplete-list">
                          <li class="nav-search-form-input-autocomplete-item">
                            <a href="/ShopPlus_Customer/search/search.php?queryString=&categoryID=1&page=1">
                              <span class="nav-search-form-input-autocomplete-item__icon">
                                <i class="fas fa-search"></i>
                              </span>
                              <span class="nav-search-form-input-autocomplete-item__label">Sách</span>
                            </a>
                          </li>
                          <li class="nav-search-form-input-autocomplete-item">
                            <a href="/ShopPlus_Customer/search/search.php?queryString=&categoryID=2&page=1">
                              <span class="nav-search-form-input-autocomplete-item__icon">
                                <i class="fas fa-search"></i>
                              </span>
                              <span class="nav-search-form-input-autocomplete-item__label">Máy Tính</span>
                            </a>
                          </li>
                          <li class="nav-search-form-input-autocomplete-item">
                            <a href="/ShopPlus_Customer/search/search.php?queryString=&categoryID=4&page=1">
                              <span class="nav-search-form-input-autocomplete-item__icon">
                                <i class="fas fa-search"></i>
                              </span>
                              <span class="nav-search-form-input-autocomplete-item__label">Điện Thoại</span>
                            </a>
                          </li>
                          <li class="nav-search-form-input-autocomplete-item">
                            <a href="/ShopPlus_Customer/search/search.php?queryString=&categoryID=6&page=1">
                              <span class="nav-search-form-input-autocomplete-item__icon">
                                <i class="fas fa-search"></i>
                              </span>
                              <span class="nav-search-form-input-autocomplete-item__label">Thời Trang</span>
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
                <div class="nav-user dropdown">
                  <div class="nav-user-btn">
                    <div class="nav-user-icon">
                      <i class="far fa-user"></i>
                    </div>
                    <div class="nav-user-info">
                      <h3 class="nav-user-info__account">Tài khoản</h3>
                      <h3 class="nav-user-info__username">Hoàng Linh</h3>
                    </div>
                    <div class="nav-user-dropdown-icon">
                      <i class="fas fa-caret-down"></i>
                    </div>
                  </div>
                  <div class="nav-user-dropdown-content dropdown-content">
                    <ul class="nav-user-dropdown-content-list">
                      <li class="nav-user-dropdown-content-item" id="myOrder"><a href="#">Đơn hàng của tôi</a></li>
                      <li class="nav-user-dropdown-content-item" id="myInfo"><a href="#">Thông Tin Của tôi</a></li>
                      <li class="nav-user-dropdown-content-item" id="deleteMyInfo"><a href="#">Xóa Thông Tin Của Tôi</a></li>
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
                  <li class="shop-app-header-path-item"><a href="../index.html">Trang chủ</a></li>
                  <li class="shop-app-header-path-item"><a href="../search/search.php?page=1&categoryID={$merchandise->getCategoryId()}">$categoryName</a></li>
                  <li class="shop-app-header-path-item"><a href="">{$merchandise->getName()}</a></li>
                </ul>
              </div>
            </div>
            <div class="shop-app-product">
              <div class="shop-app-product-detail-image-wrap">
                <div class="shop-app-product-detail-image-wrap-img" style="background-image: url('{$merchandise->getLocation()}');">
                </div>
              </div>
              <div class="shop-app-product-sell" id="productItem" productId="{$merchandise->getId()}">
                <h1 class="shop-app-product-sell__name">
                  {$merchandise->getName()}
                </h1>
                <div class="shop-app-product-sell-sold">
                  $bestSellerHTML
                  <h2 class="shop-app-product-sell-sold__number">Đã Bán : <span>{$soldProductAmount}</span></h2>
                </div>
                <div class="shop-app-product-sell-price">
                  <span class="shop-app-product-sell-price__money">{$merchandise->getPriceWithComma()}</span> đ
                </div>
                <div class="shop-app-product-sell-number">
                  <div class="shop-app-product-sell-number__label">
                    Số Lượng
                  </div>
                  <div class="shop-app-product-sell-number-input">
                    <button class="shop-app-product-sell-number__minus btn" id="minusNumber">
                      <i class="fas fa-minus"></i>
                    </button>
                    <input type="text" name="numberOfPurchase" maxlength="3" value="{$amountCanAdd}" id="numberOfPurchase" placeholder="0">
                    <button class="shop-app-product-sell-number__plus btn" id="plusNumber">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <div class="shop-app-product-sell-number-ready">
                    <span id="amountOfProduct">{$merchandise->getAmount()}</span> Sản Phẩm Có Sẵn
                  </div>
                </div>
                <div class="shop-app-product-sell-buttons">
                  <button class="shop-app-product-sell-buttons-cart btn" id="btnAddCart">
                    <i class="fas fa-cart-plus"></i>
                    <span>Thêm Vào Giỏ Hàng</span>
                  </button>
                  <button class="shop-app-product-sell-buttons-buy btn" id="btnPurchase">
                    <span>Mua Ngay</span>
                  </button>
                </div> 
              </div>
            </div>
             <div class="shop-app-product-description col-xl-12">
                  <h4 class="shop-app-product-description__label">Mô Tả Sản Phẩm</h4>
                  <div class="shop-app-product-description-content disappear">
                      <p class="description__text">{$merchandise->getNote()}</p>
                      <div class="description__gradient"></div>
                  </div>
                  <button class="btn" id="btnMore">Xem Thêm</button>
                  
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
                    <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/internet-banking.svg" alt=""></a></li>
                    <li class="footer-information-item-item"><a href="#"><img src="/ShopPlus_Customer/assets/images/icons/installment.svg" alt=""></a></li>
                  </ul>
                </div>
                <div class="footer-information-item col-xl-3">
                  <h1 class="footer-information-item__label">Kết Nối với chúng tôi</h1>
                  <ul class="footer-information-item-list footer-information-item-list--wrap">
                    <li class="footer-information-item-item"><a href="https://www.facebook.com/hoanglinhplus"><img src="/ShopPlus_Customer/assets/images/icons/fb.svg"
                          alt=""><span>Facebook</span></a></li>
                    <li class="footer-information-item-item"><a href=""><img src="/ShopPlus_Customer/assets/images/icons/zalo-seeklogo.com.svg"
                          width="32" height="32" alt=""><span>Zalo</span></a></li>
                    <li class="footer-information-item-item"><a href="https://youtube.com"><img src="/ShopPlus_Customer/assets/images/icons/youtube.svg"
                          alt=""><span>Youtube</span></a></li>
                    <li class="footer-information-item-item"><a href="https://github.com/secretdeveloperisme"><img src="/ShopPlus_Customer/assets/images/icons/github-1.svg"
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
        </body>
        </html>
      HTML;

      }
    }
    
  }
?>
