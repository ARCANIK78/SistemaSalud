@extends('layouts.app')

@section('title', 'Proyección de casos')

@push('styles')
<style>
    .algo-card { background: #ffffff; border-radius: 16px; padding: 20px 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); margin-bottom: 30px; border-left: 5px solid #2563eb; }
    .algo-card h3 { font-weight: 500; color: #1a2f44; font-size: 1.1rem; margin: 0; }
    .algo-card h3 i { color: #2563eb; margin-right: 10px; }
    .algo-card .badge { background: #e9f0f9; color: #1a3b5c; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; margin-left: 12px; font-weight: 400; }
    .chart-card { background: #ffffff; border: 0.5px solid #e2e8f0; border-radius: 16px; padding: 25px 25px 15px 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); margin-bottom: 30px; }
    .chart-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
    .chart-title { font-size: 16px; font-weight: 500; color: #1a2f44; }
    .legend { display: flex; justify-content: center; gap: 30px; margin-top: 10px; flex-wrap: wrap; }
    .legend-item { display: flex; align-items: center; font-size: 0.85rem; color: #2a3e55; }
    .legend-dot { width: 18px; height: 18px; border-radius: 4px; margin-right: 8px; }
</style>
@endpush

@section('content')
    <h2 style="font-size:20px;font-weight:600;color:#000;margin:0 0 20px 0;">Proyección de casos futuros</h2>

    <div class="algo-card">
        <h3>
            <i class="fas fa-brain"></i> Algoritmo: Programación dinámica de aprendizaje (t=0.3)
            <span class="badge">v2.1</span>
        </h3>
    </div>

    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">Tendencias proyectadas vs. real</div>
        </div>
        <div class="legend">
            <span class="legend-item">
                <span class="legend-dot" style="background:#2a78d6;"></span> Datos reales
            </span>
            <span class="legend-item">
                <span class="legend-dot" style="background:#ff8a5c; opacity:0.8;"></span> Proyección de casos
            </span>
        </div>
        <div style="position:relative; width:100%; height:320px;">
            <canvas id="chartProyecciones"></canvas>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('chartProyecciones');
        if (!canvas) return;

        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'];
        const datosReales = [198, 221, 192, 245, 268, 310, null, null];
        const datosProyectados = [198, 205, 200, 215, 230, 254, 278, 295];

        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: meses,
                datasets: [
                    {
                        label: 'Datos reales',
                        data: datosReales,
                        borderColor: '#2a78d6',
                        backgroundColor: 'rgba(42,120,214,0.08)',
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#2a78d6',
                        tension: 0.2,
                        fill: true,
                        spanGaps: false,
                    },
                    {
                        label: 'Proyección',
                        data: datosProyectados,
                        borderColor: '#ff8a5c',
                        backgroundColor: 'rgba(255,138,92,0.08)',
                        borderWidth: 2.5,
                        borderDash: [6, 4],
                        pointRadius: 4,
                        pointBackgroundColor: '#ff8a5c',
                        tension: 0.2,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#4a6a85' } },
                    y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#4a6a85' }, beginAtZero: true }
                }
            }
        });
    });
    </script>
@endsection
