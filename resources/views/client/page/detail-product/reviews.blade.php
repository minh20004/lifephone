<div class="modal fade" id="reviewForm" data-bs-backdrop="static" tabindex="-1" aria-labelledby="reviewFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content needs-validation" id="submitReviewForm" method="POST" action="{{ route('reviews.store', ['id' => $product->id]) }}">
      @csrf
      <div class="modal-header border-0">
        <h5 class="modal-title" id="reviewFormLabel">Đánh giá của bạn về sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-3 pt-0">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="mb-3">
          <label class="form-label">Đánh giá <span class="text-danger">*</span></label>
          <select class="form-select" name="rating" required>
            <option value="" disabled selected>Chọn số sao</option>
            @for ($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}">{{ $i }} sao</option>
              @endfor
          </select>
          <div class="invalid-feedback">Hãy chọn số sao cho sản phẩm!</div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="review-text">Bình luận <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="4" id="review-text" name="comment" minlength="20" required></textarea>
          <div class="invalid-feedback">Bình luận cần có ít nhất 20 ký tự!</div>
        </div>
      </div>
      <div class="modal-footer flex-nowrap gap-3 border-0 px-4">
        <button type="reset" class="btn btn-secondary w-100 m-0" data-bs-dismiss="modal">Quay lại</button>
        <button type="submit" class="btn btn-primary w-100 m-0">Gửi đánh giá</button>
      </div>
    </form>
  </div>
</div>

<!-- Reviews -->
<div class="d-flex align-items-center pt-5 mb-4 mt-2 mt-md-3 mt-lg-4" id="reviews" style="scroll-margin-top: 80px">
  <h2 class="h3 mb-0">Đánh giá</h2>
  <button type="button" class="btn btn-secondary ms-auto" data-bs-toggle="modal" data-bs-target="#reviewForm">
    <i class="ci-edit-3 fs-base ms-n1 me-2"></i>
    Để lại đánh giá
  </button>
</div>

<!-- Reviews stats -->
<div class="row g-4 pb-3">
  <div class="col-sm-4">

    <!-- Overall rating card -->
    <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-body-tertiary rounded p-4">
      <div class="h1 pb-2 mb-1">{{ number_format($averageRating, 2) }}</div> <!-- Giới hạn 2 số thập phân -->
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
  @foreach ($reviews->take(2) as $review)

  <div class="border-bottom py-3 mb-3">
    <div class="d-flex align-items-center mb-3">
      <div class="text-nowrap me-3">
        <span class="h6 mb-0">{{ $review->loadAllCustomer ? $review->loadAllCustomer->name : 'Anonymous' }}</span> <!-- Tên người dùng -->
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
   
    <button class="nav-link animate-underline px-1" data-bs-toggle="collapse" data-bs-target="#replyForm{{ $review->id }}">
    <i class="ci-corner-down-right fs-base ms-1 me-1">Phản hồi</i></button>
    <div id="replyForm{{ $review->id }}" class="collapse mt-2">
      <form method="POST" action="{{ route('comments.reply', $review->id) }}">
        @csrf
        <input type="hidden" name="customer_id" value="{{ auth()->check() ? auth()->id() : null }}">
        <textarea name="comment" class="form-control" rows="2" placeholder="Nhập phản hồi..." required></textarea>
        <button type="submit" class="btn btn-sm btn-primary mt-2">Gửi phản hồi</button>
      </form>
    </div>

    <!-- Hiển thị các phản hồi cho review -->
    @if($review->comments->count())
    <div class="comments-section ms-4">
      @foreach($review->comments as $comment)
      <div class="comment mb-2">
        <strong>{{ $comment->loadAllCustomer ? $comment->loadAllCustomer->name : 'Ẩn danh'}}</strong>
        <p>{{ $comment->comment }}</p>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</div>
<!-- Like button -->

</div>
</div>
</div>
@endforeach
@else
<p>Chưa có đánh giá nào hãy là người đánh giá sản phẩm đầu tiên của chúng tôi.</p>
@endif


<div class="nav">
  <a class="nav-link text-primary animate-underline px-0" href="{{ route('products.reviews', $product->id) }}">
    <span class="animate-target">Xem tất cả đánh giá</span>
    <i class="ci-chevron-right fs-base ms-1"></i>
  </a>
</div>
</div>
<script>
  document.getElementById('replyButton').addEventListener('click', function() {
    const replyForm = document.getElementById('replyFormContainer');
    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
  });

  document.getElementById('submitReply').addEventListener('click', function() {
    const replyContent = document.getElementById('replyText').value;
    if (replyContent.trim() === '') {
      alert('Vui lòng nhập phản hồi!');
    } else {
      alert('Phản hồi của bạn: ' + replyContent);
      // Gửi phản hồi đến server nếu cần
      // fetch('/api/reply', { method: 'POST', body: JSON.stringify({ reply: replyContent }) });
      document.getElementById('replyFormContainer').style.display = 'none';
    }
  });
</script>