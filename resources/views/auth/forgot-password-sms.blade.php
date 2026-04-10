@extends('layouts.auth_custom')
@section('title', 'Recuperar por SMS')

@section('content')

<div class="card">
    <a href="{{ route('password.choose') }}" class="auth-back">
    <svg viewBox="0 0 14 14" fill="none">
        <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
    </svg>
    Volver
</a>
<div class="auth-header">
    <div class="auth-icon sms">
        <svg viewBox="-13 0 50 22" fill="none">
            <rect x="5" y="1" width="12" height="20" rx="3" stroke="#0F6E56" stroke-width="1.5"/>
            <circle cx="11" cy="17" r="1.2" fill="#0F6E56"/>
        </svg>
    </div>
    <h1 class="auth-title">Recuperar por SMS</h1>
    <p class="auth-subtitle">Ingresa tu número con código de país y te enviaremos un código de 6 dígitos.</p>
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

<form method="POST" action="{{ route('password.sms.send') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="phone">Número de teléfono</label>
        <input id="phone" class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
            type="tel" name="phone" value="{{ old('phone') }}"
            placeholder="+521234567890" required autofocus>
        @error('phone')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-dark">
        Enviar código SMS
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
        </svg>
    </button>
</form>
</div>
@endsection

@section('footer')
    ¿Prefieres usar tu correo?
    <a href="{{ route('password.email.request') }}">Recuperar por email</a>
@endsection
