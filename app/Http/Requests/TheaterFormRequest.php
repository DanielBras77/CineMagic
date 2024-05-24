<?php

namespace App\Http\Requests;

use App\Models\Teather;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeatherFormRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Adds the user information (from the theater route parameter) to the Request
        // if it is a post, user = null
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'user' => null,
            ]);
        } else {
            $this->merge([
                'user' => $this->route('theater')->user,
            ]);
        }
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:theaters,name,'.($this->theater?$this->theater->id:null),
            'photo_file' => 'sometimes|image|max:4096', // maxsize = 4Mb
        ];
    }
}
