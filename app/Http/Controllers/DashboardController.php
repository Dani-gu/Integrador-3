<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\LoteProduccion;
use App\Models\Maquina;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = Usuario::count();
        $totalMaquinas = Maquina::count();
        $lotesActivos = LoteProduccion::where('estado', 'en_proceso')->count();
        $maquinasOperativas = Maquina::where('estado', 'operativa')->count();

        return view('dashboard.index', compact(
            'totalUsuarios',
            'totalMaquinas', 
            'lotesActivos',
            'maquinasOperativas'
        ));
    }
}