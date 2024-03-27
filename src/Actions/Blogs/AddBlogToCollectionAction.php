<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Collection;

class AddBlogToCollectionAction
{
    public function __invoke(Blog $blog, Collection $collection): void
    {
        $order = $collection->blogs()->count();

        $collection->blogs()->attach($blog, [
            'order' => $order + 1
        ]);
    }
}
