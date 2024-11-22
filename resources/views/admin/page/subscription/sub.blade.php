@extends('admin.layout.master')
@section('title')
    Thành viên đăng kí
@endsection
@section('content')
<div class="container">
    <h1 class="my-4">Danh sách email đăng ký</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Ngày đăng ký</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->id }}</td>
                    <td>{{ $subscription->email }}</td>
                    <td>{{ $subscription->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $subscriptions->links() }}
</div>
@endsection