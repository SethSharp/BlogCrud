<?php

namespace App\Domain\File\Actions;

use League\Flysystem\Visibility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreFileAction
{
    public function __invoke(UploadedFile $file, int $blogId, string $path = '/content/'): string
    {
        $structure = app()->environment('testing') || app()->environment('local')
            ? 'testing/' : 'production/';

        $filename = uniqid() . '_' . $file->getClientOriginalName();

        $path = $structure . 'blogs/' . $blogId . $path . $filename;
        //        dd($path);

        Storage::disk('s3')->put($path, file_get_contents($file), Visibility::PUBLIC);

        return $path;
    }
}
