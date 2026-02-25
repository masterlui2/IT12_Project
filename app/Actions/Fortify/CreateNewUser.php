<?php

namespace App\Actions\Fortify;
use Illuminate\Support\Facades\Http;
use App\Models\User;
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
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
               'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            ];

        $recaptchaEnabled = filled(config('services.recaptcha.site_key'))
            && filled(config('services.recaptcha.secret_key'));

        if ($recaptchaEnabled) {
            $rules['g-recaptcha-response'] = [
                'required',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => (string) config('services.recaptcha.secret_key'),
                        'response' => $value,
                    ]);

                    if (! $response->ok() || ! $response->json('success')) {
                        $fail('Captcha verification failed. Please try again.');
                    }
                },
            ];
        } else {
            $rules['human_challenge_answer'] = [
                'required',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $expected = (string) session('human_challenge_answer', '');

                    if ($expected === '' || trim((string) $value) !== $expected) {
                        $fail('Human verification answer is incorrect.');
                    }
                },
            ];
        }

        Validator::make($input, $rules)->validate();

        session()->forget('human_challenge_answer');
        return User::create([
            'firstname' => $input['first_name'],
            'lastname' => $input['last_name'],
            'birthday' => $input['birthday'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role'=> 'customer',
        ]);
    }
}
