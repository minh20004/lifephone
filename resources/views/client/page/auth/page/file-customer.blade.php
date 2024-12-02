<style>
  .avatar-preview {
    position: relative;
    display: inline-block;
}

.delete-avatar-form {
    position: absolute;
    top: 5px;
    right: 5px;
    margin: 0;
}

.delete-avatar-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: rgba(255, 0, 0, 0.8);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.delete-avatar-btn i {
    font-size: 16px;
}

.delete-avatar-btn:hover {
    background-color: rgba(255, 0, 0, 1); /* Nền đậm hơn khi hover */
}

</style>
@extends('client/page/auth/layout/master')

@section('content_customer')
<div class="ps-lg-3 ps-xl-0">

  <div class="row align-items-center">
    
    <!-- Thông tin -------------col-12 col-lg-9----------------------------------------------------------------->
    <div class="col-12 col-lg-9">
      <!-- Page title -->
      <h1 class="h2 mb-1 mb-sm-2">Thông tin cá nhân </h1>
      
      <!-- Basic info -->
    <div class="border-bottom py-4">
      <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
        <h2 class="h6 mb-0"><li>{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</li></h2>
        <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="#" data-bs-toggle="modal" data-bs-target="#basicInfoEditModal">Chỉnh sửa</a>
      </div>
      <div class="collapse basic-info show" id="basicInfoPreview">
        <ul class="list-unstyled fs-sm m-0">
          <!-- Display customer information -->
          <li>{{ Auth::user()->gender ?? 'Giới tính chưa cập nhật' }}</li>
          <!-- Hiển thị ảnh đại diện -->
        </ul>
      </div>
    </div>
    <!-- Modal for editing basic info -->
    <div class="modal fade" id="basicInfoEditModal" tabindex="-1" aria-labelledby="basicInfoEditModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="basicInfoEditModalLabel">Chỉnh sửa thông tin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 g-sm-4 needs-validation" method="POST" action="{{ route('customer.update', Auth::user()->id) }}" enctype="multipart/form-data" novalidate>
              @csrf
              @method('PUT')

              <!-- Avatar -->
              <div class="col-12">
                <label for="avatar" class="form-label">Ảnh đại diện</label>
              <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                <!-- Hiển thị ảnh đại diện -->
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar của {{ Auth::user()->name }}" class="img-thumbnail hover-effect-target" id="current-avatar">
                @else
                    <img src="{{ asset('client/img/avtt.jpg') }}" alt="avtt" class="img-thumbnail hover-effect-target" id="current-avatar">
                @endif
                @error('avatar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

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
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Đóng">Đóng</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

      <!-- Contact -->
      <div class="border-bottom py-4">
        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
          <div class="d-flex align-items-center gap-3 me-4">
            <h2 class="h6 mb-0">Liên hệ</h2>
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


      <!-- Password Section -->
      <div class="border-bottom py-4">
        <!-- Header -->
        <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
          <div class="d-flex align-items-center gap-3 me-4">
            <h2 class="h6 mb-0">Password</h2>
          </div>
          <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" href="#passChangeEdit" data-bs-toggle="collapse" aria-expanded="false" aria-controls="passChangePreview passChangeEdit">Chỉnh sửa</a>
        </div>

        <!-- Password Preview -->
        <div class="collapse password-change show" id="passChangePreview">
          <ul class="list-unstyled fs-sm m-0">
            <li>**************</li>
          </ul>
        </div>

        <!-- Password Edit Form -->
        <div class="collapse password-change" id="passChangeEdit">
          <form class="row g-3 g-sm-4 needs-validation" method="POST" action="{{ route('customer.changePassword', Auth::user()->id) }}" novalidate>
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="col-sm-6">
              <label for="current-password" class="form-label">Current Password</label>
              <div class="password-toggle">
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current-password" name="current_password" placeholder="Enter your current password" required>
                <label class="password-toggle-button" aria-label="Show/hide password">
                  <input type="checkbox" class="btn-check">
                </label>
                @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- New Password -->
            <div class="col-sm-6">
              <label for="new-password" class="form-label">New Password</label>
              <div class="password-toggle">
                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new-password" name="new_password" placeholder="Create new password" required>
                <label class="password-toggle-button" aria-label="Show/hide password">
                  <input type="checkbox" class="btn-check">
                </label>
                @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Confirm New Password -->
            <div class="col-sm-6">
              <label for="new-password-confirmation" class="form-label">Confirm New Password</label>
              <div class="password-toggle">
                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new-password-confirmation" name="new_password_confirmation" placeholder="Confirm new password" required>
                <label class="password-toggle-button" aria-label="Show/hide password">
                  <input type="checkbox" class="btn-check">
                </label>
                @error('new_password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="col-12">
              <div class="d-flex gap-3 pt-2 pt-sm-0">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target=".password-change" aria-expanded="true" aria-controls="passChangePreview passChangeEdit">Đóng</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Ảnh đại diện------------------ col-12 col-lg-3----------------------------------------------------------------------------------------------> 
    <div class="col-12 col-lg-3 text-center">
      <div class="avatar-preview position-relative">
        <!-- Hiển thị ảnh đại diện -->
        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar của {{ Auth::user()->name }}" class="img-thumbnail hover-effect-target" id="current-avatar-02">
            
            <!-- Nút xóa ảnh -->
            <form action="{{ route('customer.deleteAvatar', Auth::id()) }}" method="POST" class="delete-avatar-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm delete-avatar-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
            </form>
        @else
            <img src="{{ asset('client/img/avtt.jpg') }}" alt="Default Avatar" class="img-thumbnail hover-effect-target" id="current-avatar-02">
        @endif
      </div>
    
      <!-- Form cập nhật ảnh -->
      <form action="{{ route('customer.updateAvatar', Auth::id()) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="col-12 mt-3">
              <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
              @error('avatar')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <label for="avatar" class="form-label text-secondary" style="text-align: right;">Dụng lượng file tối đa 1 MB Định dạng: .JPEG, .PNG</label>
          </div>

          <!-- Nút cập nhật ẩn/hiện -->
          <div id="update-button-container" class="mt-3" style="display: none; text-align: right;">
              <button type="submit" class="btn btn-dark btn-sm">Lưu</button>
          </div>
      </form>
    </div>

  </div>
</div>

<script>
  // Hàm để hiển thị ảnh người dùng chọn và hiển thị nút Cập nhật
  function previewAvatar(event) {
      const fileInput = event.target;
      const file = fileInput.files[0];
      const imagePreview = document.getElementById('current-avatar');
      const imagePreview02 = document.getElementById('current-avatar-02');
      const updateButtonContainer = document.getElementById('update-button-container');

      // Kiểm tra nếu người dùng chọn ảnh
      if (file) {
          // Tạo một URL cho ảnh đã chọn
          const reader = new FileReader();
          reader.onload = function(e) {
              // Cập nhật ảnh preview với ảnh người dùng chọn
              imagePreview.src = e.target.result;
              imagePreview02.src = e.target.result;

          };
          reader.readAsDataURL(file);

          // Hiển thị nút cập nhật
          updateButtonContainer.style.display = 'block';
      } else {
          // Nếu không chọn ảnh, ẩn nút cập nhật
          updateButtonContainer.style.display = 'none';
      }
  }
</script>
@endsection