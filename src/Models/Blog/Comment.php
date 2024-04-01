<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use SethSharp\BlogCrud\Models\Iam\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Database\Factories\Domain\Blog\Models\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return new CommentFactory();
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_comment', 'comment_id', 'blog_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }
}
