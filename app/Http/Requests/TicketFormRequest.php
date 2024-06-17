<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'screening_id' => 'required|exists:screening,id',
            'seat_id' => 'required|exists:seat,id',
            'purchase_id'=> 'required|exists:purchase,id',
            'price' => 'required|numeric|min:0|regex:/^\d{1,6}(\.\d{1,2})?$/', // pode ser preciso alterar no configuration
            'status' => 'required|in:VALID,INVALID',
        ];
    }
}
