<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $table = 'certificado';
    protected $primaryKey = 'ID_Certificado';
    public $timestamps = false; // si tu tabla no usa created_at y updated_at

    protected $fillable = [
        'ID_Usuario_Socio',
        'Imagen_Certificado',
        'Aprobado',
        'Fecha_Emision',
        'Fecha_Vencimiento',
    ];

    // Relación: un certificado pertenece a un usuario/socio
    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario_Socio', 'ID_Usuario');
    }
}

