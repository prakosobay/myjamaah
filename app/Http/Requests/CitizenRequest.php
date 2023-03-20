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
            'name' => ['nullable', 'string', 'max:255'],
            'birthday' => ['nullable', 'date'],
            'nik' => ['required', 'numeric'],
            'gender' => ['nullable', 'string'],
            'kk' => ['nullable', 'numeric'],
            'phone' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'house_number' => ['nullable', 'numeric'],
            'job' => ['nullable', 'uuid'],
            'education' => ['nullable', 'uuid'],
            'residenceStatus' => ['nullable', 'uuid'],
            'salary' => ['nullable', 'uuid'],
            'marriageStatus' => ['nullable', 'string', 'max:255'],
            'socialStatus' => ['nullable', 'uuid'],
            'religion' => ['nullable', 'uuid'],
            'familyStatus' => ['nullable', 'uuid'],
            'is_death' => ['nullable', 'boolean'],
            'death_date' => ['nullable', 'date'],
            'rt' => ['nullable', 'numeric'],
            'rw' => ['nullable', 'numeric'],
        ];
    }
}
