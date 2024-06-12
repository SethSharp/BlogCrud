<?php

namespace SethSharp\BlogCrud\Actions\Files;

use SethSharp\BlogCrud\Models\Blog\File;

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
        return app(DeleteS3File::class)($file->path);
    }
}
