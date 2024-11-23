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
                <h2 class="h3 pb-2 pb-sm-3">Tin tức liên quan</h2>
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
                    <h4 class="h6 mb-4">Danh mục tin tức</h4>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($categories as $category)
                        {{-- {{ route('categoryNewsBlog', ['slug' => $category->slug]) }} --}}
                        <a class="btn btn-outline-secondary px-3" href="">{{ $category->title }}</a>

                        @endforeach
                    </div>
                    <h4 class="h6 pt-5 mb-0">Bài viết mới nhất</h4>
                    @foreach ($latestNews as $latest)
                    <article class="hover-effect-scale position-relative d-flex align-items-center border-bottom py-4">
                        <div class="w-100 pe-3">
                            <h3 class="h6 mb-2">

                                <a class="hover-effect-underline stretched-link" href="{{ route('news.show', $latest->slug) }}">

                                    {{ $latest->title }}
                                </a>
                            </h3>
                            <div class="text-body-tertiary fs-xs pb-2 mb-1">{{ $latest->created_at}}</div>
                        </div>
                        <div class="ratio w-100" style="max-width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                            <img src="{{ asset('storage/' .  $latest->thumbnail) }}" alt="{{ $latest->title }}" class="rounded-2">
                            {{-- <img src="{{ Storage::url($latest->thumbnail) }}" class="rounded-2" alt="{{ $latest->title }}"> --}}
                        </div>
                    </article>
                    @endforeach
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

</div>
@endsection