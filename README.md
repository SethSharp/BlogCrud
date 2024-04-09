[![Latest Version on Packagist](https://img.shields.io/packagist/v/sethsharp/blog-crud.svg?style=flat-square)](https://packagist.org/packages/sethsharp/blog-crud)

# Blog
A fully developed Laravel Blog CRUD package that allows you to manage blogs, tags & collections.

**How does this package work?**
This package offers a few models and provides a great base for creating a blog page for your project. The main features are:
1. A Blog model with the ability to add Tags and make it part of a Collection
2. Inbuilt role system and policies to control what actions can be performed
3. Built in Factories for easy seeding, development & testing
4. Files to make CRUD easy - including Actions & Requests

**The main 3 models of this package are:**
1. Blog: Containing columns such as `title`, `author_id`, meta related columns and `content` ... and more
2. Tag: A `name` but can be added to a blog (A Blog HasMany Tags) - used to help users understand the base topics of the blog
3. Collection: A `name` and `description` - best used for concepts like a tutorial series (A blog BelongsToOne)

**Example Use Case**
1. A personal blog page which you want an easy implementation for to manage blogs - [check out this repository](https://github.com/SethSharp/portfolio/)
2. A new blog page where you can add multiple users with restrictions through the author rule + additional roles & policies

**What this package does not offer**
1. At this point in time this package does not offer a set of front end components. This is strictly a laravel crud package.
2. Controllers: This package is not subjective so Controllers + additional logic is up to your implementation

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

### Publishing the Migrations
Then to publish the migrations:
`php artisan vendor:publish --tag="blog-crud-migrations"`

### Publishing the Config File
Publish for when you need to edit values to suit your project:

`php artisan vendor:publish --tag="blog-crud-config"`

Things that you can override include:
1. Models: Allows you to create your own models - they are automatically injected into relationships within other package models
2. Image Driver: We use the laravel-intervention library for image resizing - this defaults to `gd()`, but `imagick()` is available
3. Bucket Paths: Allows you to specify your own paths for S3 buckets in local & production environments

### Other Requirements
**File System**
This package does rely on AWS S3 logic when it comes to file uploads, via the Blog Cover or the images you can upload within your blog.
So ensure that your AWS credentials are properly configured, specifically this config file in your project `config/filesystems`:
```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
],
```

**Additional requirements:**

1. It is encouraged that you explore this package, it is very straight forward and simple. But it is necessary
you know what is contained within this package to suit your use case.
However, lets go over some basic use cases.
2. This package implements [CodingLabs Laravel Roles](https://github.com/codinglabsau/laravel-roles), so that configuration will need to be carried out as well (don't worry its nice & easy)

### Models
## Factory Integration
All models integrate a factory for ease of development so make sure to use them.

### Policies
There are policies for each available model in the package to add validation/protection to your routes.
They must be booted in your `AppServiceProvider` like so:
```php
public function boot()
{
    Gate::policy(Blog::class, BlogPolicy::class);
    Gate::policy(Tag::class, TagPolicy::class);
    Gate::policy(Collection::class, CollectionPolicy::class);
}
```

### Update a Blog
```php
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Actions\Blogs\UpdateBlogAction;
use SethSharp\BlogCrud\Requests\Blogs\UpdateBlogRequest;

class UpdateBlogController extends Controller
{
    public function __invoke(Blog $blog, UpdateBlogRequest $updateBlogRequest, UpdateBlogAction $updateBlogAction): RedirectResponse
    {
        $blog = $updateBlogAction($blog, $updateBlogRequest);

        $drafted = (bool)$updateBlogRequest->input('is_draft');

        return redirect()
            ->route('dashboard.blogs.index')
            ->with('success', $blog->title . ' successfully ' . ($drafted ? 'drafted' : 'published'));
    }
}
```
This is an example `UpdateBlogController`, using all the files from the package; `Blog`, `UpdateBlogRequest` & `UpdateBlogAction`.
Reading each of these files will ive you an understanding of what they expect - so its up to you to ensure you pass the correct information.

### How does this package rely on S3
S3 is used for any images used within your content - uploading on the fly or via the blog cover.
Images can be accomplished within the content as well. This can be done using the actions `StoreFileAction` & `DestoryFileAction`. For optimal S3 management you can also use
the `StoreBlogFileRequest` - example [here](https://github.com/SethSharp/Portfolio/blob/main/app/Http/Controllers/Dashboard/Blogs/StoreBlogImageController.php).
This example and the use of the `CleanBlogContentAction` file management at the S3 and DB level at in sync.

If you want to do this the best option is to use the [TipTap Editor](https://tiptap.dev/product/editor)

### Tips
If you wanted to add another column such as `publish_at` to define when to publish the blog through a console command, you just need to define this
attribute by extending the rules in the `UpdateBlogRequest`, then passing that data to `UpdateBlogAction` it will automatically assign that variable. Any
further logic will need to be manually done by yourself.
