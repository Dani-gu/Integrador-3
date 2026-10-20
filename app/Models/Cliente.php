<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    
    protected $fillable = [
        'nombre_razon_social',
        'nit_ci',
        'telefono',
        'email'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_cliente');
    }
}