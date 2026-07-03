@extends('layouts.app')

@section('title', 'Sistema de Salud — Pacientes')

@push('styles')
<style>
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .title-area h2 { margin: 0; font-size: 22px; font-weight: 600; color: #000; }
    .title-area p { margin: 4px 0 0 0; font-size: 13px; color: #666; }
    .btn-create { display: inline-block; padding: 8px 16px; background: #3182ce; color: #fff; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500; }
    .btn-create:hover { background: #2b6cb0; }
    .btn-edit { display: inline-block; padding: 5px 12px; background: #e2e8f0; color: #4a5568; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500; }
    .btn-edit:hover { background: #cbd5e0; }
    .filters-container { display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 20px; }
    .filters-container select { padding: 8px 12px; border-radius: 6px; border: 1px solid #e0e0e0; background-color: #fff; font-size: 14px; color: #444; cursor: pointer; outline: none; }
    .table-responsive { background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eef0f2; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
    th { background-color: #fff; padding: 14px 16px; font-weight: 600; color: #888; border-bottom: 2px solid #f1f3f5; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
    td { padding: 14px 16px; border-bottom: 1px solid #f1f3f5; color: #333; }
    tr:hover { background-color: #f8f9fa; }
    .status-text { font-weight: 500; }
    .status-activo { color: #2b6cb0; }
    .status-tratamiento { color: #dd6b20; }
    .status-recuperado { color: #38a169; }
    .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
</style>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="header-section">
        <div class="title-area">
            <h2>Registro de pacientes</h2>
            <p>Mostrando {{ $pacientes->count() }} registros</p>
        </div>
        <a href="{{ route('pacientes.create') }}" class="btn-create">+ Nuevo paciente</a>
    </div>

    <form method="GET" class="filters-container">
        <select name="sexo" onchange="this.form.submit()">
            <option value="Todos" {{ $sexo == 'Todos' ? 'selected' : '' }}>Todos los Sexos</option>
            <option value="Masculino" {{ $sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Femenino" {{ $sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
        </select>
        <select name="estado" onchange="this.form.submit()">
            <option value="Todos" {{ $estado == 'Todos' ? 'selected' : '' }}>Todos los Estados</option>
            <option value="Activo" {{ $estado == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Recuperado" {{ $estado == 'Recuperado' ? 'selected' : '' }}>Recuperado</option>
            <option value="En tratamiento" {{ $estado == 'En tratamiento' ? 'selected' : '' }}>En tratamiento</option>
        </select>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Diagnóstico</th>
                    <th>Fecha Ingreso</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pacientes as $paciente)
                    @php
                        $estilo_estado = 'status-activo';
                        if ($paciente->estado == 'En tratamiento') $estilo_estado = 'status-tratamiento';
                        if ($paciente->estado == 'Recuperado') $estilo_estado = 'status-recuperado';
                    @endphp
                    <tr>
                        <td style="color: #555; font-weight: 500;">
                            P{{ str_pad($paciente->id_paciente, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="font-weight: 500;">{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->edad }}</td>
                        <td>{{ $paciente->sexo }}</td>
                        <td>{{ $paciente->diagnostico }}</td>
                        <td>{{ $paciente->fecha_ingreso }}</td>
                        <td>
                            <span class="status-text {{ $estilo_estado }}">{{ $paciente->estado }}</span>
                        </td>
                        <td><a href="{{ route('pacientes.edit', $paciente->id_paciente) }}" class="btn-edit">Editar</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999; padding: 40px;">
                            No hay pacientes registrados con esos filtros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
