{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
<<<<<<< HEAD
<<<<<<< HEAD
                    <a href="{{route('product.index')}}"><b class="fs-4 fw-bold">Danh sách sản phẩm</b></a>
=======
                    <a href="{{ route('product.index') }}"><b class="fs-4 fw-bold">Danh sách sản phẩm</b></a>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                    <a href="{{ route('product.index') }}"><b class="fs-4 fw-bold">Danh sách sản phẩm</b></a>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                </div>
            </div>
            <div class="card">
                <div class="card-body">
<<<<<<< HEAD
<<<<<<< HEAD
                    <div class="mb-5" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                        <a href="{{ route('product.create') }}" class="btn mb-3 fs-6 fw-bold text-dark" style="background:#9df99d ">Thêm sản phẩm </a>
=======
                    <div class="mb-3" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                        <a href="{{ route('product.create') }}" class="btn mb-3 fs-6 fw-bold text-dark"
                            style="background:#9df99d ">Thêm sản phẩm </a>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
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
<<<<<<< HEAD
                    
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
=======


>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm </th>
                            <th>Hình ảnh</th>
<<<<<<< HEAD
<<<<<<< HEAD
=======
                            <th>Ảnh phụ</th>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                            <th>Ảnh phụ</th>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                            <th>Giá</th>
                            <th>Mô tả</th>
                            <th>Danh mục</th>
                            <th>Hành động </th>

                        </thead>
                        <tbody>
                            @foreach ($products as $index => $item)
                                <tr>
<<<<<<< HEAD
<<<<<<< HEAD
                                    <td>{{$index +1}}</td>
                                    <td>{{$item->product_code}}</td>
                                    <td>{{$item->name}}</td>
=======
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_code }}</td>
                                    <td>{{ $item->name }}</td>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                                    <td>
                                        <img src="{{ Storage::url($item->image_url) }}" width="70px" height="70px" alt="">
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
<<<<<<< HEAD
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
=======
                                            <a href="{{ route('product.edit', $item->id) }}">
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                                                <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                        </div>
                                        <div>
<<<<<<< HEAD
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
=======
                                            <form action="{{ route('product.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không')">
                                                    <i class="bi bi-trash-fill"></i></button>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
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
<<<<<<< HEAD
                                    <li class="page-item"><a href="{{ $products->previousPageUrl() }}" class="page-link">Lùi</a></li>
=======
                                    <li class="page-item"><a href="{{ $products->previousPageUrl() }}"
                                            class="page-link">Lùi</a></li>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                                    <li class="page-item"><a href="{{ $products->previousPageUrl() }}"
                                            class="page-link">Lùi</a></li>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                                @endif

                                {{-- Các trang số --}}
                                @foreach ($products->links()->elements[0] as $page => $url)
                                    @if ($page == $products->currentPage())
<<<<<<< HEAD
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
=======
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}"
                                                class="page-link">{{ $page }}</a></li>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                                    @endif
                                @endforeach

                                {{-- Trang sau --}}
                                @if ($products->hasMorePages())
<<<<<<< HEAD
<<<<<<< HEAD
                                    <li class="page-item"><a href="{{ $products->nextPageUrl() }}" class="page-link">Tiến</a></li>
=======
                                    <li class="page-item"><a href="{{ $products->nextPageUrl() }}"
                                            class="page-link">Tiến</a></li>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                                    <li class="page-item"><a href="{{ $products->nextPageUrl() }}"
                                            class="page-link">Tiến</a></li>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
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
