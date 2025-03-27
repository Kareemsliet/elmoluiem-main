<?php

namespace Database\Seeders;

use App\Models\EducationSystem;
use Illuminate\Database\Seeder;

class EducationSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationSystem::insert([

            ['name' => 'Egyptian National Education System', 'country_id' => 1], // General system
            ['name' => 'Al-Azhar Education System', 'country_id' => 1], // Religious education
            ['name' => 'International Baccalaureate (IB) in Egypt', 'country_id' => 1], // International system
            ['name' => 'American Curriculum in Egypt', 'country_id' => 1], // International system
            ['name' => 'British Curriculum (IGCSE) in Egypt', 'country_id' => 1], // International system
            ['name' => 'German Schools in Egypt (Deutsche Schulen)', 'country_id' => 1], 
            ['name' => 'French Education System in Egypt', 'country_id' => 1], 

            ['name' => 'Saudi National Education System', 'country_id' => 2], 
            ['name' => 'Islamic Education System', 'country_id' => 2], 
            ['name' => 'American Curriculum in Saudi Arabia', 'country_id' => 2],
            ['name' => 'British Curriculum (IGCSE) in Saudi Arabia', 'country_id' => 2], 
            ['name' => 'International Baccalaureate (IB) in Saudi Arabia', 'country_id' => 2], 
            ['name' => 'Indian Curriculum in Saudi Arabia', 'country_id' => 2], 
            ['name' => 'Pakistani Education System in Saudi Arabia', 'country_id' => 2], 

            ['name' => 'UAE National Education System', 'country_id' => 3],
            ['name' => 'American Curriculum in UAE', 'country_id' => 3],
            ['name' => 'British Curriculum (IGCSE) in UAE', 'country_id' => 3],
            ['name' => 'French Education System in UAE', 'country_id' => 3],
            ['name' => 'International Baccalaureate (IB) in UAE', 'country_id' => 3],

        ]);
    }
}
