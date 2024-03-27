<?php

namespace sethsharp\Models\Actions;

use App\Domain\File\Actions\DestroyFileAction;
use sethsharp\Models\Blog\Blog;
use sethsharp\Models\File;

class CleanBlogContentAction
{
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
