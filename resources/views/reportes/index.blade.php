<div class="content-reportes">
    <h2 class="page-title"><i class="fas fa-file-alt"></i> Reportes epidemiológicos</h2>
    <p class="page-subtitle" style="margin-bottom: 20px;">Análisis y alertas sanitarias</p>

    <div class="epi-grid">
        <div class="proj-card">
            <div style="font-size:14px;font-weight:500;color:var(--text-primary);margin-bottom:12px;">
                <i class="fas fa-file-alt"></i> Reporte epidemiológico — {{ $nombre_mes_actual ?? 'junio 2026' }}
            </div>
            <div id="reporteEpi">
                <div style="font-size:12px;color:var(--text-muted);margin-bottom:12px;">Período: enero–junio 2026</div>
                
                @foreach($top_enfermedades ?? [] as $enfermedad)
                    <div style="margin-bottom:12px;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                            <span style="font-size:13px;color:var(--text-primary)">{{ $enfermedad['nombre'] }}</span>
                            <span style="font-size:13px;font-weight:500;color:var(--text-primary)">{{ $enfermedad['casos'] }} casos</span>
                        </div>
                        <div class="meter-bar">
                            <div class="meter-fill" style="width:{{ $enfermedad['porcentaje'] }}%; background:{{ $enfermedad['color'] }}"></div>
                        </div>
                    </div>
                @endforeach

                <div style="font-size:12px;color:var(--text-muted);margin-top:12px;padding-top:10px;border-top:0.5px solid var(--border)">
                    Total registros: {{ $total_registros ?? 80 }} · Tasa recuperación: {{ $tasa_recuperacion ?? '70%' }} · R₀ estimado: {{ $r0_estimado ?? '1.24' }}
                </div>
            </div>
        </div>

        <div class="proj-card">
            <div style="font-size:14px;font-weight:500;color:var(--text-primary);margin-bottom:12px;">
                <i class="fas fa-exclamation-triangle"></i> Alertas sanitarias
            </div>
            <div id="alertasSanitarias">
                <div style="padding:10px 12px;border-radius:var(--radius);background:#fee2e2;border:0.5px solid #fecaca;margin-bottom:8px;">
                    <div style="font-size:12px;font-weight:500;color:#b91c1c;"><i class="fas fa-exclamation-circle"></i> Dengue — nivel alto</div>
                    <div style="font-size:11px;color:#b91c1c;margin-top:3px;">Incidencia superior al umbral de alerta (15%). Activar brigadas de control vectorial.</div>
                </div>
                <div style="padding:10px 12px;border-radius:var(--radius);background:#fef9c3;border:0.5px solid #fde68a;margin-bottom:8px;">
                    <div style="font-size:12px;font-weight:500;color:#854d0e;"><i class="fas fa-exclamation-triangle"></i> COVID-19 — tendencia creciente</div>
                    <div style="font-size:11px;color:#854d0e;margin-top:3px;">Incremento del 12.1% en las últimas 4 semanas. Monitoreo intensivo.</div>
                </div>
                <div style="padding:10px 12px;border-radius:var(--radius);background:#dcfce7;border:0.5px solid #bbf7d0;margin-bottom:0;">
                    <div style="font-size:12px;font-weight:500;color:#15803d;"><i class="fas fa-check"></i> Tuberculosis — bajo control</div>
                    <div style="font-size:11px;color:#15803d;margin-top:3px;">Casos dentro del rango esperado. Mantener vigilancia rutinaria.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="chart-card" style="margin-top:16px;">
        <div class="chart-header">
            <div class="chart-title">Mapa de calor — casos por semana y enfermedad</div>
        </div>
        <div id="heatmapContainer" style="padding:8px 0; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding:8px 12px; background:var(--surface-1);">Enfermedad</th>
                        <th style="text-align:center; padding:8px 12px; background:var(--surface-1);">Sem 1</th>
                        <th style="text-align:center; padding:8px 12px; background:var(--surface-1);">Sem 2</th>
                        <th style="text-align:center; padding:8px 12px; background:var(--surface-1);">Sem 3</th>
                        <th style="text-align:center; padding:8px 12px; background:var(--surface-1);">Sem 4</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($heatmapData as $row)
                        @php
                            $enfermedad = $row['enfermedad'];
                            $valores = $row['valores'];
                        @endphp
                        <tr>
                            <td style="padding:8px 12px; border-bottom:0.5px solid var(--border); font-weight:500;">{{ $enfermedad }}</td>
                            @foreach($valores as $v)
                                @php
                                    $opacidad = round($v / 30, 2);
                                    $colorTexto = $v > 15 ? '#ffffff' : 'var(--text-primary)';
                                @endphp
                                <td style="padding:8px 12px; text-align:center; border-bottom:0.5px solid var(--border); background:rgba(42,120,214,{{ $opacidad }}); color:{{ $colorTexto }}; font-weight:500;">
                                    {{ $v }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.content-reportes { max-width: 100%; }
.epi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.proj-card { background: #ffffff; border: 0.5px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); margin-bottom: 16px; }
.meter-bar { height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; margin-top: 6px; }
.meter-fill { height: 100%; border-radius: 3px; transition: width 0.6s ease; }
.chart-card { background: #ffffff; border: 0.5px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
.chart-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
.chart-title { font-size: 16px; font-weight: 500; color: #1a2f44; }
@media (max-width: 768px) { .epi-grid { grid-template-columns: 1fr; } }
</style>