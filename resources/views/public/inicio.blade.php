<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deckorativa — Cotizador Virtual de Decoración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/images/VistaPrincipal.png') center/cover;
            opacity: 0.3;
        }
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased text-gray-800">

<header class="fixed top-0 left-0 w-full z-50 glass-effect shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="text-3xl font-bold gradient-text">DECKORATIVA</div>
                <div class="hidden md:block text-sm text-gray-600 font-medium">Cotizador Virtual</div>
            </div>

            <nav class="hidden lg:flex space-x-8 text-lg font-medium">
                <a href="#inicio" class="hover:text-purple-600 transition duration-300">Inicio</a>
                <a href="#servicios" class="hover:text-purple-600 transition duration-300">Servicios</a>
                <a href="#nosotros" class="hover:text-purple-600 transition duration-300">Nosotros</a>
                <a href="#contacto" class="hover:text-purple-600 transition duration-300">Contacto</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="#cotizador" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full hover:from-purple-700 hover:to-indigo-700 transition duration-300 font-medium">
                    Cotizar Ahora
                </a>
                <!-- Botón de menú móvil -->
                <button class="lg:hidden text-gray-600 hover:text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<section id="inicio" class="hero-bg min-h-screen flex items-center justify-center relative">
    <div class="text-center text-white px-6 relative z-10">
        <div class="floating-element mb-8">
            <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                Transforma tu
                <span class="block text-yellow-300">Espacio Ideal</span>
            </h1>
            <p class="text-xl lg:text-2xl mb-8 max-w-3xl mx-auto opacity-90 font-light">
                Cotizaciones instantáneas para decoración profesional.
                Diseño, calidad y precios transparentes al alcance de un click.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="#cotizador" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full text-lg font-semibold hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                🎨 Empezar Cotización
            </a>
            <a href="#servicios" class="border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-gray-900 transition duration-300">
                Ver Servicios
            </a>
        </div>
    </div>

    <!-- Elementos decorativos -->
    <div class="absolute top-20 right-20 w-32 h-32 bg-yellow-400 rounded-full opacity-20 floating-element"></div>
    <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full opacity-10 floating-element" style="animation-delay: -2s;"></div>
</section>

<!-- Sección de Servicios -->
<section id="servicios" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold gradient-text mb-6">Nuestros Servicios</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ofrecemos soluciones completas de decoración con cotizaciones precisas y transparentes
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                    <span class="text-2xl">🏠</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Decoración Interior</h3>
                <p class="text-gray-600 mb-6">Transforma cada rincón de tu hogar con nuestro servicio de decoración personalizada.</p>
                <div class="text-purple-600 font-semibold">Cotización inmediata</div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <span class="text-2xl">🎨</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Diseño Personalizado</h3>
                <p class="text-gray-600 mb-6">Creamos espacios únicos que reflejan tu personalidad y estilo de vida.</p>
                <div class="text-blue-600 font-semibold">Desde tu idea</div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <span class="text-2xl">⚡</span>
                </div>
                <h3 class="text-2xl font-bold mb-4">Cotización Express</h3>
                <p class="text-gray-600 mb-6">Obtén precios precisos al instante con nuestro sistema automatizado.</p>
                <div class="text-green-600 font-semibold">En segundos</div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Cotización -->
<section id="cotizador" class="py-20 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-6">¡Solicita tu Cotización Personalizada!</h2>
        <p class="text-xl mb-8 opacity-90">
            Cuéntanos qué necesitas y nuestro sistema te proporcionará una cotización detallada y precisa
        </p>
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-2xl p-8 max-w-2xl mx-auto">
            <div class="text-left space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-gray-900 font-bold">1</span>
                    </div>
                    <span class="text-lg">Selecciona el tipo de espacio</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-gray-900 font-bold">2</span>
                    </div>
                    <span class="text-lg">Elige los servicios que necesitas</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-gray-900 font-bold">3</span>
                    </div>
                    <span class="text-lg">Recibe tu cotización instantánea</span>
                </div>
            </div>
            <a href="#" class="inline-block mt-8 bg-yellow-400 text-gray-900 px-8 py-4 rounded-full text-lg font-semibold hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                Comenzar Ahora
            </a>
        </div>
    </div>
</section>

<!-- Footer mejorado -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="col-span-2">
                <h3 class="text-3xl font-bold gradient-text mb-4">DECKORATIVA</h3>
                <p class="text-gray-400 mb-6 max-w-md">
                    Tu aliado en decoración profesional. Cotizaciones precisas, diseños únicos y la mejor calidad al mejor precio.
                </p>
                <div class="flex space-x-4">
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                        <span class="text-sm">📧</span>
                    </div>
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <span class="text-sm">📱</span>
                    </div>
                    <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                        <span class="text-sm">📷</span>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Servicios</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white transition">Decoración Interior</a></li>
                    <li><a href="#" class="hover:text-white transition">Diseño Personalizado</a></li>
                    <li><a href="#" class="hover:text-white transition">Consultoría</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>📧 info@deckorativa.com</li>
                    <li>📱 +502 1234-5678</li>
                    <li>📍 Guatemala, Guatemala</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2025 Deckorativa. Todos los derechos reservados.</p>
                <a href="{{ route('login') }}" class="mt-4 md:mt-0 text-gray-500 text-sm hover:text-gray-300 transition">
                    Acceso Administrativo
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript para scroll suave -->
<script>
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

</body>
</html>
