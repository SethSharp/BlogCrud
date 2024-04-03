<?php

namespace SethSharp\BlogCrud\Models\Blog;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use SethSharp\BlogCrud\Support\Cache\CacheKeys;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SethSharp\BlogCrud\Support\Editor\Nodes\EditorNodes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models\BlogFactory;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'cover',
        'is_published',
        'published_at_for_humans'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected static function newFactory()
    {
        return new BlogFactory();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(config('blog-crud.models.iam.user'), 'author_id');
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(config('blog-crud.models.blog.comment'), 'blog_comment', 'blog_id', 'comment_id')
            ->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(config('blog-crud.models.iam.user'), 'blog_likes', 'blog_id', 'user_id')
            ->withTimestamps();
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(config('blog-crud.models.blog.collection'));
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(config('blog-crud.models.blog.tag'), 'blog_tag')
            ->withTimestamps();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->whereNull('published_at');
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
        $nodes = app(EditorNodes::class)::$components;

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

    public function cover(): Attribute
    {
        return Attribute::make(
            get: fn() => $this?->cover_image ? Storage::disk('s3')->url($this->cover_image) : null
        );
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn() => (bool)$this->published_at
        );
    }

    public function publishedAtForHumans(): Attribute
    {
        return Attribute::make(
            get: fn() => $this?->published_at ? $this->published_at->diffForHumans() : 'not published yet'
        );
    }
}
