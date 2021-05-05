<?php

namespace App\Models\Administracion;

use App\Scope\RolScope;
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

    protected $hidden = [
        'pivot'
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new RolScope);
    }

    public function acciones()
    {
    	return $this->belongsToMany(Accion::class);
    }

}
