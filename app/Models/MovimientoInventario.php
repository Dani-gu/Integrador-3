<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';
    
    protected $fillable = [
        'id_usuario_responsable',
        'id_materia_prima',
        'id_producto_terminado',
        'tipo_movimiento',
        'cantidad',
        'fecha_movimiento'
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_responsable');
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'id_materia_prima');
    }

    public function productoTerminado()
    {
        return $this->belongsTo(ProductoTerminado::class, 'id_producto_terminado');
    }
}