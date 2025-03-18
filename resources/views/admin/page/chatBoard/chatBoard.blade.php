<style>
  ::-webkit-scrollbar {
    width: 12px;  /* Chiều rộng của thanh cuộn */
    height: 12px; /* Chiều cao của thanh cuộn ngang */
}

::-webkit-scrollbar-thumb {
    background-color: #888;  /* Màu sắc của phần "thumb" (phần di chuyển của thanh cuộn) */
    border-radius: 10px;  /* Bo tròn góc của phần thumb */
}

::-webkit-scrollbar-thumb:hover {
    background-color: #555;  /* Thay đổi màu khi hover */
}

::-webkit-scrollbar-track {
    background-color: #f1f1f1;  /* Màu nền của khu vực thanh cuộn */
    border-radius: 10px;  /* Bo tròn góc của thanh cuộn */
}

::-webkit-scrollbar-track:hover {
    background-color: #e0e0e0;  /* Thay đổi màu khi hover */
}

/* Tạo một lớp mới cho phần chứa (div) để tạo giao diện đẹp */
.custom-textarea-wrapper {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 10px; /* Bo tròn các góc */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Thêm bóng mờ nhẹ */
}

/* Tùy chỉnh textarea */
.custom-textarea {
    background-color: #f8f9fa; /* Màu nền nhẹ cho textarea */
    border: 1px solid #ced4da; /* Viền nhẹ */
    border-radius: 8px; /* Bo tròn góc */
    padding: 8px 12px; /* Padding vừa phải */
    resize: none; /* Tắt khả năng thay đổi kích thước */
    width: 100%; /* Đảm bảo textarea chiếm hết chiều rộng */
    height: 40px; /* Đảm bảo chiều cao hợp lý */
    box-sizing: border-box; /* Bao gồm padding trong chiều rộng */
    transition: border-color 0.2s ease-in-out; /* Thêm hiệu ứng khi thay đổi viền */
}

.custom-textarea:focus {
    border-color: #80bdff; /* Màu viền khi focus */
    outline: none; /* Xóa viền ngoài khi focus */
}

/* Tùy chỉnh nút gửi */
.custom-send-btn {
    background-color: #17a2b8; /* Màu nền của nút gửi */
    border-radius: 50%; /* Bo tròn nút */
    padding: 12px; /* Cung cấp padding để nút lớn hơn */
    border: none; /* Xóa viền mặc định */
    color: white; /* Màu chữ */
    font-size: 20px; /* Tăng kích thước biểu tượng */
    transition: background-color 0.3s ease; /* Thêm hiệu ứng khi hover */
}

.custom-send-btn:hover {
    background-color: #138496; /* Màu nền khi hover */
}

/* Tùy chỉnh nút chọn ảnh */
.custom-attach-btn {
    background-color: #f8f9fa; /* Màu nền cho nút chọn ảnh */
    border-radius: 50%; /* Bo tròn nút */
    padding: 12px; /* Padding cho nút */
    border: 1px solid #ced4da; /* Viền nhẹ */
    color: #495057; /* Màu chữ */
    font-size: 20px; /* Kích thước biểu tượng */
    transition: background-color 0.3s ease, border-color 0.3s ease; /* Thêm hiệu ứng khi hover */
}

.custom-attach-btn:hover {
    background-color: #e9ecef; /* Màu nền khi hover */
    border-color: #80bdff; /* Thay đổi màu viền khi hover */
}

/* Ẩn input file */
.custom-file-input {
    display: none;
}
</style>
@extends('admin.layout.master')

@section('content')
  <div class="page-content">
    <div class="row">

      <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

        <h5 class="font-weight-bold mb-3 text-center text-lg-start">Khách hàng </h5>

        <div class="card">
          <div class="card-body">

            <ul class="list-unstyled mb-0">
            </ul>

          </div>
        </div>

      </div>

      <div class="col-md-6 col-lg-7 col-xl-8" style="border-radius:20px;background-color: #d8cccc36;">

        <ul class="list-unstyled message-customer" style="max-height: 72vh;overflow-y:scroll;">
          <p style="height: 72vh;font-size:16px; display:grid; place-items:center;">Hãy bắt đầu cuộc trò chuyện với khách hàng</p>

        </ul>

          <div class="custom-textarea-wrapper mb-3 chat_btn_list" style="visibility: hidden;">
            <div class="d-flex align-items-center">
                <!-- Textarea để nhập tin nhắn -->
                <textarea class="form-control custom-textarea" style="outline: none;" id="textAreaExample2" rows="1" placeholder="Type a message"></textarea>

                <!-- Input file để chọn ảnh -->
                <input type="file" id="fileInput" class="custom-file-input" accept="image/*">

                <!-- Nút Gửi -->
                <button type="button" id="sendButton" onclick="sendMess()" class="btn custom-send-btn ms-2">
                    <i class="fas fa-paper-plane"></i>
                </button>

                <!-- Nút Chọn Ảnh -->
                <button type="button" id="attachButton" class="btn custom-attach-btn ms-2">
                    <i class="fas fa-paperclip"></i>
                </button>
            </div>
        </div>
      </div>

    </div>
  </div>
@endsection
