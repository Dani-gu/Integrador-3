<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAccion extends Model
{
    use HasFactory;

    protected $table = 'logs_acciones';
    
    protected $fillable = [
        'id_usuario',
        'accion_realizada',
        'tabla_afectada',
        'id_registro_afectado',
        'fecha_accion'
    ];

    protected $casts = [
        'fecha_accion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public static function registrar($accion, $tabla = null, $id_registro = null)
    {
        self::create([
            'id_usuario' => auth()->id(),
            'accion_realizada' => $accion,
            'tabla_afectada' => $tabla,
            'id_registro_afectado' => $id_registro,
            'fecha_accion' => now()
        ]);
    }
}