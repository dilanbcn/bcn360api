<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'titulo' => 'required|string',
            'ruta' => 'required|string',
            'modelo' => 'required|string',
            'estado' => 'boolean',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute es inválido',
            'boolean' => 'El campo :attribute debe ser booleano',
        ];
    }

    public function attributes()
    {
        return [
            'titulo' => 'título',
            'ruta' => 'ruta',
            'modelo' => 'modelo',
            'estado' => 'estado',
        ];
    }
}
