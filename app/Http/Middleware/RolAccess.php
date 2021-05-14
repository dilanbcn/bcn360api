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
        $strRuta = explode('.', $ruta);

        $ruta = Ruta::where('nombre', 'like', strtolower($strRuta[0]))->first();
        $paso = false;
        if ($ruta) {
            // $usuario = auth()->user();
            $usuario = 1;

            $usuario = DB::table('usuarios')->where('id', $usuario)->first();

            $roles = json_decode($usuario->roles);


            $roles = Rol::whereIn('id', $roles)->whereHas('acciones', function ($sql) use ($ruta) {
                return $sql->whereHas('menu', function ($query) use ($ruta) {
                    return $query->where('id', $ruta->menu_id);
                });
            })->exists();

            $paso = ($roles) ? true : false;

        }

        return $paso;
    }
}
