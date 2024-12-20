{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('product.index') }}"><b class="fs-4 fw-bold">Danh sách sản phẩm</b></a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                        <a href="{{ route('product.create') }}" class="btn mb-3 fs-6 fw-bold text-dark"
                            style="background:#9df99d "><i class="bi bi-cloud-plus-fill"></i>Thêm sản phẩm </a>
                        <a href="{{ route('product.trashed') }}" class="btn btn-danger mb-3">Xem sản phẩm đã bị xóa</a>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="btn btn-light mb-4 border ">
                            <form action="{{ route('product.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control search_input" name="search" value="{{ $search }}"
                                        placeholder="Tìm kiếm...">
                                    <button class="btn btn-primary btn-search" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <th>STT</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Hình ảnh phụ</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Biến thể</th>
                            <th>Hành động</th>

                        </thead>
                        <tbody>
                            @foreach ($products as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {{-- <img src="{{ Storage::url($item->image_url) }}" width="70px" height="70px" alt=""> --}}
                                        <img src="{{ asset('storage/' . $item->image_url) }}" alt=""  width="70px" height="70px">
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
                                    <td>{{ $item->category->name }}</td>
                                    <td><a href="{{ route('product.variants', $item->id) }}" class="btn btn-dark"><i class="bi bi-eye-fill"></i></a></td>
                                    <td class="d-flex">
                                        <div class="me-2">
                                            <a href="{{ route('product.edit', $item->id) }}">
                                                <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('product.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không')">
                                                    <i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    
                    {{-- phân trang  --}}
                    <div class="d-flex justify-content-end">
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
@endsection
