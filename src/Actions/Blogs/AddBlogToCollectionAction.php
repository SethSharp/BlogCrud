<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Collection;

class AddBlogToCollectionAction
{
    /**
     * Adds Blog to Collection & adds order pivot
     *
     * @param Blog $blog
     * @param Collection $collection
     * @return void
     */
    public function __invoke(Blog $blog, Collection $collection): void
    {
        $order = $collection->blogs()->count();

        $collection->blogs()->attach($blog, [
            'order' => $order + 1
        ]);
    }
}
