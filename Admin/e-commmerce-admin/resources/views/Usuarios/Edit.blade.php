{{-- resources/views/admin/usuarios/edit.blade.php --}}
@extends('layouts.adminlayout')

@section('title', 'Editar Usuario - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $usuarioArray = is_array($usuario) ? $usuario : $usuario->toArray();

                // Generar avatar con iniciales
                $iniciales = '';
                if (isset($usuarioArray['nombre']) && isset($usuarioArray['apellido'])) {
                    $iniciales = substr($usuarioArray['nombre'], 0, 1) . substr($usuarioArray['apellido'], 0, 1);
                } elseif (isset($usuarioArray['nombre'])) {
                    $iniciales = substr($usuarioArray['nombre'], 0, 2);
                } else {
                    $iniciales = 'US';
                }

                $colorClasses = [
                    'bg-blue-500 text-white',
                    'bg-green-500 text-white',
                    'bg-purple-500 text-white',
                    'bg-yellow-500 text-white',
                    'bg-pink-500 text-white',
                    'bg-indigo-500 text-white',
                    'bg-teal-500 text-white',
                    'bg-red-500 text-white',
                ];
                $colorIndex = ($usuarioArray['id'] ?? 0) % count($colorClasses);
                $avatarColor = $colorClasses[$colorIndex];

                // URL de la imagen (usando la URL completa de la API)
                $imagenUrl = null;
                if (isset($usuarioArray['imagen']) && $usuarioArray['imagen']) {
                    // Si la imagen es una ruta relativa
                    if (strpos($usuarioArray['imagen'], 'http') === 0) {
                        $imagenUrl = $usuarioArray['imagen'];
                    } else {
                        // Construir URL completa a la API
                        $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                        $imagenUrl = $apiBaseUrl . '/storage/' . ltrim($usuarioArray['imagen'], '/');
                    }
                }
            @endphp

            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-blue-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-shrink-0">
                        @if ($imagenUrl)
                            <img src="{{ $imagenUrl }}" alt="Imagen de {{ $usuarioArray['nombre'] ?? 'Usuario' }}"
                                class="w-16 h-16 rounded-full object-cover border-4 border-blue-100 shadow-lg"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-16 h-16 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-2xl border-4 border-blue-100 shadow-lg\'>{{ strtoupper($iniciales) }}</div>'">
                        @else
                            <div
                                class="w-16 h-16 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-2xl border-4 border-blue-100 shadow-lg">
                                {{ strtoupper($iniciales) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-blue-900">
                            Editar Usuario: {{ $usuarioArray['nombre'] ?? 'N/A' }}
                        </h1>
                        <p class="text-blue-600 text-sm mt-1">
                            ID: #{{ $usuarioArray['id'] ?? 'N/A' }} |
                            Rol: <span class="font-semibold">{{ $usuarioArray['rol_nombre'] ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>

                {{-- Muestra el error de sesión --}}
                @if (Session::has('error'))
                    <div
                        class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Error</p>
                            <p class="text-sm mt-1">{{ Session::get('error') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Muestra los errores de validación --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <p class="font-semibold">Por favor, corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside mt-2 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div
                        class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">¡Éxito!</p>
                            <p class="text-sm mt-1">{{ Session::get('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('usuarios.update', $usuarioArray['id']) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="sm:col-span-1">
                            <label for="nombre" class="block text-sm font-semibold text-blue-900 mb-2">
                                Nombre *
                                <span class="text-blue-500 font-normal text-xs">(Requerido)</span>
                            </label>
                            <input type="text" name="nombre" id="nombre"
                                value="{{ old('nombre', $usuarioArray['nombre'] ?? '') }}" required
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('nombre') border-red-500 @enderror"
                                placeholder="Ingrese el nombre">
                            @error('nombre')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div class="sm:col-span-1">
                            <label for="apellido" class="block text-sm font-semibold text-blue-900 mb-2">
                                Apellido *
                                <span class="text-blue-500 font-normal text-xs">(Requerido)</span>
                            </label>
                            <input type="text" name="apellido" id="apellido"
                                value="{{ old('apellido', $usuarioArray['apellido'] ?? '') }}" required
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('apellido') border-red-500 @enderror"
                                placeholder="Ingrese el apellido">
                            @error('apellido')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-semibold text-blue-900 mb-2">
                                Email *
                                <span class="text-blue-500 font-normal text-xs">(Requerido)</span>
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $usuarioArray['email'] ?? '') }}" required
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('email') border-red-500 @enderror"
                                placeholder="usuario@ejemplo.com">
                            @error('email')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="sm:col-span-1">
                            <label for="password" class="block text-sm font-semibold text-blue-900 mb-2">
                                Nueva Contraseña
                                <span class="text-blue-500 font-normal text-xs">(Opcional)</span>
                            </label>
                            <input type="password" name="password" id="password"
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('password') border-red-500 @enderror"
                                placeholder="Mínimo 8 caracteres">
                            <div class="mt-2">
                                <small class="text-xs text-blue-500 block">
                                    Dejar en blanco para mantener la contraseña actual
                                </small>
                                <small class="text-xs text-gray-500 block mt-1">
                                    Si ingresa una nueva contraseña, debe tener mínimo 8 caracteres
                                </small>
                            </div>
                            @error('password')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="sm:col-span-1">
                            <label for="password_confirmation" class="block text-sm font-semibold text-blue-900 mb-2">
                                Confirmar Contraseña
                                <span class="text-blue-500 font-normal text-xs">(Si cambia la contraseña)</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                placeholder="Repita la nueva contraseña">
                        </div>

                        <!-- Teléfono -->
                        <div class="sm:col-span-1">
                            <label for="telefono" class="block text-sm font-semibold text-blue-900 mb-2">
                                Teléfono
                                <span class="text-blue-500 font-normal text-xs">(Opcional)</span>
                            </label>
                            <input type="tel" name="telefono" id="telefono"
                                value="{{ old('telefono', $usuarioArray['telefono'] ?? '') }}"
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('telefono') border-red-500 @enderror"
                                placeholder="Ej: 3321820324">
                            @error('telefono')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="sm:col-span-1">
                            <label for="rol_id" class="block text-sm font-semibold text-blue-900 mb-2">
                                Rol *
                                <span class="text-blue-500 font-normal text-xs">(Requerido)</span>
                            </label>
                            <select id="rol_id" name="rol_id" required
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('rol_id') border-red-500 @enderror">
                                <option value="">Seleccione un rol...</option>
                                @foreach ($roles as $rol)
                                    @php
                                        $rolArray = is_array($rol) ? $rol : $rol->toArray();
                                        $selected = old('rol_id', $usuarioArray['rol_id'] ?? '') == $rolArray['id'];
                                    @endphp
                                    <option value="{{ $rolArray['id'] }}" {{ $selected ? 'selected' : '' }}>
                                        {{ $rolArray['nombre'] ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rol_id')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dirección -->
                        <div class="sm:col-span-2">
                            <label for="direccion" class="block text-sm font-semibold text-blue-900 mb-2">
                                Dirección
                                <span class="text-blue-500 font-normal text-xs">(Opcional)</span>
                            </label>
                            <textarea name="direccion" id="direccion" rows="3"
                                class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('direccion') border-red-500 @enderror"
                                placeholder="Ingrese la dirección completa">{{ old('direccion', $usuarioArray['direccion'] ?? '') }}</textarea>
                            @error('direccion')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Imagen -->
                        <div class="sm:col-span-2">
                            <label for="imagen" class="block text-sm font-semibold text-blue-900 mb-2">
                                Imagen de Perfil
                                <span class="text-blue-500 font-normal text-xs">(Opcional)</span>
                            </label>

                            <!-- Vista previa de imagen actual -->
                            <div class="mb-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                <p class="text-sm font-medium text-blue-800 mb-2">Imagen actual:</p>
                                <div class="flex items-center gap-4">
                                    @if ($imagenUrl)
                                        <img src="{{ $imagenUrl }}"
                                            alt="Imagen actual de {{ $usuarioArray['nombre'] ?? 'Usuario' }}"
                                            class="w-16 h-16 rounded-full object-cover border-2 border-blue-300 shadow-lg"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-16 h-16 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-xl border-2 border-blue-300 shadow-lg\'>{{ strtoupper($iniciales) }}</div>'">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-xl border-2 border-blue-300 shadow-lg">
                                            {{ strtoupper($iniciales) }}
                                        </div>
                                    @endif
                                    <div class="text-sm text-blue-600">
                                        <p class="font-medium">Seleccione una nueva imagen para reemplazarla</p>
                                        <p class="text-xs mt-1">Formatos permitidos: JPEG, PNG, JPG. Tamaño máximo: 2MB</p>
                                        <p class="text-xs mt-1 text-gray-500">Si no selecciona una nueva imagen, se
                                            mantendrá la actual</p>
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <input type="file" name="imagen" id="imagen" accept="image/*"
                                    class="w-full text-sm text-blue-700 opacity-0 absolute z-10 cursor-pointer"
                                    onchange="previewImage(event)">

                                <div
                                    class="border-2 border-dashed border-blue-200 rounded-xl p-6 text-center bg-blue-50 hover:bg-blue-100 transition duration-200">
                                    <svg class="w-10 h-10 text-blue-400 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <p class="text-blue-700 font-medium mb-1">Haz clic para subir una nueva imagen</p>
                                    <p class="text-xs text-blue-500">o arrastra y suelta</p>
                                    <div id="imagePreview" class="mt-4 hidden">
                                        <p class="text-sm text-green-600 font-medium">Nueva imagen seleccionada:</p>
                                        <img id="preview"
                                            class="w-20 h-20 rounded-full object-cover mx-auto mt-2 border-2 border-green-300">
                                    </div>
                                </div>
                            </div>

                            @error('imagen')
                                <span class="text-sm text-red-600 mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Información adicional</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Creado:</span>
                                <span class="ml-2">
                                    @if (isset($usuarioArray['created_at']))
                                        {{ \Carbon\Carbon::parse($usuarioArray['created_at'])->format('d/m/Y H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="font-medium">Última actualización:</span>
                                <span class="ml-2">
                                    @if (isset($usuarioArray['updated_at']))
                                        {{ \Carbon\Carbon::parse($usuarioArray['updated_at'])->format('d/m/Y H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-blue-200 flex flex-col sm:flex-row gap-4 justify-between">
                        <div>
                            <a href="{{ route('usuarios.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-blue-700 bg-white border border-blue-300 rounded-xl hover:bg-blue-50 transition duration-200 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Volver a la lista
                            </a>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="button"
                                onclick="window.location.href='{{ route('usuarios.show', $usuarioArray['id']) }}'"
                                class="px-5 py-3 text-sm font-semibold text-blue-700 bg-white border border-blue-300 rounded-xl hover:bg-blue-50 transition duration-200 shadow-sm">
                                Ver Detalles
                            </button>
                            <button type="submit"
                                class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                Actualizar Usuario
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('imagePreview');
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.classList.add('hidden');
                preview.src = '';
            }
        }
    </script>
@endsection
