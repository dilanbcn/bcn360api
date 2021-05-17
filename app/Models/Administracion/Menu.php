<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    const table = 'menus';
    protected $table = Menu::table;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'padre_id', 
        'titulo', 
        'ruta', 
        'modelo', 
        'estado', 
    ];

    public function acciones()
    {
    	return $this->hasMany(Accion::class);
    }

    public function rutas()
    {
    	return $this->hasMany(Ruta::class);
    }

    public function padre()
    {
        return $this->belongsTo(Menu::class, 'padre_id', 'id');
    }
}
