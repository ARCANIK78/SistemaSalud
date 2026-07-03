@extends('layouts.app')

@section('title', 'Consultas')

@push('styles')
<style>
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .title-area h2 { margin: 0; font-size: 20px; font-weight: 600; color: #000; }
    .title-area p { margin: 4px 0 0 0; font-size: 13px; color: #666; }
    .btn-create { display: inline-block; padding: 8px 16px; background: #3182ce; color: #fff; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; }
    .btn-create:hover { background: #2b6cb0; }
    .table-responsive { background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eef0f2; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
    th { background-color: #fff; padding: 14px 16px; font-weight: 600; color: #888; border-bottom: 2px solid #f1f3f5; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
    td { padding: 14px 16px; border-bottom: 1px solid #f1f3f5; color: #333; }
    tr:hover { background-color: #f8f9fa; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 500; }
    .badge-tratamiento { background: #fef3c7; color: #92400e; }
    .badge-recuperado { background: #d1fae5; color: #065f46; }
    .badge-hospitalizado { background: #fce4ec; color: #b71c1c; }
    .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
</style>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="header-section">
        <div class="title-area">
            <h2>Consultas</h2>
            <p>Registro de consultas médicas</p>
        </div>
        <a href="{{ route('consultas.create') }}" class="btn-create">+ Nueva consulta</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Enfermedad</th>
                    <th>Fecha</th>
                    <th>Diagnóstico</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($consultas as $c)
                    <tr>
                        <td style="font-weight: 500;">{{ $c->paciente->nombre ?? '—' }}</td>
                        <td>{{ $c->enfermedad->nombre ?? '—' }}</td>
                        <td>{{ $c->fecha }}</td>
                        <td>{{ $c->diagnostico ?? '—' }}</td>
                        <td>
                            @php
                                $clase = match($c->estado) {
                                    'En tratamiento' => 'badge-tratamiento',
                                    'Recuperado' => 'badge-recuperado',
                                    'Hospitalizado' => 'badge-hospitalizado',
                                    default => ''
                                };
                            @endphp
                            <span class="badge {{ $clase }}">{{ $c->estado }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999; padding: 40px;">
                            No hay consultas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
