@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">
    <div class="container py-5 mt-n2 mt-sm-0">
      <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">


        <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
        <aside class="col-lg-3">
          <div class="offcanvas-lg offcanvas-start pe-lg-0 pe-xl-4" id="accountSidebar">

            <!-- Header -->
            <div class="offcanvas-header d-lg-block py-3 p-lg-0">
              <div class="d-flex align-items-center">
                <div class="h5 d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0" style="width: 3rem; height: 3rem">
                  {{-- {{ strtoupper(substr(Auth::guard('customer')->user()->email, 0, 1)) }} --}}
                  {{-- <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar của {{ Auth::user()->name }}" style="height: 100%;"> --}}
                </div>
                <div class="min-w-0 ps-3">
                  <h5 class="h6 mb-1">{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</li></h5>
                  <div class="nav flex-nowrap text-nowrap min-w-0">
                    <a class="nav-link animate-underline text-body p-0" href="{{ route('customer.file') }}">
                      
                      <span class="text-body fw-normal text-truncate"><i class="fa-solid fa-pen"></i> Sửa hồ sơ</span>
                    </a>
                  </div>
                </div>
              </div>
              <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#accountSidebar" aria-label="Close"></button>
            </div>
            <!-- Body (Navigation) -->
            <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
              <nav class="list-group list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center  " href="{{route('order.history')}}">
                  <i class="ci-shopping-bag fs-base opacity-75 me-2"></i>
                  Đơn hàng
                  <span class="badge bg-primary rounded-pill ms-auto">1</span>
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="">
                  <i class="ci-heart fs-base opacity-75 me-2"></i>
                  Sản phẩm yêu thích
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-payment.html">
                  <i class="ci-credit-card fs-base opacity-75 me-2"></i>
                  Phương thức thanh toán
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-reviews.html">
                  <i class="ci-star fs-base opacity-75 me-2"></i>
                  Dánh giá của tôi
                </a>
              </nav>
              <h6 class="pt-4 ps-2 ms-1">Quản lý tài khoản</h6>
              <nav class="list-group list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="{{ route('customer.file') }}"><i class="ci-user fs-base opacity-75 me-2"></i>
                  Thông tin cá nhân
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="{{ route('customer.adress') }}">
                  <i class="ci-map-pin fs-base opacity-75 me-2"></i>
                  Địa chỉ
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-notifications.html">
                  <i class="ci-bell fs-base opacity-75 mt-1 me-2"></i>
                  Thông báo
                </a>
              </nav>
              
              <nav class="list-group list-group-borderless pt-3">
                <form action="{{ route('customer.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <a class="list-group-item list-group-item-action d-flex align-items-center" href="javascript:void(0);" onclick="this.closest('form').submit();">
                        <i class="ci-log-out fs-base opacity-75 me-2"></i>
                        Đăng xuất
                    </a>
                </form>
            </nav>
            
            </div>
          </div>
        </aside>


        <!-- Orders content -->
        <div class="col-lg-9">
          @yield('content_customer')
        </div>
      </div>
    </div>
  </main>
@endsection