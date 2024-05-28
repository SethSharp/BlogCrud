<?php

namespace SethSharp\BlogCrud\Models\Events;

use Illuminate\Support\Facades\Event;
use SethSharp\BlogCrud\Models\Blog\Like;

class LikeCreatedEvent extends Event
{
    public Like $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}
