<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
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
    public function store(Request $request)
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
    public function show(Rol $rol)
    {
        return $this->showOne($rol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rol $rol)
    {
        $rol->fill($request->only([
            'descripcion',
            'estado',
        ]));

        if ($rol->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }
        
        $rol->save();

        return $this->showOne($rol);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rol $rol)
    {
        $rol->delete();

        return $this->showOne($rol);
    }
}
