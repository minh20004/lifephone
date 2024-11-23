@extends('client/page/auth/layout/master')

@section('content_customer')
<div class="py-4">
    <h3 class="h6 mb-3">Các địa chỉ của bạn</h3>
    <ul class="list-unstyled">
        @foreach(Auth::user()->addresses as $address)
            <li>
                <div class="d-flex justify-content-between">
                    <span>{{ $address->address }}</span>
                    <div>
                        @if($address->is_default)
                            <span class="badge text-bg-info">Mặc định</span>
                        @else
                            <a href="{{ route('customer.setDefaultAddress', $address->id) }}" class="btn btn-sm btn-outline-primary">Đặt làm mặc định</a>
                        @endif
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAddressModal" data-id="{{ $address->id }}" data-address="{{ $address->address }}">Chỉnh sửa</button>

                        <form action="{{ route('customer.deleteAddress', $address->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Form thêm địa chỉ -->
    @if(Auth::user()->addresses->count() < 6)
    <form action="{{ route('customer.addAddress') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="address" class="form-label">Thêm địa chỉ mới</label>
            <input type="text" id="address" name="address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm địa chỉ</button>
    </form>
    @endif
</div>

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
