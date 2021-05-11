<?php

namespace App\Http\Requests;

use App\Rules\NombreUnicoRule;
use App\Rules\TipoArchivoRule;
use App\Rules\UsuarioExisteRule;
use Illuminate\Foundation\Http\FormRequest;

class ArchivoRequest extends FormRequest
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
        if ($this->route()->action['as'] == 'archivos.update') {
            return [
                'creado_por' => ['required', 'min:1', 'integer', new UsuarioExisteRule],
                'carpeta_id' => 'required|exists:carpetas,id',
                'nombre' => ['string' , new NombreUnicoRule],
                'privado' => 'boolean',
                'estado' => 'boolean',
                'declaracion' => 'boolean',
                'documento' => [new TipoArchivoRule, 'file'],

            ];
        } else {
            return [
                'creado_por' => ['required', 'min:1', 'integer', new UsuarioExisteRule],
                'carpeta_id' => 'required|exists:carpetas,id',
                'nombre' => 'required|string',
                'privado' => 'boolean',
                'estado' => 'boolean',
                'declaracion' => 'boolean',
                'documento' => [new TipoArchivoRule, 'file', 'required'],
            ];
        }
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'min' => 'El campo :attribute debe ser un entero positivo',
            'integer' => 'El campo :attribute debe ser un entero positivo',
            'exists' => 'El campo :attribute no existe',
            'string' => 'El campo :attribute es inválido',
            'boolean' => 'El campo :attribute debe ser booleano',
            'unique' => 'El nombre de archivo ya existe dentro de esta carpta',
        ];
    }

    public function attributes()
    {
        return [
            'carpeta_id' => 'id carpeta',
            'nombre' => 'nombre',
            'ruta' => 'ruta',
            'privado' => 'privado',
            'estado' => 'estado',
            'declaracion' => 'declaracion',
            'creado_por' => 'creado_por',
            'documento' => 'documento',
        ];
    }
}
