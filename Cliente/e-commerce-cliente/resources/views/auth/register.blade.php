<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Global AutoParts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800">Global AutoParts</h1>
            <p class="text-gray-600 mt-2">Crear Cuenta</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            {{-- Mensajes de éxito --}}
            @if (session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Mensajes de error --}}
            @if (session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200">
                    <ul class="text-red-800 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('client.register.post') }}" id="registerForm"
                enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    {{-- Foto de Perfil --}}
                    <div class="text-center">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Foto de Perfil (Opcional)
                        </label>
                        <div class="relative inline-block">
                            {{-- Vista previa de la imagen --}}
                            <img id="imagePreview"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="Vista previa"
                                class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-blue-100 shadow-sm">

                            {{-- Botón para subir imagen --}}
                            <label for="imagen"
                                class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full shadow-lg hover:bg-blue-700 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" id="imagen" name="imagen" accept="image/*" class="hidden"
                                    onchange="previewImage(event)">
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
                        @error('imagen')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre *
                        </label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Tu nombre">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apellido --}}
                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">
                            Apellido *
                        </label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Tu apellido">
                        @error('apellido')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="tu@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="+1 234 567 8900">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección
                        </label>
                        <textarea id="direccion" name="direccion" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                            placeholder="Tu dirección completa">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña *
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Mínimo 8 caracteres" minlength="8">
                        <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Contraseña *
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Repite tu contraseña">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botón de Registro --}}
                    <button type="submit" id="submitBtn"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="btnText">Crear Cuenta</span>
                        <div id="loadingSpinner" class="hidden justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('client.login') }}"
                        class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const imageInput = document.getElementById('imagen');

            setTimeout(function() {
                const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);

            window.previewImage = function(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // Validar tipo de archivo
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Por favor selecciona una imagen válida (JPG, PNG, GIF)');
                        input.value = '';
                        return;
                    }

                    // Validar tamaño (2MB máximo)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('La imagen debe ser menor a 2MB');
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }

                    reader.readAsDataURL(file);
                }
            };

            function validatePasswords() {
                if (password.value && confirmPassword.value && password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            password.addEventListener('input', validatePasswords);
            confirmPassword.addEventListener('input', validatePasswords);

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
        });
    </script>
</body>

</html>
