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
            'nik' => ['required', 'numeric', 'digits:16'],
            'gender' => ['required', 'string'],
            'kk' => ['required', 'numeric', 'digits:16'],
            'phone' => ['required', 'string'],
            'street' => ['required', 'string'],
            'house_number' => ['required', 'numeric'],
            'job' => ['required', 'uuid'],
            'education' => ['required', 'uuid'],
            'residenceStatus' => ['required', 'uuid'],
            'salary' => ['required', 'uuid'],
            'marriageStatus' => ['required', 'string', 'max:255'],
            'socialStatus' => ['required', 'uuid'],
            'religion' => ['required', 'uuid'],
            'familyStatus' => ['required', 'uuid'],
            'is_death' => ['nullable', 'boolean'],
            'death_date' => ['nullable', 'date'],
            'rt' => ['required', 'numeric'],
            'rw' => ['required', 'numeric'],
        ];
    }
}
