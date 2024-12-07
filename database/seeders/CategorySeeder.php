<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Politics', 'image' => 'storage/uploads/Politics.jpg'],
            ['name' => 'Sports', 'image' => 'storage/uploads/Sports.jpg'],
            ['name' => 'Entertainment', 'image' => 'storage/uploads/Entertainment.jpg'],
            ['name' => 'Technology', 'image' => 'storage/uploads/Technology.jpg'],
            ['name' => 'Health', 'image' => 'storage/uploads/Health.jpg'],
            ['name' => 'Business', 'image' => 'storage/uploads/Business.jpg'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => strtolower(str_replace(' ', '-', $category['name'])),
                'image' => $category['image'],
            ]);
        }
    }

}
