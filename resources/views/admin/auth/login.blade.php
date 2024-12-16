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
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" required>
        </div>
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
            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
            <label class="form-check-label" for="auth-remember-check">Nhớ mật khẩu</label>
        </div>

        <div class="mt-4">
            <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
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
