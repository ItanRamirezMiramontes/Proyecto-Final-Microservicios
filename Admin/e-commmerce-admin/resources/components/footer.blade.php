<footer class="bg-gradient-to-br from-blue-900 to-blue-800 text-white shadow-2xl">
    <div class="w-full mx-auto p-8">

        {{-- Sección Principal del Footer --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">

            {{-- Logo y Descripción --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                        </svg>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                        Global AutoParts
                    </span>
                </div>
                <p class="text-blue-200 text-sm leading-relaxed mb-6">
                    Distribuidor mundial de autopartes de calidad. Repuestos originales y compatibles para cualquier
                    vehículo con envío a todo el mundo.
                </p>

                {{-- Métodos de Pago --}}
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-white mb-3">Métodos de Pago</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-blue-700/50 rounded-lg text-xs font-medium">Visa</span>
                        <span class="px-3 py-1 bg-blue-700/50 rounded-lg text-xs font-medium">Mastercard</span>
                        <span class="px-3 py-1 bg-blue-700/50 rounded-lg text-xs font-medium">PayPal</span>
                        <span class="px-3 py-1 bg-blue-700/50 rounded-lg text-xs font-medium">Mercado Pago</span>
                    </div>
                </div>
            </div>

            {{-- Tienda --}}
            <div>
                <h2 class="mb-6 text-lg font-bold text-white uppercase flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Tienda
                </h2>
                <ul class="text-blue-200 font-medium space-y-3">

                    <li>
                        <a href=""
                            class="hover:text-white transition-colors duration-300 flex items-center gap-2 group">
                            <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            Conoce nuestros productos
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Atención al Cliente --}}
            <div>
                <h2 class="mb-6 text-lg font-bold text-white uppercase flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Soporte
                </h2>
                <ul class="text-blue-200 font-medium space-y-3">
                    <li>
                        <a href="#"
                            class="hover:text-white transition-colors duration-300 flex items-center gap-2 group">
                            <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            Contáctanos
                        </a>
                    </li>
                    <li>
                        <a href=""
                            class="hover:text-white transition-colors duration-300 flex items-center gap-2 group">
                            <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            Preguntas Frecuentes
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="hover:text-white transition-colors duration-300 flex items-center gap-2 group">
                            <svg class="w-3 h-3 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            Envíos y Devoluciones
                        </a>
                    </li>

                </ul>
            </div>

            {{-- Contacto y Redes --}}
            <div>
                <h2 class="mb-6 text-lg font-bold text-white uppercase flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Contacto
                </h2>
                <div class="text-blue-200 space-y-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm">+1 (555) 123-4567</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm">soporte@globalautoparts.com</span>
                    </div>

                    {{-- Redes Sociales --}}
                    <div class="pt-4">
                        <h4 class="text-sm font-semibold text-white mb-3">Síguenos</h4>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="text-blue-200 hover:text-white transition-colors duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="text-blue-200 hover:text-white transition-colors duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="text-blue-200 hover:text-white transition-colors duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 16c-3.314 0-6-2.686-6-6s2.686-6 6-6 6 2.686 6 6-2.686 6-6 6z" />
                                    <circle cx="12" cy="12" r="2.5" />
                                </svg>
                            </a>
                            <a href="#"
                                class="text-blue-200 hover:text-white transition-colors duration-300 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Línea Separadora --}}
        <hr class="my-8 border-blue-700" />

        {{-- Pie Inferior --}}
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <div class="text-center lg:text-left">
                <span class="text-blue-300 text-sm">
                    © 2025 <span class="font-semibold text-white">Global AutoParts</span>. Todos los derechos
                    reservados.
                </span>
            </div>

            <div class="flex flex-wrap justify-center gap-6 text-blue-300 text-sm">
                <a href="#" class="hover:text-white transition-colors duration-300">Términos y Condiciones</a>
                <a href="#" class="hover:text-white transition-colors duration-300">Política de Privacidad</a>
                <a href="#" class="hover:text-white transition-colors duration-300">Política de Cookies</a>
            </div>
        </div>
    </div>
</footer>
