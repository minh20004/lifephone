@extends('admin.layout.master')
@section('title')

REVIEW

@endsection
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Quản lý đơn hàng</h4>
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
                                                            <th data-column-id="product" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">STT</div>
                                                            </th>
                                                            <th data-column-id="product" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">Order_ID</div>
                                                            </th>
                                                            <th data-column-id="user" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">Product_ID</div>
                                                            </th>
                                                            <th data-column-id="comment" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">variant_id </div>
                                                            </th>
                                                            <th data-column-id="rating" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">quantity</div>
                                                            </th>
                                                            <th data-column-id="action" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">price</div>
                                                            </th>
                                                            <th data-column-id="action" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">Status</div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="gridjs-tbody">
    @foreach ($listOrderItem as $key => $order)
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
                            <a href="apps-ecommerce-product-details.html" class="text-body">{{$order->order_id}}</a>
                        </h5>
                    </div>
                </div>
            </span>
        </td>
        <td data-column-id="products" class="gridjs-td">{{$order->product_id}}</td>
        <td data-column-id="variant" class="gridjs-td">{{$order->variant_id}}</td>
        {{-- <td data-column-id="rating" class="gridjs-td"> --}}
            <span>
                <span class="badge bg-light text-body fs-12 fw-medium">
                    <i class="mdi mdi-star text-warning me-1"></i>{{$order->quantity}}
                </span>
            </span>
        </td>
        <td data-column-id="quantity" class="gridjs-td">
            <span>{{$order->quantity}}</span>
        </td>
        <td data-column-id="price" class="gridjs-td">
            <span>{{$order->price}}</span>
        </td>
        <td data-column-id="status" class="gridjs-td">
            <div>
                {{-- <form action="{{route('review.destroy',$order->id)}}" method="post">
                    @method('DELETE')
                    @csrf
                    <button onclick="return confirm('xoa')">
                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                    </button>
                </form> --}}

                <a href="" class="btn btn-danger">Xem</a>
                <a href="" class="btn btn-warning">Sửa</a>
                <a href="" class="btn btn-info">Hủy</a>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>

                                            </table>
                                        </div>
                                        <div class="gridjs-footer">
                                            <div class="gridjs-pagination">
                                                <div role="status" aria-live="polite" class="gridjs-summary" title="Page 1 of 2">Showing <b>1</b> to <b>10</b> of <b>12</b> results</div>
                                                <div class="gridjs-pages"><button tabindex="0" role="button" disabled="" title="Previous" aria-label="Previous" class="">Previous</button><button tabindex="0" role="button" class="gridjs-currentPage" title="Page 1" aria-label="Page 1">1</button><button tabindex="0" role="button" class="" title="Page 2" aria-label="Page 2">2</button><button tabindex="0" role="button" title="Next" aria-label="Next" class="">Next</button></div>
                                            </div>
                                        </div>
                                        <div id="gridjs-temp" class="gridjs-temp"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane" id="productnav-draft" role="tabpanel">
                                <div class="py-4 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px">
                                    </lord-icon>
                                    <h5 class="mt-4">Sorry! No Result Found</h5>
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->

                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end col -->
    </div>
</div>
</div>
@endsection