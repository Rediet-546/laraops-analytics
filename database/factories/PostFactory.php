<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        
        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(3, true),
            'slug' => Str::slug($title),
            'status' => 'published',
            'published_at' => now(),
            'user_id' => User::factory(), // Creates a new user automatically
        ];
    }
}