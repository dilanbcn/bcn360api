<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RolAccionesRequest;
use App\Models\Administracion\Rol;
use Illuminate\Http\Request;

class RolAccionesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Rol $role)
    {
        $acciones = $role->acciones;

        return $this->showAll($acciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */

    public function update(RolAccionesRequest $request, Rol $role)
    {
        $acciones = $request->get('acciones');

        $role->acciones()->detach();

        foreach ($acciones as $accion) {

            $role->acciones()->syncWithoutDetaching($accion);
        }

        return $this->showAll($role->acciones);
    }
}
