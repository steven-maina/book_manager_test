<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use WithFaker;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }
    public function testGetBooks()
    {
        $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->user->createToken('token')->plainTextToken,
                ])->get('api/books');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'isbn',
                        'author_id',
                        'created_at',
                        'updated_at'
                    ],
                ],
            ]);
    }
    public function testGetBooksWithAuthor()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('token')->plainTextToken,
        ])->get('/api/books-with-authors');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                '*' => [
                    'id',
                    'name',
                    'isbn',
                    'author_id',
                    'created_at',
                    'updated_at',
                    'author' => [
                        'id',
                        'name',
                        'gender',
                        'age',
                        'country',
                        'genre',
                    ],
                ],
                    ]
            ]);
    }

    public function testGetBook()
    {
        $faker = Faker::create();
        $book = Book::create([
            'name' => $faker->sentence(3),
            'isbn' => $faker->isbn13,
            'author_id' => $faker->numberBetween(1, 10),
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('token')->plainTextToken,
        ])->get('/api/book/' . $book->id);

        $response->assertStatus(200)
            ->assertJsonStructure([

                'id',
                'name',
                'isbn',
                'author_id',
                'created_at',
                'updated_at',
                'author' => [
                    'id',
                    'name',
                    'gender',
                    'age',
                    'country',
                    'genre',
                ],

            ]);
    }

    public function testStoreBook()
    {
        $author = Author::create([
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'age' => $this->faker->numberBetween(20, 80),
            'country' => $this->faker->country,
            'genre' => $this->faker->word,
        ]);

        $data = [
            'name' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'author_id' => $author->id,
        ];

    $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('token')->plainTextToken,
        ])->post('/api/book', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data'=>[
                'id',
                'name',
                'isbn',
                'author_id',
                'created_at',
                'updated_at',
                    ]
            ]);
    }

    public function testUpdateBook()
    {
        $faker = Faker::create();
        $book = Book::create([
            'name' => $faker->sentence(3),
            'isbn' => $faker->isbn13,
            'author_id' => $faker->numberBetween(1, 10),
        ]);
        $data = [
            'name' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'author_id' => $book->author_id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('token')->plainTextToken,
        ])->put('/api/book/' . $book->id, $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'update book details'=>[
                'id',
                'name',
                'isbn',
                'author_id',
                'created_at',
                'updated_at',
                    ]
            ]);
    }
}
