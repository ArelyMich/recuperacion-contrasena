<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Ingresa tu número con código de país y te enviaremos un código SMS.
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.sms.send') }}">
        @csrf
        <div>
            <x-input-label for="phone" value="Teléfono (ej: +521234567890)" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel"
                name="phone" :value="old('phone')" required autofocus
                placeholder="+521234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('password.email.request') }}" class="text-sm text-indigo-600">
                Recuperar por email
            </a>
            <x-primary-button>Enviar código SMS</x-primary-button>
        </div>
    </form>
</x-guest-layout>