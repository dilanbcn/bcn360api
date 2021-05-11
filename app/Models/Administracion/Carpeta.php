<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carpeta extends Model
{
    use HasFactory, SoftDeletes;

    const table = 'carpetas';
    protected $table = Carpeta::table;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'padre_id',
        'nombre', 
        'estado', 
        'path',
        'creado_por', 
    ];

    public function archivo()
    {
    	return $this->hasMany(Archivo::class);
    }

    public function padre()
    {
        return $this->belongsTo(Carpeta::class, 'padre_id', 'id');
    }
}
