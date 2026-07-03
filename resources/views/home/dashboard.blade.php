@extends('layouts.app')

@section('title', 'Sistema de estadísticas de salud — Dashboard')

@section('content')
    <div class="header-top">
        <h1>Sistema de estadísticas de salud — dashboard epidemiológico</h1>
        <div class="top-buttons">
            <a href="#">Exportar</a>
            <a href="#" style="font-weight: 600;">Nuevo registro</a>
        </div>
    </div>
    
    <div class="header-section">
        <h2>Resumen epidemiológico — {{ now()->translatedFormat('F Y') }}</h2>
    </div>

    <div class="metrics-grid">
        <div class="metric-card">
            <div class="label">Promedio edad</div>
            <div class="value">{{ $promedio_edad }}</div>
            <div class="subtext">Años, pacientes activos</div>
        </div>
        <div class="metric-card">
            <div class="label">Promedio estancia</div>
            <div class="value">{{ $promedio_estancia }}</div>
            <div class="subtext">Días promedio</div>
        </div>
        <div class="metric-card">
            <div class="label">Tasa recuperación</div>
            <div class="value">{{ $tasa_recuperacion }}%</div>
            <div class="subtext">Alta positivo</div>
        </div>
        <div class="metric-card">
            <div class="label">Índice de contagio R₀</div>
            <div class="value">{{ $indice_contagio }}</div>
            <div class="subtext">Moderado</div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-title">Curva epidemiológica mensual</div>
            <div style="height: 300px;"><canvas id="chartCurva"></canvas></div>
        </div>
        
        <div class="chart-card">
            <div class="chart-title">Edad vs. sexo distribución</div>
            <div style="height: 300px;"><canvas id="chartDistribucion"></canvas></div>
        </div>
    </div>

    <style>
        .metrics-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 35px; }
        .metric-card { background: #fff; border: 1px solid #eef0f2; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .metric-card .label { font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500; }
        .metric-card .value { font-size: 32px; font-weight: 700; color: #000; margin-bottom: 4px; }
        .metric-card .subtext { font-size: 12px; color: #888; }
        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .chart-card { background: #fff; border: 1px solid #eef0f2; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .chart-title { font-size: 14px; font-weight: 600; color: #000; margin-bottom: 20px; }
        @media (max-width: 992px) { .metrics-grid { grid-template-columns: 1fr 1fr; } .charts-grid { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .metrics-grid { grid-template-columns: 1fr; } }
    </style>

    <script>
        // Gráfico 1: Curva Epidemiológica
        const ctxCurva = document.getElementById('chartCurva').getContext('2d');
        new Chart(ctxCurva, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [
                    {
                        data: @json($casosMensuales),
                        borderColor: '#3182ce',
                        backgroundColor: 'rgba(49, 130, 206, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#3182ce'
                    },
                    {
                        data: @json($casosSuavizados),
                        borderColor: '#38a169',
                        borderDash: [4, 4],
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#38a169'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { min: 180, max: 320, ticks: { stepSize: 20, color: '#718096' }, grid: { color: '#edf2f7' } },
                    x: { grid: { display: false }, ticks: { color: '#718096' } }
                }
            }
        });

        // Gráfico 2: Edad vs Sexo
        const ctxDist = document.getElementById('chartDistribucion').getContext('2d');
        new Chart(ctxDist, {
            type: 'bar',
            data: {
                labels: ['0-14', '15-29', '30-44', '45-59', '60-74', '75+'],
                datasets: [
                    { label: 'Masculino', data: @json($masculino_counts), backgroundColor: '#3182ce', borderRadius: 3 },
                    { label: 'Femenino', data: @json($femenino_counts), backgroundColor: '#ed64a6', borderRadius: 3 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#718096' }, grid: { color: '#edf2f7' } },
                    x: { grid: { display: false }, ticks: { color: '#718096' } }
                }
            }
        });
    </script>
@endsection