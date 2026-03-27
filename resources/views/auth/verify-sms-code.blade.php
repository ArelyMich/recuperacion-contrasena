<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Ingresa el código de 6 dígitos que enviamos al número
        <strong>{{ $phone }}</strong>.
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.sms.verify') }}">
        @csrf
        <input type="hidden" name="phone" value="{{ $phone }}">
        <div>
            <x-input-label for="code" value="Código de verificación" />
            <x-text-input id="code" class="block mt-1 w-full tracking-widest text-center
                text-2xl font-bold" type="text" name="code"
                maxlength="6" inputmode="numeric" autocomplete="one-time-code"
                required autofocus placeholder="000000" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('password.sms.request') }}" class="text-sm text-indigo-600">
                Reenviar código
            </a>
            <x-primary-button>Verificar código</x-primary-button>
        </div>
    </form>
</x-guest-layout>