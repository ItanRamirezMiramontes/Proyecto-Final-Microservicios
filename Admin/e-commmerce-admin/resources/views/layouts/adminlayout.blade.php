<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Carga Tailwind CSS desde el CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>

<body>

    <x-navbar />
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <x-Footer />
</body>

</html>
