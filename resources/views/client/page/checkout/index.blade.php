@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">
    <div class="container py-5">
        <form id="checkout-form" method="POST" action="{{ route('order.store') }}" class="p-4 bg-light rounded shadow-sm">
            @csrf
            <h5>1. Địa chỉ giao hàng</h5>
            @if(auth('customer')->check() && $addresses->isNotEmpty())
                <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal" class="text-primary">Thay đổi</a>
            @endif
            <div class="mb-3">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->name : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->phone_number : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                    value="{{ auth('customer')->check() ? auth('customer')->user()->email : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="address">Địa chỉ chi tiết</label>
                <input type="text" id="address" name="address" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->address : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>

            <h5>2. Phương thức thanh toán</h5>
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

            <div class="mb-3">
                <textarea name="description" class="form-control" rows="4" placeholder="Nội dung"></textarea>
            </div>
                <div>
                    @foreach ($cart as $product)
                        @foreach ($product as $model)
                            @foreach ($model as $item)
                                <div class="ratio ratio-1x1" style="max-width: 64px">
                                    <div class="">
                                        <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="iPhone" style="width: 70px; height:70px;">
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endforeach
                </div>
                <ul class="list-unstyled fs-sm gap-3 mb-0">
                    <li class="d-flex justify-content-between">
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
                
                <button type="submit" class="btn btn-primary w-100" id="place-order-btn">Đặt hàng</button>
        </form>
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
                        <form action="{{ route('order.applyVoucher') }}" method="POST" class="needs-validation d-flex gap-2" novalidate>
                            @csrf
                            <div class="position-relative w-100 mb-3">
                                <input type="text" name="voucher_code" id="voucher_code" class="form-control" placeholder="Nhập mã khuyến mãi" required>
                                <div class="invalid-tooltip bg-transparent py-0">Nhập mã khuyến mãi hợp lệ!</div>
                            </div>
                            <button type="submit" class="btn btn-dark">Áp dụng</button>
                        </form>
        
                        <div class="mt-4">
                            <p>Chọn một mã khuyến mãi:</p>
                            <form id="voucher-selection-form" action="{{ route('order.applyVoucher') }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @foreach($vouchers as $voucher)
                                    <div class="voucher-option d-flex align-items-center">
                                        <input type="radio" name="selected_voucher" id="voucher_{{ $voucher->id }}" value="{{ $voucher->code }}" class="me-2" 
                                               {{ session('voucher.code') == $voucher->code ? 'checked' : '' }}>
                                        <label for="voucher_{{ $voucher->id }}">
                                            <div class="d-flex align-items-center">
                                                @if($voucher->image)
                                                    <img src="{{ asset('storage/' . $voucher->image) }}" alt="Voucher Image" class="voucher-image" width="50" height="50">
                                                @endif
                                                <div class="ms-3">
                                                    <strong>{{ $voucher->title }}</strong><br>
                                                    {{ $voucher->discount_percentage }}% - HSD: {{ $voucher->end_date }}<br>
                                                    <small>{{ $voucher->terms_conditions }}</small><br>
                            
                                                    @if($voucher->min_order_value)
                                                        <small><strong>Đơn tối thiểu:</strong> {{ number_format($voucher->min_order_value, 0, ',', '.') }} VNĐ</small><br>
                                                    @endif
                                                    @if($voucher->max_discount_amount)
                                                        <small><strong>Giảm tối đa:</strong> {{ number_format($voucher->max_discount_amount, 0, ',', '.') }} VNĐ</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-dark">Áp dụng</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>
</main>
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

{{-- @extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">
    <div class="container py-5">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form id="checkout-form-cod"  action="{{ route('order.store') }}" method="POST"  class="p-4 bg-light rounded shadow-sm">
            @csrf
            <h5>1. Địa chỉ giao hàng</h5>
            @if(auth('customer')->check() && $addresses->isNotEmpty())
                <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal" class="text-primary">Thay đổi</a>
            @endif
            <div class="mb-3">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->name : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->phone_number : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                    value="{{ auth('customer')->check() ? auth('customer')->user()->email : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="address">Địa chỉ chi tiết</label>
                <input type="text" id="address" name="address" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->address : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>

            <h5>2. Phương thức thanh toán</h5>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="COD" id="payment_method_cod" checked>
                    <label class="form-check-label" for="payment_method_cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
            </div>

            <div class="mb-3">
                <textarea name="description" class="form-control" rows="4" placeholder="Nội dung"></textarea>
            </div>

            <div>
                @foreach ($selectedCart as $product)
                    @foreach ($product as $model)
                        @foreach ($model as $item)
                            <div class="ratio ratio-1x1" style="max-width: 64px">
                                <div class="">
                                    <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="iPhone" style="width: 70px; height:70px;">
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>

            <ul class="list-unstyled fs-sm gap-3 mb-0">
                <li class="d-flex justify-content-between">
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

            <button type="submit" class="btn btn-primary w-100" id="place-order-btn-cod">Đặt hàng (COD)</button>
        </form>
        <form id="checkout-form-cod" method="POST" action="{{ route('order.store') }}" class="p-4 bg-light rounded shadow-sm">
            @csrf
            <h5>1. Địa chỉ giao hàng</h5>
            @if(auth('customer')->check() && $addresses->isNotEmpty())
                <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal" class="text-primary">Thay đổi</a>
            @endif
        
            <!-- Địa chỉ, tên, điện thoại, email, địa chỉ chi tiết -->
            <div class="mb-3">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->name : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
        
            <div class="mb-3">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->phone_number : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
        
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                    value="{{ auth('customer')->check() ? auth('customer')->user()->email : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
        
            <div class="mb-3">
                <label for="address">Địa chỉ chi tiết</label>
                <input type="text" id="address" name="address" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->address : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
        
            <h5>2. Phương thức thanh toán</h5>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="COD" id="payment_method_cod" checked>
                    <label class="form-check-label" for="payment_method_cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
            </div>
        
            <div class="mb-3">
                <textarea name="description" class="form-control" rows="4" placeholder="Nội dung"></textarea>
            </div>
        
            <h5>3. Các sản phẩm đã chọn</h5>
            <div>
                @foreach ($selectedCart as $product)
                    @foreach ($product as $model)
                        @foreach ($model as $item)
                            <div class="ratio ratio-1x1" style="max-width: 64px">
                                <div class="">
                                    <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="Sản phẩm" style="width: 70px; height:70px;">
                                </div>
                            </div>
                            <!-- Sản phẩm có số lượng -->
                            <div>
                                <label for="quantity_{{ $item['id'] }}">Số lượng:</label>
                                <input type="number" id="quantity_{{ $item['id'] }}" name="products[{{ $item['id'] }}][quantity]" value="{{ $item['quantity'] }}" min="1" class="form-control" required>
                                <input type="hidden" name="products[{{ $item['id'] }}][variant_id]" value="{{ $item['variant_id'] }}">
                                <input type="hidden" name="products[{{ $item['id'] }}][price]" value="{{ $item['price'] }}">
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        
            <!-- Tổng giá trị, giảm giá và tổng ước tính -->
        
            <button type="submit" class="btn btn-primary w-100" id="place-order-btn-cod">Đặt hàng (COD)</button>
        </form> 
        
        
        <form id="checkout-form-vnpay" method="POST" action="{{ url('/vnpay-payment') }}" class="p-4 bg-light rounded shadow-sm mt-4">
            @csrf
            <h5>1. Địa chỉ giao hàng</h5>
            @if(auth('customer')->check() && $addresses->isNotEmpty())
                <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal" class="text-primary">Thay đổi</a>
            @endif
            <div class="mb-3">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->name : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->phone_number : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                    value="{{ auth('customer')->check() ? auth('customer')->user()->email : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>
            <div class="mb-3">
                <label for="address">Địa chỉ chi tiết</label>
                <input type="text" id="address" name="address" class="form-control" 
                    value="{{ auth('customer')->check() && $defaultAddress ? $defaultAddress->address : '' }}" 
                    {{ auth('customer')->check() ? 'readonly' : '' }} required>
            </div>

            <h5>2. Phương thức thanh toán</h5>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="VNPay" id="payment_method_vnpay" checked>
                    <label class="form-check-label" for="payment_method_vnpay">Thanh toán trực tuyến (VNPay)</label>
                </div>
            </div>

            <div class="mb-3">
                <textarea name="description" class="form-control" rows="4" placeholder="Nội dung"></textarea>
            </div>

            <div>
                @foreach ($selectedCart as $product)
                    @foreach ($product as $model)
                        @foreach ($model as $item)
                            <div class="ratio ratio-1x1" style="max-width: 64px">
                                <div class="">
                                    <img src="{{ asset('storage/' . $item['image_url']) }}" class="d-block p-1" alt="iPhone" style="width: 70px; height:70px;">
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>

            <ul class="list-unstyled fs-sm gap-3 mb-0">
                <li class="d-flex justify-content-between">
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

            <button type="submit" class="btn btn-primary w-100" id="place-order-btn-vnpay">Đặt hàng (VNPay)</button>
        </form>
    </div>
</main>
@endsection --}}
{{-- <div>
    @if(!empty($checkoutCart))
        <h3>Sản phẩm bạn đã chọn để thanh toán:</h3>
        <ul>
            @foreach ($checkoutCart as $item)
                <li>
                    {{ $item['product']->name }} - 
                    {{ $item['variant']->capacity->name }} - 
                    {{ $item['variant']->color->name }} - 
                    Số lượng: {{ $item['quantity'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Không có sản phẩm nào trong giỏ hàng để thanh toán.</p>
    @endif

</div> --}}