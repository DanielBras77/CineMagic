<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'name_pt' => 'required|string|max:255',
            'type' => 'required|in:Degree,Master,TESP',
            'semesters' => 'required|integer|between:1,10',
            'ECTS' => 'required|integer|min:1',
            'places' => 'required|integer|min:0',
            'contact' => 'required|email',
            'objectives' => 'required|string',
            'objectives_pt' => 'required|string',
        ];
        if (strtolower($this->getMethod()) == 'post') {
            // This will merge 2 arrays:
            // (adds the "abbreviation" rule to the $rules array)
            $rules = array_merge($rules, [
                'abbreviation' => 'required|string|max:20|unique:courses,abbreviation',
            ]);
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'ECTS.required' => 'ECTS is required',
            'ECTS.integer' => 'ECTS must be an integer',
            'ECTS.min' => 'ECTS must be equal or greater that 1',
        ];
    }
}
