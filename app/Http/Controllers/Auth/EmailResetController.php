<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;

class EmailResetController extends Controller
{
    // ── Muestra el formulario para pedir el reset ──────────────────────
    public function showRequestForm()
    {
        return view('auth.forgot-password-email');
    }

    // ── Recibe el email, genera el token y lo envía ────────────────────
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Rate limiting: máx 5 intentos por IP cada 60 segundos
        $key = 'password-reset-email:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Demasiados intentos. Espera {$seconds} segundos.",
            ]);
        }
        RateLimiter::hit($key, 60);

        // Siempre respondemos igual (no revelar si el email existe o no)
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Genera token seguro y guarda su hash en la BD
            $token     = Str::random(64);
            $tokenHash = Hash::make($token);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token'      => $tokenHash,
                    'created_at' => now(),
                ]
            );

            // Envía el correo con el token en texto plano (el link)
            Mail::to($user->email)->send(new PasswordResetMail($user, $token));
        }

        return back()->with('status',
            'Si ese correo existe, recibirás un enlace en breve.'
        );
    }

    // ── Muestra el formulario para establecer nueva contraseña ─────────
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password-email', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // ── Valida el token y actualiza la contraseña ──────────────────────
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'min:8', 'confirmed'],
        ]);

        // Busca el registro del token por email
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record) {
            return back()->withErrors(['email' => 'Token inválido o expirado.']);
        }

        // Verifica que el token no haya expirado (60 minutos)
        $createdAt = \Carbon\Carbon::parse($record->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'El enlace ha expirado. Solicita uno nuevo.']);
        }

        // Verifica el hash del token
        if (! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token inválido o expirado.']);
        }

        // Actualiza la contraseña y elimina el token
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Usuario no encontrado.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('status', '¡Contraseña actualizada! Ya puedes iniciar sesión.');
    }
}