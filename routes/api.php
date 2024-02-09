<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BooksController;
use App\Http\Controllers\api\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/add/user', [AuthController::class, 'store']);
    Route::post('/users/list', [AuthorController::class, 'index']);

    Route::get('/books', [BooksController::class, 'getBooks']);
    Route::get('/books-with-authors', [BooksController::class, 'getBooksWithAuthor']);
    Route::get('/book/{id}', [BooksController::class, 'getBook']);
    Route::post('/book', [BooksController::class, 'store']);
    Route::put('/book/{id}', [BooksController::class, 'update']);

    Route::get('/authors', [AuthorController::class, 'getAuthors']);
    Route::get('/authors-with-books', [AuthorController::class, 'getAuthorsWithBooks']);
    Route::get('/author/{id}', [AuthorController::class, 'getAuthor']);
    Route::post('/author', [AuthorController::class, 'createAuthor']);
});

