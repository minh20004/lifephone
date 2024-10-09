{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <h2 class=" text-dark fw-bold m-3 mt-4"
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Tạo mới màu sắc sản phẩm</h2>
                <div class="card-body">
                    <form action="{{ route('color.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Nhập tên màu sắc --}}
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold fs-5">Tên màu sắc</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                   placeholder="Nhập tên màu sắc">

                            @error('name')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="colorCode" class="form-label text-dark fw-bold fs-5">Mã màu sắc</label>
                            <input type="text" id="colorCode" class="form-control @error('code') is-invalid @enderror" name="code"
                                   placeholder="Nhập mã màu (vd: #ddd, #000)" maxlength="7">

                            @error('code')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            {{-- <label for="colorPicker" class="form-label text-dark fw-bold fs-5">Chọn màu</label> --}}
                            <input type="color" id="colorPicker" class="form-control" style="width: 100px; height: 50px;">

                            <small class="text-muted">Bạn có thể nhập mã màu hoặc chọn màu trực tiếp.</small>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('color.index') }}" class="btn btn-dark"> Quay lại</a>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu lại</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
