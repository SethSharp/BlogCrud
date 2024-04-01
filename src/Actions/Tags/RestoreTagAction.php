<?php

namespace SethSharp\BlogCrud\Actions\Tags;

use SethSharp\BlogCrud\Models\Blog\Tag;

class RestoreTagAction
{
    public function __invoke(Tag $tag): void
    {
        $tag->restore();
    }
}
