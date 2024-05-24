<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\DTOs\User\UserRegisterDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\AccessTokenApiResource;
use App\Http\Resources\Api\User\UserApiResource;
use App\Models\User;
use App\Services\User\UserRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthApiController extends Controller
{
    public function authenticateWithProvider(string $provider)
    {
        // Redirect the user to the Google authentication page
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        try {
            DB::beginTransaction();
            // Retrieve user data from Google
            $providerUser = Socialite::driver($provider)->stateless()->user();

            // Check if the user already exists in your database
            $user = User::where('email', $providerUser->email)->first();

            if (!$user) {
                // Create a new user if they don't exist
                $user = (new UserRegisterService())->store(UserRegisterDTO::from([
                    'name' => $providerUser->name,
                    'email' => $providerUser->email
                ]));
                DB::commit();
            }

            // Generate API token for the user
//            $token = $user->createToken('GoogleToken')->plainTextToken;
            $accessToken = $user->createAccessToken($user);

//            Auth::login($user);
//            return redirect()->intended('/home');

            // Return token as response
            return ResponseHelper::successResponse(data: [
                'user' => UserApiResource::make($user),
                'access_token' => new AccessTokenApiResource($accessToken)
            ]);
        } catch (\Exception $e) {
            // Handle exception if any
            DB::rollBack();
            return ResponseHelper::errorResponse(error: 'Failed to authenticate with ' . $provider);
        }
    }
}
