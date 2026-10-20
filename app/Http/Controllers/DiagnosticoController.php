<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosticoReportado;
use App\Models\BaseConocimientoFalla;
use App\Models\LoteProduccion;
use App\Models\LogAccion;
use Illuminate\Support\Facades\Auth;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $diagnosticos = DiagnosticoReportado::with(['lote.maquina', 'falla', 'usuario'])->latest()->get();
        return view('diagnosticos.index', compact('diagnosticos'));
    }

    public function create()
    {
        $lotes = LoteProduccion::where('estado', 'en_proceso')->with('maquina')->get();
        $fallas = BaseConocimientoFalla::all();
        return view('diagnosticos.create', compact('lotes', 'fallas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lote' => 'nullable|exists:lotes_produccion,id',
            'id_falla_detectada' => 'nullable|exists:base_conocimiento_fallas,id',
            'descripcion_problema' => 'required'
        ]);

        $diagnostico = DiagnosticoReportado::create([
            'id_lote' => $request->id_lote,
            'id_falla_detectada' => $request->id_falla_detectada,
            'id_usuario_reporta' => Auth::id(),
            'descripcion_problema' => $request->descripcion_problema,
            'fecha_reporte' => now(),
            'estado_resolucion' => 'pendiente'
        ]);

        LogAccion::registrar("Diagnóstico reportado: ID {$diagnostico->id}", 'diagnosticos_reportados', $diagnostico->id);

        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico reportado exitosamente');
    }

    public function show(DiagnosticoReportado $diagnostico)
    {
        $diagnostico->load(['lote.maquina', 'falla', 'usuario']);
        return view('diagnosticos.show', compact('diagnostico'));
    }

    public function edit(DiagnosticoReportado $diagnostico)
    {
        $diagnostico->load(['lote.maquina', 'usuario']);
        return view('diagnosticos.edit', compact('diagnostico'));
    }

    public function update(Request $request, DiagnosticoReportado $diagnostico)
    {
        $request->validate([
            'estado_resolucion' => 'required|in:pendiente,en_proceso,resuelto'
        ]);

        $diagnostico->update(['estado_resolucion' => $request->estado_resolucion]);

        LogAccion::registrar("Estado de diagnóstico actualizado: {$request->estado_resolucion}", 'diagnosticos_reportados', $diagnostico->id);

        return redirect()->route('diagnosticos.index')->with('success', 'Estado actualizado exitosamente');
    }

    public function cambiarEstado(Request $request, DiagnosticoReportado $diagnostico)
    {
        $request->validate([
            'estado_resolucion' => 'required|in:pendiente,en_proceso,resuelto'
        ]);

        $diagnostico->update(['estado_resolucion' => $request->estado_resolucion]);

        LogAccion::registrar("Estado de diagnóstico cambiado: {$request->estado_resolucion}", 'diagnosticos_reportados', $diagnostico->id);

        return redirect()->route('diagnosticos.show', $diagnostico)->with('success', 'Estado actualizado exitosamente');
    }

    public function buscarSolucion(Request $request)
    {
        $query = $request->get('q');
        $soluciones = BaseConocimientoFalla::where('sintoma_descripcion', 'like', "%{$query}%")
                                          ->orWhere('causa_probable', 'like', "%{$query}%")
                                          ->get();
        
        return view('diagnosticos.soluciones', compact('soluciones', 'query'));
    }
}