<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\LogAccion;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
            'nombre_completo' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email|max:100',
            'password' => 'required|min:6|confirmed'
        ]);

        $usuario = Usuario::create([
            'id_rol' => $request->id_rol,
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'creado_en' => now()
        ]);

        LogAccion::registrar("Usuario creado: {$usuario->nombre_completo}", 'usuarios', $usuario->id);
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('rol');
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
            'nombre_completo' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id . '|max:100',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $data = [
            'id_rol' => $request->id_rol,
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email
        ];

        if ($request->password) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $usuario->update($data);

        LogAccion::registrar("Usuario actualizado: {$usuario->nombre_completo}", 'usuarios', $usuario->id);
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id == auth()->id()) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propio usuario']);
        }

        LogAccion::registrar("Usuario eliminado: {$usuario->nombre_completo}", 'usuarios', $usuario->id);
        
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}