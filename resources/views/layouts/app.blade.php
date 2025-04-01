<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Padrón de Proveedores de Oaxaca')</title>
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
</head>

<body>
    @yield('content')
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/carrousel.js') }}"></script>
    <script src="{{ asset('assets/js/pdf-qr.js') }}"></script>
    <script src="{{ asset('assets/js/scraping-sat.js') }}"></script>
    <!-- En el head -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    @stack('scripts')
</body>

</html>
