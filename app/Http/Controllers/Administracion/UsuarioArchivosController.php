<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UsuarioArchivosRequest;
use App\Models\Administracion\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioArchivosController extends ApiController
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

            $arrArchivos = DB::table('archivo_usuario')
                ->select('archivo_id')
                ->where('usuario_id', $usuario)
                ->get();

            $archivos = null;

            if (count($arrArchivos) > 0) {

                foreach ($arrArchivos as $archivo) {
                    $arrArch[] = $archivo->archivo_id;
                }

                $archivos = Archivo::whereIn('id', $arrArch)->get();

                $collectUser['archivos'] = $archivos;
            }

            $collectUser['archivos'] = $archivos;

            return $this->showOneOnly($collectUser);

        } else {

            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $usuario
     * @return \Illuminate\Http\Response
     */

    public function update(UsuarioArchivosRequest $request, $usuario)
    {

        if (DB::table('usuarios')->where('id', $usuario)->exists()) {

            $archivos = Archivo::whereIn('id', $request->get('archivos'))->get();

            DB::table('archivo_usuario')->where('usuario_id', $usuario)->delete();

            foreach ($archivos as $archivo) {

                DB::table('archivo_usuario')->insert([
                    ['archivo_id' => $archivo->id, 'usuario_id' => $usuario]
                ]);
            }

            $collectUser = collect(DB::table('usuarios')->select('id', 'nombre', 'apellido')->where('id', $usuario)->first());

            $collectUser['archivos'] = $archivos;

            return $this->showOneOnly($collectUser);
        } else {
            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }
}
