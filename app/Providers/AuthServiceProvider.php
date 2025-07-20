<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definir permisos de roles
        Gate::define('access-admin', function ($user) {
            return $user->rol === 'Admin'; // Permitir acceso solo si es admin
        });

        Gate::define('access-asesor', function ($user) {
            return $user->rol === 'Asesor'; // Permitir acceso solo si es asesor
        });

        Gate::define('access-supervisor', function ($user) {
            return $user->rol === 'Supervisor'; // Permitir acceso solo si es supervisor
        });
    }
}
