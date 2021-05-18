<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Models\Administracion\Menu;
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

            $arrRoles = json_decode($usuario->roles);


            $roles = Rol::when($arrRoles, function ($sql) use ($arrRoles) {
                return $sql->whereIn('id', $arrRoles)->with('acciones', function ($sql) {
                    return $sql->with('menu');
                });
            })->get();

            $salida = array();
            $arrPadres = array();

            $roles->map(function ($rol) use (&$salida, &$arrPadres, &$arrHijos) {
                $rol->acciones->map(function ($accion) use (&$salida, &$arrPadres, &$arrHijos) {
                    $salida[$accion->menu->id] = $accion->menu;
                    $arrPadres[] = $accion->menu->padre_id;
                });
            });

            $menuUsuario = Menu::whereIn('id', array_unique($arrPadres))->get();

            $menuUsuario->map(function ($menu) use ($salida){
                if (!$menu->padre_id) {
                    $menu->hijos = Menu::where('padre_id', $menu->id)->whereIn('id', array_keys($salida))->get();
                }
            });

            return response()->json(array('data' => $menuUsuario), 201);
        } else {
            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }
}
