@extends('admin.layout.master')
@section('title')
    Thêm mới thành viên
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h3>Thêm người dùng mới</h3>
        <p>Tạo một người sử dụng mới và thêm vào hệ thống.</p>
        <div class="row">
            <div class="col-sm-5">
                <form method="POST" class="needs-validation" novalidate action="{{ route('admins.store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" id="useremail" placeholder="Nhập địa chỉ email" value="{{ old('email') }}" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập email
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Họ và tên -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="username" placeholder="Nhập họ tên" value="{{ old('name') }}" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập họ tên
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Vai trò người dùng -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò người dùng <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="">Chọn vai trò</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                        </select>
                        <div class="invalid-feedback">
                            Vui lòng chọn vai trò người dùng.
                        </div>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Ảnh đại diện -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*">
                        <div class="invalid-feedback">
                            Vui lòng chọn một tệp ảnh hợp lệ.
                        </div>
                        @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label" for="password-input">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập mật khẩu
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Xác nhận mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label" for="password-confirm">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>
                        <div class="invalid-feedback">
                            Vui lòng xác nhận mật khẩu
                        </div>
                    </div>

                    <!-- Nút đăng ký -->
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">Thêm thành viên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
@endsection
