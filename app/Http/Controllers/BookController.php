<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display a listing of books
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    // Store a newly created book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'cover' => 'required|image',
            'price' => 'required|integer',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    // Display the specified book
    public function show(Book $book)
    {
        return response()->json($book, 200);
    }

    // Update the specified book
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'cover' => 'required|image',
            'price' => 'required|integer',
        ]);

        $book->update($validated);

        return response()->json($book, 200);
    }

    // Remove the specified book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
