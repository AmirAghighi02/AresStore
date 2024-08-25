<?php

namespace App\Actions\Fortify;

use App\Enums\Genders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        $input = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'string', 'max:20',  'unique:users,phone'],
            'birth_day' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Genders::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'birth_day' => $input['birth_day'],
            'gender' => $input['gender'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
