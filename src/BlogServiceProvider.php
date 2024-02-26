<?php

namespace Sethsharp\Blog;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'blog-migrations');
    }
}