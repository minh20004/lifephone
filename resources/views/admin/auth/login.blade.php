@extends('admin.auth.layout.master')

@section('title')
    Đăng nhập
@endsection

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf  
        {{-- Hiển thị thông báo lỗi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    
        {{-- Thông báo thành công --}}
        @if (session('success'))
            <div class="alert alert-success">
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        @endif
    
        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" value="{{ old('email') }}" required>
        </div>
    
        {{-- Mật khẩu --}}
        <div class="mb-3">
            <label class="form-label" for="password-input">Mật khẩu</label>
            <div class="position-relative auth-pass-inputgroup mb-3">
                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Nhập mật khẩu" id="password-input" required>
            </div>
        </div>
    
        {{-- Submit Button --}}
        <div class="mt-4">
            <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
        </div>
    
        {{-- Gửi lại email xác nhận --}}
        <div class="mt-3 text-center">
            <form action="{{ route('admin.resendVerification') }}" method="POST">
                @csrf
                <button type="submit">Gửi lại email xác minh</button>
            </form>
            {{-- <a href="{{ route('admin.resendVerification') }}" class="text-muted">Gửi lại email xác nhận?</a> --}}
        </div>
    </form>
    
    

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password-input');
            const passwordAddon = document.getElementById('password-addon').firstElementChild;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordAddon.classList.remove('ri-eye-fill');
                passwordAddon.classList.add('ri-eye-off-fill');
            } else {
                passwordInput.type = 'password';
                passwordAddon.classList.remove('ri-eye-off-fill');
                passwordAddon.classList.add('ri-eye-fill');
            }
        }
    </script>
@endsection
