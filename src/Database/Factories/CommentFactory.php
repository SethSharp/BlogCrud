<?php

namespace Database\Factories\Domain\Blog\Models;

use App\Domain\Iam\Models\User;
use App\Domain\Blog\Models\Comment;
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
