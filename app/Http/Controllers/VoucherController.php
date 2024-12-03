<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vouchers.themmoi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào (nếu cần)
        $request->validate([
            'code' => 'required|unique:vouchers,code|max:255',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
            'min_order_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Kiểm tra và lưu ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/vouchers', 'public');
        } else {
            $imagePath = null; // Nếu không có ảnh, gán null
        }

        // Tạo mới voucher
        $voucher = Voucher::create([
            'code' => $request->code,
            'image' => $imagePath,  // Lưu đường dẫn ảnh vào cơ sở dữ liệu
            'discount_percentage' => $request->discount_percentage,
            'max_discount_amount' => $request->max_discount_amount,
            'min_order_value' => $request->min_order_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Chức năng hiển thị voucher có thể thêm vào sau nếu cần
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'code' => 'required|max:255|unique:vouchers,code,' . $id,
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
            'min_order_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tìm voucher cần sửa
        $voucher = Voucher::findOrFail($id);

        // Kiểm tra và lưu ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Nếu voucher đã có ảnh cũ, xóa ảnh cũ khỏi storage
            if ($voucher->image && Storage::exists('public/' . $voucher->image)) {
                Storage::delete('public/' . $voucher->image);
            }

            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('uploads/vouchers', 'public');
        } else {
            // Nếu không có ảnh mới, giữ nguyên ảnh cũ
            $imagePath = $voucher->image;
        }

        // Cập nhật voucher
        $voucher->update([
            'code' => $request->code,
            'image' => $imagePath,  // Cập nhật lại đường dẫn ảnh nếu có
            'discount_percentage' => $request->discount_percentage,
            'max_discount_amount' => $request->max_discount_amount,
            'min_order_value' => $request->min_order_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm voucher cần xóa
        $voucher = Voucher::findOrFail($id);

        // Nếu voucher có ảnh, xóa ảnh khỏi storage
        if ($voucher->image && Storage::exists('public/' . $voucher->image)) {
            Storage::delete('public/' . $voucher->image);
        }

        // Xóa voucher
        $voucher->delete();

        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully!');
    }
}
