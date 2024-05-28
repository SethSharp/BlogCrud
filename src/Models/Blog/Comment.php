<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SethSharp\BlogCrud\Models\Events\CommentCreatedEvent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => CommentCreatedEvent::class
    ];

    protected static function newFactory()
    {
        return new CommentFactory();
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(config('blog-crud.models.blog.blog'), 'blog_comment', 'comment_id', 'blog_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(config('blog-crud.models.iam.user'), 'id');
    }
}
