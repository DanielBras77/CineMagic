<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TheaterFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:theaters,name,'.($this->theater?$this->theater->id:null),
            'photo_file' => 'sometimes|image|max:4096', // maxsize = 4Mb
        ];
    }
}
