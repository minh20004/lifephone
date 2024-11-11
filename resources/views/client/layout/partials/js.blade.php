
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
<script>
  function toggleChatPopup() {
      const chatPopup = document.getElementById('chatPopup');
      chatPopup.style.display = chatPopup.style.display === 'none' || chatPopup.style.display === '' ? 'block' : 'none';
      
      // Nếu hộp thoại chat được mở, đảm bảo ẩn form nhập thông tin
      if (chatPopup.style.display === 'block') {
          document.getElementById('infoForm').style.display = 'block';
          document.getElementById('chatContainer').style.display = 'none';
      }
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

  // function sendMessage() {
  //     const messageInput = document.getElementById("messageInput");
  //     const chatMessages = document.getElementById("chatMessages");

  //     const message = messageInput.value.trim();
  //     if (message) {
  //         // Tạo phần tử tin nhắn mới và thêm vào chat
  //         const newMessage = document.createElement('div');
  //         newMessage.className = 'message received';
  //         newMessage.innerHTML = `<p>${message}</p><span class="timestamp">${new Date().toLocaleTimeString()}</span>`;
  //         chatMessages.appendChild(newMessage);

  //         // Xoá nội dung trong ô nhập tin nhắn
  //         messageInput.value = '';
  //         chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối khi có tin nhắn mới
  //     }
  // }
  function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value;
    const conversationId = /* ID của cuộc hội thoại mà người dùng đang tham gia */;

    if (!message) return;

    fetch('/chat/received', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Nếu bạn sử dụng CSRF
        },
        body: JSON.stringify({
            message: message,
            conversation_id: conversationId,
            admin_id: /* ID của admin */ // Thêm ID admin ở đây
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadMessages(conversationId); // Tải lại các tin nhắn
        }
    });

    messageInput.value = ''; // Clear input
}
</script>
