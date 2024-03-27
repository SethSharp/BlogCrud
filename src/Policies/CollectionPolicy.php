<?php

namespace SethSharp\BlogCrud\Policies;

use SethSharp\BlogCrud\Models\Iam\User;

class CollectionPolicy
{
    public function manage(User $user): bool
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }
}
