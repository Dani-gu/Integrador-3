<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseConocimientoFalla extends Model
{
    use HasFactory;

    protected $table = 'base_conocimiento_fallas';
    
    protected $fillable = [
        'sintoma_descripcion',
        'causa_probable',
        'recomendacion_solucion'
    ];

    public function diagnosticos()
    {
        return $this->hasMany(DiagnosticoReportado::class, 'id_falla_detectada');
    }
}