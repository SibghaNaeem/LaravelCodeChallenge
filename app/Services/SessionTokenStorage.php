<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 *  SessionTokenStorage - manages storing and retrieving an access token from the session.
 */
class SessionTokenStorage implements TokenStorageInterface
{
    public function store(Request $request, string $plainTextToken): void
    {
        $request->session()->put('access_token', $plainTextToken);
    }

    public function get(Request $request): ?string
    {
        return $request->session()->get('access_token');
    }
}
