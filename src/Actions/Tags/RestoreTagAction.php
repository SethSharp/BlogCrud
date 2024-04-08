<?php

namespace SethSharp\BlogCrud\Actions\Tags;

use SethSharp\BlogCrud\Models\Blog\Tag;

class RestoreTagAction
{
    /**
     * Restores a soft deleted Tag model
     *
     * @param Tag $tag
     * @return void
     */
    public function __invoke(Tag $tag): void
    {
        $tag->restore();
    }
}
