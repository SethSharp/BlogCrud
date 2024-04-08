<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreBlogCoverAction
{
    /**
     * Stores an Uploaded file to a S3 bucket
     *
     * @param UploadedFile $file
     * @param int $blogId
     * @param string $path
     * @return string
     */
    public function __invoke(UploadedFile $file, int $blogId, string $path = '/cover-images/'): string
    {
        $newFile = config('blog-crud.image_driver')->read($file)->scale(500, 500)->encode();

        $structure = app()->environment('testing') || app()->environment('local')
            ? config('blog-crud.bucket_paths.local') : config('blog-crud.bucket_paths.production');

        $filename = uniqid() . '_' . $file->getClientOriginalName();

        $path = $structure . 'blogs/' . $blogId . '/cover-images/' . $filename;

        Storage::disk('s3')->put($path, $newFile);

        return $path;
    }
}
