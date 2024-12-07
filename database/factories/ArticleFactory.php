<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;

class ArticleFactory extends Factory
{
    protected $model = \App\Models\Article::class;

    public function definition()
    {
        $randomStatuses = ['draft', 'published', 'archived'];
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'category_id' => Category::inRandomOrder()->first()->id,
            'author_id' => User::inRandomOrder()->take(10)->first()->id,
            'author_id' => User::inRandomOrder()->take(10)->first()->id,
            'status' => 'published',
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            \App\Models\Image::factory(3)->create(['article_id' => $article->id]); // Attach 3 images
        });
    }
}
