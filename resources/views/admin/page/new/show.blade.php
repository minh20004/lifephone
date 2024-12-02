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

</section>
</div>
</main>

<a href="{{ url()->previous() }}" class="btn-back" title="Quay lại">
    <i class="bi bi-arrow-left"></i> Quay lại
</a>

@endsection

<!-- Thêm CSS -->
<style>
    .btn-back {
        position: fixed;
        bottom: 20px;
        /* Đặt nút cách mép dưới 20px */
        right: 20px;
        /* Đặt nút cách mép phải 20px */
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #0056b3;
    }

    .btn-back i {
        margin-right: 5px;
    }
</style>
</div>