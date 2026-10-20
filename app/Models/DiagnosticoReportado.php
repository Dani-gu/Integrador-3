<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticoReportado extends Model
{
    use HasFactory;

    protected $table = 'diagnosticos_reportados';
    
    protected $fillable = [
        'id_lote',
        'id_falla_detectada',
        'id_usuario_reporta',
        'descripcion_problema',
        'fecha_reporte',
        'estado_resolucion'
    ];

    protected $casts = [
        'fecha_reporte' => 'datetime',
    ];

    public function lote()
    {
        return $this->belongsTo(LoteProduccion::class, 'id_lote');
    }

    public function falla()
    {
        return $this->belongsTo(BaseConocimientoFalla::class, 'id_falla_detectada');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_reporta');
    }
}