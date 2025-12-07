@extends('layouts.adminlayout')

@section('title', 'Crear Nuevo Usuario')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6">

        {{-- Muestra el error de sesión (ej. error de red) si existe --}}
        @if (Session::has('error'))
            <div class="mb-4 p-4 rounded-md bg-red-100 text-red-700 border border-red-200 max-w-2xl mx-auto" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif

        {{-- Muestra los errores de validación generales si existen --}}
        @if ($errors->any() && !Session::has('error'))
            <div class="mb-4 p-4 rounded-md bg-red-100 text-red-700 border border-red-200 max-w-2xl mx-auto" role="alert">
                <p class="font-bold mb-2">Por favor, corrige los siguientes errores:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO FUERA DE CUALQUIER BLOQUE CONDICIONAL --}}
        <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data"
            class="w-full max-w-2xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-xl">
            @csrf

            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">
                Registrar Nuevo Usuario
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                {{-- Campo Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('nombre') border-red-500 @enderror">
                    @error('nombre')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Apellido --}}
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('apellido') border-red-500 @enderror">
                    @error('apellido')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Email --}}
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
                    @error('password')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Confirmar Contraseña --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmar Contraseña
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                {{-- Campo Teléfono --}}
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono (Opcional)</label>
                    <input type="tel" name="telefono" id="telefono" value="{{ old('telefono') }}"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('telefono') border-red-500 @enderror">
                    @error('telefono')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Rol --}}
                <div>
                    <label for="rol_id" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="rol_id" name="rol_id" required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('rol_id') border-red-500 @enderror">
                        <option value="">Seleccione un rol...</option>
                        @if (isset($roles) && count($roles) > 0)
                            @foreach ($roles as $rol)
                                @php
                                    $rolArray = (array) $rol;
                                @endphp
                                <option value="{{ $rolArray['id'] }}"
                                    {{ old('rol_id') == ($rolArray['id'] ?? null) ? 'selected' : '' }}>
                                    {{ $rolArray['nombre'] ?? 'N/A' }}
                                </option>
                            @endforeach
                        @else
                            {{-- Placeholder si $roles no está definido --}}
                            <option value="1">Administrador (Placeholder)</option>
                            <option value="2">Usuario Básico (Placeholder)</option>
                        @endif
                    </select>
                    @error('rol_id')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Dirección --}}
                <div class="sm:col-span-2">
                    <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección (Opcional)</label>
                    <textarea name="direccion" id="direccion" rows="3"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('direccion') border-red-500 @enderror">{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Imagen --}}
                <div class="sm:col-span-2">
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen de Perfil
                        (Opcional)</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*"
                        class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('imagen') border-red-500 @enderror">
                    @error('imagen')
                        <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
                <a href="{{ route('usuarios.index') }}"
                    class="py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center transition duration-150 ease-in-out">
                    Cancelar
                </a>
                <button type="submit"
                    class="py-2 px-4 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
@endsection
