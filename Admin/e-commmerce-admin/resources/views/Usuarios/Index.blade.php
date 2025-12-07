@extends('layouts.adminlayout')

@section('title', 'Gestion de Usuarios - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen p-0">
        <div class="max-w-7xl mx-auto p-4 md:p-8">

            {{-- Header Principal --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-blue-900">Gestión de Usuarios</h1>
                        <p class="text-blue-600 mt-1">Administra los usuarios del sistema</p>
                    </div>
                </div>

                {{-- Botón de Crear Nuevo Usuario --}}
                <a href="{{ route('usuarios.create') }}"
                    class="group flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear Nuevo Usuario
                </a>
            </div>
        </div>

        {{-- Mensajes de Sesión --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 md:px-8 mb-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-6 rounded-xl shadow-lg flex items-center gap-3"
                    role="alert">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold">¡Éxito!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 md:px-8 mb-6">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 p-6 rounded-xl shadow-lg flex items-center gap-3"
                    role="alert">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold">Error</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Contenedor de la tabla --}}
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100">

                {{-- Tabla para pantallas medianas y grandes --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full min-w-full leading-normal">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Imagen</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Rol</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Teléfono</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Registro</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($usuarios as $usuario)
                                @php
                                    $rolNombre = $usuario['rol_nombre'] ?? ($usuario['rol']['nombre'] ?? 'Sin Rol');
                                    // Generar avatar con iniciales
                                    $iniciales = '';
                                    if (isset($usuario['nombre']) && isset($usuario['apellido'])) {
                                        $iniciales =
                                            substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1);
                                    } elseif (isset($usuario['nombre'])) {
                                        $iniciales = substr($usuario['nombre'], 0, 2);
                                    } else {
                                        $iniciales = 'US';
                                    }

                                    // Colores para el avatar (basado en el ID para consistencia)
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
                                    $colorIndex = ($usuario['id'] ?? 0) % count($colorClasses);
                                    $avatarColor = $colorClasses[$colorIndex];

                                    // URL de la imagen (usando la URL completa de la API)
                                    $imagenUrl = null;
                                    if (isset($usuario['imagen']) && $usuario['imagen']) {
                                        // Si la imagen es una ruta relativa
                                        if (strpos($usuario['imagen'], 'http') === 0) {
                                            $imagenUrl = $usuario['imagen'];
                                        } else {
                                            // Construir URL completa a la API
                                            $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                            $imagenUrl = $apiBaseUrl . '/storage/' . ltrim($usuario['imagen'], '/');
                                        }
                                    }
                                @endphp
                                <tr
                                    class="hover:bg-blue-50 transition-colors duration-200 border-b border-blue-100 last:border-b-0">
                                    <td class="px-4 py-3 text-sm font-mono text-blue-900">
                                        #{{ $usuario['id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($imagenUrl)
                                            <img src="{{ $imagenUrl }}"
                                                alt="Imagen de {{ $usuario['nombre'] ?? 'Usuario' }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 shadow"
                                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm\'>{{ strtoupper($iniciales) }}</div>'">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper($iniciales) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-blue-900">
                                        <div class="flex flex-col">
                                            <span>{{ $usuario['nombre'] ?? 'N/A' }}
                                                {{ $usuario['apellido'] ?? '' }}</span>
                                            <span class="text-xs text-blue-600 font-normal">
                                                {{ \Illuminate\Support\Str::limit($usuario['direccion'] ?? 'Sin dirección', 30, '...') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-800">
                                        {{ $usuario['email'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="bg-blue-100 text-blue-800 font-semibold py-1 px-2 rounded-full text-xs">
                                            {{ $rolNombre }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-800">
                                        {{ $usuario['telefono'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-800">
                                        @if (isset($usuario['created_at']))
                                            {{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-2">
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('usuarios.edit', $usuario['id']) }}"
                                                class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold transition duration-300 text-xs p-2 hover:bg-blue-100 rounded-lg"
                                                title="Editar usuario">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="hidden sm:inline">Editar</span>
                                            </a>

                                            {{-- Formulario Eliminar --}}
                                            <form action="{{ route('usuarios.destroy', $usuario['id']) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');"
                                                    class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition duration-300 text-xs p-2 hover:bg-red-50 rounded-lg"
                                                    title="Eliminar usuario">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Eliminar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center px-5 py-12">
                                        <div
                                            class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-blue-900 text-lg font-semibold">No se encontraron usuarios
                                            registrados.</p>
                                        <p class="text-blue-600 mt-2">Intenta crear uno nuevo.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Vista para tablets --}}
                <div class="hidden md:block lg:hidden">
                    <div class="divide-y divide-blue-100">
                        @forelse ($usuarios as $usuario)
                            @php
                                $rolNombre = $usuario['rol_nombre'] ?? ($usuario['rol']['nombre'] ?? 'Sin Rol');
                                $iniciales = '';
                                if (isset($usuario['nombre']) && isset($usuario['apellido'])) {
                                    $iniciales = substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1);
                                } elseif (isset($usuario['nombre'])) {
                                    $iniciales = substr($usuario['nombre'], 0, 2);
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
                                $colorIndex = ($usuario['id'] ?? 0) % count($colorClasses);
                                $avatarColor = $colorClasses[$colorIndex];

                                $imagenUrl = null;
                                if (isset($usuario['imagen']) && $usuario['imagen']) {
                                    if (strpos($usuario['imagen'], 'http') === 0) {
                                        $imagenUrl = $usuario['imagen'];
                                    } else {
                                        $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                        $imagenUrl = $apiBaseUrl . '/storage/' . ltrim($usuario['imagen'], '/');
                                    }
                                }
                            @endphp
                            <div class="p-4 flex flex-col gap-3 bg-white hover:bg-blue-50 transition-colors duration-200">
                                <div class="flex items-center gap-4">
                                    @if ($imagenUrl)
                                        <img src="{{ $imagenUrl }}"
                                            alt="Imagen de {{ $usuario['nombre'] ?? 'Usuario' }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 shadow"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-12 h-12 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-lg\'>{{ strtoupper($iniciales) }}</div>'">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-lg">
                                            {{ strtoupper($iniciales) }}
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-semibold text-blue-900">
                                            {{ $usuario['nombre'] ?? 'N/A' }} {{ $usuario['apellido'] ?? '' }}
                                        </p>
                                        <p class="text-sm text-blue-600">{{ $usuario['email'] ?? 'N/A' }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="bg-blue-100 text-blue-800 font-medium py-1 px-2 rounded-full text-xs">
                                                {{ $rolNombre }}
                                            </span>
                                            <span class="text-xs text-blue-500">#{{ $usuario['id'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-y-2 text-sm text-blue-800">
                                    <span class="font-medium">Teléfono:</span>
                                    <span>{{ $usuario['telefono'] ?? 'N/A' }}</span>

                                    <span class="font-medium">Dirección:</span>
                                    <span>{{ \Illuminate\Support\Str::limit($usuario['direccion'] ?? 'N/A', 40, '...') }}</span>

                                    <span class="font-medium">Registrado:</span>
                                    <span>
                                        @if (isset($usuario['created_at']))
                                            {{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>

                                <div class="flex justify-end space-x-3 pt-3 border-t border-blue-100">
                                    <a href="{{ route('usuarios.edit', $usuario['id']) }}"
                                        class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold text-sm px-3 py-1 hover:bg-blue-100 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('usuarios.destroy', $usuario['id']) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');"
                                            class="flex items-center gap-2 text-red-600 hover:text-red-800 font-semibold text-sm px-3 py-1 hover:bg-red-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-blue-600">
                                <p>No se encontraron usuarios registrados.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Vista para móviles --}}
                <div class="md:hidden divide-y divide-blue-100">
                    @forelse ($usuarios as $usuario)
                        @php
                            $rolNombre = $usuario['rol_nombre'] ?? ($usuario['rol']['nombre'] ?? 'Sin Rol');
                            $iniciales = '';
                            if (isset($usuario['nombre']) && isset($usuario['apellido'])) {
                                $iniciales = substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1);
                            } elseif (isset($usuario['nombre'])) {
                                $iniciales = substr($usuario['nombre'], 0, 2);
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
                            $colorIndex = ($usuario['id'] ?? 0) % count($colorClasses);
                            $avatarColor = $colorClasses[$colorIndex];

                            $imagenUrl = null;
                            if (isset($usuario['imagen']) && $usuario['imagen']) {
                                if (strpos($usuario['imagen'], 'http') === 0) {
                                    $imagenUrl = $usuario['imagen'];
                                } else {
                                    $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                    $imagenUrl = $apiBaseUrl . '/storage/' . ltrim($usuario['imagen'], '/');
                                }
                            }
                        @endphp
                        <div class="p-4 flex flex-col gap-3 bg-white hover:bg-blue-50 transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                @if ($imagenUrl)
                                    <img src="{{ $imagenUrl }}" alt="Imagen de {{ $usuario['nombre'] ?? 'Usuario' }}"
                                        class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 shadow"
                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm\'>{{ strtoupper($iniciales) }}</div>'">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper($iniciales) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-blue-900 text-sm">
                                        {{ $usuario['nombre'] ?? 'N/A' }} {{ $usuario['apellido'] ?? '' }}
                                    </p>
                                    <p class="text-xs text-blue-600">{{ $usuario['email'] ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-y-1 text-xs text-blue-800">
                                <div class="flex justify-between">
                                    <span class="font-medium">Rol:</span>
                                    <span class="bg-blue-100 text-blue-800 font-medium py-0.5 px-2 rounded-full">
                                        {{ $rolNombre }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Teléfono:</span>
                                    <span>{{ $usuario['telefono'] ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Registro:</span>
                                    <span>
                                        @if (isset($usuario['created_at']))
                                            {{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between pt-2 border-t border-blue-100">
                                <a href="{{ route('usuarios.edit', $usuario['id']) }}"
                                    class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs px-2 py-1 hover:bg-blue-100 rounded">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario['id']) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar este usuario?');"
                                        class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold text-xs px-2 py-1 hover:bg-red-50 rounded">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-blue-600">
                            <p class="text-sm">No se encontraron usuarios registrados.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
