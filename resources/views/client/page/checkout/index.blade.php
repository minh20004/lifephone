@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">
    <div class="container py-5">
      <form action="{{ route('order.store') }}" method="POST" class="needs-validation" novalidate>
      @csrf
      <div class="row pt-1 pt-sm-3 pt-lg-4 pb-2 pb-md-3 pb-lg-4 pb-xl-5">
        
          <!-- Delivery info (Step 1) -->
          <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">
          
            <div class="d-flex flex-column gap-5 pe-lg-4 pe-xl-0">
              
                {{-- <div class="d-flex align-items-start">
                  <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">1</div>
                  <div class="flex-grow-0 flex-shrink-0 ps-3 ps-md-4" style="width: calc(100% - 2rem)">
                    <h1 class="h5 mb-md-4">Thông tin giao hàng</h1>
                    <div class="ms-n5 ms-sm-0">
                      <h3 class="h6 border-bottom pb-4 mb-0">Chọn phương thức vận chuyển</h3>
                      <div class="mb-lg-4" id="shippingMethod" role="list">

                        <!-- Giao hàng chuyển phát nhanh -->
                        <div class="border-bottom">
                          <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#courier" aria-expanded="true" aria-controls="courier">
                            <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold py-4">
                              <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method" checked="">
                              Giao hàng chuyển phát nhanh
                              <span class="fw-normal ms-auto">35.000 đ</span>
                            </label>
                          </div>
                          
                        </div>

                        <!-- nhận từ store -->
                        <div class="border-bottom">
                          <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#pickup" aria-expanded="false" aria-controls="pickup">
                            <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold py-4">
                              <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment-method">
                              Nhận hàng từ cửa hàng
                              <span class="fw-normal ms-auto">Miễn phí</span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> --}}

                <!-- Shipping address -->
                <div class="d-flex align-items-start">
                  <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">2</div>
                  <div class="w-100 ps-3 ps-md-4">
                    <h1 class="h5 mb-md-4">Địa chỉ giao hàng</h1>
                    {{-- <form class="needs-validation" novalidate=""> --}}
                      <div class="row row-cols-1 row-cols-sm-2 g-3 g-sm-4 mb-4">
                        <div class="col">
                          <label for="shipping-name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-lg" id="shipping-name" name="name" required>
                        </div>
                        <div class="col">
                            <label for="shipping-phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="shipping-phone" name="phone" required>
                          </div>
                        
                      </div>
                      <div class="mb-3">
                        <label for="shipping-email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg" id="shipping-email" name="email" required>
                      </div>
                      <div class="mb-3">
                        <label for="shipping-address" class="form-label">Địa chỉ chi tiết (nhà/ngõ/ngách/đường/quận)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg"  id="shipping-address" name="address" required>
                      </div>
                    {{-- </form> --}}
                  </div>
                </div>

                <!-- Payment -->
                <div class="d-flex align-items-start">
                  <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">3</div>
                  <div class="w-100 ps-3 ps-md-4">
                    <h2 class="h5 mb-0">Phương thức thanh toán</h2>
                    <div class="mb-4" id="paymentMethod" role="list">

                      <!-- Cash on delivery -->
                      <div class="mt-4">
                        <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#cash" aria-expanded="false" aria-controls="cash">
                          <label class="form-check-label w-100 text-dark-emphasis fw-semibold">
                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="COD">
                            Thanh toán khi nhận hàng (COD)
                          </label>
                        </div>
                        
                      </div>


                      <!-- Thanh toán online -->
                      <div class="mt-4">
                        <div class="form-check mb-0" role="listitem" data-bs-toggle="collapse" data-bs-target="#paypal" aria-expanded="false" aria-controls="paypal">
                          <label class="form-check-label d-flex align-items-center text-dark-emphasis fw-semibold">
                            <input type="radio" class="form-check-input fs-base me-2 me-sm-3" name="payment_method" value="Online">
                            Thanh Toán Online
                          </label>
                        </div>
                        <div class="collapse" id="paypal" data-bs-parent="#paymentMethod"></div>
                      </div>

                    </div>

                    <!-- Add promo code button -->
                    <div class="nav pb-3 mb-2 mb-sm-3">
                      <a class="nav-link animate-underline p-0" href="#!">
                        <i class="ci-plus-circle fs-xl ms-a me-2"></i>
                        <span class="animate-target">Thêm mã khuyến mại hoặc thẻ quà tặng</span>
                      </a>
                    </div>

                    <!-- Nội dung -->
                    <textarea class="form-control form-control-lg mb-4" rows="3" name="description" placeholder="Nội dung"></textarea>

                    <button type="submit" class="btn btn-lg btn-primary w-100 d-none d-lg-flex" >Đặt Hàng</button>
                  </div>
                </div>
            </div>
          </div>


            <!-- Order summary (sticky sidebar) -->
            <aside class="col-lg-4 offset-xl-1" style="margin-top: -100px">
              <div class="position-sticky top-0" style="padding-top: 100px">
                <div class="bg-body-tertiary rounded-5 p-4 mb-3">
                  <div class="p-sm-2 p-lg-0 p-xl-2">
                    <div class="border-bottom pb-4 mb-4">
                      <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                        <div class="nav">
                          <a class="nav-link text-decoration-underline p-0" href="{{route('cart.index')}}">Sửa</a>
                        </div>
                      </div>
                      @foreach ($cart as $product)
                        @foreach ($product as $model)
                            @foreach ($model as $item)
                            <a class="d-flex align-items-center gap-2 text-decoration-none" href="#orderPreview" data-bs-toggle="offcanvas">
                              <div class="ratio ratio-1x1" style="max-width: 64px">
                                <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="iPhone">
                              </div>
                              <i class="ci-chevron-right text-body fs-xl p-0 ms-auto"></i>
                            </a>
                          </div>
                          <ul class="list-unstyled fs-sm gap-3 mb-0">
                            <li class="d-flex justify-content-between">
                              Tổng cộng ({{ $totalQuantity }} sản phẩm):
                              <span class="text-dark-emphasis fw-medium">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                            </li>
                            <li class="d-flex justify-content-between">
                              Giảm giá:
                              <span class="text-danger fw-medium">{{ number_format($discount, 0, ',', '.') }} đ</span>
                            </li>
                            {{-- <li class="d-flex justify-content-between">
                              Vận chuyển:
                              <span class="text-dark-emphasis fw-medium">35.000 đ</span>
                            </li> --}}
                          </ul>
                          <div class="border-top pt-4 mt-4">
                            <div class="d-flex justify-content-between mb-3">
                              <span class="fs-sm">Tổng ước tính:</span>
                              <span class="h5 mb-0">{{ number_format($estimatedTotal, 0, ',', '.') }} đ</span>
                            </div>
                          </div>

                          @endforeach
                        @endforeach
                      @endforeach
                
                          
                  </div>
                </div>
                <div class="bg-body-tertiary rounded-5 p-4">
                  <div class="d-flex align-items-center px-sm-2 px-lg-0 px-xl-2">
                    <svg class="text-warning flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"><path d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z"></path><path d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z"></path><path d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z"></path></svg>
                    <div class="text-dark-emphasis fs-sm ps-2 ms-1">Xin chúc mừng! Bạn đã kiếm được <span class="fw-semibold">240 tiền thưởng</span></div>
                  </div>
                </div>
              </div>
            </aside>
        
      
      </div>
    </form>
    </div>
</main>

@endsection