<?php

namespace App\Http\Requests;

use App\Rules\CarpetaUnicaRule;
use App\Rules\UsuarioExisteRule;
use Illuminate\Foundation\Http\FormRequest;

class CarpetaRequest extends FormRequest
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
        if ($this->route()->action['as'] == 'carpetas.update') {
            return [
                'creado_por' => ['required', 'min:1', 'integer', new UsuarioExisteRule],
                'nombre' => ['string', new CarpetaUnicaRule],
                'padre' => [ 'exclude_if:padre,null', 'not_in:'.request()->route('carpeta')->id, new CarpetaUnicaRule],
                'estado' => 'boolean',
            ];
        } else {
            return [
                'creado_por' => ['required', 'min:1', 'integer', new UsuarioExisteRule],
                'nombre' => ['string', 'required', new CarpetaUnicaRule],
                'padre' => [ 'exclude_if:padre,null', new CarpetaUnicaRule],
                'estado' => 'boolean',
            ];
        }
        
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'min' => 'El campo :attribute debe ser un entero positivo',
            'integer' => 'El campo :attribute debe ser un entero positivo',
            'string' => 'El campo :attribute es inválido',
            'unique' => 'La carpeta ya existe',
            'boolean' => 'El campo :attribute debe ser booleano',
            'exists' => 'El campo :attribute no existe',
            'not_in' => 'La carpeta padre debe ser distinta a la carpeta actual',
        ];
    }

    public function attributes()
    {
        return [
            'usuario_id' => 'id usuario',
            'nombre' => 'nombre de la carpeta',
            'estado' => 'estado',
            'padre' => 'directorio padre'
        ];
    }
}
