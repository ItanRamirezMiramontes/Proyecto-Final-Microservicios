@extends('layouts.adminlayout')

@section('title', 'Dashboard - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-900 mb-2">
                    Panel de Control
                </h1>
                <p class="text-blue-700">
                    Resumen general y métricas del sistema
                </p>
            </div>

            {{-- Métricas Principales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total de Productos --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Total Productos</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $totalProductos ?? '0' }}</p>
                            <p class="text-xs text-blue-500 mt-1">Gestión de inventario</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total de Usuarios --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Total Usuarios</p>
                            <p class="text-2xl font-bold text-green-900">{{ $totalUsuarios ?? '0' }}</p>
                            <p class="text-xs text-green-500 mt-1">Usuarios registrados</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total de Categorías --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Categorías</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $totalCategorias ?? '0' }}</p>
                            <p class="text-xs text-purple-500 mt-1">Categorías activas</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-xl">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total de Marcas --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-orange-600">Marcas</p>
                            <p class="text-2xl font-bold text-orange-900">{{ $totalMarcas ?? '0' }}</p>
                            <p class="text-xs text-orange-500 mt-1">Marcas registradas</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-xl">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección de Acciones Rápidas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                {{-- Acciones Rápidas --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Acciones Rápidas
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('productos.create') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                            <div class="p-2 bg-blue-600 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-blue-900">Nuevo Producto</p>
                                <p class="text-sm text-blue-600">Agregar producto al inventario</p>
                            </div>
                        </a>

                        <a href="{{ route('usuarios.create') }}"
                            class="flex items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors group">
                            <div class="p-2 bg-green-600 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-green-900">Nuevo Usuario</p>
                                <p class="text-sm text-green-600">Registrar nuevo usuario</p>
                            </div>
                        </a>

                        <a href="{{ route('categorias.create') }}"
                            class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                            <div class="p-2 bg-purple-600 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-purple-900">Nueva Categoría</p>
                                <p class="text-sm text-purple-600">Crear categoría de productos</p>
                            </div>
                        </a>

                        <a href="{{ route('marcas.create') }}"
                            class="flex items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors group">
                            <div class="p-2 bg-orange-600 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-orange-900">Nueva Marca</p>
                                <p class="text-sm text-orange-600">Agregar marca al sistema</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Enlaces Directos --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Navegación Rápida
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('productos.index') }}"
                            class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span class="font-medium text-blue-900">Gestión de Productos</span>
                            </div>
                            <svg class="w-4 h-4 text-blue-600 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('usuarios.index') }}"
                            class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                                <span class="font-medium text-green-900">Administrar Usuarios</span>
                            </div>
                            <svg class="w-4 h-4 text-green-600 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('categorias.index') }}"
                            class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span class="font-medium text-purple-900">Categorías</span>
                            </div>
                            <svg class="w-4 h-4 text-purple-600 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('marcas.index') }}"
                            class="flex items-center justify-between p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors group">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-orange-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-medium text-orange-900">Marcas</span>
                            </div>
                            <svg class="w-4 h-4 text-orange-600 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Información del Sistema --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Información del Sistema
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-900 mb-1">Global AutoParts</div>
                        <div class="text-blue-600">Sistema de Gestión</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-lg font-semibold text-green-900 mb-1">Panel Administrativo</div>
                        <div class="text-green-600">Versión 1.0</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-lg font-semibold text-purple-900 mb-1">Estado</div>
                        <div class="text-purple-600 flex items-center justify-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Sistema Operativo
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
