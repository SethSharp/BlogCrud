<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;

class DeleteBlogAction
{
    public function __invoke(Blog $blog): void
    {
        $blog->delete();
    }
}
