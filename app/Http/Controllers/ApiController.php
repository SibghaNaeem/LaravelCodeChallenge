<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * ApiController - fetches programming jokes from an external API and returns a random selection.
 */
class ApiController extends Controller
{
    private string $apiEndpoint = 'https://official-joke-api.appspot.com/jokes/programming/ten/';

    public function jokes(): JsonResponse
    {
        $apiResponse = Http::get($this->apiEndpoint);

        if ($apiResponse->successful()) {
            $randomJokes = Arr::random($apiResponse->json(), 3);
            return response()->json($randomJokes);
        }

        return response()->json($apiResponse->json(), $apiResponse->getStatusCode());
    }
}
