@extends('layouts.auth_custom')
@section('title', 'Iniciar sesión')
@section('panel-title', 'Bienvenido de vuelta.')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        <svg viewBox="0 0 16 16" fill="none">
            <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.2"/>
            <path d="M5 8l2.5 2.5L11 5.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        {{ session('status') }}
    </div>
@endif
<div class="card">
<h1 class="auth-form-title">Iniciar sesión</h1>
<p class="auth-form-subtitle">Ingresa tus credenciales para continuar.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label class="form-label" for="email">Correo electrónico</label>
        <input id="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
            type="email" name="email" value="{{ old('email') }}"
            placeholder="tu@correo.com" required autofocus autocomplete="username">
        @error('email')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
            <label class="form-label" for="password" style="margin:0">Contraseña</label>
        </div>
        <input id="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}"
            type="password" name="password" placeholder="••••••••"
            required autocomplete="current-password">
        @error('password')
            <p class="form-error">{{ $message }}</p>
        @enderror
    </div>

    <div style="display:flex;align-items:center;gap:8px;margin-bottom:1.25rem">
        <input id="remember_me" type="checkbox" name="remember"
            style="width:15px;height:15px;accent-color:var(--carbon-900);cursor:pointer">
        <label for="remember_me" style="font-size:12px;color:var(--sand-400);cursor:pointer">
            Recordar sesión
        </label>
    </div>

    <button type="submit" class="btn btn-dark">
        Iniciar sesión
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
        </svg>
    </button>
</form>


 <div class="flex items-center justify-end mt-4">
             <div class="flex flex-col items-end gap-1">
       <a href="{{ route('password.choose') }}"
               style="font-size:15px;color:var(--sand-400);text-decoration:none">
                ¿Olvidaste tu contraseña?
            </a>
  </div>
        </div>
<div class="auth-form-footer" style="margin-top:1.5rem">
    ¿No tienes cuenta?
    <a href="{{ route('register') }}">Regístrate gratis</a>
</div>
</div>
@endsection
