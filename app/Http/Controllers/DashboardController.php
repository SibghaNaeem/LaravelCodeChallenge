<?php

namespace App\Http\Controllers;

use App\Services\TokenStorageInterface;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 *  DashboardController - fetches jokes from API and displays them on the dashboard
 */
class DashboardController extends Controller
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    public function index(Request $request): View
    {
        $token = $this->tokenStorage->get($request);

        if ($token === null) {
            return view('dashboard', ['error' => 'Access token not found.']);
        }

        try {
            $response = Http::withToken($token)
                ->withHeaders(['Accept' => 'application/json'])
                ->get(route('jokes'));

            if ($response->successful()) {
                return view('dashboard', ['jokes' => $response->json()]);
            }
        } catch(Exception $e) {
            $message = $e->getMessage();
            Log::error($message, [$e->getTrace()]);
        }

        return view('dashboard', ['error' => $message ?? $response->json('message')]);
    }
}
