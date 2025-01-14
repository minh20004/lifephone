@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">

    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home-electronics.html">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="shop-catalog-electronics.html">Sản phẩm</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
      </ol>
    </nav>


    <!-- Items in the cart + Order summary -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
      <h1 class="h3 mb-4">Giỏ hàng</h1>
      <div class="row">

        <!-- Items list -->
        <div class="col-lg-8">
          <div class="pe-lg-2 pe-xl-3 me-xl-3">
            {{-- cảnh báo vượt quá số lượng --}}
            @if($errors->has('quantity'))
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach($errors->get('quantity') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="progress w-100 overflow-visible mb-4" role="progressbar" aria-label="Free shipping progress" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="height: 4px">
              <div class="progress-bar bg-warning rounded-pill position-relative overflow-visible" style="width: 75%; height: 4px">
                <div class="position-absolute top-50 end-0 d-flex align-items-center justify-content-center translate-middle-y bg-body border border-warning rounded-circle me-n1" style="width: 1.5rem; height: 1.5rem">
                  <i class="ci-star-filled text-warning"></i>
                </div>
              </div>
            </div>


      @if(count($cartItems) > 0)
            <table class="table position-relative z-2 mb-4">
              <thead>
                <tr>
                  <th scope="col" class="fs-sm fw-normal py-3 ps-0">
                    <input type="checkbox" id="select-all" />
                  </th>
                  <th scope="col" class="fs-sm fw-normal py-3 ps-0"><span class="text-body">Sản phẩm</span></th>
                  <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-xl-table-cell"><span class="text-body">Giá</span></th>
                  <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span class="text-body">Số lượng</span></th>
                  <th scope="col" class="text-body fs-sm fw-normal py-3 d-none d-md-table-cell"><span class="text-body">Tổng cộng</span></th>
                  <th scope="col" class="py-0 px-0">
                    <div class="nav justify-content-end">
                      <button type="button" class="nav-link d-inline-block text-decoration-underline py-3 px-0">Xóa</button>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody class="align-middle">

                <!-- Item -->
                @foreach ($cartItems as $item)
                  <tr data-product-id="{{ $item['product']->id }}" data-model-id="{{ $item['capacity']->id }}" data-color-id="{{ $item['color']->id }}">
                    <td class="py-3 ps-0">
                      <input type="checkbox" class="item-select-cart" data-id="{{ $item['product']->id }}-{{ $item['capacity']->id }}-{{ $item['color']->id }}" data-prices="{{ $item['price'] }}" />
                    </td>
                    <td class="py-3 ps-0">
                      <div class="d-flex align-items-center">
                        <a class="flex-shrink-0" href="shop-product-general-electronics.html">
                          <img src="{{ asset('storage/' . $item['product']->image_url) }}" width="110" alt="iPhone 14">
                        </a>
                        <div class="w-100 min-w-0 ps-2 ps-xl-3">
                          <h5 class="d-flex animate-underline mb-2">
                            <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">{{ $item['product']->name }}</a>
                          </h5>
                          <ul class="list-unstyled gap-1 fs-xs mb-0">
                            <li><span class="text-body-secondary">Màu sắc:</span> <span class="text-dark-emphasis fw-medium">{{ $item['color']->name }}</span></li>
                            <li><span class="text-body-secondary">Dung lượng:</span> <span class="text-dark-emphasis fw-medium">{{ $item['capacity']->name }}</span></li>
                          </ul>
                          <div class="count-input rounded-2 d-md-none mt-3">
                            <div class="input-group input-group-sm count-input">
                              <button class="btn btn-outline-secondary btn-decrement" type="button">−</button>
                              <input type="number" value="{{ $item['quantity'] }}" class="form-control" readonly min="1" max="5">
                              <button class="btn btn-outline-secondary btn-increment" type="button">+</button>
                          </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="h6 py-3 d-none d-xl-table-cell">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                    <td class="py-3 d-none d-md-table-cell">

                      <div class="count-input" style="display: flex; align-items: center; border: 1px solid #d1d5db; border-radius: 8px; width: 120px; justify-content: space-between; padding: 5px;">
                          <button type="button" class="btn-decrement" style="background: none; border: none; font-size: 20px; cursor: pointer;">−</button>
                          <input type="number" class="quantity-input" data-id="{{ $item['product']->id }}-{{ $item['capacity']->id }}-{{ $item['color']->id }}" value="{{ $item['quantity'] }}" readonly style="width: 60px; text-align: center; border: none; outline: none; font-size: 16px;">
                          <button type="button" class="btn-increment" style="background: none; border: none; font-size: 20px; cursor: pointer;">+</button>
                      </div>

                    </td>
                    <td class="h6 py-3 d-none d-md-table-cell" id="itemTotal-{{ $item['product']->id }}-{{ $item['capacity']->id }}-{{ $item['color']->id }}">{{ number_format($item['itemTotal'], 0, ',', '.') }} đ</td>
                    <td class="text-end py-3 px-0">
                      <form action="{{ route('cart.remove', ['productId' => $item['product']->id, 'modelId' => $item['capacity']->id, 'colorId' => $item['color']->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-close fs-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không ?')"></button>
                      </form>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
      @else
      <p>Giỏ hàng của bạn hiện đang trống.</p>
      @endif
      <div class="nav position-relative z-2 mb-4 mb-lg-0">
        <a class="nav-link animate-underline px-0" href="{{route('home')}}">
          <i class="ci-chevron-left fs-lg me-1"></i>
          <span class="animate-target">Tiếp tục mua sắm</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Tóm tắt đơn hàng (sticky sidebar) -->
  <aside class="col-lg-4" style="margin-top: -100px">
    <div class="position-sticky top-0" style="padding-top: 100px">
      <div class="bg-body-tertiary rounded-5 p-4 mb-3">
        <div class="p-sm-2 p-lg-0 p-xl-2">
          <h5 class="border-bottom pb-4 mb-4">Tóm tắt đơn hàng</h5>
          <ul class="list-unstyled fs-sm gap-3 mb-0">
            <li class="d-flex justify-content-between">
              <span id="totalQuantity">(Tổng cộng <b>{{ $totalQuantity }}</b> sản phẩm):</span>
              <span class="text-dark-emphasis fw-medium"><span id="totalPrice">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
            </li>
            <li class="d-flex justify-content-between">
              Giảm giá:
              <span class="text-dark-emphasis fw-medium">Tính Toán khi thanh toán</span>
            </li>
          </ul>
          <div class="border-top pt-4 mt-4">
            <div class="d-flex justify-content-between mb-3">
              <span class="fs-sm">Tổng ước tính:</span>
              <span class="h5 mb-0"><span id="totalAfterDiscount">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
            </div>
            <a id="checkout-btn" class=" btn btn-lg btn-primary w-100" href="{{ route('checkout') }}">
              Tiến hành thanh toán
              <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </aside>
    </section>
  </main>
  <!-- Back to top button -->
  <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
    <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
      Top
      <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
      <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
      <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></rect>
      </svg>
    </a>
    <a class="btn btn-sm btn-outline-secondary text-uppercase bg-body rounded-pill shadow animate-rotate ms-2 me-n5" href="#customizer" style="font-size: .625rem; letter-spacing: .05rem;" data-bs-toggle="offcanvas" role="button" aria-controls="customizer">
      Customize<i class="ci-settings fs-base ms-1 me-n2 animate-target"></i>
    </a>
  </div>
@endsection
<script>

  var customer_id = @if(Auth::guard('customer')->check())
                        {{ Auth::guard('customer')->user()->id }};
                      @else
                        null;  // Hoặc giá trị mặc định khác nếu muốn
                      @endif
  window.onload = function() {
    if(customer_id == null){
      var checkboxes = document.querySelectorAll('.item-select-cart');
      var checkAll = document.getElementById('select-all');

      checkboxes.forEach(function(checkbox) {
          // Lấy thẻ cha trực tiếp của checkbox
          var wrapper = checkbox.parentNode;
          var checkAllWrapper = checkAll.parentNode;
          // Nếu người dùng chưa đăng nhập, disable và ẩn thẻ cha
          checkbox.disabled = true;
          wrapper.style.display = 'none';

          checkAll.disabled = true;// Ẩn thẻ cha
          checkAllWrapper.style.display = 'none';
      });
    }
  };
  // Hàm để lấy danh sách sản phẩm được chọn từ localStorage
  function getSelectedProducts() {
      let selectedProducts = localStorage.getItem('selectedProducts');
      if (selectedProducts) {
          return JSON.parse(selectedProducts);
      }
      return [];
  }

  // Hàm để lưu danh sách sản phẩm được chọn vào localStorage
  function saveSelectedProducts(selectedProducts) {
      localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
  }

  // Hàm để cập nhật trạng thái của checkbox khi tải lại trang
  function updateCheckboxes() {
      const selectedProducts = getSelectedProducts();
      console.log('Danh sách sản phẩm được chọn', selectedProducts);
      const checkboxes = document.querySelectorAll('.item-select-cart');
      checkboxes.forEach(checkbox => {
        const productId = checkbox.dataset.id; // Lấy id sản phẩm từ data-id

        if (!selectedProducts.includes(productId)) {
          selectedProducts.push(productId);
        }
        checkbox.checked = true;
      });

      if(selectedProducts.length == 0)  document.getElementById('checkout-btn')?.disabled = true;
      
      localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
      console.log('Cập nhật trạng thái của checkbox thành công',checkboxes);

      $.ajax({
          url: '/api/update-cart-check-status',
          method: 'POST',
          data: {
            selected_items: selectedProducts,
            customer_id: customer_id
          },
          xhrFields: {
              withCredentials: true // Đảm bảo cookie được gửi kèm trong yêu cầu
          },
          success: function(response) {
            console.log('Cập nhật giỏ hàng thành công', response);
          },
          error: function(error) {
              console.error('Có lỗi xảy ra', error);
          }
      });
  }

  // Hàm để xử lý khi checkbox thay đổi trạng thái
  function handleCheckboxChange(event) {
      const checkbox = event.target;
      const productId = checkbox.dataset.id; // Lấy id sản phẩm từ data-id
      let selectedProducts = getSelectedProducts();

      if (checkbox.checked) {
          if (!selectedProducts.includes(productId)) {
              selectedProducts.push(productId);
          }
      } else {
          selectedProducts = selectedProducts.filter(id => id !== productId);
      }

      if(selectedProducts.length == 0)  document.getElementById('checkout-btn')?.disabled = true;

      console.log('Danh sách sản phẩm được chọn', selectedProducts);

      $.ajax({
          url: '/api/update-cart-check-status',
          method: 'POST',
          data: {
            selected_items: selectedProducts,
            customer_id: customer_id
          },
          success: function(response) {
              console.log('Cập nhật giỏ hàng thành công', response);
              // alert('Cập nhật giỏ hàng thành công');
          },
          error: function(error) {
              console.error('Có lỗi xảy ra', error);
          }
      });

      // Lưu lại mảng mới vào localStorage
      saveSelectedProducts(selectedProducts);
  }

  // Hàm để xử lý checkbox "Chọn tất cả"
  function handleSelectAllChange(event) {
      const checkboxes = document.querySelectorAll('.item-select-cart');
      const selectAllCheckbox = event.target;
      let selectedProducts = [];

      checkboxes.forEach(checkbox => {
          checkbox.checked = selectAllCheckbox.checked;
          const productId = checkbox.dataset.id;
          if (checkbox.checked && !selectedProducts.includes(productId)) {
              selectedProducts.push(productId);
          }
      });

      // Lưu lại mảng mới vào localStorage
      saveSelectedProducts(selectedProducts);
  }

  // Gắn sự kiện cho checkbox "Chọn tất cả"
  setTimeout(() => {
      document.getElementById('select-all').addEventListener('change', handleSelectAllChange);
      document.querySelectorAll('.item-select-cart').forEach(checkbox => {
          checkbox.addEventListener('change', handleCheckboxChange);
      });
      document.querySelectorAll('.item-select-cart').forEach(checkbox => {
          checkbox.addEventListener('change', updateCartSummary);
      });
      updateCartSummary(false);

      console.log('Gắn sự kiện cho các checkbox thành công');
  }, 500);

  // Gắn sự kiện cho các checkbox của từng sản phẩm

  // Cập nhật trạng thái checkbox khi trang được tải lại
  window.addEventListener('load', updateCheckboxes);

  // Hàm để cập nhật tổng số lượng và tổng giá
function updateCartSummary(isChange = true) {
    // Lấy tất cả các checkbox sản phẩm đã chọn
    let selectedCheckboxes;
    console.log('isChange', isChange);
    if (!isChange) {
      selectedCheckboxes = document.querySelectorAll('.item-select-cart');
    } else {
      selectedCheckboxes = document.querySelectorAll('.item-select-cart:checked');
    }
    // Tính tổng số lượng và tổng giá trị của các sản phẩm được chọn
    let totalQuantity = 0;
    let totalPrice = 0;

    selectedCheckboxes.forEach(checkbox => {
        const productId = checkbox.dataset.id; // Lấy ID sản phẩm từ data-id
        const productPrice = parseFloat(checkbox.dataset.prices); // Lấy giá sản phẩm từ data-price
        const productQuantity = parseFloat(document.querySelector('.quantity-input[data-id="' + productId + '"]').value); // Lấy số lượng sản phẩm từ data-quantity
        console.log('Giá sản phẩm', productPrice, productId, productQuantity);
        totalQuantity += productQuantity; // Cộng tổng số lượng
        totalPrice += productPrice * productQuantity; // Cộng tổng giá trị
    });

    // Cập nhật hiển thị tổng số lượng và tổng giá trị
    document.getElementById('totalQuantity').textContent = `Tổng cộng ${totalQuantity} sản phẩm:`;
    document.getElementById('totalPrice').textContent = `${numberWithCommas(totalPrice)} đ`;

    // Cập nhật tổng giá sau giảm giá (giả sử không có giảm giá trong trường hợp này)
    document.getElementById('totalAfterDiscount').textContent = `${numberWithCommas(totalPrice)} đ`;
  }

  // Hàm chuyển đổi giá trị số thành định dạng có dấu phân cách ngàn
  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  // Gắn sự kiện thay đổi cho các checkbox


  // Gọi hàm để cập nhật khi trang được tải


</script>