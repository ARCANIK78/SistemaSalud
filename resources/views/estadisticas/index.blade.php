<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistema de Salud</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px; }
        .grid-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
        .card h3 { margin: 0 0 10px 0; color: #4b5563; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .card .numero { font-size: 32px; font-weight: bold; color: #111827; }
    </style>
</head>
<body>

    <header>
        <h2>Bienvenido al Sistema de Salud, {{ Auth::user()->nombre ?? 'Usuario' }}</h2>
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

</body>
</html>