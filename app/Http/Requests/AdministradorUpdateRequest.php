<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministradorUpdateRequest extends FormRequest
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
    public function rules() {
        return [
            'nombre' => 'required|alpha_dash',
            'apellido_paterno' => 'required|alpha',
            'apellido_materno' => 'required|alpha',
            'usuario' => 'required|alpha_num',
            'email' => 'required|email|unique:administradores,email,'.$this->administradore->email.',email'
        ];
    }

    public function messages(){
        return [
            'nombre.alpha_dash' => 'Solo caracteres',
            'nombre.required' => 'Ingrese un nombre',
            'apellido_materno.required' => 'Ingrese un apellido materno',
            'apellido_paterno.required' => 'Ingrese un apellido paterno',
            'usuario.required' => 'Ingrese un nombre de usuario',
            'usuario.alpha_num' => 'Solo caracteres alphanumericos',
            'email.required' => 'Ingrese un correo',
            'email.email' => 'Correo no valido',
            'email.unique' => 'Ya existe este email'
        ];
    }
}
