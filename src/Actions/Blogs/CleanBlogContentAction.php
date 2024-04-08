<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Actions\Files\DestroyFileAction;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\File;

class CleanBlogContentAction
{
    /**
     * Some things it does:
     * - Adds height styling to images based on height variable provided eg; <img height="322" => <img style="height: 322px"
     * - Any files that exist in the DB that do not exist in the content are removed from S3 and DB levels
     *
     * @param Blog $blog
     * @return Blog
     */
    public function __invoke(Blog $blog): Blog
    {
        // Replace height attribute with style attribute
        $newContent = preg_replace('/height="(\d+)"/', 'style="height: $1px"', $blog->content);

        $blog->update([
            'content' => $newContent
        ]);

        // Sometimes a file may be deleted within the editor, this finds all the file ids and ensures they are all exist
        // otherwise delete the unused ones (s3 and entry)
        $matches = [];
        preg_match_all('/fileid="([^"]+)"/', $blog->content, $matches);

        $fileIds = $matches[1];

        // recent files that need replacing
        File::where('blog_id', $blog->id)
            ->get()
            ->each(function (File $file) use ($fileIds) {
                if (!in_array((string)$file->id, $fileIds)) {
                    app(DestroyFileAction::class)($file);

                    $file->delete();
                }
            });

        return $blog;
    }
}
