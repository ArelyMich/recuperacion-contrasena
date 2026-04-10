@extends('layouts.auth_custom')
@section('title', 'Crear cuenta')
@section('panel-title', 'Empieza hoy.')
@section('panel-desc', 'Crea tu cuenta en segundos. Tu número de teléfono te permitirá recuperar el acceso vía SMS.')

@section('content')
<div class="card">
<h1 class="auth-form-title">Crear cuenta</h1>
<p class="auth-form-subtitle">Llena los datos para comenzar.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label class="form-label" for="name">Nombre completo</label>
        <input id="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}"
            type="text" name="name" value="{{ old('name') }}"
            placeholder="Tu nombre" required autofocus autocomplete="name">
        @error('name') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="email">Correo electrónico</label>
        <input id="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            type="email" name="email" value="{{ old('email') }}"
            placeholder="tu@correo.com" required autocomplete="username">
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="phone">
            Teléfono
        <input id="phone" class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
            type="tel" name="phone" value="{{ old('phone') }}"
            placeholder="+521234567890">
        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Contraseña</label>
        <input id="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
            type="password" name="password" placeholder="Mínimo 8 caracteres"
            required autocomplete="new-password" oninput="checkStrength(this.value)">
        <div class="pwd-bars">
            <div class="pwd-bar" id="bar1"></div>
            <div class="pwd-bar" id="bar2"></div>
            <div class="pwd-bar" id="bar3"></div>
            <div class="pwd-bar" id="bar4"></div>
        </div>
        <p class="pwd-label" id="pwd-label"></p>
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" class="form-input"
            type="password" name="password_confirmation"
            placeholder="Repite la contraseña" required autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-dark">
        Crear cuenta
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
        </svg>
    </button>
</form>

<div class="auth-form-footer">
    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
</div></div>
@endsection
