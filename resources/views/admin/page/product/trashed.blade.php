{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('product.trashed') }}"><b class="fs-4 fw-bold">Danh sách sản phẩm đã bị xóa</b></a>
                </div>
            </div>
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-body">
                    
                    <div class="d-flex justify-content-end">
                        <div class="btn btn-light mb-4 border ">
                            <form action="{{ route('product.trashed') }}" method="GET" >
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <th>STT</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm </th>
                            <th>Hình ảnh</th>
                            <th>Ảnh phụ</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Biến Thể</th>
                            <th>Hành động </th>

                        </thead>
                        <tbody>
                            @foreach ($products as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <img src="{{ Storage::url($item->image_url) }}" width="80px" height="80px" alt="">
                                    </td>
                                    <td>
                                        @if ($item->gallery_image)
                                            @php
                                                $galleryImages = json_decode($item->gallery_image);
                                            @endphp
                                            @foreach ($galleryImages as $galleryImage)
                                                <img src="{{ Storage::url($galleryImage) }}" width="70px" alt="">
                                            @endforeach
                                        @else
                                            Không có ảnh phụ
                                        @endif
                                    </td>
                                    <td>{!! Str::limit($item->description, 40) !!}</td>
                                    <td>{{ $item->Category->name }}</td>
                                    <td><a href="{{ route('product.variants', ['id' => $item->id]) }}" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a></td>



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
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('product.index') }}" class="btn btn-dark mb-3">Quay lại </a>
                        {{-- phân trang  --}}
                        <div >
                            <nav>
                                <ul class="pagination">
                                    {{-- Trang trước --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">Lùi</span></li>
                                    @else
                                        <li class="page-item"><a href="{{ $products->previousPageUrl() }}"
                                                class="page-link">Lùi</a></li>
                                    @endif

                                    {{-- Các trang số --}}
                                    @foreach ($products->links()->elements[0] as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a href="{{ $url }}"
                                                    class="page-link">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Trang sau --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item"><a href="{{ $products->nextPageUrl() }}"
                                                class="page-link">Tiến</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Tiến</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
