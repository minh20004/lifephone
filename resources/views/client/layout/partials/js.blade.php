
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
        newMessage.classList.add("message", "sent");
        newMessage.innerHTML = `<p>${messageInput.value}</p><span class="timestamp">${new Date().toLocaleTimeString()}</span>`;
        
        chatMessages.appendChild(newMessage);
        messageInput.value = "";
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

</script>