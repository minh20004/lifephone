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
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                        <!-- Trường Tên -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên người nhận</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên người nhận" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <!-- Trường Số điện thoại -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Số điện thoại</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Nhập số điện thoại" required>
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <!-- Trường Địa chỉ -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Nhập địa chỉ" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                    <p>
                        <strong>{{ $address->name ?: 'Chưa cập nhật' }}</strong>  | {{ $address->phone_number ?: 'Chưa cập nhật' }}
                    </p>
                    <div>
                        @if(!$address->is_default)
                            <a href="{{ route('customer.setDefaultAddress', $address->id) }}" class="btn btn-sm btn-secondary">
                                Thiết lập mặc định
                            </a>
                        @endif
                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#editAddressModal" 
                                data-id="{{ $address->id }}" data-address="{{ $address->address }}"
                                data-name="{{ $address->name }}" data-phone-number="{{ $address->phone_number }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        @if(!$address->is_default)
                            <form action="{{ route('customer.deleteAddress', $address->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"  onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?') ? document.getElementById('delete-form-{{ $address->id }}').submit() : false;">
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
    
                <p>Địa chỉ: {{ $address->address ?: 'Chưa cập nhật' }}</p> 
                <p>
                    @if($address->is_default)
                        <span class="badge text-bg-info">Mặc định</span>
                    @endif
                </p> 
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
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="newAddress" name="address" required>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newName" class="form-label">Tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="newName" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPhoneNumber" class="form-label">Số điện thoại</label>
                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror" id="newPhoneNumber" name="phone_number">
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
        var button = event.relatedTarget;
        var addressId = button.getAttribute('data-id');
        var addressText = button.getAttribute('data-address');
        var nameText = button.getAttribute('data-name');
        var phoneNumberText = button.getAttribute('data-phone-number');

        var form = document.getElementById('editAddressForm');
        form.action = '/customer/address/' + addressId; 

        // Điền thông tin vào các trường trong modal
        var newAddressInput = document.getElementById('newAddress');
        newAddressInput.value = addressText;

        var newNameInput = document.getElementById('newName');
        newNameInput.value = nameText || '';

        var newPhoneNumberInput = document.getElementById('newPhoneNumber');
        newPhoneNumberInput.value = phoneNumberText || '';
    });
</script>

@endsection
