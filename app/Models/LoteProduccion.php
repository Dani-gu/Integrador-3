<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteProduccion extends Model
{
    use HasFactory;

    protected $table = 'lotes_produccion';
    
    protected $fillable = [
        'id_maquina',
        'id_operario',
        'fecha_inicio',
        'fecha_fin',
        'cantidad_producida',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }

    public function operario()
    {
        return $this->belongsTo(Usuario::class, 'id_operario');
    }

    public function parametros()
    {
        return $this->hasMany(ParametroProduccion::class, 'id_lote');
    }
}