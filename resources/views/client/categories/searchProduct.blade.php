@extends('client.layout.master')
@section('content')
<style>
    .suggestion-item {
        width: auto;
        margin: 5px;
    }

    @media (max-width: 768px) {
        .list-hint a {
            width: 100% !important;
            text-align: center;
            margin-bottom: 10px;
        }
    }

    @media (min-width: 768px) {
        .list-hint a {
            width: auto;
        }
    }
</style>

<div>
  <!-- Breadcrumb -->
  <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="">trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Sản phẩm tìm kiếm</li>
    </ol>
  </nav>


  <!-- Page title -->
  <h1 class="h3 container mb-4">Sản phần tìm kiếm</h1>


  <div class="list-hint container d-flex justify-content-start align-items-center mb-5">
      <a class="" href="#" style="background-color: rgba(199, 189, 189, 0.445); border-radius:9999px;text-decoration:none;padding:5px 10px;color:white;" >Iphone 14 pro max</a>
      <a class="" href="#" style="background-color: rgba(199, 189, 189, 0.445); border-radius:9999px;text-decoration:none;padding:5px 10px;color:white;" >Iphone 13 pro max</a>
      <a class="" href="#" style="background-color: rgba(199, 189, 189, 0.445); border-radius:9999px;text-decoration:none;padding:5px 10px;color:white;" >Iphone 16 pro </a>
      <a class="" href="#" style="background-color: rgba(199, 189, 189, 0.445); border-radius:9999px;text-decoration:none;padding:5px 10px;color:white;" >Iphone 15 pro max</a>
      <a class="" href="#" style="background-color: rgba(199, 189, 189, 0.445); border-radius:9999px;text-decoration:none;padding:5px 10px;color:white;" >Iphone 13 pro max</a>
  </div>





  <!-- Products grid + Sidebar with filters -->
  <section class="container pb-5 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">

      <!-- Filter sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
      <aside class="col-lg-3">
        <div class="offcanvas-lg offcanvas-start" id="filterSidebar">
          <div class="offcanvas-header py-3">
            <h5 class="offcanvas-title">Filter and sort</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body flex-column pt-2 py-lg-0">


            <!-- Categories -->
            <div class="w-100 border rounded p-3 p-xl-4 mb-3 mb-xl-4">
              <h4 class="h6 mb-2">Danh mục</h4>
              <ul class="list-unstyled d-block m-0">
                @foreach ($categories as $item)
                <li class="nav d-block pt-2 mt-1">
                  <button type="button" class="nav-link w-auto category-filter" data-category-id="{{ $item->id }}">
                    <span class="animate-target text-truncate me-3">{{ $item->name }}</span>
                    <!-- Hiển thị số lượng sản phẩm hoặc biến thể -->
                    <span class="text-body-secondary fs-xs ms-auto">{{ $item->product_variants_count ?? $item->products_count }}</span>
                    </a>
                </li>
                @endforeach
              </ul>
            </div>

          </div>
        </div>
      </aside>


      <!-- Product grid -->
      <div class="col-lg-9">
        <div class="row row-cols-2 row-cols-md-3 g-4 pb-3 mb-3">
          <!-- Item -->
          @foreach ($latestProducts as $item)
          <div class="col">
            <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
              <div class="position-relative">
                <div class="position-absolute top-0 end-0 z-2 hover-effect-target opacity-0 mt-3 me-3">
                  <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist" data-id="{{$item->id}}">
                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist" data-id="{{$item->id}}">
                      <i class="ci-heart fs-base animate-target"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-secondary animate-rotate d-none d-lg-inline-flex" aria-label="Compare">
                      <i class="ci-refresh-cw fs-base animate-target"></i>
                    </button>
                  </div>
                </div>
                <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                  <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                    <i class="ci-more-vertical fs-lg"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                    <li>
                      <a class="dropdown-item" href="#!">
                        <i class="ci-heart fs-sm ms-n1 me-2"></i>
                        Add to Wishlist
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#!">
                        <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                        Compare
                      </a>
                    </li>
                  </ul>
                </div>
                <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="shop-product-general-electronics.html">
                  <!-- <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3">-21%</span> -->
                  <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                  </div>
                </a>
              </div>
              <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                {{-- <div class="d-flex align-items-center gap-2 mb-2">
                  <div class="d-flex gap-1 fs-xs">
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star text-body-tertiary opacity-75"></i>
                  </div>
                  <!-- <span class="text-body-tertiary fs-xs">(123)</span> -->
                </div> --}}
                <h3 class="pb-1 mb-2">
                  <a class="d-block fs-sm fw-medium text-truncate" href="shop-product-general-electronics.html">
                    <span class="animate-target">{{$item->name}}</span>
                  </a>
                </h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="h5 lh-1 mb-0">{{ $item->price }} <del class="text-body-tertiary fs-sm fw-normal">$430.00</del></div>
                  <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                    <i class="ci-shopping-cart fs-base animate-target"></i>
                  </button>
                </div>
              </div>
              {{-- <div class="product-card-details position-absolute top-100 start-0 w-100 bg-body rounded-bottom shadow mt-n2 p-3 pt-1">
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
              </div> --}}
            </div>
          </div>
          @endforeach
          </div>
        </div>


  </section>

  </main>
</div>
<!-- Thêm jQuery -->
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var searchTerm = urlParams.get('search');

    if (searchTerm) {
        $.ajax({
            url: '/api/search-suggestions',
            method: 'GET',
            data: { search: searchTerm },
            success: function(response) {
                $('.list-hint').empty();

                if(window.innerWidth < 768) {
                  response.suggestions =  response.suggestions.slice(0, 2)
                }

                response.suggestions.forEach(function(suggestion) {
                    // Tạo thẻ <a> với style và class giống như mẫu
                    var suggestionItem = $('<a></a>')
                        .addClass('suggestion-item')  // Áp dụng class từ CSS
                        .text(suggestion.name)            // Thêm nội dung từ gợi ý
                        .attr('href', '/search?search=' + encodeURIComponent(suggestion.name))  // Cập nhật href với từ khóa
                        .css({                      // Áp dụng CSS động nếu cần
                            backgroundColor: 'rgba(199, 189, 189, 0.345)',
                            borderRadius: '8px',
                            textDecoration: 'none',
                            padding: '5px 10px',
                            color: 'black'
                        });

                    $('.list-hint').append(suggestionItem);
                });
            },
            error: function(xhr, status, error) {
                console.error('Có lỗi xảy ra khi gọi API:', error);
            }
        });
    }
    document.querySelectorAll('button[aria-label="Add to Wishlist"]').forEach(button => {
      button.addEventListener('click', function() {
        let productId = this.getAttribute('data-id'); // Lấy product ID từ data-id
        let customerId = @json(Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null);

        // Gọi API để thêm sản phẩm vào danh sách yêu thích
        $.ajax({
          url: '/api/favorites',  // Đảm bảo rằng API của bạn đúng với URL này
          method: 'POST',
          data: {
            customer_id: customerId,  // Gửi customer_id (có thể bạn cần thay đổi tùy theo API)
            product_id: productId     // Gửi product_id (sản phẩm cần thêm vào wishlist)
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
  });

</script>
