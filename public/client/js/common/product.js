$('.search-header').keydown(function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();

    var searchTerm = $(this).val().trim();

    if (searchTerm) {
      var searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || [];

      if (!searchHistory.includes(searchTerm)) {
        searchHistory.unshift(searchTerm);

        if (searchHistory.length > 10) {
          searchHistory.pop();
        }
        localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
      }
      window.location.href = '/products?search=' + encodeURIComponent(searchTerm);
    }
  }
});
$('.search-header').on('click', function() {
  let searchRecent = JSON.parse(localStorage.getItem('searchHistory')) || [];
  // Lấy dropdown (hoặc tạo mới nếu chưa có)
  var dropdown = $('.search-history-dropdown');

  if (dropdown.length === 0) {
    dropdown = $('<div class="search-history-dropdown position-absolute w-100 bg-white border border-1 rounded-3 mt-1"></div>');
    $(this).parent().append(dropdown);  // Thêm vào bên cạnh ô tìm kiếm
  }

  dropdown.empty();

  // Thêm các từ tìm kiếm vào dropdown
  if (searchRecent.length > 0) {
    $('.search-history-dropdown').show();
    $('.search-history-dropdown').css('z-index', '1000');
    let text_recent = $('<div class="py-2 ps-3 pe-5" style="line-height:1.5;"> Lich su tim kiem </div>');
    dropdown.append(text_recent);
    searchRecent.forEach(function(term) {
      var listItem = $('<div class="py-2 ps-3 pe-5 cursor-pointer" style="line-height:1.5;"></div>').text(term);

      listItem.click(function() {
        $('.search-header').val(term);
        $('.search-header').focus();
        dropdown.empty();
      });

      listItem.hover(
        function() {
          $(this).addClass('highlight');
        },
        function() {
          $(this).removeClass('highlight');
        }
      );


      dropdown.append(listItem);
    });
  } else {
    dropdown.append('<div class="py-2 px-3">No search history found</div>');
    $('.search-history-dropdown').show();
  }
});
$('.search-header').on('blur', function() {
  var dropdown = $('.search-history-dropdown');
  setTimeout(function() {
      dropdown.empty();  // Ẩn dropdown khi mất focus
      dropdown.hide();
      dropdown.css('z-index', '0');
  }, 200); // Delay nhỏ để đảm bảo click vào mục trong dropdown không bị ẩn ngay lập tức
});
