<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchesRandomJokes(): void
    {
        Http::fake([
            'https://official-joke-api.appspot.com/jokes/programming/ten/' => Http::response([
                ["setup" => "What's the object-oriented way to become wealthy?", "punchline" => "Inheritance"],
                ["setup" => "Why did the programmer's wife leave him?", "punchline" => "He didn't know how to commit."],
                ["setup" => "What's the best thing about a Boolean?", "punchline" => "Even if you're wrong, you're only off by a bit."],
                ["setup" => "How many programmers does it take to change a lightbulb?", "punchline" => "None that's a hardware problem"],
                ["setup" => "How do you comfort a designer?", "punchline" => "You give them some space... between the elements."],
                ["setup" => "I was gonna tell you a joke about UDP...", "punchline" => "...but you might not get it."],
                ["setup" => "A SQL query walks into a bar, walks up to two tables and asks...", "punchline" => "'Can I join you?'"],
                ["setup" => "What's the best thing about a Boolean?", "punchline" => "Even if you're wrong, you're only off by a bit."],
                ["setup" => "How do you check if a webpage is HTML5?", "punchline" => "Try it out on Internet Explorer"],
                ["setup" => "3 SQL statements walk into a NoSQL bar. Soon, they walk out", "punchline" => "They couldn't find a table."],
            ])
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withToken($token)
            ->get(route('jokes'));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function testHandlesExternalApiFailure(): void
    {
        Http::fake([
            'https://official-joke-api.appspot.com/jokes/programming/ten/' => Http::response(['message' => 'Api down!'], 500)
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withToken($token)
            ->get(route('jokes'));

        $response->assertStatus(500);
        $response->assertJson(['message' => 'Api down!']);
    }
}
