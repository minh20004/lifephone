@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('color.trashed') }}"><b class="fs-4 fw-bold">Danh sách màu sắc đã bị xóa</b></a>
                </div>
            </div>
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Tên Màu Sắc</th>
                            <th>Mã Màu Sắc</th>
                            <th>Hành động </th>
                        </thead>
                        <tbody>
                            @foreach ($colors as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>
                                        <form action="{{ route('color.restore', $item->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success"
                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục màu sắc này không?')">Khôi phục</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('color.index') }}" class="btn btn-dark mb-3">Quay lại</a>
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
