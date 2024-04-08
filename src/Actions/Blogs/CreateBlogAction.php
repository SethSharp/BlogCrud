<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;

class CreateBlogAction
{
    /**
     * Creates a base Blog model for editing
     *
     * @return Blog
     */
    public function __invoke(): Blog
    {
        return Blog::create([
            'author_id' => auth()->user()->id,
            'slug' => 'this-is-my-blog',
            'title' => 'This is my blog!',
            'content' => '',
            'published_at' => null,
        ]);
    }
}
