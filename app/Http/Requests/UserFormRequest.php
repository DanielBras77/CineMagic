<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users, email, '.($this->user?$this->user->id:null),
            'type' => 'required|in:A,E',
            'photo_filename' => 'sometimes|image|max:4096',
            'trailer_url' => 'nullable|url:http,https|max:255',
            'photo_file' => 'sometimes|image|max:4096', // maxsize = 4Mb
            'password'  => 'required|string|min:8|confirmed',
            //'password_configuration' =>

            /*	password opcional:
		        password			        sometimes|string|min:8|confirmed
		        password_configuration		sometimes
            */
        ];
    }
}
