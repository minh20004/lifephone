{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
<<<<<<< HEAD
<<<<<<< HEAD
                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Sửa danh mục</h2>
=======
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Sửa danh mục</h2>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Sửa danh mục</h2>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
<<<<<<< HEAD
<<<<<<< HEAD
                            <label for="" class="form-label">Tên danh mục: </label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập tên danh mục" value="{{$category->name}}">
=======
                            <label for="product_code" class="form-label text-dark fw-bold fs-5">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập tên danh mục"
                                value="{{ $category->name }}" >
                            @error('name')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('category.index') }}" class="btn btn-dark"> Quay lại</a>
                            </div>
                            <button type="submit" class="btn btn-warning">Lưu lại</button>

                        </div>
                    </form>
<<<<<<< HEAD
                    <a href="{{route('category.index')}}">
                        <button class="btn btn-dark">Quay lại</button>
                    </a>
=======
                            <label for="product_code" class="form-label text-dark fw-bold fs-5">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập tên danh mục"
                                value="{{ $category->name }}" >
                            @error('name')
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

>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======

>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                </div>
            </div>
        </div>
    </div>
@endsection
