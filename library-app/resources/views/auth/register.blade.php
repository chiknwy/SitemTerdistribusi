<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Collection - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto p-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="py-4 px-6 bg-gray-900 text-white">
                    <h2 class="text-2xl font-semibold">{{ __('Register') }}</h2>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('register.web') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                            <input id="name" type="text" class="mt-1 p-2 w-full border rounded-md" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="mt-1 p-2 w-full border rounded-md" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="password" type="password" class="mt-1 p-2 w-full border rounded-md" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="mt-1 p-2 w-full border rounded-md" name="password_confirmation" required autocomplete="new-password">

                            @error('password_confirmation')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-gray-700">Already have an account?</p>
                        <a href="{{ route('login.form') }}" class="text-blue-500 hover:underline">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
