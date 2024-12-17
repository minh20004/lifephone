<div class="layout-width">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box horizontal-logo">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="17">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="17">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                    <i class='bx bx-fullscreen fs-22'></i>
                </button>
            </div>

            <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                    <i class='bx bx-moon fs-22'></i>
                </button>
            </div>

            <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-bell fs-22'></i>
                    <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}<span class="visually-hidden">unread messages</span></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                    <div class="dropdown-head bg-primary bg-pattern rounded-top">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold text-white"> Thông báo </h6>
                                </div>
                                <div class="col-auto dropdown-tabs">
                                    <span class="badge bg-light-subtle text-body fs-13"> {{ $unreadCount }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-2 pt-2">
                            <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                {{-- <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                        Tất cả (4)
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                                        Tin nhắn
                                    </a>
                                </li> --}}
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                                        Đơn hàng <span > ({{ $unreadCount }})</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="tab-content position-relative" id="notificationItemsTabContent">
                        <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                            <div data-simplebar style="max-height: 300px;" class="p-2">
                                <div>
                                    @php
                                        use App\Models\OrderNotification;
                                        $notifications = OrderNotification::with('order')
                                            ->orderBy('created_at', 'desc')
                                            ->limit(10)
                                            ->get();
                                    @endphp
    
                                    @forelse ($notifications as $notification)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="border-bottom mb-2" >
                                                <strong>Đơn hàng: {{ $notification->order->order_code }}</strong><br>
                                                <span>{{ $notification->order->name }} đã đặt hàng.</span>
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item">Không có thông báo nào.</li>
                                    @endforelse
                                </div>
                                <div class="my-3 text-center view-all">
                                    <a href="{{route('admin.notifications')}}" class="btn btn-soft-success waves-effect waves-light">Xem tất cả Thông báo <i class="ri-arrow-right-line align-middle"></i></a>
                                </div>
                            </div>
                            <div class="my-3 text-center view-all">
                                <a href="{{route('admin.notifications')}}" class="btn btn-soft-success waves-effect waves-light">Xem tất cả Thông báo <i class="ri-arrow-right-line align-middle"></i></a>
                            </div>

                        </div>

                        <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                            <div data-simplebar style="max-height: 300px;" class="pe-2">
                                <div class="text-reset notification-item d-block dropdown-item">
                                    <div class="d-flex">
                                        <img src="{{asset('assets/images/users/avatar-3.jpg')}}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <a href="#!" class="stretched-link">
                                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                            </a>
                                            <div class="fs-13 text-muted">
                                                <p class="mb-1">We talked about a project on linkedin.</p>
                                            </div>
                                            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                <span><i class="mdi mdi-clock-outline"></i> 30 min ago</span>
                                            </p>
                                        </div>
                                        <div class="px-2 fs-15">
                                            <div class="form-check notification-check">
                                                <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                                <label class="form-check-label" for="messages-notification-check01"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-3 text-center view-all">
                                    <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                        All Messages <i class="ri-arrow-right-line align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade py-2 ps-2" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab">
                            <div data-simplebar style="max-height: 300px;" class="pe-2">
                            <div class="text-reset notification-item d-block ">
                            {{-- <div>
                                @php
                                    use App\Models\OrderNotification;
                                    $notifications = OrderNotification::with('order')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(10)
                                        ->get();
                                @endphp

                                @forelse ($notifications as $notification)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="border-bottom mb-2" >
                                            <strong>Đơn hàng: {{ $notification->order->order_code }}</strong><br>
                                            <span>{{ $notification->order->name }} đã đặt hàng.</span>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item">Không có thông báo nào.</li>
                                @endforelse
                            </div> --}}
                            {{-- <div class="my-3 text-center view-all">
                                <a href="{{route('admin.notifications')}}" class="btn btn-soft-success waves-effect waves-light">Xem tất cả Thông báo <i class="ri-arrow-right-line align-middle"></i></a>
                            </div> --}}
                            </div>
                            </div>

                        </div>

                        <div class="notification-actions" id="notification-actions">
                            <div class="d-flex text-muted justify-content-center">
                                Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown ms-sm-3 header-item topbar-user">
                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- <span class="d-flex align-items-center">
                        <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="Header Avatar">
                        <span class="text-start ms-xl-2">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Anna Adame</span>
                            <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Founder</span>
                        </span>
                    </span> --}}
                    {{-- Kiểm tra nếu người dùng là admin --}}
                    @auth
                    @if (in_array(Auth::user()->role, ['admin', 'staff']))
                        <span class="d-flex align-items-center">
                            <!-- Hiển thị ảnh avatar -->
                            @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar của {{ Auth::user()->name }}" class="header-profile-user" id="current-avatar">
                            @else
                                <img src="{{ asset('client/img/avtt.jpg') }}" alt="avtt" class="header-profile-user" id="current-avatar">
                            @endif
                            @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="text-start ms-xl-2">
                                <!-- Hiển thị tên người dùng -->
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                <!-- Hiển thị vai trò của người dùng -->
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->role }}</span>
                            </span>
                        </span>
                    @endif
                    @endauth

                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <h6 class="dropdown-header">Xin chào {{ Auth::user()->name }} !</h6>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Hồ sơ</span></a>
                    <a class="dropdown-item" href="{{ route('admin.chatBoard') }}"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Tin nhắn</span></a>
                    {{-- <a class="dropdown-item" href="{{ route('admin.home') }}"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Thống kê</span></a> --}}
                    @if(auth()->user()->role === 'admin')
                        <a class="dropdown-item" href="{{ route('admin.home') }}">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Thống kê</span>
                        </a>
                    @else
                        <a class="dropdown-item" href="{{ route('admin.staff') }}">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Thống kê</span>
                        </a>
                    @endif
                    
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a> --}}
                    {{-- <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a> --}}
                    {{-- <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a> --}}

                    <form id="logout-form" class="dropdown-item" action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <span class="align-middle" data-key="t-logout" style="cursor: pointer;" onclick="document.getElementById('logout-form').submit();">
                            Đăng xuất
                        </span>
                        <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
