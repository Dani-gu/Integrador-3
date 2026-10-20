<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    
    protected $fillable = [
        'id_pedido',
        'id_cliente',
        'fecha_emision',
        'monto_total',
        'estado_pago',
        'nit_facturacion',
        'razon_social_facturacion'
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class, 'id_factura');
    }
}