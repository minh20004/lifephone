<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

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
    public function store(VoucherRequest $request)
    {
        $voucher = Voucher::create([
            'code' => $request->code,
            'discount_percentage' => $request->discount_percentage,
            'max_discount_amount' => $request->max_discount_amount,
            'min_order_value' => $request->min_order_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit,
        ]);
        return redirect()->route('vouchers.index')->with('success', 'Voucher đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(VoucherRequest $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher -> update([
            'code' => $request->code,
            'discount_percentage' => $request->discount_percentage,
            'max_discount_amount' => $request->max_discount_amount,
            'min_order_value' => $request->min_order_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit,
        ]);
        return redirect()->route('vouchers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id); // Tìm voucher theo id
        $voucher->delete(); // Xóa voucher
        return redirect()->route('vouchers.index'); // Chuyển hướng về trang danh sách với thông báo
    }
}
