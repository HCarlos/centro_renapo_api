<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'curp' => [
                'required',
                'string',
                'size:18',
                Rule::unique('users')->ignore($this->user()->id)
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'curp' => 'CURP',
        ];
    }

    public function messages(): array{

        return [
            'curp.unique' => 'Esta CURP ya está registrada por otro usuario.',
            'curp.size' => 'La CURP debe tener exactamente 18 caracteres.',
        ];
    }

}
