<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\Article;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        $imageOptions = ['news1.jpg', 'news2.jpg', 'news3.jpg', 'news4.jpg', 'news5.jpg','news6.jpg','news7.jpg','news8.jpg','news9.jpg','news10.jpg'];

        return [
            'file_path' => 'storage/uploads/' . $this->faker->randomElement($imageOptions),
            'file_type' => 'image/jpeg',
            'article_id' => Article::inRandomOrder()->first()->id,
        ];
    }
}

