<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Enfermedad;
use App\Models\Paciente;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('paciente', 'enfermedad')
            ->orderByDesc('fecha')
            ->get();

        return view('consultas.index', compact('consultas'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $enfermedades = Enfermedad::all();

        return view('consultas.crear', compact('pacientes', 'enfermedades'));
    }

    public function store()
    {
        $data = request()->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'id_enfermedad' => 'required|exists:enfermedades,id_enfermedad',
            'fecha' => 'required|date',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'estado' => 'required|in:En tratamiento,Recuperado,Hospitalizado',
        ]);

        Consulta::create($data);

        return redirect()->route('consultas.index')->with('success', 'Consulta creada correctamente.');
    }
}
