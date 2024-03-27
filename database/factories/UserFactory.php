<?php

namespace Sethsharp\BlogCrud\Database\Factories;

use Codinglabs\Roles\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use SethSharp\BlogCrud\Models\Iam\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin(): self
    {
        return $this->afterCreating(function (User $user) {
            $user->roles()->attach([
                Role::whereName(User::ROLE_ADMIN)->first()->id
            ]);
        });
    }

    public function author(): self
    {
        return $this->afterCreating(function (User $user) {
            $user->roles()->attach([
                Role::whereName(User::ROLE_AUTHOR)->first()->id
            ]);
        });
    }
}
