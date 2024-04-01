<?php

namespace Database\Factories\Domain\Blog\Models;

use App\Domain\Blog\Models\Tag;
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
