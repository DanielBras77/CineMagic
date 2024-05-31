<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'genre_code' => 'required|exists:genres,code',
            'title' => 'required|string|min:2|max:255',
            'year' => 'required|integer|digits:4',
            'synopsis' => 'required|string',
            'trailer url' => 'string|max:255',
            'photo_file' => 'sometimes|image|max:4096', // maxsize = 4Mb
        ];
    }
}
