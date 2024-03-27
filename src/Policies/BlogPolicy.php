<?php

namespace SethSharp\BlogCrud\Policies;

use SethSharp\BlogCrud\Models\Iam\User;
use SethSharp\BlogCrud\Models\Blog\Blog;

class BlogPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return null;
    }

    public function store(User $user): bool
    {
        return $user->hasRole(User::ROLE_AUTHOR);
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN);
    }

    public function update(User $user, Blog $blog): bool
    {
        return $blog->author_id === $user->id;
    }

    public function view(User $user): bool
    {
        return $user->hasRole(User::ROLE_AUTHOR);
    }
}
