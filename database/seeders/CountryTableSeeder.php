<?php

namespace Database\Seeders;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::insert([
            ['code' => '+20', 'name' => 'Egypt'],
            ['code' => '+966', 'name' => 'Saudi Arabia'],
            ['code' => '+971', 'name' => 'United Arab Emirates'],
        ]);
    }
}
