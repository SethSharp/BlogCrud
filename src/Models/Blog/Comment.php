<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SethSharp\BlogCrud\Models\Events\CommentCreatedEvent;
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

    public function blog(): BelongsTo
    {
        return $this->belongsTo(config('blog-crud.models.blog.blog'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('blog-crud.models.iam.user'));
    }
}
