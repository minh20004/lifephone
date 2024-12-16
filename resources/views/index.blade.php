
@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
    <!-- Hero slider -->
    <section class="container pt-4">
        <div class="row">
            {{-- col-lg-9 offset-lg-3 --}}
            <div class="col-lg-9 offset-lg-3">
                <div class="position-relative">
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip"
                        style="background: linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip"
                        style="background: linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>
                    <div class="row justify-content-center position-relative z-2">
                        <div class="col-xl-5 col-xxl-4 offset-xxl-1 d-flex align-items-center mt-xl-n3">

                            <!-- Text content master slider -->
                            <div class="swiper px-5 pe-xl-0 ps-xxl-0 me-xl-n5"
                                data-swiper="{
                &quot;spaceBetween&quot;: 64,
                &quot;loop&quot;: true,
                &quot;speed&quot;: 400,
                &quot;controlSlider&quot;: &quot;#sliderImages&quot;,
                &quot;autoplay&quot;: {
                  &quot;delay&quot;: 5500,
                  &quot;disableOnInteraction&quot;: false
                },
                &quot;scrollbar&quot;: {
                  &quot;el&quot;: &quot;.swiper-scrollbar&quot;
                }
              }">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <h2 class="display-4 pb-2 pb-xl-4">iPhone 16 Pro</h2>
                                            <h4 class="text-body">Đỉnh cao công nghệ, hiệu năng vượt trội,
                                                chinh phục mọi trải nghiệm!</h4>
                                        <a class="btn btn-lg btn-primary" href="http://lifephone.test/product/5">
                                            Xem ngay
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <h2 class="display-4 pb-2 pb-xl-4">oppo a 16</h2>
                                            <h4 class="text-body">Đỉnh cao công nghệ, hiệu năng vượt trội,
                                                chinh phục mọi trải nghiệm!</h4>
                                        <a class="btn btn-lg btn-primary" href="http://lifephone.test/product/5">
                                            Xem ngay
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                    <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                        <h3 class="display-4 pb-2 pb-xl-4">Galaxy S24 Ultra</h3>
                                            <h4 class="text-body">Đỉnh cao công nghệ, hiệu năng vượt trội,
                                                chinh phục mọi trải nghiệm!</h4>
                                        <a class="btn btn-lg btn-primary" href="http://lifephone.test/product/5">
                                            Xem ngay
                                            <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-sm-7 col-md-6 col-lg-5 col-xl-7">

                            <!-- Binded images (controlled slider) -->
                            <div class="swiper user-select-none" id="sliderImages"
                                data-swiper="{
                &quot;allowTouchMove&quot;: false,
                &quot;loop&quot;: true,
                &quot;effect&quot;: &quot;fade&quot;,
                &quot;fadeEffect&quot;: {
                  &quot;crossFade&quot;: true
                }
              }">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip"
                                            style="max-width: 495px; --cz-aspect-ratio: calc(537 / 495 * 100%)">
                                            <img src="client/img/home/electronics/hero-slider/16proo.png" alt="Image">
                                        </div>
                                    </div>
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip"
                                            style="max-width: 495px; --cz-aspect-ratio: calc(537 / 495 * 100%)">
                                            <img src="client/img/home/electronics/hero-slider/oppo.png" alt="Image">
                                        </div>
                                    </div>
                                    <div class="swiper-slide d-flex justify-content-end">
                                        <div class="ratio rtl-flip"
                                            style="max-width: 495px; --cz-aspect-ratio: calc(537 / 495 * 100%)">
                                            <img src="client/img/home/electronics/hero-slider/samsung.png" alt="Image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scrollbar -->
                    <div class="row justify-content-center" data-bs-theme="dark">
                        <div class="col-xxl-10">
                            <div class="position-relative mx-5 mx-xxl-0">
                                <div class="swiper-scrollbar mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features miễn phí vận chuyển -->
    <section class="container pt-5 mt-1 mt-sm-3 mt-lg-4 mb-sm-3 mb-md-4 mb-lg-5">
        <div class="row row-cols-2 row-cols-md-4 g-4">

            <!-- Item -->
            <div class="col">
                <div class="d-flex flex-column flex-xxl-row align-items-center">
                    <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                        <i class="ci-delivery fs-2 m-xxl-1"></i>
                    </div>
                    <div class="text-center text-xxl-start ps-xxl-3">
                        <h3 class="h6 mb-1">Miễn phí vận chuyển </h3>
                        <p class="fs-sm mb-0">Đối với tất cả các đơn hàng trên một triệu vnđ</p>
                    </div>
                </div>
            </div>

            <!-- Item -->
            <div class="col">
                <div class="d-flex flex-column flex-xxl-row align-items-center">
                    <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                        <i class="ci-credit-card fs-2 m-xxl-1"></i>
                    </div>
                    <div class="text-center text-xxl-start ps-xxl-3">
                        <h3 class="h6 mb-1">Thanh toán an toàn</h3>
                        <p class="fs-sm mb-0">Chúng tôi đảm bảo thanh toán an toàn</p>
                    </div>
                </div>
            </div>

            <!-- Item -->
            <div class="col">
                <div class="d-flex flex-column flex-xxl-row align-items-center">
                    <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                        <i class="ci-refresh-cw fs-2 m-xxl-1"></i>
                    </div>
                    <div class="text-center text-xxl-start ps-xxl-3">
                        <h3 class="h6 mb-1">Đảm bảo hoàn tiền</h3>
                        <p class="fs-sm mb-0">Hoàn tiền 30 ngày</p>
                    </div>
                </div>
            </div>

            <!-- Item -->
            <div class="col">
                <div class="d-flex flex-column flex-xxl-row align-items-center">
                    <div class="d-flex text-dark-emphasis bg-body-tertiary rounded-circle p-4 mb-3 mb-xxl-0">
                        <i class="ci-chat fs-2 m-xxl-1"></i>
                    </div>
                    <div class="text-center text-xxl-start ps-xxl-3">
                        <h3 class="h6 mb-1">Hỗ trợ khách hàng 24/7</h3>
                        <p class="fs-sm mb-0">Hỗ trợ khách hàng thân thiện</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ưu đãi đặc biệt dành cho bạn -->
    {{-- <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4">

        <!-- Heading + Countdown -->
        <div class="d-flex align-items-start align-items-md-center justify-content-between border-bottom pb-3 pb-md-4">
            <div class="d-md-flex align-items-center">
                <h2 class="h3 pe-3 me-3 mb-md-0">Ưu đãi đặc biệt dành cho bạn</h2>

                <!-- Replace "demoDate" inside data-countdown-date attribute with the real date, ex: "10/15/2025 12:00:00" -->
                <div class="d-flex align-items-center" data-countdown-date="demoDate">
                    <div class="btn btn-primary pe-none px-2">
                        <span data-days=""></span>
                        <span>d</span>
                    </div>
                    <div class="animate-blinking text-body-tertiary fs-lg fw-medium mx-2">:</div>
                    <div class="btn btn-primary pe-none px-2">
                        <span data-hours=""></span>
                        <span>h</span>
                    </div>
                    <div class="animate-blinking text-body-tertiary fs-lg fw-medium mx-2">:</div>
                    <div class="btn btn-primary pe-none px-2">
                        <span data-minutes=""></span>
                        <span>m</span>
                    </div>
                </div>
            </div>
            <div class="nav ms-3">
                <a class="nav-link animate-underline px-0 py-2" href="#">
                    <span class="animate-target text-nowrap">Xem tất cả</span>
                    <i class="ci-chevron-right fs-base ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Product carousel -->
        <div class="position-relative mx-md-1">

            <!-- External slider prev/next buttons visible on screens > 500px wide (sm breakpoint) -->
            <button type="button"
                class="offers-prev btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start position-absolute top-50 start-0 z-2 translate-middle-y ms-n1 d-none d-sm-inline-flex"
                aria-label="Prev">
                <i class="ci-chevron-left fs-lg animate-target"></i>
            </button>
            <button type="button"
                class="offers-next btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end position-absolute top-50 end-0 z-2 translate-middle-y me-n1 d-none d-sm-inline-flex"
                aria-label="Next">
                <i class="ci-chevron-right fs-lg animate-target"></i>
            </button>

            <!-- Slider -->
            <div class="swiper py-4 px-sm-3"
                data-swiper="{
        &quot;slidesPerView&quot;: 2,
        &quot;spaceBetween&quot;: 24,
        &quot;loop&quot;: true,
        &quot;navigation&quot;: {
          &quot;prevEl&quot;: &quot;.offers-prev&quot;,
          &quot;nextEl&quot;: &quot;.offers-next&quot;
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
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex"
                                            aria-label="Add to Wishlist">
                                            <i class="ci-heart fs-base animate-target"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex"
                                            aria-label="Compare">
                                            <i class="ci-refresh-cw fs-base animate-target"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
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
                                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                    href="shop-product-general-electronics.html">
                                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                        <img src="client/img/shop/electronics/09.png" alt="Wireless Buds">
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
                                    <span class="text-body-tertiary fs-xs">(14)</span>
                                </div>
                                <h3 class="pb-1 mb-2">
                                    <a class="d-block fs-sm fw-medium text-truncate"
                                        href="shop-product-general-electronics.html">
                                        <span class="animate-target">Xiaomi Wireless Buds Pro</span>
                                    </a>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between pb-2 mb-1">
                                    <div class="h5 lh-1 mb-0">$129.99 <del
                                            class="text-body-tertiary fs-sm fw-normal">$156.00</del></div>
                                    <button type="button"
                                        class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2"
                                        aria-label="Add to Cart">
                                        <i class="ci-shopping-cart fs-base animate-target"></i>
                                    </button>
                                </div>
                                <div class="progress mb-2" role="progressbar" aria-label="Available in stock"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                    <div class="progress-bar rounded-pill" style="width: 25%"></div>
                                </div>
                                <div class="text-body-secondary fs-sm">Available: <span
                                        class="text-dark-emphasis fw-medium">112</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="swiper-slide">
                        <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex"
                                            aria-label="Add to Wishlist">
                                            <i class="ci-heart fs-base animate-target"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex"
                                            aria-label="Compare">
                                            <i class="ci-refresh-cw fs-base animate-target"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
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
                                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                    href="shop-product-general-electronics.html">
                                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                        <img src="client/img/shop/electronics/03.png" alt="Smart Watch">
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
                                    <span class="text-body-tertiary fs-xs">(138)</span>
                                </div>
                                <h3 class="pb-1 mb-2">
                                    <a class="d-block fs-sm fw-medium text-truncate"
                                        href="shop-product-general-electronics.html">
                                        <span class="animate-target">Smart Watch Series 7, White</span>
                                    </a>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between pb-2 mb-1">
                                    <div class="h5 lh-1 mb-0">$429.00 <del
                                            class="text-body-tertiary fs-sm fw-normal">$486.00</del></div>
                                    <button type="button"
                                        class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2"
                                        aria-label="Add to Cart">
                                        <i class="ci-shopping-cart fs-base animate-target"></i>
                                    </button>
                                </div>
                                <div class="progress mb-2" role="progressbar" aria-label="Available in stock"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                    <div class="progress-bar rounded-pill" style="width: 50%"></div>
                                </div>
                                <div class="text-body-secondary fs-sm">Available: <span
                                        class="text-dark-emphasis fw-medium">45</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="swiper-slide">
                        <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex"
                                            aria-label="Add to Wishlist">
                                            <i class="ci-heart fs-base animate-target"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex"
                                            aria-label="Compare">
                                            <i class="ci-refresh-cw fs-base animate-target"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
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
                                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                    href="shop-product-general-electronics.html">
                                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                        <img src="client/img/shop/electronics/11.png" alt="Nikon Camera">
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
                                    <span class="text-body-tertiary fs-xs">(64)</span>
                                </div>
                                <h3 class="pb-1 mb-2">
                                    <a class="d-block fs-sm fw-medium text-truncate"
                                        href="shop-product-general-electronics.html">
                                        <span class="animate-target">VRB01 Camera Nikon Max</span>
                                    </a>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between pb-2 mb-1">
                                    <div class="h5 lh-1 mb-0">$652.00 <del
                                            class="text-body-tertiary fs-sm fw-normal">$785.00</del></div>
                                    <button type="button"
                                        class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2"
                                        aria-label="Add to Cart">
                                        <i class="ci-shopping-cart fs-base animate-target"></i>
                                    </button>
                                </div>
                                <div class="progress mb-2" role="progressbar" aria-label="Available in stock"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                    <div class="progress-bar rounded-pill" style="width: 75%"></div>
                                </div>
                                <div class="text-body-secondary fs-sm">Available: <span
                                        class="text-dark-emphasis fw-medium">13</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="swiper-slide">
                        <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex"
                                            aria-label="Add to Wishlist">
                                            <i class="ci-heart fs-base animate-target"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex"
                                            aria-label="Compare">
                                            <i class="ci-refresh-cw fs-base animate-target"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
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
                                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                    href="shop-product-general-electronics.html">
                                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                        <img src="client/img/shop/electronics/10.png" alt="iPhone 14">
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
                                    <span class="text-body-tertiary fs-xs">(51)</span>
                                </div>
                                <h3 class="pb-1 mb-2">
                                    <a class="d-block fs-sm fw-medium text-truncate"
                                        href="shop-product-general-electronics.html">
                                        <span class="animate-target">Apple iPhone 14 128GB Blue</span>
                                    </a>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between pb-2 mb-1">
                                    <div class="h5 lh-1 mb-0">$652.00 <del
                                            class="text-body-tertiary fs-sm fw-normal">$785.00</del></div>
                                    <button type="button"
                                        class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2"
                                        aria-label="Add to Cart">
                                        <i class="ci-shopping-cart fs-base animate-target"></i>
                                    </button>
                                </div>
                                <div class="progress mb-2" role="progressbar" aria-label="Available in stock"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                    <div class="progress-bar rounded-pill" style="width: 25%"></div>
                                </div>
                                <div class="text-body-secondary fs-sm">Available: <span
                                        class="text-dark-emphasis fw-medium">7</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="swiper-slide">
                        <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex"
                                            aria-label="Add to Wishlist">
                                            <i class="ci-heart fs-base animate-target"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex"
                                            aria-label="Compare">
                                            <i class="ci-refresh-cw fs-base animate-target"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
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
                                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                    href="shop-product-general-electronics.html">
                                    <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                        <img src="client/img/shop/electronics/01.png" alt="VR Glasses">
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
                                    <span class="text-body-tertiary fs-xs">(19)</span>
                                </div>
                                <h3 class="pb-1 mb-2">
                                    <a class="d-block fs-sm fw-medium text-truncate"
                                        href="shop-product-general-electronics.html">
                                        <span class="animate-target">VRB01 Virtual Reality Glasses</span>
                                    </a>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between pb-2 mb-1">
                                    <div class="h5 lh-1 mb-0">$340.99 <del
                                            class="text-body-tertiary fs-sm fw-normal">$430.00</del></div>
                                    <button type="button"
                                        class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2"
                                        aria-label="Add to Cart">
                                        <i class="ci-shopping-cart fs-base animate-target"></i>
                                    </button>
                                </div>
                                <div class="progress mb-2" role="progressbar" aria-label="Available in stock"
                                    aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                                    <div class="progress-bar rounded-pill" style="width: 33%"></div>
                                </div>
                                <div class="text-body-secondary fs-sm">Available: <span
                                        class="text-dark-emphasis fw-medium">16</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- External slider prev/next buttons visible on screens < 500px wide (sm breakpoint) -->
            <div class="d-flex justify-content-center gap-2 mt-n2 mb-3 pb-1 d-sm-none">
                <button type="button"
                    class="offers-prev btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start me-1"
                    aria-label="Prev">
                    <i class="ci-chevron-left fs-lg animate-target"></i>
                </button>
                <button type="button"
                    class="offers-next btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end"
                    aria-label="Next">
                    <i class="ci-chevron-right fs-lg animate-target"></i>
                </button>
            </div>
        </div>
    </section> --}}

    <!--sản phẩm mới-->
    <section class="container pt-5 mt-1 mt-sm-2 mt-md-3 mt-lg-4">
      <h2 class="h3 pb-2 pb-sm-3">Hàng mới về</h2>
      <div class="row">
          <div class="col-lg-4" data-bs-theme="dark">
              <div class="d-flex flex-column align-items-center justify-content-end h-100 text-center overflow-hidden rounded-5 px-4 px-lg-3 pt-4 pb-5"
                  style="background: #1d2c41 url('client/img/home/electronics/banner/background.jpg') center/cover no-repeat">
                  <div class="ratio animate-up-down position-relative z-2 me-lg-4"
                      style="max-width: 320px; margin-bottom: -19%; --cz-aspect-ratio: calc(690 / 640 * 100%)">
                      <img src="client/img/home/electronics/banner/san-pham-moi.png" alt="Laptop">
                  </div>
                  <h3 class="display-2 mb-2">Iphone 15 VNA</h3>
                  <p class="text-body fw-medium mb-4"> Trở nên chuyên nghiệp ở mọi nơi</p>
                  <a class="btn btn-sm btn-primary" href="#!">
                      Giá: 19.690.000đ
                      <i class="ci-arrow-up-right fs-base ms-1 me-n1"></i>
                  </a>
              </div>
          </div>

          <div class="col-lg-8">
              <div class="row">
                  @foreach ($latestProducts as $product)
                      <div class="col-sm-6 col-lg-6 d-flex flex-column gap-3 pt-4 py-lg-4">
                          <div class="position-relative animate-underline d-flex align-items-center ps-xl-3">
                            {{-- <a class="stretched-link d-block fs-sm fw-medium text-truncate" --}}
                                          {{-- href="{{ route('product.show', $product->id) }}"> --}}
                              <div class="ratio ratio-1x1 flex-shrink-0" style="width: 110px">
                                {{-- <img class="rounded" src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}"> --}}
                                <img class="rounded" src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                              </div>
                              <div class="w-100 min-w-0 ps-2 ps-sm-3">
                                  <div class="d-flex align-items-center gap-2 mb-2">
                                      <div class="d-flex gap-1 fs-xs">
                                          @for ($i = 0; $i < 5; $i++)
                                              @if ($i < $product->rating)
                                                  <i class="ci-star-filled text-warning"></i>
                                              @else
                                                  <i class="ci-star text-secondary"></i>
                                              @endif
                                          @endfor
                                      </div>
                                      <span class="text-body-tertiary fs-xs">{{ $product->reviews_count ?? 0 }}</span>
                                  </div>
                                  <h4 class="mb-2">
                                      <a class="stretched-link d-block fs-sm fw-medium text-truncate"
                                          href="{{ route('product.show', $product->id) }}">
                                          <span class="animate-target">{{ $product->name }}</span>
                                      </a>
                                  </h4>
                                  @php
                                      $minPrice = $product->variants->min('price_difference');
                                  @endphp
                                  <div class="h5 mb-0">
                                      {{ number_format($minPrice, 0, ',', '.') }} VNĐ
                                  </div>
                              </div>
                            {{-- </a> --}}
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </div>
    </section>
    <!-- Banners that are turned into collaspse on screens < 768px wide (sm breakpoint) -->
    {{-- <section class="accordion container pb-4 pb-md-5 mb-xl-3">
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
                    <img src="client/img/shop/electronics/banners/iphone-1.png" alt="iPhone 14">
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
                    <img src="client/img/shop/electronics/banners/ipad.png" width="525" alt="iPad">
                    </div>
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section> --}}
    <!-- Trending products (Grid) Thịnh hành-->
    <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4">

        <!-- Heading -->
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
            <h2 class="h3 mb-0"> Sản phẩm thịnh hành</h2>
            <div class="nav ms-3">
                <a class="nav-link animate-underline px-0 py-2" href="#">
                    <span class="animate-target">Xem tất cả</span>
                    <i class="ci-chevron-right fs-base ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Product grid -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 pt-4">

            @foreach ($trendingProducts as $product)
                <!-- Item -->
                <div class="col">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button"
                                        class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex"
                                        aria-label="Add to Wishlist" data-id="{{$product->id}}">
                                        <i class="ci-heart fs-base animate-target"></i>
                                    </button>
                                    <button type="button"
                                        class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex"
                                        aria-label="Compare">
                                        <i class="ci-refresh-cw fs-base animate-target"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                                <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
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
                            <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                                href="{{ route('product.show', $product->id) }}">
                                <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                                </div>
                            </a>
                        </div>
                        {{-- sanpham --}}
                        <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex gap-1 fs-xs">
                                    {{-- Hiển thị đánh giá dưới dạng sao --}}
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->rating))
                                            <i class="ci-star-filled text-warning"></i>
                                        @elseif($i == ceil($product->rating))
                                            <i class="ci-star-half text-warning"></i>
                                        @else
                                            <i class="ci-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-body-tertiary fs-xs">({{ $product->review_count }})</span>
                            </div>
                            <h3 class="pb-1 mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate"
                                    href="{{ route('product.show', $product->id) }}">
                                    <span class="animate-target">{{ $product->name }}</span>
                                </a>
                            </h3>
                            <div class="d-flex align-items-center justify-content-between">
                                @php
                                      $minPrice = $product->variants->min('price_difference');
                                  @endphp
                                <div class="h5 lh-1 mb-0">{{ number_format($minPrice, 0, ',', '.') }} VNĐ</div>
                                <button type="button"
                                    class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2"
                                    aria-label="Add to Cart">
                                    <i class="ci-shopping-cart fs-base animate-target"></i>
                                </button>
                            </div>
                        </div>
                        {{-- Biến thể thông tin chi tiết --}}
                        {{-- <div
                            class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
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
                        </div> --}}
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <!-- Sale Banner (CTA) -->
    <section class="container pt-5 mt-sm-2 mt-md-3 mt-lg-4">
        <div class="row g-0">
            <div class="col-md-3 mb-n4 mb-md-0">
                <div class="position-relative d-flex flex-column align-items-center justify-content-center h-100 py-5">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-none d-md-block">
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark"
                            style="background-color: #accbee"></span>
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark"
                            style="background-color: #1b273a"></span>
                    </div>
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-md-none">
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-top-5 d-none-dark"
                            style="background: linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-top-5 d-none d-block-dark"
                            style="background: linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>
                    </div>
                    <div class="position-relative z-1 display-1 text-dark-emphasis text-nowrap mb-0">
                        20
                        <span class="d-inline-block ms-n2">
                            <span class="d-block fs-1">%</span>
                            <span class="d-block fs-5">OFF</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-9 position-relative">
                <div class="position-absolute top-0 start-0 h-100 overflow-hidden rounded-pill z-2 d-none d-md-block"
                    style="color: var(--cz-body-bg); margin-left: -2px">
                    <svg width="4" height="436" viewBox="0 0 4 436" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 0L1.99998 436" stroke="currentColor" stroke-width="3" stroke-dasharray="8 12"
                            stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="position-relative">
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip"
                        style="background: linear-gradient(90deg, #accbee 0%, #e7f0fd 100%)"></span>
                    <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip"
                        style="background: linear-gradient(90deg, #1b273a 0%, #1f2632 100%)"></span>
                    <div class="row align-items-center position-relative z-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="text-center text-md-start py-md-5 px-4 ps-md-5 pe-md-0 me-md-n5">
                                <h3 class="text-uppercase fw-bold ps-xxl-3 pb-2 mb-1">Giảm giá hàng tuần theo mùa năm 2024</h3>
                                <p class="text-body-emphasis ps-xxl-3 mb-0"> Sử dụng mã <span
                                        class="d-inline-block fw-semibold bg-white text-dark rounded-pill py-1 px-2">sale 2024</span> để nhận được ưu đãi tốt nhất</p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center justify-content-md-end pb-5 pb-md-0">
                            <div class="me-xxl-4">
                                <img src="client/img/home/electronics/banner/ultra.png" class="d-block rtl-flip"
                                    width="420" alt="Camera">
                                <div class="d-none d-lg-block" style="margin-bottom: -9%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none d-lg-block" style="padding-bottom: 3%"></div>
    </section>

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
            <div class="col">
            <a class="btn btn-outline-secondary w-100 h-100 rounded-4 p-3" href="{{route('danh-muc-san-pham')}}">
                Xem tất cả
                <i class="ci-plus-circle fs-base ms-2"></i>
            </a>
        </div>
        </div>
    </section>
    <script>
        document.querySelectorAll('button[aria-label="Add to Wishlist"]').forEach(button => {
            button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let customerId = null;
            @if (Auth::guard('customer')->check())
                customerId = @json(Auth::guard('customer')->user()->id);
            @endif


            $.ajax({
                url: '/api/favorites',
                method: 'POST',
                data: {
                customer_id: customerId,
                product_id: productId
                },
                success: function(response) {
                console.log('Product added to wishlist:', response);
                alert('Sản phẩm đã được thêm vào danh sách yêu thích!');
                },
                error: function(xhr, status, error) {
                console.error('Error:', error);
                    if(customerId == null){
                        alert('Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích!');
                    }else if(productId == null){
                        alert('Sản phẩm không tồn tại!');
                    } else {
                        alert('Sản phẩm đã được thêm vào danh sách yêu thích!');
                    }
                }
            });
            });
        });
    </script>
@endsection