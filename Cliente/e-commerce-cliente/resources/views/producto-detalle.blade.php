@extends('layouts.app')

@section('title', ($producto['nombre'] ?? 'Producto') . ' - Global AutoParts')

@section('content')
    <div class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
        {{-- Breadcrumb Minimalista --}}
        <div class="bg-white border-b border-gray-100">
            <div class="container mx-auto px-4 py-3">
                <div class="text-sm text-gray-600">
                    <a href="{{ url('/') }}" class="hover:text-blue-700 transition-colors">Inicio</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('tienda') }}" class="hover:text-blue-700 transition-colors">Tienda</a>
                    @if (isset($producto['categoria_nombre']))
                        <span class="mx-2">/</span>
                        <span class="text-gray-900 font-medium">{{ $producto['categoria_nombre'] }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            {{-- Alerts --}}
            @if (session('success'))
                <div
                    class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Contenido Principal --}}
            <div class="flex flex-col lg:flex-row gap-10">
                {{-- Columna Izquierda --}}
                <div class="lg:w-1/2 xl:w-3/5">
                    {{-- Imagen Principal --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-6">
                        <div class="p-8 flex justify-center items-center min-h-[500px]">
                            <img id="mainProductImage"
                                src="{{ $producto['imagen_1_url'] ?? 'https://placehold.co/800x600/2563eb/ffffff?text=Global+AutoParts' }}"
                                alt="{{ $producto['nombre'] }}"
                                class="max-w-full max-h-[500px] object-contain cursor-zoom-in transition-transform duration-300 hover:scale-105"
                                onclick="openLightbox(this.src)">
                        </div>
                    </div>

                    {{-- Miniaturas Mejoradas --}}
                    <div class="grid grid-cols-4 gap-4">
                        @for ($i = 1; $i <= 3; $i++)
                            @if (isset($producto["imagen_{$i}_url"]))
                                <div
                                    class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden hover:border-blue-500 transition-all duration-200 hover:shadow-md">
                                    <img src="{{ $producto["imagen_{$i}_url"] }}"
                                        class="w-full h-24 object-cover cursor-pointer"
                                        onclick="changeMainImage('{{ $producto["imagen_{$i}_url"] }}')">
                                </div>
                            @endif
                        @endfor
                        {{-- Espacio vacío para consistencia --}}
                        @for ($i = count(array_filter([$producto['imagen_1_url'] ?? null, $producto['imagen_2_url'] ?? null, $producto['imagen_3_url'] ?? null])) + 1; $i <= 4; $i++)
                            <div
                                class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl border border-gray-200 flex items-center justify-center min-h-24">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endfor
                    </div>

                    {{-- Información de Envío y Garantía --}}
                    <div class="mt-10">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Entrega Rápida y Segura
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Envío Gratis</p>
                                        <p class="text-sm text-gray-600">En pedidos superiores a $500</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Garantía 1 Año</p>
                                        <p class="text-sm text-gray-600">Protección total del producto</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Información y Compra Mejorada --}}
                <div class="lg:w-1/2 xl:w-2/5">
                    {{-- Marca y SKU --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-700 bg-blue-50 px-3 py-1 rounded-full">
                                {{ $producto['marca_nombre'] ?? 'Global AutoParts' }}
                            </span>
                            <span class="text-xs text-gray-500">SKU:
                                {{ $producto['sku'] ?? 'GA-' . $producto['id'] }}</span>
                        </div>
                    </div>

                    {{-- Título Principal --}}
                    <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $producto['nombre'] }}</h1>

                    {{-- Calificaciones --}}
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex items-center">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600 font-medium">4.8</span>
                            <span class="ml-1 text-sm text-gray-500">({{ rand(500, 5000) }} reseñas)</span>
                        </div>
                        <span class="text-sm text-green-600 font-medium bg-green-50 px-3 py-1 rounded-full">
                            <i class="fas fa-bolt mr-1"></i> MÁS VENDIDO
                        </span>
                    </div>

                    {{-- Precio Principal --}}
                    <div class="mb-8">
                        <div class="flex items-baseline">
                            <span
                                class="text-4xl font-bold text-gray-900">${{ number_format($producto['precio'], 2) }}</span>
                            <span class="ml-4 text-lg text-gray-500">IVA incluido</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.2 6.5 10.266a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            Entrega garantizada para {{ now()->addDays(rand(1, 3))->format('d F') }}
                        </p>
                    </div>

                    {{-- Estado de Stock --}}
                    @php
                        $stock = $producto['stock'] ?? 0;
                        $deliveryDate = now()->addDays(rand(1, 3))->format('d M');
                    @endphp

                    <div class="mb-8">
                        @if ($stock > 0)
                            <div
                                class="flex items-center justify-between bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">En Stock</p>
                                        <p class="text-sm text-gray-600">{{ $stock }} unidades disponibles</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Entrega:</p>
                                    <p class="font-bold text-gray-900">{{ $deliveryDate }}</p>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">Agotado Temporalmente</p>
                                        <p class="text-sm text-gray-600">Nuevo stock próximamente</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Selector de Cantidad --}}
                    @if ($stock > 0)
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">CANTIDAD</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                    <button type="button" onclick="decrementQuantity()"
                                        class="px-5 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 border-r border-gray-200 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" name="cantidad" id="quantityInput" value="1"
                                        min="1" max="{{ $stock }}"
                                        class="w-20 text-center text-xl font-bold border-none focus:ring-0 focus:outline-none">
                                    <button type="button" onclick="incrementQuantity()"
                                        class="px-5 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 border-l border-gray-200 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-sm text-gray-600">Máximo: <span
                                        class="font-bold">{{ $stock }}</span> unidades</span>
                            </div>
                        </div>

                        {{-- Botones de Acción - Tema Azul --}}
                        <form id="formAgregarCarrito" method="POST" action="{{ route('carrito.add') }}"
                            class="space-y-4">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto['id'] }}">
                            <input type="hidden" name="nombre" value="{{ $producto['nombre'] }}">
                            <input type="hidden" name="cantidad" id="hiddenQuantity" value="1">

                            {{-- Botón Agregar al Carrito --}}
                            <button type="submit" id="btnAgregarCarrito"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-xl flex items-center justify-center group">
                                <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-lg">AGREGAR AL CARRITO</span>
                            </button>

                            {{-- Botón Comprar Ahora --}}
                            <button type="button" onclick="comprarAhora()"
                                class="w-full bg-gradient-to-r from-blue-800 to-blue-900 hover:from-blue-900 hover:to-blue-950 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-xl flex items-center justify-center group">
                                <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span class="text-lg">COMPRAR AHORA</span>
                            </button>
                        </form>
                    @endif

                    {{-- Información de Vendedor --}}
                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">Vendido por</p>
                                    <p class="text-gray-700">Global AutoParts Store</p>
                                    <p class="text-sm text-green-600 font-medium mt-1">★ Tienda Verificada</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">Devoluciones</p>
                                    <p class="text-gray-700">30 días para cambio o devolución</p>
                                    <p class="text-sm text-gray-600 mt-1">Garantía de satisfacción</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Descripción Detallada --}}
            <div class="mt-16">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">Detalles del
                            Producto</h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 text-lg leading-relaxed mb-6">
                                {{ $producto['descripcion'] ?? 'Este producto de alta calidad de Global AutoParts está diseñado para ofrecer el mejor rendimiento y durabilidad. Fabricado con los más altos estándares de calidad.' }}
                            </p>

                            {{-- Especificaciones Técnicas Mejoradas --}}
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 mt-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">

                                    Especificaciones Técnicas
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                        <span class="text-gray-600">Marca</span>
                                        <span
                                            class="font-bold text-gray-900">{{ $producto['marca_nombre'] ?? 'Global AutoParts' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                        <span class="text-gray-600">Categoría</span>
                                        <span
                                            class="font-bold text-gray-900">{{ $producto['categoria_nombre'] ?? 'Repuesto Automotriz' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                        <span class="text-gray-600">Código SKU</span>
                                        <span
                                            class="font-bold text-gray-900">{{ $producto['sku'] ?? 'GA-' . $producto['id'] }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                        <span class="text-gray-600">Disponibilidad</span>
                                        <span class="font-bold text-green-600">{{ $stock }} en stock</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Productos Relacionados Mejorados --}}
            @if (isset($productosRelacionados) && count($productosRelacionados) > 0)
                <div class="mt-20">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">También te podría interesar</h2>
                            <p class="text-gray-600 mt-2">Productos similares de alta calidad</p>
                        </div>
                        <a href="{{ route('tienda') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            Ver todos
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach ($productosRelacionados as $productoRel)
                            <div
                                class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group">
                                <div class="p-6">
                                    <div class="h-48 overflow-hidden mb-6 rounded-xl">
                                        <img src="{{ $productoRel['imagen_1_url'] }}" alt="{{ $productoRel['nombre'] }}"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 h-14 text-lg">
                                        {{ $productoRel['nombre'] }}
                                    </h3>
                                    <div class="flex items-center mb-4">
                                        <div class="flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">({{ rand(100, 5000) }})</span>
                                    </div>
                                    <div class="mb-6">
                                        <div class="text-2xl font-bold text-gray-900">
                                            ${{ number_format($productoRel['precio'], 2) }}</div>
                                        <div class="flex items-center mt-1">
                                            <span
                                                class="text-sm text-green-600 bg-green-50 px-2 py-1 rounded">Disponible</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('producto.detalle', $productoRel['id']) }}"
                                        class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-4 rounded-xl text-center transition-all duration-300 transform hover:scale-[1.02] group-hover:shadow-lg">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Lightbox Modal Mejorado --}}
    <div id="lightboxModal"
        class="hidden fixed inset-0 bg-black bg-opacity-95 z-[100] flex items-center justify-center p-4">
        <div class="relative max-w-6xl max-h-[90vh]">
            <button onclick="closeLightbox()"
                class="absolute -top-16 right-0 text-white text-4xl hover:text-gray-300 transition-colors z-10">
                &times;
            </button>
            <img id="lightboxImage" class="max-w-full max-h-[90vh] object-contain rounded-xl" src=""
                alt="">
        </div>
    </div>

    <script>
        // Funciones para cantidad
        function updateHiddenQuantity() {
            const input = document.getElementById('quantityInput');
            const hiddenInput = document.getElementById('hiddenQuantity');
            hiddenInput.value = input.value;
        }

        function incrementQuantity() {
            const input = document.getElementById('quantityInput');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
                updateHiddenQuantity();
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantityInput');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
                updateHiddenQuantity();
            }
        }

        // Inicializar cantidad oculta
        document.addEventListener('DOMContentLoaded', function() {
            updateHiddenQuantity();
            document.getElementById('quantityInput')?.addEventListener('change', updateHiddenQuantity);
        });

        // Funciones para imágenes
        function changeMainImage(src) {
            const mainImage = document.getElementById('mainProductImage');
            mainImage.style.opacity = '0.5';
            setTimeout(() => {
                mainImage.src = src;
                mainImage.style.opacity = '1';
            }, 200);
        }

        function openLightbox(src) {
            document.getElementById('lightboxImage').src = src;
            document.getElementById('lightboxModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightboxModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Función comprar ahora mejorada
        function comprarAhora() {
            const form = document.getElementById('formAgregarCarrito');
            if (form) {
                // Mostrar loader
                const originalText = document.querySelector('#btnAgregarCarrito span')?.textContent || 'PROCESANDO...';
                if (document.querySelector('#btnAgregarCarrito')) {
                    document.querySelector('#btnAgregarCarrito').innerHTML = `
                <svg class="animate-spin h-6 w-6 mr-3 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg">PROCESANDO...</span>
            `;
                }

                // Cambiar la acción y enviar
                form.action = '{{ route('checkout.index') }}';
                setTimeout(() => form.submit(), 500);
            }
        }

        // Cerrar lightbox con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });

        // Efecto hover en botones
        document.querySelectorAll('button[type="submit"], button[type="button"]').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .cursor-zoom-in {
            cursor: zoom-in;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .prose {
            color: #374151;
        }

        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .prose-lg p {
            font-size: 1.125rem;
        }

        .hover\:shadow-xl {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .hover\:scale-105 {
            transition: transform 0.3s ease;
        }

        .hover\:-translate-y-0\.5 {
            transition: transform 0.3s ease;
        }

        #quantityInput {
            -moz-appearance: textfield;
        }

        #quantityInput::-webkit-outer-spin-button,
        #quantityInput::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Animaciones suaves */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Gradientes mejorados */
        .bg-gradient-to-r {
            background-size: 200% 100%;
            background-position: 100% 0;
            transition: background-position 0.5s ease;
        }

        .bg-gradient-to-r:hover {
            background-position: 0 0;
        }
    </style>
@endsection
