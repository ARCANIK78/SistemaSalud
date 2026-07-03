<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Salud — Pacientes</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 25px; }
        .container { width: 100%; max-width: 100%; box-sizing: border-box; }
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .title-area h2 { margin: 0; font-size: 22px; font-weight: 600; color: #000; }
        .title-area p { margin: 4px 0 0 0; font-size: 13px; color: #666; }
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
    </style>
</head>
<body>

<div class="container">

    <div class="header-section">
        <div class="title-area">
            <h2>Registro de pacientes</h2>
            <p>Mostrando {{ $pacientes->count() }} registros activos</p>
        </div>
    </div>

    <div class="filters-container">
        <select id="filtroSexo" onchange="filtrarPacientes()">
            <option value="Todos" {{ $sexo_filtrado == 'Todos' ? 'selected' : '' }}>Todos los Sexos</option>
            <option value="Masculino" {{ $sexo_filtrado == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Femenino" {{ $sexo_filtrado == 'Femenino' ? 'selected' : '' }}>Femenino</option>
        </select>

        <select id="filtroEstado" onchange="filtrarPacientes()">
            <option value="Todos" {{ $estado_filtrado == 'Todos' ? 'selected' : '' }}>Todos los Estados</option>
            <option value="Activo" {{ $estado_filtrado == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Recuperado" {{ $estado_filtrado == 'Recuperado' ? 'selected' : '' }}>Recuperado</option>
            <option value="En tratamiento" {{ $estado_filtrado == 'En tratamiento' ? 'selected' : '' }}>En tratamiento</option>
        </select>
    </div>

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
                        <td style='color: #555; font-weight: 500;'>
                            P{{ str_pad($paciente->id_paciente, 3, "0", STR_PAD_LEFT) }}
                        </td>
                        <td style='font-weight: 500;'>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->edad }}</td>
                        <td>{{ $paciente->sexo }}</td>
                        <td>{{ $paciente->diagnostico }}</td>
                        <td>{{ $paciente->fecha_ingreso }}</td>
                        <td>
                            <span class='status-text {{ $estilo_estado }}'>{{ $paciente->estado }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan='7' style='text-align: center; color: #999; padding: 40px;'>
                            No hay pacientes registrados con esos filtros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
function filtrarPacientes() {
    var sexo = document.getElementById('filtroSexo').value;
    var estado = document.getElementById('filtroEstado').value;
    // Ahora redirigimos dinámicamente usando la misma URL en la que estemos parados
    window.location.href = window.location.pathname + "?sexo=" + sexo + "&estado=" + estado;
}
</script>

</body>
</html>