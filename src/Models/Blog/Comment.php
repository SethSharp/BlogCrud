<?php

namespace sethsharp\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use sethsharp\Models\Iam\User;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_comment', 'comment_id', 'blog_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }
}
