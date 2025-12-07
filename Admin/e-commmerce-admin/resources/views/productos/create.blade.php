@extends('layouts.adminlayout')

@section('title', 'Crear Nuevo Producto - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-blue-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-blue-900">
                        Crear Nuevo Producto
                    </h1>
                </div>

                {{-- Muestra el error de sesión --}}
                @if (Session::has('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <p class="font-semibold">{{ Session::get('error') }}</p>
                    </div>
                @endif

                {{-- Muestra los errores de validación --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <p class="font-semibold">Por favor, corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        {{-- Información Básica --}}
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Información Básica
                            </h3>

                            <!-- Campo: Nombre del Producto -->
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-semibold text-blue-900 mb-2">
                                    Nombre del Producto *
                                </label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                                    class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('nombre') border-red-500 @enderror"
                                    placeholder="Ingrese el nombre del producto">
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
                                    placeholder="Describa las características del producto...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Precio y Stock --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                                <h4 class="text-md font-semibold text-green-900 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    Información de Precio
                                </h4>

                                <!-- Campo: Precio -->
                                <div>
                                    <label for="precio" class="block text-sm font-semibold text-green-900 mb-2">
                                        Precio *
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center text-green-600 font-semibold">$</span>
                                        <input type="number" name="precio" id="precio" value="{{ old('precio') }}"
                                            required step="0.01" min="0"
                                            class="pl-10 w-full rounded-xl border border-green-200 px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200 @error('precio') border-red-500 @enderror"
                                            placeholder="0.00">
                                    </div>
                                    @error('precio')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-200">
                                <h4 class="text-md font-semibold text-orange-900 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Control de Inventario
                                </h4>

                                <!-- Campo: Stock -->
                                <div>
                                    <label for="stock" class="block text-sm font-semibold text-orange-900 mb-2">
                                        Stock (Cantidad) *
                                    </label>
                                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required
                                        min="0"
                                        class="w-full rounded-xl border border-orange-200 px-4 py-3 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-200 @error('stock') border-red-500 @enderror"
                                        placeholder="0">
                                    @error('stock')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Categoría y Marca --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div
                                class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-200">
                                <h4 class="text-md font-semibold text-purple-900 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Categoría
                                </h4>

                                <!-- Campo: Categoría -->
                                <div>
                                    <label for="categoria_id" class="block text-sm font-semibold text-purple-900 mb-2">
                                        Categoría *
                                    </label>
                                    <select name="categoria_id" id="categoria_id" required
                                        class="w-full rounded-xl border border-purple-200 px-4 py-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition duration-200 @error('categoria_id') border-red-500 @enderror">
                                        <option value="">Seleccione una categoría...</option>
                                        @foreach ($categorias as $categoria)
                                            @php
                                                $categoriaArray = is_array($categoria)
                                                    ? $categoria
                                                    : $categoria->toArray();
                                            @endphp
                                            <option value="{{ $categoriaArray['id'] }}"
                                                {{ old('categoria_id') == $categoriaArray['id'] ? 'selected' : '' }}>
                                                {{ $categoriaArray['nombre'] ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl p-6 border border-pink-200">
                                <h4 class="text-md font-semibold text-pink-900 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Marca
                                </h4>

                                <!-- Campo: Marca -->
                                <div>
                                    <label for="marca_id" class="block text-sm font-semibold text-pink-900 mb-2">
                                        Marca *
                                    </label>
                                    <select name="marca_id" id="marca_id" required
                                        class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-200 @error('marca_id') border-red-500 @enderror">
                                        <option value="">Seleccione una marca...</option>
                                        @foreach ($marcas as $marca)
                                            @php
                                                $marcaArray = is_array($marca) ? $marca : $marca->toArray();
                                            @endphp
                                            <option value="{{ $marcaArray['id'] }}"
                                                {{ old('marca_id') == $marcaArray['id'] ? 'selected' : '' }}>
                                                {{ $marcaArray['nombre'] ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('marca_id')
                                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SECCIÓN DE IMÁGENES --}}
                        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-6 border border-cyan-200">
                            <h3 class="text-lg font-semibold text-cyan-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Gestión de Imágenes
                            </h3>
                            <p class="text-sm text-cyan-700 mb-6">
                                Agregue imágenes del producto. La primera imagen es obligatoria y será la principal.
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @for ($i = 1; $i <= 3; $i++)
                                    @php
                                        $fieldName = "imagen_$i";
                                        $isRequired = $i === 1;
                                    @endphp
                                    <div class="text-center">
                                        <label for="{{ $fieldName }}"
                                            class="block text-sm font-semibold text-cyan-900 mb-3">
                                            Imagen {{ $i }}
                                            @if ($isRequired)
                                                <span class="text-cyan-500 font-normal">(Principal)*</span>
                                            @else
                                                <span class="text-cyan-500 font-normal">(Opcional)</span>
                                            @endif
                                        </label>

                                        {{-- Placeholder de imagen --}}
                                        <div class="mb-3">
                                            <div
                                                class="mx-auto h-32 w-32 bg-cyan-100 border-2 border-dashed border-cyan-300 rounded-xl flex items-center justify-center shadow-lg">
                                                <svg class="w-12 h-12 text-cyan-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Campo de subida --}}
                                        <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                            accept="image/*" {{ $isRequired ? 'required' : '' }}
                                            class="w-full text-sm text-cyan-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-700 hover:file:bg-cyan-200 transition duration-200 @error($fieldName) border-red-500 @enderror">

                                        @error($fieldName)
                                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endfor
                            </div>

                            <p class="text-xs text-cyan-600 mt-4 text-center">
                                Formatos permitidos: JPEG, PNG, JPG. Tamaño máximo: 2MB por imagen
                            </p>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="mt-8 pt-6 border-t border-blue-200 flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('productos.index') }}"
                            class="px-6 py-3 text-sm font-semibold text-blue-700 bg-white border border-blue-300 rounded-xl hover:bg-blue-50 transition duration-200 text-center shadow-sm">
                            ← Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            🚀 Crear Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para previsualización de imágenes --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Previsualización de imágenes
            const imageInputs = document.querySelectorAll('input[type="file"]');

            imageInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const previewDiv = this.previousElementSibling;

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" 
                                     alt="Vista previa" 
                                     class="mx-auto h-32 w-32 object-cover rounded-xl border-2 border-cyan-300 shadow-lg">
                            `;
                        }

                        reader.readAsDataURL(file);
                    } else {
                        previewDiv.innerHTML = `
                            <div class="mx-auto h-32 w-32 bg-cyan-100 border-2 border-dashed border-cyan-300 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-12 h-12 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        `;
                    }
                });
            });
        });
    </script>
@endsection
