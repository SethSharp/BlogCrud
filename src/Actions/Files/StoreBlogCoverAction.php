<?php

namespace App\Domain\File\Actions;

use League\Flysystem\Visibility;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class StoreBlogCoverAction
{
    public function __invoke(UploadedFile $file, int $blogId, string $path = '/cover-images/'): string
    {
        $newFile = ImageManager::gd()->read($file)->scale(500, 500)->encode();

        $structure = app()->environment('testing') || app()->environment('local')
            ? 'testing/' : 'production/';

        $filename = uniqid() . '_' . $file->getClientOriginalName();

        $path = $structure . 'blogs/' . $blogId . $path . $filename;

        Storage::disk('s3')->put($path, $newFile, Visibility::PUBLIC);

        return $path;
    }
}
