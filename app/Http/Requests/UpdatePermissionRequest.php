<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
        
        $permission = $this->route('permission');
        
        return [
            'name' => 'required|string|max:100|unique:permissions,name,'.$permission->id,
            'guard_name' => 'required|string|in:web,api'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo del Permiso es obligatorio.',
            'name.string' => 'El campo del Permiso debe ser una cadena de texto.',
            'name.max' => 'El campo del Permiso no debe tener más de 100 caracteres.',
            'name.unique' => 'El campo del Permiso debe ser único.',
            'guard_name.required' => 'El campo Guard es obligatorio.',
            'guard_name.string' => 'El campo Guard debe ser una cadena de texto.',
            'guard_name.in' => 'El campo Guard debe ser "web" o "api".',
        ];
    }
}
