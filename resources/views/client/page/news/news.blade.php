@extends('client.layout.master')
@section('title')
Lifephone
@endsection
@section('content')
<main class="content-wrapper">

    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{Route('home')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tin tức</li>
        </ol>
    </nav>


    <!-- Page title -->
    <h1 class="h3 container mb-4">Tin tức nổi bật </h1>


    <!-- Featured posts -->
    <section class="container pb-5">
        <div class="row gy-5 pb-5">

            <!-- Article -->
            @if($mostViewedNews)
    <article class="col-md-6 col-lg-7">
        <a class="ratio d-flex hover-effect-scale rounded-4 overflow-hidden"
            href="{{ route('news.show', ['slug' => $mostViewedNews->slug]) }}"
            style="--cz-aspect-ratio: calc(484 / 746 * 100%)">
            <img src="{{ asset('storage/' . $mostViewedNews->thumbnail) }}" alt=""  alt="{{ $mostViewedNews->title }}"  class="hover-effect-target">
            {{-- <img src="{{ Storage::url($mostViewedNews->thumbnail) }}" alt="{{ $mostViewedNews->title }}"
                class="hover-effect-target"> --}}
        </a>
        <div class="pt-4">
            <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                <a class="nav-link text-body fs-xs text-uppercase p-0"
                    href="#!">{{ $mostViewedNews->category_news->title ?? 'Category' }}</a>
                <hr class="vr my-1 mx-1">
                <span class="text-body-tertiary fs-xs">
                    {{ $mostViewedNews->published_date }}
                </span>
            </div>
            <h3 class="h5 mb-0">
                <a class="hover-effect-underline"
                    href="{{ route('news.show', ['slug' => $mostViewedNews->slug]) }}">
                    {{ $mostViewedNews->title }}
                </a>
            </h3>
        </div>
    </article>
@endif

            <!-- Side list -->
            <div class="col-md-6 col-lg-5 d-flex flex-column align-content-between gap-4">

                @foreach ($additionalMostViewedNews as $item)
                <article class="hover-effect-scale position-relative d-flex align-items-center ps-xl-4 mb-xl-1">
                    <div class="w-100 pe-3 pe-sm-4 pe-lg-3 pe-xl-4">
                        <div class="text-body-tertiary fs-xs pb-2 mb-1">{{ $item->published_at }}</div>
                        <h3 class="h6 mb-2">
                            <a class="hover-effect-underline stretched-link" href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                        </h3>
                    </div>
                    <div class="ratio w-100 rounded overflow-hidden" style="max-width: 196px; --cz-aspect-ratio: calc(140 / 196 * 100%)">
                        <img  src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}">

                    </div>
                    
                </article>
                @endforeach

            </div>
            <hr class="my-0 my-md-2 my-lg-4">
    </section>


    <!-- Posts grid + Sidebar -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
        <div class="row">
            <h2>Tất cả bài viết</h2>
            <!-- Posts grid -->
            <div class="col-lg-8">
                <div class="row row-cols-1 row-cols-sm-2 gy-5">

                    <!-- Article -->
                    @foreach ($allNews as $news)
                    <article class="col">
                        <a
                            class="ratio d-flex hover-effect-scale rounded overflow-hidden"
                            href="{{ route('news.show', $news->slug) }}"
                            style="--cz-aspect-ratio: calc(305 / 416 * 100%)">
                            <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}"  class="hover-effect-target">
                        </a>
                        <div class="pt-4">
                            <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                                <a
                                    class="nav-link text-body fs-xs text-uppercase p-0"
                                    href="#!">{{ $news->category_news }}</a>
                                <hr class="vr my-1 mx-1">
                                <span class="text-body-tertiary fs-xs">{{ $news->published_at}}</span>
                            </div>
                            <h3 class="h5 mb-0">
                                <a class="hover-effect-underline" href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>

                            </h3>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="row row-cols-1 row-cols-sm-2 gy-5">
                    <div class="pagination-wrapper">
                        {{ $allNews->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            <!-- Contributors' posts slider -->


            <!-- Sticky sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            <aside class="col-lg-4 col-xl-3 offset-xl-1" style="margin-top: -115px">
            <h4 class="h6 mb-4">Danh mục tin tức</h4>
                    <div class="d-flex flex-wrap gap-3">
                        {{-- @foreach($categories as $category)
                        <a class="btn btn-outline-secondary px-3" href="{{ route('categoryNewsBlog', ['slug' => $category->slug]) }}">{{ $category->title }}</a>
                        @endforeach --}}
                    </div>
                <section class="latest-news">
                    <h4>Bài viết mới nhất</h4>
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
                            <img src="{{ asset('storage/' . $latest->thumbnail) }}" alt=""  alt="{{ $latest->title }}" class="rounded-2" >
                        </div>
                    </article>
                    @endforeach
    </section>
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
    <!-- Article -->

    <!-- Pagination (Bullets) -->
    <div class="swiper-pagination position-static mt-4"></div>
    </div>
    </section>
</main>
@endsection