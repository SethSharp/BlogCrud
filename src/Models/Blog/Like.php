<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SethSharp\BlogCrud\Models\Events\LikeCreatedEvent;

class Like extends Model
{
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => LikeCreatedEvent::class
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(config('blog-crud.models.blog.blog'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('blog-crud.models.iam.user'));
    }
}
