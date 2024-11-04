<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeederSeedsTheDatabaseWithTestUser(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        self::assertInstanceOf(User::class, $user);
        self::assertTrue(Hash::check('Test@123', $user->password));
    }
}
