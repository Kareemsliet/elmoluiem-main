<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use App\Models\EducationSystem;
use App\Models\EducationSystemLevel;
use Illuminate\Database\Seeder;

class EducationSystemLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       EducationLevel::insert([
        [
            'education_system_id' => 1,
            'name' => 'Kindergarten',
            'description' => 'Pre-primary education (ages 4-6)'
        ],
        [
            'education_system_id' => 1,
            'name' => 'Primary Education',
            'description' => 'Grades 1-6 (ages 6-12)'
        ],
        [
            'education_system_id' => 1,
            'name' => 'Preparatory Education',
            'description' => 'Grades 7-9 (ages 12-15)'
        ],
        [
            'education_system_id' => 1,
            'name' => 'Secondary Education',
            'description' => 'Grades 10-12 (ages 15-18)'
        ],

        // Al-Azhar Education System
        [
            'education_system_id' => 2,
            'name' => 'Kindergarten',
            'description' => 'Pre-primary education with Islamic focus'
        ],
        [
            'education_system_id' => 2,
            'name' => 'Primary Stage',
            'description' => 'Grades 1-6 with religious studies'
        ],
        [
            'education_system_id' => 2,
            'name' => 'Preparatory Stage',
            'description' => 'Grades 7-9 with Islamic sciences'
        ],
        [
            'education_system_id' => 2,
            'name' => 'Secondary Stage',
            'description' => 'Grades 10-12 with specialization in religious or scientific sections'
        ],

        // International Baccalaureate (IB) in Egypt
        [
            'education_system_id' => 3,
            'name' => 'Primary Years Programme (PYP)',
            'description' => 'Ages 3-12'
        ],
        [
            'education_system_id' => 3,
            'name' => 'Middle Years Programme (MYP)',
            'description' => 'Ages 11-16'
        ],
        [
            'education_system_id' => 3,
            'name' => 'Diploma Programme (DP)',
            'description' => 'Ages 16-19'
        ],
        [
            'education_system_id' => 3,
            'name' => 'Career-related Programme (CP)',
            'description' => 'Ages 16-19'
        ],

        // American Curriculum in Egypt
        [
            'education_system_id' => 4,
            'name' => 'Elementary School',
            'description' => 'Grades K-5 (ages 5-11)'
        ],
        [
            'education_system_id' => 4,
            'name' => 'Middle School',
            'description' => 'Grades 6-8 (ages 11-14)'
        ],
        [
            'education_system_id' => 4,
            'name' => 'High School',
            'description' => 'Grades 9-12 (ages 14-18)'
        ],

        // British Curriculum (IGCSE) in Egypt
        [
            'education_system_id' => 5,
            'name' => 'Key Stage 1',
            'description' => 'Years 1-2 (ages 5-7)'
        ],
        [
            'education_system_id' => 5,
            'name' => 'Key Stage 2',
            'description' => 'Years 3-6 (ages 7-11)'
        ],
        [
            'education_system_id' => 5,
            'name' => 'Key Stage 3',
            'description' => 'Years 7-9 (ages 11-14)'
        ],
        [
            'education_system_id' => 5,
            'name' => 'IGCSE',
            'description' => 'Years 10-11 (ages 14-16)'
        ],
        [
            'education_system_id' => 5,
            'name' => 'A-Level',
            'description' => 'Years 12-13 (ages 16-18)'
        ],

        // German Schools in Egypt
        [
            'education_system_id' => 6,
            'name' => 'Kindergarten',
            'description' => 'Pre-primary education'
        ],
        [
            'education_system_id' => 6,
            'name' => 'Grundschule',
            'description' => 'Primary school (grades 1-4)'
        ],
        [
            'education_system_id' => 6,
            'name' => 'Sekundarstufe I',
            'description' => 'Lower secondary (grades 5-10)'
        ],
        [
            'education_system_id' => 6,
            'name' => 'Sekundarstufe II',
            'description' => 'Upper secondary (grades 11-12) leading to Abitur'
        ],

        // French Education System in Egypt
        [
            'education_system_id' => 7,
            'name' => 'Maternelle',
            'description' => 'Pre-primary education'
        ],
        [
            'education_system_id' => 7,
            'name' => 'Élémentaire',
            'description' => 'Primary school (CP-CM2)'
        ],
        [
            'education_system_id' => 7,
            'name' => 'Collège',
            'description' => 'Lower secondary (6ème-3ème)'
        ],
        [
            'education_system_id' => 7,
            'name' => 'Lycée',
            'description' => 'Upper secondary (2nde-Terminale) leading to Baccalauréat'
        ],

        // Saudi National Education System
        [
            'education_system_id' => 8,
            'name' => 'Kindergarten',
            'description' => 'Pre-primary education (ages 3-6)'
        ],
        [
            'education_system_id' => 8,
            'name' => 'Primary Education',
            'description' => 'Grades 1-6 (ages 6-12)'
        ],
        [
            'education_system_id' => 8,
            'name' => 'Intermediate Education',
            'description' => 'Grades 7-9 (ages 12-15)'
        ],
        [
            'education_system_id' => 8,
            'name' => 'Secondary Education',
            'description' => 'Grades 10-12 (ages 15-18)'
        ],

        // Islamic Education System (Saudi Arabia)
        [
            'education_system_id' => 9,
            'name' => 'Primary Stage',
            'description' => 'Grades 1-6 with Islamic studies'
        ],
        [
            'education_system_id' => 9,
            'name' => 'Intermediate Stage',
            'description' => 'Grades 7-9 with Islamic sciences'
        ],
        [
            'education_system_id' => 9,
            'name' => 'Secondary Stage',
            'description' => 'Grades 10-12 with religious specialization'
        ],

        // American Curriculum in Saudi Arabia
        [
            'education_system_id' => 10,
            'name' => 'Elementary School',
            'description' => 'Grades K-5 (ages 5-11)'
        ],
        [
            'education_system_id' => 10,
            'name' => 'Middle School',
            'description' => 'Grades 6-8 (ages 11-14)'
        ],
        [
            'education_system_id' => 10,
            'name' => 'High School',
            'description' => 'Grades 9-12 (ages 14-18)'
        ],

        // British Curriculum (IGCSE) in Saudi Arabia
        [
            'education_system_id' => 11,
            'name' => 'Key Stage 1',
            'description' => 'Years 1-2 (ages 5-7)'
        ],
        [
            'education_system_id' => 11,
            'name' => 'Key Stage 2',
            'description' => 'Years 3-6 (ages 7-11)'
        ],
        [
            'education_system_id' => 11,
            'name' => 'Key Stage 3',
            'description' => 'Years 7-9 (ages 11-14)'
        ],
        [
            'education_system_id' => 11,
            'name' => 'IGCSE',
            'description' => 'Years 10-11 (ages 14-16)'
        ],
        [
            'education_system_id' => 11,
            'name' => 'A-Level',
            'description' => 'Years 12-13 (ages 16-18)'
        ],

        // International Baccalaureate (IB) in Saudi Arabia
        [
            'education_system_id' => 12,
            'name' => 'Primary Years Programme (PYP)',
            'description' => 'Ages 3-12'
        ],
        [
            'education_system_id' => 12,
            'name' => 'Middle Years Programme (MYP)',
            'description' => 'Ages 11-16'
        ],
        [
            'education_system_id' => 12,
            'name' => 'Diploma Programme (DP)',
            'description' => 'Ages 16-19'
        ],

        // Indian Curriculum in Saudi Arabia
        [
            'education_system_id' => 13,
            'name' => 'Pre-Primary',
            'description' => 'Kindergarten (ages 3-6)'
        ],
        [
            'education_system_id' => 13,
            'name' => 'Primary',
            'description' => 'Grades 1-5 (ages 6-11)'
        ],
        [
            'education_system_id' => 13,
            'name' => 'Upper Primary',
            'description' => 'Grades 6-8 (ages 11-14)'
        ],
        [
            'education_system_id' => 13,
            'name' => 'Secondary',
            'description' => 'Grades 9-10 (ages 14-16) leading to CBSE/ICSE exams'
        ],
        [
            'education_system_id' => 13,
            'name' => 'Senior Secondary',
            'description' => 'Grades 11-12 (ages 16-18)'
        ],

        // Pakistani Education System in Saudi Arabia
        [
            'education_system_id' => 14,
            'name' => 'Pre-Primary',
            'description' => 'Ages 3-5'
        ],
        [
            'education_system_id' => 14,
            'name' => 'Primary',
            'description' => 'Grades 1-5 (ages 5-10)'
        ],
        [
            'education_system_id' => 14,
            'name' => 'Middle',
            'description' => 'Grades 6-8 (ages 10-13)'
        ],
        [
            'education_system_id' => 14,
            'name' => 'Secondary',
            'description' => 'Grades 9-10 (ages 13-15) leading to Matric exams'
        ],
        [
            'education_system_id' => 14,
            'name' => 'Higher Secondary',
            'description' => 'Grades 11-12 (ages 15-17) leading to HSSC exams'
        ],

        // UAE National Education System
        [
            'education_system_id' => 15,
            'name' => 'Kindergarten',
            'description' => 'Pre-primary education (ages 4-6)'
        ],
        [
            'education_system_id' => 15,
            'name' => 'Cycle 1 (Primary)',
            'description' => 'Grades 1-5 (ages 6-11)'
        ],
        [
            'education_system_id' => 15,
            'name' => 'Cycle 2 (Preparatory)',
            'description' => 'Grades 6-9 (ages 11-14)'
        ],
        [
            'education_system_id' => 15,
            'name' => 'Cycle 3 (Secondary)',
            'description' => 'Grades 10-12 (ages 14-18)'
        ],

        // American Curriculum in UAE
        [
            'education_system_id' => 16,
            'name' => 'Elementary School',
            'description' => 'Grades K-5 (ages 5-11)'
        ],
        [
            'education_system_id' => 16,
            'name' => 'Middle School',
            'description' => 'Grades 6-8 (ages 11-14)'
        ],
        [
            'education_system_id' => 16,
            'name' => 'High School',
            'description' => 'Grades 9-12 (ages 14-18)'
        ],

        // British Curriculum (IGCSE) in UAE
        [
            'education_system_id' => 17,
            'name' => 'Foundation Stage',
            'description' => 'Early Years (ages 3-5)'
        ],
        [
            'education_system_id' => 17,
            'name' => 'Key Stage 1',
            'description' => 'Years 1-2 (ages 5-7)'
        ],
        [
            'education_system_id' => 17,
            'name' => 'Key Stage 2',
            'description' => 'Years 3-6 (ages 7-11)'
        ],
        [
            'education_system_id' => 17,
            'name' => 'Key Stage 3',
            'description' => 'Years 7-9 (ages 11-14)'
        ],
        [
            'education_system_id' => 17,
            'name' => 'IGCSE',
            'description' => 'Years 10-11 (ages 14-16)'
        ],
        [
            'education_system_id' => 17,
            'name' => 'A-Level',
            'description' => 'Years 12-13 (ages 16-18)'
        ],

        // French Education System in UAE
        [
            'education_system_id' => 18,
            'name' => 'Maternelle',
            'description' => 'Pre-primary education'
        ],
        [
            'education_system_id' => 18,
            'name' => 'Élémentaire',
            'description' => 'Primary school (CP-CM2)'
        ],
        [
            'education_system_id' => 18,
            'name' => 'Collège',
            'description' => 'Lower secondary (6ème-3ème)'
        ],
        [
            'education_system_id' => 18,
            'name' => 'Lycée',
            'description' => 'Upper secondary (2nde-Terminale) leading to Baccalauréat'
        ],

        // International Baccalaureate (IB) in UAE
        [
            'education_system_id' => 19,
            'name' => 'Primary Years Programme (PYP)',
            'description' => 'Ages 3-12'
        ],
        [
            'education_system_id' => 19,
            'name' => 'Middle Years Programme (MYP)',
            'description' => 'Ages 11-16'
        ],
        [
            'education_system_id' => 19,
            'name' => 'Diploma Programme (DP)',
            'description' => 'Ages 16-19'
        ],
        [
            'education_system_id' => 19,
            'name' => 'Career-related Programme (CP)',
            'description' => 'Ages 16-19'
        ],
       ]);
    }
}
