<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RecoveryApp')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sand-50:  #efdbf4;
            --sand-100: #e9d5f7;
            --sand-200: #e0ddd4;
            --sand-300: #c8c4b8;
            --sand-400: #a09c8e;
            --carbon-700: #3a3935;
            --carbon-800: #2c2b28;
            --carbon-900: #1a1a18;
            --accent:       #534AB7;
            --accent-light: #EEEDFE;
            --teal:         #0F6E56;
            --teal-light:   #E1F5EE;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
        }

        /* ── Pantalla dividida ───────────────────────────────────────── */
        .auth-screen {
            display: flex;
            min-height: 100vh;
        }

        .auth-panel-right {
            flex: 1;
            background: var(--sand-50);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .auth-form-box {
            width: 100%;
            max-width: 400px;
        }

        /* Logo */
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .auth-logo-mark {
            width: 36px; height: 36px;
            background: rgba(255,255,255,.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-logo-mark svg { width: 18px; height: 18px; }
        .auth-logo-name {
            font-size: 16px; font-weight: 600;
            color: #fff; letter-spacing: -.02em;
        }
        /* Badges de features */
        .auth-badges {
            display: flex; flex-wrap: wrap; gap: 6px;
            margin-top: 2rem; position: relative; z-index: 1;
        }
        .auth-badge {
            background: rgba(255,255,255,.07);
            border: 0.5px solid rgba(255,255,255,.1);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 11px; color: rgba(255,255,255,.45);
        }

        /* ── Formulario ──────────────────────────────────────────────── */
        .auth-form-title {
            font-size: 22px; font-weight: 600;
            color: var(--carbon-900); letter-spacing: -.02em;
            margin-bottom: 4px;
        }
        .auth-form-subtitle {
            font-size: 13px; color: var(--sand-400); line-height: 1.5;
            margin-bottom: 2rem;
        }

        /* Alertas */
        .alert {
            border-radius: 10px; padding: 12px 14px;
            font-size: 13px; margin-bottom: 1.25rem;
            display: flex; align-items: flex-start; gap: 8px; line-height: 1.4;
        }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: var(--teal-light); color: var(--teal); border: 0.5px solid rgba(15,110,86,.2); }
        .alert-error   { background: #FCEBEB; color: #A32D2D; border: 0.5px solid rgba(163,45,45,.2); }

        /* Ícono de sección */
        .section-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
        }
        .section-icon.email  { background: var(--accent-light); }
        .section-icon.sms    { background: var(--teal-light); }
        .section-icon.choose { background: var(--sand-100); }
        .section-icon svg { width: 20px; height: 20px; }

        /* Campos */
        .form-group  { margin-bottom: 1rem; }
        .form-label  {
            display: block; font-size: 12px; font-weight: 500;
            color: var(--carbon-700); margin-bottom: 6px; letter-spacing: .01em;
        }
        .form-input {
            width: 100%; padding: 11px 14px;
            background: #fff; border: 1px solid var(--sand-200);
            border-radius: 10px; font-size: 14px; color: var(--carbon-900);
            transition: border-color .15s, box-shadow .15s; outline: none;
            font-family: inherit;
        }
        .form-input:focus {
            border-color: var(--carbon-800);
            box-shadow: 0 0 0 3px rgba(44,43,40,.07);
            background: #fff;
        }
        .form-input::placeholder { color: var(--sand-300); }
        .form-input.error { border-color: #E24B4A; }
        .form-error { font-size: 12px; color: #A32D2D; margin-top: 5px; }

        /* Botones */
        .btn {
            width: 100%; padding: 12px 16px;
            border-radius: 10px; font-size: 14px; font-weight: 500;
            cursor: pointer; border: none;
            transition: all .15s; font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-dark {
            background: var(--carbon-900); color: var(--sand-50);
        }
        .btn-dark:hover  { background: var(--carbon-800); }
        .btn-dark:active { transform: scale(.98); }

        .btn-outline {
            background: transparent; color: var(--carbon-700);
            border: 1px solid var(--sand-200);
        }
        .btn-outline:hover { background: var(--sand-100); border-color: var(--sand-300); }

        /* Cards de método */
        .method-card {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 16px; border-radius: 12px;
            border: 1px solid var(--sand-200); text-decoration: none;
            color: inherit; transition: all .2s; margin-bottom: .75rem;
            background: #d9d0ecb3;
        }
        .method-card:hover {
            border-color: var(--carbon-800); background: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,.06);
        }
        .method-card-icon {
            width: 20px; height: 20px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .method-card-icon.email { background: var(--accent-light); }
        .method-card-icon.sms   { background: var(--teal-light); }
        .method-card-icon svg { width: 18px; height: 18px; }
        .method-card-body { flex: 1; }
        .method-card-title { font-size: 13px; font-weight: 500; color: var(--carbon-900); }
        .method-card-desc  { font-size: 11px; color: var(--sand-400); margin-top: 2px; }
        .method-card-arrow { color: var(--sand-300); font-size: 18px; }

        /* OTP */
        .otp-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr); 
            gap: 10px;
            margin: 1.25rem 0;
            width: 100%;
            max-width: 400px; /* Evita que se estiren demasiado en desktop */
            margin-left: auto;
            margin-right: auto;
        }
        .otp-input {
            height: 50px; width: 50px; text-align: center; font-size: 18; font-weight: 600;
            color: var(--carbon-900); background: #fff;
            border: 1px solid var(--sand-200); border-radius: 10px;
            outline: none; transition: all .15s; font-family: inherit;
            margin-top: .5rem
        }
        .otp-input:focus {
            border-color: var(--carbon-900);
            box-shadow: 0 0 0 3px rgba(44,43,40,.07);
        }
        .otp-timer {
            text-align: center; font-size: 12px; color: var(--sand-400);
            margin-top: .5rem; margin-bottom: 1rem;
        }
        .otp-timer strong { color: var(--carbon-800); }

        /* Fortaleza de contraseña */
        .pwd-bars { display: flex; gap: 4px; margin-top: 8px; }
        .pwd-bar {
            height: 3px; flex: 1; border-radius: 2px;
            background: var(--sand-200); transition: background .3s;
        }
        .pwd-bar.weak   { background: #E24B4A; }
        .pwd-bar.medium { background: #BA7517; }
        .pwd-bar.strong { background: var(--teal); }
        .pwd-label {
            font-size: 11px; color: var(--sand-400); margin-top: 5px;
        }

        /* Back link */
        .auth-back {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; color: var(--sand-400); text-decoration: none;
            margin-bottom: 1.5rem; transition: color .15s;
        }
        .auth-back:hover { color: var(--carbon-800); }
        .auth-back svg { width: 14px; height: 14px; }

        /* Divider */
        .auth-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 1.25rem 0; color: var(--sand-300); font-size: 11px;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: var(--sand-200);
        }

        /* Footer */
        .auth-form-footer {
            text-align: center; margin-top: 1.5rem;
            font-size: 13px; color: var(--sand-400);
        }
        .auth-form-footer a {
            color: var(--carbon-800); font-weight: 500; text-decoration: none;
        }
        .auth-form-footer a:hover { text-decoration: underline; }

        .card { background: #ffffff; max-width: 520px; margin: 0 auto;
                border-radius: 8px; padding: 20px; }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-panel-left { display: none; }
            .auth-panel-right { padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>
<div class="auth-screen">

    <div class="auth-panel-right">
        <div class="auth-form-box">
            @yield('content')
        </div>
    </div>

</div>

<script>
/* OTP boxes — navegación automática entre celdas */
document.addEventListener('DOMContentLoaded', () => {
    const boxes = document.querySelectorAll('.otp-input');
    const hidden = document.getElementById('otp-hidden');

    if (boxes.length) {
        boxes.forEach((box, i) => {
            box.addEventListener('input', e => {
                const v = e.target.value.replace(/\D/g, '');
                box.value = v.slice(-1);
                if (v && i < boxes.length - 1) boxes[i + 1].focus();
                if (hidden) hidden.value = [...boxes].map(b => b.value).join('');
            });
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !box.value && i > 0) {
                    boxes[i - 1].focus();
                }
            });
        });
        boxes[0].focus();
    }

    /* Countdown 10 minutos */
    const cd = document.getElementById('countdown');
    if (cd) {
        let secs = 600;
        const tick = setInterval(() => {
            secs--;
            if (secs <= 0) { clearInterval(tick); cd.textContent = '00:00'; return; }
            const m = String(Math.floor(secs / 60)).padStart(2, '0');
            const s = String(secs % 60).padStart(2, '0');
            cd.textContent = `${m}:${s}`;
            if (secs <= 30) cd.style.color = '#A32D2D';
        }, 1000);
    }
});

/* Medidor de fortaleza de contraseña */
function checkStrength(val) {
    const bars  = [1,2,3,4].map(n => document.getElementById('bar'+n));
    if (!bars[0]) return;
    let score = 0;
    if (val.length >= 8)               score++;
    if (/[A-Z]/.test(val))             score++;
    if (/[0-9]/.test(val))             score++;
    if (/[^A-Za-z0-9]/.test(val))      score++;
    const cls = score <= 1 ? 'weak' : score <= 2 ? 'medium' : 'strong';
    bars.forEach((b, i) => {
        b.className = 'pwd-bar';
        if (i < score) b.classList.add(cls);
    });
}
</script>
</body>
</html>