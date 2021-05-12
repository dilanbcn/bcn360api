<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ArchivoUsuariosRequest;
use App\Models\Administracion\Carpeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarpetaUsuariosController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Carpeta $carpeta)
    {
        $archivos = $carpeta->archivo;

        if ($archivos) {

            $carpeta->archivo->map(function ($archivo) {

                $archivo->usuarios = $this->usuariosArchivo($archivo->id);
                
            });

            return $this->showOne($carpeta);

        } else {

            return $this->errorResponse('La carpeta no posee archivos', 404);

        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */

    public function update(ArchivoUsuariosRequest $request, Carpeta $carpeta)
    {

        $usuarios = $request->get('usuarios');

        $carpeta->archivo->map(function ($archivo) use ($usuarios) {

            DB::table('archivo_usuario')->where('archivo_id', $archivo->id)->delete();

            foreach ($usuarios as $usaurio) {

                DB::table('archivo_usuario')->insert([
                    ['usuario_id' => $usaurio, 'archivo_id' => $archivo->id]
                ]);
            }

            $datosUsuarios = DB::table('usuarios')
                ->select('id', 'nombre', 'apellido')
                ->whereIn('id', $usuarios)
                ->get();

            $archivo->usuarios = $datosUsuarios;

        });

        return $this->showOne($carpeta);

    }
}
