@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <h2 class="cart-header text-center m-3" style="font-weight: bold">Danh sách danh mục đã bị xóa</h2>
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
                                            <button class="btn btn-primary"
                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục danh mục này không?')">Khôi phục</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('product.index') }}" class="btn btn-primary mb-3">Quay lại danh mục</a>

                </div>
            </div>
        </div>
    </div>
@endsection
