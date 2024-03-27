<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class)
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
