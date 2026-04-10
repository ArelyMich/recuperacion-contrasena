@extends('layouts.auth_custom')
@section('title', 'Recuperar por email')

@section('content')
<div class="card">
<a href="{{ route('password.choose') }}" class="auth-back">
    <svg viewBox="0 0 14 14" fill="none">
        <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width=".5" stroke-linecap="round"/>
    </svg>
   Volver
</a>

<div class="auth-header">
    <div class="auth-icon email">
        <svg viewBox="-13 0 50 22" fill="none">
            <rect x="2" y="4" width="18" height="14" rx="2.5" stroke="#534AB7" stroke-width=".5"/>
            <path d="M2 7l9 6 9-6" stroke="#534AB7" stroke-width=".5"/>
        </svg>
    </div>
    <h1 class="auth-title">Recuperar por email</h1>
    <p class="auth-subtitle">Ingresa tu correo y te enviaremos un enlace de recuperación válido por 60 minutos.</p>
</div>
<br>
@if (session('status'))
    <div class="alert alert-success">
        <svg viewBox="0 0 16 16" fill="none">
            <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.2"/>
            <path d="M5 8l2.5 2.5L11 5.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        {{ session('status') }}
    </div>
@endif
<form method="POST" action="{{ route('password.email.send') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="email">Correo electrónico</label>
        <input id="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            type="email" name="email" value="{{ old('email') }}"
            placeholder="tu@correo.com" required autofocus>
        @error('email')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-dark">
        Enviar enlace
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
        </svg>
    </button>
</form>
</div>
@endsection

@section('footer')
    ¿Prefieres usar tu teléfono?
    <a href="{{ route('password.sms.request') }}">Recuperar por SMS</a>
@endsection
