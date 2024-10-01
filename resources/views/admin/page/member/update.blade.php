@extends('admin.layout.master')
@section('title')
    Sửa Thông tin thành viên
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h3>Sửa Thông tin thành viên</h3>
        <p>Sửa Thông tin thành viên vào hệ thống.</p>
        <div class="row">
            <div class="col-sm-5">
                <form method="POST" class="needs-validation" novalidate action="{{ route('users.store') }}">
                    @csrf
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" id="useremail" placeholder="Nhập địa chỉ email" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập email
                        </div>
                    </div>
                
                    <!-- Họ và tên -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="username" placeholder="Nhập họ tên" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập họ tên
                        </div>
                    </div>
                
                    <!-- Vai trò người dùng -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò người dùng <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" id="role" required>
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
                
                    <!-- Mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label" for="password-input">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập mật khẩu
                        </div>
                    </div>
                
                    <!-- Nút đăng ký -->
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">Thêm thành viên</button>
                    </div>
                </form>
                3. Cập nhật
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
@endsection
