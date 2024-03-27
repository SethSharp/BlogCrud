<?php


namespace SethSharp\BlogCrud\Support\Cache;

use SethSharp\BlogCrud\Models\Blog\Blog;

class CacheKeys
{
    public static function renderedBlogContent(Blog $blog): string
    {
        return 'blog-' . $blog->id . '-rendered-content';
    }
}
