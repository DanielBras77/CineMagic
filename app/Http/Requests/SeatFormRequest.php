<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'theater_id' => 'required|exists:theaters_id',
            'row' => 'required|string|min:1|max:1',
            'seat_number' => 'required|integer|min:1',
        ];
    }
}
