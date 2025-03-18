@extends('client.layout.master')
@section('title')
Lifephone
@endsection
@section('content')
<section class="container position-relative z-2 pb-4 pb-md-5 mb-2 mb-md-0">
    <div class="border-bottom">
        <ul class="nav nav-underline flex-nowrap gap-4">
            <li class="nav-item me-sm-2">
                <a class="nav-link" href="{{ route('product.show', $product->id) }}">Thông tin chung</a>
            </li>
            <li class="nav-item me-sm-2">
                <a class="nav-link" href="#">Chi tiết sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link pe-none active" href="#!">Đánh giá ({{$reviewCount }})</a>
            </li>
        </ul>
    </div>
</section>
<div class="container">
    <h2>Đánh giá của {{ $product->name }}</h2>
    <div class="row g-4 pb-3">
        <div class="col-sm-4">

            <!-- Overall rating card -->
            <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-body-tertiary rounded p-4">
                <div class="h1 pb-2 mb-1">{{ number_format($averageRating, 1) }}</div> <!-- Giới hạn 2 số thập phân -->
                <div class="hstack justify-content-center gap-1 fs-sm mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <=floor($averageRating))
                        <i class="ci-star-filled text-warning"></i> <!-- Sao đầy -->
                        @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
                        <i class="ci-star-half text-warning"></i> <!-- Sao nửa -->
                        @else
                        <i class="ci-star text-body-tertiary opacity-60"></i> <!-- Sao rỗng -->
                        @endif
                        @endfor
                </div>


                @if(isset($reviewCount))
                <p>Số lượng đánh giá: {{ $reviewCount }}</p>
                @else
                <p>Không có đánh giá nào.</p>
                @endif
            </div>
        </div>
        <div class="col-sm-8">
            <!-- Rating breakdown by quantity -->
            <div class="vstack gap-3">

                @foreach ([5, 4, 3, 2, 1] as $rating)
                <div class="hstack gap-2">
                    <div class="hstack fs-sm gap-1">
                        {{ $rating }}<i class="ci-star-filled text-warning"></i>
                    </div>
                    <div class="progress w-100" role="progressbar" aria-label="{{ $rating }} stars" aria-valuenow="{{ $ratingPercentages[$rating] }}" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
                        <div class="progress-bar bg-warning rounded-pill" style="width: {{ $ratingPercentages[$rating] }}%"></div>
                    </div>
                    <div class="fs-sm text-nowrap text-end" style="width: 40px;">{{ $ratingCounts[$rating] }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <!-- Review -->
        @if(isset($reviews))
        @foreach ($reviews as $review)

        <div class="border-bottom py-3 mb-3">
            <div class="d-flex align-items-center mb-3">
                <div class="text-nowrap me-3">
                    <span class="h6 mb-0">{{ $review->loadAllCustomer ? $review->loadAllCustomer->name : 'Ẩn danh' }}</span> <!-- Tên người dùng -->
                    <i class="ci-check-circle text-success align-middle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-sm" data-bs-title="Verified customer"></i>
                </div>
                <span class="text-body-secondary fs-sm ms-auto">{{ $review->created_at }}</span> <!-- Ngày đánh giá -->
            </div>
            <div class="d-flex gap-1 fs-sm pb-2 mb-1">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <=$review->rating)
                    <i class="ci-star-filled text-warning"></i>
                    @else
                    <i class="ci-star text-body-tertiary opacity-60"></i>
                    @endif
                    @endfor
            </div>
            <h6>đánh giá sản phẩm</h6>
            <p class="fs-sm">{{ $review->comment }}</p>

            

            <!-- Hiển thị các phản hồi cho review -->
            @if(optional($review->comments)->count())
    <div class="comments-section ms-4">
      @foreach($review->comments as $comment)
      <div class="comment mb-2">
        <strong>
          @if ($comment->loadAllUser)
          Nhân viên: {{ optional($comment->loadAllUser)->name }}
          @elseif ($comment->loadAllCustomer)
          {{ optional($comment->loadAllCustomer)->name }}
          @endif
        </strong>
      </div>

      <p>{{ $comment->comment }}</p>
    </div>
    @endforeach
  </div>
  @endif

@endforeach
@else
<p>Chưa có đánh giá nào hãy là người đánh giá sản phẩm đầu tiên của chúng tôi.</p>
@endif


@endsection