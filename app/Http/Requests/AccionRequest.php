<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccionRequest extends FormRequest
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
            'menu_id' => 'required|integer|exists:menus,id',
            'descripcion' => 'required|string',
            'create' => 'boolean',
            'read' => 'boolean',
            'update' => 'boolean',
            'delete' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute es inválido',
            'boolean' => 'El campo :attribute debe ser booleano',
            'exists' => 'El campo :attribute no existe',
            'integer' => 'El campo :attribute debe ser un número',
        ];
    }

    public function attributes()
    {
        return [
            'menu_id' => 'menu',
            'descripcion' => 'descripción',
            'create' => 'acción crear',
            'read' => 'acción leer',
            'update' => 'acción modificar',
            'delete' => 'acción eliminar',
        ];
    }
}
