<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SmsVerificationCode;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class SmsResetController extends Controller
{
    public function __construct(protected TwilioService $twilio) {}

    // ── Formulario: pedir número de teléfono ──────────────────────────
    public function showRequestForm()
    {
        return view('auth.forgot-password-sms');
    }

    // ── Genera OTP y lo envía por SMS ─────────────────────────────────
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{7,14}$/'],
        ], [
            'phone.regex' => 'El número debe incluir código de país. Ej: +521234567890',
        ]);

        // Rate limiting: máx 3 SMS por número cada 10 minutos
        $key = 'sms-otp:' . $request->phone;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'phone' => "Demasiados intentos. Espera {$seconds} segundos.",
            ]);
        }
        RateLimiter::hit($key, 600);

        // Respuesta genérica para no revelar si el número existe
        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            // Genera OTP de 6 dígitos
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Invalida OTPs anteriores del mismo número
            SmsVerificationCode::where('phone', $request->phone)
                ->whereNull('used_at')
                ->delete();

            // Guarda el hash del OTP
            SmsVerificationCode::create([
                'phone'      => $request->phone,
                'code'       => Hash::make($otp),
                'attempts'   => 0,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now(),
            ]);

            // Envía el SMS
            $this->twilio->sendSms(
                $request->phone,
                "Tu código de recuperación es: {$otp}. Válido por 10 minutos. No lo compartas."
            );
        }

        return redirect()->route('password.sms.verify.form', [
            'phone' => $request->phone,
        ])->with('status', 'Si ese número está registrado, recibirás un SMS.');
    }

    // ── Formulario: ingresar el código OTP ────────────────────────────
    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-sms-code', [
            'phone' => $request->query('phone'),
        ]);
    }

    // ── Valida el OTP ─────────────────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required'],
            'code'  => ['required', 'digits:6'],
        ]);

        // Rate limiting: máx 5 intentos de código por número
        $key = 'sms-verify:' . $request->phone;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'code' => 'Demasiados intentos fallidos. Solicita un nuevo código.',
            ]);
        }

        $record = SmsVerificationCode::where('phone', $request->phone)
            ->whereNull('used_at')
            ->latest('created_at')
            ->first();

        if (! $record || $record->isExpired()) {
            return back()->withErrors(['code' => 'El código ha expirado. Solicita uno nuevo.']);
        }

        if (! Hash::check($request->code, $record->code)) {
            RateLimiter::hit($key, 300);
            $record->increment('attempts');
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }

        // OTP válido — marcamos como usado y redirigimos a cambiar contraseña
        $record->update(['used_at' => now()]);
        RateLimiter::clear($key);

        // Guardamos el teléfono en sesión para el siguiente paso
        session(['sms_reset_phone' => $request->phone]);

        return redirect()->route('password.sms.new');
    }

    // ── Formulario: nueva contraseña ──────────────────────────────────
    public function showNewPasswordForm()
    {
        if (! session('sms_reset_phone')) {
            return redirect()->route('password.sms.request');
        }
        return view('auth.reset-password-sms');
    }

    // ── Guarda la nueva contraseña ────────────────────────────────────
    public function resetPassword(Request $request)
    {
        $phone = session('sms_reset_phone');

        if (! $phone) {
            return redirect()->route('password.sms.request');
        }

        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::where('phone', $phone)->first();

        if (! $user) {
            return redirect()->route('password.sms.request')
                ->withErrors(['phone' => 'Usuario no encontrado.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        session()->forget('sms_reset_phone');

        return redirect()->route('login')
            ->with('status', '¡Contraseña actualizada! Ya puedes iniciar sesión.');
    }
}