<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CarpetaUsuarioRequest;
use App\Models\Administracion\Archivo;
use App\Models\Administracion\Carpeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioCarpetasController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($usuario)
    {

        if (DB::table('usuarios')->where('id', $usuario)->exists()) {

            $collectUser = collect(DB::table('usuarios')->select('id', 'nombre', 'apellido')->where('id', $usuario)->first());

            $collectUser['archivos'] = $this->carpetaUsuario($usuario);

            return $this->showOneOnly($collectUser);
        } else {

            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */

    public function update(CarpetaUsuarioRequest $request, $usuario)
    {
        if (DB::table('usuarios')->where('id', $usuario)->exists()) {

            $collectUser = collect(DB::table('usuarios')->select('id', 'nombre', 'apellido')->where('id', $usuario)->first());

            $carpetas = Carpeta::whereIn('id', $request->get('carpetas'))->with('archivo')->get();

            $carpetas->map(function ($carpeta) use ($usuario) {

                DB::table('archivo_usuario')->where('usuario_id', $usuario)->delete();

                foreach ($carpeta->archivo as $archivo) {

                    DB::table('archivo_usuario')->insert([
                        ['archivo_id' => $archivo->id, 'usuario_id' => $usuario]
                    ]);
                }

            });


            $collectUser['carpetas'] = $carpetas;

            return $this->showOneOnly($collectUser);

        } else {

            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }
}
