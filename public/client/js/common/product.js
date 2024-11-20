function search_recent() {
  var searchButton = $('.search-header');

  searchButton.on('click', function() {
      let val = $('.search_input').val();

      let recentSearches = JSON.parse(localStorage.getItem('recent_search')) || [];

      if (val && !recentSearches.includes(val)) {
          recentSearches.push(val);
          localStorage.setItem('recent_search', JSON.stringify(recentSearches));
      }

  });

}
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

      alert('Đã nhấn Enter hoặc Ok, từ tìm kiếm đã được lưu');
    }
  }
});
$('.search-header').on('click', function() {
  let searchRecent = JSON.parse(localStorage.getItem('searchHistory')) || [];
  // Lấy dropdown (hoặc tạo mới nếu chưa có)
  var dropdown = $('.search-history-dropdown');

  // Nếu dropdown chưa tồn tại, tạo mới nó
  if (dropdown.length === 0) {
    dropdown = $('<div class="search-history-dropdown position-absolute w-100 bg-white border border-1 rounded-3 mt-1"></div>');
    $(this).parent().append(dropdown);  // Thêm vào bên cạnh ô tìm kiếm
  }

  // Xóa nội dung cũ trong dropdown
  dropdown.empty();

  // Thêm các từ tìm kiếm vào dropdown
  if (searchRecent.length > 0) {
    $('.search-history-dropdown').show();
    searchRecent.forEach(function(term) {
      var listItem = $('<div class="py-2 px-3 cursor-pointer"></div>').text(term);

      // Khi người dùng click vào một từ trong lịch sử tìm kiếm
      listItem.click(function() {
        $('.search-header').val(term);
        dropdown.empty();  // Ẩn dropdown khi chọn từ tìm kiếm
      });

      dropdown.append(listItem);
    });
  } else {
    dropdown.append('<div class="py-2 px-3">No search history found</div>');
  }
});
