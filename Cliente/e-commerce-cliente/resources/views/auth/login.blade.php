<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Global AutoParts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo y Título -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-4">
                <i class="fas fa-car text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-blue-800">Global AutoParts</h1>
            <p class="text-gray-600 mt-2">Accede a tu cuenta</p>
        </div>

        <!-- Tarjeta del Formulario -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <!-- Mensajes de éxito/error -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <ul class="text-red-800 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('client.login.post') }}" id="loginForm">
                @csrf

                <div class="space-y-6">
                    <!-- Campo Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>
                            Correo Electrónico
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
                            placeholder="tu@email.com" autocomplete="email">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo Contraseña -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-lock mr-2 text-blue-600"></i>
                                Contraseña
                            </label>
                            <a href="#"
                                class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
                            placeholder="Ingresa tu contraseña" autocomplete="current-password">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recordarme -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Recordar mi sesión
                        </label>
                    </div>

                    <!-- Botón de Iniciar Sesión -->
                    <button type="submit" id="submitBtn"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="btnText">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Iniciar Sesión
                        </span>
                        <div id="loadingSpinner" class="hidden justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </button>
                </div>
            </form>

            <!-- Separador -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-center text-gray-600 text-sm">
                    ¿No tienes una cuenta?
                    <a href="{{ route('client.register') }}"
                        class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="mt-8 text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                <div class="flex items-center justify-center">
                    <i class="fas fa-shipping-fast mr-2 text-blue-600"></i>
                    <span>Envíos Rápidos</span>
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-shield-alt mr-2 text-blue-600"></i>
                    <span>Compra Segura</span>
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-headset mr-2 text-blue-600"></i>
                    <span>Soporte 24/7</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');

            setTimeout(function() {
                const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);

            form.addEventListener('submit', function() {
                if (form.checkValidity()) {
                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    loadingSpinner.classList.remove('hidden');
                }
            });

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }

            function togglePasswordVisibility() {
                const passwordField = document.getElementById('password');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
            }
        });

        function fillDemoCredentials() {
            document.getElementById('email').value = 'demo@globalautoparts.com';
            document.getElementById('password').value = 'demopassword123';
        }
    </script>

</body>

</html>
