<?php

namespace sethsharp\Models\Actions;

use sethsharp\Models\Blog\Blog;

class DeleteBlogAction
{
    public function __invoke(Blog $blog): void
    {
        $blog->delete();
    }
}
