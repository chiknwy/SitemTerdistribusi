<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Collection - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto p-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="py-4 px-6 bg-gray-900 text-white">
                    <h2 class="text-2xl font-semibold">{{ __('Login') }}</h2>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('login.web') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="mt-1 p-2 w-full border rounded-md" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="password" type="password" class="mt-1 p-2 w-full border rounded-md" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input class="mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="text-sm text-gray-700" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                {{ __('Login') }}
                            </button>

                            {{-- <a class="text-sm text-gray-600 ml-4 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a> --}}
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-gray-700">Don't have an account?</p>
                        <a href="{{ route('register.form') }}" class="text-blue-500 hover:underline">Register here</a> <br> <br>
                        <a href="/landing" class="text-blue-500 hover:underline">Home Page</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
