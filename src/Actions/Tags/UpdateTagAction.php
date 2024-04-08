<?php

namespace SethSharp\BlogCrud\Actions\Tags;

use SethSharp\BlogCrud\Models\Blog\Tag;
use SethSharp\BlogCrud\Requests\Tags\StoreTagRequest;
use SethSharp\BlogCrud\Requests\Tags\UpdateTagRequest;

class UpdateTagAction
{
    /**
     * Updates a Tag model
     *
     * @param Tag $tag
     * @param UpdateTagRequest $updateTagRequest
     * @return Tag
     */
    public function __invoke(Tag $tag, UpdateTagRequest $updateTagRequest): Tag
    {
        $tag->update([
            'name' => $updateTagRequest->input('name')
        ]);

        return $tag;
    }
}
