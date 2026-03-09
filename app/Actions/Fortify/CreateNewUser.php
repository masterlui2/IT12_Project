<?php

namespace App\Actions\Fortify;

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
            'last_name'  => ['required', 'string', 'max:255'],
            'birthday'   => ['required', 'date'],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password'    => $this->passwordRules(),
            'human_check' => ['accepted'], // must be checked (value: "1", "true", "on", "yes")
        ];

        Validator::make($input, $rules, [
            'human_check.accepted' => 'Please confirm you are human before registering.',
        ])->validate();

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