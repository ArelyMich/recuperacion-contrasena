@extends('layouts.auth_custom')

@section('title', 'Recuperar cuenta')

@section('content')
<div class="card">
    <a href="{{ route('login') }}" class="auth-back">
    <svg viewBox="0 0 14 14" fill="none">
        <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width=".5" stroke-linecap="round"/>
    </svg>
   Volver
</a>
<div class="auth-header">
    <div class="auth-icon choose">
        <svg viewBox="-13 0 50 22" fill="none">
            <circle cx="11" cy="11" r="9" stroke="#3a3935" stroke-width=".5"/>
            <path d="M11 7v4l3 3" stroke="#3a3935" stroke-width=".5" stroke-linecap="round"/>
        </svg>
    </div>
    <h1>Recupera tu cuenta</h1>
    <p>Elige cómo quieres verificar tu identidad para restablecer tu contraseña.</p>
</div>
<br>
<a href="{{ route('password.email.request') }}" class="method-card">
    <div class="method-card-icon email">
        <svg viewBox="0 0 18 18" fill="none">
            <rect x="1" y="3" width="16" height="12" rx="2" stroke="#534AB7" stroke-width="1.3"/>
            <path d="M1 6l8 5 8-5" stroke="#534AB7" stroke-width="1.3"/>
        </svg>
    </div>
    <div>
        <div class="method-card-title">Correo electrónico</div>
        <div class="method-card-desc">Recibe un enlace seguro · válido 60 min</div>
    </div>
    <span class="method-card-arrow">›</span>
</a>

<a href="{{ route('password.sms.request') }}" class="method-card">
    <div class="method-card-icon sms">
        <svg viewBox="0 0 18 18" fill="none">
            <rect x="4" y="1" width="10" height="16" rx="2.5" stroke="#0F6E56" stroke-width="1.3"/>
            <circle cx="9" cy="13.5" r="1" fill="#0F6E56"/>
        </svg>
    </div>
    <div>
        <div class="method-card-title">Mensaje SMS</div>
        <div class="method-card-desc">Recibe un código de 6 dígitos · válido 10 min</div>
    </div>
    <span class="method-card-arrow">›</span>
</a>
</div>
@endsection

@section('footer')
    ¿Ya recordaste tu contraseña?
    <a href="{{ route('login') }}">Iniciar sesión</a>
@endsection
