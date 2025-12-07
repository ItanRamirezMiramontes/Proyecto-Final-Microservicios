@extends('layouts.app')

@section('title', 'Carrito de Compras - Global AutoParts')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 py-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        Mi Carrito de Compras
                    </h1>
                    <div class="text-sm text-gray-600 bg-blue-50 px-3 py-1 rounded-full">
                        <span class="font-bold text-blue-700">{{ $carrito['resumen']['cantidad_items'] ?? 0 }}</span>
                        @if (($carrito['resumen']['cantidad_items'] ?? 0) == 1)
                            producto
                        @else
                            productos
                        @endif
                    </div>
                </div>

                <div class="flex items-center text-sm text-gray-600">
                    <a href="{{ route('welcome') }}" class="hover:text-blue-700">Inicio</a>
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('tienda') }}" class="hover:text-blue-700">Tienda</a>
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-900 font-medium">Carrito</span>
                </div>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div
                    class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
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

            @if (session('error'))
                <div class="mb-8 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Carrito con productos --}}
            @if (isset($carrito['items']) && count($carrito['items']) > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    {{-- Columna izquierda: Lista de productos --}}
                    <div class="lg:w-2/3">
                        {{-- Encabezado de productos --}}
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-gray-900">Productos en el carrito</h2>
                                <span class="text-sm text-gray-600">
                                    {{ count($carrito['items']) }}
                                    {{ count($carrito['items']) == 1 ? 'producto' : 'productos' }}
                                </span>
                            </div>

                            {{-- Lista de productos --}}
                            <div class="divide-y divide-gray-100">
                                @foreach ($carrito['items'] as $item)
                                    <div class="py-6 first:pt-0 last:pb-0">
                                        <div class="flex flex-col sm:flex-row gap-6">
                                            {{-- Imagen del producto --}}
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-4">
                                                    @if (!empty($item['imagen']))
                                                        <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}"
                                                            class="w-32 h-32 object-contain">
                                                    @else
                                                        <div class="w-32 h-32 flex items-center justify-center">
                                                            <svg class="w-16 h-16 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Información del producto --}}
                                            <div class="flex-1">
                                                <div class="flex flex-col h-full">
                                                    {{-- Nombre y descripción --}}
                                                    <div class="flex-1">
                                                        <h3 class="font-bold text-gray-900 text-lg mb-2">
                                                            {{ $item['nombre'] }}</h3>
                                                        <div class="flex items-center space-x-4 mb-3">
                                                            <span
                                                                class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                                                SKU: {{ $item['producto_id'] }}
                                                            </span>
                                                            <div class="flex items-center text-sm text-gray-600">
                                                                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <span>Stock: {{ $item['stock_disponible'] }}
                                                                    unidades</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Precio y acciones --}}
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                                        {{-- Precio --}}
                                                        <div>
                                                            <div class="text-2xl font-bold text-gray-900 mb-1">
                                                                ${{ number_format($item['precio'], 2) }}
                                                            </div>
                                                            <div class="text-lg font-bold text-blue-600">
                                                                ${{ number_format($item['subtotal'], 2) }}
                                                                <span class="text-sm text-gray-500">total</span>
                                                            </div>
                                                        </div>

                                                        {{-- Controles de cantidad --}}
                                                        <div class="flex items-center space-x-4">
                                                            <div
                                                                class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                                                <button type="button"
                                                                    onclick="decrementQuantity({{ $item['id'] }}, {{ $item['cantidad'] }})"
                                                                    class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 border-r border-gray-200 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M20 12H4" />
                                                                    </svg>
                                                                </button>
                                                                <span id="quantity-{{ $item['id'] }}"
                                                                    class="w-16 text-center text-lg font-bold text-gray-900 px-2">
                                                                    {{ $item['cantidad'] }}
                                                                </span>
                                                                <button type="button"
                                                                    onclick="incrementQuantity({{ $item['id'] }}, {{ $item['cantidad'] }}, {{ $item['stock_disponible'] }})"
                                                                    class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 border-l border-gray-200 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 4v16m8-8H4" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            {{-- Eliminar --}}
                                                            <form action="{{ route('carrito.delete', $item['id']) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('¿Eliminar \'{{ $item['nombre'] }}\' del carrito?')"
                                                                    class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center">
                                                                    <svg class="w-5 h-5 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Acciones del carrito --}}
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                            <a href="{{ route('tienda') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Continuar comprando
                            </a>

                            <form action="{{ route('carrito.delete', 'all') }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Estás seguro de vaciar todo el carrito?')"
                                    class="inline-flex items-center text-red-600 hover:text-red-800 font-medium">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Vaciar carrito completo
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Columna derecha: Resumen del pedido --}}
                    <div class="lg:w-1/3">
                        <div class="sticky top-24">
                            {{-- Tarjeta de resumen --}}
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mb-6">
                                {{-- Header --}}
                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                                    <h2 class="text-xl font-bold flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Resumen del pedido
                                    </h2>
                                </div>

                                {{-- Contenido --}}
                                <div class="p-6">
                                    {{-- Detalles del pedido --}}
                                    <div class="space-y-4 mb-6">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Productos
                                                ({{ $carrito['resumen']['cantidad_items'] }})</span>
                                            <span
                                                class="font-medium text-gray-900">${{ number_format($carrito['resumen']['subtotal'], 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">IVA (16%)</span>
                                            <span
                                                class="font-medium text-gray-900">${{ number_format($carrito['resumen']['impuestos'], 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                            <span class="text-lg font-bold text-gray-900">Subtotal</span>
                                            <span
                                                class="text-lg font-bold text-gray-900">${{ number_format($carrito['resumen']['subtotal'], 2) }}</span>
                                        </div>
                                    </div>

                                    {{-- Envío --}}
                                    <div
                                        class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-3">
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 mb-1">¡Envío GRATIS!</p>
                                                <p class="text-sm text-gray-600">En pedidos superiores a $500 MXN</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Total --}}
                                    <div class="mb-6">
                                        <div
                                            class="flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl">
                                            <span class="text-xl font-bold text-gray-900">Total</span>
                                            <span
                                                class="text-2xl font-bold text-blue-700">${{ number_format($carrito['resumen']['total'], 2) }}</span>
                                        </div>
                                        <p class="text-sm text-gray-500 text-center mt-2">IVA incluido</p>
                                    </div>

                                    {{-- Botones de acción --}}
                                    <div class="space-y-3">
                                        <a href="{{ route('checkout.index') }}"
                                            class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Proceder al pago
                                        </a>

                                        <a href="{{ route('tienda') }}"
                                            class="block w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-4 px-6 rounded-xl transition-all duration-300 text-center">
                                            Seguir comprando
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Información de seguridad --}}
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-xl p-4">
                                <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Compra 100% segura
                                </h3>
                                <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pago seguro
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Garantía
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Envío rápido
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Soporte 24/7
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Carrito vacío --}}
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 text-center">
                        <div class="w-32 h-32 mx-auto mb-6 text-gray-300">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Tu carrito está vacío</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Parece que no has agregado ningún producto a tu carrito.
                            ¡Explora nuestra tienda y encuentra productos increíbles!
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('tienda') }}"
                                class="inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Explorar Tienda
                            </a>

                            <a href="{{ route('welcome') }}"
                                class="inline-flex items-center justify-center border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3 px-6 rounded-xl transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Función para incrementar cantidad
        function incrementQuantity(itemId, currentQuantity, maxStock) {
            if (currentQuantity < maxStock) {
                updateCartItem(itemId, currentQuantity + 1);
            } else {
                showNotification('No puedes agregar más de ' + maxStock + ' unidades', 'warning');
            }
        }

        // Función para decrementar cantidad
        function decrementQuantity(itemId, currentQuantity) {
            if (currentQuantity > 1) {
                updateCartItem(itemId, currentQuantity - 1);
            } else {
                if (confirm('¿Eliminar este producto del carrito?')) {
                    // Enviar petición DELETE
                    fetch(`/carrito/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                showNotification('Error al eliminar el producto', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error de conexión', 'error');
                        });
                }
            }
        }

        // Función para actualizar cantidad
        function updateCartItem(itemId, cantidad) {
            // Mostrar loader
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            const originalText = quantityElement.textContent;
            quantityElement.textContent = '...';

            // Enviar petición PUT
            fetch(`/carrito/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        cantidad: cantidad
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar navbar si existe la función
                        if (window.GlobalAutoParts && data.data && data.data.cantidad_total) {
                            window.GlobalAutoParts.updateCartCount(data.data.cantidad_total);
                        }
                        // Recargar la página para actualizar totales
                        location.reload();
                    } else {
                        quantityElement.textContent = originalText;
                        showNotification(data.message || 'Error al actualizar cantidad', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    quantityElement.textContent = originalText;
                    showNotification('Error de conexión', 'error');
                });
        }

        // Función para mostrar notificaciones
        function showNotification(message, type = 'info') {
            // Crear elemento de notificación
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-[100] px-4 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
        type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
        type === 'warning' ? 'bg-yellow-100 border border-yellow-400 text-yellow-700' :
        'bg-blue-100 border border-blue-400 text-blue-700'
    }`;
            notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                ${type === 'success' ? 
                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>' :
                  type === 'error' ?
                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>' :
                  type === 'warning' ?
                    '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>' :
                    '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;

            document.body.appendChild(notification);

            // Animar entrada
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.classList.add('translate-x-0');
            }, 10);

            // Remover después de 4 segundos
            setTimeout(() => {
                notification.classList.remove('translate-x-0');
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Efectos hover en botones
            document.querySelectorAll('button[type="submit"], a[href]').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.3s ease-out;
        }

        /* Transiciones suaves */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        /* Efectos hover mejorados */
        .hover\:-translate-y-0\.5 {
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover\:shadow-xl {
            transition: box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Scrollbar personalizado */
        .max-h-96::-webkit-scrollbar {
            width: 6px;
        }

        .max-h-96::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .max-h-96::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .max-h-96::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Gradientes animados */
        .bg-gradient-to-r {
            background-size: 200% 100%;
            background-position: 100% 0;
            transition: background-position 0.3s ease;
        }

        .bg-gradient-to-r:hover {
            background-position: 0 0;
        }

        /* Efecto de sombra en tarjetas */
        .shadow-lg {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Bordes redondeados consistentes */
        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        /* Efecto de transparencia en imágenes */
        .img-thumbnail {
            transition: opacity 0.3s ease;
        }

        .img-thumbnail:hover {
            opacity: 0.9;
        }
    </style>
@endpush
