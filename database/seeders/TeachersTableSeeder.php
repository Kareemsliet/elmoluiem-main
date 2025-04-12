<?php

namespace Database\Seeders;

use App\Enums\GenderTypesEnums;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            "name" => 'test',
            "email_verified_at"=>now(),
            "email"=>"taest@gmail.com",
            "phone"=>"0123456789",
            "password"=>"password",
            "address"=>"test address",
            "description"=>"test description",
            "education_level_id"=>1,
            "gender"=>GenderTypesEnums::Male,
        ]);
    }
}
