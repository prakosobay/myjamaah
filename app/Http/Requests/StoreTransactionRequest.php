<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'type' => ['required', 'array', 'min:1'],
            'type.*' => ['required', 'string'],
            'name' => ['required', 'array', 'min:1'],
            'name.*' => ['required', 'string', 'max:255'],
            'val' => ['required', 'array', 'min:1'],
            'val.*' => ['required', 'numeric'],
        ];
    }
}
