function renderProductTable(data, tableId) {
  var TableProductListAll = document.getElementById(tableId);

  if (TableProductListAll) {
      new gridjs.Grid({
          columns: [
              {
                  name: "#",
                  width: "40px",
                  sort: { enabled: false },
                  data: function (e) {
                      return gridjs.html(
                          '<div class="form-check checkbox-product-list">\n\t\t\t\t\t<input class="form-check-input" type="checkbox" value="' +
                          e.id +
                          '" id="checkbox-' +
                          e.id +
                          '">\n\t\t\t\t\t<label class="form-check-label" for="checkbox-' +
                          e.id +
                          '"></label>\n\t\t\t\t  </div>'
                      );
                  },
              },
              {
                  name: "Product",
                  width: "360px",
                  formatter: function (e) {
                      return gridjs.html(
                          '<div class="d-flex align-items-center"><div class="flex-shrink-0 me-3"><div class="avatar-sm bg-light rounded p-1"><img src="assets/images/products/' +
                          e[0] +
                          '" alt="" class="img-fluid d-block"></div></div><div class="flex-grow-1"><h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details.html" class="text-body">' +
                          e[1] +
                          '</a></h5><p class="text-muted mb-0">Category : <span class="fw-medium">' +
                          e[2] +
                          "</span></p></div></div>"
                      );
                  },
              },
              { name: "Stock", width: "94px" },
              { name: "Price", width: "101px" },
              { name: "Orders", width: "84px" },
              {
                  name: "Rating",
                  width: "105px",
                  formatter: function (e) {
                      return gridjs.html(
                          '<span class="badge bg-light text-body fs-12 fw-medium"><i class="mdi mdi-star text-warning me-1"></i>' +
                          e +
                          "</span>"
                      );
                  },
              },
              {
                  name: "Published",
                  width: "220px",
                  formatter: function (e) {
                      return gridjs.html(
                          e[0] +
                          '<small class="text-muted ms-1">' +
                          e[1] +
                          "</small>"
                      );
                  },
              },
              {
                  name: "Action",
                  width: "80px",
                  sort: { enabled: false },
                  formatter: function (e) {
                      return gridjs.html(
                          '<div class="dropdown"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="apps-ecommerce-product-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li><li><a class="dropdown-item" href="apps-ecommerce-add-product.html"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li><li class="dropdown-divider"></li><li><a class="dropdown-item" href="#!"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li></ul></div>'
                      );
                  },
              },
          ],
          className: { th: "text-muted" },
          pagination: { limit: 10 },
          sort: true,
          data: data, // Sử dụng dữ liệu được truyền vào
      }).render(TableProductListAll);
  }
}

// Ví dụ về cách gọi hàm renderProductTable
async function fetchData() {
  try {
      const response = await fetch('get_products.php');
      const data = await response.json();

      // Gọi hàm renderProductTable với dữ liệu và ID bảng
      renderProductTable(data, "table-product-list-all");
  } catch (error) {
      console.error("Error fetching data:", error);
  }
}

// Gọi hàm fetchData
fetchData();
