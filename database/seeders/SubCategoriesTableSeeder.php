<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategory::insert([
            [
                'name' => 'Frontend Development',
                'description' => 'HTML, CSS, JavaScript and frontend frameworks',
                'category_id' => 1
            ],
            [
                'name' => 'Backend Development',
                'description' => 'Server-side programming and database integration',
                'category_id' => 1
            ],
            [
                'name' => 'Full Stack Development',
                'description' => 'Complete web development from front to back',
                'category_id' => 1
            ],
            [
                'name' => 'Android Development',
                'description' => 'Building apps for Android devices',
                'category_id' => 2
            ],
            [
                'name' => 'iOS Development',
                'description' => 'Building apps for Apple devices',
                'category_id' => 2
            ],

            // Data Science Subcategories
            [
                'name' => 'Machine Learning',
                'description' => 'Algorithms that improve through experience',
                'category_id' => 3
            ],
            [
                'name' => 'Data Visualization',
                'description' => 'Graphical representation of data',
                'category_id' => 3
            ],

            // Programming Languages Subcategories
            [
                'name' => 'Python',
                'description' => 'Versatile and beginner-friendly language',
                'category_id' => 4
            ],
            [
                'name' => 'JavaScript',
                'description' => 'The language of the web',
                'category_id' => 4
            ],

            // DevOps Subcategories
            [
                'name' => 'Docker',
                'description' => 'Containerization platform',
                'category_id' => 5
            ],
            [
                'name' => 'AWS',
                'description' => 'Amazon Web Services cloud platform',
                'category_id' => 5
            ],
        ]);
    }
}
