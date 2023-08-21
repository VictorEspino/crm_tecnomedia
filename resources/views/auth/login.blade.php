<x-guest-layout>

<div class="min-h-screen px-3 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-transparent">
    <div>
    <x-jet-authentication-card-logo />
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="user" value="{{ __('User') }}" />
                <x-jet-input id="user" class="block mt-1 w-full" type="text" name="user" :value="old('user')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>



            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
     </div>
</div>
</x-guest-layout>
