<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map-->
<script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<!-- Swiper slider js-->
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Dashboard init -->
<script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

{{-- mô tả product --}}
<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>

{{-- ảnh thêm sản phẩm --}}
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('thumbimage').src = e.target.result;
                document.getElementById('thumbimage').style.display = 'block';
                document.querySelector('.removeimg').style.display = 'inline'; // Hiện liên kết xóa ảnh
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        document.getElementById('image_url').value = ''; // Xóa giá trị input
        document.getElementById('thumbimage').src = ''; // Xóa src của ảnh
        document.getElementById('thumbimage').style.display = 'none'; // Ẩn ảnh
        document.querySelector('.removeimg').style.display = 'none'; // Ẩn liên kết xóa ảnh
    }
</script>


{{-- modal thêm danh mục trong add sp --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('#saveCategory').on('click', function() {
                var categoryName = $('#categoryName').val(); 
                var token = $("input[name=_token]").val(); // Lấy CSRF token từ form

                if (categoryName === '') {
                    $('#categoryError').text('Tên danh mục không được để trống').show();
                    return;
                } else {
                    $('#categoryError').hide(); 
                }

                // Gửi AJAX request
                $.ajax({
                    url: "{{ route('category.store') }}", // Đường dẫn đến route để lưu danh mục
                    method: "POST", 
                    data: {
                        _token: token,
                        name: categoryName
                    },
                    success: function(response) {
                        $('#adddanhmuc').modal('hide'); 
                        location.reload(); 
                    },
                    error: function(xhr) {
                        // Xử lý lỗi 
                        $('#categoryError').text('Danh mục đã tồn tại !').show();
                    }
                });
            });
        });
<<<<<<< HEAD
<<<<<<< HEAD
    </script>
=======
=======
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
    </script>


<script>
    // Biến để lưu trữ các ảnh đã hiển thị
    const displayedImages = [];

    function previewImages(event) {
        const previewContainer = document.getElementById('image_preview');
        const files = event.target.files; // Lấy tất cả các tệp đã chọn

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Kiểm tra xem ảnh đã được hiển thị hay chưa
            if (!displayedImages.includes(file.name)) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result; // Đặt nguồn cho ảnh là dữ liệu đọc từ file
                    img.style.width = '70px'; // Thiết lập kích thước cho ảnh
                    img.style.height = '70px'; // Thiết lập kích thước cho ảnh
                    img.style.marginRight = '10px'; // Thiết lập khoảng cách giữa các ảnh

                    const imagePreviewContainer = document.createElement('div');
                    imagePreviewContainer.className = 'image-preview'; // Tạo một div để bao quanh ảnh
                    imagePreviewContainer.appendChild(img); // Thêm ảnh vào div

                    previewContainer.appendChild(imagePreviewContainer); // Thêm div vào container

                    // Lưu tên tệp đã hiển thị để tránh hiển thị lại
                    displayedImages.push(file.name);
                };

                reader.readAsDataURL(file); // Đọc dữ liệu của tệp
            }
        }
    }
<<<<<<< HEAD
</script>
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
=======
</script>
>>>>>>> c5db0cfb274568866108d6c8989726da2e799e50
