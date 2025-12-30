<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:roles,name',
            'guard_name' => 'required|string|in:web,api',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo del Rol es obligatorio.',
            'name.string' => 'El campo del Rol debe ser una cadena de texto.',
            'name.max' => 'El campo del Rol no debe tener más de 100 caracteres.',
            'name.unique' => 'El campo del Rol debe ser único.',
            'guard_name.required' => 'El campo Guard es obligatorio.',
            'guard_name.string' => 'El campo Guard debe ser una cadena de texto.',
            'guard_name.in' => 'El campo Guard debe ser "web" o "api".',
        ];
    }
}
