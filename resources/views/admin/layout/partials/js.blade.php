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
<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('message');
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
        document.getElementById('image_url').value = ''; 
        document.getElementById('thumbimage').src = ''; 
        document.getElementById('thumbimage').style.display = 'none'; 
        document.querySelector('.removeimg').style.display = 'none'; 
    }
</script>


{{-- modal thêm danh mục trong add sp --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('#saveCategory').on('click', function() {
                var categoryName = $('#categoryName').val(); 
                var token = $("input[name=_token]").val(); 

                if (categoryName === '') {
                    $('#categoryError').text('Tên danh mục không được để trống').show();
                    return;
                } else {
                    $('#categoryError').hide(); 
                }

                $.ajax({
                    url: "{{ route('category.store') }}", 
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
        $(document).ready(function() {
        // color
        $('#saveColor').on('click', function() {
            var colorName = $('#colorName').val(); 
            var colorCode = $('#colorCode').val();
            var token = $("input[name=_token]").val(); 

            if (colorName === '' || colorCode === '') {
                $('#colorError').text('Tên màu sắc và mã màu không được để trống').show();
                return;
            } else {
                $('#colorError').hide(); 
            }

            $.ajax({
                url: "{{ route('color.store') }}", 
                method: "POST", 
                data: {
                    _token: token,
                    name: colorName,
                    code: colorCode
                },
                success: function(response) {
                    $('#addmausac').modal('hide'); 
                    location.reload(); 
                },
                error: function(xhr) {
                    $('#colorError').text('Màu sắc hoặc mã màu đã tồn tại!').show();
                }
            });
        });
        // capacity
        $(document).ready(function() {
        $('#saveCapacity').on('click', function() {
            var capacityName = $('#capacityName').val();
            var token = $("input[name=_token]").val(); 

            if (capacityName === '') {
                $('#capacityError').text('Dung lượng không được để trống').show();
                return;
            } else {
                $('#capacityError').hide(); 
            }

            // AJAX để lưu dung lượng
            $.ajax({
                url: "{{ route('capacity.store') }}", 
                method: "POST", 
                data: {
                    _token: token,
                    name: capacityName
                },
                success: function(response) {
                    $('#adddungluong').modal('hide'); 
                    location.reload(); 
                },
                error: function(xhr) {
                    $('#capacityError').text('Dung lượng đã tồn tại!').show();
                }
            });
        });
});

});


    </script>
    
    


<script>
    
    const displayedImages = [];

    function previewImages(event) {
        const previewContainer = document.getElementById('image_preview');
        const files = event.target.files; 

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Kiểm tra xem ảnh đã được hiển thị hay chưa
            if (!displayedImages.includes(file.name)) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result; // Đặt nguồn cho ảnh là dữ liệu đọc từ file
                    img.style.width = '70px'; 
                    img.style.height = '70px'; 
                    img.style.marginRight = '10px'; 

                    const imagePreviewContainer = document.createElement('div');
                    imagePreviewContainer.className = 'image-preview'; 
                    imagePreviewContainer.appendChild(img); 

                    previewContainer.appendChild(imagePreviewContainer); 

                    // Lưu tên tệp đã hiển thị để tránh hiển thị lại
                    displayedImages.push(file.name);
                };

                reader.readAsDataURL(file); 
            }
        }
    }
</script>

{{-- mã màu của color trong product --}}
<script>
    document.getElementById('colorCode').addEventListener('input', function() {
        const colorPicker = document.getElementById('colorPicker');
        let codeInput = this.value;

        // Nếu mã màu ngắn (3 ký tự), chuyển sang dạng đầy đủ
        if (/^#[0-9A-Fa-f]{3}$/.test(codeInput)) {
            codeInput = '#' + codeInput[1] + codeInput[1] + codeInput[2] + codeInput[2] + codeInput[3] + codeInput[3];
        }

        // kiểm tra xem hợp lệ không
        if (/^#[0-9A-Fa-f]{6}$/.test(codeInput)) {
            colorPicker.value = codeInput;
        }
    });

    document.getElementById('colorPicker').addEventListener('input', function() {
        const colorCodeInput = document.getElementById('colorCode');
        colorCodeInput.value = this.value;
    });
    
</script>



