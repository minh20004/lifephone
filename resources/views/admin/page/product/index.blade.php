{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
<<<<<<< HEAD
                    <a href="{{route('product.index')}}"><b class="fs-4 fw-bold">Danh sách sản phẩm</b></a>
=======
                    <a href="{{ route('product.index') }}"><b class="fs-4 fw-bold">Danh sách sản phẩm</b></a>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                </div>
            </div>
            <div class="card">
                <div class="card-body">
<<<<<<< HEAD
                    <div class="mb-5" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                        <a href="{{ route('product.create') }}" class="btn mb-3 fs-6 fw-bold text-dark" style="background:#9df99d ">Thêm sản phẩm </a>
                        <a href="{{ route('product.trashed') }}" class="btn btn-danger mb-3">Xem sản phẩm đã bị xóa</a>
                    </div>
                    <div class="mb-3">
                        <form action="{{ route('product.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" value="{{ $search }}" class="form-control me-2" placeholder="Tìm kiếm sản phẩm...">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </form>
                    </div>
                    
=======
                    <div class="mb-3" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                        <a href="{{ route('product.create') }}" class="btn mb-3 fs-6 fw-bold text-dark"
                            style="background:#9df99d ">Thêm sản phẩm </a>
                        <a href="{{ route('product.trashed') }}" class="btn btn-danger mb-3">Xem sản phẩm đã bị xóa</a>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="btn btn-light mb-4 border ">
                            <form action="{{ route('product.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ $search }}"
                                        placeholder="Tìm kiếm...">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>


>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm </th>
                            <th>Hình ảnh</th>
<<<<<<< HEAD
=======
                            <th>Ảnh phụ</th>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                            <th>Giá</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Hành động </th>

                        </thead>
                        <tbody>
                            @foreach ($products as $index => $item)
                                <tr>
<<<<<<< HEAD
                                    <td>{{$index +1}}</td>
                                    <td>{{$item->product_code}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <img src="{{Storage::url($item->image_url)}}" width="80px" alt="">
                                    </td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                    <td>{!! Str::limit($item->description, 40) !!}</td>
                                    <td>{{$item->Category->name}}</td>
                                    <td class="d-flex">
                                        <div class="me-2">
                                            <a href="{{route('product.edit', $item->id)}}">
=======
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {{-- <img src="{{ Storage::url($item->image_url) }}" width="70px" height="70px" alt=""> --}}
                                        <img src="{{ asset('storage/' . $item->image_url) }}" width="70px" height="70px" alt="">
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
                                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                    <td>{!! Str::limit($item->description, 40) !!}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td class="d-flex">
                                        <div class="me-2">
                                            <a href="{{ route('product.edit', $item->id) }}">
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                                                <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                        </div>
                                        <div>
<<<<<<< HEAD
                                            <form action="{{route('product.destroy', $item->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không')"><i class="bi bi-trash-fill"></i></button>
=======
                                            <form action="{{ route('product.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không')">
                                                    <i class="bi bi-trash-fill"></i></button>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
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
<<<<<<< HEAD
                                    <li class="page-item"><a href="{{ $products->previousPageUrl() }}" class="page-link">Lùi</a></li>
=======
                                    <li class="page-item"><a href="{{ $products->previousPageUrl() }}"
                                            class="page-link">Lùi</a></li>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                                @endif

                                {{-- Các trang số --}}
                                @foreach ($products->links()->elements[0] as $page => $url)
                                    @if ($page == $products->currentPage())
<<<<<<< HEAD
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
=======
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}"
                                                class="page-link">{{ $page }}</a></li>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                                    @endif
                                @endforeach

                                {{-- Trang sau --}}
                                @if ($products->hasMorePages())
<<<<<<< HEAD
                                    <li class="page-item"><a href="{{ $products->nextPageUrl() }}" class="page-link">Tiến</a></li>
=======
                                    <li class="page-item"><a href="{{ $products->nextPageUrl() }}"
                                            class="page-link">Tiến</a></li>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
                                @else
                                    <li class="page-item disabled"><span class="page-link">Tiếp</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
