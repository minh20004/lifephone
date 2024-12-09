$('.search-header').keydown(function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();

    var searchTerm = $(this).val().trim();

    if (searchTerm) {
      var searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || [];

      if (!searchHistory.includes(searchTerm)) {
        searchHistory.unshift(searchTerm);

        if (searchHistory.length > 5) {
          searchHistory.pop();
        }
        localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
      }
      window.location.href = '/search?search=' + encodeURIComponent(searchTerm);
    }
  }
});
$('.search-header').on('click', function() {
  let searchRecent = JSON.parse(localStorage.getItem('searchHistory')) || [];
  var dropdown = $('.search-history-dropdown');

  if (dropdown.length === 0) {
    dropdown = $('<div class="search-history-dropdown position-absolute w-100 bg-white border border-1 rounded-3 mt-1"></div>');
    $(this).parent().append(dropdown);
  }

  dropdown.empty();

  if (searchRecent.length > 0) {
    $('.search-history-dropdown').show();
    $('.search-history-dropdown').css('z-index', '1000');
    let text_recent = $('<div class="py-2 ps-3 pe-5" style="line-height:1.5;font-weight:700;"> Lịch sử tìm kiếm <i class="fa-regular fa-clock"></i></div>');
    let delete_recent = $('<div class="py-1 ps-2 pe-2 delete-recent cursor-pointer" style=" position:absolute; top:2%; right:3%; line-height:1.5;font-weight:700;"> Xóa lịch sử  <i class="bi bi-trash3"></i></div>');
    dropdown.append(text_recent);
    dropdown.append(delete_recent);

    delete_recent.click(function() {
      localStorage.removeItem('searchHistory');
      dropdown.empty();
      dropdown.append('<div class="py-2 px-3">Không có lịch sử tìm kiếm</div>');
      $('.search-header').focus();
    });
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
    dropdown.append('<div class="py-2 px-3">Không có lịch sử tìm kiếm</div>');
    $('.search-history-dropdown').show();
  }
  if($('.trend-product').length ==0){
    let fire_url = $('.search-header').data('fire-url');
    let text_trend = $(`<div class="py-2 ps-3 pe-5 trend-product" style="line-height:1.5;font-weight:700;display:flex;align-items:center;"> Xu hướng tìm kiếm <img src="${fire_url}" style="width: 25px; height: 25px; vertical-align: middle; margin-left: 5px;" /></div>`);
    dropdown.append(text_trend);
    $.ajax({
      url: '/api/search-trend',  // URL của API
      method: 'GET',
      success: function(data) {
        if (data && data.length >= 4) {
          let featured_products = $(`
            <div class="row">
                <!-- Cột 1: Sản phẩm 1 -->
                <div class="col-6">
                    <div class="product-search d-flex justify-content-evenly align-items-center" data-id="${data[0].id}">
                        <img src="/storage/${data[0].image_url}" alt="${data[0].name}" class="img-fluid" style="max-height: 60px; object-fit: cover;">
                        <p class="text-center">${data[0].name}</p>
                    </div>
                    <div class="product-search d-flex justify-content-evenly align-items-center" data-id="${data[1].id}">
                        <img src="/storage/${data[1].image_url}" alt="${data[1].name}" class="img-fluid" style="max-height: 60px; object-fit: cover;">
                        <p class="text-center">${data[1].name}</p>
                    </div>
                </div>

                <!-- Cột 2: Sản phẩm 2 -->
                <div class="col-6">
                    <div class="product-search d-flex justify-content-evenly align-items-center" data-id="${data[2].id}">
                        <img src="/storage/${data[2].image_url}" alt="${data[2].name}" class="img-fluid" style="max-height: 60px; object-fit: cover;">
                        <p class="text-center">${data[2].name}</p>
                    </div>
                    <div class="product-search d-flex justify-content-evenly align-items-center" data-id="${data[3].id}">
                        <img src="/storage/${data[3].image_url}" alt="${data[3].name}" class="img-fluid" style="max-height: 60px; object-fit: cover;">
                        <p class="text-center">${data[3].name}</p>
                    </div>
                </div>
            </div>`);

          dropdown.append(featured_products);
          $('.product-search').hover(
            function() {
              $(this).addClass('highlight');
            },
            function() {
              $(this).removeClass('highlight');
            }
          );
          $('.product-search').click(function() {
            var productId = $(this).data('id');  // Lấy id sản phẩm từ data-id
            window.location.href = '/product/' + productId;  // Chuyển đến trang chi tiết sản phẩm
          });
        } else {
          console.log('Không đủ sản phẩm để hiển thị.');
        }
      },
      error: function(xhr, status, error) {
        console.log('Đã có lỗi xảy ra: ', error);
      }
    });

  }
});
$('.search-header').on('blur', function() {
  var dropdown = $('.search-history-dropdown');
  setTimeout(function() {
      dropdown.empty();
      dropdown.hide();
      dropdown.css('z-index', '0');
  }, 200);
});