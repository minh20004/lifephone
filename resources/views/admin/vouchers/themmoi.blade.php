@extends('admin.layout.master')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Thêm Voucher</h4>
            </div>
            <form action="{{ route('vouchers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="code">Mã Voucher</label>
                    <input type="text" class="form-control"  name="code">
                    @error('code')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_percentage" class="form-label">Tỷ lệ chiết khấu (%)</label>
                    <input type="number" name="discount_percentage" class="form-control" >
                    @error('discount_percentage')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_discount_amount">Số tiền chiết khấu tối đa</label>
                    <input type="number" class="form-control"  name="max_discount_amount">
                    @error('max_discount_amount')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
                    <input type="number" class="form-control"  name="min_order_value" >
                    @error('min_order_value')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="date" class="form-control"  name="start_date" >
                    @error('start_date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="date" class="form-control"  name="end_date" >
                    @error('end_date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="usage_limit">Giới hạn sử dụng</label>
                    <input type="number" class="form-control" name="usage_limit">
                    @error('usage_limit')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection
