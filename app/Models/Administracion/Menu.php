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
        'titulo', 
        'ruta', 
        'estado', 
    ];

    public function acciones()
    {
    	return $this->hasMany(Accion::class);
    }
}
