<?php

namespace sethsharp\Models\Actions;

use sethsharp\Models\Blog\Blog;
use sethsharp\Models\Blog\Collection;

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
