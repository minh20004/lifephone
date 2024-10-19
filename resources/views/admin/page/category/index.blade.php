{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('category.index') }}"><b class="fs-4 fw-bold">Danh sách Danh mục</b></a>
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
                        <a href="{{ route('category.create') }}" class="btn mb-3 fs-6 fw-bold text-dark"
                            style="background:#9df99d ">Thêm danh mục </a>
                        <a href="{{ route('category.trashed') }}" class="btn btn-danger mb-3">Xem danh mục đã bị xóa</a>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="btn btn-light mb-4 border ">
                            <form action="{{ route('category.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" placeholder="Tìm kiếm...">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Tên danh mục </th>
                            <th>Hành động </th>

                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="d-flex">
                                        <div class="me-2">
                                            <a href="{{ route('category.edit', $item->id) }}">
                                                <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('category.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không ?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{-- Phân trang danh mục --}}
                    <div class="d-flex justify-content-end">
                        <nav>
                            <ul class="pagination">
                                {{-- Trang trước --}}
                                @if ($categories->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Lùi</span></li>
                                @else
                                    <li class="page-item"><a href="{{ $categories->previousPageUrl() }}"
                                            class="page-link">Lùi</a></li>
                                @endif

                                {{-- Các trang số --}}
                                @foreach ($categories->links()->elements[0] as $page => $url)
                                    @if ($page == $categories->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a href="{{ $url }}"
                                                class="page-link">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Trang sau --}}
                                @if ($categories->hasMorePages())
                                    <li class="page-item"><a href="{{ $categories->nextPageUrl() }}"
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
