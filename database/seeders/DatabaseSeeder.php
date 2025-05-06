<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountryTableSeeder::class,
            EducationSystemTableSeeder::class,
            EducationSystemLevelsTableSeeder::class,
            SubjectTableSeeder::class,
            TeachersTableSeeder::class,
            CategoriesTableSeeder::class,
            SubCategoriesTableSeeder::class,
            CoursesTableSeeder::class,
            LessonsTableSeeder::class,
        ]);
    }
}
