<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class BookController extends Controller
{
    // Display a listing of books
    public function index()
    {
        return new BookCollection(Book::paginate(16));
        // return response()->json(Book::all(), 200);
    }

    // Store a newly created book
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'cover' => 'required|string',
                'price' => 'required|integer',
            ]);

            $book = Book::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Libro Aggiunto',
                'data' => $book
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 201);
        }

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

    public function getFavorites() {
        return new BookCollection(Auth::user()->getFavoriteItems(Book::class)->paginate());
    }

    public function getUserFavorites(Request $request, User $user) {
        return new BookCollection($user->getFavoriteItems(Book::class)->paginate());
    }

    public function addToFavorites(Request $request, Book $book) {
        $request->user()->toggleFavorite($book);

        return response()->json([
            'book' => $book,
            'isFavorited' => $request->user()->hasFavorited($book),
        ], 200);
    }

    // Remove the specified book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
