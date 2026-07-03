<?php

namespace App\Http\Controllers;

use App\Models\Paciente;

class PacienteController extends Controller
{
    public function index()
    {
        $sexo = request('sexo', 'Todos');
        $estado = request('estado', 'Todos');

        $query = Paciente::query();

        if ($sexo !== 'Todos') {
            $query->where('sexo', $sexo);
        }
        if ($estado !== 'Todos') {
            $query->where('estado', $estado);
        }

        $pacientes = $query->orderBy('id_paciente')->get();

        return view('pacientes.index', compact('pacientes', 'sexo', 'estado'));
    }

    public function create()
    {
        return view('pacientes.crear');
    }

    public function store()
    {
        $data = request()->validate([
            'nombre' => 'required|string|max:100',
            'edad' => 'required|integer|min:0|max:150',
            'sexo' => 'required|in:Masculino,Femenino',
            'diagnostico' => 'nullable|string|max:150',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Recuperado,En tratamiento',
        ]);

        Paciente::create($data);

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado correctamente.');
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.editar', compact('paciente'));
    }

    public function update(Paciente $paciente)
    {
        $data = request()->validate([
            'nombre' => 'required|string|max:100',
            'edad' => 'required|integer|min:0|max:150',
            'sexo' => 'required|in:Masculino,Femenino',
            'diagnostico' => 'nullable|string|max:150',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Recuperado,En tratamiento',
        ]);

        $paciente->update($data);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
