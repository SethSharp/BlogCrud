<?php

namespace App\Domain\Blog\Policies;

use sethsharp\Models\Iam\User;

class TagPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return null;
    }

    public function destroy(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN);
    }

    public function restore(User $user): bool
    {
        return $user->hasRole(User::ROLE_AUTHOR);
    }

    public function store(User $user): bool
    {
        return $user->hasRole(User::ROLE_AUTHOR);
    }

    public function update(User $user): bool
    {
        return $user->hasRole(User::ROLE_AUTHOR);
    }

    public function view(User $user): bool
    {
        return $user->hasRole(User::ROLE_AUTHOR);
    }
}
