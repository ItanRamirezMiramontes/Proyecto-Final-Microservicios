@extends('layouts.app')

@section('title', 'Finalizar Compra - Global AutoParts')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header con branding azul -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('welcome') }}" class="text-2xl font-bold text-white">
                            <i class="fas fa-car mr-2"></i>
                            Global AutoParts
                        </a>
                        <span class="text-blue-300 mx-2">|</span>
                        <h1 class="text-xl font-semibold text-white">Checkout</h1>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="{{ route('tienda') }}" class="text-blue-100 hover:text-white transition-colors">
                                <i class="fas fa-store mr-1"></i> Tienda
                            </a>
                            <a href="{{ route('carrito.index') }}"
                                class="text-blue-100 hover:text-white transition-colors relative">
                                <i class="fas fa-shopping-cart mr-1"></i> Carrito
                                @if (($resumen['cantidad_items'] ?? 0) > 0)
                                    <span
                                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $resumen['cantidad_items'] }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('client.profile') }}"
                                class="text-blue-100 hover:text-white transition-colors">
                                <i class="fas fa-user mr-1"></i> {{ session('client_user')['nombre'] ?? 'Cuenta' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Steps azul -->
        <div class="bg-white border-b shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex justify-center py-4">
                    <div class="flex items-center w-full max-w-3xl">
                        <div class="flex-1">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-sm"></i>
                                </div>
                                <span class="text-xs mt-2 font-medium text-gray-700">Carrito</span>
                            </div>
                        </div>

                        <div class="flex-1 border-t-2 border-blue-600 mx-2"></div>

                        <div class="flex-1">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <span class="text-xs mt-2 font-medium text-gray-900">Envío & Pago</span>
                            </div>
                        </div>

                        <div class="flex-1 border-t-2 border-gray-300 mx-2"></div>

                        <div class="flex-1">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center">
                                    <i class="fas fa-check text-sm"></i>
                                </div>
                                <span class="text-xs mt-2 font-medium text-gray-400">Confirmación</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            @if (empty($items))
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Tu carrito está vacío</h2>
                    <p class="text-gray-500 mb-6">Agrega productos al carrito antes de proceder al checkout.</p>
                    <a href="{{ route('tienda') }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-store mr-2"></i>
                        Ir a la tienda
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Columna Izquierda - Formularios -->
                    <div class="lg:w-2/3">
                        @if (session('error'))
                            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Dirección de Envío - Card azul -->
                        <div class="bg-white rounded-lg shadow-sm border border-blue-100 mb-6 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-map-marker-alt text-blue-600 text-lg"></i>
                                        </div>
                                        <h2 class="ml-3 text-lg font-semibold text-gray-900">1. Dirección de envío</h2>
                                    </div>
                                    @if (!empty(session('client_user')['direccion']))
                                        <button type="button" onclick="usarDireccionGuardada()"
                                            class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center">
                                            <i class="fas fa-redo mr-1"></i>
                                            Usar dirección guardada
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="px-6 py-5">
                                <form action="{{ route('checkout.procesar') }}" method="POST" id="checkoutForm">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="direccion_envio" class="block text-sm font-medium text-gray-700 mb-2">
                                            Dirección completa *
                                            <span class="text-blue-600 font-normal" id="charCount">0 caracteres</span>
                                        </label>
                                        <textarea name="direccion_envio" id="direccion_envio" rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                            placeholder="Calle, número, colonia, ciudad, estado, código postal..." required>{{ old('direccion_envio', session('client_user')['direccion'] ?? '') }}</textarea>
                                        @error('direccion_envio')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Información del Cliente -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <div class="bg-blue-50 p-4 rounded-lg">
                                            <label class="block text-xs font-medium text-blue-700 mb-1">Nombre
                                                completo</label>
                                            <div class="font-medium text-gray-900">
                                                {{ session('client_user')['nombre'] ?? '' }}
                                                {{ session('client_user')['apellido'] ?? '' }}
                                            </div>
                                        </div>
                                        <div class="bg-blue-50 p-4 rounded-lg">
                                            <label class="block text-xs font-medium text-blue-700 mb-1">Email</label>
                                            <div class="font-medium text-gray-900">
                                                {{ session('client_user')['email'] ?? 'N/A' }}</div>
                                        </div>
                                        @if (!empty(session('client_user')['telefono']))
                                            <div class="bg-blue-50 p-4 rounded-lg">
                                                <label class="block text-xs font-medium text-blue-700 mb-1">Teléfono</label>
                                                <div class="font-medium text-gray-900">
                                                    {{ session('client_user')['telefono'] }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Método de Pago - Estilo azul -->
                                    <div class="mb-6">
                                        <div class="flex items-center mb-4">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-credit-card text-blue-600 text-lg"></i>
                                            </div>
                                            <h3 class="ml-3 text-lg font-semibold text-gray-900">2. Método de pago</h3>
                                        </div>

                                        <div class="space-y-3">
                                            <!-- Tarjeta de Crédito/Débito -->
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="metodo_pago"
                                                    id="tarjeta" value="tarjeta"
                                                    {{ old('metodo_pago') == 'tarjeta' ? 'checked' : '' }} required>
                                                <label for="tarjeta"
                                                    class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <div
                                                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                                <i class="fas fa-credit-card text-blue-600"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-medium text-gray-900">Tarjeta de crédito/débito
                                                            </h4>
                                                            <p class="text-sm text-gray-500">Pago seguro con encriptación
                                                                SSL</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500">
                                                            <div
                                                                class="w-3 h-3 rounded-full bg-blue-500 hidden peer-checked:block">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- Transferencia Bancaria -->
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="metodo_pago"
                                                    id="transferencia" value="transferencia"
                                                    {{ old('metodo_pago') == 'transferencia' ? 'checked' : '' }}>
                                                <label for="transferencia"
                                                    class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <div
                                                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                                <i class="fas fa-university text-blue-600"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-medium text-gray-900">Transferencia bancaria
                                                            </h4>
                                                            <p class="text-sm text-gray-500">Depósito en cuenta bancaria
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500">
                                                            <div
                                                                class="w-3 h-3 rounded-full bg-blue-500 hidden peer-checked:block">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <!-- Efectivo -->
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="metodo_pago"
                                                    id="efectivo" value="efectivo"
                                                    {{ old('metodo_pago') == 'efectivo' ? 'checked' : '' }}>
                                                <label for="efectivo"
                                                    class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <div
                                                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-medium text-gray-900">Pago en efectivo</h4>
                                                            <p class="text-sm text-gray-500">Al momento de entrega</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-blue-500">
                                                            <div
                                                                class="w-3 h-3 rounded-full bg-blue-500 hidden peer-checked:block">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @error('metodo_pago')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Notas adicionales -->
                                    <div class="mb-6">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-sticky-note text-gray-400 mr-2"></i>
                                            <label for="notas" class="block text-sm font-medium text-gray-700">
                                                Notas adicionales para la entrega (opcional)
                                            </label>
                                        </div>
                                        <textarea name="notas" id="notas" rows="2"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Instrucciones especiales, horarios preferidos, información adicional...">{{ old('notas') }}</textarea>
                                    </div>

                                    <!-- Campos ocultos requeridos por el controlador -->
                                    <input type="hidden" name="telefono"
                                        value="{{ session('client_user')['telefono'] ?? '' }}">
                                    <input type="hidden" name="nombre_completo"
                                        value="{{ (session('client_user')['nombre'] ?? '') . ' ' . (session('client_user')['apellido'] ?? '') }}">
                                </form>
                            </div>
                        </div>

                        <!-- Seguridad y Garantías -->
                        <div class="bg-white rounded-lg shadow-sm border border-blue-100 p-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-3">Compra 100% segura con Global AutoParts
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-lock text-green-500 mr-2"></i>
                                            <span class="text-sm text-gray-600">Pagos seguros con SSL</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-undo text-green-500 mr-2"></i>
                                            <span class="text-sm text-gray-600">Devoluciones en 30 días</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-headset text-green-500 mr-2"></i>
                                            <span class="text-sm text-gray-600">Soporte técnico 24/7</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-award text-green-500 mr-2"></i>
                                            <span class="text-sm text-gray-600">Garantía en productos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha - Resumen del Pedido -->
                    <div class="lg:w-1/3">
                        <div class="sticky top-6">
                            <!-- Resumen del Pedido -->
                            <div class="bg-white rounded-lg shadow-md border border-blue-100 mb-6">
                                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-shopping-bag text-blue-600 mr-2"></i>
                                        Resumen del pedido
                                    </h2>
                                </div>

                                <div class="px-6 py-5">
                                    <!-- Lista de productos -->
                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-3">
                                            <h3 class="text-sm font-medium text-gray-700">Productos
                                                ({{ $resumen['cantidad_items'] ?? 0 }})</h3>
                                            <a href="{{ route('carrito.index') }}"
                                                class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                Editar <i class="fas fa-edit ml-1"></i>
                                            </a>
                                        </div>
                                        <div class="space-y-4 max-h-80 overflow-y-auto pr-2 scrollbar-thin">
                                            @foreach ($items as $item)
                                                <div
                                                    class="flex items-start space-x-3 group hover:bg-blue-50 p-2 rounded-lg transition-colors">
                                                    <div
                                                        class="flex-shrink-0 w-16 h-16 bg-blue-50 rounded-lg border border-blue-100 flex items-center justify-center">
                                                        @if (isset($item['imagen']) && !empty($item['imagen']))
                                                            <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}"
                                                                class="w-12 h-12 object-contain">
                                                        @else
                                                            <i class="fas fa-cogs text-blue-400 text-xl"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h4
                                                            class="text-sm font-medium text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                                            {{ $item['nombre'] }}
                                                        </h4>
                                                        @if (isset($item['marca']) && !empty($item['marca']))
                                                            <p class="text-xs text-blue-600 font-medium">
                                                                {{ $item['marca'] }}</p>
                                                        @endif
                                                        <div class="flex items-center justify-between mt-1">
                                                            <span class="text-xs text-gray-500">
                                                                {{ $item['cantidad'] }} ×
                                                                ${{ number_format($item['precio'], 2) }}
                                                            </span>
                                                            <span class="text-sm font-semibold text-gray-900">
                                                                ${{ number_format($item['subtotal'], 2) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Desglose de precios -->
                                    <div class="space-y-3 border-t border-gray-200 pt-4">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span
                                                class="font-medium text-gray-900">${{ number_format($resumen['subtotal'] ?? 0, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Envío</span>
                                            <span class="font-medium text-green-600">Gratis</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Impuestos (16%)</span>
                                            <span
                                                class="font-medium text-gray-900">${{ number_format($resumen['impuestos'] ?? 0, 2) }}</span>
                                        </div>

                                        <div class="border-t border-gray-200 pt-3 mt-3">
                                            <div class="flex justify-between text-lg font-bold">
                                                <span class="text-gray-900">Total</span>
                                                <span class="text-blue-600">
                                                    ${{ number_format($resumen['total'] ?? 0, 2) }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                IVA incluido • Envío gratuito
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Botón de pago desktop -->
                                    <div class="mt-6 hidden lg:block">
                                        <button type="submit" form="checkoutForm" id="desktopConfirmBtn"
                                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-lg font-semibold text-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0">
                                            <div class="flex items-center justify-center">
                                                <i class="fas fa-lock mr-3"></i>
                                                <span>Realizar pago seguro</span>
                                            </div>
                                            <div class="text-sm mt-1 opacity-90">
                                                ${{ number_format($resumen['total'] ?? 0, 2) }}
                                            </div>
                                        </button>

                                        <p class="text-xs text-center text-gray-500 mt-3">
                                            <i class="fas fa-shield-alt mr-1"></i>
                                            Tu información está protegida y encriptada
                                        </p>
                                    </div>

                                    <!-- Políticas -->
                                    <div class="mt-4 text-xs text-gray-500 text-center">
                                        Al completar tu compra, aceptas nuestros
                                        <a href="#" class="text-blue-600 hover:underline">Términos y Condiciones</a>
                                        y la
                                        <a href="#" class="text-blue-600 hover:underline">Política de
                                            Privacidad</a>.
                                    </div>
                                </div>
                            </div>

                            <!-- Protección de Compra -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-award text-blue-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-blue-900 mb-1">Protección Global AutoParts</h4>
                                        <p class="text-sm text-blue-700">
                                            Garantía de satisfacción y soporte post-venta incluido en todas tus compras.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de pago móvil -->
                <div class="lg:hidden bg-white border-t border-blue-100 fixed bottom-0 left-0 right-0 p-4 shadow-lg z-50">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-sm font-medium text-gray-700">Total a pagar:</div>
                        <div class="text-lg font-bold text-blue-600">${{ number_format($resumen['total'] ?? 0, 2) }}</div>
                    </div>
                    <button type="submit" form="checkoutForm" id="mobileConfirmBtn"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-lg font-semibold shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-lock mr-3"></i>
                            <span>Pagar ahora</span>
                        </div>
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Actualizar contador de caracteres para dirección
            const addressTextarea = document.getElementById('direccion_envio');
            const charCount = document.getElementById('charCount');

            function updateCharCount() {
                const length = addressTextarea.value.length;
                const minLength = 15;
                charCount.textContent = `${length} caracteres`;

                if (length < minLength) {
                    charCount.className = 'text-red-500 font-normal';
                    charCount.innerHTML = `${length} caracteres (mínimo ${minLength})`;
                } else if (length < 30) {
                    charCount.className = 'text-yellow-500 font-normal';
                    charCount.innerHTML = `${length} caracteres (corto)`;
                } else {
                    charCount.className = 'text-green-500 font-normal';
                    charCount.innerHTML = `${length} caracteres ✓`;
                }
            }

            addressTextarea.addEventListener('input', updateCharCount);
            updateCharCount();

            // Función para usar dirección guardada
            window.usarDireccionGuardada = function() {
                const savedAddress = '{{ session('client_user')['direccion'] ?? '' }}';
                if (savedAddress) {
                    addressTextarea.value = savedAddress;
                    updateCharCount();

                    // Efecto visual
                    addressTextarea.classList.add('bg-blue-50', 'border-blue-300');
                    setTimeout(() => {
                        addressTextarea.classList.remove('bg-blue-50', 'border-blue-300');
                    }, 1500);

                    showToast('Dirección guardada aplicada', 'success');
                }
            };

            // Validación y envío del formulario
            const form = document.getElementById('checkoutForm');
            const confirmBtns = document.querySelectorAll('#mobileConfirmBtn, #desktopConfirmBtn');
            let isProcessing = false;

            form.addEventListener('submit', function(e) {
                if (isProcessing) {
                    e.preventDefault();
                    return;
                }

                // Validar dirección
                const address = addressTextarea.value.trim();
                const minAddressLength = 15;

                if (address.length < minAddressLength) {
                    e.preventDefault();
                    showToast(`La dirección debe tener al menos ${minAddressLength} caracteres`, 'error');
                    addressTextarea.focus();
                    addressTextarea.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                    return;
                }

                // Validar método de pago
                const selectedPayment = document.querySelector('input[name="metodo_pago"]:checked');
                if (!selectedPayment) {
                    e.preventDefault();
                    showToast('Por favor, selecciona un método de pago', 'error');
                    return;
                }

                // Mostrar loading state
                isProcessing = true;
                confirmBtns.forEach(btn => {
                    btn.disabled = true;
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = `
                    <div class="flex items-center justify-center">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                        <span>Procesando pago...</span>
                    </div>
                `;
                    btn.dataset.originalHTML = originalHTML;

                    // Agregar clase de processing
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                });

                // Agregar efecto de carga al formulario
                form.classList.add('opacity-50', 'pointer-events-none');

                // Agregar delay mínimo para mostrar el loading
                setTimeout(() => {
                    // Esto permite que el formulario se envíe naturalmente
                }, 500);
            });

            // Notificaciones Toast
            function showToast(message, type = 'info') {
                // Remover toast existente
                const existingToast = document.querySelector('.global-toast');
                if (existingToast) {
                    existingToast.remove();
                }

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

                // Animación de entrada
                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-full');
                });

                // Auto-remover después de 4 segundos
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentNode) {
                            document.body.removeChild(toast);
                        }
                    }, 300);
                }, 4000);

                // Cerrar al hacer click
                toast.addEventListener('click', function() {
                    this.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (this.parentNode) {
                            document.body.removeChild(this);
                        }
                    }, 300);
                });
            }

            // Validar método de pago en tiempo real
            const paymentMethods = document.querySelectorAll('input[name="metodo_pago"]');
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    // Remover todas las clases de error
                    document.querySelectorAll('.payment-option').forEach(option => {
                        option.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                    });

                    // Agregar clase de selección
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    label.parentElement.classList.add('payment-selected');
                });
            });

            // Validar formulario al perder foco en dirección
            addressTextarea.addEventListener('blur', function() {
                const length = this.value.trim().length;
                const minLength = 15;

                if (length > 0 && length < minLength) {
                    this.classList.add('border-red-500', 'ring-1', 'ring-red-200');
                    showToast(`La dirección es muy corta (mínimo ${minLength} caracteres)`, 'error');
                } else if (length >= minLength) {
                    this.classList.remove('border-red-500', 'ring-red-200');
                    this.classList.add('border-green-500');
                    setTimeout(() => {
                        this.classList.remove('border-green-500');
                    }, 1000);
                }
            });

            // Scroll suave para errores
            const errorElements = document.querySelectorAll('.text-red-600, .border-red-500');
            if (errorElements.length > 0) {
                errorElements[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            // Efecto hover para productos
            const productItems = document.querySelectorAll('.group');
            productItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.classList.add('transform', 'scale-[1.01]', 'transition-transform',
                        'duration-200');
                });

                item.addEventListener('mouseleave', function() {
                    this.classList.remove('transform', 'scale-[1.01]');
                });
            });
        });
    </script>

    <style>
        /* Estilos personalizados */
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #93c5fd #f1f1f1;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #60a5fa;
        }

        /* Animación de selección de pago */
        .payment-selected {
            position: relative;
        }

        .payment-selected::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 8px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            animation: pulse-blue 2s infinite;
            pointer-events: none;
        }

        @keyframes pulse-blue {
            0% {
                opacity: 0.7;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(1.02);
            }

            100% {
                opacity: 0.7;
                transform: scale(1);
            }
        }

        /* Estilos para el textarea con contador */
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Estilos para botones deshabilitados */
        button:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Efecto de elevación para cards */
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Animación de spinner */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Estilos para el toast */
        .global-toast {
            z-index: 9999;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            cursor: pointer;
        }

        .global-toast:hover {
            opacity: 0.9;
        }

        /* Estilos para inputs con error */
        .border-red-500:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Gradiente azul para Global AutoParts */
        .bg-gradient-blue {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
    </style>
@endsection
