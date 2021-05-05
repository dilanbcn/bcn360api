<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RolRequest;
use App\Models\Administracion\Rol;
use Illuminate\Http\Request;

class RolController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::all();

        return $this->showAll($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolRequest $request)
    {
        $rol = Rol::create([
            'descripcion' => $request->get('descripcion'),
        ]);

        $rol->save();

        return $this->showOne($rol);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(Rol $role)
    {
        return $this->showOne($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(RolRequest $request, Rol $role)
    {
        $role->fill($request->only([
            'descripcion',
            'estado',
        ]));

        $role->save();

        return $this->showOne($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rol $role)
    {
        $role->delete();

        return $this->showOne($role);
    }
}
