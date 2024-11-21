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
                <div class="h5 d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0" style="width: 3rem; height: 3rem">S</div>
                <div class="min-w-0 ps-3">
                  <h5 class="h6 mb-1">Tên tài khoản</h5>
                  <div class="nav flex-nowrap text-nowrap min-w-0">
                    <a class="nav-link animate-underline text-body p-0" href="#bonusesModal" data-bs-toggle="modal">
                      
                      <span class="text-body fw-normal text-truncate">Sửa hồ sơ</span>
                    </a>
                  </div>
                </div>
              </div>
              <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#accountSidebar" aria-label="Close"></button>
            </div>

            <!-- Body (Navigation) -->
            <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
              <nav class="list-group list-group-borderless">
                <a class="list-group-item list-group-item-action d-flex align-items-center pe-none active" href="account-orders.html">
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
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-info.html">/-strong/-heart:>:o:-((:-h <i class="ci-user fs-base opacity-75 me-2"></i>
                  Thông tin cá nhân
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-addresses.html">
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
          <div class="ps-lg-3 ps-xl-0">

            <!-- Page title + Sorting selects -->
            <div class="row align-items-center pb-3 pb-md-4 mb-md-1 mb-lg-2">
              <div class="col-md-4 col-xl-6 mb-3 mb-md-0">
                <h1 class="h2 me-3 mb-0">Đơn Hàng</h1>
              </div>
              
            </div>


            <!-- Sortable orders table -->
            <div data-filter-list="{&quot;listClass&quot;: &quot;orders-list&quot;, &quot;sortClass&quot;: &quot;orders-sort&quot;, &quot;valueNames&quot;: [&quot;date&quot;, &quot;total&quot;]}">
              <table class="table align-middle fs-sm text-nowrap">
                <thead>
                  <tr>
                    <th scope="col" class="py-3 ps-0">
                      <span class="text-body fw-normal">Mã đơn hàng <span class="d-none d-md-inline">#</span></span>
                    </th>
                    <th scope="col" class="py-3 d-none d-md-table-cell">
                      <button type="button" class="btn orders-sort fw-normal text-body p-0" data-sort="date">Ngày đặt hàng</button>
                    </th>
                    <th scope="col" class="py-3 d-none d-md-table-cell">
                      <span class="text-body fw-normal">Chờ xác nhận</span>
                    </th>
                    <th scope="col" class="py-3 d-none d-md-table-cell">
                      <button type="button" class="btn orders-sort fw-normal text-body p-0" data-sort="total">Tổng tiền thanh toán</button>
                    </th>
                    <th scope="col" class="py-3">Xem Chi Tiết Đơn Hàng</th>
                  </tr>
                </thead>
                <tbody class="text-body-emphasis orders-list">

                  <!-- Item -->
                  <tr>
                    <td class="fw-medium pt-2 pb-3 py-md-2 ps-0">/-strong/-heart:>:o:-((:-h <a class="d-inline-block animate-underline text-body-emphasis text-decoration-none py-2" href="#orderDetails" >
                        <span class="animate-target">78A6431D409</span>
                      </a>
                      
                    </td>
                    <td class="fw-medium py-3 d-none d-md-table-cell">
                      20/11/2024
                      <span class="date d-none">25-02-06</span>
                    </td>
                    <td class="fw-medium py-3 d-none d-md-table-cell">
                      <span class="d-flex align-items-center">
                        <span class="bg-info rounded-circle p-1 me-2"></span>
                        Trạng thái
                      </span>
                    </td>
                    <td class="fw-medium py-3 d-none d-md-table-cell">
                      5.000.000 đ
                      <span class="total d-none">210590</span>
                    </td>
                    <td class="py-3 pe-0">
                      <span class="d-flex align-items-center justify-content-end position-relative gap-1 gap-sm-2 ms-n2 ms-sm-0">
                        <span><img src="{{asset('client/img/shop/electronics/thumbs/20.png')}}" width="64" alt="Thumbnail"></span>
                        
                        <a class="btn btn-icon btn-ghost btn-secondary stretched-link border-0" href="#orderDetails" >
                          <i class="ci-chevron-right fs-lg"></i>
                        </a>
                      </span>
                    </td>
                  </tr>

                  
                </tbody>
              </table>
            </div>


            <!-- Pagination -->
            <nav class="pt-3 pb-2 pb-sm-0 mt-2 mt-md-3" aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item active" aria-current="page">
                  <span class="page-link">
                    1
                    <span class="visually-hidden">(current)</span>
                  </span>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">4</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection