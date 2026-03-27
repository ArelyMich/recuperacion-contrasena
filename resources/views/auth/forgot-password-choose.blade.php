<x-guest-layout>
    <div class="mb-6 text-sm text-gray-600 text-center">
        ¿Cómo quieres recuperar tu contraseña?
    </div>

    <div class="flex flex-col gap-4">
        <a href="{{ route('password.email.request') }}"
           class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg
                  hover:border-indigo-400 hover:bg-indigo-50 transition">
            <div class="text-3xl">📧</div>
            <div>
                <div class="font-semibold text-gray-800">Por correo electrónico</div>
                <div class="text-sm text-gray-500">
                    Te enviaremos un enlace de recuperación
                </div>
            </div>
        </a>

        <a href="{{ route('password.sms.request') }}"
           class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg
                  hover:border-indigo-400 hover:bg-indigo-50 transition">
            <div class="text-3xl">📱</div>
            <div>
                <div class="font-semibold text-gray-800">Por SMS</div>
                <div class="text-sm text-gray-500">
                    Te enviaremos un código de 6 dígitos
                </div>
            </div>
        </a>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
            Volver al inicio de sesión
        </a>
    </div>
</x-guest-layout>