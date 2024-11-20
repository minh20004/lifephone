
@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Tạo mới danh mục</h2>
                <div class="card-body">
                    <form action="{{ route('category_news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="product_code" class="form-label text-dark fw-bold fs-5">Tên danh mục tin tức</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Nhập tên danh mục tin tức">

                            @error('title')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('category_news.index') }}" class="btn btn-dark"> Quay lại</a>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu lại</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection