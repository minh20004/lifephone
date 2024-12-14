@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <b class="fs-4 fw-bold">Thông Tin Biến Thể Sản Phẩm <span class="text-danger">{{$product->name}}</span></b>
                </div>
            </div>
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <table class="table table-bordered">
                        <thead class="thead-light table-light">
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Hình ảnh phụ</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                        </thead>
                        <tbody>
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->name}}</td>
                            <td>
                                <img src="{{ Storage::url($product->image_url) }}" width="70px" height="70px" alt="">
                            </td>
                            <td>
                                @if ($product->gallery_image)
                                    @php
                                        $galleryImages = json_decode($product->gallery_image);
                                    @endphp
                                    @foreach ($galleryImages as $galleryImage)
                                        <img src="{{ Storage::url($galleryImage) }}" width="70px" alt="">
                                    @endforeach
                                @else
                                    Không có ảnh phụ
                                @endif
                            </td>
                            <td>{!! Str::limit($product->description, 40) !!}</td>
                            <td>{{ $product->category->name }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card border border-danger">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-light fs-5">
                            <tr>
                                <th>Màu sắc</th>
                                <th>Dung lượng</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->variants as $variant)
                                <tr class="fw-bold">
                                    <td class="text-primary fw-bold">{{ $variant->color->name }}</td>
                                    <td class="text-info">{{ $variant->capacity->name }}</td>
                                    <td class="text-danger">{{ number_format($variant->price_difference, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $variant->stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
                
            </div>
            <a href="{{ route('product.index') }}" class="btn btn-dark mb-3">Quay lại </a>
        </div>
    </div>


@endsection
