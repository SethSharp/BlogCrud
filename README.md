# Blog
 A fully develop Blog CRUD package that allows you to manage blogs, using Blog content managing meta data with Tags & Collections.


## Steps for Development
### Installation (via composer)
`composer require sethsharp/blog-crud`

### Adding Service Provider
Add to your `config/app.php`

```php
'providers' => [
    \SethSharp\BlogCrud\BlogServiceProvider::class
]
```

### Publishing Migrations
Then to publish the migrations:
`php artisan vendor:publish --tag="blog-crud-migrations"`