<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory, SoftDeletes;

    const table = 'roles';
    protected $table = Rol::table;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion', 
        'estado', 
    ];

    public function acciones()
    {
    	return $this->belongsToMany(Accion::class);
    }

}
