<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hardware',
                'description' => 'Issues related to physical devices',
            ],
            [
                'name' => 'Software',
                'description' => 'Problems with applications or systems',
            ],
            [
                'name' => 'Network',
                'description' => 'Connectivity and infrastructure issues',
            ],
            [
                'name' => 'Account',
                'description' => 'User account and access problems',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']], // Match existing by name
                ['description' => $category['description']] // Update description if changed
            );
        }
    }
}