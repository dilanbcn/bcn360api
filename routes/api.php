<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('roles', 'Administracion\RolController', ['except' => ['create', 'edit']]);

Route::resource('acciones', 'Administracion\AccionController', ['except' => ['create', 'edit']]);
Route::resource('roles.acciones', 'Administracion\RolAccionesController', ['only' => ['index']]);
Route::put('roles/{role}/acciones', 'Administracion\RolAccionesController@update')->name('roles.acciones.update');
Route::put('usuario/{usuario}/roles', 'Administracion\UsuarioRolesController@update')->name('usuario.roles');
Route::resource('usuario.menu', 'Administracion\UsuarioMenuController', ['only' => ['index']]);
Route::resource('tipo_archivos', 'Administracion\TipoArchivosController', ['except' => ['create', 'edit']]);


// Route::resource('usuario.archivos', 'Administracion\UsuarioArchivosController', ['only' => ['index']]);
// Route::put('usuario/{usuario}/archivos', 'Administracion\UsuarioArchivosController@update')->name('usuario.archivos.update');

// Route::resource('usuario.carpetas', 'Administracion\UsuarioCarpetasController', ['only' => ['index']]);
// Route::put('usuario/{usuario}/carpetas', 'Administracion\UsuarioCarpetasController@update')->name('usuarios.carpeta.update');

Route::resource('menus', 'Administracion\MenuController', ['except' => ['create', 'edit']]);

Route::group(['middleware' => 'rol'], function () {
    
    // CARPETAS
    Route::resource('carpetas', 'Administracion\CarpetaController', ['except' => ['create', 'edit']]);
    Route::resource('carpetas/{carpeta}/usuarios', 'Administracion\CarpetaUsuariosController', ['only' => ['index']]);
    Route::put('carpetas/{carpeta}/usuarios', 'Administracion\CarpetaUsuariosController@update')->name('carpetas.usuarios.update');
    Route::get('usuario/{usuario}/carpetas', 'Administracion\UsuarioCarpetasController@index')->name('carpetas.usuario.index');
    Route::put('usuario/{usuario}/carpetas', 'Administracion\UsuarioCarpetasController@update')->name('carpetas.usuario.update');

    // ARCHIVOS
    Route::resource('archivos', 'Administracion\ArchivoController', ['except' => ['create', 'edit']]);
    Route::resource('archivos.usuarios', 'Administracion\ArchivoUsuariosController', ['only' => ['index']]);
    Route::put('archivo/{archivo}/usuarios', 'Administracion\ArchivoUsuariosController@update')->name('archivos.usuarios.update');
    Route::get('usuario/{usuario}/archivos', 'Administracion\UsuarioArchivosController@index')->name('archivos.usuario.index');
    Route::put('usuario/{usuario}/archivos', 'Administracion\UsuarioArchivosController@update')->name('archivos.usuario.update');
});


// Route::post('menus', 'Administracion\MenuController@store')->name('menus.store');
// Route::get('menus/{menu}', 'Administracion\MenuController@show')->name('menus.show');
// Route::put('menus/{menu}', 'Administracion\MenuController@update')->name('menus.update');
// Route::delete('menus/{menu}', 'Administracion\MenuController@destroy')->name('menus.destroy');

// Route::get('roles/{rol}/acciones', 'Administracion\RolAccionesController@index')->name('roles.acciones.index');
