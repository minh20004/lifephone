
<script src="{{ asset('client/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('client/vendor/timezz/timezz.js') }}"></script>

<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('client/js/theme.min.js') }}"></script>

{{-- <script>
  function toggleChatPopup() {
      const chatPopup = document.getElementById('chatPopup');
      chatPopup.style.display = chatPopup.style.display === 'none' || chatPopup.style.display === '' ? 'block' : 'none';
  }

  function startChat() {
      const userName = document.getElementById('userName').value;
      const userPhone = document.getElementById('userPhone').value;

      // Kiểm tra các trường bắt buộc
      if (userName.trim() === '' || userPhone.trim() === '') {
          alert('Vui lòng nhập tên và số điện thoại của bạn');
          return;
      }

      // Ẩn form nhập thông tin và hiển thị hộp thoại chat
      document.getElementById('infoForm').style.display = 'none';
      document.getElementById('chatContainer').style.display = 'block';
  }

  function sendMessage() {
      const messageInput = document.getElementById("messageInput");
      const chatMessages = document.getElementById("chatMessages");

      const message = messageInput.value.trim();
      if (message) {
          // Tạo phần tử tin nhắn mới và thêm vào chat
          const newMessage = document.createElement('div');
          newMessage.className = 'message sent';
          newMessage.innerHTML = `<p>${message}</p><span class="timestamp">${new Date().toLocaleTimeString()}</span>`;
          chatMessages.appendChild(newMessage);

          // Xoá nội dung trong ô nhập tin nhắn
          messageInput.value = '';
          chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối khi có tin nhắn mới
      }
  }
</script> --}}
