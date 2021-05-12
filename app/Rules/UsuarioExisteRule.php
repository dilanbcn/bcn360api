<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UsuarioExisteRule implements Rule
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

        $arrUsuarioId = (is_array($value)) ? $value : explode(" ", $value);

        $res = DB::table('usuarios')->whereIn('id', $arrUsuarioId)->count();

        $return = ($res != count($arrUsuarioId)) ? false : true;

        return $return;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No existe ninguna instancia de usuario con el id especificado';
    }
}
