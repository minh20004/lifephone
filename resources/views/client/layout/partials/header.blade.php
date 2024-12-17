<style>
  .auth {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: rgb(126, 8, 8); /* Nền trắng */
  border-radius: 50%; /* Bo tròn hoàn toàn */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Tạo bóng nhẹ */
  transition: transform 0.2s ease; /* Thêm hiệu ứng mượt */
}

.auth:hover {
  background-color: rgb(98, 6, 6); /* Nền trắng */
  transform: scale(1.1); /* Phóng to nhẹ khi hover */
}

.auth span {
  font-size: 1.25rem;
  color: #fff;
  font-weight: 700;
}
</style>
<div class="container d-block py-1 py-lg-3" data-bs-theme="dark">
  <div class="navbar-stuck-hide pt-1"></div>
  <div class="row flex-nowrap align-items-center g-0">
    <div class="col col-lg-3 d-flex align-items-center">

      <!-- Mobile offcanvas menu toggler (Hamburger) -->
      <button type="button" class="navbar-toggler me-4 me-lg-0" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar brand (Logo) -->
      <a href="{{ route('home') }}" class="navbar-brand me-0">
        <span class="d-none d-sm-flex flex-shrink-0 text-primary me-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"><path d="M36 18.01c0 8.097-5.355 14.949-12.705 17.2a18.12 18.12 0 0 1-5.315.79C9.622 36 2.608 30.313.573 22.611.257 21.407.059 20.162 0 18.879v-1.758c.02-.395.059-.79.099-1.185.099-.908.277-1.817.514-2.686C2.687 5.628 9.682 0 18 0c5.572 0 10.551 2.528 13.871 6.517 1.502 1.797 2.648 3.91 3.359 6.201.494 1.659.771 3.436.771 5.292z" fill="currentColor"></path><g fill="#fff"><path d="M17.466 21.624c-.514 0-.988-.316-1.146-.829-.198-.632.138-1.303.771-1.501l7.666-2.469-1.205-8.254-13.317 4.621a1.19 1.19 0 0 1-1.521-.75 1.19 1.19 0 0 1 .751-1.521l13.89-4.818c.553-.197 1.166-.138 1.64.158a1.82 1.82 0 0 1 .85 1.284l1.344 9.183c.138.987-.494 1.994-1.482 2.33l-7.864 2.528-.375.04zm7.31.138c-.178-.632-.85-1.007-1.482-.81l-5.177 1.58c-2.331.79-3.28.02-3.418-.099l-6.56-8.412a4.25 4.25 0 0 0-4.406-1.758l-3.122.987c-.237.889-.415 1.777-.514 2.686l4.228-1.363a1.84 1.84 0 0 1 1.857.81l6.659 8.551c.751.948 2.015 1.323 3.359 1.323.909 0 1.857-.178 2.687-.474l5.078-1.54c.632-.178 1.008-.829.81-1.481z"></path><use href="#czlogo"></use><use href="#czlogo" x="8.516" y="-2.172"></use></g><defs><path id="czlogo" d="M18.689 28.654a1.94 1.94 0 0 1-1.936 1.935 1.94 1.94 0 0 1-1.936-1.935 1.94 1.94 0 0 1 1.936-1.935 1.94 1.94 0 0 1 1.936 1.935z"></path></defs></svg>
        </span>
        LifePhone
      </a>
    </div>
    <div class="col col-lg-9 d-flex align-items-center justify-content-end">

      <!-- Search visible on screens > 991px wide (lg breakpoint) -->
      <div class="position-relative flex-fill d-none d-lg-block pe-4 pe-xl-5">
        <i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg text-white ms-3"></i>
        <input type="search" class="form-control form-control-lg form-icon-start border-white rounded-pill search-header" data-fire-url="{{ asset('storage/images/fire.png') }}" placeholder="Search the products">
      </div>

      <!-- Sale link visible on screens > 1200px wide (xl breakpoint) -->
      <a class="d-none d-xl-flex align-items-center text-decoration-none animate-shake navbar-stuck-hide me-3 me-xl-4 me-xxl-5" href="shop-catalog-electronics.html">
        <div class="btn btn-icon btn-lg fs-lg text-primary bg-body-secondary bg-opacity-75 pe-none rounded-circle">
          <i class="ci-percent animate-target"></i>
        </div>
        <div class="ps-2 text-nowrap">
          <div class="fs-xs text-body">Chỉ trong tháng này</div>
          <div class="fw-medium text-white">siêu giảm giá 20%</div>
        </div>
      </a>

      <!-- Button group -->
      <div class="d-flex align-items-center">

        <!-- Navbar stuck nav toggler -->
        <button type="button" class="navbar-toggler d-none navbar-stuck-show me-3" data-bs-toggle="collapse" data-bs-target="#stuckNav" aria-controls="stuckNav" aria-expanded="false" aria-label="Toggle navigation in navbar stuck state">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Theme switcher (light/dark/auto) -->
        <div class="dropdown">
          <button type="button" class="theme-switcher btn btn-icon btn-lg btn-outline-secondary fs-lg border-0 rounded-circle animate-scale" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Toggle theme (light)">
            <span class="theme-icon-active d-flex animate-target">
              <i class="ci-sun"></i>
            </span>
          </button>
          <ul class="dropdown-menu" style="--cz-dropdown-min-width: 9rem">
            <li>
              <button type="button" class="dropdown-item active" data-bs-theme-value="light" aria-pressed="true">
                <span class="theme-icon d-flex fs-base me-2">
                  <i class="ci-sun"></i>
                </span>
                <span class="theme-label">Trắng</span>
                <i class="item-active-indicator ci-check ms-auto"></i>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                <span class="theme-icon d-flex fs-base me-2">
                  <i class="ci-moon"></i>
                </span>
                <span class="theme-label">Đen</span>
                <i class="item-active-indicator ci-check ms-auto"></i>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item" data-bs-theme-value="auto" aria-pressed="false">
                <span class="theme-icon d-flex fs-base me-2">
                  <i class="ci-auto"></i>
                </span>
                <span class="theme-label">Tự động</span>
                <i class="item-active-indicator ci-check ms-auto"></i>
              </button>
            </li>
          </ul>
        </div>
        <!-- Search toggle button visible on screens < 992px wide (lg breakpoint) -->
        <button type="button" class="btn btn-icon btn-lg fs-xl btn-outline-secondary border-0 rounded-circle animate-shake d-lg-none" data-bs-toggle="collapse" data-bs-target="#searchBar" aria-expanded="false" aria-controls="searchBar" aria-label="Toggle search bar">
          <i class="ci-search animate-target"></i>
        </button>

         <!-- Account button visible on screens > 768px wide (md breakpoint) -->
         @if (Auth::guard('customer')->check())
         <!-- If the user is logged in, show their initials -->
         <a class="auth btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex"
           href="{{ route('customer.file') }}" >
             <span class="fw-medium">{{ strtoupper(substr(Auth::guard('customer')->user()->email, 0, 1)) }}</span>
         </a>
        @else
            <!-- If the user is not logged in, show the login icon -->
            <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex"
              href="{{ route('customer.login') }}">
                <i class="ci-user animate-target"></i>
                <span class="visually-hidden">Account</span>
            </a>
        @endif
        <!-- Wishlist button visible on screens > 768px wide (md breakpoint) -->
        <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-pulse d-none d-md-inline-flex" href="{{route('customer.wishList')}}">
          <i class="ci-heart animate-target"></i>
          <span class="visually-hidden">Wishlist</span>
        </a>

        <!-- giỏ hàng button -->
        <button type="button" class="btn btn-icon btn-lg btn-secondary position-relative rounded-circle ms-2" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart" aria-label="Shopping cart">
          <span class="position-absolute top-0 start-100 mt-n1 ms-n3 badge text-bg-success border border-3 border-dark rounded-pill" style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em" id="cartCount">0</span>
          <span class="position-absolute top-0 start-0 d-flex align-items-center justify-content-center w-100 h-100 rounded-circle animate-slide-end fs-lg">
              <i class="ci-shopping-cart animate-target ms-n1"></i>
          </span>
      </button>
      
      </div>
    </div>
  </div>
  <div class="navbar-stuck-hide pb-1"></div>
</div>

<!-- Search visible on screens < 992px wide (lg breakpoint). It is hidden inside collapse by default -->
<div class="collapse position-absolute top-100 z-2 w-100 bg-dark d-lg-none" id="searchBar">
  <div class="container position-relative my-3" data-bs-theme="dark">
    <i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg text-white ms-3"></i>
    <input type="search" class="form-control form-icon-start border-white rounded-pill" placeholder="Search the products" data-autofocus="collapse">
  </div>
</div>

<!-- Main navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
<div class="collapse navbar-stuck-hide" id="stuckNav">
  <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
    <div class="offcanvas-header py-3">
      <h5 class="offcanvas-title" id="navbarNavLabel">Browse Cartzilla</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body py-3 py-lg-0">
      <div class="container px-0 px-lg-3">
        <div class="row">

          <!-- Categories mega menu -->
          <div class="col-lg-3">
            <div class="navbar-nav">
              <div class="dropdown w-100">

                <!-- Buttton visible on screens > 991px wide (lg breakpoint) -->
                <div class="cursor-pointer d-none d-lg-block" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-theme="dark">
                  <a class="position-absolute top-0 start-0 w-100 h-100" href="{{route('danh-muc-san-pham')}}">
                    <span class="visually-hidden">Danh mục</span>
                  </a>
                  <button type="button" class="btn btn-lg btn-secondary dropdown-toggle w-100 rounded-bottom-0 justify-content-start pe-none">
                    <i class="ci-grid fs-lg"></i>
                    <span class="ms-2 me-auto">Danh mục</span>
                  </button>
                </div>

                <!-- Buttton visible on screens < 992px wide (lg breakpoint) -->
                <button type="button" class="btn btn-lg btn-secondary dropdown-toggle w-100 justify-content-start d-lg-none mb-2" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                  <i class="ci-grid fs-lg"></i>
                  <span class="ms-2 me-auto">Danh mục</span>
                </button>

                <!-- Mega menu danh mục sản phẩm-->
                  {{-- <ul class="dropdown-menu dropdown-menu-static w-100 rounded-top-0 rounded-bottom-4 py-1 p-lg-1" style="--cz-dropdown-spacer: 0; --cz-dropdown-item-padding-y: .625rem; --cz-dropdown-item-spacer: 0"> --}}
                  {{-- <ul class="dropdown-menu w-100 rounded-top-0 rounded-bottom-4 py-1 p-lg-1" style="--cz-dropdown-spacer: 0; --cz-dropdown-item-padding-y: .625rem; --cz-dropdown-item-spacer: 0"> --}}
                    @if(Route::currentRouteName() === 'home')
                      <ul class="dropdown-menu dropdown-menu-static w-100 rounded-top-0 rounded-bottom-4 py-1 p-lg-1" style="--cz-dropdown-spacer: 0; --cz-dropdown-item-padding-y: .625rem; --cz-dropdown-item-spacer: 0">
                    @else
                      <ul class="dropdown-menu w-100 rounded-top-0 rounded-bottom-4 py-1 p-lg-1" style="--cz-dropdown-spacer: 0; --cz-dropdown-item-padding-y: .625rem; --cz-dropdown-item-spacer: 0">
                    @endif

                    <li class="d-lg-none pt-2">
                      <a class="dropdown-item fw-medium" href="shop-categories-electronics.html">
                        <i class="ci-grid fs-xl opacity-60 pe-1 me-2"></i>
                        Tất cả danh mục
                        <i class="ci-chevron-right fs-base ms-auto me-n1"></i>
                      </a>
                    </li>


                      @foreach ($categories as $category)
                      <li class="dropend position-static">
                        <div class="position-relative rounded pt-2 pb-1 px-lg-2" data-bs-toggle="dropdown" data-bs-trigger="hover">

                          <!-- Link cho danh mục lớn -->
                          <a class="dropdown-item fw-medium stretched-link d-none d-lg-flex" href="{{ route('category.show', $category->id) }}">
                            {{-- <i class="ci-smartphone-2 fs-xl opacity-60 pe-1 me-2"></i> --}}
                             {{-- <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 100px"> --}}
                            <span class="text-truncate">{{ $category->name }}</span>
                            <i class="ci-chevron-right fs-base ms-auto me-n1"></i>
                          </a>

                          <!-- Hiển thị trên màn hình nhỏ -->
                          <div class="dropdown-item fw-medium text-wrap stretched-link d-lg-none">
                            <i class="ci-{{ $category->icon }} fs-xl opacity-60 pe-1 me-2"></i>
                            {{ $category->name }}
                            <i class="ci-chevron-down fs-base ms-auto me-n1"></i>
                          </div>
                        </div>
                        <div class="dropdown-menu rounded-4 p-4" style="top: 1rem; height: 100%;">
                          <div class="d-flex flex-column flex-lg-row h-100 gap-4">
                            <div style="min-width: 194px">
                              <div class="d-flex w-100">
                                <a class="h6 text-dark-emphasis text-decoration-none text-truncate" href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                              </div>
                              <ul class="nav flex-column gap-2 mt-n2">
                                @foreach ($category->products as $product)
                                  <li class="d-flex w-100 pt-1">
                                    <a class="nav-link d-inline fw-normal text-truncate p-0" href="{{ route('product.show', $product->id) }}">
                                      {{ $product->name }}
                                    </a>
                                  </li>
                                @endforeach
                              </ul>
                            </div>
                          </div>
                        </div>
                     </li>
                     @endforeach
                  </ul>

              </div>
            </div>
          </div>

          <!-- Navbar nav -->
          <div class="col-lg-9 d-lg-flex pt-3 pt-lg-0 ps-lg-0">
            <ul class="navbar-nav position-relative">
              <li class="nav-item me-lg-n2 me-xl-0">
                <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
              </li>
              <li class="nav-item dropdown position-static me-lg-n1 me-xl-0">
                <a class="nav-link" href="{{route('shop')}}">Sản phẩm</a>
              </li>
              <li class="nav-item dropdown position-static me-lg-n1 me-xl-0">
                <a class="nav-link" href="{{ route('news.index') }}">Tin tức</a>
              </li>

              <li class="nav-item me-lg-n2 me-xl-0">
                <a class="nav-link" href="{{route('cart.index')}}">Giỏ hàng</a>
              </li>
              <li class="nav-item me-lg-n2 me-xl-0">
                <a class="nav-link" href="{{route('order.publicHistory')}}">Tra cứu đơn hàng</a>
              </li>
            </ul>
            <hr class="d-lg-none my-3">
          </div>
        </div>
      </div>
    </div>
    <div class="offcanvas-header border-top px-0 py-3 mt-3 d-md-none">
      <div class="nav nav-justified w-100">
        <a class="nav-link border-end" href="account-signin.html">
          <i class="ci-user fs-lg opacity-60 me-2"></i>
          Account
        </a>
        <a class="nav-link" href="account-wishlist.html">
          <i class="ci-heart fs-lg opacity-60 me-2"></i>
          Wishlist
        </a>
      </div>
    </div>
  </nav>
</div>

<script>
  // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
  function updateCartItemCount() {
      fetch('/cart/item-count') // Gọi API từ server
          .then(response => response.json())
          .then(data => {
              const cartCountElement = document.getElementById('cartCount');
              cartCountElement.textContent = data.count > 0 ? data.count : ''; // Ẩn khi giỏ hàng rỗng
          })
          .catch(error => console.error('Error fetching cart item count:', error));
  }

  // Gọi hàm khi trang được tải
  document.addEventListener('DOMContentLoaded', updateCartItemCount);

  // Gọi lại hàm khi thêm sản phẩm vào giỏ hàng (nếu bạn có nút thêm sản phẩm)
  document.querySelectorAll('.add-to-cart-btn').forEach(button => {
      button.addEventListener('click', () => {
          updateCartItemCount();
      });
  });

</script>
