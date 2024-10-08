{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
<<<<<<< HEAD
                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Thêm danh mục</h2>
=======
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Tạo mới danh mục</h2>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="" class="form-label">Tên danh mục: </label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập tên danh mục">
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                            
                        </div>
                    </form>
                    <a href="{{route('category.index')}}">
                        <button class="btn btn-dark">Quay lại</button>
                    </a>
=======
                            <label for="product_code" class="form-label text-dark fw-bold fs-5">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập tên danh mục">

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
                            <button type="submit" class="btn btn-success">Lưu lại</button>

                        </div>
                    </form>

>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                </div>
            </div>
        </div>
    </div>
@endsection
