<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ArchivoUsuariosRequest;
use App\Models\Administracion\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivoUsuariosController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Archivo $archivo)
    {
        $archivo->usuarios = $this->usuariosArchivo($archivo->id);

        return $this->showOne($archivo);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */

    public function update(ArchivoUsuariosRequest $request, Archivo $archivo)
    {
        $usuarios = $request->get('usuarios');
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

        return $this->showOne($archivo);
    }
}
