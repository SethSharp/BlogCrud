<?php

namespace SethSharp\BlogCrud\Actions\Collections;

use SethSharp\BlogCrud\Models\Blog\Collection;
use SethSharp\BlogCrud\Requests\Collection\UpdateCollectionRequest;

class UpdateCollectionAction
{
    /**
     * Updates a Collection model & order of attached blogs
     *
     * @param UpdateCollectionRequest $updateCollectionRequest
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke(UpdateCollectionRequest $updateCollectionRequest, Collection $collection): Collection
    {
        $collection->update([
            'title' => $updateCollectionRequest->input('title'),
            'description' => $updateCollectionRequest->input('description')
        ]);

        if ($blogs = $updateCollectionRequest->input('blogs')) {
            foreach ($blogs as $index => $blog) {
                $collection->blogs()->updateExistingPivot($blog['id'], [
                    'order' => $index + 1
                ]);
            }
        }

        return $collection;
    }
}
