<?php

namespace App\Http\Requests;

use App\Rules\UsuarioExisteRule;
use Illuminate\Foundation\Http\FormRequest;

class TipoArchivoRequest extends FormRequest
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
        if ($this->route()->action['as'] == 'tipo_archivos.update'){
            return [
                'creado_por' => ['required', 'min:1', 'integer', new UsuarioExisteRule],
                'extension' => 'string|unique:tipo_archivos,extension',
                'estado' => 'boolean',
            ];
            
        } else {
            return [
                'creado_por' => ['required', 'min:1', 'integer', new UsuarioExisteRule],
                'extension' => 'required|string|unique:tipo_archivos,extension',
                'estado' => 'boolean',
            ];
        }

        
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'integer' => 'El campo :attribute debe ser un entero positivo',
            'min' => 'El campo :attribute debe ser un entero positivo',
            'string' => 'El campo :attribute es inválido',
            'boolean' => 'El campo :attribute debe ser booleano',
            'unique' => 'La extensión ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'usuario_id' => 'id usuario',
            'extension' => 'extensión',
            'estado' => 'estado'
        ];
    }
}
