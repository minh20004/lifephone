@extends('client.layout.master')
@section('title')
    Lifephone
@endsection
@section('content')
<main class="content-wrapper">

    <!-- Thank you message -->
    <section class="container pt-3 pt-sm-4 pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
      <div class="position-relative overflow-hidden rounded-5 p-4 p-sm-5" style="background-color: var(--cz-success-border-subtle)">
        <div class="position-relative z-2 text-center py-4 py-md-5 my-md-2 my-lg-5 mx-auto" style="max-width: 536px">
          <h1 class="pt-xl-4 mb-4">ĐẶT HÀNG THÀNH CÔNG </h1>
          <p class="text-dark-emphasis pb-3 pb-sm-4"><span class="fw-semibold">Cảm ơn bạn đã đặt hàng!</span> Đơn hàng của bạn đã được chấp nhận và sẽ được xử lý trong thời gian ngắn. </p>
          <a class="btn btn-lg btn-success rounded-pill mb-xl-4" href="{{route('home')}}">Tiếp Tục Mua Sắm</a>
          <a class="btn btn-lg btn-danger rounded-pill mb-xl-4" href="{{route('order.history')}}">Lịch Sử Đơn Hàng</a>
        </div>
        <img src="{{asset('client/img/shop/grocery/thankyou-bg-1.png')}}" class="animate-up-down position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Background image">
        <img src="{{asset('client/img/shop/grocery/thankyou-bg-2.png')}}" class="animate-down-up position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Background image">
      </div>
    </section>


    
  </main>
@endsection
