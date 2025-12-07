@extends('layouts.adminlayout')

@section('title', 'Crear Nueva Marca - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-blue-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-blue-900">
                        Crear Nueva Marca
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

                <form action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
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
                                    placeholder="Describa la marca...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Logo de la Marca --}}
                        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-6 border border-cyan-200">
                            <h3 class="text-lg font-semibold text-cyan-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Logo de la Marca
                            </h3>
                            <p class="text-sm text-cyan-700 mb-6">
                                Agregue el logo de la marca. Este campo es opcional pero recomendado para una mejor
                                presentación.
                            </p>

                            <!-- Placeholder del logo -->
                            <div class="mb-4 text-center">
                                <div
                                    class="mx-auto w-32 h-32 bg-cyan-100 border-2 border-dashed border-cyan-300 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-16 h-16 text-cyan-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Campo: Imagen -->
                            <div>
                                <label for="imagen" class="block text-sm font-semibold text-cyan-900 mb-2">
                                    Logo de la Marca
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
                            class="px-6 py-3 text-sm font-semibold text-blue-700 bg-white border border-blue-300 rounded-xl hover:bg-blue-50 transition duration-200 text-center shadow-sm">
                            ← Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Crear Marca
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para previsualización de logo --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imagenInput = document.getElementById('imagen');
            const previewDiv = document.querySelector('.bg-cyan-100');

            imagenInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewDiv.innerHTML = `
                            <img src="${e.target.result}" 
                                 alt="Vista previa del logo" 
                                 class="w-32 h-32 object-contain rounded-xl">
                        `;
                    }

                    reader.readAsDataURL(file);
                } else {
                    previewDiv.innerHTML = `
                        <svg class="w-16 h-16 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    `;
                }
            });
        });
    </script>
@endsection
