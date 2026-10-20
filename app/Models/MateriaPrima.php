<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    use HasFactory;

    protected $table = 'materia_prima';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'stock_actual',
        'stock_minimo',
        'unidad_medida'
    ];

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_materia_prima');
    }

    public function tieneStockBajo()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }
}