<nav class="bg-gradient-to-r from-blue-900 to-blue-800 shadow-xl sticky top-0 z-50" id="mainNavbar">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-20">
            {{-- Sección Izquierda: Logo y Navegación --}}
            <div class="flex items-center flex-1">
                {{-- Logo Premium --}}
                <a class="flex-shrink-0 flex items-center text-2xl font-bold text-white group"
                    href="{{ route('welcome') }}">
                    <div class="relative">
                        <div
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                            </svg>
                        </div>
                    </div>
                    <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent hidden sm:block">
                        Global AutoParts
                    </span>
                </a>

                {{-- Navegación Desktop --}}
                <div class="hidden lg:block ml-12">
                    <div class="flex items-baseline space-x-1">
                        <a href="{{ route('welcome') }}"
                            class="px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300 flex items-center
                           {{ request()->routeIs('welcome') ? 'bg-white/10 text-white shadow-lg backdrop-blur-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                            Inicio
                        </a>
                        <a href="{{ route('tienda') }}"
                            class="px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300 flex items-center
                           {{ request()->routeIs('tienda') ? 'bg-white/10 text-white shadow-lg backdrop-blur-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                            Tienda
                        </a>
                        <a href="{{ route('sobre.nosotros') }}"
                            class="px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300 flex items-center
                           {{ request()->routeIs('sobre.nosotros') ? 'bg-white/10 text-white shadow-lg backdrop-blur-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                            Nosotros
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sección Derecha: Carrito y Usuario --}}
            <div class="flex items-center space-x-6">
                {{-- Botón Carrito con Dropdown --}}
                <div class="relative" id="cartContainer">
                    <button id="cartButton" class="relative group p-2 text-blue-100 hover:text-white transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-white/10 transition-colors relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            {{-- Badge del Contador --}}
                            <span id="cartBadge"
                                class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-6 h-6 px-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full shadow-md border-2 border-blue-900 hidden">
                                0
                            </span>
                        </div>
                        <span class="sr-only">Carrito de compras</span>
                    </button>

                    {{-- Dropdown del Carrito - Estilo Amazon --}}
                    <div id="cartDropdown"
                        class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50 hidden">
                        {{-- Header del Carrito --}}
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Mi Carrito
                                </h3>
                                <span id="cartItemCount" class="text-sm bg-white/20 px-2 py-1 rounded-full">0
                                    items</span>
                            </div>
                        </div>

                        {{-- Contenido del Carrito --}}
                        <div class="max-h-96 overflow-y-auto">
                            {{-- Loading State --}}
                            <div id="cartLoading" class="p-8 text-center hidden">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600">
                                </div>
                                <p class="mt-2 text-gray-600">Cargando carrito...</p>
                            </div>

                            {{-- Empty State --}}
                            <div id="cartEmpty" class="p-8 text-center hidden">
                                <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Tu carrito está vacío</p>
                                <p class="text-gray-400 text-sm mt-1">Agrega productos para comenzar</p>
                                <a href="{{ route('tienda') }}"
                                    class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                    Ver Tienda
                                </a>
                            </div>

                            {{-- Cart Items --}}
                            <div id="cartItemsContainer" class="hidden"></div>
                        </div>

                        {{-- Resumen del Carrito --}}
                        <div id="cartSummary" class="border-t border-gray-200 bg-gray-50 p-4 hidden">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-600">Subtotal:</span>
                                <span id="cartSubtotal" class="text-lg font-bold text-gray-900">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-600">IVA (16%):</span>
                                <span id="cartTax" class="text-gray-900">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-bold text-gray-900">Total:</span>
                                <span id="cartTotal" class="text-xl font-bold text-blue-700">$0.00</span>
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="space-y-2">
                                <a href="{{ route('carrito.index') }}"
                                    class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                                    Ver Carrito Completo
                                </a>
                                <a href="{{ route('checkout.index') }}"
                                    class="block w-full bg-gradient-to-r from-blue-800 to-blue-900 hover:from-blue-900 hover:to-blue-950 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                                    Proceder al Pago
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Menú de Usuario --}}
                @if (session('client_user') || auth()->check())
                    <div class="relative">
                        <button id="userButton"
                            class="flex items-center max-w-xs text-sm rounded-full focus:outline-none transition-all">
                            <span class="sr-only">Abrir menú usuario</span>
                            <div
                                class="h-9 w-9 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-md border-2 border-blue-400">
                                {{ substr(session('client_user')['nombre'] ?? (auth()->user()->name ?? 'U'), 0, 1) }}
                            </div>
                        </button>

                        {{-- Dropdown del Usuario --}}
                        <div id="userDropdown"
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg py-2 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900 truncate">
                                    {{ session('client_user')['nombre'] ?? (auth()->user()->name ?? 'Usuario') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1 truncate">
                                    {{ session('client_user')['email'] ?? (auth()->user()->email ?? '') }}
                                </p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('pedido.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Mis Pedidos
                                </a>
                                <a href="{{ route('carrito.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Mi Carrito
                                    <span id="userCartBadge"
                                        class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full hidden">
                                        0
                                    </span>
                                </a>
                                <a href="{{ route('client.profile') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mi Perfil
                                </a>
                            </div>

                            <div class="border-t border-gray-100">
                                <form method="POST" action="{{ route('client.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Botones Visitante --}}
                    <div class="hidden lg:flex items-center space-x-4">
                        <a href="{{ route('client.login') }}"
                            class="text-white hover:text-blue-200 text-sm font-semibold transition-colors">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('client.register') }}"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-5 py-2 rounded-full text-sm font-bold shadow-md transition-all transform hover:scale-105">
                            Registrarse
                        </a>
                    </div>
                @endif

                {{-- Botón Menú Móvil --}}
                <div class="flex lg:hidden">
                    <button id="mobileMenuButton" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-white/10 focus:outline-none">
                        <span class="sr-only">Abrir menú</span>
                        <svg id="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="mobileMenuClose" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Menú Móvil --}}
    <div id="mobileMenu"
        class="lg:hidden bg-gradient-to-b from-blue-900 to-blue-800 border-t border-blue-700 shadow-inner hidden">
        <div class="px-4 pt-3 pb-5 space-y-1">
            <a href="{{ route('welcome') }}"
                class="flex items-center text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Inicio
            </a>
            <a href="{{ route('tienda') }}"
                class="flex items-center text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Tienda
            </a>
            <a href="{{ route('sobre.nosotros') }}"
                class="flex items-center text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Nosotros
            </a>

            @if (session('client_user') || auth()->check())
                <a href="{{ route('carrito.index') }}"
                    class="flex items-center text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Mi Carrito
                    <span id="mobileCartBadge"
                        class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full hidden">
                        0
                    </span>
                </a>
                <a href="{{ route('pedido.index') }}"
                    class="flex items-center text-white hover:bg-blue-700 px-3 py-3 rounded-lg text-base font-medium transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Mis Pedidos
                </a>
            @endif
        </div>

        @if (!session('client_user') && !auth()->check())
            <div class="px-4 pt-4 pb-5 border-t border-blue-700">
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('client.login') }}"
                        class="text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('client.register') }}"
                        class="text-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-lg transition">
                        Registrarse
                    </a>
                </div>
            </div>
        @endif
    </div>
</nav>

<script>
    // Gestor del Carrito para Global AutoParts
    const GlobalAutoParts = {
        cartCount: 0,
        cartItems: [],
        cartDropdownVisible: false,

        // Formatear precio
        formatPrice: function(price) {
            if (!price) return '0.00';
            return parseFloat(price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        // Actualizar contador del carrito
        updateCartCount: function(count) {
            this.cartCount = count;

            // Actualizar todos los badges
            const badges = [
                document.getElementById('cartBadge'),
                document.getElementById('userCartBadge'),
                document.getElementById('mobileCartBadge')
            ];

            badges.forEach(badge => {
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count > 99 ? '99+' : count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            });

            // Actualizar contador en el dropdown
            const cartItemCount = document.getElementById('cartItemCount');
            if (cartItemCount) {
                cartItemCount.textContent = count > 0 ? `${count} items` : '0 items';
            }
        },

        // Cargar carrito desde API
        loadCartItems: async function() {
            const loading = document.getElementById('cartLoading');
            const empty = document.getElementById('cartEmpty');
            const itemsContainer = document.getElementById('cartItemsContainer');
            const summary = document.getElementById('cartSummary');

            // Mostrar loading
            if (loading) loading.classList.remove('hidden');
            if (empty) empty.classList.add('hidden');
            if (itemsContainer) itemsContainer.classList.add('hidden');
            if (summary) summary.classList.add('hidden');

            try {
                // Verificar si el usuario está autenticado
                const isAuthenticated = {{ session('client_token') ? 'true' : 'false' }};
                if (!isAuthenticated) {
                    if (empty) {
                        empty.innerHTML = `
                            <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">Inicia sesión para ver tu carrito</p>
                            <a href="{{ route('client.login') }}"
                                class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                Iniciar Sesión
                            </a>
                        `;
                        empty.classList.remove('hidden');
                    }
                    this.updateCartCount(0);
                    return;
                }

                // Obtener token de sesión
                const token = '{{ session('client_token') }}';
                if (!token) {
                    throw new Error('No autenticado');
                }

                // Llamar a la API del carrito
                const apiUrl = '{{ env('API_BASE_URL', 'http://localhost:8000/api') }}/carrito';
                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.success) {
                        const carritoData = data.data;
                        this.cartItems = carritoData.items || [];

                        // Actualizar contador
                        const cantidadTotal = carritoData.resumen?.cantidad_items || 0;
                        this.updateCartCount(cantidadTotal);

                        // Renderizar items si hay productos
                        if (this.cartItems.length > 0) {
                            this.renderCartItems(carritoData);
                            if (itemsContainer) itemsContainer.classList.remove('hidden');
                            if (summary) {
                                this.updateCartSummary(carritoData.resumen);
                                summary.classList.remove('hidden');
                            }
                            if (empty) empty.classList.add('hidden');
                        } else {
                            if (empty) empty.classList.remove('hidden');
                            if (itemsContainer) itemsContainer.classList.add('hidden');
                            if (summary) summary.classList.add('hidden');
                        }
                    } else {
                        throw new Error(data.message || 'Error al cargar el carrito');
                    }
                } else {
                    // Si hay error 401, limpiar contador
                    if (response.status === 401) {
                        this.updateCartCount(0);
                        if (empty) empty.classList.remove('hidden');
                    } else {
                        throw new Error('Error en la respuesta del servidor');
                    }
                }
            } catch (error) {
                console.error('Error cargando carrito:', error);
                if (empty) empty.classList.remove('hidden');
                this.updateCartCount(0);
            } finally {
                if (loading) loading.classList.add('hidden');
            }
        },

        // Renderizar items del carrito
        renderCartItems: function(carritoData) {
            const container = document.getElementById('cartItemsContainer');
            if (!container || !carritoData || !carritoData.items) return;

            container.innerHTML = '';

            carritoData.items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className =
                    'p-4 hover:bg-gray-50 transition border-b border-gray-100 last:border-b-0';

                // Formatear precio
                const precioUnitario = item.precio || item.producto?.precio || 0;
                const subtotal = precioUnitario * (item.cantidad || 1);

                itemElement.innerHTML = `
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0">
                            ${item.producto?.imagen ? 
                                `<img src="${item.producto.imagen}" alt="${item.nombre}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">` :
                                `<div class="w-20 h-20 bg-blue-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-box text-blue-400 text-xl"></i>
                                </div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 truncate">${item.nombre || item.producto?.nombre || 'Producto'}</h4>
                            <div class="flex items-center mt-1">
                                <span class="text-sm text-gray-500">Cantidad: ${item.cantidad || 1}</span>
                                <span class="mx-2 text-gray-300">•</span>
                                <span class="text-sm text-gray-500">$${this.formatPrice(precioUnitario)} c/u</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-lg font-bold text-blue-600">$${this.formatPrice(subtotal)}</span>
                                <button onclick="GlobalAutoParts.removeFromCart(${item.id})" 
                                        class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors">
                                    <i class="fas fa-trash mr-1"></i>
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(itemElement);
            });
        },

        // Actualizar resumen del carrito
        updateCartSummary: function(resumen) {
            if (!resumen) return;

            if (document.getElementById('cartSubtotal')) {
                document.getElementById('cartSubtotal').textContent =
                    `$${this.formatPrice(resumen.subtotal || 0)}`;
            }
            if (document.getElementById('cartTax')) {
                document.getElementById('cartTax').textContent = `$${this.formatPrice(resumen.impuestos || 0)}`;
            }
            if (document.getElementById('cartTotal')) {
                document.getElementById('cartTotal').textContent = `$${this.formatPrice(resumen.total || 0)}`;
            }
        },

        // Eliminar item del carrito
        removeFromCart: async function(itemId) {
            if (!confirm('¿Eliminar este producto del carrito?')) return;

            try {
                const token = '{{ session('client_token') }}';
                const apiUrl = `{{ env('API_BASE_URL', 'http://localhost:8000/api') }}/carrito/${itemId}`;

                const response = await fetch(apiUrl, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Recargar items del carrito
                    await this.loadCartItems();

                    // Mostrar notificación
                    this.showNotification('Producto eliminado del carrito', 'success');

                    // Disparar evento de actualización
                    this.dispatchCartUpdate(data.data?.cantidad_total || 0);
                } else {
                    this.showNotification(data.message || 'Error al eliminar', 'error');
                }
            } catch (error) {
                console.error('Error eliminando del carrito:', error);
                this.showNotification('Error de conexión', 'error');
            }
        },

        // Disparar evento de actualización del carrito
        dispatchCartUpdate: function(newCount) {
            const event = new CustomEvent('cart-updated', {
                detail: {
                    count: newCount
                }
            });
            window.dispatchEvent(event);
        },

        // Mostrar notificación
        showNotification: function(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-[100] px-4 py-3 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        ${type === 'success' ? 
                            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>' :
                          type === 'error' ?
                            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>' :
                            '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0                        '}</svg>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" 
                            class="ml-4 text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto-remover después de 3 segundos
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }
    };

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar carrito inicial
        GlobalAutoParts.loadCartItems();

        // Manejar clic en el botón del carrito
        const cartButton = document.getElementById('cartButton');
        const cartDropdown = document.getElementById('cartDropdown');
        const cartContainer = document.getElementById('cartContainer');

        if (cartButton && cartDropdown) {
            cartButton.addEventListener('click', function(e) {
                e.stopPropagation();
                GlobalAutoParts.cartDropdownVisible = !GlobalAutoParts.cartDropdownVisible;

                if (GlobalAutoParts.cartDropdownVisible) {
                    cartDropdown.classList.remove('hidden');
                    // Recargar items al abrir
                    GlobalAutoParts.loadCartItems();
                } else {
                    cartDropdown.classList.add('hidden');
                }
            });

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!cartContainer.contains(e.target)) {
                    GlobalAutoParts.cartDropdownVisible = false;
                    cartDropdown.classList.add('hidden');
                }
            });
        }

        // Manejar menú de usuario
        const userButton = document.getElementById('userButton');
        const userDropdown = document.getElementById('userDropdown');
        const userContainer = userButton?.closest('.relative');

        if (userButton && userDropdown) {
            let userDropdownVisible = false;

            userButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownVisible = !userDropdownVisible;
                userDropdown.classList.toggle('hidden', !userDropdownVisible);
            });

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (userContainer && !userContainer.contains(e.target)) {
                    userDropdownVisible = false;
                    userDropdown.classList.add('hidden');
                }
            });
        }

        // Manejar menú móvil
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOpen = document.getElementById('mobileMenuOpen');
        const mobileMenuClose = document.getElementById('mobileMenuClose');

        if (mobileMenuButton && mobileMenu) {
            let mobileMenuVisible = false;

            mobileMenuButton.addEventListener('click', function() {
                mobileMenuVisible = !mobileMenuVisible;
                mobileMenu.classList.toggle('hidden', !mobileMenuVisible);
                mobileMenuOpen.classList.toggle('hidden', mobileMenuVisible);
                mobileMenuClose.classList.toggle('hidden', !mobileMenuVisible);
            });

            // Cerrar menú al hacer clic en enlaces
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenuVisible = false;
                    mobileMenu.classList.add('hidden');
                    mobileMenuOpen.classList.remove('hidden');
                    mobileMenuClose.classList.add('hidden');
                });
            });

            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenuVisible = false;
                    mobileMenu.classList.add('hidden');
                    mobileMenuOpen.classList.remove('hidden');
                    mobileMenuClose.classList.add('hidden');
                }
            });
        }

        // Cerrar menús al hacer scroll
        window.addEventListener('scroll', function() {
            if (cartDropdown && !cartDropdown.classList.contains('hidden')) {
                cartDropdown.classList.add('hidden');
                GlobalAutoParts.cartDropdownVisible = false;
            }

            if (userDropdown && !userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
            }

            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuOpen.classList.remove('hidden');
                mobileMenuClose.classList.add('hidden');
            }
        });

        // Escuchar evento de actualización del carrito
        window.addEventListener('cart-updated', function(e) {
            GlobalAutoParts.updateCartCount(e.detail.count);
        });

        // Escuchar evento de agregar al carrito desde otros componentes
        window.addEventListener('add-to-cart', function() {
            // Recargar carrito después de agregar producto
            setTimeout(() => {
                GlobalAutoParts.loadCartItems();
            }, 500);
        });
    });

    // Función global para agregar al carrito (puede ser llamada desde otros componentes)
    window.addToCart = async function(productId, quantity = 1) {
        try {
            const token = '{{ session('client_token') }}';
            if (!token) {
                // Redirigir a login si no está autenticado
                window.location.href = '{{ route('client.login') }}';
                return;
            }

            const apiUrl = '{{ env('API_BASE_URL', 'http://localhost:8000/api') }}/carrito';

            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    producto_id: productId,
                    cantidad: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                GlobalAutoParts.showNotification('Producto agregado al carrito', 'success');

                // Recargar carrito
                await GlobalAutoParts.loadCartItems();

                // Mostrar dropdown del carrito
                const cartDropdown = document.getElementById('cartDropdown');
                if (cartDropdown) {
                    GlobalAutoParts.cartDropdownVisible = true;
                    cartDropdown.classList.remove('hidden');
                }

                // Disparar evento
                GlobalAutoParts.dispatchCartUpdate(data.data?.cantidad_total || 0);

                return true;
            } else {
                GlobalAutoParts.showNotification(data.message || 'Error al agregar al carrito', 'error');
                return false;
            }
        } catch (error) {
            console.error('Error agregando al carrito:', error);
            GlobalAutoParts.showNotification('Error de conexión', 'error');
            return false;
        }
    };
</script>
