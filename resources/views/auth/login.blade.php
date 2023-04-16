{{-- <x-guest-layout>
    <x-authentication-card> --}}
<!DOCTYPE html>
<html>  
    <head>
        <title> HSS | Login </title>
        <link rel="stylesheet" href="css/base_style.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> 
    </head>
    <body>
        <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
        <div class=auth-card>
        {{-- <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot> --}}

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 style="text-align: center"> Login </h2>
            <p style="text-align: center; color: gray"> Welcome onboard with us! </p>
            <hr class="mb-3">

            <div>
                <x-label for="email" value="{{ __('Email') }}" /><br>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" /><br>
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4 button">
                    {{ __('Log in') }}
                </x-button>
                <br>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
    </div>
    </div>
</body>
</html>
    {{-- </x-authentication-card>
</x-guest-layout> --}}
