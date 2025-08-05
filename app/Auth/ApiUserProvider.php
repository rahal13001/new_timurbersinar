<?php
namespace App\Auth;

use App\Models\User;
use App\Auth\AuthApiService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiUserProvider implements UserProvider
{
    // NOTE: We are not using a constructor to avoid dependency injection issues during boot.
    // The AuthApiService will be resolved from the container inside the methods where it's needed.

    /**
     * Retrieve a user by the given credentials.
     * This is the core method for Auth::attempt().
     */
    public function retrieveByCredentials(array $credentials)
    {
        // We only care about email/password for this provider.
        if (empty($credentials) || (count($credentials) === 1 && array_key_exists('password', $credentials) === false)) {
            return null;
        }

        // Resolve the service from the container here
        $authApiService = app(AuthApiService::class);
        $apiUserData = $authApiService->attemptLogin($credentials);

        if (! $apiUserData) {
            return null; // API authentication failed.
        }

        // API auth was successful, so find or create the user locally.
        return User::updateOrCreate(
            ['summary_user_id' => $apiUserData['id']],
            [
                'email' => $apiUserData['email'],
                'name' => $apiUserData['name'] ?? 'User from API',
//                'summary_user_id' => $apiUserData['id'],
                'password' => Hash::make(Str::random(60)), // Set a dummy, unusable password.
                'email_verified_at' => $apiUserData['email_verified_at'] ?? now(),
                'jabatan' => $apiUserData['jabatan'] ?? '',
                'nip' => $apiUserData['nip'] ?? '',
                'status' => $apiUserData['status'] ?? 0,
            ]
        );
    }

    /**
     * Validate a user against the given credentials.
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        // Resolve the service and re-run the API check to ensure the password is still valid.
        return (bool) app(AuthApiService::class)->attemptLogin($credentials);
    }

    /**
     * Rehash the user's password if required.
     */
    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
        // Since passwords are not stored locally and are validated by the external API,
        // this method does not need to do anything. It's here to satisfy the UserProvider interface.
    }

    public function retrieveById($identifier)
    {
        return User::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null; // Not used for this auth method.
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }

    /**
     * Get the user model. This is needed for command-line tools like Filament Shield.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }
}
