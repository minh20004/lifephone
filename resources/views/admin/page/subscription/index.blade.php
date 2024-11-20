@extends('admin.layout.master')
@section('title')
Danh sách email đã gửi
@endsection
@section('content')
<div class="container">
    <h1 class="my-4">Danh sách email đã gửi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($sentEmails->isEmpty())
        <p>Chưa có email nào được gửi.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Ngày gửi</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sentEmails as $email)
                    <tr>
                        <td>{{ $email->subject }}</td>
                        <td>{{ $email->sent_at }}</td>
                        <td>
                            <!-- Bạn có thể thêm các thao tác khác ở đây, ví dụ: xem chi tiết, xóa -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân trang -->
        {{ $sentEmails->links() }}
    @endif
</div>
@endsection
