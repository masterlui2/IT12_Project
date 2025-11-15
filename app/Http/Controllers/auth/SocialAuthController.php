<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    // GOOGLE
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
            
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to authenticate with Google. Please try again.');
        }
    }

    // FACEBOOK
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
{
    try {
        $fbUser = Socialite::driver('facebook')->user();

        // Use Facebook ID instead of email
        $user = User::updateOrCreate([
            'facebook_id' => $fbUser->getId(),
        ], [
            'name' => $fbUser->getName(),
            'email' => $fbUser->getEmail() ?? $fbUser->getId() . '@facebook.com', // Fallback email
            'password' => bcrypt(Str::random(16)),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
        
    } catch (Exception $e) {
        Log::error('Facebook Login Error: ' . $e->getMessage());
        return redirect()->route('login')
            ->with('error', 'Failed to authenticate with Facebook. Please try again.');
    }
}

    public function terms()
    {
        //return view('legal.terms');
    }

    public function privacy()
    {
        //return view('legal.privacy');
    }
}
