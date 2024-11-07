<script src="{{ asset('client/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('client/vendor/timezz/timezz.js') }}"></script>

<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('client/js/theme.min.js') }}"></script>

{{-- thay đổi chữ theo màu sắc của chi tiết sản phẩm --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorOptions = document.querySelectorAll('input[name="color-options"]');
        const colorOptionLabel = document.getElementById('colorOption');

        colorOptions.forEach(option => {
            option.addEventListener('change', function() {
                if (this.checked) {
                    colorOptionLabel.textContent = this.getAttribute('data-color-name');
                }
            });
        });
    });
</script>

{{-- chuyển đổi giá và dung lượng theo màu sắc và dung lượng của biến thể --}}
<script>
    // Chuyển các biến thể sản phẩm thành JSON để JavaScript có thể sử dụng
    document.addEventListener('DOMContentLoaded', function() {
        const basePriceElement = document.getElementById('productPrice');
        const quantityValueElement = document.getElementById('quantityValue');
        const quantityContainer = document.getElementById('quantityContainer');

        // Hàm định dạng giá theo kiểu number_format (VNĐ)
        function formatPrice(price) {
            return price.toLocaleString('vi-VN', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }) + ' đ';
        }

        // Hàm cập nhật số lượng và hiển thị/ẩn container số lượng
        function updateQuantity() {
            const selectedCapacity = document.querySelector('input[name="model-options"]:checked');
            const selectedColor = document.querySelector('input[name="color-options"]:checked');

            if (selectedCapacity && selectedColor) {
                const capacityId = selectedCapacity.value;
                const colorId = selectedColor.value;

                // Tìm biến thể phù hợp với dung lượng và màu sắc đã chọn
                const selectedVariant = variants.find(variant =>
                    variant.capacity_id == capacityId && variant.color_id == colorId
                );

                if (selectedVariant) {
                    // Cập nhật số lượng
                    quantityValueElement.textContent = selectedVariant.stock;
                    quantityContainer.style.display = 'block'; // Hiện container số lượng
                } else {
                    quantityValueElement.textContent = 0;
                    quantityContainer.style.display = 'none'; // Ẩn nếu không có biến thể
                }
            } else {
                quantityValueElement.textContent = 0;
                quantityContainer.style.display = 'none'; // Ẩn container
            }
        }

        // Hàm cập nhật giá
        function updatePrice() {
            const selectedCapacity = document.querySelector('input[name="model-options"]:checked');
            const selectedColor = document.querySelector('input[name="color-options"]:checked');

            if (selectedCapacity && selectedColor) {
                const capacityId = selectedCapacity.value;
                const colorId = selectedColor.value;

                // Tìm biến thể phù hợp với dung lượng và màu sắc đã chọn
                const selectedVariant = variants.find(variant =>
                    variant.capacity_id == capacityId && variant.color_id == colorId
                );

                if (selectedVariant) {
                    // Cập nhật giá 
                    basePriceElement.textContent = formatPrice(Number(selectedVariant.price_difference));
                } else {
                    basePriceElement.textContent = formatPrice(Number(basePriceElement.getAttribute(
                        'data-base-price')));
                }
            }
        }

        // Hàm để kiểm tra và vô hiệu hóa các tùy chọn dung lượng khi màu sắc được chọn
        function updateCapacityOptions() {
            const selectedColor = document.querySelector('input[name="color-options"]:checked');
            const capacityOptions = document.querySelectorAll('input[name="model-options"]');

            if (selectedColor) {
                const colorId = selectedColor.value;

                capacityOptions.forEach(option => {
                    const capacityId = option.value;
                    // Tìm biến thể với dung lượng và màu sắc hiện tại
                    const matchingVariant = variants.find(variant =>
                        variant.capacity_id == capacityId && variant.color_id == colorId
                    );

                    if (!matchingVariant || matchingVariant.stock == 0) {
                        // Nếu không có biến thể hoặc hết hàng, vô hiệu hóa và làm mờ dung lượng
                        option.disabled = true;
                        option.nextElementSibling.classList.add('disabled');
                    } else {
                        // Nếu có hàng, bỏ hiệu ứng làm mờ
                        option.disabled = false;
                        option.nextElementSibling.classList.remove('disabled');
                    }
                });

                // Nếu dung lượng đã chọn bị vô hiệu hóa thì chọn dung lượng khác
                const selectedCapacity = document.querySelector('input[name="model-options"]:checked');
                if (selectedCapacity && selectedCapacity.disabled) {
                    const firstEnabledOption = document.querySelector(
                        'input[name="model-options"]:not([disabled])');
                    if (firstEnabledOption) {
                        firstEnabledOption.checked = true;
                    }
                }
            }
        }

        // Gắn sự kiện thay đổi giá, số lượng và kiểm tra dung lượng khi chọn dung lượng hoặc màu sắc
        document.querySelectorAll('input[name="model-options"]').forEach(option => {
            option.addEventListener('change', () => {
                updatePrice();
                updateQuantity(); // Cập nhật số lượng khi thay đổi dung lượng
            });
        });

        document.querySelectorAll('input[name="color-options"]').forEach(option => {
            option.addEventListener('change', () => {
                updatePrice();
                updateQuantity(); // Cập nhật số lượng khi thay đổi màu sắc
                updateCapacityOptions
            (); // Cập nhật trạng thái các dung lượng khi thay đổi màu sắc
            });
        });

        // Khởi tạo giá, số lượng và trạng thái dung lượng lúc đầu 
        updatePrice();
        updateQuantity();
        updateCapacityOptions();
    });
</script>

{{-- tăng số lượng sản phẩm trong giỏ hàng --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
          document.querySelectorAll('.btn-icon').forEach(function (button) {
              button.addEventListener('click', function () {
                  const isIncrement = this.hasAttribute('data-increment');
                  const input = this.closest('.count-input').querySelector('input');
                  let quantity = parseInt(input.value);

                  if (isIncrement) {
                      quantity++;
                  } else if (quantity > 1) {
                      quantity--;
                  }

                  // Ngăn gọi lại sự kiện khi đang xử lý
                  this.setAttribute('disabled', 'true');
                  input.value = quantity;

                  // Dữ liệu để gửi AJAX
                  const productId = this.closest('tr').dataset.productId;
                  const modelId = this.closest('tr').dataset.modelId;
                  const colorId = this.closest('tr').dataset.colorId;

                  // Cập nhật giỏ hàng qua AJAX
                  updateCart(productId, modelId, colorId, quantity)
                      .finally(() => {
                          // Bỏ thuộc tính disabled sau khi hoàn thành
                          this.removeAttribute('disabled');
                      });
              });
          });
      });

      function updateCart(productId, modelId, colorId, quantity) {
          return fetch('{{ route("cart.update") }}', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({ productId, modelId, colorId, quantity })
          })
          .then(response => response.json())
          .then(data => {
              // Cập nhật giao diện
              document.querySelector(`#itemTotal-${productId}-${modelId}-${colorId}`).textContent = data.itemTotal;
              document.querySelector(`#totalPrice`).textContent = data.totalPrice;
          })
          .catch(error => console.error('Error:', error));
      }

</script>


{{-- tính tóm tắt đơn hàng trong giỏ hàng  --}}
<script>
    // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    function updateCartQuantity(productId, modelId, colorId, quantity) {
      $.ajax({
          url: '/cart/update-quantity',
          type: 'POST',
          data: {
              productId: productId,
              modelId: modelId,
              colorId: colorId,
              quantity: quantity,
              _token: '{{ csrf_token() }}' // Token bảo mật cho yêu cầu POST
          },
          success: function(response) {
              // Cập nhật tổng tiền của sản phẩm
              $('#itemTotal-' + productId + '-' + modelId + '-' + colorId).text(response.itemTotal);

              // Cập nhật tổng tiền và tổng số lượng trong phần tóm tắt đơn hàng
              $('#totalQuantity').text(response.totalQuantity);
              $('#totalPrice').text(response.totalPrice);
          },
          error: function() {
              alert('Có lỗi xảy ra. Vui lòng thử lại.');
          }
    });
    }

    // Gọi hàm updateCartQuantity khi thay đổi số lượng
    $('.quantity-input').on('change', function() {
        const productId = $(this).data('product-id');
        const modelId = $(this).data('model-id');
        const colorId = $(this).data('color-id');
        const quantity = $(this).val();

        updateCartQuantity(productId, modelId, colorId, quantity);
    });
</script>