<?php

namespace App\Rules;

use App\Models\Administracion\TipoArchivo;
use Illuminate\Contracts\Validation\Rule;

class TipoArchivoRule implements Rule
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
        $extension = strtolower($value->getClientOriginalExtension());

        $cantidad = TipoArchivo::whereRaw("UPPER(extension) LIKE '%". strtoupper($extension)."%'")->count();

        return ($cantidad > 0) ? true : false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $permitidos = TipoArchivo::where(['estado' => 1])->get();

        return 'Tipo de archivo inválido, solo se permiten '.$permitidos->implode('extension', ', ');
    }
}
