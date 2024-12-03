@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Danh sách thông báo đơn hàng</h2>

        @if($notifications->count() > 0)
            <div class="list-group">
                @foreach ($notifications as $notification)
                    <a href="{{ route('admin.notifications.markAsRead', $notification->id) }}" class="list-group-item list-group-item-action 
                        @if($notification->is_read) bg-light @else bg-warning @endif">
                        <h5 class="mb-1">Đơn hàng #{{ $notification->order->id }} đã được đặt!</h5>
                        <p class="mb-1">{{ $notification->order->customer_name }} đã đặt đơn hàng vào {{ $notification->created_at->diffForHumans() }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $notifications->links() }} <!-- Phân trang -->
            </div>
        @else
            <p>Không có thông báo nào.</p>
        @endif
    </div>
@endsection
