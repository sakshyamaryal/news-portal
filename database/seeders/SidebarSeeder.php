<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SidebarSeeder extends Seeder
{
    public function run()
    {
        // Insert top-level menu items
        $settingsId = DB::table('sidebars')->insertGetId([
            'title' => 'Settings',
            'url' => null,
            'icon' => 'fas fa-cog',
            'parent_id' => null,
            'order' => 4,
            'is_active' => true,
            'admin_access_only' => true,
        ]);

        $articlesId = DB::table('sidebars')->insertGetId([
            'title' => 'Articles',
            'url' => null,
            'icon' => 'fas fa-newspaper',
            'parent_id' => null,
            'order' => 5,
            'is_active' => true,
            'admin_access_only' => false,
        ]);

        DB::table('sidebars')->insert([

            [
                'title' => 'Dashboard',
                'url' => '/dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'parent_id' => null,
                'order' => 1,
                'is_active' => true,
                'admin_access_only' => false,
            ],
            [
                'title' => 'Special Offer',
                'url' => '/advertisements',
                'icon' => 'fas fa-ad',
                'parent_id' => null,
                'order' => 2,
                'is_active' => true,
                'admin_access_only' => false,
            ],
            [
                'title' => 'User Management',
                'url' => '/user-management',
                'icon' => 'fas fa-users',
                'parent_id' => null,
                'order' => 3,
                'is_active' => true,
                'admin_access_only' => true,
            ],
            [
                'title' => 'Categories',
                'url' => '/categories',
                'icon' => 'fas fa-list',
                'parent_id' => null,
                'order' => 4,
                'is_active' => true,
                'admin_access_only' => false,
            ],

        ]);

        DB::table('sidebars')->insert([
            [
                'title' => 'Roles and Permission',
                'url' => '/settings/roles',
                'icon' => 'fas fa-user-tag',
                'parent_id' => $settingsId,
                'order' => 2,
                'is_active' => true,
                'admin_access_only' => true,
            ],
            [
                'title' => 'Sidebar Settings',
                'url' => '/settings/sidebar',
                'icon' => 'fas fa-sliders-h',
                'parent_id' => $settingsId,
                'order' => 4,
                'is_active' => true,
                'admin_access_only' => true,
            ],
        ]);

        // Insert submenus under "Articles"
        DB::table('sidebars')->insert([
            [
                'title' => 'Create Article',
                'url' => '/articles/create',  // This is for creating new articles
                'icon' => 'fas fa-plus',
                'parent_id' => $articlesId,
                'order' => 1,
                'is_active' => true,
                'admin_access_only' => true,
            ],
            [
                'title' => 'Article List',
                'url' => '/articles',  
                'icon' => 'fas fa-list',
                'parent_id' => $articlesId,
                'order' => 2,
                'is_active' => true,
                'admin_access_only' => true,
            ],
        ]);
    }
}
