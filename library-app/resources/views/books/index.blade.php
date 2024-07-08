<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        div.dataTables_wrapper div.dataTables_filter input {
            background-color: #111827;
            color: #60a5fa;
            border: 1px solid #60a5fa;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_length label {
            color: #60a5fa;
        }

        .dataTables_wrapper .dataTables_length select {
            background-color: #111827;
            color: #60a5fa;
            border: 1px solid #60a5fa;
            border-radius: 4px;
            padding: 4px;
            outline: none;
        }

        #myTable_paginate {
            margin-top: 10px;
        }

        #myTable_previous,
        #myTable_next {
            background-color: #111827;
            color: #60a5fa;
            border: 1px solid #60a5fa;
            border-radius: 4px;
            padding: 8px 12px;
            margin-right: 5px;
            cursor: pointer;
        }

        #myTable_previous:hover,
        #myTable_next:hover {
            background-color: #333;
        }

        #myTable_paginate .paginate_button:not(:last-child),
        #myTable_paginate .paginate_button:last-child {
            margin-right: 10px;
        }

        #myTable {
            border: 1px solid black;
        }

        #myTable tbody {
            background-color: rgba(14, 15, 25, 0.433);
        }
        *::-webkit-scrollbar {
            display: none;
        }
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
                <a href="{{ url('/landing') }}"><h1 class="text-3xl font-bold mb-4">Book Collection Management</a>
            </div>
            
                <div class=" space-x-4  mb-4">
                @if (Auth::check())
                   Hello :)
    
                @else
                <a href="/register" class="text-3xl text-blue-600 font-medium mb-4">Register</a>
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
            <h1 class="text-3xl font-bold mb-4 text-blue-400">Book Collection</h1>
            <div class=" space-x-4  mb-4">
            @if (Auth::check())
                <span class="font-bold text-blue-400">Hello, {{ Auth::user()->name }}!
                @if (Auth::user()->admin == 1)
                    You're an admin! <a href="{{ url('/admin') }}" class="inline text-red-500 ">Admin Control Panel (clickhere) </a>

                @elseif (Auth::user()->admin == 2)
                    You're a super admin! <a href="{{ url('/admin') }}" class="inline text-red-500 ">Admin Control Panel (clickhere) </a>

                @endif  <br> Welcome Back!  <a href="{{ url('/profile') }}" class="inline text-red-500 ">Profile Settings (clickhere) </a>

            @endif
        </div>
    </div>
        

        @if (Auth::check())
        <div class="flex justify-start mb-4">
            <a href="{{ url('/books/create') }}" class="text-blue-400 inline-block"  >Add New Book</a>
        </div>
        @else
        <div class="flex justify-start mb-4">
            <a href="/login" class="text-blue-400 inline-block">Login to Add New Book</a>
        </div>
        @endif

        <table id="myTable" class="w-full border-collapse border my-4 text-blue-400">
            <thead>
                <tr class="bg-gray-900">
                    <th class="border border-black py-2 px-3">Title</th>
                    <th class="border border-black py-2 px-3">Author</th>
                    <th class="border border-black py-2 px-3">ISBN</th>
                    <th class="border border-black py-2 px-3">Details</th>
                    <th class="border border-black py-2 px-3">Book Manager</th>
                    <th class="border border-black py-2 px-3">Book Image</th>
                    <th class="border border-black py-2 px-3">Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                <tr class="bg-gray-800">
                    <td class="border border-black py-3 px-4 text-lg">{{ $book->title }}</td>
                    <td class="border border-black py-3 px-4 text-lg">{{ $book->author }}</td>
                    <td class="border border-black py-3 px-4 text-lg">{{ $book->isbn }}</td>
                    <td class="border border-black py-3 px-4 text-lg">{{ $book->details }}</td>
                    <td class="border border-black py-3 px-4 text-lg">{{ optional($book->user)->name }}</td>
                    <td class="border border-black py-3 px-4 w-10 h-10">
                        <img src="{{ asset('images/' . $book->image) }}" alt="Book Image" style="max-width: 200px; max-height: 200px;">
                    </td>
                    
                    <td class="border border-black py-3 px-4">
                        @if (Auth::check())

                            @if (Auth::user()->admin == 1 || Auth::user()->id == $book->user_id || Auth::user()->admin == 2)
                                
                            
                            <a href="{{ url('/books/' . $book->id . '/edit') }}" class="text-blue-400" >Edit</a>
                            <form method="post" action="{{ url('/books/' . $book->id) }}" onsubmit="return confirmAndAlert('Are you sure you want to delete this book?', 'Deleted')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-400">Delete</button>
                            </form>
                            @else
                            <span class="text-red-500">You're not the manager of the books! Cannot edit nor delete!</span>
                            @endif
                        @else
                        <span class="text-red-500">You're not logged in! Cannot edit nor delete!</span>
                        @endif
                    </td>
                    
                    
                </tr>
                @empty
                <tr class="bg-gray-800">
                    <td colspan="6" class="border border-black py-3 px-4 text-lg">No books available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
         document.addEventListener('DOMContentLoaded', function () {
        var successMessage = '{{ session('success') }}';
        var action = '{{ session('action') }}';

        if (successMessage && action) {
            alert(successMessage);

            // You can customize the alert message based on the action
            // if (action === 'create') {
            //     alert('New book created!');
            // } else if (action === 'edit') {
            //     alert('Book updated!');
            // }
        }
        });
            function showAlert(action) {
                alert(action );
            }

            function confirmAndAlert(message, action) {
                var confirmed = confirm(message);
                if (confirmed) {
                    showAlert(action);
                }
                return confirmed;
            }

            $(document).ready(function () {
                let table = $('#myTable').DataTable({
                    "lengthMenu": [5, 10, 15, 20, 25, 50, 75, 100],
                    "ordering": true,
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "responsive": true,
                    "columnDefs": [
                        { "orderable": false, "targets": [6] }
                    ],
                });
            });
    </script>
</body>

</html>
