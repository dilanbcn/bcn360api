<?php

namespace App\Http\Requests;

use App\Rules\RolAdministradorRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioRolesRequest extends FormRequest
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
            'roles' => ['required', 'array', 'exists:roles,id', new RolAdministradorRule],
        ];
    }
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'array' => 'El campo :attribute es inválido',
            'exists' => 'El campo :attribute no existe',
            'not_in' => 'El campo :attribute no existe dentro de la BD',
        ];
    }

    public function attributes()
    {
        return [
            'roles' => 'roles',
        ];
    }
}
