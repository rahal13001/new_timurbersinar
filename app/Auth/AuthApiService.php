<?php

namespace App\Auth;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthApiService
{
    /**
     * Attempts to authenticate a user via the summary API.
     *
     * @param array $credentials Typically ['email' => 'user@example.com', 'password' => 'password']
     * @return array|false Returns user data from API on success, false on failure.
     */
    public function attemptLogin(array $credentials): array|false
    {
        $baseUrl = rtrim(env('SUMMARY_API_URL'), '/');
        $loginEndpoint = env('SUMMARY_API_LOGIN_ENDPOINT', '/login');
        $apiUrl = $baseUrl . $loginEndpoint;

        Log::info('AuthApiService: Attempting login.', [
            'url' => $apiUrl,
            'email' => $credentials['email'] // Log email for tracking, NEVER log the password.
        ]);

        try {
            $response = Http::timeout(10)->post($apiUrl, [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ]);

//             Log the complete response from the API for debugging
            Log::info('AuthApiService: Received response from API.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                // *** FIX: Look for the user object inside the 'data' key ***
                if (isset($responseData['data']['user'])) {
                    Log::info('AuthApiService: Login successful and user data found.', ['email' => $credentials['email']]);
                    return $responseData['data']['user']; // Return the nested user object
                }

                Log::warning('AuthApiService: API call was successful but response did not contain a "data.user" key.', [
                    'email' => $credentials['email']
                ]);
                return false;
            }

            Log::warning('AuthApiService: API call failed (non-2xx response).', ['email' => $credentials['email']]);
            return false;
        } catch (\Exception $e) {
            Log::error('AuthApiService: An exception occurred during API call.', [
                'message' => $e->getMessage(),
                'url' => $apiUrl,
            ]);
            return false;
        }
    }
}
