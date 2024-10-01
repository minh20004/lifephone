{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Danh sách sản phẩm đã bị xóa </h2>
                <div class="card-body">
                    <a href="{{ route('product.index') }}" class="btn btn-primary mb-3">Quay lại danh sách sản phẩm</a>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Tên sản phẩm </th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Hành động </th>

                        </thead>
                        <tbody>
                            @foreach ($products as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <img src="{{ Storage::url($item->image_url) }}" width="80px" alt="">
                                    </td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                    <td>{!! Str::limit($item->description, 40) !!}</td>
                                    <td>{{ $item->Category->name }}</td>
                                    <td>
                                        <form action="{{ route('product.restore', $item->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success"
                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục sản phẩm này không?')">Khôi
                                                phục</button>
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
