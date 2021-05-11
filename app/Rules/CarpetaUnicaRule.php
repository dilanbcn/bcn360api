<?php

namespace App\Rules;

use App\Models\Administracion\Carpeta;
use Illuminate\Contracts\Validation\Rule;

class CarpetaUnicaRule implements Rule
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

        $filtroId = (isset(request()->route('carpeta')->id)) ? request()->route('carpeta')->id : null;
        $filtroPadre = (request()->get('padre')) ? request()->get('padre') : null;

        if (request()->get('padre')) {
            $cantidad = Carpeta::when($filtroPadre, function ($query) use ($filtroPadre) {
                $query->where(['padre_id' => $filtroPadre]);
            })->whereRaw("UPPER(nombre) LIKE '%" . strtoupper(request()->get('nombre')) . "%'")
                ->when($filtroId, function ($query) use ($filtroId) {
                    $query->where('id', '<>', $filtroId);
                })->count();
        } else {
            $cantidad = Carpeta::whereRaw("UPPER(nombre) LIKE '%" . strtoupper(request()->get('nombre')) . "%'")
                ->when($filtroId, function ($query) use ($filtroId) {
                    $query->where('id', '<>', $filtroId);
                })->count();
        }

        return ($cantidad > 0) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La carpeta ya existe en esa ruta';
    }
}
