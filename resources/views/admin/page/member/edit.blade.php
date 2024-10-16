@extends('admin.layout.master')
@section('title')
    Sửa Thông tin thành viên
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h3>Sửa Thông tin thành viên</h3>
        <p>Sửa Thông tin thành viên vào hệ thống.</p>
        <div class="row">
            <div class="col-sm-5">
                <form method="POST" class="needs-validation" novalidate action="{{ route('admins.update', $user->id) }}" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" id="useremail" value="{{ old('email', $user->email) }}" placeholder="Nhập địa chỉ email" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập email
                        </div>
                    </div>
                
                    <!-- Họ và tên -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="username" value="{{ old('name', $user->name) }}" placeholder="Nhập họ tên" required >
                        <div class="invalid-feedback">
                            Vui lòng nhập họ tên
                        </div>
                    </div>
                
                    <!-- Vai trò người dùng -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò người dùng <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Quản trị</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Nhân viên</option>
                            <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Khách hàng</option>
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
                    <!-- Nút cập nhật -->
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">Cập nhật thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
@endsection