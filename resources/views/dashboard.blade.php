<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sand-50:#faf9f6;--sand-100:#f2f0ea;--sand-200:#e0ddd4;
            --sand-300:#c8c4b8;--sand-400:#a09c8e;--carbon-700:#3a3935;
            --carbon-800:#2c2b28;--carbon-900:#1a1a18;
            --accent:#534AB7;--accent-light:#EEEDFE;
            --teal:#0F6E56;--teal-light:#E1F5EE;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Figtree', system-ui, sans-serif; }

        body {
            background: var(--sand-100);
            display: flex; flex-direction: column;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .nav {
            background: var(--carbon-700);
            padding: 0 2.5rem;
            display: flex; align-items: center;
            height: 58px; gap: 2rem; flex-shrink: 0;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 9px; text-decoration: none;
        }
        .nav-logo-box {
            width: 30px; height: 30px;
            background: rgba(255,255,255,.1); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .nav-logo-box svg { width: 15px; height: 15px; }
        .nav-logo-name {
            font-size: 14px; font-weight: 600; color: #fff; letter-spacing: -.02em;
        }
        .nav-links {
            display: flex; gap: 4px; margin-left: .5rem; flex: 1;
        }
        .nav-link {
            padding: 6px 12px; border-radius: 7px;
            font-size: 13px; color: rgba(255, 255, 255, 0.56);
            text-decoration: none; transition: all .15s;
        }
        .nav-link:hover  { color: rgba(255,255,255,.7); background: rgba(255, 255, 255, 0.1); }
        .nav-link.active { color: #fff; background: rgba(255, 255, 255, 0); }
        .nav-right {
            display: flex; align-items: center; gap: 12px; margin-left: auto;
        }
        .nav-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--accent-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600; color: var(--accent);
            cursor: pointer;
        }
        .nav-logout {
            font-size: 12px; color: rgba(255, 255, 255, 0.82);
            text-decoration: none; padding: 5px 10px;
            border: 0.5px solid rgba(255, 255, 255, 0.29);
            border-radius: 7px; transition: all .15s;
        }
        .nav-logout:hover { color: rgba(255, 255, 255, 0.78); border-color: rgba(255,255,255,.2); }

        /* ── Contenido ── */
        .page {
            flex: 1; padding: 2rem 2.5rem;
            display: flex; flex-direction: column; gap: 1.5rem;
        }

        /* Header de página */
        .page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
        }
        .page-title { font-size: 20px; font-weight: 600; color: var(--carbon-900); letter-spacing: -.02em; }
        .page-sub   { font-size: 13px; color: var(--sand-400); margin-top: 3px; }
        .page-date  { font-size: 12px; color: var(--sand-400); }

        /* Cards de métricas */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0,1fr));
            gap: 12px;
        }
        .metric-card {
            background: #fff; border-radius: 14px;
            border: 0.5px solid var(--sand-200); padding: 1.25rem 1.5rem;
        }
        .metric-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: .75rem;
        }
        .metric-label { font-size: 12px; color: var(--sand-400); font-weight: 400; }
        .metric-icon  {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .metric-icon svg { width: 15px; height: 15px; }
        .metric-value { font-size: 26px; font-weight: 600; color: var(--carbon-900); letter-spacing: -.03em; }
        .metric-delta {
            font-size: 11px; margin-top: 4px;
            display: flex; align-items: center; gap: 4px;
        }
        .delta-up   { color: var(--teal); }
        .delta-down { color: #A32D2D; }

        /* Grid principal */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 12px;
            flex: 1;
        }

        /* Panel genérico */
        .panel {
            background: #fff; border-radius: 14px;
            border: 0.5px solid var(--sand-200); padding: 1.25rem 1.5rem;
        }
        .panel-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .panel-title { font-size: 13px; font-weight: 500; color: var(--carbon-800); }
        .panel-badge {
            font-size: 10px; padding: 3px 9px; border-radius: 20px;
            background: var(--sand-100); color: var(--sand-400);
        }

        /* Tabla de actividad */
        .activity-table { width: 100%; border-collapse: collapse; }
        .activity-table th {
            font-size: 11px; color: var(--sand-400); font-weight: 500;
            text-align: left; padding: 0 0 10px; border-bottom: 1px solid var(--sand-100);
        }
        .activity-table td {
            font-size: 12px; color: var(--carbon-700); padding: 10px 0;
            border-bottom: 0.5px solid var(--sand-100); vertical-align: middle;
        }
        .activity-table tr:last-child td { border-bottom: none; }
        .status-pill {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 8px; border-radius: 20px; font-size: 10px; font-weight: 500;
        }
        .status-pill.ok      { background: var(--teal-light); color: var(--teal); }
        .status-pill.blocked { background: #FCEBEB; color: #A32D2D; }
        .status-pill.pending { background: #FAEEDA; color: #854F0B; }
        .channel-tag {
            display: inline-block; padding: 2px 7px; border-radius: 5px;
            font-size: 10px; background: var(--sand-100); color: var(--sand-400);
        }
        .channel-tag.email { background: var(--accent-light); color: var(--accent); }
        .channel-tag.sms   { background: var(--teal-light); color: var(--teal); }

        /* Panel derecho — actividad */
        .activity-list { display: flex; flex-direction: column; gap: 0; }
        .activity-item {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 10px 0; border-bottom: 0.5px solid var(--sand-100);
        }
        .activity-item:last-child { border-bottom: none; }
        .act-dot-wrap {
            display: flex; flex-direction: column; align-items: center; padding-top: 4px;
        }
        .act-dot {
            width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
        }
        .act-text { font-size: 12px; color: var(--carbon-700); line-height: 1.4; }
        .act-time { font-size: 11px; color: var(--sand-300); margin-top: 2px; }

        /* Barra de uso */
        .usage-row { margin-bottom: 12px; }
        .usage-header {
            display: flex; justify-content: space-between;
            font-size: 11px; margin-bottom: 6px;
        }
        .usage-label { color: var(--carbon-700); font-weight: 500; }
        .usage-pct   { color: var(--sand-400); }
        .usage-track { height: 6px; background: var(--sand-100); border-radius: 3px; overflow: hidden; }
        .usage-fill  { height: 100%; border-radius: 3px; }

        /* Alerta de bienvenida */
        .welcome-banner {
            background: var(--carbon-700); border-radius: 14px;
            padding: 1.25rem 1.5rem;
            display: flex; align-items: center; gap: 1rem;
        }
        .welcome-text  { font-size: 14px; font-weight: 500; color: rgba(255,255,255,.85); }
        .welcome-sub   { font-size: 12px; color: rgba(255,255,255,.35); margin-top: 3px; }
        .welcome-right { margin-left: auto; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="nav">
    <a href="{{ url('/') }}" class="nav-logo">
        <div class="nav-logo-box">
            <svg viewBox="0 0 18 18" fill="none">
                <path d="M9 1L2 6v11h5v-5h4v5h5V6L9 1z" fill="rgba(255,255,255,.9)"/>
            </svg>
        </div>
        <span class="nav-logo-name">Dashboard</span>
    </a>

    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="nav-link active">Inicio</a>
    </div>

    <div class="nav-right">
        <div class="nav-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="nav-logout">Cerrar sesión</button>
        </form>
    </div>
</nav>

<!-- Contenido -->
<main class="page">
    <div class="welcome-banner">
        <div>
            <div class="welcome-text">Hola, {{ Auth::user()->name }}</div>
            <div class="welcome-sub">
                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM') }} 
            </div>
        </div>
    </div>

    <!-- Métricas -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-label">Usuarios registrados</span>
                <div class="metric-icon" style="background:var(--accent-light)">
                    <svg viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="5" r="3" stroke="#534AB7" stroke-width="1.2"/>
                        <path d="M2 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="#534AB7" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="metric-value">{{ \App\Models\User::count() }}</div>
            <div class="metric-delta delta-up">↑ en la plataforma</div>
        </div>

        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-label">Resets por email</span>
                <div class="metric-icon" style="background:var(--accent-light)">
                    <svg viewBox="0 0 15 15" fill="none">
                        <rect x="1" y="3" width="13" height="9" rx="1.5" stroke="#534AB7" stroke-width="1.2"/>
                        <path d="M1 5.5l6.5 4 6.5-4" stroke="#534AB7" stroke-width="1.2"/>
                    </svg>
                </div>
            </div>
            <div class="metric-value">{{ \DB::table('password_reset_tokens')->count() }}</div>
            <div class="metric-delta delta-up">tokens activos</div>
        </div>

        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-label">Resets por SMS</span>
                <div class="metric-icon" style="background:var(--teal-light)">
                    <svg viewBox="0 0 15 15" fill="none">
                        <rect x="4" y="1" width="7" height="13" rx="2" stroke="#0F6E56" stroke-width="1.2"/>
                        <circle cx="7.5" cy="11" r=".8" fill="#0F6E56"/>
                    </svg>
                </div>
            </div>
            <div class="metric-value">{{ \App\Models\SmsVerificationCode::count() }}</div>
            <div class="metric-delta delta-up">códigos enviados</div>
        </div>

        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-label">Códigos usados</span>
                <div class="metric-icon" style="background:var(--teal-light)">
                    <svg viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="7.5" r="5.5" stroke="#0F6E56" stroke-width="1.2"/>
                        <path d="M5 7.5l2 2 3.5-3" stroke="#0F6E56" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="metric-value">{{ \App\Models\SmsVerificationCode::whereNotNull('used_at')->count() }}</div>
            <div class="metric-delta delta-up">verificaciones exitosas</div>
        </div>
    </div>

    <!-- Grid principal -->
    <div class="content-grid">

        <!-- Panel izquierdo: tabla de usuarios -->
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Usuarios registrados</span>
                <span class="panel-badge">{{ \App\Models\User::count() }} total</span>
            </div>
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Canales</th>
                        <th>Registro</th>
                    </tr>
                </thead>
                <tbody>
                @foreach(\App\Models\User::latest()->take(8)->get() as $user)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:28px;height:28px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:var(--accent);flex-shrink:0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span style="font-weight:500">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td style="color:var(--sand-400)">{{ $user->email }}</td>
                        <td style="color:var(--sand-400)">{{ $user->phone ?? '—' }}</td>
                        <td>
                            <span class="channel-tag email">Email</span>
                            @if($user->phone)
                                <span class="channel-tag sms" style="margin-left:3px">SMS</span>
                            @endif
                        </td>
                        <td style="color:var(--sand-300)">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Panel derecho: actividad y uso -->
        <div style="display:flex;flex-direction:column;gap:12px">
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Uso de mecanismos</span>
                </div>
                @php
                    $emailCount = \DB::table('password_reset_tokens')->count();
                    $smsCount   = \App\Models\SmsVerificationCode::count();
                    $total      = $emailCount + $smsCount ?: 1;
                @endphp
                <div class="usage-row">
                    <div class="usage-header">
                        <span class="usage-label">Email</span>
                        <span class="usage-pct">{{ round($emailCount/$total*100) }}%</span>
                    </div>
                    <div class="usage-track">
                        <div class="usage-fill" style="width:{{ round($emailCount/$total*100) }}%;background:var(--accent)"></div>
                    </div>
                </div>
                <div class="usage-row">
                    <div class="usage-header">
                        <span class="usage-label">SMS</span>
                        <span class="usage-pct">{{ round($smsCount/$total*100) }}%</span>
                    </div>
                    <div class="usage-track">
                        <div class="usage-fill" style="width:{{ round($smsCount/$total*100) }}%;background:var(--teal)"></div>
                    </div>
                </div>
            </div>

            <div class="panel" style="flex:1">
                <div class="panel-header">
                    <span class="panel-title">Actividad reciente</span>
                </div>
                <div class="activity-list">
                    @foreach(\App\Models\SmsVerificationCode::latest('created_at')->take(5)->get() as $code)
                    <div class="activity-item">
                        <div class="act-dot-wrap">
                            <div class="act-dot" style="background:{{ $code->used_at ? 'var(--teal)' : '#BA7517' }}"></div>
                        </div>
                        <div>
                            <div class="act-text">
                                SMS {{ $code->used_at ? 'verificado' : 'enviado' }}
                                · {{ substr($code->phone, 0, 4) }}•••
                            </div>
                            <div class="act-time">{{ \Carbon\Carbon::parse($code->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endforeach

                    @foreach(\DB::table('password_reset_tokens')->latest('created_at')->take(3)->get() as $token)
                    <div class="activity-item">
                        <div class="act-dot-wrap">
                            <div class="act-dot" style="background:var(--accent)"></div>
                        </div>
                        <div>
                            <div class="act-text">Reset email · {{ substr($token->email, 0, 5) }}•••</div>
                            <div class="act-time">{{ \Carbon\Carbon::parse($token->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>