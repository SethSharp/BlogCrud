<?php

namespace Database\Factories\Domain\Blog\Models;

use App\Domain\Blog\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition()
    {
        return [
            'title' => fake()->text(20),
            'description' => fake()->text(100),
        ];
    }
}
