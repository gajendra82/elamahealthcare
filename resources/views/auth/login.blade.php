<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-[#0056A6] text-white font-bold text-xl mb-3">E</div>
        <h2 class="text-xl font-semibold text-gray-800">Elama Healthcare Admin</h2>
        <p class="text-sm text-gray-500 mt-1">Sign in to manage your website</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0056A6] shadow-sm focus:ring-[#0056A6]" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-[#0056A6] rounded-md" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-[#0056A6] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#004080] focus:outline-none focus:ring-2 focus:ring-[#0056A6] focus:ring-offset-2 transition">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
