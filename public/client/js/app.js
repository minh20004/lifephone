$(document).ready(function() {
    // Lắng nghe sự kiện thay đổi của filter
    $('.category-filter, .capacity-checkbox, .range-slider input, .color-filter').on('change', function() {
        filterProducts();
    });

    function filterProducts() {
        // Lấy các giá trị lọc
        var categoryId = $('.category-filter:checked').data('category-id'); // For category
        var minPrice = $('#min_price').val();
        var maxPrice = $('#max_price').val();
        
        // Lấy các giá trị capacity đã chọn
        var capacities = [];
        $('.capacity-checkbox:checked').each(function() {
            capacities.push($(this).val());
        });
        
        // Lấy các giá trị color đã chọn
        var colors = [];
        $('.color-filter:checked').each(function() {
            colors.push($(this).data('color-id'));
        });

        // Debug các giá trị trước khi gửi
        console.log('Category ID: ', categoryId);
        console.log('Min Price: ', minPrice);
        console.log('Max Price: ', maxPrice);
        console.log('Capacities: ', capacities);
        console.log('Colors: ', colors);

        // Gửi Ajax request tới server
        $.ajax({
            url: "{{ route('filter.products') }}", // Đảm bảo rằng đường dẫn này chính xác
            method: 'GET',
            data: {
                category_id: categoryId,
                min_price: minPrice,
                max_price: maxPrice,
                capacities: capacities,
                colors: colors
            },
            success: function(response) {
                // Kiểm tra xem có gì được trả về từ server
                console.log('Response:', response);
                
                // Cập nhật lại danh sách sản phẩm
                $('#product-list').html(response.html); // Đảm bảo server trả về đúng HTML
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                alert('Lỗi khi lọc sản phẩm');
            }
        });
    }
});
