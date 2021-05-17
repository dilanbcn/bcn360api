<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AccionRequest;
use App\Models\Administracion\Accion;
use Illuminate\Http\Request;

class AccionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acciones = Accion::all();

        return $this->showAll($acciones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccionRequest $request)
    {
        $accion = Accion::create([
            'menu_id' => $request->get('menu_id'),
            'ruta_id' => $request->get('ruta_id'),
            'descripcion' => $request->get('descripcion'),
            'create' => ($request->get('create')) ? $request->get('create') : false,
            'read' => ($request->get('read')) ? $request->get('read') : false,
            'update' => ($request->get('update')) ? $request->get('update') : false,
            'delete' => ($request->get('delete')) ? $request->get('delete') : false,
        ]);

        $accion->save();

        return $this->showOne($accion);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administracion\Accion  $accion
     * @return \Illuminate\Http\Response
     */
    public function show(Accion $accione)
    {
        return $this->showOne($accione);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Accion  $accion
     * @return \Illuminate\Http\Response
     */
    public function update(AccionRequest $request, Accion $accione)
    {
        $accione->fill([
            'menu_id' => $request->get('menu_id'),
            'ruta_id' => $request->get('ruta_id'),
            'descripcion' => ($request->get('descripcion')) ? $request->get('descripcion') : $accione->descripcion,
            'create' => ($request->get('create')) ? $request->get('create') : $accione->create,
            'read' => ($request->get('read')) ? $request->get('read') : $accione->read,
            'update' => ($request->get('update')) ? $request->get('update') : $accione->update,
            'delete' => ($request->get('delete')) ? $request->get('delete') : $accione->delete,
        ]);
        
        $accione->save();

        return $this->showOne($accione);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\Accion  $accion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accion $accione)
    {
        $accione->delete();

        return $this->showOne($accione);
    }
}
