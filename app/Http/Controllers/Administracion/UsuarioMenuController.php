<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Models\Administracion\Rol;
use Illuminate\Support\Facades\DB;

class UsuarioMenuController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($usuario)
    {

        if (DB::table('usuarios')->where('id', $usuario)->exists()) {

            $usuario = DB::table('usuarios')->where('id', $usuario)->first();

            $roles = json_decode($usuario->roles);

            $roles = Rol::when($roles, function ($sql) use ($roles) {
                return $sql->whereIn('id', $roles)->with('acciones', function ($sql) {
                    return $sql->with('menu');
                });
            })->get();

            $salida = array();

            $roles->map(function ($rol) use (&$salida) {
                $rol->acciones->map(function ($accion) use (&$salida) {
                    $salida[] = $accion->menu;
                });
            });

            return response()->json(array('data' => $salida), 201);

        } else {
            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }
}
