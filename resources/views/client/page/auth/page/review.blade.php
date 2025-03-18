@extends('client/page/auth/layout/master')

@section('content_customer')


<!-- Page title + Sorting select -->
<div class="row align-items-center pb-2 mb-sm-1">
  <div class="col-sm-6 col-md-7 col-xxl-8 mb-3 mb-md-0">
    <h1 class="h2 me-3 mb-0">Đánh giá của bạn</h1>
  </div>
</div>
@if($customerReviews->isEmpty())
        <p>Bạn chưa có đánh giá nào.</p>
    @else
@foreach($customerReviews as $review)
<div class="d-md-flex align-items-center justify-content-between gap-4 border-bottom py-3">
  <div class="nav flex-nowrap position-relative align-items-center">
    <!-- Hình ảnh sản phẩm -->
    <img src="{{ asset('storage/' . $review->product->image_url) }}" class="d-block my-xl-1" width="64" alt="{{ $review->product->name }}">

    <!-- Tên sản phẩm -->
    <a class="nav-link stretched-link hover-effect-underline ps-3 p-0" href="{{ route('product.show', $review->product->id) }}">
      {{ $review->product->name }}
    </a>
  </div>

  <!-- Đánh giá và nội dung -->
  <div class="position-relative d-flex align-items-center text-decoration-none min-w-0 pt-1 pt-md-0 ps-3 ps-md-0 mb-2 mb-md-0">
    <div class="h6 fs-sm text-body-secondary text-truncate p-0 me-3 me-sm-4 mb-0">
      {{ $review->comment }}
    </div>

    <!-- Sao đánh giá -->
    <div class="d-flex gap-1 fs-sm me-2 me-sm-3">
      @for ($i = 1; $i <= 5; $i++)
        @if ($i <=$review->rating)
        <i class="ci-star-filled text-warning"></i>
        @else
        <i class="ci-star text-body-tertiary opacity-60"></i>
        @endif
        @endfor
    </div>
  </div>
</div>

@endforeach
<div class="d-flex justify-content-center mt-4">
            {{ $customerReviews->links() }}
        </div>
        @endif

@endsection