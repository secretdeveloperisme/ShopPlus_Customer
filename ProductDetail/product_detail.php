<?php
  include("../php/Controller/HandleProduct.php");
  if(isset($_GET["id"])&&!empty($_GET["id"])){
    $isValidProduct = 0;
    $idProduct = $_GET["id"];
    if(IsExistProduct($idProduct)){
      if($merchandise = getProductViaID($idProduct)){
        $isValidProduct=1; 
      }
    }
    
  }
?>
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
  <script src="js/navbar.js"></script>
  <script src="../js/ProductDetail.js"></script>
</head>
<body>
  <div id="toast"></div>
  <div class="shop-app">
    <div class="shop-app-header">
      <div class="nav">
        <div class="nav-home">
          <a href="#" class="nav-home-link">
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
          <div class="nav-search-form">
            <div class="nav-search-form-input">
              <input type="text" class="nav-search-form-input__box" placeholder="Tìm Kiếm Sản Phẩm Bạn Muốn Mua, hoặc muốn...."> 
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
          </div>
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
              <li class="nav-user-dropdown-content-item"><a href="#">Đơn hàng của tôi</a></li>
              <li class="nav-user-dropdown-content-item"><a href="#">Thông Tin Của tôi</a></li>
              <li class="nav-user-dropdown-content-item"><a href="#">Xóa Thông Tin Của Tôi</a></li>
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
              <li class="nav-cart-dropdown-content-item">
                <a href="#">
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(assets/images/products/1f24a67376c5e98b3c3c08c6300e5c9b_tn.jfif);"></div>
                  <div class="nav-cart-dropdown-content-item__name">Sách - 30 Chủ Đề Từ Vựng Tiếng Anh (Bộ 2 quyển, lẻ tùy chọn)</div>
                  <div class="nav-cart-dropdown-content-item__price">99,000 đ</div>
                </a>
              </li>
              <li class="nav-cart-dropdown-content-item">
                <a href="#">
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(assets/images/products/1f934d3ae7dba14ba9a0636b878b5a88_tn.jfif);"></div>
                  <div class="nav-cart-dropdown-content-item__name">USB 256/512GB 3.0 tốc độ truyền dữ liệu cực nhanh kiểu dáng sang trọng</div>
                  <div class="nav-cart-dropdown-content-item__price">99,000 đ</div>
                </a>
              </li>
              <li class="nav-cart-dropdown-content-item">
                <a href="#">
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(assets/images/products/8881955f7ad0ffc82cb7ac90dd871bd6.jfif);"></div>
                  <div class="nav-cart-dropdown-content-item__name">[Mã LIFE5510K giảm 10K đơn 20K] Sách - Không Phải Chưa Đủ Năng Lực, Mà Là Chưa Đủ Kiên Định</div>
                  <div class="nav-cart-dropdown-content-item__price">99,000 đ</div>
                </a>
              </li>
            </ul>
            <a href="#" class="nav-cart-dropdown-content-btn">Xem Giỏ Hàng</a>
          </div>
        </div>
      </div>
      <div class="shop-app-header-path">
        <ul class="shop-app-header-path-list">
          <li class="shop-app-header-path-item"><a href="">Trang chủ</a></li>
          <li class="shop-app-header-path-item"><a href="">Nhà Sách</a></li>
          <li class="shop-app-header-path-item"><a href="">Sapien Lược Sử Loài người</a></li>
        </ul>
      </div>
    </div>
    <div class="shop-app-product">
      <div class="shop-app-product-detail-image-wrap">
        <div class="shop-app-product-detail-image-wrap-img" style="background-image: url(/assets/images/products/1f24a67376c5e98b3c3c08c6300e5c9b_tn.jfif);">
        </div>
      </div>
      <div class="shop-app-product-sell">
        <h1 class="shop-app-product-sell__name">
          Sapien Lược Sử Loài Người 
        </h1>
        <div class="shop-app-product-sell-sold">
          <h2 class="shop-app-product-sell-sold__favorite">Yêu Thích</h2>
          <h2 class="shop-app-product-sell-sold__number">Đã Bán : <span>1</span></h2>
        </div>
        <div class="shop-app-product-sell-price">
          <span class="shop-app-product-sell-price__money">99.000</span> đ
        </div>
        <div class="shop-app-product-sell-number">
          <div class="shop-app-product-sell-number__label">
            Số Lượng
          </div>
          <div class="shop-app-product-sell-number-input">
            <button class="shop-app-product-sell-number__minus btn" id="minusNumber">
              <i class="fas fa-minus"></i>
            </button>
            <input type="text" name="numberOfPurchase" maxlength="3" value="1" id="numberOfPurchase" placeholder="0">
            <button class="shop-app-product-sell-number__plus btn" id="plusNumber">
              <i class="fas fa-plus"></i>
            </button>
          </div>
          <div class="shop-app-product-sell-number-ready">
            <span>10</span> Sản Phẩm Có Sẵn
          </div>
        </div>
        <div class="shop-app-product-sell-buttons">
          <button class="shop-app-product-sell-buttons-cart btn">
            <i class="fas fa-cart-plus"></i>
            <span>Thêm Vào Giỏ Hàng</span>
          </button>
          <button class="shop-app-product-sell-buttons-buy btn">
            <span>Mua Ngay</span>
          </button>
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
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/visa.svg" alt=""></a></li>
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/cash.svg" alt=""></a></li>
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/internet-banking.svg"
                  alt=""></a></li>
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/installment.svg" alt=""></a>
            </li>
          </ul>
        </div>
        <div class="footer-information-item col-xl-3">
          <h1 class="footer-information-item__label">Kết Nối với chúng tôi</h1>
          <ul class="footer-information-item-list footer-information-item-list--wrap">
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/fb.svg"
                  alt=""><span>Facebook</span></a></li>
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/zalo-seeklogo.com.svg"
                  width="32" height="32" alt=""><span>Zalo</span></a></li>
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/youtube.svg"
                  alt=""><span>Youtube</span></a></li>
            <li class="footer-information-item-item"><a href="#"><img src="/assets/images/icons/github-1.svg"
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