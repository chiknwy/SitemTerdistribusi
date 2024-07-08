<?php

namespace App\Http\Controllers;

// BookController.php

use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class  BookController extends Controller {
    public function index()
    {
        $books = Book::when(request('filter'), function ($query) {
            $query->where('title', 'like', '%' . request('filter') . '%');
        })->paginate(100);

        return view('books.index', compact('books'));
    }
    

    public function create() {
        return view('books.create');
    }



    public function show($id) {
        $book = Book::find($id);
        return view('books.show', compact('book'));
    }

    public function uts(){
        return view('uts.uts');
    }

    public function edit($id) {
        $book = Book::find($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|max:255',
        'author' => 'required|max:255',
        'isbn' => 'required|numeric',
        'details' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $book = Book::find($id);

    // Update other fields
    $book->title = $request->title;
    $book->author = $request->author;
    $book->isbn = $request->isbn;
    $book->details = $request->details;

    // Check if a new image is provided
    if ($request->hasFile('image')) {
        // Delete the existing image if it exists
        if ($book->image) {
            Storage::delete('public/images/' . $book->image);
        }

        // Move the new image to the storage
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        // Update the book with the new image name
        $book->image = $imageName;
    }

    $book->save();

    return redirect('/books')
        ->with('success', 'Book updated successfully.')
        ->with('action', 'edit');
}

public function updateApi(Request $request, $id)
{
    try {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'details' => 'string',
            'isbn' => 'string|unique:books,isbn,' . $id,
            'image' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }

        $book = BookModel::findOrFail($id);
        $book->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Book updated successfully',
            'book' => $book
        ], 200);
    } catch (\Throwable $th) {
        Log::error($th);
        return response()->json([
            'status' => 500,
            'message' => $th->getMessage()
        ], 500);
    }
}
    public function destroy($id) {
        $book = Book::find($id);
    
        // Delete the associated image from local storage
        $imagePath = public_path($book->image); // Assuming image_path is the attribute storing the image path
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    
        // Delete the book record
        $book->delete();
    
        return redirect('/books');
    }
    public function destroyApi($id) {
        $book = Book::find($id);
    
        // Delete the associated image from local storage
        $imagePath = public_path($book->image); // Assuming image_path is the attribute storing the image path
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    
        // Delete the book record
        $book->delete();
    
        return response()->json([
            'status' => 200,
            'message' => 'Book deleted successfully'
        ], 200);
    }
    

    public function admin() {
        $admin = auth()->user();
        $users = User::all();

        if (auth()->check() && $admin->admin == true ) {

            return view('books.admin', compact('users'));
        } else {
            return redirect('/books');
        }
    }
    public function createUser()
{
    return view('admin.create');
}

public function store(Request $request)
{   
    // dd($request->all());
    $request->validate([
        'title' => 'required|max:255',
        'author' => 'required|max:255',
        'isbn' => 'required|string',
        'details' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Check if an image file is present in the request
    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);
    } else {
        // Handle the case where no image is uploaded
        $imageName = null;
    }

    // Set the user_id before saving the book
    $book = new Book($request->all());
    $book->user_id = auth()->user()->id;

    // Store the book data including the image name
    $book->image = $imageName;
    $book->save();

    return redirect('/books')
        ->with('success', 'You have successfully uploaded the book.')
        ->with('action', 'create');
}
public function storeApi(Request $request)
{
    // dd($request->all());
    $request->validate([
        'title' => 'required|max:255',
        'author' => 'required|max:255',
        'isbn' => 'required|string',
        'details' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Check if an image file is present in the request
    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);
    } else {
        // Handle the case where no image is uploaded
        $imageName = null;
    }

    // Set the user_id before saving the book
    $book = new Book($request->all());
    $book->user_id = auth()->user()->id;

    // Store the book data including the image name
    $book->image = $imageName;
    $book->save();

    return response()->json([
        'status' => 200,
        'message' => 'Book created successfully',
        'book' => $book
    ], 200);
}


public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'admin' => '', // You might need to adjust this validation based on your admin field type
    ]);

    $user = new User($request->all());
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect('/admin')->with('success', 'User created successfully.');
}

public function editUser($id)
{   
    $admin = auth()->user();
    $user = User::find($id);
    if (auth()->check() && $admin->admin == true ) {
    return view('admin.edit', compact('user'));
    }else{
        return redirect('/books'); 
    }
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6',
        'admin' => 'numeric',
    ]);

    $user = User::find($id);
    $user->fill($request->except('password')); // Exclude password from fill

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    } else {
        $user->password = $user->getOriginal('password');
    }

    $user->save();

    return redirect('/admin')->with('success', 'User updated successfully.');
}


public function deleteUser($id)
{
    User::find($id)->delete();
    return redirect('/admin')->with('success', 'User deleted successfully.');
}

public function profile()
{
    $users = auth()->user();
    return view('books.profile', compact('users'));
}
}