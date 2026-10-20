<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\LogAccion;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::withCount('usuarios')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|unique:roles,nombre_rol|max:50'
        ]);

        $rol = Rol::create($request->all());

        LogAccion::registrar("Rol creado: {$rol->nombre_rol}", 'roles', $rol->id);
        
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }

    public function edit(Rol $rol)
    {
        return view('admin.roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'nombre_rol' => 'required|unique:roles,nombre_rol,' . $rol->id . '|max:50'
        ]);

        $rol->update($request->all());

        LogAccion::registrar("Rol actualizado: {$rol->nombre_rol}", 'roles', $rol->id);
        
        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente');
    }

    public function destroy(Rol $rol)
    {
        if ($rol->usuarios()->count() > 0) {
            return back()->withErrors(['error' => 'No se puede eliminar un rol que tiene usuarios asignados']);
        }

        LogAccion::registrar("Rol eliminado: {$rol->nombre_rol}", 'roles', $rol->id);
        
        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}