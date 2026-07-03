<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Salud')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f8f9fa; color: #333; display: flex; }

        /* Sidebar */
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

        /* Main Content */
        .main-content { margin-left: 240px; padding: 40px; width: calc(100% - 240px); box-sizing: border-box; }

        .header-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px; }
        .header-top h1 { font-size: 20px; font-weight: 700; color: #000; margin: 0; }
        .header-top .top-buttons { display: flex; gap: 15px; }
        .header-top .top-buttons a { font-size: 13px; color: #4a5568; text-decoration: none; font-weight: 500; }

        .header-section { margin-bottom: 30px; }
        .header-section h2 { margin: 0; font-size: 16px; font-weight: 600; color: #000; }
        .header-section p { margin: 4px 0 0 0; font-size: 12px; color: #666; }

        @media (max-width: 992px) {
            .sidebar { width: 60px; padding: 15px 10px; }
            .sidebar .brand, .sidebar .sub-brand, .sidebar .section-title, .sidebar ul li a span { display: none; }
            .sidebar ul li a { padding: 10px; font-size: 18px; text-align: center; }
            .main-content { margin-left: 60px; width: calc(100% - 60px); padding: 20px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.sidebar')
    <div class="main-content">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
