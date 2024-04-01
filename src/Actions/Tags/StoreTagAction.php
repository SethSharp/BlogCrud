<?php

namespace SethSharp\BlogCrud\Actions\Tags;

use SethSharp\BlogCrud\Models\Blog\Tag;
use SethSharp\BlogCrud\Requests\Tags\StoreTagRequest;

class StoreTagAction
{
    public function __invoke(StoreTagRequest $storeTagRequest): Tag
    {
        return Tag::create([
            'name' => $storeTagRequest->input('name')
        ]);
    }
}
