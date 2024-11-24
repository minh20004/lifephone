<style>
    .address-item {
    border: 1px solid #ddd; /* Viền nhẹ */
    border-radius: 8px; /* Góc bo tròn */
    padding: 15px; /* Khoảng cách trong */
    background-color: #fff; /* Nền trắng */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng */
    transition: transform 0.2s, box-shadow 0.2s; /* Hiệu ứng khi hover */
}

/* .address-item:hover {
    transform: translateY(-3px); /* Nổi lên khi hover */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Đổ bóng đậm hơn */
} */

.address-item .btn {
    margin-left: 5px; /* Khoảng cách giữa các nút */
}

.address-item .badge {
    margin-left: 10px; /* Khoảng cách giữa text và badge */
}

</style>
@extends('client/page/auth/layout/master')

@section('content_customer')
<div class="">
    <h2 class="h3 mb-3">Địa chỉ của tôi</h2>
    <div class="py-4">
    <!-- Nút Thêm Địa Chỉ -->
    @if(Auth::user()->addresses->count() < 6)
    <div class="text-end">
        <button type="button" class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="fa-solid fa-plus"></i>  Thêm địa chỉ
        </button>
    </div>
    @endif
    </div>
    <!-- Modal thêm địa chỉ -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('customer.addAddress') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <ul class="list-unstyled">
        @foreach(Auth::user()->addresses as $address) 
            <li class="address-item mb-3">
                <div class="d-flex justify-content-between">
                    <span>
                        {{ $address->address }}
                        @if($address->is_default)
                            <span class="badge text-bg-info">Mặc định</span>
                        @endif
                    </span>
                    <div>
                        @if(!$address->is_default)
                            <a href="{{ route('customer.setDefaultAddress', $address->id) }}" class="btn btn-sm btn-secondary">
                                Thiết lập mặc định
                            </a>
                        @endif
                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#editAddressModal" 
                                data-id="{{ $address->id }}" data-address="{{ $address->address }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        @if(!$address->is_default)
                            <form action="{{ route('customer.deleteAddress', $address->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-danger" disabled title="Không thể xóa địa chỉ mặc định">
                                <i class="bi bi-trash3"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <p>{{ Auth::user()->name ?? 'Tên chưa được cập nhật' }}</p>
            </li>
        @endforeach
    </ul>
    
    <!-- Modal chỉnh sửa địa chỉ -->
    <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" id="editAddressForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAddressModalLabel">Chỉnh sửa địa chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newAddress" class="form-label">Địa chỉ mới</label>
                            <input type="text" class="form-control" id="newAddress" name="address" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // JavaScript để xử lý modal chỉnh sửa
    var editAddressModal = document.getElementById('editAddressModal');
    editAddressModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Nút 'Chỉnh sửa'
        var addressId = button.getAttribute('data-id');
        var addressText = button.getAttribute('data-address');

        var form = document.getElementById('editAddressForm');
        form.action = '/customer/address/' + addressId; // Cập nhật đường dẫn form

        var newAddressInput = document.getElementById('newAddress');
        newAddressInput.value = addressText; // Điền địa chỉ vào input
    });
</script>
@endsection
