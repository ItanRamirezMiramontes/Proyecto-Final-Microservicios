@extends('layouts.adminlayout')

@section('title', 'Gestión de Productos - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen p-0">
        <div class="max-w-7xl mx-auto p-4 md:p-8">

            {{-- Header Principal --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg">
                        {{-- Icono de Caja/Producto --}}
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-blue-900">Gestión de Productos</h1>
                        <p class="text-blue-600 mt-1">Administra el inventario de autopartes</p>
                    </div>
                </div>

                {{-- Botón Crear --}}
                <a href="{{ route('productos.create') }}"
                    class="group flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Producto
                </a>
            </div>

            {{-- Mensajes Flash --}}
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

            {{-- Contenedor Principal --}}
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100">

                {{-- TABLA DESKTOP --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full min-w-full leading-normal">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Detalles</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Categoría /
                                    Marca</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Precio /
                                    Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($productos as $producto)
                                @php
                                    $prodArray = is_array($producto) ? $producto : $producto->toArray();

                                    // 1. Lógica de URL de imagen (Igual que en Marcas)
                                    $imagenUrl = null;
                                    // Priorizamos imagen_1
                                    $imagenRaw = $prodArray['imagen_1'] ?? null;

                                    if ($imagenRaw) {
                                        if (strpos($imagenRaw, 'http') === 0) {
                                            $imagenUrl = $imagenRaw;
                                        } else {
                                            $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                            $cleanPath = str_replace('public/', '', $imagenRaw);
                                            $cleanPath = ltrim($cleanPath, '/');
                                            $imagenUrl = $apiBaseUrl . '/storage/' . $cleanPath;
                                        }
                                    }

                                    // 2. Lógica de Stock
                                    $stock = $prodArray['stock'] ?? 0;
                                    $stockColor =
                                        $stock < 10 ? 'text-red-600 bg-red-100' : 'text-green-600 bg-green-100';
                                @endphp
                                <tr
                                    class="hover:bg-blue-50 transition-colors duration-200 border-b border-blue-100 last:border-b-0">

                                    {{-- Columna: Imagen + Nombre --}}
                                    <td class="px-4 py-4 text-sm">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-16 w-16">
                                                @if ($imagenUrl)
                                                    <img class="h-16 w-16 rounded-lg object-contain border border-blue-200 bg-white"
                                                        src="{{ $imagenUrl }}" alt="{{ $prodArray['nombre'] }}"
                                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-16 w-16 rounded-lg bg-blue-100 flex items-center justify-center text-blue-400\'><svg class=\'w-8 h-8\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\' /></svg></div>'">
                                                @else
                                                    <div
                                                        class="h-16 w-16 rounded-lg bg-blue-100 flex items-center justify-center text-blue-400">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-blue-900">
                                                    {{ $prodArray['nombre'] ?? 'Sin Nombre' }}
                                                </div>
                                                <div class="text-xs text-blue-500 font-mono mt-1">
                                                    ID: #{{ $prodArray['id'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Columna: Descripción Corta --}}
                                    <td class="px-4 py-4 text-sm text-blue-800">
                                        <p class="w-48 truncate" title="{{ $prodArray['descripcion'] ?? '' }}">
                                            {{ \Illuminate\Support\Str::limit($prodArray['descripcion'] ?? 'Sin descripción', 50) }}
                                        </p>
                                    </td>

                                    {{-- Columna: Categoría y Marca --}}
                                    <td class="px-4 py-4 text-sm">
                                        <div class="flex flex-col gap-1 items-start">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $prodArray['categoria']['nombre'] ?? ($prodArray['categoria_nombre'] ?? 'Sin Categoría') }}
                                            </span>
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $prodArray['marca']['nombre'] ?? ($prodArray['marca_nombre'] ?? 'Sin Marca') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Columna: Precio y Stock --}}
                                    <td class="px-4 py-4 text-sm">
                                        <div class="font-bold text-gray-900 text-base">
                                            ${{ number_format($prodArray['precio'] ?? 0, 2) }}
                                        </div>
                                        <div class="mt-1">
                                            <span class="px-2 py-0.5 rounded text-xs font-bold {{ $stockColor }}">
                                                Stock: {{ $stock }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Columna: Acciones --}}
                                    <td class="px-4 py-4 text-sm">
                                        <div class="flex items-center space-x-2">
                                            {{-- Editar --}}
                                            <a href="{{ route('productos.edit', $prodArray['id']) }}"
                                                class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold transition duration-300 text-xs p-2 hover:bg-blue-100 rounded-lg"
                                                title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="hidden xl:inline">Editar</span>
                                            </a>

                                            {{-- Eliminar --}}
                                            <form action="{{ route('productos.destroy', $prodArray['id']) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"
                                                    class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition duration-300 text-xs p-2 hover:bg-red-50 rounded-lg"
                                                    title="Eliminar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span class="hidden xl:inline">Borrar</span>
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
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <p class="text-blue-900 text-lg font-semibold">No se encontraron productos.</p>
                                        <p class="text-blue-600 mt-2">Comienza agregando nuevo inventario.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- VISTA MOVIL (CARDS) --}}
                <div class="lg:hidden divide-y divide-blue-100">
                    @forelse ($productos as $producto)
                        @php
                            $prodArray = is_array($producto) ? $producto : $producto->toArray();

                            $imagenUrl = null;
                            $imagenRaw = $prodArray['imagen_1'] ?? null;
                            if ($imagenRaw) {
                                if (strpos($imagenRaw, 'http') === 0) {
                                    $imagenUrl = $imagenRaw;
                                } else {
                                    $apiBaseUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000'), '/');
                                    $cleanPath = str_replace('public/', '', $imagenRaw);
                                    $cleanPath = ltrim($cleanPath, '/');
                                    $imagenUrl = $apiBaseUrl . '/storage/' . $cleanPath;
                                }
                            }

                            $stock = $prodArray['stock'] ?? 0;
                            $stockColor = $stock < 10 ? 'text-red-700 bg-red-50' : 'text-green-700 bg-green-50';
                        @endphp

                        <div class="p-4 flex flex-col gap-3 bg-white hover:bg-blue-50 transition-colors duration-200">
                            {{-- Header Card --}}
                            <div class="flex gap-4">
                                {{-- Imagen --}}
                                <div class="flex-shrink-0">
                                    @if ($imagenUrl)
                                        <img class="h-20 w-20 rounded-lg object-contain border border-blue-200 bg-white"
                                            src="{{ $imagenUrl }}" alt="{{ $prodArray['nombre'] }}"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-20 w-20 rounded-lg bg-blue-100 flex items-center justify-center text-blue-400\'><svg class=\'w-8 h-8\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\' /></svg></div>'">
                                    @else
                                        <div
                                            class="h-20 w-20 rounded-lg bg-blue-100 flex items-center justify-center text-blue-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-blue-900 truncate">
                                        {{ $prodArray['nombre'] ?? 'Sin Nombre' }}
                                    </p>
                                    <p class="text-xs text-blue-500 font-mono mb-1">ID: #{{ $prodArray['id'] }}</p>

                                    <div class="flex flex-wrap gap-1 mt-1">
                                        <span class="px-2 py-0.5 rounded text-xs bg-indigo-50 text-indigo-700 font-medium">
                                            {{ $prodArray['categoria']['nombre'] ?? 'Cat N/A' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded text-xs bg-blue-50 text-blue-700 font-medium">
                                            {{ $prodArray['marca']['nombre'] ?? 'Marca N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div class="flex justify-between items-center border-t border-b border-blue-50 py-2 mt-1">
                                <div class="text-lg font-bold text-gray-900">
                                    ${{ number_format($prodArray['precio'] ?? 0, 2) }}
                                </div>
                                <div class="text-xs font-bold px-2 py-1 rounded {{ $stockColor }}">
                                    Stock: {{ $stock }} u.
                                </div>
                            </div>

                            {{-- Botones --}}
                            <div class="flex justify-end gap-3 pt-1">
                                <a href="{{ route('productos.edit', $prodArray['id']) }}"
                                    class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm px-3 py-2 hover:bg-blue-100 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg> Editar
                                </a>
                                <form action="{{ route('productos.destroy', $prodArray['id']) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"
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
                            <p class="text-sm">No se encontraron productos.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
