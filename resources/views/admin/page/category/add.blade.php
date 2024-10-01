{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Thêm danh mục</h2>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
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
                </div>
            </div>
        </div>
    </div>
@endsection
