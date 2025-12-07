@extends('layouts.adminlayout')

@section('title', 'Editar Marca - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- VALIDACIÓN: Verificar si $marca existe --}}
            @if (empty($marca) || !is_array($marca))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-semibold text-lg">Error: No se pudo cargar la marca</p>
                    </div>
                    <p class="text-sm mb-4">La información de la marca no está disponible o hubo un error al cargarla.</p>
                    <a href="{{ route('marcas.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        ← Volver a la lista de marcas
                    </a>
                </div>
                @php return; @endphp
            @endif

            @php
                // Asegurar que $marca sea un array
                $marcaArray = is_array($marca)
                    ? $marca
                    : (is_object($marca) && method_exists($marca, 'toArray')
                        ? $marca->toArray()
                        : []);

                // Validar campos esenciales
                $marcaNombre = $marcaArray['nombre'] ?? 'Marca sin nombre';
                $marcaId = $marcaArray['id'] ?? null;
            @endphp

            {{-- VALIDACIÓN: Verificar si tenemos ID --}}
            @if (!$marcaId)
                <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <p class="font-semibold text-lg">Advertencia: ID no válido</p>
                    </div>
                    <p class="text-sm mb-4">No se pudo identificar la marca correctamente.</p>
                    <a href="{{ route('marcas.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        ← Volver a la lista
                    </a>
                </div>
                @php return; @endphp
            @endif

            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-blue-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-blue-900">
                        Editar Marca: {{ $marcaNombre }}
                    </h1>
                </div>

                {{-- Muestra el error de sesión --}}
                @if (Session::has('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-semibold">{{ Session::get('error') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Muestra el éxito de sesión --}}
                @if (Session::has('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-semibold">{{ Session::get('success') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Muestra los errores de validación --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <p class="font-semibold">Por favor, corrige los siguientes errores:</p>
                        </div>
                        <ul class="list-disc list-inside mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('marcas.update', $marcaId) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        {{-- Información de la Marca --}}
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Información de la Marca
                            </h3>

                            <!-- Campo: Nombre -->
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-semibold text-blue-900 mb-2">
                                    Nombre de la Marca *
                                </label>
                                <input type="text" name="nombre" id="nombre"
                                    value="{{ old('nombre', $marcaArray['nombre'] ?? '') }}" required
                                    class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('nombre') border-red-500 @enderror"
                                    placeholder="Ingrese el nombre de la marca">
                                @error('nombre')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Campo: Descripción -->
                            <div>
                                <label for="descripcion" class="block text-sm font-semibold text-blue-900 mb-2">
                                    Descripción
                                    <span class="text-blue-500 font-normal">(Opcional)</span>
                                </label>
                                <textarea name="descripcion" id="descripcion" rows="4"
                                    class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('descripcion') border-red-500 @enderror"
                                    placeholder="Describa la marca...">{{ old('descripcion', $marcaArray['descripcion'] ?? '') }}</textarea>
                                @error('descripcion')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Logo de la Marca --}}
                        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-6 border border-cyan-200">
                            <h3 class="text-lg font-semibold text-cyan-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Logo de la Marca
                            </h3>

                            <!-- Vista previa del logo actual -->
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-cyan-900 mb-3">Logo actual:</p>
                                @if (isset($marcaArray['imagen']) && !empty($marcaArray['imagen']))
                                    <div class="flex items-center gap-4">
                                        @php
                                            // Construir URL segura para la imagen
                                            $imagenUrl = '';
                                            if (str_starts_with($marcaArray['imagen'], 'http')) {
                                                $imagenUrl = $marcaArray['imagen'];
                                            } elseif (str_starts_with($marcaArray['imagen'], 'storage/')) {
                                                $imagenUrl = asset($marcaArray['imagen']);
                                            } elseif (str_starts_with($marcaArray['imagen'], 'imagenes_marcas/')) {
                                                $imagenUrl = asset('storage/' . $marcaArray['imagen']);
                                            } else {
                                                $imagenUrl = asset('storage/' . $marcaArray['imagen']);
                                            }
                                        @endphp
                                        <img src="{{ $imagenUrl }}"
                                            alt="Logo actual de {{ $marcaArray['nombre'] ?? 'Marca' }}"
                                            class="w-24 h-24 object-contain rounded-xl border-2 border-cyan-300 shadow-lg"
                                            onerror="this.onerror=null; this.src='https://via.placeholder.com/150/93c5fd/1e3a8a?text=Logo+No+Disponible';">
                                        <div class="text-sm text-cyan-700">
                                            <p class="font-medium">Logo actual</p>
                                            <p class="text-xs mt-1">Seleccione un nuevo archivo para reemplazarlo.</p>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="p-4 bg-cyan-100 border-2 border-dashed border-cyan-300 rounded-xl text-center">
                                        <svg class="w-12 h-12 text-cyan-400 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <p class="text-cyan-600 text-sm font-medium">No hay logo para esta marca</p>
                                        <p class="text-cyan-500 text-xs mt-1">Puede subir uno nuevo si lo desea</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Campo: Nueva Imagen -->
                            <div>
                                <label for="imagen" class="block text-sm font-semibold text-cyan-900 mb-2">
                                    Actualizar Logo
                                    <span class="text-cyan-500 font-normal">(Opcional)</span>
                                </label>
                                <input type="file" name="imagen" id="imagen" accept="image/*"
                                    class="w-full text-sm text-cyan-700 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-700 hover:file:bg-cyan-200 transition duration-200 @error('imagen') border-red-500 @enderror">

                                <p class="text-xs text-cyan-600 mt-2">
                                    Formatos permitidos: JPEG, PNG, JPG. Tamaño máximo: 2MB
                                </p>
                                @error('imagen')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="mt-8 pt-6 border-t border-blue-200 flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('marcas.index') }}"
                            class="px-6 py-3 text-sm font-semibold text-blue-700 bg-white border border-blue-300 rounded-xl hover:bg-blue-50 transition duration-200 text-center shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Actualizar Marca
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
