<?php

namespace Database\Seeders;

use App\Models\Administracion\Menu;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::flushEventListeners();

        $archivo = File::get(storage_path('seeders/menus.json'));
        $menus = json_decode($archivo, true);

        foreach($menus as $menu) {
            DB::table(Menu::table)->insert([
                'padre_id' => $menu['padre_id'],
                'titulo' => $menu['titulo'],
                'ruta' => $menu['ruta'],
                'modelo' => $menu['modelo'],
                'estado' => $menu['estado'],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
