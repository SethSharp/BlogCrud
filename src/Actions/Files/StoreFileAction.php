<?php

namespace SethSharp\BlogCrud\Actions\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreFileAction
{
    public function __invoke(UploadedFile $file, int $blogId, string $path = '/content/'): string
    {
        $structure = app()->environment('testing') || app()->environment('local')
            ? config('blog-crud.bucket_paths.local') : config('blog-crud.bucket_paths.production');

        $path = $file->hashName(path: "{$structure}blogs/{$blogId}{$path}");

        Storage::disk('s3')->put($path, $file);

        return $path;
    }
}
