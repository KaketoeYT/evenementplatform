<x-layouts.auth>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Register an account') }}</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf
                <!-- Full Name Input -->
                <div>
                    <x-forms.input label="Full Name" name="name" type="text" placeholder="{{ __('Full Name') }}" autofocus />
                </div>

                <!-- Email Input -->
                <div>
                    <x-forms.input label="Email" name="email" type="email" placeholder="your@email.com" />
                </div>
                <!-- phonenumber Input -->
                <div>
                    <x-forms.input label="Phonenumber" name="phonenumber" type="tel" placeholder="+31 45642 11" />
                </div>

                <!-- Emergency contact Input -->
                <div>
                    <x-forms.input label="Emergency contact" name="emergency_contact" type="tel" placeholder="+31 56422 34" />
                </div>

                <!-- City Input -->
                <div>
                    <x-forms.input label="City" name="city" type="text" placeholder="Amsterdam" />
                </div>

                <!-- Country Input -->
                <div>
                    <x-forms.input label="Country" name="country" type="text" placeholder="Netherlands" />
                </div>

                <!-- Street Input -->
                <div>
                    <x-forms.input label="Street" name="street" type="text" placeholder="Main Street 123" />
                </div>

                <!-- zipcode Input -->
                <div>
                    <x-forms.input label="Zipcode" name="zipcode" type="text" placeholder="3455XX" />
                </div>

                <!-- Password Input -->
                <div>
                    <x-forms.input label="Password" name="password" type="password" placeholder="••••••••" />
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <x-forms.input label="Confirm Password" name="password_confirmation" type="password"
                        placeholder="••••••••" />
                </div>

                <!-- Register Button -->
                <x-button type="primary" class="w-full">{{ __('Create Account') }}</x-button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">{{ __('Sign in') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.auth>
