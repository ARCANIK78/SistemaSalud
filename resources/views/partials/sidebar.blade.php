<div class="sidebar">
    <div class="brand">SaludStat</div>
    <div class="sub-brand">Sistema Epidemiológico</div>

    <div class="section-title">Principal</div>
    <ul>
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i>📊</i> <span>Dashboard</span>
        </a></li>
        <li><a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes*') ? 'active' : '' }}">
            <i>👥</i> <span>Pacientes</span>
        </a></li>
        <li><a href="{{ route('consultas.index') }}" class="{{ request()->routeIs('consultas*') ? 'active' : '' }}">
            <i>🩺</i> <span>Consultas</span>
        </a></li>
    </ul>

    <div class="section-title">Análisis</div>
    <ul>
        <li><a href="{{ route('enfermedades.index') }}" class="{{ request()->routeIs('enfermedades*') ? 'active' : '' }}">
            <i>🦠</i> <span>Enfermedades</span>
        </a></li>
        <li><a href="{{ route('estadisticas.index') }}" class="{{ request()->routeIs('estadisticas*') ? 'active' : '' }}">
            <i>📈</i> <span>Estadísticas</span>
        </a></li>
        <li><a href="#" class="{{ request()->routeIs('proyecciones*') ? 'active' : '' }}">
            <i>🚀</i> <span>Proyecciones</span>
        </a></li>
        <li><a href="#" class="{{ request()->routeIs('reportes*') ? 'active' : '' }}">
            <i>📄</i> <span>Reportes</span>
        </a></li>
    </ul>

    <div class="section-title">Sistema</div>
    <ul>
        <li><a href="#" class="{{ request()->routeIs('algoritmos*') ? 'active' : '' }}">
            <i>⚙️</i> <span>Algoritmos</span>
        </a></li>
    </ul>
</div>
