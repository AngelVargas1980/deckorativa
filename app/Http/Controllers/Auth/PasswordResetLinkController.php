<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Verificar que el correo existe en la base de datos
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No se encontró ningún usuario con este correo electrónico.']);
        }

        // Generar una contraseña temporal aleatoria
        $temporaryPassword = Str::random(10);

        // Guardar la contraseña temporal y marcar que es temporal
        $user->password = Hash::make($temporaryPassword);
        $user->is_temporary_password = true;
        $user->save();

        // Enviar el correo con la contraseña temporal
        try {
            Mail::raw(
                "Hola {$user->name},\n\n" .
                "Has solicitado restablecer tu contraseña.\n\n" .
                "Tu contraseña temporal es: {$temporaryPassword}\n\n" .
                "Por favor, inicia sesión con esta contraseña. Se te pedirá que cambies tu contraseña inmediatamente.\n\n" .
                "Si no solicitaste este cambio, por favor contacta al administrador del sistema.\n\n" .
                "Saludos,\nEquipo de Deckorativa",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Contraseña Temporal - Deckorativa');
                }
            );

            return back()->with('status', 'Se ha enviado una contraseña temporal a tu correo electrónico.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Error al enviar el correo. Por favor, intenta de nuevo.']);
        }
    }
}
