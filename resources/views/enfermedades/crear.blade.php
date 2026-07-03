@extends('layouts.app')

@section('title', 'Nueva Enfermedad')

@push('styles')
<style>
    .container-form { max-width: 600px; margin: 0 auto; }
    h2 { margin: 0 0 20px 0; font-size: 22px; font-weight: 600; color: #000; }
    .card { background: #fff; border-radius: 8px; border: 1px solid #eef0f2; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    label { display: block; font-size: 14px; font-weight: 500; color: #444; margin-bottom: 6px; margin-top: 16px; }
    label:first-child { margin-top: 0; }
    input, textarea { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; outline: none; }
    input:focus, textarea:focus { border-color: #3182ce; box-shadow: 0 0 0 2px rgba(49,130,206,0.15); }
    textarea { resize: vertical; min-height: 80px; }
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
        <h2>Nueva Enfermedad</h2>
        <div class="card">
            <form method="POST" action="{{ route('enfermedades.store') }}">
                @csrf
                <label>Nombre</label>
                <input type="text" name="nombre" required>

                <label>Descripción</label>
                <textarea name="descripcion"></textarea>

                <label>Categoría</label>
                <input type="text" name="categoria">

                <label>Tratamiento</label>
                <textarea name="tratamiento"></textarea>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('enfermedades.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
