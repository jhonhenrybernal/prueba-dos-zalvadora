<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Si solo un admin puede registrar, descomenta la siguiente línea
        // return auth()->check() && auth()->user()->is_admin;
        return true; // O false para bloquear si no quieres uso libre
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // Solo permitir que admin cree admin, no desde frontend
            //'is_admin' => ['sometimes', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Este correo ya está registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
