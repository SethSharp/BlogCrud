<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;

class DeleteBlogAction
{
    /**
     * Soft deletes a Blog model
     *
     * @param Blog $blog
     * @return void
     */
    public function __invoke(Blog $blog): void
    {
        $blog->delete();
    }
}
