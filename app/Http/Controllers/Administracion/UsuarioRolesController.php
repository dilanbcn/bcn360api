<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UsuarioRolesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioRolesController extends ApiController
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRolesRequest $request, $usuario)
    {
        if (DB::table('usuarios')->where('id', $usuario)->exists()) {

            DB::table('usuarios')->where('id', $usuario)->update(['roles' => json_encode($request->get('roles'))]);
            $collectUser = collect(DB::table('usuarios')->where('id', $usuario)->first());
            
            return $this->showOneOnly($collectUser);

        } else {
            return $this->errorResponse('No existe ninguna instancia de usuario con el id especificado', 404);
        }
    }
}
