 
 @extends('client.layout.master')
 @section('title')
     Lifephone
 @endsection
 @section('content')
 <!-- Breadcrumb -->
 <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
      <li class="breadcrumb-item"><a href="shop-catalog-electronics.html">Shop</a></li>
      <li class="breadcrumb-item active" aria-current="page">Product page</li>
    </ol>
  </nav>


  <!-- Page title -->
  <h1 class="h3 container mb-4">{{$product->name}}</h1>


  <!-- Nav links + Reviews -->
  <section class="container pb-2 pb-lg-4">
    <div class="d-flex align-items-center border-bottom">
      <ul class="nav nav-underline flex-nowrap gap-4">
        <li class="nav-item me-sm-2">
          <a class="nav-link pe-none active" href="#!">Thông tin chung</a>
        </li>
        <li class="nav-item me-sm-2">
          <a class="nav-link" href="#detail">Chi tiết sản phẩm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="shop-product-reviews-electronics.html">Đánh giá (68)</a>
        </li>
      </ul>
      <a class="d-none d-md-flex align-items-center gap-2 text-decoration-none ms-auto mb-1" href="#reviews">
        <div class="d-flex gap-1 fs-sm">
          <i class="ci-star-filled text-warning"></i>
          <i class="ci-star-filled text-warning"></i>
          <i class="ci-star-filled text-warning"></i>
          <i class="ci-star-filled text-warning"></i>
          <i class="ci-star-half text-warning"></i>
        </div>
        <span class="text-body-tertiary fs-xs">68 reviews</span>
      </a>
    </div>
  </section>


  <!-- Gallery + Product options -->
  <section class="container pb-5 mb-1 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">
      <!-- Product gallery -->
      <div class="col-md-6">

        <!-- Preview (Large image) -->
        <div class="swiper" data-swiper="{
          &quot;loop&quot;: true,
          &quot;navigation&quot;: {
            &quot;prevEl&quot;: &quot;.btn-prev&quot;,
            &quot;nextEl&quot;: &quot;.btn-next&quot;
          },
          &quot;thumbs&quot;: {
            &quot;swiper&quot;: &quot;#thumbs&quot;
          }
        }">
        <div class="swiper-wrapper">
          <!-- Ảnh chính (hiển thị trước) -->
          <div class="swiper-slide">
            <div class="ratio ratio-1x1">
              <img src="{{ asset('storage/' . $product->image_url) }}" data-zoom="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" data-zoom-options="{
                &quot;paneSelector&quot;: &quot;#zoomPane&quot;,
                &quot;inlinePane&quot;: 768,
                &quot;hoverDelay&quot;: 500,
                &quot;touchDisable&quot;: true
              }">
            </div>
          </div>

          <!-- Ảnh gallery -->
          @foreach (json_decode($product->gallery_image, false) as $galleryImage)
            <div class="swiper-slide">
              <div class="ratio ratio-1x1">
                <img src="{{ asset('storage/' . $galleryImage) }}" data-zoom="{{ asset('storage/' . $galleryImage) }}" alt="{{ $product->name }}">
              </div>
            </div>
          @endforeach
        </div>

        <!-- Prev button -->
        <div class="position-absolute top-50 start-0 z-2 translate-middle-y ms-sm-2 ms-lg-3">
          <button type="button" class="btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start" aria-label="Prev">
            <i class="ci-chevron-left fs-lg animate-target"></i>
          </button>
        </div>

        <!-- Next button -->
        <div class="position-absolute top-50 end-0 z-2 translate-middle-y me-sm-2 ms-lg-3">
          <button type="button" class="btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end" aria-label="Next">
            <i class="ci-chevron-right fs-lg animate-target"></i>
          </button>
        </div>
      </div>

      <!-- Thumbnails -->
      <div class="swiper swiper-load swiper-thumbs pt-2 mt-1" id="thumbs" data-swiper="{
        &quot;loop&quot;: false,
        &quot;spaceBetween&quot;: 12,
        &quot;slidesPerView&quot;: 3,
        &quot;watchSlidesProgress&quot;: false,
        &quot;breakpoints&quot;: {
          &quot;340&quot;: {
            &quot;slidesPerView&quot;: 4
          },
          &quot;500&quot;: {
            &quot;slidesPerView&quot;: 5
          },
          &quot;600&quot;: {
            &quot;slidesPerView&quot;: 6
          },
          &quot;768&quot;: {
            &quot;slidesPerView&quot;: 4
          },
          &quot;992&quot;: {
            &quot;slidesPerView&quot;: 5
          },
          &quot;1200&quot;: {
            &quot;slidesPerView&quot;: 6
          }
        }
      }">
      <div class="swiper-wrapper">
        <!-- ảnh chính -->
        <div class="swiper-slide swiper-thumb">
          <div class="ratio ratio-1x1" style="max-width: 94px">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="swiper-thumb-img" alt="Thumbnail">
          </div>
        </div>
      
        <!-- ảnh gallery -->
        @foreach (json_decode($product->gallery_image, true) as $galleryImage)
          <div class="swiper-slide swiper-thumb">
            <div class="ratio ratio-1x1" style="max-width: 94px">
              <img src="{{ asset('storage/' . $galleryImage) }}" class="swiper-thumb-img" alt="Thumbnail">
            </div>
          </div>
        @endforeach
      </div>
            
        </div>
      </div>


      <!-- Product options -->
      <div class="col-md-6 col-xl-5 offset-xl-1 pt-4">
        <div class="ps-md-4 ps-xl-0">
          <div class="position-relative" id="zoomPane">
            <form action="{{ route('cart.add') }}" method="POST">
              @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <!-- Model dung lượng -->
                <div class="pb-3 mb-2 mb-lg-3">
                  <label class="form-label fw-semibold pb-1 mb-2">Model</label>
                  <div class="d-flex flex-wrap gap-2">
                    @php
                        $capacities = $product->variants->unique('capacity_id');
                    @endphp
                    @foreach ($capacities as $variant)
                        <input type="radio" class="btn-check model-option" name="model-options" id="model-{{ $variant->capacity->id }}" 
                              value="{{ $variant->capacity->id }}" {{ $loop->first ? 'checked' : '' }}>
                        <label for="model-{{ $variant->capacity->id }}" class="btn btn-sm btn-outline-secondary">{{ $variant->capacity->name }} GB</label>
                    @endforeach
                  </div>
                </div>

                <!-- Color màu sắc -->
                <div class="pb-3 mb-3 mb-lg-3">
                  <label class="form-label fw-semibold pb-1 mb-2">Color: <span class="text-body fw-normal fs-6" id="colorOption">{{ $product->variants->first()->color->name }}</span></label>
                  <div class="d-flex flex-wrap gap-2 mb-2" >
                    @php
                        $colors = $product->variants->unique('color_id');
                    @endphp
                    @foreach ($colors as $variant)
                        <input type="radio" class="btn-check color-option" name="color-options" id="color-{{ $variant->color->id }}" 
                              value="{{ $variant->color->id }}" data-color-name="{{ $variant->color->name }}">
                        <label for="color-{{ $variant->color->id }}" class="btn btn-color fs-xl" style="color: {{ $variant->color->code }};">
                            <span class="visually-hidden">{{ $variant->color->name }}</span>
                        </label>
                    @endforeach
                </div>
                
                <!-- Hiển thị giá -->
                <div class="d-flex flex-wrap align-items-center mb-2">
                    <div class="fs-3 mb-0 text-danger fw-bold" id="productPrice" data-base-price="{{ $minPrice }}">{{ number_format($minPrice, 0, ',', '.') }} đ</div>
                    <div class="d-flex align-items-center text-success fs-sm ms-auto">
                        <i class="ci-check-circle fs-base me-2"></i>
                        Có thể đặt hàng
                    </div>
                </div>
                {{-- số lượng --}}
                <div class="d-flex flex-wrap align-items-center mb-3"  >
                  <p style="font-size: 13px; display:none;" id="quantityContainer" class="text-success mb-0">Còn <span id="quantityValue">0</span> sản phẩm</p>
                </div>

                <!-- Lưu trữ toàn bộ biến thể sản phẩm -->
                  @php
                  $variants = $product->variants;
                  @endphp
                  <script>
                    const variants = @json($variants);
                  </script>
              
            
                <!-- Count + Buttons -->
                <div class="d-flex flex-wrap flex-sm-nowrap flex-md-wrap flex-lg-nowrap gap-3 gap-lg-2 gap-xl-3 mb-4">
                  <div class="count-input flex-shrink-0 order-sm-1">
                    <button type="button" class="btn btn-icon btn-lg" data-decrement="" aria-label="Decrement quantity">
                      <i class="ci-minus"></i>
                    </button>
                    <input type="number" class="form-control form-control-lg" value="1" min="1" max="5" readonly=""  name="quantity">
                    <button type="button" class="btn btn-icon btn-lg" data-increment="" aria-label="Increment quantity">
                      <i class="ci-plus"></i>
                    </button>
                  </div>
                  <button type="button" class="btn btn-icon btn-lg btn-secondary animate-pulse order-sm-3 order-md-2 order-lg-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Add to Wishlist" aria-label="Add to Wishlist">
                    <i class="ci-heart fs-lg animate-target"></i>
                  </button>
                  <button type="button" class="btn btn-icon btn-lg btn-secondary animate-rotate order-sm-4 order-md-3 order-lg-4" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Compare" aria-label="Compare">
                    <i class="ci-refresh-cw fs-lg animate-target"></i>
                  </button>
                  <button type="submit" class="btn btn-lg btn-primary w-100 animate-slide-end order-sm-2 order-md-4 order-lg-2">
                    <i class="ci-shopping-cart fs-lg animate-target ms-n1 me-2"></i>
                    Thêm vào giỏ hàng
                  </button>
                </div>
            </form>

            <!-- Features -->
            <div class="d-flex flex-wrap gap-3 gap-xl-4 pb-4 pb-lg-5 mb-2 mb-lg-0 mb-xl-2">
              <div class="d-flex align-items-center fs-sm">
                <svg class="text-warning me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"><path d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z"></path><path d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z"></path><path d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z"></path></svg>
                <div class="text-body-emphasis text-nowrap"><span class="fw-semibold">+32</span> Phần thưởng</div>
              </div>
              <div class="d-flex align-items-center fs-sm">
                <svg class="text-primary me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path d="M15.264 8.001l.702-1.831a.5.5 0 0 0-.152-.568l-1.522-1.234-.308-1.937a.5.5 0 0 0-.416-.415l-1.937-.308L10.399.185a.5.5 0 0 0-.567-.152L8 .736 6.169.034a.5.5 0 0 0-.567.152L4.368 1.709l-1.937.308a.5.5 0 0 0-.415.415l-.308 1.937L.185 5.603a.5.5 0 0 0-.152.567l.702 1.831-.702 1.831a.5.5 0 0 0 .152.567l1.523 1.233.308 1.937a.5.5 0 0 0 .415.416l1.937.308 1.234 1.522c.137.17.366.23.568.152L8 15.265l1.831.702a.5.5 0 0 0 .568-.153l1.233-1.522 1.937-.308a.5.5 0 0 0 .416-.416l.308-1.937 1.522-1.233a.5.5 0 0 0 .152-.567l-.702-1.831z" fill="currentColor"></path><path d="M6.5 7.001a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3zm0-2a.5.5 0 1 0 0 1 .5.5 0 1 0 0-1zM9.5 12a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3zm0-2a.5.5 0 1 0 0 1 .5.5 0 1 0 0-1zm-4 2c-.101 0-.202-.03-.29-.093a.5.5 0 0 1-.116-.698l5-7a.5.5 0 1 1 .814.581l-5 7A.5.5 0 0 1 5.5 12z" fill="white"></path></svg>
                <div class="text-body-emphasis text-nowrap">Vay không lãi suất</div>
              </div>
              <div class="d-flex align-items-center fs-sm">
                <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path class="text-success" d="M7.42169 1.15662C3.3228 1.15662 0 4.47941 0 8.5783C0 12.6772 3.3228 16 7.42169 16C11.5206 16 14.8434 12.6772 14.8434 8.5783H7.42169V1.15662Z" fill="currentColor"></path><path class="text-info" d="M8.57812 0V7.42169H15.9998C15.9998 3.3228 12.677 0 8.57812 0Z" fill="currentColor"></path><defs><rect width="16" height="16" fill="white"></rect></defs></svg>
                <div class="text-body-emphasis text-nowrap">Thanh toán theo từng đợt</div>
              </div>
            </div>
          </div>

          <!-- Shipping options -->
          <div class="d-flex align-items-center pb-2">
            <h3 class="h6 mb-0">Tùy chọn vận chuyển</h3>
            <a class="btn btn-sm btn-secondary ms-auto" href="#!">
              <i class="ci-map-pin fs-sm ms-n1 me-1"></i>
              Tìm của hàng địa phương
            </a>
          </div>
          <table class="table table-borderless fs-sm mb-2">
            <tbody>
              <tr>
                <td class="py-2 ps-0">Nhận hàng từ của hàng</td>
                <td class="py-2">Hôm nay</td>
                <td class="text-body-emphasis fw-semibold text-end py-2 pe-0">Miễn phí</td>
              </tr>
              <tr>
                <td class="py-2 ps-0">Nhận hàng từ bưu điện</td>
                <td class="py-2">Ngày mai</td>
                <td class="text-body-emphasis fw-semibold text-end py-2 pe-0">50.0000 đ</td>
              </tr>
              <tr>
                <td class="py-2 ps-0">Giang hàng bằng chuyển phát nhanh</td>
                <td class="py-2">2-3 ngày </td>
                <td class="text-body-emphasis fw-semibold text-end py-2 pe-0">35.000 đ</td>
              </tr>
            </tbody>
          </table>

          <!-- Warranty + Payment info accordion -->
          <div class="accordion" id="infoAccordion">
            <div class="accordion-item border-top">
              <h3 class="accordion-header" id="headingWarranty">
                <button type="button" class="accordion-button animate-underline collapsed" data-bs-toggle="collapse" data-bs-target="#warranty" aria-expanded="false" aria-controls="warranty">
                  <span class="animate-target me-2">Thông tin bảo hành</span>
                </button>
              </h3>
              <div class="accordion-collapse collapse" id="warranty" aria-labelledby="headingWarranty" data-bs-parent="#infoAccordion">
                <div class="accordion-body">
                  <div class="alert d-flex alert-info mb-3" role="alert">
                    <i class="ci-check-shield fs-xl mt-1 me-2"></i>
                    <div class="fs-sm"><span class="fw-semibold">Bảo hành:</span> Bảo hành chính hãng 12 tháng. Đổi/trả sản phẩm trong vòng 14 ngày.</div>
                  </div>
                  <p class="mb-0">Khám phá thông tin chi tiết về <a class="fw-medium" href="#!">bảo hành sản phẩm của chúng tôi tại đây</a>, bao gồm thời hạn, phạm vi bảo hành và bất kỳ kế hoạch bảo vệ bổ sung nào có sẵn.
                     Chúng tôi ưu tiên sự hài lòng của bạn và thông tin bảo hành của chúng tôi được thiết kế để giúp bạn được thông báo và tự tin vào việc mua hàng của mình.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h3 class="accordion-header" id="headingPayment">
                <button type="button" class="accordion-button animate-underline collapsed" data-bs-toggle="collapse" data-bs-target="#payment" aria-expanded="false" aria-controls="payment">
                  <span class="animate-target me-2">Thanh toán bằng tín dụng</span>
                </button>
              </h3>
              <div class="accordion-collapse collapse" id="payment" aria-labelledby="headingPayment" data-bs-parent="#infoAccordion">
                <div class="accordion-body">Trải nghiệm giao dịch không rắc rối với <a class="fw-medium" href="#!"> các tùy chọn thanh toán linh hoạt</a> và các tiện ích tín dụng của chúng tôi. Tìm hiểu thêm về 
                  các phương thức thanh toán khác nhau được chấp nhận, các gói trả góp và bất kỳ ưu đãi tín dụng độc quyền nào có sẵn để giúp trải nghiệm mua sắm của bạn trở nên liền mạch.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Sticky product preview + Add to cart CTA -->
  <section class="sticky-product-banner sticky-top d-md-none" data-sticky-element="">
    <div class="sticky-product-banner-inner pt-5">
      <div class="bg-body border-bottom border-light border-opacity-10 shadow pt-4 pb-2">
        <div class="container d-flex align-items-center">
          <div class="d-flex align-items-center min-w-0 ms-n2 me-3">
            <div class="ratio ratio-1x1 flex-shrink-0" style="width: 50px">
              <img src="{{asset('client/img/shop/electronics/thumbs/10.png')}}" alt="iPhone 14">
            </div>
            <div class="w-100 min-w-0 ps-2">
              <h4 class="fs-sm fw-medium text-truncate mb-1"></h4>
              <div class="h6 mb-0">$940.00</div>
            </div>
          </div>
          <div class="d-flex gap-2 ms-auto">
            <button type="button" class="btn btn-icon btn-secondary animate-pulse" aria-label="Add to Wishlist">
              <i class="ci-heart fs-base animate-target"></i>
            </button>
            <button type="button" class="btn btn-primary animate-slide-end d-none d-sm-inline-flex">
              <i class="ci-shopping-cart fs-base animate-target ms-n1 me-2"></i>
              Add to cart
            </button>
            <button type="button" class="btn btn-icon btn-primary animate-slide-end d-sm-none" aria-label="Add to Cart">
              <i class="ci-shopping-cart fs-lg animate-target"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>


  @include('client.page.detail-product.detail')


  <!-- Viewed products (Carousel) -->
  <section class="container pb-4 pb-md-5 mb-2 mb-sm-0 mb-lg-2 mb-xl-4">
    <h2 class="h3 border-bottom pb-4 mb-0">Sản phẩm đã xem</h2>

    <!-- Product carousel -->
    <div class="position-relative mx-md-1">

      <!-- External slider prev/next buttons visible on screens > 500px wide (sm breakpoint) -->
      <button type="button" class="viewed-prev btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start position-absolute top-50 start-0 z-2 translate-middle-y ms-n1 d-none d-sm-inline-flex" aria-label="Prev">
        <i class="ci-chevron-left fs-lg animate-target"></i>
      </button>
      <button type="button" class="viewed-next btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end position-absolute top-50 end-0 z-2 translate-middle-y me-n1 d-none d-sm-inline-flex" aria-label="Next">
        <i class="ci-chevron-right fs-lg animate-target"></i>
      </button>

      <!-- Slider -->
      <div class="swiper py-4 px-sm-3" data-swiper="{
        &quot;slidesPerView&quot;: 2,
        &quot;spaceBetween&quot;: 24,
        &quot;loop&quot;: true,
        &quot;navigation&quot;: {
          &quot;prevEl&quot;: &quot;.viewed-prev&quot;,
          &quot;nextEl&quot;: &quot;.viewed-next&quot;
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
                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#!">
                  <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{asset('client/img/shop/electronics/13.png')}}" alt="Dualsense Edge">
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
                  <span class="text-body-tertiary fs-xs">(187)</span>
                </div>
                <h3 class="pb-1 mb-2">
                  <a class="d-block fs-sm fw-medium text-truncate" href="#!">
                    <span class="animate-target">Sony Dualsense Edge Controller</span>
                  </a>
                </h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="h5 lh-1 mb-0">$200.00</div>
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
        <button type="button" class="viewed-prev btn btn-prev btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start me-1" aria-label="Prev">
          <i class="ci-chevron-left fs-lg animate-target"></i>
        </button>
        <button type="button" class="viewed-next btn btn-next btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end" aria-label="Next">
          <i class="ci-chevron-right fs-lg animate-target"></i>
        </button>
      </div>
    </div>
  </section>
@endsection