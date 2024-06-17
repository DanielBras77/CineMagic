<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->payment_type == "VISA") {
            $rules = "|max:20|regex:/^\d{16}-\d{3}$/";
        } elseif ($this->payment_type == "PAYPAL") {
            $rules = "|email";
        } else {
            $rules = "|digits:9";
        }

        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'required|date|date_format:Y-m-d|after_or_equal:now',
            'total_price' => 'required|numeric|min:0|regex:/^\d{1,6}(\.\d{1,2})?$/',
            'receipt_pdf_filename' => 'required|string|max:255',
            'customer_name' => 'required|string|min:3|max:255',
            'costumer_email' => 'required|email|unique:users, email,'.($this->user?$this->user->id:null), // preciso de alterar ?
            'nif' => 'required|string|digits:9',
            'payment_type' => 'required|in:MBWAY,VISA,PAYPAL',
            'payment_ref' => 'required:payment_type' . $rules,
        ];
    }
}
