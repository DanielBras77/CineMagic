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
            'name' => 'required|string|max:255|movies,name,'.($this->movie?$this->movie->id:null),
            'genre_code' => 'required| exists:genres,code',
            'title' => 'required|string|min:2|max:255',
            'year' => 'required|integer',
            'synopsis' => 'required|string',
            'trailer url' => 'string|max:255',
            'photo_file' => 'sometimes|image|max:4096', // maxsize = 4Mb
        ];
    }
}
