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
                  <a href="{{ route('client.category.products', $item->id) }}" class="nav-link w-auto">
                    <span class="animate-target text-truncate me-3">{{ $item->name }}</span>
                    <span class="text-body-secondary fs-xs ms-auto">{{ $item->products_count }}</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6 mb-2" id="slider-label">Price</h4>
              <div class="range-slider" data-range-slider="{&quot;startMin&quot;: 340, &quot;startMax&quot;: 1250, &quot;min&quot;: 0, &quot;max&quot;: 1600, &quot;step&quot;: 1, &quot;tooltipPrefix&quot;: &quot;$&quot;}" aria-labelledby="slider-label">
                <div class="range-slider-ui"></div>
                <div class="d-flex align-items-center">
                  <div class="position-relative w-50">
                    <i class="ci-dollar-sign position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                    <input type="number" id="min_price" class="form-control form-icon-start" min="0" placeholder="Giá tối thiểu">
                  </div>
                  <i class="ci-minus text-body-emphasis mx-2"></i>
                  <div class="position-relative w-50">
                    <i class="ci-dollar-sign position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                    <input type="number" id="max_price" class="form-control form-icon-start" min="0" placeholder="Giá tối đa">
                  </div>
                </div>
              </div>
            </div>

            <!-- Capacity (checkboxes) -->
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6">Capacity</h4>
              <div class="d-flex flex-column gap-1">
                @foreach ($capacities as $item)
                <div class="d-flex align-items-center justify-content-between">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input capacity-checkbox" id="tb-{{$item->id}}" value="{{ $item->id }}">
                    <label for="tb-{{$item->id}}" class="form-check-label text-body-emphasis">{{$item->name}}</label>
                  </div>
                  <span class="text-body-secondary fs-xs">{{$item->products_count}}</span>
                </div>
                @endforeach
              </div>
            </div>

            <!-- Color -->
            <div class="w-100 border rounded p-3 p-xl-4">
              <h4 class="h6">Color</h4>
              <div class="nav d-block mt-n2">
                @foreach ($colors as $color)
                <button type="button" class="nav-link w-auto animate-underline fw-normal pt-2 pb-0 px-0 color-filter" data-color-id="{{ $color->id }}">
                  <span class="rounded-circle me-2" style="width: .875rem; height: .875rem; margin-top: .125rem; background-color: {{ $color->code }}"></span>
                  <span class="animate-target">{{ $color->name }}</span>
                </button>
                @endforeach
              </div>
            </div>
            <!-- Other filters (Price, Capacity, Color) giữ nguyên -->
          </div>
        </div>
      </aside>
      <!-- Product grid -->
      <div class="col-lg-9">
        <div class="container mb-6 ">
          <p class="h6 text-muted">Tìm thấy <span class="fw-bold text-dark">{{ $productCount }}</span> sản phẩm thuộc danh mục <span class="fw-bold text-primary">{{ $currentCategory->name }}</span></p>
        </div>

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