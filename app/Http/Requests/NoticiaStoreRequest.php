<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaStoreRequest extends FormRequest
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
            'titulo' => 'required',
            'tema' => 'required',
            'contenido' => 'required',
            'file' => 'required|image'
        ];
    }

    public function messages(){
        return [
            'titulo.required' => 'Ingrese un titulo',
            'tema.required' => 'Ingrese un tema',
            'contenido.required' => 'Ingrese un contenido',
            'file.required' => 'Ingrese una caratula',
            'file.image' => 'La caratula debe ser una imagen'
        ];   
    }
}
