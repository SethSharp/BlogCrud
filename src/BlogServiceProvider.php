<?php

namespace SethSharp\BlogCrud;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'blog-crud-migrations');

        $this->publishes([
            __DIR__ . '/../config/blog-crud.php' => config_path('blog-crud.php')
        ], 'blog-crud-config');
    }
}