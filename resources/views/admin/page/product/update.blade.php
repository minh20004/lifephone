{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Sửa sản phẩm</h2>
                <div class="card-body">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="product_code" class="form-label text-dark fw-bold fs-5">Mã sản phẩm</label>
                                <input type="text" class="form-control" id="product_code" name="product_code"
                                    placeholder="Nhập mã sản phẩm" @error('product_code') is-invalid @enderror
                                    value="{{ $product->product_code }}">
                                @error('product_code')
                                    <div class="invalid-feeback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="name" class="form-label text-dark fw-bold fs-5">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nhập tên sản phẩm" @error('name') is-invalid @enderror
                                    value="{{ $product->name }}">
                                @error('name')
                                    <div class="invalid-feeback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="category" class="form-label text-dark fw-bold fs-5">Danh mục</label>
                                <select name="category_id" id="category"
                                    class="form-select @error('category_id') is-invalid @enderror">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $product->category_id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feeback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>




                        <div class="mb-3 mt-3">
                            <label for="image_url" class="form-label text-dark fw-bold fs-5 mb-3">Hình ảnh sản phẩm</label>
                            <div class="custom-file-upload">
                                <input type="file" id="image_url" name="image_url" onchange="readURL(this);"
                                    accept="image/*" />
                                <label for="image_url" class="btn-choose">
                                    <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh
                                </label>
                            </div>
                            <div id="thumbbox" style="margin-top: 10px;">
                                @if ($product->image_url)
                                    <img height="100" width="100" alt="Hình ảnh sản phẩm cũ" id="thumbimage"
                                        src="{{ Storage::url($product->image_url) }}" />
                                @else
                                    <img height="100" width="100" alt="Hình ảnh sản phẩm" id="thumbimage"
                                        style="display: none;" />
                                @endif
                                <div>
                                    <a class="removeimg" href="javascript:void(0);" onclick="removeImage()"
                                        style="display: {{ $product->image_url ? 'inline' : 'none' }}; color:red">Xóa </a>

                                </div>
                                @error('image_url')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>




                        <div class="mb-3 mt-3">
                            <label for="gallery_image" class="form-label text-dark fw-bold fs-5 mb-3">Ảnh phụ sản
                                phẩm</label>
                            <div class="d-flex align-items-start"> <!-- Sử dụng Flexbox để căn chỉnh -->
                                <div id="image_preview" class="d-flex flex-wrap mt-3 me-3">
                                    @if ($product->gallery_image)
                                        <!-- Kiểm tra xem có ảnh trong gallery hay không -->
                                        @php
                                            $galleryImages = json_decode($product->gallery_image, true); // Giải mã ảnh đã lưu
                                        @endphp
                                        @foreach ($galleryImages as $image)
                                            <div class="position-relative me-2 mb-2">
                                                <img src="{{ asset('storage/' . $image) }}"
                                                    style="width: 70px; height: 70px; margin-right: 10px;">
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-gallery"
                                                    data-image="{{ $image }}"
                                                    style="cursor: pointer;">&times;</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
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
                        <!-- Thêm biến thể sản phẩm -->
                        <div id="variant-section" class="mb-4">
                            <div style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
                                <h3 class="form-label text-dark fw-bold fs-5 mb-3">Biến thể sản phẩm</h3>
                                <button type="button" id="add-variant" class="btn btn-success mb-3 fw-bold ">
                                    <i class="bi bi-cloud-plus"></i>Thêm biến thể
                                </button>
                            </div>

                            @foreach ($variants as $index => $variant)
                                <div class="variant form-group">
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label for="color_id_{{ $index }}" class="form-label text-dark fw-bold">Màu sắc</label>
                                            <select name="variants[{{ $index }}][color_id]" id="color_id_{{ $index }}" class="form-select @error("variants.$index.color_id") is-invalid @enderror">
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}"
                                                        {{ $color->id == $variant->color_id ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("variants.$index.color_id")
                                                <div class="invalid-feedback text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="capacity_id_{{ $index }}" class="form-label text-dark fw-bold">Dung lượng</label>
                                            <select name="variants[{{ $index }}][capacity_id]" id="capacity_id_{{ $index }}" class="form-select @error("variants.$index.capacity_id") is-invalid @enderror">
                                                @foreach ($capacities as $capacity)
                                                    <option value="{{ $capacity->id }}"
                                                        {{ $capacity->id == $variant->capacity_id ? 'selected' : '' }}>
                                                        {{ $capacity->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("variants.$index.capacity_id")
                                                <div class="invalid-feedback text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="price_difference_{{ $index }}" class="form-label text-dark fw-bold">Giá sản phẩm</label>
                                            <input type="number" name="variants[{{ $index }}][price_difference]"
                                                min="0" step="0.01"
                                                value="{{ old('variants.' . $index . '.price_difference', $variant->price_difference) }}"
                                                class="form-control @error("variants.$index.price_difference") is-invalid @enderror" 
                                                placeholder="Nhập giá sản phẩm">
                                            @error("variants.$index.price_difference")
                                                <div class="invalid-feedback text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="stock_{{ $index }}" class="form-label text-dark fw-bold">Số lượng</label>
                                            <input type="number" name="variants[{{ $index }}][stock]"
                                                min="0"
                                                value="{{ old('variants.' . $index . '.stock', $variant->stock) }}"
                                                class="form-control @error("variants.$index.stock") is-invalid @enderror" 
                                                placeholder="Nhập số lượng" required>
                                            @error("variants.$index.stock")
                                                <div class="invalid-feedback text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger" onclick="removeVariant(this)">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
<<<<<<< HEAD
                        
=======



>>>>>>> b023fbb (sua noi)


                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold fs-5">Mô tả sản phẩm:</label>
                            <textarea class="form-control" id="description" name="description" cols="500" rows="10"
                                @error('description') is-invalid @enderror placeholder="Mô tả sản phẩm">{{ $product->description }}</textarea>
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
                            <button type="submit" class="btn btn-warning">Lưu lại</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-variant').addEventListener('click', function() {
            let variantsContainer = document.getElementById('variant-section');
            let newVariantIndex = variantsContainer.getElementsByClassName('variant').length;

            let newVariant = `
        <div class="variant form-group mb-3">
            <div class="row mb-3">
                <div class="col-md-2">
                    <select name="variants[${newVariantIndex}][color_id]" id="color_id_${newVariantIndex}" class="form-select">
                        <option disabled selected>Chọn màu sắc</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="variants[${newVariantIndex}][capacity_id]" id="capacity_id_${newVariantIndex}" class="form-select">
                        <option disabled selected>Chọn dung lượng</option>
                        @foreach ($capacities as $capacity)
                            <option value="{{ $capacity->id }}">{{ $capacity->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="variants[${newVariantIndex}][price_difference]" min="0" step="0.01" class="form-control" placeholder="Nhập giá sản phẩm">
                </div>
                <div class="col-md-2">
                    <input type="number" name="variants[${newVariantIndex}][stock]" min="0" class="form-control" placeholder="Nhập số lượng">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger bg-opacity-50" onclick="removeVariant(this)"><i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        </div>
    `;

            variantsContainer.insertAdjacentHTML('beforeend', newVariant);
        });

        // Hàm xóa biến thể
        function removeVariant(button) {
            button.closest('.variant').remove();
        }
    </script>

@endsection
