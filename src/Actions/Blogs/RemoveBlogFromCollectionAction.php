<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Collection;

class RemoveBlogFromCollectionAction
{
    /**
     * Removes a Blog from a collection by removing the pivot & re-ordering other pivot entries
     *
     * @param Blog $blogToRemove
     * @param Collection $oldCollection
     * @return void
     * @throws \Exception
     */
    public function __invoke(Blog $blogToRemove, Collection $oldCollection): void
    {
        // remove from pivot
        $originalOrder = $oldCollection->blogs()->where('blog_id', $blogToRemove->id)->first();

        if (is_null($originalOrder)) {
            throw new \Exception("Blog " . $blogToRemove->title . " does not exist in collection " . $oldCollection->title);
        }

        /**
         * blog - 1
         * blog - removed
         * blog - 3
         * blog -4
         *
         * We need to move the order of blogs in positions 3 and 4 down one
         *
         * This logic will get item with the order above the old
         */

        $blogs = $oldCollection->blogs()->where('order', '>', $originalOrder->pivot->order)->get();

        $count = $originalOrder->pivot->order;

        foreach ($blogs as $blog) {
            $oldCollection->blogs()->updateExistingPivot($blog->id, [
                'order' => $count
            ]);

            $count = $count + 1;
        }

        // remove old pivot
        $oldCollection->blogs()->detach($blogToRemove->id);
    }
}
