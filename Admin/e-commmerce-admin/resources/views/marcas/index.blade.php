@extends('layouts.adminlayout')

@section('title', 'Gestión de Marcas - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen p-0">
        <div class="max-w-7xl mx-auto p-4 md:p-8">

            {{-- Header Principal --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-blue-900">Gestión de Marcas</h1>
                        <p class="text-blue-600 mt-1">Administra los fabricantes y marcas del sistema</p>
                    </div>
                </div>

                <a href="{{ route('marcas.create') }}"
                    class="group flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear Nueva Marca
                </a>
            </div>

            @if (session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-6 mb-6 rounded-xl shadow-lg flex items-center gap-3"
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
            @endif

            @if (session('error'))
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 p-6 mb-6 rounded-xl shadow-lg flex items-center gap-3"
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
            @endif

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100">
                {{-- Tabla PC --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full min-w-full leading-normal">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Logo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Descripción
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($marcas as $marca)
                                @php
                                    $marcaArray = is_array($marca) ? $marca : $marca->toArray();
                                    $iniciales = isset($marcaArray['nombre'])
                                        ? substr($marcaArray['nombre'], 0, 1)
                                        : 'M';

                                    // Colores aleatorios
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
                                    $colorIndex = ($marcaArray['id'] ?? 0) % count($colorClasses);
                                    $avatarColor = $colorClasses[$colorIndex];

                                    // LOGICA DE URL EXACTA A USUARIOS
                                    $imagenUrl = null;
                                    if (isset($marcaArray['imagen']) && $marcaArray['imagen']) {
                                        if (strpos($marcaArray['imagen'], 'http') === 0) {
                                            $imagenUrl = $marcaArray['imagen'];
                                        } else {
                                            // Aquí obtenemos la URL base de la API desde el .env
                                            $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                            // Limpiamos 'public/' si viene en la ruta
                                            $pathLimpio = str_replace('public/', '', $marcaArray['imagen']);
                                            $pathLimpio = ltrim($pathLimpio, '/');
                                            // Construimos: http://localhost:8000/storage/imagenes_marcas/foto.png
                                            $imagenUrl = $apiBaseUrl . '/storage/' . $pathLimpio;
                                        }
                                    }
                                @endphp
                                <tr
                                    class="hover:bg-blue-50 transition-colors duration-200 border-b border-blue-100 last:border-b-0">
                                    <td class="px-4 py-3 text-sm font-mono text-blue-900">#{{ $marcaArray['id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($imagenUrl)
                                            <img src="{{ $imagenUrl }}" alt="Logo"
                                                class="w-12 h-12 object-contain rounded-lg border-2 border-blue-200 shadow bg-white" />
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-lg {{ $avatarColor }} flex items-center justify-center font-bold text-lg shadow">
                                                {{ strtoupper($iniciales) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-blue-900">
                                        {{ $marcaArray['nombre'] ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-blue-800">
                                        {{ \Illuminate\Support\Str::limit($marcaArray['descripcion'] ?? 'Sin descripción', 60, '...') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('marcas.edit', $marcaArray['id']) }}"
                                                class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold transition duration-300 text-xs p-2 hover:bg-blue-100 rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="hidden sm:inline">Editar</span>
                                            </a>
                                            <form action="{{ route('marcas.destroy', $marcaArray['id']) }}" method="POST"
                                                class="inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Eliminar?');"
                                                    class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition duration-300 text-xs p-2 hover:bg-red-50 rounded-lg">
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
                                    <td colspan="5" class="text-center px-5 py-12">
                                        <div
                                            class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </div>
                                        <p class="text-blue-900 text-lg font-semibold">No se encontraron marcas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Vista Móvil --}}
                <div class="lg:hidden divide-y divide-blue-100">
                    @forelse ($marcas as $marca)
                        @php
                            $marcaArray = is_array($marca) ? $marca : $marca->toArray();
                            $iniciales = isset($marcaArray['nombre']) ? substr($marcaArray['nombre'], 0, 1) : 'M';

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
                            $colorIndex = ($marcaArray['id'] ?? 0) % count($colorClasses);
                            $avatarColor = $colorClasses[$colorIndex];

                            $imagenUrl = null;
                            if (isset($marcaArray['imagen']) && $marcaArray['imagen']) {
                                if (strpos($marcaArray['imagen'], 'http') === 0) {
                                    $imagenUrl = $marcaArray['imagen'];
                                } else {
                                    $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                    $pathLimpio = str_replace('public/', '', $marcaArray['imagen']);
                                    $pathLimpio = ltrim($pathLimpio, '/');
                                    $imagenUrl = $apiBaseUrl . '/storage/' . $pathLimpio;
                                }
                            }
                        @endphp
                        <div class="p-4 flex flex-col gap-3 bg-white hover:bg-blue-50 transition-colors duration-200">
                            <div class="flex items-center gap-4">
                                @if ($imagenUrl)
                                    <img src="{{ $imagenUrl }}" alt="Logo"
                                        class="w-14 h-14 object-contain rounded-lg border-2 border-blue-200 shadow bg-white" />
                                @else
                                    <div
                                        class="w-14 h-14 rounded-lg {{ $avatarColor }} flex items-center justify-center font-bold text-xl shadow">
                                        {{ strtoupper($iniciales) }}</div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-blue-900 text-lg">{{ $marcaArray['nombre'] ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-blue-500 font-mono">ID: #{{ $marcaArray['id'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-blue-800 bg-blue-50 p-3 rounded-lg border border-blue-100">
                                <span class="font-medium block mb-1 text-blue-900">Descripción:</span>
                                {{ \Illuminate\Support\Str::limit($marcaArray['descripcion'] ?? 'Sin descripción', 80, '...') }}
                            </div>
                            <div class="flex justify-end space-x-3 pt-2 border-t border-blue-100 mt-1">
                                <a href="{{ route('marcas.edit', $marcaArray['id']) }}"
                                    class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm px-3 py-2 hover:bg-blue-100 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg> Editar
                                </a>
                                <form action="{{ route('marcas.destroy', $marcaArray['id']) }}" method="POST"
                                    class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar?');"
                                        class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold text-sm px-3 py-2 hover:bg-red-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-blue-600">
                            <p class="text-sm">No se encontraron marcas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
