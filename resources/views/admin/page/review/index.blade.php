
@extends('admin.layout.master')
@section('title')

REVIEW

@endsection
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">REVIEW</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-8">
                <div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div id="selection-element">
                                        <div class="my-n1 d-flex align-items-center text-muted">
                                            Select <div id="select-content" class="text-body fw-semibold px-1"></div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3 material-shadow-none" data-bs-toggle="modal" data-bs-target="#removeItemModal">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="productnav-all" role="tabpanel">
                                    <div id="table-product-list-all" class="table-card gridjs-border-none">
                                        <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                                            <div class="gridjs-wrapper" style="height: auto;">
                                                <table role="grid" class="gridjs-table" style="height: auto;">
                                                    <thead class="gridjs-thead">
                                                        <tr class="gridjs-tr">
                                                            <th data-column-id="#" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 40px;">
                                                                <div class="gridjs-th-content">#</div>
                                                            </th>
                                                            <th data-column-id="product" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 94px;">
                                                                <div class="gridjs-th-content">STT</div>
                                                            </th>
                                                            <th data-column-id="product" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 300;">
                                                                <div class="gridjs-th-content">Sản phẩm</div>
                                                            </th>
                                                            <th data-column-id="user" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 105px;">
                                                                <div class="gridjs-th-content">Khách hàng</div>
                                                            </th>
                                                            <th data-column-id="comment" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 360px;">
                                                                <div class="gridjs-th-content">Bình luận</div>
                                                            </th>
                                                            <th data-column-id="rating" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 105px;">
                                                                <div class="gridjs-th-content">Đánh giá </div>
                                                            </th>
                                                            <th data-column-id="action" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 140px;">
                                                                <div class="gridjs-th-content">Ngày gửi</div>
                                                            <th data-column-id="action" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 80px;">
                                                                <div class="gridjs-th-content">Hành động</div>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="gridjs-tbody">
                                                        @foreach ($listReview as $key => $review)
                                                        <tr class="gridjs-tr">
                                                            <td data-column-id="#" class="gridjs-td">
                                                                <span>
                                                                    <div class="form-check checkbox-product-list">
                                                                        <input class="form-check-input" type="checkbox" value="3" id="checkbox-3">
                                                                        <label class="form-check-label" for="checkbox-3"></label>
                                                                    </div>
                                                                </span>
                                                            </td>
                                                            <td data-column-id="STT" class="gridjs-td">{{$key+1}}</td>
                                                            <td data-column-id="product" class="gridjs-td">
                                                                <span>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="fs-14 mb-1">
                                                                                <a href="{{ url('product/' . $review->loadAllProduct->id) }}" class="text-body" target="_blank">{{$review->loadAllProduct->name}}</a>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </td>
                                                            <td data-column-id="user" class="gridjs-td">{{$review->loadAllCustomer->name}}</td>
                                                            <td data-column-id="orders" class="gridjs-td">{{$review->comment}}</td>
                                                            <td data-column-id="rating" class="gridjs-td">
                                                                <span>
                                                                    <span class="badge bg-light text-body fs-12 fw-medium">
                                                                        <i class="mdi mdi-star text-warning me-1"></i>{{$review->rating}}
                                                                    </span>
                                                                </span>
                                                            </td>
                                                            <td data-column-id="published" class="gridjs-td">
                                                                <span>{{$review->created_at}}</span>
                                                            </td>
                                                            <td data-column-id="action" class="gridjs-td">
                                                                <div>
                                                                  
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                            <div>
                                                {{ $listReview->links() }}
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
 