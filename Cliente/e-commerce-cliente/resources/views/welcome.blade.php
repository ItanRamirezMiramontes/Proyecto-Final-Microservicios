@extends('layouts.app')

@section('title', 'Inicio - Global AutoParts | Expertos en Refacciones')

@section('content')

    <div class="relative bg-gray-900 h-[600px] flex items-center">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=2832&auto=format&fit=crop"
                alt="Taller Global AutoParts" class="w-full h-full object-cover object-center opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 via-blue-900/60 to-transparent"></div>
        </div>

        <div class="relative container mx-auto px-6 md:px-12 z-10">
            <div class="max-w-3xl">
                <div
                    class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-200 uppercase bg-blue-800/50 rounded-full border border-blue-400/30 backdrop-blur-md">
                    Envíos a todo el país 🇲🇽
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6">
                    Tu auto merece <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">
                        Ingeniería Original
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-gray-200 mb-8 leading-relaxed max-w-2xl">
                    Accede al catálogo más completo de refacciones certificadas. Desde el motor hasta los frenos,
                    garantizamos el rendimiento de tu vehículo.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href=""
                        class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-600/40 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Ver Catálogo
                    </a>
                    <a href="#ofertas"
                        class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl backdrop-blur-sm border border-white/30 transition-all flex items-center justify-center">
                        Ver Ofertas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm">Catálogo Especializado</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">Encuentra tu pieza por Sistema</h2>
                <p class="text-gray-500 text-lg">Navega a través de los componentes vitales de tu vehículo. Todo lo que
                    necesitas, organizado por ingeniería.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-6 h-[800px] md:h-[600px]">

                <a href="#"
                    class="group relative md:col-span-2 md:row-span-2 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500">
                    <img src="{{ asset('images/motorrr.jpg') }}" alt="Sistema de Motor"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity">
                    </div>

                    <div class="absolute bottom-0 left-0 p-8 w-full">
                        <div
                            class="flex items-center gap-4 mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">

                            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold text-white">Motor y Afinación</h3>
                        </div>

                        <div
                            class="h-0 overflow-hidden group-hover:h-auto transition-all duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                            <p class="text-gray-300 mb-4 mt-2 border-l-2 border-blue-500 pl-3">
                                Kits de distribución, bombas de agua, bandas, filtros, bujías y componentes internos.
                            </p>
                            <span
                                class="inline-flex items-center text-blue-300 font-semibold text-sm group-hover:text-white transition-colors">
                                Explorar categoría <svg class="w-4 h-4 ml-2 animate-pulse" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

                <a href="#"
                    class="group relative md:col-span-2 md:row-span-1 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500">
                    <img src="{{ asset('images/balatas-freno-1.jpg') }}" alt="Sistema de Frenos"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 p-8 w-full flex flex-col justify-center h-full">
                        <div class="flex items-center gap-3 mb-1">
                            <div
                                class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center text-white group-hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Frenos y Seguridad</h3>
                        </div>
                        <p
                            class="text-gray-400 text-sm translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                            Discos ventilados, balatas cerámicas, calipers y sensores ABS.
                        </p>
                    </div>
                </a>

                <a href="#"
                    class="group relative md:col-span-1 md:row-span-1 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500">
                    <img src="{{ asset('images/d2.jpg') }}" alt="Suspensión"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/50 group-hover:bg-blue-900/60 transition-colors duration-500">
                    </div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                        <svg class="w-10 h-10 text-white mb-2 opacity-80 group-hover:scale-110 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                            </path>
                        </svg>
                        <h3 class="text-xl font-bold text-white">Suspensión</h3>
                        <span
                            class="text-xs text-gray-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Amortiguadores
                            y Dirección</span>
                    </div>
                </a>

                <a href="#"
                    class="group relative md:col-span-1 md:row-span-1 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500">
                    <img src="https://images.unsplash.com/photo-1584345604476-8ec5e12e42dd?q=80&w=600&auto=format&fit=crop"
                        alt="Sistema Eléctrico"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/50 group-hover:bg-yellow-900/60 transition-colors duration-500">
                    </div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                        <svg class="w-10 h-10 text-white mb-2 opacity-80 group-hover:scale-110 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-white">Eléctrico</h3>
                        <span
                            class="text-xs text-gray-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Baterías,
                            Luces y Sensores</span>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <div id="ofertas" class="bg-gray-50 py-20">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Ofertas Relámpago ⚡</h2>
                    <p class="text-gray-600 mt-2">Precios especiales en componentes de alto rendimiento.</p>
                </div>
                <a href="#"
                    class="hidden md:flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                    Ver todo el catálogo <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-64 bg-white p-4 flex items-center justify-center overflow-hidden">
                        <span
                            class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">-15%</span>
                        <img src="{{ asset('images/kit-distribucion-2.jpg') }}" alt="Kit de Distribución"
                            class="h-full object-contain group-hover:scale-110 transition-transform duration-500">

                        <div
                            class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <button
                                class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-semibold shadow-lg hover:bg-black">Vista
                                Rápida</button>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-1">Motor y Distribución</p>
                        <h3 class="text-gray-900 font-bold text-lg leading-tight mb-2 truncate">Kit de Distribución
                            Completo
                        </h3>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-bold text-blue-700">$3,850</span>
                            <span class="text-sm text-gray-400 line-through mb-1">$4,500</span>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-green-600 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="10" />
                            </svg>
                            En Stock
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-64 bg-white p-4 flex items-center justify-center overflow-hidden">
                        <span
                            class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded z-10">Nuevo</span>
                        <img src="{{ asset('images/d2.jpg') }}" alt="Disco de Freno"
                            class="h-full object-contain group-hover:scale-110 transition-transform duration-500">

                        <div
                            class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <button
                                class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-semibold shadow-lg hover:bg-black">Vista
                                Rápida</button>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-1">Sistema de Frenos</p>
                        <h3 class="text-gray-900 font-bold text-lg leading-tight mb-2 truncate">Disco Ventilado Delantero
                        </h3>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-bold text-blue-700">$1,250</span>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-green-600 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="10" />
                            </svg>
                            Pocas unidades
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-64 bg-white p-4 flex items-center justify-center overflow-hidden">
                        <span
                            class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">-10%</span>
                        <img src="{{ asset('images/bomba-agua-1.jpg') }}"
                            onerror="this.src='https://placehold.co/400x400/png?text=Bomba+Agua'" alt="Bomba de Agua"
                            class="h-full object-contain group-hover:scale-110 transition-transform duration-500">

                        <div
                            class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <button
                                class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-semibold shadow-lg hover:bg-black">Vista
                                Rápida</button>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-1">Refrigeración</p>
                        <h3 class="text-gray-900 font-bold text-lg leading-tight mb-2 truncate">Bomba de Agua Alto Flujo
                        </h3>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-bold text-blue-700">$980</span>
                            <span class="text-sm text-gray-400 line-through mb-1">$1,100</span>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-green-600 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="10" />
                            </svg>
                            En Stock
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-64 bg-white p-4 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/balatas-freno-1.jpg') }}"
                            onerror="this.src='https://placehold.co/400x400/png?text=Balatas'" alt="Balatas Cerámicas"
                            class="h-full object-contain group-hover:scale-110 transition-transform duration-500">

                        <div
                            class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <button
                                class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-semibold shadow-lg hover:bg-black">Vista
                                Rápida</button>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-1">Frenos</p>
                        <h3 class="text-gray-900 font-bold text-lg leading-tight mb-2 truncate">Juego de Balatas Cerámicas
                        </h3>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl font-bold text-blue-700">$850</span>
                        </div>
                        <div class="mt-3 flex items-center text-xs text-orange-500 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="10" />
                            </svg>
                            Envío Gratis
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="#"
                    class="inline-block px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Ver todo el catálogo
                </a>
            </div>
        </div>
    </div>


@endsection
