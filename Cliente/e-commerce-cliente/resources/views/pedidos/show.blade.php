@extends('layouts.app')

@section('title', 'Detalle del Pedido #' . $pedido['id'] . ' - Global AutoParts')

@section('content')
    <div class="min-h-screen bg-gray-50">

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
                                <a href="{{ route('pedido.index') }}"
                                    class="ml-1 text-sm text-gray-700 hover:text-blue-600">
                                    Mis Pedidos
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-blue-600">
                                    Pedido #{{ $pedido['id'] }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Header del Pedido -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-receipt text-blue-600 mr-3"></i>
                            Pedido #{{ $pedido['id'] }}
                        </h1>
                        <div class="flex items-center mt-2 text-gray-600">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>Realizado el
                                {{ \Carbon\Carbon::parse($pedido['created_at'])->format('d/m/Y \a \l\a\s H:i') }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-hashtag mr-1"></i>
                            <span>{{ count($pedido['items'] ?? []) }} producto(s)</span>
                        </div>
                    </div>

                    <!-- Badge de Estado -->
                    @php
                        $estadoConfig = [
                            'completado' => [
                                'class' => 'bg-green-100 text-green-800 border-green-200',
                                'icon' => 'fa-check-circle',
                            ],
                            'entregado' => [
                                'class' => 'bg-green-100 text-green-800 border-green-200',
                                'icon' => 'fa-truck',
                            ],
                            'pagado' => [
                                'class' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'icon' => 'fa-credit-card',
                            ],
                            'pendiente' => [
                                'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'icon' => 'fa-clock',
                            ],
                            'cancelado' => [
                                'class' => 'bg-red-100 text-red-800 border-red-200',
                                'icon' => 'fa-times-circle',
                            ],
                            'enviado' => [
                                'class' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                'icon' => 'fa-shipping-fast',
                            ],
                            'procesando' => [
                                'class' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'icon' => 'fa-cogs',
                            ],
                        ];

                        $estado = strtolower($pedido['estado']);
                        $config = $estadoConfig[$estado] ?? [
                            'class' => 'bg-gray-100 text-gray-800 border-gray-200',
                            'icon' => 'fa-question-circle',
                        ];
                    @endphp

                    <div class="flex items-center space-x-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full border {{ $config['class'] }}">
                            <i class="fas {{ $config['icon'] }} mr-2"></i>
                            <span class="font-semibold text-sm uppercase">{{ ucfirst($estado) }}</span>
                        </div>

                        @if ($pedido['estado'] == 'pendiente')
                            <button onclick="cancelarPedido()"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar Pedido
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Columna Izquierda - Productos -->
                <div class="lg:w-2/3">
                    <!-- Tarjeta de Productos -->
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 mb-6 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-boxes text-blue-600 mr-3"></i>
                                    Productos comprados
                                </h2>
                                <span class="text-sm text-gray-600">{{ count($pedido['items'] ?? []) }} items</span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-blue-50">
                                        <th
                                            class="py-3 px-6 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Producto
                                        </th>
                                        <th
                                            class="py-3 px-6 text-center text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Cantidad
                                        </th>
                                        <th
                                            class="py-3 px-6 text-right text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Precio Unitario
                                        </th>
                                        <th
                                            class="py-3 px-6 text-right text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($pedido['items'] as $index => $item)
                                        <tr class="hover:bg-blue-50 transition-colors group">
                                            <!-- Producto -->
                                            <td class="py-4 px-6">
                                                <div class="flex items-center space-x-4">
                                                    <!-- Imagen del Producto -->
                                                    <div
                                                        class="flex-shrink-0 w-16 h-16 bg-blue-100 rounded-lg border border-blue-200 flex items-center justify-center">
                                                        @if (isset($item['producto']['imagen']) && !empty($item['producto']['imagen']))
                                                            <img src="{{ $item['producto']['imagen'] }}"
                                                                alt="{{ $item['producto']['nombre'] }}"
                                                                class="w-12 h-12 object-contain">
                                                        @else
                                                            <i class="fas fa-cogs text-blue-400 text-xl"></i>
                                                        @endif
                                                    </div>
                                                    <!-- Info del Producto -->
                                                    <div class="min-w-0 flex-1">
                                                        <h4
                                                            class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                            {{ $item['producto']['nombre'] }}
                                                        </h4>
                                                        @if (isset($item['producto']['marca']) && !empty($item['producto']['marca']))
                                                            <div class="flex items-center mt-1">
                                                                <span
                                                                    class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-1 rounded">
                                                                    {{ $item['producto']['marca']['nombre'] ?? '' }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        @if (isset($item['producto']['codigo']))
                                                            <p class="text-xs text-gray-500 mt-1">
                                                                SKU: {{ $item['producto']['codigo'] }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Cantidad -->
                                            <td class="py-4 px-6 text-center">
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-700 font-semibold rounded-lg">
                                                    {{ $item['cantidad'] }}
                                                </div>
                                            </td>

                                            <!-- Precio Unitario -->
                                            <td class="py-4 px-6 text-right">
                                                <div class="text-gray-900 font-medium">
                                                    ${{ number_format($item['precio_unitario'], 2) }}
                                                </div>
                                            </td>

                                            <!-- Subtotal -->
                                            <td class="py-4 px-6 text-right">
                                                <div class="text-gray-900 font-semibold">
                                                    ${{ number_format($item['precio_unitario'] * $item['cantidad'], 2) }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Información de Envío -->
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl mr-3"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Información de envío</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-2">Dirección de entrega</label>
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <p class="text-gray-900 font-medium">{{ $pedido['direccion_envio'] }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-2">Método de pago</label>
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 flex items-center space-x-3">
                                    @if ($pedido['metodo_pago'] == 'tarjeta')
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-credit-card text-blue-600"></i>
                                        </div>
                                    @elseif($pedido['metodo_pago'] == 'efectivo')
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-money-bill-wave text-blue-600"></i>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-university text-blue-600"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900 capitalize">{{ $pedido['metodo_pago'] }}</p>
                                        <p class="text-sm text-gray-600">
                                            @if ($pedido['metodo_pago'] == 'tarjeta')
                                                Pago seguro con tarjeta
                                            @elseif($pedido['metodo_pago'] == 'efectivo')
                                                Pago al recibir
                                            @else
                                                Transferencia bancaria
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha - Resumen -->
                <div class="lg:w-1/3">
                    <div class="sticky top-6 space-y-6">
                        <!-- Resumen Financiero -->
                        <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-file-invoice-dollar text-blue-600 mr-3"></i>
                                    Resumen de pago
                                </h3>
                            </div>

                            <div class="p-6">
                                <!-- Desglose de precios -->
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span
                                            class="font-medium text-gray-900">${{ number_format($pedido['subtotal'], 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Envío</span>
                                        <span class="font-medium text-green-600">Gratis</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Impuestos (16%)</span>
                                        <span
                                            class="font-medium text-gray-900">${{ number_format($pedido['impuestos'], 2) }}</span>
                                    </div>

                                    <div class="border-t border-gray-200 pt-4 mt-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-lg font-bold text-gray-900">Total pagado</span>
                                                <p class="text-sm text-gray-500">IVA incluido</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-blue-600">
                                                    ${{ number_format($pedido['total'], 2) }}
                                                </div>
                                                <p class="text-sm text-green-600 mt-1">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Pago confirmado
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acciones -->
                                <div class="space-y-3">
                                    <button onclick="window.print()"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-print mr-3"></i>
                                        Imprimir recibo
                                    </button>

                                    <a href="{{ route('pedido.index') }}"
                                        class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-arrow-left mr-3"></i>
                                        Volver a mis pedidos
                                    </a>

                                    @if ($pedido['estado'] == 'entregado' || $pedido['estado'] == 'completado')
                                        <button onclick="solicitarGarantia()"
                                            class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            <i class="fas fa-shield-alt mr-3"></i>
                                            Solicitar garantía
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Cronología del Pedido -->
                        <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-history text-blue-600 mr-3"></i>
                                Cronología
                            </h3>

                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-shopping-cart text-blue-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Pedido realizado</p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($pedido['created_at'])->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <i class="fas fa-check text-green-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Pago confirmado</p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($pedido['created_at'])->addMinutes(5)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                @if (in_array($pedido['estado'], ['enviado', 'entregado', 'completado']))
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-shipping-fast text-indigo-600 text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Pedido enviado</p>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($pedido['created_at'])->addHours(2)->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if (in_array($pedido['estado'], ['entregado', 'completado']))
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <i class="fas fa-home text-green-600 text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Pedido entregado</p>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($pedido['created_at'])->addDays(1)->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Soporte y Ayuda -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                            <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                                <i class="fas fa-headset text-blue-600 mr-2"></i>
                                ¿Necesitas ayuda?
                            </h4>
                            <p class="text-sm text-blue-700 mb-4">
                                Si tienes preguntas sobre tu pedido, nuestro equipo de soporte está disponible.
                            </p>
                            <div class="space-y-2">
                                <a href="#" class="flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-question-circle mr-2"></i>
                                    Preguntas frecuentes
                                </a>
                                <a href="#" class="flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-phone mr-2"></i>
                                    Contactar soporte
                                </a>
                                <a href="#" class="flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-file-alt mr-2"></i>
                                    Política de devoluciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación para la tabla de productos
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-10px)';

                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease-out';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, index * 50);
            });

            // Función para cancelar pedido
            window.cancelarPedido = async function() {
                if (!confirm('¿Estás seguro de que deseas cancelar este pedido?')) {
                    return;
                }

                try {
                    const response = await fetch('{{ route('pedido.cancelar', $pedido['id']) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showToast('Pedido cancelado exitosamente', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showToast(data.message || 'Error al cancelar el pedido', 'error');
                    }
                } catch (error) {
                    showToast('Error de conexión', 'error');
                    console.error('Error:', error);
                }
            };

            // Función para solicitar garantía
            window.solicitarGarantia = function() {
                alert('Funcionalidad de solicitud de garantía en desarrollo. Próximamente disponible.');
            };

            // Función para mostrar notificaciones toast
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className =
                    `global-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500'} text-white`;
                toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'} mr-3"></i>
                    <span>${message}</span>
                </div>
            `;

                document.body.appendChild(toast);

                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-full');
                });

                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentNode) {
                            document.body.removeChild(toast);
                        }
                    }, 300);
                }, 4000);

                toast.addEventListener('click', function() {
                    this.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (this.parentNode) {
                            document.body.removeChild(this);
                        }
                    }, 300);
                });
            }

            // Efecto hover para productos
            const productRows = document.querySelectorAll('tbody tr');
            productRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.classList.add('bg-blue-50');
                });

                row.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-blue-50');
                });
            });

            // Animación para el badge de estado
            const statusBadge = document.querySelector('.inline-flex.items-center.px-4.py-2');
            if (statusBadge) {
                statusBadge.style.animation = 'pulse 2s infinite';
            }

            // Copiar número de pedido al portapapeles
            const orderNumber = document.querySelector('h1.text-2xl');
            if (orderNumber) {
                orderNumber.addEventListener('click', function() {
                    const text = this.textContent.match(/#(\d+)/)?.[0] || '';
                    if (text) {
                        navigator.clipboard.writeText(text).then(() => {
                            showToast(`Número de pedido ${text} copiado`, 'success');
                        });
                    }
                });
                orderNumber.classList.add('cursor-pointer', 'hover:text-blue-700');
            }
        });
    </script>

    <style>
        /* Estilos personalizados */
        .global-toast {
            z-index: 9999;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            cursor: pointer;
        }

        .global-toast:hover {
            opacity: 0.9;
        }

        /* Animación para el badge de estado */
        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(59, 130, 246, 0);
            }
        }

        /* Estilos para la tabla */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            position: sticky;
            top: 0;
            background-color: #eff6ff;
        }

        /* Estilos para el breadcrumb */
        .breadcrumb-item:not(:last-child)::after {
            content: "/";
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            color: #9ca3af;
        }

        /* Estilos para la cronología */
        .timeline-item:not(:last-child)::after {
            content: "";
            position: absolute;
            left: 16px;
            top: 40px;
            bottom: -20px;
            width: 2px;
            background-color: #e5e7eb;
        }

        /* Efectos hover */
        tr:hover {
            transition: background-color 0.2s ease;
        }

        /* Estilos para botones deshabilitados */
        button:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Scrollbar personalizado */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #60a5fa;
        }

        /* Efecto de elevación */
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Estilos para print */
        @media print {
            .no-print {
                display: none !important;
            }

            body * {
                visibility: hidden;
            }

            .container,
            .container * {
                visibility: visible;
            }

            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
@endsection
