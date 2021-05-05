<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolAccionesRequest extends FormRequest
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
            'acciones' => 'required|array|exists:acciones,id',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'array' => 'El campo :attribute es inválido',
            'exists' => 'El campo :attribute no existe',
        ];
    }

    public function attributes()
    {
        return [
            'acciones' => 'acciones',
        ];
    }
}
