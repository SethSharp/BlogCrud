<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreBlogCoverAction
{
    public function __invoke(UploadedFile $file, int $blogId, string $path = '/cover-images/'): string
    {
        $newFile = config('blog-crud.image_driver')->read($file)->scale(500, 500)->encode();

        $structure = app()->environment('testing') || app()->environment('local')
            ? config('blog-crud.buckets.local') : config('blog-crud.bucket_paths.production');

        $path = $structure . 'blogs/' . $blogId . '/cover-image.' . $file->getClientOriginalExtension();

        Storage::disk('s3')->put($path, $newFile);

        return $path;
    }
}
