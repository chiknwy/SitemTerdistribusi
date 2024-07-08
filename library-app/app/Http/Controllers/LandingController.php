<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $title = "Landing Page";


        $books = Book::take(6)->get(); // Assuming you want to display 4 featured books

        return view('frontpage.landing', compact('title','books'));
    }
}
