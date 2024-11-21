@extends('client.layout.master')
@section('title')
Lifephone
@endsection
@section('content')
<main class="content-wrapper">
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh mục sản phẩm</li>
      </ol>
    </nav>

    <!-- Page title -->
    <h1 class="h3 container mb-sm-4">Danh mục sản phẩm</h1>

       <!-- Brands -->
      <section class="container pt-4 pt-md-5 pb-5 mt-sm-2 mb-2">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 g-md-4 g-lg-3 g-xl-4">
          @foreach ($categories as $category)
          <div class="col">
              <a class="btn btn-outline-secondary w-100 rounded-4 p-3" href="#">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid">
              </a>
          </div>
          @endforeach
        </div>
    </section>

    <!-- Category cards -->
    <section class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gy-5">
        @foreach ($categories as $category)
            <!-- Category -->
            <div class="col">
                <div class="hover-effect-scale">
                    <!-- Image and Link to Category -->
                    <a class="d-block bg-body-tertiary rounded p-4 mb-4" href="{{ route('category.show', $category->id) }}">
                        <div class="ratio" style="--cz-aspect-ratio: calc(184 / 258 * 100%)">
                            <img src="{{ asset('storage/' . $category->image_page) }}" class="hover-effect-target" alt="{{ $category->name }}">
                        </div>
                    </a>
                    <!-- Category Name -->
                    <h2 class="h6 d-flex w-100 pb-2 mb-1">
                        <a class="animate-underline animate-target d-inline text-truncate" href="{{ route('category.show', $category->id) }}">
                            {{ $category->name }}
                        </a>
                    </h2>
                    <!-- Products List -->
                    <ul class="nav flex-column gap-2 mt-n1">
                        @foreach ($category->products as $product)
                            <li class="d-flex w-100 pt-1">
                                <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="{{ route('product.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>
    </section>

    <!-- Banners -->
    <section class="container pb-4 pt-5 mb-3">
      <div class="row g-3 g-lg-4">
        <div class="col-md-7">
          <div class="position-relative d-flex flex-column flex-sm-row align-items-center h-100 rounded-5 overflow-hidden px-5 px-sm-0 pe-sm-4">
            <span class="position-absolute top-0 start-0 w-100 h-100 d-none-dark rtl-flip" style="background: linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
            <span class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark rtl-flip" style="background: linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>
            <div class="position-relative z-1 text-center text-sm-start pt-4 pt-sm-0 ps-xl-4 mt-2 mt-sm-0 order-sm-2">
              <h2 class="h3 mb-2">iPhone 14</h2>
              <p class="fs-sm text-light-emphasis mb-sm-4">Apple iPhone 14 128GB Blue</p>
              <a class="btn btn-primary" href="shop-product-general-electronics.html">
                From $899
                <i class="ci-arrow-up-right fs-base ms-1 me-n1"></i>
              </a>
            </div>
            <div class="position-relative z-1 w-100 align-self-end order-sm-1" style="max-width: 416px">
              <div class="ratio rtl-flip" style="--cz-aspect-ratio: calc(320 / 416 * 100%)">
                <img src="client/assets/img/shop/electronics/banners/iphone-1.png" alt="iPhone 14">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="position-relative d-flex flex-column align-items-center justify-content-between h-100 rounded-5 overflow-hidden pt-3">
            <span class="position-absolute top-0 start-0 w-100 h-100 d-none-dark rtl-flip" style="background: linear-gradient(90deg, #fdcbf1 0%, #fdcbf1 1%, #ffecfa 100%)"></span>
            <span class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark rtl-flip" style="background: linear-gradient(90deg, #362131 0%, #322730 100%)"></span>
            <div class="position-relative z-1 text-center pt-3 mx-4">
              <i class="ci-apple text-body-emphasis fs-3 mb-3"></i>
              <p class="fs-sm text-light-emphasis mb-1">Deal of the week</p>
              <h2 class="h3 mb-4">iPad Pro M1</h2>
            </div>
            <a class="position-relative z-1 d-block w-100" href="shop-product-general-electronics.html">
              <div class="ratio rtl-flip" style="--cz-aspect-ratio: calc(159 / 525 * 100%)">
                <img src="client/assets/img/shop/electronics/banners/ipad.png" width="525" alt="iPad">
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Trending products (Grid) -->
    <section class="container pb-5 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">

        <!-- Item -->
        <div class="col">
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
                  <img src="client/assets/img/shop/electronics/01.png" alt="VR Glasses">
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
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Display:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">OLED 1440x1600</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Graphics:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Adreno 540</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Sound:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">2x3.5mm jack</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Input:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">4 built-in cameras</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/02.png" alt="iPhone 14">
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
                  <i class="ci-star-half text-warning"></i>
                </div>
                <span class="text-body-tertiary fs-xs">(142)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Apple iPhone 14 128GB White</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$899.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Display:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">6.1" XDR</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Capacity:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">128 GB</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Chip:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">A15 Bionic</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Camera:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">12 + 12 MP</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Weight:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">172 grams</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/03.png" alt="Smart Watch">
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
                  <i class="ci-star-filled text-warning"></i>
                </div>
                <span class="text-body-tertiary fs-xs">(67)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Smart Watch Series 7, White</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$429.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Display:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">45mm OLED</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Chip:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">64-bit Dual-core</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Connectivity:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Wi-Fi, Bluetooth</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Power:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Lithium-ion battery</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Weight:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">37.0 grams</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
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
                <span class="badge bg-info position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">New</span>
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/04.png" alt="MacBook">
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
                  <i class="ci-star-half text-warning"></i>
                </div>
                <span class="text-body-tertiary fs-xs">(51)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Laptop Apple MacBook Pro 13 M2</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$1,200.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Chip:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Apple M2</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Memory:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">8 GB unified</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Storage:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">256 GB SSD</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Display:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">13.3-inch Retina</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
          <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
            <div class="posittion-relative">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/05.png" alt="iPad Air">
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
                  <i class="ci-star-filled text-warning"></i>
                </div>
                <span class="text-body-tertiary fs-xs">(12)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Tablet Apple iPad Air M1</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$540.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Display:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">10.9" LED</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Capacity:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">64 GB</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Chip:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Apple M1</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Camera:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">12 MP Wide</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Weight:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">462 grams</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/06.png" alt="AirPods 2">
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
                <span class="text-body-tertiary fs-xs">(78)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Headphones Apple AirPods 2 Pro</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$224.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Audio:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Noise Cancellation</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Sensors:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Touch control</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Chip:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Apple H2</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Weight:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">50.8 grams</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
          <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
            <div class="posittion-relative">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/07.png" alt="iPad Pro">
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
                  <i class="ci-star-half text-warning"></i>
                </div>
                <span class="text-body-tertiary fs-xs">(49)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Tablet Apple iPad Pro M1</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$739.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Display:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">11" LED</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Capacity:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">128 GB</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Chip:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Apple M1</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Camera:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">12 MP Wide</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Weight:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">470 grams</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Item -->
        <div class="col">
          <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
            <div class="posittion-relative">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                  <img src="client/assets/img/shop/electronics/08.png" alt="Bluetooth Headphones">
                </div>
              </a>
            </div>
            <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="d-flex gap-1 fs-xs">
                  <i class="ci-star-filled text-warning"></i>
                  <i class="ci-star-filled text-warning"></i>
                  <i class="ci-star-filled text-warning"></i>
                  <i class="ci-star-half text-warning"></i>
                  <i class="ci-star text-body-tertiary opacity-75"></i>
                </div>
                <span class="text-body-tertiary fs-xs">(136)</span>
              </div>
              <h3 class="pb-1 mb-2">
                <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                  <span class="animate-target">Wireless Bluetooth Headphones Sony</span>
                </a>
              </h3>
              <div class="d-flex align-items-center justify-content-between">
                <div class="h5 lh-1 mb-0">$299.00</div>
                <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                  <i class="ci-shopping-cart fs-base animate-target"></i>
                </button>
              </div>
            </div>
            <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
              <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
              <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Audio:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Noise Cancellation</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Connectivity:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Bluetooth, 3.5mm jack</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Material:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">Leather, Plastic</span>
                </li>
                <li class="d-flex align-items-center">
                  <span class="fs-xs">Weight:</span>
                  <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                  <span class="text-dark-emphasis fs-xs fw-medium text-end">185 grams</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection