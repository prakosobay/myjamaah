<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitizenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'nik' => ['required', 'numeric'],
            'gender' => ['required', 'string'],
            'kk' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
            'street' => ['required', 'string'],
            'rt' => ['required', 'numeric'],
            'rw' => ['required', 'numeric'],
            'house_number' => ['required', 'numeric'],
            'job' => ['required', 'uuid'],
            'education' => ['required', 'uuid'],
            'residenceStatus' => ['required', 'uuid'],
            'salary' => ['required', 'uuid'],
            'marriageStatus' => ['required', 'uuid'],
            'socialStatus' => ['required', 'uuid'],
            'religion' => ['required', 'uuid'],
            'familyStatus' => ['required', 'uuid'],
            'isDeath' => ['required', 'boolean'],
            'death_date' => ['nullable', 'date'],
        ];
    }
}
