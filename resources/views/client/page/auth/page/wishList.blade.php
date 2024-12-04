@extends('client/page/auth/layout/master')

@section('content_customer')

  <div class="ps-lg-3 ps-xl-0">

    <!-- Page title + Add list button-->
    <div class="d-flex align-items-center justify-content-between pb-3 mb-1 mb-sm-2 mb-md-3">
      <h1 class="h2 me-3 mb-0">Danh sách sản phẩm yêu thích</h1>
    </div>
    <!-- Wishlist selector -->
    <div class="border-bottom pb-4 mb-3">
      <div class="row align-items-center justify-content-between">
        <div class="col-sm-7 col-md-8 col-xxl-9 d-flex align-items-center mb-3 mb-sm-0">
          {{-- <h5 class="me-2 mb-0">Sản phẩm yêu thích</h5> --}}
          <div class="dropdown ms-auto ms-sm-0">
            <div class="dropdown-menu dropdown-menu-end">
              <div class="d-flex flex-column gap-1 mb-2">
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="wishlist-1" name="wishlist" checked="">
                  <label for="wishlist-1" class="form-check-label text-body">Interesting offers</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="wishlist-2" name="wishlist">
                  <label for="wishlist-2" class="form-check-label text-body">Top picks collection</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="wishlist-3" name="wishlist">
                  <label for="wishlist-3" class="form-check-label text-body">Family stuff</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="wishlist-4" name="wishlist">
                  <label for="wishlist-4" class="form-check-label text-body">My must-haves</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="wishlist-5" name="wishlist">
                  <label for="wishlist-5" class="form-check-label text-body">For my husband</label>
                </div>
              </div>
              <button type="button" class="btn btn-sm btn-dark w-100" onclick="document.getElementById('wishlist-selector').click()">Select wishlist</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Master checkbox + Action buttons -->
    <div class="nav align-items-center mb-4">
      <div class="form-checkl nav-link animate-underline fs-lg ps-0 pe-2 py-2 mt-n1 me-4" data-master-checkbox="{&quot;container&quot;: &quot;#wishlistSelection&quot;, &quot;label&quot;: &quot;Select all&quot;, &quot;labelChecked&quot;: &quot;Unselect all&quot;, &quot;showOnCheck&quot;: &quot;#action-buttons&quot;}">
        <input type="checkbox" id="selectAllCheckbox" />
        <label for="wishlist-master" class="form-check-label animate-target mt-1 ms-2">Chọn tất cả</label>
      </div>
      <div class="d-flex flex-wrap" id="action-buttons">
        <a class="nav-link animate-underline px-0 py-2 delete-selected" href="#!">
          <i class="ci-trash fs-base me-1"></i>
          <span class="animate-target d-none d-md-inline">Xóa đã chọn</span>
        </a>
      </div>
    </div>

    <!-- Wishlist items (Grid) -->
    <div class="row row-cols-2 row-cols-md-3 g-4" id="wishlistSelection">

    </div>
  </div>

  <script>

    let customerId = @json(Auth::guard('customer')->user()->id);
    console.log(customerId);



    $(document).ready(function(){
      const selectedProducts = [];
      const unselectedProducts = [];


      function getProduct()
      {
        $.ajax({
          url: '/api/favorites',  // Địa chỉ API GET
          type: 'GET',
          data: {
            customer_id: customerId,
          } ,
          success: function(response) {
            if (response.length > 0) {
              var htmlContent = '';
              console.log(response)

              response.forEach(function(item) {
                let product = item.product;
                htmlContent += `
                  <div class="col">
                    <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                      <div class="position-relative">
                        <div class="position-absolute top-0 end-0 z-1 pt-1 pe-1 mt-2 me-2">
                          <div class="form-check fs-lg">
                            <input type="checkbox" class="form-check-input select-card-check" data-id="${product.id}" >
                          </div>
                        </div>
                        <a class="d-block rounded-top overflow-hidden p-3 p-sm-4" href="/product/${product.id}">
                          <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2 mt-lg-3 ms-lg-3"></span>
                          <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                            <img src="${window.location.origin}/storage/${product.image_url}" alt="${product.name}">
                          </div>
                        </a>
                      </div>
                      <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                        <h3 class="pb-1 mb-2">
                          <a class="d-block fs-sm fw-medium text-truncate" href="/product/${product.id}">
                            <span class="animate-target">${product.name}</span>
                          </a>
                        </h3>
                        <div class="d-flex align-items-center justify-content-between">
                          <div class="h5 lh-1 mb-0">${product.price}</div>
                          <button type="button" class="product-card-button btn btn-icon btn-secondary animate-slide-end ms-2" aria-label="Add to Cart">
                            <i class="ci-shopping-cart fs-base animate-target"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                `;
              });
              $('#wishlistSelection').html(htmlContent);
            } else {
              $('#wishlistSelection').html('<p>Không có sản phẩm yêu thích.</p>');
            }
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Something went wrong while fetching favorites!');
          }
        });
      }

      getProduct();

      document.getElementById('selectAllCheckbox').addEventListener('change', (event) => {
        const isChecked = event.target.checked;

        document.querySelectorAll('.select-card-check').forEach((checkbox) => {
          checkbox.checked = isChecked;

          const productId = checkbox.getAttribute('data-id');

          if (isChecked) {
            if (!selectedProducts.includes(productId)) {
              selectedProducts.push(productId);
            }

            const unselectedIndex = unselectedProducts.indexOf(productId);
            if (unselectedIndex !== -1) {
              unselectedProducts.splice(unselectedIndex, 1);
            }
          } else {
            const selectedIndex = selectedProducts.indexOf(productId);
            if (selectedIndex !== -1) {
              selectedProducts.splice(selectedIndex, 1);
            }

            if (!unselectedProducts.includes(productId)) {
              unselectedProducts.push(productId);
            }
          }
        });

      });

      $(document).on('click', '.select-card-check', function() {
        const productId = $(this).attr('data-id');
        const isChecked = $(this).prop('checked');

        function toggleProductInLists(productId, isSelected) {
          const targetArray = isSelected ? selectedProducts : unselectedProducts;
          const oppositeArray = isSelected ? unselectedProducts : selectedProducts;

          if (!targetArray.includes(productId)) {
            targetArray.push(productId);
          }

          const oppositeIndex = oppositeArray.indexOf(productId);
          if (oppositeIndex !== -1) {
            oppositeArray.splice(oppositeIndex, 1);
          }
        }

        toggleProductInLists(productId, isChecked);

      });

      $('.delete-selected').click(function(){
        console.log(selectedProducts,unselectedProducts,'dele')
        delete_selectProduct();
      })


      function delete_selectProduct(notice = true){
        $.ajax({
            url: '/api/favorites/delete',
            type: 'POST',
            data: {
              customer_id: customerId,
              product_ids : selectedProducts,
            } ,
            success: function(response) {
              if(notice){
                alert(response.message);
              }
              selectedProducts = [];
              getProduct();
            },
            error: function(xhr, status, error){
              alert(error);
            }
          })
      }



      $('.addToCard').click(function(){
        $.ajax({
          url: '/api/favorites/addToCard',
          type: 'POST',
          data: {
            product_ids : selectedProducts,
          } ,
          success: function(response) {
            delete_selectProduct(false);
            getProduct();
            alert(response.message);
          },
          error: function(xhr, status, error){
            alert(error);
          }
        })
      })

    });
  </script>
@endsection