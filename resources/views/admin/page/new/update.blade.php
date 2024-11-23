@extends('admin.layout.master')
@section('title')
Cập nhật Tin Tức
@endsection

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Cập nhật Tin Tức</h4>
            </div>
        </div>
    </div>
    <div id="updateproduct-form" autocomplete="off" class="needs-validation">

        <form action="{{ route('new_admin.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="product-title-input">Tên chính tin tức</label>
                                <input type="text" class="form-control" id="product-title-input" value="{{ old('title', $news->title) }}" name="title" placeholder="Tin tức">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="content" class="form-label text-dark">Tin tức chính:</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="description" name="content" cols="500" rows="10" placeholder="Mô tả tin tức">{{ old('content', $news->content) }}</textarea>

                                @error('content')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Hình ảnh tin tức</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="image_url" class="form-label text-dark">Hình ảnh </label>
                                    <div class="custom-file-upload">
                                        <input type="file" id="image_url" name="thumbnail" onchange="previewImage(event);" accept="image/*" />
                                        <label for="image_url" class="btn-choose">
                                            <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh
                                        </label>
                                    </div>
                                    <div id="thumbbox" style="margin-top: 10px;">
                                        <img height="100" width="100" alt="Thumb image" id="thumbimage"
                                            src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : '' }}">
                                        <a class="removeimg" href="javascript:void(0);" onclick="removeImage()"
                                        style="display: none; color:red">Xóa ảnh</a>
                                        @error('thumbnail')
                                        <div class="invalid-feeback text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Trạng thái </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="choices-publish-status-input" class="form-label">Trạng Thái</label>
                                        <select name="status" class="form-select" id="choices-publish-status-input" data-choices data-choices-search-false onchange="toggleScheduledDate()">
                                            <option value="Công khai" {{ old('status', $news->status) == 'Công khai' ? 'selected' : '' }}>Công khai</option>
                                            <option value="Đã lên lịch" {{ old('status', $news->status) == 'Đã lên lịch' ? 'selected' : '' }}>Đã lên lịch</option>
                                            <option value="Bản nháp" {{ old('status', $news->status) == 'Bản nháp' ? 'selected' : '' }}>Bản nháp</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card" id="scheduled-date-card" @if(old('status', $news->status)=='Đã lên lịch' ) style="display: block;" @else style="display: none;" @endif>
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Ngày đăng tin</h5>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <label for="datepicker-publish-input" class="form-label">Thời gian đăng bài</label>
                                        <input value="{{ old('scheduled_at', $news->scheduled_at) }}" name="scheduled_at" type="date" id="datepicker-publish-input" class="form-control" placeholder="thời gian đăng bài">
                                    </div>
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
                                <option value="{{ $item->id }}" {{ old('category_news_id', $news->category_news_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
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
                            <textarea class="form-control" placeholder="Tiêu đề ngắn để 100 chữ" name="short_content" rows="3">{{ old('short_content', $news->short_content) }}</textarea>
                            @error('short_content')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Tác giả</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2"> <a href="#" class="float-end text-decoration-underline">Tác giả tin tức</a></p>
                            <select class="form-select" id="choices-category-input" name="author_id" data-choices data-choices-search-false disabled>
                                @foreach ($author_id as $item)
                                <option value="{{ $item->id }}" {{ old('author_id', $news->author_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">slug</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">hãy viết slug</p>
                            <textarea class="form-control" placeholder="" name="slug" rows="3">{{ old('slug', $news->slug) }}</textarea>
                            @error('slug')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <div>
                        <a href="{{ route('new_admin.index') }}" class="btn btn-dark"> Quay lại</a>
                    </div>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>

    <script>
         function previewImage(event) {
            const img = document.getElementById('product-img');
            img.src = URL.createObjectURL(event.target.files[0]);
        }

        function toggleScheduledDate() {
            const statusSelect = document.getElementById('choices-publish-status-input');
            const scheduledDateCard = document.getElementById('scheduled-date-card');

            // Kiểm tra xem trạng thái có phải là "Đã lên lịch" không
            if (statusSelect.value === 'Đã lên lịch') {
                scheduledDateCard.style.display = 'block'; // Hiện phần ngày
            } else {
                scheduledDateCard.style.display = 'none'; // Ẩn phần ngày
            }
        }

        // Gọi hàm ngay khi tải trang để xác định trạng thái ban đầu
        document.addEventListener('DOMContentLoaded', toggleScheduledDate);

        function previewImage(event) {
            const img = document.getElementById('thumbimage');
            img.src = URL.createObjectURL(event.target.files[0]);
            img.style.display = 'block'; // Hiển thị ảnh khi chọn
            document.querySelector('.removeimg').style.display = 'inline'; // Hiển thị nút xóa ảnh
        }

        function removeImage() {
            const img = document.getElementById('thumbimage');
            img.src = '';
            img.style.display = 'none';
            document.getElementById('image_url').value = ''; // Xóa giá trị input file
            document.querySelector('.removeimg').style.display = 'none'; // Ẩn nút xóa ảnh
        }
        document.addEventListener('DOMContentLoaded', toggleScheduledDate);
    </script>
@endsection
