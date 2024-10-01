{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Sửa sản phẩm</h2>
                <div class="card-body">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="mb-3">
                            <label for="product_code" class="form-label">Mã sản phẩm:</label>
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                placeholder="Nhập mã sản phẩm" @error('product_code') is-invalid @enderror
                                value="{{ $product->product_code }}">
                            @error('product_code')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên sản phẩm" @error('name') is-invalid @enderror
                                value="{{ $product->name }}">
                            @error('name')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Hình ảnh sản phẩm:</label>
                            <input type="file" class="form-control" id="image_url" name="image_url"
                                placeholder=" Hình ảnh sản phẩm" @error('image_url') is-invalid @enderror
                                value="{{ $product->image_url }}">
                            @if ($product->image_url)
                                <img src="{{ Storage::url($product->image_url) }}" width="80px" alt="">
                            @endif
                            @error('image_url')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá sản phẩm:</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" placeholder="Giá sản phẩm"
                                    value="{{ number_format($product->price, 0, ',', '.') }}">
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả sản phẩm:</label>
                            <textarea class="form-control" id="description" name="description" cols="500" rows="10"
                                @error('description') is-invalid @enderror placeholder="Mô tả sản phẩm">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Danh mục:</label>
                            <select name="category_id" id="category" class="form-select"
                                @error('category_id') is-invalid @enderror>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Sửa sản phẩm</button>
                        </div>
                    </form>
                    <a href="{{ route('product.index') }}">
                        <button class="btn btn-dark">Quay lại</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
@endsection
