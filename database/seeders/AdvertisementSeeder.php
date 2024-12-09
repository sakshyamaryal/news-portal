<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Advertisement::create([
            'title' => 'Special Offer!',
            'image_url' => 'storage/advertisements/mega.gif',
            'link_url' => 'https://example.com/special-offer',
            'is_active' => true,
        ]);
    }
}
