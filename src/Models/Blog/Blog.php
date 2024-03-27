<?php

namespace SethSharp\BlogCrud\Models\Blog;

use SethSharp\BlogCrud\Models\Iam\User;
use Illuminate\Support\Facades\Cache;
use SethSharp\BlogCrud\Support\Cache\CacheKeys;
use Illuminate\Database\Eloquent\Model;
use SethSharp\BlogCrud\Support\Editor\Nodes\EditorNodes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_draft' => 'bool',
        'published_at' => 'datetime'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(\SethSharp\BlogCrud\Models\Blog\Comment::class, 'blog_comment', 'blog_id', 'comment_id')
            ->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'blog_likes', 'blog_id', 'user_id')
            ->withTimestamps();
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(\SethSharp\BlogCrud\Models\Blog\Collection::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(\SethSharp\BlogCrud\Models\Blog\Tag::class, 'blog_tag')
            ->withTimestamps();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_draft', false);
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where('is_draft', true);
    }

    public function getContent(): string
    {
        // check if cache exists and hasn't been cleared
        if (Cache::has(CacheKeys::renderedBlogContent($this))) {
            return Cache::get(CacheKeys::renderedBlogContent($this));
        }

        return $this->render();
    }

    public function render(): string
    {
        $nodes = \SethSharp\BlogCrud\Models\Blog\app(EditorNodes::class)::$components;

        $result = $this->content;

        foreach ($nodes as $node) {
            $result = str_replace($node::buildHtmlTag(), $node::getReplaceTag(), $result);
        }

        return $this->cacheResult($result);
    }

    public function cacheBlog(): string
    {
        return $this->cacheResult($this->content);
    }

    private function cacheResult(string $content): string
    {
        return Cache::rememberForever(CacheKeys::renderedBlogContent($this), function () use ($content) {
            return $content;
        });
    }

    public function isDraft(): bool
    {
        return $this->is_draft;
    }
}
