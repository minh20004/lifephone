@extends('admin.layout.master')
@section('title')
    Thành viên
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1"></div>
            <div class="mt-3 mt-lg-0">
                <form action="javascript:void(0);">
                    <div class="row g-3 mb-0 align-items-center">
                        <div class="col-sm-auto">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" data-default-date="01 Jan 2022 to 31 Jan 2022">
                                <div class="input-group-text bg-primary border-primary text-white">
                                    <i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Thành viên</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm">
                        <i class="ri-file-list-3-line align-middle"></i> Generate Report
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">Tên người dùng</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Vai trò</th>
                                <th scope="col">Bài viết</th>
                                <th scope="col">Trạng thái 2FA</th>
                                <th scope="col">Sắp xếp tăng dần</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    {{-- <td>
                                        <a href="{{ route('users.show', $user->id) }}" class="fw-medium link-primary">{{ $user->id }}</a>
                                    </td> --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <img src="{{ asset('assets/images/users/avatar-' . $user->avatar) }}" alt="" class="avatar-xs rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->posts_count }}</td>
                                    <td>
                                        <span class="badge {{ $user->two_factor_enabled ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                            {{ $user->two_factor_enabled ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}
                                        </span>
                                    </td>
                                    <td>
                                        <h5 class="fs-14 fw-medium mb-0">{{ $user->rating }}<span class="text-muted fs-11 ms-1">({{ $user->votes }} votes)</span></h5>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- .card-->

    </div>
</div>
@endsection
