<?php
// dashboard.php - Sistema Epidemiológico - Dashboard Principal
// INCLUIR CONEXIÓN A BASE DE DATOS
include('conexion.php');

// ============================================================
// 1. SISTEMA DE CARGA DINÁMICA DE MÓDULOS
// ============================================================
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Mapeo de páginas a archivos (¡TODOS los módulos!)
$pages = [
    'dashboard'    => 'dashboard_content.php',  // Contenido del dashboard
    'pacientes'    => 'pacientes/index.php',
    'enfermedades' => 'enfermedades/index.php',
    'estadisticas' => 'estadisticas/index.php',
    'proyecciones' => 'proyecciones/index.php',
    'reportes'     => 'reportes/index.php',
    'algoritmos'   => 'algoritmos/index.php',
];

// Si la página solicitada no existe, mostrar dashboard
if (!array_key_exists($page, $pages)) {
    $page = 'dashboard';
}

$include_file = $pages[$page];
$is_dashboard = ($page === 'dashboard');

// ============================================================
// 2. CALCULAR MÉTRICAS SUPERIORES EN TIEMPO REAL
// ============================================================
$sql_edad = "SELECT AVG(edad) AS promedio_edad FROM pacientes";
$res_edad = mysqli_query($conn, $sql_edad);
$fila_edad = mysqli_fetch_assoc($res_edad);
$promedio_edad = $fila_edad['promedio_edad'] ? number_format($fila_edad['promedio_edad'], 1) : "0.0";

$sql_total = "SELECT COUNT(*) AS total FROM pacientes";
$res_total = mysqli_query($conn, $sql_total);
$total_pacientes = mysqli_fetch_assoc($res_total)['total'];

$sql_recuperados = "SELECT COUNT(*) AS total FROM pacientes WHERE estado = 'Recuperado'";
$res_recuperados = mysqli_query($conn, $sql_recuperados);
$total_recuperados = mysqli_fetch_assoc($res_recuperados)['total'];

$tasa_recuperacion = $total_pacientes > 0 ? number_format(($total_recuperados / $total_pacientes) * 100, 0) : "0";

$mediana_estancia = "8.5"; 
$indice_contagio = "1.24"; 

// 3. DATOS PARA GRÁFICO: EDAD VS SEXO
$rangos = ['0-14', '15-29', '30-44', '45-59', '60-74', '75+'];
$masculino_counts = array_fill(0, 6, 0);
$femenino_counts = array_fill(0, 6, 0);

$sql_dist = "SELECT edad, sexo FROM pacientes";
$res_dist = mysqli_query($conn, $sql_dist);

if ($res_dist) {
    while ($row = mysqli_fetch_assoc($res_dist)) {
        $e = (int)$row['edad'];
        $s = $row['sexo'];
        
        if ($e <= 14) $idx = 0;
        elseif ($e <= 29) $idx = 1;
        elseif ($e <= 44) $idx = 2;
        elseif ($e <= 59) $idx = 3;
        elseif ($e <= 74) $idx = 4;
        else $idx = 5;

        if ($s == 'Masculino' || $s == 'M') {
            $masculino_counts[$idx]++;
        } else {
            $femenino_counts[$idx]++;
        }
    }
}

// 4. DATOS PARA CURVA EPIDEMIOLÓGICA (6 meses)
$casosMensuales = [];
for ($m = 1; $m <= 6; $m++) {
    $res = mysqli_query($conn, "SELECT COUNT(*) FROM pacientes WHERE MONTH(fecha_ingreso)=$m AND YEAR(fecha_ingreso)=2026");
    $casosMensuales[] = mysqli_fetch_assoc($res)['COUNT(*)'] ?? 0;
}
// Si no hay datos en BD, usar valores de ejemplo
if (array_sum($casosMensuales) == 0) {
    $casosMensuales = [198, 221, 192, 245, 268, 310];
}
$casosSuavizados = [198, 205, 200, 215, 230, 254]; // Ejemplo de suavizado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Salud — Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* ============================================================
           ESTILOS DEL DASHBOARD (SIN MODIFICAR, SOLO CORREGIDOS)
           ============================================================ */
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; display: flex; }
        
        /* Menú Lateral Izquierdo */
        .sidebar { width: 240px; background-color: #fff; border-right: 1px solid #eef0f2; height: 100vh; padding: 25px 20px; box-sizing: border-box; position: fixed; overflow-y: auto; }
        .sidebar .brand { font-size: 14px; font-weight: 700; color: #000; margin-bottom: 5px; }
        .sidebar .sub-brand { font-size: 11px; color: #666; margin-bottom: 30px; }
        .sidebar .section-title { font-size: 11px; font-weight: 600; text-transform: uppercase; color: #999; letter-spacing: 0.5px; margin: 20px 0 10px 0; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li { margin-bottom: 8px; }
        .sidebar ul li a { 
            display: block; padding: 8px 12px; color: #4a5568; text-decoration: none; font-size: 14px; border-radius: 6px; font-weight: 500; 
            transition: all 0.15s;
        }
        .sidebar ul li a.active, .sidebar ul li a:hover { background-color: #f0f4ff; color: #2563eb; font-weight: 600; }
        .sidebar ul li a i { width: 20px; margin-right: 8px; }

        /* Contenedor Principal */
        .main-content { margin-left: 240px; padding: 40px; width: calc(100% - 240px); box-sizing: border-box; }
        
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px; }
        .header-top h1 { font-size: 20px; font-weight: 700; color: #000; margin: 0; }
        .header-top .top-buttons { display: flex; gap: 15px; }
        .header-top .top-buttons a { font-size: 13px; color: #4a5568; text-decoration: none; font-weight: 500; }

        .header-section { margin-bottom: 30px; }
        .header-section h2 { margin: 0; font-size: 16px; font-weight: 600; color: #000; }
        .header-section p { margin: 4px 0 0 0; font-size: 12px; color: #666; }

        /* Tarjetas de Métricas */
        .metrics-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 35px; }
        .metric-card { background: #fff; border: 1px solid #eef0f2; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .metric-card .label { font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500; }
        .metric-card .value { font-size: 32px; font-weight: 700; color: #000; margin-bottom: 4px; }
        .metric-card .subtext { font-size: 12px; color: #888; }

        /* Gráficos */
        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .chart-card { background: #fff; border: 1px solid #eef0f2; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .chart-title { font-size: 14px; font-weight: 600; color: #000; margin-bottom: 20px; }

        /* Para el contenido de módulos */
        .module-content {
            margin-top: 10px;
        }
        .module-content h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { width: 60px; padding: 15px 10px; }
            .sidebar .brand, .sidebar .sub-brand, .sidebar .section-title, .sidebar ul li a span { display: none; }
            .sidebar ul li a { padding: 10px; font-size: 18px; text-align: center; }
            .sidebar ul li a i { margin-right: 0; }
            .main-content { margin-left: 60px; width: calc(100% - 60px); padding: 20px; }
            .metrics-grid { grid-template-columns: 1fr 1fr; }
            .charts-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            .metrics-grid { grid-template-columns: 1fr; }
            .header-top { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

<!-- ============================================================
     MENÚ LATERAL CON ICONOS Y ENLACES DINÁMICOS
     ============================================================ -->
<div class="sidebar">
    <div class="brand">SaludStat</div>
    <div class="sub-brand">Sistema Epidemiológico</div>
    
    <div class="section-title">Principal</div>
    <ul>
        <li><a href="?page=dashboard" class="<?php echo $page == 'dashboard' ? 'active' : ''; ?>">
            <i>📊</i> <span>Dashboard</span>
        </a></li>
        <li><a href="?page=pacientes" class="<?php echo $page == 'pacientes' ? 'active' : ''; ?>">
            <i>👥</i> <span>Pacientes</span>
        </a></li>
    </ul>

    <div class="section-title">Análisis</div>
    <ul>
        <li><a href="?page=enfermedades" class="<?php echo $page == 'enfermedades' ? 'active' : ''; ?>">
            <i>🦠</i> <span>Enfermedades</span>
        </a></li>
        <li><a href="?page=estadisticas" class="<?php echo $page == 'estadisticas' ? 'active' : ''; ?>">
            <i>📈</i> <span>Estadísticas</span>
        </a></li>
        <li><a href="?page=proyecciones" class="<?php echo $page == 'proyecciones' ? 'active' : ''; ?>">
            <i>🚀</i> <span>Proyecciones</span>
        </a></li>
        <li><a href="?page=reportes" class="<?php echo $page == 'reportes' ? 'active' : ''; ?>">
            <i>📄</i> <span>Reportes</span>
        </a></li>
    </ul>

    <div class="section-title">Sistema</div>
    <ul>
        <li><a href="?page=algoritmos" class="<?php echo $page == 'algoritmos' ? 'active' : ''; ?>">
            <i>⚙️</i> <span>Algoritmos</span>
        </a></li>
    </ul>
</div>

<!-- ============================================================
     CONTENIDO PRINCIPAL
     ============================================================ -->
<div class="main-content">

    <!-- BARRA SUPERIOR -->
    <div class="header-top">
        <h1 id="pageTitle">
            <?php
                $titulos = [
                    'dashboard'    => 'Sistema de estadísticas de salud — dashboard epidemiológico',
                    'pacientes'    => 'Gestión de pacientes',
                    'enfermedades' => 'Catálogo de enfermedades',
                    'estadisticas' => 'Estadísticas mensuales',
                    'proyecciones' => 'Proyecciones de casos futuros',
                    'reportes'     => 'Reportes epidemiológicos',
                    'algoritmos'   => 'Algoritmos implementados'
                ];
                echo $titulos[$page] ?? 'Dashboard';
            ?>
        </h1>
        <div class="top-buttons">
            <a href="#">Exportar</a>
            <a href="#" style="font-weight: 600;">Nuevo registro</a>
        </div>
    </div>
    
    <div class="header-section">
        <h2 id="pageSubtitle">
            <?php
                $subtitulos = [
                    'dashboard'    => 'Resumen epidemiológico — ' . date('F Y'),
                    'pacientes'    => 'Ordenación QuickSort · Búsqueda binaria',
                    'enfermedades' => 'Counting sort por frecuencia',
                    'estadisticas' => 'Curvas y distribuciones',
                    'proyecciones' => 'Programación dinámica — suavizado exponencial',
                    'reportes'     => 'Análisis y alertas sanitarias',
                    'algoritmos'   => 'Documentación técnica de algoritmos'
                ];
                echo $subtitulos[$page] ?? '';
            ?>
        </h2>
    </div>

    <!-- ============================================================
         CONTENIDO DINÁMICO SEGÚN PÁGINA
         ============================================================ -->
    <?php if ($is_dashboard): ?>
        <!-- ===== DASHBOARD ===== -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="label">Promedio edad</div>
                <div class="value"><?php echo $promedio_edad; ?></div>
                <div class="subtext">Años, pacientes activos</div>
            </div>
            <div class="metric-card">
                <div class="label">Mediana estancia</div>
                <div class="value"><?php echo $mediana_estancia; ?></div>
                <div class="subtext">Días promedio</div>
            </div>
            <div class="metric-card">
                <div class="label">Tasa recuperación</div>
                <div class="value"><?php echo $tasa_recuperacion; ?>%</div>
                <div class="subtext">Alta positivo</div>
            </div>
            <div class="metric-card">
                <div class="label">Índice de contagio R₀</div>
                <div class="value"><?php echo $indice_contagio; ?></div>
                <div class="subtext">Moderado</div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-title">Curva epidemiológica mensual</div>
                <div style="height: 300px;"><canvas id="chartCurva"></canvas></div>
            </div>
            
            <div class="chart-card">
                <div class="chart-title">Edad vs. sexo distribución</div>
                <div style="height: 300px;"><canvas id="chartDistribucion"></canvas></div>
            </div>
        </div>

        <script>
            // Gráfico 1: Curva Epidemiológica
            const ctxCurva = document.getElementById('chartCurva').getContext('2d');
            new Chart(ctxCurva, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                    datasets: [
                        {
                            data: <?php echo json_encode($casosMensuales); ?>,
                            borderColor: '#3182ce',
                            backgroundColor: 'rgba(49, 130, 206, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#3182ce'
                        },
                        {
                            data: <?php echo json_encode($casosSuavizados); ?>,
                            borderColor: '#38a169',
                            borderDash: [4, 4],
                            fill: false,
                            tension: 0.3,
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: '#38a169'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { min: 180, max: 320, ticks: { stepSize: 20, color: '#718096' }, grid: { color: '#edf2f7' } },
                        x: { grid: { display: false }, ticks: { color: '#718096' } }
                    }
                }
            });

            // Gráfico 2: Edad vs Sexo
            const datosMasculino = <?php echo json_encode($masculino_counts); ?>;
            const datosFemenino = <?php echo json_encode($femenino_counts); ?>;

            const ctxDist = document.getElementById('chartDistribucion').getContext('2d');
            new Chart(ctxDist, {
                type: 'bar',
                data: {
                    labels: ['0-14', '15-29', '30-44', '45-59', '60-74', '75+'],
                    datasets: [
                        { data: datosMasculino, backgroundColor: '#3182ce', borderRadius: 3 },
                        { data: datosFemenino, backgroundColor: '#ed64a6', borderRadius: 3 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#718096' }, grid: { color: '#edf2f7' } },
                        x: { grid: { display: false }, ticks: { color: '#718096' } }
                    }
                }
            });
        </script>

    <?php else: ?>
        <!-- ===== MÓDULOS EXTERNOS (Reportes, Proyecciones, etc.) ===== -->
        <div class="module-content">
            <?php
            // Verificar si el archivo existe ANTES de incluirlo
            if (file_exists($include_file)) {
                include $include_file;
            } else {
                echo '<div style="background:#fff5f5; padding:30px; border-radius:12px; border-left:5px solid #dc2626;">
                        <h3 style="color:#dc2626; margin:0 0 10px 0;"><i class="fas fa-exclamation-triangle"></i> Módulo no encontrado</h3>
                        <p style="color:#666;">El archivo <strong>' . htmlspecialchars($include_file) . '</strong> no existe.</p>
                        <p style="color:#999; font-size:13px;">Verifica que la carpeta y el archivo existan en la ruta correcta.</p>
                      </div>';
            }
            ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>