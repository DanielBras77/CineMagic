<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfigurationFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ticket_price' => 'required|numeric|min:0',
            'registered_customer_ticket_discount' => 'required|numeric|min:1|lt:ticket_price',
        ];
    }
}
