{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card ">
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Tạo mới sản phẩm</h2>

                <div class="card-body">
                    {{-- thêm danh mục modal --}}
                    <div class="d-flex" style=" border-bottom: 1px solid #ddd; padding-bottom: 10px;margin-bottom: 10px;">
                            <div class="me-3 mb-3">
                                <button type="button" class="btn btn-sm fs-6 fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#adddanhmuc" style="background:#9df99d ">
                                    <i class="fas fa-folder-plus"></i> Thêm danh mục
                                </button>
                            </div>
                            <div class="me-3 mb-3">
                                <button type="button" class="btn btn-sm fs-6 fw-bold" data-bs-toggle="modal" data-bs-target="#addMausacModal" style="background:#9df99d">
                                    <i class="fas fa-palette"></i> Thêm màu sắc
                                </button>
                            </div>
                            <div class="me-3 mb-3">
                                <button type="button" class="btn btn-sm fs-6 fw-bold" data-bs-toggle="modal" data-bs-target="#addDungluongModal" style="background:#9df99d">
                                    <i class="fas fa-hdd"></i> Thêm dung lượng
                                </button>
                            </div>
                    </div>
                    
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="product_code" class="form-label text-dark fw-bold fs-5">Mã sản phẩm</label>
                                <input type="text" class="form-control  @error('product_code') is-invalid @enderror"
                                    id="product_code" name="product_code" placeholder="Nhập mã sản phẩm">
                                @error('product_code')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="name" class="form-label text-dark fw-bold fs-5">Tên sản phẩm</label>
                                <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Nhập tên sản phẩm">
                                @error('name')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="category" class="form-label text-dark fw-bold fs-5">Danh mục</label>
                                <select name="category_id" id="category"
                                    class="form-select @error('category_id') is-invalid @enderror">
                                    <option disabled selected>Chọn danh mục</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 mt-3 ">
                                <label for="image_url" class="form-label text-dark fw-bold fs-5 mb-3">Hình ảnh sản phẩm</label>
                                <div class="custom-file-upload">
                                    <input type="file" id="image_url" name="image_url" onchange="readURL(this);"
                                        accept="image/*" />
                                    <label for="image_url" class="btn-choose">
                                        <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh
                                    </label>
                                </div>
                                <div id="thumbbox" style="margin-top: 10px;">
                                    <img height="100" width="100" alt="Thumb image" id="thumbimage"
                                        style="display: none" />
                                    <a class="removeimg" href="javascript:void(0);" onclick="removeImage()"
                                        style="display: none; color:red">Xóa ảnh</a>
                                    @error('image_url')
                                        <div class="invalid-feeback text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3 mt-3">
                                <label for="gallery_image" class="form-label text-dark fw-bold fs-5 mb-3">Ảnh phụ sản
                                    phẩm</label>
                                <div class="d-flex align-items-start"> 
                                    <div id="image_preview" class="d-flex flex-wrap mt-3 me-3"></div>
                                    <div class="gallery-upload" onclick="document.getElementById('gallery_image').click();">
                                        <div class="plus-icon">+</div>
                                    </div>
                                </div>
                                <input type="file" id="gallery_image" name="gallery_image[]" multiple accept="image/*"
                                    class="form-control d-none @error('gallery_image.*') is-invalid @enderror"
                                    onchange="previewImages(event)" />
                                @error('gallery_image.*')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- <div id="image_preview" class="d-flex flex-wrap mt-3"></div> --}}

                            <!-- Thêm biến thể sản phẩm -->
                            <div id="variant-section" class="mb-4">
                                <div style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
                                    <h3 class="form-label text-dark fw-bold fs-5 mb-3">Biến thể sản phẩm</h3>
                                    <button type="button" id="add-variant" class="btn btn-success mb-3 fw-bold">
                                        <i class="bi bi-cloud-plus"></i> Thêm biến thể
                                    </button>
                                </div>
                            
                                <div id="variant-container">
                                    @if(old('variants'))
                                        @foreach (old('variants') as $index => $variant)
                                            <div class="variant form-group">
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label for="color_id" class="form-label text-dark fw-bold">Màu sắc</label>
                                                        <select name="variants[{{ $index }}][color_id]" id="color_id" class="form-select @error('variants.' . $index . '.color_id') is-invalid @enderror">
                                                            <option disabled selected>Chọn màu sắc</option>
                                                            @foreach($colors as $color)
                                                                <option value="{{ $color->id }}" {{ old('variants.' . $index . '.color_id') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('variants.' . $index . '.color_id')
                                                            <div class="invalid-feedback text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-2">
                                                        <label for="capacity_id" class="form-label text-dark fw-bold">Dung lượng</label>
                                                        <select name="variants[{{ $index }}][capacity_id]" id="capacity_id" class="form-select @error('variants.' . $index . '.capacity_id') is-invalid @enderror">
                                                            <option disabled selected>Chọn dung lượng</option>
                                                            @foreach($capacities as $capacity)
                                                                <option value="{{ $capacity->id }}" {{ old('variants.' . $index . '.capacity_id') == $capacity->id ? 'selected' : '' }}>{{ $capacity->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('variants.' . $index . '.capacity_id')
                                                            <div class="invalid-feedback text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-2">
                                                        <label for="price_difference" class="form-label text-dark fw-bold">Giá sản phẩm</label>
                                                        <input type="number" name="variants[{{ $index }}][price_difference]" min="0" step="0.01" class="form-control @error('variants.' . $index . '.price_difference') is-invalid @enderror" placeholder="Nhập giá sản phẩm" value="{{ old('variants.' . $index . '.price_difference') }}">
                                                        @error('variants.' . $index . '.price_difference')
                                                            <div class="invalid-feedback text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-2">
                                                        <label for="stock" class="form-label text-dark fw-bold">Số lượng</label>
                                                        <input type="number" name="variants[{{ $index }}][stock]" min="0" class="form-control @error('variants.' . $index . '.stock') is-invalid @enderror" placeholder="Nhập số lượng" value="{{ old('variants.' . $index . '.stock') }}">
                                                        @error('variants.' . $index . '.stock')
                                                            <div class="invalid-feedback text-danger">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <button type="button" class="btn btn-danger remove-variant" onclick="removeVariant(this)"><i class="bi bi-trash-fill"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Default nếu chưa có biến thể nào -->
                                        <div class="variant form-group">
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="color_id" class="form-label text-dark fw-bold">Màu sắc</label>
                                                    <select name="variants[0][color_id]" id="color_id" class="form-select">
                                                        <option disabled selected>Chọn màu sắc</option>
                                                        @foreach($colors as $color)
                                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                            
                                                <div class="col-md-2">
                                                    <label for="capacity_id" class="form-label text-dark fw-bold">Dung lượng</label>
                                                    <select name="variants[0][capacity_id]" id="capacity_id" class="form-select">
                                                        <option disabled selected>Chọn dung lượng</option>
                                                        @foreach($capacities as $capacity)
                                                            <option value="{{ $capacity->id }}">{{ $capacity->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                            
                                                <div class="col-md-2">
                                                    <label for="price_difference" class="form-label text-dark fw-bold">Giá sản phẩm</label>
                                                    <input type="number" name="variants[0][price_difference]" min="0" step="0.01" class="form-control" placeholder="Nhập giá sản phẩm">
                                                </div>
                            
                                                <div class="col-md-2">
                                                    <label for="stock" class="form-label text-dark fw-bold">Số lượng</label>
                                                    <input type="number" name="variants[0][stock]" min="0" class="form-control" placeholder="Nhập số lượng">
                                                </div>
                            
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger remove-variant" onclick="removeVariant(this)"><i class="bi bi-trash-fill"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="mb-5">
                                <label for="description" class="form-label text-dark fw-bold fs-5">Mô tả sản phẩm:</label>
                                <textarea class="form-control" id="description" name="description" cols="500" rows="10"
                                    @error('description') is-invalid @enderror placeholder="Mô tả sản phẩm"></textarea>

                                @error('description')
                                    <div class="invalid-feeback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                             



                            <div class="mb-3 d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('product.index') }}" class="btn btn-dark"> Quay lại</a>
                                </div>
                                <button type="submit" class="btn btn-success">Lưu lại</button>

                            </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="adddanhmuc" tabindex="-1" role="dialog" aria-labelledby="addDanhMucModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDanhMucModal">Thêm danh mục mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" method="POST" action="{{ route('category.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="categoryName">Tên danh mục</label>
                            <input type="text" class="form-control" id="categoryName" name="name"
                                placeholder="Nhập tên danh mục" required>
                        </div>
                    </form>
                    <div id="categoryError" class="text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" id="saveCategory">Lưu danh
                        mục</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal thêm màu sắc -->
    <div class="modal fade" id="addMausacModal" tabindex="-1" aria-labelledby="mausacModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mausacModalLabel">Thêm màu sắc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="colorForm">
                        <div class="form-group">
                            <label for="colorName">Tên màu sắc</label>
                            <input type="text" class="form-control" id="colorName" name="colorName" placeholder="Nhập tên màu sắc">
                        </div>
                        <div class="form-group">
                            <label for="colorCode">Mã màu sắc</label>
                            <input type="text" class="form-control" id="colorCode" name="colorCode" placeholder="Nhập mã màu sắc">
                        </div>
                        <div id="colorError" class="text-danger" style="display: none;"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" id="saveColor">Lưu màu sắc</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal thêm dung lượng -->
    <div class="modal fade" id="addDungluongModal" tabindex="-1" aria-labelledby="dungluongModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dungluongModalLabel">Thêm dung lượng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="capacityForm">
                        <div class="form-group">
                            <label for="capacityName">Dung lượng</label>
                            <input type="text" class="form-control" id="capacityName" name="capacityName" placeholder="Nhập dung lượng">
                        </div>
                    </form>
                    <div id="capacityError" class="text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" id="saveCapacity">Lưu dung lượng</button>
                </div>
            </div>
        </div>
    </div>

    {{-- liên quan đến thêm biến thể --}}
    <script>
        let variantCount = 1; // Đếm số biến thể đã thêm
    
        document.getElementById('add-variant').addEventListener('click', function() {
            const variantSection = document.getElementById('variant-container');
            const newVariant = document.createElement('div');
            newVariant.classList.add('variant', 'form-group', 'mb-3');
    
            newVariant.innerHTML = `
                <div class="row">
                    <div class="col-md-2">
                        <select name="variants[${variantCount}][color_id]" id="color_id_${variantCount}" class="form-select">
                            <option disabled selected>Chọn màu sắc</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="col-md-2">
                        <select name="variants[${variantCount}][capacity_id]" id="capacity_id_${variantCount}" class="form-select">
                            <option disabled selected>Chọn dung lượng</option>
                            @foreach($capacities as $capacity)
                                <option value="{{ $capacity->id }}">{{ $capacity->name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="col-md-2">
                        <input type="number" name="variants[${variantCount}][price_difference]" id="price_difference_${variantCount}" min="0" step="0.01" class="form-control" placeholder="Nhập giá sản phẩm">
                    </div>
    
                    <div class="col-md-2">
                        <input type="number" name="variants[${variantCount}][stock]" id="stock_${variantCount}" min="0" class="form-control" placeholder="Nhập số lượng ">
                    </div>
    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onclick="removeVariant(this)"><i class="bi bi-trash-fill"></i></button>
                    </div>
                </div>
            `;
    
            variantSection.appendChild(newVariant);
            variantCount++;
        });
    
        function removeVariant(button) {
            const variant = button.closest('.variant');
            variant.remove();
        }
    </script>
    
    
@endsection
