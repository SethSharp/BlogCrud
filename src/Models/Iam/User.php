<?php

namespace SethSharp\BlogCrud\Models\Iam;

use Codinglabs\Roles\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use SethSharp\BlogCrud\Models\Blog\Blog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SethSharp\BlogCrud\Database\Factories\UserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        return $this->hasMany(config('blog-crud.models.blog.blog'));
    }

    public function comments(): HasMany
    {
        return $this->hasMany(config('blog-crud.models.blog.comment'))
            ->withTimestamps();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(config('blog-crud.models.blog.like'));
    }

    public function hasLikedBlog(Blog $blog): bool
    {
        return $this->likes()->where('blog_id', $blog->id)->exists();
    }
}
