<?php

namespace SethSharp\BlogCrud\Policies;

use SethSharp\BlogCrud\Models\Iam\User;
use SethSharp\BlogCrud\Models\Blog\Blog;

class BlogPolicy
{
    public function before(User $user): ?bool
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

    public function restore(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN);
    }

    public function show(?User $user, Blog $blog): bool
    {
        if (! $blog->is_published) {
            if (auth()->check()) {
                if (! auth()->user()->hasRole([User::ROLE_ADMIN])) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
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
