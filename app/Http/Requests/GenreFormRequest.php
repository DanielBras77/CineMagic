<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
        if (empty($this->genre)) {

            $rules = array_merge($rules, [
                'code' => 'required|string|max:20|unique:genres,code',
            ]);
        }
        return $rules;
    }
}
