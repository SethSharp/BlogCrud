<?php

namespace SethSharp\BlogCrud\Database\Factories\Domain\Blog\Models;

use Illuminate\Support\Str;
use SethSharp\BlogCrud\Models\Iam\User;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        $name = fake()->words(8, true);
        $slug = Str::slug($name);

        return [
            'author_id' => User::factory()->create()->id,
            'cover_image' => $this->getRandomCover(),
            'title' => $name,
            'slug' => $slug,
            'meta_title' => fake()->text(20),
            'meta_description' => fake()->text(200),
            'meta_tags' => fake()->text(10),
            'content' => fake()->text(1000),
            'published_at' => now()
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function ($blog) {
            $comments = Comment::factory()->count(3)->create()->pluck('id');

            $blog->comments()->attach($comments);
        });
    }

    public function draft(): self
    {
        return $this->afterCreating(function ($blog) {
            $blog->update([
                'published_at' => null
            ]);
        });
    }

    public function published(): self
    {
        return $this->afterCreating(function ($blog) {
            $blog->update([
                'published_at' => now()
            ]);
        });
    }

    protected function getRandomCover(): string
    {
        return $this->coverImages()[array_rand($this->coverImages())];
    }

    public static function coverImages(): array
    {
        return [
            'seeding/desk-1.avif',
            'seeding/desk-2.avif',
            'seeding/desk-3.avif',
            'seeding/desk-4.avif',
        ];
    }
}
