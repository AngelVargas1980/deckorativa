<x-guest-layout>
    <div class="mb-4 text-sm text-white">
        <strong>Cambio de Contraseña Requerido</strong>
        <p class="mt-2">Has iniciado sesión con una contraseña temporal. Por favor, cambia tu contraseña para continuar.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.change.update') }}">
        @csrf

        <!-- Nueva Contraseña -->
        <div>
            <x-input-label for="password" value="Nueva Contraseña" class="text-white" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" class="text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Cambiar Contraseña
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
