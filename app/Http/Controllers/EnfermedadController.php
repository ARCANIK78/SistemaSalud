<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Enfermedad;
use App\Models\Paciente;

class EnfermedadController extends Controller
{
    public function index()
    {
        $resultados = Consulta::selectRaw("
                enfermedades.nombre as enfermedad,
                COUNT(*) as casos_totales,
                SUM(CASE WHEN consultas.estado = 'En tratamiento' OR consultas.estado = 'Hospitalizado' THEN 1 ELSE 0 END) as activos,
                SUM(CASE WHEN consultas.estado = 'Recuperado' THEN 1 ELSE 0 END) as recuperados
            ")
            ->join('enfermedades', 'consultas.id_enfermedad', '=', 'enfermedades.id_enfermedad')
            ->groupBy('enfermedades.nombre')
            ->orderByDesc('casos_totales')
            ->get();

        $total_general_pacientes = max(Paciente::count(), 1);

        return view('enfermedades.index', compact('resultados', 'total_general_pacientes'));
    }

    public function create()
    {
        return view('enfermedades.crear');
    }

    public function store()
    {
        $data = request()->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:100',
            'tratamiento' => 'nullable|string',
        ]);

        Enfermedad::create($data);

        return redirect()->route('enfermedades.index');
    }

    public function edit(Enfermedad $enfermedad)
    {
        return view('enfermedades.editar', compact('enfermedad'));
    }

    public function update(Enfermedad $enfermedad)
    {
        $data = request()->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:100',
            'tratamiento' => 'nullable|string',
        ]);

        $enfermedad->update($data);

        return redirect()->route('enfermedades.index');
    }

    public function destroy(Enfermedad $enfermedad)
    {
        $enfermedad->delete();

        return redirect()->route('enfermedades.index');
    }
}
