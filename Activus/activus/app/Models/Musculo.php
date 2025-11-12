<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musculo extends Model
{
    protected $table = 'musculo';
    protected $primaryKey = 'ID_Musculo';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Musculo',
    ];

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'ejercicio_musculo', 'ID_Musculo', 'ID_Ejercicio');
    }
}
