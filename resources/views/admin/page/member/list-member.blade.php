@extends('admin.layout.master')
@section('title')
    Thành viên
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <!--end col-->
                <div class="col-auto">
                    <a href="{{ route('admin.them-thanh-vien') }}" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Thêm mới</a>
                </div>
            </div>
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
                                <th scope="col">Email</th>
                                <th scope="col">Vai trò</th>
                                {{-- <th scope="col">Bài viết</th> --}}
                                {{-- <th scope="col">Trạng thái 2FA</th> --}}
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    {{-- <td>
                                        <a href="{{ route('users.show', $user->id) }}" class="fw-medium link-primary">{{ $user->id }}</a>
                                    </td> --}}
                                    <td class="gridjs-td">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                {{-- <img src="{{ asset('storage/' . $user->avatar) }}" alt=""  width="70px" height="70px"> --}}
                                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('client/img/avtt.jpg') }}" alt="User Avatar" class="rounded" width="60px" height="60px">
                                            </div>
                                            <div class="flex-grow-1">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="gridjs-td">{{ $user->email }}</td>
                                    <td class="gridjs-td">{{ $user->role }}</td>
                                    {{-- <td class="gridjs-td">{{ $user->posts_count }}</td> --}}
                                    {{-- <td class="gridjs-td">
                                        <span class="badge {{ $user->two_factor_enabled ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                            {{ $user->two_factor_enabled ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}
                                        </span>
                                    </td> --}}
                                    <td class="gridjs-td">
                                        <div class="d-flex justify-content-center">
                                            {{-- Chỉ hiển thị nút xóa nếu role không phải là admin --}}
                                            @if($user->role !== 'admin')
                                            <form action="{{route('admins.destroy', $user)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('xác nhận xóa!')" class="btn btn-dark btn-sm me-2"> 
                                                    <i class="fa-solid fa-delete-left"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>{{ $users->links() }}
        </div> <!-- .card-->

    </div>
</div>
@endsection
