<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 *  TokenStorageInterface - Contract for storing and retrieving an access token facade.
 */

interface TokenStorageInterface
{
    public function store(Request $request, string $plainTextToken): void;

    public function get(Request $request): ?string ;
}
