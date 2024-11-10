<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    $(document).ready(function() {
        // Hàm gửi yêu cầu AJAX
        function filterProducts() {
            var minPrice = $('#min_price').val();
            var maxPrice = $('#max_price').val();

            $.ajax({
                url: '{{ route("filter.price") }}', // Đảm bảo route này đúng với route bạn đã tạo
                method: 'GET',
                data: {
                    min_price: minPrice,
                    max_price: maxPrice,
                },
                success: function(response) {
                    $('#product-list').empty(); // Xóa danh sách sản phẩm trước đó
                    if (response.length) {
                        response.forEach(function(product) {
                            $('#product-list').append('<div>' + product.name + ' - ' + product.price + '</div>');
                        });
                    } else {
                        $('#product-list').append('<div>Không có sản phẩm nào trong khoảng giá này.</div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        }

        // Gửi yêu cầu khi người dùng thay đổi giá
        $('#min_price, #max_price').on('input', function() {
            filterProducts();
        });
    });
    
