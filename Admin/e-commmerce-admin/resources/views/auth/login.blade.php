<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Global AutoParts Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white min-h-screen flex items-center justify-center p-4" x-data="{ loading: false }">

    <div class="w-full max-w-md">
        {{-- Logo Header --}}
        <div class="text-center mb-8">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                    </svg>
                </div>
                <div class="text-left">
                    <h1 class="text-2xl font-bold text-blue-800">Global AutoParts</h1>
                    <p class="text-blue-600 text-sm">Panel Administrativo</p>
                </div>
            </div>
        </div>

        {{-- Login Card --}}
        <div class="bg-white border border-blue-100 rounded-lg shadow-sm p-8">
            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="mb-6 p-3 rounded-lg bg-blue-50 border border-blue-200 flex items-start space-x-3">
                    <div class="w-4 h-4 text-blue-500 flex-shrink-0 mt-1">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-blue-800 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-3 rounded-lg bg-red-50 border border-red-200 flex items-start space-x-3">
                    <div class="w-4 h-4 text-red-500 flex-shrink-0 mt-1">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-red-800 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.post') }}" @submit="loading = true">
                @csrf

                <div class="space-y-6">
                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-800 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                autofocus
                                class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200
                                          @error('email') border-red-300 bg-red-50 @enderror"
                                placeholder="admin@globalautoparts.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-blue-800 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full px-3 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200
                                          @error('password') border-red-300 bg-red-50 @enderror"
                                placeholder="Ingresa tu contraseña">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button (Versión Simple) --}}
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200
                                   hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                   disabled:opacity-50 disabled:cursor-not-allowed"
                        onclick="this.disabled=true;this.innerHTML='<span class=\'flex items-center justify-center space-x-2\'><svg class=\'animate-spin mr-2 h-4 w-4 text-white\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg><span>Procesando...</span></span>';this.form.submit();">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Iniciar Sesión</span>
                        </span>
                    </button>
                </div>
            </form>

            {{-- Footer Note --}}
            <div class="mt-6 pt-4 border-t border-blue-100">
                <p class="text-center text-xs text-blue-600">
                    Acceso exclusivo para personal autorizado
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('[class*="bg-blue-50"], [class*="bg-red-50"]');
                alerts.forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 5000);
        });
    </script>
</body>

</html>
