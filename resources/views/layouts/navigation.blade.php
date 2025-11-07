<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo y Marca -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center group-hover:shadow-lg transition-shadow duration-200">
                            <span class="text-white font-bold text-lg">D</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                DECKORATIVA
                            </div>
                            <div class="text-xs text-gray-500 font-medium">Panel Administrativo</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links Desktop -->
                <div class="hidden lg:flex lg:items-center lg:ml-10 lg:space-x-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'text-gray-700 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </x-nav-link>

                    @can('view users')
                        <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('usuarios.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-users w-5 h-5 {{ request()->routeIs('usuarios.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
                            <span class="font-medium">Usuarios</span>
                        </x-nav-link>
                    @endcan

                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('clients.*') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('clients.*') ? 'text-green-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">Clientes</span>
                    </x-nav-link>

                    @can('view categorias')
                        <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('categorias.*') ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'text-gray-700 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('categorias.*') ? 'text-amber-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zM9 9h6v6H9V9z"></path>
                            </svg>
                            <span class="font-medium">Categorías</span>
                        </x-nav-link>
                    @endcan

                    @can('view servicios')
                        <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.*')" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('servicios.*') ? 'bg-cyan-50 text-cyan-700 border border-cyan-200' : 'text-gray-700 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('servicios.*') ? 'text-cyan-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l5.5-3.5L16 21z"></path>
                            </svg>
                            <span class="font-medium">Servicios</span>
                        </x-nav-link>
                    @endcan

                    @can('view cotizaciones')
                        <x-nav-link :href="route('cotizaciones.index')" :active="request()->routeIs('cotizaciones.*')" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('cotizaciones.*') ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'text-gray-700 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('cotizaciones.*') ? 'text-orange-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">Cotizaciones</span>
                        </x-nav-link>
                    @endcan

                    @can('view pedidos')
                        <x-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('pedidos.*') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('pedidos.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span class="font-medium">Pedidos</span>
                        </x-nav-link>
                    @endcan

                    @can('view roles')
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-purple-50 text-purple-700 border border-purple-200' : 'text-gray-700 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('roles.*') ? 'text-purple-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="font-medium">Roles</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- User Menu Desktop -->
            <div class="hidden lg:flex lg:items-center lg:ml-6">
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition ease-in-out duration-150">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                    @if(Auth::user()->getRoleNames()->count() > 0)
                                        <div class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->first() }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            @if(Auth::user()->getRoleNames()->count() > 0)
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ Auth::user()->getRoleNames()->first() }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Profile Link -->
                        <div class="py-1">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mi Perfil
                            </a>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <!-- Logout -->
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Cerrar Sesión') }}
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </x-responsive-nav-link>

            @can('view users')
                <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" 
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('usuarios.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-users w-5 h-5 {{ request()->routeIs('usuarios.*') ? 'text-blue-600' : 'text-gray-500' }}"></i>
                    <span class="font-medium">Usuarios</span>
                </x-responsive-nav-link>
            @endcan

            <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" 
                class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('clients.*') ? 'bg-green-50 text-green-700 border-l-4 border-green-600' : 'text-gray-700' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('clients.*') ? 'text-green-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="font-medium">Clientes</span>
            </x-responsive-nav-link>

            @can('view categorias')
                <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" 
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('categorias.*') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-600' : 'text-gray-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('categorias.*') ? 'text-amber-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zM9 9h6v6H9V9z"></path>
                    </svg>
                    <span class="font-medium">Categorías</span>
                </x-responsive-nav-link>
            @endcan

            @can('view servicios')
                <x-responsive-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.*')" 
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('servicios.*') ? 'bg-cyan-50 text-cyan-700 border-l-4 border-cyan-600' : 'text-gray-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('servicios.*') ? 'text-cyan-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l5.5-3.5L16 21z"></path>
                    </svg>
                    <span class="font-medium">Servicios</span>
                </x-responsive-nav-link>
            @endcan

            @can('view cotizaciones')
                <x-responsive-nav-link :href="route('cotizaciones.index')" :active="request()->routeIs('cotizaciones.*')" 
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('cotizaciones.*') ? 'bg-orange-50 text-orange-700 border-l-4 border-orange-600' : 'text-gray-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('cotizaciones.*') ? 'text-orange-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Cotizaciones</span>
                </x-responsive-nav-link>
            @endcan

            @can('view pedidos')
                <x-responsive-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')" 
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('pedidos.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('pedidos.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="font-medium">Pedidos</span>
                </x-responsive-nav-link>
            @endcan

            @can('view roles')
                <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" 
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('roles.*') ? 'text-purple-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="font-medium">Roles</span>
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Mobile User Menu -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 py-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        @if(Auth::user()->getRoleNames()->count() > 0)
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ Auth::user()->getRoleNames()->first() }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <!-- Profile Link -->
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Mi Perfil</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-700 hover:bg-red-50 rounded-lg transition-colors duration-150">
                        <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="font-medium">{{ __('Cerrar Sesión') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>