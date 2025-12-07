<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Global AutoParts')</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    {{-- NAVBAR DINÁMICO SEGÚN AUTENTICACIÓN --}}
    @if (session('client_user'))
        <x-navbar_cliente />
    @else
        <x-navbar_public />
    @endif

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    <x-footer />
</body>

</html>
