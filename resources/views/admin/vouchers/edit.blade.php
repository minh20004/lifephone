@extends('admin.layout.master')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <!-- Bọc toàn bộ nội dung vào một div có nền trắng -->
            <div class="p-4 bg-white rounded shadow-sm">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Sửa Voucher</h4>
                </div>
                <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Mã Voucher -->
                    <div class="mb-4">
                        <label for="code" class="form-label fw-bold">Mã Voucher</label>
                        <input type="text" class="form-control shadow-sm" name="code" value="{{ old('code', $voucher->code) }}" required>
                        @error('code')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ảnh Voucher -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Ảnh Voucher (nếu thay đổi)</label>
                        <input type="file" class="form-control shadow-sm" name="image" accept="image/*">
                        @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        @if($voucher->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $voucher->image) }}" alt="Voucher Image" class="img-fluid rounded-3 shadow-sm" style="max-width: 150px; max-height: 150px;">
                        </div>
                        @endif
                    </div>

                    <!-- Tỷ lệ chiết khấu -->
                    <div class="mb-4">
                        <label for="discount_percentage" class="form-label fw-bold">Tỷ lệ chiết khấu (%)</label>
                        <input type="number" name="discount_percentage" class="form-control shadow-sm" value="{{ old('discount_percentage', $voucher->discount_percentage) }}" required>
                        @error('discount_percentage')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Số tiền chiết khấu tối đa -->
                    <div class="mb-4">
                        <label for="max_discount_amount" class="form-label fw-bold">Số tiền chiết khấu tối đa</label>
                        <input type="number" class="form-control shadow-sm" name="max_discount_amount" value="{{ old('max_discount_amount', $voucher->max_discount_amount) }}" required>
                        @error('max_discount_amount')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Giá trị đơn hàng tối thiểu -->
                    <div class="mb-4">
                        <label for="min_order_value" class="form-label fw-bold">Giá trị đơn hàng tối thiểu</label>
                        <input type="number" class="form-control shadow-sm" name="min_order_value" value="{{ old('min_order_value', $voucher->min_order_value) }}" required>
                        @error('min_order_value')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày bắt đầu -->
                    <div class="mb-4">
                        <label for="start_date" class="form-label fw-bold">Ngày bắt đầu</label>
                        <input type="date" class="form-control shadow-sm" name="start_date" value="{{ old('start_date', $voucher->start_date) }}" required>
                        @error('start_date')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày kết thúc -->
                    <div class="mb-4">
                        <label for="end_date" class="form-label fw-bold">Ngày kết thúc</label>
                        <input type="date" class="form-control shadow-sm" name="end_date" value="{{ old('end_date', $voucher->end_date) }}" required>
                        @error('end_date')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Giới hạn sử dụng -->
                    <div class="mb-4">
                        <label for="usage_limit" class="form-label fw-bold">Giới hạn sử dụng</label>
                        <input type="number" class="form-control shadow-sm" name="usage_limit" value="{{ old('usage_limit', $voucher->usage_limit) }}" required>
                        @error('usage_limit')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nút Lưu -->
                    <div class="d-flex justify-content-between">
                        <!-- Nút Quay lại -->
                        <a href="{{ route('vouchers.index') }}" class="btn btn-secondary shadow-sm">
                            Quay lại
                        </a>
                        <!-- Nút Lưu -->
                        <button type="submit" class="btn btn-primary shadow-sm">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
