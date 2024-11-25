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
        <div class="container py-5 mb-2 mb-sm-3 mb-md-4 mb-lg-5 mt-lg-3 mt-xl-4">
  
          <!-- Page title -->
          <h1 class="text-center">Contact us</h1>
          <p class="text-center pb-2 pb-sm-3">Fill out the form below and we will reply within 24 hours</p>
  
  
          <!-- Form + Image -->
          <section class="row row-cols-1 row-cols-md-2 g-0 overflow-hidden rounded-5">
  
            <!-- Contact form -->
            <div class="col bg-body-tertiary py-5 px-4 px-xl-5">
              <form class="needs-validation py-md-2 px-md-1 px-lg-3 mx-lg-3" novalidate="">
                <div class="position-relative mb-4">
                  <label for="name" class="form-label">Name *</label>
                  <input type="text" class="form-control form-control-lg rounded-pill" id="name" required="">
                  <div class="invalid-tooltip bg-transparent z-0 py-0 ps-3">Enter your name!</div>
                </div>
                <div class="position-relative mb-4">
                  <label for="email" class="form-label">Email *</label>
                  <input type="email" class="form-control form-control-lg rounded-pill" id="email" required="">
                  <div class="invalid-tooltip bg-transparent z-0 py-0 ps-3">Enter your email address!</div>
                </div>
                <div class="position-relative mb-4">
                  <label class="form-label">Subject *</label>
                  <select class="form-select form-select-lg rounded-pill" data-select="{
                    &quot;classNames&quot;: {
                      &quot;containerInner&quot;: &quot;form-select form-select-lg rounded-pill&quot;
                    }
                  }" required="">
                    <option value="">Select subject</option>
                    <option value="General inquiry">General inquiry</option>
                    <option value="Order status">Order status</option>
                    <option value="Product information">Product information</option>
                    <option value="Technical support">Technical support</option>
                    <option value="Website feedback">Website feedback</option>
                    <option value="Account assistance">Account assistance</option>
                    <option value="Security concerns">Security concerns</option>
                  </select>
                  <div class="invalid-tooltip bg-transparent z-0 py-0 ps-3">Select the subject of your message!</div>
                </div>
                <div class="position-relative mb-4">
                  <label for="message" class="form-label">Message *</label>
                  <textarea class="form-control form-control-lg rounded-6" id="message" rows="5" required=""></textarea>
                  <div class="invalid-tooltip bg-transparent z-0 py-0 ps-3">Write your message!</div>
                </div>
                <div class="pt-2">
                  <button type="submit" class="btn btn-lg btn-dark rounded-pill">Send message</button>
                </div>
              </form>
            </div>
  
            <!-- Image -->
            <div class="col position-relative">
              <img src="{{ asset('client/img/contact/form-image.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Image">
            </div>
          </section>
  
  
          <!-- Contacts -->
          <section class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 pt-5 pb-3 pb-md-4 pb-lg-3 mt-lg-0 mt-xxl-4">
            <div class="col text-center pt-1 pt-sm-2 pt-md-3">
              <div class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                <i class="ci-phone-outgoing position-absolute top-50 start-50 translate-middle"></i>
              </div>
              <h3 class="h6">Call us directly</h3>
              <ul class="list-unstyled m-0">
                <li class="nav animate-underline justify-content-center">
                  Customers:
                  <a class="nav-link animate-target fs-base ms-1 p-0" href="tel:+15053753082">+1&nbsp;50&nbsp;537&nbsp;53&nbsp;082</a>
                </li>
                <li class="nav animate-underline justify-content-center">
                  Franchise:
                  <a class="nav-link animate-target fs-base ms-1 p-0" href="tel:+15053753000">+1&nbsp;50&nbsp;537&nbsp;53&nbsp;000</a>
                </li>
              </ul>
            </div>
            <div class="col text-center pt-1 pt-sm-2 pt-md-3">
              <div class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                <i class="ci-mail position-absolute top-50 start-50 translate-middle"></i>
              </div>
              <h3 class="h6">Send a message</h3>
              <ul class="list-unstyled m-0">
                <li class="nav animate-underline justify-content-center">
                  Customers:
                  <a class="nav-link animate-target fs-base ms-1 p-0" href="mailto:info@cartzilla.com">info@cartzilla.com</a>
                </li>
                <li class="nav animate-underline justify-content-center">
                  Franchise:
                  <a class="nav-link animate-target fs-base ms-1 p-0" href="mailto:franchise@cartzilla.com">franchise@cartzilla.com</a>
                </li>
              </ul>
            </div>
            <div class="col text-center pt-1 pt-sm-2 pt-md-3">
              <div class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                <i class="ci-map-pin position-absolute top-50 start-50 translate-middle"></i>
              </div>
              <h3 class="h6">Store location</h3>
              <ul class="list-unstyled m-0">
                <li>New York 11741, USA</li>
                <li>396 Lillian Bolavandy, Holbrook</li>
              </ul>
            </div>
            <div class="col text-center pt-1 pt-sm-2 pt-md-3">
              <div class="position-relative d-inline-block bg-body-tertiary text-dark-emphasis fs-xl rounded-circle p-4 mb-3">
                <i class="ci-clock position-absolute top-50 start-50 translate-middle"></i>
              </div>
              <h3 class="h6">Working hours</h3>
              <ul class="list-unstyled m-0">
                <li>Mon - Fri  8:00 - 18:00</li>
                <li>Sut - Sun  10:00 - 16:00</li>
              </ul>
            </div>
          </section>
  
          <hr class="my-lg-5">
  
  
          <!-- Help center CTA -->
          <section class="text-center pb-xxl-3 pt-4 pt-lg-3">
            <h2 class="pt-md-2 pt-lg-0">Looking for support?</h2>
            <p class="pb-2 pb-sm-3">We might already have what you're looking for. See our FAQs or head to our dedicated Help Center.</p>
            <a class="btn btn-lg btn-outline-dark rounded-pill" href="#!">Help Center</a>
          </section>
        </div>
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