<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;

class RestoreBlogAction
{
    /**
     * Restores a soft deleted Blog model
     *
     * @param Blog $blog
     * @return void
     */
    public function __invoke(Blog $blog): void
    {
        $blog->restore();
    }
}
