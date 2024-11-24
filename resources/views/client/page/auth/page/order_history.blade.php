@extends('client/page/auth/layout/master')

@section('content_customer')
<div class="container mt-4">
  <!-- Tabs -->
  <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Tất Cả</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Chờ Xác Nhận</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Đã Xác Nhận</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Đang giao hàng</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">Hoàn Thành</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">Đã Hủy</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund" type="button" role="tab" aria-controls="refund" aria-selected="false">Trả hàng/Hoàn tiền</button>
    </li>
  </ul>

  <!-- Search Bar -->
  <div class="mb-4">
    <h5 class="fw-bold">Tìm kiếm đơn hàng bằng Mã Đơn hàng</h5>
    <input type="text" class="form-control" placeholder="Nhập mã đơn hàng...">
  </div>

  <!-- Tab Content -->
  <div class="tab-content" id="myTabContent">
    <!-- All Orders -->
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
          <span>Trạng thái: Chờ xác nhận</span>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-2">
              <img src="https://via.placeholder.com/80" alt="Product" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
              <p class="mb-1 fw-bold">Tên sản phẩm</p>
              <p class="mb-1 text-muted">Phân loại hàng: Màu sắc, Dung lượng</p>
              <p class="mb-1">Số lượng: 1</p>
            </div>
            <div class="col-md-4 text-end">
              <p class="mb-1 text-danger fw-bold">Tổng tiền: ₫830.000</p>
            </div>
          </div>
          <div class="text-end mt-3">
            <button class="btn btn-danger btn-sm">Xem Chi Tiết Đơn Hàng</button>
            <button class="btn btn-outline-danger btn-sm">Hủy Đơn Hàng</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Other Tabs -->
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">...</div>
    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">...</div>
    <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">...</div>
    <div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="refund-tab">...</div>
  </div>
</div>
@endsection
