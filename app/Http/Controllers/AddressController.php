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
            'address' => 'required|string|max:255',
        ]);

        $address = new Address();
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

        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        // Tìm địa chỉ cần cập nhật
        $address = Address::findOrFail($addressId);
        $address->address = $request->address;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ đã được cập nhật!');
    }
}
