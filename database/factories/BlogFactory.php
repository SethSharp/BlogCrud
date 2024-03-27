<?php

namespace Sethsharp\BlogCrud\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Comment;
use SethSharp\BlogCrud\Models\Iam\User;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        $name = fake()->words(8, true);
        $slug = Str::slug($name);

        return [
            'author_id' => User::factory()->create()->id,
            'cover_image' => config('app.cloudfront_url') . $this->getRandomCover(),
            'is_draft' => false,
            'title' => $name,
            'slug' => $slug,
            'meta_title' => fake()->text(20),
            'meta_description' => fake()->text(200),
            'meta_tags' => fake()->text(10),
            'content' => fake()->text(400),
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
                'is_draft' => true
            ]);
        });
    }

    public function published(): self
    {
        return $this->afterCreating(function ($blog) {
            $blog->update([
                'is_draft' => false
            ]);
        });
    }

    protected function getRandomCover(): string
    {
        return $this->coverImages()[array_rand($this->coverImages())];
    }

    private function coverImages(): array
    {
        return [
            'seeding/desk-1.avif',
            'seeding/desk-2.avif',
            'seeding/desk-3.avif',
            'seeding/desk-4.avif',
        ];
    }
}
