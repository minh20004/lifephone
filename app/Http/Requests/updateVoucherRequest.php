<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateVoucherRequest extends FormRequest
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
            // Sửa lại mã voucher, kiểm tra tính duy nhất khi cập nhật (trừ chính voucher đang được sửa)
            'code' => 'required',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'max_discount_amount' => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Voucher code is required.',
            'code.unique' => 'The voucher code has already been taken.',
            'discount_percentage.required' => 'Voucher discount rate is required.',
            'discount_percentage.numeric' => 'Voucher discount rate must be a numeric value.',
            'discount_percentage.min' => 'Voucher discount rate must be at least 0.',
            'discount_percentage.max' => 'Voucher discount rate can be at most 100.',
            'max_discount_amount.required' => 'Voucher max discount amount is required.',
            'max_discount_amount.numeric' => 'Voucher max discount amount must be a numeric value.',
            'max_discount_amount.min' => 'Voucher max discount amount must be at least 0.',
            'min_order_value.required' => 'Voucher min order value is required.',
            'min_order_value.numeric' => 'Voucher min order value must be a numeric value.',
            'min_order_value.min' => 'Voucher min order value must be at least 0.',
            'start_date.required' => 'Voucher start date is required.',
            'start_date.date' => 'Voucher start date must be a valid date.',
            'end_date.required' => 'Voucher end date is required.',
            'end_date.date' => 'Voucher end date must be a valid date.',
            'end_date.after_or_equal' => 'Voucher end date must be after or equal to the start date.',
            'usage_limit.required' => 'Voucher usage limit is required.',
            'usage_limit.integer' => 'Voucher usage limit must be an integer.',
            'usage_limit.min' => 'Voucher usage limit must be at least 1.',
            'image.image' => 'Voucher image must be an image.',
        ];
    }
}
