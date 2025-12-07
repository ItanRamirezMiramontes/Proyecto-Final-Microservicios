@extends('layouts.adminlayout')

@section('title', 'Gestión de Categorías - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen p-0">
        <div class="max-w-7xl mx-auto p-4 md:p-8">

            {{-- Header Principal --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg">
                        {{-- Icono de Categorías (Folder/Tag) --}}
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-blue-900">Gestión de Categorías</h1>
                        <p class="text-blue-600 mt-1">Administra las categorías de autopartes</p>
                    </div>
                </div>

                {{-- Botón de Crear --}}
                <a href="{{ route('categorias.create') }}"
                    class="group flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear Nueva Categoría
                </a>
            </div>

            {{-- Mensajes de Sesión --}}
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

            {{-- Tabla de Categorías --}}
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-blue-100">

                {{-- Tabla para pantallas grandes (SIN IMAGEN) --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full min-w-full leading-normal">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-20">ID
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-1/4">Nombre
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Descripción
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider w-32">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($categorias as $categoria)
                                @php
                                    $categoriaArray = is_array($categoria) ? $categoria : $categoria->toArray();
                                @endphp
                                <tr
                                    class="hover:bg-blue-50 transition-colors duration-200 border-b border-blue-100 last:border-b-0">
                                    <td class="px-4 py-3 text-sm font-mono text-blue-900">
                                        #{{ $categoriaArray['id'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="font-semibold text-blue-900 text-lg">
                                            {{ $categoriaArray['nombre'] ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-800">
                                        {{ \Illuminate\Support\Str::limit($categoriaArray['descripcion'] ?? 'Sin descripción', 80, '...') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('categorias.edit', $categoriaArray['id']) }}"
                                                class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold transition duration-300 text-xs p-2 hover:bg-blue-100 rounded-lg"
                                                title="Editar categoría">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="hidden sm:inline">Editar</span>
                                            </a>

                                            {{-- Formulario Eliminar --}}
                                            <form action="{{ route('categorias.destroy', $categoriaArray['id']) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');"
                                                    class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition duration-300 text-xs p-2 hover:bg-red-50 rounded-lg"
                                                    title="Eliminar categoría">
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
                                    <td colspan="4" class="text-center px-5 py-12">
                                        <div
                                            class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <p class="text-blue-900 text-lg font-semibold">No se encontraron categorías
                                            registradas.</p>
                                        <p class="text-blue-600 mt-2">Comienza creando la primera categoría.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Vista para móviles y tablets (SIN IMAGEN) --}}
                <div class="lg:hidden divide-y divide-blue-100">
                    @forelse ($categorias as $categoria)
                        @php
                            $categoriaArray = is_array($categoria) ? $categoria : $categoria->toArray();
                        @endphp
                        <div class="p-4 flex flex-col gap-3 bg-white hover:bg-blue-50 transition-colors duration-200">
                            {{-- Header de la tarjeta móvil --}}
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-blue-900 text-lg">
                                        {{ $categoriaArray['nombre'] ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-blue-600 font-mono mt-0.5">ID:
                                        #{{ $categoriaArray['id'] ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Descripción --}}
                            <div class="text-sm text-blue-800 bg-blue-50 p-3 rounded-lg border border-blue-100">
                                <span
                                    class="font-medium block mb-1 text-blue-900 text-xs uppercase tracking-wider">Descripción:</span>
                                {{ \Illuminate\Support\Str::limit($categoriaArray['descripcion'] ?? 'Sin descripción', 100, '...') }}
                            </div>

                            {{-- Botones de acción móvil --}}
                            <div class="flex justify-end space-x-3 pt-2 border-t border-blue-100 mt-1">
                                <a href="{{ route('categorias.edit', $categoriaArray['id']) }}"
                                    class="flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm px-3 py-2 hover:bg-blue-100 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('categorias.destroy', $categoriaArray['id']) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');"
                                        class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold text-sm px-3 py-2 hover:bg-red-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="text-sm">No se encontraron categorías registradas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
