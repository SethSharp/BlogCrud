<?php

namespace SethSharp\BlogCrud\Actions\Collections;

use SethSharp\BlogCrud\Models\Blog\Collection;
use SethSharp\BlogCrud\Requests\Collection\StoreCollectionRequest;

class StoreCollectionAction
{
    public function __invoke(StoreCollectionRequest $storeCollectionRequest): Collection
    {
        return Collection::create([
            'title' => $storeCollectionRequest->input('title'),
            'description' => $storeCollectionRequest->input('description')
        ]);
    }
}
