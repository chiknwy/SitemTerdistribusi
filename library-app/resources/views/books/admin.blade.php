<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Your existing styles here */

        #userTable {
            border: 1px solid black;
        }

        #userTable tbody {
            background-color: rgba(14, 15, 25, 0.433);
        }
    </style>
</head>

<body class="bg-gray-900 text-blue-400">
    <!-- Your existing header code here -->
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
                <div class="font-bold text-blue-400">
                    <a href="{{ url('/books') }}" class="bg-blue-400 text-gray-900 px-4 py-2 rounded-md hover:bg-blue-500 transition duration-300">Back to Books</a>
                </div>
    
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
    
    

    <div class="container mx-auto p-4">
        <div class="inline">
            <h1 class="text-3xl font-bold mb-4 text-blue-400">Admin Control Panel - User Table</h1>
            <div class="flex space-x-4 inline mb-4">
                @if (Auth::check())
                <span class="font-bold text-blue-400">Hello, {{ Auth::user()->name }}!
                    @if (Auth::user()->admin == 1)
                    You're an admin!
                    @elseif (Auth::user()->admin == 2)
                    You're a super admin!
                    @endif <br> Welcome Back! 

                @else
                <a href="{{ route('register') }}" class="text-3xl text-blue-600 font-medium mb-4">Register</a>
                @endif
            </div>
        </div>
        <div class="my-4 mx-8">
            <div class="flex justify-end mb-4">
                <a href="{{ url('/admin/create') }}" class="bg-green-400 text-gray-900 px-4 py-2 rounded-md hover:bg-green-500 transition duration-300">Create User</a>
            </div>

        <table id="userTable" class="w-full border-collapse border my-4 text-blue-400">
            <thead>
                <tr class="bg-gray-900">
                    <th class="border border-black py-2 px-3">Name</th>
                    <th class="border border-black py-2 px-3">Email</th>
                    <th class="border border-black py-2 px-3">Role</th>
                    <th class="border border-black py-2 px-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr class="bg-gray-800">
                    <td class="border border-black py-3 px-4 text-lg">{{ $user->name }}</td>
                    <td class="border border-black py-3 px-4 text-lg">{{ $user->email }}</td>
                    <td class="border border-black py-3 px-4 text-lg">
                        @if ($user->admin == 1)
                        Admin
                        @elseif ($user->admin == 2)
                        Super Admin
                        @else
                        User
                        @endif
                    </td>
                    <td class="border border-black py-3 px-4 text-lg">
                        @if ((Auth::user()->admin == 1 && $user->admin == 0 || Auth::user()->id == $user->id) || Auth::user()->admin == 2)
                                <a href="{{ url('/admin/edit/' . $user->id) }}" class="text-blue-400">Edit</a>
                                @if (Auth::user()->id == $user->id)
                                
                                @else
                                <form method="post" action="{{ url('/admin/delete/' . $user->id) }}"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-400">Delete</button>
                                </form>
                                @endif
                        @elseif (Auth::user()->admin == 2)
                        <a href="{{ url('/admin/edit/' . $user->id) }}" class="text-blue-400">Edit</a>
                        <form method="post" action="{{ url('/admin/delete/' . $user->id) }}"
                            style="display: inline-block;"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-red-400">Delete</button>
                        </form>
                        @else
                        <span class="text-red-400">No Action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="bg-gray-800">
                    <td colspan="4" class="border border-black py-3 px-4 text-lg">No users available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Your existing script tags and closing body and html tags here -->
</body>

</html>
