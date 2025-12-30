<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:50',
            'password' => 'nullable|string|min:6',
            'role' => 'required|exists:roles,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo del Nombre es obligatorio.',
            'name.string' => 'El campo del Nombre debe tener el formato correcto.',
            'name.max' => 'El campo del Nombre no debe tener más de 100 caracteres.',
            'email.required' => 'El campo del Correo es obligatorio.',
            'email.email' => 'El campo del Correo debe tener el formato correcto.',
            'email.max' => 'El campo del Correo no debe tener más de 50 caracteres.',
            'password.string' => 'El campo de la Contraseña debe tener el formato correcto.',
            'password.min' => 'El campo de la Contraseña debe tener mínimo de 6 caracteres.',
            'role.required' => 'El campo del Nombre es obligatorio.',
            'role.exists' => 'El campo del Rol debe existir.',
        ];
    }
}
