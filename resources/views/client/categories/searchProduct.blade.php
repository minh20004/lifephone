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
      <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
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
              <h4 class="h6 mb-2">Categories</h4>
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


            <!-- Price range -->
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
              <div id="product-list" class="mt-4"></div>
            </div>


            <!-- SSD size (checkboxes) -->
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
                <button type="button" class="nav-link w-auto animate-underline fw-normal pt-2 pb-0 px-0">
                <span class="rounded-circle me-2" style="width: .875rem; height: .875rem; margin-top: .125rem; background-color: {{ $color->code }}"></span>
                <span class="animate-target">{{ $color->name }}</span>
                </button>
                @endforeach

              </div>
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
                    <button type="button" class="btn btn-icon btn-secondary animate-pulse d-none d-lg-inline-flex" aria-label="Add to Wishlist">
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
                <div class="d-flex align-items-center gap-2 mb-2">
                  <div class="d-flex gap-1 fs-xs">
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star-filled text-warning"></i>
                    <i class="ci-star text-body-tertiary opacity-75"></i>
                  </div>
                  <!-- <span class="text-body-tertiary fs-xs">(123)</span> -->
                </div>
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
                  <!-- <li class="d-flex align-items-center">
                    <span class="fs-xs">Sound:</span>
                    <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                    <span class="text-dark-emphasis fs-xs fw-medium text-end">2x3.5mm jack</span>
                  </li>
                  <li class="d-flex align-items-center">
                    <span class="fs-xs">Input:</span>
                    <span class="d-block flex-grow-1 border-bottom border-dashed px-1 mt-2 mx-2"></span>
                    <span class="text-dark-emphasis fs-xs fw-medium text-end">4 built-in cameras</span>
                  </li> -->
                </ul>
              </div>
            </div>
          </div>
          @endforeach




          <!-- Pagination -->
          <!-- <nav class="border-top mt-4 pt-3" aria-label="Catalog pagination">
              <ul class="pagination pagination-lg pt-2 pt-md-3">
                <li class="page-item disabled me-auto">
                  <a class="page-link d-flex align-items-center h-100 fs-lg px-2" href="#!" aria-label="Previous page">
                    <i class="ci-chevron-left mx-1"></i>
                  </a>
                </li>
                <li class="page-item active" aria-current="page">
                  <span class="page-link">
                    1
                    <span class="visually-hidden">(current)</span>
                  </span>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#!">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#!">3</a>
                </li>
                <li class="page-item">
                  <span class="page-link pe-none">...</span>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#!">16</a>
                </li>
                <li class="page-item ms-auto">
                  <a class="page-link d-flex align-items-center h-100 fs-lg px-2" href="#!" aria-label="Next page">
                    <i class="ci-chevron-right mx-1"></i>
                  </a>
                </li>
              </ul>
            </nav> -->
          </div>
        </div>


  </section>


  <!-- Subscription form + Vlog -->
  <section class="bg-body-tertiary py-5">
    <div class="container pt-sm-2 pt-md-3 pt-lg-4 pt-xl-5">
      <div class="row">
        <div class="col-md-6 col-lg-5 mb-5 mb-md-0">
          <h2 class="h4 mb-2">Sign up to our newsletter</h2>
          <p class="text-body pb-2 pb-ms-3">Receive our latest updates about our products &amp; promotions</p>
          <form class="d-flex needs-validation pb-1 pb-sm-2 pb-md-3 pb-lg-0 mb-4 mb-lg-5" novalidate="">
            <div class="position-relative w-100 me-2">
              <input type="email" class="form-control form-control-lg" placeholder="Your email" required="">
            </div>
            <button type="submit" class="btn btn-lg btn-primary">Subscribe</button>
          </form>
          <div class="d-flex gap-3">
            <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Instagram">
              <i class="ci-instagram fs-base"></i>
            </a>
            <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Facebook">
              <i class="ci-facebook fs-base"></i>
            </a>
            <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="YouTube">
              <i class="ci-youtube fs-base"></i>
            </a>
            <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Telegram">
              <i class="ci-telegram fs-base"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 col-xl-4 offset-lg-1 offset-xl-2">
          <ul class="list-unstyled d-flex flex-column gap-4 ps-md-4 ps-lg-0 mb-3">
            <li class="nav flex-nowrap align-items-center position-relative">
              <img src="assets/img/home/electronics/vlog/01.jpg" class="rounded" width="140" alt="Video cover">
              <div class="ps-3">
                <div class="fs-xs text-body-secondary lh-sm mb-2">6:16</div>
                <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 New Cool Gadgets You Must See on Cartzilla - Cheap Budget</a>
              </div>
            </li>
            <li class="nav flex-nowrap align-items-center position-relative">
              <img src="assets/img/home/electronics/vlog/02.jpg" class="rounded" width="140" alt="Video cover">
              <div class="ps-3">
                <div class="fs-xs text-body-secondary lh-sm mb-2">10:20</div>
                <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 Super Useful Gadgets on Cartzilla You Must Have in 2023</a>
              </div>
            </li>
            <li class="nav flex-nowrap align-items-center position-relative">
              <img src="assets/img/home/electronics/vlog/03.jpg" class="rounded" width="140" alt="Video cover">
              <div class="ps-3">
                <div class="fs-xs text-body-secondary lh-sm mb-2">8:40</div>
                <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">Top 5 New Amazing Gadgets on Cartzilla You Must See</a>
              </div>
            </li>
          </ul>
          <div class="nav ps-md-4 ps-lg-0">
            <a class="btn nav-link animate-underline text-decoration-none px-0" href="#!">
              <span class="animate-target">View all</span>
              <i class="ci-chevron-right fs-base ms-1"></i>
            </a>
          </div>
        </div>
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
  });

</script>