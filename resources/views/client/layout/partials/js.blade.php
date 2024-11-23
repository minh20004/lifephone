<script src="{{ asset('client/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('client/vendor/timezz/timezz.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap + Theme scripts -->
<!-- Vendor scripts -->
<script src="{{ asset('client/vendor/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('client/js/theme.min.js') }}"></script>

<script src="{{ asset('client/js/common/product.js') }}"></script>

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

        // Hàm cập nhật giá thấp nhất dựa trên các màu sắc và dung lượng còn hàng
        function updateLowestPrice() {
            const availableVariants = variants.filter(variant => variant.stock > 0);
            if (availableVariants.length > 0) {
                const lowestPrice = Math.min(...availableVariants.map(variant => variant.price_difference));
                basePriceElement.textContent = formatPrice(lowestPrice);
            } else {
                basePriceElement.textContent = "Hết hàng";
            }
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

                if (selectedVariant && selectedVariant.stock > 0) {
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
                    updateLowestPrice(); // Nếu không tìm thấy biến thể hoặc hết hàng, cập nhật giá thấp nhất
                }
            } else {
                updateLowestPrice(); // Cập nhật giá thấp nhất nếu không có dung lượng hoặc màu sắc được chọn
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
                    const firstEnabledOption = document.querySelector('input[name="model-options"]:not([disabled])');
                    if (firstEnabledOption) {
                        firstEnabledOption.checked = true;
                        updatePrice(); // Cập nhật giá ngay khi chọn dung lượng mới
                        updateQuantity(); // Cập nhật số lượng ngay khi chọn dung lượng mới
                    }
                } else {
                    // Đảm bảo số lượng được cập nhật ngay cả khi dung lượng hiện tại không bị vô hiệu hóa
                    updateQuantity();
                }
            }
        }

        // Hàm kiểm tra và vô hiệu hóa màu sắc nếu tất cả dung lượng của màu đó hết hàng
        function updateColorOptions() {
            const colorOptions = document.querySelectorAll('input[name="color-options"]');

            colorOptions.forEach(option => {
                const colorId = option.value;
                const hasStock = variants.some(variant => variant.color_id == colorId && variant.stock > 0);

                if (!hasStock) {
                    option.disabled = true;
                    option.nextElementSibling.classList.add('disabled');
                } else {
                    option.disabled = false;
                    option.nextElementSibling.classList.remove('disabled');
                }
            });
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
                updateCapacityOptions(); // Cập nhật trạng thái các dung lượng khi thay đổi màu sắc
                updateColorOptions(); // Cập nhật trạng thái các màu sắc
            });
        });

        // Khởi tạo giá, số lượng và trạng thái dung lượng lúc đầu
        updatePrice();
        updateQuantity();
    });
</script>
{{-- Hàm tăng giảm số lượng sản phẩm trong giỏ hàng --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Xử lý sự kiện thay đổi số lượng
    document.querySelectorAll('.btn-decrement, .btn-increment').forEach(function (button) {
        button.addEventListener('click', function () {
            const isIncrement = this.classList.contains('btn-increment');
            const input = this.closest('.count-input').querySelector('input');
            let quantity = parseInt(input.value);

            // Tăng hoặc giảm số lượng
            if (isIncrement) {
                quantity++;
            } else if (quantity > 1) {
                quantity--;
            }

            // Cập nhật giá trị trong ô input
            input.value = quantity;

            // Lấy thông tin sản phẩm và biến thể
            const productId = this.closest('tr').dataset.productId;
            const modelId = this.closest('tr').dataset.modelId;
            const colorId = this.closest('tr').dataset.colorId;

            // Gọi AJAX để cập nhật giỏ hàng
            updateCart(productId, modelId, colorId, quantity);
        });
    });
    });

    // Hàm cập nhật giỏ hàng và giao diện
    
    function updateCart(productId, modelId, colorId, quantity) {
    fetch('{{ route('cart.update') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ productId, modelId, colorId, quantity })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) { // Thêm kiểm tra nếu API trả về success
                // Cập nhật tổng tiền của sản phẩm
                document.querySelector(`#itemTotal-${productId}-${modelId}-${colorId}`).textContent = data.itemTotal;

                // Cập nhật tổng tiền giỏ hàng và các giá trị liên quan
                document.querySelector('#totalPrice').textContent = data.totalPrice;
                document.querySelector('#totalAfterDiscount').textContent = data.totalAfterDiscount;
                document.querySelector('#discount').textContent = data.discount;

                // Cập nhật tổng số lượng sản phẩm trong giỏ hàng
                if (data.totalQuantity !== undefined) {
                    document.querySelector('#cartTotalQuantity').textContent = data.totalQuantity;
                }
            } else {
                console.error('Lỗi khi cập nhật giỏ hàng:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

</script>
<script>
    function updateCart(productId, modelId, colorId, quantity) {
        fetch('{{ route('cart.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ productId, modelId, colorId, quantity })
        })
            .then(response => response.json())
            .then(data => {
                // Cập nhật tổng tiền của sản phẩm
                document.querySelector(`#itemTotal-${productId}-${modelId}-${colorId}`).textContent = data.itemTotal;

                // Cập nhật tổng giỏ hàng và tổng ước tính sau giảm giá
                document.querySelector('#totalPrice').textContent = data.totalPrice;
                document.querySelector('#totalAfterDiscount').textContent = data.totalAfterDiscount;
                document.querySelector('#discount').textContent = data.discount;

                // Hiển thị số lượng tổng cộng (nếu cần)
                if (data.totalQuantity !== undefined) {
                    document.querySelector('#cartTotalQuantity').textContent = data.totalQuantity;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>