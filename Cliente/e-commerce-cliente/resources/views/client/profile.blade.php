@extends('layouts.app')

@section('title', 'Mi Perfil - Global AutoParts')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Mi Perfil</h1>
                <p class="text-gray-600 mt-2">Gestiona tu información personal y preferencias</p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">¡Éxito!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <div class="lg:col-span-3 space-y-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-900">Información Personal</h2>
                            <button onclick="toggleEdit()"
                                class="flex items-center space-x-2 text-blue-600 hover:text-blue-700 transition-colors">
                                <i class="fas fa-edit"></i>
                                <span>Editar</span>
                            </button>
                        </div>

                        <div id="viewMode">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                    <p class="text-gray-900 font-medium">
                                        {{ session('client_user')['nombre'] ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                                    <p class="text-gray-900 font-medium">
                                        {{ session('client_user')['apellido'] ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <p class="text-gray-900">{{ session('client_user')['email'] ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                    <p class="text-gray-900">{{ session('client_user')['telefono'] ?? 'No especificado' }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                    <p class="text-gray-900">{{ session('client_user')['direccion'] ?? 'No especificado' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ session('client_user')['rol_nombre'] ?? 'Cliente' }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Miembro desde</label>
                                    <p class="text-gray-900">
                                        @if (isset(session('client_user')['created_at']))
                                            {{ \Carbon\Carbon::parse(session('client_user')['created_at'])->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form id="editForm" class="hidden" action="{{ route('client.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre
                                        *</label>
                                    <input type="text" id="nombre" name="nombre"
                                        value="{{ old('nombre', session('client_user')['nombre']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellido
                                        *</label>
                                    <input type="text" id="apellido" name="apellido"
                                        value="{{ old('apellido', session('client_user')['apellido']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        *</label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', session('client_user')['email']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="telefono"
                                        class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <input type="text" id="telefono" name="telefono"
                                        value="{{ old('telefono', session('client_user')['telefono']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="direccion"
                                        class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                    <textarea id="direccion" name="direccion" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none">{{ old('direccion', session('client_user')['direccion']) }}</textarea>
                                </div>

                                <div class="hidden">
                                    <input type="file" id="imagen" name="imagen" accept="image/*">
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="toggleEdit()"
                                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span>Guardar Cambios</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-900">Historial de Pedidos</h2>
                            <button onclick="cargarPedidos()"
                                class="flex items-center space-x-2 text-gray-600 hover:text-gray-800 transition-colors">
                                <i class="fas fa-sync-alt"></i>
                                <span>Actualizar</span>
                            </button>
                        </div>

                        <div id="pedidosContainer">
                            <div id="cargandoPedidos" class="text-center py-8">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600">
                                </div>
                                <p class="mt-2 text-gray-600">Cargando pedidos...</p>
                            </div>

                            <div id="sinPedidos" class="hidden text-center py-8">
                                <i class="fas fa-shopping-bag text-gray-300 text-4xl mb-3"></i>
                                <h3 class="text-lg font-semibold text-gray-700">No tienes pedidos aún</h3>
                                <p class="text-gray-500 mt-1">Realiza tu primera compra para ver tu historial aquí.</p>
                                <a href="{{ route('tienda') }}"
                                    class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-shopping-cart mr-2"></i> Ir a la tienda
                                </a>
                            </div>

                            <div id="listaPedidos" class="hidden space-y-4"></div>

                            <div id="errorPedidos" class="hidden text-center py-8">
                                <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-3"></i>
                                <h3 class="text-lg font-semibold text-gray-700">Error al cargar pedidos</h3>
                                <p class="text-gray-500 mt-1" id="errorMensaje"></p>
                                <button onclick="cargarPedidos()"
                                    class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    Reintentar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Seguridad</h2>
                        <button onclick="togglePasswordForm()" id="btnChangePass"
                            class="w-full md:w-auto px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors flex items-center space-x-2">
                            <i class="fas fa-lock"></i>
                            <span>Cambiar Contraseña</span>
                        </button>

                        <form id="passwordForm" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"
                            action="{{ route('client.password.change') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="md:col-span-2">
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Nueva
                                    Contraseña</label>
                                <input type="password" id="new_password" name="new_password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required minlength="8">
                            </div>
                            <div>
                                <label for="new_password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <div class="md:col-span-2 flex justify-end space-x-3">
                                <button type="button" onclick="togglePasswordForm()"
                                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Actualizar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="space-y-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                        <div class="relative inline-block">
                            @php
                                use App\Http\Controllers\ClientAuthController;
                                // Obtenemos el helper desde el controlador
                                $authController = new ClientAuthController();

                                $rawImage =
                                    session('client_user')['imagen'] ??
                                    (session('client_user')['imagen_perfil'] ?? null);
                                $imagenUrl = $authController->construirUrlImagen($rawImage);

                                $imagenDefault =
                                    'https://ui-avatars.com/api/?name=' .
                                    urlencode(session('client_user')['nombre']) .
                                    '&background=random';
                            @endphp

                            <img id="profileImage" src="{{ !empty($imagenUrl) ? $imagenUrl : $imagenDefault }}"
                                alt="Foto de perfil"
                                class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-100"
                                onerror="this.onerror=null; this.src='{{ $imagenDefault }}';">

                            <div class="absolute bottom-2 right-2">
                                <button type="button"
                                    onclick="toggleEdit(); setTimeout(() => document.getElementById('imagen').click(), 100);"
                                    class="cursor-pointer bg-blue-600 text-white p-2 rounded-full shadow-lg hover:bg-blue-700 transition-colors border-none outline-none">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mt-4">
                            {{ session('client_user')['nombre'] }} {{ session('client_user')['apellido'] }}
                        </h3>
                        <p class="text-gray-600 text-sm">{{ session('client_user')['rol_nombre'] ?? 'Cliente' }}</p>

                        <div class="mt-4 space-y-2">
                            <div class="flex items-center justify-center text-sm text-gray-600">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>{{ session('client_user')['email'] }}</span>
                            </div>
                            @if (!empty(session('client_user')['telefono']))
                                <div class="flex items-center justify-center text-sm text-gray-600">
                                    <i class="fas fa-phone mr-2"></i>
                                    <span>{{ session('client_user')['telefono'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mi Actividad</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pedidos Totales</span>
                                <span id="totalPedidos" class="font-semibold text-blue-600">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pendientes</span>
                                <span id="pedidosPendientes" class="font-semibold text-yellow-600">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Completados</span>
                                <span id="pedidosCompletados" class="font-semibold text-green-600">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
                        <div class="space-y-2">
                            <a href="{{ route('tienda') }}"
                                class="flex items-center space-x-2 text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                <i class="fas fa-shopping-cart"></i> <span>Continuar Comprando</span>
                            </a>
                            <a href="{{ route('pedido.index') }}"
                                class="flex items-center space-x-2 text-purple-600 hover:text-purple-700 p-2 rounded-lg hover:bg-purple-50 transition-colors">
                                <i class="fas fa-history"></i> <span>Ver Historial Completo</span>
                            </a>
                            <a href="{{ route('carrito.index') }}"
                                class="flex items-center space-x-2 text-orange-600 hover:text-orange-700 p-2 rounded-lg hover:bg-orange-50 transition-colors">
                                <i class="fas fa-shopping-bag"></i> <span>Mi Carrito</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // --- 1. Control de Interfaz ---
        function toggleEdit() {
            const viewMode = document.getElementById('viewMode');
            const editForm = document.getElementById('editForm');

            if (viewMode.classList.contains('hidden')) {
                viewMode.classList.remove('hidden');
                editForm.classList.add('hidden');
            } else {
                viewMode.classList.add('hidden');
                editForm.classList.remove('hidden');
            }
        }

        function togglePasswordForm() {
            const form = document.getElementById('passwordForm');
            const btn = document.getElementById('btnChangePass');

            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                btn.classList.add('hidden');
            } else {
                form.classList.add('hidden');
                btn.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            cargarPedidos();

            // Abrir formulario si hay errores de validación de Laravel
            @if ($errors->has('current_password') || $errors->has('new_password'))
                togglePasswordForm();
            @elseif ($errors->any())
                const viewMode = document.getElementById('viewMode');
                const editForm = document.getElementById('editForm');
                viewMode.classList.add('hidden');
                editForm.classList.remove('hidden');
            @endif
        });

        async function cargarPedidos() {
            const cargando = document.getElementById('cargandoPedidos');
            const sinPedidos = document.getElementById('sinPedidos');
            const listaPedidos = document.getElementById('listaPedidos');
            const errorPedidos = document.getElementById('errorPedidos');
            const errorMensaje = document.getElementById('errorMensaje');

            // Reset UI
            cargando.classList.remove('hidden');
            sinPedidos.classList.add('hidden');
            listaPedidos.classList.add('hidden');
            errorPedidos.classList.add('hidden');

            try {
                const token = '{{ session('client_token') }}';
                if (!token) throw new Error('No autenticado');

                const response = await fetch(
                    '{{ rtrim(env('API_BASE_URL', 'http://localhost:8000/api'), '/') }}/pedidos', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });

                const data = await response.json();

                if (response.ok && (data.success || Array.isArray(data.data))) {
                    const pedidos = data.data?.data || data.data || [];
                    cargando.classList.add('hidden');

                    if (pedidos.length === 0) {
                        sinPedidos.classList.remove('hidden');
                    } else {
                        listaPedidos.classList.remove('hidden');
                        listaPedidos.innerHTML = pedidos.map(p => renderPedido(p)).join('');
                    }
                    actualizarEstadisticas(pedidos);
                } else {
                    throw new Error(data.message || 'Error al obtener pedidos');
                }
            } catch (error) {
                console.error(error);
                cargando.classList.add('hidden');
                errorMensaje.textContent = "No se pudo conectar con el historial.";
                errorPedidos.classList.remove('hidden');
                actualizarEstadisticas([]);
            }
        }

        function renderPedido(pedido) {
            const total = parseFloat(pedido.total || 0).toFixed(2);
            const fechaRaw = pedido.fecha_pedido || pedido.created_at;
            const fecha = fechaRaw ? new Date(fechaRaw).toLocaleDateString() : 'Fecha desc.';

            const estado = (pedido.estado || 'Desconocido').toLowerCase();
            let colorClass = 'bg-gray-100 text-gray-800';

            if (estado === 'pendiente') colorClass = 'bg-yellow-100 text-yellow-800';
            else if (estado === 'completado') colorClass = 'bg-green-100 text-green-800';
            else if (estado === 'cancelado') colorClass = 'bg-red-100 text-red-800';
            else if (estado === 'procesando') colorClass = 'bg-blue-100 text-blue-800';

            return `
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-gray-700">Pedido #${pedido.id}</span>
                            <span class="text-sm text-gray-500">• ${fecha}</span>
                        </div>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${colorClass}">
                                ${estado.charAt(0).toUpperCase() + estado.slice(1)}
                            </span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <div class="text-lg font-bold text-gray-900">$${total}</div>
                        <a href="/pedido/${pedido.id}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Ver detalles &rarr;</a>
                    </div>
                </div>
            `;
        }

        function actualizarEstadisticas(pedidos) {
            document.getElementById('totalPedidos').textContent = pedidos.length;

            const pendientes = pedidos.filter(p => (p.estado || '').toLowerCase() === 'pendiente').length;
            document.getElementById('pedidosPendientes').textContent = pendientes;

            const completados = pedidos.filter(p => (p.estado || '').toLowerCase() === 'completado').length;
            document.getElementById('pedidosCompletados').textContent = completados;
        }
    </script>
@endsection
