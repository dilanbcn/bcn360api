<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarpetaUsuarioRequest extends FormRequest
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
            'carpetas' => 'required|array|exists:carpetas,id',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'array' => 'El campo :attribute es inválido',
            'exists' => 'La :attribute no existe',
        ];
    }

    public function attributes()
    {
        return [
            'carpetas' => 'carpeta',
        ];
    }
}
