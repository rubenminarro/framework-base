<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
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
        return [
            'role' => 'required|nullable|exists:roles,name',
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'El campo del Nombre es obligatorio.',
            'role.nullable' => 'El campo del Rol no puede ser nulo.',
            'role.exists' => 'El campo del Rol debe existir.',
        ];
    }
}
