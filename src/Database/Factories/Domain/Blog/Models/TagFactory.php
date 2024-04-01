<?php

namespace SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models;

use SethSharp\BlogCrud\Models\Blog\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => 'Tutorial',
        ];
    }
}
