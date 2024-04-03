<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models\TagFactory;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function newFactory()
    {
        return new TagFactory();
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(config('blog-crud.models.blog.blog'), 'blog_tag')
            ->withTimestamps();
    }
}
