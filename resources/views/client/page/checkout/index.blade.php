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
            <div class="border-top pt-4 mt-4">
                <div class="d-flex justify-content-between mb-3">
                  <span class="fs-sm">Tổng ước tính:</span>
                  <span class="h5 mb-0">{{ number_format($estimatedTotal, 0, ',', '.') }} đ</span>
                </div>
              </div>
            <button type="button" class="btn btn-primary w-100" id="place-order-btn">Đặt hàng</button>
        </form>
    </div>
</main>

{{-- <script>
    document.getElementById('place-order-btn').addEventListener('click', function () {
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const form = document.getElementById('checkout-form');

        if (selectedPaymentMethod === 'VNPay') {
            // Chuyển hướng sang xử lý VNPay
            form.action = "{{ url('/vnpay-payment') }}";
            form.method = "POST";
        } else {
            // Xử lý thanh toán COD
            form.action = "{{ route('order.store') }}";
            form.method = "POST";
        }

        form.submit();
    });
</script> --}}
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
