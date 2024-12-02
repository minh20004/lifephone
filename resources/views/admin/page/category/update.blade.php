{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Sửa danh mục</h2>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="product_code" class="form-label text-dark fw-bold fs-5">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập tên danh mục"
                                value="{{ $category->name }}" >
                            @error('name')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="100" class="mb-2">
                        @endif
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold fs-5">Thay đổi hình ảnh</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            @error('image')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($category->image_page)
                        <img src="{{ asset('storage/' . $category->image_page) }}" alt="{{ $category->image_page }}" width="100" class="mb-2">
                        @endif
                        <div class="mb-3">
                            <label for="image_page" class="form-label text-dark fw-bold fs-5">Thay đổi hình ảnh trang </label>
                            <input type="file" class="form-control @error('image_page') is-invalid @enderror" name="image_page">
                            @error('image_page')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('category.index') }}" class="btn btn-dark"> Quay lại</a>
                            </div>
                            <button type="submit" class="btn btn-warning">Lưu lại</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
