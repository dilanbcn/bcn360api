<?php

use App\Models\Administracion\Menu;
use App\Models\Administracion\Ruta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Ruta::table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained(Menu::table);
            $table->string('nombre');
            $table->boolean('estado')->default(true);

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
        Schema::dropIfExists(Ruta::table);
    }
}
