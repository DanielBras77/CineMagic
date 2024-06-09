<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->payment_type == "MBWAY") {
            $rules = "|max:20|regex:/^\d{16}-\d{3}$/";
        } elseif ($this->payment_type == "PAYPAL") {
            $rules = "|email";
        } else {
            $rules = "|digits:9";
        }

        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->user ? $this->user->id : null),
            'photo_filename' => 'sometimes|image|max:4096',
            'nif' => 'nullable|string|min:9|max:9',
            'payment_type' => 'nullable|in:MBWAY,VISA,PAYPAL',
            'payment_ref' => 'required_with:payment_type' . $rules,
        ];
    }
}
