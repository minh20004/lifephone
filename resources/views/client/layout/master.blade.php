<!DOCTYPE html><html lang="en" data-bs-theme="light" data-pwa="true">
<!-- Mirrored from cartzilla.createx.studio/home-electronics.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 06 Sep 2024 06:26:54 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SEO Meta Tags -->
    <title>@yield('title')</title>
    @include('client.layout.partials.css')
    @include('client.layout.partials.js')
  </head>
  <!-- Body -->
  <body>
    <!-- Customizer offcanvas -->
    @include('client.layout.partials.Customizeroffcanvas')

    <!-- Shopping cart offcanvas -->
    @include('client.layout.partials.Shoppingcartoffcanvas')

    <!-- Navigation bar (Page header) -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark d-block z-fixed p-0" data-sticky-navbar="{&quot;offset&quot;: 500}">
        @include('client.layout.partials.header')
    </header>
    <!-- Page content -->
    <main class="content-wrapper">
      @yield('content')
    </main>
    <!-- Page footer -->
    <footer class="footer position-relative bg-dark">
        @include('client.layout.partials.footer')
    </footer>
    <!-- Back to top button -->
    <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
      <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
        Top
        <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
        <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
        <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></rect>
        </svg>
      </a>
      <a class="btn btn-sm btn-outline-secondary text-uppercase bg-body rounded-pill shadow animate-rotate ms-2 me-n5" href="#customizer" style="font-size: .625rem; letter-spacing: .05rem;" data-bs-toggle="offcanvas" role="button" aria-controls="customizer">
        Customize<i class="ci-settings fs-base ms-1 me-n2 animate-target"></i>
      </a>
    </div>
    <!-- Vendor scripts -->
    @include('client.layout.partials.js')
</body>
<!-- Mirrored from cartzilla.createx.studio/home-electronics.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 06 Sep 2024 06:27:25 GMT -->
</html>
