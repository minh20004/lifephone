<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|unique:vouchers,code',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'max_discount_amount' => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'required|integer|min:1',
            'image' => 'required'
        ];
    }

    public function massages(): array
    {
        return [
            'code.required' => 'Voucher code is required',
            'discount_rate.required' => 'Voucher discount rate is required',
            'max_discount.required' => 'Voucher max discount is required',
            'min_order_value.required' => 'Voucher min order value is required',
            'start_date.required' => 'Voucher start date is required',
            'end_date.required' => 'Voucher end date is required',
            'usage_limit.required' => 'Voucher usage limit is required',
            'image.image' => 'Voucher image must be an image',
        ];
    }
}
