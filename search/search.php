<?php
  include_once "../php/Controller/HandleProduct.php";
  parse_str($_SERVER["QUERY_STRING"],$queryURL);
  $queryString = $categoryID = $orderAsc = $orderDesc = $lowPrice = $highPrice =$bestSeller= $page = "";
  if(isset($_GET["queryString"]))
      $queryString = $_GET["queryString"];
  if(isset($_GET["categoryID"]))
    $categoryID = $_GET["categoryID"];
  if(isset($_GET["orderAsc"]))
    $orderAsc = $_GET["orderAsc"];
  if(isset($_GET["orderDesc"]))
    $orderDesc = $_GET["orderDesc"];
  if(isset($_GET["lowPrice"]))
    $lowPrice = $_GET["lowPrice"];
  if(isset($_GET["highPrice"]))
    $highPrice = $_GET["highPrice"];
  if(isset($_GET["bestSeller"]))
    $bestSeller = $_GET["bestSeller"];
  if(isset($_GET["page"]))
    $page = $_GET["page"];
  $searchingProducts = getProductWithSearching($queryString,$categoryID,$orderAsc,$orderDesc,$lowPrice,$highPrice,$bestSeller,$page);
  $numberOfProducts =  getProductNumbersWithSearching($queryString,$categoryID,$lowPrice,$highPrice,$bestSeller);

  $count = 0;
  $pages = array();
  while($numberOfProducts > 0){
    $numberOfProducts -=10;
    $count++;
    array_push($pages,$count);
  }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>ShopPlus</title>
  <link rel="shortcut icon" href="../assets/images/icons/shopplus.svg" type="image/x-icon">
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
  <link rel="stylesheet" href="../assets/css/index.css">
  <link rel="stylesheet" href="../assets/css/footer.css">
  <script src="../js/base.js"></script>
  <script src="../js/Controller/handleCart.js"></script>
  <script src="../js/navbar.js"></script>
  <script src="../js/searching.js"></script>
</head>
<body>
  <div class="loader-container">
    <div class="loader"></div>
  </div>
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
          <form method="get" action="search.php" class="nav-search-form" autocomplete="off">
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
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(/assets/images/products/1f24a67376c5e98b3c3c08c6300e5c9b_tn.jfif);"></div>
                  <div class="nav-cart-dropdown-content-item__name">Sách - 30 Chủ Đề Từ Vựng Tiếng Anh (Bộ 2 quyển, lẻ tùy chọn)</div>
                  <div class="nav-cart-dropdown-content-item__price">99,000 đ</div>
                </a>
              </li>
              <li class="nav-cart-dropdown-content-item">
                <a href="#">
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(/assets/images/products/1f934d3ae7dba14ba9a0636b878b5a88_tn.jfif);"></div>
                  <div class="nav-cart-dropdown-content-item__name">USB 256/512GB 3.0 tốc độ truyền dữ liệu cực nhanh kiểu dáng sang trọng</div>
                  <div class="nav-cart-dropdown-content-item__price">99,000 đ</div>
                </a>
              </li>
              <li class="nav-cart-dropdown-content-item">
                <a href="#">
                  <div class="nav-cart-dropdown-content-item__img" style="background-image: url(/assets/images/products/8881955f7ad0ffc82cb7ac90dd871bd6.jfif);"></div>
                  <div class="nav-cart-dropdown-content-item__name">[Mã LIFE5510K giảm 10K đơn 20K] Sách - Không Phải Chưa Đủ Năng Lực, Mà Là Chưa Đủ Kiên Định</div>
                  <div class="nav-cart-dropdown-content-item__price">99,000 đ</div>
                </a>
              </li>
            </ul>
            <a href="#" class="nav-cart-dropdown-content-btn">Xem Giỏ Hàng</a>
          </div>
        </div>
      </div>
    </div>
    <div class="shop-app-container gird">
      <div class="container-shop-app-wrap-product-and-filter grid-row">
        <div class="container-shop-app-filter col-xl-2-10">
          <div class="container-shop-app-filter-category">
            <h1 class="container-shop-app-filter-category__label">
              <i class="fas fa-list"></i>
              <span>Tất Cả Danh Mục</span>
            </h1>
            <ul class="container-shop-app-filter-category-list" id="categoryFilter">
            </ul>
          </div>
          <div class="container-shop-app-filter-search">
            <h1 class="container-shop-app-filter-search__lablel">
              <i class="fas fa-filter"></i>
              <span>Bộ Lọc Tìm Kiếm</span>
            </h1>
            <div class="container-shop-app-filter-search-price">
              <h2 class="container-shop-app-filter-search-price__label">
                Khoảng Giá 
              </h2>
              <div class="container-shop-app-filter-search-price-range">
                <input type="number" placeholder="đ Từ" class="container-shop-app-filter-search-price-range__from" maxlength="13" min="0" max="9999999" value="<?php echo $lowPrice?>">
                <div class="container-shop-app-filter-search-price-range__line"></div>
                <input type="number" placeholder="đ Đến" class="container-shop-app-filter-search-price-range__to" maxlength="13" min="0" max="9999999" value="<?php echo $highPrice?>">
              </div>
              <button class="container-shop-app-filter-search-price-range__btn btn" id="btnFilterPrice">
                Áp Dụng
              </button>
            </div>
            <div class="container-shop-app-filter-search-favorite">
              <h2 class="container-shop-app-filter-search-favorite__label">
                Best Seller
              </h2>
              <div class="container-shop-app-filter-search-favorite-input">
                <input type="checkbox" name="" id="cbBestSeller" <?php if(!empty($bestSeller)) echo "checked"?>>
                <label for="cbBestSeller">Best Seller</label>
              </div>
              <button class="container-shop-app-filter-search-favorite__btn btn" id="btnBestSeller">
                Áp Dụng
              </button>
            </div>

          </div>
        </div>
        <div class="container-shop-app-display-product grid col-xl-10">
          <div class="shop-app-product-header grid-row">
            <div class="shop-app-product-header__label "><i class="fas fa-star"></i><span>Kết quả tìm kiếm : <span style="color: red"><?php echo $queryString==""?"Tất cả sản phẩm":$queryString; ?></span></span></div>
            <div class="shop-app-product-header-sort">
              <div class="shop-app-product-header-sort-price dropdown">
                <button class="shop-app-product-header-sort-price__lablel dropdown-btn">
                  <span>Sắp Xếp giá Theo</span> <i class="fas fa-chevron-down"></i>
                </button>
                <div class="shop-app-product-header-sort-price-list dropdown-content">
                  <div class="shop-app-product-header-sort-price-item" id="btnAscPrice"><a><i class="fas fa-arrow-up"></i><span>Giá: Từ Thấp Đến Cao</span></a></div>
                  <div class="shop-app-product-header-sort-price-item" id="btnDescPrice"><a><i class="fas fa-arrow-down"></i><span>Giá: Từ Cao Đến Thấp </span></a></div>
                </div>
              </div>
            </div>
          </div>
          <div class="shop-app-product-display grid-row">
            <?php
              if(count($searchingProducts) > 0){
                foreach ($searchingProducts as $searchingProduct){
                  $soldProductAmount = getSoldProductAmount($searchingProduct->getId());
                  $isBestSeller = "";
                  if(isTopTenSeller($searchingProduct->getId())){
                    $isBestSeller = '
                    <div class="product-display-item__favorite">Top Seller</div>
                  ';
                  }
                  echo <<<PRODUCT
                  <div class="shop-app-product-display-item col-xl-2-10 col-es-6">
                    <a href="/ShopPlus_Customer/ProductDetail/product_detail.php?id={$searchingProduct->getId()}">
                      <div class="product-display-item-container">
                        <div class="product-display-container-box-shadow">
                          <div class="product-display-item__img" style="background-image: url('{$searchingProduct->getLocation()}');"></div>
                          $isBestSeller
                          <div class="product-display-item-description">
                            <div class="product-display-item-description__name">
                              {$searchingProduct->getName()}
                            </div>
                            <div class="product-display-item-description-sell">
                              <h2 class="product-display-item-description-sell__price">{$searchingProduct->getPriceWithComma()}</h2>
                              <h2 class="product-display-item-description-sell__sold">Đã bán <span class="price">{$soldProductAmount}</span></h2>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                PRODUCT;
                }
              }
              else {
                echo <<<HTML
                  <div class="no-product">
                    <i class="far fa-frown"></i>
                    <span>Rất Tiếc, Không Có Sản Phẩm Phù Hợp Với Bạn</span>
                  </div>
                HTML;
              }


            ?>
          </div>
        </div>
      </div>
      <div class="pagination">
        <div class="pagination-items">
          <a href="
            <?php $queryURL["page"] = (int)$queryURL["page"] -1 ;
              $leftPageHREF = "./search.php?". http_build_query($queryURL);
              echo "$leftPageHREF";?>" id="btnLeftPage"><i class="fas fa-chevron-left"></i></a>
           <?php
            //$queryURL = parse_str($_SERVER["QUERY_STRING"]);
            foreach ($pages as $p){
              if($p == $page)
                echo "<a class='active'>$p</a>";
              else{
                $queryURL["page"] = $p;
                $pageHREF = "./search.php?". http_build_query($queryURL);
                echo "<a href='$pageHREF'>$p</a>";
              }

            }
           ?>
          <a href="
            <?php
              parse_str($_SERVER["QUERY_STRING"],$queryURL);
              $queryURL["page"] = (int)$queryURL["page"] + 1 ;
              $rightPageHREF = "./search.php?". http_build_query($queryURL);
              echo "$rightPageHREF";?>" id="btnRightPage"><i class="fas fa-chevron-right"></i></a>
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
</body>"
</html>