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
