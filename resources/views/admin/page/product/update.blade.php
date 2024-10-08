{{-- extends: Chir định layout được sử dụng --}}
@extends('admin.layout.master')
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
<<<<<<< HEAD
<<<<<<< HEAD
                <h2 class="cart-header text-center m-3" style="font-weight: bold"> Sửa sản phẩm</h2>
=======
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Sửa sản phẩm</h2>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                <h2 class=" text-dark fw-bold m-3 mt-4 "
                    style="font-weight: bold; border-bottom: 2px solid #FFD43B; font-family: 'Roboto', sans-serif; padding-bottom: 10px;padding-left: 5px ">
                    Sửa sản phẩm</h2>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                <div class="card-body">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
<<<<<<< HEAD
<<<<<<< HEAD

                        <div class="mb-3">
                            <label for="product_code" class="form-label">Mã sản phẩm:</label>
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                placeholder="Nhập mã sản phẩm" @error('product_code') is-invalid @enderror
                                value="{{ $product->product_code }}">
                            @error('product_code')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên sản phẩm" @error('name') is-invalid @enderror
                                value="{{ $product->name }}">
                            @error('name')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Hình ảnh sản phẩm:</label>
                            <input type="file" class="form-control" id="image_url" name="image_url"
                                placeholder=" Hình ảnh sản phẩm" @error('image_url') is-invalid @enderror
                                value="{{ $product->image_url }}">
                            @if ($product->image_url)
                                <img src="{{ Storage::url($product->image_url) }}" width="80px" alt="">
                            @endif
                            @error('image_url')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá sản phẩm:</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" placeholder="Giá sản phẩm"
                                    value="{{ number_format($product->price, 0, ',', '.') }}">
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            @error('price')
=======
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
=======
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
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50

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
                                <label for="price" class="form-label text-dark fw-bold fs-5">Giá sản phẩm</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" placeholder="Giá sản phẩm"
                                        value="{{ number_format($product->price, 0, ',', '.') }}">
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="category" class="form-label text-dark fw-bold fs-5">Danh mục</label>
                                <select name="category_id" id="category" class="form-select"
                                    @error('category_id') is-invalid @enderror>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                <input type="file" id="image_url" name="image_url" onchange="readURL(this);" accept="image/*" />
                                <label for="image_url" class="btn-choose">
                                    <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh
                                </label>
                            </div>
                            <div id="thumbbox" style="margin-top: 10px;">
                                @if ($product->image_url)
                                    <img height="100" width="100" alt="Hình ảnh sản phẩm cũ" id="thumbimage" src="{{ Storage::url($product->image_url) }}" />
                                @else
                                    <img height="100" width="100" alt="Hình ảnh sản phẩm" id="thumbimage" style="display: none;" />
                                @endif
                                <div>
                                    <a class="removeimg" href="javascript:void(0);" onclick="removeImage()" style="display: {{ $product->image_url ? 'inline' : 'none' }}; color:red">Xóa </a>

                                </div>
                                @error('image_url')
                                    <div class="invalid-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        
                        
                       
                        <div class="mb-3 mt-3">
                            <label for="gallery_image" class="form-label text-dark fw-bold fs-5 mb-3">Ảnh phụ sản phẩm</label>
                            <div class="d-flex align-items-start"> <!-- Sử dụng Flexbox để căn chỉnh -->
                                <div id="image_preview" class="d-flex flex-wrap mt-3 me-3">
                                    @if($product->gallery_image) <!-- Kiểm tra xem có ảnh trong gallery hay không -->
                                        @php
                                            $galleryImages = json_decode($product->gallery_image, true); // Giải mã ảnh đã lưu
                                        @endphp
                                        @foreach($galleryImages as $image)
                                            <div class="position-relative me-2 mb-2">
                                                <img src="{{ asset('storage/' . $image) }}" style="width: 70px; height: 70px; margin-right: 10px;">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-gallery" data-image="{{ $image }}" style="cursor: pointer;">&times;</span>
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
<<<<<<< HEAD
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
<<<<<<< HEAD
<<<<<<< HEAD


                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả sản phẩm:</label>
=======
                        
                        


                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold fs-5">Mô tả sản phẩm:</label>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                        
                        


                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold fs-5">Mô tả sản phẩm:</label>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                            <textarea class="form-control" id="description" name="description" cols="500" rows="10"
                                @error('description') is-invalid @enderror placeholder="Mô tả sản phẩm">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

<<<<<<< HEAD
<<<<<<< HEAD
                        <div class="mb-3">
                            <label for="category" class="form-label">Danh mục:</label>
                            <select name="category_id" id="category" class="form-select"
                                @error('category_id') is-invalid @enderror>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feeback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Sửa sản phẩm</button>
                        </div>
                    </form>
                    <a href="{{ route('product.index') }}">
                        <button class="btn btn-dark">Quay lại</button>
                    </a>
=======
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('product.index') }}" class="btn btn-danger"> Quay lại</a>
                            </div>
                            <button type="submit" class="btn btn-warning">Lưu lại</button>

                        </div>
                    </form>
                    
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
                        
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <a href="{{ route('product.index') }}" class="btn btn-danger"> Quay lại</a>
                            </div>
                            <button type="submit" class="btn btn-warning">Lưu lại</button>

                        </div>
                    </form>
                    
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
                </div>
            </div>
        </div>
    </div>
    
@endsection
