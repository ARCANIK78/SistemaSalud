<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Enfermedad;
use App\Models\Paciente;
use App\Models\Usuario;

class EstadisticaController extends Controller
{
    public function index()
    {
        return view('estadisticas.index', [
            'totalPacientes' => Paciente::count(),
            'totalEnfermedades' => Enfermedad::count(),
            'totalConsultas' => Consulta::count(),
            'totalUsuarios' => Usuario::count(),
        ]);
    }
}
