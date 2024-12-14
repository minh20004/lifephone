@extends('admin.layout.master')
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <!-- Tiêu đề trang -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-gradient-info text-white p-4 rounded-3 shadow-sm">
                <h4 class="mb-sm-0 fw-bold">Vouchers</h4>
            </div>

            <!-- Nút thêm voucher -->
            <div class="mb-4">
                <a href="{{ route('vouchers.create') }}" class="btn btn-info btn-sm rounded-3 shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> Thêm mới voucher
                </a>
            </div>


            <!-- Bảng danh sách vouchers -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped shadow-lg bg-light rounded-3">
                    <thead class="table-secondary">
                        <tr>
                            <th>Mã Vouchers</th>
                            <th>Tỷ lệ chiết khấu</th>
                            <th>Số tiền chiết khấu tối đa</th>
                            <th>Giá trị đơn hàng tối thiểu</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Giới hạn sử dụng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vouchers as $voucher)
                        <tr class="hover:bg-light transition-all duration-200">
                            <td>{{ $voucher->code }}</td>
                            <td>{{ number_format($voucher->discount_percentage, 2) }}%</td>
                            <td>{{ number_format($voucher->max_discount_amount) }}</td>
                            <td>{{ number_format($voucher->min_order_value) }}</td>
                            <td>{{ \Carbon\Carbon::parse($voucher->start_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d-m-Y') }}</td>
                            <td>{{ $voucher->usage_limit }}</td>
                            <td class="d-flex">
                                <!-- Nút sửa -->
                                <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-primary rounded-3 shadow-sm me-2 transition-all duration-300 hover:bg-primary-light">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <!-- Form xóa -->
                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa voucher này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 shadow-sm transition-all duration-300 hover:bg-danger-light">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection