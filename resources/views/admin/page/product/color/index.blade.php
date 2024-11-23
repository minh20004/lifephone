{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('color.index') }}"><b class="fs-4 fw-bold">Danh Sách Màu Sắc Sản Phẩm</b></a>
                </div>
            </div>
            <div class="card">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-body">
                    <div class="mb-3" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                        <a href="{{ route('color.create') }}" class="btn mb-3 fs-6 fw-bold text-dark"
                            style="background:#9df99d ">Thêm màu sắc</a>
                        <a href="{{ route('color.trashed') }}" class="btn btn-danger mb-3">Xem danh mục đã bị xóa</a>
                        <a href="{{ route('color.trashed') }}" class="btn btn-danger mb-3">Xem màu sắc đã bị xóa</a>
                    </div>                  
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Tên Màu</th>
                            <th>Mã màu sắc</th>
                            <th>Hành động </th>

                        </thead>
                        <tbody>
                            @foreach ($colors as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>
                                        <div style="width: 50px; height: 30px; background-color: {{ $item->code }}; border: 1px solid #000;"></div>
                                    </td>
                                    <td class="d-flex">
                                        <div class="me-2">
                                            <a href="{{ route('color.edit', $item->id) }}">
                                                <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('color.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa màu sắc này không ?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-end">
                        <nav>
                            <ul class="pagination">
                                {{-- Trang trước --}}
                                @if ($colors->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Lùi</span></li>
                                @else
                                    <li class="page-item"><a href="{{ $colors->previousPageUrl() }}"
                                            class="page-link">Lùi</a></li>
                                @endif

                                {{-- Các trang số --}}
                                @foreach ($colors->links()->elements[0] as $page => $url)
                                    @if ($page == $colors->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}"
                                                class="page-link">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Trang sau --}}
                                @if ($colors->hasMorePages())
                                    <li class="page-item"><a href="{{ $colors->nextPageUrl() }}"
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
