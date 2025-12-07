<nav class="bg-gradient-to-r from-blue-900 to-blue-800 shadow-2xl" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-20 items-center justify-between">

            {{-- Sección Izquierda: Logo y Navegación --}}
            <div class="flex flex-1 items-center">
                {{-- Logo Premium --}}
                <a class="flex-shrink-0 flex items-center text-2xl font-bold text-white group"
                    href="{{ route('dashboard') }}">
                    <div class="relative">
                        <div
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-blue-700" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                            </svg>
                        </div>
                    </div>
                    <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                        Global AutoParts
                    </span>
                    <span
                        class="ml-3 px-2 py-1 bg-yellow-500 text-blue-900 text-xs font-bold rounded-full uppercase tracking-wide">
                        Admin
                    </span>
                </a>

                {{-- Navegación Desktop --}}
                <div class="hidden lg:block ml-12">
                    <div class="flex items-baseline space-x-1">
                        {{-- Tablero --}}
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('dashboard')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Tablero
                        </a>

                        {{-- Usuarios --}}
                        <a href="{{ route('usuarios.index') }}"
                            class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('usuarios.*')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            Usuarios
                        </a>

                        {{-- Productos --}}
                        <a href="{{ route('productos.index') }}"
                            class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('productos.*')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Productos
                        </a>

                        {{-- Categorías --}}
                        <a href="{{ route('categorias.index') }}"
                            class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('categorias.*')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Categorías
                        </a>

                        {{-- Marcas --}}
                        <a href="{{ route('marcas.index') }}"
                            class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('marcas.*')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 4H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2z" />
                            </svg>
                            Marcas
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sección Derecha: Información del Usuario --}}
            <div class="flex items-center space-x-4">
                @if (session('user'))
                    {{-- Dropdown Usuario Desktop --}}
                    <div class="hidden lg:block relative">
                        <button @click="userDropdownOpen = !userDropdownOpen"
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr(session('user')['nombre'], 0, 1)) }}
                                </span>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-semibold">{{ session('user')['nombre'] }}
                                    {{ session('user')['apellido'] }}</div>
                                <div class="text-xs text-blue-200">Administrador</div>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-300"
                                :class="{ 'rotate-180': userDropdownOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="userDropdownOpen" @click.away="userDropdownOpen = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50 border border-blue-100">
                            <div class="px-4 py-2 border-b border-blue-50">
                                <div class="text-sm font-medium text-gray-900">{{ session('user')['nombre'] }}
                                    {{ session('user')['apellido'] }}</div>
                                <div class="text-xs text-gray-500">{{ session('user')['email'] }}</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Botón Logout Móvil --}}
                    <div class="lg:hidden">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center px-3 py-2 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Botón Login si no hay usuario --}}
                    <a href="{{ route('login') }}"
                        class="flex items-center px-4 py-2 rounded-lg bg-white text-blue-700 hover:bg-blue-50 font-semibold transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Iniciar Sesión
                    </a>
                @endif

                {{-- Botón Menú Móvil --}}
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="inline-flex items-center justify-center p-3 rounded-lg text-blue-100 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Abrir menú principal</span>
                        <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="h-6 w-6"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="h-6 w-6"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Menú Móvil --}}
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="lg:hidden bg-blue-800 shadow-2xl"
        id="mobile-menu">
        {{-- Información Usuario Móvil --}}
        @if (session('user'))
            <div class="px-4 py-3 border-b border-blue-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">
                            {{ strtoupper(substr(session('user')['nombre'], 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-white font-semibold">{{ session('user')['nombre'] }}
                            {{ session('user')['apellido'] }}</div>
                        <div class="text-blue-200 text-sm">Administrador</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Navegación Móvil --}}
        <div class="px-2 pt-4 pb-6 space-y-2">
            {{-- Tablero --}}
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('dashboard')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Tablero
            </a>

            {{-- Usuarios --}}
            <a href="{{ route('usuarios.index') }}"
                class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('usuarios.*')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
                Usuarios
            </a>

            {{-- Productos --}}
            <a href="{{ route('productos.index') }}"
                class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('productos.*')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Productos
            </a>

            {{-- Categorías --}}
            <a href="{{ route('categorias.index') }}"
                class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('categorias.*')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Categorías
            </a>

            {{-- Marcas --}}
            <a href="{{ route('marcas.index') }}"
                class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('marcas.*')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 4H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2z" />
                </svg>
                Marcas
            </a>
        </div>
    </div>
</nav>
