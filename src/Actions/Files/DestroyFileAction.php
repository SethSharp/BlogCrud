<?php

namespace SethSharp\BlogCrud\Actions\Files;

use Exception;
use App\Domain\File\Models\File;
use Illuminate\Support\Facades\Storage;

class DestroyFileAction
{
    public function __invoke(File $file): bool
    {
        try {
            Storage::disk('s3')->delete($file->path);

            return true;
        } catch (Exception $e) {
            
            return false;
        }
    }
}
