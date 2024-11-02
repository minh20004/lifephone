<meta name="description" content="Cartzilla - Multipurpose Bootstrap E-Commerce HTML Template">
<meta name="keywords" content="online shop, e-commerce, online store, market, multipurpose, product landing, cart, checkout, ui kit, light and dark mode, bootstrap, html5, css3, javascript, gallery, slider, mobile, pwa">
<meta name="author" content="Createx Studio">

<!-- Webmanifest + Favicon / App icons -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="manifest" href="{{ asset('client/manifest.json') }}">
<link rel="icon" type="image/png" href="{{ asset('client/app-icons/icon-32x32.png') }}" sizes="32x32">
<link rel="apple-touch-icon" href="{{ asset('client/app-icons/icon-180x180.png') }}">

<!-- Theme switcher (color modes) -->
<script src="{{ asset('client/js/theme-switcher.js') }}"></script>

<!-- Preloaded local web font (Inter) -->
<link rel="preload" href="{{ asset('client/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin="">

<!-- Font icons -->
<link rel="preload" href="{{ asset('client/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin="">
<link rel="stylesheet" href="{{ asset('client/icons/cartzilla-icons.min.css') }}">

<!-- Vendor styles -->
<link rel="stylesheet" href="{{ asset('client/vendor/swiper/swiper-bundle.min.css') }}">

<!-- Bootstrap + Theme styles -->
<link rel="preload" href="{{ asset('client/css/theme.min.css') }}" as="style">
<link rel="preload" href="{{ asset('client/css/theme.rtl.min.css') }}" as="style">
<link rel="stylesheet" href="{{ asset('client/css/theme.min.css') }}" id="theme-styles">

<!-- Customizer -->
<script src="{{ asset('client/js/customizer.min.js') }}"></script>

{{--  mô tả của chi tiết sản phẩm --}}
<style>
    .product-description {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
    }

    .product-description img {
        max-width: 100%; 
        height: auto;
        display: block;
        margin: 10px 0; 
    }

    .product-description p {
        margin-bottom: 10px; 
    }
</style>
{{-- chọn màu của sản phẩm --}}
<style>
              
    .btn-color {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1;
        border: 2px solid #ddd; 
        transition: border-color 0.3s; 
    }

    
    .btn-color:hover {
        border-color: #333;
    }

    
    .btn-check:checked + .btn-color {
        border-color: #000; 
    }
</style>
{{-- /* Nút Chat */ --}}
<style>
.chat-button {
    position: fixed;
    bottom: 10px;
    right: 20px;
    background-color: #007bff;
    color: #fff;
    border-radius: 10px;
    width: 150px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}
/* Popup Chat */
.chat-popup {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 350px;
    max-width: 100%;
    height: 500px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
    display: none;
    z-index: 1000;
    overflow: hidden;
    overflow-y: auto;
}

/* Định dạng cho phần nội dung chat */
/* .chat-popup .user-chat-topbar,
.chat-popup .chat-conversation {
    height: calc(100% - 40px);
}
.chat-popup .user-chat-topbar {
    border-bottom: 1px solid #f1f1f1;
}
.chat-popup #chat-conversation {
    height: calc(100% - 60px);
    overflow-y: auto;
} */
/* Tổng thể khung chat */
.chat-container {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    background-color: #fff;
}

/* Thanh điều hướng trên cùng */
.chat-header {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-info {
    display: flex;
    justify-content: center;
    align-items: center;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.username {
    font-size: 16px;
    margin: 0;
}

.status {
    font-size: 14px;
    color: #b2d1ff;
}

/* Khu vực hiển thị tin nhắn */
.chat-messages {
    flex-grow: 1;
    padding: 20px;
    overflow-y: auto; /* Cho phép cuộn khi có nhiều tin nhắn */
    background-color: #f5f7fa;
}

.message {
    padding: 9px;
    max-width: 70%;
    margin-bottom: 10px;
    position: relative;
    font-size: 15px;
    line-height: 1.5;
    word-wrap: break-word; /* Cho phép từ dài xuống dòng */
    overflow-wrap: break-word; /* Đảm bảo chữ không bị tràn ra ngoài */
    /* padding: 10px; */
    border-radius: 5px;
}

.received {
    background-color: #007bff;
    color: #fff;
    margin-left: auto; /* Đẩy tin nhắn nhận được sang bên trái */
    align-self: flex-start; /* Căn trái cho tin nhắn nhận */
}

/* Tin nhắn gửi đi */
.sent {
    background-color: #e9ecef;
    margin-right: auto; /* Đẩy tin nhắn gửi đi sang bên phải */
    align-self: flex-end; /* Căn phải cho tin nhắn gửi */
}

.timestamp {
    font-size: 12px;
    color: #888;
    position: absolute;
    bottom: -15px;
    right: 10px;
}

/* Khu vực nhập tin nhắn */
.chat-input {
    display: flex;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #ddd;
    background-color: #f9f9f9;
}

#messageInput {
    flex-grow: 1; /* Làm cho ô nhập tin nhắn chiếm không gian còn lại */
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    font-size: 14px;
    margin-right: 10px;
}

.send-button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
}
</style>

{{-- form kiểm tra thong tin chat --}}
<style>
    .info-form {
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.info-form label {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
}

.info-form input,
.info-form select,
.info-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
}

.info-form button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>