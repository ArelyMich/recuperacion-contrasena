<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Ingresa tu email y te enviaremos un enlace para recuperar tu contraseña.
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email.send') }}">
        @csrf
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Enviar enlace</x-primary-button>
        </div>
    </form>
</x-guest-layout>