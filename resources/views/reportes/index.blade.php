@extends('layouts.app')

@section('title', 'Reportes epidemiológicos')

@push('styles')
<style>
    .epi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .proj-card { background: #ffffff; border: 0.5px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); margin-bottom: 16px; }
    .meter-bar { height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; margin-top: 6px; }
    .meter-fill { height: 100%; border-radius: 3px; transition: width 0.6s ease; }
    .chart-card { background: #ffffff; border: 0.5px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
    .chart-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
    .chart-title { font-size: 16px; font-weight: 500; color: #1a2f44; }
    @media (max-width: 768px) { .epi-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
    <h2 style="font-size:20px;font-weight:600;color:#000;margin:0 0 4px 0;">Reportes epidemiológicos</h2>
    <p style="font-size:13px;color:#666;margin-bottom:20px;">Análisis y alertas sanitarias</p>

    <div class="epi-grid">
        <div class="proj-card">
            <div style="font-size:14px;font-weight:500;color:#1a2f44;margin-bottom:12px;">
                Reporte epidemiológico
            </div>
            <div>
                <div style="font-size:12px;color:#666;margin-bottom:12px;">Período: enero–junio 2026</div>
                <div style="font-size:12px;color:#666;">Seleccione una enfermedad del listado para ver su reporte detallado.</div>
            </div>
        </div>

        <div class="proj-card">
            <div style="font-size:14px;font-weight:500;color:#1a2f44;margin-bottom:12px;">
                Alertas sanitarias
            </div>
            <div>
                <div style="padding:10px 12px;border-radius:8px;background:#fee2e2;border:1px solid #fecaca;margin-bottom:8px;">
                    <div style="font-size:12px;font-weight:500;color:#b91c1c;">Dengue — nivel alto</div>
                    <div style="font-size:11px;color:#b91c1c;margin-top:3px;">Incidencia superior al umbral de alerta.</div>
                </div>
                <div style="padding:10px 12px;border-radius:8px;background:#fef9c3;border:1px solid #fde68a;margin-bottom:8px;">
                    <div style="font-size:12px;font-weight:500;color:#854d0e;">COVID-19 — tendencia creciente</div>
                    <div style="font-size:11px;color:#854d0e;margin-top:3px;">Incremento en las últimas 4 semanas.</div>
                </div>
            </div>
        </div>
    </div>
@endsection
