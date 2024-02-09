<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Support\Facades\Factory; // Import the Factory facade
use App\Models\User;

class AuthorControllerTest extends TestCase
{
    use WithFaker;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
       $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    public function testCreateAuthor()
    {
        $data = [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'age' => $this->faker->numberBetween(18, 80),
            'country' => $this->faker->country,
            'genre' => $this->faker->word,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('api')->plainTextToken,
        ])->post('/api/author', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('authors', [
            'name' => $data['name'],
            'gender' => $data['gender'],
            'age' => $data['age'],
            'country' => $data['country'],
            'genre' => $data['genre'],
        ]);
    }
}
