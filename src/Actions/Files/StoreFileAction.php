<?php

namespace SethSharp\BlogCrud\Actions\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreFileAction
{
    /**
     * Stores an Uploaded file to a S3 bucket
     * @param UploadedFile $file
     * @param int $blogId
     * @param string $path
     * @return string
     */
    public function __invoke(UploadedFile $file, int $blogId, string $path = '/content/'): string
    {
        $structure = app()->environment('testing') || app()->environment('local')
            ? config('blog-crud.bucket_paths.local') : config('blog-crud.bucket_paths.production');

        $filename = uniqid() . '_' . $file->getClientOriginalName();

        $path = $structure . 'blogs/' . $blogId . $path . $filename;

        Storage::disk('s3')->put($path, file_get_contents($file));

        return $path;
    }
}
