<?php

namespace App\Http\Middleware;

use App\Models\Administracion\Menu;
use App\Models\Administracion\Rol;
use App\Models\Administracion\Ruta;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $accesoUsuario = $this->getAccesoUsuario($request->route()->action['as']);

        if ($accesoUsuario) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Acceso denegado', 'code' => 401], 401);
        }
    }

    private function getAccesoUsuario($ruta)
    {

        $arrRuta = explode('.', $ruta);
        $strQuery = $this->getAccion(end($arrRuta));

        $ruta = Ruta::where('nombre', 'like', strtolower($arrRuta[0]))->first();
        $paso = false;

        if ($ruta) {
            // $usuario = auth()->user();
            $usuario = 1;

            $usuario = DB::table('usuarios')->where('id', $usuario)->first();

            $arrRoles = json_decode($usuario->roles);

            $roles = array();

            if ($arrRoles) {
                $roles = Rol::whereIn('id', $arrRoles)->whereHas('acciones', function ($sql) use ($ruta, $strQuery) {
                    return $sql->where('ruta_id', $ruta->id)->where($strQuery, 1);
                })->with('acciones')->get()->pluck('acciones')->unique()->values();
            }


            $paso = (count($roles)) ? true : false;
        }

        return $paso;
    }

    private function getAccion($strAccion)
    {
        switch ($strAccion) {
            case "index":
                $strQuery = 'read';
                break;
            case "store":
                $strQuery = 'create';
                break;
            case "update":
                $strQuery = 'update';
                break;
            case "destroy":
                $strQuery = 'delete';
                break;
        }

        return $strQuery;
    }
}
