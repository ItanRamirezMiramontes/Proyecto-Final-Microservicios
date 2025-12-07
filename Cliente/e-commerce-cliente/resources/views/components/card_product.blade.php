{{-- resources/views/components/card_product.blade.php --}}
@props(['producto' => []])

{{-- Validar y extraer datos del producto --}}
@php
    // Asegurar que $producto sea un array
    $productoData = is_array($producto) ? $producto : [];

    // Extraer valores con validación
    $id = $productoData['id'] ?? 0;
    $nombre = $productoData['nombre'] ?? 'Sin nombre';
    $descripcion = $productoData['descripcion'] ?? 'Sin descripción';
    $precio = $productoData['precio'] ?? 0;
    $stock = $productoData['stock'] ?? 0;
    $categoria_id = $productoData['categoria_id'] ?? null;
    $marca_id = $productoData['marca_id'] ?? null;
    $categoria_nombre = $productoData['categoria_nombre'] ?? 'Sin categoría';
    $marca_nombre = $productoData['marca_nombre'] ?? null;
    $imagen_1_url = $productoData['imagen_1_url'] ?? 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=AutoParte';
@endphp

<div
    class="producto-card-js group relative flex flex-col h-full overflow-hidden bg-white rounded-2xl shadow-lg border border-blue-100 transition-all duration-300">

    <a href="{{ route('producto.detalle', $id) }}" class="relative block overflow-hidden">

        <img src="{{ $imagen_1_url }}" alt="{{ $nombre }}"
            class="object-cover w-full h-56 transition-transform duration-300"
            onerror="this.src='https://placehold.co/600x400/e2e8f0/e2e8f0?text=AutoParte'">

        <div class="js-overlay absolute inset-0 bg-black opacity-0 transition-opacity duration-300"></div>

        <div class="absolute top-3 right-3">
            @if ($stock == 0)
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-red-600 to-red-700 rounded-full shadow-lg">
                    <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5"></span>
                    Agotado
                </span>
            @elseif($stock <= 10)
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-gray-900 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full shadow-lg">
                    <span class="w-1.5 h-1.5 bg-gray-900 rounded-full mr-1.5"></span>
                    Pocas unidades
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-full shadow-lg">
                    <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5"></span>
                    En Stock
                </span>
            @endif
        </div>

        @if ($marca_nombre)
            <div class="absolute top-3 left-3">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-800 bg-white/95 backdrop-blur-sm rounded-full shadow-lg border border-blue-200">
                    {{ $marca_nombre }}
                </span>
            </div>
        @endif
    </a>

    <div class="flex flex-col flex-grow p-6">

        <div class="mb-3">
            @if ($categoria_id)
                <a href="{{ route('producto.filtrar', ['categoria_id' => $categoria_id]) }}"
                    class="relative z-10 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    {{ $categoria_nombre }}
                </a>
            @else
                <span class="inline-flex items-center text-sm font-medium text-gray-500">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    {{ $categoria_nombre }}
                </span>
            @endif
        </div>

        <h3 class="flex-grow mb-3 text-lg font-bold text-blue-900 leading-tight transition-colors duration-200">
            <a href="{{ route('producto.detalle', $id) }}"
                class="js-title-link text-blue-900 no-underline transition-colors duration-200">
                {{ $nombre }}
            </a>
        </h3>

        @if ($descripcion && $descripcion != 'Sin descripción')
            <p class="mb-4 text-sm text-blue-600 leading-relaxed line-clamp-2">
                {{ Illuminate\Support\Str::limit($descripcion, 80) }}
            </p>
        @endif

        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-2xl font-bold text-blue-700">
                    ${{ number_format($precio, 2) }}
                </p>
                @if ($stock > 0)
                    <p class="text-xs text-blue-500 mt-1">
                        {{ $stock }} unidades disponibles
                    </p>
                @endif
            </div>
            <div class="flex items-center space-x-1">
                <div class="flex text-yellow-400">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-xs text-blue-500">(24)</span>
            </div>
        </div>

        {{-- Formulario para agregar al carrito --}}
        @if (session('client_user'))
            <form action="{{ route('carrito.agregar') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $id }}">
                <input type="hidden" name="cantidad" value="1">

                <button type="submit" @if ($stock == 0) disabled @endif
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300 flex items-center justify-center 
                           disabled:bg-gray-400 disabled:cursor-not-allowed"
                    @if ($stock > 0) onclick="agregarAlCarrito(this, {{ $id }})" @endif>
                    @if ($stock == 0)
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Agotado
                    @else
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Agregar al Carrito
                    @endif
                </button>
            </form>
        @else
            <a href="{{ route('client.login') }}"
                class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300 flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Inicia sesión para comprar
            </a>
        @endif

        @if ($precio > 50)
            <div class="mt-3 text-center">
                <span
                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Envío gratis
                </span>
            </div>
        @endif
    </div>
    <div
        class="js-border-effect absolute inset-0 rounded-2xl border-2 border-transparent transition-all duration-300 pointer-events-none">
    </div>
</div>

@push('scripts')
    @once('iniciar-efectos-producto')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                iniciarEfectosMouseProducto();
            });

            function iniciarEfectosMouseProducto() {
                const productos = document.getElementsByClassName('producto-card-js');

                for (let i = 0; i < productos.length; i++) {
                    productos[i].addEventListener("mouseover", resaltarProducto);
                    productos[i].addEventListener("mouseout", restaurarProducto);
                }
            }

            function resaltarProducto() {
                // Efecto Sombra (en la tarjeta principal)
                this.classList.add('shadow-2xl');

                const img = this.querySelector('img');
                if (img) {
                    img.classList.add('scale-105');
                }

                // Efecto Overlay (sobre la imagen)
                const overlay = this.querySelector('.js-overlay');
                if (overlay) {
                    overlay.classList.add('opacity-5');
                }

                // Efecto Título (cambio de color)
                const title = this.querySelector('.js-title-link');
                if (title) {
                    title.classList.add('text-blue-800');
                }

                // Efecto Borde (en la div de borde)
                const borderEffect = this.querySelector('.js-border-effect');
                if (borderEffect) {
                    borderEffect.classList.add('border-blue-300');
                }
            }

            function restaurarProducto() {
                // Quitar Sombra
                this.classList.remove('shadow-2xl');

                // Quitar Escala de Imagen
                const img = this.querySelector('img');
                if (img) {
                    img.classList.remove('scale-105');
                }

                // Quitar Overlay
                const overlay = this.querySelector('.js-overlay');
                if (overlay) {
                    overlay.classList.remove('opacity-5');
                }

                // Quitar color de Título
                const title = this.querySelector('.js-title-link');
                if (title) {
                    title.classList.remove('text-blue-800');
                }

                // Quitar Borde
                const borderEffect = this.querySelector('.js-border-effect');
                if (borderEffect) {
                    borderEffect.classList.remove('border-blue-300');
                }
            }

            // Función para agregar al carrito con feedback visual
            function agregarAlCarrito(button, productoId) {
                const originalText = button.innerHTML;

                // Cambiar el texto y deshabilitar temporalmente
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Agregando...
                `;
                button.disabled = true;

                // Enviar el formulario
                const form = button.closest('form');
                form.submit();

                // Restaurar después de 2 segundos
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            }
        </script>
    @endonce
@endpush
