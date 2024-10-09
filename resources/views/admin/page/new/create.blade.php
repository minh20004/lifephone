@extends('admin.layout.master')
@section('title')

Thêm Tin Tức

@endsection
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Thêm Tin Tức</h4>
            </div>
        </div>
    </div>
    <div id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
    <form action="{{route('new.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Tên chính tin tức</label>
                            <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                            <input type="text" class="form-control d-none" id="product-id-input">
                            <input type="text" class="form-control" id="product-title-input" value="" name="title" placeholder="Tin tức" required>
                        </div>
                        <div>
                            <label>Mô tả dài tin tức </label>
                            <input type="text" class="form-control d-none" id="product-id-input">
                            <textarea class="form-control" placeholder="Tiêu đề ngắn để 100 chữ  " name="content" rows="3"></textarea>    
                            <!-- <div id="ckeditor-classic"> -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Hình ảnh tin tức</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="fs-14 mb-1">Hình ảnh tin tức</h5>
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute top-100 start-100 translate-middle">
                                        <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Chọn ảnh">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" value="" id="product-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                    </div>
                                    <div class="avatar-lg">
                                        <div class="avatar-title bg-light rounded">
                                            <img src="" id="product-img" class="avatar-md h-auto" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="card">
                    <div class="">
                    </div>
                    <div class="">
                        <div class="tab-pane" id="" role="">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">Trạng Thái</label>

                            <select class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                                <option value="Published" selected>Đã xuất bản</option>
                                <option value="Scheduled">Đã lên lịch</option>
                                <option value="Draft">Bản nháp</option>
                            </select>
                        </div>

                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ngày đăng tin</h5>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <label for="datepicker-publish-input" class="form-label">Thời gian đăng bài</label>
                            <input type="text" id="datepicker-publish-input" class="form-control" placeholder="thời gian đăng bài" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh mục tin tức</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Danh mục tin tức</a>Hãy chọn danh mục tin tức của bạn</p>
                        <select class="form-select" id="choices-category-input" name="choices-category-input" data-choices data-choices-search-false>
                            <option value="Grocery">Grocery</option>
                            <option value="Kids">Kids</option>
                            <option value="Watches">Watches</option>
                        </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tiêu đề ngắn</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">Hãy viết tiêu đề ngắn của bạn</p>
                        <textarea class="form-control" placeholder="Tiêu đề ngắn để 100 chữ  " name="short_content" rows="3"></textarea>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Đăng tin tức</button>
                </div>
        </form>

    </div>
    
    <!-- container-fluid -->
</div>
<!-- End Page-content -->


@endsection