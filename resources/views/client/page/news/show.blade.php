@extends('client.layout.master')
@section('title')
Lifephone
@endsection
@section('content')
<nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{Route('home')}}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{Route('news.index')}}">Tin tức</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ Str::limit($news->title, 20) }}
        </li>
    </ol>
</nav>

<section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
    <div class="row">

        <!-- Posts content -->
        <div class="col-lg-8 position-relative z-2">

            <!-- Post title -->
            <h1 class="h3 mb-4">{{ $news->title }}</h1>

            <!-- Post meta -->
            <div class="nav align-items-center gap-2 border-bottom pb-4 mt-n1 mb-4">
                <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!"> {{ $news->category_news_id }}</a>
                <hr class="vr my-1 mx-1">
                <span class="text-body-tertiary fs-xs">{{ $news->published_at }}</span>
            </div>


            <div class="" style="--cz-aspect-ratio: calc(599 / 856 * 100%)">
                @if($news->thumbnail)
                <figure class="figure w-100 py-3 py-md-4 mb-3">
                    <img src="{{ asset('storage/' . $news->thumbnail) }}" class="rounded-4" alt="Image">
                </figure>
                @endif
            </div>

            @if($news->content)
            {!! $news->content !!}
            @else
            <p>No content available.</p>
            @endif
            <!-- Subscription CTA -->
            <div class="d-sm-flex align-items-center justify-content-between bg-body-tertiary rounded-4 py-5 px-4 px-md-5">
                <div class="mb-4 mb-sm-0 me-sm-4">
                    <h3 class="h5 mb-2">Đăng kí để có những thông tin mới nhất</h3>
                    <p class="fs-sm mb-0">Đăng kí ngay để chúng tôi thông báo cho bạn về khuyến mãi của chúng tôi</p>
                </div>
                <button type="button" class="btn btn-dark ">
                    <i class="ci-mail fs-base ms-n1 me-2"></i>
                    <a href="#" style="color:white">
                        Đăng kí
                    </a>
                </button>
            </div>


            <!-- Related articles -->
            <div class="pt-5 mt-2 mt-md-3 mt-lg-4 mt-xl-5">
                <h2 class="h3 pb-2 pb-sm-3">Tin tức mới nhất</h2>
                <div class="d-flex flex-column gap-4 mt-n3">

                    <!-- Article -->
                    @foreach($relatedPost as $post) <!-- Vòng lặp qua các bài viết liên quan -->
                    <article class="row align-items-start align-items-md-center gx-0 gy-4 pt-3">
                        <div class="col-sm-5 pe-sm-4">
                            <a class="ratio d-flex hover-effect-scale rounded overflow-hidden flex-md-shrink-0" href="{{ route('news.show', ['slug' => $post->slug]) }}" style="--cz-aspect-ratio: calc(226 / 306 * 100%)">
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" class="hover-effect-target" alt="Image">
                            </a>
                        </div>
                        <div class="col-sm-7">
                            <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                                @foreach($relatedPost as $spost)
                                @if($spost->category_news)
                                <a class="nav-link text-body fs-xs text-uppercase p-0" href="{{ route('category_news', ['slug' => $spost->category_news->slug]) }}">
                                    {{ $spost->category_news->title }}
                                </a>
                                @else
                                <p>Category</p>
                                @endif
                                @endforeach

                                <hr class="vr my-1 mx-1">
                                <span class="text-body-tertiary fs-xs">{{ $post->published_at }}</span>
                            </div>
                            <h3 class="h5 mb-2 mb-md-3">
                                <a class="hover-effect-underline" href="{{ route('news.show', ['slug' => $post->slug]) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="mb-0">{{ Str::limit($post->short_content, 150) }}</p>
                        </div>
                    </article>
                    @endforeach


                    <!-- Article -->

                    <div class="nav">
                        <a class="nav-link animate-underline px-0 py-2" href="{{Route(name: 'news.index')}}">
                            <span class="animate-target">Xem tất cả</span>
                            <i class="ci-chevron-right fs-base ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sticky sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
        <aside class="col-lg-4 col-xl-3 offset-xl-1" style="margin-top: -115px">
            <div class="offcanvas-lg offcanvas-end sticky-lg-top ps-lg-4 ps-xl-0" id="blogSidebar">
                <div class="d-none d-lg-block" style="height: 115px"></div>
                <div class="offcanvas-header py-3">
                    <h5 class="offcanvas-title">Sidebar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#blogSidebar" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-block pt-2 py-lg-0">
                    <h4 class="h6 mb-4">Blog categories</h4>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($categories as $category)
                        <a class="btn btn-outline-secondary px-3" href="{{ route('categoryNewsBlog', ['slug' => $category->slug]) }}">{{ $category->title }}</a>
                        @endforeach
                    </div>
                    <h4 class="h6 pt-5 mb-0">Trending posts</h4>
                    <article class="hover-effect-scale position-relative d-flex align-items-center border-bottom py-4">
                        <div class="w-100 pe-3">
                            <h3 class="h6 lh-base fs-sm mb-0">
                                <a class="hover-effect-underline stretched-link" href="#!">The role of philanthropy in building a better world</a>
                            </h3>
                        </div>
                        <div class="ratio w-100" style="max-width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                            <img src="assets/img/blog/grid/v1/th01.jpg" class="rounded-2" alt="Image">
                        </div>
                    </article>
                    <article class="hover-effect-scale position-relative d-flex align-items-center border-bottom py-4">
                        <div class="w-100 pe-3">
                            <h3 class="h6 lh-base fs-sm mb-0">
                                <a class="hover-effect-underline stretched-link" href="#!">The biggest prospects for the smart home electronics industry</a>
                            </h3>
                        </div>
                        <div class="ratio w-100" style="max-width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                            <img src="assets/img/blog/grid/v1/th02.jpg" class="rounded-2" alt="Image">
                        </div>
                    </article>
                    <article class="hover-effect-scale position-relative d-flex align-items-center py-4">
                        <div class="w-100 pe-3">
                            <h3 class="h6 lh-base fs-sm mb-0">
                                <a class="hover-effect-underline stretched-link" href="#!">Behind-the-scenes stories from the world of iPhones</a>
                            </h3>
                        </div>
                        <div class="ratio w-100" style="max-width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                            <img src="assets/img/blog/grid/v1/th03.jpg" class="rounded-2" alt="Image">
                        </div>
                    </article>
                    <h4 class="h6 pt-4">Follow us</h4>
                    <div class="d-flex gap-2 pb-2">
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>" title="Instagram" aria-label="Follow us on Instagram">
                            <i class="ci-instagram"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>" title="X (Twitter)" aria-label="Follow us on X">
                            <i class="ci-x"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>" title="Facebook" aria-label="Follow us on Facebook">
                            <i class="ci-facebook"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>" title="Telegram" aria-label="Follow us on Telegram">
                            <i class="ci-telegram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>
</main>


<!-- Page footer -->
<footer class="footer position-relative bg-dark border-top">
    <span class="position-absolute top-0 start-0 w-100 h-100 bg-body d-none d-block-dark"></span>
    <div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">

        <!-- Columns with links that are turned into accordion on screens < 500px wide (sm breakpoint) -->
        <div class="accordion py-5" id="footerLinks">
            <div class="row">
                <div class="col-md-4 d-sm-flex flex-md-column align-items-center align-items-md-start pb-3 mb-sm-4">
                    <h4 class="mb-sm-0 mb-md-4 me-4">
                        <a class="text-dark-emphasis text-decoration-none" href="home-electronics.html">Cartzilla</a>
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
                    <img src="assets/img/payment-methods/visa-dark-mode.svg" alt="Visa">
                </div>
                <div>
                    <img src="assets/img/payment-methods/mastercard.svg" alt="Mastercard">
                </div>
                <div>
                    <img src="assets/img/payment-methods/paypal-dark-mode.svg" alt="PayPal">
                </div>
                <div>
                    <img src="assets/img/payment-methods/google-pay-dark-mode.svg" alt="Google Pay">
                </div>
                <div>
                    <img src="assets/img/payment-methods/apple-pay-dark-mode.svg" alt="Apple Pay">
                </div>
            </div>
            <p class="text-body fs-xs text-center text-md-start mb-0 me-4 order-md-1">© All rights reserved. Made by <span class="animate-underline"><a class="animate-target text-dark-emphasis fw-medium text-decoration-none" href="https://createx.studio/" target="_blank" rel="noreferrer">Createx Studio</a></span></p>
        </div>
    </div>

    <!-- Additional spacing to accommodate the sticky offcanvas toggle button -->
    <div class="d-lg-none" style="height: 3.75rem"></div>
</footer>


<!-- Blog sidebar offcanvas toggle that is visible on screens < 992px wide (lg breakpoint) -->
<button type="button" class="fixed-bottom z-sticky w-100 btn btn-lg btn-dark border-0 border-top border-light border-opacity-10 rounded-0 pb-4 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#blogSidebar" aria-controls="blogSidebar" data-bs-theme="light">
    <i class="ci-sidebar fs-base me-2"></i>
    Sidebar
</button>


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
@endsection