<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\EducationSystemLevel;
use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::insert([
            ['education_level_id' => 1, 'name' => 'Arabic'], // Kindergarten
            ['education_level_id' => 1, 'name' => 'Basic Math'],
            ['education_level_id' => 1, 'name' => 'Social Skills'],
            
            ['education_level_id' => 2, 'name' => 'Arabic'], // Primary Education
            ['education_level_id' => 2, 'name' => 'Mathematics'],
            ['education_level_id' => 2, 'name' => 'Science'],
            ['education_level_id' => 2, 'name' => 'Social Studies'],
            ['education_level_id' => 2, 'name' => 'English'],
            
            ['education_level_id' => 3, 'name' => 'Arabic'], // Preparatory Education
            ['education_level_id' => 3, 'name' => 'Mathematics'],
            ['education_level_id' => 3, 'name' => 'Science'],
            ['education_level_id' => 3, 'name' => 'Social Studies'],
            ['education_level_id' => 3, 'name' => 'English'],
            ['education_level_id' => 3, 'name' => 'Second Foreign Language'],
            
            ['education_level_id' => 4, 'name' => 'Arabic'], // Secondary Education
            ['education_level_id' => 4, 'name' => 'Mathematics'],
            ['education_level_id' => 4, 'name' => 'Physics'],
            ['education_level_id' => 4, 'name' => 'Chemistry'],
            ['education_level_id' => 4, 'name' => 'Biology'],
            ['education_level_id' => 4, 'name' => 'English'],
            ['education_level_id' => 4, 'name' => 'Second Foreign Language'],
            ['education_level_id' => 4, 'name' => 'Philosophy'],

            // Al-Azhar Education System (ID: 2)
            ['education_level_id' => 5, 'name' => 'Quran'], // Kindergarten
            ['education_level_id' => 5, 'name' => 'Arabic'],
            ['education_level_id' => 5, 'name' => 'Basic Math'],
            
            ['education_level_id' => 6, 'name' => 'Quran'], // Primary Stage
            ['education_level_id' => 6, 'name' => 'Arabic'],
            ['education_level_id' => 6, 'name' => 'Mathematics'],
            ['education_level_id' => 6, 'name' => 'Science'],
            ['education_level_id' => 6, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 7, 'name' => 'Quran'], // Preparatory Stage
            ['education_level_id' => 7, 'name' => 'Arabic'],
            ['education_level_id' => 7, 'name' => 'Mathematics'],
            ['education_level_id' => 7, 'name' => 'Science'],
            ['education_level_id' => 7, 'name' => 'Islamic Studies'],
            ['education_level_id' => 7, 'name' => 'English'],
            
            ['education_level_id' => 8, 'name' => 'Quran'], // Secondary Stage
            ['education_level_id' => 8, 'name' => 'Arabic'],
            ['education_level_id' => 8, 'name' => 'Mathematics'],
            ['education_level_id' => 8, 'name' => 'Physics'],
            ['education_level_id' => 8, 'name' => 'Chemistry'],
            ['education_level_id' => 8, 'name' => 'Biology'],
            ['education_level_id' => 8, 'name' => 'Islamic Studies'],
            ['education_level_id' => 8, 'name' => 'English'],

            // International Baccalaureate (IB) in Egypt (ID: 3)
            ['education_level_id' => 9, 'name' => 'Language Acquisition'], // PYP
            ['education_level_id' => 9, 'name' => 'Mathematics'],
            ['education_level_id' => 9, 'name' => 'Science'],
            ['education_level_id' => 9, 'name' => 'Social Studies'],
            ['education_level_id' => 9, 'name' => 'Arts'],
            
            ['education_level_id' => 10, 'name' => 'Language and Literature'], // MYP
            ['education_level_id' => 10, 'name' => 'Language Acquisition'],
            ['education_level_id' => 10, 'name' => 'Mathematics'],
            ['education_level_id' => 10, 'name' => 'Sciences'],
            ['education_level_id' => 10, 'name' => 'Individuals and Societies'],
            ['education_level_id' => 10, 'name' => 'Arts'],
            ['education_level_id' => 10, 'name' => 'Physical and Health Education'],
            ['education_level_id' => 10, 'name' => 'Design'],
            
            ['education_level_id' => 11, 'name' => 'Studies in Language and Literature'], // DP
            ['education_level_id' => 11, 'name' => 'Language Acquisition'],
            ['education_level_id' => 11, 'name' => 'Mathematics'],
            ['education_level_id' => 11, 'name' => 'Sciences'],
            ['education_level_id' => 11, 'name' => 'Individuals and Societies'],
            ['education_level_id' => 11, 'name' => 'Arts'],
            ['education_level_id' => 11, 'name' => 'Theory of Knowledge'],
            
            ['education_level_id' => 12, 'name' => 'Career-related Study'], // CP
            ['education_level_id' => 12, 'name' => 'Personal and Professional Skills'],
            ['education_level_id' => 12, 'name' => 'Service Learning'],
            ['education_level_id' => 12, 'name' => 'Reflective Project'],

            // American Curriculum in Egypt (ID: 4)
            ['education_level_id' => 13, 'name' => 'English Language Arts'], // Elementary
            ['education_level_id' => 13, 'name' => 'Mathematics'],
            ['education_level_id' => 13, 'name' => 'Science'],
            ['education_level_id' => 13, 'name' => 'Social Studies'],
            ['education_level_id' => 13, 'name' => 'Art'],
            
            ['education_level_id' => 14, 'name' => 'English Language Arts'], // Middle
            ['education_level_id' => 14, 'name' => 'Mathematics'],
            ['education_level_id' => 14, 'name' => 'Science'],
            ['education_level_id' => 14, 'name' => 'Social Studies'],
            ['education_level_id' => 14, 'name' => 'Foreign Language'],
            
            ['education_level_id' => 15, 'name' => 'English'], // High
            ['education_level_id' => 15, 'name' => 'Mathematics'],
            ['education_level_id' => 15, 'name' => 'Science'],
            ['education_level_id' => 15, 'name' => 'Social Studies'],
            ['education_level_id' => 15, 'name' => 'Foreign Language'],
            ['education_level_id' => 15, 'name' => 'Electives'],

            // British Curriculum (IGCSE) in Egypt (ID: 5)
            ['education_level_id' => 16, 'name' => 'English'], // Key Stage 1
            ['education_level_id' => 16, 'name' => 'Mathematics'],
            ['education_level_id' => 16, 'name' => 'Science'],
            
            ['education_level_id' => 17, 'name' => 'English'], // Key Stage 2
            ['education_level_id' => 17, 'name' => 'Mathematics'],
            ['education_level_id' => 17, 'name' => 'Science'],
            ['education_level_id' => 17, 'name' => 'History'],
            ['education_level_id' => 17, 'name' => 'Geography'],
            
            ['education_level_id' => 18, 'name' => 'English'], // Key Stage 3
            ['education_level_id' => 18, 'name' => 'Mathematics'],
            ['education_level_id' => 18, 'name' => 'Science'],
            ['education_level_id' => 18, 'name' => 'History'],
            ['education_level_id' => 18, 'name' => 'Geography'],
            ['education_level_id' => 18, 'name' => 'Modern Foreign Languages'],
            
            ['education_level_id' => 19, 'name' => 'First Language English'], // IGCSE
            ['education_level_id' => 19, 'name' => 'Mathematics'],
            ['education_level_id' => 19, 'name' => 'Biology'],
            ['education_level_id' => 19, 'name' => 'Chemistry'],
            ['education_level_id' => 19, 'name' => 'Physics'],
            ['education_level_id' => 19, 'name' => 'Foreign Language'],
            
            ['education_level_id' => 20, 'name' => 'English Literature'], // A-Level
            ['education_level_id' => 20, 'name' => 'Mathematics'],
            ['education_level_id' => 20, 'name' => 'Biology'],
            ['education_level_id' => 20, 'name' => 'Chemistry'],
            ['education_level_id' => 20, 'name' => 'Physics'],
            ['education_level_id' => 20, 'name' => 'Foreign Language'],

            // German Schools in Egypt (ID: 6)
            ['education_level_id' => 21, 'name' => 'Deutsch'], // Kindergarten
            ['education_level_id' => 21, 'name' => 'Mathematik'],
            ['education_level_id' => 21, 'name' => 'Sachkunde'],
            
            ['education_level_id' => 22, 'name' => 'Deutsch'], // Grundschule
            ['education_level_id' => 22, 'name' => 'Mathematik'],
            ['education_level_id' => 22, 'name' => 'Sachkunde'],
            ['education_level_id' => 22, 'name' => 'Englisch'],
            
            ['education_level_id' => 23, 'name' => 'Deutsch'], // Sekundarstufe I
            ['education_level_id' => 23, 'name' => 'Mathematik'],
            ['education_level_id' => 23, 'name' => 'Englisch'],
            ['education_level_id' => 23, 'name' => 'Biologie'],
            ['education_level_id' => 23, 'name' => 'Chemie'],
            ['education_level_id' => 23, 'name' => 'Physik'],
            ['education_level_id' => 23, 'name' => 'Geschichte'],
            
            ['education_level_id' => 24, 'name' => 'Deutsch'], // Sekundarstufe II
            ['education_level_id' => 24, 'name' => 'Mathematik'],
            ['education_level_id' => 24, 'name' => 'Englisch'],
            ['education_level_id' => 24, 'name' => 'Biologie'],
            ['education_level_id' => 24, 'name' => 'Chemie'],
            ['education_level_id' => 24, 'name' => 'Physik'],
            ['education_level_id' => 24, 'name' => 'Geschichte'],

            // French Education System in Egypt (ID: 7)
            ['education_level_id' => 25, 'name' => 'Français'], // Maternelle
            ['education_level_id' => 25, 'name' => 'Mathématiques'],
            ['education_level_id' => 25, 'name' => 'Découverte du Monde'],
            
            ['education_level_id' => 26, 'name' => 'Français'], // Élémentaire
            ['education_level_id' => 26, 'name' => 'Mathématiques'],
            ['education_level_id' => 26, 'name' => 'Sciences'],
            ['education_level_id' => 26, 'name' => 'Histoire-Géographie'],
            ['education_level_id' => 26, 'name' => 'Anglais'],
            
            ['education_level_id' => 27, 'name' => 'Français'], // Collège
            ['education_level_id' => 27, 'name' => 'Mathématiques'],
            ['education_level_id' => 27, 'name' => 'Physique-Chimie'],
            ['education_level_id' => 27, 'name' => 'SVT'],
            ['education_level_id' => 27, 'name' => 'Histoire-Géographie'],
            ['education_level_id' => 27, 'name' => 'Anglais'],
            ['education_level_id' => 27, 'name' => 'Espagnol/Allemand'],
            
            ['education_level_id' => 28, 'name' => 'Français'], // Lycée
            ['education_level_id' => 28, 'name' => 'Philosophie'],
            ['education_level_id' => 28, 'name' => 'Mathématiques'],
            ['education_level_id' => 28, 'name' => 'Physique-Chimie'],
            ['education_level_id' => 28, 'name' => 'SVT'],
            ['education_level_id' => 28, 'name' => 'Histoire-Géographie'],
            ['education_level_id' => 28, 'name' => 'Anglais'],
            ['education_level_id' => 28, 'name' => 'Spécialités'],

            // Saudi National Education System (ID: 8)
            ['education_level_id' => 29, 'name' => 'Arabic'], // Kindergarten
            ['education_level_id' => 29, 'name' => 'Islamic Studies'],
            ['education_level_id' => 29, 'name' => 'Basic Math'],
            
            ['education_level_id' => 30, 'name' => 'Arabic'], // Primary Education
            ['education_level_id' => 30, 'name' => 'Islamic Studies'],
            ['education_level_id' => 30, 'name' => 'Mathematics'],
            ['education_level_id' => 30, 'name' => 'Science'],
            ['education_level_id' => 30, 'name' => 'English'],
            
            ['education_level_id' => 31, 'name' => 'Arabic'], // Intermediate Education
            ['education_level_id' => 31, 'name' => 'Islamic Studies'],
            ['education_level_id' => 31, 'name' => 'Mathematics'],
            ['education_level_id' => 31, 'name' => 'Science'],
            ['education_level_id' => 31, 'name' => 'English'],
            ['education_level_id' => 31, 'name' => 'Social Studies'],
            
            ['education_level_id' => 32, 'name' => 'Arabic'], // Secondary Education
            ['education_level_id' => 32, 'name' => 'Islamic Studies'],
            ['education_level_id' => 32, 'name' => 'Mathematics'],
            ['education_level_id' => 32, 'name' => 'Physics'],
            ['education_level_id' => 32, 'name' => 'Chemistry'],
            ['education_level_id' => 32, 'name' => 'Biology'],
            ['education_level_id' => 32, 'name' => 'English'],

            // Islamic Education System (Saudi Arabia) (ID: 9)
            ['education_level_id' => 33, 'name' => 'Quran'], // Primary Stage
            ['education_level_id' => 33, 'name' => 'Arabic'],
            ['education_level_id' => 33, 'name' => 'Islamic Studies'],
            ['education_level_id' => 33, 'name' => 'Mathematics'],
            ['education_level_id' => 33, 'name' => 'Science'],
            
            ['education_level_id' => 34, 'name' => 'Quran'], // Intermediate Stage
            ['education_level_id' => 34, 'name' => 'Arabic'],
            ['education_level_id' => 34, 'name' => 'Islamic Studies'],
            ['education_level_id' => 34, 'name' => 'Mathematics'],
            ['education_level_id' => 34, 'name' => 'Science'],
            ['education_level_id' => 34, 'name' => 'English'],
            
            ['education_level_id' => 35, 'name' => 'Quran'], // Secondary Stage
            ['education_level_id' => 35, 'name' => 'Arabic'],
            ['education_level_id' => 35, 'name' => 'Islamic Studies'],
            ['education_level_id' => 35, 'name' => 'Mathematics'],
            ['education_level_id' => 35, 'name' => 'Physics'],
            ['education_level_id' => 35, 'name' => 'Chemistry'],
            ['education_level_id' => 35, 'name' => 'Biology'],
            ['education_level_id' => 35, 'name' => 'English'],

            // American Curriculum in Saudi Arabia (ID: 10)
            ['education_level_id' => 36, 'name' => 'English Language Arts'], // Elementary
            ['education_level_id' => 36, 'name' => 'Mathematics'],
            ['education_level_id' => 36, 'name' => 'Science'],
            ['education_level_id' => 36, 'name' => 'Social Studies'],
            ['education_level_id' => 36, 'name' => 'Arabic'],
            ['education_level_id' => 36, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 37, 'name' => 'English Language Arts'], // Middle
            ['education_level_id' => 37, 'name' => 'Mathematics'],
            ['education_level_id' => 37, 'name' => 'Science'],
            ['education_level_id' => 37, 'name' => 'Social Studies'],
            ['education_level_id' => 37, 'name' => 'Arabic'],
            ['education_level_id' => 37, 'name' => 'Islamic Studies'],
            ['education_level_id' => 37, 'name' => 'Foreign Language'],
            
            ['education_level_id' => 38, 'name' => 'English'], // High
            ['education_level_id' => 38, 'name' => 'Mathematics'],
            ['education_level_id' => 38, 'name' => 'Science'],
            ['education_level_id' => 38, 'name' => 'Social Studies'],
            ['education_level_id' => 38, 'name' => 'Arabic'],
            ['education_level_id' => 38, 'name' => 'Islamic Studies'],
            ['education_level_id' => 38, 'name' => 'Electives'],

            // British Curriculum (IGCSE) in Saudi Arabia (ID: 11)
            ['education_level_id' => 39, 'name' => 'English'], // Key Stage 1
            ['education_level_id' => 39, 'name' => 'Mathematics'],
            ['education_level_id' => 39, 'name' => 'Science'],
            ['education_level_id' => 39, 'name' => 'Arabic'],
            ['education_level_id' => 39, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 40, 'name' => 'English'], // Key Stage 2
            ['education_level_id' => 40, 'name' => 'Mathematics'],
            ['education_level_id' => 40, 'name' => 'Science'],
            ['education_level_id' => 40, 'name' => 'History'],
            ['education_level_id' => 40, 'name' => 'Geography'],
            ['education_level_id' => 40, 'name' => 'Arabic'],
            ['education_level_id' => 40, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 41, 'name' => 'English'], // Key Stage 3
            ['education_level_id' => 41, 'name' => 'Mathematics'],
            ['education_level_id' => 41, 'name' => 'Science'],
            ['education_level_id' => 41, 'name' => 'History'],
            ['education_level_id' => 41, 'name' => 'Geography'],
            ['education_level_id' => 41, 'name' => 'Arabic'],
            ['education_level_id' => 41, 'name' => 'Islamic Studies'],
            ['education_level_id' => 41, 'name' => 'Modern Foreign Languages'],
            
            ['education_level_id' => 42, 'name' => 'First Language English'], // IGCSE
            ['education_level_id' => 42, 'name' => 'Mathematics'],
            ['education_level_id' => 42, 'name' => 'Biology'],
            ['education_level_id' => 42, 'name' => 'Chemistry'],
            ['education_level_id' => 42, 'name' => 'Physics'],
            ['education_level_id' => 42, 'name' => 'Arabic'],
            ['education_level_id' => 42, 'name' => 'Islamic Studies'],
            ['education_level_id' => 42, 'name' => 'Foreign Language'],
            
            ['education_level_id' => 43, 'name' => 'English Literature'], // A-Level
            ['education_level_id' => 43, 'name' => 'Mathematics'],
            ['education_level_id' => 43, 'name' => 'Biology'],
            ['education_level_id' => 43, 'name' => 'Chemistry'],
            ['education_level_id' => 43, 'name' => 'Physics'],
            ['education_level_id' => 43, 'name' => 'Arabic'],
            ['education_level_id' => 43, 'name' => 'Islamic Studies'],

            // International Baccalaureate (IB) in Saudi Arabia (ID: 12)
            ['education_level_id' => 44, 'name' => 'Language Acquisition'], // PYP
            ['education_level_id' => 44, 'name' => 'Mathematics'],
            ['education_level_id' => 44, 'name' => 'Science'],
            ['education_level_id' => 44, 'name' => 'Arabic'],
            ['education_level_id' => 44, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 45, 'name' => 'Language and Literature'], // MYP
            ['education_level_id' => 45, 'name' => 'Language Acquisition'],
            ['education_level_id' => 45, 'name' => 'Mathematics'],
            ['education_level_id' => 45, 'name' => 'Sciences'],
            ['education_level_id' => 45, 'name' => 'Arabic'],
            ['education_level_id' => 45, 'name' => 'Islamic Studies'],
            ['education_level_id' => 45, 'name' => 'Physical and Health Education'],
            
            ['education_level_id' => 46, 'name' => 'Studies in Language and Literature'], // DP
            ['education_level_id' => 46, 'name' => 'Language Acquisition'],
            ['education_level_id' => 46, 'name' => 'Mathematics'],
            ['education_level_id' => 46, 'name' => 'Sciences'],
            ['education_level_id' => 46, 'name' => 'Arabic'],
            ['education_level_id' => 46, 'name' => 'Islamic Studies'],
            ['education_level_id' => 46, 'name' => 'Theory of Knowledge'],

            // Indian Curriculum in Saudi Arabia (ID: 13)
            ['education_level_id' => 47, 'name' => 'English'], // Pre-Primary
            ['education_level_id' => 47, 'name' => 'Mathematics'],
            ['education_level_id' => 47, 'name' => 'Environmental Studies'],
            
            ['education_level_id' => 48, 'name' => 'English'], // Primary
            ['education_level_id' => 48, 'name' => 'Mathematics'],
            ['education_level_id' => 48, 'name' => 'Science'],
            ['education_level_id' => 48, 'name' => 'Social Studies'],
            ['education_level_id' => 48, 'name' => 'Hindi'],
            ['education_level_id' => 48, 'name' => 'Arabic'],
            
            ['education_level_id' => 49, 'name' => 'English'], // Upper Primary
            ['education_level_id' => 49, 'name' => 'Mathematics'],
            ['education_level_id' => 49, 'name' => 'Science'],
            ['education_level_id' => 49, 'name' => 'Social Studies'],
            ['education_level_id' => 49, 'name' => 'Hindi'],
            ['education_level_id' => 49, 'name' => 'Arabic'],
            ['education_level_id' => 49, 'name' => 'Computer Science'],
            
            ['education_level_id' => 50, 'name' => 'English'], // Secondary
            ['education_level_id' => 50, 'name' => 'Mathematics'],
            ['education_level_id' => 50, 'name' => 'Physics'],
            ['education_level_id' => 50, 'name' => 'Chemistry'],
            ['education_level_id' => 50, 'name' => 'Biology'],
            ['education_level_id' => 50, 'name' => 'Social Studies'],
            ['education_level_id' => 50, 'name' => 'Hindi'],
            ['education_level_id' => 50, 'name' => 'Arabic'],
            
            ['education_level_id' => 51, 'name' => 'English'], // Senior Secondary
            ['education_level_id' => 51, 'name' => 'Mathematics'],
            ['education_level_id' => 51, 'name' => 'Physics'],
            ['education_level_id' => 51, 'name' => 'Chemistry'],
            ['education_level_id' => 51, 'name' => 'Biology'],
            ['education_level_id' => 51, 'name' => 'Computer Science'],
            ['education_level_id' => 51, 'name' => 'Economics'],
            ['education_level_id' => 51, 'name' => 'Business Studies'],

            // Pakistani Education System in Saudi Arabia (ID: 14)
            ['education_level_id' => 52, 'name' => 'English'], // Pre-Primary
            ['education_level_id' => 52, 'name' => 'Urdu'],
            ['education_level_id' => 52, 'name' => 'Basic Math'],
            
            ['education_level_id' => 53, 'name' => 'English'], // Primary
            ['education_level_id' => 53, 'name' => 'Urdu'],
            ['education_level_id' => 53, 'name' => 'Mathematics'],
            ['education_level_id' => 53, 'name' => 'Science'],
            ['education_level_id' => 53, 'name' => 'Islamiyat'],
            ['education_level_id' => 53, 'name' => 'Arabic'],
            
            ['education_level_id' => 54, 'name' => 'English'], // Middle
            ['education_level_id' => 54, 'name' => 'Urdu'],
            ['education_level_id' => 54, 'name' => 'Mathematics'],
            ['education_level_id' => 54, 'name' => 'Science'],
            ['education_level_id' => 54, 'name' => 'Islamiyat'],
            ['education_level_id' => 54, 'name' => 'Social Studies'],
            ['education_level_id' => 54, 'name' => 'Arabic'],
            
            ['education_level_id' => 55, 'name' => 'English'], // Secondary
            ['education_level_id' => 55, 'name' => 'Urdu'],
            ['education_level_id' => 55, 'name' => 'Mathematics'],
            ['education_level_id' => 55, 'name' => 'Physics'],
            ['education_level_id' => 55, 'name' => 'Chemistry'],
            ['education_level_id' => 55, 'name' => 'Biology'],
            ['education_level_id' => 55, 'name' => 'Islamiyat'],
            ['education_level_id' => 55, 'name' => 'Pakistan Studies'],
            ['education_level_id' => 55, 'name' => 'Arabic'],
            
            ['education_level_id' => 56, 'name' => 'English'], // Higher Secondary
            ['education_level_id' => 56, 'name' => 'Urdu'],
            ['education_level_id' => 56, 'name' => 'Mathematics'],
            ['education_level_id' => 56, 'name' => 'Physics'],
            ['education_level_id' => 56, 'name' => 'Chemistry'],
            ['education_level_id' => 56, 'name' => 'Biology'],
            ['education_level_id' => 56, 'name' => 'Islamiyat'],
            ['education_level_id' => 56, 'name' => 'Pakistan Studies'],
            ['education_level_id' => 56, 'name' => 'Arabic'],

            // UAE National Education System (ID: 15)
            ['education_level_id' => 57, 'name' => 'Arabic'], // Kindergarten
            ['education_level_id' => 57, 'name' => 'English'],
            ['education_level_id' => 57, 'name' => 'Basic Math'],
            ['education_level_id' => 57, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 58, 'name' => 'Arabic'], // Cycle 1 (Primary)
            ['education_level_id' => 58, 'name' => 'English'],
            ['education_level_id' => 58, 'name' => 'Mathematics'],
            ['education_level_id' => 58, 'name' => 'Science'],
            ['education_level_id' => 58, 'name' => 'Islamic Studies'],
            ['education_level_id' => 58, 'name' => 'Social Studies'],
            ['education_level_id' => 58, 'name' => 'Moral Education'],
            
            ['education_level_id' => 59, 'name' => 'Arabic'], // Cycle 2 (Preparatory)
            ['education_level_id' => 59, 'name' => 'English'],
            ['education_level_id' => 59, 'name' => 'Mathematics'],
            ['education_level_id' => 59, 'name' => 'Physics'],
            ['education_level_id' => 59, 'name' => 'Chemistry'],
            ['education_level_id' => 59, 'name' => 'Biology'],
            ['education_level_id' => 59, 'name' => 'Islamic Studies'],
            ['education_level_id' => 59, 'name' => 'Social Studies'],
            ['education_level_id' => 59, 'name' => 'Moral Education'],
            
            ['education_level_id' => 60, 'name' => 'Arabic'], // Cycle 3 (Secondary)
            ['education_level_id' => 60, 'name' => 'English'],
            ['education_level_id' => 60, 'name' => 'Mathematics'],
            ['education_level_id' => 60, 'name' => 'Physics'],
            ['education_level_id' => 60, 'name' => 'Chemistry'],
            ['education_level_id' => 60, 'name' => 'Biology'],
            ['education_level_id' => 60, 'name' => 'Islamic Studies'],
            ['education_level_id' => 60, 'name' => 'Social Studies'],
            ['education_level_id' => 60, 'name' => 'Moral Education'],

            // American Curriculum in UAE (ID: 16)
            ['education_level_id' => 61, 'name' => 'English Language Arts'], // Elementary
            ['education_level_id' => 61, 'name' => 'Mathematics'],
            ['education_level_id' => 61, 'name' => 'Science'],
            ['education_level_id' => 61, 'name' => 'Social Studies'],
            ['education_level_id' => 61, 'name' => 'Arabic'],
            ['education_level_id' => 61, 'name' => 'Islamic Studies'],
            ['education_level_id' => 61, 'name' => 'Moral Education'],
            
            ['education_level_id' => 62, 'name' => 'English Language Arts'], // Middle
            ['education_level_id' => 62, 'name' => 'Mathematics'],
            ['education_level_id' => 62, 'name' => 'Science'],
            ['education_level_id' => 62, 'name' => 'Social Studies'],
            ['education_level_id' => 62, 'name' => 'Arabic'],
            ['education_level_id' => 62, 'name' => 'Islamic Studies'],
            ['education_level_id' => 62, 'name' => 'Moral Education'],
            ['education_level_id' => 62, 'name' => 'Foreign Language'],
            
            ['education_level_id' => 63, 'name' => 'English'], // High
            ['education_level_id' => 63, 'name' => 'Mathematics'],
            ['education_level_id' => 63, 'name' => 'Science'],
            ['education_level_id' => 63, 'name' => 'Social Studies'],
            ['education_level_id' => 63, 'name' => 'Arabic'],
            ['education_level_id' => 63, 'name' => 'Islamic Studies'],
            ['education_level_id' => 63, 'name' => 'Moral Education'],
            ['education_level_id' => 63, 'name' => 'Electives'],

            // British Curriculum (IGCSE) in UAE (ID: 17)
            ['education_level_id' => 64, 'name' => 'English'], // Foundation Stage
            ['education_level_id' => 64, 'name' => 'Mathematics'],
            ['education_level_id' => 64, 'name' => 'Science'],
            ['education_level_id' => 64, 'name' => 'Arabic'],
            ['education_level_id' => 64, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 65, 'name' => 'English'], // Key Stage 1
            ['education_level_id' => 65, 'name' => 'Mathematics'],
            ['education_level_id' => 65, 'name' => 'Science'],
            ['education_level_id' => 65, 'name' => 'Arabic'],
            ['education_level_id' => 65, 'name' => 'Islamic Studies'],
            ['education_level_id' => 65, 'name' => 'Moral Education'],
            
            ['education_level_id' => 66, 'name' => 'English'], // Key Stage 2
            ['education_level_id' => 66, 'name' => 'Mathematics'],
            ['education_level_id' => 66, 'name' => 'Science'],
            ['education_level_id' => 66, 'name' => 'History'],
            ['education_level_id' => 66, 'name' => 'Geography'],
            ['education_level_id' => 66, 'name' => 'Arabic'],
            ['education_level_id' => 66, 'name' => 'Islamic Studies'],
            ['education_level_id' => 66, 'name' => 'Moral Education'],
            
            ['education_level_id' => 67, 'name' => 'English'], // Key Stage 3
            ['education_level_id' => 67, 'name' => 'Mathematics'],
            ['education_level_id' => 67, 'name' => 'Science'],
            ['education_level_id' => 67, 'name' => 'History'],
            ['education_level_id' => 67, 'name' => 'Geography'],
            ['education_level_id' => 67, 'name' => 'Arabic'],
            ['education_level_id' => 67, 'name' => 'Islamic Studies'],
            ['education_level_id' => 67, 'name' => 'Moral Education'],
            ['education_level_id' => 67, 'name' => 'Modern Foreign Languages'],
            
            ['education_level_id' => 68, 'name' => 'First Language English'], // IGCSE
            ['education_level_id' => 68, 'name' => 'Mathematics'],
            ['education_level_id' => 68, 'name' => 'Biology'],
            ['education_level_id' => 68, 'name' => 'Chemistry'],
            ['education_level_id' => 68, 'name' => 'Physics'],
            ['education_level_id' => 68, 'name' => 'Arabic'],
            ['education_level_id' => 68, 'name' => 'Islamic Studies'],
            ['education_level_id' => 68, 'name' => 'Moral Education'],
            ['education_level_id' => 68, 'name' => 'Foreign Language'],
            
            ['education_level_id' => 69, 'name' => 'English Literature'], // A-Level
            ['education_level_id' => 69, 'name' => 'Mathematics'],
            ['education_level_id' => 69, 'name' => 'Biology'],
            ['education_level_id' => 69, 'name' => 'Chemistry'],
            ['education_level_id' => 69, 'name' => 'Physics'],
            ['education_level_id' => 69, 'name' => 'Arabic'],
            ['education_level_id' => 69, 'name' => 'Islamic Studies'],

            // French Education System in UAE (ID: 18)
            ['education_level_id' => 70, 'name' => 'Français'], // Maternelle
            ['education_level_id' => 70, 'name' => 'Mathématiques'],
            ['education_level_id' => 70, 'name' => 'Découverte du Monde'],
            ['education_level_id' => 70, 'name' => 'Arabic'],
            ['education_level_id' => 70, 'name' => 'Islamic Studies'],
            
            ['education_level_id' => 71, 'name' => 'Français'], // Élémentaire
            ['education_level_id' => 71, 'name' => 'Mathématiques'],
            ['education_level_id' => 71, 'name' => 'Sciences'],
            ['education_level_id' => 71, 'name' => 'Histoire-Géographie'],
            ['education_level_id' => 71, 'name' => 'Anglais'],
            ['education_level_id' => 71, 'name' => 'Arabic'],
            ['education_level_id' => 71, 'name' => 'Islamic Studies'],
            ['education_level_id' => 71, 'name' => 'Moral Education'],
            
            ['education_level_id' => 72, 'name' => 'Français'], // Collège
            ['education_level_id' => 72, 'name' => 'Mathématiques'],
            ['education_level_id' => 72, 'name' => 'Physique-Chimie'],
            ['education_level_id' => 72, 'name' => 'SVT'],
            ['education_level_id' => 72, 'name' => 'Histoire-Géographie'],
            ['education_level_id' => 72, 'name' => 'Anglais'],
            ['education_level_id' => 72, 'name' => 'Arabic'],
            ['education_level_id' => 72, 'name' => 'Islamic Studies'],
            ['education_level_id' => 72, 'name' => 'Moral Education'],
            ['education_level_id' => 72, 'name' => 'Espagnol/Allemand'],
            
            ['education_level_id' => 73, 'name' => 'Français'], // Lycée
            ['education_level_id' => 73, 'name' => 'Philosophie'],
            ['education_level_id' => 73, 'name' => 'Mathématiques'],
            ['education_level_id' => 73, 'name' => 'Physique-Chimie'],
            ['education_level_id' => 73, 'name' => 'SVT'],
            ['education_level_id' => 73, 'name' => 'Histoire-Géographie'],
            ['education_level_id' => 73, 'name' => 'Anglais'],
            ['education_level_id' => 73, 'name' => 'Arabic'],
            ['education_level_id' => 73, 'name' => 'Islamic Studies'],
            ['education_level_id' => 73, 'name' => 'Moral Education'],
            ['education_level_id' => 73, 'name' => 'Spécialités'],

            // International Baccalaureate (IB) in UAE (ID: 19)
            ['education_level_id' => 74, 'name' => 'Language Acquisition'], // PYP
            ['education_level_id' => 74, 'name' => 'Mathematics'],
            ['education_level_id' => 74, 'name' => 'Science'],
            ['education_level_id' => 74, 'name' => 'Arabic'],
            ['education_level_id' => 74, 'name' => 'Islamic Studies'],
            ['education_level_id' => 74, 'name' => 'Moral Education'],
            
            ['education_level_id' => 75, 'name' => 'Language and Literature'], // MYP
            ['education_level_id' => 75, 'name' => 'Language Acquisition'],
            ['education_level_id' => 75, 'name' => 'Mathematics'],
            ['education_level_id' => 75, 'name' => 'Sciences'],
            ['education_level_id' => 75, 'name' => 'Arabic'],
            ['education_level_id' => 75, 'name' => 'Islamic Studies'],
            ['education_level_id' => 75, 'name' => 'Moral Education'],
            ['education_level_id' => 75, 'name' => 'Physical and Health Education'],
            
            ['education_level_id' => 76, 'name' => 'Studies in Language and Literature'], // DP
            ['education_level_id' => 76, 'name' => 'Language Acquisition'],
            ['education_level_id' => 76, 'name' => 'Mathematics'],
            ['education_level_id' => 76, 'name' => 'Sciences'],
            ['education_level_id' => 76, 'name' => 'Arabic'],
            ['education_level_id' => 76, 'name' => 'Islamic Studies'],
            ['education_level_id' => 76, 'name' => 'Moral Education'],
            ['education_level_id' => 76, 'name' => 'Theory of Knowledge'],
            
            ['education_level_id' => 77, 'name' => 'Career-related Study'], // CP
            ['education_level_id' => 77, 'name' => 'Personal and Professional Skills'],
            ['education_level_id' => 77, 'name' => 'Service Learning'],
            ['education_level_id' => 77, 'name' => 'Arabic'],
            ['education_level_id' => 77, 'name' => 'Islamic Studies'],
            ['education_level_id' => 77, 'name' => 'Moral Education'],
            ['education_level_id' => 77, 'name' => 'Reflective Project'],
        ]);
    }
}
