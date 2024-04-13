<?php

namespace SethSharp\BlogCrud\Actions\Files;

use Exception;
use Illuminate\Support\Facades\Storage;

class DeleteS3File
{
    /**
     * Deletes S3 file
     *
     * @param string $path
     * @return bool
     */
    public function __invoke(string $path): bool
    {
        try {
            Storage::disk('s3')->delete($path);

            return true;
        } catch (Exception $e) {
            
            return false;
        }
    }
}
