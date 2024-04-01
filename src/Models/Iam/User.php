<?php

namespace SethSharp\BlogCrud\Models\Iam;

use Codinglabs\Roles\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use SethSharp\BlogCrud\Models\Blog\Blog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SethSharp\BlogCrud\Database\Factories\UserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens;
    use Notifiable;
    use HasFactory;
    use HasRoles;

    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';

    protected $guarded = [];

    protected static function newFactory()
    {
        return new UserFactory();
    }

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
