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
<link rel="stylesheet" href="{{ asset('client/css/header.css') }}" id="theme-styles">

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
