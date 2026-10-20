<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    
    protected $fillable = [
        'id_cliente',
        'id_vendedor',
        'fecha_pedido',
        'estado',
        'total_pedido'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'id_vendedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class, 'id_pedido');
    }
}