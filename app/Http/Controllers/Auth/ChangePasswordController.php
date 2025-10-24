<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    /**
     * Mostrar el formulario de cambio de contraseña obligatorio
     */
    public function show(): View
    {
        // Verificar que el usuario esté autenticado y tenga contraseña temporal
        if (!Auth::check() || !Auth::user()->is_temporary_password) {
            abort(403, 'Acceso no autorizado');
        }

        return view('auth.change-password-required');
    }

    /**
     * Procesar el cambio de contraseña
     */
    public function update(Request $request): RedirectResponse
    {
        // Verificar que el usuario esté autenticado y tenga contraseña temporal
        if (!Auth::check() || !Auth::user()->is_temporary_password) {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->is_temporary_password = false;
        $user->save();

        return redirect()->to(RouteServiceProvider::HOME)
            ->with('status', 'Tu contraseña ha sido actualizada exitosamente.');
    }
}
