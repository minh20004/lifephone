{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
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

                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Danh sách danh mục</h2>
                <div class="card-body">
                    <a href="{{ route('category.create') }}" class="btn btn-success mb-3">Thêm danh mục </a>
                    <a href="{{ route('category.trashed') }}" class="btn btn-danger mb-3">Xem danh mục đã bị xóa</a>

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
                                                <button class="btn btn-warning">Sửa</button>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('category.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không ?')">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
