<?php

namespace SethSharp\BlogCrud\Actions\Tags;

use SethSharp\BlogCrud\Models\Blog\Tag;

class DestroyTagAction
{
    public function __invoke(Tag $tag): void
    {
        $tag->delete();
    }
}
