<?php

namespace SethSharp\BlogCrud\Policies;

use SethSharp\BlogCrud\Models\Iam\User;

class CollectionPolicy
{
    public function manage(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN);
    }
}
