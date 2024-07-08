<header class="px-5 sticky top-0 bg-gray-900 py-5 opacity-95 backdrop-blur-sm z-10">
    <nav class="container mx-auto flex items-center justify-between opacity-100">
        @if (Auth::check())
        <div class="text-3xl font-bold mb-4">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="font-bold text-indigo-500 hover:underline">Logout</button>
            </form>
        @else
        <a href="{{ route('login') }}" class="text-3xl font-bold mb-4">Login as Admin</a>
        @endif
        </div>
        <div class="text-center text-blue-400 justify-center items-center space-x-4 hidden sm:flex flex-grow">
            <a href="{{ url('/landing') }}"><h1 class="text-3xl font-bold mb-4">Book Collection Management</h1></a>
        </div>
        <div class="flex space-x-4">
            @if (Auth::check())
            <span class="font-extrabold text-blue-400">Hello, {{ Auth::user()->name }}! <br> Welcome Back!</span><br>
            @else
            <a href="{{ route('register') }}" class="text-3xl font-bold mb-4">Register</a>
            @endif
        </div>
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