<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoArchivo extends Model
{
    use HasFactory;

    const table = 'tipo_archivos';
    protected $table = TipoArchivo::table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'extension', 
        'creado_por', 
        'estado', 
    ];

    public function archivo()
    {
    	return $this->hasMany(Archivo::class);
    }
}
