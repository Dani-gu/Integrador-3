<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametroProduccion extends Model
{
    use HasFactory;

    protected $table = 'parametros_produccion';
    
    protected $fillable = [
        'id_lote',
        'temperatura',
        'presion',
        'cantidad_resina',
        'timestamp_lectura'
    ];

    protected $casts = [
        'timestamp_lectura' => 'datetime',
    ];

    public function lote()
    {
        return $this->belongsTo(LoteProduccion::class, 'id_lote');
    }
}