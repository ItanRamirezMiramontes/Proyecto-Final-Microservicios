{{-- resources/views/categorias/create.blade.php --}}
@extends('layouts.adminlayout')

@section('title', 'Crear Nueva Categoría - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 border border-blue-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-blue-900">
                        Crear Nueva Categoría
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

                <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        {{-- Información de la Categoría --}}
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Información de la Categoría
                            </h3>

                            <!-- Campo: Nombre -->
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-semibold text-blue-900 mb-2">
                                    Nombre de la Categoría *
                                </label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                                    class="w-full rounded-xl border border-blue-200 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 @error('nombre') border-red-500 @enderror"
                                    placeholder="Ingrese el nombre de la categoría">
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
                                    placeholder="Describa la categoría...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    {{-- Botones --}}
                    <div class="mt-8 pt-6 border-t border-blue-200 flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('categorias.index') }}"
                            class="px-6 py-3 text-sm font-semibold text-blue-700 bg-white border border-blue-300 rounded-xl hover:bg-blue-50 transition duration-200 text-center shadow-sm">
                            ← Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Crear Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Vista previa de imagen
        document.getElementById('imagen').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('image-preview');
            const noImageContainer = document.getElementById('no-image');

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    noImageContainer.classList.add('hidden');
                }

                reader.readAsDataURL(this.files[0]);
            } else {
                previewContainer.classList.add('hidden');
                noImageContainer.classList.remove('hidden');
            }
        });
    </script>
@endsection
