<?php
session_start();
$timeLimit = 3600; // Thời gian tối đa cho phiên chat (1 giờ)

if (!isset($_SESSION['chat_start_time'])) {
    $_SESSION['chat_start_time'] = time(); // Khởi tạo thời gian bắt đầu nếu chưa có
}

// Kiểm tra thời gian đã trôi qua
$current_time = time();
$time_elapsed = $current_time - $_SESSION['chat_start_time'];

if ($time_elapsed > $timeLimit) {
    // Nếu thời gian phiên đã hết
    session_destroy(); // Hủy phiên chat
    echo json_encode(['status' => 'error', 'message' => 'Phiên chat đã hết hạn.']);
    exit;
}

// Khởi tạo mảng tin nhắn nếu chưa có
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

// Xử lý yêu cầu gửi tin nhắn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = trim($_POST['message']);
    if (!empty($userMessage)) {
        // Lưu tin nhắn của người dùng
        $_SESSION['messages'][] = [
            'type' => 'sent',
            'message' => htmlspecialchars($userMessage),
            'timestamp' => date('H:i')
        ];

        // Phản hồi từ admin (mô phỏng)
        $adminResponse = "Admin: " . htmlspecialchars($userMessage) . " đã nhận.";
        $_SESSION['messages'][] = [
            'type' => 'received',
            'message' => htmlspecialchars($adminResponse),
            'timestamp' => date('H:i')
        ];
    }
}

// Trả về danh sách tin nhắn
echo json_encode(['status' => 'success', 'messages' => $_SESSION['messages']]);
?>
{{-- chat --}}
<div class="chat-button container" onclick="toggleChatPopup()">
  <i class="ri-chat-3-line"></i> CHAT NGAY
</div>

<!-- Pop-up Chat -->
<div class=" chat-popup" id="chatPopup">
  <!-- Form yêu cầu thông tin người dùng -->
  <div class="info-form" id="infoForm">
    <h3>Thông tin cơ bản</h3>
    <div class="info">
      <label for="userName">Nhập tên của bạn*</label>
      <input type="text" id="userName" required>
  
      <label for="userEmail">Nhập email của bạn</label>
      <input type="email" id="userEmail">
  
      <label for="userPhone">Nhập số điện thoại của bạn*</label>
      <input type="tel" id="userPhone" required>
  
      <h4>Thông tin bổ sung</h4>
      <label for="userGender">Giới tính</label>
      <select id="userGender">
          <option value="male">Nam</option>
          <option value="female">Nữ</option>
          <option value="other">Khác</option>
      </select>
  
      <label for="userMessage">Tin nhắn</label>
      <textarea id="userMessage" placeholder="Nhập tin nhắn"></textarea>
    </div>
    <button class="chat-input" onclick="startChat()">Bắt đầu trò chuyện</button>
  </div>

  <!-- Khung Chat -->
  <div class="chat-container" id="chatContainer" style="display: none;">
    <!-- Thanh điều hướng trên cùng -->
    <div class="chat-header">
      <div class="user-info">
        <img src="assets/images/users/avatar-2.jpg" alt="User Avatar" class="user-avatar">
        <div class="user-details">
          <h5 class="username">Xin chào</h5>
          <p class="status">Em ở đây để hỗ trợ cho mình ạ</p>
        </div>
      </div>
    </div>
    <!-- Khu vực danh sách tin nhắn -->
    <div class="chat-messages" id="chatMessages">
      <div class="message received">
        <p>Chào bạn! Có thể giúp mình được không?</p>
        <span class="timestamp">10:00 AM</span>
      </div>
      <div class="message received">
        <p>Chào bạn! Có thể giúp mình được không?</p>
        <span class="timestamp">10:00 AM</span>
      </div>
      <div class="message sent">
        <p>Xin chào! Mình có thể giúp gì cho bạn?</p>
        <span class="timestamp">10:01 AM</span>
      </div>
      <!-- Thêm các tin nhắn khác tại đây -->
    </div>
    <!-- Khu vực nhập tin nhắn -->
    <div class="chat-input">
      <input type="text" id="messageInput" placeholder="Nhập tin nhắn...">
      <button onclick="sendMessage()" class="send-button"><i class="ri-send-plane-2-line"></i> Gửi</button>
    </div>
  </div>
</div>

<span class="position-absolute top-0 start-0 w-100 h-100 bg-body d-none d-block-dark"></span>
      <div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">

        <!-- Columns with links that are turned into accordion on screens < 500px wide (sm breakpoint) -->
        <div class="accordion py-5" id="footerLinks">
          <div class="row">
            <div class="col-md-4 d-sm-flex flex-md-column align-items-center align-items-md-start pb-3 mb-sm-4">
              <h4 class="mb-sm-0 mb-md-4 me-4">
                <a class="text-dark-emphasis text-decoration-none" href="index.html">Cartzilla</a>
              </h4>
              <p class="text-body fs-sm text-sm-end text-md-start mb-sm-0 mb-md-3 ms-0 ms-sm-auto ms-md-0 me-4">Got questions? Contact us 24/7</p>
              <div class="dropdown" style="max-width: 250px">
                <button type="button" class="btn btn-light dropdown-toggle justify-content-between w-100 d-none-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Help and consultation
                </button>
                <button type="button" class="btn btn-secondary dropdown-toggle justify-content-between w-100 d-none d-flex-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Help and consultation
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#!">Help center &amp; FAQ</a></li>
                  <li><a class="dropdown-item" href="#!">Support chat</a></li>
                  <li><a class="dropdown-item" href="#!">Open support ticket</a></li>
                  <li><a class="dropdown-item" href="#!">Call center</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row row-cols-1 row-cols-sm-3 gx-3 gx-md-4">
                <div class="accordion-item col border-0">
                  <h6 class="accordion-header" id="companyHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Company</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#companyLinks" aria-expanded="false" aria-controls="companyLinks">Company</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="companyLinks" aria-labelledby="companyHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">About company</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Our team</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Careers</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Contact us</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">News</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col border-0">
                  <h6 class="accordion-header" id="accountHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Account</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#accountLinks" aria-expanded="false" aria-controls="accountLinks">Account</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="accountLinks" aria-labelledby="accountHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Your account</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping rates &amp; policies</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Refunds &amp; replacements</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Delivery info</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Order tracking</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Taxes &amp; fees</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col border-0">
                  <h6 class="accordion-header" id="customerHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Customer service</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#customerLinks" aria-expanded="false" aria-controls="customerLinks">Customer service</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="customerLinks" aria-labelledby="customerHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Payment methods</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Money back guarantee</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Product returns</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Support center</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Terms &amp; conditions</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Category / tag links -->
        <div class="d-flex flex-column gap-3 pb-3 pb-md-4 pb-lg-5 mt-n2 mt-sm-n4 mt-lg-0 mb-4">
          <ul class="nav align-items-center text-body-tertiary gap-2">
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Computers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Smartphones</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">TV, Video</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Speakers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Cameras</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Printers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Video Games</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Headphones</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Wearable</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">HDD/SSD</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Smart Home</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Apple Devices</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Tablets</a>
            </li>
          </ul>
          <ul class="nav align-items-center text-body-tertiary gap-2">
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Monitors</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Scanners</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Servers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Heating and Cooling</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">E-readers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Data Storage</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Networking</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Power Strips</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Plugs and Outlets</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Detectors and Sensors</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Accessories</a>
            </li>
          </ul>
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
      <script>
        function toggleChatPopup() {
            const chatPopup = document.getElementById('chatPopup');
            const infoForm = document.getElementById('infoForm');
            const chatContainer = document.getElementById('chatContainer');
    
            // Bật/tắt hộp thoại chat
            if (chatPopup.style.display === 'none' || chatPopup.style.display === '') {
                chatPopup.style.display = 'block';
                infoForm.style.display = 'block';  // Hiển thị form nhập thông tin
                chatContainer.style.display = 'none'; // Ẩn khung chat
            } else {
                chatPopup.style.display = 'none';
            }
        }
    
        function startChat() {
            const userName = document.getElementById('userName').value.trim();
            const userPhone = document.getElementById('userPhone').value.trim();
    
            if (userName === '' || userPhone === '') {
                alert('Vui lòng nhập tên và số điện thoại của bạn');
                return;
            }
    
            // Ẩn form nhập thông tin và hiển thị hộp thoại chat
            document.getElementById('infoForm').style.display = 'none';
            document.getElementById('chatContainer').style.display = 'block';
        }
    
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            const conversationId = 1; // ID của cuộc hội thoại
            const adminId = 1; // ID của admin
    
            if (!message) return;
    
            fetch('/chat/received', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message,
                    conversation_id: conversationId,
                    admin_id: adminId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    loadMessages(conversationId); // Tải lại các tin nhắn
                }
            })
            .catch(error => console.error('Error:', error));
    
            messageInput.value = ''; // Xóa nội dung ô nhập tin nhắn
        }
    
        function loadMessages(conversationId) {
            fetch(`/chat/messages/${conversationId}`)
            .then(response => response.json())
            .then(data => {
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = ''; // Xóa nội dung cũ
                data.messages.forEach(msg => {
                    const newMessage = document.createElement('div');
                    newMessage.className = 'message received';
                    newMessage.innerHTML = `<p>${msg.content}</p><span class="timestamp">${new Date(msg.timestamp).toLocaleTimeString()}</span>`;
                    chatMessages.appendChild(newMessage);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối khi có tin nhắn mới
            })
            .catch(error => console.error('Error loading messages:', error));
        }
    </script>