@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">
    <div class="container py-5">
        
        <form id="checkout-form" action="{{ route('order.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row pt-1 pt-sm-3 pt-lg-4 pb-2 pb-md-3 pb-lg-4 pb-xl-5">
              
                <!-- Delivery info (Step 1) -->
                <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">
                
                  <div class="d-flex flex-column gap-5 pe-lg-4 pe-xl-0">
                      <!-- Shipping address -->
                      <div class="d-flex align-items-start">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">1</div>
                        <div class="w-100 ps-3 ps-md-4">
                            <div class="d-flex justify-content-between">
                                <h1 class="h5 mb-md-4">Địa chỉ giao hàng</h1>
                                @if(auth('customer')->check() && $addresses->isNotEmpty())
                                    <a type="button" class="text-decoration-none fs-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Thay Đổi
                                    </a>
                                @endif
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 g-3 g-sm-4 mb-4">
                                <div class="col">
                                    <label for="shipping-name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="shipping-name" name="name" 
                                        value="{{ old('name', auth('customer')->check() && $defaultAddress ? $defaultAddress->name : '') }}" 
                                        {{ auth('customer')->check() ? 'readonly' : '' }} required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="shipping-phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="shipping-phone" name="phone" 
                                        value="{{ old('phone', auth('customer')->check() && $defaultAddress ? $defaultAddress->phone_number : '') }}" 
                                        {{ auth('customer')->check() ? 'readonly' : '' }} required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="shipping-email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="shipping-email" name="email" 
                                    value="{{ old('email', auth('customer')->check() ? auth('customer')->user()->email : '') }}" 
                                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="shipping-address" class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg @error('address') is-invalid @enderror" id="shipping-address" name="address" 
                                    value="{{ old('address', auth('customer')->check() && $defaultAddress ? $defaultAddress->address : '') }}" 
                                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Modal -->
                            @if(auth('customer')->check() && $addresses->isNotEmpty())
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Địa chỉ của tôi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="d-flex list-group ">
                                                @foreach ($addresses as $address)
                                                    <li class="d-flex gap-3 list-group-item border-bottom border-danger">
                                                        <input type="radio" class="btn btn-primary btn-sm mt-2 change-address-btn" 
                                                            name="selected_address"
                                                            data-name="{{ $address->name }}" 
                                                            data-phone="{{ $address->phone_number }}" 
                                                            data-address="{{ $address->address }}" 
                                                            style="width: 20px; height: 20px; accent-color: red; font-size: 26px;"> 
                                                        <div>
                                                            <strong>{{ $address->name }}</strong> | {{ $address->phone_number }}<br>
                                                            {{ $address->address }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirm-address-btn">Xác Nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                  
                      <!-- Payment -->
                      <div class="d-flex align-items-start">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-sm fw-semibold lh-1 flex-shrink-0" style="width: 2rem; height: 2rem; margin-top: -.125rem">2</div>
                        <div class="w-100 ps-3 ps-md-4">
                          <h2 class="h5 mb-0">Phương thức thanh toán</h2>
                          <div class="mb-4" id="paymentMethod" role="list">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="COD" id="payment_method_cod" checked>
                                    <label class="form-check-label" for="payment_method_cod">Thanh toán khi nhận hàng (COD)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="VNPay" id="payment_method_vnpay">
                                    <label class="form-check-label" for="payment_method_vnpay">Thanh toán trực tuyến (VNPay)</label>
                                </div>
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
      
                          <button type="button" class="btn btn-primary w-100" id="place-order-btn">Đặt hàng</button>
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
                                  <a class="d-flex align-items-center gap-2 text-decoration-none " href="#orderPreview" data-bs-toggle="offcanvas">
                                    @if (auth('customer')->check())
                                        @foreach ($cartItems as $cartItem)
                                            <div class="ratio ratio-1x1" style="max-width: 64px">
                                                <img src="{{ asset('storage/' . $cartItem->image_url) }}" class="d-block p-1" alt="{{ $cartItem->product->name }}" style="width: 70px; height:70px;">
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach ($cart as $productId => $models)
                                            @foreach ($models as $modelId => $colors)
                                                @foreach ($colors as $colorId => $item)
                                                    <div class="ratio ratio-1x1" style="max-width: 64px">
                                                        <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="Sản phẩm" style="width: 70px; height:70px;">
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endif
                                    <i class="ci-chevron-right text-body fs-xl p-0 ms-auto"></i>
                                  </a>
                                </div>
                                
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                              <li class="d-flex justify-content-between">
                                Tổng cộng ({{ $totalQuantity }} sản phẩm):
                                <span class="text-dark-emphasis fw-medium" id="totalPrice">{{ session('totalPrice', number_format($totalPrice, 0, ',', '.')) }} đ</span>
                              </li>
                              <li class="d-flex justify-content-between">
                                Giảm giá:
                                <span id="discount" class="text-danger">
                                    {{ session('discount', '0 đ') }}
                                </span>
                              </li>
                            </ul>
                            <div class="border-top pt-4 mt-4">
                              <div class="d-flex justify-content-between mb-3">
                                <span class="fs-sm">Tổng ước tính:</span>
                                <span class="h5 mb-0" id="estimatedTotal">{{ session('estimatedTotal', number_format($estimatedTotal, 0, ',', '.')) }} đ</span>
                              </div>
                            </div>
                                
                        </div>
                      </div>
                      <div class="accordion bg-body-tertiary rounded-5 p-4">
                        {{-- <div class="accordion-item border-0">
                            <h3 class="accordion-header" id="promoCodeHeading">
                                <button type="button" class="accordion-button animate-underline collapsed py-0 ps-sm-2 ps-lg-0 ps-xl-2" data-bs-toggle="collapse" data-bs-target="#promoCode" aria-expanded="false" aria-controls="promoCode">
                                    <i class="ci-percent fs-xl me-2"></i>
                                    <span class="animate-target me-2">Áp dụng mã khuyến mãi</span>
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse" id="promoCode" aria-labelledby="promoCodeHeading">
                                <div class="accordion-body pt-3 pb-2 ps-sm-2 px-lg-0 px-xl-2">
                                    <form action="{{ route('order.applyVoucher') }}" method="POST" class="needs-validation d-flex gap-2" novalidate>
                                        @csrf
                                        <div class="d-flex">
                                            <div class="position-relative w-100 mb-3">
                                                <input type="text" name="voucher_code" id="voucher_code" class="form-control" placeholder="Nhập mã khuyến mãi" required>
                                                <div class="invalid-tooltip bg-transparent py-0">Nhập mã khuyến mãi hợp lệ!</div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-danger">Áp dụng</button>
                                            </div>
                                        </div>
                                    </form>
                    
                                    <div class="mt-4">
                                        <p class="text-danger">Chọn một mã khuyến mãi:</p>
                                        <form id="voucher-selection-form" action="{{ route('order.applyVoucher') }}" method="POST" >
                                            @csrf
                                           <div>
                                            @foreach($vouchers as $voucher)
                                            <div class="voucher-option d-flex align-items-center border mb-3">
                                                
                                                <label for="voucher_{{ $voucher->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @if($voucher->image)
                                                                <img src="{{ asset('storage/' . $voucher->image) }}" alt="Voucher Image" class="voucher-image" width="100" height="100">
                                                            @endif
                                                        </div>
                                                        <div class="ms-3">
                                                            <strong>{{ $voucher->title }}</strong><br>
                                                            <p class="text-dark">Giảm {{ $voucher->discount_percentage }}% giảm tối đa {{ number_format($voucher->max_discount_amount, 0, ',', '.') }} VNĐ</p>
                                                            @if($voucher->min_order_value)
                                                                <small><strong>Đơn tối thiểu:</strong> {{ number_format($voucher->min_order_value, 0, ',', '.') }} VNĐ</small><br>
                                                            @endif
                                                            <div>
                                                                HSD: {{ $voucher->end_date }}
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </label>
                                                <input type="radio" name="selected_voucher" id="voucher_{{ $voucher->id }}" value="{{ $voucher->code }}" class="me-2 " 
                                                       {{ session('voucher.code') == $voucher->code ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                           </div>
                                            <div class="d-flex justify-content-end ">
                                                <button type="submit" class="btn btn-danger">OK</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                            <div class="accordion-item border-0">
                                <h3 class="accordion-header" id="promoCodeHeading">
                                    <button type="button" class="accordion-button animate-underline collapsed py-0 ps-sm-2 ps-lg-0 ps-xl-2" data-bs-toggle="collapse" data-bs-target="#promoCode" aria-expanded="false" aria-controls="promoCode">
                                        <i class="ci-percent fs-xl me-2"></i>
                                        <span class="animate-target me-2">Áp dụng mã khuyến mãi</span>
                                    </button>
                                </h3>
                                <div class="accordion-collapse collapse" id="promoCode" aria-labelledby="promoCodeHeading">
                                    <div class="accordion-body pt-3 pb-2 ps-sm-2 px-lg-0 px-xl-2">
                                        <form action="{{ route('order.applyVoucher') }}" method="POST" class="needs-validation d-flex gap-2" novalidate>
                                            @csrf
                                            <div class="d-flex">
                                                <div class="position-relative w-100 mb-3">
                                                    <input type="text" name="voucher_code" id="voucher_code" class="form-control" placeholder="Nhập mã khuyến mãi" required>
                                                    <div class="invalid-tooltip bg-transparent py-0">Nhập mã khuyến mãi hợp lệ!</div>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-danger">Áp dụng</button>
                                                </div>
                                            </div>
                                        </form>
                        
                                        <div class="mt-4">
                                            <p class="text-danger">Chọn một mã khuyến mãi:</p>
                                            <form id="voucher-selection-form" action="{{ route('order.applyVoucher') }}" method="POST">
                                                @csrf
                                                <div>
                                                    @foreach($vouchers as $voucher)
                                                        @php
                                                            // Kiểm tra xem voucher đã được sử dụng chưa
                                                            $isUsed = \App\Models\VoucherUsage::where('customer_id', auth('customer')->id())
                                                                ->where('voucher_id', $voucher->id)
                                                                ->exists();
                                                        @endphp
                                                        <div class="voucher-option d-flex align-items-center border mb-3 
                                                            @if($isUsed) opacity-50 pointer-events-none @endif">
                                                            <label for="voucher_{{ $voucher->id }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        @if($voucher->image)
                                                                            <img src="{{ asset('storage/' . $voucher->image) }}" alt="Voucher Image" class="voucher-image" width="100" height="100">
                                                                        @endif
                                                                    </div>
                                                                    <div class="ms-3">
                                                                        <strong>{{ $voucher->title }}</strong><br>
                                                                        <p class="text-dark">Giảm {{ $voucher->discount_percentage }}% giảm tối đa {{ number_format($voucher->max_discount_amount, 0, ',', '.') }} VNĐ</p>
                                                                        @if($voucher->min_order_value)
                                                                            <small><strong>Đơn tối thiểu:</strong> {{ number_format($voucher->min_order_value, 0, ',', '.') }} VNĐ</small><br>
                                                                        @endif
                                                                        <div>
                                                                            HSD: {{ $voucher->end_date }}
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            </label>
                                                            <input type="radio" name="selected_voucher" id="voucher_{{ $voucher->id }}" value="{{ $voucher->code }}" class="me-2 " 
                                                                {{ session('voucher.code') == $voucher->code ? 'checked' : '' }}
                                                                @if($isUsed) disabled @endif>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-danger">OK</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                    </div>
                    </div>
                  </aside>
                  
            
            </div>
        </form>
        
       
        
        
        
    </div>
</main>
<script>
  let selectedAddress = {};
  document.querySelectorAll('.change-address-btn').forEach(button => {
      button.addEventListener('click', function () {
          selectedAddress = {
              name: this.getAttribute('data-name'),
              phone: this.getAttribute('data-phone'),
              address: this.getAttribute('data-address'),
          };
      });
  });
  document.getElementById('confirm-address-btn').addEventListener('click', function () {
      // Kiểm tra xem đã chọn địa chỉ chưa
      if (Object.keys(selectedAddress).length === 0) {
          alert('Vui lòng chọn địa chỉ trước khi xác nhận!');
          return;
      }
      document.getElementById('shipping-name').value = selectedAddress.name;
      document.getElementById('shipping-phone').value = selectedAddress.phone;
      document.getElementById('shipping-address').value = selectedAddress.address;
      selectedAddress = {};
  });
</script>
<script>
    document.getElementById('place-order-btn').addEventListener('click', function () {
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const form = document.getElementById('checkout-form');

        if (selectedPaymentMethod === 'VNPay') {
            // Chuyển hướng sang xử lý VNPay
            form.action = "{{ url('/vnpay-payment') }}";
            form.method = "POST";

            // Thêm input hidden `redirect` để kích hoạt giao diện VNPay
            const redirectInput = document.createElement('input');
            redirectInput.type = 'hidden';
            redirectInput.name = 'redirect';
            redirectInput.value = 'true';
            form.appendChild(redirectInput);
        } else {
            // Xử lý thanh toán COD
            form.action = "{{ route('order.store') }}";
            form.method = "POST";
        }

        form.submit();
    });
</script>

@endsection