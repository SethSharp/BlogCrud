<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models\CollectionFactory;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return new CollectionFactory();
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(config('blog-crud.models.blog.blog'))
            ->withPivot('order')
            ->withTimestamps();
    }

    public function nextOrder(): int
    {
        return $this->blogs()->count() + 1;
    }

    public function getBlogOrder(Blog $blog): ?int
    {
        return $this->blogs()->where('blog_id', $blog->id)?->first()->pivot->order;
    }
}
