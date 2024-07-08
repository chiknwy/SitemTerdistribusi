<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">
    <header class="px-5 sticky top-0 bg-gray-900 py-5 opacity-95 backdrop-blur-sm z-10">
        <nav class="container mx-auto flex items-center justify-between opacity-100">
            @if (Auth::check())
            <div class="text-3xl font-bold mb-4">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="font-bold text-indigo-500 hover:underline">Logout</button>
                </form>
            @else
            <a href="{{ url('/login') }}" class="text-3xl text-blue-600 font-medium mb-4">Login</a>
            @endif
            </div>
            <div class="text-center text-blue-400 justify-center items-center space-x-4 hidden sm:flex flex-grow">
                <a href="{{ url('/landing') }}"><h1 class="text-3xl font-bold mb-4"><img class="w-11 h-11 inline" src="https://chiknwy.github.io/Tekweb/porto/img/skull.gif" alt="skull">Book Collection Management <img class="w-11 h-11 inline" src="https://chiknwy.github.io/Tekweb/porto/img/skull.gif" alt="skull"></h1></a>
            </div>
            
                <div class="flex space-x-4 inline mb-4">
                @if (Auth::check())
                   Hello :)
    
                @else
                <a href="{{ route('register') }}" class="text-3xl text-blue-600 font-medium mb-4">Register</a>
                @endif

           
            <div class="sm:hidden relative">
                <button id="menu-toggle" class="text-blue-400 hover:text-white transition-transform transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform transform" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div id="menu" class="hidden absolute right-0 mt-2 py-2 bg-gray-700 rounded-lg shadow-lg">
                    <a href="#home" class="block px-4 py-2 text-blue-200 hover:text-white">Home</a>
                    <a href="#about" class="block px-4 py-2 text-blue-200 hover:text-white">About</a>
                    <a href="#portfolio" class="block px-4 py-2 text-blue-200 hover:text-white">Portfolio</a>
                    <a href="#contact" class="block px-4 py-2 text-blue-200 hover:text-white">Contact</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="my-8 mx-8">
        <h2 class="text-2xl font-bold mb-4">Edit User: {{ Auth::user()->name  }}</h2>

        <form method="post" action="{{ url('/admin/update/' . $users->id) }}" class="w-full max-w-md"
            onsubmit="return validateForm()">
            @csrf
            @method('put')

            <div class="mb-4">
                <label for="name" class="block text-gray-500 text-sm font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                    class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-500 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" value="{{ $users->email }}"
                    class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-500 text-sm font-bold mb-2">New Password:</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
                    <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-class')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center transition-transform transform">
                        <!-- Your eye icon SVG or HTML here -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="h-4 w-4 text-gray-500 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.536 6.464a9 9 0 0 1 0 11.313m-1.414-1.414a9 9 0 0 0 0-11.313m-1 11.313a5 5 0 0 1 0-7.071"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4.75a8.954 8.954 0 0 1 2.44 2.432m0 0a8.954 8.954 0 0 1 2.432 2.439m-2.432-2.44a8.954 8.954 0 0 0 2.432 2.44m0 0a8.954 8.954 0 0 0 2.439 2.432m-2.44-2.432a8.954 8.954 0 0 1 2.44 2.432m0 0a8.954 8.954 0 0 1 2.432 2.439m-7.71-7.71a6 6 0 0 1 0 9.192"></path>
                    </svg>
                    </button>
                </div>
                <p class="text-gray-500 text-sm mt-2">Leave it empty if you don't want to change the password.</p>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-500 text-sm font-bold mb-2">Confirm New
                    Password:</label>
                <div class="relative">
                   
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-class')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center transition-transform transform">
                        <!-- Your eye icon SVG or HTML here -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="h-4 w-4 text-gray-500 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.536 6.464a9 9 0 0 1 0 11.313m-1.414-1.414a9 9 0 0 0 0-11.313m-1 11.313a5 5 0 0 1 0-7.071"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4.75a8.954 8.954 0 0 1 2.44 2.432m0 0a8.954 8.954 0 0 1 2.432 2.439m-2.432-2.44a8.954 8.954 0 0 0 2.432 2.44m0 0a8.954 8.954 0 0 0 2.439 2.432m-2.44-2.432a8.954 8.954 0 0 1 2.44 2.432m0 0a8.954 8.954 0 0 1 2.432 2.439m-7.71-7.71a6 6 0 0 1 0 9.192"></path>
                    </svg>
                    </button>
                    <p id="passwordError" class="text-red-500 hidden">Passwords do not match.</p>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition duration-300">Update User</button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId, eyeIconClass) {
            var passwordInput = document.getElementById(inputId);
            var eyeIcon = document.querySelector("." + eyeIconClass);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.add("rotate-eye-open");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("rotate-eye-open");
            }
        }

        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirmation").value;

            if (password !== confirmPassword) {
                document.getElementById("passwordError").classList.remove("hidden");
                return false;
            } else {
                document.getElementById("passwordError").classList.add("hidden");
                return true;
            }
        }
    </script>


    <style>
        .rotate-eye-open {
            transform: rotate(-45deg);
        }
    </style>
</body>

</html>
