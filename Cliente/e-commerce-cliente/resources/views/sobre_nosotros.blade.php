@extends('layouts.app')

@section('title', 'Sobre Nosotros | Global AutoParts')

@section('content')
    <div class="relative bg-gradient-to-r from-blue-900 to-blue-700 py-20 -mt-6 -mx-4 sm:-mx-6 lg:-mx-8">
        <div class="absolute inset-0 opacity-20 pattern-grid-lg text-white"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Impulsando tu camino
            </h1>
            <p class="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto">
                En Global AutoParts, no solo vendemos refacciones; garantizamos la seguridad y el rendimiento de tu vehículo
                con el mejor equipo de expertos.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-10 mb-20 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div
                class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-blue-600 transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-100 rounded-full text-blue-700 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Nuestra Misión</h2>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    Proveer refacciones automotrices de la más alta calidad, ofreciendo soluciones confiables y accesibles
                    para mantener cada vehículo en su mejor estado. Nos comprometemos a brindar una experiencia de compra
                    ágil, segura y respaldada por conocimiento técnico experto.
                </p>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-blue-400 transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-100 rounded-full text-blue-700 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Nuestra Visión</h2>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    Ser el referente líder en comercio electrónico de autopartes en la región, reconocidos por nuestra
                    innovación tecnológica, catálogo integral y un servicio al cliente que supera expectativas,
                    convirtiéndonos en el copiloto de confianza de cada conductor.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Conoce a nuestro Equipo</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded"></div>
                <p class="text-gray-600 mt-4">El talento humano detrás de cada refacción.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">

                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <div class="h-64 overflow-hidden relative bg-gray-200">
                        <img src="{{ asset('images/nadya.jpeg') }}" alt="Nadya Muñoz Madriz"
                            class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900">Nadya Muñoz Madriz</h3>
                        <p class="text-blue-600 font-medium mb-3">Dirección General</p>
                        <p class="text-sm text-gray-500">
                            Liderando la estrategia comercial y asegurando que Global AutoParts cumpla con los más altos
                            estándares de calidad.
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <div class="h-64 overflow-hidden relative bg-gray-200">
                        <img src="{{ asset('images/itan.jpeg') }}" alt="Itan Ramirez Miramontes"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900">Itan Ramirez Miramontes</h3>
                        <p class="text-blue-600 font-medium mb-3">Especialista Técnico</p>
                        <p class="text-sm text-gray-500">
                            Encargado de la curaduría del catálogo y validación técnica de componentes de motor y sistemas
                            eléctricos.
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <div class="h-64 overflow-hidden relative bg-gray-100 flex items-center justify-center">
                        <img src="{{ asset('images/joshua.jpeg') }}" alt="Joshua Gonzalez"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900">Joshua Gonzalez</h3>
                        <p class="text-blue-600 font-medium mb-3">Logística y Operaciones</p>
                        <p class="text-sm text-gray-500">
                            Optimiza la cadena de suministro para asegurar que tus refacciones lleguen a tiempo a cualquier
                            destino.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
