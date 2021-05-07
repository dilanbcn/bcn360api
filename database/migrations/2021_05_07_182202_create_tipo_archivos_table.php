<?php

use App\Models\Administracion\TipoArchivo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TipoArchivo::table, function (Blueprint $table) {
            $table->id();
            $table->string('extension')->unique();
            $table->boolean('estado')->default(true);
            $table->integer('creado_por')->unsigned()->nullable();

            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(TipoArchivo::table);
    }
}
