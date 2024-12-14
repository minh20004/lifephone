<style>
  /* Cấu hình cho nút chat */
  .chat-buttonC {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: rgb(34, 41, 52);
      color: white;
      border: none;
      padding: 15px;
      border-radius: 50%;
      font-size: 18px;
      cursor: pointer;
      z-index: 5000;
  }

  /* Cấu hình cho cửa sổ chat */
  .chat-boxC {
      position: fixed;
      bottom: 20px;
      right: 80px;
      width: 300px;
      height: 400px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      flex-direction: column;
      z-index: 5000;
      visibility: hidden;
  }

  .chat-headerC {
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      background-color: rgb(34, 41, 52);;
      color: white !important;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 16px !important;
  }

  .messagesC {
      padding: 10px;
      flex-grow: 1;
      overflow-y: auto;
      background-color: #f9f9f9;
  }

  #messageInputC {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
  }

  .send-btnC {
      width: 100%;
      padding: 10px;
      background-color: rgb(34, 41, 52);;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
  }

  .close-btnC {
      background: none;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
  }

  @media (max-width: 767px) {
    /* Giảm kích thước nút chat trên màn hình nhỏ */
    .chat-buttonC {
        padding: 10px;
        font-size: 20px;  /* Giảm kích thước icon */
        bottom: 15px;
        right: 15px;
    }

    /* Điều chỉnh cửa sổ chat cho màn hình nhỏ */
    .chat-boxC {
        width: 250px;  /* Rút gọn chiều rộng cửa sổ chat */
        height: 350px; /* Rút gọn chiều cao cửa sổ chat */
        right: 60px;
    }

    /* Điều chỉnh header của cửa sổ chat */
    .chat-headerC {
        font-size: 14px;  /* Giảm kích thước font header */
    }

    /* Các tin nhắn sẽ được hiển thị với khoảng cách nhỏ hơn */
    .messagesC {
        padding: 8px;
    }

    #messageInputC {
        padding: 8px;
        font-size: 14px;  /* Giảm kích thước font input */
    }

    .send-btnC {
        padding: 8px;
        font-size: 14px;  /* Giảm kích thước font button */
    }

    .close-btnC {
        font-size: 16px;  /* Giảm kích thước close button */
    }
  }

  @media (max-width: 1024px) {
    .chat-button {
        padding: 12px;
        font-size: 22px;  /* Giảm kích thước icon ở máy tính bảng */
    }

    .chat-box {
        width: 280px;
        height: 380px;
    }

    .chat-header {
        font-size: 15px;
    }

    #messageInput {
        padding: 10px;
        font-size: 15px;
    }

    .send-btn {
        padding: 10px;
        font-size: 15px;
    }
  }

</style>
<!-- Subscription form + Vlog -->
<section class="bg-body-tertiary py-5">
  <div class="container pt-sm-2 pt-md-3 pt-lg-4 pt-xl-5">
    <div class="row">
      <div class="col-md-6 col-lg-5 mb-5 mb-md-0">
        <h2 class="h4 mb-2">Đăng ký nhận bản tin của chúng tôi</h2>
        <p class="text-body pb-2 pb-ms-3">Nhận thông tin cập nhật mới nhất về sản phẩm và chương trình khuyến mãi của chúng tôi</p>
        <form class="d-flex needs-validation pb-1 pb-sm-2 pb-md-3 pb-lg-0 mb-4 mb-lg-5"
              action="{{ route('subscriptions.store') }}" method="POST" novalidate="">
            @csrf
            <div class="position-relative w-100 me-2">
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Your email" required="">
            </div>
            <button type="submit" class="btn btn-lg btn-primary">Nhận thông báo</button>
        </form>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex gap-3">
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Instagram">
            <i class="ci-instagram fs-base"></i>
          </a>
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Facebook">
            <i class="ci-facebook fs-base"></i>
          </a>
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="YouTube">
            <i class="ci-youtube fs-base"></i>
          </a>
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Telegram">
            <i class="ci-telegram fs-base"></i>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-5 col-xl-4 offset-lg-1 offset-xl-2">
        <ul class="list-unstyled d-flex flex-column gap-4 ps-md-4 ps-lg-0 mb-3">
          @foreach($latestNews as $news)
          <li class="nav flex-nowrap align-items-center position-relative">
              <!-- Hình ảnh bài viết -->
              <img src="{{ asset('storage/' . $news->thumbnail) }}" class="rounded" width="140" alt="{{ $news->title }}">

              <!-- Thông tin bài viết -->
              <div class="ps-3">
                  <!-- Thời gian đăng bài -->
                  <div class="fs-xs text-body-secondary lh-sm mb-2">
                      {{ $news->created_at->format('H:i') }}
                  </div>

                  <!-- Tiêu đề bài viết -->
                  <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="{{ route('news.show', $news->slug) }}">
                      {{ $news->title }}
                  </a>
              </div>
          </li>
      @endforeach
        </ul>
        <div class="nav ps-md-4 ps-lg-0">
          <a class="btn nav-link animate-underline text-decoration-none px-0" href="{{ route('news.index') }}">
            <span class="animate-target">Xem tất cả</span>
            <i class="ci-chevron-right fs-base ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<span class="position-absolute top-0 start-0 w-100 h-100 bg-body d-none d-block-dark"></span>
      <div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">

        <div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">

          <!-- Cột với liên kết được chuyển thành accordion trên màn hình < 500px -->
          <div class="accordion py-5" id="footerLinks">
              <div class="row">
                  <div class="col-md-4 d-sm-flex flex-md-column align-items-center align-items-md-start pb-3 mb-sm-4">
                      <h4 class="mb-sm-0 mb-md-4 me-4">
                          <a class="text-dark-emphasis text-decoration-none" href="index.html">Cartzilla</a>
                      </h4>
                      <p class="text-body fs-sm text-sm-end text-md-start mb-sm-0 mb-md-3 ms-0 ms-sm-auto ms-md-0 me-4">Có câu hỏi? Liên hệ với chúng tôi 24/7</p>
                      <div class="dropdown" style="max-width: 250px">
                          <button type="button" class="btn btn-light dropdown-toggle justify-content-between w-100 d-none-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Hỗ trợ và tư vấn
                          </button>
                          <button type="button" class="btn btn-secondary dropdown-toggle justify-content-between w-100 d-none d-flex-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Hỗ trợ và tư vấn
                          </button>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#!">Trung tâm hỗ trợ &amp; Câu hỏi thường gặp</a></li>
                              <li><a class="dropdown-item" href="#!">Trò chuyện hỗ trợ</a></li>
                              <li><a class="dropdown-item" href="#!">Mở yêu cầu hỗ trợ</a></li>
                              <li><a class="dropdown-item" href="#!">Tổng đài</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-md-8">
                      <div class="row row-cols-1 row-cols-sm-3 gx-3 gx-md-4">
                          <div class="accordion-item col border-0">
                              <h6 class="accordion-header" id="companyHeading">
                                  <span class="text-dark-emphasis d-none d-sm-block">Công ty</span>
                                  <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#companyLinks" aria-expanded="false" aria-controls="companyLinks">Công ty</button>
                              </h6>
                              <div class="accordion-collapse collapse d-sm-block" id="companyLinks" aria-labelledby="companyHeading" data-bs-parent="#footerLinks">
                                  <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Giới thiệu công ty</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Đội ngũ của chúng tôi</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Cơ hội nghề nghiệp</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Liên hệ</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Tin tức</a>
                                      </li>
                                  </ul>
                              </div>
                              <hr class="d-sm-none my-0">
                          </div>
                          <div class="accordion-item col border-0">
                              <h6 class="accordion-header" id="accountHeading">
                                  <span class="text-dark-emphasis d-none d-sm-block">Tài khoản</span>
                                  <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#accountLinks" aria-expanded="false" aria-controls="accountLinks">Tài khoản</button>
                              </h6>
                              <div class="accordion-collapse collapse d-sm-block" id="accountLinks" aria-labelledby="accountHeading" data-bs-parent="#footerLinks">
                                  <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Tài khoản của bạn</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Chi phí vận chuyển</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Hoàn tiền và thay thế</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Thông tin giao hàng</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Theo dõi đơn hàng</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Thuế &amp; phí</a>
                                      </li>
                                  </ul>
                              </div>
                              <hr class="d-sm-none my-0">
                          </div>
                          <div class="accordion-item col border-0">
                              <h6 class="accordion-header" id="customerHeading">
                                  <span class="text-dark-emphasis d-none d-sm-block">Dịch vụ khách hàng</span>
                                  <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#customerLinks" aria-expanded="false" aria-controls="customerLinks">Dịch vụ khách hàng</button>
                              </h6>
                              <div class="accordion-collapse collapse d-sm-block" id="customerLinks" aria-labelledby="customerHeading" data-bs-parent="#footerLinks">
                                  <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Phương thức thanh toán</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Cam kết hoàn tiền</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Trả lại sản phẩm</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Trung tâm hỗ trợ</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Vận chuyển</a>
                                      </li>
                                      <li class="d-flex w-100 pt-1">
                                          <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Điều khoản &amp; điều kiện</a>
                                      </li>
                                  </ul>
                              </div>
                              <hr class="d-sm-none my-0">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      

        <!-- Copyright + Payment methods -->
        <div class="d-md-flex align-items-center border-top py-4">
          <div class="d-flex gap-2 gap-sm-3 justify-content-center ms-md-auto mb-4 mb-md-0 order-md-2">
            <div>
              <img src="client/img/payment-methods/visa-dark-mode.svg" alt="Visa">
            </div>
            <div>
              <img src="client/img/payment-methods/mastercard.svg" alt="Mastercard">
            </div>
            <div>
              <img src="client/img/payment-methods/paypal-dark-mode.svg" alt="PayPal">
            </div>
            <div>
              <img src="client/img/payment-methods/google-pay-dark-mode.svg" alt="Google Pay">
            </div>
            <div>
              <img src="client/img/payment-methods/apple-pay-dark-mode.svg" alt="Apple Pay">
            </div>
          </div>
          <p class="text-body fs-xs text-center text-md-start mb-0 me-4 order-md-1">© All rights reserved. Made by <span class="animate-underline"><a class="animate-target text-dark-emphasis fw-medium text-decoration-none" href="https://createx.studio/" target="_blank" rel="noreferrer">Createx Studio</a></span></p>
        </div>
      </div>

      <button id="chatButtonC" class="chat-buttonC" style="line-height: 1; ">
        <i class="fa-regular fa-comment"></i>
        <div id="numberUnread" class="numberUnread" style="position:absolute; top:-10%; right:-10%; border-radius: 50%; background-color: red; line-height:1; width:45%; height:45%; display:grid; place-items:center;">0</div>
      </button>
      <div id="chatBoxC" class="chat-boxC d-flex">
        <div class="chat-headerC">
            <p class="m-0">Chăm sóc khách hàng</p>
            <button id="closeChatC" class="close-btnC">X</button>
        </div>
        <div id="messagesC" class="messagesC"></div>
        <input id="messageInputC" type="text" placeholder="Nhập tin nhắn...." />
        <!-- Nút gửi tin nhắn -->
        <div class="d-flex">
          <button id="sendMessageC" class="send-btnC w-75">Gửi</button>
          <button id="uploadImageC" class="upload-btnC w-25" style="border: none; border-radius:10px;">📷 <span id="imageCount">0</span></button>
        </div>
        <!-- Nút tải ảnh -->
        <input type="file" id="imageInputC" class="image-input d-none" accept="image/*" />
      </div>

      <div class="toast-container position-fixed top-50 end-0 p-3">
        <div id="toast_new_mess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">Tin nhắn mới</strong>
            <small>Vừa xong</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            Bạn có một tin nhắn mới!
          </div>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>

  <script>
    // Kết nối tới server Socket.IO
    var socket = null;
    var conversationId = null;
    var customerId = null;

    // Lấy các phần tử DOM
    const chatButton = document.getElementById("chatButtonC");
    const chatBox = document.getElementById("chatBoxC");
    const closeChat = document.getElementById("closeChatC");
    const sendMessage = document.getElementById("sendMessageC");
    const messageInput = document.getElementById("messageInputC");
    const messagesDiv = document.getElementById("messagesC");
    const messageImg = document.getElementById('imageInputC');

    document.getElementById('uploadImageC').addEventListener('click', function() {
        document.getElementById('imageInputC').click(); // Kích hoạt ô chọn tệp khi nhấn nút
    });

    let imageCount = 0;
    document.getElementById('imageInputC').addEventListener('change', function(event) {
      const files = event.target.files;  // Lấy các tệp được chọn
      if (files.length > 0) {
          imageCount += files.length;  // Cập nhật số lượng ảnh đã tải lên
          console.log(imageCount)
          // Cập nhật hiển thị số lượng ảnh trên nút tải ảnh
          document.getElementById('imageCount').textContent = imageCount;
      }
    });

    chatButton.addEventListener("click", () => {
      chatBox.style.visibility = "visible";
      document.getElementById('numberUnread').textContent = 0;
    });
    document.addEventListener('DOMContentLoaded', function() {
    // Khi người dùng bấm nút "Chat with Admin"

        // Gửi yêu cầu join vào room với admin
        // socket.emit('join', conversationId, userId, senderType);
        customerId = @json(Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null);
        console.log('Chat with Admin',customerId);
          // Mở cửa sổ chat
        $.ajax({
          url: '/api/getConversation',
          type: 'POST',
          data: {
            customerId: customerId,
          },
          success: function(data) {
            console.log(data);
            conversationId = data.conversationId;
            socket = io('http://localhost:3000');
            console.log(socket)
            socket.emit('join',conversationId, 'customer')

            socket.on('previous_messages', (data) => {
              console.log('--------------')
              console.log('previous_messages', data);
              console.log('--------------')

              data.forEach((message) => {
                const messageElement = document.createElement("div");

                // Kiểm tra senderType để quyết định kiểu hiển thị
                if(message.type == 'text'){
                  if (message.senderType === 'customer') {
                      // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                      messageElement.classList.add('d-flex', 'justify-content-end', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                              ${message.content}
                          </div>
                      `;
                  } else {
                      // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                      messageElement.classList.add('d-flex', 'justify-content-star', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                              ${message.content}
                          </div>
                      `;
                  }
                }else if(message.type == 'img'){
                  if (message.senderType === 'customer') {
                      // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                      messageElement.classList.add('d-flex', 'justify-content-end', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                            <img src="${message.content}" class="w-100" alt="">
                          </div>
                      `;
                  } else {
                      // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                      messageElement.classList.add('d-flex', 'justify-content-star', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                            <img src="${message.content}" class="w-100" alt="">
                          </div>
                      `;
                  }
                }

                // Thêm phần tử tin nhắn vào phần tử DOM chứa tin nhắn (messagesDiv)
                messagesDiv.appendChild(messageElement);
              });
              messagesDiv.scrollTop = messagesDiv.scrollHeight;  // Cuộn xuống cuối tin nhắn
            });

            socket.on('new_message', (data) => {
              console.log('++++++++++++++++');
              console.log('new_message', data);
              console.log('++++++++++++++++');

              let messageElement;

              if (data.senderType === 'customer') {
                    // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                    messageElement = `
                        <div class="d-flex justify-content-end mb-3">
                          <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                              ${data.message}
                          </div>
                      </div>
                    `;
                } else {
                    // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                    messageElement = `
                        <div class="d-flex justify-content-star mb-3">
                          <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                              ${data.message}
                          </div>
                      </div>
                    `;
                }
                messagesDiv.innerHTML += messageElement;
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
                if(data.senderType === 'admin'){
                  var toastEl = document.getElementById('toast_new_mess');
                  var toast = new bootstrap.Toast(toastEl);
                  toast.show();
                  document.getElementById('numberUnread').textContent = parseInt(document.getElementById('numberUnread').textContent) + 1;
                }

            });

            socket.on('new_img', (data) => {
              let messageElement = document.createElement("div");

              if (data.senderType === 'customer') {
                  messageElement = `
                      <div class="d-flex justify-content-end mb-3">
                        <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                            <img src="${data.img}" class="w-100" alt="">
                        </div>
                    </div>
                  `;
              } else {
                  // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                  messageElement = `
                      <div class="d-flex justify-content-star mb-3">
                        <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                            <img src="${data.img}" class="w-100" alt="">
                        </div>
                    </div>
                  `;
              }
              messagesDiv.innerHTML += messageElement;
              messagesDiv.scrollTop = messagesDiv.scrollHeight;
              if(data.senderType === 'admin'){
                var toastEl = document.getElementById('toast_new_mess');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
                document.getElementById('numberUnread').textContent = parseInt(document.getElementById('numberUnread').textContent) + 1;
              }
            })
          },
          error: function(e) {
            console.log(e);
          }
        });
    });

    // Khi người dùng đóng cửa sổ chat
    closeChat.addEventListener("click", () => {
        chatBox.style.visibility = "hidden";  // Ẩn cửa sổ chat
    });

    // Khi người dùng gửi tin nhắn
    sendMessage.addEventListener("click", () => {
        const message = messageInput.value.trim();
        const fileInput = messageImg.files[0];
        if (message) {
            // Gửi tin nhắn tới server
            socket.emit("sendMessage", {
              conversationId: conversationId,
              senderId: customerId,
              senderType: 'customer',
              content: message,
              type: 'text',
            });
            console.log('sendMessage', message);
            messageInput.value = "";  // Xóa nội dung sau khi gửi
        }
        if(fileInput){
          const reader = new FileReader();
          reader.onloadend = function() {
              const base64Image = reader.result;

              // Gửi ảnh qua socket
              socket.emit("sendImg", {
                  conversationId: conversationId,
                  senderId: customerId,
                  senderType: 'customer',
                  content: base64Image, // Dữ liệu ảnh base64
                  type: 'img'
              });
          };
          console.log('send img', fileInput)
          reader.readAsDataURL(fileInput); // Đọc ảnh thành base64
          document.getElementById('imageInputC').value = "";  // Reset input ảnh
          imageCount = 0;  // Reset số lượng ảnh
          document.getElementById('imageCount').textContent = imageCount;
        }
    });

    // Nhận các tin nhắn từ server
    // socket.on("receive_message", (message) => {
    //     const messageElement = document.createElement("div");
    //     messageElement.textContent = message;
    //     messagesDiv.appendChild(messageElement);
    //     messagesDiv.scrollTop = messagesDiv.scrollHeight;  // Cuộn xuống cuối tin nhắn
    // });

  </script>
