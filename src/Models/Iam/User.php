<?php

namespace SethSharp\BlogCrud\Models\Iam;

use Codinglabs\Roles\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use SethSharp\BlogCrud\Models\Blog\Blog;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SethSharp\BlogCrud\Models\Blog\Comment;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasFactory;
    use HasRoles;

    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';

    public function blog(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comments')
            ->withTimestamps();
    }

    public function likedBlogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_likes', 'user_id', 'blog_id');
    }
}
