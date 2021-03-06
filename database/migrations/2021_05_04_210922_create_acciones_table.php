<?php

use App\Models\Administracion\Accion;
use App\Models\Administracion\Menu;
use App\Models\Administracion\Ruta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Accion::table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained(Menu::table);
            $table->foreignId('ruta_id')->constrained(Ruta::table);
            $table->string('descripcion');
            $table->boolean('create')->nullable();
            $table->boolean('read')->nullable();
            $table->boolean('update')->nullable();
            $table->boolean('delete')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Accion::table);
    }
}
