@extends('layouts.auth_custom')
@section('title', 'Verificar código')

@section('content')
<div class="card">
<a href="{{ route('password.sms.request') }}" class="auth-back">
    <svg viewBox="0 0 14 14" fill="none">
        <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
    </svg>
    Volver
</a>

<div class="auth-header">
     <div class="auth-icon sms">
        <svg viewBox="-13 0 50 22" fill="none">
            <path d="M4 4h14v10H4z" stroke="#0F6E56" stroke-width="1.5" stroke-linejoin="round"/>
            <path d="M8 18h6M11 14v4" stroke="#0F6E56" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </div>
    <h1 class="auth-title">Código de verificación</h1>
    <p class="auth-subtitle">Ingresa el código de 6 dígitos enviado al número <strong>{{ $phone }}</strong>.</p>
</div>

@if (session('status'))
    <div class="alert alert-success">
        <svg viewBox="0 0 16 16" fill="none">
            <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.2"/>
            <path d="M5 8l2.5 2.5L11 5.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.sms.verify') }}" id="otp-form">
    @csrf
    <input type="hidden" name="phone" value="{{ $phone }}">
    <input type="hidden" name="code" id="otp-hidden">

    <div class="otp-container" id="otp-boxes">
        @for ($i = 0; $i < 6; $i++)
            <input type="text" class="otp-input" maxlength="1"
                inputmode="numeric" autocomplete="one-time-code"
                pattern="[0-9]">
        @endfor
    </div>

    @error('code')
        <p class="form-error" style="text-align:center;margin-top:-.5rem;margin-bottom:.75rem">
            {{ $message }}
        </p>
    @enderror

    <p class="otp-timer">
        Expira en <strong id="countdown">10:00</strong>
    </p>

    <button type="submit" class="btn btn-dark">Verificar código</button>

    <div class="auth-divider">o</div>

    <a href="{{ route('password.sms.send') }}" class="btn btn-outline"
       style="text-decoration:none;font-size:14px">
        Reenviar código
    </a>
</form>
</div>
@endsection

@section('footer')
    <a href="{{ route('login') }}">Volver al inicio de sesión</a>
@endsection
