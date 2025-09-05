<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Deckorativa') }} - Acceso Administrativo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
            
            .login-container {
                background: linear-gradient(145deg, #1e3c72, #2a5298, #1e3c72);
                background-size: 400% 400%;
                animation: gradientShift 8s ease infinite;
                position: relative;
                overflow: hidden;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .floating-orbs::before,
            .floating-orbs::after {
                content: '';
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.1);
                animation: float 8s ease-in-out infinite;
            }
            
            .floating-orbs::before {
                width: 200px;
                height: 200px;
                top: 10%;
                right: 10%;
                animation-delay: 0s;
            }
            
            .floating-orbs::after {
                width: 150px;
                height: 150px;
                bottom: 15%;
                left: 15%;
                animation-delay: -4s;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-30px) rotate(180deg); }
            }
            
            .glass-morphism {
                background: rgba(255, 255, 255, 0.12);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }
            
            .input-focus {
                transition: all 0.3s ease;
            }
            
            .input-focus:focus {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                border: 2px solid #60a5fa;
            }
            
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            
            .btn-primary::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                transition: left 0.5s ease;
            }
            
            .btn-primary:hover::before {
                left: 100%;
            }
            
            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="login-container floating-orbs min-h-screen flex items-center justify-center p-4">
            
            <!-- Formulario de Login -->
            <div class="w-full max-w-md">
                <!-- Logo y Título -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-6 glass-morphism">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-2">DECKORATIVA</h1>
                    <p class="text-blue-200 text-lg">Panel Administrativo</p>
                </div>

                <!-- Formulario -->
                <div class="glass-morphism rounded-3xl p-8 shadow-2xl">
                    {{ $slot }}
                </div>
                
                <!-- Enlace para volver -->
                <div class="text-center mt-6">
                    <a href="/" class="inline-flex items-center space-x-2 text-blue-200 hover:text-white transition-colors duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Volver al sitio web</span>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
