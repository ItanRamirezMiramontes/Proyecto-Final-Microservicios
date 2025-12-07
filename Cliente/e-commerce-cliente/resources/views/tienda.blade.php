@extends('layouts.app')

@section('title', 'Tienda - Global AutoParts')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">



        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- ================================================
                 COLUMNA DE FILTROS (SIDEBAR)
                 ================================================ --}}
            <aside id="filtro-sidebar" class="lg:col-span-1">
                <div class="sticky top-6">
                    <div class="flex justify-between items-center mb-6 pb-2 border-b-2 border-blue-800">
                        <h3 class="text-xl font-bold text-gray-900">Filtros</h3>

                        {{-- Botón de limpiar si hay filtros activos --}}
                        @if (request()->hasAny(['categoria_id', 'marca_id', 'q', 'buscar']))
                            <a href="{{ route('tienda') }}" class="text-xs text-red-600 hover:text-red-800 underline">
                                Limpiar todo
                            </a>
                        @endif
                    </div>

                    {{-- 1. FILTRO CATEGORÍAS --}}
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-300 mb-6">
                        <div class="bg-blue-800 px-4 py-3">
                            <h5 class="font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                                Categorías
                            </h5>
                        </div>
                        <div class="flex flex-col p-3 space-y-1">
                            {{-- Enlace "Todas las categorías" (Mantiene marca y búsqueda, quita categoría) --}}
                            <a href="{{ route('tienda', request()->except(['categoria_id', 'page'])) }}"
                                class="filtro-link-js flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-200 ease-in-out
                                 {{ !request('categoria_id') ? 'bg-blue-700 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                Todas las categorías
                            </a>

                            @php $categoriasArray = is_array($categorias) ? $categorias : []; @endphp

                            @if (count($categoriasArray) > 0)
                                @foreach ($categoriasArray as $cat)
                                    @php
                                        $catId = $cat['id'];
                                        $isActive = request('categoria_id') == $catId;
                                        // Generamos la URL manteniendo otros filtros (marca, q) y agregando/cambiando categoria
                                        $url = route(
                                            'tienda',
                                            array_merge(request()->except(['page']), ['categoria_id' => $catId]),
                                        );
                                    @endphp
                                    <a href="{{ $url }}"
                                        class="filtro-link-js flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-200 ease-in-out
                                        {{ $isActive ? 'bg-blue-700 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        {{ $cat['nombre'] }}
                                    </a>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-sm p-2">Sin categorías</p>
                            @endif
                        </div>
                    </div>

                    {{-- 2. FILTRO MARCAS --}}
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-300 mb-6">
                        <div class="bg-blue-800 px-4 py-3">
                            <h5 class="font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                                Marcas
                            </h5>
                        </div>
                        <div class="flex flex-col p-3 space-y-1">
                            {{-- Enlace "Todas las marcas" (Mantiene categoría y búsqueda, quita marca) --}}
                            <a href="{{ route('tienda', request()->except(['marca_id', 'page'])) }}"
                                class="filtro-link-js flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-200 ease-in-out
                                 {{ !request('marca_id') ? 'bg-blue-700 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                Todas las marcas
                            </a>

                            @php $marcasArray = is_array($marcas) ? $marcas : []; @endphp

                            @if (count($marcasArray) > 0)
                                @foreach ($marcasArray as $marca)
                                    @php
                                        $marcaId = $marca['id'];
                                        $isActive = request('marca_id') == $marcaId;
                                        // Generamos la URL manteniendo otros filtros
                                        $url = route(
                                            'tienda',
                                            array_merge(request()->except(['page']), ['marca_id' => $marcaId]),
                                        );
                                    @endphp
                                    <a href="{{ $url }}"
                                        class="filtro-link-js flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-200 ease-in-out
                                        {{ $isActive ? 'bg-blue-700 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        {{ $marca['nombre'] }}
                                    </a>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-sm p-2">Sin marcas</p>
                            @endif
                        </div>
                    </div>

                    {{-- Banner Promocional --}}
                    <div class="bg-gradient-to-r from-blue-700 to-blue-900 rounded-lg p-4 text-white text-center shadow-lg">
                        <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <h4 class="font-bold">Envío Mundial</h4>
                        <p class="text-sm mt-1">Entregamos autopartes a cualquier lugar del mundo</p>
                    </div>
                </div>
            </aside>

            {{-- ================================================
                 COLUMNA PRINCIPAL (GRID)
                 ================================================ --}}
            <main id="main-content" class="lg:col-span-3">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-300">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">
                        @if (request('q') || request('buscar'))
                            Resultados para: "{{ request('q') ?? request('buscar') }}"
                        @else
                            Nuestros Productos
                        @endif
                    </h1>

                    {{-- Etiquetas de Filtros Activos --}}
                    @if (request('categoria_id') || request('marca_id'))
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm text-gray-600 mr-2">Filtros:</span>

                            {{-- Tag Categoría Activa --}}
                            @if (request('categoria_id') && isset($categorias))
                                @foreach ($categorias as $cat)
                                    @if ($cat['id'] == request('categoria_id'))
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">
                                            Cat: {{ $cat['nombre'] }}
                                            <a href="{{ route('tienda', request()->except(['categoria_id'])) }}"
                                                class="ml-2 text-blue-600 hover:text-blue-900 font-bold focus:outline-none">×</a>
                                        </span>
                                        @break
                                    @endif
                                @endforeach
                            @endif

                            {{-- Tag Marca Activa --}}
                            @if (request('marca_id') && isset($marcas))
                                @foreach ($marcas as $mar)
                                    @if ($mar['id'] == request('marca_id'))
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full border border-green-200">
                                            Marca: {{ $mar['nombre'] }}
                                            <a href="{{ route('tienda', request()->except(['marca_id'])) }}"
                                                class="ml-2 text-green-600 hover:text-green-900 font-bold focus:outline-none">×</a>
                                        </span>
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Mensajes Flash --}}
                @if (session('success'))
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- GRID DE PRODUCTOS --}}
                <div id="grid-productos" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @php $productosArray = is_array($productos) ? $productos : []; @endphp

                    @if (count($productosArray) > 0)
                        @foreach ($productosArray as $producto)
                            @php
                                $id = $producto['id'] ?? 0;
                                $nombre = $producto['nombre'] ?? 'Sin nombre';
                                $desc = $producto['descripcion'] ?? '';
                                $precio = $producto['precio'] ?? 0;
                                $stock = $producto['stock'] ?? 0;
                                $catNombre = $producto['categoria_nombre'] ?? 'General';
                                $marNombre = $producto['marca_nombre'] ?? '';
                                $img = $producto['imagen_1_url'] ?? null;
                            @endphp

                            {{-- Tarjeta de Producto --}}
                            <div class="producto-item-js transition-all duration-300 ease-in-out border border-transparent rounded-lg cursor-pointer h-full"
                                onclick="window.location='{{ route('producto.detalle', $id) }}'">

                                <div
                                    class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-300 h-full flex flex-col">
                                    {{-- Área de Imagen --}}
                                    <div
                                        class="relative h-48 bg-gray-50 overflow-hidden flex items-center justify-center group">
                                        @if ($img)
                                            <img src="{{ $img }}" alt="{{ $nombre }}"
                                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                onerror="this.src='https://placehold.co/300x300/EBF8FF/3182CE?text={{ urlencode($nombre) }}'">
                                        @else
                                            <div class="text-gray-400 flex flex-col items-center">
                                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs">Sin imagen</span>
                                            </div>
                                        @endif

                                        {{-- Badge Stock --}}
                                        <div class="absolute top-2 right-2">
                                            @if ($stock == 0)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full shadow-sm">Agotado</span>
                                            @elseif($stock <= 5)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-bold text-gray-900 bg-yellow-400 rounded-full shadow-sm">¡Últimas
                                                    {{ $stock }}!</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-green-600 rounded-full shadow-sm">En
                                                    Stock</span>
                                            @endif
                                        </div>

                                        {{-- Badge Marca (si existe) --}}
                                        @if ($marNombre && $marNombre != 'N/A')
                                            <div class="absolute top-2 left-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold text-blue-800 bg-white/90 backdrop-blur-sm rounded-md shadow-sm border border-blue-100">
                                                    {{ $marNombre }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Contenido Textual --}}
                                    <div class="p-4 flex flex-col flex-grow">
                                        <div class="mb-1">
                                            <span
                                                class="text-xs text-gray-500 uppercase tracking-wide">{{ $catNombre }}</span>
                                        </div>

                                        <h3
                                            class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 leading-tight min-h-[3rem]">
                                            {{ $nombre }}
                                        </h3>

                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow">
                                            {{ $desc }}
                                        </p>

                                        <div
                                            class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span class="text-xs text-gray-500">Precio</span>
                                                <span
                                                    class="text-xl font-extrabold text-blue-700">${{ number_format($precio, 2) }}</span>
                                            </div>
                                            <button
                                                class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors shadow-sm group-hover:shadow-md">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Estado Vacío --}}
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                            <div class="rounded-xl bg-gray-50 p-12 text-center border-2 border-dashed border-gray-300">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">No se encontraron productos</h4>
                                <p class="text-gray-600 mb-6">Intentamos buscar pero no encontramos coincidencias con los
                                    filtros seleccionados.</p>

                                <a href="{{ route('tienda') }}"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none transition-colors shadow-lg hover:shadow-xl">
                                    Ver todo el catálogo
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            iniciarEfectosMouse();
        });

        function iniciarEfectosMouse() {
            // --- Tarjetas de Producto ---
            const contenedorProductos = document.getElementById('grid-productos');
            if (contenedorProductos) {
                const productos = contenedorProductos.getElementsByClassName('producto-item-js');
                for (let i = 0; i < productos.length; i++) {
                    productos[i].addEventListener("mouseenter", resaltarProducto);
                    productos[i].addEventListener("mouseleave", restaurarProducto);
                    productos[i].style.cursor = 'pointer';
                }
            }

            // --- Links de Filtro ---
            const contenedorFiltros = document.getElementById('filtro-sidebar');
            if (contenedorFiltros) {
                const links = contenedorFiltros.getElementsByClassName('filtro-link-js');
                for (let i = 0; i < links.length; i++) {
                    links[i].addEventListener("mouseenter", resaltarLinkFiltro);
                    links[i].addEventListener("mouseleave", restaurarLinkFiltro);
                }
            }
        }

        function resaltarProducto() {
            this.classList.add('transform', 'scale-[1.02]', 'z-10');
        }

        function restaurarProducto() {
            this.classList.remove('transform', 'scale-[1.02]', 'z-10');
        }

        function resaltarLinkFiltro() {
            this.classList.add('translate-x-2');
            if (!this.classList.contains('bg-blue-700')) {
                this.classList.add('bg-blue-50', 'text-blue-700');
            }
        }

        function restaurarLinkFiltro() {
            this.classList.remove('translate-x-2');
            this.classList.remove('bg-blue-50', 'text-blue-700');
        }
    </script>
@endpush
