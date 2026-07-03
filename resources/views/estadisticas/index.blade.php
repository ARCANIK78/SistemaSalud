@extends('layouts.app')

@section('title', 'Estadísticas — Sistema de Salud')

@push('styles')
<style>
    .grid-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 20px; }
    .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
    .card h3 { margin: 0 0 10px 0; color: #4b5563; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
    .card .numero { font-size: 32px; font-weight: bold; color: #111827; }
</style>
@endpush

@section('content')
    <header>
        <h2>Bienvenido al Sistema de Salud</h2>
        <p>Resumen general del estado del sistema</p>
    </header>

    <main class="grid-cards">
        <div class="card">
            <h3>Total Pacientes</h3>
            <div class="numero">{{ $totalPacientes }}</div>
        </div>

        <div class="card">
            <h3>Total Enfermedades</h3>
            <div class="numero">{{ $totalEnfermedades }}</div>
        </div>

        <div class="card">
            <h3>Total Consultas</h3>
            <div class="numero">{{ $totalConsultas }}</div>
        </div>

        <div class="card">
            <h3>Total Usuarios</h3>
            <div class="numero">{{ $totalUsuarios }}</div>
        </div>
    </main>
@endsection
