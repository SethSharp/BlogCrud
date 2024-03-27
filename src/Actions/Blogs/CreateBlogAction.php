<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;

class CreateBlogAction
{
    public function __invoke(): Blog
    {
        return Blog::create([
            'author_id' => auth()->user()->id,
            'slug' => 'this-is-my-blog',
            'title' => 'This is my blog!',
            'content' => '',
            'is_draft' => true,
        ]);
    }
}
