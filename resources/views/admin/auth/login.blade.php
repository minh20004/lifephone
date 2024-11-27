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

    <form action="{{ route('admin.login.submit') }}" method="POST"> <!-- Sửa đổi route ở đây -->
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
    
        {{-- Thông báo lỗi cụ thể từ session --}}
        @if (session('error'))
            <div class="alert alert-danger">
                <p class="mb-0">{{ session('error') }}</p>
            </div>
        @endif
    
        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" value="{{ old('email') }}" required>
        </div>
    
        {{-- Mật khẩu --}}
        <div class="mb-3">
            <div class="float-end">
                <a href="#" class="text-muted">Quên mật khẩu?</a> <!-- Thay đổi URL cho trang quên mật khẩu nếu cần -->
            </div>
            <label class="form-label" for="password-input">Mật khẩu</label>
            <div class="position-relative auth-pass-inputgroup mb-3">
                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Nhập mật khẩu" id="password-input" required>
                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon" onclick="togglePasswordVisibility()"><i class="ri-eye-fill align-middle"></i></button>
            </div>
        </div>
    
        {{-- Checkbox "Nhớ mật khẩu" --}}
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
            <label class="form-check-label" for="auth-remember-check">Nhớ mật khẩu</label>
        </div>
    
        <div class="mt-4">
            <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
        </div>
    
        <div class="mt-4 text-center">
            <div class="signin-other-title">
                <a href="{{ route('admin.them-thanh-vien') }}"><h5 class="fs-13 mb-4 title">Đăng kí</h5></a>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
            </div>
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
