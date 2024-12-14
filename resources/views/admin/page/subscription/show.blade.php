@extends('admin.layout.master')
@section('title')
    Thành viên đăng kí
@endsection
@section('content')
<div class="container">
    <h1 class="" style="margin-top: 100px;">Chi tiết tin nhắn</h1>

    <div class="card">
        <div class="card-body">
            <h3>Tiêu đề: {{ $sentEmail->subject }}</h3>
            <p><strong>Ngày gửi:</strong> {{ $sentEmail->sent_at }}</p>
            <div>
                <strong>Nội dung:</strong>
                {!! $sentEmail->message !!}
            </div>
        </div>
    </div>

    <a href="{{ route('subscriptions.index') }}" class="btn btn-primary mt-3">Quay lại danh sách</a>
</div>
@endsection