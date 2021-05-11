<?php

use App\Models\Administracion\Carpeta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarpetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Carpeta::table, function (Blueprint $table) {
            $table->id();
            $table->integer('padre_id')->unsigned()->nullable();
            $table->string('nombre');
            $table->string('path');
            $table->boolean('estado')->default(true);
            $table->integer('creado_por')->unsigned()->nullable();

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
        Schema::dropIfExists(Carpeta::table);
    }
}
