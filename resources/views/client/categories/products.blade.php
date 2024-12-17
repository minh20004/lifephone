@extends('client.layout.master')
@section('content')
<div>
  <!-- Breadcrumb -->
  <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $currentCategory->name }}</li>
    </ol>
  </nav>





  <!-- Products grid + Sidebar with filters -->
  <section class="container pb-5 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">
      <!-- Filter sidebar -->
      <aside class="col-lg-3">
        <div class="offcanvas-lg offcanvas-start" id="filterSidebar">
          <div class="offcanvas-header py-3">
            <h5 class="offcanvas-title">Lọc và sắp xếp</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body flex-column pt-2 py-lg-0">
            <!-- Categories -->
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6 mb-2">Categories</h4>
              <ul class="list-unstyled d-block m-0">
                @foreach ($categories as $item)
                <li class="nav d-block pt-2 mt-1">
                  <a href="{{ route('client.category.products', $item->id) }}" class="nav-link w-auto">
                    <span class="animate-target text-truncate me-3">{{ $item->name }}</span>
                    <span class="text-body-secondary fs-xs ms-auto">{{ $item->products_count }}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
            <form action="{{ route('client.category.products', [
    'id' => $currentCategory->id, 
    'min_price' => request('min_price'),  
    'max_price' => request('max_price'),
    'capacity_id' => request('capacity_id'),
    'per_page' => request('per_page', 6)  // Giữ giá trị phân trang, mặc định là 6
]) }}" method="GET" class="p-4 border rounded bg-light">
              <!-- Bộ lọc giá -->
              <div class="mb-3">
                <label for="min_price" class="form-label">Giá tối thiểu:</label>
                <input type="number" id="min_price" name="min_price" class="form-control"
                  value="{{ request('min_price', 1000000) }}" min="1000000" step="500000" placeholder="Nhập giá tối thiểu">
              </div>
              <div class="mb-3">
                <label for="max_price" class="form-label">Giá tối đa:</label>
                <input type="number" id="max_price" name="max_price" class="form-control"
                  value="{{ request('max_price', 10000000) }}" min="0" step="1000000" placeholder="Nhập giá tối đa">
              </div>
              <!-- Nút lọc -->
              <button type="submit" class="btn btn-primary w-100">Lọc sản phẩm</button>
            </form>
            <!-- Other filters (Price, Capacity, Color) giữ nguyên -->
          </div>
        </div>
      </aside>
      <!-- Product grid -->
      <div class="col-lg-9">
        @if($productsByCategory->isEmpty())
        <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">
          <!-- Item -->
          @foreach ($products as $item)
          <div class="col">
            <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
              <div class="position-relative">
                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="{{ route('product.show', $item->id) }}">
                  <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                  </div>
                </a>
              </div>
              <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                <h3 class="pb-1 mb-2">
                  <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('product.show', $item->id) }}">
                    <span class="animate-target">{{ $item->name }}</span>
                  </a>
                </h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="h5 lh-1 mb-0">
                    {{ number_format($item->variants->min('price_difference'), 0, ',', '.') }} VND
                  </div>
                  <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                    <i class="ci-shopping-cart fs-base animate-target"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
          {{ $products->links() }}
        </div>
        @else
        <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">
          <!-- Item -->
          @foreach ($productsByCategory as $item)
          <div class="col">
            <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
              <div class="position-relative">
                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="{{ route('product.show', $item->id) }}">
                  <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                  </div>
                </a>
              </div>
              <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                <h3 class="pb-1 mb-2">
                  <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('product.show', $item->id) }}">
                    <span class="animate-target">{{ $item->name }}</span>
                  </a>
                </h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="h5 lh-1 mb-0">
                    {{ number_format($item->variants->min('price_difference'), 0, ',', '.') }} VND
                  </div>
                  <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                    <i class="ci-shopping-cart fs-base animate-target"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
          {{ $productsByCategory->links() }}
        </div>
        @endif
        <!-- Pagination -->

      </div>
    </div>
</div>
</section>
</div>
<script>
  document.querySelectorAll('button[aria-label="Add to Wishlist"]').forEach(button => {
    button.addEventListener('click', function() {
      let productId = this.getAttribute('data-id');

      let customerId = @json(Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : null);

      // Gọi API để thêm sản phẩm vào danh sách yêu thích
      $.ajax({
        url: '/api/favorites', 
        method: 'POST',
        data: {
          customer_id: customerId, 
          product_id: productId 
        },
        success: function(response) {
          console.log('Product added to wishlist:', response);
          alert('Sản phẩm đã được thêm vào danh sách yêu thích!');
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
          alert('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
      });
    });
  });
</script>
@endsection

