<x-layouts.auth :title="__('Reset Password')">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Reset wachtwoord</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Voer je e-mail, token en nieuw wachtwoord in om het wachtwoord te resetten.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <div class="mb-4">
                    <x-forms.input name="email" type="email" label="Email" value="{{ old('email') }}" placeholder="jouw@email.com" />
                </div>

                <div class="mb-4">
                    <x-forms.input name="token" type="text" label="Reset token" value="{{ old('token') }}" placeholder="Voer hier je token in" />
                </div>

                <div class="mb-4">
                    <x-forms.input name="password" type="password" label="Nieuw wachtwoord" placeholder="••••••••" />
                </div>

                <div class="mb-4">
                    <x-forms.input name="password_confirmation" type="password" label="Bevestig wachtwoord" placeholder="••••••••" />
                </div>

                <x-button type="primary" buttonType="submit" class="w-full">
                    {{ __('Reset wachtwoord') }}
                </x-button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Terug naar inloggen</a>
            </div>
        </div>
    </div>
</x-layouts.auth>
