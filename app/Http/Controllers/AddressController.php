<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Phương thức thêm địa chỉ
    public function addAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255|unique:addresses,address,',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^\d{10}$/|max:10',
            ], [
                'address.unique' => 'Địa chỉ này đã được sử dụng. Vui lòng thử lại.',
                'phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'phone_number.regex' => 'Vui lòng nhập đúng số điện thoại của bạn.',
                'phone_number.max' => 'Vui lòng nhập đúng số điện thoại của bạn.',
                'name.required' => 'Tên không được bỏ trống',
            ]);
        

        $address = new Address();
        $address->name = $request->name;
        $address->phone_number = $request->phone_number;
        $address->address = $request->address;
        $address->customer_id = auth()->id();
        $address->is_default = false;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ đã được thêm thành công!');
    }

    // Phương thức xóa địa chỉ
    public function deleteAddress($addressId)
    {
        $address = Address::findOrFail($addressId);
        $address->delete();

        return redirect()->back()->with('success', 'Địa chỉ đã được xóa!');
    }

    // Phương thức đặt địa chỉ làm mặc định
    public function setDefaultAddress($addressId)
    {
        $address = Address::findOrFail($addressId);
        
        // Đặt tất cả các địa chỉ của khách hàng thành không mặc định
        Address::where('customer_id', auth()->id())->update(['is_default' => false]);

        // Đặt địa chỉ này làm mặc định
        $address->is_default = true;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ mặc định đã được thay đổi!');
    }

    // Phương thức cập nhật địa chỉ
    public function updateAddress(Request $request, $addressId)
{
    // Xác thực dữ liệu nhập vào
    $request->validate([
    'address' => 'required|string|max:255|unique:addresses,address,' . $addressId,
    'name' => 'required|string|max:255',
    'phone_number' => 'required|regex:/^\d{10}$/|max:10',
    ], [
        'address.unique' => 'Địa chỉ này đã được sử dụng. Vui lòng thử lại.',
        'phone_number.required' => 'Vui lòng nhập số điện thoại.',
        'phone_number.regex' => 'Vui lòng nhập đúng số điện thoại của bạn.',
        'phone_number.max' => 'Vui lòng nhập đúng số điện thoại của bạn.',
        'name.required' => 'Tên không được bỏ trống',
    ]);

    // Tìm địa chỉ cần cập nhật
    $address = Address::findOrFail($addressId);
    $address->address = $request->address;
    $address->name = $request->name;  // Cập nhật tên nếu có
    $address->phone_number = $request->phone_number;  // Cập nhật số điện thoại nếu có
    $address->save();

    return redirect()->back()->with('success', 'Địa chỉ đã được cập nhật!');
}

}
