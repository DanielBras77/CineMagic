<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => 'required'|'exists:movies,id',
            'theater_id' => 'required|exists:theaters, id',
            'date' => 'required|date|date_format:Y-m-d|after_or_equal:now',
            'start_time' => 'required|date_format:H:i',
        ];
    }
}
