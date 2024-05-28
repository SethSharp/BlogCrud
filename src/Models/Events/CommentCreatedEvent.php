<?php

namespace SethSharp\BlogCrud\Models\Events;

use Illuminate\Support\Facades\Event;
use SethSharp\BlogCrud\Models\Blog\Comment;

class CommentCreatedEvent extends Event
{
    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
