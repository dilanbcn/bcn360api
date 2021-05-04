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

Route::get('roles', 'Administracion\RolController@index')->name('roles.index');
Route::post('roles', 'Administracion\RolController@store')->name('roles.store');
Route::get('roles/{rol}', 'Administracion\RolController@show')->name('roles.show');
Route::put('roles/{rol}', 'Administracion\RolController@update')->name('roles.update');
Route::delete('roles/{rol}', 'Administracion\RolController@destroy')->name('roles.destroy');

Route::get('menus', 'Administracion\MenuController@index')->name('menus.index');
Route::post('menus', 'Administracion\MenuController@store')->name('menus.store');
Route::get('menus/{menu}', 'Administracion\MenuController@show')->name('menus.show');
Route::put('menus/{menu}', 'Administracion\MenuController@update')->name('menus.update');
Route::delete('menus/{menu}', 'Administracion\MenuController@destroy')->name('menus.destroy');
