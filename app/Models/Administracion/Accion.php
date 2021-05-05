<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accion extends Model
{
    use HasFactory, SoftDeletes;

    const table = 'acciones';
    protected $table = Accion::table;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id', 
        'descripcion', 
        'create', 
        'read', 
        'update', 
        'delete', 
    ];

    protected $hidden = [
        'pivot'
    ];

    public function menu()
    {
    	return $this->belongsTo(Menu::class);
    }

    public function roles()
    {
    	return $this->belongsToMany(Rol::class);
    }
}
