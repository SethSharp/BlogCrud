<?php


namespace sethsharp\Support\Cache;

use sethsharp\Models\Blog\Blog;

class CacheKeys
{
    public static function renderedBlogContent(Blog $blog): string
    {
        return 'blog-' . $blog->id . '-rendered-content';
    }
}
