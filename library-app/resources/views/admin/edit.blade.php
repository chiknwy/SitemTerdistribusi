<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">

    <div class="flex justify-between items-center bg-gray-900 p-4">
        <div>
            <a href="{{ url('/admin') }}" class="text-blue-400">Back to Admin</a>
        </div>
        <div>
            <a href="{{ url('/books') }}" class="text-blue-400">Back to Books</a>
        </div>
    </div>

    <div class="my-8 mx-8">
        <h2 class="text-2xl font-bold mb-4">Edit User: {{ $user->name }}</h2>

        <form method="post" action="{{ url('/admin/update/' . $user->id) }}" class="w-full max-w-md">
            @csrf
            @method('put')

            <div class="mb-4">
                <label for="name" class="block text-gray-500 text-sm font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}"
                    class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-500 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}"
                    class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-500 text-sm font-bold mb-2">New Password:</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center transition-transform transform">
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
                <label for="password_confirmation" class="block text-gray-500 text-sm font-bold mb-2">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
                <p id="passwordError" class="text-red-500 hidden">Passwords do not match.</p>
            </div>

            <div class="mb-4">
                <label for="admin" class="block text-gray-500 text-sm font-bold mb-2">Role:</label>
                <select name="admin" id="admin"
                    class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
                    <option value="0" {{ $user->admin == 0 ? 'selected' : '' }}>User</option>
                    <option value="1" {{ $user->admin == 1 ? 'selected' : '' }}>Admin</option>
                    @if (Auth::user()->admin == 2)
                        <option value="2" {{ $user->admin == 2 ? 'selected' : '' }}>Super Admin</option>
                    @endif
                </select>
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition duration-300">Update User</button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.querySelector(".relative button svg");

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
