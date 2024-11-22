@extends('client/page/auth/layout/master')

@section('content_customer')
  <div class="ps-lg-3 ps-xl-0">

    <!-- Page title -->
    <h1 class="h2 mb-1 mb-sm-2">Thông tin cá nhân</h1>
    {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}
    <!-- Basic info -->
    <div class="border-bottom py-4">
      <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
        <h2 class="h6 mb-0"><li>{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</li></h2>
        <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="#basicInfoEdit" data-bs-toggle="collapse" aria-expanded="false" aria-controls="basicInfoPreview basicInfoEdit">Edit</a>
      </div>
      <div class="collapse basic-info show" id="basicInfoPreview">
        <ul class="list-unstyled fs-sm m-0">
          <!-- Display customer information -->
          <li>{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</li>
          <li>{{ Auth::user()->gender ?? 'Giới tính chưa cập nhật' }}</li>
          <li>{{ Auth::user()->phone ?? 'Số điện thoại chưa cập nhật' }}</li>
          <li>{{ Auth::user()->address ?? 'Địa chỉ Chưa cập nhật' }}</li>
        </ul>
      </div>
      <div class="collapse basic-info" id="basicInfoEdit">

      <form class="row g-3 g-sm-4 needs-validation" method="POST" action="{{ route('customer.update', Auth::user()->id) }}" novalidate>
          @csrf
          @method('PUT') <!-- Xác định phương thức PUT -->
          <!-- Avatar -->
          {{-- <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" id="avatar" name="avatar">
            <!-- Hiển thị ảnh hiện tại nếu có -->
            @if($customer->avatar)
                <div class="mt-2">
                    <img src="{{ Storage::url($customer->avatar) }}" alt="Avatar" class="img-thumbnail" width="150">
                </div>
            @endif
          </div> --}}
          <!-- Name -->
          <div class="col-sm-6">
              <label for="name" class="form-label">Tên</label>
              <div class="position-relative">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                  @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>

          <!-- Phone number -->
          <div class="col-sm-6">
              <label for="phone" class="form-label">Số điện thoại</label>
              <div class="position-relative">
                  <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                  @error('phone')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>

          <!-- Address -->
          <div class="col-sm-6">
              <label for="address" class="form-label">Địa chỉ</label>
              <div class="position-relative">
                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', Auth::user()->address) }}" required>
                  @error('address')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>

          <!-- Gender -->
          <div class="col-sm-6">
              <label for="gender" class="form-label">Giới tính</label>
              <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                  <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                  <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                  <option value="other" {{ old('gender', Auth::user()->gender) == 'other' ? 'selected' : '' }}>Khác</option>
              </select>
              @error('gender')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          <div class="col-12">
              <div class="d-flex gap-3 pt-2 pt-sm-0">
                  <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                  <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target=".basic-info" aria-expanded="true" aria-controls="basicInfoPreview basicInfoEdit">Đóng</button>
              </div>
          </div>
      </form>

      </div>
    </div>

    <!-- Contact -->
    <div class="border-bottom py-4">
      <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
        <div class="d-flex align-items-center gap-3 me-4">
          <h2 class="h6 mb-0">Liên hệ</h2>
           @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
        </div>
        <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="#contactInfoEdit" data-bs-toggle="collapse" aria-expanded="false" aria-controls="contactInfoPreview contactInfoEdit">Chỉnh sửa</a>
      </div>

      <!-- Contact Info Preview -->
      <div class="collapse contact-info show" id="contactInfoPreview">
        <ul class="list-unstyled fs-sm m-0">
          <li class="mb-1">{{ Auth::user()->email }} <span class="text-success ms-1">Đã xác nhận</span></li>
          <li>{{ Auth::user()->phone ?? 'Số điện thoại chưa cập nhật' }}</li>
        </ul>
      </div>

      <!-- Contact Info Edit Form -->
      <div class="collapse contact-info" id="contactInfoEdit">
        <form class="row g-3 g-sm-4 needs-validation" method="POST" action="{{ route('customer.updateContact', Auth::user()->id) }}" novalidate>
          @csrf
          @method('PUT')
          
          <!-- Email Address -->
          <div class="col-sm-6">
            <label for="email" class="form-label">Địa chỉ email</label>
            <div class="position-relative">
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
              <div class="invalid-feedback">Vui lòng nhập địa chỉ email hợp lệ!</div>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Phone Number -->
          <div class="col-sm-6">
            <label for="phone" class="form-label">Số điện thoại</label>
            <div class="position-relative">
              <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
              <div class="invalid-feedback">Vui lòng nhập số điện thoại của bạn!</div>
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-12">
            <div class="d-flex gap-3 pt-2 pt-sm-0">
              <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
              <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target=".contact-info" aria-expanded="true" aria-controls="contactInfoPreview contactInfoEdit">Đóng</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <!-- Password -->
    <div class="border-bottom py-4">
      <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
        <div class="d-flex align-items-center gap-3 me-4">
          <h2 class="h6 mb-0">Password</h2>
        </div>
        <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="-6.html" data-bs-toggle="collapse" aria-expanded="false" aria-controls="passChangePreview passChangeEdit">Edit</a>
      </div>
      <div class="collapse password-change show" id="passChangePreview">
        <ul class="list-unstyled fs-sm m-0">
          <li>**************</li>
        </ul>
      </div>
      <div class="collapse password-change" id="passChangeEdit">
        <form class="row g-3 g-sm-4 needs-validation" novalidate="">
          <div class="col-sm-6">
            <label for="current-password" class="form-label">Current password</label>
            <div class="password-toggle">
              <input type="password" class="form-control" id="current-password" placeholder="Enter your current password" required="">
              <label class="password-toggle-button" aria-label="Show/hide password">
                <input type="checkbox" class="btn-check">
              </label>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="new-password" class="form-label">New password</label>
            <div class="password-toggle">
              <input type="password" class="form-control" id="new-password" placeholder="Create new password" required="">
              <label class="password-toggle-button" aria-label="Show/hide password">
                <input type="checkbox" class="btn-check">
              </label>
            </div>
          </div>
          <div class="col-12">
            <div class="d-flex gap-3 pt-2 pt-sm-0">
              <button type="submit" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target=".password-change" aria-expanded="true" aria-controls="passChangePreview passChangeEdit">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete account -->
    <div class="pt-3 mt-2 mt-sm-3">
      <h2 class="h6">Delete account</h2>
      <p class="fs-sm">Khi bạn xóa tài khoản của mình, hồ sơ công khai của bạn sẽ bị vô hiệu hóa ngay lập tức. Nếu bạn thay đổi ý định trước khi hết 14 ngày, 
        hãy đăng nhập bằng email và mật khẩu của bạn và chúng tôi sẽ gửi cho bạn liên kết để kích hoạt lại tài khoản của bạn.</p>
      <a class="text-danger fs-sm fw-medium" href="#!">Delete account</a>
    </div>
  </div>
@endsection