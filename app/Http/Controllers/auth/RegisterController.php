<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show registration form.
     */
    public function showRegistrationForm()
    {
        // Your blade is under resources/views/livewire/auth/register.blade.php
        // Return that view (no need to move it).
        return view('livewire.auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:50'],
            'last_name' => ['required','string','max:50'],
            'birthday' => ['required','date'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','confirmed', Password::min(8)],
            'role' => ['required','string'],
        ]);

        // Create user with concatenated name. Only mass-assign fields that exist on User model.
        $user = User::create([
            'name' => trim($data['first_name'] . ' ' . $data['last_name']),
            'email' => $data['email'],
            // If you want automatic hashing via $casts['password' => 'hashed'] that's fine,
            // but we'll explicitly hash to be safe:
            'password' => Hash::make($data['password']),
        ]);

        // Optional: if you use role package (spatie), assign role here.
        // if (method_exists($user, 'assignRole')) {
        //     $user->assignRole(strtolower($data['role']));
        // }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Welcome! Your account has been created.');
    }
}
