<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'isbn' => 'nullable|max:20',
            'publisher' => 'nullable|max:255',
            'publication_year' => 'nullable|integer',
            'description' => 'nullable',
            'student_id' => 'nullable|max:50',
            'status' => 'nullable|in:available,borrowed',
        ]);

        Book::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Book added successfully!']);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'isbn' => 'nullable|max:20',
            'publisher' => 'nullable|max:255',
            'publication_year' => 'nullable|integer',
            'description' => 'nullable',
            'student_id' => 'nullable|max:50',
            'status' => 'nullable|in:available,borrowed',
        ]);

        $book->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Book updated successfully!']);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['success' => true, 'message' => 'Book deleted successfully!']);
    }

    public function search(Request $request)
    {
        $studentId = $request->get('student_id');
        $books = Book::where('student_id', 'like', "%{$studentId}%")->get();
        
        return response()->json($books);
    }
}