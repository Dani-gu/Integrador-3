<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoTerminado extends Model
{
    use HasFactory;

    protected $table = 'productos_terminados';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'stock_actual',
        'precio_unitario'
    ];

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_producto_terminado');
    }
}