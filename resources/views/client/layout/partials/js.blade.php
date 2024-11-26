
<script src="{{ asset('client/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('client/vendor/timezz/timezz.js') }}"></script>

<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('client/js/theme.min.js') }}"></script>

<script>
  function toggleChatPopup() {
      const chatPopup = document.getElementById('chatPopup');
      chatPopup.style.display = chatPopup.style.display === 'none' || chatPopup.style.display === '' ? 'block' : 'none';
  }

  function startChat() {
      const userName = document.getElementById('userName').value;
      const userPhone = document.getElementById('userPhone').value;

      // Kiểm tra các trường bắt buộc
      if (userName.trim() === '' || userPhone.trim() === '') {
          alert('Vui lòng nhập tên và số điện thoại của bạn');
          return;
      }

      // Ẩn form nhập thông tin và hiển thị hộp thoại chat
      document.getElementById('infoForm').style.display = 'none';
      document.getElementById('chatContainer').style.display = 'block';
  }

  function sendMessage() {
      const messageInput = document.getElementById("messageInput");
      const chatMessages = document.getElementById("chatMessages");

      const message = messageInput.value.trim();
      if (message) {
          // Tạo phần tử tin nhắn mới và thêm vào chat
          const newMessage = document.createElement('div');
          newMessage.className = 'message sent';
          newMessage.innerHTML = `<p>${message}</p><span class="timestamp">${new Date().toLocaleTimeString()}</span>`;
          chatMessages.appendChild(newMessage);

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
{{-- Hàm tăng giảm số lượng sản phẩm trong giỏ hàng --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-icon').forEach(function(button) {
            button.addEventListener('click', function() {
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
        return fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    productId,
                    modelId,
                    colorId,
                    quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                // Cập nhật giao diện
                document.querySelector(`#itemTotal-${productId}-${modelId}-${colorId}`).textContent = data
                .itemTotal;
                document.querySelector(`#totalPrice`).textContent = data.totalPrice;

                // Cập nhật tổng tiền sau giảm giá nếu có voucher
                if (data.totalAfterDiscount !== undefined) {
                    document.querySelector(`#totalAfterDiscount`).textContent = data.totalAfterDiscount;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>




