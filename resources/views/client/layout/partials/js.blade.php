
<script src="{{ asset('client/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('client/vendor/timezz/timezz.js') }}"></script>

<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('client/js/theme.min.js') }}"></script>

<script>
    function toggleChatPopup() {
    const chatPopup = document.getElementById('chatPopup');
    if (chatPopup.style.display === 'none' || chatPopup.style.display === '') {
        chatPopup.style.display = 'block';
    } else {
        chatPopup.style.display = 'none';
    }
}
function toggleChatPopup() {
    const chatPopup = document.getElementById('chatPopup');
    if (chatPopup.style.display === 'none' || chatPopup.style.display === '') {
        chatPopup.style.display = 'block';
    } else {
        chatPopup.style.display = 'none';
    }
}

function sendMessage() {
    const messageInput = document.getElementById("messageInput");
    const chatMessages = document.getElementById("chatMessages");

    if (messageInput.value.trim() !== "") {
        const newMessage = document.createElement("div");
        newMessage.classList.add("message", "received");
        newMessage.innerHTML = `<p>${messageInput.value}</p><span class="timestamp">${new Date().toLocaleTimeString()}</span>`;
        
        chatMessages.appendChild(newMessage);
        messageInput.value = "";
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}
// kiểm tra thông tin đăng nhập
// Hiển thị form thông tin
function toggleInfoForm() {
    document.getElementById("infoForm").style.display = "flex";
    document.getElementById("chatContainer").style.display = "none"; // Ẩn khung chat
}

// Bắt đầu trò chuyện sau khi kiểm tra thông tin
function startChat() {
    const userName = document.getElementById("userName").value.trim();
    const userPhone = document.getElementById("userPhone").value.trim();

    // Kiểm tra các trường bắt buộc
    if (userName === "" || userPhone === "") {
        alert("Vui lòng điền tên và số điện thoại.");
        return;
    }

    // Nếu thông tin hợp lệ, ẩn form yêu cầu và hiển thị khung chat
    document.getElementById("infoForm").style.display = "none";
    document.getElementById("chatContainer").style.display = "flex";
}


</script>