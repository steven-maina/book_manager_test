<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAuthors()
    {
        $authors = Author::all();
        return response()->json($authors);
    }
    public function getAuthorsWithBooks()
    {
        $authors = Author::with('books')->get();
        return response()->json($authors);
    }

    public function getAuthor($id)
    {
        $author = Author::find($id);
        return response()->json($author);
    }

    public function createAuthor(Request $request)
    {
        try {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:authors',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer',
            'country' => 'required|string',
            'genre' => 'required|string',
        ]);
    } catch (ValidationException $e) {
            return response()->json([
            'error' => 'Validation failed',
            'messages' => $e->errors(),
            ], 422);
        }
        $author = Author::create($validatedData);
        if ($author) {
            return response()->json(["success" => true, "message" => "Author " . $request->name . "  created successful"], 201);
        }
        return response()->json(["success"=>false, "message"=>"Author could not be created, please check details and try again"],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
