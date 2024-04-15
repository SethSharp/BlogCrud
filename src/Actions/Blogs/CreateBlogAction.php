<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use Illuminate\Support\Str;
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
        $title = fake()->catchPhrase();

        return Blog::create([
            'author_id' => auth()->user()->id,
            'slug' => Str::slug($title),
            'title' => $title,
            'content' => 'Welcome to my blog post - this is a draft!',
            'published_at' => null,
        ]);
    }
}
