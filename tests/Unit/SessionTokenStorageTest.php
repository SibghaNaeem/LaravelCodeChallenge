<?php

namespace Tests\Unit;

use App\Services\SessionTokenStorage;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class SessionTokenStorageTest extends TestCase
{
    private SessionTokenStorage $tokenStorage;
    private MockObject|Request $request;
    private MockObject|Store $session;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tokenStorage = new SessionTokenStorage();
        $this->session = $this->createMock(Store::class);
        $this->request = Request::create('/');

        $this->request->setLaravelSession($this->session);
    }

    public function testTokenStorage(): void
    {
        $plainTextToken = 'test_token_123';

        $this->session
            ->expects(self::once())
            ->method('put')
            ->with('access_token', $plainTextToken);

        $this->tokenStorage->store($this->request, $plainTextToken);
    }

    public function testTokenRetrieval(): void
    {
        $plainTextToken = 'test_token_123';

        $this->session
            ->expects(self::once())
            ->method('get')
            ->with('access_token')
            ->willReturn($plainTextToken);

        $token = $this->tokenStorage->get($this->request);

        self::assertEquals($plainTextToken, $token);
    }
}
