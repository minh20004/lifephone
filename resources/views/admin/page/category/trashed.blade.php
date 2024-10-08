@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('category.trashed') }}"><b class="fs-4 fw-bold">Danh sách danh mục đã bị xóa</b></a>
                </div>
            </div>
            <div class="card">
<<<<<<< HEAD
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
<<<<<<< HEAD
<<<<<<< HEAD
                <h2 class="cart-header text-center m-3" style="font-weight: bold">Danh sách danh mục đã bị xóa</h2>
=======
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <th>STT</th>
                            <th>Tên danh mục</th>
                            <th>Hành động</th>
                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form action="{{ route('category.restore', $item->id) }}" method="POST">
                                            @csrf
<<<<<<< HEAD
<<<<<<< HEAD
                                            <button class="btn btn-primary"
=======
                                            <button class="btn btn-success"
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                                            <button class="btn btn-success"
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục danh mục này không?')">Khôi phục</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
<<<<<<< HEAD
<<<<<<< HEAD
                    <a href="{{ route('product.index') }}" class="btn btn-primary mb-3">Quay lại danh mục</a>
=======
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('category.index') }}" class="btn btn-dark mb-3">Quay lại</a>
                        {{-- Phân trang danh mục --}}
                        <div >
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
<<<<<<< HEAD
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50

                </div>
            </div>
        </div>
    </div>
@endsection
