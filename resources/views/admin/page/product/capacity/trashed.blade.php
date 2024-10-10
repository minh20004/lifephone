@extends('admin.layout.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="m-3" style="margin-left: 20px">
                    <a href="{{ route('capacity.trashed') }}"><b class="fs-4 fw-bold">Danh sách dung lượng đã bị xóa</b></a>
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
                            <th>Tên dung lượng</th>
                            <th>Hành động </th>
                        </thead>
                        <tbody>
                            @foreach ($capacities as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form action="{{ route('capacity.restore', $item->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success"
                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục dung lượng này không?')">Khôi phục</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('capacity.index') }}" class="btn btn-dark mb-3">Quay lại</a>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
