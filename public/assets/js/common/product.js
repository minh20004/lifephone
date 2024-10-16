function search_recent() {
  var searchButton = $('.btn_search_product');

  searchButton.on('click', function() {
      let val = $('.search_input').val();

      let recentSearches = JSON.parse(localStorage.getItem('recent_search')) || [];

      if (val && !recentSearches.includes(val)) {
          recentSearches.push(val);

          localStorage.setItem('recent_search', JSON.stringify(recentSearches));
      }

  });
}
