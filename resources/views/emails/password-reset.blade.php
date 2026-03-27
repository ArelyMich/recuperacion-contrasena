<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .card { background: #fff; max-width: 520px; margin: 0 auto;
                border-radius: 8px; padding: 40px; }
        .btn  { display: inline-block; background: #6366f1; color: #fff;
                padding: 12px 28px; border-radius: 6px; text-decoration: none;
                font-weight: bold; margin: 24px 0; }
        .footer { font-size: 12px; color: #888; margin-top: 24px; }
    </style>
</head>
<body>
<div class="card">
    <h2>Recupera tu contraseña</h2>
    <p>Hola, <strong>{{ $user->name }}</strong>.</p>
    <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta.
       Haz clic en el botón de abajo. El enlace expira en <strong>60 minutos</strong>.</p>

    <a class="btn" href="{{ url('/password/email/reset/' . $token . '?email=' . urlencode($user->email)) }}">
        Restablecer contraseña
    </a>

    <p>Si no solicitaste este cambio, ignora este correo.</p>
    <div class="footer">
        Este enlace expira el {{ now()->addMinutes(60)->format('d/m/Y H:i') }}.
    </div>
</div>
</body>
</html>