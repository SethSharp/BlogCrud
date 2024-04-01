<?php

namespace SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models;

use SethSharp\BlogCrud\Models\Iam\User;
use SethSharp\BlogCrud\Models\Blog\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'comment' => $this->faker->text(100),
        ];
    }
}
