<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use SethSharp\BlogCrud\Models\Events\LikeCreatedEvent;

class Like extends Model
{
    protected $dispatchesEvents = [
        'created' => LikeCreatedEvent::class
    ];
}
