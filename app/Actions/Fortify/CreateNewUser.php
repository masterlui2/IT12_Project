<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'birthday'   => ['required', 'date'],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'g-recaptcha-response' => [
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $siteKey   = (string) config('services.recaptcha.site_key');
                    $secretKey = (string) config('services.recaptcha.secret_key');

                    if ($siteKey === '' || $secretKey === '') {
                        $fail('Captcha is not configured. Please contact support.');
                        return;
                    }

                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret'   => $secretKey,
                        'response' => $value,
                    ]);

                    if (! $response->ok() || ! $response->json('success')) {
                        $fail('Captcha verification failed. Please try again.');
                    }
                },
            ],
        ];

        Validator::make($input, $rules)->validate();

        session()->forget('human_challenge_answer');

        return User::create([
            'firstname' => $input['first_name'],
            'lastname'  => $input['last_name'],
            'birthday'  => $input['birthday'],
            'email'     => $input['email'],
            'password'  => $input['password'],
            'role'      => 'customer',
        ]);
    }
}