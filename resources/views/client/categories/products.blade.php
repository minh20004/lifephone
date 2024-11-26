@extends('client.layout.master')
@section('content')
<div>
  <!-- Breadcrumb -->
  <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $currentCategory->name }}</li>
    </ol>
  </nav>
  <!-- Page title -->
  <!-- <div class="container mb-4">
    <p class="h5 text-muted">Tìm thấy <span class="fw-bold text-dark">{{ $productCount }}</span> sản phẩm thuộc danh mục <span class="fw-bold text-primary">{{ $currentCategory->name }}</span></p>
  </div> -->




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
              <h4 class="h6 mb-2">Danh mục</h4>
              <ul class="list-unstyled d-block m-0">
                @foreach ($categories as $item)
                <li class="nav d-block pt-2 mt-1">
                  <a href="{{ route('client.category.products', ['id' => $item->id, 'min_price' => request('min_price'), 'max_price' => request('max_price')]) }}" class="nav-link w-auto {{ $currentCategory->id == $item->id ? 'active' : '' }}">
                    <span class="animate-target text-truncate me-3">{{ $item->name }}</span>
                    <span class="text-body-secondary fs-xs ms-auto">{{ $item->products_count }}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>

            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <form action="{{ route('client.category.products', ['id' => $currentCategory->id]) }}" method="GET" id="price-filter-form">
                <h4 class="h6 mb-3">Lọc theo giá</h4>
                <div class="btn-group-vertical w-100" id="price-range-list" role="group">
                  <!-- Hiển thị 5 giá trị ban đầu -->
                  <button type="submit" name="min_price" value="0" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 0 ? 'active' : '' }} {{ request('max_price') == 1000000 ? 'active' : '' }}">
                    Dưới 1 triệu
                  </button>
                  <button type="submit" name="min_price" value="1000000" name="max_price" value="3000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 1000000 && request('max_price') == 3000000 ? 'active' : '' }}">
                    1 đến 3 triệu
                  </button>
                  <button type="submit" name="min_price" value="3000000" name="max_price" value="5000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 3000000 && request('max_price') == 5000000 ? 'active' : '' }}">
                    3 đến 5 triệu
                  </button>
                  <button type="submit" name="min_price" value="5000000" name="max_price" value="10000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 5000000 && request('max_price') == 10000000 ? 'active' : '' }}">
                    5 đến 10 triệu
                  </button>
                  <button type="submit" name="min_price" value="10000000" name="max_price" value="15000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 10000000 && request('max_price') == 15000000 ? 'active' : '' }}">
                    10 đến 15 triệu
                  </button>

                  <!-- Các giá trị còn lại ẩn đi -->
                  <div id="more-price-range" class="btn-group-vertical w-100 d-none">
                    <button type="submit" name="min_price" value="15000000" name="max_price" value="20000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 15000000 && request('max_price') == 20000000 ? 'active' : '' }}">
                      15 đến 20 triệu
                    </button>
                    <button type="submit" name="min_price" value="20000000" name="max_price" value="25000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 20000000 && request('max_price') == 25000000 ? 'active' : '' }}">
                      20 đến 25 triệu
                    </button>
                    <button type="submit" name="min_price" value="25000000" name="max_price" value="30000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 25000000 && request('max_price') == 30000000 ? 'active' : '' }}">
                      25 đến 30 triệu
                    </button>
                    <button type="submit" name="min_price" value="30000000" name="max_price" value="50000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 30000000 && request('max_price') == 50000000 ? 'active' : '' }}">
                      30 đến 50 triệu
                    </button>
                    <button type="submit" name="min_price" value="50000000" name="max_price" value="85000000" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 50000000 && request('max_price') == 85000000 ? 'active' : '' }}">
                      50 đến 85 triệu
                    </button>
                    <button type="submit" name="min_price" value="85000000" name="max_price" value="99999999" class="btn btn-outline-secondary mb-2 {{ request('min_price') == 85000000 && request('max_price') == 99999999 ? 'active' : '' }}">
                      Trên 85 triệu
                    </button>
                  </div>

                  <!-- Nút "Thu gọn" -->
                  <button type="button" class="btn btn-link mt-2" id="show-more-button">
                    Thu gọn <i class="bi bi-chevron-up"></i>
                  </button>
                </div>
              </form>
            </div>


            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6 mb-2">Dung lượng</h4>
              <ul class="list-unstyled d-block m-0">
                @foreach ($capacities as $item)
                <li class="nav d-block pt-2 mt-1">
                  <a href="{{ route('client.category.products', ['id' => $currentCategory->id, 'capacity_id' => $item->id, 'min_price' => request('min_price'), 'max_price' => request('max_price')]) }}"
                    class="nav-link w-auto {{ request('capacity_id') == $item->id ? 'active' : '' }}">
                    <span class="animate-target text-truncate me-3">{{ $item->name }}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>

            <div class="w-100 border rounded p-3 p-xl-4">
              <h4 class="h6">Màu sắc</h4>
              <div class="nav d-block mt-n2">
                @foreach ($colors as $color)
                <a href="{{ route('client.category.products', ['id' => $currentCategory->id, 'color_id' => $color->id, 'min_price' => request('min_price'), 'max_price' => request('max_price')]) }}"
                  class="nav-link w-auto animate-underline fw-normal pt-2 pb-0 px-0 {{ request('color_id') == $color->id ? 'active' : '' }}">
                  <span class="rounded-circle me-2" style="width: .875rem; height: .875rem; margin-top: .125rem; background-color: {{ $color->code }}"></span>
                  <span class="animate-target">{{ $color->name }}</span>
                </a>
                @endforeach
              </div>
            </div>

            <!-- Other filters (Price, Capacity, Color) giữ nguyên -->
          </div>
        </div>
      </aside>
      <!-- Product grid -->
      <div class="col-lg-9">
        <p class="h6 text-muted">
          Tìm thấy
          <span class="fw-bold text-dark">{{ $productCount }}</span>
          sản phẩm
          @if ($colorId && $colors->contains('id', $colorId))
          có màu
          <span class="fw-bold text-primary">
            {{ $colors->firstWhere('id', $colorId)->name }}
          </span>
          @endif
          @if ($minPrice && $maxPrice)
          trong khoảng giá
          <span class="fw-bold text-primary">{{ $minPrice }} - {{ $maxPrice }}</span>
          @elseif ($minPrice)
          từ
          <span class="fw-bold text-primary">{{ $minPrice }}</span>
          @elseif ($maxPrice)
          đến
          <span class="fw-bold text-primary">{{ $maxPrice }}</span>
          @endif
          @if ($capacityId && $capacities->contains('id', $capacityId))
          có dung lượng
          <span class="fw-bold text-primary">
            {{ $capacities->firstWhere('id', $capacityId)->name }}
          </span>
          @endif
          @if (!$colorId && !$minPrice && !$maxPrice && !$capacityId)
          thuộc danh mục
          <span class="fw-bold text-primary">
            {{ $currentCategory->name }}
          </span>
          @else
          trong danh mục
          <span class="fw-bold text-primary">
            {{ $currentCategory->name }}
          </span>
          @endif
        </p>

        <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">
          <!-- Product Items -->
          @forelse ($productsByCategory as $item)
          <div class="col">
            <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
              <div class="position-relative">
                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="#">
                  <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                  </div>
                </a>
              </div>
              <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                <h3 class="pb-1 mb-2">
                  <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('product.show', $item->id) }}">
                    {{ $item->name }}
                  </a>
                </h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="h5 lh-1 mb-0">@foreach ($item->variants as $variant)
                    @if ($variant->price_difference == $item->variants->min('price_difference'))
                    {{ number_format($item->variants->min('price_difference'), 0, ',', '.') }} VND
                    @endif
                    @endforeach
                  </div>
                  <button type="button" class="product-card-button btn btn-icon btn-secondary" aria-label="Add to Cart">
                    <i class="ci-shopping-cart"></i>
                  </button>
                </div>
                <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
                  <span class="position-absolute top-0 start-0 w-100 bg-body mt-n2 py-2"></span>
                  <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                    @foreach ($item->variants as $variant)
                    <li class="d-flex align-items-center">
                      <span class="fs-xs">Color:</span>
                      <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                      <span class="text-dark-emphasis fs-xs fw-medium text-end">{{ $variant->color->name}}</span>
                    </li>

                    <li class="d-flex align-items-center">
                      <span class="fs-xs">Capacity:</span>
                      <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                      <span class="text-dark-emphasis fs-xs fw-medium text-end">{{ $variant->capacity->name }}</span>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>

          @empty
          <div class="col-12">
            <p class="text-center">Không có sản phẩm nào trong danh mục này.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </section>
  <div class=" d-flex justify-content-center mt-4">
    {{ $productsByCategory->links() }}
  </div>
</div>
@endsection