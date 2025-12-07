@extends('layouts.app')

@section('title', 'Mis Pedidos - Global AutoParts')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header Global AutoParts -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('welcome') }}" class="text-2xl font-bold text-white">
                            <i class="fas fa-car mr-2"></i>
                            Global AutoParts
                        </a>
                        <span class="text-blue-300 mx-2">|</span>
                        <h1 class="text-xl font-semibold text-white">Mis Pedidos</h1>
                    </div>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('tienda') }}" class="text-blue-100 hover:text-white transition-colors">
                            <i class="fas fa-store mr-1"></i> Tienda
                        </a>
                        <a href="{{ route('carrito.index') }}" class="text-blue-100 hover:text-white transition-colors">
                            <i class="fas fa-shopping-cart mr-1"></i> Carrito
                        </a>
                        <a href="{{ route('client.profile') }}" class="text-blue-100 hover:text-white transition-colors">
                            <i class="fas fa-user mr-1"></i> {{ session('client_user')['nombre'] ?? 'Cuenta' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="bg-white border-b py-3">
            <div class="container mx-auto px-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('welcome') }}"
                                class="inline-flex items-center text-sm text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i>
                                Inicio
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <a href="{{ route('client.dashboard') }}"
                                    class="ml-1 text-sm text-gray-700 hover:text-blue-600">
                                    Dashboard
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-blue-600">
                                    Mis Pedidos
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-3"></i>
                    Historial de Pedidos
                </h1>
                <p class="text-gray-600 mt-2">Revisa todos tus pedidos anteriores</p>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl border border-blue-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Pedidos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ count($pedidos) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-blue-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Gastado</p>
                            <p class="text-2xl font-bold text-gray-900">
                                ${{ number_format(collect($pedidos)->sum('total'), 2) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-blue-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pedidos Pendientes</p>
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ count(collect($pedidos)->where('estado', 'pendiente')) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Pedidos -->
            @if (empty($pedidos))
                <div class="bg-white rounded-xl border border-blue-100 p-12 text-center">
                    <div class="w-24 h-24 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shopping-bag text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aún no tienes pedidos</h3>
                    <p class="text-gray-600 mb-6">Comienza a comprar en nuestra tienda para ver tu historial aquí.</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('tienda') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-store mr-2"></i>
                            Ir a la tienda
                        </a>
                        <a href="{{ route('carrito.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Ver carrito
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($pedidos as $pedido)
                        @php
                            $estadoConfig = [
                                'pendiente' => ['color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'],
                                'procesando' => ['color' => 'bg-purple-100 text-purple-800', 'icon' => 'fa-cogs'],
                                'enviado' => ['color' => 'bg-indigo-100 text-indigo-800', 'icon' => 'fa-shipping-fast'],
                                'entregado' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
                                'completado' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-double'],
                                'cancelado' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle'],
                                'pagado' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-credit-card'],
                            ];

                            $config = $estadoConfig[$pedido['estado']] ?? [
                                'color' => 'bg-gray-100 text-gray-800',
                                'icon' => 'fa-question-circle',
                            ];
                        @endphp

                        <div
                            class="bg-white rounded-xl border border-blue-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <!-- Información principal -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-12 h-12 rounded-full {{ str_replace('text-', '', $config['color']) }} flex items-center justify-center">
                                                <i
                                                    class="fas {{ $config['icon'] }} {{ str_replace('bg-', 'text-', explode(' ', $config['color'])[1]) }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Pedido #{{ $pedido['id'] }}
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ \Carbon\Carbon::parse($pedido['created_at'])->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="ml-16 space-y-2">
                                        <!-- Badges -->
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['color'] }}">
                                                <i class="fas {{ $config['icon'] }} mr-1.5"></i>
                                                {{ ucfirst($pedido['estado']) }}
                                            </span>
                                            @if (isset($pedido['items']))
                                                @php
                                                    $cantidadProductos = collect($pedido['items'])->sum('cantidad');
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-box mr-1.5"></i>
                                                    {{ $cantidadProductos }}
                                                    producto{{ $cantidadProductos != 1 ? 's' : '' }}
                                                </span>
                                            @endif
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                <i class="fas fa-credit-card mr-1.5"></i>
                                                {{ ucfirst($pedido['metodo_pago'] ?? 'No especificado') }}
                                            </span>
                                        </div>

                                        <!-- Dirección -->
                                        @if (isset($pedido['direccion_envio']))
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-map-marker-alt mr-1.5"></i>
                                                {{ Str::limit($pedido['direccion_envio'], 60) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Total y acciones -->
                                <div class="lg:text-right">
                                    <div class="text-2xl font-bold text-blue-600">${{ number_format($pedido['total'], 2) }}
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="mr-3">
                                            <i class="fas fa-cube mr-1"></i>${{ number_format($pedido['subtotal'], 2) }}
                                        </span>
                                        <span>
                                            <i
                                                class="fas fa-percentage mr-1"></i>${{ number_format($pedido['impuestos'], 2) }}
                                        </span>
                                    </p>

                                    <div class="flex flex-wrap gap-2 mt-4">
                                        <a href="{{ route('pedido.show', $pedido['id']) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                            <i class="fas fa-eye mr-2"></i>
                                            Ver Detalle
                                        </a>

                                        @if ($pedido['estado'] == 'pendiente')
                                            <form action="{{ route('pedido.cancelar', $pedido['id']) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?')"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Productos destacados -->
                            @if (isset($pedido['items']) && count($pedido['items']) > 0)
                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Productos incluidos:</h4>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach (array_slice($pedido['items'], 0, 3) as $item)
                                            <div class="flex items-center space-x-2 bg-blue-50 rounded-lg px-3 py-2">
                                                <span
                                                    class="text-xs font-medium text-blue-700">{{ $item['cantidad'] }}×</span>
                                                <span
                                                    class="text-sm text-gray-900">{{ $item['producto']['nombre'] ?? 'Producto' }}</span>
                                            </div>
                                        @endforeach
                                        @if (count($pedido['items']) > 3)
                                            <div class="flex items-center space-x-2 bg-gray-100 rounded-lg px-3 py-2">
                                                <span class="text-sm text-gray-600">+{{ count($pedido['items']) - 3 }}
                                                    más</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Acciones rápidas -->
            <div class="mt-12">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-headset text-blue-600 mr-2"></i>
                        ¿Necesitas ayuda?
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('tienda') }}"
                            class="flex items-center p-4 bg-white rounded-lg border border-blue-100 hover:border-blue-300 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-store text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Continuar comprando</p>
                                <p class="text-sm text-gray-600">Explora más productos</p>
                            </div>
                        </a>

                        <a href="{{ route('carrito.index') }}"
                            class="flex items-center p-4 bg-white rounded-lg border border-blue-100 hover:border-blue-300 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Ver mi carrito</p>
                                <p class="text-sm text-gray-600">Revisa tus productos</p>
                            </div>
                        </a>

                        <a href="{{ route('client.profile') }}"
                            class="flex items-center p-4 bg-white rounded-lg border border-blue-100 hover:border-blue-300 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Mi perfil</p>
                                <p class="text-sm text-gray-600">Administra tu cuenta</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Función simple para confirmar cancelación
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar confirmación a todos los botones de cancelar
            const cancelButtons = document.querySelectorAll('button[onclick*="confirm"]');
            cancelButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('¿Estás seguro de que deseas cancelar este pedido?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
