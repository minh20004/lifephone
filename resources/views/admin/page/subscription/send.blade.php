@extends('admin.layout.master')
@section('title')
Gửi email hàng loạt 
@endsection
@section('content')
<div class="container">
    <h1 class="my-4">Gửi email hàng loạt</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('subscriptions.send') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subject" class="form-label">Tiêu đề</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Nội dung</label>
     
            <textarea class="form-control" id="message" name="message" cols="500" rows="10"
                @error('message') is-invalid @enderror placeholder="Nhập thông tin"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi email</button>
    </form>
</div>
@endsection