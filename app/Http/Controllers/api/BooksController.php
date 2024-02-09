<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getBooks()
    {
        $books = Book::all();
        return response()->json(["message"=>"Books List","data"=>$books], 200);
    }
    public function getBooksWithAuthor()
    {
        $books = Book::with('author')->get();
        return response()->json(["message"=>"Books List","data"=>$books], 200);
    }

    public function getBook($id)
    {
        $book = Book::with('author')->find($id);
        return response()->json($book);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:books',
                'isbn' => 'required|string|unique:books,isbn',
                'author_id' => 'required|exists:authors,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
            'error' => 'Validation failed',
            'messages' => $e->errors(),
            ], 422);
            }

        $book = Book::create($validatedData);
        if ($book){
        return response()->json(["success"=>true,"message"=>"Book ".$book->name. " added successful" ,'data'=>$book], 201);
        }
        else{
            return response()->json(["success"=>false,"message"=>"Error! Book could not be added" ], 402);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'author_id' => 'required|exists:authors,id',
        ]);
        $book = Book::findOrFail($id);
        $book->update($validatedData);
        return response()->json(["success"=>true, "update book details"=>$book], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
