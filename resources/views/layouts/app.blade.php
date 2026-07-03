<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Salud')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8f9fa; color: #333; padding: 25px; }
        .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header-top h1 { font-size: 20px; font-weight: 600; color: #000; }
        .top-buttons { display: flex; gap: 10px; }
        .top-buttons a { padding: 8px 16px; border-radius: 6px; font-size: 13px; text-decoration: none; }
        .top-buttons a:first-child { background: #e2e8f0; color: #4a5568; }
        .top-buttons a:last-child { background: #3182ce; color: #fff; }
        .header-section { margin-bottom: 25px; }
        .header-section h2 { font-size: 16px; font-weight: 600; color: #444; }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>
