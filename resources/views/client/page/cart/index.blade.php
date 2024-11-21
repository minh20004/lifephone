@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">

    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
        <li class="breadcrumb-item"><a href="shop-catalog-electronics.html">Shop</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cart</li>
      </ol>
    </nav>


    <!-- Items in the cart + Order summary -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
      <h1 class="h3 mb-4">Giỏ hàng</h1>
      <div class="row">

        <!-- Items list -->
        <div class="col-lg-8">
          <div class="pe-lg-2 pe-xl-3 me-xl-3">
            <p class="fs-sm">Mua thêm <span class="text-dark-emphasis fw-semibold">$183</span> để được <span class="text-dark-emphasis fw-semibold">Miễn phí vận chuyển</span></p>
            <div class="progress w-100 overflow-visible mb-4" role="progressbar" aria-label="Free shipping progress" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
              <div class="progress-bar bg-warning rounded-pill position-relative overflow-visible" style="width: 75%; height: 4px">
                <div class="position-absolute top-50 end-0 d-flex align-items-center justify-content-center translate-middle-y bg-body border border-warning rounded-circle me-n1" style="width: 1.5rem; height: 1.5rem">
                  <i class="ci-star-filled text-warning"></i>
                </div>
              </div>
            </div>

            
        @if(session()->has('cart') && count(session('cart')) > 0)
  <table class="table table-bordered mb-4">
    <thead class="table-light">
      <tr>
        <th>Sản phẩm</th>
        <th class="d-none d-xl-table-cell">Giá</th>
        <th class="d-none d-md-table-cell">Số lượng</th>
        <th class="d-none d-md-table-cell">Tổng cộng</th>
        <th class="text-center">
          <button class="btn btn-outline-danger">Xóa giỏ hàng</button>
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($cartItems as $item)
          <tr data-product-id="{{ $item['product']->id }}" data-model-id="{{ $item['capacity']->id }}" data-color-id="{{ $item['color']->id }}">
              <td>
                  <!-- Checkbox để chọn sản phẩm -->
                  <div class="form-check">
                      <input 
                          class="form-check-input cart-item-checkbox" 
                          type="checkbox" 
                          value="{{ $item['product']->id }}-{{ $item['capacity']->id }}-{{ $item['color']->id }}" 
                          checked>
                  </div>
              </td>
              <td>
                  <div class="d-flex align-items-center">
                      <a href="shop-product-general-electronics.html">
                          <img src="{{ asset('storage/' . $item['product']->image_url) }}" width="110" class="img-fluid rounded">
                      </a>
                      <div class="ms-3">
                          <h5><a href="shop-product-general-electronics.html">{{ $item['product']->name }}</a></h5>
                          <ul>
                              <li>Màu sắc: <span>{{ $item['color']->name }}</span></li>
                              <li>Dung lượng: <span>{{ $item['capacity']->name }}</span></li>
                          </ul>
                      </div>
                  </div>
              </td>
              <td class="d-none d-xl-table-cell">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
              <td class="d-none d-md-table-cell">
                  <div class="input-group input-group-sm count-input">
                      <button class="btn btn-outline-secondary btn-decrement" type="button">−</button>
                      <input type="number" value="{{ $item['quantity'] }}" class="form-control" readonly>
                      <button class="btn btn-outline-secondary btn-increment" type="button">+</button>
                  </div>
              </td>
              <td class="d-none d-md-table-cell" id="itemTotal-{{ $item['product']->id }}-{{ $item['capacity']->id }}-{{ $item['color']->id }}">{{ number_format($item['itemTotal'], 0, ',', '.') }} đ</td>
              <td class="text-center">
                  <form action="{{ route('cart.remove', ['productId' => $item['product']->id, 'modelId' => $item['capacity']->id, 'colorId' => $item['color']->id]) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn-close"></button>
                  </form>
              </td>
          </tr>
      @endforeach
  </tbody>
  
  </table>
@else
  <p class="text-center text-muted">Giỏ hàng của bạn hiện đang trống.</p>
@endif

<div class="nav mb-4">
  <a class="nav-link" href="{{ route('home') }}">
    <i class="ci-chevron-left fs-lg"></i> Tiếp tục mua sắm
  </a>
</div>

<aside class="col-lg-4">
  <div class="position-sticky top-0">
    <div class="bg-body-tertiary rounded-5 p-4 mb-3">
      <h5>Tóm tắt đơn hàng</h5>
      <ul class="list-unstyled">
        <li>Tổng cộng <b>{{ $totalQuantity }}</b> sản phẩm: <span id="totalPrice">{{ number_format($totalPrice, 0, ',', '.') }} đ</span></li>
        <li>Giảm giá: <span id="discount" class="text-danger">{{ number_format($discount, 0, ',', '.') }} đ</span></li>
        <li>Vận chuyển: Tính Toán khi thanh toán</li>
      </ul>
      <div class="border-top pt-4">
        <div class="d-flex justify-content-between">
          <span>Tổng ước tính:</span>
          <span class="h5" id="totalAfterDiscount">{{ number_format($totalAfterDiscount, 0, ',', '.') }} đ</span>
        </div>
        <a class="btn btn-lg btn-primary w-100 mt-3" href="{{ route('checkout') }}">
          Tiến hành thanh toán
          <i class="ci-chevron-right fs-lg ms-1"></i>
        </a>
      </div>
    </div>

    <div class="accordion bg-body-tertiary rounded-5 p-4">
      <div class="accordion-item border-0">
        <h3 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#promoCode">
            <i class="ci-percent fs-xl"></i> Áp dụng mã khuyến mãi
          </button>
        </h3>
        <div class="accordion-collapse collapse" id="promoCode">
          <div class="accordion-body">
            <form action="{{ route('cart.apply-voucher') }}" method="POST">
              @csrf
              <div class="input-group">
                <input type="text" name="voucher_code" class="form-control" placeholder="Nhập mã khuyến mãi" required>
                <button type="submit" class="btn btn-dark">Áp dụng</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</aside>

      
      
      </div>
    </section>
    <!-- Trending products (Carousel) -->
    <section class="container pb-4 pb-md-5 mb-2 mb-sm-0 mb-lg-2 mb-xl-4">
      <h2 class="h3 border-bottom pb-4 mb-0">Trending products</h2>

      <!-- Product carousel -->
      <div class="position-relative mx-md-1">

        <!-- External slider prev/next buttons visible on screens > 500px wide (sm breakpoint) -->
        <button type="button" class="trending-prev btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start position-absolute top-50 start-0 z-2 translate-middle-y ms-n1 d-none d-sm-inline-flex" aria-label="Prev">
          <i class="ci-chevron-left fs-lg animate-target"></i>
        </button>
        <button type="button" class="trending-next btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end position-absolute top-50 end-0 z-2 translate-middle-y me-n1 d-none d-sm-inline-flex" aria-label="Next">
          <i class="ci-chevron-right fs-lg animate-target"></i>
        </button>

        <!-- Slider -->
        <div class="swiper py-4 px-sm-3" data-swiper="{
          &quot;slidesPerView&quot;: 2,
          &quot;spaceBetween&quot;: 24,
          &quot;loop&quot;: true,
          &quot;navigation&quot;: {
            &quot;prevEl&quot;: &quot;.trending-prev&quot;,
            &quot;nextEl&quot;: &quot;.trending-next&quot;
          },
          &quot;breakpoints&quot;: {
            &quot;768&quot;: {
              &quot;slidesPerView&quot;: 3
            },
            &quot;992&quot;: {
              &quot;slidesPerView&quot;: 4
            }
          }
        }">
          <div class="swiper-wrapper">

            <!-- Item -->
            <div class="swiper-slide">
              <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                <div class="position-relative">
                  <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                    <div class="d-flex flex-column gap-2">
                      <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
                        <i class="ci-heart fs-base animate-target"></i>
                      </button>
                      <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                        <i class="ci-refresh-cw fs-base animate-target"></i>
                      </button>
                    </div>
                  </div>
                  <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                      <i class="ci-more-vertical fs-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                      <li>
                        <a class="dropdown-item" href="#!">
                          <i class="ci-heart fs-sm ms-n1 me-2"></i>
                          Add to Wishlist
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#!">
                          <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                          Compare
                        </a>
                      </li>
                    </ul>
                  </div>
                  <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="shop-product-general-electronics.html">
                    <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">-21%</span>
                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                      <img src="{{asset('client/img/shop/electronics/01.png')}}" alt="VR Glasses">
                    </div>
                  </a>
                </div>
                <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="d-flex gap-1 fs-xs">
                      <i class="ci-star-filled text-warning"></i>
                      <i class="ci-star-filled text-warning"></i>
                      <i class="ci-star-filled text-warning"></i>
                      <i class="ci-star-filled text-warning"></i>
                      <i class="ci-star text-body-tertiary opacity-75"></i>
                    </div>
                    <span class="text-body-tertiary fs-xs">(123)</span>
                  </div>
                  <h3 class="pb-1 mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                      <span class="animate-target">VRB01 Virtual Reality Glasses</span>
                    </a>
                  </h3>
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="h5 lh-1 mb-0">$340.99 <del class="text-body-tertiary fs-sm fw-normal">$430.00</del></div>
                    <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                      <i class="ci-shopping-cart fs-base animate-target"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            

            
          </div>
        </div>

        <!-- External slider prev/next buttons visible on screens < 500px wide (sm breakpoint) -->
        <div class="d-flex justify-content-center gap-2 mt-n2 mb-3 pb-1 d-sm-none">
          <button type="button" class="trending-prev btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start me-1" aria-label="Prev">
            <i class="ci-chevron-left fs-lg animate-target"></i>
          </button>
          <button type="button" class="trending-next btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end" aria-label="Next">
            <i class="ci-chevron-right fs-lg animate-target"></i>
          </button>
        </div>
      </div>
    </section>


    <!-- Subscription form + Vlog -->
    <section class="bg-body-tertiary py-5">
      <div class="container pt-sm-2 pt-md-3 pt-lg-4 pt-xl-5">
        <div class="row">
          <div class="col-md-6 col-lg-5 mb-5 mb-md-0">
            <h2 class="h4 mb-2">Sign up to our newsletter</h2>
            <p class="text-body pb-2 pb-ms-3">Receive our latest updates about our products &amp; promotions</p>
            <form class="d-flex needs-validation pb-1 pb-sm-2 pb-md-3 pb-lg-0 mb-4 mb-lg-5" novalidate="">
              <div class="position-relative w-100 me-2">
                <input type="email" class="form-control form-control-lg" placeholder="Your email" required="">
              </div>
              <button type="submit" class="btn btn-lg btn-primary">Subscribe</button>
            </form>
            <div class="d-flex gap-3">
              <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Instagram">
                <i class="ci-instagram fs-base"></i>
              </a>
              <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Facebook">
                <i class="ci-facebook fs-base"></i>
              </a>
              <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="YouTube">
                <i class="ci-youtube fs-base"></i>
              </a>
              <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Telegram">
                <i class="ci-telegram fs-base"></i>
              </a>
            </div>
          </div>
          <div class="col-md-6 col-lg-5 col-xl-4 offset-lg-1 offset-xl-2">
            <ul class="list-unstyled d-flex flex-column gap-4 ps-md-4 ps-lg-0 mb-3">
              <li class="nav flex-nowrap align-items-center position-relative">
                <img src="{{asset('client/img/home/electronics/vlog/01.jpg')}}" class="rounded" width="140" alt="Video cover">
                <div class="ps-3">
                  <div class="fs-xs text-body-secondary lh-sm mb-2">6:16</div>
                  <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 New Cool Gadgets You Must See on Cartzilla - Cheap Budget</a>
                </div>
              </li>
              <li class="nav flex-nowrap align-items-center position-relative">
                <img src="{{asset('client/img/home/electronics/vlog/02.jpg')}}" class="rounded" width="140" alt="Video cover">
                <div class="ps-3">
                  <div class="fs-xs text-body-secondary lh-sm mb-2">10:20</div>
                  <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 Super Useful Gadgets on Cartzilla You Must Have in 2023</a>
                </div>
              </li>
              <li class="nav flex-nowrap align-items-center position-relative">
                <img src="{{asset('client/img/home/electronics/vlog/03.jpg')}}" class="rounded" width="140" alt="Video cover">
                <div class="ps-3">
                  <div class="fs-xs text-body-secondary lh-sm mb-2">8:40</div>
                  <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">Top 5 New Amazing Gadgets on Cartzilla You Must See</a>
                </div>
              </li>
            </ul>
            <div class="nav ps-md-4 ps-lg-0">
              <a class="btn nav-link animate-underline text-decoration-none px-0" href="#!">
                <span class="animate-target">View all</span>
                <i class="ci-chevron-right fs-base ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Back to top button -->
  <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
    <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
      Top
      <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
      <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
      <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></rect>
      </svg>
    </a>
    <a class="btn btn-sm btn-outline-secondary text-uppercase bg-body rounded-pill shadow animate-rotate ms-2 me-n5" href="#customizer" style="font-size: .625rem; letter-spacing: .05rem;" data-bs-toggle="offcanvas" role="button" aria-controls="customizer">
      Customize<i class="ci-settings fs-base ms-1 me-n2 animate-target"></i>
    </a>
  </div>
@endsection




