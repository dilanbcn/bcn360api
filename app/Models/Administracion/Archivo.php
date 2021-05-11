<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archivo extends Model
{
    use HasFactory, SoftDeletes;

    const table = 'archivos';
    protected $table = Archivo::table;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'carpeta_id',
        'tipo_archivo_id',
        'nombre',
        'ruta',
        'nombre_archivo',
        'nombre_descarga',
        'privado',
        'estado',
        'declaracion',
        'creado_por',
    ];

    public function carpeta()
    {
    	return $this->belongsTo(Carpeta::class);
    }

    public function tipoArchivo()
    {
    	return $this->belongsTo(TipoArchivo::class);
    }

}
