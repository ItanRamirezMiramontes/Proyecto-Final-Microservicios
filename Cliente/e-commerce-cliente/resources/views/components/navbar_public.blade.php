{{-- 
  Navbar profesional para Global AutoParts
  Branding: Azules corporativos, diseño premium, elementos que inspiran confianza
--}}
<nav class="bg-gradient-to-r from-blue-900 to-blue-800 shadow-xl" x-data="{ open: false, searchOpen: false }">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        {{-- Contenedor principal del navbar --}}
        <div class="relative flex items-center justify-between h-20">

            {{-- Sección Izquierda: Logo y Navegación --}}
            <div class="flex items-center flex-1">
                {{-- Logo Premium --}}
                <a class="flex-shrink-0 flex items-center text-2xl font-bold text-white group" href="{{ url('/') }}">
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
                </a>

                {{-- Navegación Desktop --}}
                <div class="hidden lg:block ml-12">
                    <div class="flex items-baseline space-x-1">
                        <a class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('welcome')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}"
                            href="{{ url('/') }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Welcome
                        </a>
                        <a class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('tienda')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}"
                            href="{{ route('tienda') }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Tienda
                        </a>
                        <a class="flex items-center px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300
                                {{ request()->routeIs('sobre.nosotros')
                                    ? 'bg-white text-blue-800 shadow-lg'
                                    : 'text-blue-100 hover:bg-blue-700 hover:text-white hover:shadow-md' }}"
                            href="{{ route('sobre.nosotros') }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sobre Nosotros
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sección Derecha: Acciones de Usuario --}}
            <div class="flex items-center space-x-4">
                {{-- Botón Búsqueda Móvil --}}
                <button @click="searchOpen = !searchOpen" class="lg:hidden text-blue-100 hover:text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                {{-- Botones Login/Registro Desktop --}}
                <div class="hidden lg:flex items-center space-x-3">
                    <a class="flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-blue-100 hover:bg-blue-700 hover:text-white transition-all duration-300"
                        href="{{ route('client.login') }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Iniciar Sesión
                    </a>
                    <a class="flex items-center px-6 py-3 rounded-full text-sm font-semibold bg-white text-blue-800 hover:bg-blue-50 hover:shadow-lg transition-all duration-300 shadow-md"
                        href="{{ route('client.register') }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Registrarse
                    </a>
                </div>

                {{-- Botón Menú Móvil --}}
                <div class="lg:hidden">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center justify-center p-3 rounded-lg text-blue-100 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300"
                        aria-controls="navbarMain" aria-expanded="false">
                        <span class="sr-only">Abrir menú principal</span>
                        <svg :class="{ 'hidden': open, 'block': !open }" class="h-6 w-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg :class="{ 'block': open, 'hidden': !open }" class="h-6 w-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Búsqueda Móvil --}}
        <div x-show="searchOpen" @click.away="searchOpen = false" class="lg:hidden pb-4 px-2">
            <form action="{{ route('tienda') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" placeholder="Buscar autopartes..."
                        class="w-full pl-10 pr-4 py-3 rounded-full border-0 bg-white/10 text-white placeholder-blue-200 focus:bg-white focus:text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Menú Móvil --}}
    <div x-show="open" @click.away="open = false" class="lg:hidden bg-blue-800 shadow-xl" id="navbarMain">
        <div class="px-2 pt-2 pb-4 space-y-2">
            <a class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('welcome')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}"
                href="{{ url('/') }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Welcome
            </a>
            <a class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('tienda')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}"
                href="{{ route('tienda') }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Tienda
            </a>
            <a class="flex items-center px-4 py-3 rounded-lg text-base font-semibold transition-all duration-300
                    {{ request()->routeIs('sobre.nosotros')
                        ? 'bg-white text-blue-800 shadow-lg'
                        : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}"
                href="{{ route('sobre.nosotros') }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Sobre Nosotros
            </a>
        </div>

        {{-- Sección de Autenticación Móvil --}}
        <div class="pt-4 pb-4 border-t border-blue-700">
            <div class="px-2 space-y-2">
                <a class="flex items-center justify-center px-4 py-3 rounded-lg text-base font-semibold text-blue-100 hover:bg-blue-700 hover:text-white transition-all duration-300"
                    href="{{ route('client.login') }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Iniciar Sesión
                </a>
                <a class="flex items-center justify-center px-4 py-3 rounded-full text-base font-semibold bg-white text-blue-800 hover:bg-blue-50 transition-all duration-300 shadow-md"
                    href="{{ route('client.register') }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Registrarse
                </a>
            </div>
        </div>
    </div>
</nav>
