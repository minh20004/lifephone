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
            {{-- cảnh báo vượt quá số lượng --}}
            @if($errors->has('quantity'))
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach($errors->get('quantity') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="progress w-100 overflow-visible mb-4" role="progressbar" aria-label="Free shipping progress" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
              <div class="progress-bar bg-warning rounded-pill position-relative overflow-visible" style="width: 75%; height: 4px">
                <div class="position-absolute top-50 end-0 d-flex align-items-center justify-content-center translate-middle-y bg-body border border-warning rounded-circle me-n1" style="width: 1.5rem; height: 1.5rem">
                  <i class="ci-star-filled text-warning"></i>
                </div>
              </div>
            </div>
            
        <!-- Table of items -->
        @if(session()->has('cart') && count(session('cart')) > 0)
        <table class="table position-relative z-2 mb-4">
          <thead>
            <tr>
              <th scope="col" class="fs-sm fw-normal py-3 ps-0"><span class="text-body">Sản phẩm</span></th>
              <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-xl-table-cell"><span class="text-body">Giá</span></th>
              <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span class="text-body">Số lượng</span></th>
              <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span class="text-body">Tổng cộng</span></th>
              <th scope="col" class="py-0 px-0">
                <div class="nav justify-content-end">
                  <button type="button" class="nav-link d-inline-block text-decoration-underline text-nowrap py-3 px-0">Xóa giỏ hàng</button>
                </div>
              </th>
            </tr>
          </thead>
          <tbody class="align-middle">

            <!-- Item -->
            @foreach ($cartItems as $item)
              <tr data-product-id="{{ $item['product']->id }}" data-model-id="{{ $item['capacity']->id }}" data-color-id="{{ $item['color']->id }}">
                <td class="py-3 ps-0">
                  <div class="d-flex align-items-center">
                    <a class="flex-shrink-0" href="shop-product-general-electronics.html">
                      <img src="{{ asset('storage/' . $item['product']->image_url) }}" width="110" alt="iPhone 14">
                    </a>
                    <div class="w-100 min-w-0 ps-2 ps-xl-3">
                      <h5 class="d-flex animate-underline mb-2">
                        <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">{{ $item['product']->name }}</a>
                      </h5>
                      <ul class="list-unstyled gap-1 fs-xs mb-0">
                        <li><span class="text-body-secondary">Màu sắc:</span> <span class="text-dark-emphasis fw-medium">{{ $item['color']->name }}</span></li>
                        <li><span class="text-body-secondary">Dung lượng:</span> <span class="text-dark-emphasis fw-medium">{{ $item['capacity']->name }}</span></li>
                      </ul>
                      <div class="count-input rounded-2 d-md-none mt-3">
                        <div class="input-group input-group-sm count-input">
                          <button class="btn btn-outline-secondary btn-decrement" type="button">−</button>
                          <input type="number" value="{{ $item['quantity'] }}" class="form-control" readonly min="1" max="5">
                          <button class="btn btn-outline-secondary btn-increment" type="button">+</button>
                      </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="h6 py-3 d-none d-xl-table-cell">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                <td class="py-3 d-none d-md-table-cell">
                  
                  <div class="count-input" style="display: flex; align-items: center; border: 1px solid #d1d5db; border-radius: 8px; width: 120px; justify-content: space-between; padding: 5px;">
                      <button type="button" class="btn-decrement" style="background: none; border: none; font-size: 20px; cursor: pointer;">−</button>
                      <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" readonly style="width: 30px; text-align: center; border: none; outline: none; font-size: 16px;">
                      <button type="button" class="btn-increment" style="background: none; border: none; font-size: 20px; cursor: pointer;">+</button>
                  </div>
                
                </td>
                <td class="h6 py-3 d-none d-md-table-cell" id="itemTotal-{{ $item['product']->id }}-{{ $item['capacity']->id }}-{{ $item['color']->id }}">{{ number_format($item['itemTotal'], 0, ',', '.') }} đ</td>
                <td class="text-end py-3 px-0">
                  <form action="{{ route('cart.remove', ['productId' => $item['product']->id, 'modelId' => $item['capacity']->id, 'colorId' => $item['color']->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không ?')"></button>
                  </form>
                </td>
              </tr>
            @endforeach
            
          </tbody>
        </table>
      @else
      <p>Giỏ hàng của bạn hiện đang trống.</p>
      @endif
      <div class="nav position-relative z-2 mb-4 mb-lg-0">
        <a class="nav-link animate-underline px-0" href="{{route('home')}}">
          <i class="ci-chevron-left fs-lg me-1"></i>
          <span class="animate-target">Tiếp tục mua sắm</span>
        </a>
      </div>
    </div>
  </div>
  
  <!-- Tóm tắt đơn hàng (sticky sidebar) -->
  <aside class="col-lg-4" style="margin-top: -100px">
    <div class="position-sticky top-0" style="padding-top: 100px">
      <div class="bg-body-tertiary rounded-5 p-4 mb-3">
        <div class="p-sm-2 p-lg-0 p-xl-2">
          <h5 class="border-bottom pb-4 mb-4">Tóm tắt đơn hàng</h5>
          <ul class="list-unstyled fs-sm gap-3 mb-0">
            <li class="d-flex justify-content-between">
              <span id="totalQuantity">(Tổng cộng <b>{{ $totalQuantity }}</b> sản phẩm):</span> 
              <span class="text-dark-emphasis fw-medium"><span id="totalPrice">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
            </li>
            <li class="d-flex justify-content-between">
              Giảm giá:
              <span id="discount" class="text-danger">{{ number_format($discount, 0, ',', '.') }} đ</span>
            </li>
            <li class="d-flex justify-content-between">
              Vận chuyển:
              <span class="text-dark-emphasis fw-medium">Tính Toán khi thanh toán</span>
            </li>
          </ul>
          <div class="border-top pt-4 mt-4">
            <div class="d-flex justify-content-between mb-3">
              <span class="fs-sm">Tổng ước tính:</span>
              <span class="h5 mb-0"><span id="totalAfterDiscount">{{ number_format($totalAfterDiscount, 0, ',', '.') }} đ</span>
            </div>
            <a class="btn btn-lg btn-primary w-100" href="{{ route('checkout') }}">
              Tiến hành thanh toán
              <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
            </a>

          </div>
        </div>
      </div>
      <div class="accordion bg-body-tertiary rounded-5 p-4">
        <div class="accordion-item border-0">
          <h3 class="accordion-header" id="promoCodeHeading">
            <button type="button" class="accordion-button animate-underline collapsed py-0 ps-sm-2 ps-lg-0 ps-xl-2" data-bs-toggle="collapse" data-bs-target="#promoCode" aria-expanded="false" aria-controls="promoCode">
              <i class="ci-percent fs-xl me-2"></i>
              <span class="animate-target me-2">Áp dụng mã khuyến mãi</span>
            </button>
          </h3>
          <div class="accordion-collapse collapse" id="promoCode" aria-labelledby="promoCodeHeading">
            <div class="accordion-body pt-3 pb-2 ps-sm-2 px-lg-0 px-xl-2">
              <form action="{{ route('cart.apply-voucher') }}" method="POST" class="needs-validation d-flex gap-2" novalidate="">
                @csrf
                <div class="position-relative w-100">
                  <input type="text" name="voucher_code" id="voucher_code" class="form-control" placeholder="Nhập mã khuyến mãi" required="">
                  <div class="invalid-tooltip bg-transparent py-0">Enter a valid promo code!</div>
                </div>
                <button type="submit" class="btn btn-dark">Áp dụng</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </aside>
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



