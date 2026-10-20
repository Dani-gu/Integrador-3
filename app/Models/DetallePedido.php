<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalles_pedido';
    
    protected $fillable = [
        'id_pedido',
        'id_producto_terminado',
        'cantidad',
        'precio_unitario'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function producto()
    {
        return $this->belongsTo(ProductoTerminado::class, 'id_producto_terminado');
    }

    public function getSubtotalAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }
}