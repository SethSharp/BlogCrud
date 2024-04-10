<?php

namespace SethSharp\BlogCrud\Actions\Blogs;

use SethSharp\BlogCrud\Models\File;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Actions\Files\DestroyFileAction;

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
        /**
         * Any files with the height attribute is converted to a style
         */
        $newContent = preg_replace('/height="(\d+)"/', 'style="height: $1px"', $blog->content);

        $blog->update([
            'content' => $newContent
        ]);

        /**
         * Files may be removed from the editor, this searches for the existing file ids (fileid="id") within the content
         * With this we get all the files attached to the blog - looping over each one to see if the file exists within
         * the content. If not, we destroy the file at the S3 and DB level
         */
        $matches = [];
        preg_match_all('/fileid="([^"]+)"/', $blog->content, $matches);

        $fileIds = $matches[1];

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
