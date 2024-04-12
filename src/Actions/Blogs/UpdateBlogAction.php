<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Collection;
use SethSharp\BlogCrud\Support\Cache\CacheKeys;
use SethSharp\BlogCrud\Requests\Blogs\UpdateBlogRequest;

class UpdateBlogAction
{
    /**
     * Updates a Blog Model
     *
     * @param Blog $blog
     * @param UpdateBlogRequest $updateBlogRequest
     * @return Blog
     */
    public function __invoke(Blog $blog, UpdateBlogRequest $updateBlogRequest): Blog
    {
        // setup slug based on provided input
        if ($updateBlogRequest->has('slug')) {
            $slug = Str::slug($updateBlogRequest->input('slug'));
        } else {
            $slug = Str::slug($updateBlogRequest->input('title'));
        }

        // attach tags
        if ($tags = $updateBlogRequest->input('tags')) {
            $tags = collect($tags)->pluck('id');
            $blog->tags()->sync($tags);
        }

        // setting published_at logic
        $publishedAt = $blog->published_at;
        if ($updateBlogRequest->input('is_draft')) {
            $publishedAt = null;
        } else {
            if (! $blog->published_at) {
                $publishedAt = now();
            }
        }

        // setting collection logic
        $collection_id = null;
        if (! $updateBlogRequest->has('collection_id')) {
            if ($blog->collection_id) {
                app(RemoveBlogFromCollectionAction::class)($blog, Collection::whereId($blog->collection_id)->first());
            }
        } else {
            // we have a collection_id
            $collection_id = $updateBlogRequest->input('collection_id');

            if (! is_null($collection_id)) {
                // We are providing a collection_id when one already existed
                if ($blog->collection_id) {
                    app(RemoveBlogFromCollectionAction::class)($blog, Collection::whereId($blog->collection_id)->first());
                }

                if (! is_null($collection_id)) {
                    app(AddBlogToCollectionAction::class)($blog, Collection::whereId($collection_id)->first());
                }
            } else {
                app(RemoveBlogFromCollectionAction::class)($blog,  Collection::whereId($blog->collection_id)->first());
            }
        }

        // upload cover image
        $coverImagePath = $blog->cover_image;
        if ($coverImage = $updateBlogRequest->file('cover_image')) {
            $coverImagePath = app(StoreBlogCoverAction::class)($coverImage, $blog);
        }

        // dynamically update model with validated data
        // along with other calculated information
        $blog->update([
            ...$updateBlogRequest->validated(),
            'slug' => $slug,
            'cover_image' => $coverImagePath,
            'published_at' => $publishedAt,
            'collection_id' => $collection_id
        ]);

        $blog = app(CleanBlogContentAction::class)($blog);

        Cache::forget(CacheKeys::renderedBlogContent($blog));

        $blog->render();

        return $blog;
    }
}
