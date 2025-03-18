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
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sentEmails as $email)
                    <tr>
                        <td>{{ $email->subject }}</td>
                        <td>{{ $email->sent_at }}</td>
                        <td>
                            <a href="{{ route('subscriptions.detailsub', $email->id) }}" class="btn btn-info"><i class="bi bi-eye-fill"></i></a>
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
