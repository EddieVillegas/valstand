<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministradorStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'apellido_paterno' => 'required|alpha',
            'apellido_materno' => 'required|alpha',
            'usuario' => 'required|alpha_num',
            'email' => 'required|email|unique:administradores,email',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'Se requiere nombre',
            'nombre.required' => 'Ingrese un nombre',
            'apellido_materno.required' => 'Ingrese un apellido materno',
            'apellido_paterno.required' => 'Ingrese un apellido paterno',
            'usuario.required' => 'Ingrese un nombre de usuario',
            'usuario.alpha_num' => 'Solo caracteres alphanumericos',
            'email.required' => 'Ingrese un correo',
            'email.email' => 'Correo no valido',
            'email.unique' => 'El email ya existe',
            'password.required' => 'Ingrese una contraseña',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe de ser mayor a :min'
        ];
    }
}
