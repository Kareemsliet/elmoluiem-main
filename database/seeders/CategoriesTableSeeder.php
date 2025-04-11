<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Web Development',
                'description' => 'Learn to build modern websites and web applications using the latest technologies.'
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Master mobile app development for iOS and Android platforms.'
            ],
            [
                'name' => 'Data Science',
                'description' => 'Explore data analysis, machine learning, and artificial intelligence techniques.'
            ],
            [
                'name' => 'Programming Languages',
                'description' => 'Learn various programming languages from beginner to advanced levels.'
            ],
            [
                'name' => 'Game Development',
                'description' => 'Create interactive games using popular engines and frameworks.'
            ],
            [
                'name' => 'DevOps & Cloud Computing',
                'description' => 'Learn about deployment, automation, and cloud services management.'
            ],
            [
                'name' => 'Cybersecurity',
                'description' => 'Protect systems and networks from digital attacks and vulnerabilities.'
            ],
            [
                'name' => 'Database Design & Development',
                'description' => 'Master database management systems and query languages.'
            ],
            [
                'name' => 'Software Testing',
                'description' => 'Learn various software testing methodologies and tools.'
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Create beautiful and user-friendly interfaces and experiences.'
            ],
            [
                'name' => 'IT Certifications',
                'description' => 'Prepare for various IT certification exams and boost your career.'
            ],
            [
                'name' => 'Network & Security',
                'description' => 'Understand network infrastructure and security protocols.'
            ],
            [
                'name' => 'Artificial Intelligence',
                'description' => 'Dive into machine learning, neural networks, and AI applications.'
            ],
            [
                'name' => 'Blockchain',
                'description' => 'Learn about cryptocurrency, smart contracts, and decentralized applications.'
            ],
            [
                'name' => 'Business & Productivity',
                'description' => 'Tools and techniques to improve business operations and personal productivity.'
            ]
        ]);
    }
}
