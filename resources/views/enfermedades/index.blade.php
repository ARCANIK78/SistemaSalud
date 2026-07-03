<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Salud — Frecuencia de Enfermedades</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 25px; }
        .container { width: 100%; max-width: 100%; box-sizing: border-box; }
        
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .title-area h2 { margin: 0; font-size: 20px; font-weight: 600; color: #000; }
        .title-area p { margin: 4px 0 0 0; font-size: 13px; color: #666; }
        .algoritmo-badge { font-size: 13px; color: #333; font-weight: 500; }

        /* Estilos de la tabla tipo panel corporativo */
        .table-responsive { background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eef0f2; overflow: hidden; margin-bottom: 40px; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background-color: #fff; padding: 14px 16px; font-weight: 600; color: #888; border-bottom: 2px solid #f1f3f5; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        td { padding: 14px 16px; border-bottom: 1px solid #f1f3f5; color: #333; }
        tr:hover { background-color: #f8f9fa; }

        /* Badges de nivel de riesgo */
        .badge-riesgo { font-weight: 600; font-size: 13px; }
        .riesgo-alto { color: #e53e3e; }
        .riesgo-medio { color: #dd6b20; }
        .riesgo-bajo { color: #38a169; }

        /* Contenedor del gráfico */
        .chart-container { background: #fff; border-radius: 8px; border: 1px solid #eef0f2; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .chart-title { font-size: 16px; font-weight: 600; color: #000; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">

    <div class="header-section">
        <div class="title-area">
            <h2>Frecuencia de enfermedades</h2>
            <p>Ordenado por frecuencia descendente</p>
        </div>
        <div class="algoritmo-badge">
            Algoritmo: <span style="font-weight: 600;">Counting Sort</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Enfermedad</th>
                    <th>Casos Totales</th>
                    <th>Activos</th>
                    <th>Recuperados</th>
                    <th>Incidencia</th>
                    <th>Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($resultados as $fila)
                    @php
                        $enfermedad = $fila->enfermedad;
                        $casos = (int)$fila->casos_totales;
                        $activos = (int)$fila->activos;
                        $recuperados = (int)$fila->recuperados;

                        // Calcular la incidencia de forma dinámica
                        $incidencia = ($casos / $total_general_pacientes) * 100;

                        // Determinar el riesgo lógicamente
                        if ($casos >= 12) {
                            $riesgo_texto = "Alto";
                            $riesgo_clase = "riesgo-alto";
                        } elseif ($casos >= 6) {
                            $riesgo_texto = "Medio";
                            $riesgo_clase = "riesgo-medio";
                        } else {
                            $riesgo_texto = "Bajo";
                            $riesgo_clase = "riesgo-bajo";
                        }
                    @endphp
                    <tr>
                        <td style="font-weight: 500;">{{ $enfermedad }}</td>
                        <td style="font-weight: 600; color: #1a202c;">{{ $casos }}</td>
                        <td>{{ $activos }}</td>
                        <td>{{ $recuperados }}</td>
                        <td style="color: #4a5568;">{{ number_format($incidencia, 1) }}%</td>
                        <td><span class="badge-riesgo {{ $riesgo_clase }}">{{ $riesgo_texto }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999; padding: 40px;">
                            No hay datos de pacientes registrados para procesar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="chart-container">
        <div class="chart-title">Distribución de enfermedades — Gráfico de barras</div>
        <canvas id="graficoEnfermedades" style="max-height: 380px; width: 100%;"></canvas>
    </div>

</div>

<script>
    // Usamos @json de Blade para pasar las colecciones directo a arreglos de JavaScript
    const etiquetasEnfermedades = @json($resultados->pluck('enfermedad'));
    const datosTotales = @json($resultados->pluck('casos_totales'));

    const paletaColores = [
        '#3182ce', '#38a169', '#ecc94b', '#5a67d8', 
        '#e53e3e', '#ed64a6', '#ed8936', '#4fd1c5'
    ];

    const ctx = document.getElementById('graficoEnfermedades').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: etiquetasEnfermedades,
            datasets: [{
                label: 'Casos Totales',
                data: datosTotales,
                backgroundColor: paletaColores.slice(0, etiquetasEnfermedades.length),
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 2, color: '#718096' },
                    grid: { color: '#edf2f7' }
                },
                x: {
                    ticks: { color: '#718096', font: { size: 13 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>

</body>
</html>