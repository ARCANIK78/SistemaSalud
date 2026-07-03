@extends('layouts.app')

@section('title', 'Editar Paciente')

@push('styles')
<style>
    .container-form { max-width: 600px; margin: 0 auto; }
    h2 { margin: 0 0 20px 0; font-size: 22px; font-weight: 600; color: #000; }
    .card { background: #fff; border-radius: 8px; border: 1px solid #eef0f2; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    label { display: block; font-size: 14px; font-weight: 500; color: #444; margin-bottom: 6px; margin-top: 16px; }
    label:first-child { margin-top: 0; }
    input, select { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; outline: none; background: #fff; }
    input:focus, select:focus { border-color: #3182ce; box-shadow: 0 0 0 2px rgba(49,130,206,0.15); }
    .btn-group { display: flex; gap: 10px; margin-top: 24px; }
    .btn { padding: 10px 20px; border: none; border-radius: 6px; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-block; }
    .btn-primary { background: #3182ce; color: #fff; }
    .btn-primary:hover { background: #2b6cb0; }
    .btn-secondary { background: #e2e8f0; color: #4a5568; }
    .btn-secondary:hover { background: #cbd5e0; }
</style>
@endpush

@section('content')
    <div class="container-form">
        <h2>Editar Paciente</h2>
        <div class="card">
            <form method="POST" action="{{ route('pacientes.update', $paciente->id_paciente) }}">
                @csrf
                @method('PUT')

                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ $paciente->nombre }}" required>

                <label>Edad</label>
                <input type="number" name="edad" min="0" max="150" value="{{ $paciente->edad }}" required>

                <label>Sexo</label>
                <select name="sexo" required>
                    <option value="Masculino" {{ $paciente->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $paciente->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>

                <label>Diagnóstico</label>
                <input type="text" name="diagnostico" value="{{ $paciente->diagnostico }}">

                <label>Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" value="{{ $paciente->fecha_ingreso }}" required>

                <label>Estado</label>
                <select name="estado" required>
                    <option value="Activo" {{ $paciente->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="En tratamiento" {{ $paciente->estado == 'En tratamiento' ? 'selected' : '' }}>En tratamiento</option>
                    <option value="Recuperado" {{ $paciente->estado == 'Recuperado' ? 'selected' : '' }}>Recuperado</option>
                </select>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
