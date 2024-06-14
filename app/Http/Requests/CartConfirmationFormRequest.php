<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartConfirmationFormRequest extends FormRequest
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
            'customer_name' => 'required|string|min:3|max:255',
            'customer_email' => 'required|email',
            'nif' => 'required|string|digits:9',
            'payment_type' => 'required|in:MBWAY,VISA,PAYPAL',
            'payment_ref' => 'required:payment_type' . $rules,
        ];
    }
}
