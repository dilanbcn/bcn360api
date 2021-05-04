<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\ApiController;
use App\Models\Administracion\Menu;
use Illuminate\Http\Request;

class MenuController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();

        return $this->showAll($menus);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = Menu::create([
            'titulo' => $request->get('titulo'),
            'ruta' => $request->get('ruta'),
        ]);

        $menu->save();

        return $this->showOne($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administracion\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return $this->showOne($menu);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administracion\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->fill($request->only([
            'titulo' => $request->get('titulo'),
            'ruta' => $request->get('ruta'),
            'estado' => $request->get('estado'),
        ]));

        $menu->save();

        return $this->showOne($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administracion\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return $this->showOne($menu);
    }
}
