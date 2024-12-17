<!-- Product details and Reviews shared container -->
<section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">
      <div class="col-md-7">

        <!-- Product details -->
        <h2 class="h3 pb-2 pb-md-3">Chi tiết sản phẩm</h2>
        <h3 class="h6">Thông số kỹ thuật chung</h3>
        <div class="product-description">
          {!! $product->description !!}
      </div>



        
        <div class="nav">
          <a class="nav-link text-primary animate-underline px-0" href="shop-product-details-electronics.html">
            <span class="animate-target">See all product details</span>
            <i class="ci-chevron-right fs-base ms-1"></i>
          </a>
        </div>

    @include('client.page.detail-product.reviews')

      <!-- Sticky product preview visible on screens > 991px wide (lg breakpoint) -->
      {{-- <aside class="col-md-5 col-xl-4 offset-xl-1 d-none d-md-block" style="margin-top: -100px">
        <div class="position-sticky top-0 ps-3 ps-lg-4 ps-xl-0" style="padding-top: 100px">
          <div class="border rounded p-3 p-lg-4">
            <div class="d-flex align-items-center mb-3">
              <div class="ratio ratio-1x1 flex-shrink-0" style="width: 110px">
                <img src="{{ asset('storage/' . $product->image_url) }}" width="110" alt="iPhone 14">
              </div>
              <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <h4 class="fs-sm fw-medium mb-2">{{$product->name}}</h4>
                <div class="h5 mb-0 text-danger">{{ number_format($minPrice, 0, ',', '.') }} đ</div>
              </div>
            </div>
          </div>
        </div>
      </aside> --}}
    </div>
  </section>
