<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Bucket Paths
    |--------------------------------------------------------------------------
    |
    | Allows the option for users to define their own location for
    | local/production paths for the s3 bucket
    */
    'bucket_paths' => [
      'local' => 'local/',
      'production' => 'production/'
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Allows the option for users to define their own driver
    */
    'image_driver' => \Intervention\Image\ImageManager::gd(),

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Allows the option for users to define their custom models
    | which will automatically be applied to relationships throughout the package
    */
    'models' => [
        'blog' => [
            'blog' => \SethSharp\BlogCrud\Models\Blog\Blog::class,
            'collection' => \SethSharp\BlogCrud\Models\Blog\Collection::class,
            'comment' => \SethSharp\BlogCrud\Models\Blog\Comment::class,
            'like' => \SethSharp\BlogCrud\Models\Blog\Like::class,
            'tag' => \SethSharp\BlogCrud\Models\Blog\Tag::class,
        ],
        'file' => [
            'file' => \SethSharp\BlogCrud\Models\Blog\File::class,
        ],
        'iam' => [
            'user' => \SethSharp\BlogCrud\Models\Iam\User::class,
        ]
    ]
];