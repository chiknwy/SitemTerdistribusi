<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Book Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
        body {
            background-color: #1a1c24; /* Dark background color */
            color: #60a5fa; /* Text color */
        
        }
    
        *::-webkit-scrollbar {
            display: none;
        }


        /* Add any additional styles for the landing page header if needed */
    </style>
</head>



<body class="bg-gray-900 text-blue-400">
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
                <a href="{{ url('/books') }}"><h1 class="text-3xl font-bold mb-4">Book Collection Management</h1></a>
            </div>
            <div class="flex space-x-4">
                @if (Auth::check())
                <span class="font-extrabold text-blue-400">Hello, {{ Auth::user()->name }}! <br> Welcome Back!</span><br>
                @else
                <a href="/register" class="text-3xl text-blue-600 font-medium mb-4">Register</a>
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

    <div class="container mx-auto p-4">

        <!-- Welcome Section -->
<section class="bg-gray-800 p-10 rounded-lg shadow-lg mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-4 text-green-200">Uncover the Magic of Book Management</h1>
        <p class="mt-4 text-lg text-blue-200">
            Welcome, avid reader, to a realm where words come alive and stories become your companions. Dive into the heart of Book Management System, where the ordinary transforms into the extraordinary, and each book is a gateway to a new adventure.

            Imagine a library where every book whispers secrets, beckoning you to explore its pages. Our collection isn't just a compilation of titles; it's a curated selection of worlds waiting to be discovered. Whether you seek tales of mystery, romance, or adventure, our shelves hold the keys to realms you've yet to explore.

            Here, book management isn't just about cataloging; it's about unlocking the mysteries that lie within the covers. Your journey with us is more than a collection—it's a story waiting to be written. So, embark on this literary odyssey, where every click opens a door to new possibilities.

            Let the adventure begin. Welcome to Book Collection Management—your portal to a universe of stories.
        </p>
    </div>
</section>


        <div class="custom-container mx-auto p-8 bg-purple-800 rounded-lg shadow-lg text-center mb-8">
            <p class="text-2xl font-bold text-yellow-400 mb-4">Get Started with Book Management!</p>
            <a href="{{ url("/books/") }}" class="text-blue-400 inline-block px-6 py-3 bg-gray-700 rounded-full hover:bg-gray-600 transition duration-300">Explore Now</a>
        </div>

        <!-- About Section -->
<section class="bg-gray-800 p-10 rounded-lg shadow-lg mb-8">
    <h2 class="text-3xl font-bold text-green-200">About Us</h2>
    <p class="mt-4 text-lg text-blue-200">
        Embark on a literary journey with us, where pages transform into portals and words weave enchanting tales. At Book Collection Management, we don't just curate stories; we curate experiences. Immerse yourself in a world where the ordinary becomes extraordinary, and every book is a gateway to uncharted realms.

        Our passion for literature transcends the ordinary. We believe in the power of storytelling to ignite imaginations, spark conversations, and create connections. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Sed ut ullamcorper nisl. In hac habitasse platea dictumst. Nullam malesuada vel turpis eget posuere.

        Join us on this odyssey of words, where every page turned is a step into a universe waiting to be discovered. Let the stories unfold, and let your journey with Book Collection Management begin.
    </p>
</section>


        <!-- Featured Books Section -->
        <section id="featuredbook" class="bg-gray-800 p-10 rounded-lg shadow-lg mb-8">
            <h2 class="text-3xl font-bold text-green-200">Featured Books</h2>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if ($books->isEmpty())
                 
                @else
                    @forelse ($books as $book)
                        <div class="bg-gray-700 p-6 h-full rounded-lg shadow-md"> <!-- Added "h-full" class -->
                            <h3 class="text-xl font-semibold text-blue-400">{{ $book->title }}</h3>
                            <p class="mt-2 text-blue-200">{{ $book->author }}</p>
                        </div>
                    @empty
                        <p class="text-lg">No featured books available</p>
                    @endforelse
                @endif
            </div>
        </section>
        

    </div>

    <!-- Include your scripts and additional elements as needed -->

</body>

</html>
