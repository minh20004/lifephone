@extends('admin.layout.master')
@section('title')
profile
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="profile-foreground position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg">
                {{-- <img src="assets/images/profile-bg.jpg" alt="" class="profile-wid-img" /> --}}
            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
            <div class="row g-4">
                <div class="col-auto">
                    <div class="avatar-lg">
                        {{-- <img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-thumbnail rounded-circle" /> --}}
                        <!-- Hiển thị ảnh đại diện -->
                        @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar của {{ Auth::user()->name }}" class="img-thumbnail rounded-circle" id="current-avatar">
                        @else
                            <img src="{{ asset('client/img/avtt.jpg') }}" alt="avtt" class="img-thumbnail rounded-circle" id="current-avatar">
                        @endif
                        @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                    </div>
                </div>
                <!--end col-->
                <div class="col">
                    <div class="p-2">
                        <h3 class="text-white mb-1">{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</h3>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="d-flex profile-wrapper">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Hồ sơ của bạn</span>
                                </a>
                            </li>
                        </ul>
                        <div class="flex-shrink-0">
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="ri-edit-box-line align-bottom"></i> Chỉnh sửa hồ sơ
                            </a>
                        </div>

                        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalLabel">Chỉnh sửa hồ sơ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editProfileForm" method="POST" enctype="multipart/form-data" action="{{ route('profile.update') }}">
                                            @csrf
                                            @method('PUT')
                        
                                            <!-- Tên -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Họ và Tên</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                                            </div>
                        
                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                                            </div>
                        
                                            <!-- Avatar -->
                                            <div class="mb-3">
                                                <label for="avatar" class="form-label">Ảnh đại diện</label>
                                                <input type="file" class="form-control" id="avatar" name="avatar">
                                            </div>
                        
                                            <!-- Nút Lưu -->
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content pt-4 text-muted">
                        <div class="tab-pane active" id="overview-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-xxl-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-5">Hoàn thiện hồ sơ của bạn</h5>
                                            <div class="progress animated-progress custom-progress progress-label">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="label">100%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Thông tin của bạn</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="ps-0" scope="row">Họ và tên :</th>
                                                            <td class="text-muted">{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">ảnh :</th>
                                                            <td class="text-muted">
                                                                @if(Auth::user()->avatar)
                                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar của {{ Auth::user()->name }}" class="img-thumbnail" id="current-avatar" style="width: 60px;">
                                                                @else
                                                                    <img src="{{ asset('client/img/avtt.jpg') }}" alt="avtt" class="img-thumbnail" id="current-avatar" style="width: 60px;">
                                                                @endif
                                                                @error('avatar')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">E-mail :</th>
                                                            <td class="text-muted">{{ Auth::user()->email ?? 'Tên chưa được cập nhật' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">Ngày tạo</th>
                                                            <td class="text-muted">{{ Auth::user()->created_at ?? 'Tên chưa được cập nhật' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->

                                </div>
                                <!--end col-->
                                <div class="col-xxl-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">About</h5>
                                            <p>Hi I'm Anna Adame, It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is European languages are members of the same family.</p>
                                            <p>You always want to make sure that your fonts work well together and try to limit the number of fonts you use to three or less. Experiment and play around with the fonts that you already have in the software you’re working with reputable font websites. This may be the most commonly encountered tip I received from the designers I spoke with. They highly encourage that you use different fonts in one design, but do not over-exaggerate and go overboard.</p>
                                            <div class="row">
                                                <div class="col-6 col-md-4">
                                                    <div class="d-flex mt-4">
                                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                <i class="ri-user-2-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="mb-1">Designation :</p>
                                                            <h6 class="text-truncate mb-0">Lead Designer / Developer</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-6 col-md-4">
                                                    <div class="d-flex mt-4">
                                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                <i class="ri-global-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="mb-1">Website :</p>
                                                            <a href="#" class="fw-semibold">www.Lifephone.com</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-body-->
                                    </div><!-- end card -->

                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end tab-pane-->
                    </div>
                    <!--end tab-content-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div><!-- container-fluid -->
</div>
@endsection
