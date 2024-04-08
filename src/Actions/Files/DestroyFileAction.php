<?php

namespace SethSharp\BlogCrud\Actions\Files;

use Exception;
use SethSharp\BlogCrud\Models\File;
use Illuminate\Support\Facades\Storage;

class DestroyFileAction
{
    /**
     * Deletes a provided File models path from S3
     *
     * @param File $file
     * @return bool
     */
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
