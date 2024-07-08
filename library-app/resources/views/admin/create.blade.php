<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Create User</title>
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
        <h2 class="text-2xl font-bold mb-4">Create User</h2>

        <form method="post" action="{{ url('/admin/store') }}" class="w-full max-w-md" onsubmit="return validateForm()">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-500 text-sm font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200" value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-500 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200" value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-500 text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-500 text-sm font-bold mb-2">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200">
                <p id="passwordError" class="text-red-500 hidden">Passwords do not match.</p>
            </div>

            <div class="mb-4">
                <label for="admin" class="block text-gray-500 text-sm font-bold mb-2">Role:</label>
                <select name="admin" id="admin" class="w-full px-3 py-2 border rounded-md text-blue-400 bg-gray-900 focus:outline-none focus:border-blue-400 border-blue-200"> 
                    <option value="0" {{ old('admin') == false ? 'selected' : '' }}>User</option>
                    <option value="1" {{ old('admin') == true ? 'selected' : '' }}>Admin</option>
                    @if (Auth::user()->admin == 2)
                        <option value="2" {{ old('admin') == true ? 'selected' : '' }}>Super Admin</option>
                    @endif
                </select>
            </div>

            <div>
                <button type="submit" class="bg-green-400 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-300">Create User</button>
            </div>
        </form>
    </div>

    <script>
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
</body>

</html>
