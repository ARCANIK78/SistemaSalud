<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;

class DashboardController extends Controller
{
    public function index()
    {
        $total = max(Paciente::count(), 1);

        $promedio_edad = round(Paciente::avg('edad') ?? 0, 1);

        $promedio_estancia = round(Paciente::where('fecha_ingreso', '!=', '0000-00-00')
            ->get()
            ->avg(fn($p) => now()->diffInDays($p->fecha_ingreso)) ?? 0, 1);

        $recuperados = Paciente::where('estado', 'Recuperado')->count();
        $tasa_recuperacion = round(($recuperados / $total) * 100, 1);

        $total_consultas = Consulta::count();
        $total_enfermedades = Consulta::distinct()->count('id_enfermedad');
        $indice_contagio = $total_enfermedades > 0 ? round($total_consultas / $total_enfermedades, 2) : 0;

        $casosMensuales = [];
        $casosSuavizados = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $count = Consulta::whereYear('fecha', $mes->year)
                ->whereMonth('fecha', $mes->month)
                ->count();
            $casosMensuales[] = $count;
        }
        for ($i = 0; $i < 6; $i++) {
            $sum = 0;
            $div = 0;
            for ($j = max(0, $i - 1); $j <= min(5, $i + 1); $j++) {
                $sum += $casosMensuales[$j];
                $div++;
            }
            $casosSuavizados[] = round($sum / $div, 1);
        }

        $rangos = ['0-14', '15-29', '30-44', '45-59', '60-74', '75+'];
        $masculino_counts = [];
        $femenino_counts = [];
        $limites = [[0, 14], [15, 29], [30, 44], [45, 59], [60, 74], [75, 200]];
        foreach ($limites as [$min, $max]) {
            $masculino_counts[] = Paciente::where('sexo', 'Masculino')
                ->whereBetween('edad', [$min, $max])->count();
            $femenino_counts[] = Paciente::where('sexo', 'Femenino')
                ->whereBetween('edad', [$min, $max])->count();
        }

        return view('home.dashboard', compact(
            'promedio_edad', 'promedio_estancia', 'tasa_recuperacion',
            'indice_contagio', 'casosMensuales', 'casosSuavizados',
            'masculino_counts', 'femenino_counts'
        ));
    }
}
