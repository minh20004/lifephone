@extends('admin.layout.master')
@section('title')
Thêm Tin Tức
@endsection

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Thêm Tin Tức</h4>
            </div>
        </div>
    </div>
    <div id="createproduct-form" autocomplete="off" class="needs-validation">
        <form action="{{ route('new.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Tên chính tin tức</label>
                                <input type="hidden" class="form-control" id="formAction" value="add">
                                <input type="text" class="form-control" id="product-title-input" value="{{ old('title') }}" name="title" placeholder="Tin tức">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label> Tin tức </label>
                                <textarea id="editor" class="form-control" placeholder=" " rows="3" name="content">{{ old('content') }}</textarea>
                                @error('content')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <input name="thumbnail" class="form-control d-none" id="product-image-input" type="file" accept="image/png, image/gif, image/jpeg" onchange="previewImage(event)">
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

                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Trạng   </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label">Trạng Thái</label>
                                <select name="status" class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false>
                                    <option value="Công khai" {{ old('status') == 'Công khai' ? 'selected' : '' }}>Công khai</option>
                                    <option value="Đã lên lịch" {{ old('status') == 'Đã lên lịch' ? 'selected' : '' }}>Đã lên lịch</option>
                                    <option value="Bản nháp" {{ old('status') == 'Bản nháp' ? 'selected' : 'selected' }}>Bản nháp</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ngày đăng tin</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <label for="datepicker-publish-input" class="form-label">Thời gian đăng bài</label>
                                <input value="{{ old('published_at') }}" name="published_at" type="date" id="datepicker-publish-input" class="form-control" placeholder="thời gian đăng bài">
                                @error('published_at')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Người đăng</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Người đăng</a></p>
                            <select class="form-select" id="choices-category-input" name="author_id" data-choices data-choices-search-false>
                                @foreach ($author_id as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh mục tin tức</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Danh mục tin tức</a>Hãy chọn danh mục tin tức của bạn</p>
                        <select class="form-select" id="choices-category-input" name="category_news_id" data-choices data-choices-search-false>
                            @foreach ($category_news as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Bài viết ngắn</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">Hãy viết bài viết ngắn của bạn</p>
                        <textarea class="form-control" placeholder="Tiêu đề ngắn để 100 chữ" name="short_content" rows="3">{{ old('short_content') }}</textarea>
                        @error('short_content')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Đăng tin tức</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const img = document.getElementById('product-img');
        img.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection
