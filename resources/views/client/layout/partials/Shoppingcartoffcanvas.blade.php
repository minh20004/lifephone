<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" aria-labelledby="shoppingCartLabel" style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
      <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-lg-4">
        <h4 class="offcanvas-title" id="shoppingCartLabel">Giỏ hàng</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>

    <!-- Items -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">

      <!-- Item -->
      <div class="d-flex align-items-center">
        <a class="flex-shrink-0" href="shop-product-general-electronics.html">
          <img src="client/img/shop/electronics/thumbs/08.png" width="110" alt="iPhone 14">
        </a>
        <div class="w-100 min-w-0 ps-2 ps-sm-3">
          <h5 class="d-flex animate-underline mb-2">
            <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">Apple iPhone 14 128GB White</a>
          </h5>
          <div class="h6 pb-1 mb-2">$899.00</div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="count-input rounded-2">
              <button type="button" class="btn btn-icon btn-sm" data-decrement="" aria-label="Decrement quantity">
                <i class="ci-minus"></i>
              </button>
              <input type="number" class="form-control form-control-sm" value="1" readonly="">
              <button type="button" class="btn btn-icon btn-sm" data-increment="" aria-label="Increment quantity">
                <i class="ci-plus"></i>
              </button>
            </div>
            <button type="button" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"></button>
          </div>
        </div>
      </div>

    </div>

    <!-- Footer -->
    <div class="offcanvas-header flex-column align-items-start">
      <div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
        <span class="text-light-emphasis">Tổng cộng:</span>
        <span class="h6 mb-0">$2,317.00</span>
      </div>
      <div class="d-flex w-100 gap-3">
        <a class="btn btn-lg btn-secondary w-100" href="{{route('cart.index')}}">Xem giỏ hàng</a>
        <a class="btn btn-lg btn-primary w-100" href="checkout-v1-delivery-1.html">Thanh Toán</a>
      </div>
    </div>
  </div>
