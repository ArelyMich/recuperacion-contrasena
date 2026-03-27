<x-guest-layout>
    <form method="POST" action="{{ route('password.sms.update') }}">
        @csrf
        <div>
            <x-input-label for="password" value="Nueva contraseña" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Guardar contraseña</x-primary-button>
        </div>
    </form>
</x-guest-layout>