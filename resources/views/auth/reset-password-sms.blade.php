@extends('layouts.auth_custom')
@section('title', 'Nueva contraseña')

@section('content')
<div class="card">
    <a href="{{ route('password.choose') }}" class="auth-back">
        <svg viewBox="0 0 14 14" fill="none">
            <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width=".5" stroke-linecap="round"/>
        </svg>
    Volver
    </a>

<div class="auth-header">
    <div class="auth-icon sms">
        <svg viewBox="-13 0 50 22" fill="none">
            <rect x="5" y="9" width="12" height="10" rx="2" stroke="#0F6E56" stroke-width="1.5"/>
            <path d="M8 9V6a3 3 0 016 0v3" stroke="#0F6E56" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </div>
    <h1 class="auth-title">Nueva contraseña</h1>
    <p class="auth-subtitle">Ya verificamos tu identidad. Elige una contraseña segura.</p>
</div>
<br>
<form method="POST" action="{{ route('password.sms.update') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="password">Nueva contraseña</label>
        <input id="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
            type="password" name="password" placeholder="Mínimo 8 caracteres"
            required oninput="checkStrength(this.value)">
        <div class="pwd-strength">
            <div class="pwd-bar" id="bar1"></div>
            <div class="pwd-bar" id="bar2"></div>
            <div class="pwd-bar" id="bar3"></div>
            <div class="pwd-bar" id="bar4"></div>
        </div>
        @error('password')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" class="form-input"
            type="password" name="password_confirmation"
            placeholder="Repite la contraseña" required>
    </div>
    <button type="submit" class="btn btn-dark">Guardar contraseña</button>
</form>
</div>
</div>
@endsection

@section('footer')
    <a href="{{ route('login') }}">Volver al inicio de sesión</a>
@endsection
