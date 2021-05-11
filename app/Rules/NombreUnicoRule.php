<?php

namespace App\Rules;

use App\Models\Administracion\Archivo;
use Illuminate\Contracts\Validation\Rule;

class NombreUnicoRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $cantidad = Archivo::where(['carpeta_id' => request()->get('carpeta_id')])
        ->whereRaw("UPPER(nombre) LIKE '%". strtoupper($value)."%'")
        ->where('id', '<>', request()->route('archivo')->id)->count();

        return ($cantidad > 0) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El nombre del archivo ya existe dentro de la carpeta';
    }
}
