@extends('client.layout.master')
@section('content')
<div>
  <!-- Breadcrumb -->
  <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Catalog with sidebar filters</li>
    </ol>
  </nav>
  <!-- Page title -->
  <h1 class="h3 container mb-4">Shop catalog</h1>
  <!-- Banners that are turned into collaspse on screens < 768px wide (sm breakpoint) -->
  <section class="accordion container pb-4 pb-md-5 mb-xl-3">
    <div class="accordion-item border-0">
      <div class="accordion-header d-md-none" id="offersHeading">
        <button type="button" class="accordion-button w-auto fw-medium collapsed border border-dashed border-danger border-opacity-50 rounded py-2 px-3" data-bs-toggle="collapse" data-bs-target="#offers" aria-expanded="false" aria-controls="offers">
          <span class="d-inline-flex ci-percent fs-lg text-danger rounded-circle me-2"></span>
          <span class="me-2">See latest offers</span>
        </button>
      </div>
      <div class="accordion-collapse collapse d-md-block" id="offers" aria-labelledby="offersHeading">
        <div class="row g-3 g-lg-4 pt-3 pt-md-0">
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
                  <img src="assets/img/shop/electronics/banners/iphone-1.png" alt="iPhone 14">
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
                <div class="ratio" style="--cz-aspect-ratio: calc(159 / 525 * 100%)">
                  <img src="assets/img/shop/electronics/banners/ipad.png" width="525" alt="iPad">
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Products grid + Sidebar with filters -->
  <section class="container pb-5 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">
      <!-- Filter sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
      <aside class="col-lg-3">
        <div class="offcanvas-lg offcanvas-start" id="filterSidebar">
          <div class="offcanvas-header py-3">
            <h5 class="offcanvas-title">Filter and sort</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body flex-column pt-2 py-lg-0">
            <!-- Categories --> 
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6 mb-2">Categories</h4>
              <ul class="list-unstyled d-block m-0">
                @foreach ($categories as $item)
                <li class="nav d-block pt-2 mt-1">
                  <button type="button" class="nav-link w-auto category-filter" data-category-id="{{ $item->id }}">
                    <span class="animate-target text-truncate me-3">{{ $item->name }}</span>
                    <!-- Hiển thị số lượng sản phẩm hoặc biến thể -->
                    <span class="text-body-secondary fs-xs ms-auto">{{ $item->product_variants_count ?? $item->products_count }}</span>
                    </a>
                </li>
                @endforeach
              </ul>
            </div>
            <!-- Price range -->
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6 mb-2" id="slider-label">Price</h4>
              <div class="range-slider" data-range-slider="{&quot;startMin&quot;: 340, &quot;startMax&quot;: 1250, &quot;min&quot;: 0, &quot;max&quot;: 1600, &quot;step&quot;: 1, &quot;tooltipPrefix&quot;: &quot;$&quot;}" aria-labelledby="slider-label">
                <div class="range-slider-ui"></div>
                <div class="d-flex align-items-center">
                  <div class="position-relative w-50">
                    <i class="ci-dollar-sign position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                    <input type="number" id="min_price" class="form-control form-icon-start" min="0" placeholder="Giá tối thiểu">
                  </div>
                  <i class="ci-minus text-body-emphasis mx-2"></i>
                  <div class="position-relative w-50">
                    <i class="ci-dollar-sign position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                    <input type="number" id="max_price" class="form-control form-icon-start" min="0" placeholder="Giá tối đa">
                  </div>
                </div>
              </div>
              <div id="product-list" class="mt-4"></div>
            </div>
            <!-- SSD size (checkboxes) -->
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6">Capacity</h4>
              <div class="d-flex flex-column gap-1">
                @foreach ($capacities as $item)
                <div class="d-flex align-items-center justify-content-between">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input capacity-checkbox" id="tb-{{$item->id}}" value="{{ $item->id }}">
                    <label for="tb-{{$item->id}}" class="form-check-label text-body-emphasis">{{$item->name}}</label>
                  </div>
                  <span class="text-body-secondary fs-xs">{{$item->products_count}}</span>
                </div>
                @endforeach
              </div>
            </div>
            <!-- Color -->
            <div class="w-100 border rounded p-3 p-xl-4">
              <h4 class="h6">Color</h4>
              <div class="nav d-block mt-n2">
                @foreach ($colors as $color)
                <button type="button" class="nav-link w-auto animate-underline fw-normal pt-2 pb-0 px-0">
                  <span class="rounded-circle me-2" style="width: .875rem; height: .875rem; margin-top: .125rem; background-color: {{ $color->code }}"></span>
                  <span class="animate-target">{{ $color->name }}</span>
                </button>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </aside>
      <!-- Product grid -->
      <div class="col-lg-9">
        <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">
          <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">
            <div id="product-list">
              <!-- Sản phẩm sẽ được load vào đây qua Ajax -->
            </div>
          </div>
          <div id="filtered-products">
            <!-- Danh sách sản phẩm sẽ được cập nhật ở đây -->
          </div>
          <!-- Item -->
          @foreach ($products as $item)
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
                  <!-- <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">-21%</span> -->
                  <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
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
                  <!-- <span class="text-body-tertiary fs-xs">(123)</span> -->
                </div>
                <h3 class="pb-1 mb-2">
                  <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                    <span class="animate-target">{{$item->name}}</span>
                  </a>
                </h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="h5 lh-1 mb-0">{{ $item->price }} <del class="text-body-tertiary fs-sm fw-normal">$430.00</del></div>
                  <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                    <i class="ci-shopping-cart fs-base animate-target"></i>
                  </button>
                </div>
              </div>
              <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
                <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
                <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                  @foreach ($item->variants as $variant)
                  <li class="d-flex align-items-center">
                    <span class="fs-xs">Color:</span>
                    <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                    <span class="text-dark-emphasis fs-xs fw-medium text-end">{{ $variant->color->name}}</span>
                  </li>

                  <li class="d-flex align-items-center">
                    <span class="fs-xs">Capacity:</span>
                    <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                    <span class="text-dark-emphasis fs-xs fw-medium text-end">{{ $variant->capacity->name }}</span>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          @endforeach
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
              <img src="assets/img/home/electronics/vlog/01.jpg" class="rounded" width="140" alt="Video cover">
              <div class="ps-3">
                <div class="fs-xs text-body-secondary lh-sm mb-2">6:16</div>
                <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 New Cool Gadgets You Must See on Cartzilla - Cheap Budget</a>
              </div>
            </li>
            <li class="nav flex-nowrap align-items-center position-relative">
              <img src="assets/img/home/electronics/vlog/02.jpg" class="rounded" width="140" alt="Video cover">
              <div class="ps-3">
                <div class="fs-xs text-body-secondary lh-sm mb-2">10:20</div>
                <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 Super Useful Gadgets on Cartzilla You Must Have in 2023</a>
              </div>
            </li>
            <li class="nav flex-nowrap align-items-center position-relative">
              <img src="assets/img/home/electronics/vlog/03.jpg" class="rounded" width="140" alt="Video cover">
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
</div>

<!-- Thêm jQuery -->
@endsection