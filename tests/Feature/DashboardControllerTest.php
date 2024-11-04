<?php

namespace Tests\Feature;

use App\Services\SessionTokenStorage;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use App\Models\User;
use App\Services\TokenStorageInterface;
use Mockery;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    private MockObject|SessionTokenStorage $tokenStorage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tokenStorage = $this->createMock(SessionTokenStorage::class);

        $this->app->instance(TokenStorageInterface::class, $this->tokenStorage);

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testDisplaysErrorMessageWhenTokenIsMissing(): void
    {
        $this->tokenStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn(null);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Access token not found.');
    }

    public function testDisplaysJokesOnDashboard(): void
    {
        Http::fake([
            route('jokes') => Http::response([
                ["setup" => "Why did the programmer always carry a pencil?", "punchline" => "They preferred to write in C#."],
                ["setup" => "Why don't React developers like nature?", "punchline" => "They prefer the virtual DOM."],
                ["setup" => "How many programmers does it take to change a light bulb?", "punchline" => "None that's a hardware problem"],
            ])
        ]);

        $this->tokenStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn('fake_token');

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Why did the programmer always carry a pencil?');
        $response->assertSee('They preferred to write in C#.');
        $response->assertSee("Why don't React developers like nature?");
        $response->assertSee("They prefer the virtual DOM.");
        $response->assertSee('How many programmers does it take to change a light bulb?');
        $response->assertSee("None that's a hardware problem");
    }

    public function testDisplaysErrorMessageWhenApiFails(): void
    {
        Http::fake([
            route('jokes') => Http::response(['message' => 'An error has occurred.'], 500)
        ]);

        $this->tokenStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn('test_token');

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('An error has occurred.');
    }

    public function testDisplaysDefaultErrorMessageWhenApiFails(): void
    {
        Http::fake([
            route('jokes') => Http::response([], 500)
        ]);

        $this->tokenStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn('test_token');

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('No joke found');
    }

    public function testLogsErrorMessageWhenExceptionIsThrown(): void
    {
        $this->tokenStorage
            ->expects(self::once())
            ->method('get')
            ->willReturn('test_token');

        Http::fake(function () {
            throw new Exception('Something went wrong');
        });

        Log::shouldReceive('error')
            ->once()
            ->with('Something went wrong', Mockery::type('array'));

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Something went wrong');
    }
}

