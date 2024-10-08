@extends('admin.layout.master')
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Vouchers</h4>
            </div>
            <div>
                <a href="{{ route('vouchers.create') }}" class="btn btn-sm btn-danger">Thêm mới voucher</a>
            </div>
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
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
                    <tr>
                        <td>{{ $voucher->code }}</td>
                        <td>{{ number_format($voucher->discount_percentage, 2) }}%</td>
                        <td>{{ number_format($voucher->max_discount_amount) }}</td>
                        <td>{{ number_format($voucher->min_order_value) }}</td>
                        <td>{{ \Carbon\Carbon::parse($voucher->start_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d-m-Y') }}</td>
                        <td>{{ $voucher->usage_limit }}</td>
                        <td>
                            <a href="{{route('vouchers.edit', $voucher->id)}}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa voucher này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
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
@endsection