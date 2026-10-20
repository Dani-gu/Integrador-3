<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAccion;

class LogAccionController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAccion::with('usuario');

        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->usuario . '%');
            });
        }

        if ($request->filled('tabla')) {
            $query->where('tabla_afectada', $request->tabla);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_accion', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_accion', '<=', $request->fecha_hasta);
        }

        $logs = $query->latest('fecha_accion')->paginate(50);
        $tablas = LogAccion::distinct()->pluck('tabla_afectada')->filter();

        return view('admin.logs.index', compact('logs', 'tablas'));
    }

    public function show(LogAccion $log)
    {
        $log->load('usuario');
        return view('admin.logs.show', compact('log'));
    }
}